@extends('templates.app')

@section('title', 'Home')

@section('content')
    <div class="jumbotron-container py-4">
        <div class="container-fluid overflow-hidden" style="border-radius: 20px;">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
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

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

    <main>
        {{-- DATA DUMMY PRODUK TERLARIS --}}
        @php
            $bestSeller = [
                [
                    'idProduk' => 4,
                    'namaProduk' => 'Bakpia Keju',
                    'harga' => 300000,
                    'rating' => 5.0,
                    'gambar' => 'bakpia-keju.jpg',
                ],
                [
                    'idProduk' => 1,
                    'namaProduk' => 'Bakpia Cokelat',
                    'harga' => 200000,
                    'rating' => 4.9,
                    'gambar' => 'bakpia-cokelat.jpg',
                ],
            ];
        @endphp

        {{-- SECTION PRODUK TERLARIS --}}
        <div class="container py-3">
            <div class="section-header">Best Seller</div>

            <div class="products">
                @foreach ($bestSeller as $product)
                    <a href="{{ route('produk.show', $product['idProduk']) }}" class="product-link">
                        <div class="product-card">
                            <img
                                src="{{ !empty($product['gambar']) ? asset('images/' . $product['gambar']) : 'https://via.placeholder.com/300x200/A0522D/FFFFFF?text=Best+Seller' }}"
                                alt="{{ $product['namaProduk'] }}"
                            >
                            <div class="product-info">
                                <div class="product-name">{{ $product['namaProduk'] }}</div>
                                <div class="product-rating">Rating : {{ $product['rating'] }} ⭐</div>
                                <div class="product-price">Rp{{ number_format($product['harga'], 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- SECTION PRODUK LAINNYA --}}
        <div class="container py-4">
            <div class="section-header">Produk Lainnya</div>

            <div class="products">
                @foreach ($products as $product)
                    <a href="{{ route('produk.show', $product->idProduk) }}" class="product-link">

                        {{-- penting: position-relative untuk overlay --}}
                        <div class="product-card position-relative">

                            
                            <img
                                src="{{ !empty($product->gambar) ? asset('images/' . $product->gambar) : 'https://via.placeholder.com/300x200/A0522D/FFFFFF?text=Bakpia' }}"
                                alt="{{ $product->namaProduk }}"
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
                @endforeach
            </div>
        </div>
    </main>

    {{-- CSS cepat (boleh pindah ke file CSS kamu) --}}
    <style>
        .product-card { position: relative; }
        .product-img { width: 100%; display: block; }

        .soldout-badge{
            position: absolute;
            top: 10px;
            left: 10px;
            width: 140px; /* sesuaikan */
            height: auto;
            z-index: 5;
            pointer-events: none;
        }

        .product-img.out{
            filter: grayscale(100%);
            opacity: .65;
        }
    </style>
@endsection
