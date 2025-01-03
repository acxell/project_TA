{{-- Sidebars --}}

<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="{{ route('dashboard') }}"><img src="{{ asset('logo.png') }}" alt="Logo" style="width: 150px; height: auto;"></a>
                </div>

                <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                        <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2" opacity=".3"></path>
                            <g transform="translate(-210 -1)">
                                <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                <circle cx="220.5" cy="11.5" r="4"></circle>
                                <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                            </g>
                        </g>
                    </svg>
                    <div class="form-check form-switch fs-6">
                        <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                        <label class="form-check-label"></label>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                        <path fill="currentColor" d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                        </path>
                    </svg>
                </div>
                <div class="sidebar-toggler  x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu Utama
                <li class="sidebar-item ">
                    <a href="{{ route('dashboard') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @canany([
                'View Program Kerja',
                'View Kegiatan Tahunan',
                ])
                <li
                    class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-stack"></i>
                        <span>Penganggaran</span>
                    </a>

                    <ul class="submenu ">
                        @can('View Program Kerja')
                        <li class="submenu-item  ">
                            <a href="{{ route('penyusunan.programKerja.view') }}" class="submenu-link">Program Kerja</a>
                        </li>
                        @endCan
                        @can('View Kegiatan Tahunan')
                        <li class="submenu-item  ">
                            <a href="{{ route('penyusunan.kegiatan.view') }}" class="submenu-link">Kegiatan (TOR & RAB)</a>
                        </li>
                        @endCan
                    </ul>
                </li>
                @endcanany

                @canany([
                'Pengajuan Anggaran Tahunan',
                'View Kegiatan Bulanan',
                'View Retur',
                ])
                <li
                    class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-briefcase-fill"></i>
                        <span>Pengajuan</span>
                    </a>

                    <ul class="submenu ">
                        @can('Pengajuan Anggaran Tahunan')
                        <li class="submenu-item  ">
                            <a href="{{ route('pengajuan.anggaranTahunan.view') }}" class="submenu-link">Anggaran Tahunan</a>
                        </li>
                        @endCan
                        @can('View Kegiatan Bulanan')
                        <li class="submenu-item  ">
                            <a href="{{ route('pengajuan.pendanaanKegiatan.view') }}" class="submenu-link">Kegiatan</a>
                        </li>
                        @endCan
                        @can('View Retur')
                        <li class="submenu-item  ">
                            <a href="{{ route('pengajuan.retur.view') }}" class="submenu-link">Retur</a>
                        </li>
                        @endCan
                    </ul>
                </li>
                @endcanany

                @canany([
                'View LPJ',
                'Pelaporan LPJ',
                ])
                <li class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-passport"></i>
                        <span>laporan Pertanggung Jawabann</span>
                    </a>

                    <ul class="submenu ">
                        @can('View LPJ')
                        <li class="submenu-item  ">
                            <a href="{{ route('penyusunan.lpjKegiatan.view') }}" class="submenu-link">Form Pelaporan</a>
                        </li>
                        @endCan
                        @can('Pelaporan LPJ')
                        <li class="submenu-item  ">
                            <a href="{{ route('pengajuan.lpj.view') }}" class="submenu-link">Pelaporan Pertanggung Jawaban</a>
                        </li>
                        @endCan
                    </ul>
                </li>
                @endcanany
                </li>

                @canany([
                'View Data Pendanaan',
                'Pemberian Pendanaan',
                'View Kriteria dan Sub Kriteria',
                ])
                <li class="sidebar-title">Akuntan

                    @canany([
                    'View Data Pendanaan',
                    'Pemberian Pendanaan',
                    ])
                <li
                    class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-cash-coin"></i>
                        <span>Pendanaan</span>
                    </a>
                    <ul class="submenu ">
                        @can('View Data Pendanaan')
                        <li class="submenu-item  ">
                            <a href="{{ route('pendanaan.dataPendanaan.view') }}" class="submenu-link">Data Pencairan Dana Kegiatan</a>

                        </li>
                        @endCan
                        @can('Pemberian Pendanaan')
                        <li class="submenu-item  ">
                            <a href="{{ route('pendanaan.givePendanaan.view') }}" class="submenu-link">Pencairan Dana Kegiatan</a>

                        </li>
                        @endCan
                    </ul>
                </li>
                @endcanany
                @can('View Kriteria dan Sub Kriteria')
                <li class="sidebar-item  ">
                    <a href="{{ route('penyusunan.kriteria') }}" class='sidebar-link'>
                        <i class="bi bi-tools"></i>
                        <span>Kriteria & Sub Kriteria</span>
                    </a>
                </li>
                @endCan
                </li>
                @endcanany

                @canany([
                'View Validasi Anggaran Tahunan',
                'Validasi Retur',
                'Validasi LPJ',
                ])
                <li class="sidebar-title">Validasi

                    @canany([
                    'View Validasi Anggaran Tahunan',
                    'Validasi Retur',
                    ])
                <li class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-file-earmark-medical-fill"></i>
                        <span>Pengajuan</span>
                    </a>

                    <ul class="submenu ">
                        @can('View Validasi Anggaran Tahunan')
                        <li class="submenu-item  ">
                            <a href="{{ route('validasi.validasiAnggaran.view') }}" class="submenu-link">Anggaran Tahunan</a>

                        </li>
                        @endCan
                        @can('Validasi Retur')
                        <li class="submenu-item  ">
                            <a href="{{ route('pengajuan.retur.validasi') }}" class="submenu-link">Retur</a>
                        </li>
                        @endCan
                    </ul>
                </li>
                @endcanany
                @can('Validasi LPJ')
                <li class="sidebar-item  ">
                    <a href="{{ route('validasi.validasiLpj.view') }}" class='sidebar-link'>
                        <i class="bi bi-collection-fill"></i>
                        <span>Pelaporan Pertanggung Jawaban</span>
                    </a>

                </li>
                @endCan
                </li>
                @endcanany

                @canany([
                'View Finalisasi Anggaran Tahunan',
                'View Riwayat Finalisasi',
                ])
                <li class="sidebar-title">Atasan Yayasan
                @can('View Finalisasi Anggaran Tahunan')
                <li class="sidebar-item  ">
                    <a href="{{ route('finalisasi.finalisasiKegiatan.view') }}" class='sidebar-link'>
                        <i class="bi bi-safe-fill"></i>
                        <span>Finalisasi Pengajuan Tahunan</span>
                    </a>

                </li>
                @endCan
                @can('View Riwayat Finalisasi')
                <li class="sidebar-item  ">
                    <a href="{{ route('riwayat') }}" class='sidebar-link'>
                        <i class="bi bi-file-earmark-medical-fill"></i>
                        <span>Riwayat Finalisasi</span>
                    </a>

                </li>
                @endCan
                </li>
                @endcanany


                @canany([
                'View Pengguna',
                'View Roles',
                'View Permission',
                'View Unit',
                'View Satuan Kerja',
                'View Data Coa'
                ])
                <li class="sidebar-title">Admin

                <li class="sidebar-item  has-sub">
                    @canany([
                    'View Pengguna',
                    'View Roles',
                    'View Permission',
                    ])
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-person-fill-gear"></i>
                        <span>Pengguna</span>
                    </a>

                    <ul class="submenu ">
                        @can('View Pengguna')
                        <li class="submenu-item  ">
                            <a href="{{ route('pengguna.view') }}" class="submenu-link">Data Pengguna</a>
                        </li>
                        @endCan
                        @can('View Roles')
                        <li class="submenu-item  ">
                            <a href="{{ route('role.view') }}" class="submenu-link">Role Pengguna</a>
                        </li>
                        @endCan
                        @can('View Permission')
                        <li class="submenu-item  ">
                            <a href="{{ route('permission.view') }}" class="submenu-link">Permission Pengguna</a>
                        </li>
                        @endCan
                    </ul>
                    @endcanany
                    @can('View Unit')
                <li class="sidebar-item  ">
                    <a href="{{ route('unit.view') }}" class='sidebar-link'>
                        <i class="bi bi-people-fill"></i>
                        <span>Unit</span>
                    </a>
                </li>
                @endCan
                @can('View Satuan Kerja')
                <li class="sidebar-item  ">
                    <a href="{{ route('satuan_kerja.view') }}" class='sidebar-link'>
                        <i class="bi bi-building-fill"></i>
                        <span>Satuan Kerja</span>
                    </a>
                </li>
                @endCan
                @can('View Data Coa')
                <li class="sidebar-item  ">
                    <a href="{{ route('coa.view') }}" class='sidebar-link'>
                        <i class="bi bi-file-binary-fill"></i>
                        <span>COA</span>
                    </a>
                </li>
                @endCan
                </li>
                @endcanany
                <br>
                </li>
            </ul>
        </div>
    </div>
</div>