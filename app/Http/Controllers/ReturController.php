<?php

namespace App\Http\Controllers;

use App\Models\Retur;
use Illuminate\Http\Request;

class ReturController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $retur = Retur::all();

        return view('pengajuan.retur.view', ['retur' => $retur]);
    }

    public function indexVal()
    {
        $retur = Retur::whereIn('status', ['Proses Validasi', 'Diterima'])->get();

        return view('pengajuan.retur.validasi', ['retur' => $retur]);
    }

    public function accept(Retur $retur)
    {
        $retur->status = 'Diterima';
        $retur->save();

        $retur->lpj->status = 'Selesai';
        $retur->lpj->save();

        $retur->lpj->kegiatan->status = 'Selesai';
        $retur->lpj->kegiatan->save();

        return redirect()->route('pengajuan.retur.validasi')->with('success', 'Retur accepted and LPJ and Kegiatan statuses updated to Selesai.');
    }

    public function decline(Retur $retur)
    {
        $retur->status = 'Ditolak';
        $retur->save();

        return redirect()->route('pengajuan.retur.validasi')->with('success', 'Retur Declined');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Retur $retur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Retur $retur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Retur $retur)
    {
        $request->validate([
            'nominal_retur' => 'required|numeric',
            'bukti_retur' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Upload the new file if provided
        if ($request->hasFile('bukti_retur')) {
            $filePath = $request->file('bukti_retur')->store('retur_bukti', 'public');
            $retur->bukti_retur = $filePath;
        }

        $retur->nominal_retur = $request->nominal_retur;
        $retur->status = 'Proses Validasi';
        $retur->save();

        return redirect()->route('pengajuan.retur.view')->with('success', 'Retur updated successfully');
    }

    public function ajukan(Retur $retur)
    {
        $retur->status = 'Proses Validasi';
        $retur->save();

        return redirect()->route('pengajuan.retur.view')->with('success', 'Retur submitted for validation');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Retur $retur)
    {
        //
    }
}
