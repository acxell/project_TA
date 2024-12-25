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
                    @can('Create Unit')
                    <div class="col-12 col-md-12 order-md-2 order-last">
                        <a class="btn btn-primary" href="{{ route('unit.create') }}">Create</a>
                    </div>
                    @endCan
                </div>
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Satuan Kerja</th>
                            <th>No Rekening</th>
                            <th>Status</th>
                            @canany([
                            'Detail Unit',
                            'Edit Unit',
                            'Delete Unit',
                            ])
                            <th>Action</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($units as $unit)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $unit->nama }}</td>
                            <td>{{ $unit->satuan->nama }}</td>
                            <td>{{ $unit->nomor_rekening }}</td>
                            <td>
                                <span class="badge {{ $unit->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $unit->status == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td>
                                @can('Detail Unit')
                                <a onclick="showModal({ nama: '{{ $unit->nama }}', deskripsi: '{{ $unit->description }}' })" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                    <i class="badge-circle font-small-1" data-feather="eye"></i>
                                </a>
                                @endCan
                                @can('Delete Unit')
                                <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $unit->id }}').submit();" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                    <i class="badge-circle font-medium-1" data-feather="trash"></i>
                                </a>
                                <form id="delete-form-{{ $unit->id }}" action="{{ route('unit.destroy', $unit->id) }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endCan
                                @can('Edit Unit')
                                <a href="{{ route('unit.edit', $unit->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="badge-circle font-medium-1"
                                        data-feather="edit"></i></a>
                                @endCan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-primary me-1 mb-1 d-inline-block">
            <!-- Button trigger for primary themes modal -->


            <!-- Single Modal Template -->
            <div class="modal fade text-left" id="primary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title white" id="modalTitle"></h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <div class="modal-body" id="modalBody"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection