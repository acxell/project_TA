<?php

namespace App\Http\Controllers;

use App\Models\ProgramKerja;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProgramKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programKerja = ProgramKerja::all();

        return view('penganggaran.programKerja.view', ['programKerja' => $programKerja]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programKerja = ProgramKerja::all();

        return view('penganggaran.programKerja.create', ['programKerja' => $programKerja]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'string|required|unique:program_kerjas',
            'status' => 'string|required',
        ]);

        $validateData['user_id'] = Auth::id();

        $programKerja = ProgramKerja::create($validateData);

        if ($programKerja) {
            return to_route('penganggaran.programKerja.view')->with('success', 'Data Telah Ditambahkan');
        } else {
            return to_route('penganggaran.programKerja.view')->with('failed', 'Data Gagal Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProgramKerja $programKerja)
    {
        return view('penganggaran.programKerja.detail', ['programKerja' => $programKerja]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProgramKerja $programKerja)
    {
        return view('penganggaran.programKerja.edit', ['programKerja' => $programKerja]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProgramKerja $programKerja)
    {
        $validateData = $request->validate([
            'nama' => [
                'string',
                'required',
                Rule::unique('program_kerjas')->ignore($programKerja->id),
            ],
            'status' => 'string|required',
        ]);
    
        $validateData['user_id'] = Auth::id();
    
        $programKerja->update($validateData);
    
        if ($programKerja) {
            return to_route('penganggaran.programKerja.view')->with('success', 'Data Telah Diperbarui');
        } else {
            return to_route('penganggaran.programKerja.view')->with('failed', 'Data Gagal Diperbarui');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProgramKerja $programKerja)
    {
        $programKerja->delete();

        if ($programKerja) {
            return to_route('penganggaran.programKerja.view')->with('success', 'Data Telah Dihapus');
        } else {
            return to_route('penganggaran.programKerja.view')->with('failed', 'Data Gagal Dihapus');
        }
    }
}
