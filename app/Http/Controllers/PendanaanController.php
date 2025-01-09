<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Pendanaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PendanaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pendanaan = Pendanaan::all();

        return view('pendanaan.dataPendanaan.view', ['pendanaan' => $pendanaan]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($kegiatan_id)
    {
        $kegiatan = Kegiatan::findOrFail($kegiatan_id);

        return view('pendanaan.dataPendanaan.create', ['kegiatan' => $kegiatan]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validateData = $request->validate([
            'bukti_transfer' => 'required|mimes:pdf|max:2048',
            'besaran_transfer' => 'integer|required',
            'kegiatan_id' => 'string|required|exists:kegiatans,id',
        ], [
            'bukti_transfer.required' => 'Bukti transfer harus diupload.',
            'bukti_transfer.mimes' => 'Bukti transfer harus berformat PDF.',
            'bukti_transfer.max' => 'Ukuran bukti transfer maksimal 2MB.',
            'besaran_transfer.required' => 'Besaran transfer harus diisi.',
            'besaran_transfer.integer' => 'Besaran transfer harus berupa angka.',
            'kegiatan_id.required' => 'Kegiatan harus dipilih.',
            'kegiatan_id.exists' => 'Kegiatan tidak valid.',
        ]);

        $validateData['user_id'] = Auth::id();

        $kegiatan = Kegiatan::find($validateData['kegiatan_id']);
        if (!$kegiatan) {
            return back()->with('failed', 'Kegiatan tidak ditemukan.');
        }

        $validateData['unit_id'] = $kegiatan->unit_id;
        $validateData['satuan_id'] = $kegiatan->satuan_id;

        $filename = 'bukti_transfer_' . uniqid() . '.' . $request->file('bukti_transfer')->getClientOriginalExtension();
        $request->file('bukti_transfer')->storeAs('bukti_transfer', $filename, 'public');

        $validateData['bukti_transfer'] = 'bukti_transfer/' . $filename;

        // Create a new Pendanaan entry
        $pendanaan = Pendanaan::create($validateData);

        if ($pendanaan) {
            $status = DB::table('statuses')
            ->where('status', 'Telah Didanai')
            ->first();
            $kegiatan->status_id = $status->id;
            $kegiatan->save();

            return to_route('pendanaan.givePendanaan.view')->with('success', 'Pendanaan berhasil ditambahkan dan status kegiatan diperbarui.');
        } else {
            return to_route('pendanaan.givePendanaan.view')->with('failed', 'Gagal menambahkan pendanaan.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Pendanaan $pendanaan)
    {
        return view('pendanaan.dataPendanaan.detail', ['pendanaan' => $pendanaan]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pendanaan $pendanaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pendanaan $pendanaan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pendanaan $pendanaan)
    {
        //
    }
}
