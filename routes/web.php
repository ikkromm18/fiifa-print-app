<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
});


Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');

    Route::post('/signin', [AuthController::class, 'signin'])->name('signin');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/adminpage', function () {
        return view('admin.pageadmin');
    })->name('admin');
});


Route::middleware(['role:owner'])->group(function () {
    Route::get('/owner', function () {
        return view('admin.pageowner');
    })->name('owner');
});
