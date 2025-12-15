<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; // Diperlukan untuk validasi unique saat update

class AdminController extends Controller
{
    /**
     * Menampilkan daftar semua akun Admin. (Method index)
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 1. Ambil semua data Admin dari database
        $admins = Admin::paginate(10);

        // 2. Mengirim data ke view. 
        return view('dashboard-admin.kelola_admin', compact('admins'));
    }

    /**
     * Menampilkan form untuk registrasi akun admin baru (create).
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Menggunakan path view yang lebih jelas dan konsisten
        return view('dashboard-admin.tambah_admin');
    }

    /**
     * Menyimpan akun admin baru ke database. (store)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Validasi Data
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Mengubah 'unique:users' menjadi 'unique:admins' karena menggunakan Model Admin
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admin'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        try {
            // 2. Membuat Akun Admin
            $user = Admin::insert([
                'username' => $validatedData['name'], // Asumsi kolom nama adalah 'username'
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                // ... kolom lain
            ]);

            // 3. Redirect dengan Pesan Sukses
            return redirect('/admin/kelola-admin')
                // Menggunakan $validatedData['name'] karena $user->name mungkin tidak tersedia
                ->with('success', 'Akun admin **' . $validatedData['name'] . '** berhasil didaftarkan!');
        } catch (\Exception $e) {
            // 4. Redirect dengan Pesan Error
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mendaftarkan akun admin. Silakan coba lagi. Error: ' . $e->getMessage());
        }
    }

    /**
     * Memperbarui data akun Admin di database. (update)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Admin $admin)
    {
        // 1. Validasi Data
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Gunakan Rule::unique untuk mengabaikan email admin saat ini
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('admin', 'email')->ignore($admin->id)],
            // Password tidak wajib jika tidak ingin diubah
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        try {
            // 2. Memperbarui Akun Admin
            $admin->username = $validatedData['name'];
            $admin->email = $validatedData['email'];

            // Jika field password diisi, hash dan update password
            if (!empty($validatedData['password'])) {
                $admin->password = Hash::make($validatedData['password']);
            }
            // Tambahkan kolom lain yang mungkin diubah (misal: role, status)

            $admin->save();

            // 3. Redirect dengan Pesan Sukses
            return redirect('/admin/kelola-admin')
                ->with('success', 'Akun admin **' . $admin->username . '** berhasil diperbarui!');
        } catch (\Exception $e) {
            // 4. Redirect dengan Pesan Error
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui akun admin. Error: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus akun Admin dari database. (destroy)
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Admin $admin)
    {
        // Tambahkan pengecekan keamanan, misal: tidak boleh menghapus akun yang sedang login
        if (Auth::guard('admin')->id() === $admin->id) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        try {
            $name = $admin->username;
            $admin->delete();

            return redirect('/admin/kelola-admin')
                ->with('success', 'Akun admin **' . $name . '** berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus akun admin. Error: ' . $e->getMessage());
        }
    }
}
