@extends('layouts.auth')
@section('title', 'Konfirmasi Password')

@section('content')
<div class="p-8">
    <div class="text-center mb-7">
        <div class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3" class="icon-bg-navy">
            <svg class="w-6 h-6 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        </div>
        <h1 class="font-display text-2xl font-bold text-navy">Konfirmasi Password</h1>
        <p class="text-sm mt-2 max-w-xs mx-auto" style="color:#6b7280;">Ini adalah area aman. Mohon konfirmasi password Anda sebelum melanjutkan.</p>
    </div>

    <x-auth-messages />

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1.5" style="color:#374151;">Password</label>
            <input type="password" name="password" required autofocus autocomplete="current-password"
                   class="input-auth {{ $errors->has('password') ? 'is-error' : '' }}">
            @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <button type="submit" class="btn-auth !mt-6">Konfirmasi</button>
    </form>
</div>
@endsection
