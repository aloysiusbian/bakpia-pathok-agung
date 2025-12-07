@extends('templates.app')

@section('title', 'Status Pembayaran Pesanan ' . $order->nomorPesanan)

@section('content')
@extends('templates.app')

@section('content')
<div class="container text-center" style="margin-top: 100px; margin-bottom: 100px;">
    <div class="card shadow-sm border-0 mx-auto" style="max-width: 500px; border-radius: 15px; background-color: #fff;">
        <div class="card-body p-5">
            <div style="font-size: 5rem; color: #28a745; margin-bottom: 20px;">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            
            <h2 class="fw-bold mb-3">Bukti Diterima!</h2>
            <p class="text-muted mb-4">
                Terima kasih, Kak! Bukti pembayaran untuk pesanan <strong>{{ $order->nomorPesanan }}</strong> sudah masuk ke sistem kami.
            </p>

            <div class="alert alert-warning" role="alert" style="font-size: 0.9rem; background-color: #fff3cd; border-color: #ffecb5;">
                <i class="bi bi-hourglass-split me-2"></i>
                Mohon tunggu, tim kami sedang mengecek mutasi bank. Proses ini biasanya memakan waktu 10-30 menit.
            </div>

            <div class="d-grid gap-2 mt-4">
                <a href="{{ url('/pesanan-saya') }}" class="btn btn-dark" style="border-radius: 10px; padding: 12px;">
                    Cek Status Pesanan
                </a>
                <a href="{{ url('/') }}" class="btn btn-outline-secondary" style="border-radius: 10px; padding: 12px;">
                    Belanja Lagi
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
