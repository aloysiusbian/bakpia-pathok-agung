@extends('layouts.auth')
@section('title', 'Sign up')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-stretch">
  {{-- Kiri: Form --}}
  <div class="py-10 lg:py-16">
    {{-- Logo + Brand --}}
    <div class="mb-10 flex items-center gap-3">
      <img src="{{ asset('image/logo.png') }}" class="h-50 w-60 rounded" alt="Agung">
      <span class="text-3xl font-semibold"></span>
    </div>

    {{-- Ringkasan error --}}
    @if ($errors->any())
      <div class="mb-4 rounded-md border border-red-200 bg-red-50 p-3 text-sm text-red-700">
        <ul class="list-disc list-inside">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ url('/register') }}" method="POST" class="max-w-lg" novalidate>
      @csrf

      {{-- Name --}}
      <label for="name" class="block text-sm text-slate-600 mb-1">Name</label>
      <div class="flex items-center gap-3 bg-transparent rounded @error('name') ring-1 ring-red-500 @enderror">
        <span class="pl-1">
          {{-- user icon --}}
          <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 19.5a7.5 7.5 0 1115 0"/>
          </svg>
        </span>
        <input
          id="name" type="text" name="name" value="{{ old('name') }}"
          placeholder="Enter your full name"
          autocomplete="name"
          minlength="2" maxlength="255"
          class="w-full bg-transparent border-0 accent-line focus:outline-none py-2"
          required>
      </div>
      @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror

      {{-- Email --}}
      <label for="email" class="block text-sm text-slate-600 mt-6 mb-1">Email</label>
      <div class="flex items-center gap-3 @error('email') ring-1 ring-red-500 @enderror">
        <span class="pl-1">
          {{-- mail icon --}}
          <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M3 7l9 6 9-6" />
            <rect x="3" y="5" width="18" height="14" rx="2" ry="2"/>
          </svg>
        </span>
        <input
          id="email" type="email" name="email" value="{{ old('email') }}"
          placeholder="Enter your email address"
          autocomplete="email"
          maxlength="255"
          class="w-full bg-transparent border-0 accent-line focus:outline-none py-2"
          required>
      </div>
      @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
      

      {{-- Password --}}
      <label for="password" class="block text-sm text-slate-600 mt-6 mb-1">Password</label>
      <div class="flex items-center gap-3 @error('password') ring-1 ring-red-500 @enderror">
        <span class="pl-1">
          {{-- lock icon --}}
          <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M7 10V7a5 5 0 0110 0v3" />
            <rect x="5" y="10" width="14" height="10" rx="2" />
          </svg>
        </span>
        <input
          id="password" type="password" name="password"
          placeholder="Enter your Password"
          autocomplete="new-password"
          minlength="8"
          class="w-full bg-transparent border-0 accent-line focus:outline-none py-2"
          required>
      </div>
      @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror

      {{-- Confirm Password --}}
      <label for="password_confirmation" class="block text-sm text-slate-600 mt-6 mb-1">Confirm Password</label>
      <div class="flex items-center gap-3">
        <span class="pl-1">
          {{-- lock icon --}}
          <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M7 10V7a5 5 0 0110 0v3" />
            <rect x="5" y="10" width="14" height="10" rx="2" />
          </svg>
        </span>
        <input
          id="password_confirmation" type="password" name="password_confirmation"
          placeholder="Confirm your Password"
          autocomplete="new-password"
          minlength="8"
          class="w-full bg-transparent border-0 accent-line focus:outline-none py-2"
          required>
      </div>

      {{-- Submit --}}
      <button class="btn-gold text-white w-full md:w-3/2 mt-10 rounded-full py-3 text-lg shadow-lg">
        Register
      </button>
    </form>
  </div>

  {{-- Kanan: Gambar --}}
  <div class="hidden lg:block">
    <div class="rounded-2xl overflow-hidden border border-black/10 shadow-md h-full">
      <div class="relative h-full min-h-[560px]">
        <img src="{{ asset('images/image.png') }}" alt="Bakpia Agung" class="object-cover w-full h-full">
        <div class="absolute top-4 right-5 text-white/90 text-sm flex items-center gap-2">
          {{-- phone icon --}}
          <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="currentColor">
            <path d="M6.6 10.8a15.1 15.1 0 006.6 6.6l2.2-2.2a1 1 0 011.1-.2c1.2.5 2.5.8 3.9.8a1 1 0 011 1V20a1 1 0 01-1 1C12.4 21 3 11.6 3 1a1 1 0 011-1h3.2a1 1 0 011 1c0 1.4.3 2.7.8 3.9a1 1 0 01-.2 1.1L6.6 10.8z"/>
          </svg>
          +6282240401312
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
