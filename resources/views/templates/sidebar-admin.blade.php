<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | @yield('title')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #fbf3df;
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        /* ================== 1. SIDEBAR STYLES ================== */
        .sidebar {
            width: 260px;
            background-color: #e3d3ad;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Memisahkan konten atas dan tombol logout */
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            padding: 10px 0;
            z-index: 1020;
        }

        /* --- UPDATE BARU: Agar Menu Bisa di-Scroll --- */
        .sidebar-content {
            flex-grow: 1;          /* Mengisi sisa ruang kosong */
            overflow-y: auto;      /* Aktifkan scroll vertikal */
            overflow-x: hidden;    /* Matikan scroll horizontal */
            margin-bottom: 10px;   /* Jarak dengan tombol logout */
            
            /* Styling Scrollbar (Biar cantik dan sesuai tema) */
            scrollbar-width: thin;
            scrollbar-color: #d1b673 transparent;
        }

        /* Scrollbar untuk Chrome/Safari/Edge */
        .sidebar-content::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar-content::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-content::-webkit-scrollbar-thumb {
            background-color: #d1b673;
            border-radius: 20px;
        }
        /* --- END UPDATE BARU --- */

        .sidebar .logo { display: flex; align-items: center; justify-content: center; margin-bottom: 10px; min-height: 40px; flex-shrink: 0; }
        .sidebar .logo .logo-full { display: block; }
        .sidebar .logo .logo-icon { display: none; }
        
        .sidebar .profile { text-align: left; margin-bottom: 20px; display: flex; align-items: center; justify-content: center; padding: 10px 20px; flex-shrink: 0; }
        .sidebar .profile img { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; margin-right: 10px; }
        .sidebar .profile h6 { margin-top: 8px; font-weight: 600; color: #3a2d1a; white-space: nowrap; }

        .nav-section-title { font-size: 0.8rem; font-weight: 600; color: #6e5b3b; margin: 10px 20px 5px; white-space: nowrap; }
        .sidebar .nav-link { color: #3a2d1a; border-radius: 5px; margin: 2px; display: flex; align-items: center; gap: 15px; transition: all 0.2s; white-space: nowrap; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #d1b673; color: #000; font-weight: 600; }
        
        /* Tombol Logout (Fixed di bawah) */
        .sidebar-footer {
            flex-shrink: 0; /* Jangan sampai mengecil/gepeng */
            width: 100%;
            text-align: center;
            padding-bottom: 10px;
        }

        .offline-btn { margin: 0 auto; border-radius: 10px; background-color: white; color: #3a2d1a; font-weight: 600; white-space: nowrap; display: flex; justify-content: center; align-items: center; }
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
            z-index: 1030;
        }

        .content {
            margin-left: 260px;
            padding: 100px 30px 30px;
            transition: all 0.3s ease;
            min-height: 100vh;
        }

        /* ================== UTILITIES ================== */
        .card { border: none; border-radius: 12px; box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1); }
        .card-header-custom { background: linear-gradient(135deg, #ffe2a4, #f5c24c); border-radius: 12px 12px 0 0; border-bottom: none; color: #4a3312; }
        .section-title { font-size: 0.85rem; font-weight: 600; text-transform: uppercase; color: #7b643c; margin-bottom: 4px; }
        .form-label { font-size: 0.85rem; font-weight: 500; color: #4b3920; }
        .form-control, .form-select { border-radius: 10px; border-color: #e0c78b; font-size: 0.9rem; }
        .form-control:focus, .form-select:focus { border-color: #f0b232; box-shadow: 0 0 0 0.15rem rgba(240, 178, 50, 0.35); }
        
        .btn-theme { background-color: #f5c24c; border-color: #f5c24c; color: #4a3312; font-weight: 600; border-radius: 999px; padding: 8px 22px; }
        .btn-theme:hover { background-color: #e8b138; border-color: #e8b138; color: #3a2d1a; }
        .btn-outline-theme { border-radius: 999px; border-color: #f5c24c; color: #4a3312; font-weight: 500; }
        .btn-outline-theme:hover { background-color: #f5c24c; color: #3a2d1a; }
        
        .order-type-badge { font-size: 0.8rem; border-radius: 999px; padding: 4px 10px; background-color: #fff3cd; color: #7b643c; }
        .badge-status { font-size: 0.75rem; padding: 6px 10px; border-radius: 999px; }
        .table-rounded { border-radius: 8px; overflow: hidden; }
        .produk-row { background-color: #fff7e5; border-radius: 10px; padding: 10px; margin-bottom: 10px; }
        
        .filter-select { position: relative; }
        .filter-select i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-size: 0.9rem; color: #a17a29; pointer-events: none; }
        .filter-select .form-select { padding-left: 2rem; border-radius: 999px; border: 1px solid #d4b36c; background-color: #fff7e1; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08); font-size: 0.85rem; font-weight: 500; color: #5a4525; transition: all 0.2s ease-in-out; }
        .filter-select .form-select:hover { background-color: #ffe9b6; border-color: #c8a04a; }
        .filter-select .form-select:focus { border-color: #f0b232; background-color: #fff3cc; box-shadow: 0 0 0 0.25rem rgba(240, 178, 50, 0.35); }
        .filter-select .form-select option { padding: 5px 8px; background: #fff; color: #5a4525; }
        
        .summary-card { border-radius: 14px; background: linear-gradient(135deg, #ffe2a4, #f5c24c); color: #4a3312; }
        .summary-card.secondary { background: linear-gradient(135deg, #f7e6c9, #d1b673); }
        .summary-card.danger { background: linear-gradient(135deg, #ffd6c7, #ff9b7a); }
        
        .table-custom th { background-color: #d1b673; color: #3a2d1a; font-weight: 600; vertical-align: middle; }
        .img-thumbnail-custom { width: 50px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; }
        .action-btn { margin: 0 2px; }

        .product-dropdown { position: relative; }
        .product-dropdown-toggle { border-radius: 10px; border: 1px solid #e0c78b; background-color: #fff; padding: 8px 12px; cursor: pointer; display: flex; align-items: center; justify-content: space-between; width: 100%; font-size: 0.9rem; }
        .product-dropdown-toggle:focus { outline: none; box-shadow: 0 0 0 0.15rem rgba(240, 178, 50, 0.35); }
        .product-dropdown-toggle .selected-info { display: flex; align-items: center; gap: 10px; }
        .product-dropdown-toggle img { width: 40px; height: 40px; border-radius: 8px; object-fit: cover; }
        .product-dropdown-menu { position: absolute; top: 100%; left: 0; right: 0; z-index: 2000; background-color: #fff; border-radius: 10px; margin-top: 4px; box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15); max-height: 260px; overflow-y: auto; padding: 4px 0; }
        .product-option { display: flex; align-items: center; gap: 10px; padding: 6px 10px; cursor: pointer; }
        .product-option:hover { background-color: #fff7e5; }
        .product-option img { width: 40px; height: 40px; border-radius: 8px; object-fit: cover; }
        .product-option-name { font-size: 0.9rem; font-weight: 500; }
        .product-option-stock { font-size: 0.8rem; color: #777; }

        /* Overlay HP */
        .mobile-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1035;
            display: none;
        }
        .mobile-overlay.show { display: block !important; }

        /* ================== MEDIA QUERIES ================== */
        
        /* DESKTOP MINI MODE (Layar > 992px) */
        @media (min-width: 992px) {
            .sidebar.collapsed { width: 80px; }
            .sidebar.collapsed .logo .logo-full { display: none; }
            .sidebar.collapsed .logo .logo-icon { display: block; height: 30px; }
            
            /* Sembunyikan teks di mini mode */
            .sidebar.collapsed .profile h6, 
            .sidebar.collapsed .nav-section-title, 
            .sidebar.collapsed .nav-link span, 
            .sidebar.collapsed .offline-btn span { display: none !important; }
            
            .sidebar.collapsed .profile { flex-direction: column; padding: 10px 0; }
            .sidebar.collapsed .profile img { margin-right: 0; }
            .sidebar.collapsed .nav-link { justify-content: center; gap: 0; padding: 10px 0; }
            .sidebar.collapsed .offline-btn { width: 40px !important; margin: 15px auto; padding: 8px; }
            .sidebar.collapsed .offline-btn i { margin-right: 0; }
            
            /* Navbar & Content geser */
            .navbar.collapsed { left: 80px; width: calc(100% - 80px); }
            .content.collapsed { margin-left: 80px; }
        }

        /* MOBILE MODE (Layar <= 991.98px) */
        @media (max-width: 991.98px) {
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
            #toggle-btn { margin-right: 15px; cursor: pointer; position: relative; z-index: 1035; }
        }
    </style>
</head>

<body>

    <div id="mobile-overlay" class="mobile-overlay"></div>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-content">
            
            <div class="logo">
                <a href="/admin/dashboard">
                    <img class="logo-full" src="{{ asset('images/logo.png') }}" alt="Logo" height="40">
                    <img class="logo-icon" src="{{ asset('images/logo-icon.png') }}" alt="Icon" height="30">
                </a>
            </div>

            @php
                $adminImage = isset($admin) && $admin->image ? asset('storage/' . $admin->image) : asset('images/profile-dummy.png');
                $adminName = isset($admin) ? ($admin->username ?? 'Admin') : 'Administrator';
            @endphp
            <div class="profile">
                <img src="{{ $adminImage }}" alt="Admin">
                <div class="profile-content">
                    <h6>{{ $adminName }}</h6>
                </div>
            </div>

            <div class="menu px-2">
                <hr class="my-2">
                <p class="nav-section-title">Dashboard</p>
                <ul class="nav flex-column px-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="/admin/dashboard" title="Dashboard">
                            <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/edit-akun') ? 'active' : '' }}" href="/admin/edit-akun" title="Edit Akun">
                            <i class="bi bi-person-gear"></i> <span>Edit Akun</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/ganti-sandi') ? 'active' : '' }}" href="/admin/ganti-sandi" title="Ganti Password">
                            <i class="bi bi-lock"></i> <span>Ganti Password</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/analisis') ? 'active' : '' }}" href="#" title="Analisis">
                            <i class="bi bi-graph-up"></i> <span>Analisis</span>
                        </a>
                    </li>
                </ul>

                <hr class="my-2">
                <p class="nav-section-title mt-3">Pesanan</p>
                <ul class="nav flex-column px-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/pemesananOnline') ? 'active' : '' }}" href="/admin/pemesananOnline" title="Pemesanan Online">
                            <i class="bi bi-cart4"></i> <span>Pemesanan Online</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/pemesananOffline') ? 'active' : '' }}" href="/admin/pemesananOffline" title="Pemesanan Offline">
                            <i class="bi bi-telephone"></i> <span>Pemesanan Offline</span>
                        </a>
                    </li>
                </ul>

                <hr class="my-2">
                <p class="nav-section-title mt-3">Produk</p>
                <ul class="nav flex-column px-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/lihatproduk') ? 'active' : '' }}" href="/admin/lihatproduk" title="Lihat Produk">
                            <i class="bi bi-box-seam"></i> <span>Lihat Produk</span>
                        </a>
                    </li>
                </ul>

                <hr class="my-2">
                <p class="nav-section-title mt-3">Admin</p>
                <ul class="nav flex-column px-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/tambah-admin') ? 'active' : '' }}" href="/admin/tambah-admin" title="Tambah Admin">
                            <i class="bi bi-person-fill-add"></i> <span>Tambah Admin</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/kelola-admin') ? 'active' : '' }}" href="/admin/kelola-admin" title="Kelola Admin">
                            <i class="bi bi-people-fill"></i> <span>Kelola Admin</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="sidebar-footer">
            <div class="text-center w-100">
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn offline-btn w-75">
                        <i class="bi bi-box-arrow-right me-2"></i> <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

<<<<<<< HEAD
    <nav class="navbar d-flex align-items-center" id="navbar">
        <button type="button" class="btn btn-light me-3 shadow-sm border-0" id="toggle-btn" style="background: #fff;">
            <i class="bi bi-list fs-5"></i>
        </button>
        <input type="text" class="form-control w-50 me-auto" placeholder="Admin Dashboard">
    </nav>
=======
    <div class="text-center mb-3">
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn offline-btn w-75">
                <i class="bi bi-box-arrow-right me-2"></i><span>Logout</span>
            </button>
        </form>
    </div>
</div>
>>>>>>> 9b30a8972784f3a7c5bfd7b4eccce689a3bf33c8


        @yield('content')


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.getElementById('sidebar');
            const navbar = document.getElementById('navbar');
            const content = document.getElementById('content');
            const toggleBtn = document.getElementById('toggle-btn');
            const overlay = document.getElementById('mobile-overlay');

            // 1. Tooltip Initialization
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // 2. FUNGSI UTAMA: Cek Mode Mobile vs Desktop
            function isMobile() {
                return window.matchMedia("(max-width: 991.98px)").matches;
            }

            function checkLayout() {
                if (isMobile()) {
                    sidebar.classList.remove('collapsed');
                    navbar.classList.remove('collapsed');
                    if(content) content.classList.remove('collapsed');
                    
                    if (!overlay.classList.contains('show')) {
                        sidebar.classList.add('mobile-hidden');
                    }
                } else {
                    sidebar.classList.remove('mobile-hidden');
                    overlay.classList.remove('show');
                }
            }

            checkLayout();
            window.addEventListener('resize', checkLayout);

            // 3. LOGIC TOMBOL KLIK
            if(toggleBtn) {
                toggleBtn.addEventListener('click', (e) => {
                    e.stopPropagation();

                    if (isMobile()) {
                        if (sidebar.classList.contains('mobile-hidden')) {
                            sidebar.classList.remove('mobile-hidden'); // BUKA
                            overlay.classList.add('show');
                        } else {
                            sidebar.classList.add('mobile-hidden'); // TUTUP
                            overlay.classList.remove('show');
                        }
                    } else {
                        sidebar.classList.remove('mobile-hidden');
                        
                        sidebar.classList.toggle('collapsed');
                        navbar.classList.toggle('collapsed');
                        if(content) content.classList.toggle('collapsed');
                    }
                });
            }

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