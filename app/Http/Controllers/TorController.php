<?php

namespace App\Http\Controllers;

use App\Models\Aktivitas;
use App\Models\coa;
use App\Models\indikatorKegiatan;
use App\Models\kebutuhanAnggaran;
use App\Models\Kegiatan;
use App\Models\outcomeKegiatan;
use App\Models\ProgramKerja;
use App\Models\Rab;
use App\Models\Tor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $tor = Tor::all();
        $proker = ProgramKerja::all();
        $coa = coa::all();

        return view('penyusunan.tor.create', ['tor' => $tor, 'proker' => $proker, 'coa' => $coa]);
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

            return redirect()->route('penyusunan.kegiatan.view')->with('success', 'Data telah ditambahkan.');
        }

        return redirect()->route('penyusunan.kegiatan.view')->with('failed', 'Data gagal ditambahkan.');
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

        // Only fetch related records for the current TOR
        $aktivitas = Aktivitas::where('tor_id', $tor->id)->get();
        $outcomes = outcomeKegiatan::where('tor_id', $tor->id)->get();
        $indikators = indikatorKegiatan::where('tor_id', $tor->id)->get();

        return view('penyusunan.tor.edit', compact('tor', 'aktivitas', 'proker', 'coa', 'outcomes', 'indikators'));
    }

    public function update(Request $request, $id)
    {
        // Validate input
        $validateData = $request->validate([
            'proker_id' => 'string|required|exists:program_kerjas,id',
            'nama_kegiatan' => 'string|required|unique:tors,nama_kegiatan,' . $id,
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
        ]);

        // Update the main TOR record
        $tor = Tor::findOrFail($id);
        $tor->update($validateData);

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

        return redirect()->route('penyusunan.kegiatan.view')->with('success', 'Data telah diperbarui.');
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
            'aktivitas_id' => 'required|uuid',
        ]);

        $validateData['aktivitas_id'] = $aktivitas_id;
        $validateData['jumlah'] = $validateData['frekwensi'] * $validateData['nominal_volume'];

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
        ]);

        $anggaran = KebutuhanAnggaran::findOrFail($anggaran_id);

        $anggaran->update($validateData);

        $anggaran->jumlah = $validateData['frekwensi'] * $validateData['nominal_volume'];
        $anggaran->save();

        $tor_id = $anggaran->aktivitas->tor_id;
        $rab = RAB::where('tor_id', $tor_id)->first();

        if ($rab) {
            $totalBiaya = KebutuhanAnggaran::whereHas('aktivitas', function ($query) use ($tor_id) {
                $query->where('tor_id', $tor_id);
            })->sum('jumlah');

            $rab->total_biaya = $totalBiaya;
            $rab->save();
        }

        return redirect()->route('penyusunan.tor.aktivitas', ['tor' => $tor_id])
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

        return redirect()->route('penyusunan.tor.aktivitas', ['tor' => $tor_id])
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

        return redirect()->route('penyusunan.tor.aktivitas', $tor->id);
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

        return redirect()->route('penyusunan.tor.aktivitas', $aktivitas->tor_id);
    }

    // Delete Aktivitas
    public function destroyAktivitas(Aktivitas $aktivitas)
    {
        $aktivitas->delete();
        return redirect()->route('penyusunan.tor.aktivitas', $aktivitas->tor_id);
    }
}
