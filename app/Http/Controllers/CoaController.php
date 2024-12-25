<?php

namespace App\Http\Controllers;

use App\Models\coa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoaController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coa = coa::all();

        return view('coa.view', ['coa' => $coa]);

        //return view('unit.viewunit');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $coa = Coa::with('kategoriCoa')->get();

        return view('coa.create', ['coa' => $coa]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'kode' => 'required|string|unique:coas',
            'nama' => 'required|string|unique:coas',
            'kategori_coa_id' => 'required|string',
        ]);

        $coa = coa::create($validateData);

        if ($coa) {
            return to_route('coa.view')->with('success', 'Data Telah Ditambahkan');
        } else {
            return to_route('coa.view')->with('failed', 'Data Gagal Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(coa $coa)
    {
        //
        return view('coa.detail', ['coa' => $coa]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(coa $coa)
    {

        return view('coa.edit', ['coa' => $coa]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, coa $coa)
    {
        $validateData = $request->validate([
            'kode' => 'required|string|unique:coas',
            'nama' => 'required|string|unique:coas',
            'kategori' => 'required|string',
        ]);

        $coa->update($validateData);

        if ($coa) {
            return to_route('coa.view')->with('success', 'Data Berhasil Diubah');
        } else {
            return to_route('coa.view')->with('failed', 'Data Gagal Diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(coa $coa)
    {
        $coa->delete();

        if ($coa) {
            return to_route('coa.view')->with('success', 'Data Telah Dihapus');
        } else {
            return to_route('coa.view')->with('failed', 'Data Gagal Dihapus');
        }
    }
}
