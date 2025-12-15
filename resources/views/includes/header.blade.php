<header>
    {{-- Hapus 'navbar-expand-lg' agar layout tidak berubah vertikal di layar kecil --}}
    <nav class="navbar bg-warning shadow-sm">
        
        {{-- Tambahkan 'flex-nowrap' agar elemen dipaksa satu baris (tidak turun) --}}
        <div class="container-fluid d-flex flex-nowrap align-items-center">
            
            {{-- 1. LOGO --}}
            <a class="navbar-brand me-2 me-md-3" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Bakpia Pathok Agung" height="40">
            </a>

            {{-- 2. SEARCH BAR --}}
            {{-- Gunakan w-100 di mobile jika perlu, tapi flex-grow-1 sudah cukup --}}
            {{-- Ubah margin: mx-2 (mobile) dan mx-md-5 (laptop) agar tidak terlalu sempit di HP --}}
            <div class="input-group flex-grow-1 mx-2 mx-md-5">
                <input class="form-control rounded-pill border-0" placeholder="Cari Bakpia..." aria-label="Search">
                <span class="input-group-text bg-transparent border-0 position-absolute end-0" style="z-index: 1;">
                    <i class="bi bi-search text-secondary"></i>
                </span>
            </div>

            {{-- 3. ICON KERANJANG & PROFIL --}}
            {{-- ms-auto memastikan elemen ini didorong ke paling kanan --}}
            <div class="d-flex align-items-center gap-2 gap-md-3 ms-auto">
                
                {{-- Keranjang --}}
                <a href="/keranjang" class="text-dark fs-4 position-relative" title="Keranjang">
                    <i class="bi bi-cart"></i>
                    {{-- Opsional: Badge jumlah item --}}
                    {{-- <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.5rem;">2</span> --}}
                </a>

                {{-- Guest (Belum Login) --}}
                @guest
                    <a href="/login" class="btn btn-outline-dark fw-bold btn-sm text-nowrap">
                        Login
                    </a>
                @endguest

                {{-- Auth (Sudah Login) --}}
                @auth
                    <div class="dropdown">
                        <a href="#" class="text-dark fs-4 dropdown-toggle text-decoration-none" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                           <i class="bi bi-person-circle"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownMenuLink">
                            <li>
                                <a class="dropdown-item" href="/dashboard-pelanggan">
                                    <i class="bi bi-person me-2"></i> Profil Akun
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/pesanan-saya">
                                    <i class="bi bi-clock-history me-2"></i> Pesanan Saya
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form id="logout-form" action="/logout" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <a class="dropdown-item text-danger" href="/logout" onclick="event.preventDefault();
                                if (confirm('Yakin ingin logout?')) { document.getElementById('logout-form').submit(); }">
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