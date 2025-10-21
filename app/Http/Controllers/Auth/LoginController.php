<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pelanggan;
use App\Models\Admin; // ✅ 1. Import model Admin

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
     * Proses login (Admin atau Pelanggan)
     */
    public function login(Request $request)
    {
        // 🔍 Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // ✅ 2. Coba login sebagai ADMIN terlebih dahulu
        // Kita gunakan Auth::guard('admin')->attempt()
        // 'attempt' sudah otomatis melakukan Hash::check
        if (Auth::guard('admin')->attempt($credentials)) {
            
            // Regenerasi sesi untuk keamanan
            $request->session()->regenerate();

            // 🔁 Redirect ke dashboard ADMIN
            // Pastikan Anda punya route bernama 'admin.dashboard'
            return redirect()->route('admin.dashboard')->with('success', 'Login admin berhasil!');
        }

        // ⚠️ 3. Jika login admin GAGAL, coba login sebagai PELANGGAN
        // Kita gunakan Auth::guard('web')->attempt() atau Auth::attempt() (karena 'web' adalah default)
        else if (Auth::guard('web')->attempt($credentials)) {
            
            // Regenerasi sesi untuk keamanan
            $request->session()->regenerate();

            // 🔁 Redirect ke dashboard PELANGGAN
            return redirect()->route('pages.home')->with('success', 'Login berhasil!');
        }


        // ❌ 4. Jika KEDUANYA gagal
        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }
}