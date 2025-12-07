@extends('templates.sidebar')

@section('title', 'Profil')

@section('content')

<div class="content" id="content">
    <div class="card p-4">
        <div class="d-flex align-items-center">
            {{-- Foto Profil (Static dulu karena belum ada fitur upload foto) --}}
            <img src="{{ asset('images/bian.png') }}" alt="Foto Profil" class="rounded-circle me-4" width="100" height="100">
            
            <div class="profile-info">
                {{-- 1. TAMPILKAN NAMA --}}
                {{-- Logika: Ambil nama penerima dari alamat. Jika kosong, pakai Email --}}
                <h5>{{ $address->nama_penerima ?? $user->email }}</h5>

                {{-- 2. TAMPILKAN EMAIL DARI USER AUTH --}}
                <p class="text-muted mb-1">{{ $user->email }}</p>

                {{-- 3. TAMPILKAN NO TELP DARI USER AUTH --}}
                <p class="mb-1">{{ $user->noTelp }}</p>

                {{-- 4. TAMPILKAN ALAMAT LENGKAP DARI DB --}}
                <p class="fw-bold mt-2">
                    @if($address)
                        {{ $address->alamat_lengkap }}<br>
                        Kec. {{ $address->kecamatan }}, {{ $address->kota_nama }}<br>
                        {{ $address->provinsi_nama }} - {{ $address->kode_pos }}
                    @else
                        <span class="text-danger fst-italic">Belum ada alamat utama yang diatur.</span>
                    @endif
                </p>
            </div>
        </div>
        
        <div class="mt-4">
            {{-- Gunakan route name agar lebih aman --}}
            <a href="{{ route('profile.edit') }}" class="btn btn-warning">
                <i class="bi bi-pencil-square"></i> Edit Profil
            </a>
        </div>
    </div>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const navbar = document.getElementById('navbar');
    const content = document.getElementById('content');
    const toggleBtn = document.getElementById('toggle-btn');

    if(toggleBtn){
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            navbar.classList.toggle('collapsed');
            content.classList.toggle('collapsed');
        });
    }
</script>

@endsection