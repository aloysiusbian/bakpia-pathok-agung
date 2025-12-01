@extends('templates.app')

@section('title', 'Pesanan Belum Bayar')

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
        font-weight: 600;
        padding: 5px 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .nav-item-custom:hover {
        color: #000;
    }

    /* Style untuk Tab Aktif */
    .nav-item-custom.active {
        color: #000;
        font-weight: 800;
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

    .transaction-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        font-size: 0.9rem;
    }

    .status-badge {
        font-weight: bold;
        color: #fd7e14; /* Oranye terang untuk belum bayar */
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
        .total-section,
        .action-buttons {
            justify-content: center;
        }
    }
</style>

{{-- Data Simulasi untuk Pesanan Belum Bayar --}}
@php
    $unpaidOrders = [
        [
            'id_pesanan' => 'ORD-UNPAID-001',
            'tanggal' => '24-5-2025 09:00',
            'status' => 'Menunggu Pembayaran',
            'deadline' => 'Bayar sebelum 25 Mei 09:00',
            'total' => 250000,
            'link_detail' => '/detailpesanan',
            'produk' => [
                [
                    'nama' => 'Bakpia Keju',
                    'gambar' => 'images/bakpia-keju.jpg',
                    'variasi' => '1 box isi 15',
                    'jumlah' => 4
                ]
            ]
        ],
        [
            'id_pesanan' => 'ORD-UNPAID-002',
            'tanggal' => '24-5-2025 08:30',
            'status' => 'Menunggu Pembayaran',
            'deadline' => 'Bayar sebelum 25 Mei 08:30',
            'total' => 145000,
            'link_detail' => '/detail-pesanan-multi',
            'produk' => [
                [
                    'nama' => 'Bakpia Kumbu Hitam',
                    'gambar' => 'images/bakpia-kumbu-hitam.jpg',
                    'variasi' => '1 box isi 15',
                    'jumlah' => 3
                ]
            ]
        ]
    ];
@endphp

<div class="container py-5">

    <!-- 1. Navigasi Status Pesanan -->
    <div class="order-status-nav">
        <!-- Tab Belum Bayar Aktif -->
        <a href="bayarpesanan" class="nav-item-custom active" onclick="setActive(this)">Belum Bayar</a>
        <a href="dalamproses" class="nav-item-custom" onclick="setActive(this)">Dalam Proses</a>
        <a href="batalkanpesanan" class="nav-item-custom" onclick="setActive(this)">Dibatalkan</a>
        <a href="kirimpesanan" class="nav-item-custom" onclick="setActive(this)">Dikirim</a>
        <a href="tespesanan" class="nav-item-custom" onclick="setActive(this)">Selesai</a>
    </div>

    <!-- 2. Container Utama List Pesanan -->
    <div class="orders-container-box">

        @if(count($unpaidOrders) > 0)
            @foreach($unpaidOrders as $order)
                <!-- Kartu Transaksi -->
                <div class="transaction-card" onclick="window.location.href=''">
                    
                    <div class="transaction-header">
                        <div class="text-muted">{{ $order['tanggal'] }}</div>
                        <div>
                            <span class="status-badge">{{ $order['status'] }}</span>
                            <!-- Menampilkan Deadline Pembayaran -->
                            <span class="deadline-text">({{ $order['deadline'] }})</span>
                        </div>
                    </div>

                    <!-- Loop Produk -->
                    @foreach($order['produk'] as $item)
                        <div class="product-item">
                            <img src="{{ asset($item['gambar']) }}" 
                                 onerror="this.src='https://via.placeholder.com/100x100?text=Produk'"
                                 alt="{{ $item['nama'] }}" 
                                 class="product-img">
                            <div class="product-info">
                                <div class="product-name">{{ $item['nama'] }}</div>
                                <div class="product-variant">Variasi : {{ $item['variasi'] }}</div>
                                <div class="product-variant">x{{ $item['jumlah'] }}</div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Total Harga -->
                    <div class="total-section {{ count($order['produk']) > 1 ? 'border-top pt-3' : '' }}">
                        <span class="total-label">Total Belanja :</span>
                        <span class="total-amount">Rp {{ number_format($order['total'], 0, ',', '.') }}</span>
                    </div>

                    <!-- Tombol Aksi Khusus Belum Bayar -->
                    <div class="action-buttons">
                        <!-- Opsional: Tombol Batalkan -->
                        <!-- <button class="btn btn-outline-danger-custom" onclick="event.stopPropagation()">Batalkan</button> -->
                        
                        <!-- Tombol Utama: Bayar Sekarang -->
                        <button class="btn btn-custom-gray" onclick="event.stopPropagation()">Bayar Sekarang</button>
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center py-5">
                <h5 class="text-muted">Tidak ada tagihan yang belum dibayar.</h5>
            </div>
        @endif

    </div>
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