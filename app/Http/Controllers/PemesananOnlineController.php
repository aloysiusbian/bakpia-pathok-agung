<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\PemesananOnline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PemesananOnlineController extends Controller
{
    /**
     * Dari keranjang -> tampil halaman checkout
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
        ]);
    }

    /**
     * Simpan ke tabel pemesanan + detail transaksi
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
