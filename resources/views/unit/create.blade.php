@extends('master.master')
@section('title', 'Masukkan Data Unit')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Input Detail Data Unit</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit.view') }}">Data Unit</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Insert</li>
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
                            <form class="form" method="POST" action=" {{ route('unit.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" id="nama" class="form-control 
                                            @error ('nama') is invalid
                                            @enderror"
                                                placeholder="Nama" name="nama" value="{{ old('nama') }}">
                                                @error('nama')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <fieldset class="form-group">
                                                <select class="form-select" name="status" id="status" aria-placeholder="Status">
                                                    <option value="1">Aktif</option>
                                                    <option value="0">Tidak Aktif</option>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Satuan Kerja / Pendidikan</label>
                                                <select class="choices form-select" name="satuan_id" id="satuan_id" type="text" aria-placeholder="Satker">
                                                    @foreach ($satuan as $satuans)
                                                    <option value="{{ $satuans->id }}">{{ $satuans->nama }}</option>
                                                    @endforeach
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Nomor Rekening</label>
                                            <input type="text" id="nomor_rekening" class="form-control 
                                            @error ('nomor_rekening') is invalid
                                            @enderror"
                                                placeholder="Nomor Rekening" name="nomor_rekening" value="{{ old('nomor_rekening') }}">
                                            @error('nomor_rekening')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Deskripsi</label>
                                            <input type="textbox" id="description" class="form-control 
                                            @error ('description') is invalid
                                            @enderror"
                                                placeholder="Deskripsi Unit" name="description" value="{{ old('description') }}">
                                                @error('description')
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