<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

class KategoriProdukController extends Controller
{
    //

    public function index(Request $request)
    {

        $search = $request->input('search');

        $kategoris = KategoriProduk::query()->when($search, function ($query, $search) {
            $query->where('nama', 'like', '%' . $search . '%');
        })
            ->paginate(7);

        $data = [
            'kategoris' => $kategoris
        ];

        return view('admin.kategori_produk.kategori-index', $data);
    }

    public function create()
    {
        return view('admin.kategori_produk.kategori-create');
    }

    public function store(Request $request)
    {
        // Validasi
        $fields = $request->validate([
            'nama' => 'required|max:255'
        ]);

        // Store Ke Database
        KategoriProduk::create($fields);

        // Redirect
        return redirect()->route('kategori_produk.index')->with('success', 'berhasil menambahkan data');
    }

    public function edit($id)
    {
        $kategori = KategoriProduk::findOrFail($id);

        $data = [
            'kategori' => $kategori
        ];

        return view('admin.kategori_produk.kategori-edit', $data);
    }

    public function update(Request $request, $id)
    {
        // Validasi
        $fields = $request->validate([
            'nama' => 'required|max:255'
        ]);

        // Update Data
        $kategori = KategoriProduk::findOrFail($id);
        $kategori->update($fields);

        // Redirect
        return redirect()->route('kategori_produk.index')->with('success', 'berhasil mengupdate data');
    }

    public function destroy($id)
    {
        $kategori = KategoriProduk::findOrFail($id);

        $kategori->delete();

        return redirect()->route('kategori_produk.index')->with('success', 'berhasil meghapus data');
    }
}
