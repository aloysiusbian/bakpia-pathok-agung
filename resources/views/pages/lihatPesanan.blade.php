@extends('templates.app')

@section('title', 'lihat')

@section('content')
<div class="container my-5">
    <h3 class="fw-bold mb-4">Pesanan saya</h3>

    <div class="p-4 rounded-4 shadow-sm" style="background-color: #f8f2e0; border: 2px solid #bca87f;">
        <!-- Info Pengiriman -->
        <div class="p-3 mb-4 rounded-3" style="background-color: #fefcf6; border: 1px solid #cbbf9b;">
            <h5 class="fw-bold mb-2">Info pengiriman</h5>
            <p class="text-success mb-1 fw-semibold">Pesanan akan tiba dalam 30 menit</p>
            <small class="text-muted">21-5-2025 15:30</small>
        </div>

        <!-- Alamat Pengiriman -->
        <div class="p-3 mb-4 rounded-3" style="background-color: #fefcf6; border: 1px solid #cbbf9b;">
            <h5 class="fw-bold mb-2">Alamat Pengiriman</h5>
            <div class="d-flex align-items-start">
                <i class="bi bi-geo-alt-fill me-2 fs-5 text-dark"></i>
                <p class="mb-0">
                    Kampus III Universitas Sanata Dharma, Jl. Paingan, Krodan, Maguwoharjo, Kec. Depok, 
                    Kabupaten Sleman, Daerah Istimewa Yogyakarta 55281
                </p>
            </div>
        </div>

        <!-- Produk -->
        <div class="p-3 mb-4 rounded-3 d-flex align-items-center justify-content-between" style="background-color: #fefcf6; border: 1px solid #cbbf9b;">
            <div>
                <h5 class="fw-bold mb-3">Bakpia Durian</h5>
                <img src="{{ asset('images/bakpia-durian.jpg') }}" alt="Bakpia Durian" class="rounded-3 shadow-sm" width="150">
            </div>
        </div>

        <!-- Total -->
        <div class="text-end">
            <p class="fw-semibold text-secondary mb-0">Total Pesanan : <span class="fw-bold text-dark">250.000</span></p>
        </div>
    </div>
</div>
@endsection
