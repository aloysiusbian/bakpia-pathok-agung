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

    <!-- Tombol Status (MODIFIKASI: Menambahkan trigger modal) -->
    <!-- Saya mengganti href="#" dengan atribut data-bs-toggle -->
    <button type="button" class="btn-status" data-bs-toggle="modal" data-bs-target="#uploadBuktiModal">
        Kirim bukti pembayaran!
    </button>
    
    <p style="margin-top: 20px; font-size: 0.8rem; color: #888;">Pesanan akan dibatalkan otomatis jika belum ada bukti pembayaran dalam 24 jam.</p>
</div>

<!-- TAMBAHAN: MODAL UPLOAD BUKTI -->
<div class="modal fade" id="uploadBuktiModal" tabindex="-1" aria-labelledby="uploadBuktiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="uploadBuktiModalLabel">Upload Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Form Upload -->
            <!-- Pastikan route 'upload.bukti' sudah ada di web.php Anda -->
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
                        <textarea class="form-control" id="catatan" name="catatan" rows="2" placeholder="Contoh: Sudah transfer a.n Budi"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 justify-content-center">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-dark px-4" style="background-color: #000; border-radius: 8px;">Kirim Bukti</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script Bootstrap Bundle (Wajib ada untuk Modal) -->
<!-- Jika di templates.app sudah ada, baris ini bisa dihapus -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection