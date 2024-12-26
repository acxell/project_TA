@extends('master.master')
@section('title', 'Data Pendanaan Kegiatan')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Seluruh Data Pendanaan Kegiatan</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Pendanaan Kegiatan</li>
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
                            <th>No</th>
                            <th>Nama Kegiatan</th>
                            <th>Bulan Pelaksanaan</th>
                            <th>Unit</th>
                            <th>Total Pengajuan</th>
                            <th>Total Pencairan</th>
                            @can('Detail Data Pendanaan')
                            <th>Actions</th>
                            @endCan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendanaan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->kegiatan->tor->nama_kegiatan }}</td>
                            <td>{{ $item->kegiatan->tor->waktu }}</td>
                            <td>{{ $item->kegiatan->unit->nama }}</td>
                            <td>@currency($item->kegiatan->tor->rab->total_biaya)</td>
                            <td>@currency($item->besaran_transfer)</td>
                            <td>
                            @can('Detail Data Pendanaan')    
                            <a href="{{ route('pendanaan.dataPendanaan.detail', $item->id) }}"><i class="badge-circle font-small-1"
                                        data-feather="eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail"></i></a>
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