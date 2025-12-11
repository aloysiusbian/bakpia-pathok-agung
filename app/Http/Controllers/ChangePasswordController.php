<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ChangePasswordController extends Controller
{
    /**
     * Menampilkan form ganti password.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('dashboard-pelanggan.ganti-password');
    }

    /**
     * Memproses permintaan ganti password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            // Memeriksa apakah password lama yang dimasukkan sesuai dengan yang ada di DB
            'current_password' => ['required', 'string', 'current_password'],

            // Password baru harus wajib, string, minimal 8, dan harus dikonfirmasi
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // 2. Cek Tambahan (Opsional, tapi disarankan)
        // Pastikan password baru BUKAN password lama.
        if (Hash::check($request->password, $user->password)) {
            // Melemparkan error jika password baru sama dengan yang lama
            throw ValidationException::withMessages([
                'password' => ['Password baru tidak boleh sama dengan password lama.'],
            ]);
        }

        // 3. Update Password
        $user->password = Hash::make($request->password);
        $user->save();

        // 4. Logout User dari Sesi Lain (Opsional, untuk keamanan)
        // request()->session()->regenerate();

        // 5. Redirect dengan Pesan Sukses
        return redirect()->route('password-pelanggan.edit')->with('success', 'Password Anda berhasil diubah!');
    }

    /**
     * Menampilkan form ganti password.
     *
     * @return \Illuminate\View\View
     */
    public function edit1()
    {
        return view('dashboard-admin.ganti-sandi');
    }

    /**
     * Memproses permintaan ganti password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update1(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            // Memeriksa apakah password lama yang dimasukkan sesuai dengan yang ada di DB
            'current_password' => ['required', 'string', 'current_password'],

            // Password baru harus wajib, string, minimal 8, dan harus dikonfirmasi
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // 2. Cek Tambahan (Opsional, tapi disarankan)
        // Pastikan password baru BUKAN password lama.
        if (Hash::check($request->password, $user->password)) {
            // Melemparkan error jika password baru sama dengan yang lama
            throw ValidationException::withMessages([
                'password' => ['Password baru tidak boleh sama dengan password lama.'],
            ]);
        }

        // 3. Update Password
        $user->password = Hash::make($request->password);
        $user->save();

        // 4. Logout User dari Sesi Lain (Opsional, untuk keamanan)
        // request()->session()->regenerate();

        // 5. Redirect dengan Pesan Sukses
        return redirect()->route('admin.password-admin.edit')->with('success', 'Password Anda berhasil diubah!');
    }
}
