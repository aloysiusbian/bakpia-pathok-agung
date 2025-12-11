@extends('templates.sidebar-admin')

@section('title', 'Ganti Password Admin')

@section('content')

<div class="content" id="content">
    <div class="container">
        <div class="card p-4">

            <h4 class="fw-bold mb-4" style="color:#3a2d1a;">
                <i class="bi bi-person-lines-fill me-2"></i>Ganti Password Admin
            </h4>

            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @error('current_password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            {{-- FORM START: enctype wajib ada untuk upload file --}}
            <form action="{{ route('admin.password-admin.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <hr class="my-4">

                <div class="mb-3">
                    <label class="form-label">Password Terbaru</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                @error('password')
                <div class="error-message">{{ $message }}</div>
                @enderror

                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" name="password_confirmation" required>
                </div>

                {{-- Validasi --}}
                <div class="mb-3">
                    <label class="form-label">Password Lama</label>
                    <input type="password" class="form-control" name="current_password" required>
                </div>

                @error('current_password')
                <div class="error-message">{{ $message }}</div>
                @enderror

                <hr class="my-4">

                <div class="text-end">
                    <button type="submit" class="btn btn-warning px-4 text-white">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
