@extends('layouts.app')
@section('title', 'Profil Saya')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-8">
        <div class="w-16 h-16 bg-navy rounded-full flex items-center justify-center text-gold font-display font-bold text-2xl flex-shrink-0">
            {{ substr($user->name, 0, 1) }}
        </div>
        <div>
            <h1 class="font-display text-2xl font-bold text-navy">{{ $user->name }}</h1>
            <p class="text-sm text-gray-500">{{ $user->email }}</p>
        </div>
    </div>

    <div class="space-y-6">

        {{-- Informasi Profil --}}
        <x-card>
            <h2 class="font-display text-lg font-bold text-navy mb-1">Informasi Profil</h2>
            <p class="text-sm text-gray-500 mb-6">Perbarui nama, email, dan nomor HP akun Anda.</p>

            <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
                @csrf
                @method('patch')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 @error('name') border-red-300 @enderror">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 @error('email') border-red-300 @enderror">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-2 p-3 bg-amber-50 rounded-lg border border-amber-200">
                            <p class="text-sm text-amber-700">
                                Email belum diverifikasi.
                                <form method="post" action="{{ route('verification.otp.resend') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="underline font-medium hover:text-amber-900">Kirim ulang OTP.</button>
                                </form>
                            </p>
                        </div>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor HP <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20"
                           placeholder="08xx-xxxx-xxxx">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <textarea name="address" rows="3" placeholder="Alamat lengkap..."
                              class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 resize-none">{{ old('address', $user->address) }}</textarea>
                </div>

                <div class="flex items-center gap-4 pt-2">
                    <button type="submit" class="btn-primary text-sm px-6 py-2.5">Simpan Perubahan</button>
                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2500)"
                           class="text-sm text-emerald-600 font-medium">Profil berhasil disimpan.</p>
                    @endif
                </div>
            </form>
        </x-card>

        {{-- Ganti Password --}}
        <x-card>
            <h2 class="font-display text-lg font-bold text-navy mb-1">Ganti Password</h2>
            <p class="text-sm text-gray-500 mb-6">Gunakan password yang kuat dan unik untuk keamanan akun.</p>

            <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                @csrf
                @method('put')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password Saat Ini</label>
                    <input type="password" name="current_password" autocomplete="current-password"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 @error('current_password', 'updatePassword') border-red-300 @enderror">
                    @error('current_password', 'updatePassword')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password Baru</label>
                    <input type="password" name="password" autocomplete="new-password"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 @error('password', 'updatePassword') border-red-300 @enderror">
                    @error('password', 'updatePassword')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" autocomplete="new-password"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20">
                </div>

                <div class="flex items-center gap-4 pt-2">
                    <button type="submit" class="btn-primary text-sm px-6 py-2.5">Ganti Password</button>
                    @if (session('status') === 'password-updated')
                        <p x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2500)"
                           class="text-sm text-emerald-600 font-medium">Password berhasil diganti.</p>
                    @endif
                </div>
            </form>
        </x-card>

        {{-- Hapus Akun --}}
        <div class="bg-white rounded-2xl shadow-sm border border-red-100 p-6" x-data="{ confirmDelete: {{ $errors->userDeletion->isNotEmpty() ? 'true' : 'false' }} }">
            <h2 class="font-display text-lg font-bold text-red-600 mb-1">Hapus Akun</h2>
            <p class="text-sm text-gray-500 mb-5">Setelah akun dihapus, semua data Anda akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.</p>

            <button @click="confirmDelete = true" type="button"
                    class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">
                Hapus Akun Saya
            </button>

            {{-- Confirmation Modal --}}
            <div x-show="confirmDelete" x-cloak
                 class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4"
                 x-transition:enter="transition-opacity duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6" @click.stop>
                    <h3 class="font-display text-lg font-bold text-gray-900 mb-2">Hapus akun ini?</h3>
                    <p class="text-sm text-gray-600 mb-5">Masukkan password Anda untuk mengkonfirmasi penghapusan akun secara permanen. Semua pesanan dan data Anda akan hilang.</p>

                    <form method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                            <input type="password" name="password" placeholder="Masukkan password..."
                                   class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-200 @error('password', 'userDeletion') border-red-300 @enderror">
                            @error('password', 'userDeletion')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="flex gap-3 justify-end">
                            <button type="button" @click="confirmDelete = false"
                                    class="px-5 py-2 text-sm font-medium text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                    class="px-5 py-2 text-sm font-semibold text-white bg-red-500 hover:bg-red-600 rounded-xl transition-colors">
                                Ya, Hapus Akun
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
