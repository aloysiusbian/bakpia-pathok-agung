<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Admin | Tambah Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #fbf3df;
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        /* Styling CSS yang sama persis untuk konsistensi */
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
        }

        .sidebar.collapsed {
            transform: translateX(-200%);
        }

        .sidebar .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .sidebar .profile {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar .profile img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }

        .sidebar .profile h6 {
            margin-top: 8px;
            font-weight: 600;
            color: #3a2d1a;
        }

        .nav-section-title {
            font-size: 0.8rem;
            font-weight: 600;
            color: #6e5b3b;
            margin: 10px 20px 5px;
        }

        .sidebar .nav-link {
            color: #3a2d1a;
            border-radius: 8px;
            margin: 4px 10px;
            display: flex;
            align-items: center;
            gap: 10px;
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

        .navbar.collapsed {
            left: 0;
            width: 100%;
        }

        .content {
            margin-left: 260px;
            padding: 100px 30px 30px;
            transition: all 0.3s ease;
        }

        .content.collapsed {
            margin-left: 0;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-primary-custom {
            background-color: #f5c24c;
            border: none;
            color: #3a2d1a;
            font-weight: 600;
        }
        .btn-primary-custom:hover {
            background-color: #d1b673;
            color: #3a2d1a;
        }
    </style>
</head>

<body>

    <div class="sidebar" id="sidebar">
        <div>
            <a class="logo" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Bakpia Pathok Agung" height="40">
            </a>
            <div class="profile">
                <img src="{{ asset('images/bian.png') }}" alt="Admin">
                <h6>Alberto Sahara</h6>
            </div>

            <div class="menu px-2">
                <hr class="my-2">
                <p class="nav-section-title">Dashboard</p>
                <a href="/admin/dashboard" class="nav-link"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a>
                <a href="/pemesananonline" class="nav-link"><i class="bi bi-graph-up"></i> <span>Analytics</span></a>
                <hr class="my-2">
                <p class="nav-section-title mt-3">Pesanan</p>
                <a href="{{ route('admin.pemesanan.online') }}" class="nav-link">
                    <i class="bi bi-cart4"></i> <span>Pemesanan Online</span>
                </a>
                <a href="/pemesananoffline" class="nav-link"><i class="bi bi-telephone"></i> <span>Pemesanan Offline</span></a>
                <hr class="my-2">
                <p class="nav-section-title mt-3">Produk</p>
                <a href="/tambah_produk" class="nav-link"><i class="bi bi-box-seam"></i> <span>Lihat Produk</span></a>
                <hr class="my-2">
                <p class="nav-section-title mt-3">Admin</p>
                <a href="/testambahakun" class="nav-link active"><i class="bi bi-person-fill-add"></i> <span>Tambah Akun Admin</span></a>
                <a href="/teskelolaadmin" class="nav-link"><i class="bi bi-people-fill"></i> <span>Kelola Akun</span></a>
                <hr class="my-2">
            </div>
        </div>

        <div class="text-center mb-3">
            <a href="/" class="btn offline-btn w-75"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
    </div>

    <nav class="navbar d-flex align-items-center" id="navbar">
        <button class="btn btn-light me-3" id="toggle-btn"><i class="bi bi-list"></i></button>
        <input type="text" class="form-control w-50 me-auto" placeholder="Tambah Akun Administrator">
    </nav>

    <div class="content" id="content">
        <h2 class="mb-4 text-dark">Registrasi Akun Admin Baru</h2>

        <div class="card p-4">
            <div class="mb-4">
                {{-- Anda mungkin ingin tautan ini menuju halaman kelola akun admin --}}
                <a href="{{ url('/admin/accounts') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Kembali ke Kelola Akun</a>
            </div>
            
            {{-- Form untuk registrasi akun baru --}}
            <form action="{{ url('/admin/accounts') }}" method="POST">
                {{-- Di Laravel, Anda akan menambahkan: @csrf --}}
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="name" required placeholder="Contoh: Budi Santoso">
                    </div>
                    
                    <div class="col-md-6">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control" id="email" name="email" required placeholder="Contoh: budi.admin@bakpia.com">
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label">Kata Sandi (Password)</label>
                        <input type="password" class="form-control" id="password" name="password" required minlength="8" placeholder="Minimal 8 karakter">
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required minlength="8" placeholder="Ulangi kata sandi">
                    </div>
                    
                    <div class="col-12">
                        <label for="peran" class="form-label">Peran Akun</label>
                        <select class="form-select" id="peran" name="role" required>
                            <option selected disabled value="">Pilih Peran...</option>
                            <option value="admin">Administrator Penuh</option>
                            <option value="manager">Manager Produk & Stok</option>
                            <option value="finance">Finance/Keuangan</option>
                        </select>
                        <div class="form-text">Pastikan peran yang dipilih sesuai dengan tanggung jawab pengguna.</div>
                    </div>

                    <div class="col-12 mt-4 text-end">
                        <button type="reset" class="btn btn-outline-secondary me-2">Reset Formulir</button>
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="bi bi-person-check-fill"></i> Daftarkan Admin
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <script>
        // JavaScript untuk Toggle Sidebar
        const sidebar = document.getElementById('sidebar');
        const navbar = document.getElementById('navbar');
        const content = document.getElementById('content');
        const toggleBtn = document.getElementById('toggle-btn');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            navbar.classList.toggle('collapsed');
            content.classList.toggle('collapsed');
        });
    </script>

</body>

</html>