@extends('master.master')
@section('title', 'Data Pengajuan Anggaran Tahunan Kegiatan')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Seluruh Data Pengajuan Anggaran Tahunan Kegiatan Program Kerja</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Riwayat Perangkingan</li>
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
                            <th>Tanggal Penerimaan</th>
                            <th>Hasil Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kegiatan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->kegiatan->tor->nama_kegiatan }}</td>
                            <td>{{ $item->kegiatan->tor->proker->nama }}</td>
                            <td>{{ $item->kegiatan->unit->nama }}</td>
                            <td>
                                @unless(empty($item->kegiatan->tor->rab->total_biaya))
                                @currency($item->kegiatan->tor->rab->total_biaya)
                                @else
                                N/A
                                @endunless
                            </td>
                            <td>
                                @if($item->kegiatan->status == 0)
                                <span class="badge bg-warning">Belum Diajukan</span>
                                @elseif($item->kegiatan->status == 1)
                                <span class="badge bg-info">Telah Diajukan</span>
                                @elseif($item->kegiatan->status == 2)
                                <span class="badge bg-primary">Diterima Atasan Unit</span>
                                @elseif($item->kegiatan->status == 3)
                                <span class="badge bg-success">Proses Finalisasi Pengajuan</span>
                                @elseif($item->kegiatan->status == 4)
                                <span class="badge bg-warning">Revisi</span>
                                @elseif($item->kegiatan->status == 5)
                                <span class="badge bg-danger">Tidak Disetujui</span>
                                @elseif($item->kegiatan->status == 6)
                                <span class="badge bg-primary">Proses Pendanaan</span>
                                @elseif($item->kegiatan->status == 7)
                                <span class="badge bg-success">Telah Didanai</span>
                                @elseif($item->kegiatan->status == 8)
                                <span class="badge bg-info">Proses Pelaporan</span>
                                @elseif($item->kegiatan->status == 9)
                                <span class="badge bg-danger">Perlu Retur</span>
                                @elseif($item->kegiatan->status == 10)
                                <span class="badge bg-success">Selesai</span>
                                @elseif($item->kegiatan->status == 11)
                                <span class="badge bg-primary">Diterima</span>
                                @elseif($item->kegiatan->status == 12)
                                <span class="badge bg-warning">Belum Dilaporkan</span>
                                @elseif($item->kegiatan->status == 13)
                                <span class="badge bg-info">Proses Validasi</span>
                                @else
                                <span class="badge bg-secondary">Status Tidak Diketahui</span>
                                @endif
                            </td>
                            <td>{{ $item->tanggal_penerimaan }}</td>
                            <td>{{ $item->hasil_akhir }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

@endsection