@extends('master.master')
@section('title', 'Pelaporan Pertanggung Jawaban Kegiatan')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Detail Data Pelaporan Pertanggung Jawaban Kegiatan</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pengajuan.lpj.view') }}">Data LPJ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Detail Kegiatan Section Start -->
    <section id="detail-kegiatan">
        <div class="row match-height">
            <div class="col-12">
                <form class="form" action="{{ route('pengajuan.lpj.laporkan', $lpj->id) }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="col d-flex justify-content-center">
                                <h4 class="card-title">Laporan Pertanggung Jawaban</h4>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Satuan Pendidikan</th>
                                        <td colspan="5">{{ $lpj->kegiatan->satuan->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>Satuan Unit</th>
                                        <td colspan="5">{{ $lpj->kegiatan->unit->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>Bulan Tahun</th>
                                        <td colspan="5">{{ $lpj->kegiatan->tor->waktu }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Program Kerja</th>
                                        <td colspan="5">{{ $lpj->kegiatan->tor->proker->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Kegiatan</th>
                                        <td colspan="5">{{ $lpj->kegiatan->tor->nama_kegiatan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Penjelasan Kegiatan</th>
                                        <td colspan="5">{{ $lpj->penjelasan_kegiatan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jumlah Peserta Undangan</th>
                                        <td colspan="5">{{ $lpj->jumlah_peserta_undangan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jumlah Peserta Hadir</th>
                                        <td colspan="5">{{ $lpj->jumlah_peserta_hadir }}</td>
                                    </tr>
                                </table>

                                <!-- Detail Rincian Section Start -->
                                <section class="section mt-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5>Rincian Belanja</h5>
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Waktu Belanja</th>
                                                        <th>Harga</th>
                                                        <th>Keterangan</th>
                                                        <th>Bukti</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($lpj->rincian_lpj as $rincian)
                                                    <tr>
                                                        <td>{{ $rincian->waktu_belanja }}</td>
                                                        <td>@currency($rincian->harga)</td>
                                                        <td>{{ $rincian->keterangan }}</td>
                                                        <td><iframe src="{{ asset('storage/' . $rincian->bukti) }}" width="50%" height="400px">View Bukti</iframe></td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="5">Tidak ada rincian LPJ untuk kegiatan ini.</td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </section>
                                <!-- Detail Rincian Section End -->

                                <div class="col-12 d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary me-1 mb-1" onclick="window.history.back();">Go Back</button>
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Laporkan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Detail Kegiatan Section End -->
</div>
@endsection