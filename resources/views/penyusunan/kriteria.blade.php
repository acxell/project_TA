@extends('master.master')
@section('title', 'Daftar Kriteria dan Sub Kriteria')
@section('content')

<div class="alert-container">
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
</div>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Seluruh Kriteria dan Sub Kriteria</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Kriteria dan Sub Kriteria</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Tombol Create Aktivitas -->
    @can('Create Kriteria')
    <a href="#" class="btn btn-success my-3" data-bs-toggle="modal" data-bs-target="#modalCreateKriteria">Create Kriteria</a>
    @endCan
</div>

<section class="section">
    <!-- Modal Create Aktivitas -->
    <div class="modal fade" id="modalCreateKriteria" tabindex="-1" role="dialog" aria-labelledby="modalCreateKriteriaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCreateKriteriaLabel">Create Kriteria</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('penyusunan.kriteria.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_kriteria">Nama Kriteria</label>
                            <input type="text" name="nama_kriteria" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis_kriteria">Jenis Kriteria</label>
                            <select class="form-select" name="jenis_kriteria" id="jenis_kriteria" type="text" aria-placeholder="jenis">
                                <option value="Cost">Cost</option>
                                <option value="Benefit">Benefit</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tipe_kriteria">Tipe Kriteria</label>
                            <select class="form-select" name="tipe_kriteria" id="tipe_kriteria" type="text" aria-placeholder="tipe">
                                <option value="Select">Select</option>
                                <option value="Interval">Interval</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bobot_kriteria">Bobot Kriteria</label>
                            <input type="number" name="bobot_kriteria" class="form-control" min="0" max="1" step="0.1" required>
                        </div>
                        <div class="form-group">
                            <label for="status_kriteria">Status Kriteria</label>
                            <select class="form-select" name="status_kriteria" id="status_kriteria" type="text" aria-placeholder="Status">
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
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
    @foreach($kriteria as $item)
    <div class="card">
        <div class="card-body">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Tipe Pembobotan</th>
                        <th>Bobot Kriteria</th>
                        <th>Status</th>
                        @canany([
                        'Edit Kriteria',
                        'Delete Kriteria',
                        'Create Sub Kriteria',
                        ])
                        <th>Aksi</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>{{ $item->nama_kriteria }}</td>
                        <td>{{ $item->jenis_kriteria }}</td>
                        <td>{{ $item->tipe_kriteria }}</td>
                        <td>{{ $item->bobot_kriteria }}</td>
                        <td>
                            <span class="badge {{ $item->status_kriteria == 1 ? 'bg-success' : 'bg-danger' }}">
                                {{ $item->status_kriteria == 1 ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td>
                            <!-- Tombol Edit Aktivitas -->
                            @can('Edit Kriteria')
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditKriteria{{ $item->id }}">Edit</button>
                            @endCan
                            <!-- Tombol Delete Aktivitas -->
                            @can('Delete Kriteria')
                            <form action="{{ route('penyusunan.kriteria.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                            @endCan
                            @can('Create Sub Kriteria')
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalSubkriteria{{ $item->id }}">Input Sub Kriteria</button>
                            @endCan
                        </td>
                    </tr>

                    <!-- Modal untuk input kebutuhan anggaran -->
                    <div class="modal fade" id="modalSubkriteria{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modalSubkriteriaLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalSubkriteriaLabel{{ $item->id }}">Input Sub Kriteria untuk Kriteria: {{ $item->nama_kriteria }}</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('penyusunan.subkriteria.store', $item->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_kriteria" value="{{ $item->id }}">
                                    <div class="modal-body">
                                        @if($item->tipe_kriteria === 'Interval')
                                        <div class="form-group">
                                            <label for="batas_bawah_bobot_subkriteria">Batas Bawah</label>
                                            <input type="number" name="batas_bawah_bobot_subkriteria" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="batas_atas_bobot_subkriteria">Batas Atas</label>
                                            <input type="number" name="batas_atas_bobot_subkriteria" class="form-control">
                                        </div>
                                        @elseif($item->tipe_kriteria === 'Select')
                                        <div class="form-group">
                                            <label for="bobot_text_subkriteria">Text Sub Kriteria</label>
                                            <input type="text" name="bobot_text_subkriteria" class="form-control">
                                        </div>
                                        @endif
                                        <div class="form-group">
                                            <label for="nilai_bobot_subkriteria">Nilai Bobot Sub Kriteria</label>
                                            <input type="number" name="nilai_bobot_subkriteria" class="form-control" required>
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
                    <div class="modal fade" id="modalEditKriteria{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditKriteriaLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalEditKriteriaLabel{{ $item->id }}">Edit Kriteria: {{ $item->nama_kriteria }}</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('penyusunan.kriteria.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT') <!-- Method PUT untuk edit -->
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="nama_kriteria">Nama Kriteria</label>
                                            <input type="text" name="nama_kriteria" class="form-control" value="{{ $item->nama_kriteria }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="jenis_kriteria">Jenis Kriteria</label>
                                            <select class="form-select" name="jenis_kriteria" id="jenis_kriteria" type="text" aria-placeholder="jenis">
                                                <option value="Cost" {{ (old('jenis_kriteria') ?? $item->jenis_kriteria) == 'Cost' ? 'selected' : '' }}>Cost</option>
                                                <option value="Benefit" {{ (old('jenis_kriteria') ?? $item->jenis_kriteria) == 'Benefit' ? 'selected' : '' }}>Benefit</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="bobot_kriteria">Bobot Kriteria</label>
                                            <input type="number" name="bobot_kriteria" class="form-control" value="{{ $item->bobot_kriteria }}" min="0" max="1" step="0.1" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="status_kriteria">Status Kriteria</label>
                                            <select class="form-select @error('status_kriteria') is-invalid @enderror" name="status_kriteria" id="status_kriteria">
                                                <option value="1" {{ (old('status_kriteria') ?? $item->status_kriteria) == 1 ? 'selected' : '' }}>Aktif</option>
                                                <option value="0" {{ (old('status_kriteria') ?? $item->status_kriteria) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
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
                            <h5>Sub Kriteria:</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        @if($item->tipe_kriteria === 'Interval')
                                        <th>Batas Bawah</th>
                                        <th>Batas Atas</th>
                                        @elseif($item->tipe_kriteria === 'Select')
                                        <th>Text</th>
                                        @endif
                                        <th>Nilai</th>
                                        @canany([
                                        'Edit Sub Kriteria',
                                        'Delete Sub Kriteria',
                                        ])
                                        <th>Aksi</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($item->subkriteria as $subkriterias)
                                    <tr>
                                        @if($item->tipe_kriteria === 'Interval')
                                        <td>{{ $subkriterias->batas_bawah_bobot_subkriteria }}</td>
                                        <td>{{ $subkriterias->batas_atas_bobot_subkriteria }}</td>
                                        @elseif($item->tipe_kriteria === 'Select')
                                        <td>{{ $subkriterias->bobot_text_subkriteria }}</td>
                                        @endif
                                        <td>{{ $subkriterias->nilai_bobot_subkriteria }}</td>
                                        <td>
                                            <!-- Button Edit -->
                                            @can('Edit Sub Kriteria')
                                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditSubkriteria{{ $subkriterias->id }}">Edit</button>
                                            @endCan
                                            <!-- Button Delete -->
                                            @can('Delete Sub Kriteria')
                                            <form action="{{ route('penyusunan.subkriteria.destroy', $subkriterias->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                            @endCan
                                        </td>
                                    </tr>

                                    <!-- Modal untuk edit kebutuhan anggaran -->
                                    <div class="modal fade" id="modalEditSubkriteria{{ $subkriterias->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditSubkriteriaLabel{{ $subkriterias->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalEditSubkriteriaLabel{{ $subkriterias->id }}">Edit Sub Kriteria untuk Kriteria: {{ $item->nama_kriteria }}</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('penyusunan.subkriteria.update', $subkriterias->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT') <!-- Method PUT untuk edit -->
                                                    <div class="modal-body">
                                                        @if($item->tipe_kriteria === 'Interval')
                                                        <div class="form-group">
                                                            <label for="batas_bawah_bobot_subkriteria">Batas Bawah</label>
                                                            <input type="number" name="batas_bawah_bobot_subkriteria" class="form-control" value="{{ $subkriterias->batas_bawah_bobot_subkriteria }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="batas_atas_bobot_subkriteria">Batas Atas </label>
                                                            <input type="number" name="batas_atas_bobot_subkriteria" class="form-control" value="{{ $subkriterias->batas_atas_bobot_subkriteria }}" required>
                                                        </div>
                                                        @elseif($item->tipe_kriteria === 'Select')
                                                        <div class="form-group">
                                                            <label for="bobot_text_subkriteria">Text</label>
                                                            <input type="text" name="bobot_text_subkriteria" class="form-control" value="{{ $subkriterias->bobot_text_subkriteria }}" required>
                                                        </div>
                                                        @endif
                                                        <div class="form-group">
                                                            <label for="nilai_bobot_subkriteria">Nilai</label>
                                                            <input type="number" name="nilai_bobot_subkriteria" class="form-control" value="{{ $subkriterias->nilai_bobot_subkriteria }}" required>
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
                                        <td colspan="6">Tidak ada Sub Kriteria untuk Kriteria berikut.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </td>
                    </tr>


                </tbody>
            </table>
        </div>
    </div>
    @endforeach
</section>

@endsection