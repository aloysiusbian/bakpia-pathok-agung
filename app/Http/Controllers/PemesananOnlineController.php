<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\PemesananOnline;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PemesananOnlineController extends Controller
{
    public function index()
    {
        $orders = PemesananOnline::with('pelanggan')
            ->orderByDesc('tanggalPemesanan')
            ->paginate(10);

        $summary = $this->calculateOrderSummary();

        return view('dashboard-admin.pemesananOnline', compact('orders', 'summary'));
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

    public function checkout(Request $request)
    {
        $ids = $request->input('items', []);
        $idPelanggan = Auth::user()->idPelanggan;

        if (empty($ids)) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Pilih minimal satu produk untuk dibeli.');
        }

        $items = Keranjang::with('produk')
            ->where('idPelanggan', $idPelanggan)
            ->whereIn('idKeranjang', $ids)
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Item keranjang tidak ditemukan.');
        }

        $subTotal = $items->sum('subTotal');
        $shippingCost = 10000;
        $grandTotal = $subTotal + $shippingCost;
        $totalQty = $items->sum('jumlahBarang');

        session([
            'checkout_items' => $ids,
            'checkout_subtotal' => $subTotal,
            'checkout_shipping' => $shippingCost,
        ]);

        return view('pages.pembayaran', [
            'items' => $items,
            'subTotal' => $subTotal,
            'shippingCost' => $shippingCost,
            'grandTotal' => $grandTotal,
            'totalQty' => $totalQty,
            'formAction' => route('pembayaran.process'),
        ]);
    }

    public function process(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:qris,bank',
            'alamatPengirim' => 'required|string|max:255',
        ]);

        $ids = session('checkout_items', []);
        $idPelanggan = Auth::user()->idPelanggan;

        if (empty($ids)) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Sesi checkout sudah berakhir. Silakan ulangi proses.');
        }

        $items = Keranjang::with('produk')
            ->where('idPelanggan', $idPelanggan)
            ->whereIn('idKeranjang', $ids)
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Item keranjang tidak ditemukan.');
        }

        foreach ($items as $item) {
            if (!$item->produk || $item->jumlahBarang > $item->produk->stok) {
                return redirect()->route('keranjang.index')
                    ->with('error', 'Stok untuk produk ' . $item->produk->namaProduk . ' tidak mencukupi.');
            }
        }

        $shippingCost = session('checkout_shipping', 0);
        $subTotal = $items->sum('subTotal');
        $grandTotal = $subTotal + $shippingCost;

        DB::beginTransaction();

        try {
            $order = PemesananOnline::create([
                'idPelanggan' => $idPelanggan,
                'tanggalPemesanan' => now(),
                'totalNota' => $grandTotal,
                'metodePembayaran' => $request->metode_pembayaran,
                'statusPesanan' => PemesananOnline::STATUS_PO,
                'discountPerNota' => 0,
                'alamatPengirim' => $request->alamatPengirim,
            ]);

            foreach ($items as $item) {
                Produk::where('idProduk', $item->idProduk)
                    ->lockForUpdate()
                    ->decrement('stok', $item->jumlahBarang);

                $order->detailTransaksiOnline()->create([
                    'idProduk' => $item->idProduk,
                    'jumlahBarang' => $item->jumlahBarang,
                    'harga' => $item->produk->harga,
                    'discountPerProduk' => 0,
                    'subTotal' => $item->subTotal,
                ]);
            }

            Keranjang::where('idPelanggan', $idPelanggan)
                ->whereIn('idKeranjang', $ids)
                ->delete();

            session()->forget(['checkout_items', 'checkout_subtotal', 'checkout_shipping']);

            DB::commit();

            if ($request->metode_pembayaran === 'qris') {
                return redirect()->route('pembayaran.qris', $order->nomorPemesanan);
            }

            return redirect()->route('pembayaran.bank', $order->nomorPemesanan);
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pembayaran.');
        }
    }

    public function checkoutProduk(Request $request)
    {
        $request->validate([
            'idProduk' => 'required|exists:produk,idProduk',
            'jumlahBarang' => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->idProduk);
        $qty = $request->jumlahBarang;

        if ($qty > $produk->stok) {
            return back()->with('error', 'Stok tidak mencukupi. Stok tersisa: ' . $produk->stok);
        }

        $subTotal = $produk->harga * $qty;
        $shippingCost = 10000;
        $grandTotal = $subTotal + $shippingCost;

        session([
            'checkout_single' => [
                'idProduk' => $produk->idProduk,
                'jumlahBarang' => $qty,
                'harga' => $produk->harga,
                'subTotal' => $subTotal,
                'shippingCost' => $shippingCost,
                'grandTotal' => $grandTotal,
            ],
        ]);

        $items = collect([
            (object) [
                'produk' => $produk,
                'jumlahBarang' => $qty,
                'subTotal' => $subTotal,
            ],
        ]);

        return view('pages.pembayaran', [
            'items' => $items,
            'subTotal' => $subTotal,
            'shippingCost' => $shippingCost,
            'grandTotal' => $grandTotal,
            'totalQty' => $qty,
            'formAction' => route('pembayaran.process.produk'),
        ]);
    }

    public function processProduk(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:qris,bank',
            'alamatPengirim' => 'required|string|max:255',
        ]);

        $data = session('checkout_single');
        if (!$data) {
            return redirect()->route('produk.index')
                ->with('error', 'Sesi checkout sudah berakhir. Silakan ulangi.');
        }

        $idPelanggan = Auth::user()->idPelanggan;

        DB::beginTransaction();

        try {
            $produk = Produk::lockForUpdate()->findOrFail($data['idProduk']);
            if ($data['jumlahBarang'] > $produk->stok) {
                DB::rollBack();
                return redirect()->route('produk.show', $produk->idProduk)
                    ->with('error', 'Stok untuk produk ini tidak mencukupi.');
            }

            $order = PemesananOnline::create([
                'idPelanggan' => $idPelanggan,
                'tanggalPemesanan' => now(),
                'totalNota' => $data['grandTotal'],
                'metodePembayaran' => $request->metode_pembayaran,
                'statusPesanan' => PemesananOnline::STATUS_PO,
                'discountPerNota' => 0,
                'alamatPengirim' => $request->alamatPengirim,
            ]);

            $produk->decrement('stok', $data['jumlahBarang']);

            $order->detailTransaksiOnline()->create([
                'idProduk' => $data['idProduk'],
                'jumlahBarang' => $data['jumlahBarang'],
                'harga' => $data['harga'],
                'discountPerProduk' => 0,
                'subTotal' => $data['subTotal'],
            ]);

            session()->forget('checkout_single');

            DB::commit();

            if ($request->metode_pembayaran === 'qris') {
                return redirect()->route('pembayaran.qris', $order->nomorPemesanan);
            }

            return redirect()->route('pembayaran.bank', $order->nomorPemesanan);
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pembayaran.');
        }
    }

    public function konfirmasiPembayaran($nomorPemesanan)
    {
        $order = PemesananOnline::where('nomorPemesanan', $nomorPemesanan)
            ->first();

        if (!$order) {
            return back()->with('error', 'Pesanan tidak ditemukan atau statusnya tidak valid untuk dikonfirmasi.');
        }

        DB::beginTransaction();
        try {
            $order->statusPesanan = 'diproses';
            $order->save();

            DB::commit();
            return redirect()->route('admin.pemesanan.online') // Arahkan kembali ke daftar pesanan admin
                ->with('success', 'Pesanan ' . $order->nomorPemesanan . ' berhasil dikonfirmasi dan status diubah menjadi DIPROSES.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengkonfirmasi pembayaran: ' . $e->getMessage());
        }
    }

    public function qris($nomorPemesanan)
    {
        $order = PemesananOnline::with('detailTransaksiOnline.produk')
            ->findOrFail($nomorPemesanan);

        return view('pages.qris', compact('order'));
    }

    public function transfer($nomorPemesanan)
    {
        $order = PemesananOnline::with('detailTransaksiOnline.produk')
            ->findOrFail($nomorPemesanan);

        return view('pages.bank', compact('order'));
    }

    public function riwayat(Request $request)
    {
        $idPelanggan = Auth::user()->idPelanggan;

        $filterStatus = $request->query('status');
        $allowedStatus = ['menunggu_pembayaran', 'diproses', 'batal', 'selesai'];

        $query = PemesananOnline::with(['detailTransaksiOnline.produk'])
            ->where('idPelanggan', $idPelanggan)
            ->orderByDesc('tanggalPemesanan');

        if ($filterStatus && in_array($filterStatus, $allowedStatus)) {
            $query->where('statusPesanan', $filterStatus);
        }

        $orders = $query->get();

        return view('pages.pesanansaya', [
            'orders' => $orders,
            'filterStatus' => $filterStatus,
        ]);
    }

    public function detail($nomorPemesanan)
    {
        $idPelanggan = Auth::user()->idPelanggan;

        $order = PemesananOnline::with(['detailTransaksiOnline.produk'])
            ->where('idPelanggan', $idPelanggan)
            ->findOrFail($nomorPemesanan);

        return view('pages.detailpesanan', compact('order'));
    }

    public function riwayatTabel()
    {
        $idPelanggan = Auth::user()->idPelanggan;

        $orders = PemesananOnline::with('detailTransaksiOnline.produk')
            ->where('idPelanggan', $idPelanggan)
            ->orderByDesc('tanggalPemesanan')
            ->get();

        return view('dashboard-pelanggan.riwayat', compact('orders'));
    }

    public function dashboard()
    {
        $idPelanggan = Auth::user()->idPelanggan;

        $totalPembelian = PemesananOnline::where('idPelanggan', $idPelanggan)
            ->where('statusPesanan', 'menunggu_pembayaran')
            ->count();

        $pesananAktif = PemesananOnline::where('idPelanggan', $idPelanggan)
            ->whereIn('statusPesanan', ['diproses', 'menunggu_pembayaran'])
            ->count();

        $baruMingguIni = PemesananOnline::where('idPelanggan', $idPelanggan)
            ->where('statusPesanan', 'selesai')
            ->whereBetween('tanggalPemesanan', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek(),
            ])
            ->count();

        $totalPengeluaran = PemesananOnline::where('idPelanggan', $idPelanggan)
            ->where('statusPesanan', 'diproses')
            ->whereMonth('tanggalPemesanan', Carbon::now()->month)
            ->whereYear('tanggalPemesanan', Carbon::now()->year)
            ->sum('totalNota');

        return view('dashboard-pelanggan.dashboardPelanggan', compact(
            'totalPembelian',
            'pesananAktif',
            'baruMingguIni',
            'totalPengeluaran'
        ));
    }

    public function uploadBukti(Request $request, $nomorPemesanan)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'catatan'          => 'nullable|string|max:255',
        ]);

        $idPelanggan = Auth::user()->idPelanggan;

        $order = PemesananOnline::where('nomorPemesanan', $nomorPemesanan)
            ->where('idPelanggan', $idPelanggan)
            ->firstOrFail();

        $file = $request->file('bukti_pembayaran');

        $filename = 'bukti_' . $order->nomorPemesanan . '_' . time() . '.' . $file->getClientOriginalExtension();

        // === PAKSA SIMPAN KE DISK PUBLIC (paling aman) ===
        $savedPath = $file->storeAs('bukti_pembayaran', $filename, 'public');

        // LOG HASILNYA
        logger()->info('UPLOAD BUKTI SAVED', [
            'savedPath' => $savedPath,
            'fullPath'  => storage_path('app/public/' . $savedPath),
            'exists'    => file_exists(storage_path('app/public/' . $savedPath)),
        ]);

        $order->buktiPembayaran = 'storage/' . $savedPath;
        $order->catatan = $request->catatan;
        $order->statusPesanan = 'menunggu_pembayaran';
        $order->save();

        return redirect()->route('pembayaran.sukses', $nomorPemesanan);
    }

    public function pembayaranSukses($nomorPemesanan)
    {
        $order = PemesananOnline::where('idPelanggan', Auth::user()->idPelanggan)
            ->where('nomorPemesanan', $nomorPemesanan)
            ->firstOrFail();

        return view('pages.status_pembayaran', compact('order'));
    }

    public function batalkanPesanan($nomorPemesanan)
    {
        $pesanan = pemesananOnline::where('nomorPemesanan', $nomorPemesanan)
            ->where('idPelanggan', Auth::id()) // Pastikan milik user yang login
            ->firstOrFail();

        if ($pesanan->statusPesanan == 'menunggu_pembayaran') {
            $pesanan->statusPesanan = 'batal';
            $pesanan->save();
            return back()->with('success', 'Pesanan berhasil dibatalkan.');
        }

        return back()->with('error', 'Pesanan tidak dapat dibatalkan.');
    }
}
