@extends('admin.layout')
@section('title', 'Manajemen Produk')

@section('admin-content')
<div class="flex items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="font-display text-xl font-bold text-navy">Manajemen Produk</h2>
        <p class="text-sm text-gray-500 mt-0.5">{{ $products->total() }} produk</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="bg-navy text-white font-semibold px-5 py-2.5 rounded-xl text-sm hover:bg-[#12301f] transition-colors flex items-center gap-2 whitespace-nowrap shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Produk
    </a>
</div>

<div class="mb-6">
    <x-search-bar action="{{ route('admin.products.index') }}"
                  placeholder="Cari nama produk..."
                  :reset-url="request('search') ? route('admin.products.index') : null" />
</div>

@if(request('search'))
<div class="flex items-center gap-2 mb-4">
    <span class="text-sm text-gray-500">Hasil pencarian:</span>
    <span class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 bg-navy/10 text-navy rounded-full">
        "{{ request('search') }}"
        <a href="{{ route('admin.products.index') }}" class="hover:text-red-500 transition-colors">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
        </a>
    </span>
</div>
@endif

<x-card :flush="true">
    <div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk</th>
                <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Kategori</th>
                <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga</th>
                <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Stok</th>
                <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Status</th>
                <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($products as $product)
            <tr class="hover:bg-gray-50/50">
                <td class="px-5 py-3.5">
                    <div class="flex items-center gap-3">
                        <x-product-image class="w-10 h-10"
                            :thumbnail="$product->thumbnail"
                            :icon="$product->category->icon ?? '🛍️'" />
                        <div class="min-w-0">
                            <p class="font-medium text-gray-800">{{ $product->name }}</p>
                            @if($product->is_featured)<span class="text-xs text-amber-600 bg-amber-50 px-1.5 py-0.5 rounded">Unggulan</span>@endif
                            @if($product->is_bestseller)<span class="text-xs text-orange-600 bg-orange-50 px-1.5 py-0.5 rounded ml-1">Laris</span>@endif
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3.5 text-gray-600 hidden md:table-cell">{{ $product->category->name }}</td>
                <td class="px-4 py-3.5 font-semibold text-navy">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="px-4 py-3.5 text-center">
                    <span class="font-semibold {{ $product->stock === 0 ? 'text-red-500' : ($product->stock <= 5 ? 'text-amber-500' : 'text-emerald-600') }}">{{ $product->stock }}</span>
                </td>
                <td class="px-4 py-3.5 text-center hidden lg:table-cell">
                    <x-status-badge :status="$product->is_active ? 'active' : 'inactive'" />
                </td>
                <td class="px-5 py-3.5 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-navy hover:text-gold text-xs font-medium px-3 py-1.5 border border-gray-200 rounded-lg hover:border-gold transition-colors">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:text-red-600 text-xs font-medium px-3 py-1.5 border border-gray-200 rounded-lg hover:border-red-200 transition-colors">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-12 text-gray-400">Belum ada produk</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
    <div class="px-5 py-4 border-t border-gray-100">{{ $products->links() }}</div>
</x-card>
@endsection
