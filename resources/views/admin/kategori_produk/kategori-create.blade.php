@extends('layouts.admin')
@section('title', 'Tambah kategori Produk')
@section('content')

    <div class="">

        <div class="flex justify-between items-center">
            <x-page-title title="Tambah Kategori Produk" />
            <x-breadcrumb :items="[
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Kategori Produk', 'url' => route('kategori_produk.index')],
                ['label' => 'Tambah'],
            ]" />

        </div>


        <div class="max-w-sm mt-4">
            <form action="{{ route('kategori_produk.store') }}" method="post">
                @csrf
                <x-input name="nama" label="Nama Kategori" type="text" value="{{ old('nama') }}" />

                <x-submit-button />
            </form>
        </div>

    </div>

@endsection
