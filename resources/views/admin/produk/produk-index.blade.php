@extends('layouts.admin')
@section('title', 'Produk')
@section('content')

    <div class="">




        <div class="flex justify-between items-center">
            <x-page-title title="Daftar Produk" />
            <x-breadcrumb :items="[['label' => 'Dashboard', 'url' => route('dashboard')], ['label' => 'Produk']]" />

        </div>

        <x-alert />

        <div class="flex flex-row w-full justify-between">
            <x-search name="search" placeholder="Cari Produk..." />
            <x-add-button href="{{ route('produk.create') }}" label="Tambah Produk" />
        </div>



        <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-2">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mb-2">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Kategori Produk
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Nama Produk
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Harga
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Stok
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($produks as $produk)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">

                            <td class="px-6 py-4">
                                {{ $loop->iteration + ($produks->currentPage() - 1) * $produks->perPage() }}
                            </td>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $produk->kategori_produks->nama }}
                            </th>

                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $produk->nama_produk }}
                            </th>

                            <td scope="row" class="px-6 py-4 text-gray-900">
                                {{ 'Rp ' . number_format($produk->harga, 0, ',', '.') }}
                            </td>

                            <td scope="row" class="px-6 py-4 text-gray-900">
                                {{ $produk->stok }}
                            </td>


                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('produk.edit', $produk->id) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>

                                <form action="{{ route('produk.destroy', $produk->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="font-medium text-red-600 dark:text-red-500 hover:underline">Hapus</button>

                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $produks->appends(['search' => request('search')])->links() }}
        </div>

    </div>

@endsection
