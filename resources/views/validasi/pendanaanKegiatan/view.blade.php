@extends('master.master')
@section('title', 'Validasi Pengajuan Anggaran Bulanan')
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
                        <li class="breadcrumb-item active" aria-current="page">Data Pengajuan Anggaran Bulanan</li>
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
                            <th>Bulan Pelaksanaan</th>
                            <th>Total Biaya</th>
                            <th>Status</th>
                            @can('Validasi Anggaran Bulanan')
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
                            <td>{{ $item->tor->waktu }}</td>
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
                                @if (($item->status->status == 'Telah Diajukan' && auth()->user()->hasRole('Atasan Unit')))
                                @can('Validasi Anggaran Bulanan')
                                <a href="{{ route('validasi.validasiBulanan.validasi', $item->id) }}">
                                    <i class="badge-circle font-small-1" data-feather="check"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Validasi"></i>
                                </a>
                                @endcan
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