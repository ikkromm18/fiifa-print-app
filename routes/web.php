<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
});


Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');

    Route::post('/signin', [AuthController::class, 'signin'])->name('signin');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/kategori_produk', [KategoriProdukController::class, 'index'])->name('kategori_produk.index');
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');


    Route::get('/adminpage', function () {
        return view('admin.pageadmin');
    })->name('admin');
});


Route::middleware(['role:owner'])->group(function () {
    Route::get('/owner', function () {
        return view('admin.pageowner');
    })->name('owner');

    Route::resource('kategori_produk', KategoriProdukController::class)->except(['index', 'show']);
    Route::resource('produk', ProdukController::class)->except(['index', 'show']);
    Route::resource('karyawan', KaryawanController::class)->except(['index', 'show']);
});
