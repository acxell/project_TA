<?php

use App\Http\Controllers\CoaController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\LpjController;
use App\Http\Controllers\PendanaanController;
use App\Http\Controllers\penggunaController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PesanPerbaikanController;
use App\Http\Controllers\ProgramKerjaController;
use App\Http\Controllers\RabController;
use App\Http\Controllers\ReturController;
use App\Http\Controllers\RincianLpjController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SatuanKerjaController;
use App\Http\Controllers\TorController;
use App\Http\Controllers\UnitController;
use App\Models\Kegiatan;
use App\Models\Pendanaan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [loginController::class, 'getView'])->name('login');
Route::post('/login', [loginController::class, 'login'])->name('login.store');


Route::group(['middleware' => 'auth'], function () {

    Route::post('/logout', [loginController::class, 'logout'])->name('logout');

    //Route::get('/dashboard', [dashboardController::class, 'getView'])->name('dashboard')->middleware('auth');

    Route::get('/dashboard', [dashboardController::class, 'getView'])->name('dashboard');

    //Actions Manajemen Data Pengguna
    Route::get('/data-pengguna', [penggunaController::class, 'index'])->name('pengguna.view');
    Route::get('/pengguna/{pengguna}/detail', [penggunaController::class, 'show'])->name('pengguna.detail');
    Route::get('/create-data-pengguna', [penggunaController::class, 'create'])->name('pengguna.create');
    Route::post('/pengguna', [penggunaController::class, 'store'])->name('pengguna.store');
    Route::get('/pengguna/{pengguna}/edit', [penggunaController::class, 'edit'])->name('pengguna.edit');
    Route::post('/pengguna/{pengguna}/update', [penggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna/{pengguna}', [penggunaController::class, 'destroy'])->name('pengguna.destroy');

    //Actions Manajemen Data Permission Pengguna
    Route::get('/data-permission', [permissionController::class, 'index'])->name('permission.view');
    Route::get('/create-data-permission', [permissionController::class, 'create'])->name('permission.create');
    Route::post('/permission', [permissionController::class, 'store'])->name('permission.store');
    Route::get('/permission/{permission}/edit', [permissionController::class, 'edit'])->name('permission.edit');
    Route::post('/permission/{permission}/update', [permissionController::class, 'update'])->name('permission.update');
    Route::delete('/permission/{permission}', [permissionController::class, 'destroy'])->name('permission.destroy');

    //Actions Manajemen Data Role Pengguna
    Route::get('/data-role', [RoleController::class, 'index'])->name('role.view');
    Route::get('/create-data-role', [RoleController::class, 'create'])->name('role.create');
    Route::post('/role', [RoleController::class, 'store'])->name('role.store');
    Route::get('/role/{role}/edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::post('/role/{role}/update', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/role/{role}', [RoleController::class, 'destroy'])->name('role.destroy');

    //Actions Role Permissions Pengguna
    Route::get('/role/{role}/give-permission', [RoleController::class, 'addPermissionToRole'])->name('addRolePermission.create');
    Route::post('/role/{role}/store-permission', [RoleController::class, 'storePermissionToRole'])->name('addRolePermission.store');

    //Actions Manajemen Data Unit
    Route::get('/data-unit', [UnitController::class, 'index'])->name('unit.view');
    Route::get('/create-data-unit', [UnitController::class, 'create'])->name('unit.create');
    Route::get('/unit/{unit}/detail', [UnitController::class, 'show'])->name('unit.detail');
    Route::post('/unit', [UnitController::class, 'store'])->name('unit.store');
    Route::get('/unit/{unit}/edit', [UnitController::class, 'edit'])->name('unit.edit');
    Route::post('/unit/{unit}/update', [UnitController::class, 'update'])->name('unit.update');
    Route::delete('/unit/{unit}', [UnitController::class, 'destroy'])->name('unit.destroy');

    //Actions Manajemen Data Satuan Kerja
    Route::get('/data-satuan-kerja', [SatuanKerjaController::class, 'index'])->name('satuan_kerja.view');
    Route::get('/create-data-satuan-kerja', [SatuanKerjaController::class, 'create'])->name('satuan_kerja.create');
    Route::get('/satuan-kerja/{satuan}/detail', [SatuanKerjaController::class, 'show'])->name('satuan_kerja.detail');
    Route::post('/satuan-kerja', [SatuanKerjaController::class, 'store'])->name('satuan_kerja.store');
    Route::get('/satuan-kerja/{satuan}/edit', [SatuanKerjaController::class, 'edit'])->name('satuan_kerja.edit');
    Route::post('/satuan-kerja/{satuan}/update', [SatuanKerjaController::class, 'update'])->name('satuan_kerja.update');
    Route::delete('/satuan-kerja/{satuan}', [SatuanKerjaController::class, 'destroy'])->name('satuan_kerja.destroy');

    //Actions Manajemen Data COA
    Route::get('/data-coa', [CoaController::class, 'index'])->name('coa.view');
    Route::get('/create-data-coa', [CoaController::class, 'create'])->name('coa.create');
    Route::get('/coa/{coa}/detail', [CoaController::class, 'show'])->name('coa.detail');
    Route::post('/coa', [CoaController::class, 'store'])->name('coa.store');
    Route::get('/coa/{coa}/edit', [CoaController::class, 'edit'])->name('coa.edit');
    Route::post('/coa/{coa}/update', [CoaController::class, 'update'])->name('coa.update');
    Route::delete('/coa/{coa}', [CoaController::class, 'destroy'])->name('coa.destroy');

    //Actions Manajemen Data Program Kerja
    Route::get('/data-program-kerja', [ProgramKerjaController::class, 'index'])->name('penyusunan.programKerja.view');
    Route::get('/create-data-program-kerja', [ProgramKerjaController::class, 'create'])->name('penyusunan.programKerja.create');
    Route::get('/program-kerja/{programKerja}/detail', [ProgramKerjaController::class, 'show'])->name('penyusunan.programKerja.detail');
    Route::post('/program-kerja', [ProgramKerjaController::class, 'store'])->name('penyusunan.programKerja.store');
    Route::get('/program-kerja/{programKerja}/edit', [ProgramKerjaController::class, 'edit'])->name('penyusunan.programKerja.edit');
    Route::post('/program-kerja/{programKerja}/update', [ProgramKerjaController::class, 'update'])->name('penyusunan.programKerja.update');
    Route::delete('/program-kerja/{programKerja}', [ProgramKerjaController::class, 'destroy'])->name('penyusunan.programKerja.destroy');


    Route::get('/create-data-tor-kegiatan', [TorController::class, 'create'])->name('penyusunan.tor.create');
    Route::post('/store-tor-kegiatan', [TorController::class, 'store'])->name('penyusunan.tor.store');
    Route::get('/tor-kegiatan/{tor}/edit', [TorController::class, 'edit'])->name('penyusunan.tor.edit');
    Route::post('/tor-kegiatan/{tor}/update', [TorController::class, 'update'])->name('penyusunan.tor.update');



    //Actions Manajemen Data Kegiatan
    Route::get('/data-kegiatan', [KegiatanController::class, 'index'])->name('penyusunan.kegiatan.view');
    Route::get('/create-data-kegiatan', [KegiatanController::class, 'create'])->name('penyusunan.kegiatan.create');
    Route::get('/kegiatan/{kegiatan}/detail', [KegiatanController::class, 'show'])->name('penyusunan.kegiatan.detail');
    Route::post('/kegiatan', [KegiatanController::class, 'store'])->name('penyusunan.kegiatan.store');
    Route::get('/kegiatan/{kegiatan}/edit', [KegiatanController::class, 'edit'])->name('penyusunan.kegiatan.edit');
    Route::post('/kegiatan/{kegiatan}/update', [KegiatanController::class, 'update'])->name('penyusunan.kegiatan.update');
    Route::delete('/kegiatan/{kegiatan}', [KegiatanController::class, 'destroy'])->name('penyusunan.kegiatan.destroy');

    //Actions Validasi Pengajuan Anggaran Tahunan
    Route::get('/data-pengajuan-kegiatan', [KegiatanController::class, 'pengajuanIndex'])->name('pengajuan.anggaranTahunan.view');
    Route::get('/data-pengajuan/{kegiatan}/detail', [KegiatanController::class, 'konfirmasiPengajuan'])->name('pengajuan.anggaranTahunan.detail');
    Route::post('/data-pengajuan/{kegiatan}/ajukan', [KegiatanController::class, 'ajukan'])->name('pengajuan.anggaranTahunan.ajukan');

    Route::get('/data-pengajuan-anggaran-tahunan', [KegiatanController::class, 'validasi_index'])->name('validasi.validasiAnggaran.view');
    Route::get('/pengajuan-anggaran-tahunan/{kegiatan}/validasi-pengajuan', [KegiatanController::class, 'validasi_pengajuan_tahunan'])->name('validasi.validasiAnggaran.validasi');
    Route::post('/pengajuan-anggaran-tahunan/{kegiatan}/acc-validasi', [KegiatanController::class, 'acc_validasi_pengajuan_tahunan'])->name('validasi.validasiAnggaran.acc');

    Route::get('/data-finalisasi-pengajuan-anggaran-tahunan', [KegiatanController::class, 'finalisasi_index'])->name('finalisasi.finalisasiKegiatan.view');
    Route::get('/finalisasi-pengajuan-anggaran-tahunan/{kegiatan}/finalisasi-pengajuan', [KegiatanController::class, 'finalisasi_pengajuan_tahunan'])->name('finalisasi.finalisasiKegiatan.finalisasi');
    Route::post('/finalisasi-pengajuan-anggaran-tahunan/{kegiatan}/acc-finalisasis', [KegiatanController::class, 'acc_finalisasi_pengajuan_tahunan'])->name('finalisasi.finalisasiKegiatan.acc');

    //Actions Pesan Perbaikan Anggaran Tahunan
    Route::get('/buat-pesan-perbaikan/{kegiatan_id}', [PesanPerbaikanController::class, 'create'])->name('pesanPerbaikan.anggaranTahunan.create');
    Route::post('/pesan-perbaikan', [PesanPerbaikanController::class, 'store'])->name('pesanPerbaikan.anggaranTahunan.store');
    Route::get('/pesan-perbaikan/{kegiatan_id}', [PesanPerbaikanController::class, 'show'])->name('pesanPerbaikan.anggaranTahunan.view');

    //Actions Pendanaan
    Route::get('/data-pengajuan-pendanaan-kegiatan', [KegiatanController::class, 'pendanaan_kegiatan_index'])->name('pengajuan.pendanaanKegiatan.view');
    Route::get('/data-pengajuan/{kegiatan}/pendanaan-kegiatan', [KegiatanController::class, 'konfirmasiPendanaan'])->name('pengajuan.pendanaanKegiatan.detail');
    Route::post('/data-pengajuan/{kegiatan}/ajukan-pendanaan-kegiatan', [KegiatanController::class, 'pendanaan'])->name('pengajuan.pendanaanKegiatan.ajukan');

    //Actions Didanai
    Route::get('/data-pendanaan-kegiatan', [KegiatanController::class, 'give_pendanaan_index'])->name('pendanaan.givePendanaan.view');
    Route::get('/data/{kegiatan}/pendanaan-kegiatan', [KegiatanController::class, 'give_konfirmasi_pendanaan'])->name('pendanaan.givePendanaan.detail');
    Route::post('/data/{kegiatan}/berikan-pendanaan-kegiatan', [KegiatanController::class, 'give_pendanaan'])->name('pendanaan.givePendanaan.berikan');

    //Actions Data Pendanaan
    Route::get('/data-pendanaan', [PendanaanController::class, 'index'])->name('pendanaan.dataPendanaan.view');
    Route::get('/create-data-pendanaan/{kegiatan_id}', [PendanaanController::class, 'create'])->name('pendanaan.dataPendanaan.create');
    Route::post('/store-data-pendanaan', [PendanaanController::class, 'store'])->name('pendanaan.dataPendanaan.store');
    Route::get('/data-pendanaan/{pendanaan}/detail', [PendanaanController::class, 'show'])->name('pendanaan.dataPendanaan.detail');

    //Actions Data LPJ
    Route::get('/data-lpj', [LpjController::class, 'index'])->name('penyusunan.lpjKegiatan.view');
    Route::get('/create-data-lpj', [LpjController::class, 'create'])->name('penyusunan.lpjKegiatan.create');
    Route::get('/lpj/{lpj}/detail', [LpjController::class, 'show'])->name('penyusunan.lpjKegiatan.detail');
    Route::post('/lpj', [LpjController::class, 'store'])->name('penyusunan.lpjKegiatan.store');
    Route::get('/lpj/{lpj}/edit', [LpjController::class, 'edit'])->name('penyusunan.lpjKegiatan.edit');
    Route::post('/lpj/{lpj}/update', [LpjController::class, 'update'])->name('penyusunan.lpjKegiatan.update');
    Route::delete('/lpj/{lpj}', [LpjController::class, 'destroy'])->name('penyusunan.lpjKegiatan.destroy');

    //Pelaporan LPJ
    Route::get('/data-laporan/lpj', [LpjController::class, 'pengajuanLpjIndex'])->name('pengajuan.lpj.view');
    Route::get('/data-laporan/lpj/{lpj}/pengajuan', [LpjController::class, 'konfirmasiPengajuanLPJ'])->name('pengajuan.lpj.detail');
    Route::post('/data-laporan/lpj/{lpj}/ajukan', [LpjController::class, 'ajukanLpj'])->name('pengajuan.lpj.laporkan');

    //Validasi LPJ
    Route::get('/data-pelaporan-pertanggung-jawaban', [LpjController::class, 'validasi_lpj_index'])->name('validasi.validasiLpj.view');
    Route::get('/lpj/{lpj}/validasi-pelaporan', [LpjController::class, 'validasi_pelaporan_lpj'])->name('validasi.validasiLpj.validasi');
    Route::post('/lpj/{lpj}/acc-validasi', [LpjController::class, 'acc_validasi_pelaporan_lpj'])->name('validasi.validasiLpj.acc');

    //Pesan perbaikan LPJ
    Route::get('/buat-pesan-perbaikan/lpj/{lpj_id}', [PesanPerbaikanController::class, 'create_lpj'])->name('pesanPerbaikan.lpj.create');
    Route::post('/pesan-perbaikan/lpj', [PesanPerbaikanController::class, 'store_lpj'])->name('pesanPerbaikan.lpj.store');
    Route::get('/pesan-perbaikan/lpj/{lpj_id}', [PesanPerbaikanController::class, 'show_lpj'])->name('pesanPerbaikan.lpj.view');

    Route::get('/lpjKegiatan/rincian/{id}', [RincianLpjController::class, 'index'])->name('penyusunan.lpjKegiatan.rincian');
    Route::post('/lpjKegiatan/rincian/store/{lpj}', [RincianLpjController::class, 'store'])->name('penyusunan.lpjKegiatan.rincian.store');
    Route::delete('/lpjKegiatan/rincian/destroy/{id}', [RincianLpjController::class, 'destroy'])->name('penyusunan.lpjKegiatan.rincian.destroy');
    Route::put('/penyusunan/lpjKegiatan/rincian/{id}', [RincianLpjController::class, 'update'])->name('penyusunan.lpjKegiatan.rincian.update');


    Route::get('penyusunan/tor/{tor}/aktivitas', [TorController::class, 'showAktivitas'])->name('penyusunan.tor.aktivitas');
    Route::post('penyusunan/aktivitas/{aktivitas}/kebutuhan-anggaran', [TorController::class, 'storeAnggaran'])->name('penyusunan.aktivitas.kebutuhan.store');
    Route::put('/penyusunan/aktivitas/kebutuhan/{id}', [TorController::class, 'updateAnggaran'])->name('penyusunan.aktivitas.kebutuhan.update');
    Route::delete('penyusunan/aktivitas/kebutuhan-anggaran/{anggaran}', [TorController::class, 'destroyAnggaran'])->name('penyusunan.aktivitas.kebutuhan.destroy');


    Route::post('tor/{tor}/aktivitas', [TorController::class, 'storeAktivitas'])->name('penyusunan.aktivitas.store');
    Route::put('tor/aktivitas/{aktivitas}', [TorController::class, 'updateAktivitas'])->name('penyusunan.aktivitas.update');
    Route::delete('tor/aktivitas/{aktivitas}', [TorController::class, 'destroyAktivitas'])->name('penyusunan.aktivitas.destroy');

    Route::get('/data-retur', [ReturController::class, 'index'])->name('pengajuan.retur.view');
    Route::patch('/retur/{retur}', [ReturController::class, 'update'])->name('retur.update');
    Route::post('/retur/{retur}/ajukan', [ReturController::class, 'ajukan'])->name('retur.ajukan');

    Route::get('/validasi-data-retur', [ReturController::class, 'indexVal'])->name('pengajuan.retur.validasi');
    Route::patch('/retur/{retur}/accept', [ReturController::class, 'accept'])->name('retur.accept');

    //Kriteria Sub Kriteria
    Route::get('penyusunan/kriteria', [KriteriaController::class, 'showKriteria'])->name('penyusunan.kriteria');
    Route::post('penyusunan/kriteria/{subkriteria}', [KriteriaController::class, 'storeSubkriteria'])->name('penyusunan.subkriteria.store');
    Route::put('penyusunan/kriteria/subkriteria/{id}', [KriteriaController::class, 'updateSubkriteria'])->name('penyusunan.subkriteria.update');
    Route::delete('penyusunan/aktivitas/subkriteria/{subkriteria}', [KriteriaController::class, 'destroySubkriteria'])->name('penyusunan.subkriteria.destroy');


    Route::post('kriteria/store', [KriteriaController::class, 'storeKriteria'])->name('penyusunan.kriteria.store');
    Route::put('updateKriteria/{kriteria}', [KriteriaController::class, 'updateKriteria'])->name('penyusunan.kriteria.update');
    Route::delete('deleteKriteria/{kriteria}', [KriteriaController::class, 'destroyKriteria'])->name('penyusunan.kriteria.destroy');

    //SAW
    Route::post('/calculate-saw', [KegiatanController::class, 'triggerCalculateSAW'])->name('saw.calculate');
});
