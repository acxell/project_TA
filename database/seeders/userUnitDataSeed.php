<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class userUnitDataSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unitId = Str::uuid()->toString(); 
        $roleId = Str::uuid()->toString();
        $satkerId = Str::uuid()->toString();
        $userId = Str::uuid()->toString();
        
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

        DB::table('roles')->insert([
            'id' => $roleId,
            'name' => 'Super Admin',
            'guard_name' => 'web',
        ]);

        DB::table('penggunas')->insert([
            'id' => $userId,
            'nama' => 'Agung',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'status' => '1',
            'unit_id' => $unitId,
        ]);

        DB::table('model_has_roles')->insert([
            'role_id' => $roleId,
            'model_type' => 'App\Models\pengguna',
            'model_uuid' => $userId,
        ]);

    }
}
