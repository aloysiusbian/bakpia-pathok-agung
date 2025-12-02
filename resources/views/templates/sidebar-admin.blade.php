<!-- resources/views/admin/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelanggan | @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
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
            justify-content: space-between;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            padding: 10px 0;
            z-index: 1030;
        }

        .sidebar .logo .logo-full {
            display: block;
            /* Tampilkan logo penuh secara default */
        }

        .sidebar .logo .logo-icon {
            display: none;
            /* Sembunyikan logo ikon secara default */
        }

        /* KETIKA SIDEBAR COLLAPSED (Mini Mode) */
        .sidebar.collapsed .logo .logo-full {
            display: none;
            /* Sembunyikan logo penuh */
        }

        .sidebar.collapsed .logo .logo-icon {
            display: block;
            /* Tampilkan logo ikon */
            height: 30px;
            /* Sesuaikan ukuran ikon */
        }

        /* Sesuaikan penempatan logo dalam mode collapsed */
        .sidebar.collapsed .logo {
            padding: 5px 0;
            /* Memberi sedikit ruang di atas dan bawah */
        }

        /* Ada dua definisi collapsed di file sumber. Menggunakan transform untuk menyembunyikan sepenuhnya (untuk mobile/toggle) */
        .sidebar.collapsed {
            /* transform: translateX(-200%); */
            width: 100px;
            /* Jika ingin mode mini/icon-only, ganti dengan: width: 80px; */
        }

        /* Tambahkan style untuk menyembunyikan teks di mode collapsed */
        .sidebar.collapsed .profile .profile-name,
        .sidebar.collapsed .profile h6,
        .sidebar.collapsed .nav-section-title,
        .sidebar.collapsed .nav-link span,
        .sidebar.collapsed .offline-btn span {
            display: none !important;
        }

        .sidebar.collapsed .logo {
            /* logo harus tetap terlihat di tengah */
            justify-content: center;
        }

        .sidebar.collapsed .profile {
            /* Tidak perlu margin-bottom besar, hanya gambar */
            justify-content: center;
            padding: 10px 0;
            /* Sesuaikan padding agar terlihat terpusat */
            flex-direction: column;
            /* Ubah arah flex agar gambar bisa diposisikan sendiri */
            margin-bottom: 10px;
            height: auto;
        }

        .sidebar.collapsed .profile img {
            /* Hapus margin kanan dari mode lebar */
            margin-right: 0 !important;
            /* Tambahkan margin atas/bawah jika perlu, tapi biasanya tidak perlu */
            margin-bottom: 0;
            /* Pastikan gambar terpusat */
            display: block;
        }

        .sidebar.collapsed .profile .profile-content {
            justify-content: center;
            align-items: center;
            /* Penting: Set display ke flex atau block agar centering berfungsi */
            display: flex;
            /* Kita ingin gambar berada di tengah secara horizontal (dalam lebar 80px) */
            width: 100%;
        }

        .sidebar.collapsed .nav-link {
            /* Pusatkan ikon, hapus gap yang tidak perlu */
            justify-content: center;
            gap: 0;
            padding: 10px 0;
            /* Sesuaikan padding vertikal */
        }

        .sidebar.collapsed .offline-btn {
            /* Perkecil tombol logout, hanya ikon */
            width: 50px !important;
            margin: 15px auto;
            padding: 8px;
            /* Sesuaikan padding */
        }

        .sidebar.collapsed .offline-btn i {
            /* Pusatkan ikon logout */
            margin-right: 0 !important;
        }

        /* Penting: Sesuaikan posisi navbar dan konten saat sidebar collapsed */
        .navbar.collapsed {
            left: 80px;
            /* Sesuaikan dengan lebar sidebar.collapsed */
            width: calc(100% - 80px);
            /* Sesuaikan lebar navbar */
        }

        .content.collapsed {
            margin-left: 80px;
            /* Sesuaikan dengan lebar sidebar.collapsed */
        }

        .sidebar .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .sidebar .profile {
            text-align: left;
            margin-bottom: 20px;
            display: flex;
            /* Aktifkan Flexbox */
            align-items: center;
            /* Posisikan elemen secara vertikal di tengah */
            justify-content: center;
            /* Pusatkan konten di tengah sidebar */
            padding: 10px 20px;
        }

        .sidebar .profile .profile-content {
            /* Memastikan konten (img dan span) berada berdampingan */
            display: flex;
            align-items: center;
        }

        .sidebar .profile img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
            /* Jarak antara foto dan nama */
            margin-bottom: 0;
            /* Hapus margin bawah default yang mungkin ada */
        }

        .sidebar .profile h6 {
            margin-top: 8px;
            font-weight: 600;
            color: #3a2d1a;
        }

        .sidebar .profile .profile-name {
            margin-top: 0;
            font-weight: 600;
            color: #3a2d1a;
            font-size: 1rem;
            /* Biarkan font size lebih normal untuk nama */
        }

        .nav-section-title {
            font-size: 0.8rem;
            font-weight: 600;
            color: #6e5b3b;
            margin: 10px 20px 5px;
        }

        .sidebar .nav-link {
            color: #3a2d1a;
            border-radius: 5px;
            margin: 2px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.2s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #d1b673;
            color: #000;
            font-weight: 600;
        }

        .offline-btn {
            margin: 15px 20px;
            border-radius: 10px;
            background-color: white;
            color: #3a2d1a;
            font-weight: 600;
        }

        .offline-btn i {
            margin-right: 5px;
            /* Tambahan dari file tambah_produk */
        }

        /* ================== 2. NAVBAR STYLES ================== */

        .navbar {
            background-color: #f5c24c;
            padding: 10px 25px;
            position: fixed;
            top: 0;
            left: 260px;
            width: calc(100% - 260px);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        /* Ada dua definisi collapsed di file sumber. Menggunakan left: 0px untuk mode collapsed (menutup sidebar) */
        .navbar.collapsed {
            left: 80px;
            width: calc(100% - 80px);
        }

        .navbar.collapsed #toggle-btn {
            /* Geser tombol sedikit ke kanan. Misalnya, 10px dari kiri (yang sekarang adalah 80px dari tepi layar) */
            margin-left: 10px !important;
        }

        /* ================== 3. CONTENT STYLES ================== */

        .content {
            margin-left: 260px;
            padding: 100px 30px 30px;
            transition: all 0.3s ease;
        }

        /* Ada dua definisi collapsed di file sumber. Menggunakan margin-left: 0px untuk mode collapsed (menutup sidebar) */
        .content.collapsed {
            margin-left: 80px;
        }

        /* ================== 4. CARD & UTILITY STYLES ================== */

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        }

        .card-header-custom {
            background: linear-gradient(135deg, #ffe2a4, #f5c24c);
            border-radius: 12px 12px 0 0;
            border-bottom: none;
            color: #4a3312;
        }

        .section-title {
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #7b643c;
            margin-bottom: 4px;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 500;
            color: #4b3920;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            border-color: #e0c78b;
            font-size: 0.9rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #f0b232;
            box-shadow: 0 0 0 0.15rem rgba(240, 178, 50, 0.35);
        }

        /* Focus tambahan untuk form control di tambah_produk */
        .form-control:focus {
            border-color: #d1b673;
            box-shadow: 0 0 0 0.25rem rgba(209, 182, 115, 0.4);
        }


        /* ================== 5. BUTTON & BADGE STYLES ================== */

        .btn-theme {
            background-color: #f5c24c;
            border-color: #f5c24c;
            color: #4a3312;
            font-weight: 600;
            border-radius: 999px;
            padding: 8px 22px;
        }

        .btn-theme:hover {
            background-color: #e8b138;
            border-color: #e8b138;
            color: #3a2d1a;
        }

        .btn-outline-theme {
            border-radius: 999px;
            border-color: #f5c24c;
            color: #4a3312;
            font-weight: 500;
        }

        .btn-outline-theme:hover {
            background-color: #f5c24c;
            color: #3a2d1a;
        }

        .order-type-badge {
            font-size: 0.8rem;
            border-radius: 999px;
            padding: 4px 10px;
            background-color: #fff3cd;
            color: #7b643c;
        }

        .badge-status {
            font-size: 0.75rem;
            padding: 6px 10px;
            border-radius: 999px;
        }

        /* ================== 6. SPESIFIK KOMPONEN ================== */

        .table-rounded {
            border-radius: 8px;
            /* Sesuaikan nilai */
            overflow: hidden;
        }

        /* Baris Produk di Form Offline */
        .produk-row {
            background-color: #fff7e5;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
        }

        /* Filter ComboBox (dari pemesananOnline) */
        .filter-select {
            position: relative;
        }

        .filter-select i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.9rem;
            color: #a17a29;
            pointer-events: none;
        }

        .filter-select .form-select {
            padding-left: 2rem;
            border-radius: 999px;
            border: 1px solid #d4b36c;
            background-color: #fff7e1;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
            font-size: 0.85rem;
            font-weight: 500;
            color: #5a4525;
            transition: all 0.2s ease-in-out;
        }

        .filter-select .form-select:hover {
            background-color: #ffe9b6;
            border-color: #c8a04a;
        }

        .filter-select .form-select:focus {
            border-color: #f0b232;
            background-color: #fff3cc;
            box-shadow: 0 0 0 0.25rem rgba(240, 178, 50, 0.35);
        }

        .filter-select .form-select option {
            padding: 5px 8px;
            background: #fff;
            color: #5a4525;
        }

        /* Kartu Ringkasan (dari pemesananOnline) */
        .summary-card {
            border-radius: 14px;
            background: linear-gradient(135deg, #ffe2a4, #f5c24c);
            color: #4a3312;
        }

        .summary-card.secondary {
            background: linear-gradient(135deg, #f7e6c9, #d1b673);
        }

        .summary-card.danger {
            background: linear-gradient(135deg, #ffd6c7, #ff9b7a);
        }

        /* Table Produk (dari lihatproduk) */
        .table-custom th {
            background-color: #d1b673;
            color: #3a2d1a;
            font-weight: 600;
            vertical-align: middle;
        }

        .img-thumbnail-custom {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .action-btn {
            margin: 0 2px;
        }

        /* =========== CUSTOM DROPDOWN PRODUK =========== */

        .product-dropdown {
            position: relative;
        }

        .product-dropdown-toggle {
            border-radius: 10px;
            border: 1px solid #e0c78b;
            background-color: #fff;
            padding: 8px 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            font-size: 0.9rem;
        }

        .product-dropdown-toggle:focus {
            outline: none;
            box-shadow: 0 0 0 0.15rem rgba(240, 178, 50, 0.35);
        }

        .product-dropdown-toggle .selected-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .product-dropdown-toggle img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
        }

        .product-dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 2000;
            background-color: #fff;
            border-radius: 10px;
            margin-top: 4px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
            max-height: 260px;
            overflow-y: auto;
            padding: 4px 0;
        }

        .product-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 10px;
            cursor: pointer;
        }

        .product-option:hover {
            background-color: #fff7e5;
        }

        .product-option img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
        }

        .product-option-name {
            font-size: 0.9rem;
            font-weight: 500;
        }

        .product-option-stock {
            font-size: 0.8rem;
            color: #777;
        }
    </style>
</head>

<body>
<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <div>
        <a class="logo" href="/">
            <img class="logo-full" src="{{ asset('images/logo.png') }}" alt="Bakpia Pathok Agung" height="40">

            <img class="logo-icon" src="{{ asset('images/logo-icon.png') }}" alt="Bakpia Icon" height="30">
        </a>
        <div class="profile d-flex align-items-center justify-content-center">
            <div class="profile-content">
                <img src="{{ $loggedInAdmin->image ?? 'bian.png' }}" alt="Admin" class="rounded-circle me-3">
                <span class="profile-name">{{ $loggedInAdmin->username ?? 'Pengguna' }}</span>
            </div>
        </div>

        <div class="menu px-2">
            <hr class="my-2">
            <p class="nav-section-title">Dashboard</p>
            <ul class="nav flex-column px-3">
                <li class="nav-item ">
                    <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                       href="/admin/dashboard" data-bs-toggle="tooltip" data-bs-placement="right"
                       title="Beranda"><i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ request()->is('Analisis') ? 'active' : '' }}" href="#"
                       data-bs-toggle="tooltip" data-bs-placement="right" title="Analisis"><i
                            class="bi bi-graph-up"></i>
                        <span>Analisis</span></a>
                </li>
            </ul>
            <hr class="my-2">
            <p class="nav-section-title mt-3">Pesanan</p>
            <ul class="nav flex-column px-3">
                <li class="nav-item ">
                    <a class="nav-link {{ request()->is('admin/pemesananOnline') ? 'active' : '' }}"
                       href="/admin/pemesananOnline" data-bs-toggle="tooltip" data-bs-placement="right"
                       title="Pemesanan Online"><i class="bi bi-cart4"></i>
                        <span>Pemesanan Online</span></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ request()->is('admin/pemesananOffline') ? 'active' : '' }}"
                       href="/admin/pemesananOffline" data-bs-toggle="tooltip" data-bs-placement="right"
                       title="Pemesanan Offline"><i class="bi bi-telephone"></i>
                        <span>Pemesanan Offline</span></a>
                </li>
            </ul>
            <hr class="my-2">
            <p class="nav-section-title mt-3">Produk</p>
            <ul class="nav flex-column px-3">
                <li class="nav-item ">
                    <a class="nav-link {{ request()->is('lihatproduk') ? 'active' : '' }}"
                       href="/lihatproduk" data-bs-toggle="tooltip" data-bs-placement="right"
                       title="Lihat Produk"><i class="bi bi-box-seam"></i>
                        <span>Lihat Produk</span></a>
                </li>
            </ul>
            <hr class="my-2">
            <p class="nav-section-title mt-3">Admin</p>
            <ul class="nav flex-column px-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('testambahakun') ? 'active' : '' }}"
                       href="/tambah-admin" data-bs-toggle="tooltip" data-bs-placement="right"
                       title="Tambah Admin"><i class="bi bi-person-fill-add"></i>
                        <span>Tambah Admin</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('teskelolaadmin') ? 'active' : '' }}"
                       href="/kelola-admin" data-bs-toggle="tooltip" data-bs-placement="right"
                       title="Kelola Admin"><i class="bi bi-people-fill"></i>
                        <span>Kelola Admin</span></a>
                </li>
            </ul>
        </div>
    </div>

    <div class="text-center mb-3">
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn offline-btn w-75">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </button>
        </form>
    </div>
</div>

<!-- NAVBAR -->
<nav class="navbar d-flex align-items-center" id="navbar">
    <button class="btn btn-light me-3" id="toggle-btn"><i class="bi bi-list"></i></button>
    <input type="text" class="form-control w-50 me-auto" placeholder="Admin Dashboard">
</nav>

@yield('content')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const sidebar = document.getElementById('sidebar');
    const navbar = document.getElementById('navbar');
    const content = document.getElementById('content');
    const toggleBtn = document.getElementById('toggle-btn');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        navbar.classList.toggle('collapsed');
        content.classList.toggle('collapsed');
    });

    /* resources/views/admin/dashboard.blade.php (Di dalam tag <script>) */

    // ... kode JS yang sudah ada

    // INISIALISASI TOOLTIP BOOTSTRAP
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            // Hanya tampilkan tooltip jika sidebar sedang collapsed, atau gunakan konfigurasi default
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>

</body>

</html>
