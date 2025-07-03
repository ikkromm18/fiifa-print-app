@extends('layouts.admin')
@section('title', 'Edit Akun')
@section('content')
    <div class="">
        <div class="flex justify-between items-center">
            <x-page-title title="Edit Akun" />
            <x-breadcrumb :items="[
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Akun', 'url' => route('users.index')],
                ['label' => 'Edit'],
            ]" />
        </div>

        <div class="max-w-4xl mt-4">
            <form action="{{ route('users.update', $user->id) }}" method="post">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-6">
                    <x-input name="name" label="Nama" type="text" value="{{ old('name', $user->name) }}" />
                    <x-input name="email" label="Email" type="email" value="{{ old('email', $user->email) }}" />

                    <x-input name="password" label="Password Baru (opsional)" type="password" />
                    <x-input name="password_confirmation" label="Konfirmasi Password Baru" type="password" />

                    <x-input name="current_password" label="Password Saat Ini (Wajib untuk menyimpan perubahan)"
                        type="password" required />
                </div>

                <x-submit-button label="Simpan Perubahan" />
            </form>
        </div>
    </div>
@endsection
