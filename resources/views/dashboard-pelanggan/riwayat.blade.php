@extends('templates.sidebar')

@section('title', 'Riwayat Pemesanan')

@section('content')
@php
// Simulasi data pelanggan
$customer = [
'nama' => 'Alberto Sahara',
'gambar' => asset('images/bian.png')
];

// Simulasi data riwayat pembelian
$orders = [
[
'kode' => 'ORD-001',
'tanggal' => '2025-10-25',
'produk' => 'Bakpia Kacang Hijau (Isi 15)',
'jumlah' => 2,
'total' => 70000,
'status' => 'Selesai'
],
[
'kode' => 'ORD-002',
'tanggal' => '2025-10-28',
'produk' => 'Bakpia Keju (Isi 10)',
'jumlah' => 1,
'total' => 40000,
'status' => 'Dalam Proses'
],
[
'kode' => 'ORD-003',
'tanggal' => '2025-11-02',
'produk' => 'Bakpia Coklat (Isi 15)',
'jumlah' => 3,
'total' => 105000,
'status' => 'Dibatalkan'
],
];
@endphp

<!-- CONTENT -->
<div class="content" id="content">
    <div class="card p-4">
        <h5 class="mb-3">Daftar Transaksi</h5>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                <tr>
                    <th>Kode Pesanan</th>
                    <th>Tanggal</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{ $order['kode'] }}</td>
                    <td>{{ $order['tanggal'] }}</td>
                    <td>{{ $order['produk'] }}</td>
                    <td>{{ $order['jumlah'] }}</td>
                    <td>Rp {{ number_format($order['total'], 0, ',', '.') }}</td>
                    <td>
                        @if ($order['status'] === 'Selesai')
                        <span class="status-selesai"><i class="bi bi-check-circle"></i> {{ $order['status'] }}</span>
                        @elseif ($order['status'] === 'Dalam Proses')
                        <span class="status-proses"><i class="bi bi-hourglass-split"></i> {{ $order['status'] }}</span>
                        @else
                        <span class="status-batal"><i class="bi bi-x-circle"></i> {{ $order['status'] }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const navbar = document.getElementById('navbar');
    const content = document.getElementById('content');
    const toggleBtn = document.getElementById('toggle-btn');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        navbar.classList.toggle('collapsed');
        content.classList.toggle('collapsed');
    });
</script>

@endsection
