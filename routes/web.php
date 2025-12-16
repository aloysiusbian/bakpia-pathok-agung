<?php

use App\Http\Controllers\PemesananOfflineController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PemesananOnlineController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChangePasswordController;

/*
|-------------------------------------------------------------------------- 
| Publik
|-------------------------------------------------------------------------- 
*/

Route::get('/', [ProdukController::class, 'index'])->name('pages.home');
Route::get('/produk/{produk}', [ProdukController::class, 'detailProduk'])->name('produk.show');

/*
|-------------------------------------------------------------------------- 
| Admin
|-------------------------------------------------------------------------- 
*/
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/kelola-admin', [AdminController::class, 'index'])->name('kelola.akun');
    Route::get('/tambah-admin', [AdminController::class, 'create'])->name('accounts.create');
    Route::post('/kelola-admin', [AdminController::class, 'store'])->name('accounts.store');
    Route::put('/kelola-admin/{idAdmin}', [AdminController::class, 'update'])->name('accounts.update');
    Route::delete('/kelola-admin/{idAdmin}', [AdminController::class, 'destroy'])->name('accounts.destroy');

    Route::get('/tambah-admin', fn() => view('dashboard-admin.tambah_admin'));
    // Route::get('/kelola-admin', fn() => view('dashboard-admin.kelola_admin'));

    Route::get('/ganti-sandi', [ChangePasswordController::class, 'edit1'])->name('password-admin.edit');
    Route::put('/ganti-sandi', [ChangePasswordController::class, 'update1'])->name('password-admin.update');

    Route::get('/edit-akun', [DashboardController::class, 'edit'])->name('akun-admin.edit');
    Route::put('/edit-akun', [DashboardController::class, 'update'])->name('akun-admin.update');

    Route::get('/lihatproduk', [ProdukController::class, 'lihat'])->name('lihat.produk');
    Route::get('/lihatproduk/tambah', [ProdukController::class, 'store'])->name('tambah.produk');
    // Route::get('/lihatproduk/edit', [ProdukController::class, 'update'])->name('edit.produk');

    Route::put('/admin/lihatproduk/{produk}/update', [ProdukController::class, 'update'])->name('produk.update');

    // ROUTE BARU UNTUK HAPUS (Menggunakan HTTP Method DELETE)
    // {produk} adalah Model Binding. Kita akan menggunakan ini untuk hapus produk.
    // PERHATIAN: Perhatikan URL ini, karena berbeda dengan yang Anda gunakan di script JS Anda sebelumnya.
    Route::delete('/admin/lihatproduk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    Route::get('/pemesananOnline', [PemesananOnlineController::class, 'index'])->name('pemesanan.online');
    Route::post('/pemesananOnline/{nomorPemesanan}/konfirmasi', [PemesananOnlineController::class, 'konfirmasiPembayaran'])->name('admin.pemesanan.online');

    Route::get('/pemesanan-offline', [PemesananOfflineController::class, 'index'])->name('pemesanan.offline.index');

// 2. Untuk membuka Form Tambah Pesanan (Create)
// URL saya bedakan jadi '/buat' agar tidak bentrok dengan index
    Route::get('/pemesanan-offline/buat', [PemesananOfflineController::class, 'create'])->name('pemesanan.offline.create');

// 3. Untuk Proses Simpan ke Database (Store)
// Method-nya POST
    Route::post('/pemesanan-offline', [PemesananOfflineController::class, 'store'])->name('pemesanan.offline.store');
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
| Pelanggan (login)
|-------------------------------------------------------------------------- 
*/
Route::middleware('auth:web')->group(function () {

    Route::get('/dashboard-pelanggan', [PemesananOnlineController::class, 'dashboard'])->name('dashboard.pelanggan');
    Route::get('/lihat-profil', [ProfileController::class, 'index'])->name('profile.lihat');
    Route::get('/edit-profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/edit-profil', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/ganti-password', [ChangePasswordController::class, 'edit'])->name('password-pelanggan.edit');
    Route::put('/ganti-password', [ChangePasswordController::class, 'update'])->name('password-pelanggan.update');

    Route::get('/riwayat-pemesanan', [PemesananOnlineController::class, 'riwayatTabel'])->name('riwayat.pemesanan');

    Route::post('/pesanan/upload-bukti/{nomorPemesanan}', [PemesananOnlineController::class, 'uploadBukti'])
        ->name('pembayaran.upload');

    Route::get('/pembayaran/sukses/{nomorPemesanan}', [PemesananOnlineController::class, 'pembayaranSukses'])
        ->name('pembayaran.sukses');

    Route::get('/api/regencies', [ProfileController::class, 'getRegencies'])->name('api.regencies');

    Route::get('/keranjang', [KeranjangController::class, 'tampilKeranjang'])->name('keranjang.index');
    Route::post('/keranjang/tambah', [KeranjangController::class, 'store'])->name('keranjang.store');
    Route::delete('/keranjang/{idKeranjang}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');
    Route::post('/keranjang/kosongkan', [KeranjangController::class, 'clear'])->name('keranjang.clear');
    Route::patch('/keranjang/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');

    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    Route::post('/pembayaran', [PemesananOnlineController::class, 'checkout'])->name('pembayaran.checkout');
    Route::post('/pembayaran/process', [PemesananOnlineController::class, 'process'])->name('pembayaran.process');

    Route::post('/pembayaran/produk', [PemesananOnlineController::class, 'checkoutProduk'])->name('pembayaran.checkout.produk');
    Route::post('/pembayaran/produk/process', [PemesananOnlineController::class, 'processProduk'])->name('pembayaran.process.produk');

    // DISAMAKAN param-nya jadi nomorPemesanan
    Route::get('/pembayaran/qris/{nomorPemesanan}', [PemesananOnlineController::class, 'qris'])->name('pembayaran.qris');
    Route::get('/pembayaran/bank/{nomorPemesanan}', [PemesananOnlineController::class, 'transfer'])->name('pembayaran.bank');

    Route::get('/pesanan-saya', [PemesananOnlineController::class, 'riwayat'])->name('pesanan.saya');
    Route::get('/pesanan/{nomorPemesanan}', [PemesananOnlineController::class, 'detail'])->name('pesanan.detail');
    // web.php
    Route::put('/pesanan/batal/{nomorPemesanan}', [PemesananOnlineController::class, 'batalkanPesanan'])->name('pesanan.batal');
});

/*
|-------------------------------------------------------------------------- 
| Guest (belum login)
|-------------------------------------------------------------------------- 
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

/*
|-------------------------------------------------------------------------- 
| Route tambahan (kalau masih dipakai)
|-------------------------------------------------------------------------- 
*/
Route::get('/tambah_produk', [ProdukController::class, 'create'])->name('produk.create');
Route::post('/admin/produk', [ProdukController::class, 'store'])->name('produk.store');
