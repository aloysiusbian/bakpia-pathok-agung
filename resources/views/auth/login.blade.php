@extends('layouts.auth')
@section('title', 'Login')

@section('content')
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-stretch">
    {{-- Kiri: Form Login --}}
    <div class="py-10 lg:py-16">

      {{-- Logo --}}
      <div class="mb-10 flex items-center gap-3">
        <img src="{{ asset('images/Logo.png') }}" height="20" alt="Agung">
      </div>

      {{-- Judul dan link register --}}
      <h1 class="text-4xl font-extrabold mb-2">Login</h1>
      <p class="text-slate-600 mb-6">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-blue-600 underline font-semibold">
          BUAT DI SINI
        </a>
      </p>

      {{-- Form Login --}}
      <form action="{{ url('/login') }}" method="POST">
        @csrf

        {{-- Email --}}
        <label class="block text-sm text-slate-600 mb-1">Email</label>
        <div class="flex items-center gap-3">
          <span class="pl-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-700" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5">
              <path d="M3 7l9 6 9-6" />
              <rect x="3" y="5" width="18" height="14" rx="2" ry="2" />
            </svg>
          </span>
          <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email address"
            class="w-full bg-transparent border-0 accent-line focus:outline-none py-2" required>
        </div>
        @error('email')
          <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror

        {{-- Password --}}
        <label class="block text-sm text-slate-600 mt-6 mb-1">Password</label>
        <div class="flex items-center gap-3">
          <span class="pl-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-700" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5">
              <path d="M7 10V7a5 5 0 0110 0v3" />
              <rect x="5" y="10" width="14" height="10" rx="2" />
            </svg>
          </span>
          <input type="password" name="password" placeholder="Enter your Password"
            class="w-full bg-transparent border-0 accent-line focus:outline-none py-2" required>
        </div>
        @error('password')
          <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror

        {{-- Remember --}}
        <label class="flex items-center gap-2 mt-6">
          <input type="checkbox" name="remember" class="size-4">
          <span class="text-sm">Remember me</span>
        </label>

        {{-- Error umum --}}
        @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
          <p class="text-red-600 text-sm mt-3">{{ $errors->first() }}</p>
        @endif

        {{-- Tombol Login --}}
        <button type="submit" class="btn-gold text-white w-full md:w-3/3 mt-10 rounded-full py-3 text-lg shadow-lg">
          Login
        </button>
      </form>
    </div>

    {{-- Kanan: Gambar --}}
    <div class="hidden lg:block">
      <div class="rounded-2xl overflow-hidden border border-black/10 shadow-md h-full">
        <div class="relative h-full min-h-[560px]">
          <img src="{{ asset('images/image.png') }}" alt="Bakpia Agung" class="object-cover w-full h-full">
          <div class="absolute top-4 right-5 text-white/90 text-sm flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="currentColor">
              <path
                d="M6.6 10.8a15.1 15.1 0 006.6 6.6l2.2-2.2a1 1 0 011.1-.2c1.2.5 2.5.8 3.9.8a1 1 0 011 1V20a1 1 0 01-1 1C12.4 21 3 11.6 3 1a1 1 0 011-1h3.2a1 1 0 011 1c0 1.4.3 2.7.8 3.9a1 1 0 01-.2 1.1L6.6 10.8z" />
            </svg>
            +6282240401312
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection