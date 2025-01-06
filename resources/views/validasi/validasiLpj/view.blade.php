@extends('master.master')
@section('title', 'Validasi Pelaporan Pertanggung Jawaban')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Seluruh Data Pelaporan Pertanggung Jawaban</p>
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
                            <th>No</th>
                            <th>Nama Kegiatan</th>
                            <th>Nama Program Kerja</th>
                            <th>Unit</th>
                            <th>Total Biaya</th>
                            <th>Total Belanja</th>
                            <th>Status</th>
                            @can('Validasi LPJ')
                            <th>Actions</th>
                            @endCan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lpj as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->kegiatan->tor->nama_kegiatan }}</td>
                            <td>{{ $item->kegiatan->tor->proker->nama }}</td>
                            <td>{{ $item->kegiatan->unit->nama }}</td>
                            <td>@currency($item->kegiatan->pendanaan->first()->besaran_transfer ?? 0)</td>
                            <td>@currency($item->total_belanja)</td>
                            <td>
                                @if($item->status == 0)
                                <span class="badge bg-warning">Belum Diajukan</span>
                                @elseif($item->status == 1)
                                <span class="badge bg-info">Telah Diajukan</span>
                                @elseif($item->status == 2)
                                <span class="badge bg-primary">Diterima Atasan Unit</span>
                                @elseif($item->status == 3)
                                <span class="badge bg-success">Proses Finalisasi Pengajuan</span>
                                @elseif($item->status == 4)
                                <span class="badge bg-warning">Revisi</span>
                                @elseif($item->status == 5)
                                <span class="badge bg-danger">Tidak Disetujui</span>
                                @elseif($item->status == 6)
                                <span class="badge bg-primary">Proses Pendanaan</span>
                                @elseif($item->status == 7)
                                <span class="badge bg-success">Telah Didanai</span>
                                @elseif($item->status == 8)
                                <span class="badge bg-info">Proses Pelaporan</span>
                                @elseif($item->status == 9)
                                <span class="badge bg-danger">Perlu Retur</span>
                                @elseif($item->status == 10)
                                <span class="badge bg-success">Selesai</span>
                                @elseif($item->status == 11)
                                <span class="badge bg-primary">Diterima</span>
                                @elseif($item->status == 12)
                                <span class="badge bg-warning">Belum Dilaporkan</span>
                                @elseif($item->status == 13)
                                <span class="badge bg-info">Proses Validasi</span>
                                @else
                                <span class="badge bg-secondary">Status Tidak Diketahui</span>
                                @endif
                            </td>
                            <td>
                            @if($item->status == 8)
                            @can('Validasi LPJ')
                            <a href="{{ route('validasi.validasiLpj.validasi', $item->id) }}"><i class="badge-circle font-small-1"
                            data-feather="check" data-bs-toggle="tooltip" data-bs-placement="top" title="Validasi"></i></a>
                            @endCan
                            @endif
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