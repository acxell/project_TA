@extends('master.master')
@section('title', 'Data Pengajuan Retur')
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
                        <li class="breadcrumb-item active" aria-current="page">Data Pengajuan Retur</li>
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
                            <th>Total Retur</th>
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
                            <td>{{ $item->lpj->kegiatan->unit->nama }}</td>
                            <td>
                                @currency($item->total_retur)
                            </td>
                            <td>
                                @if(!empty($item->bukti_retur))
                                <a href="{{ asset('storage/' . $item->bukti_retur) }}" target="_blank">View Bukti Retur</a>
                                @else
                                <span class="text-muted">Tidak ada Bukti Retur</span>
                                @endif
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
                                @if(in_array($item->status->status, ['Perlu Retur', 'Revisi']))
                                @can('Pengajuan Retur')
                                <button type="button" class="btn btn-primary btn-sm updateReturBtn"
                                    data-id="{{ $item->id }}"
                                    data-nominal="{{ $item->nominal_retur }}"
                                    data-bukti="{{ asset('storage/' . $item->bukti_retur) }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#updateReturModal">
                                    Buat Retur
                                </button>
                                @endCan
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add this below your existing table or at the bottom of the page -->
        <div class="modal fade" id="updateReturModal" tabindex="-1" aria-labelledby="updateReturModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="updateReturForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateReturModalLabel">Update Retur</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nominal_retur">Nominal Retur</label>
                                <input type="number" name="nominal_retur" id="nominal_retur" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="bukti_retur">Bukti Retur</label>
                                <input type="file" name="bukti_retur" id="bukti_retur" class="basic-filepond">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



    </section>
</div>

@endsection