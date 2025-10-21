<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Keranjang; // ✅ Gunakan model yang benar
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid; // ✅ Diperlukan untuk generate UUID

class KeranjangController extends Controller
{
    /**
     * Menampilkan halaman keranjang belanja milik pengguna.
     */
    public function tampilKeranjang()
    {
        $idPelanggan = Auth::user()->idPelanggan;

        // Ambil item keranjang, dan sertakan data produk terkait (Eager Loading)
        $items = Keranjang::where('idPelanggan', $idPelanggan)->with('produk')->get();

        return view('pages.keranjang', compact('items'));
    }


    /**
     * Menambahkan atau memperbarui produk di keranjang.
     */
    public function store(Request $request)
    {
        // 1. Validasi input (gunakan 'jumlahBarang' agar konsisten)
        $request->validate([
            'idProduk' => 'required|exists:produk,idProduk',
            'jumlahBarang' => 'required|integer|min:1',
        ]);

        // 2. Ambil data yang diperlukan
        $produk = Produk::find($request->idProduk);
        $idPelanggan = Auth::user()->idPelanggan; // Ambil PK dari model Pelanggan
        $jumlahBarang = $request->jumlahBarang;

        // 3. Validasi stok di server (SANGAT PENTING)
        if ($produk->stok < $jumlahBarang) {
            return back()->with('error', 'Stok produk tidak mencukupi.');
        }

        // 4. Siapkan data untuk dikirim ke model
        $data = [
            'idPelanggan'  => $idPelanggan,
            'idProduk'     => $produk->idProduk,
            'jumlahBarang' => $jumlahBarang,
            'subTotal'     => $produk->harga * $jumlahBarang, // ✅ Hitung subtotal
        ];

        // 5. Panggil method static dari Model untuk menjalankan logika
        Keranjang::tambahKeKeranjang($data);
        
        // 6. Redirect kembali dengan pesan sukses
        return redirect()->route('keranjang.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }


    /**
     * Menghapus satu item dari keranjang.
     */
    public function destroy($idKeranjang)
    {
        // Opsi keamanan: Pastikan item yang akan dihapus milik user yang sedang login
        $item = Keranjang::find($idKeranjang);
        if ($item && $item->idPelanggan == Auth::user()->idPelanggan) {
            Keranjang::hapusDariKeranjang($idKeranjang);
            return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
        }

        return back()->with('error', 'Gagal menghapus produk dari keranjang.');
    }
}
