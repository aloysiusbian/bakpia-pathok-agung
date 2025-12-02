@extends('templates.daftar-pesanan')

@section('title', 'Batalkan Pesanan')

@section('content-pesanan')

@php
$cancelledOrders = [
[
'id_pesanan' => 'ORD-001',
'tanggal' => '21-5-2025 15:30',
'status' => 'Dibatalkan',
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
'id_pesanan' => 'ORD-002',
'tanggal' => '19-5-2025 12:30',
'status' => 'Dibatalkan',
'total' => 275000,
'link_detail' => '/detail-pesanan-2',
'produk' => [
[
'nama' => 'Bakpia Cokelat',
'gambar' => 'images/bakpia-cokelat.jpg',
'variasi' => '1 box isi 15',
'jumlah' => 5
]
]
]
];
@endphp

<!-- 2. Container Utama List Pesanan -->
<div class="orders-container-box">

    @if(count($cancelledOrders) > 0)
    @foreach($cancelledOrders as $order)
    <!-- Kartu Transaksi -->
    <div class="transaction-card" onclick="window.location.href=''">

        <!-- Hanya menampilkan Status saja -->
        <div class="transaction-date">
            <span class="status-badge-cancel">{{ $order['status'] }}</span>
        </div>

        <!-- Loop Produk dalam satu pesanan -->
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

        <!-- Tombol Aksi -->
        <div class="action-buttons">
            <button class="btn btn-custom-gray" onclick="event.stopPropagation()">Beli Lagi</button>
        </div>
    </div>
    @endforeach
    @else
    <div class="text-center py-5">
        <h5 class="text-muted">Tidak ada pesanan yang dibatalkan.</h5>
    </div>
    @endif

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
