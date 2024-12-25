@extends('master.master')
@section('title', 'Data Kegiatan Program Kerja')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Seluruh Data Kegiatan Program Kerja</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Kegiatan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @can('Create Kegiatan Tahunan')
                    <div class="col-12 col-md-12 order-md-2 order-last">
                        <a class="btn btn-primary" href="{{ route('penyusunan.tor.create') }}">Create</a>
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
                            @canany([
                            'Detail Kegiatan Tahunan',
                            'Edit Kegiatan Tahunan',
                            'Delete Kegiatan Tahunan',
                            'View Aktivitas dan Anggaran Kegiatan',
                            ])
                            <th>Actions</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kegiatan as $item)
                        <tr>
                        <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->tor->nama_kegiatan }}</td>
                            <td>{{ $item->tor->proker->nama }}</td>
                            <td>{{ $item->tor->waktu }}</td>
                            <td>
                                @unless(empty($item->tor->rab->total_biaya))
                                @currency($item->tor->rab->total_biaya)
                                @else
                                N/A
                                @endunless
                            </td>
                            <td> @if($item->status == 'Belum Diajukan' || $item->status == 'Ditolak')
                                @can('Detail Kegiatan Tahunan')
                            <a href="{{ route('penyusunan.kegiatan.detail', $item->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                    <i class="badge-circle font-small-1" data-feather="eye"></i>
                                </a>
                                @endCan
                                @can('Delete Kegiatan Tahunan')
                                <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $item->id }}').submit();" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                    <i class="badge-circle font-medium-1" data-feather="trash"></i>
                                </a>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('penyusunan.kegiatan.destroy', $item->id) }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endCan
                                @can('Edit Kegiatan Tahunan')
                                <a href="{{ route('penyusunan.tor.edit', $item->tor->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                    <i class="badge-circle font-medium-1" data-feather="edit"></i>
                                </a>
                                @endCan
                                @can('View Aktivitas dan Anggaran Kegiatan')
                                <a href="{{ route('penyusunan.tor.aktivitas', $item->tor->id) }}" class="btn btn-info">Lihat Aktivitas</a>
                                @endCan
                                @else
                                @can('Detail Kegiatan Tahunan')
                                <a href="{{ route('penyusunan.kegiatan.detail', $item->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                    <i class="badge-circle font-small-1" data-feather="eye"></i>
                                </a>
                                @endCan
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