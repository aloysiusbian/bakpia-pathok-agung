@extends('templates.sidebar-admin')

@section('title', 'Lihat Produk')

@section('content')

<div class="content" id="content">
    <h2 class="mb-4 text-dark"><b>Daftar Produk</b></h2>

    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Data Produk Bakpia</h5>
            <button class="btn btn-primary" style="background-color: #f5c24c; border: none; color: #3a2d1a;"
                    data-bs-toggle="modal" data-bs-target="#modalTambahProduk">
                <i class="bi bi-plus-circle"></i> Tambah Produk Baru
            </button>
        </div>

        <div class="table-responsive table-rounded overflow-hidden">
            <table class="table table-hover table-bordered table-custom align-middle">
                <thead class="text-center">
                <tr>
                    <th style="width: 50px;">#</th>
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
                        <img src="/images/bakpia-keju.jpg" alt="Bakpia " class="img-thumbnail-custom">
                    </td>
                    <td class="fw-bold">Bakpia Keju (20 Pcs)</td>
                    <td>45.000</td>
                    <td>150</td>
                    <td>Bakpia</td>
                    <td>
                        <a href="{{ url('/admin/produk/1/edit') }}" class="btn btn-sm btn-warning action-btn"
                           title="Edit"><i class="bi bi-pencil"></i></a>
                        <button class="btn btn-sm btn-danger action-btn" title="Hapus"><i
                                class="bi bi-trash"></i></button>
                    </td>
                </tr>

                <!-- {{-- Contoh Data Statis 2 --}} -->
                <tr>
                    <td>2</td>
                    <td class="text-center">
                        <img src="/images/bakpia-cokelat.jpg" alt="Bakpia Cokelat" class="img-thumbnail-custom">
                    </td>
                    <td class="fw-bold">Bakpia Cokelat (10 Pcs)</td>
                    <td>25.000</td>
                    <td>80</td>
                    <td>Bakpia</td>
                    <td>
                        <a href="{{ url('/admin/produk/2/edit') }}" class="btn btn-sm btn-warning action-btn"
                           title="Edit"><i class="bi bi-pencil"></i></a>
                        <button class="btn btn-sm btn-danger action-btn" title="Hapus"><i
                                class="bi bi-trash"></i></button>
                    </td>
                </tr>

                <tr>
                    <td>3</td>
                    <td class="text-center">
                        <img src="/images/bakpia-kacang-hijau.jpg" alt="Bakpia Durian" class="img-thumbnail-custom">
                    </td>
                    <td class="fw-bold">Bakpia Durian Spesial</td>
                    <td>60.000</td>
                    <td>45</td>
                    <td>Bakpia</td>
                    <td>
                        <a href="{{ url('/admin/produk/3/edit') }}" class="btn btn-sm btn-warning action-btn"
                           title="Edit"><i class="bi bi-pencil"></i></a>
                        <button class="btn btn-sm btn-danger action-btn" title="Hapus"><i
                                class="bi bi-trash"></i></button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH PRODUK -->
<div class="modal fade" id="modalTambahProduk" tabindex="-1" aria-labelledby="modalTambahProdukLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 14px;">
            <div class="modal-header" style="background: #f5c24c;">
                <h5 class="modal-title" id="modalTambahProdukLabel" style="color:#4a3312; font-weight:700;">
                    Tambah Produk Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ url('/admin/produk/store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="row g-3">

                        <!-- Nama Produk -->
                        <div class="col-md-6">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" name="nama_produk" class="form-control" required>
                        </div>

                        <!-- Jenis -->
                        <div class="col-md-6">
                            <label class="form-label">Pilihan Jenis</label>
                            <input type="text" name="jenis" class="form-control" required>
                        </div>

                        <!-- Kategori -->
                        <div class="col-md-6">
                            <label class="form-label">Kategori</label>
                            <input type="text" name="kategori" class="form-control" required>
                        </div>

                        <!-- Harga -->
                        <div class="col-md-3">
                            <label class="form-label">Harga (Rp)</label>
                            <input type="number" name="harga" class="form-control" required>
                        </div>

                        <!-- Stok -->
                        <div class="col-md-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" class="form-control" required>
                        </div>

                        <!-- Upload Gambar -->
                        <div class="col-md-6">
                            <label class="form-label">Upload Gambar</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*" required>
                        </div>

                        <!-- Deskripsi Produk -->
                        <div class="col-12">
                            <label class="form-label">Deskripsi Produk</label>
                            <textarea name="deskripsi" rows="3" class="form-control"></textarea>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-theme">
                        Simpan Produk
                    </button>
                </div>
            </form>

        </div>
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
