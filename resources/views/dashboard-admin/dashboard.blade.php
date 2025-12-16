@extends('templates.sidebar-admin')

@section('title', 'Dashboard Admin')

@section('content')

    <!-- MAIN CONTENT -->
    <div class="content" id="content">
        <div class="row g-4">
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <div class="card summary-card p-3 shadow-sm bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-uppercase fw-semibold text-primary">Total Pesanan Hari Ini</small>
                                <h3 class="mb-0">{{ $summary['total_today'] ?? 0 }}</h3>
                                <small>Online (website + aplikasi)</small>
                            </div>
                            <i class="bi bi-cart4 fs-1 opacity-75 text-primary"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card summary-card p-3 shadow-sm bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-uppercase fw-semibold text-success">Sudah Dibayar</small>
                                <h3 class="mb-0">{{ $summary['paid_count'] ?? 0 }}</h3>
                                <small>Nilai: Rp {{ number_format($summary['paid_amount'] ?? 0, 0, ',', '.') }}</small>
                            </div>
                            <i class="bi bi-check-circle fs-1 opacity-75 text-success"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card summary-card p-3 shadow-sm bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-uppercase fw-semibold text-danger">Menunggu Pembayaran</small>
                                <h3 class="mb-0">{{ $summary['pending_count'] ?? 0 }}</h3>
                                <small>Segera follow-up pelanggan</small>
                            </div>
                            <i class="bi bi-hourglass-split fs-1 opacity-75 text-danger"></i>
                        </div>
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