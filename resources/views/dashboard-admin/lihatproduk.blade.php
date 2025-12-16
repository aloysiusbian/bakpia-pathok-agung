@extends('templates.sidebar-admin')

@section('title', 'Lihat Produk')

@section('content')

    <div class="content" id="content">
        <h2 class="mb-4 text-dark"><b>Daftar Produk</b></h2>

        {{-- 1. PESAN SUKSES (Jika Controller mengirim: ->with('success', '...') ) --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- 2. PESAN GAGAL/ERROR UMUM (Jika Controller mengirim: ->with('error', '...') ) --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-x-octagon-fill me-2"></i>
                <strong>Gagal!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- 3. ERROR VALIDASI (Jika Validator gagal: ->withErrors(...) ) --}}
        @if ($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Perhatian!</strong> Ada kesalahan input. Mohon periksa kembali formulir Anda:
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            {{-- TAMBAHAN KRUSIAL: Tampilkan MODAL EDIT secara OTOMATIS jika VALIDASI GAGAL --}}
            <script>
                // Hanya jalankan jika ada error validasi
                var editModal = new bootstrap.Modal(document.getElementById('modalEditProduk'));
                editModal.show();
            </script>
        @endif

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

                        @foreach ($produks as $produk)
                            <tr id="row-{{ $produk->idProduk }}">
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    {{-- Asumsi gambar disimpan di storage/app/public/images --}}
                                    <img src="{{ asset('storage/produk_images/' . $produk->gambar) }}"
                                        alt="{{ $produk->namaProduk }}" class="img-thumbnail-custom"
                                        style="width: 70px; height: 70px; object-fit: cover;">
                                </td>
                                <td class="fw-bold">{{ $produk->namaProduk }}</td>
                                {{-- Menggunakan number_format untuk harga --}}
                                <td>{{ number_format($produk->harga, 0, ',', '.') }}</td>
                                <td>{{ $produk->stok }}</td>
                                <td>{{ $produk->kategori }}</td>
                                <td>
                                    {{-- TOMBOL EDIT --}}
                                    <button class="btn btn-sm btn-warning action-btn text-white" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#modalEditProduk"
                                        data-id="{{ $produk->idProduk }}" data-nama="{{ $produk->namaProduk }}"
                                        data-jenis="{{ $produk->pilihanJenis }}" data-kategori="{{ $produk->kategori }}"
                                        data-harga="{{ $produk->harga }}" data-stok="{{ $produk->stok }}"
                                        data-deskripsi="{{ $produk->deskripsiProduk }}" onclick="populateEditModal(this)">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    {{-- TOMBOL HAPUS --}}
                                    <button class="btn btn-sm btn-danger action-btn" title="Hapus" data-bs-toggle="modal"
                                        data-bs-target="#modalHapusProduk" onclick="setDeleteId({{ $produk->idProduk }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

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
                {{-- Form action diarahkan ke route store --}}
                <form action="{{ url('/admin/produk') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Produk</label>
                                <input type="text" name="namaProduk" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pilihan Jenis (Contoh: 15/25)</label>
                                <input type="text" name="pilihanJenis" class="form-control" required>
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
                                <textarea name="deskripsiProduk" rows="3" class="form-control"></textarea>
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

    <div class="modal fade" id="modalEditProduk" tabindex="-1" aria-labelledby="modalEditProdukLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 14px;">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-dark" id="modalEditProdukLabel" style="font-weight:700;">
                        Edit Produk
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                {{-- Action form akan diisi oleh JavaScript dengan URL /admin/produk/{id} --}}
                <form id="formEditProduk" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Produk</label>
                                <input type="text" id="edit_nama_produk" name="namaProduk" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pilihan Jenis</label>
                                <input type="text" id="edit_jenis" name="pilihanJenis" class="form-control" required>
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
                                <textarea id="edit_deskripsi" name="deskripsiProduk" rows="3"
                                    class="form-control"></textarea>
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
                    <p class="text-muted mb-0">Tindakan ini tidak dapat dibatalkan. Data produk akan hilang secara permanen.
                    </p>
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

    {{-- Pastikan Anda sudah memuat Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // --- SCRIPT MODAL EDIT ---
        function populateEditModal(button) {
            // 1. Ambil data dari atribut tombol
            const idProduk = button.getAttribute('data-id');
            const namaProduk = button.getAttribute('data-nama');
            const pilihanJenis = button.getAttribute('data-jenis');
            const kategori = button.getAttribute('data-kategori');
            const harga = button.getAttribute('data-harga');
            const stok = button.getAttribute('data-stok');
            const deskripsiProduk = button.getAttribute('data-deskripsi');

            // 2. Isi nilai input dalam modal edit
            // document.getElementById('edit_id').value = idProduk; // Hapus baris ini karena kita menghapus input hidden ID
            document.getElementById('edit_nama_produk').value = namaProduk;
            document.getElementById('edit_jenis').value = pilihanJenis;
            document.getElementById('edit_kategori').value = kategori;
            document.getElementById('edit_harga').value = harga;
            document.getElementById('edit_stok').value = stok;
            document.getElementById('edit_deskripsi').value = deskripsiProduk;

            // 3. Update Action Form agar mengarah ke route update yang benar (/admin/produk/{id})
            const form = document.getElementById('formEditProduk');
            // Menggunakan route() helper untuk membuat URL yang benar: /admin/produk/ID
            form.action = '{{ url("admin/lihatproduk") }}/' + idProduk + '/update';
        }

        // --- SCRIPT MODAL HAPUS (Interaksi Backend) ---
        // Hanya menyimpan ID
        function setDeleteId(idProduk) {
            document.getElementById('deleteIdInput').value = idProduk;
        }

        function confirmDelete() {
            const idToDelete = document.getElementById('deleteIdInput').value;

            // URL BARU: Mengarah ke /admin/produk/{id}
            const url = '{{ url("admin/lihatproduk") }}';

            // Mengirim request DELETE (menggunakan fetch dengan method: 'POST' dan spoofing '_method': 'DELETE')
            fetch(url, {
                method: 'POST', // Walaupun ini DELETE secara konseptual, kita kirim POST
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    '_method': 'DELETE', // Spoofing method
                    // Kita juga bisa mengirim ID di sini, tapi karena sudah di URL, ini tidak wajib.
                })
            })
                .then(response => {
                    if (response.ok) {
                        // Hapus baris dari DOM setelah sukses dari backend
                        const row = document.getElementById('row-' + idToDelete);
                        if (row) row.remove();

                        // Tutup modal
                        const modalElement = document.getElementById('modalHapusProduk');
                        const modalInstance = bootstrap.Modal.getInstance(modalElement);
                        modalInstance.hide();

                        // Tampilkan pesan sukses (opsional)
                        alert('Produk berhasil dihapus!');
                    } else {
                        // Perlu menambahkan log/cek response.json() untuk detail error dari server
                        alert('Gagal menghapus produk. Terjadi kesalahan server.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan jaringan.');
                });
        }

        // --- Script Sidebar & Navbar (Keeping for completeness) ---
        const sidebar = document.getElementById('sidebar');
        const navbar = document.getElementById('navbar');
        const content = document.getElementById('content');
        const toggleBtn = document.getElementById('toggle-btn');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                if (sidebar) sidebar.classList.toggle('collapsed');
                if (navbar) navbar.classList.toggle('collapsed');
                if (content) content.classList.toggle('collapsed');
            });
        }
    </script>

@endsection