@extends('layouts.admin')
@section('title', 'Tambah Produk')
@section('content')

    <div class="">

        <div class="flex justify-between items-center">
            <x-page-title title="Tambah  Produk" />
            <x-breadcrumb :items="[
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Produk', 'url' => route('produk.index')],
                ['label' => 'Tambah'],
            ]" />

        </div>


        <div class="max-w-4xl  mt-4">
            <form action="{{ route('produk.store') }}" method="post">
                @csrf
                <div class="grid grid-cols-2 gap-6">

                    <x-select name="kategori_produk_id" label="Pilih Kategori" :options="$kategories->pluck('nama', 'id')" :selected="old('kategori_id')" />

                    <x-input name="nama_produk" label="Nama Produk" type="text" value="{{ old('nama_produk') }}" />


                    <x-input name="harga" label="Harga" type="number" value="{{ old('harga') }}" />


                    <x-input name="stok" label="Jumlah Stok" type="number" value="{{ old('stok') }}" />

                </div>

                <x-submit-button />
            </form>
        </div>

    </div>

@endsection
