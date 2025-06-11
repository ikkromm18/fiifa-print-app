@extends('layouts.admin')
@section('title', 'Edit Produk')
@section('content')

    <div class="">

        <div class="flex justify-between items-center">
            <x-page-title title="Edit  Produk" />
            <x-breadcrumb :items="[
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Produk', 'url' => route('produk.index')],
                ['label' => 'Edit'],
            ]" />

        </div>


        <div class="max-w-4xl  mt-4">
            <form action="{{ route('produk.update', $produk->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-6">

                    <x-select name="kategori_produk_id" label="Pilih Kategori" :options="$kategories->pluck('nama', 'id')" :selected="old('kategori_produk_id', $produk->kategori_produk_id)" />

                    <x-input name="nama_produk" label="Nama Produk" type="text" value="{{ $produk->nama_produk }}" />


                    <x-input name="harga" label="Harga" type="number" value="{{ $produk->harga }}" />


                    <x-input name="stok" label="Jumlah Stok" type="number" value="{{ $produk->stok }}" />

                </div>

                <x-submit-button label="Update" />
            </form>
        </div>

    </div>

@endsection
