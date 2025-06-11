<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->input('search');

        $produks = Produk::query()->when($search, function ($query, $search) {
            $query->where('nama_produk', 'like', '%' . $search . '%');
        })
            ->paginate(7);

        $data = [
            'produks' => $produks
        ];

        return view('admin.produk.produk-index', $data);
    }

    public function create()
    {
        $kategories = KategoriProduk::all();

        $data = [
            'kategories' => $kategories
        ];

        return view('admin.produk.produk-create', $data);
    }

    public function store(Request $request)
    {
        // Validasi
        $fields = $request->validate([
            'kategori_produk_id' => 'required',
            'nama_produk' => 'required|max:255',
            'harga' => 'required|integer',
            'stok' => 'nullable|integer'
        ]);

        // Store Ke Database
        Produk::create($fields);

        // Redirect
        return redirect()->route('produk.index')->with('success', 'berhasil menambahkan data');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategories = KategoriProduk::all();

        $data = [
            'produk' => $produk,
            'kategories' => $kategories
        ];

        return view('admin.produk.produk-edit', $data);
    }

    public function update(Request $request, $id)
    {
        // Validasi
        $fields = $request->validate([
            'kategori_produk_id' => 'required',
            'nama_produk' => 'required|max:255',
            'harga' => 'required|integer',
            'stok' => 'nullable|integer'
        ]);


        // Update Data
        $produk = Produk::findOrFail($id);
        $produk->update($fields);

        // Redirect
        return redirect()->route('produk.index')->with('success', 'berhasil mengupdate data');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'berhasil meghapus data');
    }
}
