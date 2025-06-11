@extends('layouts.admin')
@section('title', 'kategori Produk')
@section('content')

    <div class="">




        <div class="flex justify-between items-center">
            <x-page-title title="Kategori Produk" />
            <x-breadcrumb :items="[['label' => 'Dashboard', 'url' => route('dashboard')], ['label' => 'Kategori Produk']]" />

        </div>

        <x-alert />

        <div class="flex flex-row w-full justify-between">
            <x-search name="search" placeholder="Cari Kategori..." />
            <x-add-button href="{{ route('kategori_produk.create') }}" label="Tambah Kategori" />
        </div>



        <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-2">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mb-2">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Nama Kategori
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                @php
                    $no = 1;
                @endphp
                <tbody>
                    @foreach ($kategoris as $kategori)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">

                            <td class="px-6 py-4">
                                {{ $loop->iteration + ($kategoris->currentPage() - 1) * $kategoris->perPage() }}
                            </td>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $kategori->nama }}
                            </th>


                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('kategori_produk.edit', $kategori->id) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>

                                <form action="{{ route('kategori_produk.destroy', $kategori->id) }}" method="post">
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

            {{ $kategoris->appends(['search' => request('search')])->links() }}
        </div>

    </div>

@endsection
