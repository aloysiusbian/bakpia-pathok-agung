@extends('templates.app')

@section('title', 'qris ')

@section('content')
<style>
  body {
      background-color: #f9f3e2; /* warna krem lembut */
    }

    .payment-box {
      background-color: #f9f3e2;
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
  <div class="payment-box">
    <!-- QR CODE -->
    <img src="{{ asset('images/qris_sample.png') }}" alt="QRIS QR Code" width="180" height="180">

    <!-- QRIS Logo -->
    <div>
      <img src="{{ asset('images/qris.png') }}" alt="Pembayaran 1" class="h-8" height="100">
    </div>
    <!-- Detail pembayaran -->
    <table>
      <tr>
        <td><strong>Total Pesanan (1 Menu)</strong></td>
        <td class="text-end">Rp 250.000</td>
      </tr>
      <tr>
        <td><strong>Total Biaya Pengiriman</strong></td>
        <td class="text-end">Rp 10.000</td>
      </tr>
      <tr>
        <td><strong>Total</strong></td>
        <td class="text-end fw-bold">Rp 260.000</td>
      </tr>
    </table>

    <!-- Tombol Status -->
    <button class="btn-status">Menunggu Konfirmasi Pembayaran</button>
  </div>
@endsection