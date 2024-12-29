<?php

namespace Database\Seeders;

use App\Models\pengguna;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class userUnitDataSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected static ?string $password;

    public function run(): void
    {
        $unitId = Str::uuid()->toString(); 
        $satkerId = Str::uuid()->toString();
        
        DB::table('satuan_kerjas')->insert([
            'id' => $satkerId,
            'kode' => '112',
            'nama' => 'UNTAG Surabaya',
            'status' => '1',
        ]);

        DB::table('units')->insert([
            'id' => $unitId,
            'nama' => 'BKA',
            'description' => Str::random(10),
            'nomor_rekening' => Str::random(10),
            'status' => '1',
            'satuan_id' => $satkerId,
        ]);

        $superAdminRole = Role::create([
            'id' => Str::uuid()->toString(),
            'name' => 'Super Admin',
            'guard_name' => 'web',
        ]);

        $permissions = [
            'Create Permission',
            'Edit Permission',
            'Delete Permission',
            'View Permission',

            'Create Roles',
            'Edit Roles',
            'Delete Roles',
            'View Roles',

            'View Role Permissions',
            'Add Role Permissions',

            'Create Pengguna',
            'Edit Pengguna',
            'Delete Pengguna',
            'View Pengguna',

            'Create Unit',
            'Edit Unit',
            'Delete Unit',
            'View Unit',

            'View Data Coa',

            'Create Satuan Kerja',
            'Edit Satuan Kerja',
            'Delete Satuan Kerja',
            'View Satuan Kerja',

            'Create Kegiatan Tahunan',
            'Edit Kegiatan Tahunan',
            'Delete Kegiatan Tahunan',
            'Detail Kegiatan Tahunan',
            'View Kegiatan Tahunan',

            'Create Program Kerja',
            'Edit Program Kerja',
            'Delete Program Kerja',
            'View Program Kerja',
            'Detail Program Kerja',

            'View Aktivitas dan Anggaran Kegiatan',
            'Create Aktivitas Kegiatan',
            'Edit Aktivitas Kegiatan',
            'Delete Aktivitas Kegiatan',

            'Create Kebutuhan Anggaran Kegiatan',
            'Edit Kebutuhan Anggaran Kegiatan',
            'Delete Kebutuhan Anggaran Kegiatan',

            'Pengajuan Anggaran Tahunan',

            'View Validasi Anggaran Tahunan',
            'Validasi Anggaran Tahunan',

            'View Finalisasi Anggaran Tahunan',
            'Acc Finalisasi Anggaran Tahunan',
            'View Riwayat Finalisasi',

            'Create Kegiatan Bulanan',
            'Edit Kegiatan Bulanan',
            'Delete Kegiatan Bulanan',
            'Detail Kegiatan Bulanan',
            'View Kegiatan Bulanan',
            'Pengajuan Kegiatan Bulanan',

            'Pemberian Pendanaan',

            'View Data Pendanaan',
            'Detail Data Pendanaan',

            'Create LPJ',
            'Edit LPJ',
            'Delete LPJ',
            'Detail LPJ',
            'View LPJ',

            'Data Rincian LPJ',

            'Pelaporan LPJ',

            'Validasi LPJ',

            'View Retur',
            'Edit Retur',
            'Pengajuan Retur',

            'Validasi Retur',

            'View Kriteria dan Sub Kriteria',
            'Create Kriteria',
            'Edit Kriteria',
            'Delete Kriteria',

            'Create Sub Kriteria',
            'Edit Sub Kriteria',
            'Delete Sub Kriteria',
        ];

        foreach ($permissions as $permissionName) {
            $permission = Permission::create([
                'id' => Str::uuid()->toString(),
                'name' => $permissionName,
                'guard_name' => 'web',
            ]);

            $superAdminRole->givePermissionTo($permission);
        }

        $superAdmin = pengguna::create([
            'id' => Str::uuid()->toString(),
            'nama' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'status' => '1',
            'unit_id' => $unitId,
        ]);
        $superAdmin->assignRole($superAdminRole);

    }
}
