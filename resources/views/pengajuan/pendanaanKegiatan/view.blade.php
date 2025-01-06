@extends('master.master')
@section('title', 'Data Pengajuan Pendanaan Kegiatan')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Seluruh Data Pengajuan Pendanaan Kegiatan</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Pengajuan Pendanaan Kegiatan</li>
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
                            <th>Nama Program Kerja</th>
                            <th>Unit</th>
                            <th>Total Biaya</th>
                            <th>Status</th>
                            @can('Pengajuan Kegiatan Bulanan')
                            <th>Actions</th>
                            @endCan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kegiatan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->tor->nama_kegiatan }}</td>
                            <td>{{ $item->tor->proker->nama }}</td>
                            <td>{{ $item->unit->nama }}</td>
                            <td>
                                @unless(empty($item->tor->rab->total_biaya))
                                @currency($item->tor->rab->total_biaya)
                                @else
                                N/A <!-- Atau pesan lain -->
                                @endunless
                            </td>
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
                                @can('Pengajuan Kegiatan Bulanan')
                                <a href="{{ route('viewBulanan', $item->id) }}"><i class="badge-circle font-small-1"
                                        data-feather="dollar-sign" data-bs-toggle="tooltip" data-bs-placement="top" title="Pendanaan"></i></a>
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