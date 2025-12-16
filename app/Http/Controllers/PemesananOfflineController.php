<?php

namespace App\Http\Controllers;

use App\Models\PemesananOffline;
use App\Models\DetailTransaksiOffline;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PemesananOfflineController extends Controller
{
    // ==========================================================
    // 1. INDEX: Untuk Menampilkan Tabel Riwayat (List)
    // ==========================================================
    public function index()
    {
        // Ambil data pesanan, urutkan dari yang terbaru
        $pesanan = PemesananOffline::orderByDesc('tanggalPemesanan')
            ->paginate(10);

        // Pastikan nama file view-nya benar: 'lihatPemesananOffline.blade.php'
        return view('dashboard-admin.lihatPemesananOffline', compact('pesanan'));
    }

    // ==========================================================
    // 2. CREATE: Untuk Menampilkan Form Input (Tambah)
    // ==========================================================
    public function create()
    {
        $produk = Produk::select('idProduk','namaProduk','stok','harga','gambar')
            ->orderBy('namaProduk')
            ->get()
            ->map(function ($p) {
                // Logika gambar
                $file = $p->gambar;
                $imageUrl = asset('images/image.png'); // Default

                if ($file) {
                    if (file_exists(public_path('storage/' . $file))) {
                        $imageUrl = asset('storage/' . $file);
                    } else {
                        $imageUrl = asset('images/' . ltrim($file, '/'));
                    }
                }

                return [
                    'id'    => $p->idProduk,
                    'nama'  => $p->namaProduk,
                    'stok'  => (int) $p->stok,
                    'harga' => (int) $p->harga,
                    'gambar' => $imageUrl,
                ];
            });

        // PERHATIKAN: Panggil view FORMULIR, bukan view Tabel
        // Pastikan nama file view form-nya: 'pemesananOffline.blade.php'
        return view('dashboard-admin.pemesananOffline', compact('produk'));
    }

    // ==========================================================
    // 3. STORE: Untuk Menyimpan Data ke Database
    // ==========================================================
    public function store(Request $request)
    {
        $request->validate([
            'namaPelanggan'    => 'required|string',
            'noTelpPelanggan'  => 'required|string',
            'sumberPesanan'    => 'nullable|string',
            'catatan'          => 'nullable|string',
            'alamatPengirim'   => 'required|string',
            'tanggalPemesanan' => 'required|date',
            'metodePembayaran' => 'required|string',
            'discountPerNota'  => 'nullable|numeric|min:0|max:100',
            
            'produk'           => 'required|array',
            'produk.*'         => 'exists:produk,idProduk',
            'jumlah'           => 'required|array',
            'jumlah.*'         => 'integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            // A. Hitung Total Tagihan (Hanya Variabel Sementara)
            $totalTagihan = 0; 
            $details = [];

            foreach ($request->produk as $key => $idProduk) {
                $qty = $request->jumlah[$key];
                $produkDB = Produk::lockForUpdate()->find($idProduk);

                if (!$produkDB || $produkDB->stok < $qty) {
                    throw new \Exception("Stok {$produkDB->namaProduk} kurang!");
                }

                $subTotalItem = $produkDB->harga * $qty;
                $totalTagihan += $subTotalItem; // Kita butuh ini buat hitung diskon nanti

                $details[] = [
                    'produk' => $produkDB,
                    'qty' => $qty,
                    'sub' => $subTotalItem // <--- INI MASUK KE DETAIL (SUB)
                ];
            }

            // B. Hitung Diskon & Total Nota
            $inputDiskon = $request->discountPerNota ?? 0;
            $diskonDb = $inputDiskon / 100;

            $potonganHarga = $totalTagihan * $diskonDb;
            $totalNota = $totalTagihan - $potonganHarga; // Ini Net yang disimpan

            // C. Simpan Header (TANPA totalTagihan)
            $uuidPenjualan = (string) Str::uuid();

            PemesananOffline::create([
                'idPenjualan'      => $uuidPenjualan,
                'namaPelanggan'    => $request->namaPelanggan,
                'noTelpPelanggan'  => $request->noTelpPelanggan,
                'sumberPesanan'    => $request->sumberPesanan,
                'catatan'          => $request->catatan,
                'alamatPengirim'   => $request->alamatPengirim,
                'tanggalPemesanan' => $request->tanggalPemesanan,
                'metodePembayaran' => $request->metodePembayaran,
                
                // 'totalTagihan' => $totalTagihan, <--- HAPUS BARIS INI
                'discountPerNota'  => $diskonDb,
                'totalNota'        => $totalNota, // Simpan hasil akhir saja
            ]);

            // D. Simpan Detail
            foreach ($details as $det) {
                DetailTransaksiOffline::create([
                    'idPenjualan'       => $uuidPenjualan,
                    'idProduk'          => $det['produk']->idProduk,
                    'jumlahBarang'      => $det['qty'],
                    'hargaTransaksi'    => $det['produk']->harga,
                    'discountPerProduk' => 0,
                    'sub'               => $det['sub'], // <--- SUB SUDAH DISIMPAN DI SINI
                ]);

                $det['produk']->decrement('stok', $det['qty']);
            }

            DB::commit();
            // Langsung tulis URL-nya di dalam kurung redirect()
            return redirect('/admin/pemesanan-offline')->with('success', 'Transaksi Berhasil Disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}