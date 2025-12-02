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

<!-- Style Tambahan untuk Popup Modal -->
<style>
    .modal-content-custom {
        background-color: #fbf3df; /* Menyesuaikan background */
        border-radius: 15px;
        border: 1px solid #7a7a7a;
    }
    .modal-header {
        border-bottom: 1px solid #d1c7b0;
    }
    .modal-footer {
        border-top: 1px solid #d1c7b0;
    }
    .btn-confirm-cancel {
        background-color: #dc3545;
        color: white;
        border-radius: 6px;
        border: none;
        padding: 8px 20px;
    }
    .btn-confirm-cancel:hover {
        background-color: #bb2d3b;
        color: white;
    }
</style>

<!-- 2. Container Utama List Pesanan -->
<div class="orders-container-box">

    @if(count($unpaidOrders) > 0)
    @foreach($unpaidOrders as $order)
    <!-- Kartu Transaksi -->
    <div class="transaction-card" onclick="window.location.href='pembayaran'">

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
            
            <!-- Tombol Utama: Bayar Sekarang -->
            <button class="btn btn-custom-gray" 
                    onclick="event.stopPropagation(); window.location.href='/pembayaran/process'">
                Bayar Sekarang
            </button>
            
            <!-- MODIFIKASI: Tombol ini sekarang memanggil fungsi showCancelModal -->
            <button class="btn btn-custom-gray" 
                    onclick="event.stopPropagation(); showCancelModal('')">
                Batalkan Pesanan
            </button>
        </div>
    </div>
    @endforeach
    @else
    <div class="text-center py-5">
        <h5 class="text-muted">Tidak ada tagihan yang belum dibayar.</h5>
    </div>
    @endif

</div>

<!-- TAMBAHAN: MODAL POPUP HTML -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="cancelModalLabel">Batalkan Pesanan?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin membatalkan pesanan ini? <br> <span class="text-muted small">Pesanan yang dibatalkan tidak dapat dikembalikan.</span></p>
                <!-- Hidden input untuk menyimpan ID pesanan sementara -->
                <input type="hidden" id="orderIdToCancel">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Tidak, Kembali</button>
                <button type="button" class="btn btn-confirm-cancel" onclick="processCancellation()">Ya, Batalkan Pesanan</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi simulasi aktif tab (bawaan program Anda)
    function setActive(element) {
        const items = document.querySelectorAll('.nav-item-custom');
        items.forEach(item => {
            item.classList.remove('active');
        });
        element.classList.add('active');
    }
    
    // 1. Munculkan Modal
    function showCancelModal(orderId) {
        // Simpan ID pesanan agar kita tahu mana yang mau dihapus saat tombol "Ya" diklik
        document.getElementById('orderIdToCancel').value = orderId;
        
        // Tampilkan modal menggunakan Bootstrap
        var myModal = new bootstrap.Modal(document.getElementById('cancelOrderModal'));
        myModal.show();
    }

    // 2. Proses Pembatalan (Saat klik Ya)
    function processCancellation() {
        var orderId = document.getElementById('orderIdToCancel').value;
        
        
        alert("Pesanan " + orderId + " berhasil dibatalkan.");
        
        // Refresh halaman
        location.reload(); 
    }
</script>

@endsection