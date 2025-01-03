@extends('master.master')
@section('title', 'Daftar Aktivitas untuk Kegiatan : ' . $tor->nama_kegiatan)
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Seluruh Aktivitas dan Kebutuhan Anggaran</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('penyusunan.kegiatan.view') }}">Data Kegiatan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Aktivitas Kegiatan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Tombol Create Aktivitas -->
    @can('Create Aktivitas Kegiatan')
    <a href="#" class="btn btn-success my-3" data-bs-toggle="modal" data-bs-target="#modalCreateAktivitas">Create Aktivitas</a>
    @endCan
</div>

<section class="section">
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
                            <input type="date" name="waktu_aktivitas" class="form-control" min="{{ now()->format('Y-m-d') }}" required>
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
    @foreach($aktivitas as $item)
    <div class="card">
        <div class="card-body">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Aktivitas</th>
                        <th>Waktu</th>
                        <th>Kategori</th>
                        @canany([
                        'Edit Aktivitas Kegiatan',
                        'Delete Aktivitas Kegiatan',
                        'Create Kebutuhan Anggaran Kegiatan',
                        ])
                        <th>Aksi</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>{{ $item->penjelasan }}</td>
                        <td>{{ $item->waktu_aktivitas }}</td>
                        <td>{{ $item->kategori }}</td>
                        <td>
                            <!-- Tombol Edit Aktivitas -->
                            @can('Edit Aktivitas Kegiatan')
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditAktivitas{{ $item->id }}">Edit</button>
                            @endCan
                            @can('Delete Aktivitas Kegiatan')
                            <!-- Tombol Delete Aktivitas -->
                            <form action="{{ route('penyusunan.aktivitas.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                            @endCan
                            @can('Create Kebutuhan Anggaran Kegiatan')
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAnggaran{{ $item->id }}">Input Kebutuhan Anggaran</button>
                            @endCan
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
                                            <input type="date" name="waktu_aktivitas" class="form-control" value="{{ $item->waktu_aktivitas }}" min="{{ now()->format('Y-m-d') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="kategori">Kategori</label>
                                            <select type="select" name="kategori" class="form-control">
                                                <option value="Persiapan" {{ (old('kategori') ?? $item->kategori) == 'Persiapan' ? 'selected' : '' }}>Persiapan</option>
                                                <option value="Pelaksanaan" {{ (old('kategori') ?? $item->kategori) == 'Pelaksanaan' ? 'selected' : '' }}>Pelaksanaan</option>
                                                <option value="Pelaporan" {{ (old('kategori') ?? $item->kategori) == 'Pelaporan' ? 'selected' : '' }}>Pelaporan</option>
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
                                        @canany([
                                        'Edit Kebutuhan Anggaran Kegiatan',
                                        'Delete Kebutuhan Anggaran Kegiatan',
                                        ])
                                        <th>Aksi</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($item->kebutuhanAnggaran as $anggaran)
                                    <tr>
                                        <td>{{ $anggaran->uraian_aktivitas }}</td>
                                        <td>{{ $anggaran->frekwensi }}</td>
                                        <td>{{ $anggaran->nominal_volume }}</td>
                                        <td>{{ $anggaran->satuan_volume }}</td>
                                        <td>@currency($anggaran->harga)</td>
                                        <td>@currency($anggaran->jumlah)</td>
                                        <td>
                                            <!-- Button Edit -->
                                            @can('Edit Kebutuhan Anggaran Kegiatan')
                                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditAnggaran{{ $anggaran->id }}">Edit</button>
                                            @endCan
                                            <!-- Button Delete -->
                                            @can('Delete Kebutuhan Anggaran Kegiatan')
                                            <form action="{{ route('penyusunan.aktivitas.kebutuhan.destroy', $anggaran->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                            @endCan
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
        </div>
    </div>
    @endforeach
</section>

@endsection