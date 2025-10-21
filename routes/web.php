<?php

use App\Http\Controllers\ProdukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\keranjangController;

// Route::get('/', function () {
//     return view('pages.home');
// });

Route::get('/', [ProdukController::class, 'index'])->name('pages.home');

Route::get('/produk/{produk}', [ProdukController::class, 'detailProduk'])->name('produk.show');


Route::middleware('auth')->group(function () {
    // Route untuk menambahkan item ke keranjang
    Route::post('/keranjang/tambah', [KeranjangController::class, 'store'])->name('keranjang.store');
    
    // Route untuk logout
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    // Anda bisa menambahkan route lain yang butuh login di sini, contohnya:
    // Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    // Route::get('/dashboard', function() { return view('pages.dashboard'); })->name('dashboard');
});


// Route Grup untuk tamu (yang belum login)
Route::middleware('guest')->group(function () {
    // Route untuk menampilkan halaman login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    // Route untuk memproses login
    Route::post('/login', [LoginController::class, 'login']);

    // Route untuk menampilkan halaman register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    // Route untuk memproses register
    Route::post('/register', [RegisterController::class, 'register']);
<<<<<<< HEAD
});
=======
});
<<<<<<< HEAD
=======

Route::get('/dashboard', [DashboardController::class, 'index'])->name('pages.dashboard');

Route::get('/keranjang', function () {
    return view('pages.keranjang');
});

>>>>>>> 06e67e3584936a04978511c32fffe93a2f295973
>>>>>>> 29e06b4592f9e80444f67efc1fecf84a16a03f86
