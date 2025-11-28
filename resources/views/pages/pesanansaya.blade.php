@extends('templates.app')

@section('title', 'Pesanan Saya')

@section('content')
<style>
   
    .main-order-container {
        border: 1px solid #7a7a7a;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 40px;
    }
    .info-card {
        border: 1px solid #7a7a7a;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .delivery-status { color: #4caf50; font-weight: 600; }
    /* ... sisa style lainnya ... */
</style>

<div class="container py-5">
    <h2 class="fw-bold mb-4">Pesanan saya</h2>

    <!-- Container Utama -->
    <div class="main-order-container">
        
        <!-- Kartu 1: Info Pengiriman -->
        <div class="info-card">
            <h5 class="fw-bold">Info pengiriman</h5>
            <div class="delivery-status">Pesanan akan tiba dalam 30 menit</div>
            <div class="text-muted small">21-5-2025 15:30</div>
        </div>

        <!-- Kartu 2: Alamat -->
        <div class="info-card">
            <h5 class="fw-bold">Alamat Pengiriman</h5>
            <div class="d-flex gap-2">
                <i class="fas fa-map-marker-alt mt-1"></i>
                <p class="mb-0 small">
                    Kampus III Universitas Sanata Dharma, Jl. Paingan, Krodan,<br>
                    Maguwoharjo, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55281
                </p>
            </div>
        </div>

        <!-- Kartu 3: Produk -->
        <div class="info-card">
            <h5 class="fw-bold">Bakpia Cokelat</h5>
          <div class="row">
                    <!-- Kolom 1: Gambar -->
                    <div class="col-auto">
                        <img src="images/bakpia-cokelat.jpg" 
                             class="rounded border" 
                             style="width: 120px; height: 120px; object-fit: cover;" 
                             alt="Bakpia Cokelat">
                    </div>

                    <!-- Kolom 2: Deskripsi (Di samping gambar) -->
                    <div class="col">
                        <div class="product-desc">
                            <p class="mb-1"><strong>Rasa:</strong> Cokelat asli yang manis dan lembut di mulut.</p>
                            <p class="mb-1 text-muted small">Tekstur kulit tipis berlapis dengan isian padat tanpa pengawet buatan.</p>
                           
                        </div>
                    </div>
                </div>
                <div class="col text-end">
                    <h5 class="fw-bold text-secondary">Total Pesanan : 250.000</h5>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection