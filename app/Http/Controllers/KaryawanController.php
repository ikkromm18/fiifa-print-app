<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->input('search');

        $karyawans = Karyawan::query()->when($search, function ($query, $search) {
            $query->where('nama_karyawan', 'like', '%' . $search . '%');
        })
            ->paginate(8);

        $data = [
            'karyawans' => $karyawans
        ];

        return view('admin.karyawan.karyawan-index', $data);
    }

    public function create()
    {
        return view('admin.karyawan.karyawan-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
        ]);

        Karyawan::create($validated);

        return redirect()->route('karyawan.index')->with('success', 'Berhasil menambahkan data karyawan.');
    }

    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        return view('admin.karyawan.karyawan-edit', compact('karyawan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
        ]);

        $karyawan = Karyawan::findOrFail($id);
        $karyawan->update($validated);

        return redirect()->route('karyawan.index')->with('success', 'Berhasil memperbarui data karyawan.');
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('karyawan.index')->with('success', 'Berhasil menghapus data karyawan.');
    }
}
