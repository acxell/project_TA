@extends('master.master')
@section('title', 'Masukkan Data Pesan Perbaikan')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Input Pesan Perbaikan</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('validasi.validasiAnggaran.view') }}">Data Pengajuan Anggaran Tahunan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Buat Pesan Perbaikan</li>
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
                            <form class="form" method="POST" action=" {{ route('pesanPerbaikan.anggaranTahunan.store') }}">
                                @csrf

                                <input type="hidden" name="kegiatan_id" value="{{ $kegiatan->id }}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group with-title mb-3">
                                            <label>Pesan Perbaikan</label>
                                            <textarea id="pesan" class="form-control 
                                            @error ('pesan') is invalid
                                            @enderror"
                                                placeholder="Pesan Perbaikan" name="pesan" value="{{ old('pesan') }}" rows="4"></textarea>
                                                @error('pesan')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
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