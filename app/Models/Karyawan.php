<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_karyawan',
        'alamat',
        'no_hp'
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'karyawans_id');
    }
}
