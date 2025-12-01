@extends('templates.sidebar')

@section('title', 'Profil')

@section('content')
@php
// Simulasi data dari "database"
$customer = [
'nama' => 'Alberto Sahara',
'email' => 'alberto@example.com',
'telepon' => '0812-3456-7890',
'alamat' => 'Jl. Malioboro No. 12, Yogyakarta',
'gambar' => asset('images/bian.png')
];
@endphp

<!-- CONTENT -->
<div class="content" id="content">
    <div class="card p-4">
        <div class="d-flex align-items-center">
            <img src="{{ $customer['gambar'] }}" alt="Foto Profil" class="rounded-circle me-4" width="100" height="100">
            <div class="profile-info">
                <h5>{{ $customer['nama'] }}</h5>
                <p>{{ $customer['email'] }}</p>
                <p>{{ $customer['telepon'] }}</p>
                <p>{{ $customer['alamat'] }}</p>
            </div>
        </div>
        <div class="mt-4">
            <a href="/edit-profil" class="btn btn-warning"><i class="bi bi-pencil-square"></i> Edit Profil</a>
        </div>
    </div>
</div>

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
