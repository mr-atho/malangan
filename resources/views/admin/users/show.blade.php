@extends('admin.layout')
@section('title', 'Detail Pengguna')

@section('admin-content')
<div class="max-w-3xl">
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:text-navy inline-flex items-center gap-1">← Kembali ke pengguna</a>
        <a href="{{ route('admin.users.edit', $user) }}" class="text-sm px-4 py-2 bg-navy text-white rounded-xl font-medium hover:bg-[#12301f] transition-colors">Edit Pengguna</a>
    </div>

    <div class="space-y-5 mt-4">

        {{-- Profile Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-start justify-between gap-4 flex-wrap">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full icon-bg-navy flex items-center justify-center font-bold text-navy text-xl flex-shrink-0">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="font-display text-xl font-bold text-navy">{{ $user->name }}</h2>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        <div class="flex items-center gap-2 mt-1.5">
                            @if($user->role === 'admin')
                                <span class="text-xs px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 font-semibold">Admin</span>
                            @else
                                <span class="text-xs px-2.5 py-1 rounded-full bg-gray-100 text-gray-600 font-medium">Customer</span>
                            @endif
                            @if($user->email_verified_at)
                                <span class="text-xs px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 font-medium">✓ Terverifikasi</span>
                            @else
                                <span class="text-xs px-2.5 py-1 rounded-full bg-red-100 text-red-600 font-medium">Belum verifikasi</span>
                            @endif
                        </div>
                    </div>
                </div>
                @if($user->id !== auth()->id())
                <form method="POST" action="{{ route('admin.users.toggle-role', $user) }}">
                    @csrf @method('PATCH')
                    <button type="submit"
                            class="text-sm px-4 py-2 rounded-xl font-medium transition-colors {{ $user->role === 'admin' ? 'bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200' : 'bg-navy/10 text-navy hover:bg-navy/20 border border-navy/20' }}"
                            onclick="return confirm('Ubah role {{ $user->name }}?')">
                        {{ $user->role === 'admin' ? '↓ Jadikan Customer' : '↑ Jadikan Admin' }}
                    </button>
                </form>
                @endif
            </div>

            <div class="grid sm:grid-cols-3 gap-4 mt-6 pt-5 border-t border-gray-100">
                <div>
                    <p class="text-xs text-gray-400 mb-1">Telepon</p>
                    <p class="text-sm font-medium text-gray-700">{{ $user->phone ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">Bergabung</p>
                    <p class="text-sm font-medium text-gray-700">{{ $user->created_at->format('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">Alamat</p>
                    <p class="text-sm font-medium text-gray-700">{{ $user->address ?? '—' }}</p>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center">
                <p class="text-3xl font-bold text-navy font-display">{{ $user->orders_count }}</p>
                <p class="text-sm text-gray-500 mt-1">Total Pesanan</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center">
                <p class="text-2xl font-bold text-navy font-display">Rp {{ number_format($user->orders_sum_total ?? 0, 0, ',', '.') }}</p>
                <p class="text-sm text-gray-500 mt-1">Total Belanja</p>
            </div>
        </div>

        {{-- Recent Orders --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-display font-bold text-navy">Riwayat Pesanan</h3>
            </div>
            @forelse($orders as $order)
            <div class="px-6 py-3.5 border-b border-gray-50 flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-800">{{ $order->order_number }}</p>
                    <p class="text-xs text-gray-400">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm font-bold text-navy">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    <span class="text-xs px-2 py-0.5 rounded-full bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-700 font-medium">{{ $order->status_label }}</span>
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-xs text-navy hover:underline">Lihat →</a>
                </div>
            </div>
            @empty
            <p class="text-center py-10 text-sm text-gray-400">Belum ada pesanan</p>
            @endforelse
        </div>

        {{-- Danger Zone --}}
        @if($user->id !== auth()->id() && !$user->orders()->exists())
        <div class="bg-white rounded-2xl shadow-sm border border-red-100 p-5">
            <h3 class="font-semibold text-red-600 mb-1 text-sm">Hapus Pengguna</h3>
            <p class="text-xs text-gray-500 mb-4">Pengguna ini belum memiliki pesanan dan bisa dihapus. Tindakan ini tidak bisa dibatalkan.</p>
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                  onsubmit="return confirm('Hapus pengguna {{ $user->name }}? Tindakan ini permanen.')">
                @csrf @method('DELETE')
                <button type="submit" class="text-sm px-4 py-2 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 font-medium border border-red-200 transition-colors">
                    Hapus Pengguna
                </button>
            </form>
        </div>
        @endif

    </div>
</div>
@endsection
