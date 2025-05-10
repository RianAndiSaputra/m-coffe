<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return response('IT Solution');
// });

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
})->name('dashboard');

Route::get('/outlet', function () {
    return view('dashboard.outlet.daftar-outlet');
})->name('outlet');

Route::get('/list-produk', function () {
    return view('dashboard.produk.produk');
})->name('list.produk');

Route::get('/member', function () {
    return view('dashboard.user.member');
})->name('dashboard.user.member');

Route::get('/kategori', function () {
    return view('dashboard.produk.kategori-produk');
})->name('kategori');

Route::get('/riwayat-stok', function () {
    return view('dashboard.stok.riwayat-stock');
})->name('kategori');
