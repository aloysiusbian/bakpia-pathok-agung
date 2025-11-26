<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pelanggan | Edit Profil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #fbf3df;
      font-family: 'Poppins', sans-serif;
      overflow-x: hidden;
    }

    /* Sidebar */
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

    .form-control:focus {
      box-shadow: 0 0 5px rgba(241, 173, 24, 0.8);
      border-color: #e2b13c;
    }

    .btn-save {
      background-color: #f5c24c;
      color: #000;
      font-weight: 600;
      border-radius: 10px;
      transition: all 0.2s;
    }

    .btn-save:hover {
      background-color: #e0a918;
    }

    .card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body>
  @php
    // Simulasi data dari "database"
    $customer = [
      'nama' => 'Alberto Sahara',
      'email' => 'alberto@example.com',
      'telepon' => '0812-3456-7890',
      'alamat' => 'Jl. Malioboro No. 12, Yogyakarta',
      'gambar' => asset('images/bian.png')
    ];
  @endphp

  <!-- SIDEBAR -->
  <div class="sidebar" id="sidebar">
    <div>
      <a class="logo" href="/">
        <img src="{{ asset('images/logo.png') }}" alt="Bakpia Pathok Agung" height="40">
      </a>
      <div class="profile">
        <img src="{{ asset('images/bian.png') }}" alt="Pelanggan">
        <h6>{{ Auth::user()->name ?? 'Reza Saputra' }}</h6>
      </div>

      <div class="menu px-2">
        <hr>
        <p class="nav-section-title">Menu Utama</p>
        <a href="/testes" class="nav-link"><i class="bi bi-house-door"></i> <span>Beranda</span></a>
        <a href="/teslihat" class="nav-link active"><i class="bi bi-person-circle"></i> <span>Lihat Profil</span></a>
        <a href="/tesriwayat" class="nav-link"><i class="bi bi-clock-history"></i> <span>Riwayat Pembelian</span></a>
        <hr>
      </div>
    </div>

    <div class="text-center mb-3">
      <a href="/" class="btn offline-btn w-75"><i class="bi bi-box-arrow-right"></i> Kembali? </a>
    </div>
  </div>

  <!-- NAVBAR -->
  <nav class="navbar d-flex align-items-center" id="navbar">
    <button class="btn btn-light me-3" id="toggle-btn"><i class="bi bi-list"></i></button>
    <input type="text" class="form-control w-50 me-auto" placeholder="Lihat Profil">
  </nav>

  <!-- CONTENT -->
  <div class="content" id="content">
    <div class="card p-4">
      <div class="d-flex align-items-center">
        <img src="{{ $customer['gambar'] }}" alt="Foto Profil" class="rounded-circle me-4" width="100" height="100">
        <div class="profile-info">
          <h5>{{ $customer['nama'] }}</h5>
          <p>{{ $customer['email'] }}</p>
          <p>{{ $customer['telepon'] }}</p>
          <p>{{ $customer['alamat'] }}</p>
        </div>
      </div>
       <div class="mt-4">
        <a href="/tesedit" class="btn btn-warning"><i class="bi bi-pencil-square"></i> Edit Profil</a>

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