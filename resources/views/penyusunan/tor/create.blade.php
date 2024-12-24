@extends('master.master')
@section('title', 'Masukkan Data Kegiatan Program Kerja')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Input Detail Data Tor Kegiatan</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('penyusunan.kegiatan.view') }}">Data Kegiatan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Insert TOR</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="POST" action=" {{ route('penyusunan.tor.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label>Program Kerja</label>
                                            <select class="choices form-select" name="proker_id" id="proker_id" type="text" aria-placeholder="Program Kerja" required>
                                                @foreach ($proker as $prokers)
                                                <option value="{{ $prokers->id }}">{{ $prokers->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Nama Kegiatan</label>
                                            <input type="text" id="nama_kegiatan" class="form-control 
                                            @error ('nama_kegiatan') is invalid
                                            @enderror"
                                                placeholder="Nama Kegiatan" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}">
                                            @error('nama_kegiatan')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label for="waktu">Tanggal Pelaksanaan</label>
                                        <input type="month" name="waktu" class="form-control" value="{{ old('waktu', now()->format('Y-m')) }}" min="{{ now()->format('Y-m') }}">
                                    </div>
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="row">
                                                    <!-- Form for Outcome -->
                                                    <div class="col-md-12">
                                                        <label for="outcome">Outcome</label>
                                                        <div id="outcome-wrapper">
                                                            <!-- Dynamically display old input values if available -->
                                                            @foreach(old('outcomes', []) as $index => $outcome)
                                                            <div class="form-group d-flex" id="outcome-group-{{ $index + 1 }}">
                                                                <input type="text" name="outcomes[]" class="form-control" placeholder="Outcome" value="{{ $outcome }}" required>
                                                                <button type="button" class="btn btn-danger ms-2 remove-outcome">Delete</button>
                                                            </div>
                                                            @endforeach

                                                            <!-- Default input if no old data -->
                                                            @if(empty(old('outcomes')))
                                                            <div class="form-group d-flex" id="outcome-group-1">
                                                                <input type="text" name="outcomes[]" class="form-control" placeholder="Outcome" required>
                                                                <button type="button" class="btn btn-danger ms-2 remove-outcome">Delete</button>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <button type="button" class="btn btn-primary me-1 mb-1" id="add-outcome">Add More Outcome</button>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <!-- Form for Indikator -->
                                                    <div class="col-md-12">
                                                        <label for="indikator">Indikator</label>
                                                        <div id="indikator-wrapper">
                                                            <!-- Dynamically display old input values if available -->
                                                            @foreach(old('indikators', []) as $index => $indikator)
                                                            <div class="form-group d-flex" id="indikator-group-{{ $index + 1 }}">
                                                                <input type="text" name="indikators[]" class="form-control" placeholder="Indikator" value="{{ $indikator }}" required>
                                                                <button type="button" class="btn btn-danger ms-2 remove-indikator">Delete</button>
                                                            </div>
                                                            @endforeach

                                                            <!-- Default input if no old data -->
                                                            @if(empty(old('indikators')))
                                                            <div class="form-group d-flex" id="indikator-group-1">
                                                                <input type="text" name="indikators[]" class="form-control" placeholder="Indikator" required>
                                                                <button type="button" class="btn btn-danger ms-2 remove-indikator">Delete</button>
                                                            </div>
                                                            @error('indikators')
                                                            <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                            @endif
                                                        </div>
                                                        <button type="button" class="btn btn-primary me-1 mb-1" id="add-indikator">Add More Indikator</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Orang yang Bertanggung Jawab (PIC)</label>
                                            <input type="text" id="pic" class="form-control 
                                            @error ('pic') is invalid
                                            @enderror"
                                                placeholder="Person In Charge" name="pic" value="{{ old('pic') }}">
                                            @error('pic')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Kepesertaan Kegiatan</label>
                                            <input type="text" id="kepesertaan" class="form-control 
                                            @error ('kepesertaan') is invalid
                                            @enderror"
                                                placeholder="Kepesertaan Kegiatan" name="kepesertaan" value="{{ old('kepesertaan') }}">
                                            @error('kepesertaan')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Nomor Standar Akreditasi</label>
                                            <input type="text" id="nomor_standar_akreditasi" class="form-control 
                                            @error ('nomor_standar_akreditasi') is invalid
                                            @enderror"
                                                placeholder="Nomor Standar Akreditasi" name="nomor_standar_akreditasi" value="{{ old('nomor_standar_akreditasi') }}">
                                            @error('nomor_standar_akreditasi')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Penjelasan Standar Akreditasi</label>
                                            <input type="text" id="penjelasan_standar_akreditasi" class="form-control 
                                            @error ('penjelasan_standar_akreditasi') is invalid
                                            @enderror"
                                                placeholder="Penjelasan Standar Akreditasi" name="penjelasan_standar_akreditasi" value="{{ old('penjelasan_standar_akreditasi') }}">
                                            @error('penjelasan_standar_akreditasi')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Chart Of Accounts (COA)</label>
                                            <select class="choices form-select" name="coa_id" id="coa_id" type="text" aria-placeholder="COA">
                                                @foreach ($coa as $coas)
                                                <option value="{{ $coas->id }}">{{ $coas->kode }} - {{ $coas->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Latar Belakang Kegiatan</label>
                                            <input type="text" id="latar_belakang" class="form-control 
                                            @error ('latar_belakang') is invalid
                                            @enderror"
                                                placeholder="Latar Belakang Kegiatan" name="latar_belakang" value="{{ old('latar_belakang') }}">
                                            @error('latar_belakang')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Tujuan</label>
                                            <input type="text" id="tujuan" class="form-control 
                                            @error ('tujuan') is invalid
                                            @enderror"
                                                placeholder="Tujuan" name="tujuan" value="{{ old('tujuan') }}">
                                            @error('tujuan')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Manfaat Internal</label>
                                            <input type="text" id="manfaat_internal" class="form-control 
                                            @error ('manfaat_internal') is invalid
                                            @enderror"
                                                placeholder="Manfaat Internal" name="manfaat_internal" value="{{ old('manfaat_internal') }}">
                                            @error('manfaat_internal')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Manfaat Eksternal</label>
                                            <input type="text" id="manfaat_eksternal" class="form-control 
                                            @error ('manfaat_eksternal') is invalid
                                            @enderror"
                                                placeholder="Manfaat Eksternal" name="manfaat_eksternal" value="{{ old('manfaat_eksternal') }}">
                                            @error('manfaat_eksternal')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Metode Pelaksanaan</label>
                                            <input type="text" id="metode_pelaksanaan" class="form-control 
                                            @error ('metode_pelaksanaan') is invalid
                                            @enderror"
                                                placeholder="Metode Pelaksanaan" name="metode_pelaksanaan" value="{{ old('metode_pelaksanaan') }}">
                                            @error('metode_pelaksanaan')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        @foreach($kriterias as $kriteria)
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label>{{ $kriteria->nama_kriteria }}</label>

                                                @if($kriteria->tipe_kriteria === 'Select')
                                                @if($kriteria->subkriteria && $kriteria->subkriteria->isNotEmpty())
                                                <select name="kriteria[{{ $kriteria->id }}][subkriteria_id]" class="form-select" required>
                                                    @foreach($kriteria->subkriteria as $subkriteria)
                                                    <option value="{{ $subkriteria->id }}"
                                                        {{ old("kriteria.{$kriteria->id}.subkriteria_id") == $subkriteria->id ? 'selected' : '' }}>
                                                        {{ $subkriteria->bobot_text_subkriteria }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <!-- Display error for subkriteria -->
                                                @if($errors->has("kriteria.{$kriteria->id}.subkriteria_id"))
                                                <small class="text-danger">{{ $errors->first("kriteria.{$kriteria->id}.subkriteria_id") }}</small>
                                                @endif
                                                @else
                                                <p class="text-danger">Tidak ada subkriteria tersedia.</p>
                                                @endif

                                                @elseif($kriteria->tipe_kriteria === 'Interval')
                                                <input type="number" name="kriteria[{{ $kriteria->id }}][nilai]" class="form-control" placeholder="Masukkan nilai"
                                                    value="{{ old("kriteria.{$kriteria->id}.nilai") }}" required>
                                                <!-- Display error for nilai -->
                                                @if($errors->has("kriteria.{$kriteria->id}.nilai"))
                                                <small class="text-danger">{{ $errors->first("kriteria.{$kriteria->id}.nilai") }}</small>
                                                @endif
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    <div class="card">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="row">
                                                    <!-- Aktivitas Section -->
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group">
                                                            <label>Aktivitas</label>
                                                            <div id="aktivitas-wrapper">
                                                                <!-- Dynamically display old input values if available -->
                                                                @if(old('waktu_aktivitas'))
                                                                @foreach(old('waktu_aktivitas') as $index => $waktu_aktivitas)
                                                                <div class="row align-items-center" id="aktivitas-group-{{ $index + 1 }}">
                                                                    <div class="col-md-2 col-12">
                                                                        <label for="waktu_aktivitas">Waktu Aktivitas</label>
                                                                        <input type="date" name="waktu_aktivitas[]" class="form-control" placeholder="mm/dd/yyyy" value="{{ $waktu_aktivitas }}" min="{{ now()->format('Y-m-d') }}" required>
                                                                    </div>
                                                                    @error('waktu_aktivitas')
                                                                    <small class="text-danger">{{ $message }}</small>
                                                                    @enderror
                                                                    <div class="col-md-6 col-12">
                                                                        <label for="penjelasan">Penjelasan</label>
                                                                        <textarea name="penjelasan[]" class="form-control" placeholder="Penjelasan" rows="1" required>{{ old('penjelasan')[$index] }}</textarea>
                                                                    </div>

                                                                    <div class="col-md-3 col-12">
                                                                        <label for="kategori">Kategori</label>
                                                                        <select class="choices form-select" name="kategori[]" required>
                                                                            <option value="Persiapan" {{ old('kategori')[$index] == 'Persiapan' ? 'selected' : '' }}>Persiapan</option>
                                                                            <option value="Pelaksanaan" {{ old('kategori')[$index] == 'Pelaksanaan' ? 'selected' : '' }}>Pelaksanaan</option>
                                                                            <option value="Pelaporan" {{ old('kategori')[$index] == 'Pelaporan' ? 'selected' : '' }}>Pelaporan</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-1 col-12">
                                                                        <button type="button" class="btn btn-danger remove-aktivitas">Delete</button>
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                                @else
                                                                <!-- Default input if no old data -->
                                                                <div class="row align-items-center" id="aktivitas-group-1">
                                                                    <div class="col-md-2 col-12">
                                                                        <label for="waktu_aktivitas">Waktu Aktivitas</label>
                                                                        <input type="date" name="waktu_aktivitas[]" class="form-control" placeholder="mm/dd/yyyy" min="{{ now()->format('Y-m-d') }}" required>
                                                                        @error('waktu_aktivitas')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-md-6 col-12">
                                                                        <label for="penjelasan">Penjelasan</label>
                                                                        <textarea name="penjelasan[]" class="form-control" placeholder="Penjelasan" rows="1" required></textarea>
                                                                        @error('penjelasan')
                                                                        <small class="text-danger">{{ $message }}</small>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="col-md-3 col-12">
                                                                        <label for="kategori">Kategori</label>
                                                                        <select class="choices form-select" name="kategori[]" required>
                                                                            <option value="Persiapan">Persiapan</option>
                                                                            <option value="Pelaksanaan">Pelaksanaan</option>
                                                                            <option value="Pelaporan">Pelaporan</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-1 col-12">
                                                                        <button type="button" class="btn btn-danger remove-aktivitas">Delete</button>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            </div>
                                                            <button type="button" class="btn btn-primary" id="add-aktivitas">Add More Aktivitas</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                            <button type="button" class="btn btn-light-secondary me-1 mb-1" onclick="window.history.back();">Back</button>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- // Basic multiple Column Form section end -->
</div>
@endsection