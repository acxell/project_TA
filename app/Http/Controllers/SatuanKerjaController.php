<?php

namespace App\Http\Controllers;

use App\Models\satuanKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SatuanKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $satuan = satuanKerja::all();

        return view('satuan_kerja.view', ['satuan' => $satuan]);

        //return view('unit.viewunit');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $satuan = DB::table('satuan_kerjas')->get();

        return view('satuan_kerja.create', ['satuan' => $satuan]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'kode' => 'string|required|unique:satuan_kerjas',
            'nama' => 'string|required|unique:satuan_kerjas',
            'status' => 'boolean|required',
        ]);

        $satuan = satuanKerja::create($validateData);

        if ($satuan) {
            return to_route('satuan_kerja.view')->with('success', 'Data Telah Ditambahkan');
        } else {
            return to_route('satuan_kerja.view')->with('failed', 'Data Gagal Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(satuanKerja $satuan)
    {
        //
        return view('satuan_kerja.detail', ['satuan' => $satuan]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(satuanKerja $satuan)
    {

        return view('satuan_kerja.edit', ['satuan' => $satuan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, satuanKerja $satuan)
    {
        $validateData = $request->validate([
            'kode' => 'string|required|unique:satuan_kerjas',
            'nama' => 'string|required|unique:satuan_kerjas',
            'status' => 'string|required',
        ]);

        $satuan->update($validateData);

        if ($satuan) {
            return to_route('satuan_kerja.view')->with('success', 'Data Berhasil Diubah');
        } else {
            return to_route('satuan_kerja.view')->with('failed', 'Data Gagal Diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(satuanKerja $satuan)
    {
        $satuan->delete();

        if ($satuan) {
            return to_route('satuan_kerja.view')->with('success', 'Data Telah Dihapus');
        } else {
            return to_route('satuan_kerja.view')->with('failed', 'Data Gagal Dihapus');
        }
    }
}
