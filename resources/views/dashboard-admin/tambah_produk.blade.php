@extends('templates.sidebar-admin')

@section('title', 'Tambah Produk?')

@section('content')

  <div class="content" id="content">
    <h1 class="h3 fw-bold mb-4">Tambah Produk Baru</h1>

    <div class="card p-4">
      {{-- Form akan dikirimkan ke controller untuk menyimpan produk --}}
        <form action="/admin/produk" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">

          {{-- Nama Produk --}}
          <div class="col-md-6">
            <label for="nama_produk" class="form-label fw-bold">Nama Produk</label>
            <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
          </div>

          {{-- Harga --}}
          <div class="col-md-6">
            <label for="harga" class="form-label fw-bold">Harga (Rp)</label>
            <input type="number" class="form-control" id="harga" name="harga" required min="0">
          </div>

          {{-- Stok --}}
          <div class="col-md-6">
            <label for="stok" class="form-label fw-bold">Stok Tersedia</label>
            <input type="number" class="form-control" id="stok" name="stok" required min="0">
          </div>

          {{-- Pilihan Jenis (Comma Separated) --}}
          <div class="col-md-12">
            <label for="pilihan_jenis" class="form-label fw-bold">Pilihan Jenis (Contoh: Original, Durian,
              Coklat)</label>
            <input type="text" class="form-control" id="pilihan_jenis" name="pilihan_jenis"
              placeholder="Pisahkan dengan koma">
          </div>

          {{-- Deskripsi Produk --}}
          <div class="col-md-12">
            <label for="deskripsi_produk" class="form-label fw-bold">Deskripsi Produk</label>
            <textarea class="form-control" id="deskripsi_produk" name="deskripsi_produk" rows="5" required></textarea>
          </div>

          {{-- Gambar Produk --}}
          <div class="col-md-12">
            <label for="gambar" class="form-label fw-bold">Gambar Produk</label>
            <input class="form-control" type="file" id="gambar" name="gambar" accept="image/*" required>
          </div>

          {{-- Tombol Submit --}}
          <div class="col-12 mt-4">
            <button type="submit" class="btn btn-dark fw-bold w-100">
              <i class="bi bi-plus-circle me-2"></i> Simpan Produk Baru
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

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
  </script>
@endsection
