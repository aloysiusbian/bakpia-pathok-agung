@extends('templates.app')

@section('title', 'Pembayaran QRIS Pesanan ' . $order->nomorPemesanan)

@section('content')
<style>
    body { background-color: #f9f3e2; }
    .payment-box {
        background-color: #ffffff;
        border-radius: 10px;
        max-width: 600px;
        margin: 80px auto;
        text-align: center;
        border: 1px solid #e2d6b8;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.03);
        padding-bottom: 30px;
    }
    .payment-box img.qris-logo { width: 70px; margin: 10px 0 20px; }
    .payment-box table { margin: 20px auto; text-align: left; width: 80%; }
    .payment-box table td { padding: 4px 0; }
    .payment-box .btn-status {
        background-color: #000;
        color: #fff;
        font-weight: 600;
        border-radius: 10px;
        padding: 12px 20px;
        margin-top: 20px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }
    .payment-box .btn-status:hover { background-color: #333; color: #fff; }
    .modal-content-custom { background-color: #fff; border-radius: 15px; border: 1px solid #e2d6b8; }
    .modal-header {
        border-bottom: 1px solid #f0e6cc;
        background-color: #f9f3e2;
        border-radius: 15px 15px 0 0;
    }
</style>

<div class="payment-box">
    <h3>Pembayaran QRIS Pesanan {{ $order->nomorPemesanan }}</h3>

    <div class="qris-qr-code">
        <img src="{{ asset('images/qris_sample.png') }}" alt="QRIS QR Code" width="200" height="200">
    </div>

    <div class="qris-logo-container">
        <img src="{{ asset('images/qris2.png') }}" alt="QRIS Logo" class="qris-logo" height="35">
    </div>

    <table>
        @php
            $shippingCost = 10000;
            $subTotal = $order->totalNota - $shippingCost;
        @endphp

        <tr>
            <td><strong>Total Pesanan ({{ $order->detailTransaksiOnline->count() }} Menu)</strong></td>
            <td class="text-end">Rp {{ number_format($subTotal, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Total Biaya Pengiriman</strong></td>
            <td class="text-end">Rp {{ number_format($shippingCost, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Total Bayar</strong></td>
            <td class="text-end fw-bold">Rp {{ number_format($order->totalNota, 0, ',', '.') }}</td>
        </tr>
    </table>

    <button type="button" class="btn-status" data-bs-toggle="modal" data-bs-target="#uploadBuktiModal">
        Kirim bukti pembayaran!
    </button>

    <p style="margin-top: 20px; font-size: 0.8rem; color: #888;">
        Pesanan akan dibatalkan otomatis jika belum ada bukti pembayaran dalam 24 jam.
    </p>
</div>

<div class="modal fade" id="uploadBuktiModal" tabindex="-1" aria-labelledby="uploadBuktiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="uploadBuktiModalLabel">Upload Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('pembayaran.upload', $order->nomorPemesanan) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="modal-body text-start p-4">
                    <div class="mb-3">
                        <label for="fileBukti" class="form-label fw-bold">Pilih Foto / Screenshot</label>
                        <input class="form-control" type="file" id="fileBukti" name="bukti_pembayaran" accept="image/*" required>
                        <div class="form-text">Format: JPG, PNG, atau JPEG. Maksimal 2MB.</div>
                    </div>

                    <div class="mb-3">
                        <label for="catatan" class="form-label fw-bold">Catatan (Opsional)</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="2"
                                  placeholder="Contoh: Sudah transfer a.n Budi"></textarea>
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0 pb-4 justify-content-center">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-dark px-4" style="background-color: #000; border-radius: 8px;">
                        Kirim Bukti
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
