<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Lpj;
use App\Models\PesanPerbaikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesanPerbaikanController extends Controller
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
    
     //Pesan Perbaikan Anggaran Tahunan
    public function create($kegiatan_id)
    {
        $kegiatan = Kegiatan::findOrFail($kegiatan_id);

        return view('pesanPerbaikan.anggaranTahunan.create', ['kegiatan' => $kegiatan]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validateData = $request->validate([
            'pesan' => 'required|string',
            'kegiatan_id' => 'string|required|exists:kegiatans,id',
        ]);

        $validateData['user_id'] = Auth::id();
        $validateData['unit_id'] = Auth::user()->unit_id;
        $validateData['satuan_id'] = Auth::user()->unit->satuan_id;

        //dd($validateData);

        $pesanPerbaikan = PesanPerbaikan::create($validateData);
        

        if ($pesanPerbaikan) {
            $kegiatan = Kegiatan::find($validateData['kegiatan_id']);

            $kegiatan->status = 4;
            $kegiatan->save();

            return to_route('validasi.validasiAnggaran.view')->with('success', 'Pesan Perbaikan Telah Ditambahkan dan Kegiatan Ditolak');
        } else {
            return to_route('validasi.validasiAnggaran.view')->with('failed', 'Pesan Perbaikan Gagal Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($kegiatan_id)
    {
        $pesanPerbaikan = PesanPerbaikan::where('kegiatan_id', $kegiatan_id)->latest()->first();

        if (!$pesanPerbaikan) {
            return redirect()->route('validasi.validasiAnggaran.view')->with('error', 'Pesan Perbaikan tidak ditemukan.');
        }

        return view('pesanPerbaikan.anggaranTahunan.detail', ['pesanPerbaikan' => $pesanPerbaikan]);
    }

    //Pesan Perbaikan Bulanan
    public function createBulanan($kegiatan_id)
    {
        $kegiatan = Kegiatan::findOrFail($kegiatan_id);

        return view('pesanPerbaikan.anggaranBulanan.create', ['kegiatan' => $kegiatan]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeBulanan(Request $request)
    {
        
        $validateData = $request->validate([
            'pesan' => 'required|string',
            'kegiatan_id' => 'string|required|exists:kegiatans,id',
        ]);

        $validateData['user_id'] = Auth::id();
        $validateData['unit_id'] = Auth::user()->unit_id;
        $validateData['satuan_id'] = Auth::user()->unit->satuan_id;

        //dd($validateData);

        $pesanPerbaikan = PesanPerbaikan::create($validateData);
        

        if ($pesanPerbaikan) {
            $kegiatan = Kegiatan::find($validateData['kegiatan_id']);

            $kegiatan->status = 4;
            $kegiatan->save();

            return to_route('validasi.validasiBulanan.view')->with('success', 'Pesan Perbaikan Telah Ditambahkan dan Kegiatan Ditolak');
        } else {
            return to_route('validasi.validasiBulanan.view')->with('failed', 'Pesan Perbaikan Gagal Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function showBulanan($kegiatan_id)
    {
        $pesanPerbaikan = PesanPerbaikan::where('kegiatan_id', $kegiatan_id)->latest()->first();

        if (!$pesanPerbaikan) {
            return redirect()->route('validasi.validasiBulanan.view')->with('error', 'Pesan Perbaikan tidak ditemukan.');
        }

        return view('pesanPerbaikan.anggaranBulanan.detail', ['pesanPerbaikan' => $pesanPerbaikan]);
    }


    //Pesan Perbaikan LPJ
    public function create_lpj($lpj_id)
    {
        $lpj = Lpj::findOrFail($lpj_id);

        return view('pesanPerbaikan.lpj.create', ['lpj' => $lpj]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store_lpj(Request $request)
    {
        $validateData = $request->validate([
            'pesan' => 'string|required',
            'lpj_id' => 'string|required|exists:lpjs,id',
        ]);

        $validateData['user_id'] = Auth::id();
        $validateData['unit_id'] = Auth::user()->unit_id;
        $validateData['satuan_id'] = Auth::user()->unit->satuan_id;

        $pesanPerbaikan = PesanPerbaikan::create($validateData);

        if ($pesanPerbaikan) {
            $lpj = Lpj::find($validateData['lpj_id']);

            $lpj->status = 4;
            $lpj->save();

            return to_route('validasi.validasiLpj.view')->with('success', 'Pesan Perbaikan Telah Ditambahkan dan Kegiatan Ditolak');
        } else {
            return to_route('validasi.validasiLpj.view')->with('failed', 'Pesan Perbaikan Gagal Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show_lpj($lpj_id)
    {
        $pesanPerbaikan = PesanPerbaikan::where('lpj_id', $lpj_id)->latest()->first();

        if (!$pesanPerbaikan) {
            return redirect()->route('validasi.validasiLpj.view')->with('error', 'Pesan Perbaikan tidak ditemukan.');
        }

        return view('pesanPerbaikan.lpj.detail', ['pesanPerbaikan' => $pesanPerbaikan]);
    }

}
