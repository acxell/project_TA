<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Subkriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KriteriaController extends Controller
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
    public function show(Kriteria $kriteria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kriteria $kriteria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kriteria $kriteria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kriteria $kriteria)
    {
        //
    }

    public function showKriteria(Kriteria $kriteria)
    {
        $kriteria = Kriteria::with('subkriteria')->get();

        $kriteriaAktif = DB::table('kriterias')
        ->where('status_kriteria', true)
        ->get();

    $totalBobot = $kriteriaAktif->sum('bobot_kriteria');
    if ($totalBobot != 1) {
        logger("Total bobot kriteria: {$totalBobot}.");
        session()->flash('error', 'Pastikan total bobot kriteria Aktif sama dengan 1.');
    }

        return view('penyusunan.kriteria', compact('kriteria'));
    }

     // Store Aktivitas
     public function storeKriteria(Request $request)
     {
         $request->validate([
             'nama_kriteria' => 'required|string|max:50',
             'jenis_kriteria' => 'required|string',
             'tipe_kriteria' => 'required|string',
             'bobot_kriteria' => 'required|numeric|between:0,1',
             'status_kriteria' => 'required',
         ]);
 
         Kriteria::create([
            'nama_kriteria' => $request->nama_kriteria,
            'jenis_kriteria' => $request->jenis_kriteria,
            'tipe_kriteria' => $request->tipe_kriteria,
            'bobot_kriteria' => $request->bobot_kriteria,
            'status_kriteria' => $request->status_kriteria,
         ]);
 
         return redirect()->route('penyusunan.kriteria')->with('success', 'Kriteria berhasil dibuat');
     }
 
     // Update Aktivitas
     public function updateKriteria(Request $request, Kriteria $kriteria)
     {
         $request->validate([
            'nama_kriteria' => 'required|string|max:50',
             'jenis_kriteria' => 'required|string',
             'bobot_kriteria' => 'required|numeric|between:0,1',
             'status_kriteria' => 'required',
         ]);
 
         $kriteria->update($request->all());
 
         return redirect()->route('penyusunan.kriteria')->with('success', 'Kriteria berhasil diperbarui');
     }
 
     // Delete Aktivitas
     public function destroyKriteria(Kriteria $kriteria)
     {
         $kriteria->delete();
         return redirect()->route('penyusunan.kriteria')->with('success', 'Kriteria berhasil dihapus');
     }


    public function storeSubkriteria(Request $request, $id_kriteria)
    {
        $validateData = $request->validate([
            'batas_bawah_bobot_subkriteria' => 'nullable|numeric',
            'batas_atas_bobot_subkriteria' => 'nullable|numeric',
            'bobot_text_subkriteria' => 'nullable|string',
            'nilai_bobot_subkriteria' => 'required|numeric',
            'id_kriteria' => 'required|uuid',
        ]);

        $validateData['id_kriteria'] = $id_kriteria;

        Subkriteria::create($validateData);

        $id_kriteria = Kriteria::findOrFail($id_kriteria);

        return redirect()->back()->with('success', 'Sub Kriteria berhasil disimpan');
    }

    public function updateSubkriteria(Request $request, $id_subkriteria)
    {
        $validateData = $request->validate([
            'batas_bawah_bobot_subkriteria' => 'nullable|numeric',
            'batas_atas_bobot_subkriteria' => 'nullable|numeric',
            'bobot_text_subkriteria' => 'nullable|string',
            'nilai_bobot_subkriteria' => 'required|numeric',
        ]);

        $subkriteria = Subkriteria::findOrFail($id_subkriteria);

        $subkriteria->update($validateData);

        return redirect()->route('penyusunan.kriteria')
            ->with('success', 'Sub Kriteria berhasil diperbarui.');
    }



    public function destroySubkriteria($id_subkriteria)
    {
        $subkriteria = Subkriteria::findOrFail($id_subkriteria);

        $subkriteria->delete();

        return redirect()->route('penyusunan.kriteria')
            ->with('success', 'Sub Kriteria berhasil dihapus.');
    }
}
