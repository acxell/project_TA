<?php

namespace App\Http\Controllers;

use App\Models\Aktivitas;
use App\Models\coa;
use App\Models\indikatorKegiatan;
use App\Models\kebutuhanAnggaran;
use App\Models\Kegiatan;
use App\Models\Kriteria;
use App\Models\outcomeKegiatan;
use App\Models\pengguna;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kegiatan = Kegiatan::all();

        return view('penyusunan.kegiatan.view', ['kegiatan' => $kegiatan]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kegiatan = Kegiatan::all();
        $proker = ProgramKerja::all();
        $coa = coa::all();

        return view('penyusunan.kegiatan.create', ['kegiatan' => $kegiatan, 'proker' => $proker, 'coa' => $coa]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate input
        //dd($request->all());
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
            'biaya_keperluan' => 'numeric|required',
            'persen_dana' => 'numeric|required',
            'dana_bulan_berjalan' => 'numeric|required',
            'outcomes.*' => 'string|required',
            'indikators.*' => 'string|required',
            'waktu_aktivitas.*' => 'date|required',
            'penjelasan.*' => 'string|required',
            'kategori.*' => 'string|required',
        ]);

        $validateData['user_id'] = Auth::id();
        $validateData['unit_id'] = Auth::user()->unit_id;
        $validateData['satuan_id'] = Auth::user()->unit->satuan_id;

        // Create Kegiatan
        $kegiatan = Kegiatan::create($validateData);

        if ($kegiatan) {
            // Store outcomes
            foreach ($request->outcomes as $outcome) {
                OutcomeKegiatan::create([
                    'kegiatan_id' => $kegiatan->id,
                    'outcome' => $outcome,
                ]);
            }

            // Store indicators
            foreach ($request->indikators as $indikator) {
                IndikatorKegiatan::create([
                    'kegiatan_id' => $kegiatan->id,
                    'indikator' => $indikator,
                ]);
            }

            // Store aktivitas details and budget needs
            foreach ($request->waktu_aktivitas as $index => $waktu) {
                // Create aktivitas and link with kegiatan_id
                $aktivitas = Aktivitas::create([
                    'kegiatan_id' => $kegiatan->id, // Automatically add kegiatan_id
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
    public function show(Kegiatan $kegiatan)
    {
        $proker = ProgramKerja::all();

        $kegiatan->load(['tor.outcomeKegiatan', 'tor.indikatorKegiatan', 'tor.aktivitas', 'tor.aktivitas.kebutuhanAnggaran', 'tor.rab']);

        return view('penyusunan.kegiatan.detail', [
            'kegiatan' => $kegiatan,
            'proker' => $proker
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kegiatan $kegiatan)
    {
        $proker = ProgramKerja::all();

        return view('penyusunan.kegiatan.edit', ['kegiatan' => $kegiatan, 'proker' => $proker]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kegiatan $kegiatan)
    {
        $validateData = $request->validate([
            'nama_kegiatan' => [
                'string',
                'required',
                Rule::unique('kegiatans')->ignore($kegiatan->id),
            ],
            'total_biaya' => 'integer|required',
            'proker_id' => 'string|required|exists:program_kerjas,id',
        ]);

        $validateData['user_id'] = Auth::id();

        $user = Auth::user();

        $validateData['unit_id'] = $user->unit_id;

        $validateData['satuan_id'] = $user->unit->satuan_id;

        $kegiatan->update(['status' => 'Belum Diajukan']);

        $kegiatan->update($validateData);

        if ($kegiatan) {
            return to_route('penyusunan.kegiatan.view')->with('success', 'Data Telah Ditambahkan');
        } else {
            return to_route('penyusunan.kegiatan.view')->with('failed', 'Data Gagal Ditambahkan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kegiatan $kegiatan)
    {
        $kegiatan->delete();

        if ($kegiatan) {
            return to_route('penyusunan.kegiatan.view')->with('success', 'Data Telah Dihapus');
        } else {
            return to_route('penyusunan.kegiatan.view')->with('failed', 'Data Gagal Dihapus');
        }
    }

    // Pengajuan Anggaran Tahunan

    public function pengajuanIndex()
    {
        $kegiatan = Kegiatan::all();

        //$kegiatan = Kegiatan::whereIn('status', ['Belum Diajukan'])->get();

        return view('pengajuan.anggaranTahunan.view', ['kegiatan' => $kegiatan]);
    }

    public function ajukan(Kegiatan $kegiatan)
    {
        $kegiatan->update(['status' => 'Telah Diajukan']);

        return redirect()->route('pengajuan.anggaranTahunan.view')->with('success', 'Status telah diubah menjadi "Telah Diajukan"');
    }

    public function konfirmasiPengajuan(Kegiatan $kegiatan)
    {
        $proker = ProgramKerja::all();

        $kegiatan->load('unit');

        return view('pengajuan.anggaranTahunan.detail', ['kegiatan' => $kegiatan, 'proker' => $proker]);
    }


    // Validasi Pengajuan by Unit & Atasan

    public function validasi_index()
    {
        $kegiatan = Kegiatan::whereIn('status', ['Telah Diajukan', 'Diterima'])->get();

        $proker = ProgramKerja::all();

        return view('validasi.validasiAnggaran.view', ['kegiatan' => $kegiatan, 'proker' => $proker]);
    }

    public function validasi_pengajuan_tahunan(Kegiatan $kegiatan)
    {
        $proker = ProgramKerja::all();

        $kegiatan->load('unit');

        return view('validasi.validasiAnggaran.validasi', ['kegiatan' => $kegiatan, 'proker' => $proker]);
    }

    public function acc_validasi_pengajuan_tahunan(Request $request, Kegiatan $kegiatan)
    {
        if ($request->input('action') == 'reject') {
            return redirect()->route('pesanPerbaikan.anggaranTahunan.create')->with('success', 'Pengajuan telah ditolak.');
        } elseif ($request->input('action') == 'accept') {
            $kegiatan->update(['status' => 'Proses Finalisasi Pengajuan']);
            return redirect()->route('validasi.validasiAnggaran.view')->with('success', 'Pengajuan telah diterima.');
        }
    }

    // Finalisasi Pengajuan Untuk Pendanaan

    public function finalisasi_index()
    {
        $kegiatan = Kegiatan::whereIn('status', ['Proses Finalisasi Pengajuan ', 'Diterima'])->get();

        $proker = ProgramKerja::all();

        return view('finalisasi.finalisasiKegiatan.view', ['kegiatan' => $kegiatan, 'proker' => $proker]);
    }

    public function finalisasi_pengajuan_tahunan(Kegiatan $kegiatan)
    {
        $proker = ProgramKerja::all();

        $kegiatan->load('unit');

        return view('finalisasi.finalisasiKegiatan.finalisasi', ['kegiatan' => $kegiatan, 'proker' => $proker]);
    }

    public function acc_finalisasi_pengajuan_tahunan(Request $request, Kegiatan $kegiatan)
    {
        if ($request->input('action') == 'Tidak Didanai') {
            return redirect()->route('finalisasi.finalisasiKegiatan.view')->with('success', 'Pengajuan telah ditolak.');
        } elseif ($request->input('action') == 'accept') {
            $kegiatan->update(['status' => 'Diterima']);
            return redirect()->route('finalisasi.finalisasiKegiatan.view')->with('success', 'Pengajuan telah diterima.');
        }
    }

    //SAW
    public function calculateSAW()
{
    $kriteria = DB::table('kriterias')
        ->where('status_kriteria', true)
        ->get();

    $kegiatanKriteria = DB::table('kriteria_kegiatan')
        ->join('kegiatans', 'kriteria_kegiatan.kegiatan_id', '=', 'kegiatans.id')
        ->join('kriterias', 'kriteria_kegiatan.kriteria_id', '=', 'kriterias.id')
        ->leftJoin('subkriterias', 'kriteria_kegiatan.subkriteria_id', '=', 'subkriterias.id')
        ->select(
            'kriteria_kegiatan.kegiatan_id',
            'kriteria_kegiatan.kriteria_id',
            'subkriterias.nilai_bobot_subkriteria',
            'kriterias.jenis_kriteria',
            'kriterias.bobot_kriteria'
        )
        ->get();

    $normalisasi = [];
    foreach ($kriteria as $k) {
        $filtered = $kegiatanKriteria->where('kriteria_id', $k->id);
        if ($filtered->isEmpty()) continue; 
    
        if ($k->jenis_kriteria === 'Benefit') {
            $maxValue = $filtered->max('nilai_bobot_subkriteria');
            if ($maxValue > 0) {
                foreach ($filtered as $item) {
                    $normalisasi[$item->kegiatan_id][$k->id] = $item->nilai_bobot_subkriteria / $maxValue;
                }
            }
        } elseif ($k->jenis_kriteria === 'Cost') {
            $minValue = $filtered->min('nilai_bobot_subkriteria');
            if ($minValue > 0) {
                foreach ($filtered as $item) {
                    $normalisasi[$item->kegiatan_id][$k->id] = $minValue / $item->nilai_bobot_subkriteria;
                }
            }
        }
    }

    $hasilSAW = [];
    foreach ($normalisasi as $kegiatanId => $kriteriaValues) {
        $totalScore = 0;
        foreach ($kriteriaValues as $kriteriaId => $normalizedValue) {
            $kriteriaObj = $kriteria->firstWhere('id', $kriteriaId);
            if ($kriteriaObj) { 
                $totalScore += $normalizedValue * $kriteriaObj->bobot_kriteria;
            }
        }
        $hasilSAW[$kegiatanId] = $totalScore;
    }

    foreach ($hasilSAW as $kegiatanId => $score) {
        DB::table('perangkingan')->updateOrInsert(
            ['id' => Str::uuid(),
                'kegiatan_id' => $kegiatanId],
            ['hasil_akhir' => $score, 'updated_at' => now()]
        );
    }

    return response()->json(['success' => true, 'message' => 'Perhitungan SAW selesai.']);
}



public function triggerCalculateSAW()
{
    try {
        DB::table('perangkingan')->truncate();

        $this->calculateSAW();

        return response()->json(['success' => true, 'message' => 'Perhitungan SAW berhasil dilakukan dan disimpan.']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
    }
}


    // Pengajuan Pendanaan Kegiatan

    public function pendanaan_kegiatan_index()
    {
        $kegiatan = Kegiatan::whereIn('status', ['Diterima', 'Proses Pendanaan'])->get();

        $proker = ProgramKerja::all();

        return view('pengajuan.pendanaanKegiatan.view', ['kegiatan' => $kegiatan, 'proker' => $proker]);
    }

    public function konfirmasiPendanaan(Kegiatan $kegiatan)
    {
        $proker = ProgramKerja::all();

        $kegiatan->load('unit');

        return view('pengajuan.pendanaanKegiatan.detail', ['kegiatan' => $kegiatan, 'proker' => $proker]);
    }

    public function pendanaan(Kegiatan $kegiatan)
    {
        $kegiatan->update(['status' => 'Proses Pendanaan']);

        return redirect()->route('pengajuan.pendanaanKegiatan.view')->with('success', 'Status telah diubah menjadi "Telah Diajukan"');
    }

    // Proses Pendanaan
    public function give_pendanaan_index()
    {
        $kegiatan = Kegiatan::whereIn('status', ['Proses Pendanaan', 'Telah Didanai'])->get();

        $proker = ProgramKerja::all();

        $kegiatan->load(['unit', 'user']);

        return view('pendanaan.givePendanaan.view', ['kegiatan' => $kegiatan, 'proker' => $proker]);
    }

    public function give_konfirmasi_Pendanaan(Kegiatan $kegiatan)
    {
        $proker = ProgramKerja::all();

        $kegiatan->load('unit');

        return view('pendanaan.givePendanaan.detail', ['kegiatan' => $kegiatan, 'proker' => $proker]);
    }
}
