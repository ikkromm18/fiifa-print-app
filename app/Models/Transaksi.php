<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{

    use HasFactory;
    protected $fillable = [
        'kode_transaksi',
        'karyawans_id',
        'total_bayar',
        'jumlah_bayar',
        'kembalian'
    ];

    public function karyawan()
    {

        return $this->belongsTo(Karyawan::class, 'karyawans_id');
    }

    public function items()
    {
        return $this->hasMany(TransaksiItem::class, 'transaksi_id');
    }
}
