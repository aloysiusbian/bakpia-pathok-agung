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

        <div class="table-responsive table-rounded overflow-hidden shadow-lg border">
            <table class="table table-hover table-bordered table-custom align-middle mb-0">
                <thead class="text-center bg-gray-100 border-b">
                <tr>
                    <th style="width: 50px;" class="py-3">#</th>
                    <th style="width: 100px;">Gambar</th>
                    <th>Nama Produk</th>
                    <th>Harga (Rp)</th>
                    <th>Stok</th>
                    <th>Kategori</th>
                    <th style="width: 150px;">Aksi</th>
                </tr>
                </thead>
                <tbody>

                @if(isset($products) && $products->count() > 0)
                {{-- Loop untuk setiap produk dalam koleksi $produks --}}
                @foreach($products as $index => $produk)
                <tr class="text-sm">
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">
                        {{-- Ganti '/images/' dengan path penyimpanan gambar Anda (misalnya: 'storage/products/') --}}
                        <img src="{{ asset($produk->image ?? 'images/bakpia-cokelat.jpg') }}"
                             alt="{{ $produk->namaProduk }}"
                             class="img-thumbnail-custom w-16 h-16 object-cover rounded-md mx-auto border"
                             onerror="this.onerror=null;this.src='/images/placeholder.jpg';"
                        >
                    </td>
                    <td class="fw-bold">{{ $produk->namaProduk }}</td>
                    <td>{{ number_format($produk->harga, 0, ',', '.') }}</td>
                    <td class="text-center {{ $produk->stok < 10 ? 'text-danger fw-bold' : '' }}">
                        {{ $produk->stok }}
                    </td>
                    <td>{{ $produk->kategori ?? 'N/A' }}</td>
                    <td class="text-center">
                        {{-- Tombol Edit --}}
                        <a href="{{ url('/admin/produk/' . $produk->idProduk . '/edit') }}"
                           class="btn btn-sm btn-warning action-btn text-white me-1"
                           title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>

                        {{-- Tombol Hapus (Memicu Modal Hapus) --}}
                        <button class="btn btn-sm btn-danger action-btn"
                                title="Hapus"
                                data-bs-toggle="modal"
                                data-bs-target="#modalHapusProduk"
                                data-produk-id="{{ $produk->idProduk }}"
                                data-produk-name="{{ $produk->namaProduk }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">
                        Tidak ada data produk yang tersedia saat ini.
                    </td>
                </tr>
                @endif

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH PRODUK (SAMA SEPERTI SEBELUMNYA) -->
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

<!-- TAMBAHAN: MODAL HAPUS PRODUK -->
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
                <p class="text-muted mb-0">Tindakan ini tidak dapat dibatalkan. Data produk akan hilang secara
                    permanen.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                    Batal
                </button>
                <!-- Form Hapus (Contoh Action) -->
                <form action="{{ url('/admin/produk/delete') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<script>
    const sidebar = document.getElementById('sidebar');
    const navbar = document.getElementById('navbar');
    const content = document.getElementById('content');
    const toggleBtn = document.getElementById('toggle-btn');

    // Tambahkan pengecekan apakah toggleBtn ada sebelum menambahkan event listener
    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            if (sidebar) sidebar.classList.toggle('collapsed');
            if (navbar) navbar.classList.toggle('collapsed');
            if (content) content.classList.toggle('collapsed');
        });
    }
</script>

@endsection
