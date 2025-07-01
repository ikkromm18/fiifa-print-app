@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
    <div class="grid grid-cols-4 gap-2">
        <a href="#"
            class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <div class="flex justify-between items-center">
                <div class="">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                    </h5>
                    <p class="font-normal text-gray-700 dark:text-gray-400">Total Pemasukan</p>
                </div>
                <div class="bg-blue-600 p-3 rounded-lg"><svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#fff" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M7 6a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2h-2v-4a3 3 0 0 0-3-3H7V6Z"
                            clip-rule="evenodd" />
                        <path fill-rule="evenodd"
                            d="M2 11a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-7Zm7.5 1a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5Z"
                            clip-rule="evenodd" />
                        <path d="M10.5 14.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z" />
                    </svg>
                </div>
            </div>

        </a>

        <a href="#"
            class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <div class="flex justify-between items-center">
                <div class="">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $jumlahTransaksi }}
                    </h5>
                    <p class="font-normal text-gray-700 dark:text-gray-400">Total Transaksi</p>
                </div>

                <div class="bg-green-600 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="#fff" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M4 4a1 1 0 0 1 1-1h1.5a1 1 0 0 1 .979.796L7.939 6H19a1 1 0 0 1 .979 1.204l-1.25 6a1 1 0 0 1-.979.796H9.605l.208 1H17a3 3 0 1 1-2.83 2h-2.34a3 3 0 1 1-4.009-1.76L5.686 5H5a1 1 0 0 1-1-1Z"
                            clip-rule="evenodd" />
                    </svg>

                </div>
            </div>

        </a>

        <a href="#"
            class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

            <div class="flex justify-between items-center">
                <div class="">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ $jumlahStokMenipis }}</h5>
                    <p class="font-normal text-gray-700 dark:text-gray-400">Stok Menipis</p>
                </div>


                <div class="bg-red-600 p-3 rounded-lg"><svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#fff" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M11 16.5a5.5 5.5 0 1 1 11 0 5.5 5.5 0 0 1-11 0Zm4.5 2.5v-1.5H14v-2h1.5V14h2v1.5H19v2h-1.5V19h-2Z"
                            clip-rule="evenodd" />
                        <path d="M3.987 4A2 2 0 0 0 2 6v9a2 2 0 0 0 2 2h5v-2H4v-5h16V6a2 2 0 0 0-2-2H3.987Z" />
                        <path fill-rule="evenodd" d="M5 12a1 1 0 0 1 1-1h3a1 1 0 1 1 0 2H6a1 1 0 0 1-1-1Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>

        </a>

        <a href="#"
            class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <div class="flex justify-between items-center">
                <div class="">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $jumlahProduk }}
                    </h5>
                    <p class="font-normal text-gray-700 dark:text-gray-400">Jumlah Barang</p>

                </div>

                <div class="bg-amber-600 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="#fff" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M5.535 7.677c.313-.98.687-2.023.926-2.677H17.46c.253.63.646 1.64.977 2.61.166.487.312.953.416 1.347.11.42.148.675.148.779 0 .18-.032.355-.09.515-.06.161-.144.3-.243.412-.1.111-.21.192-.324.245a.809.809 0 0 1-.686 0 1.004 1.004 0 0 1-.324-.245c-.1-.112-.183-.25-.242-.412a1.473 1.473 0 0 1-.091-.515 1 1 0 1 0-2 0 1.4 1.4 0 0 1-.333.927.896.896 0 0 1-.667.323.896.896 0 0 1-.667-.323A1.401 1.401 0 0 1 13 9.736a1 1 0 1 0-2 0 1.4 1.4 0 0 1-.333.927.896.896 0 0 1-.667.323.896.896 0 0 1-.667-.323A1.4 1.4 0 0 1 9 9.74v-.008a1 1 0 0 0-2 .003v.008a1.504 1.504 0 0 1-.18.712 1.22 1.22 0 0 1-.146.209l-.007.007a1.01 1.01 0 0 1-.325.248.82.82 0 0 1-.316.08.973.973 0 0 1-.563-.256 1.224 1.224 0 0 1-.102-.103A1.518 1.518 0 0 1 5 9.724v-.006a2.543 2.543 0 0 1 .029-.207c.024-.132.06-.296.11-.49.098-.385.237-.85.395-1.344ZM4 12.112a3.521 3.521 0 0 1-1-2.376c0-.349.098-.8.202-1.208.112-.441.264-.95.428-1.46.327-1.024.715-2.104.958-2.767A1.985 1.985 0 0 1 6.456 3h11.01c.803 0 1.539.481 1.844 1.243.258.641.67 1.697 1.019 2.72a22.3 22.3 0 0 1 .457 1.487c.114.433.214.903.214 1.286 0 .412-.072.821-.214 1.207A3.288 3.288 0 0 1 20 12.16V19a2 2 0 0 1-2 2h-6a1 1 0 0 1-1-1v-4H8v4a1 1 0 0 1-1 1H6a2 2 0 0 1-2-2v-6.888ZM13 15a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-2Z"
                            clip-rule="evenodd" />
                    </svg>

                </div>
            </div>

        </a>
    </div>

    {{-- Tabel Daftar Barang Stok Menipis --}}
    <div class="relative overflow-x-auto mt-4">
        <h3 class="pl-4 text-lg font-semibold text-gray-800 dark:text-white mb-4">Daftar Stok Menipis</h3>
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
