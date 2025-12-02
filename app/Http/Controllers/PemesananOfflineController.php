<?php

namespace App\Http\Controllers;

use App\Models\Produk;

class PemesananOfflineController extends Controller
{
    public function create()
    {
        $produk = Produk::select('idProduk','namaProduk','stok','harga','gambar')
    ->orderBy('namaProduk')
    ->get()
    ->map(function ($p) {
        $file = $p->gambar; // contoh: "bakpia-keju.jpg"

        return [
            'id'    => $p->idProduk,
            'nama'  => $p->namaProduk,
            'stok'  => (int) $p->stok,
            'harga' => (int) $p->harga,
            'gambar' => $file
                ? asset('images/' . ltrim($file, '/'))
                : asset('images/image.png'), // fallback, pilih salah satu yg ada
        ];
    });

        return view('dashboard-admin.pemesananOffline', compact('produk'));
    }
}



