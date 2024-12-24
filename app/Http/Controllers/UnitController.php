<?php

namespace App\Http\Controllers;

use App\Models\satuanKerja;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Unit;
use Illuminate\Validation\Rule;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unit = Unit::all();

        return view('unit.view', ['units' => $unit]);

        //return view('unit.viewunit');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unit = DB::table('units')->get();
        $satuan = satuanKerja::where('status', true)->get();

        return view('unit.create', ['units' => $unit, 'satuan' => $satuan]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required|string|unique:units',
            'description' => 'required|string',
            'status' => 'required|boolean',
            'nomor_rekening' => 'required|string',
            'satuan_id' => 'required|string|exists:satuan_kerjas,id',
        ]);

        $unit = unit::create($validateData);

        if ($unit) {
            return to_route('unit.view')->with('success', 'Unit Telah Ditambahkan');
        } else {
            return to_route('unit.view')->with('failed', 'Unit Gagal Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(unit $unit)
    {
        //
        return view('unit.detail', ['unit' => $unit]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(unit $unit)
    {
        //$unit = DB::table('units')->get();
        $satuan = satuanKerja::where('status', true)->get();

        return view('unit.edit', ['unit' => $unit, 'satuan' => $satuan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, unit $unit)
    {
        $validateData = $request->validate([
            'nama' => [
                'required',
                'string',
                Rule::unique('units')->ignore($unit->id),
            ],
            'description' => 'required|string',
            'status' => 'required|boolean',
            'nomor_rekening' => 'required|string',
            'satuan_id' => 'required|string|exists:satuan_kerjas,id',
        ]);

        $unit->update($validateData);

        if ($unit) {
            return to_route('unit.view')->with('success', 'Unit Berhasil Diubah');
        } else {
            return to_route('unit.view')->with('failed', 'Unit Gagal Diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(unit $unit)
    {
        $unit->delete();

        if ($unit) {
            return to_route('unit.view')->with('success', 'Unit Telah Dihapus');
        } else {
            return to_route('unit.view')->with('failed', 'Unit Gagal Dihapus');
        }
    }
}
