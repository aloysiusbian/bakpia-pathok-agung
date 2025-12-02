@extends('templates.app')

@section('title', 'Pembayaran Transfer Pesanan ' . $order->nomorPesanan)

@section('content')
<style>
    /* Menggunakan gaya CSS yang Anda berikan */
    body {
        background-color: #f9f3e2; /* warna krem lembut */
        font-family: 'Inter', sans-serif; 
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

    .account-info h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #333;
        margin-top: 10px;
        margin-bottom: 5px;
    }
    
    .account-number {
        font-size: 28px;
        font-weight: 700;
        margin: 5px 0 5px;
        letter-spacing: 2px;
        color: #000;
    }
    
    .account-name {
        font-size: 1rem;
        color: #555;
        margin-bottom: 10px;
    }


    table {
        width: 85%;
        margin: 0 auto 20px;
        text-align: left;
        border-collapse: collapse;
    }

    table td {
        padding: 8px 0;
        color: #444;
        border-bottom: 1px solid #eee;
    }

    table td:first-child {
        font-weight: 600;
    }
    
    table tr:last-child td {
        border-bottom: none;
        padding-top: 15px;
        font-size: 1.1rem;
    }
    
    .payment-box .text-end {
        text-align: right;
    }
    
    .payment-box .fw-bold {
        font-weight: bold;
    }

    .btn-status {
        background-color: #000;
        color: #fff;
        font-weight: 600;
        border: none;
        border-radius: 8px; /* Sedikit diubah agar konsisten dengan box */
        padding: 12px 30px;
        margin-top: 20px;
        cursor: pointer;
        display: inline-block;
        text-decoration: none;
        transition: background-color 0.2s;
    }
    
    .btn-status:hover {
        background-color: #333;
    }
    
    .notes {
        margin-top: 7px;
        font-size: 0.9rem;
        color: #888;
    }

</style>
<div class="payment-box">
    
    <div class="account-info">
        <h2>Transfer Bank</h2>
        <!-- Logo Bank (Contoh: logo BCA/Mandiri, ganti URL sesuai aset Anda) -->
        <img src="{{ asset('images/bank2.png') }}" alt="Bank Transfer Logo" class="bank-logo" height="150">
    </div>

    <!-- Nomor Rekening -->
    <p class="text-gray-600 font-semibold">Nomor Rekening Tujuan:</p>
    <div class="account-number">5314 1790 0008 223</div>
    <div class="account-name">A.N. Toko Agung Sentosa</div>

    <!-- Detail Pembayaran -->
    <table>
        @php
            // Asumsi biaya kirim tetap Rp 10.000 (sesuai controller)
            $shippingCost = 10000;
            // Menghitung subTotal: Total Akhir - Biaya Kirim
            $subTotal = $order->totalNota - $shippingCost; 
        @endphp
        
        <tr>
            {{-- Menggunakan data dinamis: jumlah item dari relasi --}}
            <td>Total Pesanan ({{ $order->detailTransaksiOnline->count() }} Menu)</td>
            {{-- Menggunakan data dinamis: subTotal --}}
            <td class="text-end">Rp {{ number_format($subTotal, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Total Biaya Pengiriman</td>
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

    <!-- Tombol Status (Diubah menjadi tombol aksi/konfirmasi) -->
    {{-- Arahkan ke route konfirmasi pembayaran jika sudah dibuat --}}
    <a href="#" class="btn-status">Konfirmasi Pembayaran</a>
    
    <p class="notes">Lakukan pembayaran dalam waktu 24 jam agar pesanan tidak dibatalkan.</p>
</div>
@endsection