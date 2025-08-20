<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TransaksiItemController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
});

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');

    Route::post('/signin', [AuthController::class, 'signin'])->name('signin');
});

Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class)->only('index');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Index only (akses umum)
    Route::get('/kategori_produk', [KategoriProdukController::class, 'index'])->name('kategori_produk.index');
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');

    // Transaksi
    Route::resource('transaksi', TransaksiController::class)->only(['index', 'create', 'store']);
    Route::get('/transaksi/{id}/detail', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/{id}/print', [TransaksiController::class, 'print'])->name('transaksi.print');

    // Transaksi Item
    Route::resource('transaksi_item', TransaksiItemController::class)->except(['destroy']);

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/penjualan/pdf', [LaporanController::class, 'cetakPenjualan'])->name('laporan.penjualan.pdf');
    Route::get('/laporan/keuangan/pdf', [LaporanController::class, 'cetakKeuangan'])->name('laporan.keuangan.pdf');
    Route::get('/laporan/stok/pdf', [LaporanController::class, 'cetakStok'])->name('laporan.stok.pdf');
});


Route::middleware(['role:owner'])->group(function () {

    // Dalam group role:owner
    Route::resource('transaksi', TransaksiController::class)->only(['edit', 'update', 'destroy']);
    Route::resource('kategori_produk', KategoriProdukController::class)->except(['index', 'show']);
    Route::resource('produk', ProdukController::class)->except(['index', 'show']);
    Route::resource('karyawan', KaryawanController::class)->except(['index', 'show']);
    Route::resource('users', UserController::class)->except('index');
});

// index
// create
// store
// edit
// show
// update
// destroy