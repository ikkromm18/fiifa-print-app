<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPemasukan = TransaksiItem::join('transaksis', 'transaksi_items.transaksi_id', '=', 'transaksis.id')
            ->sum(DB::raw('transaksi_items.harga * transaksi_items.quantity'));

        $jumlahTransaksi = Transaksi::count();
        $jumlahProduk = Produk::count();

        $stokMenipis = Produk::where('stok', '<=', 5)->get();
        $jumlahStokMenipis = $stokMenipis->count();

        $penjualanHariIni = Transaksi::whereDate('created_at', Carbon::today())->count();

        $produkTerlaris = TransaksiItem::select('produk_id', DB::raw('SUM(quantity) as total_terjual'))
            ->groupBy('produk_id')
            ->orderByDesc('total_terjual')
            ->with('produk')
            ->limit(5)
            ->get();

        $transaksiTerbaru = Transaksi::latest()->limit(5)->get();

        $penjualanMingguan = Transaksi::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(total_bayar) as total'))
            ->whereBetween('created_at', [now()->subDays(6), now()])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        return view('admin.dashboard', compact(
            'totalPemasukan',
            'jumlahTransaksi',
            'jumlahProduk',
            'stokMenipis',
            'jumlahStokMenipis',
            'penjualanHariIni',
            'produkTerlaris',
            'transaksiTerbaru',
            'penjualanMingguan'
        ));
    }
}
