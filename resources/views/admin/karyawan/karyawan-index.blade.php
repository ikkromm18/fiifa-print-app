@extends('layouts.admin')
@section('title', 'Karyawan')
@section('content')

    <div class="">


        <div class="flex justify-between items-center">
            <x-page-title title="Daftar Karyawan" />
            <x-breadcrumb :items="[['label' => 'Dashboard', 'url' => route('dashboard')], ['label' => 'Karyawan']]" />

        </div>

        <x-alert />

        <div class="flex flex-row w-full justify-between">
            <x-search name="search" placeholder="Cari Karyawan..." />
            <x-add-button href="{{ route('karyawan.create') }}" label="Tambah Karyawan" />
        </div>



        <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-2">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mb-2">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Nama Karyawan
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Nomor HP
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Alamat
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($karyawans as $karyawan)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">

                            <td class="px-6 py-4">
                                {{ $loop->iteration + ($karyawans->currentPage() - 1) * $karyawans->perPage() }}
                            </td>

                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $karyawan->nama_karyawan }}
                            </th>

                            <td scope="row" class="px-6 py-4 text-gray-900">
                                {{ $karyawan->no_hp }}
                            </td>

                            <td scope="row" class="px-6 py-4 text-gray-900">
                                {{ $karyawan->alamat }}
                            </td>


                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('karyawan.edit', $karyawan->id) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>

                                <form action="{{ route('karyawan.destroy', $karyawan->id) }}" method="post">
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

            {{ $karyawans->appends(['search' => request('search')])->links() }}
        </div>

    </div>

@endsection
