@extends('layouts.auth')
@section('title', 'Verifikasi Email')

@section('content')
<div class="p-8">
    <div class="text-center mb-6">
        <div class="w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4 icon-bg-navy">
            <svg class="w-7 h-7 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <h1 class="font-display text-2xl font-bold text-navy">Verifikasi Email</h1>
        <p class="text-sm mt-2" style="color:#6b7280;">Kami mengirimkan kode 6 digit ke</p>
        <p class="font-semibold text-sm mt-0.5" style="color:#111827;">{{ auth()->user()->email }}</p>
    </div>

    <x-auth-messages />

    <form method="POST" action="{{ route('verification.otp.verify') }}">
        @csrf
        <div class="mb-5">
            <label class="block text-sm font-medium text-center mb-3" style="color:#374151;">Masukkan Kode OTP</label>
            <input type="text" name="otp" maxlength="6" inputmode="numeric" pattern="[0-9]{6}"
                   placeholder="000000" autofocus autocomplete="one-time-code"
                   value="{{ old('otp') }}"
                   class="input-otp">
            <p class="text-xs text-center mt-2" style="color:#9ca3af;">Kode berlaku selama 10 menit</p>
        </div>

        <button type="submit" class="btn-auth">Verifikasi Email</button>
    </form>

    <div class="mt-6 pt-5 border-t border-gray-100 text-center space-y-3">
        <p class="text-sm" style="color:#6b7280;">Tidak menerima kode?</p>
        <form method="POST" action="{{ route('verification.otp.resend') }}">
            @csrf
            <button type="submit" class="text-sm font-semibold text-navy hover:text-gold transition-colors underline underline-offset-2">
                Kirim Ulang Kode OTP
            </button>
        </form>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-xs" style="color:#9ca3af;">Keluar dari akun ini</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelector('[name="otp"]').addEventListener('input', function() {
    this.value = this.value.replace(/\D/g, '').slice(0, 6);
    if (this.value.length === 6) this.closest('form').submit();
});
</script>
@endpush
