@extends('master.master')
@section('title', 'Data Pengguna')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Seluruh Data Pengguna Serta Aktivitas Pengguna</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Pengguna</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 order-md-2 order-last">
                        <a class="btn btn-primary" href="{{ route('pengguna.createPengguna') }}">Create</a>
                    </div>
                </div>
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No Rekening</th>
                            <th>Role</th>
                            <th>Unit Id</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penggunas as $pengguna)
                        <tr>
                            <td>{{ $pengguna->nama }}</td>
                            <td>{{ $pengguna->email }}</td>
                            <td>{{ $pengguna->nomor_rekening }}</td>
                            <td>{{ $pengguna->role }}</td>
                            <td>{{ $pengguna->unit_id }}</td>
                            <td>
                                <span class="badge bg-success">{{ $pengguna->status }}</span>
                            </td>
                            <td><a href="#"><i class="badge-circle font-small-1"
                                        data-feather="eye"></i></a>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $pengguna->id }}').submit();">
                                    <i class="badge-circle font-medium-1" data-feather="trash"></i>
                                </a>
                                <form id="delete-form-{{ $pengguna->id }}" action="{{ route('pengguna.destroy', $pengguna->id) }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <a href="{{ route('pengguna.edit', $pengguna->id) }}"><i class="badge-circle font-medium-1"
                                        data-feather="edit"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>

@endsection