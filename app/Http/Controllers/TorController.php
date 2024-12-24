<?php

namespace App\Http\Controllers;

use App\Models\Aktivitas;
use App\Models\coa;
use App\Models\indikatorKegiatan;
use App\Models\kebutuhanAnggaran;
use App\Models\Kegiatan;
use App\Models\Kriteria;
use App\Models\outcomeKegiatan;
use App\Models\ProgramKerja;
use App\Models\Rab;
use App\Models\Subkriteria;
use App\Models\Tor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        $unitId = auth()->user()->unit_id;
        $tor = Tor::all();
        $proker = ProgramKerja::where('status', 1)
        ->whereHas('user', function ($query) use ($user) {
            $query->where('unit_id', $user->unit_id);
        })
        ->get();
        $coa = coa::all();
        $kriterias = Kriteria::with('subkriteria')
            ->where('status_kriteria', 1)
            ->get();

        return view('penyusunan.tor.create', compact('tor', 'proker', 'coa', 'kriterias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate input
        // dd($request->all());
        $validateData = $request->validate([
            'proker_id' => 'string|required|exists:program_kerjas,id',
            'nama_kegiatan' => 'string|required|unique:tors',
            'waktu' => 'required|date_format:Y-m',
            'pic' => 'string|required',
            'kepesertaan' => 'string|required',
            'nomor_standar_akreditasi' => 'string|required',
            'penjelasan_standar_akreditasi' => 'string|required',
            'coa_id' => 'string|required|exists:coas,id',
            'latar_belakang' => 'string|required',
            'tujuan' => 'string|required',
            'manfaat_internal' => 'string|required',
            'manfaat_eksternal' => 'string|required',
            'metode_pelaksanaan' => 'string|required',
            'outcomes.*' => 'string|required',
            'indikators.*' => 'string|required',
            'waktu_aktivitas.*' => 'date|required',
            'penjelasan.*' => 'string|required',
            'kategori.*' => 'string|required',
            'kriteria' => 'array|required',
        ]);

        $validateData['user_id'] = Auth::id();
        $validateData['unit_id'] = Auth::user()->unit_id;
        $validateData['satuan_id'] = Auth::user()->unit->satuan_id;

        $tor = Tor::create($validateData);

        if ($tor) {
            $kegiatan = Kegiatan::create([
                'tor_id' => $tor->id,
                'status' => 'Belum Diajukan',
                'user_id' => $validateData['user_id'],
                'unit_id' => $validateData['unit_id'],
                'satuan_id' => $validateData['satuan_id'],
                'rab_id' => null,
                'jenis' => 'Tahunan',
                'tahunan_id' => null,
            ]);

            foreach ($request->outcomes as $outcome) {
                outcomeKegiatan::create([
                    'tor_id' => $tor->id,
                    'outcome' => $outcome,
                ]);
            }

            foreach ($request->indikators as $indikator) {
                indikatorKegiatan::create([
                    'tor_id' => $tor->id,
                    'indikator' => $indikator,
                ]);
            }

            foreach ($request->waktu_aktivitas as $index => $waktu) {
                $aktivitas = Aktivitas::create([
                    'tor_id' => $tor->id,
                    'waktu_aktivitas' => $waktu,
                    'penjelasan' => $request->penjelasan[$index],
                    'kategori' => $request->kategori[$index],
                ]);
            }

            foreach ($request->kriteria as $kriteriaId => $data) {
                $kriteria = Kriteria::find($kriteriaId);

                if ($kriteria && $kriteria->tipe_kriteria === 'Interval' && isset($data['nilai'])) {
                    $nilai = $data['nilai'];

                    // Cari subkriteria yang sesuai dengan nilai
                    $subkriteria = Subkriteria::where('id_kriteria', $kriteriaId)
                        ->where('batas_bawah_bobot_subkriteria', '<=', $nilai)
                        ->where('batas_atas_bobot_subkriteria', '>=', $nilai)
                        ->first();

                    if ($subkriteria) {
                        DB::table('kriteria_kegiatan')->insert([
                            'id' => Str::uuid(),
                            'kegiatan_id' => $kegiatan->id,
                            'kriteria_id' => $kriteriaId,
                            'subkriteria_id' => $subkriteria->id,
                            'nilai' => $nilai,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                } elseif ($kriteria && $kriteria->tipe_kriteria === 'Select' && isset($data['subkriteria_id'])) {
                    DB::table('kriteria_kegiatan')->insert([
                        'id' => Str::uuid(),
                        'kegiatan_id' => $kegiatan->id,
                        'kriteria_id' => $kriteriaId,
                        'subkriteria_id' => $data['subkriteria_id'],
                        'nilai' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }


            return redirect()->route('penyusunan.kegiatan.view')->with('success', 'Kegiatan telah ditambahkan.');
        }

        return redirect()->route('penyusunan.kegiatan.view')->with('failed', 'Kegiatan gagal ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tor $tor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tor $tor)
    {
        $proker = ProgramKerja::all();
        $coa = Coa::all();

        $aktivitas = Aktivitas::where('tor_id', $tor->id)->get();
        $outcomes = outcomeKegiatan::where('tor_id', $tor->id)->get();
        $indikators = indikatorKegiatan::where('tor_id', $tor->id)->get();

        $kegiatan = Kegiatan::where('tor_id', $tor->id)->first();

        if (!$kegiatan) {
            return redirect()->back()->with('error', 'Kegiatan tidak ditemukan.');
        }

        $kriterias = Kriteria::with('subkriteria')->where('status_kriteria', 1)->get();

        $kriteriaKegiatan = DB::table('kriteria_kegiatan')
            ->where('kegiatan_id', $kegiatan->id)
            ->get()
            ->keyBy('kriteria_id');


        return view('penyusunan.tor.edit', compact('tor', 'aktivitas', 'proker', 'coa', 'outcomes', 'indikators', 'kriterias', 'kriteriaKegiatan'));
    }

    public function update(Request $request, $id)
    {
        // Validate input
        $validateData = $request->validate([
            'proker_id' => 'string|required|exists:program_kerjas,id',
            'nama_kegiatan' => 'string|required|unique:tors,nama_kegiatan,' . $id,
            'waktu' => 'required|date_format:Y-m',
            'pic' => 'string|required',
            'kepesertaan' => 'string|required',
            'nomor_standar_akreditasi' => 'string|required',
            'penjelasan_standar_akreditasi' => 'string|required',
            'coa_id' => 'string|required|exists:coas,id',
            'latar_belakang' => 'string|required',
            'tujuan' => 'string|required',
            'manfaat_internal' => 'string|required',
            'manfaat_eksternal' => 'string|required',
            'metode_pelaksanaan' => 'string|required',
            'outcomes.*' => 'string|required',
            'indikators.*' => 'string|required',
            'kriteria' => 'array|required',
            'kriteria.*.nilai' => 'nullable|numeric',
            'kriteria.*.subkriteria_id' => 'nullable|exists:subkriterias,id',
        ]);

        $tor = Tor::findOrFail($id);
        $kegiatan = Kegiatan::where('tor_id', $tor->id)->first();

        if (!$kegiatan) {
            return redirect()->back()->with('error', 'Kegiatan tidak ditemukan.');
        }
        $tor->update($validateData);

        foreach ($validateData['kriteria'] as $kriteriaId => $data) {
            $kriteria = Kriteria::find($kriteriaId);

            if ($kriteria && $kriteria->tipe_kriteria === 'Interval' && isset($data['nilai'])) {
                $nilai = $data['nilai'];

                $subkriteria = Subkriteria::where('id_kriteria', $kriteriaId)
                    ->where('batas_bawah_bobot_subkriteria', '<=', $nilai)
                    ->where('batas_atas_bobot_subkriteria', '>=', $nilai)
                    ->first();

                DB::table('kriteria_kegiatan')->updateOrInsert(
                    [
                        'kegiatan_id' => $kegiatan->id,
                        'kriteria_id' => $kriteriaId,
                    ],
                    [
                        'subkriteria_id' => $subkriteria ? $subkriteria->id : null,
                        'nilai' => $nilai,
                        'updated_at' => now(),
                    ]
                );
            } elseif ($kriteria && $kriteria->tipe_kriteria === 'Select' && isset($data['subkriteria_id'])) {
                DB::table('kriteria_kegiatan')->updateOrInsert(
                    [
                        'kegiatan_id' => $kegiatan->id,
                        'kriteria_id' => $kriteriaId,
                    ],
                    [
                        'subkriteria_id' => $data['subkriteria_id'],
                        'nilai' => null,
                        'updated_at' => now(),
                    ]
                );
            }
        }

        // Retrieve current outcomes, indikator, and aktivitas IDs
        $existingOutcomeIds = $request->outcome_ids ?? [];
        $existingIndikatorIds = $request->indikator_ids ?? [];

        // Handle Outcomes: Create/Update/Delete
        $outcomeIdsToKeep = [];
        foreach ($request->outcomes as $index => $outcome) {
            $outcomeModel = outcomeKegiatan::updateOrCreate(
                ['tor_id' => $id, 'id' => $existingOutcomeIds[$index] ?? null], // If ID exists, update, otherwise create new
                ['outcome' => $outcome]
            );
            $outcomeIdsToKeep[] = $outcomeModel->id; // Track IDs to keep
        }

        // Delete removed outcomes
        outcomeKegiatan::where('tor_id', $id)
            ->whereNotIn('id', $outcomeIdsToKeep)
            ->delete();

        // Handle Indikators: Create/Update/Delete
        $indikatorIdsToKeep = [];
        foreach ($request->indikators as $index => $indikator) {
            $indikatorModel = indikatorKegiatan::updateOrCreate(
                ['tor_id' => $id, 'id' => $existingIndikatorIds[$index] ?? null],
                ['indikator' => $indikator]
            );
            $indikatorIdsToKeep[] = $indikatorModel->id;
        }

        // Delete removed indikator
        indikatorKegiatan::where('tor_id', $id)
            ->whereNotIn('id', $indikatorIdsToKeep)
            ->delete();

        return redirect()->route('penyusunan.kegiatan.view')->with('success', 'Kegiatan telah diperbarui.');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tor $tor)
    {
        //
    }

    public function showAktivitas(Tor $tor)
    {
        $aktivitas = Aktivitas::with('kebutuhanAnggaran')->where('tor_id', $tor->id)->get();

        return view('penyusunan.tor.aktivitas', compact('tor', 'aktivitas'));
    }


    public function storeAnggaran(Request $request, $aktivitas_id)
    {
        $validateData = $request->validate([
            'uraian_aktivitas' => 'string|required',
            'frekwensi' => 'integer|required',
            'nominal_volume' => 'integer|required',
            'satuan_volume' => 'string|required',
            'harga' => 'integer|required',
            'aktivitas_id' => 'required|uuid',
        ]);

        $validateData['aktivitas_id'] = $aktivitas_id;
        $validateData['jumlah'] = ($validateData['frekwensi'] * $validateData['nominal_volume']) * $validateData['harga'];

        kebutuhanAnggaran::create($validateData);

        $aktivitas = Aktivitas::findOrFail($aktivitas_id);
        $tor_id = $aktivitas->tor_id;

        $rab = RAB::firstOrCreate(
            ['tor_id' => $tor_id],
            ['total_biaya' => 0]
        );

        Kegiatan::where('tor_id', $tor_id)->whereNull('rab_id')->update(['rab_id' => $rab->id]);

        $totalBiaya = KebutuhanAnggaran::whereHas('aktivitas', function ($query) use ($tor_id) {
            $query->where('tor_id', $tor_id);
        })->sum('jumlah');

        $rab->total_biaya = $totalBiaya;
        $rab->save();

        return redirect()->back()->with('success', 'Kebutuhan anggaran berhasil disimpan dan RAB diperbarui.');
    }

    public function updateAnggaran(Request $request, $anggaran_id)
    {
        $validateData = $request->validate([
            'uraian_aktivitas' => 'string|required',
            'frekwensi' => 'integer|required',
            'nominal_volume' => 'integer|required',
            'satuan_volume' => 'string|required',
            'harga' => 'integer|required',
        ]);

        $anggaran = KebutuhanAnggaran::findOrFail($anggaran_id);

        $validateData['jumlah'] = ($validateData['frekwensi'] * $validateData['nominal_volume']) * $validateData['harga'];
        $anggaran->save();

        $anggaran->update($validateData);



        $tor_id = $anggaran->aktivitas->tor_id;
        $rab = RAB::where('tor_id', $tor_id)->first();

        if ($rab) {
            $totalBiaya = KebutuhanAnggaran::whereHas('aktivitas', function ($query) use ($tor_id) {
                $query->where('tor_id', $tor_id);
            })->sum('jumlah');

            $rab->total_biaya = $totalBiaya;
            $rab->save();
        }

        return redirect()->back()
            ->with('success', 'Kebutuhan anggaran berhasil diperbarui dan total biaya RAB diperbarui.');
    }



    public function destroyAnggaran($anggaran_id)
    {
        $anggaran = KebutuhanAnggaran::findOrFail($anggaran_id);
        $tor_id = $anggaran->aktivitas->tor_id;

        $anggaran->delete();

        $rab = RAB::where('tor_id', $tor_id)->first();

        if ($rab) {
            $totalBiaya = KebutuhanAnggaran::whereHas('aktivitas', function ($query) use ($tor_id) {
                $query->where('tor_id', $tor_id);
            })->sum('jumlah');

            $rab->total_biaya = $totalBiaya;
            $rab->save();
        }

        return redirect()->back()
            ->with('success', 'Kebutuhan anggaran berhasil dihapus dan total biaya RAB diperbarui.');
    }

    // Store Aktivitas
    public function storeAktivitas(Request $request, Tor $tor)
    {
        $request->validate([
            'penjelasan' => 'required',
            'waktu_aktivitas' => 'required|date',
            'kategori' => 'required',
        ]);

        Aktivitas::create([
            'penjelasan' => $request->penjelasan,
            'waktu_aktivitas' => $request->waktu_aktivitas,
            'kategori' => $request->kategori,
            'tor_id' => $tor->id,
        ]);

        return redirect()->back()->with('success', 'Aktivitas Berhasil Dibuat');
    }

    // Update Aktivitas
    public function updateAktivitas(Request $request, Aktivitas $aktivitas)
    {
        $request->validate([
            'penjelasan' => 'required',
            'waktu_aktivitas' => 'required|date',
            'kategori' => 'required',
        ]);
        
        $aktivitas->update($request->all());

        return redirect()->back()->with('success', 'Aktivitas Berhasil Diperbarui');
    }

    // Delete Aktivitas
    public function destroyAktivitas(Aktivitas $aktivitas)
    {
        $aktivitas->delete();
        return redirect()->back()->with('success', 'Aktivitas Berhasil Dihapus');
    }
}
