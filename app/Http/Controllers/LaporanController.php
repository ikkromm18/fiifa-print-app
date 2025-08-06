<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Pagination\LengthAwarePaginator;

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

        // --- PENJUALAN DENGAN PAGINATION ---
        $penjualan = Transaksi::whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
            ->orderBy('created_at', 'desc')
            ->paginate(15, ['*'], 'page_penjualan')
            ->withQueryString();

        // --- TOTAL KESELURUHAN ---
        $totalKeuangan = $penjualan->total() > 0
            ? Transaksi::whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])->sum('total_bayar')
            : 0;

        // --- KEUANGAN PER TANGGAL (GROUP BY + PAGINATION MANUAL) ---
        $keuanganData = Transaksi::whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
            ->get()
            ->groupBy(function ($item) {
                return $item->created_at->format('Y-m-d');
            })
            ->map(function ($group) {
                return [
                    'tanggal' => $group->first()->created_at->format('Y-m-d'),
                    'total' => $group->sum('total_bayar'),
                ];
            })
            ->sortByDesc('tanggal')
            ->values(); // jadi collection numerik

        $pageKeuangan = $request->input('page_keuangan', 1);
        $perPage = 20;
        $keuanganPerTanggal = new LengthAwarePaginator(
            $keuanganData->forPage($pageKeuangan, $perPage),
            $keuanganData->count(),
            $perPage,
            $pageKeuangan,
            ['path' => $request->url(), 'pageName' => 'page_keuangan']
        );

        // --- STOK DENGAN PAGINATION ---
        $stok = Produk::paginate(20, ['*'], 'page_stok')->withQueryString();

        return view('admin.laporan.laporan-index', compact(
            'penjualan',
            'totalKeuangan',
            'stok',
            'from',
            'to',
            'keuanganPerTanggal'
        ));
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
