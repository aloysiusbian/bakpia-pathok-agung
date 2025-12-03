<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Produk;

class ProdukController extends Controller
{
    public function index()
    {
        $products = [
            'products'    => Produk::orderBy('idProduk', 'DESC')->get()
        ];
        return view('pages.home', $products);
    }

    public function index2()
    {
        $products = [
            'products'    => Produk::orderBy('idProduk', 'DESC')->get()
        ];
        return view('dashboard-admin.lihatproduk', $products);
    }
   
    public function detailProduk(Produk $produk)
    {
        $produksLainnya = Produk::where('idProduk', '!=', $produk->idProduk)
                                  ->inRandomOrder() // Tampilkan secara acak
                                  ->take(4)         // Ambil 4 produk saja
                                  ->get();

        // Kirim data produk yang dipilih dan produk lainnya ke view 'pages.detail'
        return view('pages.detail_produk', [
            'produk' => $produk,
            'produksLainnya' => $produksLainnya
        ]);
    }
    public function create()
    {
        // Pastikan nama view sesuai dengan lokasi file Anda (misal: 'pages.tambah_produk')
        return view('pages.tambah_produk'); 
    }


    public function store(Request $request)
    {
        // 1. Validasi Data
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'rating' => 'numeric|min:0|max:5',
            'deskripsi_produk' => 'required|string',
            'pilihan_jenis' => 'nullable|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        // 2. Upload Gambar
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('produk_images', 'public');
        }

        // 3. Simpan Data
        Produk::create([
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'rating' => $request->rating ?? 5.0,
            'pilihan_jenis' => $request->pilihan_jenis,
            'deskripsi_produk' => $request->deskripsi_produk,
            'gambar' => $gambarPath,
        ]);

        // Redirect ke dashboard atau halaman list produk (asumsi dashboard)
        return redirect('/dashboard')->with('success', 'Produk baru berhasil ditambahkan!');
    }
}