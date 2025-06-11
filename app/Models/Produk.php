<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_produk_id',
        'nama_produk',
        'harga',
        'stok',
    ];

    public function kategori_produks()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_produk_id');
    }
}
