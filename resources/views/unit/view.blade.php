@extends('master.master')
@section('title', 'Data Unit')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Seluruh Data Unit Serta Aktivitas Unit</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Unit</li>
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
                        <a class="btn btn-primary" href="{{ route('unit.create') }}">Create</a>
                    </div>
                </div>
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Satuan Kerja</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($units as $unit)
                        <tr>
                            <td>{{ $unit->nama }}</td>
                            <td>{{ $unit->satuan->nama }}</td>
                            <td>
                            <span class="badge {{ $unit->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $unit->status == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td><a href="{{ route('unit.detail', $unit->id) }}"><i class="badge-circle font-small-1"
                                        data-feather="eye"></i></a>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $unit->id }}').submit();">
                                    <i class="badge-circle font-medium-1" data-feather="trash"></i>
                                </a>
                                <form id="delete-form-{{ $unit->id }}" action="{{ route('unit.destroy', $unit->id) }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <a href="{{ route('unit.edit', $unit->id) }}"><i class="badge-circle font-medium-1"
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