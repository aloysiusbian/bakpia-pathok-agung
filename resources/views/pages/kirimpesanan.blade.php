@extends('templates.daftar-pesanan')

@section('title', 'Pesanan Dikirim')

@section('content-pesanan')

@php
$shippedOrders = [
[
'id_pesanan' => 'ORD-SHIP-001',
'tanggal' => '22-5-2025 09:00',
'status' => 'Sedang Dikirim',
'estimasi' => 'Estimasi tiba: 23 Mei',
'total' => 250000,
'link_detail' => '/detailpesanan',
'produk' => [
[
'nama' => 'Bakpia Kacang Hijau',
'gambar' => 'images/bakpia-kacang-hijau.jpg',
'variasi' => '1 box isi 15',
'jumlah' => 4
]
]
],
[
'id_pesanan' => 'ORD-SHIP-002',
'tanggal' => '22-5-2025 08:30',
'status' => 'Sedang Dikirim',
'estimasi' => 'Estimasi tiba: 24 Mei',
'total' => 405000,
'link_detail' => '/detail-pesanan-multi',
'produk' => [
[
'nama' => 'Bakpia Cokelat',
'gambar' => 'images/bakpia-cokelat.jpg',
'variasi' => '1 box isi 15',
'jumlah' => 2
],
[
'nama' => 'Bakpia Keju',
'gambar' => 'images/bakpia-keju.jpg',
'variasi' => '1 box isi 15',
'jumlah' => 3
]
]
]
];
@endphp
<!-- 2. Container Utama List Pesanan -->
<div class="orders-container-box">

    @if(count($shippedOrders) > 0)
    @foreach($shippedOrders as $order)
    <!-- Kartu Transaksi -->
    <div class="transaction-card" onclick="window.location.href=''">

        <div class="transaction-header">
            <div class="text-muted">{{ $order['tanggal'] }}</div>
            <div>
                <span class="status-badge">{{ $order['status'] }}</span>
                <span class="estimasi-text">({{ $order['estimasi'] }})</span>
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
            <span class="total-label">Total Pesanan :</span>
            <span class="total-amount">Rp {{ number_format($order['total'], 0, ',', '.') }}</span>
        </div>

        <!-- Tombol Aksi Khusus Dikirim -->
        <div class="action-buttons">
            <button class="btn btn-outline-custom" onclick="event.stopPropagation()">Lacak Pesanan</button>
            <button class="btn btn-custom-gray" onclick="event.stopPropagation()">Pesanan Diterima</button>
        </div>
    </div>
    @endforeach
    @else
    <div class="text-center py-5">
        <h5 class="text-muted">Tidak ada pesanan yang sedang dikirim.</h5>
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
