@extends('templates.app')

@section('title', 'Keranjang')

@section('content')
  <main class="flex-grow-1">
    <div class="container py-4">

      {{-- Flash Message --}}
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
          {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      {{-- Grid utama: kiri keranjang, kanan ringkasan --}}
      <div class="row g-4">
        {{-- Kiri --}}
        <div class="col-lg-8">
          <h2 class="h4 fw-bold mb-3">Keranjang</h2>

          @if($items->isEmpty())
            {{-- Empty state --}}
            <div class="border rounded-3 p-4 mt-3 bg-white">
              <div class="d-flex align-items-center gap-3 py-3">
                <i class="bi bi-cart fs-1 text-secondary"></i>
                <div class="flex-grow-1">
                  <div class="fw-semibold">Keranjang belanjamu kosong!</div>
                </div>
              </div>
            </div>
          @else
            {{-- Pilih semua & Hapus --}}
            <div class="border rounded-3 p-3 bg-white mb-3 d-flex justify-content-between align-items-center">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="checkAll">
                <label class="form-check-label" for="checkAll">Pilih Semua</label>
              </div>

              {{-- Tombol Kosongkan --}}
              <form action="{{ route('keranjang.clear') }}" method="POST"
                    onsubmit="return confirm('Kosongkan keranjang?');">
                @csrf
                <button type="submit" class="btn btn-link text-danger text-decoration-none fw-bold p-0 small">
                  Hapus Semua
                </button>
              </form>
            </div>

            {{-- List Items (Looping) --}}
            <div class="d-flex flex-column gap-3">
              @foreach($items as $item)
                @php
                  $stok = $item->produk->stok ?? 0;
                  $isOut = $stok < 1;
                @endphp

                <div class="border rounded-3 p-3 bg-white shadow-sm {{ $isOut ? 'item-out' : '' }}">
                  <div class="row align-items-center">
                    {{-- Checkbox & Gambar --}}
                    <div class="col-3 col-md-2 d-flex align-items-center gap-2">
                      <input
                        class="form-check-input item-checkbox"
                        type="checkbox"
                        data-id="{{ $item->idKeranjang }}"
                        {{ $isOut ? 'disabled' : 'checked' }}
                      >

                      <div class="cart-thumb position-relative w-100">
                        <img
                          src="{{ $item->produk->display_image }}"
                          alt="{{ $item->produk->namaProduk ?? 'Produk' }}"
                          class="rounded border w-100 cart-img"
                          style="aspect-ratio: 1/1; object-fit: cover;"
                          onerror="this.onerror=null;this.src='https://placehold.co/100x100?text=Produk';"
                        >

                        @if($isOut)
                          <div class="stock-overlay">
                            <span class="badge bg-dark px-3 py-2">Stok Habis</span>
                          </div>
                        @endif
                      </div>
                    </div>

                    {{-- Info Produk --}}
                    <div class="col-9 col-md-6" style="margin-left: 20px">
                      <h6 class="fw-semibold mb-1 text-truncate">{{ $item->produk->namaProduk }}</h6>
                      <div class="text-muted small">
                        Rp{{ number_format($item->produk->harga, 0, ',', '.') }}
                      </div>

                      @if($isOut)
                        <div class="text-danger small fw-semibold mt-1">Produk sedang habis.</div>
                      @else
                        <div class="text-muted small mt-1">Stok : {{ $stok }}</div>
                      @endif

                      <div class="fw-bold text-dark mt-1">
                        Subtotal: Rp{{ number_format($item->subTotal, 0, ',', '.') }}
                      </div>
                    </div>

                    {{-- Actions (Qty & Delete) --}}
                    <div
                      class="col-12 col-md-4 mt-3 mt-md-0 d-flex justify-content-between justify-content-md-end align-items-center gap-3"
                      style="margin-left: 28px;"
                    >
                      {{-- Update Quantity --}}
                      <form action="{{ route('keranjang.update', $item->idKeranjang) }}" method="POST"
                            class="d-flex align-items-center border rounded px-2" style="height: 32px;">
                        @csrf
                        @method('PATCH')

                        <button
                          type="submit"
                          name="jumlahBarang"
                          value="{{ $item->jumlahBarang - 1 }}"
                          class="btn btn-sm btn-link text-dark text-decoration-none p-0 px-1"
                          {{ ($item->jumlahBarang <= 1 || $isOut) ? 'disabled' : '' }}
                        >-</button>

                        <input type="text" value="{{ $item->jumlahBarang }}" readonly
                               class="border-0 text-center bg-transparent fw-bold"
                               style="width: 30px; font-size: 0.9rem;">

                        <button
                          type="submit"
                          name="jumlahBarang"
                          value="{{ $item->jumlahBarang + 1 }}"
                          class="btn btn-sm btn-link text-dark text-decoration-none p-0 px-1"
                          {{ $isOut ? 'disabled' : '' }}
                        >+</button>
                      </form>

                      {{-- Delete Button --}}
                      <form action="{{ route('keranjang.destroy', $item->idKeranjang) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link text-secondary p-0">
                          <i class="bi bi-trash fs-5"></i>
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          @endif
        </div>

        {{-- Kanan: Ringkasan --}}
        <div class="col-lg-4">
          @php
            // Hitung jumlah item yang ready (stok > 0) untuk label tombol beli
            $readyCount = $items->filter(fn($i) => ($i->produk->stok ?? 0) > 0)->sum('jumlahBarang');
          @endphp

          <form id="checkout-form" action="{{ route('pembayaran.checkout') }}" method="POST">
            @csrf
            <div class="border rounded-3 p-3 bg-white position-sticky" style="top: 2rem;">
              <h5 class="fw-bold mb-3">Ringkasan Belanja</h5>

              <div class="d-flex justify-content-between align-items-center mb-3">
                <span>Total</span>
                {{-- total dari backend kamu (grandTotal) --}}
                <span class="fw-bold">Rp{{ number_format($grandTotal, 0, ',', '.') }}</span>
              </div>

              <button
                type="submit"
                class="btn w-100 text-white fw-bold"
                style="background-color:#000; border-color:#000;"
                {{ $readyCount < 1 ? 'disabled' : '' }}
              >
                Beli ({{ $readyCount }})
              </button>

              @if($items->isNotEmpty() && $readyCount < 1)
                <div class="text-muted small mt-2">
                  Semua produk di keranjang sedang habis stok.
                </div>
              @endif
            </div>
          </form>
        </div>
      </div>

      <hr class="my-4">

      {{-- PRODUK LAINNYA --}}
      <h3 class="h5 fw-bold mb-3">Produk Lainnya</h3>

      @php
        $produksLainnya = $produksLainnya ?? \App\Models\Produk::orderBy('idProduk', 'asc')->take(8)->get();
      @endphp

      <div class="d-flex flex-row overflow-auto gap-3 pb-2">
        @forelse ($produksLainnya as $product)
          <a href="{{ route('produk.show', $product->idProduk) }}"
             class="text-decoration-none text-dark flex-shrink-0"
             style="width: 220px;">
            <div class="product-card shadow-sm rounded-4 border overflow-hidden bg-white position-relative"
                 style="transition:.2s;">

              {{-- gambar produk, abu-abu jika stok habis --}}
              <img
                src="{{ $product->display_image }}"
                alt="{{ $product->namaProduk }}"
                class="w-100 product-img {{ $product->stok < 1 ? 'out' : '' }}"
                style="height:180px; object-fit:cover;"
                onerror="this.onerror=null;this.src='https://placehold.co/300x180/A0522D/FFFFFF?text=Produk';"
              >

              {{-- overlay sold out --}}
              @if($product->stok < 1)
                <img
                  src="{{ asset('images/soldout.png') }}"
                  alt="Sold Out"
                  class="soldout-badge"
                >
              @endif

              <div class="product-info p-3">
                <div class="product-name fw-semibold mb-1 text-truncate">{{ $product->namaProduk }}</div>
                <div class="product-stock text-muted small">Stok : {{ $product->stok }}</div>
                <div class="product-rating text-muted small">
                  Rating : {{ number_format($product->rating ?? 0, 1) }} ⭐
                </div>
                {{-- harga hitam (default) --}}
                <div class="product-price mt-2 fw-bold">
                  Rp{{ number_format($product->harga, 0, ',', '.') }}
                </div>

                <form action="{{ route('keranjang.store') }}" method="POST" class="mt-3">
                  @csrf
                  <input type="hidden" name="idProduk" value="{{ $product->idProduk }}">
                  <input type="hidden" name="jumlahBarang" value="1">
                  <button type="submit"
                          class="btn btn-add-cart w-100 fw-semibold"
                          {{ $product->stok < 1 ? 'disabled' : '' }}>
                    + Keranjang
                  </button>
                </form>
              </div>
            </div>
          </a>
        @empty
          <p class="text-muted">Tidak ada produk lain yang ditampilkan.</p>
        @endforelse
      </div>

    </div>
  </main>

  <style>
    .product-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
    }

    .btn-add-cart {
      background: #FFC107;
      color: #000;
      border: 0;
      border-radius: 12px;
      padding: .6rem 1rem;
    }

    .btn-add-cart:hover { filter: brightness(0.95); }
    .btn-add-cart:active { filter: brightness(0.9); }
    .btn-add-cart:disabled {
      background: #e6e6e6;
      color: #888;
      cursor: not-allowed;
    }

    .overflow-auto::-webkit-scrollbar { height: 8px; }
    .overflow-auto::-webkit-scrollbar-thumb {
      background: #ccc;
      border-radius: 4px;
    }
    .overflow-auto::-webkit-scrollbar-thumb:hover { background: #aaa; }

    /* === STYLE STOK HABIS DI KERANJANG (list item) === */
    .cart-thumb { position: relative; }
    .cart-img { transition: .2s; }
    .item-out .cart-img { filter: grayscale(1); opacity: .55; }

    .stock-overlay{
      position:absolute;
      inset:0;
      display:flex;
      align-items:center;
      justify-content:center;
      background: rgba(255,255,255,.55);
      backdrop-filter: blur(1px);
    }

    /* === STYLE UNTUK PRODUK LAINNYA (kartu bawah) === */
    .product-card {
      position: relative;
    }

    .product-img {
      display: block;
      width: 100%;
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
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const master = document.getElementById('checkAll');
      const checkoutForm = document.getElementById('checkout-form');

      const getItemChecks = () => Array.from(document.querySelectorAll('.item-checkbox'));
      const getEnabledItemChecks = () => getItemChecks().filter(i => !i.disabled);

      function syncMaster() {
        if (!master) return;

        const enabled = getEnabledItemChecks();
        if (enabled.length === 0) {
          master.checked = false;
          master.indeterminate = false;
          return;
        }

        const checkedCount = enabled.filter(i => i.checked).length;
        master.checked = checkedCount === enabled.length;
        master.indeterminate = checkedCount > 0 && checkedCount < enabled.length;
      }

      if (master) {
        master.addEventListener('change', function () {
          const enabled = getEnabledItemChecks();
          enabled.forEach(i => i.checked = master.checked);
          master.indeterminate = false;
        });
      }

      document.body.addEventListener('change', function (e) {
        const tgt = e.target;
        if (tgt.classList.contains('item-checkbox')) {
          syncMaster();
        }
      });

      // set awal
      syncMaster();

      // Saat form checkout disubmit, kumpulkan id item yang dicentang (dan tidak disabled) ke items[]
      if (checkoutForm) {
        checkoutForm.addEventListener('submit', function (e) {
          const checked = getEnabledItemChecks().filter(i => i.checked);

          if (checked.length === 0) {
            e.preventDefault();
            alert('Pilih minimal satu produk yang akan dibeli.');
            return;
          }

          // hapus hidden items[] sebelumnya (kalau ada)
          checkoutForm.querySelectorAll('input[name="items[]"]').forEach(el => el.remove());

          checked.forEach(cb => {
            const id = cb.dataset.id;
            if (!id) return;
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'items[]';
            hidden.value = id;
            checkoutForm.appendChild(hidden);
          });
        });
      }
    });
  </script>
@endsection
