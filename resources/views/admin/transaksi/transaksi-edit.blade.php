@extends('layouts.admin')
@section('title', 'Edit Transaksi')

@section('content')
    <div class="w-full mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Form Edit Transaksi</h2>

        <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Karyawan --}}
            <div class="mb-4">
                <label for="karyawans_id" class="block mb-1 font-medium text-gray-700 dark:text-gray-200">Karyawan</label>
                <select name="karyawans_id" id="karyawans_id" required class="w-full border-gray-300 rounded-lg shadow-sm">
                    <option value="">Pilih Karyawan</option>
                    @foreach ($karyawans as $karyawan)
                        <option value="{{ $karyawan->id }}"
                            {{ $transaksi->karyawans_id == $karyawan->id ? 'selected' : '' }}>
                            {{ $karyawan->nama_karyawan }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Produk --}}
            <div id="produk-container" class="mb-4 space-y-4">
                @foreach ($items as $index => $item)
                    <div class="produk-item grid grid-cols-4 gap-4 relative">
                        <!-- Produk -->
                        <div>
                            <label>Produk</label>
                            <select name="produk_ids[]" class="produk-select w-full rounded">
                                @foreach ($produks as $produk)
                                    <option value="{{ $produk->id }}" data-harga="{{ $produk->harga }}"
                                        {{ $item->produks_id == $produk->id ? 'selected' : '' }}>
                                        {{ $produk->nama_produk }} - Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Qty -->
                        <div>
                            <label>Qty</label>
                            <input type="number" name="quantities[]" class="w-full rounded" min="1"
                                value="{{ $item->quantity }}">
                        </div>

                        <!-- Harga -->
                        <div>
                            <label>Harga</label>
                            <input type="number" name="hargas[]" class="w-full rounded" value="{{ $item->harga }}"
                                readonly>
                        </div>

                        <!-- Subtotal -->
                        <div>
                            <label>Subtotal</label>
                            <input type="number" name="subtotals[]" class="w-full rounded" value="{{ $item->subtotal }}"
                                readonly>
                        </div>

                        <!-- Tombol Hapus -->
                        <button type="button" onclick="removeProduk(this)"
                            class="absolute -top-3 -right-3 bg-red-600 text-white rounded-full w-6 h-6 text-sm flex items-center justify-center z-10">&times;</button>
                    </div>
                @endforeach
            </div>

            <button type="button" onclick="addProduk()"
                class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 mb-4">
                + Produk
            </button>

            {{-- Jumlah Bayar --}}
            <div class="mb-4">
                <label>Jumlah Bayar</label>
                <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="w-full border rounded p-2" required
                    value="{{ $transaksi->jumlah_bayar }}">
            </div>

            {{-- Total Bayar --}}
            <div class="mb-4">
                <label>Total Bayar</label>
                <input type="number" name="total_bayar" id="total_bayar" class="w-full border rounded p-2" readonly
                    value="{{ $transaksi->total_bayar }}">
            </div>

            {{-- Kembalian --}}
            <div class="mb-4">
                <label>Kembalian</label>
                <input type="number" name="kembalian" id="kembalian" class="w-full border rounded p-2" readonly
                    value="{{ $transaksi->kembalian }}">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Update
                Transaksi</button>
        </form>
    </div>

    @include('admin.transaksi._form-js')
@endsection
