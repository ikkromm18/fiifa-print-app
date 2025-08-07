<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
        })->latest()
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

        // Cek stok sebelum simpan
        foreach ($request->produk_ids as $index => $produkId) {
            $produk = Produk::find($produkId);
            $qty = $request->quantities[$index];

            // Cek hanya jika produk ada dan merupakan kategori produk (bukan jasa)
            if ($produk && $produk->kategori_produk_id == 1 && $produk->stok < $qty) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['stok' => "Stok untuk produk '{$produk->nama_produk}' tidak mencukupi. Tersisa {$produk->stok}, dibutuhkan {$qty}."]);
            }
        }

        // Hitung total bayar
        $totalBayar = array_sum($request->subtotals);
        $kembalian = $request->jumlah_bayar - $totalBayar;

        // Pengecekan jika uang kurang
        if ($request->jumlah_bayar < $totalBayar) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['jumlah_bayar' => 'Jumlah bayar tidak mencukupi. Total yang harus dibayar adalah ' . number_format($totalBayar) . '.']);
        }

        // Buat kode transaksi
        $tanggal = now()->format('dmy');
        $countToday = Transaksi::whereDate('created_at', now())->count() + 1;
        $kodeTransaksi = $tanggal . str_pad($countToday, 3, '0', STR_PAD_LEFT);

        // Simpan transaksi
        $transaksi = Transaksi::create([
            'kode_transaksi' => $kodeTransaksi,
            'karyawans_id' => $request->karyawans_id,
            'total_bayar' => $totalBayar,
            'jumlah_bayar' => $request->jumlah_bayar,
            'kembalian' => $kembalian,
        ]);

        // Simpan item dan kurangi stok
        foreach ($request->produk_ids as $index => $produkId) {
            $qty = $request->quantities[$index];
            $produk = Produk::find($produkId);

            TransaksiItem::create([
                'transaksi_id' => $transaksi->id,
                'produks_id' => $produkId,
                'quantity' => $qty,
                'harga' => $request->hargas[$index],
                'subtotal' => $request->subtotals[$index],
            ]);

            // Kurangi stok jika produk adalah barang
            if ($produk->kategori_produk_id == 1) {
                $produk->stok -= $qty;
                $produk->save();
            }
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
    public function edit($id)
    {
        $transaksi = Transaksi::with('items')->findOrFail($id);
        $karyawans = Karyawan::all();
        $produks = Produk::all();
        $items = $transaksi->items;

        return view('admin.transaksi.transaksi-edit', compact('transaksi', 'karyawans', 'produks', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
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

        $transaksi = Transaksi::findOrFail($id);

        // Kembalikan stok produk lama
        foreach ($transaksi->items as $oldItem) {
            $produk = $oldItem->produk;
            if ($produk && $produk->kategori_produk_id == 1) {
                $produk->stok += $oldItem->quantity;
                $produk->save();
            }
        }

        // Hapus item lama
        $transaksi->items()->delete();

        // Cek stok produk baru sebelum simpan
        foreach ($request->produk_ids as $index => $produkId) {
            $produk = Produk::find($produkId);
            $qty = $request->quantities[$index];

            if ($produk && $produk->kategori_produk_id == 1 && $produk->stok < $qty) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['stok' => "Stok untuk produk '{$produk->nama_produk}' tidak mencukupi. Tersisa {$produk->stok}, dibutuhkan {$qty}."]);
            }
        }

        // Hitung total bayar dan kembalian
        $totalBayar = array_sum($request->subtotals);
        $kembalian = $request->jumlah_bayar - $totalBayar;

        if ($request->jumlah_bayar < $totalBayar) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['jumlah_bayar' => 'Jumlah bayar tidak mencukupi. Total yang harus dibayar adalah ' . number_format($totalBayar) . '.']);
        }

        // Update transaksi
        $transaksi->update([
            'karyawans_id' => $request->karyawans_id,
            'jumlah_bayar' => $request->jumlah_bayar,
            'total_bayar' => $totalBayar,
            'kembalian' => $kembalian,
        ]);

        // Simpan item baru dan kurangi stok jika barang
        foreach ($request->produk_ids as $index => $produkId) {
            $qty = $request->quantities[$index];
            $produk = Produk::find($produkId);

            TransaksiItem::create([
                'transaksi_id' => $transaksi->id,
                'produks_id' => $produkId,
                'quantity' => $qty,
                'harga' => $request->hargas[$index],
                'subtotal' => $request->subtotals[$index],
            ]);

            if ($produk && $produk->kategori_produk_id == 1) {
                $produk->stok -= $qty;
                $produk->save();
            }
        }

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diupdate.');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        // Kembalikan stok terlebih dahulu
        foreach ($transaksi->items as $item) {
            $produk = $item->produk;
            $produk->stok += $item->quantity;
            $produk->save();
        }

        // Hapus transaksi & relasi item-nya
        $transaksi->items()->delete();
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }


    public function print($id)
    {
        $transaksi = Transaksi::with(['karyawan', 'items.produk'])->findOrFail($id);
        return view('admin.transaksi.print', compact('transaksi'));
    }
}
