@extends('master.master')
@section('title', 'Data Pengajuan Kegiatan Program Kerja')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Seluruh Data Pengajuan Kegiatan Program Kerja</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Pengajuan Kegiatan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Nama Kegiatan</th>
                            <th>Nama Program Kerja</th>
                            <th>Total Biaya</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kegiatan as $item)
                        <tr>
                            <td>{{ $item->tor->nama_kegiatan }}</td>
                            <td>{{ $item->tor->proker->nama }}</td>
                            <td>
                                @unless(empty($item->tor->rab->total_biaya))
                                {{ $item->tor->rab->total_biaya }}
                                @else
                                N/A
                                @endunless
                            </td>

                            <td>
                                <span class="badge {{ $item->status == 'Aktif' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td><a href="{{ route('pengajuan.anggaranTahunan.detail', $item->id) }}"><i class="badge-circle font-small-1"
                                        data-feather="folder-plus"></i></a>
                                @if($item->status == 'Ditolak')
                                <a data-bs-toggle="modal" href="{{ route('pesanPerbaikan.anggaranTahunan.view', $item->id) }}"
                                    data-bs-target="#primary"><i class="badge-circle font-small-1"
                                        data-feather="mail"></i></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal-primary me-1 mb-1 d-inline-block">
            <!-- Button trigger for primary themes modal -->


            <!--primary theme Modal -->
            <div class="modal fade text-left" id="primary" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel160" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                    role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            @foreach ($kegiatan as $item)
                            <h5 class="modal-title white" id="myModalLabel160">{{ $item->tor->nama_kegiatan }}
                            </h5>
                            <button type="button" class="close" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{ $item->pesan_perbaikan->last()->pesan ?? 'No message available' }}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary"
                                data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="button" class="btn btn-primary ms-1"
                                data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Accept</span>
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

@endsection