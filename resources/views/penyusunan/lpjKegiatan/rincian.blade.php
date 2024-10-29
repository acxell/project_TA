@extends('master.master')
@section('title', 'Rincian LPJ Kegiatan: ' . $lpj->kegiatan->tor->nama_kegiatan)
@section('content')

<div class="page-heading">
<div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Seluruh Data Pertanggung Jawaban Penggunaan Anggaran</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('penyusunan.lpjKegiatan.view') }}">Data LPJ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Rincian LPJ</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Button to Open the Modal for Creating New Rincian -->
    <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modalCreateRincian">
        Tambah Rincian LPJ
    </button>
</div>

<section class="section">
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Waktu Belanja</th>
                        <th>Harga</th>
                        <th>Keterangan</th>
                        <th>Bukti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rincianLpjs as $rincian)
                    <tr>
                        <td>{{ $rincian->waktu_belanja }}</td>
                        <td>@currency($rincian->harga)</td>
                        <td>{{ $rincian->keterangan }}</td>
                        <td><a href="{{ asset('storage/' . $rincian->bukti) }}" target="_blank">View Bukti</a></td>
                        <td>
                            <form action="{{ route('penyusunan.lpjKegiatan.rincian.destroy', $rincian->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">Tidak ada rincian LPJ untuk kegiatan ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Modal for Creating Rincian LPJ -->
<div class="modal fade" id="modalCreateRincian" tabindex="-1" role="dialog" aria-labelledby="modalCreateRincianLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreateRincianLabel">Tambah Rincian LPJ</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('penyusunan.lpjKegiatan.rincian.store', $lpj->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="waktu_belanja">Waktu Belanja</label>
                        <input type="date" name="waktu_belanja" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" name="harga" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Bukti</label>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupFile01"><i class="bi bi-upload"></i></label>
                            <input type="file" class="form-control" id="bukti" name="bukti" accept=".pdf">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.getElementById('bukti').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.type === 'application/pdf') {
            const fileURL = URL.createObjectURL(file);
            document.getElementById('bukti_preview').data = fileURL;
        } else {
            alert("Please upload a valid PDF file.");
        }
    });
</script>
@endsection