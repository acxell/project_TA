@extends('master.master')
@section('title', 'Detail Kegiatan Program Kerja')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md- order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('penyusunan.kegiatan.view') }}">Data Kegiatan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Kegiatan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Detail Kegiatan Section Start -->
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
                            <table class="table table-bordered">
                                <tr>
                                    <th>Satuan Pendidikan</th>
                                    <td colspan="5">{{ $kegiatan->satuan->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Satuan Unit</th>
                                    <td colspan="5">{{ $kegiatan->unit->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Bulan Tahun</th>
                                    <td colspan="5">{{ $kegiatan->tor->waktu }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Program Kerja</th>
                                    <td colspan="5">{{ $kegiatan->tor->proker->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Kegiatan</th>
                                    <td colspan="5">{{ $kegiatan->tor->nama_kegiatan }}</td>
                                </tr>

                                <tr>
                                    <th>Indikators</th>
                                    <td colspan="5">
                                        @if ($kegiatan->tor && $kegiatan->tor->indikatorKegiatan->isNotEmpty())
                                        <ol type="1">
                                            @foreach ($kegiatan->tor->indikatorKegiatan as $indikator)
                                            <li>{{ $indikator->indikator }}</li>
                                            @endforeach
                                        </ol>
                                        @else
                                        <p>Tidak ada indikators tersedia.</p>
                                        @endif
                                </tr>

                                <tr>
                                    <th>Outcomes</th>
                                    <td colspan="5">
                                        @if ($kegiatan->tor && $kegiatan->tor->outcomeKegiatan->isNotEmpty())
                                        <ol type="1">
                                            @foreach ($kegiatan->tor->outcomeKegiatan as $outcome)
                                            <li>{{ $outcome->outcome }}</li>
                                            @endforeach
                                        </ol>
                                        @else
                                        <p>Tidak ada outcomes tersedia.</p>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>PIC (Orang yang Bertanggung Jawab)</th>
                                    <td colspan="5">{{ $kegiatan->tor->pic }}</td>
                                </tr>
                                <tr>
                                    <th>Kepesertaan Kegiatan</th>
                                    <td colspan="5">{{ $kegiatan->tor->kepesertaan }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor dan Penjelasan Standar Akreditasi</th>
                                    <td colspan="1">{{ $kegiatan->tor->nomor_standar_akreditasi }}</td>
                                    <td colspan="3">{{ $kegiatan->tor->penjelasan_standar_akreditasi }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor dan Penjelasan COA Induk</th>
                                    <td colspan="1">{{ $kegiatan->tor->coa->kode }}</td>
                                    <td colspan="3">{{ $kegiatan->tor->coa->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Latar Belakang Kegiatan</th>
                                    <td colspan="5">{{ $kegiatan->tor->latar_belakang }}</td>
                                </tr>
                                <tr>
                                    <th>Tujuan Kegiatan</th>
                                    <td colspan="5">{{ $kegiatan->tor->tujuan }}</td>
                                </tr>
                                <tr>
                                    <th rowspan="2">Penerima Manfaat</th>
                                    <th>Internal</th>
                                    <td>{{ $kegiatan->tor->manfaat_internal }}</td>
                                </tr>
                                <tr>
                                    <th>Eksternal</th>
                                    <td>{{ $kegiatan->tor->manfaat_eksternal }}</td>
                                </tr>
                                <tr>
                                    <th>Metode Pelaksanaan</th>
                                    <td colspan="5">{{ $kegiatan->tor->metode_pelaksanaan }}</td>
                                </tr>
                                <tr>
                                    <th colspan="5">Tahapan dan Waktu Pelaksanaan</th>
                                </tr>

                                <!-- Table Head for Aktivitas -->
                                <tr>
                                    <th>Kategori</th>
                                    <th>Waktu Aktivitas</th>
                                    <th>Penjelasan Aktivitas</th>
                                </tr>

                                @if ($kegiatan->tor && $kegiatan->tor->aktivitas->isNotEmpty())
                                @php
                                $currentKategori = null;
                                $rowspanCount = 0;
                                @endphp

                                @foreach ($kegiatan->tor->aktivitas->groupBy('kategori') as $kategori => $aktivitasGroup)
                                @php
                                $rowspanCount = $aktivitasGroup->count();
                                @endphp

                                @foreach ($aktivitasGroup as $index => $aktivitas)
                                <tr>
                                    <!-- Kategori (Apply rowspan only for the first row of each category group) -->
                                    @if ($index === 0)
                                    <td rowspan="{{ $rowspanCount }}">{{ $kategori }}</td>
                                    @endif

                                    <!-- Waktu Aktivitas -->
                                    <td>{{ $aktivitas->waktu_aktivitas }}</td>

                                    <!-- Penjelasan Aktivitas -->
                                    <td>{{ $aktivitas->penjelasan }}</td>
                                </tr>
                                @endforeach
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5">Tidak ada aktivitas tersedia.</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Biaya yang Diperlukan</th>
                                    <td colspan="5">
                                        @unless(empty($kegiatan->tor->rab->total_biaya))
                                        {{ $kegiatan->tor->rab->total_biaya }}
                                        @else
                                        N/A <!-- Atau pesan lain -->
                                        @endunless
                                    </td>
                                </tr>
                                <tr>
                                    <th>Terbilang</th>
                                    <td colspan="5">
                                        @unless(empty($kegiatan->tor->rab->total_biaya))
                                        {{ $kegiatan->tor->rab->total_biaya }}
                                        @else
                                        N/A <!-- Atau pesan lain -->
                                        @endunless
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>


                    <div class="card-header">
                        <div class="col d-flex justify-content-center">
                            <h4 class="card-title">Rencana Anggaran dan Biaya (RAB)</h4>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Satuan Pendidikan</th>
                                    <td colspan="5">{{ $kegiatan->satuan->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Satuan Unit</th>
                                    <td colspan="5">{{ $kegiatan->unit->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Bulan Tahun</th>
                                    <td colspan="5">{{ $kegiatan->tor->waktu }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Kegiatan</th>
                                    <td colspan="5">{{ $kegiatan->tor->nama_kegiatan }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor dan Penjelasan COA Induk</th>
                                    <td colspan="1">{{ $kegiatan->tor->coa->kode }}</td>
                                    <td colspan="3">{{ $kegiatan->tor->coa->nama }}</td>
                                </tr>
                                <tr>
                                    <th colspan="5">Uraian Aktivitas</th>
                                </tr>

                                <!-- Table Head for Aktivitas -->
                                <tr>
                                    <th>Kategori</th>
                                    <th>Waktu Aktivitas</th>
                                    <th>Penjelasan Aktivitas</th>
                                    <th>Kebutuhan Anggaran</th>
                                </tr>

                                @if ($kegiatan->tor && $kegiatan->tor->aktivitas->isNotEmpty())
                                @php
                                $currentKategori = null;
                                $rowspanCount = 0;
                                @endphp

                                @foreach ($kegiatan->tor->aktivitas->groupBy('kategori') as $kategori => $aktivitasGroup)
                                @php
                                $rowspanCount = $aktivitasGroup->count();
                                @endphp

                                @foreach ($aktivitasGroup as $index => $aktivitas)
                                <tr>
                                    <!-- Kategori (Apply rowspan only for the first row of each category group) -->
                                    @if ($index === 0)
                                    <td rowspan="{{ $rowspanCount }}">{{ $kategori }}</td>
                                    @endif

                                    <!-- Waktu Aktivitas -->
                                    <td>{{ $aktivitas->waktu_aktivitas }}</td>

                                    <!-- Penjelasan Aktivitas -->
                                    <td>{{ $aktivitas->penjelasan }}</td>

                                    <td>
                                        @if ($aktivitas->kebutuhanAnggaran && $aktivitas->kebutuhanAnggaran->isNotEmpty())
                                        <table class="table table-lg">
                                            <thead>
                                                <tr>
                                                    <th>Nama Kebutuhan</th>
                                                    <th>Frekwensi</th>
                                                    <th>Volume</th>
                                                    <th>Satuan Volume</th>
                                                    <th>Harga</th>
                                                    <th>Total Biaya</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($aktivitas->kebutuhanAnggaran as $anggaran)
                                                <tr>
                                                    <td>{{ $anggaran->uraian_aktivitas }}</td>
                                                    <td>{{ $anggaran->frekwensi }}</td>
                                                    <td>Rp. {{ number_format($anggaran->nominal_volume, 2, ',', '.') }}</td>
                                                    <td>{{ $anggaran->satuan_volume }}</td>
                                                    <td>{{ number_format($anggaran->harga, 2, ',', '.') }}</td>
                                                    <td>{{ number_format($anggaran->jumlah, 2, ',', '.') }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @else
                                        <p>Tidak ada kebutuhan anggaran tersedia.</p>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5">Tidak ada aktivitas tersedia.</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Biaya yang Diperlukan</th>
                                    <td colspan="5">
                                        @unless(empty($kegiatan->tor->rab->total_biaya))
                                        {{ $kegiatan->tor->rab->total_biaya }}
                                        @else
                                        N/A <!-- Atau pesan lain -->
                                        @endunless
                                    </td>
                                </tr>
                                <tr>
                                    <th>Terbilang</th>
                                    <td colspan="5">
                                        @unless(empty($kegiatan->tor->rab->total_biaya))
                                        {{ $kegiatan->tor->rab->total_biaya }}
                                        @else
                                        N/A <!-- Atau pesan lain -->
                                        @endunless
                                    </td>
                                </tr>
                            </table>
                        </div>

                            <!-- Button Back to Kegiatan List -->
                            <div class="col-12 d-flex justify-content-end mt-3">
                                <a href="{{ route('penyusunan.kegiatan.view') }}" class="btn btn-primary">Back to Kegiatan List</a>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>
    <!-- Detail Kegiatan Section End -->
</div>

@endsection