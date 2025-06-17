<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{

    public function index(Request $request)
    {
        $from = $request->input('from')
            ? Carbon::createFromFormat('m/d/Y', $request->input('from'))->format('Y-m-d')
            : Carbon::today()->format('Y-m-d');

        $to = $request->input('to')
            ? Carbon::createFromFormat('m/d/Y', $request->input('to'))->format('Y-m-d')
            : Carbon::today()->format('Y-m-d');


        $penjualan = Transaksi::whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->get();
        $totalKeuangan = $penjualan->sum('total_bayar');
        $stok = Produk::all();

        return view('admin.laporan.laporan-index', compact('penjualan', 'totalKeuangan', 'stok', 'from', 'to'));
    }

    public function cetakPenjualan(Request $request)
    {
        $from = $request->input('from', Carbon::today()->format('Y-m-d'));
        $to = $request->input('to', Carbon::today()->format('Y-m-d'));

        $data = Transaksi::whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->get();
        $pdf = PDF::loadView('admin.laporan.penjualan_pdf', compact('data', 'from', 'to'));
        return $pdf->download("laporan-penjualan-{$from}-{$to}.pdf");
    }

    public function cetakKeuangan(Request $request)
    {
        $from = $request->input('from', Carbon::today()->format('Y-m-d'));
        $to = $request->input('to', Carbon::today()->format('Y-m-d'));

        $data = Transaksi::whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->get();
        $pdf = PDF::loadView('admin.laporan.keuangan_pdf', compact('data', 'from', 'to'));
        return $pdf->download("laporan-keuangan-{$from}-{$to}.pdf");
    }

    public function cetakStok()
    {
        $data = Produk::all();
        $pdf = PDF::loadView('admin.laporan.stok_pdf', compact('data'));
        return $pdf->download("laporan-stok.pdf");
    }
}
