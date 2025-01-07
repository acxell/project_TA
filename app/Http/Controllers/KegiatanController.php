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
use App\Models\Perangkingan;
use App\Models\ProgramKerja;
use App\Models\RiwayatPerangkingan;
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
        $user = auth()->user();
        $unitId = $user->unit_id;
        $isAtasanUnit = $user->hasRole('Atasan Unit');
        $isPenggunaAnggaran = $user->hasRole('Pengguna Anggaran');

        if ($isAtasanUnit || $isPenggunaAnggaran) {
            $kegiatan = Kegiatan::where('jenis', 'Tahunan')->where('unit_id', $unitId)->get();
        } else {
            $kegiatan = Kegiatan::where('jenis', 'Tahunan')->get();
        }

        return view('penyusunan.kegiatan.view', ['kegiatan' => $kegiatan]);
    }

    public function riwayatIndex()
    {
        $kegiatan = RiwayatPerangkingan::all();

        return view('finalisasi.riwayat', ['kegiatan' => $kegiatan]);
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
        $user = auth()->user();
        $unitId = $user->unit_id;
        $isAtasanUnit = $user->hasRole('Atasan Unit');
        $isPenggunaAnggaran = $user->hasRole('Pengguna Anggaran');

        if ($isAtasanUnit || $isPenggunaAnggaran) {
            $kegiatan = Kegiatan::whereNotNull('rab_id')
                ->where('unit_id', $unitId)
                ->whereHas('rab', function ($query) {
                    $query->where('total_biaya', '>', 0);
                })
                ->where('jenis', 'Tahunan')
                ->get();
        } else {
            $kegiatan = Kegiatan::whereNotNull('rab_id')
                ->whereHas('rab', function ($query) {
                    $query->where('total_biaya', '>', 0);
                })
                ->where('jenis', 'Tahunan')
                ->get();
        }
        //$kegiatan = Kegiatan::whereIn('status', ['Belum Diajukan'])->get();

        return view('pengajuan.anggaranTahunan.view', ['kegiatan' => $kegiatan]);
    }

    public function ajukan(Kegiatan $kegiatan)
    {
        $kegiatan->update(['status' => 1]);

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
        $user = auth()->user();
        $unitId = $user->unit_id;
        $isAtasanUnit = $user->hasRole('Atasan Unit');

        if ($isAtasanUnit) {
            $kegiatan = Kegiatan::whereNotNull('rab_id')
                ->where('unit_id', $unitId)
                ->whereIn('status', [1, 11, 3, 2])
                ->where('jenis', 'Tahunan')
                ->get();
        } else {
            $kegiatan = Kegiatan::whereIn('status', [1, 11, 3, 2])
                ->where('jenis', 'Tahunan')
                ->get();
        }

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
        $user = auth()->user();
        $isAtasanUnit = $user->hasRole('Atasan Unit');
        $isAtasanYayasan = $user->hasRole('Atasan Yayasan');
        $isAtasanSU = $user->hasRole('Super Admin');

        if ($request->input('action') == 'reject') {
            return redirect()->route('pesanPerbaikan.anggaranTahunan.create')->with('success', 'Pengajuan telah ditolak.');
        } elseif ($request->input('action') == 'accept') {

            if ($isAtasanUnit) {
                $kegiatan->update(['status' => 2]);
            } elseif ($isAtasanYayasan || $isAtasanSU) {
                $kegiatan->update(['status' => 3]);
            }
            return redirect()->route('validasi.validasiAnggaran.view')->with('success', 'Pengajuan telah diterima.');
        }
    }

    // Validasi Pengajuan Bulanan By Unit
    public function validasiBulanan_index()
    {
        $user = auth()->user();
        $unitId = $user->unit_id;
        $isAtasanUnit = $user->hasRole('Atasan Unit');

        if ($isAtasanUnit) {
            $kegiatan = Kegiatan::whereNotNull('rab_id')
                ->where('unit_id', $unitId)
                ->whereIn('status', [1, 11, 4, 6, 7])
                ->where('jenis', 'Bulanan')
                ->get();
        } else {
            $kegiatan = Kegiatan::whereIn('status', [1, 11, 4, 6, 7])
                ->where('jenis', 'Bulanan')
                ->get();
        }

        $proker = ProgramKerja::all();

        return view('validasi.pendanaanKegiatan.view', ['kegiatan' => $kegiatan, 'proker' => $proker]);
    }

    public function validasi_pengajuan_bulanan(Kegiatan $kegiatan)
    {
        $proker = ProgramKerja::all();

        $kegiatan->load('unit');

        return view('validasi.pendanaanKegiatan.validasi', ['kegiatan' => $kegiatan, 'proker' => $proker]);
    }

    public function acc_validasi_pengajuan_bulanan(Request $request, Kegiatan $kegiatan)
    {

        if ($request->input('action') == 'reject') {
            return redirect()->route('pesanPerbaikan.anggaranBulanan.create')->with('success', 'Pengajuan telah ditolak.');
        } elseif ($request->input('action') == 'accept') {
            $kegiatan->update(['status' => 6]);
            return redirect()->route('validasi.validasiBulanan.view')->with('success', 'Pengajuan telah diterima.');
        }
    }

    // Finalisasi Pengajuan Untuk Pendanaan

    public function finalisasi_index()
    {
        $kegiatan = Perangkingan::whereHas('kegiatan', function ($query) {
            $query->whereIn('status', [3, 11, 5]);
        })->get();

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
            $kegiatan->update(['status' => 11]);
            return redirect()->route('finalisasi.finalisasiKegiatan.view')->with('success', 'Pengajuan telah diterima.');
        }
    }

    public function simpanSementara(Request $request)
    {
        $statusKegiatan = $request->input('kegiatan', []);
        session(['kegiatan_status' => $statusKegiatan]);

        return redirect()->route('finalisasi.finalisasiKegiatan.view')
            ->with('success', 'Perubahan status disimpan sementara. Klik Submit untuk menyimpan ke database.');
    }

    // public function konfirmasi()
    // {
    //     $kegiatanStatus = session('kegiatan_status', []);

    //     $allKegiatanIds = Kegiatan::pluck('id')->toArray();

    //     foreach ($allKegiatanIds as $kegiatanId) {
    //         $kegiatan = Kegiatan::find($kegiatanId);

    //         if ($kegiatan) {
    //             if (array_key_exists($kegiatanId, $kegiatanStatus)) {
    //                 $status = $kegiatanStatus[$kegiatanId];
    //             } else {
    //                 $status = 5;
    //             }

    //             $kegiatan->update(['status' => $status]);

    //             $hasilAkhir = Perangkingan::where('kegiatan_id', $kegiatanId)->value('hasil_akhir') ?? 0;

    //             // Simpan ke tabel riwayat_saw
    //             RiwayatPerangkingan::create([
    //                 'id' => Str::uuid(), // Membuat UUID
    //                 'kegiatan_id' => $kegiatanId,
    //                 'tanggal_penerimaan' => now(),
    //                 'hasil_akhir' => $hasilAkhir,
    //             ]);
    //         }
    //     }

    //     session()->forget('kegiatan_status');

    //     return redirect()->route('finalisasi.finalisasiKegiatan.view')
    //         ->with('success', 'Status kegiatan berhasil diperbarui.');
    // }

    public function konfirmasi()
    {
        $kegiatanStatus = session('kegiatan_status', []);

        $kegiatanIdsInPerangkingan = Perangkingan::pluck('kegiatan_id')->toArray();

        foreach ($kegiatanIdsInPerangkingan as $kegiatanId) {
            $kegiatan = Kegiatan::find($kegiatanId);

            if ($kegiatan) {
                $status = $kegiatanStatus[$kegiatanId] ?? 5;

                $kegiatan->update(['status' => $status]);

                $hasilAkhir = Perangkingan::where('kegiatan_id', $kegiatanId)->value('hasil_akhir') ?? 0;

                RiwayatPerangkingan::create([
                    'id' => Str::uuid(),
                    'kegiatan_id' => $kegiatanId,
                    'tanggal_penerimaan' => now(),
                    'hasil_akhir' => $hasilAkhir,
                ]);
            }
        }

        session()->forget('kegiatan_status');

        return redirect()->route('finalisasi.finalisasiKegiatan.view')
            ->with('success', 'Status kegiatan berhasil diperbarui.');
    }



    //SAW
    public function calculateSAW()
    {
        $kriteria = DB::table('kriterias')
            ->where('status_kriteria', true)
            ->get();

        $totalBobot = $kriteria->sum('bobot_kriteria');
        if ($totalBobot != 1) {
            logger("Total bobot kriteria: {$totalBobot}. Perangkingan tidak dapat dilakukan.");
            return response()->json([
                'success' => false,
                'message' => 'Perangkingan tidak dapat dilakukan. Pastikan total bobot kriteria sama dengan 1.'
            ]);
        }

        $kegiatanKriteria = DB::table('kriteria_kegiatan')
            ->join('kegiatans', 'kriteria_kegiatan.kegiatan_id', '=', 'kegiatans.id')
            ->join('kriterias', 'kriteria_kegiatan.kriteria_id', '=', 'kriterias.id')
            ->leftJoin('subkriterias', 'kriteria_kegiatan.subkriteria_id', '=', 'subkriterias.id')
            ->where('kegiatans.status', 3)
            ->select(
                'kriteria_kegiatan.kegiatan_id',
                'kriteria_kegiatan.kriteria_id',
                'subkriterias.nilai_bobot_subkriteria',
                'kriterias.jenis_kriteria',
                'kriterias.bobot_kriteria'
            )
            ->get();

        $normalisasi = [];
        logger("=== Tahap Normalisasi ===");
        foreach ($kriteria as $k) {
            $filtered = $kegiatanKriteria->where('kriteria_id', $k->id);
            if ($filtered->isEmpty()) continue;

            if ($k->jenis_kriteria === 'Benefit') {
                $maxValue = $filtered->max('nilai_bobot_subkriteria');
                logger("Kriteria ID: {$k->id} (Benefit), Max Value: {$maxValue}");
                if ($maxValue > 0) {
                    foreach ($filtered as $item) {
                        $normalizedValue = $item->nilai_bobot_subkriteria / $maxValue;
                        $normalisasi[$item->kegiatan_id][$k->id] = $normalizedValue;
                        logger("Kegiatan ID: {$item->kegiatan_id}, Nilai Normalisasi: {$normalizedValue}");
                    }
                }
            } elseif ($k->jenis_kriteria === 'Cost') {
                $minValue = $filtered->min('nilai_bobot_subkriteria');
                logger("Kriteria ID: {$k->id} (Cost), Min Value: {$minValue}");
                if ($minValue > 0) {
                    foreach ($filtered as $item) {
                        $normalizedValue = $minValue / $item->nilai_bobot_subkriteria;
                        $normalisasi[$item->kegiatan_id][$k->id] = $normalizedValue;
                        logger("Kegiatan ID: {$item->kegiatan_id}, Nilai Normalisasi: {$normalizedValue}");
                    }
                }
            }
        }

        $hasilSAW = [];
        logger("=== Tahap Perhitungan Skor Akhir ===");
        foreach ($normalisasi as $kegiatanId => $kriteriaValues) {
            $totalScore = 0;
            foreach ($kriteriaValues as $kriteriaId => $normalizedValue) {
                $kriteriaObj = $kriteria->firstWhere('id', $kriteriaId);
                if ($kriteriaObj) {
                    $weightedValue = $normalizedValue * $kriteriaObj->bobot_kriteria;
                    $totalScore += $weightedValue;
                    logger("Kegiatan ID: {$kegiatanId}, Kriteria ID: {$kriteriaId}, Nilai Normalisasi: {$normalizedValue}, Bobot Kriteria: {$kriteriaObj->bobot_kriteria}, Nilai Akhir: {$weightedValue}");
                }
            }
            $hasilSAW[$kegiatanId] = $totalScore;
            logger("Kegiatan ID: {$kegiatanId}, Skor Total: {$totalScore}");
        }

        foreach ($hasilSAW as $kegiatanId => $score) {
            DB::table('perangkingan')->updateOrInsert(
                [
                    'id' => Str::uuid(),
                    'kegiatan_id' => $kegiatanId,
                ],
                ['hasil_akhir' => $score, 'updated_at' => now()]
            );
        }

        return response()->json(['success' => true, 'message' => 'Perhitungan SAW selesai.']);
    }

    public function triggerCalculateSAW()
    {
        try {
            DB::table('perangkingan')->truncate();

            $response = $this->calculateSAW();

            if (!$response->getData()->success) {
                return $response;
            }

            return response()->json([
                'success' => true,
                'message' => 'Perhitungan SAW berhasil dilakukan dan disimpan.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    // Pengajuan Pendanaan Kegiatan
    public function pendanaan_kegiatan_index()
    {
        $user = auth()->user();
        $unitId = $user->unit_id;
        $isAtasanUnit = $user->hasRole('Atasan Unit');
        $isPenggunaAnggaran = $user->hasRole('Pengguna Anggaran');

        if ($isAtasanUnit || $isPenggunaAnggaran) {
            $kegiatan = Kegiatan::where('jenis', 'Tahunan')->whereIn('status', [1, 11, 6])->where('unit_id', $unitId)->get();
        } else {
            $kegiatan = Kegiatan::where('jenis', 'Tahunan')->whereIn('status', [1, 11, 6])->get();
        }


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
        $kegiatan->update(['status' => 1]);

        return redirect()->route('pengajuan.pendanaanKegiatan.view')->with('success', 'Status telah diubah menjadi "Telah Diajukan"');
    }

    // Proses Pendanaan
    public function give_pendanaan_index()
    {
        $kegiatan = Kegiatan::whereIn('status', [6, 7])->get();

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
