<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk; // Pastikan model Produk di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    /**
     * Menampilkan daftar isi keranjang belanja user saat ini.
     */
    public function tampilKeranjang()
    {
        // Ambil ID user yang sedang login
        $idPelanggan = Auth::id();

        // Panggil method static dari Model Keranjang
        $items = Keranjang::getKeranjang($idPelanggan);

        // Hitung Grand Total (Total belanja keseluruhan)
        $grandTotal = $items->sum('subTotal');

        return view('pages.keranjang', compact('items', 'grandTotal'));
    }

    /**
     * Menambahkan produk ke keranjang.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'idProduk' => 'required|exists:produk,idProduk', // Pastikan tabel produk & kolom ID sesuai
            'jumlahBarang' => 'required|integer|min:1',
        ]);

        // 2. Ambil data user dan produk
        $idPelanggan = Auth::id();
        $produk = Produk::findOrFail($request->idProduk);

        // 3. Hitung Subtotal (Harga x Jumlah)
        // Penting: Hitung di server, jangan ambil harga dari input form untuk keamanan
        $subTotal = $produk->harga * $request->jumlahBarang;

        // 4. Siapkan array data sesuai $fillable di Model
        $data = [
            'idPelanggan'  => $idPelanggan,
            'idProduk'     => $produk->idProduk,
            'jumlahBarang' => $request->jumlahBarang,
            'subTotal'     => $subTotal,
            'gambar'       => $produk->gambar, // Asumsi kolom gambar ada di tabel produk
        ];

        // 5. Panggil fungsi static custom Anda
        Keranjang::tambahKeKeranjang($data);

        return redirect()->route('keranjang.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Menghapus satu item spesifik dari keranjang.
     */
    public function destroy($idKeranjang)
    {
        // Panggil fungsi static hapusDariKeranjang
        Keranjang::hapusDariKeranjang($idKeranjang);

        return redirect()->back()->with('success', 'Item berhasil dihapus.');
    }

    /**
     * Mengosongkan seluruh keranjang belanja user.
     */
    public function clear()
    {
        $idPelanggan = Auth::id();
        
        // Panggil fungsi static hapusKeranjang
        Keranjang::hapusKeranjang($idPelanggan);

        return redirect()->back()->with('success', 'Keranjang berhasil dikosongkan.');
    }
    
    /**
     * (Opsional) Update jumlah barang langsung dari halaman keranjang
     * Misal: Tombol (+) atau (-)
     */
    public function update(Request $request, $idKeranjang)
    {
        $request->validate([
            'jumlahBarang' => 'required|integer|min:1'
        ]);

        $item = Keranjang::where('idKeranjang', $idKeranjang)->firstOrFail();
        
        // Ambil harga terbaru produk untuk update subtotal
        $hargaProduk = $item->produk->harga; 

        $item->jumlahBarang = $request->jumlahBarang;
        $item->subTotal = $hargaProduk * $request->jumlahBarang;
        $item->save();

        return redirect()->back()->with('success', 'Jumlah barang diperbarui.');
    }
}