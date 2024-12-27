<?php

namespace App\Http\Controllers;

use App\Models\Lpj;
use App\Models\RincianLpj;
use Illuminate\Http\Request;

class RincianLpjController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $lpj = Lpj::findOrFail($id);
        $rincianLpjs = RincianLpj::where('lpj_id', $id)->get();

        return view('penyusunan.lpjKegiatan.rincian', compact('lpj', 'rincianLpjs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $lpjId)
    {
        $request->validate([
            'waktu_belanja' => 'required|date',
            'harga' => 'required|integer',
            'keterangan' => 'required|string',
            'bukti' => 'required|file|mimes:pdf',
        ]);

        $filename = 'bukti_' . uniqid() . '.' . $request->file('bukti')->getClientOriginalExtension();
        $filePath = $request->file('bukti')->storeAs('bukti', $filename, 'public');

        $validatedData = [
            'lpj_id' => $lpjId,
            'waktu_belanja' => $request->waktu_belanja,
            'harga' => $request->harga,
            'keterangan' => $request->keterangan,
            'bukti' => $filePath,
        ];

        RincianLpj::create($validatedData);

        $totalBelanja = RincianLpj::where('lpj_id', $lpjId)->sum('harga');
        Lpj::where('id', $lpjId)->update(['total_belanja' => $totalBelanja]);

        return redirect()->route('penyusunan.lpjKegiatan.rincian', $lpjId)->with('success', 'Rincian LPJ berhasil ditambahkan.');
    }



    /**
     * Display the specified resource.
     */
    public function show(RincianLpj $rincianLpj)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RincianLpj $rincianLpj)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RincianLpj $rincianLpj)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    // Delete a rincian from LPJ
    public function destroy($id)
    {
        $rincianLpj = RincianLpj::findOrFail($id);
        $lpjId = $rincianLpj->lpj_id;
        $rincianLpj->delete();

        $totalBelanja = RincianLpj::where('lpj_id', $lpjId)->sum('harga');
        Lpj::where('id', $lpjId)->update(['total_belanja' => $totalBelanja]);

        return redirect()->route('penyusunan.lpjKegiatan.rincian', $lpjId)->with('success', 'Rincian LPJ berhasil dihapus.');
    }
}
