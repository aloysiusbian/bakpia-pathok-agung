@extends('templates.app')

@section('title', 'Home')

@section('content')

    {{-- Menambahkan beberapa style untuk link produk dan hover effect --}}
    <style>
        .product-link {
            text-decoration: none;
            color: inherit;
            display: block;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-link:hover .product-card {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }
    </style>

    <div class="jumbotron-container py-5">
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
        {{-- @php
            $products = [
                [
                    'idProduk' => 1,
                    'namaProduk' => 'Bakpia Durian',
                    'deskripsi' => 'Rasa durian legit dan lembut',
                    'harga' => 250000,
                    'stok' => 100,
                    'rating' => 4.9,
                    'gambar' => 'images/bakpiadurian.png',
                ],
                [
                    'idProduk' => 2,
                    'namaProduk' => 'Bakpia Coklat',
                    'deskripsi' => 'Rasa coklat manis lezat',
                    'harga' => 150000,
                    'stok' => 100,
                    'rating' => 4.5,
                    'gambar' => 'images/bakpiacoklat.png',
                ],
                [
                    'idProduk' => 3,
                    'namaProduk' => 'Bakpia Kacang Hijau',
                    'deskripsi' => 'Isi kacang hijau gurih dan manis',
                    'harga' => 99000,
                    'stok' => 120,
                    'rating' => 4.8,
                    'gambar' => 'images/bakpiakacanghijau.png',
                ],
                [
                    'idProduk' => 4,
                    'namaProduk' => 'Bakpia Keju',
                    'deskripsi' => 'Rasa keju lembut dan creamy',
                    'harga' => 99000,
                    'stok' => 90,
                    'rating' => 4.7,
                    'gambar' => 'images/bakpiakeju.png',
                ],
            ];
        @endphp --}}

        <div class="container py-4">
            <div class="products">
                @foreach ($products as $product)
                    {{-- Menambahkan anchor tag untuk membuat produk dapat diklik --}}
                    {{-- Pastikan Anda memiliki route dengan nama 'produk.show' yang menerima id produk --}}
                    <a href="{{ route('produk.show', $product->idProduk) }}" class="product-link">
                        <div class="product-card">

                            <img src="{{ !empty($product['gambar']) ? asset('images/' . $product['gambar']) : 'https://via.placeholder.com/300x200/A0522D/FFFFFF?text=Bakpia' }}"
                                alt="{{ $product['namaProduk'] }}">

                            <div class="product-info">
                                <div class="product-name">{{ $product['namaProduk'] }}</div>
                                <div class="product-stock">Stok : {{ $product['stok'] }}</div>
                                <div class="product-rating">Rating : {{ $product['rating'] }} ⭐</div>
                                <div class="product-price">Rp{{ number_format($product['harga'], 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </main>
@endsection
