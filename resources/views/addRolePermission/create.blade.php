@extends('master.master')
@section('title', 'Tambah Permission Pada Role')
@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Form Tambah Permission pada Role {{ $role->name }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('role.view') }}">Data Role</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Tambah Role Permission</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form class="form" method="POST" action="{{ route('addRolePermission.store', $role->id) }}">
                @csrf
                <!-- Permission Categories Start -->
                <div class="row">
                    @php
                    $categories = [
                    'General Permissions' => [
                    'Create Permission',
                    'Edit Permission',
                    'Delete Permission',
                    'View Permission',
                    ],
                    'Role Management' => [
                    'Create Roles',
                    'Edit Roles',
                    'Delete Roles',
                    'View Roles',
                    'View Role Permissions',
                    'Add Role Permissions',
                    ],
                    'User Management' => [
                    'Create Pengguna',
                    'Edit Pengguna',
                    'Delete Pengguna',
                    'View Pengguna',
                    'Detail Pengguna',
                    ],
                    'Unit Management' => [
                    'Create Unit',
                    'Edit Unit',
                    'Delete Unit',
                    'Detail Unit',
                    'View Unit',
                    'View Data Coa',
                    ],
                    'Satuan Kerja Management' => [
                    'Create Satuan Kerja',
                    'Edit Satuan Kerja',
                    'Delete Satuan Kerja',
                    'View Satuan Kerja',
                    ],
                    'Kegiatan Tahunan' => [
                    'Create Kegiatan Tahunan',
                    'Edit Kegiatan Tahunan',
                    'Delete Kegiatan Tahunan',
                    'Detail Kegiatan Tahunan',
                    'View Kegiatan Tahunan',
                    ],
                    'Program Kerja' => [
                    'Create Program Kerja',
                    'Edit Program Kerja',
                    'Delete Program Kerja',
                    'View Program Kerja',
                    'Detail Program Kerja',
                    ],
                    'Aktivitas dan Anggaran Kegiatan' => [
                    'View Aktivitas dan Anggaran Kegiatan',
                    'Create Aktivitas Kegiatan',
                    'Edit Aktivitas Kegiatan',
                    'Delete Aktivitas Kegiatan',
                    'Create Kebutuhan Anggaran Kegiatan',
                    'Edit Kebutuhan Anggaran Kegiatan',
                    'Delete Kebutuhan Anggaran Kegiatan',
                    ],
                    'Anggaran Tahunan' => [
                    'Pengajuan Anggaran Tahunan',
                    'View Validasi Anggaran Tahunan',
                    'Validasi Anggaran Tahunan',
                    'View Finalisasi Anggaran Tahunan',
                    'Acc Finalisasi Anggaran Tahunan',
                    'View Riwayat Finalisasi',
                    ],
                    'Kegiatan Bulanan' => [
                    'Create Kegiatan Bulanan',
                    'Edit Kegiatan Bulanan',
                    'Delete Kegiatan Bulanan',
                    'Detail Kegiatan Bulanan',
                    'View Kegiatan Bulanan',
                    'Pengajuan Kegiatan Bulanan',
                    'Validasi Anggaran Bulanan',
                    'View Validasi Anggaran Bulanan',
                    ],
                    'Pendanaan' => [
                    'Pemberian Pendanaan',
                    'View Data Pendanaan',
                    'Detail Data Pendanaan',
                    ],
                    'LPJ' => [
                    'Create LPJ',
                    'Edit LPJ',
                    'Delete LPJ',
                    'Detail LPJ',
                    'View LPJ',
                    'Data Rincian LPJ',
                    'Pelaporan LPJ',
                    'Validasi LPJ',
                    ],
                    'Retur' => [
                    'View Retur',
                    'Edit Retur',
                    'Pengajuan Retur',
                    'Validasi Retur',
                    ],
                    'Kriteria dan Sub Kriteria' => [
                    'View Kriteria dan Sub Kriteria',
                    'Create Kriteria',
                    'Edit Kriteria',
                    'Delete Kriteria',
                    'Create Sub Kriteria',
                    'Edit Sub Kriteria',
                    'Delete Sub Kriteria',
                    ],
                    ];
                    @endphp

                    @foreach ($categories as $category => $permissionNames)
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header">{{ $category }}</div>
                            <div class="card-body">
                                <div class="list-group">
                                    @foreach ($permissionNames as $permissionName)
                                    @php
                                    $permission = $permissions->firstWhere('name', $permissionName);
                                    @endphp
                                    @if ($permission)
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" id="permission_{{ $permission->id }}" name="permission[]" value="{{ $permission->id }}"
                                            {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- Permission Categories End -->

                @can('Add Role Permissions')
                <div class="col-12 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary mt-6">Submit</button>
                </div>
                @endCan

            </form>
        </div>
    </div>
</div>
@endsection