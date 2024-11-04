@extends('master.master')
@section('title', 'Detail Data Pendanaan Kegiatan')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Data Pendanaan Kegiatan</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pendanaan.dataPendanaan.view') }}">Data Pendanaan Kegiatan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
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
                            <form class="form">
                                <div class="row">
                                <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Nama Kegiatan</label>
                                            <input type="text" id="nama_kegiatan" class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                                name="nama_kegiatan" value="{{ old('nama_kegiatan')  ?? $pendanaan->kegiatan->tor->nama_kegiatan }}" disabled>
                                            @error('nama_kegiatan')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Nominal Transfer</label>
                                            <input type="number" id="besaran_transfer" class="form-control 
                                            @error ('besaran_transfer') is invalid
                                            @enderror"
                                                placeholder="Nominal Transfer" name="besaran_transfer" value="{{ old('besaran_transfer')  ?? $pendanaan->besaran_transfer }}" disabled>
                                                @error('besaran_transfer')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Bukti Transfer</label>
                                            <a href="{{ asset('storage/' . $pendanaan->bukti_transfer) }}"
                                                target="_blank">Download</a>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <a href="{{ route('pendanaan.dataPendanaan.view') }}" class="btn btn-light-secondary me-1 mb-1">Done</a>
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
