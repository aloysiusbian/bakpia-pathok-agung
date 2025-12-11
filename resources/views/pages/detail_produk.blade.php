@extends('templates.app')

@section('title', 'Detail Produk: ' . $produk->namaProduk)

@section('content')

<div class="container my-4" style="background-color:#fbf3df; border-radius:10px; padding:20px;">
    <div class="row">
        <!-- KOLOM KIRI (Info Produk Dinamis) -->
        <div class="col-lg-8 mb-3">
            <div class="card p-3">
                <div class="row g-3">
                    <div class="col-md-5 text-center position-relative">
                        {{-- Gambar utama: abu-abu + overlay jika stok habis --}}
                        <img src="{{ asset('images/' . $produk->gambar) }}" alt="{{ $produk->namaProduk }}"
                             class="img-fluid rounded product-img-detail {{ $produk->stok <= 0 ? 'out' : '' }}"
                             onerror="this.onerror=null;this.src='https://placehold.co/400x400/A0522D/FFFFFF?text=Gambar+Tidak+Ada';">

                        @if($produk->stok <= 0)
                            <img
                                src="{{ asset('images/soldout.png') }}"
                                alt="Sold Out"
                                class="soldout-badge"
                            >
                        @endif

                        <div class="d-flex justify-content-center mt-3 gap-2 thumbnail-scroll">
                            <img src="{{ asset('images/' . $produk->gambar) }}" alt="Thumbnail 1"
                                 class="img-thumbnail rounded thumbnail-item active"
                                 style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;"
                                 data-bs-toggle="modal" data-bs-target="#imageZoomModal">
                        </div>
                    </div>

                    <div class="col-md-7">
                        <h4>{{ $produk->namaProduk }}</h4>
                        <p class="text-warning mb-1">⭐ {{ $produk->rating }}</p>
                        <h5 class="fw-bold text-dark">Rp{{ number_format($produk->harga, 0, ',', '.') }}</h5>

                        <p class="mb-1">
                            Stok:
                            <strong id="stok-display">{{ $produk->stok }}</strong>
                            @if($produk->stok <= 0)
                                <span class="badge bg-danger ms-1">Habis</span>
                            @endif
                        </p>

                        <div class="mt-2">
                            <p class="fw-bold mb-1">Pilih Jenis:</p>
                            <div class="d-flex gap-2 flex-wrap">
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

        {{-- MODAL ZOOM GAMBAR --}}
        <div class="modal fade" id="imageZoomModal" tabindex="-1" aria-labelledby="imageZoomModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="zoomedImage" src="" class="img-fluid rounded" alt="Gambar Diperbesar">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: FORM PEMBELIAN --}}
        <div class="col-lg-4">
            <div class="sticky-purchase">
                {{-- SATU FORM, ACTION DITENTUKAN PER TOMBOL --}}
                <form method="POST">
                    @csrf
                    <input type="hidden" name="idProduk" value="{{ $produk->idProduk }}">

                    <div class="card p-3" id="purchase-card"
                         data-harga="{{ $produk->harga }}"
                         data-stok="{{ $produk->stok }}">
                        <h6 class="fw-bold mb-3">Pembelian Barang</h6>

                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('images/' . $produk->gambar) }}" width="40" class="rounded me-3"
                                 alt="{{ $produk->namaProduk }}">
                            <span class="fw-bold">{{ $produk->namaProduk }}</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2">
                            <div class="input-group" style="width: 130px;">
                                <button class="btn btn-outline-dark" type="button" id="btn-minus">-</button>
                                <input type="text" name="jumlahBarang" class="form-control text-center" value="1"
                                       id="kuantitas-input" readonly>
                                <button class="btn btn-outline-dark" type="button" id="btn-plus">+</button>
                            </div>
                            <span>Stok: <strong id="stok-display-sidebar">{{ $produk->stok }}</strong></span>
                        </div>

                        <hr class="my-3">

                        <div class="d-flex justify-content-between align-items-center">
                            <span>Subtotal:</span>
                            <h5 class="fw-bold mb-0" id="subtotal">
                                Rp{{ number_format($produk->harga, 0, ',', '.') }}
                            </h5>
                        </div>

                        <div class="d-grid gap-2 mt-3">
                            {{-- + KERANJANG --}}
                            <button type="submit"
                                    formaction="{{ route('keranjang.store') }}"
                                    class="btn btn-warning fw-bold btn-aksi-beli">
                                + Keranjang
                            </button>

                            {{-- BELI SEKARANG --}}
                            <button type="submit"
                                    formaction="{{ route('pembayaran.checkout.produk') }}"
                                    class="btn btn-outline-dark btn-aksi-beli">
                                Beli Sekarang
                            </button>
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
            <a href="{{ route('produk.show', $product->idProduk) }}" class="text-decoration-none product-link">
                <div class="product-card position-relative">

                    <img
                        src="{{ asset('images/' . $product->gambar) }}"
                        alt="{{ $product->namaProduk }}"
                        onerror="this.onerror=null;this.src='https://placehold.co/300x200/A0522D/FFFFFF?text=Bakpia';"
                        class="product-img {{ $product->stok <= 0 ? 'out' : '' }}"
                    >

                    @if($product->stok <= 0)
                        <img
                            src="{{ asset('images/soldout.png') }}"
                            alt="Sold Out"
                            class="soldout-badge"
                        >
                    @endif

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
    /* contoh style, sesuaikan dengan punyamu */

    .products {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 16px;
    }

    .product-card {
        position: relative;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        transition: transform .15s ease, box-shadow .15s ease;
    }

    .product-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    .product-img,
    .product-img-detail {
        width: 100%;
        display: block;
    }

    .soldout-badge{
        position: absolute;
        top: 10px;
        left: 10px;
        width: 140px;
        height: auto;
        z-index: 5;
        pointer-events: none;
    }

    .out{
        filter: grayscale(100%);
        opacity: .65;
    }

    .product-info {
        padding: 10px 12px 12px;
    }

    .product-name {
        font-weight: 600;
        margin-bottom: 4px;
        color: #3b2b1a;
    }

    .product-price {
        font-weight: 700;
        color: #000;
    }

    .desc-scroll {
        max-height: 160px;
        overflow-y: auto;
    }

    .sticky-purchase {
        position: sticky;
        top: 90px;
    }
</style>

{{-- SCRIPT LANGSUNG DI DALAM SECTION, TANPA @push --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const purchaseCard   = document.getElementById('purchase-card');
    if (!purchaseCard) return;

    const btnMinus       = document.getElementById('btn-minus');
    const btnPlus        = document.getElementById('btn-plus');
    const qtyInput       = document.getElementById('kuantitas-input');
    const subtotalElm    = document.getElementById('subtotal');
    const stokDisplay    = document.getElementById('stok-display');
    const stokDisplaySb  = document.getElementById('stok-display-sidebar');
    const aksiButtons    = document.querySelectorAll('.btn-aksi-beli');

    const hargaSatuan  = parseFloat(purchaseCard.dataset.harga);
    const stokTersedia = parseInt(purchaseCard.dataset.stok);

    function updateSubtotal() {
        let qty = parseInt(qtyInput.value);

        if (isNaN(qty) || qty < 1) qty = 1;
        if (qty > stokTersedia)   qty = stokTersedia;

        qtyInput.value = qty;

        const subtotal = hargaSatuan * qty;
        subtotalElm.textContent = 'Rp' + subtotal.toLocaleString('id-ID');

        if (btnPlus && btnMinus) {
            btnPlus.disabled  = (qty >= stokTersedia);
            btnMinus.disabled = (qty <= 1);
        }
    }

    // Jika stok habis: disable semua aksi beli
    function handleStokHabis() {
        if (stokTersedia <= 0) {
            if (qtyInput) qtyInput.value = 0;
            if (subtotalElm) subtotalElm.textContent = 'Rp0';

            if (btnPlus)  btnPlus.disabled  = true;
            if (btnMinus) btnMinus.disabled = true;

            aksiButtons.forEach(btn => {
                btn.disabled = true;
                btn.textContent = 'Stok Habis';
            });

            if (stokDisplay)   stokDisplay.textContent   = '0';
            if (stokDisplaySb) stokDisplaySb.textContent = '0';
        }
    }

    if (btnPlus && btnMinus) {
        btnPlus.addEventListener('click', function () {
            let currentValue = parseInt(qtyInput.value);
            if (currentValue < stokTersedia) {
                qtyInput.value = currentValue + 1;
                updateSubtotal();
            }
        });

        btnMinus.addEventListener('click', function () {
            let currentValue = parseInt(qtyInput.value);
            if (currentValue > 1) {
                qtyInput.value = currentValue - 1;
                updateSubtotal();
            }
        });
    }

    // logika thumbnail & zoom
    const mainImage   = document.querySelector('.product-img-detail');
    const thumbnails  = document.querySelectorAll('.thumbnail-item');
    const zoomedImage = document.getElementById('zoomedImage');

    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function () {
            thumbnails.forEach(item => item.classList.remove('active'));
            this.classList.add('active');

            const newDetailSrc = this.src;
            if (mainImage) {
                mainImage.src = newDetailSrc;
                mainImage.alt = this.alt;
            }

            const fullSrc = this.getAttribute('data-full-src') || this.src;
            if (zoomedImage) {
                zoomedImage.src = fullSrc;
            }
        });
    });

    handleStokHabis();
    updateSubtotal();
});
</script>

@endsection
