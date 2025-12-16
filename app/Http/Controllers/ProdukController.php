<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Exception; // Diperlukan untuk menangkap error umum
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    // HOME (menampilkan produk + best seller)
    public function index()
    {
        $products = Produk::with(['detailTransaksiOffline', 'detailTransaksiOnline'])
            ->orderBy('idProduk', 'DESC')
            ->get();

        $bestSeller = $products
            ->filter(fn($p) => $p->total_terjual > 0)
            ->sortByDesc('total_terjual')
            ->take(2);

        return view('pages.home', [
            'products' => $products,
            'bestSeller' => $bestSeller
        ]);
    }

    // HALAMAN ADMIN
    public function index2()
    {
        return view('dashboard-admin.lihatproduk', [
            'products' => Produk::orderBy('idProduk', 'DESC')->get()
        ]);
    }

    public function lihat()
    {
        $produks = Produk::all();

        // Kirim data ke view 'produk.index'
        return view('dashboard-admin.lihatproduk', compact('produks'));
    }

    // DETAIL PRODUK
    public function detailProduk(Produk $produk)
    {
        $produksLainnya = Produk::where('idProduk', '!=', $produk->idProduk)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('pages.detail_produk', [
            'produk' => $produk,
            'produksLainnya' => $produksLainnya
        ]);
    }

    // FORM TAMBAH PRODUK
    public function create()
    {
        return view('pages.tambah_produk');
    }

    // SIMPAN PRODUK BARU
    public function store(Request $request)
    {
        // 1. Validasi
        $validator = Validator::make($request->all(), [
            'namaProduk'      => 'required|string|max:100',
            'deskripsiProduk' => 'required|string',
            'pilihanJenis'    => 'required|string|max:3',
            'kategori'        => 'required|string|max:50',
            'rating'          => 'nullable|numeric|min:0|max:5',
            'harga'           => 'required|numeric|min:0',
            'stok'            => 'required|integer|min:0',
            'gambar'          => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Sudah benar untuk file
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Ambil semua data yang sudah divalidasi
        $validatedData = $validator->validated();

        try {

            // --- LOGIKA UPLOAD FILE GAMBAR ---
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');

                // 1. Buat nama file yang bersih dan unik
                $namaBersih = Str::slug($validatedData['namaProduk']);
                $filename = $namaBersih . '-' . time() . '.' . $file->getClientOriginalExtension();

                // 2. Simpan file ke disk 'public' di dalam folder 'produk_images'
                // Path: storage/app/public/produk_images
                $file->storeAs('produk_images', $filename, 'public');

                // 3. Timpa nilai 'gambar' di array $validatedData 
                //    dengan NAMA FILE yang akan disimpan di database
                $validatedData['gambar'] = $filename;
            }
            // ----------------------------------

            // Opsional: Hapus rating jika kosong agar disimpan sebagai NULL (jika kolom DB nullable)
            if (empty($validatedData['rating'])) {
                unset($validatedData['rating']);
            }

            // 4. Buat produk baru
            // Catatan: Pastikan semua keys di $validatedData sesuai dengan $fillable di Model Produk
            Produk::create($validatedData);

            // 5. Redirect dengan pesan sukses
            return redirect()->route('admin.lihat.produk')->with('success', 'Produk berhasil ditambahkan!');
        } catch (Exception $e) {
            // Log error untuk debugging di backend
            Log::error('Gagal menambahkan produk: ' . $e->getMessage(), [
                'request' => $request->all()
            ]);

            // Redirect kembali dengan pesan error yang ramah pengguna
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan produk. Silakan coba lagi atau hubungi administrator. (Detail Error: ' . $e->getMessage() . ')');
        }
    }

    public function update(Request $request, Produk $produk)
    {
        // 1. Validasi
        $validator = Validator::make($request->all(), [
            'namaProduk'      => 'required|string|max:100',
            'deskripsiProduk' => 'required|string',
            'pilihanJenis'    => 'required|string|max:3',
            'kategori'        => 'required|string|max:50',
            'rating'          => 'nullable|numeric|min:0|max:5',
            'harga'           => 'required|numeric|min:0',
            'stok'            => 'required|integer|min:0',

            // Gambar bersifat 'nullable' karena user mungkin tidak ingin mengganti gambar
            'gambar'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validatedData = $validator->validated();

        try {

            // --- LOGIKA UPLOAD/HAPUS FILE GAMBAR ---
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');

                // 1. Hapus gambar lama (jika ada) dari storage
                if ($produk->gambar) {
                    // Lokasi gambar lama: produk_images/nama_file_lama.jpg
                    Storage::disk('public')->delete('produk_images/' . $produk->gambar);
                }

                // 2. Buat nama file yang baru dan unik
                $namaBersih = Str::slug($validatedData['namaProduk']);
                $filename = $namaBersih . '-' . time() . '.' . $file->getClientOriginalExtension();

                // 3. Simpan file baru ke disk 'public' di dalam folder 'produk_images'
                $file->storeAs('produk_images', $filename, 'public');

                // 4. Update array data yang akan dimasukkan ke DB
                $validatedData['gambar'] = $filename;
            } else {
                // Jika user tidak upload file baru, hapus 'gambar' dari array 
                // agar path gambar lama tetap utuh di database.
                unset($validatedData['gambar']);
            }
            // ----------------------------------

            // Opsional: Hapus rating jika kosong agar disimpan sebagai NULL
            if (isset($validatedData['rating']) && empty($validatedData['rating'])) {
                $validatedData['rating'] = null;
            }

            // 2. Update data produk di database
            // Catatan: Pastikan $fillable di Model Produk sudah mencakup semua keys di $validatedData.
            $produk->update($validatedData);

            // 3. Redirect dengan pesan sukses
            return redirect()->route('admin.lihat.produk')->with('success', 'Produk berhasil diperbarui!');
        } catch (Exception $e) {
            // Log error untuk debugging
            Log::error('Gagal memperbarui produk (ID: ' . $produk->idProduk . '): ' . $e->getMessage(), [
                'request' => $request->all()
            ]);

            // Redirect kembali dengan pesan error
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui produk. Silakan coba lagi. (Kode Error: ' . $e->getCode() . ')');
        }
    }
}
