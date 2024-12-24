@extends('master.master')
@section('title', 'Data Satuan Kerja dan Pendidikan')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Seluruh Data Satuan Kerja dan Pendidikan</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Satuan Kerja</li>
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
                        <a class="btn btn-primary" href="{{ route('satuan_kerja.create') }}">Create</a>
                    </div>
                </div>
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($satuan as $satuans)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $satuans->kode }}</td>
                            <td>{{ $satuans->nama }}</td>
                            <td>
                                <span class="badge {{ $satuans->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $satuans->status == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $satuans->id }}').submit();" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                    <i class="badge-circle font-medium-1" data-feather="trash"></i>
                                </a>
                                <form id="delete-form-{{ $satuans->id }}" action="{{ route('satuan_kerja.destroy', $satuans->id) }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <a href="{{ route('satuan_kerja.edit', $satuans->id) }}"><i class="badge-circle font-medium-1"
                                        data-feather="edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a>
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