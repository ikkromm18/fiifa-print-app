@extends('layouts.admin')
@section('title', 'Tambah Transaksi')

@section('content')
    <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Form Tambah Transaksi</h2>

        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf

            {{-- Karyawan --}}
            <div class="mb-4">
                <label for="karyawans_id" class="block mb-1 font-medium text-gray-700 dark:text-gray-200">Karyawan</label>
                <select name="karyawans_id" id="karyawans_id" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:text-white">
                    <option value="">Pilih Karyawan</option>
                    @foreach ($karyawans as $karyawan)
                        <option value="{{ $karyawan->id }}">{{ $karyawan->nama_karyawan }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Produk --}}
            <div id="produk-container" class="mb-4 space-y-4">
                <div class="produk-item grid grid-cols-4 gap-4">
                    <div>
                        <label>Produk</label>
                        <select name="produk_ids[]" class="w-full rounded">
                            @foreach ($produks as $produk)
                                <option value="{{ $produk->id }}" data-harga="{{ $produk->harga }}">
                                    {{ $produk->nama_produk }} - Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label>Qty</label>
                        <input type="number" name="quantities[]" class="w-full rounded" value="1" min="1">
                    </div>
                    <div>
                        <label>Harga</label>
                        <input type="number" name="hargas[]" class="w-full rounded" readonly>
                    </div>
                    <div>
                        <label>Subtotal</label>
                        <input type="number" name="subtotals[]" class="w-full rounded" readonly>
                    </div>
                </div>
            </div>

            <button type="button" onclick="addProduk()"
                class="mb-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">+ Produk</button>

            {{-- Jumlah Bayar --}}
            <div class="mb-4">
                <label>Jumlah Bayar</label>
                <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="w-full border rounded p-2" required>
            </div>

            {{-- Total Bayar + Kembalian --}}
            <div class="mb-4">
                <label>Total Bayar</label>
                <input type="number" name="total_bayar" id="total_bayar" class="w-full border rounded p-2" readonly>
            </div>

            <div class="mb-4">
                <label>Kembalian</label>
                <input type="number" name="kembalian" id="kembalian" class="w-full border rounded p-2" readonly>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Simpan
                Transaksi</button>
        </form>
    </div>

    <script>
        function addProduk() {
            const produkItem = document.querySelector('.produk-item').cloneNode(true);
            produkItem.querySelectorAll('input').forEach(input => input.value = '');
            document.getElementById('produk-container').appendChild(produkItem);
        }

        function updateHargaDanSubtotal() {
            const produkItems = document.querySelectorAll('.produk-item');
            let total = 0;

            produkItems.forEach(item => {
                const select = item.querySelector('select');
                const hargaInput = item.querySelector('input[name="hargas[]"]');
                const qtyInput = item.querySelector('input[name="quantities[]"]');
                const subtotalInput = item.querySelector('input[name="subtotals[]"]');

                const harga = parseInt(select.selectedOptions[0].dataset.harga || 0);
                const qty = parseInt(qtyInput.value || 0);
                const subtotal = harga * qty;

                hargaInput.value = harga;
                subtotalInput.value = subtotal;

                total += subtotal;
            });

            document.getElementById('total_bayar').value = total;

            const bayar = parseInt(document.getElementById('jumlah_bayar').value || 0);
            document.getElementById('kembalian').value = bayar - total;
        }

        document.addEventListener('input', updateHargaDanSubtotal);
        document.addEventListener('change', updateHargaDanSubtotal);
    </script>
@endsection
