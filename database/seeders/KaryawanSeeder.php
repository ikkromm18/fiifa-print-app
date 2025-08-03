<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_karyawan' => 'Alya',
                'alamat' => 'Desa Purwosari',
                'no_hp' => '083146813961'
            ],
            [
                'nama_karyawan' => 'Eka',
                'alamat' => 'Desa Purwosari',
                'no_hp' => '082122154913'
            ],
            [
                'nama_karyawan' => 'Amel',
                'alamat' => 'Desa Pecangakan',
                'no_hp' => '085802223831'
            ],
        ];

        DB::table('karyawans')->insert($data);
    }
}
