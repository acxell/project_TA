@extends('master.master')
@section('title', 'Program Kerja')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Seluruh Data Program Kerja</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Program Kerja</li>
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
                        <a class="btn btn-primary" href="{{ route('penyusunan.programKerja.create') }}">Create</a>
                    </div>
                </div>
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Nama Program Kerja</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($programKerja as $item)
                        <tr>
                            <td>{{ $item->nama }}</td>
                            <td>
                                <span class="badge {{ $item->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $item->status == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td> <a onclick="showModal({ nama: '{{ $item->nama }}', deskripsi: '{{ $item->deskripsi }}' })" href="javascript:void(0)">
                                    <i class="badge-circle font-small-1" data-feather="eye"></i>
                                </a>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $item->id }}').submit();">
                                    <i class="badge-circle font-medium-1" data-feather="trash"></i>
                                </a>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('penyusunan.programKerja.destroy', $item->id) }}" method="POST" style="display:none;">
                                    @csrf;
                                    @method('DELETE')
                                </form>
                                <a href="{{ route('penyusunan.programKerja.edit', $item->id) }}"><i class="badge-circle font-medium-1"
                                        data-feather="edit"></i></a>
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
                            <button type="button" class="btn btn-primary ms-1" data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Accept</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </section>
</div>

@endsection