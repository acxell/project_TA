@extends('master.master')
@section('title', 'Edit Data Unit')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Lakukan Edit Data Unit</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit.view') }}">Data Unit</a></li>
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
                            <form class="form" method="POST" action="{{ route('unit.update', $unit->id) }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" id="nama" class="form-control 
                                            @error ('nama') is invalid
                                            @enderror"
                                                placeholder="Nama" name="nama" value="{{ old('nama') ?? $unit->nama }}">
                                                @error('nama')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <fieldset class="form-group">
                                                <select class="form-select @error('status') is-invalid @enderror" name="status" id="status">
                                                    <option value="Aktif" {{ (old('status') ?? $unit->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                    <option value="Tidak Aktif" {{ (old('status') ?? $unit->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                                </select>
                                                @error('status')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Satuan Kerja / Pendidikan</label>
                                            <select class="choices form-select @error('satuan_id') is-invalid @enderror" name="satuan_id" id="satuan_id">
                                                @foreach ($satuan as $satuans)
                                                <option value="{{ $satuans->id }}" {{ (old('satuan_id') ?? $unit->satuan_id) == $satuans->id ? 'selected' : '' }}>
                                                    {{ $satuans->nama }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('satuan_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Nomor Rekening</label>
                                            <input type="text" id="nomor_rekening" class="form-control 
                                            @error ('nomor_rekening') is invalid
                                            @enderror"
                                                placeholder="Nomor Rekening" name="nomor_rekening" value="{{ old('nomor_rekening') ?? $unit->nomor_rekening }}">
                                            @error('nomor_rekening')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Deskripsi</label>
                                            <input type="text" id="description" class="form-control 
                                            @error ('description') is invalid
                                            @enderror"
                                                placeholder="Deskripsi" name="description" value="{{ old('description') ?? $unit->description }}">
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