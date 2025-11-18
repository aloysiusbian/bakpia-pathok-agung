<?php

use App\Http\Controllers\ProdukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeranjangController;

/*
|--------------------------------------------------------------------------
| Route Publik (Bisa diakses siapa saja)
|--------------------------------------------------------------------------
*/

Route::get('/', [ProdukController::class, 'index'])->name('pages.home');

Route::get('/produk/{produk}', [ProdukController::class, 'detailProduk'])->name('produk.show');


/*
|--------------------------------------------------------------------------
| Route Admin (Wajib login sebagai admin)
|--------------------------------------------------------------------------
|
| ✅ KITA TAMBAHKAN GRUP INI
| Route ini menggunakan middleware 'auth:admin'
|
*/
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Ini adalah route yang Anda panggil di LoginController
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route logout khusus untuk admin
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    Route::get('/pemesanan-online', function () {
        return view('pages.pemesanan_online');
    })->name('pemesanan.online');

    /*
    | Di sinilah Anda meletakkan route untuk mengelola produk
    | (sesuai use case diagram Anda: Tambah, Edit, Hapus Produk)
    |
    | Contoh:
    | Route::get('/produk', [ProdukController::class, 'adminIndex'])->name('produk.index');
    | Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    | Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    | Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    | Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
    | Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');
    */
});


/*
|--------------------------------------------------------------------------
| Route Pelanggan (Wajib login sebagai pelanggan)
|--------------------------------------------------------------------------
|
| middleware('auth') akan otomatis menggunakan guard 'web' (pelanggan)
|
*/
Route::middleware('auth')->group(function () {

        // --- FITUR KERANJANG (Updated) ---

    // 1. Lihat Keranjang (Menggunakan method index)
    Route::get('/keranjang', [KeranjangController::class, 'tampilKeranjang'])->name('keranjang.index');

    // 2. Tambah ke Keranjang
    Route::post('/keranjang/tambah', [KeranjangController::class, 'store'])->name('keranjang.store');

    // 3. Update Jumlah Barang (+/-) - Method PATCH
    Route::patch('/keranjang/update/{idKeranjang}', [KeranjangController::class, 'update'])->name('keranjang.update');

    // 4. Hapus Satu Item - Method DELETE
    Route::delete('/keranjang/hapus/{idKeranjang}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');

    // 5. Kosongkan Keranjang (Hapus Semua) - Method POST
    Route::post('/keranjang/kosongkan', [KeranjangController::class, 'clear'])->name('keranjang.clear');

});


/*
|--------------------------------------------------------------------------
| Route Tamu (Hanya bisa diakses yang BELUM login)
|--------------------------------------------------------------------------
|
| middleware('guest') akan otomatis menggunakan guard 'web' (pelanggan)
|
*/
Route::middleware('guest')->group(function () {
    // Route untuk menampilkan halaman login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    // Route untuk memproses login
    Route::post('/login', [LoginController::class, 'login']);

    // Route untuk menampilkan halaman register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    // Route untuk memproses register
    Route::post('/register', [RegisterController::class, 'register']);
});
// routes/web.php atau routes/admin.php
Route::get('/tambah_produk', [ProdukController::class, 'create'])->name('produk.create');
Route::post('/admin/produk', [ProdukController::class, 'store'])->name('produk.store');
Route::get('/pembayaran', function () {
    return view('pages.pembayaran');
});
Route::get('/qris', function () {
    return view('pages.qris');
});
Route::get('/bank', function () {
    return view('pages.bank');
});
Route::get('/testes', function () {
    return view('pages.dbPelanggan');
});
Route::get('/tes', function () {
    return view('pages.dashboard');
});
Route::get('/tesedit', function () {
    return view('pages.edit_profile');
});
Route::get('/teslihat', function () {
    return view('pages.profile');
});
Route::get('/tesriwayat', function () {
    return view('pages.riwayat');
});
Route::get('/teshapusadmin', function () {
    return view('pages.hapusproduk');
});
Route::get('/pelanggan/profile', [CustomerController::class, 'editProfile'])->name('pelanggan.editProfile');
Route::put('/pelanggan/profile', [CustomerController::class, 'updateProfile'])->name('pelanggan.updateProfile');
Route::get('/pelanggan/profile', [CustomerController::class, 'showProfile'])->name('pelanggan.showProfile');
