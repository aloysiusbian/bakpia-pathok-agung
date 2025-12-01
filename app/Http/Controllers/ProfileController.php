<?php

namespace App\Http\Controllers;  // <-- PASTIKAN INI, TANPA \Auth

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function edit()
    {
        /** @var Pelanggan $user */
        $user = Auth::user();

        if (!$user) {
            abort(401);
        }

        $primaryAddress = $user->alamat
            ? json_decode($user->alamat, true)
            : null;

        $provinsiJson = File::get(database_path('data/provinces.json'));
        $provinces = json_decode($provinsiJson, true);

        return view('pages.edit_profile', [
            'primaryAddress' => $primaryAddress,
            'provinces'      => $provinces,
        ]);
    }

    public function getRegencies(Request $request)
    {
        $provinceId = (int) $request->query('province_id');

        $regencyJson = File::get(database_path('data/regencies.json'));
        $regencies = json_decode($regencyJson, true);

        $filtered = array_values(array_filter($regencies, function ($reg) use ($provinceId) {
            return (int)$reg['province_id'] === $provinceId;
        }));

        return response()->json($filtered);
    }

    public function update(Request $request)
    {
        /** @var Pelanggan $user */
        $user = Auth::user();

        if (!$user) {
            abort(401);
        }

        $request->validate([
            'email'        => 'required|email',
            'noTelp'       => 'required|string|max:255',

            'address.namaPenerima'   => 'required|string|max:255',
            'address.noTelp'         => 'required|string|max:255',
            'address.labelAlamat'    => 'required|string|max:50',
            'address.provinsi_id'    => 'required|integer',
            'address.provinsi_nama'  => 'required|string',
            'address.kota_id'        => 'required|integer',
            'address.kota_nama'      => 'required|string',
            'address.kecamatan'      => 'required|string',
            'address.kodePos'        => 'required|string',
            'address.alamatLengkap'  => 'required|string',
            'address.catatanKurir'   => 'nullable|string',
            'address.isDefault'      => 'nullable',
        ]);

        $user->email  = $request->email;
        $user->noTelp = $request->noTelp;

        $addressData = $request->input('address', []);
        $addressData['isDefault'] = isset($addressData['isDefault']) ? 1 : 0;

        $user->alamat = json_encode($addressData);

        $user->save();

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
