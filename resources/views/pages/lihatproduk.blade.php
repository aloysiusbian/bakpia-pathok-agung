<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk | Lihat Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #fbf3df;
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
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
            z-index: 1001;
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

        /* Navbar Styles */
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

        /* Content Styles */
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

        /* Styling spesifik untuk tabel */
        .table-custom th {
            background-color: #d1b673;
            color: #3a2d1a;
            font-weight: 600;
            vertical-align: middle;
            /* Header rata tengah vertikal */
        }

        /* Styling Thumbnail Gambar */
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
                <a href="#" class="nav-link"><i class="bi bi-graph-up"></i> <span>Analytics</span></a>
                <hr class="my-2">
                <p class="nav-section-title mt-3">Pesanan</p>

                <a href="{{ route('admin.pemesanan.online') }}" class="nav-link">
                <i class="bi bi-cart4"></i> <span>Pemesanan Online</span></a>
                  <a href="{{ route('admin.pemesanan.offline') }}" class="nav-link"><i class="bi bi-telephone"></i> <span>Pemesanan Offline</span></a>
                <hr class="my-2">
                <p class="nav-section-title mt-3">Produk</p>
                <a href="/tambah_produk" class="nav-link active"><i class="bi bi-box-seam"></i> <span>Lihat Produk</span></a>
                <hr class="my-2">
            </div>
        </div>

        <div class="text-center mb-3">
            <a href="/" class="btn offline-btn w-75"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
    </div>

    <nav class="navbar d-flex align-items-center" id="navbar">
        <button class="btn btn-light me-3" id="toggle-btn"><i class="bi bi-list"></i></button>
        <input type="text" class="form-control w-50 me-auto" placeholder="Daftar Produk">
    </nav>

    <div class="content" id="content">
        <h2 class="mb-4 text-dark">Daftar Produk</h2>

        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5></h5>
                <a href="/tambahproduk" class="btn btn-primary" style="background-color: #f5c24c; border: none; color: #3a2d1a;">
                    <i class="bi bi-plus-circle"></i> Tambah Produk Baru
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered table-custom align-middle">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th style="width: 80px;">Gambar</th>
                            <th>Nama Produk</th>
                            <th>Harga (Rp)</th>
                            <th>Stok</th>
                            <th>Kategori</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- {{-- Contoh Data Statis 1 --}} -->
                        <tr>
                            <td>1</td>
                            <td class="text-center">
                                <img src="/images/bakpia-keju.jpg"
                                    alt="Bakpia "
                                    class="img-thumbnail-custom">
                            </td>
                            <td class="fw-bold">Bakpia Keju (20 Pcs)</td>
                            <td>45.000</td>
                            <td>150</td>
                            <td>Bakpia</td>
                            <td>
                                <a href="{{ url('/admin/produk/1/edit') }}" class="btn btn-sm btn-warning action-btn" title="Edit"><i class="bi bi-pencil"></i></a>
                                <button class="btn btn-sm btn-danger action-btn" title="Hapus"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>

                        <tr>
                            <td>2</td>
                            <td class="text-center">
                                <img src="/images/bakpia-cokelat.jpg"
                                    alt="Bakpia Cokelat"
                                    class="img-thumbnail-custom">
                            </td>
                            <td class="fw-bold">Bakpia Cokelat (10 Pcs)</td>
                            <td>25.000</td>
                            <td>80</td>
                            <td>Bakpia</td>
                            <td>
                                <a href="{{ url('/admin/produk/2/edit') }}" class="btn btn-sm btn-warning action-btn" title="Edit"><i class="bi bi-pencil"></i></a>
                                <button class="btn btn-sm btn-danger action-btn" title="Hapus"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>

                        <tr>
                            <td>3</td>
                            <td class="text-center">
                                <img src="/images/bakpia-kacang-hijau.jpg"
                                    alt="Bakpia Durian"
                                    class="img-thumbnail-custom">
                            </td>
                            <td class="fw-bold">Bakpia Kacang Hijau (20 Pcs)</td>
                            <td>60.000</td>
                            <td>45</td>
                            <td>Bakpia</td>
                            <td>
                                <a href="{{ url('/admin/produk/3/edit') }}" class="btn btn-sm btn-warning action-btn" title="Edit"><i class="bi bi-pencil"></i></a>
                                <button class="btn btn-sm btn-danger action-btn" title="Hapus"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>


                    </tbody>
                </table>
            </div>
        </div>
    </div>

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
    </script>

</body>

</html>