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
                'alamat' => 'Comal',
                'no_hp' => '082134885973'
            ],
            [
                'nama_karyawan' => 'Ikrom',
                'alamat' => 'Wonoyoso',
                'no_hp' => '082134885973'
            ],
        ];

        DB::table('karyawans')->insert($data);
    }
}
