@extends('templates.app')

@section('title', 'Home')

@section('content')
    <div class="jumbotron-container py-4">
        <div class="container-fluid overflow-hidden" style="border-radius: 20px;">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                            class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                </div>

                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('images/bakpiaa.png') }}" class="d-block w-100" alt="Bakpia Pathok Agung">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/bakpiaa.png') }}" class="d-block w-100" alt="Produk Wingko">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/bakpiaa.png') }}" class="d-block w-100" alt="Toko Bakpia Agung">
                    </div>
                </div>

                <button class="carousel-control-prev" type="button"
                        data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button"
                        data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

    <main>
        {{-- ===================== SECTION BEST SELLER ===================== --}}
        <div class="container py-3">
            <div class="section-header">Best Seller</div>

            <div class="products">
                @forelse ($bestSeller as $product)
                    <a href="{{ route('produk.show', $product->idProduk) }}" class="product-link">
                        <div class="product-card">

                            {{-- gambar pakai accessor display_image --}}
                            <img
                                src="{{ $product->display_image }}"
                                alt="{{ $product->namaProduk }}"
                                class="product-img {{ $product->is_out_of_stock ? 'out' : '' }}"
                            >

                            {{-- badge sold out kalau stok habis --}}
                            @if($product->is_out_of_stock)
                                <img
                                    src="{{ asset('images/soldout.png') }}"
                                    alt="Sold Out"
                                    class="soldout-badge"
                                >
                            @endif

                            <div class="product-info">
                                <div class="product-name">{{ $product->namaProduk }}</div>
                                <div class="product-rating">Rating : {{ $product->rating }} ⭐</div>
                                <div class="product-price">
                                    Rp{{ number_format($product->harga, 0, ',', '.') }}
                                </div>
                                <div class="product-sold">
                                    Terjual: {{ $product->total_terjual }}
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <p>Belum ada produk yang terjual.</p>
                @endforelse
            </div>
        </div>

        {{-- ===================== SECTION PRODUK LAINNYA ===================== --}}
        <div class="container py-4">
            <div class="section-header">Produk Lainnya</div>

            <div class="products">
                @foreach ($products as $product)
                    <a href="{{ route('produk.show', $product->idProduk) }}" class="product-link">
                        <div class="product-card">

                            {{-- gambar + efek sold out --}}
                            <img
                                src="{{ $product->display_image }}"
                                alt="{{ $product->namaProduk }}"
                                class="product-img {{ $product->is_out_of_stock ? 'out' : '' }}"
                            >

                            @if($product->is_out_of_stock)
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
                                <div class="product-price">
                                    Rp{{ number_format($product->harga, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </main>

    {{-- CSS --}}
    <style>
        .products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 16px;
        }

        .product-card {
            position: relative;          /* penting utk posisi badge */
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

        .product-img {
            width: 100%;
            display: block;
        }

        /* gambar produk kalau stok habis */
        .product-img.out {
            filter: grayscale(100%);
            opacity: .65;
        }

        /* badge STOK HABIS / soldout */
        .soldout-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 160px;
            height: auto;
            z-index: 10;               /* di atas gambar */
            pointer-events: none;
            filter: none !important;   /* jangan ikut grayscale/opacity */
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
    </style>
@endsection
