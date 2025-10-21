<?php

use Illuminate\Support\Facades\Route;

// contoh isi route tambahan
Route::get('/', function () {
    return view('auth.register');
});

Route::get('/halo', function () {
    return 'Halo dari Bertotes!';
});
