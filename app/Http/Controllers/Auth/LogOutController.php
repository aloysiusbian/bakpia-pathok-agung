<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * Proses logout pengguna
     */
    public function logout(Request $request)
    {
        // Hapus sesi login
        Auth::logout();

        // Hapus session & regenerate CSRF token agar aman
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect kembali ke halaman login
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}
