<?php

namespace App\Http\Controllers;

use App\Models\Aktivitas;
use App\Models\coa;
use App\Models\indikatorKegiatan;
use App\Models\kebutuhanAnggaran;
use App\Models\Kegiatan;
use App\Models\Kriteria;
use App\Models\outcomeKegiatan;
use App\Models\ProgramKerja;
use App\Models\Rab;
use App\Models\Tor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KegiatanBulananController extends Controller
{
    public function index(Kegiatan $kegiatan)
    {
        $user = auth()->user();
        $unitId = $user->unit_id;
        $isAtasanUnit = $user->hasRole('Atasan Unit');
        $isPenggunaAnggaran = $user->hasRole('Pengguna Anggaran');

        if ($isAtasanUnit || $isPenggunaAnggaran) {
            $kegiatanBulanan = Kegiatan::where('tahunan_id', $kegiatan->id)->where('unit_id', $unitId)->get();
        } else {
            $kegiatanBulanan = Kegiatan::where('tahunan_id', $kegiatan->id)->get();
        }

        $proker = ProgramKerja::all();

        return view('pengajuan.pendanaanKegiatan.viewBulanan', [
            'kegiatanBulanan' => $kegiatanBulanan,
            'proker' => $proker,
            'kegiatan' => $kegiatan->tor->nama_kegiatan,
            'kegiatan_id' => $kegiatan->id,
        ]);
    }

    public function create(Kegiatan $kegiatan)
    {
        $kegiatanWithDetails = Kegiatan::where('id', $kegiatan->id)
            ->with(['tor.aktivitas', 'tor.outcomeKegiatan', 'tor.indikatorKegiatan', 'tor.aktivitas.kebutuhanAnggaran'])
            ->firstOrFail();


        $user = auth()->user();
        $unitId = $user->unit_id;
        $isAtasanUnit = $user->hasRole('Atasan Unit');
        $isPenggunaAnggaran = $user->hasRole('Pengguna Anggaran');

        if ($isAtasanUnit || $isPenggunaAnggaran) {
            $proker = ProgramKerja::where('unit_id', $unitId)->get();
        } else {
            $proker = ProgramKerja::all();
        }
        $coa = Coa::all();

        return view('pengajuan.pendanaanKegiatan.createBulanan', [
            'kegiatan' => $kegiatanWithDetails,
            'proker' => $proker,
            'coa' => $coa,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Kegiatan $kegiatan)
    {
        // Reload the $kegiatan with necessary relationships
        $kegiatan = Kegiatan::where('id', $kegiatan->id)
            ->with(['tor.aktivitas.kebutuhanAnggaran'])
            ->firstOrFail();

        $validateData = $request->validate([
            'proker_id' => 'string|required|exists:program_kerjas,id',
            'nama_kegiatan' => 'string|required',
            'waktu' => 'required|date_format:Y-m',
            'pic' => 'string|required',
            'kepesertaan' => 'string|required',
            'nomor_standar_akreditasi' => 'string|required',
            'penjelasan_standar_akreditasi' => 'string|required',
            'coa_id' => 'string|required|exists:coas,id',
            'latar_belakang' => 'string|required',
            'tujuan' => 'string|required',
            'manfaat_internal' => 'string|required',
            'manfaat_eksternal' => 'string|required',
            'metode_pelaksanaan' => 'string|required',
            'outcomes.*' => 'string|required',
            'indikators.*' => 'string|required',
        ]);

        $validateData['user_id'] = Auth::id();
        $validateData['unit_id'] = Auth::user()->unit_id;
        $validateData['satuan_id'] = Auth::user()->unit->satuan_id;

        $tor = Tor::create($validateData);

        if ($tor) {
            $status = DB::table('statuses')->where('status', 'Belum Diajukan')->first();
            $newKegiatan = Kegiatan::create([
                'tor_id' => $tor->id,
                'status_id' => $status->id,
                'user_id' => $validateData['user_id'],
                'unit_id' => $validateData['unit_id'],
                'satuan_id' => $validateData['satuan_id'],
                'rab_id' => null,
                'jenis' => 'Bulanan',
                'tahunan_id' => $request->tahunan_id,
            ]);

            // Save outcomes and indicators
            foreach ($request->outcomes as $outcome) {
                outcomeKegiatan::create([
                    'tor_id' => $tor->id,
                    'outcome' => $outcome,
                ]);
            }

            foreach ($request->indikators as $indikator) {
                indikatorKegiatan::create([
                    'tor_id' => $tor->id,
                    'indikator' => $indikator,
                ]);
            }

            $totalBiaya = 0;
            $oldAktivitas = $kegiatan->tor->aktivitas ?? [];

            foreach ($oldAktivitas as $aktivitas) {
                $newAktivitas = Aktivitas::create([
                    'tor_id' => $tor->id,
                    'waktu_aktivitas' => $aktivitas->waktu_aktivitas,
                    'penjelasan' => $aktivitas->penjelasan,
                    'kategori' => $aktivitas->kategori,
                ]);

                foreach ($aktivitas->kebutuhanAnggaran as $anggaran) {
                    $newAnggaran = kebutuhanAnggaran::create([
                        'aktivitas_id' => $newAktivitas->id,
                        'jumlah' => $anggaran->jumlah,
                        'uraian_aktivitas' => $anggaran->uraian_aktivitas,
                        'frekwensi' => $anggaran->frekwensi,
                        'nominal_volume' => $anggaran->nominal_volume,
                        'satuan_volume' => $anggaran->satuan_volume,
                        'harga' => $anggaran->harga,
                    ]);

                    $totalBiaya += $newAnggaran->jumlah;
                }
            }

            $rab = Rab::create([
                'tor_id' => $tor->id,
                'kegiatan_id' => $newKegiatan->id,
                'total_biaya' => $totalBiaya,
            ]);

            $newKegiatan->update(['rab_id' => $rab->id]);

            return redirect()->route('viewBulanan', $kegiatan->id)->with('success', 'Data telah ditambahkan.');
        }

        return redirect()->route('viewBulanan', $kegiatan->id)->with('failed', 'Data gagal ditambahkan.');
    }

    public function edit(Tor $tor)
    {
        $user = auth()->user();
        $unitId = $user->unit_id;
        $isAtasanUnit = $user->hasRole('Atasan Unit');
        $isPenggunaAnggaran = $user->hasRole('Pengguna Anggaran');

        if ($isAtasanUnit || $isPenggunaAnggaran) {
            $proker = ProgramKerja::where('unit_id', $unitId)->get();
        } else {
            $proker = ProgramKerja::all();
        }
        $coa = Coa::all();

        $aktivitas = Aktivitas::where('tor_id', $tor->id)->get();
        $outcomes = outcomeKegiatan::where('tor_id', $tor->id)->get();
        $indikators = indikatorKegiatan::where('tor_id', $tor->id)->get();

        $kegiatan = Kegiatan::where('tor_id', $tor->id)->first();

        if (!$kegiatan) {
            return redirect()->back()->with('error', 'Kegiatan tidak ditemukan.');
        }

        return view('pengajuan.pendanaanKegiatan.edit', compact('tor', 'aktivitas', 'proker', 'coa', 'outcomes', 'indikators', 'kegiatan'));
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'proker_id' => 'string|required|exists:program_kerjas,id',
            'nama_kegiatan' => 'string|required',
            'waktu' => 'required|date_format:Y-m',
            'pic' => 'string|required',
            'kepesertaan' => 'string|required',
            'nomor_standar_akreditasi' => 'string|required',
            'penjelasan_standar_akreditasi' => 'string|required',
            'coa_id' => 'string|required|exists:coas,id',
            'latar_belakang' => 'string|required',
            'tujuan' => 'string|required',
            'manfaat_internal' => 'string|required',
            'manfaat_eksternal' => 'string|required',
            'metode_pelaksanaan' => 'string|required',
            'outcomes.*' => 'string|required',
            'indikators.*' => 'string|required',
        ]);

        $tor = Tor::findOrFail($id);
        $kegiatan = Kegiatan::where('tor_id', $tor->id)->first();

        if (!$kegiatan) {
            return redirect()->back()->with('error', 'Kegiatan tidak ditemukan.');
        }
        $tor->update($validateData);

        $existingOutcomeIds = $request->outcome_ids ?? [];
        $existingIndikatorIds = $request->indikator_ids ?? [];

        // Handle Outcomes: Create/Update/Delete
        $outcomeIdsToKeep = [];
        foreach ($request->outcomes as $index => $outcome) {
            $outcomeModel = outcomeKegiatan::updateOrCreate(
                ['tor_id' => $id, 'id' => $existingOutcomeIds[$index] ?? null],
                ['outcome' => $outcome]
            );
            $outcomeIdsToKeep[] = $outcomeModel->id;
        }

        outcomeKegiatan::where('tor_id', $id)
            ->whereNotIn('id', $outcomeIdsToKeep)
            ->delete();

        $indikatorIdsToKeep = [];
        foreach ($request->indikators as $index => $indikator) {
            $indikatorModel = indikatorKegiatan::updateOrCreate(
                ['tor_id' => $id, 'id' => $existingIndikatorIds[$index] ?? null],
                ['indikator' => $indikator]
            );
            $indikatorIdsToKeep[] = $indikatorModel->id;
        }

        indikatorKegiatan::where('tor_id', $id)
            ->whereNotIn('id', $indikatorIdsToKeep)
            ->delete();

        return redirect()->route('viewBulanan', $kegiatan->tahunan_id)->with('success', 'Data telah diperbarui.');
    }

    public function showAktivitasBulanan(Tor $tor)
    {
        $kegiatan = Kegiatan::where('tor_id', $tor->id)->first();
        $aktivitas = Aktivitas::with('kebutuhanAnggaran')->where('tor_id', $tor->id)->get();

        return view('pengajuan.pendanaanKegiatan.aktivitasBulanan', compact('tor', 'aktivitas', 'kegiatan'));
    }

    public function destroyBulanan(Kegiatan $kegiatan)
    {
        $kegiatan->delete();

        if ($kegiatan) {
            return to_route('viewBulanan', $kegiatan->tahunan_id)->with('success', 'Data Telah Dihapus');
        } else {
            return to_route('viewBulanan', $kegiatan->tahunan_id)->with('failed', 'Data Gagal Dihapus');
        }
    }
}
