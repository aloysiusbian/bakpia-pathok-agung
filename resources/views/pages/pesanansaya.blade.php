@extends('templates.daftar-pesanan')

@section('title', 'Pesanan Selesai')

@section('content-pesanan')

@php
$finishOrders = [
[
'id_pesanan' => 'ORD-001',
'tanggal' => '21-5-2025 15:30',
'status' => 'Selesai',
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
'status' => 'Selesai',
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
],
// Contoh jika ada pesanan dengan lebih dari 1 produk
[
'id_pesanan' => 'ORD-003',
'tanggal' => '18-5-2025 09:00',
'status' => 'Selesai',
'total' => 150000,
'link_detail' => '/detail-pesanan-3',
'produk' => [
[
'nama' => 'Bakpia Kumbu Hitam',
'gambar' => 'images/bakpia-kumbu-hitam.jpg',
'variasi' => '1 box isi 15',
'jumlah' => 2
],
[
'nama' => 'Bakpia Kacang Hijau',
'gambar' => 'images/bakpia-kacang-hijau.jpg',
'variasi' => '1 box isi 15',
'jumlah' => 1
]
]
]
];
@endphp

<div class="orders-container-box">

    @if(count($finishOrders) > 0)
    @foreach($finishOrders as $order)
    <!-- Kartu Transaksi -->
    <div class="transaction-card" onclick="window.location.href='detailpesanan'">

        <!-- KEMBALI SEPERTI SEMULA: Menampilkan Tanggal dan Status -->
        <div class="transaction-date">
            {{ $order['tanggal'] }} | <span class="status-badge">{{ $order['status'] }}</span>
        </div>

        <!-- Loop Produk dalam satu pesanan -->
        @foreach($order['produk'] as $item)
        <div class="product-item">
            <img src="{{ asset($item['gambar']) }}"
                 onerror="this.src='lihatproduk'"
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
            <button class="btn btn-custom-gray" onclick="event.stopPropagation()">Beri Rating</button>
            <button class="btn btn-custom-gray" onclick="event.stopPropagation()">Beli Lagi</button>
        </div>
    </div>
    @endforeach
    @else
    <div class="text-center py-5">
        <h5 class="text-muted">Belum Ada Riwayat Pesanan.</h5>
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
