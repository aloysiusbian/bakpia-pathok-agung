<?php

use App\Http\Controllers\ProdukController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('pages.home');
// });

Route::get('/', [ProdukController::class, 'index'])->name('pages.home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('pages.dashboard');

Route::get('/keranjang', function () {
    return view('pages.keranjang');
});
