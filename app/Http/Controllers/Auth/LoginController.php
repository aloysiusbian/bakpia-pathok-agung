<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pelanggan;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login pelanggan
     */
    public function login(Request $request)
    {
        // 🔍 Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 🔎 Cari pelanggan berdasarkan email
        $pelanggan = Pelanggan::where('email', $request->email)->first();

        // ✅ Verifikasi password
        if ($pelanggan && Hash::check($request->password, $pelanggan->password)) {
            Auth::login($pelanggan);

            // Regenerasi sesi untuk keamanan
            $request->session()->regenerate();

            // 🔁 Redirect ke dashboard
            return redirect()->route('pages.home')->with('success', 'Login berhasil!');
        }

        // ❌ Jika gagal
        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }
}