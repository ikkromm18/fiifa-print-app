@extends('layouts.admin')
@section('title', 'Transaksi')
@section('content')

    <div class="">




        <div class="flex justify-between items-center">
            <x-page-title title="Data Transaksi" />
            <x-breadcrumb :items="[['label' => 'Dashboard', 'url' => route('dashboard')], ['label' => 'Transaksi']]" />

        </div>

        <x-alert />

        <div class="flex flex-row w-full justify-between">
            <x-search name="search" placeholder="Cari Data Transaksi..." />
            <x-add-button href="{{ route('transaksi.create') }}" label="Tambah Transaksi" />
        </div>



        <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-2">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mb-2">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Tanggal
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Nama Karyawan
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Total Bayar
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Jumlah Bayar
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Kembalian
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($transaksis as $transaksi)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">

                            <td class="px-6 py-4">
                                {{ $loop->iteration + ($transaksis->currentPage() - 1) * $transaksis->perPage() }}
                            </td>

                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $transaksi->created_at }}
                            </th>

                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $transaksi->karyawan->nama_karyawan }}
                            </th>

                            <td scope="row" class="px-6 py-4 text-gray-900">
                                {{ 'Rp ' . number_format($transaksi->total_bayar, 0, ',', '.') }}
                            </td>

                            <td scope="row" class="px-6 py-4 text-gray-900">
                                {{ 'Rp ' . number_format($transaksi->jumlah_bayar, 0, ',', '.') }}
                            </td>

                            <td scope="row" class="px-6 py-4 text-gray-900">
                                {{ 'Rp ' . number_format($transaksi->kembalian, 0, ',', '.') }}
                            </td>


                            <td class="px-6 py-4 flex gap-2">


                                <button onclick="showDetail({{ $transaksi->id }})"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Detail</button>


                                {{-- <a href="{{ route('transaksi.show', $transaksi->id) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Detail</a> --}}

                                {{-- <form action="{{ route('transaksi.destroy', $transaksi->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="font-medium text-red-600 dark:text-red-500 hover:underline">Hapus</button>

                                </form> --}}

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $transaksis->appends(['search' => request('search')])->links() }}
        </div>

    </div>


    <!-- Modal -->
    <div id="readProductModal" tabindex="-1"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">

        <!-- Wrapper dengan batas ukuran & scroll -->
        <div class="relative w-full max-w-2xl max-h-full p-4 overflow-y-auto">
            <!-- Modal Box -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 sm:p-6">
                <!-- Header -->
                <div class="flex justify-between items-start border-b pb-4 mb-4">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Detail Transaksi</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Dilayani oleh: <span id="modal-karyawan"
                                class="font-medium text-gray-900 dark:text-white">-</span>
                        </p>
                        <p id="modal-tanggal" class="text-xs text-gray-500 dark:text-gray-400"></p>
                    </div>
                    <button type="button" onclick="closeModal()"
                        class="text-gray-400 hover:text-gray-900 dark:hover:text-white text-lg font-bold">×</button>
                </div>

                <!-- Produk List -->
                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Daftar Produk</h4>
                <ul id="modal-items" class="space-y-2 mb-4">
                    <!-- Dynamic content -->
                </ul>

                <!-- Info Pembayaran -->
                <div class="border-t pt-4 mb-4">
                    <dl class="grid grid-cols-2 gap-2 text-sm">
                        <dt class="font-semibold text-gray-900 dark:text-white">Total Bayar</dt>
                        <dd id="modal-totalBayar" class="text-gray-700 dark:text-gray-300">Rp -</dd>

                        <dt class="font-semibold text-gray-900 dark:text-white">Jumlah Bayar</dt>
                        <dd id="modal-jumlahBayar" class="text-gray-700 dark:text-gray-300">Rp -</dd>

                        <dt class="font-semibold text-gray-900 dark:text-white">Kembalian</dt>
                        <dd id="modal-kembalian" class="text-gray-700 dark:text-gray-300">Rp -</dd>
                    </dl>
                </div>

                <!-- Footer Buttons -->
                <div class="flex justify-between items-center pt-4 border-t dark:border-gray-700">
                    <button id="btnCetak"
                        class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5">
                        Cetak
                    </button>
                    <div class="flex gap-2">
                        <button id="btnEdit"
                            class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5">
                            Edit
                        </button>
                        <button id="btnHapus"
                            class="text-white bg-red-600 hover:bg-red-700 font-medium rounded-lg text-sm px-5 py-2.5">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        let currentTransaksiId = null;

        function showDetail(id) {
            currentTransaksiId = id; // simpan id saat ini

            fetch(`/transaksi/${id}/detail`)
                .then(response => response.json())
                .then(data => {
                    const transaksi = data.transaksi;

                    document.getElementById('modal-karyawan').textContent = transaksi.karyawan.nama_karyawan;
                    document.getElementById('modal-tanggal').textContent = new Date(transaksi.created_at)
                        .toLocaleString();
                    document.getElementById('modal-totalBayar').textContent = 'Rp ' + formatRupiah(transaksi
                        .total_bayar);
                    document.getElementById('modal-jumlahBayar').textContent = 'Rp ' + formatRupiah(transaksi
                        .jumlah_bayar);
                    document.getElementById('modal-kembalian').textContent = 'Rp ' + formatRupiah(transaksi.kembalian);

                    const itemsList = document.getElementById('modal-items');
                    itemsList.innerHTML = '';
                    data.items.forEach(item => {
                        itemsList.innerHTML += `
                    <li class="border rounded p-3 bg-gray-50 dark:bg-gray-700">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-900 dark:text-white">${item.nama_produk}</span>
                            <span class="text-sm text-gray-600 dark:text-gray-300">x${item.quantity}</span>
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Harga: Rp ${formatRupiah(item.harga)}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Subtotal: Rp ${formatRupiah(item.subtotal)}</div>
                    </li>
                `;
                    });

                    document.getElementById('readProductModal').classList.remove('hidden');
                });
        }

        document.getElementById('btnCetak').addEventListener('click', function() {
            if (currentTransaksiId) {
                window.open(`/transaksi/${currentTransaksiId}/print`, '_blank');
            }
        });

        function closeModal() {
            document.getElementById('readProductModal').classList.add('hidden');
        }

        function formatRupiah(angka) {
            return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    </script>


@endsection
