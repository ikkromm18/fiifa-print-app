@extends('layouts.admin')
@section('title', 'Tambah Karyawan')
@section('content')
    <div class="">
        <div class="flex justify-between items-center">
            <x-page-title title="Tambah Karyawan" />
            <x-breadcrumb :items="[
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Karyawan', 'url' => route('karyawan.index')],
                ['label' => 'Tambah'],
            ]" />
        </div>

        <div class="max-w-4xl mt-4">
            <form action="{{ route('karyawan.store') }}" method="post">
                @csrf
                <div class="grid grid-cols-2 gap-6">
                    <x-input name="nama_karyawan" label="Nama Karyawan" type="text" value="{{ old('nama_karyawan') }}" />
                    <x-input name="alamat" label="Alamat" type="text" value="{{ old('alamat') }}" />
                    <x-input name="no_hp" label="No HP" type="text" value="{{ old('no_hp') }}" />
                </div>
                <x-submit-button />
            </form>
        </div>
    </div>
@endsection
