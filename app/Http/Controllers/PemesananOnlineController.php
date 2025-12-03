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
    /**
     * DARI KERANJANG -> tampil halaman checkout
     */
    public function checkout(Request $request)
    {
        $ids         = $request->input('items', []);
        $idPelanggan = Auth::user()->idPelanggan;

        if (empty($ids)) {
            return redirect()
                ->route('keranjang.index')
                ->with('error', 'Pilih minimal satu produk untuk dibeli.');
        }

        $items = Keranjang::with('produk')
            ->where('idPelanggan', $idPelanggan)
            ->whereIn('idKeranjang', $ids)
            ->get();

        if ($items->isEmpty()) {
            return redirect()
                ->route('keranjang.index')
                ->with('error', 'Item keranjang tidak ditemukan.');
        }

        $subTotal     = $items->sum('subTotal');
        $shippingCost = 10000;
        $grandTotal   = $subTotal + $shippingCost;
        $totalQty     = $items->sum('jumlahBarang');

        session([
            'checkout_items'    => $ids,
            'checkout_subtotal' => $subTotal,
            'checkout_shipping' => $shippingCost,
        ]);

        return view('pages.pembayaran', [
            'items'        => $items,
            'subTotal'     => $subTotal,
            'shippingCost' => $shippingCost,
            'grandTotal'   => $grandTotal,
            'totalQty'     => $totalQty,
            'formAction'   => route('pembayaran.process'),
        ]);
    }

    /**
     * SIMPAN dari keranjang ke pemesanan + detail transaksi
     */
    public function process(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:qris,bank',
            'alamatPengirim'    => 'required|string|max:255',
        ]);

        $ids         = session('checkout_items', []);
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
            return redirect()
                ->route('keranjang.index')
                ->with('error', 'Item keranjang tidak ditemukan.');
        }

        // ✨ Cek stok cukup untuk semua item sebelum transaksi
        foreach ($items as $item) {
            if (!$item->produk || $item->jumlahBarang > $item->produk->stok) {
                return redirect()
                    ->route('keranjang.index')
                    ->with('error', 'Stok untuk produk ' . $item->produk->namaProduk . ' tidak mencukupi.');
            }
        }

        $shippingCost = session('checkout_shipping', 0);
        $subTotal     = $items->sum('subTotal');
        $grandTotal   = $subTotal + $shippingCost;

        DB::beginTransaction();

        try {
            $order = PemesananOnline::create([
                'idPelanggan'      => $idPelanggan,
                'tanggalPemesanan' => now(),
                'totalNota'        => $grandTotal,
                'metodePembayaran' => $request->metode_pembayaran,
                'statusPesanan'    => PemesananOnline::STATUS_PO,
                'discountPerNota'  => 0,
                'alamatPengirim'   => $request->alamatPengirim,
            ]);

            foreach ($items as $item) {
                // ✨ Kurangi stok produk
                Produk::where('idProduk', $item->idProduk)
                    ->lockForUpdate()
                    ->decrement('stok', $item->jumlahBarang);

                // Simpan detail transaksi
                $order->detailTransaksiOnline()->create([
                    'idProduk'          => $item->idProduk,
                    'jumlahBarang'      => $item->jumlahBarang,
                    'harga'             => $item->produk->harga,
                    'discountPerProduk' => 0,
                    'subTotal'          => $item->subTotal,
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

    /**
     * DARI DETAIL PRODUK -> tampil halaman checkout (TANPA keranjang)
     */
    public function checkoutProduk(Request $request)
    {
        $request->validate([
            'idProduk'     => 'required|exists:produk,idProduk',
            'jumlahBarang' => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->idProduk);
        $qty    = $request->jumlahBarang;

        // ✨ Pastikan qty tidak melebihi stok
        if ($qty > $produk->stok) {
            return back()->with('error', 'Stok tidak mencukupi. Stok tersisa: ' . $produk->stok);
        }

        $subTotal     = $produk->harga * $qty;
        $shippingCost = 10000;
        $grandTotal   = $subTotal + $shippingCost;

        session([
            'checkout_single' => [
                'idProduk'     => $produk->idProduk,
                'jumlahBarang' => $qty,
                'harga'        => $produk->harga,
                'subTotal'     => $subTotal,
                'shippingCost' => $shippingCost,
                'grandTotal'   => $grandTotal,
            ],
        ]);

        $items = collect([
            (object) [
                'produk'       => $produk,
                'jumlahBarang' => $qty,
                'subTotal'     => $subTotal,
            ],
        ]);

        return view('pages.pembayaran', [
            'items'        => $items,
            'subTotal'     => $subTotal,
            'shippingCost' => $shippingCost,
            'grandTotal'   => $grandTotal,
            'totalQty'     => $qty,
            'formAction'   => route('pembayaran.process.produk'),
        ]);
    }

    /**
     * SIMPAN dari detail produk (langsung) ke pemesanan + detail transaksi
     */
    public function processProduk(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:qris,bank',
            'alamatPengirim'    => 'required|string|max:255',
        ]);

        $data = session('checkout_single');
        if (!$data) {
            return redirect()->route('produk.index')
                ->with('error', 'Sesi checkout sudah berakhir. Silakan ulangi.');
        }

        $idPelanggan = Auth::user()->idPelanggan;

        DB::beginTransaction();

        try {
            // ✨ Cek stok lagi di level DB (lebih aman)
            $produk = Produk::lockForUpdate()->findOrFail($data['idProduk']);
            if ($data['jumlahBarang'] > $produk->stok) {
                DB::rollBack();
                return redirect()->route('produk.show', $produk->idProduk)
                    ->with('error', 'Stok untuk produk ini tidak mencukupi.');
            }

            $order = PemesananOnline::create([
                'idPelanggan'      => $idPelanggan,
                'tanggalPemesanan' => now(),
                'totalNota'        => $data['grandTotal'],
                'metodePembayaran' => $request->metode_pembayaran,
                'statusPesanan'    => PemesananOnline::STATUS_PO,
                'discountPerNota'  => 0,
                'alamatPengirim'   => $request->alamatPengirim,
            ]);

            // ✨ Kurangi stok produk
            $produk->decrement('stok', $data['jumlahBarang']);

            // Detail transaksi
            $order->detailTransaksiOnline()->create([
                'idProduk'          => $data['idProduk'],
                'jumlahBarang'      => $data['jumlahBarang'],
                'harga'             => $data['harga'],
                'discountPerProduk' => 0,
                'subTotal'          => $data['subTotal'],
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
    // id pelanggan yang sedang login
    $idPelanggan = Auth::id(); // atau Auth::user()->idPelanggan kalau kamu mau konsisten

    // ambil status dari query string, contoh: ?status=pending
    $filterStatus = $request->query('status'); // bisa null

    // boleh dibatasi supaya status yang aneh diabaikan
    $allowedStatus = ['payment', 'pending', 'cancel', 'shipped'];

    $query = PemesananOnline::with(['detailTransaksiOnline.produk'])
        ->where('idPelanggan', $idPelanggan)
        ->orderByDesc('tanggalPemesanan');

    if ($filterStatus && in_array($filterStatus, $allowedStatus)) {
        $query->where('statusPesanan', $filterStatus);
    }

    $orders = $query->get();

    return view('pages.pesanansaya', [
        'orders'       => $orders,
        'filterStatus' => $filterStatus, // dipakai di blade untuk set tab aktif
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

    // 1. Total pembelian: JUMLAH pesanan yang sudah shipped
    $totalPembelian = PemesananOnline::where('idPelanggan', $idPelanggan)
        ->where('statusPesanan', 'shipped')
        ->count();

    // 2. Pesanan aktif: pending atau payment
    $pesananAktif = PemesananOnline::where('idPelanggan', $idPelanggan)
        ->whereIn('statusPesanan', ['pending', 'payment'])
        ->count();

    // 3. Pesanan baru minggu ini (status shipped)
    $baruMingguIni = PemesananOnline::where('idPelanggan', $idPelanggan)
        ->where('statusPesanan', 'shipped')
        ->whereBetween('tanggalPemesanan', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
        ])
        ->count();

    // 4. Total pengeluaran: jumlah uang dari pesanan shipped (misal bulan ini)
    $totalPengeluaran = PemesananOnline::where('idPelanggan', $idPelanggan)
        ->where('statusPesanan', 'shipped')
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

}