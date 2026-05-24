@extends('layouts.auth')
@section('title', 'Reset Password')

@section('content')
<div class="p-8">
    <div class="text-center mb-7">
        <div class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3" class="icon-bg-navy">
            <svg class="w-6 h-6 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        </div>
        <h1 class="font-display text-2xl font-bold text-navy">Buat Password Baru</h1>
        <p class="text-sm mt-1" style="color:#6b7280;">Masukkan password baru yang kuat untuk akun Anda</p>
    </div>

    <x-auth-messages />

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label class="block text-sm font-medium mb-1.5" style="color:#374151;">Email</label>
            <input type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                   class="input-auth {{ $errors->has('email') ? 'is-error' : '' }}">
            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1.5" style="color:#374151;">Password Baru</label>
            <input type="password" name="password" required autocomplete="new-password"
                   class="input-auth {{ $errors->has('password') ? 'is-error' : '' }}">
            @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1.5" style="color:#374151;">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" required autocomplete="new-password"
                   class="input-auth">
        </div>

        <button type="submit" class="btn-auth !mt-6">Simpan Password Baru</button>
    </form>
</div>
@endsection
