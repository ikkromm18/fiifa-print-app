@extends('layouts.admin')
@section('title', 'Edit Karyawan')
@section('content')
    <div class="">
        <div class="flex justify-between items-center">
            <x-page-title title="Edit Karyawan" />
            <x-breadcrumb :items="[
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Karyawan', 'url' => route('karyawan.index')],
                ['label' => 'Edit'],
            ]" />
        </div>

        <div class="max-w-4xl mt-4">
            <form action="{{ route('karyawan.update', $karyawan->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-6">
                    <x-input name="nama_karyawan" label="Nama Karyawan" type="text"
                        value="{{ old('nama_karyawan', $karyawan->nama_karyawan) }}" />
                    <x-input name="alamat" label="Alamat" type="text" value="{{ old('alamat', $karyawan->alamat) }}" />
                    <x-input name="no_hp" label="No HP" type="text" value="{{ old('no_hp', $karyawan->no_hp) }}" />
                </div>
                <x-submit-button label="Update" />
            </form>
        </div>
    </div>
@endsection
