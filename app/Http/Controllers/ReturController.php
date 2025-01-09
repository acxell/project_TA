<?php

namespace App\Http\Controllers;

use App\Models\Retur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $retur = Retur::whereHas('status', function ($query) {
            $query->whereIn('status', ['Proses Validasi', 'Diterima', 'Revisi']);
        })->get();

        return view('pengajuan.retur.validasi', ['retur' => $retur]);
    }

    public function accept(Retur $retur)
    {
        $statusDiterima = DB::table('statuses')->where('status', 'Diterima')->first();
        $statusDone = DB::table('statuses')->where('status', 'Selesai')->first();

        $retur->status_id = $statusDiterima->id;
        $retur->save();

        $retur->lpj->status_id = $statusDone->id;
        $retur->lpj->save();

        $retur->lpj->kegiatan->status_id = $statusDone->id;
        $retur->lpj->kegiatan->save();

        return redirect()->route('pengajuan.retur.validasi')->with('success', 'Retur accepted and LPJ and Kegiatan statuses updated to Selesai.');
    }

    public function decline(Retur $retur)
    {
        $status = DB::table('statuses')->where('status', 'Revisi')->first();
        $retur->status_id = $status->id;
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
        $status = DB::table('statuses')->where('status', 'Proses Validasi')->first();
        $retur->status_id = $status->id;
        $retur->save();

        return redirect()->route('pengajuan.retur.view')->with('success', 'Retur updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Retur $retur)
    {
        //
    }
}
