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
}
