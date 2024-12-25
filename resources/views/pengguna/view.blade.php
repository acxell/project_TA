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
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
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
                    @can('Create Pengguna')
                    <div class="col-12 col-md-12 order-md-2 order-last">
                        <a class="btn btn-primary" href="{{ route('pengguna.create') }}">Create</a>
                    </div>
                    @endCan
                </div>
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Unit</th>
                            <th>Status</th>
                            @canany([
                            'Detail Pengguna',
                            'Delete Pengguna',
                            'Edit Pengguna',
                            ])
                            <th>Action</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penggunas as $pengguna)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pengguna->nama }}</td>
                            <td>{{ $pengguna->email }}</td>
                            <td>
                                @if (!empty($pengguna->getRoleNames()))
                                @foreach ($pengguna->getRoleNames() as $rolename)
                                <label class="badge bg-primary mx-1">{{ $rolename }}</label>
                                @endforeach
                                @endif
                            </td>
                            <td>{{ $pengguna->unit->nama }}</td>
                            <td>
                                <span class="badge {{ $pengguna->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $pengguna->status == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>

                            <td>
                                @can('Detail Pengguna')
                                <a href="{{ route('pengguna.detail', $pengguna->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail"><i class="badge-circle font-small-1"
                                        data-feather="eye"></i></a>
                                @endCan
                                @can('Delete Pengguna')
                                <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $pengguna->id }}').submit();" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                    <i class="badge-circle font-medium-1" data-feather="trash"></i>
                                </a>
                                <form id="delete-form-{{ $pengguna->id }}" action="{{ route('pengguna.destroy', $pengguna->id) }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endCan
                                @can('Edit Pengguna')
                                <a href="{{ route('pengguna.edit', $pengguna->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="badge-circle font-medium-1"
                                        data-feather="edit"></i></a>
                                @endCan
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