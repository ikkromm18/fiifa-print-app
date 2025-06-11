@extends('layouts.admin')
@section('title', 'Edit kategori Produk')
@section('content')

    <div class="">

        <div class="flex justify-between items-center">
            <x-page-title title="Edit Kategori Produk" />
            <x-breadcrumb :items="[
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Kategori Produk', 'url' => route('kategori_produk.index')],
                ['label' => 'Edit'],
            ]" />

        </div>


        <div class="max-w-sm mt-4">
            <form action="{{ route('kategori_produk.update', $kategori->id) }}" method="post">
                @csrf
                @method('PUT')
                <x-input name="nama" label="Nama Kategori" type="text" value="{{ $kategori->nama }}" />

                <x-submit-button label="Update" />
            </form>
        </div>

    </div>

@endsection
