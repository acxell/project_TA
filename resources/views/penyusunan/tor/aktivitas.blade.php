@extends('master.master')
@section('title', 'Daftar Aktivitas untuk TOR: ' . $tor->nama_kegiatan)
@section('content')

<div class="page-heading">
    <h3>Daftar Aktivitas untuk TOR: {{ $tor->nama_kegiatan }}</h3>

    <!-- Tombol Create Aktivitas -->
    <a href="#" class="btn btn-success my-3" data-bs-toggle="modal" data-bs-target="#modalCreateAktivitas">Create Aktivitas</a>
</div>

<section class="section">
    @foreach($aktivitas as $item)
    <div class="card">
        <div class="card-body">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Aktivitas</th>
                        <th>Waktu</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>{{ $item->penjelasan }}</td>
                        <td>{{ $item->waktu_aktivitas }}</td>
                        <td>{{ $item->kategori }}</td>
                        <td>
                            <!-- Tombol Edit Aktivitas -->
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditAktivitas{{ $item->id }}">Edit</button>

                            <!-- Tombol Delete Aktivitas -->
                            <form action="{{ route('penyusunan.aktivitas.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAnggaran{{ $item->id }}">Input Kebutuhan Anggaran</button>
                        </td>
                    </tr>

                    <!-- Modal untuk input kebutuhan anggaran -->
                    <div class="modal fade" id="modalAnggaran{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modalAnggaranLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalAnggaranLabel{{ $item->id }}">Input Kebutuhan Anggaran untuk Aktivitas: {{ $item->penjelasan }}</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('penyusunan.aktivitas.kebutuhan.store', $item->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="aktivitas_id" value="{{ $item->id }}">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="uraian_aktivitas">Uraian Aktivitas</label>
                                            <input type="text" name="uraian_aktivitas" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="frekwensi">Frekwensi</label>
                                            <input type="number" name="frekwensi" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="nominal_volume">Nominal Volume</label>
                                            <input type="number" name="nominal_volume" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="satuan_volume">Satuan Volume</label>
                                            <input type="text" name="satuan_volume" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="harga">Harga</label>
                                            <input type="number" name="harga" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal untuk Edit Aktivitas -->
                    <div class="modal fade" id="modalEditAktivitas{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditAktivitasLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalEditAktivitasLabel{{ $item->id }}">Edit Aktivitas: {{ $item->penjelasan }}</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('penyusunan.aktivitas.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT') <!-- Method PUT untuk edit -->
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="penjelasan">Penjelasan Aktivitas</label>
                                            <input type="text" name="penjelasan" class="form-control" value="{{ $item->penjelasan }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="waktu_aktivitas">Waktu Aktivitas</label>
                                            <input type="date" name="waktu_aktivitas" class="form-control" value="{{ $item->waktu_aktivitas }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="kategori">Kategori</label>
                                            <input type="text" name="kategori" class="form-control" value="{{ $item->kategori }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Tampilkan Kebutuhan Anggaran -->
                    <!-- Tampilkan Kebutuhan Anggaran -->
                    <tr>
                        <td colspan="4">
                            <h5>Kebutuhan Anggaran:</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Uraian Aktivitas</th>
                                        <th>Frekwensi</th>
                                        <th>Nominal Volume</th>
                                        <th>Satuan Volume</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($item->kebutuhanAnggaran as $anggaran)
                                    <tr>
                                        <td>{{ $anggaran->uraian_aktivitas }}</td>
                                        <td>{{ $anggaran->frekwensi }}</td>
                                        <td>{{ $anggaran->nominal_volume }}</td>
                                        <td>{{ $anggaran->satuan_volume }}</td>
                                        <td>{{ $anggaran->harga }}</td>
                                        <td>{{ $anggaran->jumlah }}</td>
                                        <td>
                                            <!-- Button Edit -->
                                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditAnggaran{{ $anggaran->id }}">Edit</button>

                                            <!-- Button Delete -->
                                            <form action="{{ route('penyusunan.aktivitas.kebutuhan.destroy', $anggaran->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal untuk edit kebutuhan anggaran -->
                                    <div class="modal fade" id="modalEditAnggaran{{ $anggaran->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditAnggaranLabel{{ $anggaran->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalEditAnggaranLabel{{ $anggaran->id }}">Edit Kebutuhan Anggaran untuk Aktivitas: {{ $item->penjelasan }}</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('penyusunan.aktivitas.kebutuhan.update', $anggaran->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT') <!-- Method PUT untuk edit -->
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="uraian_aktivitas">Uraian Aktivitas</label>
                                                            <input type="text" name="uraian_aktivitas" class="form-control" value="{{ $anggaran->uraian_aktivitas }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="frekwensi">Frekwensi</label>
                                                            <input type="number" name="frekwensi" class="form-control" value="{{ $anggaran->frekwensi }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nominal_volume">Nominal Volume</label>
                                                            <input type="number" name="nominal_volume" class="form-control" value="{{ $anggaran->nominal_volume }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="satuan_volume">Satuan Volume</label>
                                                            <input type="text" name="satuan_volume" class="form-control" value="{{ $anggaran->satuan_volume }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="harga">Harga</label>
                                                            <input type="number" name="harga" class="form-control" value="{{ $anggaran->harga }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <tr>
                                        <td colspan="6">Tidak ada kebutuhan anggaran untuk aktivitas ini.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </td>
                    </tr>


                </tbody>
            </table>
            <!-- Modal Create Aktivitas -->
            <div class="modal fade" id="modalCreateAktivitas" tabindex="-1" role="dialog" aria-labelledby="modalCreateAktivitasLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCreateAktivitasLabel">Create Aktivitas</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('penyusunan.aktivitas.store', $tor->id) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="penjelasan">Penjelasan Aktivitas</label>
                                    <input type="text" name="penjelasan" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="waktu_aktivitas">Waktu Aktivitas</label>
                                    <input type="date" name="waktu_aktivitas" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="kategori">Kategori</label>
                                    <select class="choices form-select" name="kategori">
                                        <option value="Persiapan">Persiapan</option>
                                        <option value="Pelaksanaan">Pelaksanaan</option>
                                        <option value="Pelaporan">Pelaporan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</section>

@endsection