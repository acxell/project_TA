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
        $user = auth()->user();
        $unitId = $user->unit_id;

        if ($user->hasRole('Pengguna Anggaran')) {
            $retur = Retur::whereHas('lpj', function ($query) use ($unitId) {
                $query->where('unit_id', $unitId);
            })->get();
        } else {
            $retur = Retur::all();
        }

        return view('pengajuan.retur.view', ['retur' => $retur]);
    }

    public function indexVal()
    {
        $retur = Retur::whereIn('status', [13, 11, 4])->get();

        return view('pengajuan.retur.validasi', ['retur' => $retur]);
    }

    public function accept(Retur $retur)
    {
        $retur->status = 11;
        $retur->save();

        $retur->lpj->status = 10;
        $retur->lpj->save();

        $retur->lpj->kegiatan->status = 10;
        $retur->lpj->kegiatan->save();

        return redirect()->route('pengajuan.retur.validasi')->with('success', 'Retur accepted and LPJ and Kegiatan statuses updated to Selesai.');
    }

    public function decline(Retur $retur)
    {
        $retur->status = 4;
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

        if ($request->hasFile('bukti_retur')) {
            $filePath = $request->file('bukti_retur')->store('retur_bukti', 'public');
            $retur->bukti_retur = $filePath;
        }

        $retur->nominal_retur = $request->nominal_retur;
        $retur->status = 13;
        $retur->save();

        return redirect()->route('pengajuan.retur.view')->with('success', 'Retur updated successfully');
    }

    public function ajukan(Retur $retur)
    {
        $retur->status = 13;
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
