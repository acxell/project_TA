@extends('master.master')
@section('title', 'Finalisasi Pengajuan Anggaran Tahunan')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Seluruh Data Finalisasi Pengajuan Anggaran</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Perangkingan Finalisasi Kegiatan Tahunan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                @can('Acc Finalisasi Anggaran Tahunan')
                    <div class="col">
                        <button id="trigger-saw" class="btn btn-primary">Lakukan Perangkingan</button>
                    </div>
                    @endCan
                </div>
                <div id="hasil-saw">
                </div>
                <form action="{{ route('finalisasi.simpan') }}" method="POST">
                    @csrf
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kegiatan</th>
                                <th>Nama Program Kerja</th>
                                <th>Bulan Pelaksanaan</th>
                                <th>Total Biaya</th>
                                <th>Skor</th>
                                <th>Status</th>
                                <th>ACC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kegiatan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->kegiatan->tor->nama_kegiatan }}</td>
                                <td>{{ $item->kegiatan->tor->proker->nama }}</td>
                                <td>{{ $item->kegiatan->tor->waktu }}</td>
                                <td>
                                    @unless(empty($item->kegiatan->tor->rab->total_biaya))
                                    @currency($item->kegiatan->tor->rab->total_biaya)
                                    @else
                                    N/A
                                    @endunless
                                </td>
                                <td>{{ $item->hasil_akhir }}</td>
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
                                <td>
                                    @if($item->kegiatan->status == 3)
                                    @can('Acc Finalisasi Anggaran Tahunan')
                                    <input
                                        type="checkbox"
                                        name="kegiatan[{{ $item->kegiatan->id }}]"
                                        value=11
                                        {{ session('kegiatan_status') && array_key_exists($item->kegiatan->id, session('kegiatan_status')) ? 'checked' : '' }}>
                                    Diterima
                                    <a href="{{ route('finalisasi.finalisasiKegiatan.finalisasi', $item->kegiatan->id) }}"><i class="badge-circle font-small-1"
                                    data-feather="eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail"></i></a>
                                    @endCan
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @can('Acc Finalisasi Anggaran Tahunan')
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                    @endCan
                </form>
                @if (session('kegiatan_status'))
                <div class="d-flex justify-content-center">
                    <form action="{{ route('finalisasi.konfirmasi') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Submit Final Status</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </section>
</div>

<script>
   document.getElementById('trigger-saw').addEventListener('click', function () {
        fetch('{{ route('saw.calculate') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
        })
        .then(response => response.json())
        .then(data => {
            const hasilSaw = document.getElementById('hasil-saw');
            if (data.success) {
                hasilSaw.innerHTML = `
                    <div class="alert alert-success">
                        ${data.message}
                    </div>`;
            } else {
                hasilSaw.innerHTML = `
                    <div class="alert alert-danger">
                        ${data.message}
                    </div>`;
            }
            setTimeout(() => location.reload(), 5000);
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('hasil-saw').innerHTML = `
                <div class="alert alert-danger">
                    Terjadi kesalahan saat memproses perhitungan SAW.
                </div>`;
                setTimeout(() => location.reload(), 5000);
        });
});
</script>

@endsection