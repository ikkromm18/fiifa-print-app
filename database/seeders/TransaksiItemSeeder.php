<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransaksiItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'transaksi_id' => 1,
                'produks_id' => rand(1, 50),
                'quantity' => 2,
                'harga' => 10000,
                'subtotal' => 20000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'transaksi_id' => 1,
                'produks_id' => rand(1, 50),
                'quantity' => 3,
                'harga' => 5000,
                'subtotal' => 15000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        DB::table('transaksi_items')->insert($data);
    }
}
