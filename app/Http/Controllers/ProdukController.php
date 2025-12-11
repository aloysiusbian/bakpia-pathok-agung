<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    // HOME (menampilkan produk + best seller)
    public function index()
    {
        $products = Produk::with(['detailTransaksiOffline', 'detailTransaksiOnline'])
            ->orderBy('idProduk', 'DESC')
            ->get();

        $bestSeller = $products
            ->filter(fn ($p) => $p->total_terjual > 0)
            ->sortByDesc('total_terjual')
            ->take(2);

        return view('pages.home', [
            'products' => $products,
            'bestSeller' => $bestSeller
        ]);
    }

    // HALAMAN ADMIN
    public function index2()
    {
        return view('dashboard-admin.lihatproduk', [
            'products' => Produk::orderBy('idProduk', 'DESC')->get()
        ]);
    }

    // DETAIL PRODUK
    public function detailProduk(Produk $produk)
    {
        $produksLainnya = Produk::where('idProduk', '!=', $produk->idProduk)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('pages.detail_produk', [
            'produk' => $produk,
            'produksLainnya' => $produksLainnya
        ]);
    }

    // FORM TAMBAH PRODUK
    public function create()
    {
        return view('pages.tambah_produk');
    }

    // SIMPAN PRODUK BARU
    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'nama_produk'       => 'required|string|max:255',
            'harga'             => 'required|integer|min:0',
            'stok'              => 'required|integer|min:0',
            'rating'            => 'nullable|numeric|min:0|max:5',
            'deskripsi_produk'  => 'required|string',
            'pilihan_jenis'     => 'nullable|string',
            'kategori'          => 'nullable|string',
            'gambar'            => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

      
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');

            // Nama file rapi: slug-nama_produk + timestamp + extension
            $namaBersih = Str::slug($validated['nama_produk']);
            $filename = $namaBersih . '-' . time() . '.' . $file->getClientOriginalExtension();

            // Simpan di storage/app/public/produk_images
            $gambarPath = $file->storeAs('produk_images', $filename, 'public');
        }

        // Simpan ke database
        Produk::create([
            'namaProduk'       => $validated['nama_produk'],
            'harga'            => $validated['harga'],
            'stok'             => $validated['stok'],
            'rating'           => $validated['rating'] ?? 5.0,
            'pilihanJenis'     => $validated['pilihan_jenis'] ?? null,
            'kategori'         => $validated['kategori'] ?? null,
            'deskripsiProduk'  => $validated['deskripsi_produk'],
            'gambar'           => $gambarPath,  // contoh: "produk_images/kopi-susu-1700000000.jpg"
        ]);

        return redirect('/dashboard')->with('success', 'Produk baru berhasil ditambahkan!');
    }
}
