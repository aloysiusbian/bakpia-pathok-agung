<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\PemesananOnline;
use App\Models\Produk;                     
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            // ✨ form action kalau berasal dari keranjang
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
                'statusPesanan'    => PemesananOnline::STATUS_PENDING,
                'discountPerNota'  => 0,
                'alamatPengirim'   => $request->alamatPengirim,
            ]);

            foreach ($items as $item) {
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

        $subTotal     = $produk->harga * $qty;
        $shippingCost = 10000;
        $grandTotal   = $subTotal + $shippingCost;

        // simpan data sementara di session (bukan info asal, cuma data produk)
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

        // bentuk collection mirip data keranjang supaya view bisa pakai loop yang sama
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
            // ✨ action khusus kalau berasal dari detail produk
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
            return redirect()->route('produk.index') // sesuaikan kalau nama route beda
                ->with('error', 'Sesi checkout sudah berakhir. Silakan ulangi.');
        }

        $idPelanggan = Auth::user()->idPelanggan;

        DB::beginTransaction();

        try {
            $order = PemesananOnline::create([
                'idPelanggan'      => $idPelanggan,
                'tanggalPemesanan' => now(),
                'totalNota'        => $data['grandTotal'],
                'metodePembayaran' => $request->metode_pembayaran,
                'statusPesanan'    => PemesananOnline::STATUS_PENDING,
                'discountPerNota'  => 0,
                'alamatPengirim'   => $request->alamatPengirim,
            ]);

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
}
