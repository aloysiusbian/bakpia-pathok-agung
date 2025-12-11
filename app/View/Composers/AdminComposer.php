<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AdminComposer
{
    /**
     * Bind data ke view.
     */
    public function compose(View $view)
    {
        // 1. Ambil objek Admin yang sedang login menggunakan Guard 'admin'
        $admin = Auth::guard('admin')->user();

        // 2. Jika admin ditemukan, bind (ikat) objek tersebut ke semua view yang menggunakan composer ini.
        // Variabel ini akan tersedia di view sebagai $admin
        if ($admin) {
            $view->with('admin', $admin);
        } else {
            // Jika tidak ada admin, kirim null atau objek Admin baru yang kosong
            $view->with('admin', null);
        }
    }
}
