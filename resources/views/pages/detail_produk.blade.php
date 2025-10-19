@extends('templates.app')

@section('title', 'Detail')

@section('content')

    <div class="jumbotron-container bg-light-subtle py-5">
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
<div class="container my-4" style="background-color:#fbf3df; border-radius:10px; padding:20px;">

  <div class="row">
    <!-- KOLOM KIRI (Gambar + Info Produk) -->
    <div class="col-lg-8 mb-3">
      <div class="card p-3">
        <div class="row g-3">
          <!-- Gambar Produk -->
          <div class="col-md-5 text-center">
            <img src="{{ asset('images/bakpia_duren.png') }}" alt="Bakpia Durian" class="img-fluid rounded">
          </div>

          <!-- Detail Produk -->
          <div class="col-md-7">
            <h4>Bakpia Durian</h4>
            <p class="text-warning mb-1">⭐ 4.9</p>
            <h5 class="fw-bold text-dark">Rp250.000</h5>

            <div class="mt-2">
              <p class="fw-bold mb-1">Pilih Jenis:</p>
              <div class="d-flex gap-2">
                <button class="btn btn-outline-dark btn-sm">10</button>
                <button class="btn btn-outline-dark btn-sm">15</button>
                <button class="btn btn-outline-dark btn-sm">20</button>
              </div>
            </div>

            <div class="mt-3">
              <p class="fw-bold mb-1">Deskripsi Produk :</p>
              <div class="desc-scroll">
                <p>
                  Produk ini adalah produk yang sangat mantap sehingga produk ini dapat menjadi sebuah produk
                  yang berprodukan dan produk yang produk dengan produk, produk terbagus. Maka dari itu produk
                  ini harus dibeli, selamat berproduksi jaya.
                </p>
                <p>
                  Produk ini adalah produk yang sangat mantap sehingga produk ini dapat menjadi sebuah produk
                  yang berprodukan dan produk yang produk dengan produk, produk terbagus. Maka dari itu produk
                  ini harus dibeli, selamat berproduksi jaya.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- KOLOM KANAN (Pembelian Barang) -->
    <div class="col-lg-4">
      <div class="sticky-purchase">
        <div class="card p-3">
          <h6 class="fw-bold mb-3">Pembelian Barang</h6>
          <p><strong>10</strong>, Bakpia Durian</p>

          <p class="mb-1">Stok: <strong>100</strong></p>
          <hr>
          <p class="mb-1">Subtotal:</p>
          <h5 class="fw-bold">Rp250.000</h5>

          <div class="d-grid gap-2 mt-3">
            <button class="btn btn-outline-dark">+ Keranjang</button>
            <button class="btn btn-dark">Beli Sekarang</button>
          </div>
        </div>
      </div>
    </div>
  </div> <!-- ✅ Penutup .row di sini -->

  <!-- PRODUK LAINNYA (masih di dalam container tapi di luar row) -->
  <hr class="my-4">
  <h5 class="fw-bold mb-3">Produk Lainnya</h5>
  <div class="row g-3">
     @php
        $products = [
            [
                'id' => 1,
                'nama' => 'Bakpia Durian',
                'deskripsi' => 'Rasa durian legit dan lembut',
                'harga' => 250000,
                'stok' => 100,
                'rating' => 4.9,
                'gambar' => 'images/bakpia_duren.png',
            ],
            [
                'id' => 2,
                'nama' => 'Bakpia Coklat',
                'deskripsi' => 'Rasa coklat manis lezat',
                'harga' => 150000,
                'stok' => 100,
                'rating' => 4.5,
                'gambar' => 'images/bakpia_coklat.png',
            ],
            [
                'id' => 3,
                'nama' => 'Bakpia Kacang Hijau',
                'deskripsi' => 'Isi kacang hijau gurih dan manis',
                'harga' => 99000,
                'stok' => 120,
                'rating' => 4.8,
                'gambar' => 'images/bakpia_ijo.png',
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

</div>

<style>
.btn-warning {
    background-color:#f5c24c;
    border:none;
}
.btn-warning:hover {
    background-color:#e0ad2f;
}
.btn-outline-dark:hover {
    background-color:#000;
    color:#fff;
}
.desc-scroll {
    max-height: 160px;
    overflow-y: auto;
    padding-right: 10px;
    scrollbar-width: thin;
    scrollbar-color: #c1a45f #f5f0df;
}
.desc-scroll::-webkit-scrollbar {
    width: 6px;
}
.desc-scroll::-webkit-scrollbar-thumb {
    background-color: #c1a45f;
    border-radius: 10px;
}
.desc-scroll::-webkit-scrollbar-track {
    background: #f5f0df;
}
.card {
  background-color: #fdf5e6 !important; /* warna cream lembut */
  border: none;
}

.sticky-purchase {
    position: sticky;
    top: 100px; /* jarak dari atas saat berhenti */
}
.products {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 25px;
}

.product-card {
    background-color: #f8f9fa;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    border: 1px solid #dee2e6;
}

.product-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.product-info {
    padding: 15px;
    text-align: left;
    font-family: Arial, sans-serif;
}

.product-name {
    font-size: 1rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 8px;
}

.product-stock,
.product-rating {
    font-size: 0.85rem;
    color: #6c757d;
    margin-bottom: 4px;
}

.product-price {
    font-size: 1.1rem;
    font-weight: bold;
    color: #212529;
    margin-top: 8px;
}


</style>
@endsection
