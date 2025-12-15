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
                <tr id="row-1">
                    <td>1</td>
                    <td class="text-center">
                        <img src="/images/bakpia-keju.jpg" alt="Bakpia " class="img-thumbnail-custom">
                    </td>
                    <td class="fw-bold">Bakpia Keju (20 Pcs)</td>
                    <td>45.000</td>
                    <td>150</td>
                    <td>Bakpia</td>
                    <td>
                        <!-- TOMBOL EDIT (Dimodifikasi untuk memicu Modal) -->
                        <button class="btn btn-sm btn-warning action-btn text-white" title="Edit"
                                data-bs-toggle="modal" 
                                data-bs-target="#modalEditProduk"
                                data-id="1"
                                data-nama="Bakpia Keju (20 Pcs)"
                                data-jenis="Kering"
                                data-kategori="Bakpia"
                                data-harga="45000"
                                data-stok="150"
                                data-deskripsi="Bakpia rasa keju yang gurih dan lembut."
                                onclick="populateEditModal(this)">
                            <i class="bi bi-pencil"></i>
                        </button>

                        <!-- TOMBOL HAPUS -->
                        <button class="btn btn-sm btn-danger action-btn" title="Hapus" 
                                data-bs-toggle="modal" data-bs-target="#modalHapusProduk"
                                onclick="setDeleteId(1)">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>

                <!-- {{-- Contoh Data Statis 2 --}} -->
                <tr id="row-2">
                    <td>2</td>
                    <td class="text-center">
                        <img src="/images/bakpia-cokelat.jpg" alt="Bakpia Cokelat" class="img-thumbnail-custom">
                    </td>
                    <td class="fw-bold">Bakpia Cokelat (10 Pcs)</td>
                    <td>25.000</td>
                    <td>80</td>
                    <td>Bakpia</td>
                    <td>
                        <!-- TOMBOL EDIT -->
                        <button class="btn btn-sm btn-warning action-btn text-white" title="Edit"
                                data-bs-toggle="modal" 
                                data-bs-target="#modalEditProduk"
                                data-id="2"
                                data-nama="Bakpia Cokelat (10 Pcs)"
                                data-jenis="Kering"
                                data-kategori="Bakpia"
                                data-harga="25000"
                                data-stok="80"
                                data-deskripsi="Bakpia isi cokelat lumer."
                                onclick="populateEditModal(this)">
                            <i class="bi bi-pencil"></i>
                        </button>

                        <button class="btn btn-sm btn-danger action-btn" title="Hapus" 
                                data-bs-toggle="modal" data-bs-target="#modalHapusProduk"
                                onclick="setDeleteId(2)">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>

                <!-- {{-- Contoh Data Statis 3 --}} -->
                <tr id="row-3">
                    <td>3</td>
                    <td class="text-center">
                        <img src="/images/bakpia-kacang-hijau.jpg" alt="Bakpia Durian" class="img-thumbnail-custom">
                    </td>
                    <td class="fw-bold">Bakpia Durian Spesial</td>
                    <td>60.000</td>
                    <td>45</td>
                    <td>Bakpia</td>
                    <td>
                        <!-- TOMBOL EDIT -->
                        <button class="btn btn-sm btn-warning action-btn text-white" title="Edit"
                                data-bs-toggle="modal" 
                                data-bs-target="#modalEditProduk"
                                data-id="3"
                                data-nama="Bakpia Durian Spesial"
                                data-jenis="Kering"
                                data-kategori="Bakpia"
                                data-harga="60000"
                                data-stok="45"
                                data-deskripsi="Rasa durian asli premium."
                                onclick="populateEditModal(this)">
                            <i class="bi bi-pencil"></i>
                        </button>

                        <button class="btn btn-sm btn-danger action-btn" title="Hapus" 
                                data-bs-toggle="modal" data-bs-target="#modalHapusProduk"
                                onclick="setDeleteId(3)">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH PRODUK -->
<div class="modal fade" id="modalTambahProduk" tabindex="-1" aria-labelledby="modalTambahProdukLabel" aria-hidden="true">
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
                        <div class="col-md-6">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" name="nama_produk" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pilihan Jenis</label>
                            <input type="text" name="jenis" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kategori</label>
                            <input type="text" name="kategori" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Harga (Rp)</label>
                            <input type="number" name="harga" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Upload Gambar</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi Produk</label>
                            <textarea name="deskripsi" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-theme">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDIT PRODUK (BARU) -->
<div class="modal fade" id="modalEditProduk" tabindex="-1" aria-labelledby="modalEditProdukLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 14px;">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-dark" id="modalEditProdukLabel" style="font-weight:700;">
                    Edit Produk
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
           
            <form id="formEditProduk" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Method spoofing untuk update -->
                
                <div class="modal-body">
                    <!-- Input Hidden ID (Opsional) -->
                    <input type="hidden" id="edit_id" name="id">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" id="edit_nama_produk" name="nama_produk" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pilihan Jenis</label>
                            <input type="text" id="edit_jenis" name="jenis" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kategori</label>
                            <input type="text" id="edit_kategori" name="kategori" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Harga (Rp)</label>
                            <input type="number" id="edit_harga" name="harga" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Stok</label>
                            <input type="number" id="edit_stok" name="stok" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ganti Gambar (Opsional)</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Deskripsi Produk</label>
                            <textarea id="edit_deskripsi" name="deskripsi" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL HAPUS PRODUK -->
<div class="modal fade" id="modalHapusProduk" tabindex="-1" aria-labelledby="modalHapusProdukLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 14px;">
            <div class="modal-header" style="background: #dc3545; color: white;">
                <h5 class="modal-title" id="modalHapusProdukLabel" style="font-weight:700;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Hapus Produk
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <h5 class="mb-3">Apakah Anda yakin ingin menghapus produk ini?</h5>
                <p class="text-muted mb-0">Tindakan ini tidak dapat dibatalkan. Data produk akan hilang secara permanen.</p>
                <!-- Input hidden untuk menyimpan ID yang akan dihapus -->
                <input type="hidden" id="deleteIdInput">
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                    Batal
                </button>
                <button type="button" class="btn btn-danger px-4" onclick="confirmDelete()">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // --- Script Sidebar & Navbar ---
    const sidebar = document.getElementById('sidebar');
    const navbar = document.getElementById('navbar');
    const content = document.getElementById('content');
    const toggleBtn = document.getElementById('toggle-btn');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            if(sidebar) sidebar.classList.toggle('collapsed');
            if(navbar) navbar.classList.toggle('collapsed');
            if(content) content.classList.toggle('collapsed');
        });
    }

    // --- SCRIPT MODAL EDIT ---
    function populateEditModal(button) {
        // 1. Ambil data dari atribut tombol
        const id = button.getAttribute('data-id');
        const nama = button.getAttribute('data-nama');
        const jenis = button.getAttribute('data-jenis');
        const kategori = button.getAttribute('data-kategori');
        const harga = button.getAttribute('data-harga');
        const stok = button.getAttribute('data-stok');
        const deskripsi = button.getAttribute('data-deskripsi');

        // 2. Isi nilai input dalam modal edit
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nama_produk').value = nama;
        document.getElementById('edit_jenis').value = jenis;
        document.getElementById('edit_kategori').value = kategori;
        document.getElementById('edit_harga').value = harga;
        document.getElementById('edit_stok').value = stok;
        document.getElementById('edit_deskripsi').value = deskripsi;

        // 3. Update Action Form agar mengarah ke route update yang benar
        // Contoh: /admin/produk/1/update
        const form = document.getElementById('formEditProduk');
        form.action = '/admin/produk/' + id + '/update';
    }

    // --- SCRIPT MODAL HAPUS (Simulasi) ---
    function setDeleteId(id) {
        document.getElementById('deleteIdInput').value = id;
    }

    function confirmDelete() {
        const idToDelete = document.getElementById('deleteIdInput').value;
        const row = document.getElementById('row-' + idToDelete);
        
        if (row) {
            row.remove();
            
            // Tutup modal
            const modalElement = document.getElementById('modalHapusProduk');
            const modalInstance = bootstrap.Modal.getInstance(modalElement);
            modalInstance.hide();
        }
    }
</script>

@endsection