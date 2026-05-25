@extends('layouts.auth')
@section('title', 'Lupa Password')

@section('content')
<div class="p-8">
    <div class="text-center mb-7">
        <div class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3 icon-bg-navy">
            <svg class="w-6 h-6 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
        </div>
        <h1 class="font-display text-2xl font-bold text-navy">Lupa Password?</h1>
        <p class="text-sm mt-2 max-w-xs mx-auto" style="color:#6b7280;">Masukkan email Anda dan kami akan mengirimkan tautan untuk reset password.</p>
    </div>

    <x-auth-messages />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1.5" style="color:#374151;">Alamat Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="input-auth {{ $errors->has('email') ? 'is-error' : '' }}">
            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <button type="submit" class="btn-auth !mt-6">Kirim Tautan Reset Password</button>
    </form>

    <p class="text-center text-sm mt-6" style="color:#6b7280;">
        Ingat password Anda?
        <a href="{{ route('login') }}" class="text-navy font-semibold hover:text-gold transition-colors">Kembali masuk</a>
    </p>
</div>
@endsection
