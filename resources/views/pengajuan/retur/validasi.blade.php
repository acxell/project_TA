@extends('master.master')
@section('title', 'Validasi Data Pengajuan Retur')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Seluruh Data Pengajuan Retur</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Validasi Data Pengajuan Retur</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Nama Kegiatan</th>
                            <th>Nama Program Kerja</th>
                            <th>Total Retur</th>
                            <th>Nominal Retur</th>
                            <th>Bukti Retur</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($retur as $item)
                        <tr>
                            <td>{{ $item->lpj->kegiatan->tor->nama_kegiatan }}</td>
                            <td>{{ $item->lpj->kegiatan->tor->proker->nama }}</td>
                            <td>
                                @currency($item->total_retur)
                            </td>
                            <td>
                                @currency($item->nominal_retur)
                            </td>
                            <td><a href="{{ asset('storage/' . $item->bukti_retur) }}" target="_blank">View Bukti Retur</a>
                            <td>
                                <span class="badge {{ $item->status == 'Aktif' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('retur.accept', $item->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">Accept</button>
                                </form>
                                <form action="{{ route('retur.decline', $item->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="danger" class="btn btn-success btn-sm">Decline</button>
                                </form>
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