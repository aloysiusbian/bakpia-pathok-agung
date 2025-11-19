<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Admin | Kelola Akun</title>
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

        /* Styling spesifik untuk tabel */
        .table-custom th {
            background-color: #d1b673; /* Warna kepala tabel yang serasi */
            color: #3a2d1a;
            font-weight: 600;
        }
        .action-btn {
            margin: 0 2px;
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
                <a href="#" class="nav-link"><i class="bi bi-graph-up"></i> <span>Analytics</span></a>
                <hr class="my-2">
                <p class="nav-section-title mt-3">Pesanan</p>
                <a href="{{ route('admin.pemesanan.online') }}" class="nav-link">
                    <i class="bi bi-cart4"></i> <span>Pemesanan Online</span>
                </a>
                <a href="#" class="nav-link"><i class="bi bi-telephone"></i> <span>Pemesanan Offline</span></a>
                <hr class="my-2">
                <p class="nav-section-title mt-3">Produk</p>
                <a href="/tambah_produk" class="nav-link"><i class="bi bi-box-seam"></i> <span>Lihat Produk</span></a>
                <hr class="my-2">
                <p class="nav-section-title mt-3">Pengaturan</p>
                <a href="/testambahakun" class="nav-link"><i class="bi bi-person-fill-add"></i> <span>Tambah Akun Admin</span></a>
                <a href="/teskelolaadmin" class="nav-link active"><i class="bi bi-people-fill"></i> <span>Kelola Akun</span></a>
                <hr class="my-2">
            </div>
        </div>

        <div class="text-center mb-3">
            <a href="/" class="btn offline-btn w-75"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
    </div>

    <nav class="navbar d-flex align-items-center" id="navbar">
        <button class="btn btn-light me-3" id="toggle-btn"><i class="bi bi-list"></i></button>
        <input type="text" class="form-control w-50 me-auto" placeholder="Kelola Akun Administrator">
    </nav>

    <div class="content" id="content">
        <h2 class="mb-4 text-dark">Kelola Akun Administrator</h2>

        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Daftar Pengguna Admin</h5>
                <a href="/testambahakun" class="btn btn-primary-custom">
                    <i class="bi bi-person-add"></i> Tambah Admin Baru
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered table-custom">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Peran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Ini adalah contoh data statis. Di Laravel, Anda akan menggunakan @foreach loop --}}
                        <tr>
                            <td>1</td>
                            <td>Alberto Sahara</td>
                            <td>alberto.s@bakpia.com</td>
                            <td>Administrator</td>
                            <td><span class="badge bg-success">Aktif</span></td>
                            <td>
                                <a href="{{ url('/admin/accounts/1/edit') }}" class="btn btn-sm btn-warning action-btn" title="Edit"><i class="bi bi-pencil"></i></a>
                                <button class="btn btn-sm btn-danger action-btn" title="Hapus"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Reza Kakap</td>
                            <td>reza.k@bakpia.com</td>
                            <td>Administrator</td>
                            <td><span class="badge bg-warning text-dark">Nonaktif</span></td>
                            <td>
                                <a href="{{ url('/admin/accounts/2/edit') }}" class="btn btn-sm btn-warning action-btn" title="Edit"><i class="bi bi-pencil"></i></a>
                                <button class="btn btn-sm btn-danger action-btn" title="Hapus"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    
                        {{-- Akhir contoh data --}}

                        {{-- Di Laravel, Anda akan menggunakan: --}}
                        {{-- @foreach ($admins as $admin)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->role_name }}</td>
                            <td><span class="badge bg-{{ $admin->is_active ? 'success' : 'warning text-dark' }}">{{ $admin->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                            <td>
                                <a href="{{ route('admin.accounts.edit', $admin->id) }}" class="btn btn-sm btn-warning action-btn" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.accounts.destroy', $admin->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger action-btn" onclick="return confirm('Yakin ingin menghapus akun ini?')" title="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
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

<!-- <!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk | Tambah Baru</title>
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
                <a href="#" class="nav-link"><i class="bi bi-graph-up"></i> <span>Analytics</span></a>
                <hr class="my-2">
                <p class="nav-section-title mt-3">Pesanan</p>
                <a href="{{ route('admin.pemesanan.online') }}" class="nav-link">
                    <i class="bi bi-cart4"></i> <span>Pemesanan Online</span>
                </a>
                <a href="#" class="nav-link"><i class="bi bi-telephone"></i> <span>Pemesanan Offline</span></a>
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
        <input type="text" class="form-control w-50 me-auto" placeholder="Tambah Produk Baru">
    </nav>

    <div class="content" id="content">
        <h2 class="mb-4 text-dark">Tambah Produk Baru</h2>

        <div class="card p-4">
            <div class="mb-4">
                <a href="{{ url('/admin/produk') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Kembali ke Daftar Produk</a>
            </div>
            
            <form action="{{ url('/admin/produk') }}" method="POST" enctype="multipart/form-data">
                {{-- Di Laravel, Anda akan menambahkan: @csrf --}}
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nama_produk" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk" required placeholder="Contoh: Bakpia Original (15 Pcs)">
                    </div>
                    
                    <div class="col-md-6">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori" name="kategori_id" required>
                            <option selected disabled value="">Pilih Kategori...</option>
                            <option value="1">Bakpia</option>
                            <option value="2">Minuman</option>
                            <option value="3">Oleh-Oleh Lain</option>
                            {{-- Di Laravel, Anda akan loop data kategori: @foreach ($kategoris as $kategori) ... @endforeach --}}
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="harga" class="form-label">Harga (Rp)</label>
                        <input type="number" class="form-control" id="harga" name="harga" required min="0" placeholder="Contoh: 45000">
                    </div>

                    <div class="col-md-4">
                        <label for="stok" class="form-label">Stok Awal</label>
                        <input type="number" class="form-control" id="stok" name="stok" required min="0" placeholder="Contoh: 100">
                    </div>

                    <div class="col-md-4">
                        <label for="berat" class="form-label">Berat (Gram)</label>
                        <input type="number" class="form-control" id="berat" name="berat" required min="1" placeholder="Contoh: 500">
                    </div>

                    <div class="col-12">
                        <label for="deskripsi" class="form-label">Deskripsi Produk</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required placeholder="Jelaskan detail produk, rasa, dan daya tahan."></textarea>
                    </div>

                    <div class="col-12">
                        <label for="gambar" class="form-label">Gambar Produk</label>
                        <input class="form-control" type="file" id="gambar" name="gambar" accept="image/*" required>
                        <div class="form-text">Maksimal ukuran file 2MB (jpg, jpeg, png).</div>
                    </div>

                    <div class="col-12 mt-4 text-end">
                        <button type="reset" class="btn btn-outline-secondary me-2">Reset Formulir</button>
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="bi bi-save"></i> Simpan Produk
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

</html> -->