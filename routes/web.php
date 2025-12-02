<?php

use App\Http\Controllers\PemesananOfflineController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\PemesananOnlineController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\ProfileController;

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

    Route::get('/pemesananOnline', function () {
        return view('dashboard-admin.pemesananOnline');
    })->name('pemesanan.online');

      Route::get('/pemesananOffline', [PemesananOfflineController::class, 'create'])
        ->name('pemesanan.offline');

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

    Route::get('/edit-profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/edit-profil', [ProfileController::class, 'update'])->name('profile.update');

    // API untuk dropdown kabupaten
    Route::get('/api/regencies', [ProfileController::class, 'getRegencies'])->name('api.regencies');


        // --- FITUR KERANJANG (Updated) ---

    // 1. Lihat Keranjang (Menggunakan method index)
    Route::get('/keranjang', [KeranjangController::class, 'tampilKeranjang'])->name('keranjang.index');

    // 2. Tambah ke Keranjang

    Route::post('/keranjang/tambah', [KeranjangController::class, 'store'])->name('keranjang.store');

    // Route untuk logout pelanggan
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    // Route untuk melihat keranjang
    Route::get('/keranjang', [KeranjangController::class, 'tampilKeranjang'])->name('keranjang.index');

    // ✅ TAMBAHKAN ROUTE INI
    // Route untuk menghapus item dari keranjang
    Route::delete('/keranjang/{idKeranjang}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');



    // 5. Kosongkan Keranjang (Hapus Semua) - Method POST
    Route::post('/keranjang/kosongkan', [KeranjangController::class, 'clear'])->name('keranjang.clear');

    Route::patch('/keranjang/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');

    Route::post('/pembayaran', [PemesananOnlineController::class, 'checkout'])
        ->name('pembayaran.checkout');

    // 2) Dari halaman checkout -> simpan ke PemesananOnline
    Route::post('/pembayaran/process', [PemesananOnlineController::class, 'process'])
        ->name('pembayaran.process');

        // ========== BARU: CHECKOUT LANGSUNG DARI DETAIL PRODUK ==========
    Route::post('/pembayaran/produk', [PemesananOnlineController::class, 'checkoutProduk'])
        ->name('pembayaran.checkout.produk');

    Route::post('/pembayaran/produk/process', [PemesananOnlineController::class, 'processProduk'])
        ->name('pembayaran.process.produk');

    // 3) Halaman pembayaran QRIS (setelah process)
    Route::get('/pembayaran/qris/{nomorPesanan}', [PemesananOnlineController::class, 'qris'])
        ->name('pembayaran.qris');

    // 4) Halaman pembayaran Transfer Bank (setelah process)
    Route::get('/pembayaran/bank/{nomorPesanan}', [PemesananOnlineController::class, 'transfer'])
        ->name('pembayaran.bank');

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

Route::get('/dashboard-pelanggan', function () {
    return view('dashboard-pelanggan.dashboardPelanggan');
});
Route::get('/tes', function () {
    return view('dashboard-admin.dashboard');
});

Route::get('/lihat-profil', function () {
    return view('pages.profile');
});
Route::get('/riwayat', function () {
    return view('dashboard-pelanggan.riwayat');
});
Route::get('/lihatproduk', function () {
    return view('dashboard-admin.lihatproduk');
});
Route::get('/tambahproduk', function () {
    return view('dashboard-admin.tambah_produk');
});
Route::get('/pemesananonline', function () {
    return view('dashboard-admin.pemesananOnline');
});
Route::get('/testambahakun', function () {
    return view('dashboard-admin.tambah_admin');
});
Route::get('/teskelolaadmin', function () {
    return view('dashboard-admin.kelola_admin');
});
Route::get('/tambah-admin', function () {
    return view('dashboard-admin.tambah_admin');
});
Route::get('/kelola-admin', function () {
    return view('dashboard-admin.kelola_admin');
});
Route::get('/lihatproduk', function () {
    return view('dashboard-admin.lihatproduk');
});
Route::get('/pesanan-saya', function () {
    return view('pages.pesanansaya');
});

Route::get('/detailpesanan', function () {
    return view('pages.detailpesanan');
});
Route::get('/batalkanpesanan', function () {
    return view('pages.batalkanpesanan');
});

