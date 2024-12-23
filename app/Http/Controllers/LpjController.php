<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Lpj;
use App\Models\Retur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LpjController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lpj = Lpj::all();

        return view('penyusunan.lpjKegiatan.view', ['lpj' => $lpj]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lpj = Lpj::all();
        $kegiatan = Kegiatan::where('status', 'Telah Didanai')->get();

        return view('penyusunan.lpjKegiatan.create', ['lpj' => $lpj, 'kegiatan' => $kegiatan]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'penjelasan_kegiatan' => 'string|required',
            'jumlah_peserta_undangan' => 'integer|required',
            'jumlah_peserta_hadir' => 'integer|required',
            'kegiatan_id' => 'string|required|exists:kegiatans,id',
        ]);

        $validateData['user_id'] = Auth::id();

        $user = Auth::user();

        $validateData['unit_id'] = $user->unit_id;

        $kegiatan = Kegiatan::findOrFail($validateData['kegiatan_id']);
        $validateData['proker_id'] = $kegiatan->tor->proker_id;

        $lpj = Lpj::create($validateData);

        if ($lpj) {
            return to_route('penyusunan.lpjKegiatan.view')->with('success', 'Data Telah Ditambahkan');
        } else {
            return to_route('penyusunan.lpjKegiatan.view')->with('failed', 'Data Gagal Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Lpj $lpj)
    {
        $kegiatan = Kegiatan::all();

        $lpj->load('proker');

        return view('penyusunan.lpjKegiatan.detail', ['lpj' => $lpj, 'kegiatan' => $kegiatan]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lpj $lpj)
    {
        $kegiatan = Kegiatan::all();

        return view('penyusunan.lpjKegiatan.edit', ['lpj' => $lpj, 'kegiatan' => $kegiatan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lpj $lpj)
    {
        $validateData = $request->validate([
            'penjelasan_kegiatan' => 'string|required',
            'jumlah_peserta_undangan' => 'integer|required',
            'jumlah_peserta_hadir' => 'integer|required',
            'kegiatan_id' => 'string|required|exists:kegiatans,id',
        ]);

        $validateData['user_id'] = Auth::id();

        $user = Auth::user();

        $validateData['unit_id'] = $user->unit_id;

        $kegiatan = Kegiatan::findOrFail($validateData['kegiatan_id']);
        $validateData['proker_id'] = $kegiatan->tor->proker_id;

        $lpj->update(['status' => 'Belum Diajukan']);
        $lpj->update($validateData);

        if ($lpj) {
            return to_route('penyusunan.lpjKegiatan.view')->with('success', 'Data Telah Ditambahkan');
        } else {
            return to_route('penyusunan.lpjKegiatan.view')->with('failed', 'Data Gagal Ditambahkan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lpj $lpj)
    {
        $lpj->delete();

        if ($lpj) {
            return to_route('penyusunan.lpjKegiatan.view')->with('success', 'Data Telah Dihapus');
        } else {
            return to_route('penyusunan.lpjKegiatan.view')->with('failed', 'Data Gagal Dihapus');
        }
    }

    // Pelaporan Pertanggung Jawaban

    public function pengajuanLpjIndex()
    {
        $lpj = Lpj::all();

        //$kegiatan = Kegiatan::whereIn('status', ['Belum Diajukan'])->get();

        return view('pengajuan.lpj.view', ['lpj' => $lpj]);
    }
    public function konfirmasiPengajuanLPJ(Lpj $lpj)
    {
        $kegiatan = Kegiatan::all();

        $lpj->load('proker');

        return view('pengajuan.lpj.detail', ['lpj' => $lpj, 'kegiatan' => $kegiatan]);
    }

    public function ajukanLpj(Lpj $lpj)
    {
        $lpj->update(['status' => 'Proses Pelaporan']);

        return redirect()->route('pengajuan.lpj.view')->with('success', 'Status telah diubah menjadi "Telah Diajukan"');
    }

    //Validasi Pengajuan
    public function validasi_lpj_index()
    {
        $lpj = Lpj::whereIn('status', ['Proses Pelaporan', 'Selesai', 'Perlu Retur', 'Ditolak'])->get();

        $kegiatan = Kegiatan::all();

        return view('validasi.validasiLpj.view', ['lpj' => $lpj, 'kegiatan' => $kegiatan]);
    }

    public function validasi_pelaporan_lpj(Lpj $lpj)
    {
        $kegiatan = Kegiatan::all();

        $lpj->load('proker');

        return view('validasi.validasiLpj.validasi', ['lpj' => $lpj, 'kegiatan' => $kegiatan]);
    }

    public function acc_validasi_pelaporan_lpj(Request $request, Lpj $lpj)
    {
        if ($request->input('action') == 'reject') {
            return redirect()->route('pesanPerbaikan.lpj.create')->with('success', 'Pengajuan telah ditolak.');
        } elseif ($request->input('action') == 'accept') {
            // Load related Kegiatan and Pendanaan data
            $lpj->load('kegiatan.pendanaan');

            // Calculate the total transfer amount from Pendanaan
            $totalTransfer = $lpj->kegiatan->pendanaan->first()->besaran_transfer;

            // Calculate the difference between total transfer and total belanja
            $remainingBalance = $totalTransfer - $lpj->total_belanja;

            // Determine status based on the remaining balance
            if ($remainingBalance > 0) {
                $lpj->update(['status' => 'Perlu Retur']);

                // Create a new Retur record
                Retur::create([
                    'lpj_id' => $lpj->id,
                    'total_retur' => $remainingBalance,
                    'status' => 'Lakukan Retur', // Initial status
                ]);

                return redirect()->route('validasi.validasiLpj.view')
                    ->with('success', 'Pengajuan diterima, tetapi terdapat sisa dana yang perlu dikembalikan.');
            } else {
                $lpj->update(['status' => 'Selesai']);
                return redirect()->route('validasi.validasiLpj.view')
                    ->with('success', 'Pengajuan diterima dan status telah selesai.');
            }
        }
    }
}
