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
                                @php
                                $statusColors = [
                                'Belum Diajukan' => 'bg-warning',
                                'Telah Diajukan' => 'bg-info',
                                'Diterima Atasan Unit' => 'bg-primary',
                                'Proses Finalisasi Pengajuan' => 'bg-success',
                                'Revisi' => 'bg-warning',
                                'Tidak Disetujui' => 'bg-danger',
                                'Proses Pendanaan' => 'bg-primary',
                                'Telah Didanai' => 'bg-success',
                                'Proses Pelaporan' => 'bg-info',
                                'Perlu Retur' => 'bg-danger',
                                'Selesai' => 'bg-success',
                                'Diterima' => 'bg-primary',
                                'Belum Dilaporkan' => 'bg-warning',
                                'Proses Validasi' => 'bg-info',
                                ];
                                $badgeClass = $statusColors[$item->status->status] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $item->status->status ?? 'Status Tidak Diketahui' }}</span>
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