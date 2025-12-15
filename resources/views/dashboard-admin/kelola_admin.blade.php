@extends('templates.sidebar-admin')

@section('title', 'Kelola Admin')

@section('content')

    <div class="content" id="content">
        <h2 class="mb-4 text-dark">Kelola Akun Administrator</h2>

        {{-- Logika untuk menampilkan pesan SUKSES atau GAGAL (Flash Messages) --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {!! session('success') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {!! session('error') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Daftar Pengguna Admin</h5>
                {{-- Mengubah URL statis ke Route Naming: admin.accounts.create --}}
                <a href="/admin/tambah-admin" class="btn btn-primary-custom">
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

                        {{-- Loop data admin dari database --}}
                        @forelse ($admins as $admin)
                            <tr>
                                <td>{{ $loop->iteration + ($admins->currentPage() - 1) * $admins->perPage() }}</td>
                                {{-- Asumsi kolom nama di model Admin adalah 'username' atau 'name' --}}
                                <td>{{ $admin->username ?? $admin->name }}</td>
                                <td>{{ $admin->email }}</td>

                                {{-- Peran: Asumsi kolom 'role' ada di tabel Admin, jika tidak, Anda harus menyesuaikannya. --}}
                                <td>{{ $admin->role ?? 'Administrator' }}</td>

                                {{-- Status: Asumsi ada kolom boolean 'is_active' --}}
                                <td>
                                    @if ($admin->is_active ?? true)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Nonaktif</span>
                                    @endif
                                </td>

                                <td>
                                    {{-- Tombol Edit: Memicu Modal Edit --}}
                                    <button type="button" class="btn btn-sm btn-warning action-btn" data-bs-toggle="modal"
                                        data-bs-target="#editAdminModal" data-id="{{ $admin->id }}"
                                        data-name="{{ $admin->username ?? $admin->name }}" data-email="{{ $admin->email }}"
                                        data-role="{{ $admin->role ?? 'Administrator' }}"
                                        data-is-active="{{ $admin->is_active ?? 1 }}" {{-- Asumsi default aktif --}}
                                        title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    {{-- Tombol Hapus: Memicu Modal Hapus --}}
                                    <button type="button" class="btn btn-sm btn-danger action-btn" data-bs-toggle="modal"
                                        data-bs-target="#deleteAdminModal" data-id="{{ $admin->id }}"
                                        data-name="{{ $admin->username ?? $admin->name }}" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data administrator.</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            {{-- Menampilkan Link Pagination --}}
            <div class="mt-3">
                {{ $admins->links() }}
            </div>
        </div>
    </div>

    {{-- Modal untuk Edit Akun Admin --}}
    <div class="modal fade" id="editAdminModal" tabindex="-1" aria-labelledby="editAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAdminModalLabel">Edit Akun Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- Form akan diisi aksi dinamis oleh JavaScript --}}
                <form id="editAdminForm" method="PUT">
                    @csrf
                    <div class="modal-body">
                        {{-- Input ID admin, disembunyikan --}}
                        <input type="hidden" id="admin_id_edit" name="admin_id">

                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>

                        {{-- Contoh field password baru (opsional) --}}
                        <div class="mb-3">
                            <label for="edit_password" class="form-label">Password Baru (Kosongkan jika tidak
                                diubah)</label>
                            <input type="password" class="form-control" id="edit_password" name="password" minlength="8">
                        </div>

                        <div class="mb-3">
                            <label for="edit_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="edit_password_confirmation"
                                name="password_confirmation" minlength="8">
                        </div>

                        {{-- Contoh field Peran (jika Anda mengelola peran) --}}
                        <div class="mb-3">
                            <label for="edit_role" class="form-label">Peran</label>
                            <select class="form-select" id="edit_role" name="role">
                                <option value="Administrator">Administrator</option>
                                <option value="Editor">Editor</option>
                                {{-- Tambahkan opsi peran lain sesuai kebutuhan --}}
                            </select>
                        </div>

                        {{-- Contoh field Status --}}
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="edit_is_active"
                                name="is_active" value="1">
                            <label class="form-check-label" for="edit_is_active">Aktifkan Akun</label>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary-custom">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal untuk Konfirmasi Hapus Akun Admin --}}
    <div class="modal fade" id="deleteAdminModal" tabindex="-1" aria-labelledby="deleteAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAdminModalLabel">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteAdminForm" method="DELETE">
                    @csrf
                    <div class="modal-body">
                        <p>Anda yakin ingin menghapus akun admin bernama **<span id="admin_name_delete"
                                class="fw-bold"></span>**?</p>
                        <div class="alert alert-danger" role="alert">
                            Tindakan ini tidak dapat dibatalkan.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Hapus Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // JavaScript untuk Toggle Sidebar (dibiarkan seperti semula)
        const sidebar = document.getElementById('sidebar');
        const navbar = document.getElementById('navbar');
        const content = document.getElementById('content');
        const toggleBtn = document.getElementById('toggle-btn');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            navbar.classList.toggle('collapsed');
            content.classList.toggle('collapsed');
        });

        // --- LOGIKA MODAL EDIT DAN HAPUS ---
        document.addEventListener('DOMContentLoaded', function () {
            const editModal = document.getElementById('editAdminModal');
            const deleteModal = document.getElementById('deleteAdminModal');

            // --- Modal Edit ---
            if (editModal) {
                editModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget; // Tombol yang memicu modal

                    // Ambil data dari atribut data-*
                    const adminId = button.getAttribute('data-id');
                    const adminName = button.getAttribute('data-name');
                    const adminEmail = button.getAttribute('data-email');
                    const adminRole = button.getAttribute('data-role');
                    const adminIsActive = button.getAttribute('data-is-active');

                    // Dapatkan form dan elemen input
                    const form = document.getElementById('editAdminForm');
                    const inputName = document.getElementById('edit_name');
                    const inputEmail = document.getElementById('edit_email');
                    const inputRole = document.getElementById('edit_role');
                    const inputIsActive = document.getElementById('edit_is_active');

                    // Isi input form dengan data yang diambil
                    inputName.value = adminName;
                    inputEmail.value = adminEmail;
                    inputRole.value = adminRole;
                    inputIsActive.checked = (adminIsActive === '1' || adminIsActive === 'true'); // Atur checkbox

                    // Atur action form ke route update
                    // Asumsi nama route Anda adalah 'admin.accounts.update'
                    form.action = '/admin/kelola-admin/' + adminId;

                    // Kosongkan password field setiap kali modal dibuka
                    document.getElementById('edit_password').value = '';
                    document.getElementById('edit_password_confirmation').value = '';
                });
            }

            // --- Modal Hapus ---
            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget; // Tombol yang memicu modal

                    // Ambil data dari atribut data-*
                    const adminId = button.getAttribute('data-id');
                    const adminName = button.getAttribute('data-name');

                    // Dapatkan form dan elemen teks
                    const form = document.getElementById('deleteAdminForm');
                    const nameSpan = document.getElementById('admin_name_delete');

                    // Isi nama admin pada teks konfirmasi
                    nameSpan.textContent = adminName;

                    // Atur action form ke route destroy
                    // Asumsi nama route Anda adalah 'admin.accounts.destroy'
                    form.action = '/admin/kelola-admin/' + adminId;
                });
            }
        });
    </script>

@endsection