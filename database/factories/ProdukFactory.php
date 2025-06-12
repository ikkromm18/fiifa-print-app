<?php

namespace Database\Factories;

use App\Models\KategoriProduk;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    protected $model = Produk::class;

    public function definition(): array
    {
        return [
            'kategori_produk_id' => $this->faker->numberBetween(1, 2),
            'nama_produk' => $this->faker->words(3, true),
            'harga' => $this->faker->numberBetween(1000, 50000),
            'stok' => $this->faker->numberBetween(0, 100),
        ];
    }
}
