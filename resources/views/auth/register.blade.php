@extends('layouts.auth')
@section('title', 'Daftar Akun')

@section('content')
<div class="p-8">
    <div class="text-center mb-7">
        <div class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3 icon-bg-navy">
            <svg class="w-6 h-6 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
        </div>
        <h1 class="font-display text-2xl font-bold text-navy">Buat Akun</h1>
        <p class="text-sm mt-1" style="color:#6b7280;">Bergabung dan mulai belanja produk khas Malang</p>
    </div>

    <x-auth-messages />

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1.5" style="color:#374151;">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="input-auth {{ $errors->has('name') ? 'is-error' : '' }}">
            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1.5" style="color:#374151;">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   class="input-auth {{ $errors->has('email') ? 'is-error' : '' }}">
            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1.5" style="color:#374151;">Password</label>
            <input type="password" name="password" required autocomplete="new-password"
                   class="input-auth {{ $errors->has('password') ? 'is-error' : '' }}">
            @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1.5" style="color:#374151;">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required autocomplete="new-password"
                   class="input-auth {{ $errors->has('password_confirmation') ? 'is-error' : '' }}">
        </div>

        <button type="submit" class="btn-auth !mt-6">Daftar Sekarang</button>
    </form>

    <p class="text-center text-sm mt-6" style="color:#6b7280;">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-navy font-semibold hover:text-gold transition-colors">Masuk di sini</a>
    </p>
</div>
@endsection
