@extends('templates.daftar-pesanan')

@section('title', 'Pesanan Diproses')

@section('content-pesanan')

@php
$processOrders = [
[
'id_pesanan' => 'ORD-PRO-001',
'tanggal' => '23-5-2025 08:15',
'status' => 'Sedang Dikemas',
'estimasi' => 'Akan dikirim sebelum 24 Mei',
'total' => 150000,
'link_detail' => '/detailpesanan',
'produk' => [
[
'nama' => 'Bakpia Kumbu Hitam',
'gambar' => 'images/bakpia-kumbu-hitam.jpg',
'variasi' => '1 box isi 15',
'jumlah' => 2
]
]
],
[
'id_pesanan' => 'ORD-PRO-002',
'tanggal' => '23-5-2025 10:00',
'status' => 'Menunggu Kurir',
'estimasi' => 'Kurir sedang menuju toko',
'total' => 300000,
'link_detail' => '/detail-pesanan-multi',
'produk' => [
[
'nama' => 'Bakpia Keju',
'gambar' => 'images/bakpia-keju.jpg',
'variasi' => '1 box isi 15',
'jumlah' => 2
],
[
'nama' => 'Bakpia Cokelat',
'gambar' => 'images/bakpia-cokelat.jpg',
'variasi' => '1 box isi 15',
'jumlah' => 2
]
]
]
];
@endphp
<!-- 2. Container Utama List Pesanan -->
<div class="orders-container-box">

    @if(count($processOrders) > 0)
    @foreach($processOrders as $order)
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

        <!-- Tombol Aksi Khusus Dalam Proses -->
        <div class="action-buttons">
            <button class="btn btn-custom-gray" onclick="event.stopPropagation()">Hubungi Penjual</button>
        </div>
    </div>
    @endforeach
    @else
    <div class="text-center py-5">
        <h5 class="text-muted">Tidak ada pesanan yang sedang diproses.</h5>
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
