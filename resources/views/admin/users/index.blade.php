@extends('admin.layout')
@section('title', 'Manajemen Pengguna')

@section('admin-content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="font-display text-xl font-bold text-navy">Pengguna Terdaftar</h2>
        <p class="text-sm text-gray-500 mt-0.5">Total {{ $users->total() }} pengguna</p>
    </div>
</div>

{{-- Filter --}}
<div class="mb-6">
    <x-search-bar action="{{ route('admin.users.index') }}"
                  placeholder="Cari nama atau email..."
                  :reset-url="request()->hasAny(['search','role']) ? route('admin.users.index') : null">
        <x-slot:append>
            <select name="role" class="select-admin w-44">
                <option value="">Semua Role</option>
                <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </x-slot:append>
    </x-search-bar>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="text-left px-6 py-3.5 font-semibold text-gray-600">Pengguna</th>
                <th class="text-left px-4 py-3.5 font-semibold text-gray-600 hidden sm:table-cell">Telepon</th>
                <th class="text-center px-4 py-3.5 font-semibold text-gray-600">Role</th>
                <th class="text-center px-4 py-3.5 font-semibold text-gray-600 hidden md:table-cell">Pesanan</th>
                <th class="text-right px-4 py-3.5 font-semibold text-gray-600 hidden lg:table-cell">Total Belanja</th>
                <th class="text-left px-4 py-3.5 font-semibold text-gray-600 hidden lg:table-cell">Bergabung</th>
                <th class="px-4 py-3.5"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($users as $user)
            <tr class="hover:bg-gray-50/60 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full icon-bg-navy flex items-center justify-center font-bold text-navy text-sm flex-shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-semibold text-gray-800 truncate">{{ $user->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ $user->email }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-4 text-gray-500 hidden sm:table-cell">{{ $user->phone ?? '—' }}</td>
                <td class="px-4 py-4 text-center">
                    @if($user->role === 'admin')
                        <span class="inline-block text-xs px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 font-semibold">Admin</span>
                    @else
                        <span class="inline-block text-xs px-2.5 py-1 rounded-full bg-gray-100 text-gray-600 font-medium">Customer</span>
                    @endif
                </td>
                <td class="px-4 py-4 text-center font-semibold text-gray-700 hidden md:table-cell">{{ $user->orders_count }}</td>
                <td class="px-4 py-4 text-right text-gray-700 hidden lg:table-cell">
                    Rp {{ number_format($user->orders_sum_total ?? 0, 0, ',', '.') }}
                </td>
                <td class="px-4 py-4 text-gray-400 text-xs hidden lg:table-cell">{{ $user->created_at->format('d M Y') }}</td>
                <td class="px-4 py-4">
                    <div class="flex items-center gap-2 justify-end">
                        <a href="{{ route('admin.users.show', $user) }}"
                           class="text-xs px-3 py-1.5 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 font-medium transition-colors">
                            Detail
                        </a>
                        <a href="{{ route('admin.users.edit', $user) }}"
                           class="text-xs px-3 py-1.5 rounded-lg bg-navy/10 text-navy hover:bg-navy/20 font-medium transition-colors">
                            Edit
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-12 text-gray-400">
                    <p class="text-2xl mb-2">👤</p>
                    <p>Tidak ada pengguna ditemukan</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $users->links() }}
    </div>
    @endif
</div>

@endsection
