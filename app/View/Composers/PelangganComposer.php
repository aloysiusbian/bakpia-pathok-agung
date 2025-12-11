<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class PelangganComposer
{
    /**
     * Bind data Pelanggan ke view.
     */
    public function compose(View $view)
    {
        // 1. Ambil objek Pelanggan yang sedang login menggunakan Guard 'web'
        // Guard 'web' diasumsikan terhubung ke model Pelanggan (seperti yang kita konfigurasikan sebelumnya).
        $pelanggan = Auth::guard('web')->user();

        // 2. Jika pelanggan ditemukan, bind (ikat) objek tersebut ke semua view yang menggunakan composer ini.
        // Variabel ini akan tersedia di view sebagai $pelanggan.
        if ($pelanggan) {
            $view->with('pelanggan', $pelanggan);
        } else {
            // Jika tidak ada pelanggan, kirim null
            $view->with('pelanggan', null);
        }
    }
}
