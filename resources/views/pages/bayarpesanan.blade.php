@extends('templates.daftar-pesanan')

@section('title', 'Bayar Pesanan')

@section('content-pesanan')

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
