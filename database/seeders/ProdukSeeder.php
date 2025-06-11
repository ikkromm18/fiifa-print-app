<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kategori_produk_id' => '1',
                'nama_produk' => 'Stopmap',
                'harga' => 10000,
                'stok' => 30
            ]
        ];

        DB::table('produks')->insert($data);
    }
}
