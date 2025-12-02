@extends('templates.app')

@section('title', 'Pembayaran QRIS Pesanan ' . $order->nomorPesanan)

@section('content')
<style>
  body {
      background-color: #f9f3e2; /* warna krem lembut */
    }

    .payment-box {
      background-color: #ffffff;
      border-radius: 10px;
      max-width: 600px;
      margin: 80px auto;
      text-align: center;
      border: 1px solid #e2d6b8;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.03);
    }

    .payment-box img.qris-logo {
      width: 70px;
      margin: 10px 0 20px;
    }

    .payment-box table {
      margin: 20px auto;
      text-align: left;
      width: 80%;
    }

    .payment-box table td {
      padding: 4px 0;
    }

    .payment-box .btn-status {
      background-color: #000;
      color: #fff;
      font-weight: 600;
      border-radius: 10px;
      padding: 12px 20px;
      margin-top: 20px;
      border: none;
      cursor: default;
    }
</style>
{{-- Tidak perlu memuat Tailwind CSS di sini karena kita menggunakan custom CSS --}}

<div class="payment-box">
    
    <h3>Pembayaran QRIS Pesanan{{ $order->nomorPesanan }}</h3>

    <!-- QR CODE -->
    <div class="qris-qr-code">
        <img src="{{ asset('images/qris_sample.png') }}" alt="QRIS QR Code" width="200" height="200">
    </div>

    <!-- QRIS Logo -->
    <div class="qris-logo-container">
        {{-- Mengganti class menjadi qris-logo sesuai CSS di atas --}}
        <img src="{{ asset('images/qris2.png') }}" alt="QRIS Logo" class="qris-logo" height="35" >
    </div>

    <!-- Detail pembayaran -->
    <table>
        @php
            // Asumsi biaya kirim tetap Rp 10.000 (dari controller sebelumnya)
            $shippingCost = 10000;
            // Menghitung subTotal: Total Akhir - Biaya Kirim
            $subTotal = $order->totalNota - $shippingCost; 
        @endphp
        
        <tr>
            {{-- Menggunakan data dinamis: jumlah item dari relasi --}}
            <td><strong>Total Pesanan ({{ $order->detailTransaksiOnline->count() }} Menu)</strong></td>
            {{-- Menggunakan data dinamis: subTotal --}}
            <td class="text-end">Rp {{ number_format($subTotal, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Total Biaya Pengiriman</strong></td>
            {{-- Menggunakan data dinamis: Biaya Kirim --}}
            <td class="text-end">Rp {{ number_format($shippingCost, 0, ',', '.') }}</td>
        </tr>
        <tr>
            {{-- Baris Total Akhir --}}
            <td><strong>Total Bayar</strong></td>
            {{-- Menggunakan data dinamis: TotalNota/GrandTotal --}}
            <td class="text-end fw-bold">Rp {{ number_format($order->totalNota, 0, ',', '.') }}</td>
        </tr>
    </table>

    <!-- Tombol Status (Hanya satu tombol aksi yang dipertahankan) -->
    <a href="#" class="btn-status">Kirim bukti pembayaran!</a>
    
    <p style="margin-top: 20px; font-size: 0.8rem; color: #888;">Pesanan akan dibatalkan otomatis jika belum ada bukti pembayaran dalam 24 jam.</p>
</div>
@endsection