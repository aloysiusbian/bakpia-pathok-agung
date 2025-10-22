@extends('templates.app')

@section('title', 'Keranjang')

@section('content')
<main class="flex-grow-1">
  <div class="container py-4">

    {{-- Grid utama: kiri keranjang, kanan ringkasan --}}
    <div class="row g-4">
      {{-- Kiri --}}
      <div class="col-lg-8">
        <h2 class="h4 fw-bold mb-3">Keranjang</h2>

        {{-- Pilih semua --}}
        <div class="border rounded-3 p-3 bg-white">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="checkAll" disabled>
            <label class="form-check-label" for="checkAll">Pilih Semua</label>
          </div>
        </div>

        {{-- Empty state --}}
        <div class="border rounded-3 p-4 mt-3 bg-white">
          <div class="d-flex align-items-center gap-3 py-3">
            <i class="bi bi-cart fs-1 text-secondary"></i>
            <div class="flex-grow-1">
              <div class="fw-semibold">Keranjang belanjamu kosong!</div>
            </div>
          </div>
        </div>
      </div>

      {{-- Kanan: Ringkasan --}}
      <div class="col-lg-4">
        <div class="border rounded-3 p-3 bg-white">
          <h5 class="fw-bold mb-3">Ringkasan Belanja</h5>
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span>Total</span>
            <span>—</span>
          </div>
          <button class="btn w-100 text-white fw-bold" style="background-color: #000; border-color: #000;">Beli</button>
        </div>
      </div>
    </div>

    <hr class="my-4">

    {{-- PRODUK LAINNYA --}}
    <h3 class="h5 fw-bold mb-3">Produk Lainnya</h3>

    @php
      $produksLainnya = $produksLainnya ?? \App\Models\Produk::orderBy('idProduk','asc')->take(8)->get();
    @endphp

    {{-- Baris horizontal --}}
    <div class="d-flex flex-row overflow-auto gap-3 pb-2">
      @forelse ($produksLainnya as $product)
        <a href="{{ route('produk.show', $product->idProduk) }}" class="text-decoration-none text-dark flex-shrink-0" style="width: 220px;">
          <div class="product-card shadow-sm rounded-4 border overflow-hidden bg-white" style="transition:.2s;">
            <img
              src="{{ asset('images/' . $product->gambar) }}"
              alt="{{ $product->namaProduk }}"
              class="w-100"
              style="height:180px; object-fit:cover;"
              onerror="this.onerror=null;this.src='https://placehold.co/300x180/A0522D/FFFFFF?text=Bakpia';"
            >
            <div class="product-info p-3">
              <div class="product-name fw-semibold mb-1">{{ $product->namaProduk }}</div>
              <div class="product-stock text-muted small">Stok : {{ $product->stok }}</div>
              <div class="product-rating text-muted small">Rating : {{ number_format($product->rating,1) }} ⭐</div>
              <div class="product-price mt-2 fw-bold">Rp{{ number_format($product->harga, 0, ',', '.') }}</div>

              {{-- Tombol + Keranjang --}}
              <form action="{{ route('keranjang.store') }}" method="POST" class="mt-3">
                @csrf
                <input type="hidden" name="idProduk" value="{{ $product->idProduk }}">
                <input type="hidden" name="kuantitas" value="1">
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

{{-- STYLE TAMBAHAN --}}
<style>
  .product-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,.08);
  }

  /* Tombol + Keranjang */
  .btn-add-cart{
    background:#FFC107;
    color:#000;
    border:0;
    border-radius:12px;
    padding:.6rem 1rem;
  }
  .btn-add-cart:hover{ filter:brightness(0.95); }
  .btn-add-cart:active{ filter:brightness(0.9); }
  .btn-add-cart:disabled{
    background:#e6e6e6;
    color:#888;
    cursor:not-allowed;
  }

  /* Scrollbar halus */
  .overflow-auto::-webkit-scrollbar {
    height: 8px;
  }
  .overflow-auto::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 4px;
  }
  .overflow-auto::-webkit-scrollbar-thumb:hover {
    background: #aaa;
  }
</style>

{{-- SCRIPT PILIH SEMUA --}}
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const master = document.getElementById('checkAll');
    if (!master) return;
    master.removeAttribute('disabled');
    const getItemChecks = () =>
      Array.from(document.querySelectorAll('input[type="checkbox"]:not(#checkAll)'));
    function syncMaster() {
      const items = getItemChecks();
      if (items.length === 0) { master.checked = false; master.indeterminate = false; return; }
      const checkedCount = items.filter(i => i.checked).length;
      master.checked = checkedCount === items.length;
      master.indeterminate = checkedCount > 0 && checkedCount < items.length;
    }
    master.addEventListener('change', function () {
      const items = getItemChecks();
      items.forEach(i => i.checked = master.checked);
      master.indeterminate = false;
    });
    document.body.addEventListener('change', function (e) {
      const tgt = e.target;
      if (tgt.matches('input[type="checkbox"]') && tgt.id !== 'checkAll') {
        syncMaster();
      }
    });
    syncMaster();
  });
</script>
@endsection
