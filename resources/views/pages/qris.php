@extends('templates.app')

@section('title', 'Qris')

@section('content')
<div class="payment-box">
  <!-- QR CODE -->
  <img src="{{ asset('images/qris_sample.png') }}" alt="QRIS QR Code" width="180" height="180">

  <!-- QRIS Logo -->
  <div>
    <img src="{{ asset('images/qris.png') }}" alt="Pembayaran 1" class="h-8" height="100" background-color=transparant>
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