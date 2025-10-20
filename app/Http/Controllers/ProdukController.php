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
}
