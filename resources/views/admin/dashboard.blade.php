@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
    <div class="grid grid-cols-4 gap-2">
        <a href="#"
            class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
            </h5>
            <p class="font-normal text-gray-700 dark:text-gray-400">Total Pemasukan</p>
        </a>

        <a href="#"
            class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $jumlahTransaksi }}</h5>
            <p class="font-normal text-gray-700 dark:text-gray-400">Total Transaksi</p>
        </a>

        <a href="#"
            class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $jumlahStokMenipis }}</h5>
            <p class="font-normal text-gray-700 dark:text-gray-400">Stok Menipis</p>
        </a>

        <a href="#"
            class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $jumlahProduk }}</h5>
            <p class="font-normal text-gray-700 dark:text-gray-400">Jumlah Barang</p>
        </a>
    </div>

    {{-- Tabel Daftar Barang Stok Menipis --}}
    <div class="relative overflow-x-auto mt-4">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 rounded-s-lg">Nama Produk</th>
                    <th scope="col" class="px-6 py-3">Stok</th>
                    <th scope="col" class="px-6 py-3 rounded-e-lg">Harga</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stokMenipis as $produk)
                    <tr class="bg-white dark:bg-gray-800">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $produk->nama_produk }}
                        </th>
                        <td class="px-6 py-4">{{ $produk->stok }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-4 text-gray-500">Tidak ada barang dengan stok ≤ 5</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Grafik Penjualan Mingguan --}}
    <div class="mt-6 bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Grafik Penjualan Mingguan</h3>
        <canvas id="penjualanChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('penjualanChart').getContext('2d');
        const penjualanChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($penjualanMingguan->pluck('tanggal')->map(fn($t) => \Carbon\Carbon::parse($t)->format('d M'))) !!},
                datasets: [{
                    label: 'Total Penjualan',
                    data: {!! json_encode($penjualanMingguan->pluck('total')) !!},
                    borderColor: 'rgb(75, 192, 192)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
