@extends('layouts.admin')
@section('title', 'Tambah Akun')
@section('content')
    <div class="">
        <div class="flex justify-between items-center">
            <x-page-title title="Tambah Akun" />
            <x-breadcrumb :items="[
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Akun', 'url' => route('users.index')],
                ['label' => 'Tambah'],
            ]" />
        </div>

        <div class="max-w-4xl mt-4">
            <form action="{{ route('users.store') }}" method="post">
                @csrf
                <div class="grid grid-cols-2 gap-6">
                    <x-input name="name" label="Nama" type="text" value="{{ old('name') }}" />
                    <x-input name="email" label="Email" type="email" value="{{ old('email') }}" />
                    <x-input name="password" label="Password" type="password" />
                    <x-input name="password_confirmation" label="Konfirmasi Password" type="password" />
                </div>
                <x-submit-button />
            </form>
        </div>
    </div>
@endsection
