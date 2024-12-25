@extends('master.master')
@section('title', 'Data Permission')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Seluruh Data Permission Untuk Pengguna</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Permissions</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @can('Create Permission')
                    <div class="col-12 col-md-12 order-md-2 order-last">
                        <a class="btn btn-primary" href="{{ route('permission.create') }}">Create</a>
                    </div>
                    @endCan
                </div>
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            @canany([
                            'Edit Permission',
                            'Delete Permission',
                            ])
                            <th>Action</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>
                                @can('Delete Permission')
                                <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $permission->id }}').submit();" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                    <i class="badge-circle font-medium-1" data-feather="trash"></i>
                                </a>
                                <form id="delete-form-{{ $permission->id }}" action="{{ route('permission.destroy', $permission->id) }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endCan
                                @can('Edit Permission')
                                <a href="{{ route('permission.edit', $permission->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="badge-circle font-medium-1"
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