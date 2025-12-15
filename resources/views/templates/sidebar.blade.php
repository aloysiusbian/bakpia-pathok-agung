<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelanggan | @yield('title')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
    body {
        background-color: #fbf3df;
        font-family: 'Poppins', sans-serif;
        overflow-x: hidden;
    }

    /* ================== SIDEBAR (DEFAULT DESKTOP) ================== */
    .sidebar {
        width: 260px;
        background-color: #e3d3ad;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 0 6px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        padding: 10px 0;
        /* UPDATE: Z-Index Desktop diturunkan biar gak nutupin Navbar */
        z-index: 1020; 
    }

    /* Styles Logo, Profil, Menu tetap sama */
    .sidebar .logo { display: flex; align-items: center; justify-content: center; margin-bottom: 10px; min-height: 40px; }
    .sidebar .logo .logo-full { display: block; }
    .sidebar .logo .logo-icon { display: none; }
    
    .sidebar .profile { text-align: left; margin-bottom: 20px; display: flex; align-items: center; justify-content: center; padding: 10px 20px; }
    .sidebar .profile img { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; margin-right: 10px; }
    .sidebar .profile h6 { margin-top: 8px; font-weight: 600; color: #3a2d1a; white-space: nowrap; }

    .nav-section-title { font-size: 0.8rem; font-weight: 600; color: #6e5b3b; margin: 10px 20px 5px; white-space: nowrap; }
    .sidebar .nav-link { color: #3a2d1a; border-radius: 5px; margin: 2px; display: flex; align-items: center; gap: 15px; transition: all 0.2s; white-space: nowrap; }
    .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #d1b673; color: #000; font-weight: 600; }
    
    .offline-btn { margin: 15px 20px; border-radius: 10px; background-color: white; color: #3a2d1a; font-weight: 600; white-space: nowrap; display: flex; justify-content: center; align-items: center; }
    .offline-btn i { margin-right: 5px; }

    /* ================== NAVBAR & CONTENT ================== */
    .navbar {
        background-color: #f5c24c;
        padding: 10px 25px;
        position: fixed;
        top: 0;
        left: 260px;
        width: calc(100% - 260px);
        transition: all 0.3s ease;
        /* UPDATE: Navbar harus LEBIH TINGGI dari Sidebar di Desktop */
        z-index: 1030; 
    }

    .content {
        margin-left: 260px;
        padding: 100px 30px 30px;
        transition: all 0.3s ease;
        min-height: 100vh;
    }

    /* Utilities */
    .card { border: none; border-radius: 12px; box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1); }
    .btn-theme { background-color: #f5c24c; color: #4a3312; font-weight: 600; border-radius: 999px; }
    
    .mobile-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 1035; /* Di atas Navbar */
        display: none;
    }
    .mobile-overlay.show { display: block !important; }

    /* ================== DESKTOP MINI MODE (Layar > 991.98px) ================== */
    @media (min-width: 992px) {
        .sidebar.collapsed { width: 80px; }
        .sidebar.collapsed .logo .logo-full { display: none; }
        .sidebar.collapsed .logo .logo-icon { display: block; height: 30px; }
        .sidebar.collapsed .profile h6, 
        .sidebar.collapsed .nav-section-title, 
        .sidebar.collapsed .nav-link span, 
        .sidebar.collapsed .offline-btn span { display: none !important; }
        .sidebar.collapsed .profile { flex-direction: column; padding: 10px 0; }
        .sidebar.collapsed .profile img { margin-right: 0; }
        .sidebar.collapsed .nav-link { justify-content: center; gap: 0; padding: 10px 0; }
        .sidebar.collapsed .offline-btn { width: 40px !important; margin: 15px auto; padding: 8px; }
        .sidebar.collapsed .offline-btn i { margin-right: 0; }
        
        .navbar.collapsed { left: 80px; width: calc(100% - 80px); }
        .content.collapsed { margin-left: 80px; }
    }

    /* ================== MOBILE MODE (Layar <= 991.98px) ================== */
    @media (max-width: 991.98px) {
        /* UPDATE: Di HP, Sidebar harus Paling Atas (Overlay) */
        .sidebar { z-index: 1040 !important; }

        .sidebar.mobile-hidden {
            transform: translateX(-100%) !important;
            width: 260px !important; 
        }

        .sidebar {
            transform: translateX(0) !important;
            width: 260px !important;
            box-shadow: 5px 0 15px rgba(0,0,0,0.3);
        }

        .navbar, .content {
            left: 0 !important;
            margin-left: 0 !important;
            width: 100% !important;
        }

        .sidebar .logo .logo-icon { display: none !important; }
        .sidebar .logo .logo-full { display: block !important; }
        #toggle-btn { margin-right: 15px; }
    }
</style>
</head>

<body>

    <div id="mobile-overlay" class="mobile-overlay"></div>

    <div class="sidebar" id="sidebar">
        <div>
            <div class="logo">
                <a href="/">
                    <img class="logo-full" src="{{ asset('images/logo.png') }}" alt="Logo" height="40">
                    <img class="logo-icon" src="{{ asset('images/logo-icon.png') }}" alt="Icon" height="30">
                </a>
            </div>

            @php
                $userImage = isset($pelanggan) && $pelanggan->image ? asset('storage/' . $pelanggan->image) : asset('images/profile-dummy.png');
                $userName = isset($pelanggan) ? ($pelanggan->username ?? 'Pelanggan') : 'Guest';
            @endphp

            <div class="profile">
                <img src="{{ $userImage }}" alt="Pelanggan">
                <div class="profile-content">
                    <h6>{{ $userName }}</h6>
                </div>
            </div>

            <div class="menu px-2">
                <hr>
                <p class="nav-section-title">Menu Utama</p>
                <ul class="nav flex-column px-2">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('dashboard-pelanggan') ? 'active' : '' }}" href="/dashboard-pelanggan">
                            <i class="bi bi-house-door"></i> <span>Beranda</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('lihat-profil') ? 'active' : '' }}" href="/lihat-profil">
                            <i class="bi bi-person-circle"></i> <span>Lihat Profil</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('ganti-password') ? 'active' : '' }}" href="/ganti-password">
                            <i class="bi bi-lock"></i> <span>Ganti Password</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('riwayat.pemesanan') ? 'active' : '' }}" href="{{ route('riwayat.pemesanan') }}">
                            <i class="bi bi-clock-history"></i> <span>Riwayat Pembelian</span>
                        </a>
                    </li>
                </ul>
                <hr>
            </div>
        </div>
        
        <div class="text-center w-100 mb-3">
            <a href="/" class="btn offline-btn w-75"><i class="bi bi-box-arrow-right"></i><span> Kembali?</span></a>
        </div>
    </div>

    <nav class="navbar d-flex align-items-center" id="navbar">
        <button class="btn btn-light me-3 shadow-sm border-0" id="toggle-btn" style="background: #fff;">
            <i class="bi bi-list fs-5"></i>
        </button>
        <input type="text" class="form-control w-50 me-auto" placeholder="Dashboard Pelanggan">
    </nav>

        @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const sidebar = document.getElementById('sidebar');
        const navbar = document.getElementById('navbar');
        const content = document.getElementById('content');
        const toggleBtn = document.getElementById('toggle-btn');
        const overlay = document.getElementById('mobile-overlay');

        toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        navbar.classList.toggle('collapsed');
        content.classList.toggle('collapsed');
    });
        // FUNGSI UTAMA: Cek Mode Mobile vs Desktop
        // Menggunakan matchMedia agar 100% sinkron dengan CSS Media Query
        function isMobile() {
            return window.matchMedia("(max-width: 991.98px)").matches;
        }

        function checkLayout() {
            if (isMobile()) {
                // --- MODE HP ---
                // Bersihkan class desktop
                sidebar.classList.remove('collapsed');
                navbar.classList.remove('collapsed');
                if(content) content.classList.remove('collapsed');
                
                // Set default sembunyi (kecuali overlay sedang aktif)
                if (!overlay.classList.contains('show')) {
                    sidebar.classList.add('mobile-hidden');
                }
            } else {
                // --- MODE PC ---
                // Bersihkan class mobile
                sidebar.classList.remove('mobile-hidden');
                overlay.classList.remove('show');
            }
        }

        // Jalankan saat load & resize
        checkLayout();
        window.addEventListener('resize', checkLayout);

        // LOGIC TOMBOL KLIK
        if(toggleBtn) {
            toggleBtn.addEventListener('click', (e) => {
                e.stopPropagation(); // Mencegah klik tembus

                if (isMobile()) {
                    // === LOGIKA HP: Muncul/Hilang ===
                    if (sidebar.classList.contains('mobile-hidden')) {
                        sidebar.classList.remove('mobile-hidden'); // BUKA
                        overlay.classList.add('show');
                    } else {
                        sidebar.classList.add('mobile-hidden'); // TUTUP
                        overlay.classList.remove('show');
                    }
                } else {
                    // === LOGIKA PC: Besar/Kecil ===
                    // Pastikan class mobile-hidden tidak nyangkut
                    sidebar.classList.remove('mobile-hidden');
                    
                    // Toggle Class
                    sidebar.classList.toggle('collapsed');
                    navbar.classList.toggle('collapsed');
                    if(content) content.classList.toggle('collapsed');
                }
            });
        }

        // LOGIC KLIK OVERLAY (Tutup Sidebar di HP)
        if(overlay) {
            overlay.addEventListener('click', () => {
                sidebar.classList.add('mobile-hidden');
                overlay.classList.remove('show');
            });
        }
    });
</script>
</body>
</html>