<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Toko Bakpia Agung')</title>

    {{-- Link CSS Bootstrap (atau CSS framework lain yang Anda gunakan) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- Anda bisa menambahkan link ke file CSS kustom Anda di sini --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
</head>
<body>
@extends('templates.app')

@section('title', 'Detail Produk: ' . $produk->namaProduk)

@section('content')

    {{-- Jumbotron bisa Anda sesuaikan atau biarkan --}}
    <div class="jumbotron-container bg-light-subtle py-5">
        {{-- ... Isi Jumbotron ... --}}
    </div>
    
<div class="container my-4" style="background-color:#fbf3df; border-radius:10px; padding:20px;">
    <div class="row">
        <!-- KOLOM KIRI (Info Produk Dinamis) -->
        <div class="col-lg-8 mb-3">
            <div class="card p-3">
                <div class="row g-3">
                    <div class="col-md-5 text-center">
                        <img src="{{ asset('images/' . $produk->gambar) }}" alt="{{ $produk->namaProduk }}" class="img-fluid rounded" onerror="this.onerror=null;this.src='https://placehold.co/400x400/A0522D/FFFFFF?text=Gambar+Tidak+Ada';">
                    </div>
                    <div class="col-md-7">
                        <h4>{{ $produk->namaProduk }}</h4>
                        <p class="text-warning mb-1">⭐ {{ $produk->rating }}</p>
                        <h5 class="fw-bold text-dark">Rp{{ number_format($produk->harga, 0, ',', '.') }}</h5>
                        <div class="mt-2">
                            <p class="fw-bold mb-1">Pilih Jenis:</p>
                            <div class="d-flex gap-2">
                                @foreach(explode(',', $produk->pilihanJenis) as $jenis)
                                    <button class="btn btn-outline-dark btn-sm">{{ trim($jenis) }}</button>
                                @endforeach
                            </div>
                        </div>
                        <div class="mt-3">
                            <p class="fw-bold mb-1">Deskripsi Produk :</p>
                            <div class="desc-scroll">
                                <p>{!! nl2br(e($produk->deskripsiProduk)) !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN (Pembelian Barang Interaktif) -->
        <div class="col-lg-4">
            <div class="sticky-purchase">
                <form action="{{ route('keranjang.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="idProduk" value="{{ $produk->idProduk }}">
                    
                    <div class="card p-3" id="purchase-card" data-harga="{{ $produk->harga }}" data-stok="{{ $produk->stok }}">
                        <h6 class="fw-bold mb-3">Pembelian Barang</h6>
                        
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('images/' . $produk->gambar) }}" width="40" class="rounded me-3" alt="{{$produk->namaProduk}}">
                            <span class="fw-bold">{{ $produk->namaProduk }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center my-2">
                            <div class="input-group" style="width: 130px;">
                                <button class="btn btn-outline-dark" type="button" id="btn-minus">-</button>
                                <input type="text" name="kuantitas" class="form-control text-center" value="1" id="kuantitas-input" readonly>
                                <button class="btn btn-outline-dark" type="button" id="btn-plus">+</button>
                            </div>
                            <span>Stok: <strong id="stok-display">{{ $produk->stok }}</strong></span>
                        </div>
                        
                        <hr class="my-3">
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Subtotal:</span>
                            <h5 class="fw-bold mb-0" id="subtotal">Rp{{ number_format($produk->harga, 0, ',', '.') }}</h5>
                        </div>

                        <div class="d-grid gap-2 mt-3">
                            <button type="submit" class="btn btn-warning fw-bold">+ Keranjang</button>
                            <button type="button" class="btn btn-outline-dark">Beli Sekarang</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> <!-- .row -->

    <!-- PRODUK LAINNYA (Dinamis) -->
    <hr class="my-4">
    <h5 class="fw-bold mb-3">Produk Lainnya</h5>
    <div class="products">
        @forelse ($produksLainnya as $product)
            <a href="{{ route('produk.show', $product->idProduk) }}" class="text-decoration-none">
                <div class="product-card">
                    <img src="{{ asset('images/' . $product->gambar) }}" alt="{{ $product->namaProduk }}" onerror="this.onerror=null;this.src='https://placehold.co/300x200/A0522D/FFFFFF?text=Bakpia';">
                    <div class="product-info"> 
                        <div class="product-name">{{ $product->namaProduk }}</div>
                        <div class="product-stock">Stok : {{ $product->stok }}</div>
                        <div class="product-rating">Rating : {{ $product->rating }} ⭐</div>
                        <div class="product-price">Rp{{ number_format($product->harga, 0, ',', '.') }}</div>
                    </div>
                </div>
            </a>
        @empty
            <p style="text-align: center; width: 100%;">Tidak ada produk lain yang ditampilkan.</p>
        @endforelse
    </div>
</div>

<style>
/* ... (Style Anda tetap di sini, tidak perlu diubah) ... */
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    console.log('Script Dijalankan!'); // <-- DEBUG 1

    const purchaseCard = document.getElementById('purchase-card');
    console.log('Purchase Card ditemukan?', purchaseCard); // <-- DEBUG 2

    if (!purchaseCard) {
        console.error('ERROR: Element dengan ID "purchase-card" tidak ditemukan. Script berhenti.');
        return;
    }

    const btnMinus = document.getElementById('btn-minus');
    const btnPlus = document.getElementById('btn-plus');
    const kuantitasInput = document.getElementById('kuantitas-input');
    console.log('Tombol Plus ditemukan?', btnPlus); // <-- DEBUG 3
    console.log('Tombol Minus ditemukan?', btnMinus); // <-- DEBUG 4

    const subtotalElement = document.getElementById('subtotal');
    
    const hargaSatuan = parseFloat(purchaseCard.dataset.harga);
    const stokTersedia = parseInt(purchaseCard.dataset.stok);
    console.log('Harga Satuan:', hargaSatuan, 'Stok:', stokTersedia); // <-- DEBUG 5

    function updateSubtotal() {
        let kuantitas = parseInt(kuantitasInput.value);
        if (isNaN(kuantitas) || kuantitas < 1) { kuantitas = 1; }
        if (kuantitas > stokTersedia) { kuantitas = stokTersedia; }
        kuantitasInput.value = kuantitas;
        const subtotal = hargaSatuan * kuantitas;
        subtotalElement.textContent = 'Rp' + subtotal.toLocaleString('id-ID');
        btnPlus.disabled = (kuantitas >= stokTersedia);
        btnMinus.disabled = (kuantitas <= 1);
    }

    if(btnPlus && btnMinus) {
        btnPlus.addEventListener('click', function () {
            console.log('Tombol Plus diklik!'); // <-- DEBUG 6
            let currentValue = parseInt(kuantitasInput.value);
            if (currentValue < stokTersedia) {
                kuantitasInput.value = currentValue + 1;
                updateSubtotal();
            }
        });

        btnMinus.addEventListener('click', function () {
            console.log('Tombol Minus diklik!'); // <-- DEBUG 7
            let currentValue = parseInt(kuantitasInput.value);
            if (currentValue > 1) {
                kuantitasInput.value = currentValue - 1;
                updateSubtotal();
            }
        });
    }
    
    updateSubtotal();
});
</script>
@endpush
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>
</html>
