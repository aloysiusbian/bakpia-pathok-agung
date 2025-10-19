@extends('templates.app')

@section('title', 'Keranjang')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pembayaran QRIS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f9f3e2; /* warna krem lembut */
      font-family: "Poppins", sans-serif;
    }

    .payment-box {
      background-color: #f9f3e2;
      border: 1px solid #d6c29e;
      border-radius: 10px;
      padding: 40px;
      max-width: 500px;
      margin: 80px auto;
      text-align: center;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
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
</head>
<body>

  <div class="payment-box">
    <!-- QR CODE -->
    <img src="{{ asset('images/qris_sample.png') }}" alt="QRIS QR Code" width="180" height="180">

    <!-- QRIS Logo -->
    <div>
      <img src="{{ asset('images/qris.png') }}" alt="Pembayaran 1" class="h-8" height="100" background-color= transparant>
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

</body>
</html>