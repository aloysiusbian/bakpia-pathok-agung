<?php

use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('pages.home');
// });

Route::get('/', [ProdukController::class, 'index'])->name('pages.home');