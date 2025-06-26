@extends('layouts.admin')
@section('title', 'Tambah Transaksi')

@section('content')
    <div class="w-full mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Form Tambah Transaksi</h2>

        @if ($errors->any())
            <div id="alert-2"
                class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                role="alert">
                <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div class="ms-3 text-sm font-medium">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
                <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-2" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif

        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf

            {{-- Karyawan --}}
            <div class="mb-4">
                <label for="karyawans_id" class="block mb-1 font-medium text-gray-700 dark:text-gray-200">Karyawan</label>
                <select name="karyawans_id" id="karyawans_id" required
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 dark:bg-gray-700 dark:text-white">
                    <option value="">Pilih Karyawan</option>
                    @foreach ($karyawans as $karyawan)
                        <option value="{{ $karyawan->id }}" {{ old('karyawans_id') == $karyawan->id ? 'selected' : '' }}>
                            {{ $karyawan->nama_karyawan }}
                        </option>
                    @endforeach
                </select>

            </div>

            {{-- Produk --}}
            <div id="produk-container" class="mb-4 space-y-4">
                @php
                    $oldProdukIds = old('produk_ids', [null]);
                    $oldQuantities = old('quantities', [1]);
                    $oldHargas = old('hargas', [null]);
                    $oldSubtotals = old('subtotals', [null]);
                @endphp

                @foreach ($oldProdukIds as $index => $oldProdukId)
                    <div class="produk-item grid grid-cols-4 gap-4 relative">
                        <!-- kolom produk -->
                        <div>
                            <label>Produk</label>
                            <select name="produk_ids[]" class="produk-select w-full rounded">
                                @foreach ($produks as $produk)
                                    <option value="{{ $produk->id }}" data-harga="{{ $produk->harga }}"
                                        {{ $oldProdukId == $produk->id ? 'selected' : '' }}>
                                        {{ $produk->nama_produk }} - Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- kolom qty -->
                        <div>
                            <label>Qty</label>
                            <input type="number" name="quantities[]" class="w-full rounded"
                                value="{{ $oldQuantities[$index] ?? 1 }}" min="1">
                        </div>

                        <!-- kolom harga -->
                        <div>
                            <label>Harga</label>
                            <input type="number" name="hargas[]" class="w-full rounded" readonly
                                value="{{ $oldHargas[$index] ?? '' }}">
                        </div>

                        <!-- kolom subtotal -->
                        <div>
                            <label>Subtotal</label>
                            <input type="number" name="subtotals[]" class="w-full rounded" readonly
                                value="{{ $oldSubtotals[$index] ?? '' }}">
                        </div>

                        <!-- Tombol Hapus -->
                        <button type="button" onclick="removeProduk(this)"
                            class="absolute -top-3 -right-3 bg-red-600 hover:bg-red-700 text-white rounded-full w-6 h-6 text-sm flex items-center justify-center z-10"
                            title="Hapus Produk">
                            &times;
                        </button>
                    </div>
                @endforeach
            </div>


            <button type="button" onclick="addProduk()"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">+
                Produk</button>

            {{-- Jumlah Bayar --}}
            <div class="mb-4">
                <label>Jumlah Bayar</label>
                <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="w-full border rounded p-2" required
                    value="{{ old('jumlah_bayar') }}">
            </div>

            {{-- Total Bayar + Kembalian --}}
            <div class="mb-4">
                <label>Total Bayar</label>
                <input type="number" name="total_bayar" id="total_bayar" class="w-full border rounded p-2" readonly
                    value="{{ old('total_bayar') }}">
            </div>

            <div class="mb-4">
                <label>Kembalian</label>
                <input type="number" name="kembalian" id="kembalian" class="w-full border rounded p-2" readonly
                    value="{{ old('kembalian') }}">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Simpan
                Transaksi</button>
        </form>
    </div>

    <!-- Tambahkan CSS Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            height: 42px;
            border-radius: 0.375rem;
            border: 1px solid #d1d5db;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 42px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
        }

        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 42px;
            user-select: none;
            -webkit-user-select: none;
        }

        .select2-container--default .select2-results__option--highlighted {
            background-color: #3b82f6;
            color: white;
        }
    </style>

    @include('admin.transaksi._form-js')
@endsection
