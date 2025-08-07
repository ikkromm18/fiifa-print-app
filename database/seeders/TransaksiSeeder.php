<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use App\Models\Produk;
use App\Models\Karyawan;
use Faker\Factory as Faker;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        $produks = Produk::all();
        $karyawans = Karyawan::all();

        if ($produks->isEmpty() || $karyawans->isEmpty()) {
            $this->command->warn("Seeder transaksi dilewati: produk atau karyawan tidak tersedia.");
            return;
        }

        for ($i = 1; $i <= 50; $i++) {
            // Generate tanggal antara 1 - 6 Agustus 2025
            $createdAt = Carbon::create(2025, 8, 1)->addDays(rand(0, 5))->setTime(rand(8, 17), rand(0, 59));
            $kodeTransaksi = $createdAt->format('dmy') . str_pad($i, 3, '0', STR_PAD_LEFT);

            $karyawan = $karyawans->random();
            $jumlahProduk = $faker->numberBetween(1, 3);
            $produkTerpilih = $produks->random($jumlahProduk);

            $totalBayar = 0;
            $items = [];

            foreach ($produkTerpilih as $produk) {
                $qty = $faker->numberBetween(1, 5);
                $harga = $produk->harga;
                $subtotal = $harga * $qty;
                $totalBayar += $subtotal;

                $items[] = [
                    'produks_id' => $produk->id,
                    'quantity' => $qty,
                    'harga' => $harga,
                    'subtotal' => $subtotal,
                ];

                // Kurangi stok hanya jika produk adalah barang
                if ($produk->kategori_produk_id == 1 && $produk->stok !== null) {
                    $produk->stok = max(0, $produk->stok - $qty);
                    $produk->save();
                }
            }

            // Tambahkan random uang kembalian, lalu bulatkan ke kelipatan 500
            $tambahan = $faker->numberBetween(0, 10000);
            $jumlahBayarKasar = $totalBayar + $tambahan;
            $jumlahBayar = ceil($jumlahBayarKasar / 1000) * 1000;

            $kembalian = $jumlahBayar - $totalBayar;

            $transaksi = Transaksi::create([
                'kode_transaksi' => $kodeTransaksi,
                'karyawans_id' => $karyawan->id,
                'total_bayar' => $totalBayar,
                'jumlah_bayar' => $jumlahBayar,
                'kembalian' => $kembalian,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            foreach ($items as $item) {
                TransaksiItem::create([
                    'transaksi_id' => $transaksi->id,
                    'produks_id' => $item['produks_id'],
                    'quantity' => $item['quantity'],
                    'harga' => $item['harga'],
                    'subtotal' => $item['subtotal'],
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }
        }
    }
}
