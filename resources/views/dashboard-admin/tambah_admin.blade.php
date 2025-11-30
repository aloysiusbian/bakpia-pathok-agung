@extends('templates.sidebar-admin')

@section('title', 'Tambah Admin')

@section('content')
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
                        <input type="text" class="form-control" id="nama_lengkap" name="name" required placeholder="Contoh: Reza Kakap">
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control" id="email" name="email" required placeholder="Contoh: reza.k@bakpia.com">
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label">Kata Sandi (Password)</label>
                        <input type="password" class="form-control" id="password" name="password" required minlength="8" placeholder="Minimal 8 karakter">
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required minlength="8" placeholder="Ulangi kata sandi">
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

@endsection
