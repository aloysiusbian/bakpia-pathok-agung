@extends('templates.app')

@section('title', 'Home')

@section('content')

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
                        <img src="{{ asset('images/bakpiaa.png') }}" class="d-block w-100"
                            alt="Bakpia Pathok Agung">
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
    @php
        $products = [
            [
                'id' => 1,
                'nama' => 'Bakpia Durian',
                'deskripsi' => 'Rasa durian legit dan lembut',
                'harga' => 250000,
                'stok' => 100,
                'rating' => 4.9,
                'gambar' => 'images/bakpiadurian.png',
            ],
            [
                'id' => 2,
                'nama' => 'Bakpia Coklat',
                'deskripsi' => 'Rasa coklat manis lezat',
                'harga' => 150000,
                'stok' => 100,
                'rating' => 4.5,
                'gambar' => 'images/bakpiacoklat.png',
            ],
            [
                'id' => 3,
                'nama' => 'Bakpia Kacang Hijau',
                'deskripsi' => 'Isi kacang hijau gurih dan manis',
                'harga' => 99000,
                'stok' => 120,
                'rating' => 4.8,
                'gambar' => 'images/bakpiakacanghijau.png',
            ],
            [
                'id' => 4,
                'nama' => 'Bakpia Keju',
                'deskripsi' => 'Rasa keju lembut dan creamy',
                'harga' => 99000,
                'stok' => 90,
                'rating' => 4.7,
                'gambar' => 'images/bakpiakeju.png',
            ],
        ];
    @endphp

    <div class="container py-4">
        <div class="products">
            @forelse ($products as $product)
                <div class="product-card">
                    
                    <img src="{{ !empty($product['gambar']) ? asset($product['gambar']) : 'https://via.placeholder.com/300x200/A0522D/FFFFFF?text=Bakpia' }}"
                        alt="{{ $product['nama'] }}">

                    <div class="product-info"> 
                        <div class="product-name">{{ $product['nama'] }}</div>
                        <div class="product-stock">Stok : {{ $product['stok'] }}</div>
                        <div class="product-rating">Rating : {{ $product['rating'] }} ⭐</div>
                        <div class="product-price">Rp{{ number_format($product['harga'], 0, ',', '.') }}</div>
                    </div>
                </div>
            @empty
                <p style="text-align: center; width: 100%;">Tidak ada produk yang ditampilkan.</p>
            @endforelse
        </div>
    </div>
</main>
@endsection

