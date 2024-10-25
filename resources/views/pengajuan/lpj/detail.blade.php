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
                                        <th>Nama Kegiatan</th>
                                        <td colspan="5">{{ $lpj->jumlah_peserta_undangan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Kegiatan</th>
                                        <td colspan="5">{{ $lpj->jumlah_peserta_hadir }}</td>
                                    </tr>



                                </table>

                                <div class="col-12 d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary me-1 mb-1" onclick="window.history.back();">Go Back</button>
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Laporkan</button>
                                </div>
                            </div>

                        </div>
                </form>
            </div>
        </div>
</div>
</div>


</section>
<!-- Detail Kegiatan Section End -->
</div>
@endsection