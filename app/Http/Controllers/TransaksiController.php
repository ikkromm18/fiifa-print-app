<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $transaksis = Transaksi::query()->when($search, function ($query, $search) {
            $query->where('nama_produk', 'like', '%' . $search . '%');
        })
            ->paginate(8);

        $data = [
            'transaksis' => $transaksis
        ];

        return view('admin.transaksi.transaksi-index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.transaksi.transaksi-create', [
            'karyawans' => Karyawan::all(),
            'produks' => Produk::orderBy('nama_produk')->get(),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'karyawans_id' => 'required|exists:karyawans,id',
            'produk_ids' => 'required|array',
            'produk_ids.*' => 'exists:produks,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
            'hargas' => 'required|array',
            'hargas.*' => 'integer|min:0',
            'subtotals' => 'required|array',
            'subtotals.*' => 'integer|min:0',
            'jumlah_bayar' => 'required|integer|min:0',
        ]);

        // Hitung total bayar
        $totalBayar = array_sum($request->subtotals);

        // Hitung kembalian
        $kembalian = $request->jumlah_bayar - $totalBayar;

        // Simpan transaksi
        $transaksi = Transaksi::create([
            'karyawans_id' => $request->karyawans_id,
            'total_bayar' => $totalBayar,
            'jumlah_bayar' => $request->jumlah_bayar,
            'kembalian' => $kembalian,
        ]);

        // Simpan transaksi items
        foreach ($request->produk_ids as $index => $produkId) {
            TransaksiItem::create([
                'transaksi_id' => $transaksi->id,
                'produks_id' => $produkId,
                'quantity' => $request->quantities[$index],
                'harga' => $request->hargas[$index],
                'subtotal' => $request->subtotals[$index],
            ]);
        }

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transaksi = Transaksi::with(['karyawan', 'items.produk'])->findOrFail($id);

        return response()->json([
            'transaksi' => $transaksi,
            'items' => $transaksi->items->map(function ($item) {
                return [
                    'nama_produk' => $item->produk->nama_produk,
                    'harga' => $item->harga,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                ];
            }),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(transaksi $transaksi)
    {
        //
    }

    public function print($id)
    {
        $transaksi = Transaksi::with(['karyawan', 'items.produk'])->findOrFail($id);
        return view('admin.transaksi.print', compact('transaksi'));
    }
}
