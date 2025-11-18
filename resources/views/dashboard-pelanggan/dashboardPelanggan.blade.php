@extends('templates.sidebar')

@section('title', 'Dashboard')

@section('content')
<!-- MAIN CONTENT -->
<div class="content" id="content">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card p-4 text-center">
                <i class="bi bi-basket-fill fs-2 text-success bg-light"></i>
                <h6 class="mt-2 text-muted">Total Pembelian</h6>
                <h3 class="fw-bold">12</h3>
                <small class="text-success">+2 pesanan baru minggu ini</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 text-center">
                <i class="bi bi-cart-check fs-2 text-primary bg-light"></i>
                <h6 class="mt-2 text-muted">Pesanan Aktif</h6>
                <h3 class="fw-bold">3</h3>
                <small class="text-warning">Sedang diproses</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 text-center">
                <i class="bi bi-cash-stack fs-2 text-danger bg-light"></i>
                <h6 class="mt-2 text-muted">Total Pengeluaran</h6>
                <h3 class="fw-bold">Rp 450.000</h3>
                <small class="text-muted">Bulan ini</small>
            </div>
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
