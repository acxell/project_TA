@extends('master.master')
@section('title', 'Masukkan Data Pendanaan Kegiatan')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <p class="text-subtitle text-muted">Input Detail Data Pendanaan Kegiatan</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pendanaan.givePendanaan.view') }}">Data Pendanaan Kegiatan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Insert</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="POST" action="{{ route('pendanaan.dataPendanaan.store') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="kegiatan_id" value="{{ $kegiatan->id }}">
                                <div class="row">

                                    <div class="col-md-6 col-12">
                                        <fieldset>
                                            <label>Bukti Transfer</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group mb-3">
                                                    <label class="input-group-text" for="inputGroupFile01"><i
                                                            class="bi bi-upload"></i></label>
                                                    <input type="file" class="form-control" id="bukti_transfer" name="bukti_transfer" accept=".pdf">
                                                </div>
                                            </div>
                                            @error('bukti_transfer')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Nominal Transfer</label>
                                            <input type="number" id="besaran_transfer" class="form-control @error('besaran_transfer') is-invalid @enderror"
                                                placeholder="Nominal Transfer" name="besaran_transfer" value="{{ old('besaran_transfer') }}">
                                        </div>
                                        @error('besaran_transfer')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Basic multiple Column Form section end -->
</div>

@endsection

@section('scripts')
<script>
    document.getElementById('bukti_transfer').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const fileName = file ? file.name : 'No file chosen';
        document.getElementById('selectedFileName').textContent = fileName;

        // Check if the selected file is a PDF
        if (file && file.type === 'application/pdf') {
            const fileURL = URL.createObjectURL(file);
            document.getElementById('bukti_preview').data = fileURL; // Set the object data to the PDF file URL
        } else {
            document.getElementById('bukti_preview').data = ''; // Clear the object data if not a PDF
            alert("Please upload a valid PDF file.");
        }
    });
</script>
@endsection