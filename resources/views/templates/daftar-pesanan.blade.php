@extends('templates.app')

@section('title', '@yield("title")')

@section('content')

<style>
    /* --- Navigasi Tab Status Pesanan --- */
    .order-status-nav {
        background-color: transparent;
        border: 1px solid #7a7a7a;
        border-radius: 8px;
        padding: 15px 10px;
        margin-bottom: 30px;
        display: flex;
        justify-content: space-around;
        align-items: center;
        flex-wrap: wrap;
    }

    .nav-item-custom {
        text-decoration: none;
        color: #555;
        font-weight: 500;
        padding: 8px 18px; /* Tambah padding agar background tidak terlalu kecil */
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        border-radius: 6px; /* Tambahkan border-radius */
    }

    .nav-item-custom:hover {
        color: #000;
        background-color: rgba(122, 122, 122, 0.1); /* Hover state yang ringan */
    }

    /* Style untuk Tab Aktif: Diberi background gelap */
    .nav-item-custom.active {
        background-color: #7a7a7a; /* Warna background gelap */
        color: white; /* Ubah warna teks menjadi putih/terang agar kontras */
        font-weight: 700; /* Sedikit dikurangi agar tidak terlalu tebal */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Efek bayangan ringan */
    }

    /* --- Container Utama List Pesanan --- */

    .orders-container-box {
        border: 1px solid #7a7a7a;
        border-radius: 20px;
        padding: 30px;
        min-height: 500px;
        background-color: transparent;
    }

    /* --- Kartu Per Transaksi --- */

    .transaction-card {
        border: 1px solid #bbb;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 25px;
        background-color: rgba(255, 255, 255, 0.3);
        position: relative;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .transaction-card:hover {
        background-color: rgba(255, 255, 255, 0.6);
        border-color: #7a7a7a;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    .transaction-date {
        font-size: 0.95rem; /* Sedikit diperbesar agar jelas */
        text-align: right;
        margin-bottom: 10px;
    }

    .transaction-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        font-size: 0.9rem;
    }

    .status-badge {
        font-weight: bold;
        color: #34e820ff; /* hijau untuk selesai */
    }

    .status-badge-cancel {
        font-weight: bold;
        color: #d9534f; /* hijau untuk selesai */
    }

    .deadline-text {
        font-size: 0.8rem;
        color: #dc3545; /* Merah untuk urgency deadline */
        margin-left: 5px;
        font-style: italic;
    }

    .product-item {
        display: flex;
        gap: 20px;
        margin-bottom: 15px;
        align-items: flex-start;
    }

    .product-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #ddd;
        background-color: #fff;
    }

    .product-info {
        flex: 1;
    }

    .product-name {
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 5px;
        color: #000;
    }

    .product-variant {
        font-size: 0.9rem;
        color: #555;
        margin-bottom: 2px;
    }

    .total-section {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-top: 15px;
        margin-bottom: 15px;
        gap: 10px;
    }

    .total-label {
        font-size: 1rem;
        font-weight: 600;
        color: #555;
    }

    .total-amount {
        font-size: 1.1rem;
        font-weight: 700;
        color: #333;
    }

    /* --- Tombol Aksi --- */

    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-custom-gray {
        background-color: #E3D6B6;
        color: #000;
        border: none;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 8px 25px;
        border-radius: 6px;
        transition: background 0.2s;
    }

    .btn-custom-gray:hover {
        background-color: #f5c042;
        color: #000;
    }

    .btn-outline-danger-custom {
        border: 1px solid #dc3545;
        color: #dc3545;
        background: transparent;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 8px 20px;
        border-radius: 6px;
        transition: all 0.2s;
    }

    .btn-outline-danger-custom:hover {
        background-color: #dc3545;
        color: white;
    }

    @media (max-width: 576px) {
        .product-item {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .transaction-header {
            flex-direction: column;
            gap: 5px;
            text-align: center;
        }

        .transaction-date {
            text-align: center;
        }

        .total-section,
        .action-buttons {
            justify-content: center;
        }
    }
</style>

<div class="container py-5">

    <!-- 1. Navigasi Status Pesanan -->
    <div class="order-status-nav">
    @php
        // kalau controller tidak mengirim, pakai request('status')
        $filterStatus = $filterStatus ?? request('status');
    @endphp

    <a class="nav-item-custom {{ $filterStatus === 'preorder' ? 'active' : '' }}"
       href="{{ route('pesanan.saya', ['status' => 'preorder']) }}"
       title="Pre-Order">
        <span>Pre-Order</span>
    </a>

    <a class="nav-item-custom {{ $filterStatus === 'pending' ? 'active' : '' }}"
       href="{{ route('pesanan.saya', ['status' => 'pending']) }}"
       title="Pending">
        <span>Pending</span>
    </a>

    <a class="nav-item-custom {{ $filterStatus === 'cancel' ? 'active' : '' }}"
       href="{{ route('pesanan.saya', ['status' => 'cancel']) }}"
       title="Cancel">
        <span>Cancel</span>
    </a>

    <a class="nav-item-custom {{ $filterStatus === 'shipped' ? 'active' : '' }}"
       href="{{ route('pesanan.saya', ['status' => 'shipped']) }}"
       title="Shipped">
        <span>Shipped</span>
    </a>
    
    </div>


    @yield('content-pesanan')

</div>
<script>
    function setActive(element) {
        const items = document.querySelectorAll('.nav-item-custom');
        items.forEach(item => {
            item.classList.remove('active');
        });
        element.classList.add('active');
    }
</script>

@endsection
