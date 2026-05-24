@extends('layouts.auth')
@section('title', 'Verifikasi Email')

@section('content')
<div class="p-8">
    <div class="text-center mb-6">
        <div class="w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4" class="icon-bg-navy">
            <svg class="w-7 h-7 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <h1 class="font-display text-2xl font-bold text-navy">Cek Email Anda</h1>
        <p class="text-sm mt-2 max-w-xs mx-auto" style="color:#6b7280;">Kami telah mengirimkan kode OTP ke email Anda. Masukkan kode tersebut untuk memverifikasi akun.</p>
    </div>

    @if(session('status') === 'otp-sent')
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-4 py-3 text-sm mb-5">
            Kode OTP baru telah dikirim ke email Anda.
        </div>
    @endif

    <div class="space-y-3">
        <a href="{{ route('verification.notice') }}" class="btn-auth block text-center">Masukkan Kode OTP</a>

        <form method="POST" action="{{ route('verification.otp.resend') }}">
            @csrf
            <button type="submit" class="w-full text-sm font-medium text-navy hover:text-gold transition-colors py-2 border border-gray-200 rounded-xl hover:border-gold/50">
                Kirim Ulang Kode OTP
            </button>
        </form>
    </div>

    <div class="mt-6 pt-5 border-t border-gray-100 text-center">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-xs" style="color:#9ca3af;">Keluar dari akun ini</button>
        </form>
    </div>
</div>
@endsection
