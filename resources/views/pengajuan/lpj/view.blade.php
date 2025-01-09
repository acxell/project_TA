@extends('master.master')
@section('title', 'Pelaporan Pertanggung Jawaban Kegiatan')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Seluruh Pelaporan Pertanggung Jawaban Kegiatan</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Pelaporan Pertanggung Jawaban Kegiatan</li>
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
                            <th>Bulan Pelaksanaan</th>
                            <th>Total Biaya</th>
                            <th>Total Belanja</th>
                            <th>Unit</th>
                            <th>Status</th>
                            @can('Pelaporan LPJ')
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
                            <td>{{ $item->kegiatan->tor->waktu }}</td>
                            <td>@currency($item->kegiatan->pendanaan->first()->besaran_transfer ?? 0)</td>
                            <td>@currency($item->total_belanja)</td>
                            <td>{{ $item->kegiatan->unit->nama }}</td>
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
                                @can('Pelaporan LPJ')
                            @if($item->status->status == 'Belum Dilaporkan')    
                            <a href="{{ route('pengajuan.lpj.detail', $item->id) }}"><i class="badge-circle font-small-1"
                                        data-feather="folder-plus" data-bs-toggle="tooltip" data-bs-placement="top" title="Ajukan"></i></a>
                                @endif
                                @if($item->status->status == 'Revisi')
                                <a href="{{ route('pengajuan.lpj.detail', $item->id) }}"><i class="badge-circle font-small-1"
                                        data-feather="folder-plus" data-bs-toggle="tooltip" data-bs-placement="top" title="Ajukan"></i></a>
                                        <a data-bs-toggle="modal" href="#modal-{{ $item->id }}">
                                    <i class="badge-circle font-small-1" data-feather="mail" data-bs-toggle="tooltip" data-bs-placement="top" title="Pesan Perbaikan"></i>
                                </a>
                                @endif
                                @endCan
                            </td>
                        </tr>
                        <div class="modal fade text-left" id="modal-{{ $item->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <h5 class="modal-title white" id="myModalLabel{{ $item->id }}">{{ $item->kegiatan->tor->nama_kegiatan }}</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        {{ $item->pesan_perbaikan->last()->pesan ?? 'No message available' }}
                                    </div>
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
                        <!-- End Modal -->
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal-primary me-1 mb-1 d-inline-block">
        </div>

    </section>
</div>

@endsection