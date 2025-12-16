<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\PemesananOnline;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class DashboardController extends Controller
{

    public function index()
    {
        $orders = PemesananOnline::with('pelanggan')
            ->orderByDesc('tanggalPemesanan')
            ->paginate(10);

        $summary = $this->calculateOrderSummary();

        return view('dashboard-admin.dashboard', compact('orders', 'summary'));
    }

    protected function calculateOrderSummary()
    {
        $today = Carbon::now()->toDateString();

        $totalToday = PemesananOnline::whereDate('tanggalPemesanan', $today)->count();

        $paidCount = PemesananOnline::where('statusPesanan', 'diproses')->count();
        $paidAmount = PemesananOnline::where('statusPesanan', 'diproses')->sum('totalNota');

        $pendingCount = PemesananOnline::where('statusPesanan', 'menunggu_pembayaran')->count();

        return [
            'total_today' => $totalToday,
            'paid_count' => $paidCount,
            'paid_amount' => $paidAmount,
            'pending_count' => $pendingCount,
        ];
    }

    public function DashAdmin()
    {
        // Mendapatkan objek model Admin dari Guard 'admin'
        $admin = Auth::guard('admin')->user();

        // Pastikan Anda meneruskan variabel $admin ke view
        return view('dashboard-admin.dashboard', compact('admin'));
    }

    /**
     * Menampilkan dashboard untuk Pelanggan yang terautentikasi (Guard 'web').
     */
    public function DashPelanggan()
    {
        // Mendapatkan objek model Pelanggan dari Guard 'web'
        $pelanggan = Auth::guard('web')->user();

        // Pastikan Anda meneruskan variabel $pelanggan ke view
        return view('dashboard-pelanggan.dashboardPelanggan', compact('pelanggan'));
    }

    public function edit()
    {
        /** @var Admin $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        return view('dashboard-admin.edit-profil-admin', [
            'user' => $user,
        ]);
    }

    public function update(Request $request)
    {
        /** @var Admin $user */
        $user = Auth::user();

        // Validasi (Tetap Sama)
        $request->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'email' => [
                'required', 'email',
                Rule::unique('admin', 'email')->ignore($user->idAdmin, 'idAdmin')
            ],
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'username' => 'required|string|max:255',
        ]);

        // 1. UPDATE PELANGGAN (Tetap pakai Model karena Pelanggan ada Modelnya)
        $user->email = $request->email;

        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');

            // Tentukan Nama File Unik
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Simpan File ke Disk 'public' di folder 'foto_profil'
            $path = $file->storeAs('foto_profil', $filename, 'public');

            // Hapus Foto Lama (jika ada)
            // Asumsikan path disimpan dalam kolom 'profile_photo_path' di tabel 'pelanggan'
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->image);
            }

            // Simpan path baru ke model user
            $user->image = $path;
        }

        $user->username = $request->username;

        $user->save();

        return redirect()
            ->route('admin.akun-admin.update')
            ->with('success', 'Akun berhasil diperbarui.');
    }
}
