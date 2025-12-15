@extends('templates.sidebar-admin')

@section('title', 'Tambah Admin')

@section('content')
    <div class="content" id="content">
        <h2 class="mb-4 text-dark">Registrasi Akun Admin Baru</h2>

        {{-- Menampilkan pesan Flash (Success/Error dari Controller) --}}
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
            <div class="mb-4">
                {{-- Menggunakan route name jika sudah didefinisikan --}}
                <a href="{{ url('/admin/kelola-admin') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i>
                    Kembali ke Kelola Akun</a>
            </div>

            {{-- Form untuk registrasi akun baru --}}
            <form action="{{ url('/admin/kelola-admin') }}" method="POST">
                {{-- Wajib di Laravel untuk semua form POST, PUT, PATCH, DELETE --}}
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        {{-- Tambahkan @error untuk menampilkan error validasi dan old() untuk menjaga input --}}
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="nama_lengkap"
                            name="name" required placeholder="Contoh: John Doe" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" required placeholder="Contoh: johndoe@sukabakpia.com" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label">Kata Sandi (Password)</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password" required minlength="8" placeholder="Minimal 8 karakter">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                            required minlength="8" placeholder="Ulangi kata sandi">
                        {{-- Laravel menggunakan field 'password' untuk menampilkan error 'confirmed' --}}
                        @if ($errors->has('password') && !$errors->has('password_confirmation'))
                            {{-- Kosongkan saja karena error sudah ditangani di atas --}}
                        @endif
                    </div>

                    <div class="col-12 mt-4 text-end">
                        <button type="reset" class="btn btn-outline-secondary me-2">Reset Formulir</button>
                        {{-- Tombol submit akan mengirimkan form --}}
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="bi bi-person-check-fill"></i> Daftarkan Admin
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <script>
        // JavaScript untuk Toggle Sidebar (tidak diubah)
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