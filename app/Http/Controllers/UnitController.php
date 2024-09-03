<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Unit;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unit = DB::table('units')->get();

        return view('unit.view', ['units' => $unit]);

        //return view('unit.viewunit');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unit = DB::table('units')->get();

        return view('unit.create', ['units' => $unit]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'string|required|unique:units',
            'description' => 'string|required',
            'status' => 'string|required',
        ]);

        $unit = unit::create($validateData);

        if ($unit) {
            return to_route('unit.view')->with('success', 'Data Telah Ditambahkan');
        } else {
            return to_route('unit.view')->with('failed', 'Data Gagal Ditambahkan');
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

        return view('unit.edit', ['unit' => $unit]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, unit $unit)
    {
        $validateData = $request->validate([
            'nama' => 'string|required',
            'description' => 'string|required',
            'status' => 'string|required',
        ]);

        $unit->update($validateData);

        if ($unit) {
            return to_route('unit.view')->with('success', 'Data Berhasil Diubah');
        } else {
            return to_route('unit.view')->with('failed', 'Data Gagal Diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(unit $unit)
    {
        $unit->delete();

        if ($unit) {
            return to_route('unit.view')->with('success', 'Data Telah Dihapus');
        } else {
            return to_route('unit.view')->with('failed', 'Data Gagal Dihapus');
        }
    }
}
