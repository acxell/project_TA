@extends('master.master')
@section('title', 'Validasi Data Pengajuan Retur')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Seluruh Data Pengajuan Retur</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Validasi Data Pengajuan Retur</li>
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
                            <th>Total Retur</th>
                            <th>Nominal Retur</th>
                            <th>Unit</th>
                            <th>Bukti Retur</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($retur as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->lpj->kegiatan->tor->nama_kegiatan }}</td>
                            <td>{{ $item->lpj->kegiatan->tor->proker->nama }}</td>
                            <td>
                                @currency($item->total_retur)
                            </td>
                            <td>
                                @currency($item->nominal_retur)
                            </td>
                            <td>{{ $item->lpj->kegiatan->user->unit->nama }}</td>
                            <td><a href="{{ asset('storage/' . $item->bukti_retur) }}" target="_blank">View Bukti Retur</a>
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
                            @can('Validasi Retur')    
                            @if($item->status == 13)
                                <form action="{{ route('retur.accept', $item->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">Accept</button>
                                </form>
                                <form action="{{ route('retur.decline', $item->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="danger" class="btn btn-danger btn-sm">Decline</button>
                                </form>
                                @endif
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