@extends('master.master')
@section('title', 'Validasi Pengajuan Anggaran Tahunan')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Seluruh Data Pengajuan Anggaran</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Pengajuan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row">
                </div>
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Nama Kegiatan</th>
                            <th>Nama Program Kerja</th>
                            <th>Total Biaya</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rab as $item)
                        <tr>
                            <td>{{ $item->nama_kegiatan }}</td>
                            <td>{{ $item->tor->nama_proker }}</td>
                            <td>@currency($item->total_biaya)</td>
                            <td>
                                <span class="badge {{ $item->status == 'Aktif' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td><a href="{{ route('validasiAnggaran.validasi', $item->id) }}"><i class="badge-circle font-small-1"
                                        data-feather="eye"></i></a>
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