{{-- resources/views/cart.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bakpia Pathok Agung - Keranjang</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="d-flex flex-column min-vh-100">

  {{-- HEADER --}}
  <header>
    <nav class="navbar navbar-expand-lg bg-warning shadow-sm">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">
          <img src="{{ asset('images/logo.png') }}" alt="Agung Logo" height="40">
        </a>

        <div class="input-group flex-grow-1 mx-lg-5 position-relative">
          <input type="text" class="form-control rounded-pill border-0 ps-4 pe-5" placeholder="Cari di sini" aria-label="Search">
          <span class="position-absolute end-0 top-50 translate-middle-y pe-3 text-secondary">
            <i class="bi bi-search"></i>
          </span>
        </div>

        <div class="d-flex align-items-center gap-3 ms-lg-auto">
          <a href="#" class="text-dark fs-4" title="Akun">
            <i class="bi bi-person"></i>
          </a>
        </div>
      </div>
    </nav>
  </header>

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

  {{-- FOOTER --}}
  <footer class="custom-footer py-5 mt-auto bg-light">
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
          <img src="{{ asset('images/logo.png') }}" alt="Agung Logo" class="h-10 mb-3" height="50">
          <p class="text-sm text-secondary">
            Kami memiliki oleh-oleh khas Yogyakarta dengan beragam macam jenis. Dari Bakpia hingga Wingko.
          </p>
          <div class="d-flex gap-3 fs-5 mt-4">
            <a href="#" class="text-secondary"><i class="bi bi-twitter"></i></a>
            <a href="#" class="text-secondary"><i class="bi bi-facebook"></i></a>
            <a href="#" class="text-secondary"><i class="bi bi-instagram"></i></a>
            <a href="#" class="text-secondary"><i class="bi bi-github"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-6 mb-4">
          <h5 class="fw-bold">COMPANY</h5>
          <ul class="list-unstyled text-sm">
            <li><a href="#" class="text-secondary text-decoration-none">About</a></li>
            <li><a href="#" class="text-secondary text-decoration-none">Features</a></li>
            <li><a href="#" class="text-secondary text-decoration-none">Works</a></li>
            <li><a href="#" class="text-secondary text-decoration-none">Career</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-6 mb-4">
          <h5 class="fw-bold">HELP</h5>
          <ul class="list-unstyled text-sm">
            <li><a href="#" class="text-secondary text-decoration-none">Customer Support</a></li>
            <li><a href="#" class="text-secondary text-decoration-none">Delivery Details</a></li>
            <li><a href="#" class="text-secondary text-decoration-none">Terms & Conditions</a></li>
            <li><a href="#" class="text-secondary text-decoration-none">Privacy Policy</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-6 mb-4">
          <h5 class="fw-bold">FAQ</h5>
          <ul class="list-unstyled text-sm">
            <li><a href="#" class="text-secondary text-decoration-none">Account</a></li>
            <li><a href="#" class="text-secondary text-decoration-none">Manage Deliveries</a></li>
            <li><a href="#" class="text-secondary text-decoration-none">Orders</a></li>
            <li><a href="#" class="text-secondary text-decoration-none">Payments</a></li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
          <h5 class="fw-bold">RESOURCES</h5>
          <ul class="list-unstyled text-sm">
            <li><a href="#" class="text-secondary text-decoration-none">Free eBooks</a></li>
            <li><a href="#" class="text-secondary text-decoration-none">Development Tutorial</a></li>
            <li><a href="#" class="text-secondary text-decoration-none">How to - Blog</a></li>
            <li><a href="#" class="text-secondary text-decoration-none">Youtube Playlist</a></li>
          </ul>
        </div>
      </div>

      <hr class="text-secondary mt-1 mb-3">
      <div class="d-flex justify-content-between align-items-center text-sm">
        <p class="text-secondary mb-0">Bakpia Pathok Agung © 2025. All Rights Reserved</p>
        <div class="d-flex gap-2">
          <img src="{{ asset('images/qris.png') }}" alt="Pembayaran 1" class="h-8" height="70">
          <img src="{{ asset('images/bank.png') }}" alt="Pembayaran 2" class="h-8" height="70">
        </div>
      </div>
    </div>
  </footer>

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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
          integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
          crossorigin="anonymous"></script>
</body>
</html>
