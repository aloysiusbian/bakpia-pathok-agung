<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\DetailTransaksiOnline; // <-- GANTI: Gunakan model Keranjang dari database
use Illuminate\Support\Facades\Auth; // <-- BARU: Diperlukan untuk mendapatkan info user yang login

class KeranjangController extends Controller
{
    /**
     * Menambahkan atau memperbarui produk di keranjang database.
     */
    public function store(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            'idProduk' => 'required|exists:produk,idProduk',
            'kuantitas' => 'required|integer|min:1',
        ]);

        // BARU: Pastikan pengguna sudah login sebelum menambahkan ke keranjang
        if (!Auth::check()) {
            // Jika belum login, arahkan ke halaman login
            return redirect()->route('login')->with('error', 'Anda harus login untuk menambahkan produk ke keranjang.');
        }

        $idProduk = $request->input('idProduk');
        $kuantitas = $request->input('kuantitas');
        $produk = Produk::find($idProduk);
        $userId = Auth::id(); // Dapatkan ID dari pengguna yang sedang login

        // 2. Validasi stok di server (SANGAT PENTING)
        if ($produk->stok < $kuantitas) {
            // Jika stok tidak mencukupi, kembalikan ke halaman sebelumnya dengan error
            return back()->with('error', 'Stok produk tidak mencukupi.');
        }

        // 3. GANTI: Logika untuk menyimpan ke database, bukan session
        // Cek apakah produk ini sudah ada di keranjang milik user ini
        $itemKeranjang = Keranjang::where('idPelanggan', $userId)
                                  ->where('idProduk', $idProduk)
                                  ->first();

        if ($itemKeranjang) {
            // Jika produk sudah ada di keranjang, cukup tambahkan kuantitasnya
            $itemKeranjang->kuantitas += $kuantitas;
            $itemKeranjang->save();
        } else {
            // Jika produk belum ada, buat baris data baru di tabel 'keranjangs'
            Keranjang::create([
                'user_id' => $userId,
                'idProduk' => $idProduk,
                'kuantitas' => $kuantitas,
            ]);
        }
        
        // 4. Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function tampilKeranjang()
    {
        return view('pages.keranjang');
    }
}