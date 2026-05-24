@extends('layouts.auth')
@section('title', 'Masuk')

@section('content')
<div class="p-8">
    <div class="text-center mb-7">
        <div class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3 icon-bg-navy">
            <svg class="w-6 h-6 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <h1 class="font-display text-2xl font-bold text-navy">Selamat Datang</h1>
        <p class="text-sm mt-1" style="color:#6b7280;">Masuk ke akun malangan.com Anda</p>
    </div>

    <x-auth-messages />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1.5" style="color:#374151;">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="input-auth {{ $errors->has('email') ? 'is-error' : '' }}">
        </div>

        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label class="text-sm font-medium" style="color:#374151;">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-navy hover:text-gold transition-colors">Lupa password?</a>
                @endif
            </div>
            <input type="password" name="password" required autocomplete="current-password"
                   class="input-auth {{ $errors->has('password') ? 'is-error' : '' }}">
        </div>

        <div class="flex items-center gap-2">
            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded">
            <label for="remember_me" class="text-sm" style="color:#4b5563;">Ingat saya</label>
        </div>

        <button type="submit" class="btn-auth !mt-6">Masuk</button>
    </form>

    <p class="text-center text-sm mt-6" style="color:#6b7280;">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-navy font-semibold hover:text-gold transition-colors">Daftar sekarang</a>
    </p>
</div>
@endsection
