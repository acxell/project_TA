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
        $kegiatan = Kegiatan::where('jenis', 'Tahunan')->get();

        return view('penyusunan.kegiatan.view', ['kegiatan' => $kegiatan]);
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
        $kegiatan = Kegiatan::whereNotNull('rab_id')
            ->whereHas('rab', function ($query) {
                $query->where('total_biaya', '>', 0);
            })
            ->where('jenis', 'Tahunan')
            ->get();
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
        $kegiatan = Kegiatan::whereIn('status', ['Telah Diajukan', 'Diterima', 'Proses Finalisasi Pengajuan', 'Diterima Atasan Unit'])
            ->where('jenis', 'Tahunan')
            ->get();

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
        $kegiatan = Perangkingan::all();

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
            ->where('kegiatans.status', 'Proses Finalisasi Pengajuan')
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
            // Truncate tabel perangkingan terlebih dahulu
            DB::table('perangkingan')->truncate();
    
            // Panggil fungsi calculateSAW dan tangkap responsnya
            $response = $this->calculateSAW();
    
            // Jika respons dari calculateSAW success: false, kembalikan respons gagal
            if (!$response->getData()->success) {
                return $response;
            }
    
            // Jika semua berjalan lancar, kembalikan respons sukses
            return response()->json([
                'success' => true,
                'message' => 'Perhitungan SAW berhasil dilakukan dan disimpan.'
            ]);
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi exception
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
    


    // Pengajuan Pendanaan Kegiatan

    public function pendanaan_kegiatan_index()
    {
        $kegiatan = Kegiatan::where('jenis', 'Tahunan')->whereIn('status', ['Diterima', 'Proses Pendanaan'])->get();

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
