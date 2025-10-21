<header>
    <nav class="navbar navbar-expand-lg bg-warning shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Bakpia Pathok Agung" height="40">
            </a>

            <div class="input-group flex-grow-1 mx-lg-5">
                <input class="form-control rounded-pill border-0" placeholder="Bakpia Pathok?" aria-label="Search">
                <span class="input-group-text bg-transparent border-0 position-absolute end-0" style="z-index: 1;" >
                    <i class="bi bi-search text-secondary"></i>
                </span>
            </div>

            <div class="d-flex align-items-center gap-3 ms-lg-auto">
                <a href="/keranjang" class="text-dark fs-4" title="Dashboard Anda (Halaman Belum Dibuat)">
                    <i class="bi bi-cart"></i>
                </a>
                {{-- Cek apakah user belum login (Guest) --}}
@guest
    <a href="/login" class="btn btn-outline-dark fw-bold">
        Login
    </a>
@endguest

{{-- Cek apakah user sudah login (Authenticated) --}}
@auth
    <a href="{{ route('dashboard') }}" class="text-dark fs-4">
        <i class="bi bi-person"></i>
    </a>
@endauth
            </div>
        </div>
    </nav>
</header>
