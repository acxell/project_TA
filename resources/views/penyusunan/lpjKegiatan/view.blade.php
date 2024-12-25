@extends('master.master')
@section('title', 'Data Laporan Pertanggung Jawaban Kegiatan')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Seluruh Laporan Pertanggung Jawaban Kegiatan</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data LPJ Kegiatan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @can('Create LPJ')
                    <div class="col-12 col-md-12 order-md-2 order-last">
                        <a class="btn btn-primary" href="{{ route('penyusunan.lpjKegiatan.create') }}">Create</a>
                    </div>
                    @endCan
                </div>
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kegiatan</th>
                            <th>Nama Program Kerja</th>
                            <th>Bulan Pelaksanaan</th>
                            <th>Total Biaya</th>
                            <th>Total Belanja</th>
                            @canany([
                            'Edit LPJ',
                            'Delete LPJ',
                            'Detail LPJ',
                            'Data Rincian LPJ',
                            ])
                            <th>Actions</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lpj as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->kegiatan->tor->nama_kegiatan }}</td>
                            <td>{{ $item->kegiatan->tor->waktu }}</td>
                            <td>{{ $item->kegiatan->tor->proker->nama }}</td>
                            <td>@currency($item->kegiatan->pendanaan->first()->besaran_transfer ?? 0)</td>
                            <td>@currency($item->total_belanja)</td>
                            <td>
                                @if($item->status == 'Belum Dilaporkan' || $item->status == 'Ditolak')
                                @can('Data Rincian LPJ')
                                <a href="{{ route('penyusunan.lpjKegiatan.rincian', $item->id) }}" class="btn btn-info">Lihat Rincian</a>
                                @endCan
                                @can('Delete LPJ')
                                <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $item->id }}').submit();">
                                    <i class="badge-circle font-medium-1" data-feather="trash" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i>
                                </a>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('penyusunan.lpjKegiatan.destroy', $item->id) }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endCan
                                @can('Edit LPJ')
                                <a href="{{ route('penyusunan.lpjKegiatan.edit', $item->id) }}"><i class="badge-circle font-medium-1"
                                        data-feather="edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a>
                                @endCan
                                @endif
                                @can('Detail LPJ')
                                <a href="{{ route('penyusunan.lpjKegiatan.detail', $item->id) }}"><i class="badge-circle font-small-1"
                                        data-feather="eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail"></i></a>
                                @endCan
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