<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PemesananOnline;

class PemesananOnlineController extends Controller
{
    /**
     * Menampilkan halaman daftar Pemesanan Online.
     * * @return \Illuminate\View\View
     */
    public function showPesananOnline()
    {
        return view('pages.pemesanan_online'); 
        
    }
}



