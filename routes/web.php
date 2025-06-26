<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TransaksiItemController;
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

    Route::resource('transaksi', TransaksiController::class)->except(['show']);
    Route::resource('transaksi_item', TransaksiItemController::class)->except('destroy');

    Route::get('/transaksi/{id}/detail', [TransaksiController::class, 'show'])->name('transaksi.show');

    Route::get('/transaksi/{id}/print', [TransaksiController::class, 'print'])->name('transaksi.print');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/penjualan/pdf', [LaporanController::class, 'cetakPenjualan'])->name('laporan.penjualan.pdf');
    Route::get('/laporan/keuangan/pdf', [LaporanController::class, 'cetakKeuangan'])->name('laporan.keuangan.pdf');
    Route::get('/laporan/stok/pdf', [LaporanController::class, 'cetakStok'])->name('laporan.stok.pdf');

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
