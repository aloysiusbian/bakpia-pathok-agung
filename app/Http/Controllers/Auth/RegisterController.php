<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Tampilkan halaman register
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Proses data registrasi
    public function register(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:pelanggan,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Simpan ke tabel pelanggan
        $pelanggan = Pelanggan::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'alamat' => '-', // nilai default
            'noTelp' => '-', // nilai default
        ]);

        // Login otomatis setelah register
        Auth::login($pelanggan);

        // Redirect ke dashboard
        return redirect()->route('pages.home')->with('success', 'Registrasi berhasil! Selamat datang.');
    }
}
