@extends('master.master')
@section('title', 'Validasi Pelaporan Pertanggung Jawaban')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Validasi Pelaporan Pertanggung Jawaban</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('validasi.validasiLpj.view') }}">Data Pengajuan Anggaran Tahunan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">validasi</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- // Basic multiple Column Form section start -->
<section id="detail-kegiatan">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col d-flex justify-content-center">
                        <h4 class="card-title">Term Of Reference (TOR)</h4>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" action="{{ route('validasi.validasiLpj.acc', $lpj->id) }}" method="POST">
                            @csrf
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


                            <!-- Button Back to Kegiatan List -->
                            <div class="col-12 d-flex justify-content-end mt-3">
                                <button type="button" class="btn btn-primary me-1 mb-1" onclick="window.history.back();">Go Back</button>
                                <a href="{{ route('pesanPerbaikan.lpj.create', ['lpj_id' => $lpj->id]) }}" class="btn btn-primary me-1 mb-1">
                                    Buat Pesan Perbaikan
                                </a>
                                <button type="submit" name="action" value="accept" class="btn btn-primary me-1 mb-1">Terima Pengajuan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


</section>
<!-- // Basic multiple Column Form section end -->
</div>
@endsection