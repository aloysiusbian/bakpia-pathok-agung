<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// <--- WAJIB TAMBAHKAN INI
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        /** @var \App\Models\Pelanggan $user */
        $user = Auth::user();

        // Ambil alamat utama dari database menggunakan Query Builder
        $address = DB::table('alamat')
            ->where('idPelanggan', $user->idPelanggan)
            ->where('is_utama', true)
            ->first();

        // Kirim data user dan address ke view
        return view('dashboard-pelanggan.profile', [ // Sesuaikan nama file view Anda
            'user' => $user,
            'address' => $address
        ]);
    }

    public function edit()
    {
        /** @var Pelanggan $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // --- CARA MANUAL (QUERY BUILDER) ---
        // Kita cari langsung ke tabel 'alamat' berdasarkan idPelanggan user
        $primaryAddress = DB::table('alamat')
            ->where('idPelanggan', $user->idPelanggan)
            ->where('is_utama', true)
            ->first(); // Hasilnya adalah object stdClass, bukan Model

        // Fallback: Jika tidak ada alamat utama, ambil satu alamat apa saja
        if (!$primaryAddress) {
            $primaryAddress = DB::table('alamat')
                ->where('idPelanggan', $user->idPelanggan)
                ->orderByDesc('created_at')
                ->first();
        }

        $provinces = Cache::remember('data_provinces', 1440, function () {
            return json_decode(File::get(database_path('data/provinces.json')), true);
        });

        return view('dashboard-pelanggan.edit_profile', [
            'user' => $user,
            'primaryAddress' => $primaryAddress, // Object biasa, aksesnya sama: $primaryAddress->kota_nama
            'provinces' => $provinces,
        ]);
    }

    public function getRegencies(Request $request)
    {
        $provinceId = (int)$request->query('province_id');

        if (!$provinceId) {
            return response()->json([]);
        }

        // Cache data kabupaten agar cepat
        $regencies = Cache::remember('data_regencies', 1440, function () {
            $json = File::get(database_path('data/regencies.json'));
            return json_decode($json, true);
        });

        // Filter array berdasarkan province_id
        $filtered = array_values(array_filter($regencies, function ($reg) use ($provinceId) {
            return (int)$reg['province_id'] === $provinceId;
        }));

        return response()->json($filtered);
    }

    public function update(Request $request)
    {
        /** @var Pelanggan $user */
        $user = Auth::user();

        // Validasi (Tetap Sama)
        $request->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'email' => [
                'required', 'email',
                Rule::unique('pelanggan', 'email')->ignore($user->idPelanggan, 'idPelanggan')
            ],

            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'noTelp' => 'required|string|max:20',
            // Validasi Address
            'address.namaPenerima' => 'required|string|max:255',
            'address.noTelp' => 'required|string|max:20',
            'address.labelAlamat' => 'required|string|max:50',
            'address.provinsi_id' => 'required|integer',
            'address.provinsi_nama' => 'required|string',
            'address.kota_id' => 'required|integer',
            'address.kota_nama' => 'required|string',
            'address.kecamatan' => 'required|string',
            'address.kodePos' => 'required|string',
            'address.alamatLengkap' => 'required|string',
        ]);

        // 1. UPDATE PELANGGAN (Tetap pakai Model karena Pelanggan ada Modelnya)
        $user->email = $request->email;
        $user->noTelp = $request->noTelp;

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

        $user->save();

        // 2. UPDATE / INSERT ALAMAT (PAKAI DB FACADE)

        // Siapkan data untuk disimpan
        $dataAlamat = [
            // Kolom target => Nilai dari form
            'judul_alamat' => $request->input('address.labelAlamat'),
            'nama_penerima' => $request->input('address.namaPenerima'),
            'no_telp_penerima' => $request->input('address.noTelp'),
            'provinsi_id' => $request->input('address.provinsi_id'),
            'provinsi_nama' => $request->input('address.provinsi_nama'),
            'kota_id' => $request->input('address.kota_id'),
            'kota_nama' => $request->input('address.kota_nama'),
            'kecamatan' => $request->input('address.kecamatan'),
            'alamat_lengkap' => $request->input('address.alamatLengkap'),
            'kode_pos' => $request->input('address.kodePos'),
            'catatan_kurir' => $request->input('address.catatanKurir'),
            'is_utama' => true,
            'updated_at' => now(), // Manual update timestamp
        ];

        // Gunakan updateOrInsert
        // Parameter 1: Kondisi pencarian (WHERE ...)
        // Parameter 2: Data yang mau diupdate/insert

        DB::table('alamat')->updateOrInsert(
            [
                'idPelanggan' => $user->idPelanggan,
                'is_utama' => true
            ],
            array_merge($dataAlamat, ['created_at' => now()])
        // Catatan: created_at hanya akan terisi jika INSERT,
        // tapi DB::table agak tricky dengan timestamp,
        // biasanya orang memisahkan logika insert/update jika butuh created_at akurat.
        );

        // *Alternatif lebih rapi untuk timestamp created_at jika data baru:*
        // Anda bisa cek dulu pakai ->exists(), lalu pilih ->insert() atau ->update() manual.

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
