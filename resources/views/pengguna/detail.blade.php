@extends('master.master')
@section('title', 'Detail Data Pengguna')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Detail Data Pengguna</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pengguna.view') }}">Data Pengguna</a></li>
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
                            <form class="form" action="{{ route('pengguna.view') }}">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" id="nama" class="form-control 
                                            @error ('nama') is invalid
                                            @enderror"
                                                placeholder="Nama" name="nama" value="{{ old('nama') ?? $pengguna->nama }}" disabled>
                                            @error('nama')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" id="email" class="form-control 
                                            @error ('email') is invalid
                                            @enderror"
                                                placeholder="Email" name="email" value="{{ old('email') ?? $pengguna->email }}" disabled>
                                            @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" id="password" class="form-control 
                                            @error ('password') is invalid
                                            @enderror"
                                                placeholder="Password" name="password" value="{{ old('password') ?? $pengguna->password }}" disabled>
                                            @error('password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <input type="text" id="status" class="form-control 
                                            @error ('status') is invalid
                                            @enderror"
                                                placeholder="Status" name="status" value="{{ old('status') ?? $pengguna->status }}" disabled>
                                            @error('status')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Role</label>
                                            <input type="text" id="role" class="form-control 
                                            @error ('role') is invalid
                                            @enderror"
                                                placeholder="Role" name="role" value="{{ old('role') ?? $pengguna->role }}" disabled>
                                            @error('role')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Unit</label>
                                            <input type="text" id="unit_id" class="form-control @error ('unit_id') is-invalid @enderror"
                                                placeholder="Nama Unit" name="unit_id" value="{{ old('unit_id') ?? $pengguna->unit->nama }}" disabled>
                                            @error('unit_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button class="btn btn-light-secondary me-1 mb-1">Done</button>
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