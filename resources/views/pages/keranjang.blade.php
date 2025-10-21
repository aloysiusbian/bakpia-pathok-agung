@extends('templates.app')

@section('title', 'keranjang')

@section('content')

  {{-- KONTEN --}}
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

      {{-- Produk Lainnya --}}
      <h3 class="h5 fw-bold mb-3">Produk Lainnya</h3>

      <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">

        {{-- === LOOP DARI DATABASE === --}}
        @isset($products)
          @forelse($products as $p)
            @php
              $src = '';
              if (!empty($p->gambar) && (str_starts_with($p->gambar, 'http://') || str_starts_with($p->gambar, 'https://'))) {
                  $src = $p->gambar;
              } elseif (!empty($p->gambar)) {
                  $src = asset('storage/' . ltrim($p->gambar, '/'));
              } else {
                  $src = asset('images/placeholder.jpg');
              }
            @endphp

            <div class="col">
              <div class="card border-0 shadow-sm h-100">
                <img src="{{ $src }}" class="card-img-top"
                     alt="{{ $p->nama_produk ?? 'Produk' }}" style="aspect-ratio:4/3;object-fit:cover;">
                <div class="card-body">
                  <h6 class="mb-1">{{ $p->nama_produk ?? 'Nama Produk' }}</h6>
                  <div class="text-secondary small mb-1">Stok : {{ $p->stok ?? '-' }}</div>
                  @if(isset($p->rating))
                    <div class="text-secondary small mb-2">Rating : <strong>{{ number_format((float)$p->rating,1) }}</strong> ✨</div>
                  @endif
                  <div class="fw-bold">
                    @if(isset($p->harga))
                      Rp{{ number_format((float)$p->harga, 0, ',', '.') }}
                    @else
                      Rp—
                    @endif
                  </div>
                </div>
              </div>
            </div>
          @empty
            <div class="col-12">
              <div class="alert alert-light border text-center">Belum ada produk untuk ditampilkan.</div>
            </div>
          @endforelse
        @endisset

        {{-- === FALLBACK (saat backend belum kirim $products) === --}}
        @empty($products)
          <div class="col">
            <div class="card border-0 shadow-sm h-100">
              <img src="{{ asset('images/produk/bakpia-durian.jpg') }}" class="card-img-top"
                   alt="Bakpia Durian" style="aspect-ratio:4/3;object-fit:cover;">
              <div class="card-body">
                <h6 class="mb-1">Bakpia Durian</h6>
                <div class="text-secondary small mb-1">Stok : 100</div>
                <div class="text-secondary small mb-2">Rating : <strong>4,9</strong> ✨</div>
                <div class="fw-bold">Rp250.000</div>
              </div>
            </div>
          </div>

          @for ($i = 0; $i < 11; $i++)
            <div class="col">
              <div class="card border-0 shadow-sm h-100">
                <div class="bg-light w-100" style="aspect-ratio:4/3;"></div>
                <div class="card-body">
                  <div class="placeholder-glow">
                    <span class="placeholder col-9 mb-2"></span>
                    <span class="placeholder col-6 mb-2"></span>
                    <span class="placeholder col-7 mb-2"></span>
                    <span class="placeholder col-5 mb-2"></span>
                    <span class="placeholder col-4"></span>
                  </div>
                </div>
              </div>
            </div>
          @endfor
        @endempty
      </div>

      @if(isset($products) && method_exists($products, 'links'))
        <div class="mt-4">
          {{ $products->links() }}
        </div>
      @endif
    </div>
  </main>

  {{-- SCRIPT PILIH SEMUA --}}
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const master = document.getElementById('checkAll');
      if (!master) return;

      // aktifkan checkbox utama
      master.removeAttribute('disabled');

      // ambil semua checkbox selain master
      const getItemChecks = () =>
        Array.from(document.querySelectorAll('input[type="checkbox"]:not(#checkAll)'));

      // update status "indeterminate"
      function syncMaster() {
        const items = getItemChecks();
        if (items.length === 0) {
          master.checked = false;
          master.indeterminate = false;
          return;
        }
        const checkedCount = items.filter(i => i.checked).length;
        master.checked = checkedCount === items.length;
        master.indeterminate = checkedCount > 0 && checkedCount < items.length;
      }

      // ketika master diubah
      master.addEventListener('change', function () {
        const items = getItemChecks();
        items.forEach(i => i.checked = master.checked);
        master.indeterminate = false;
      });

      // jika salah satu item diubah
      document.body.addEventListener('change', function (e) {
        const tgt = e.target;
        if (tgt.matches('input[type="checkbox"]') && tgt.id !== 'checkAll') {
          syncMaster();
        }
      });

      // inisialisasi awal
      syncMaster();
    });
  </script>

@endsection
