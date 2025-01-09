<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kegiatan;
use App\Models\Pendanaan;
use App\Models\Rab;
use App\Models\satuanKerja;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function getView()
    {
        $user = Auth::user();

        $isAtasanUnit = $user->hasRole('Atasan Unit');
        $isPenggunaAnggaran = $user->hasRole('Pengguna Anggaran');

        if ($isAtasanUnit || $isPenggunaAnggaran) {
            $unitId = $user->unit_id;

            $jumlahPengajuanTahunan = Kegiatan::where('unit_id', $unitId)->where('jenis', 'Tahunan')->count();
            $jumlahPengajuanBulanan = Kegiatan::where('unit_id', $unitId)->where('jenis', 'Bulanan')->count();
            $kegiatanDilaksanakan = Kegiatan::where('unit_id', $unitId)
                ->whereHas('status', function ($query) {
                    $query->where('status', 'Selesai');
                })
                ->count();
            $totalPendanaan = Pendanaan::where('unit_id', $unitId)->sum('besaran_transfer');
            $pengajuanTerbaru = Kegiatan::with('tor')
                ->where('unit_id', $unitId)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        } else {
            $jumlahPengajuanTahunan = Kegiatan::where('jenis', 'Tahunan')->count();
            $jumlahPengajuanBulanan = Kegiatan::where('jenis', 'Bulanan')->count();
            $kegiatanDilaksanakan = Kegiatan::whereHas('status', function ($query) {
                $query->where('status', 'Selesai');
            })->count();
            $totalPendanaan = Pendanaan::sum('besaran_transfer');
            $pengajuanTerbaru = Kegiatan::with('tor')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        return view('dashboard.dashboard', compact(
            'user',
            'jumlahPengajuanTahunan',
            'jumlahPengajuanBulanan',
            'kegiatanDilaksanakan',
            'totalPendanaan',
            'pengajuanTerbaru'
        ));
    }

    public function getDashboardData()
    {
        $currentYear = Carbon::now()->year;

        $user = Auth::user();

        $isAtasanUnit = $user->hasRole('Atasan Unit');
        $isPenggunaAnggaran = $user->hasRole('Pengguna Anggaran');

        if ($isAtasanUnit || $isPenggunaAnggaran) {
            $unitId = $user->unit_id;
            $satkerId = $user->unit->satuan->id;
            $totalPendanaanPerBulan = Pendanaan::where('unit_id', $unitId)->selectRaw('MONTH(created_at) as bulan, SUM(besaran_transfer) as total')
                ->whereYear('created_at', $currentYear)
                ->groupByRaw('MONTH(created_at)')
                ->pluck('total', 'bulan');

            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $formattedData = array_fill(1, 12, 0);
            foreach ($totalPendanaanPerBulan as $month => $value) {
                $formattedData[$month] = $value;
            }

            $pengajuanPerSatuanKerja = Kegiatan::whereHas('unit', function ($query) use ($satkerId) {
                $query->where('satuan_id', $satkerId);
            })
                ->selectRaw('satuan_id, COUNT(*) as jumlah_kegiatan')
                ->groupBy('satuan_id')
                ->get()
                ->mapWithKeys(function ($item) {
                    $satuanKerja = satuanKerja::find($item->satuan_id);
                    return [$satuanKerja->nama ?? 'Unknown' => $item->jumlah_kegiatan];
                });
        } else {
            $totalPendanaanPerBulan = Pendanaan::selectRaw('MONTH(created_at) as bulan, SUM(besaran_transfer) as total')
                ->whereYear('created_at', $currentYear)
                ->groupByRaw('MONTH(created_at)')
                ->pluck('total', 'bulan');

            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $formattedData = array_fill(1, 12, 0);
            foreach ($totalPendanaanPerBulan as $month => $value) {
                $formattedData[$month] = $value;
            }

            $pengajuanPerSatuanKerja = Kegiatan::selectRaw('satuan_id, COUNT(*) as jumlah_kegiatan')
                ->groupBy('satuan_id')
                ->get()
                ->mapWithKeys(function ($item) {
                    $satuanKerja = satuanKerja::find($item->satuan_id);
                    return [$satuanKerja->nama ?? 'Unknown' => $item->jumlah_kegiatan];
                });
        }
        return response()->json([
            'barChart' => [
                'categories' => $months,
                'data' => array_values($formattedData),
            ],
            'pieChart' => [
                'labels' => $pengajuanPerSatuanKerja->keys(),
                'data' => $pengajuanPerSatuanKerja->values(),
            ],
        ]);
    }
}
