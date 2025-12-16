@extends('templates.app')

@section('title', 'Detail Pesanan')

@section('content')
<style>
    .main-order-container {
        border: 1px solid #7a7a7a;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 40px;
    }
    .info-card {
        border: 1px solid #7a7a7a;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .delivery-status { color: #4caf50; font-weight: 600; }
</style>

<div class="container py-5">
    <h2 class="fw-bold mb-4">Detail Pesanan</h2>

    <div class="main-order-container">

        {{-- Kartu 1: Info Pengiriman --}}
        <div class="info-card">
            <h5 class="fw-bold">Info pengiriman</h5>
            <div class="delivery-status">
                {{-- bisa disesuaikan kalau ada status lain --}}
                {{ $order->statusPesanan === 'selesai' ? 'Pesanan telah diterima' : ucfirst($order->statusPesanan) }}
            </div>
            <div class="text-muted small">
                {{ \Carbon\Carbon::parse($order->tanggalPemesanan)->format('d-m-Y H:i') }}
            </div>
        </div>

        {{-- Kartu 2: Alamat --}}
        <div class="info-card">
            <h5 class="fw-bold">Alamat Pengiriman</h5>
            <div class="d-flex gap-2">
                <i class="fas fa-map-marker-alt mt-1"></i>
                <p class="mb-0 small">
                    {{ $order->alamatPengirim }}
                </p>
            </div>
        </div>

        {{-- Kartu 3: Produk --}}
        <div class="info-card">
            @foreach($order->detailTransaksiOnline as $detail)
                <h5 class="fw-bold">{{ $detail->produk->namaProduk ?? 'Produk' }}</h5>

                <div class="row mb-3">
                    <div class="col-auto">
                       <img src="{{ $detail->produk->display_image ?? asset('images/bakpia-default.jpg') }}"
                             class="rounded border"
                             style="width: 120px; height: 120px; object-fit: cover;"
                             alt="{{ $detail->produk->namaProduk ?? 'Produk' }}"
                             onerror="this.src='{{ asset('images/bakpia-default.jpg') }}'">
                    </div>

                    <div class="col">
                        <div class="product-desc">
                            {{-- kalau punya field khusus, tinggal ganti --}}
                            <p class="mb-1">
                                <strong>Jumlah:</strong> x{{ $detail->jumlahBarang }}
                            </p>
                            <p class="mb-1">
                                <strong>Harga:</strong>
                                Rp {{ number_format($detail->harga, 0, ',', '.') }}
                            </p>
                            <p class="mb-1 text-muted small">
                                Subtotal:
                                Rp {{ number_format($detail->subTotal, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                @if(!$loop->last)
                    <hr>
                @endif
            @endforeach

            <div class="col text-end mt-2">
                <h5 class="fw-bold text-secondary">
                    Total Pesanan : Rp {{ number_format($order->totalNota, 0, ',', '.') }}
                </h5>
            </div>
        </div>
    
    </div>
</div>
@endsection
