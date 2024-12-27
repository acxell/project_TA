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
                                    <span class="badge {{ $item->kegiatan->status == 'Aktif' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $item->kegiatan->status }}
                                    </span>
                                </td>
                                <td>
                                    @if($item->kegiatan->status == 'Proses Finalisasi Pengajuan')
                                    @can('Acc Finalisasi Anggaran Tahunan')
                                    <input
                                        type="checkbox"
                                        name="kegiatan[{{ $item->kegiatan->id }}]"
                                        value="Diterima"
                                        {{ session('kegiatan_status') && array_key_exists($item->kegiatan->id, session('kegiatan_status')) ? 'checked' : '' }}>
                                    Diterima
                                    <a href="{{ route('finalisasi.finalisasiKegiatan.finalisasi', $item->kegiatan->id) }}"><i class="badge-circle font-small-1"
                                            data-feather="check" data-bs-toggle="tooltip" data-bs-placement="top" title="Finalisasi Pengajuan"></i></a>
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