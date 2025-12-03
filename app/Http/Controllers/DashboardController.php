<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class DashboardController extends Controller
{
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
}
