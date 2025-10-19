@extends('templates.app')

@section('title', 'qris ')

@section('content')
<style>
    body {
      background-color: #f9f3e2; /* warna krem lembut seperti di gambar */
    }

    .payment-box {
      background-color: #fff;
      border-radius: 10px;
      padding: 40px;
      max-width: 600px;
      margin: 80px auto;
      text-align: center;
      border: 1px solid #e2d6b8;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.03);
    }

    .bank-logo {
      display: block;
      margin: 0 auto 10px;
      width: 300px; /* ukuran logo bank */
    }

    .account-number {
      font-size: 28px;
      font-weight: 700;
      margin: 20px 0 30px;
      letter-spacing: 2px;
    }

    table {
      width: 80%;
      margin: 0 auto 20px;
      text-align: left;
    }

    table td {
      padding: 4px 0;
      color: #444;
    }

    table td:first-child {
      font-weight: 600;
    }

    .btn-status {
      background-color: #000;
      color: #fff;
      font-weight: 600;
      border: none;
      border-radius: 10px;
      padding: 12px 20px;
      cursor: default;
    }

</style>
<div class="payment-box">
    <!-- Logo Bank -->
    <img src="{{ asset('images/bank2.png') }}" alt="Bank Transfer Logo" class="bank-logo" height="150">

    <!-- Nomor Rekening -->
    <div class="account-number">5314 1790 0008 223</div>

    <!-- Detail Pembayaran -->
    <table>
      <tr>
        <td>Total Pesanan (1 Menu)</td>
        <td class="text-end">Rp 250.000</td>
      </tr>
      <tr>
        <td>Total Biaya Pengiriman</td>
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