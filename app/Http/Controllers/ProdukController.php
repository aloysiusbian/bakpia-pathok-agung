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
        // VALIDASI INPUT
        $request->validate([
            'nama_produk'      => 'required|string|max:100',
            'deskripsi'        => 'required|string',
            'jenis'            => 'required|string|max:3',
            'kategori'         => 'required|string|max:50',
            'harga'            => 'required|numeric|min:0',
            'stok'             => 'required|integer|min:0',
            'gambar'           => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // UPLOAD GAMBAR
        $gambarPath = $request->file('gambar')->store('produk_images', 'public');

        // SIMPAN DATA KE DATABASE
        Produk::create([
            'namaProduk'       => $request->nama_produk,
            'deskripsiProduk'  => $request->deskripsi,
            'pilihanJenis'     => strtoupper($request->jenis), // contoh: "KJ", "CK"
            'kategori'         => $request->kategori,
            'rating'           => 5.0, // rating default
            'harga'            => $request->harga,
            'stok'             => $request->stok,
            'gambar'           => $gambarPath,
        ]);

        return redirect('/admin/lihatproduk')->with('success', 'Produk berhasil ditambahkan!');
    }

    
}
