@extends('master.master')
@section('title', 'Data Pengajuan Pendanaan Kegiatan '. $kegiatan)
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Seluruh Data Pengajuan Pendanaan Kegiatan</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pengajuan.pendanaanKegiatan.view') }}">Data Pengajuan Pendanaan Kegiatan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kegiatan Bulanan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 order-md-2 order-last">
                        <a class="btn btn-primary" href="{{ route('createBulanan', $kegiatan_id) }}">Create</a>
                    </div>
                </div>
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Nama Kegiatan</th>
                            <th>Nama Program Kerja</th>
                            <th>Total Biaya</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kegiatanBulanan as $item)
                        <tr>
                            <td>{{ $item->tor->nama_kegiatan }}</td>
                            <td>{{ $item->tor->proker->nama }}</td>
                            <td>
                                @unless(empty($item->tor->rab->total_biaya))
                                @currency($item->tor->rab->total_biaya)
                                @else
                                N/A <!-- Atau pesan lain -->
                                @endunless
                            </td>
                            <td>
                                <span class="badge {{ $item->status == 'Aktif' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td>
                                @if($item->status == 'Belum Diajukan')
                                <a href="{{ route('editBulanan', $item->tor->id) }}"><i class="badge-circle font-medium-1"
                                        data-feather="edit"></i></a>
                                <a href="{{ route('pengajuan.pendanaanKegiatan.detail', $item->id) }}"><i class="badge-circle font-small-1"
                                        data-feather="dollar-sign"></i></a>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $item->id }}').submit();">
                                    <i class="badge-circle font-medium-1" data-feather="trash"></i>
                                </a>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('destroyBulanan', $item->id) }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <a href="{{ route('aktivitasBulanan', $item->tor->id) }}" class="btn btn-info">Lihat Aktivitas</a>
                                @endif
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