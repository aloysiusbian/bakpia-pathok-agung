<header>
    <nav class="navbar navbar-expand-lg bg-warning shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Bakpia Pathok Agung" height="40">
            </a>

            <div class="input-group flex-grow-1 mx-lg-5">
                <input class="form-control rounded-pill border-0" placeholder="Bakpia Pathok?" aria-label="Search">
                <span class="input-group-text bg-transparent border-0 position-absolute end-0" style="z-index: 1;">
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
                    {{-- Dropdown Container --}}
                    <div class="dropdown">
                        {{-- Tombol Dropdown (Ikon Profil) --}}
                        <a href="#" class="text-dark fs-4 dropdown-toggle" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false"></a>

                        {{-- Menu Dropdown --}}
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                            {{-- 1. Link ke Profil Akun --}}
                            <li>
                                {{-- Gunakan href="#" karena halaman profil belum dibuat, seperti permintaan sebelumnya --}}
                                <a class="dropdown-item" href="/profilpelanggan">
                                    <i class="bi bi-person"></i> Profil Akun
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            {{-- 2. Link untuk Logout dengan Konfirmasi --}}
                            <li>
                                {{-- Form POST yang dibutuhkan Laravel untuk keamanan --}}
                                <form id="logout-form" action="/logout" method="POST" style="display: none;">
                                    @csrf
                                </form>

                                {{-- Tautan yang memanggil konfirmasi --}}
                                <a class="dropdown-item" href="/logout" onclick="event.preventDefault(); 
                                if (confirm('Apakah Anda yakin ingin mengakhiri sesi Anda?')) {
                                    document.getElementById('logout-form').submit();
                                }">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                @endauth
            </div>
        </div>
    </nav>
</header>