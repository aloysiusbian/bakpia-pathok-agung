<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    /**
     * Menampilkan daftar isi keranjang belanja user saat ini.
     */
    public function tampilKeranjang()
    {
        $idPelanggan = Auth::user()->idPelanggan;

        $items = Keranjang::getKeranjang($idPelanggan);

        $grandTotal = $items->sum('subTotal');

        return view('pages.keranjang', compact('items', 'grandTotal'));
    }

    /**
     * Menambahkan produk ke keranjang.
     */
    public function store(Request $request)
    {
        $request->validate([
            'idProduk'     => 'required|exists:produk,idProduk',
            'jumlahBarang' => 'required|integer|min:1',
        ]);

        $idPelanggan = Auth::user()->idPelanggan;
        $produk      = Produk::findOrFail($request->idProduk);

        $subTotal = $produk->harga * $request->jumlahBarang;

        $data = [
            'idPelanggan'  => $idPelanggan,
            'idProduk'     => $produk->idProduk,
            'jumlahBarang' => $request->jumlahBarang,
            'subTotal'     => $subTotal,
            'gambar'       => $produk->gambar,
        ];

        Keranjang::tambahKeKeranjang($data);

        return redirect()
            ->route('keranjang.index')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Menghapus satu item spesifik dari keranjang.
     */
    public function destroy($idKeranjang)
    {
        $idPelanggan = Auth::user()->idPelanggan;

        Keranjang::hapusDariKeranjang($idKeranjang, $idPelanggan);

        return redirect()
            ->back()
            ->with('success', 'Item berhasil dihapus.');
    }

    /**
     * Mengosongkan seluruh keranjang belanja user.
     */
    public function clear()
    {
        $idPelanggan = Auth::user()->idPelanggan;
        
        Keranjang::hapusKeranjang($idPelanggan);

        return redirect()
            ->back()
            ->with('success', 'Keranjang berhasil dikosongkan.');
    }
    
    /**
     * Update jumlah barang langsung dari halaman keranjang (+ / -)
     */
    public function update(Request $request, $id)
    {
        $idPelanggan = Auth::user()->idPelanggan;

        $keranjang = Keranjang::with('produk')
            ->where('idKeranjang', $id)
            ->where('idPelanggan', $idPelanggan)
            ->first();

        if (!$keranjang) {
            return redirect()
                ->back()
                ->with('error', 'Item tidak ditemukan.');
        }

        $jumlahBarang = (int) $request->input('jumlahBarang');

        if ($jumlahBarang < 1) {
            return redirect()
                ->back()
                ->with('error', 'Jumlah minimal 1.');
        }

        $hargaProduk  = $keranjang->produk->harga;
        $subTotalBaru = $hargaProduk * $jumlahBarang;

        $keranjang->update([
            'jumlahBarang' => $jumlahBarang,
            'subTotal'     => $subTotalBaru,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Keranjang diperbarui.');
    }
}
