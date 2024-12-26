{{-- Dashboard --}}

@extends('master.master')
@section('title', 'Dashboard')
@section('content')

<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon purple mb-2">
                                        <i class="iconly-boldShow"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Pengajuan Tahunan</h6>
                                    <h6 class="font-extrabold mb-0">{{ $jumlahPengajuanTahunan }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon purple mb-2">
                                        <i class="iconly-boldShow"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Pengajuan Bulanan</h6>
                                    <h6 class="font-extrabold mb-0">{{ $jumlahPengajuanBulanan }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon blue mb-2">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Kegiatan Dilaksanakan</h6>
                                    <h6 class="font-extrabold mb-0">{{ $kegiatanDilaksanakan }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon green mb-2">
                                        <i class="iconly-boldAdd-User"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Pendanaan</h6>
                                    <h6 class="font-extrabold mb-0">@currency($totalPendanaan)</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Total Pendanaan Anggaran</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-profile-visit"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl">
                            <img src="{{ asset('template/assets/compiled/jpg/1.jpg') }}" alt="Face 1">
                        </div>
                        <div class="ms-3 name">
                            <h5 class="font-bold">Welcome, {{ $user->nama }}</h5>
                            <h6 class="text-muted mb-0">{{ $user->getRoleNames()->join(', ') }}</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Persentase Pengajuan Dana per Satuan Kerja</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-visitors-profile"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="row">
        <div class="col-12 col-lg-12">
            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Pengajuan Terbaru</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-lg">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name Kegiatan</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Jenis</th>
                                        <th>Kebutuhan Anggaran</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengajuanTerbaru as $key => $kegiatan)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $kegiatan->tor->nama_kegiatan }}</td>
                                        <td>{{ $kegiatan->created_at->format('d-m-Y') }}</td>
                                        <td>{{ $kegiatan->jenis }}</td>
                                        <td>
                                            @unless(empty($kegiatan->tor->rab->total_biaya))
                                            @currency($kegiatan->tor->rab->total_biaya)
                                            @else
                                            N/A
                                            @endunless
                                        </td>
                                        <td>{{ $kegiatan->status }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="{{ asset('template/assets/static\js\pages\dashboard.js') }}"></script>
@endsection