@extends('admin.layout')
@section('title', 'Edit Pengguna')

@section('admin-content')
<div class="max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.users.show', $user) }}" class="text-sm text-gray-500 hover:text-navy inline-flex items-center gap-1">← Kembali ke detail</a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full icon-bg-navy flex items-center justify-center font-bold text-navy text-sm">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="font-display font-bold text-navy">Edit: {{ $user->name }}</h2>
                    <p class="text-xs text-gray-400">{{ $user->email }}</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="p-6 space-y-5">
            @csrf
            @method('PATCH')

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 text-sm text-red-600 space-y-1">
                @foreach($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="input-admin {{ $errors->has('name') ? 'border-red-400' : '' }}">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="input-admin {{ $errors->has('email') ? 'border-red-400' : '' }}">
                @if($user->email_verified_at)
                    <p class="text-xs text-gray-400 mt-1">✓ Email terverifikasi · Jika email diubah, verifikasi akan direset.</p>
                @else
                    <p class="text-xs text-amber-500 mt-1">⚠ Email belum terverifikasi.</p>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Opsional"
                       class="input-admin">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat</label>
                <textarea name="address" rows="2" placeholder="Opsional"
                          class="input-admin resize-none">{{ old('address', $user->address) }}</textarea>
            </div>

            @if($user->id !== auth()->id())
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Role</label>
                <select name="role" class="select-admin">
                    <option value="customer" {{ old('role', $user->role) === 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            @endif

            <div class="pt-2 border-t border-gray-100">
                <p class="text-sm font-medium text-gray-700 mb-3">Reset Password <span class="text-xs font-normal text-gray-400">(kosongkan jika tidak ingin diubah)</span></p>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1.5">Password Baru</label>
                        <input type="password" name="password" autocomplete="new-password"
                               class="input-admin {{ $errors->has('password') ? 'border-red-400' : '' }}">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1.5">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" autocomplete="new-password"
                               class="input-admin">
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-6 py-2.5 bg-navy text-white text-sm font-semibold rounded-xl hover:bg-[#12301f] transition-colors">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.users.show', $user) }}"
                   class="px-6 py-2.5 bg-gray-100 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-200 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
