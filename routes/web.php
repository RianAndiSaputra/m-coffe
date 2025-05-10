<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return response('IT Solution');
// });

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard');

Route::get('/list-produk', function () {
    return view('dashboard.produk.produk');
})->name('list.produk');