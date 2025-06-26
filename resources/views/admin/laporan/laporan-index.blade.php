@extends('layouts.admin')
@section('title', 'Laporan')
@section('content')


    <div class="flex justify-between items-center">
        <x-page-title title="Laporan" />
        <x-breadcrumb :items="[['label' => 'Dashboard', 'url' => route('dashboard')], ['label' => 'Laporan']]" />

    </div>

    <x-alert />



    <div class="mb-4">
        <form method="GET" action="{{ route('laporan.index') }}" class="flex gap-2 items-center">


            <div id="date-range-picker" date-rangepicker class="flex items-center">
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                    </div>

                    <input id="datepicker-range-start" name="from" type="from"
                        value="{{ \Carbon\Carbon::parse($from)->format('m/d/Y') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Select date end">
                </div>

                <span class="mx-4 text-gray-500">Ke</span>

                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                    </div>

                    <input id="datepicker-range-end" name="to" type="text"
                        value="{{ \Carbon\Carbon::parse($to)->format('m/d/Y') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Select date end">


                </div>
            </div>

            <div class="mt-2">

                <x-submit-button label="Tampilkan" />
            </div>
        </form>
    </div>

    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="tab-report" role="tablist">
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg text-blue-600 border-blue-600 active"
                    id="penjualan-tab" data-tabs-target="#penjualan" type="button" role="tab">Penjualan</button>
            </li>
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="keuangan-tab" data-tabs-target="#keuangan"
                    type="button" role="tab">Keuangan</button>
            </li>
            <li role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="stok-tab" data-tabs-target="#stok"
                    type="button" role="tab">Stok Barang</button>
            </li>
        </ul>
    </div>

    <div id="tab-content">
        <div id="penjualan" class="p-4 bg-white rounded-lg dark:bg-gray-800" role="tabpanel">


            <x-add-button href="{{ route('laporan.penjualan.pdf', ['from' => $from, 'to' => $to]) }}" label="Cetak PDF" />



            <div class="relative overflow-x-auto mt-4">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                No
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Tanggal
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Total Bayar
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penjualan as $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                <th class="px-6 py-4">
                                    {{ $loop->iteration }}
                                </th>
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y H:i') }}
                                </th>
                                <th class="px-6 py-4">
                                    {{ 'Rp ' . number_format($item->total_bayar, 0, ',', '.') }}
                                </th>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>


        </div>

        <div id="keuangan" class="hidden p-4 bg-white rounded-lg dark:bg-gray-800" role="tabpanel">


            <x-add-button href="{{ route('laporan.keuangan.pdf', ['from' => $from, 'to' => $to]) }}" label="Cetak PDF" />

            <p class="mt-4">Total Pemasukan: <strong>Rp {{ number_format($totalKeuangan, 0, ',', '.') }}</strong></p>
        </div>

        <div id="stok" class="hidden p-4 bg-white rounded-lg dark:bg-gray-800" role="tabpanel">



            <div class="flex flex-row w-full justify-between">
                <x-add-button href="{{ route('laporan.stok.pdf') }}" label="Cetak PDF" />
            </div>

            <div class="relative overflow-x-auto mt-4">
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
                                Total Bayar
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stok as $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                <th class="px-6 py-4">
                                    {{ $loop->iteration }}
                                </th>
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->nama_produk }}
                                </th>
                                <th class="px-6 py-4">
                                    {{ $item->stok }}
                                </th>

                            </tr>
                        @endforeach

                    </tbody>
                </table>


            </div>


        </div>
    </div>

    <script>
        document.querySelectorAll('[data-tabs-target]').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('#tab-content > div').forEach(tab => tab.classList.add('hidden'))
                document.querySelectorAll('#tab-report button').forEach(tab => {
                    tab.classList.remove('text-blue-600', 'border-blue-600', 'active')
                })
                const target = button.getAttribute('data-tabs-target')
                document.querySelector(target).classList.remove('hidden')
                button.classList.add('text-blue-600', 'border-blue-600', 'active')
            })
        })
    </script>

@endsection
