@extends('templates.sidebar')

@section('title', 'Dashboard')

@section('content')

<!-- MAIN CONTENT -->
<div class="content" id="content">
    <div class="row g-4">
        {{-- TOTAL PEMBELIAN: hanya status shipped --}}
        <div class="col-md-4">
            <div class="card p-4 text-center">
                <i class="bi bi-basket-fill fs-2 text-success bg-light"></i>
                <h6 class="mt-2 text-muted">Total Pemesanan</h6>
                <h3 class="fw-bold">{{ $totalPembelian }}</h3>
                <small class="text-success">+{{ $baruMingguIni }} pembelian dilakukan</small>
            </div>
        </div>

        {{-- PESANAN AKTIF: status payment / pending --}}
        <div class="col-md-4">
            <div class="card p-4 text-center">
                <i class="bi bi-cart-check fs-2 text-primary bg-light"></i>
                <h6 class="mt-2 text-muted">Pesanan Aktif</h6>
                <h3 class="fw-bold">{{ $pesananAktif }}</h3>
                <small class="text-warning">Sedang diproses</small>
            </div>
        </div>

        {{-- TOTAL PENGELUARAN: sum totalNota shipped --}}
        <div class="col-md-4">
            <div class="card p-4 text-center">
                <i class="bi bi-cash-stack fs-2 text-danger bg-light"></i>
                <h6 class="mt-2 text-muted">Total Pengeluaran</h6>
                <h3 class="fw-bold">
                    Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                </h3>
                <small class="text-muted">Berdasarkan pesanan yang sudah dibayar</small>
            </div>
        </div>
    </div>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const navbar  = document.getElementById('navbar');
    const content = document.getElementById('content');
    const toggleBtn = document.getElementById('toggle-btn');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        navbar.classList.toggle('collapsed');
        content.classList.toggle('collapsed');
    });
</script>

@endsection
