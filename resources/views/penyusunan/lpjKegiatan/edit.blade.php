@extends('master.master')
@section('title', 'Edit Data Laporan Pertanggung Jawaban Kegiatan')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Lakukan Edit Data Pelaporan Pertanggung Jawaban Kegiatan</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('penyusunan.lpjKegiatan.view') }}">Data LPJ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
                            <form class="form" method="POST" action="{{ route('penyusunan.lpjKegiatan.update', $lpj->id) }}">
                                @csrf
                                <div class="row">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Kegiatan</label>
                                                <select class="choices form-select @error('nama_kegiatan') is-invalid @enderror" name="kegiatan_id" id="kegiatan_id" type="text" aria-placeholder="Kegiatan">
                                                    @foreach ($kegiatan as $kegiatans)
                                                    <option value="{{ $kegiatans->id }}" {{ (old('kegiatans_id') ?? $lpj->kegiatan_id) == $kegiatans->id ? 'selected' : '' }}>
                                                    {{ $kegiatans->tor->nama_kegiatan }}
                                                </option>
                                                    @endforeach
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Penjelasan Kegiatan</label>
                                            <input type="text" id="penjelasan_kegiatan" class="form-control @error ('penjelasan_kegiatan') is-invalid @enderror"
                                                placeholder="Penjelasan Kegiatan" name="penjelasan_kegiatan" value="{{ old('penjelasan_kegiatan') ?? $lpj->penjelasan_kegiatan }}" >
                                            @error('penjelasan_kegiatan')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Jumlah Peserta Undangan</label>
                                            <input type="text" id="jumlah_peserta_undangan" class="form-control 
                                            @error ('jumlah_peserta_undangan') is invalid
                                            @enderror"
                                                placeholder="Jumlah Peserta Undangan" name="jumlah_peserta_undangan" value="{{ old('jumlah_peserta_undangan')  ?? $lpj->jumlah_peserta_undangan }}" >
                                            @error('jumlah_peserta_undangan')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Jumlah Peserta Hadir</label>
                                            <input type="text" id="jumlah_peserta_hadir" class="form-control 
                                            @error ('jumlah_peserta_hadir') is invalid
                                            @enderror"
                                                placeholder="Jumlah Peserta Hadir" name="jumlah_peserta_hadir" value="{{ old('jumlah_peserta_hadir')  ?? $lpj->jumlah_peserta_hadir }}" >
                                            @error('jumlah_peserta_hadir')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                        <a type="button" class="btn btn-light-secondary me-1 mb-1" href="{{ route('penyusunan.lpjKegiatan.view') }}">Back</a>
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