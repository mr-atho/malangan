@extends('admin.layout')
@section('title', 'Manajemen Stok')

@section('admin-content')

{{-- Summary cards --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    <a href="{{ route('admin.stock.index', ['filter' => 'empty'] + request()->except('filter', 'page')) }}"
       class="rounded-2xl p-4 border-2 transition-all {{ $filter === 'empty' ? 'bg-red-50 border-red-300' : 'bg-white border-gray-100 hover:border-red-200' }}">
        <p class="text-2xl font-bold {{ $filter === 'empty' ? 'text-red-600' : 'text-red-500' }}">{{ $summary['empty'] }}</p>
        <p class="text-sm font-medium text-gray-600 mt-0.5">Stok Habis</p>
    </a>
    <a href="{{ route('admin.stock.index', ['filter' => 'low'] + request()->except('filter', 'page')) }}"
       class="rounded-2xl p-4 border-2 transition-all {{ $filter === 'low' ? 'bg-amber-50 border-amber-300' : 'bg-white border-gray-100 hover:border-amber-200' }}">
        <p class="text-2xl font-bold {{ $filter === 'low' ? 'text-amber-600' : 'text-amber-500' }}">{{ $summary['low'] }}</p>
        <p class="text-sm font-medium text-gray-600 mt-0.5">Stok Menipis (&le;5)</p>
    </a>
    <a href="{{ route('admin.stock.index', ['filter' => 'safe'] + request()->except('filter', 'page')) }}"
       class="rounded-2xl p-4 border-2 transition-all {{ $filter === 'safe' ? 'bg-emerald-50 border-emerald-300' : 'bg-white border-gray-100 hover:border-emerald-200' }}">
        <p class="text-2xl font-bold {{ $filter === 'safe' ? 'text-emerald-600' : 'text-emerald-500' }}">{{ $summary['safe'] }}</p>
        <p class="text-sm font-medium text-gray-600 mt-0.5">Stok Aman (&gt;5)</p>
    </a>
</div>

{{-- Search --}}
<div class="mb-6">
    <x-search-bar action="{{ route('admin.stock.index') }}"
                  placeholder="Cari nama produk..."
                  :reset-url="request()->hasAny(['search','filter']) ? route('admin.stock.index') : null">
        @if(request('filter'))
            <input type="hidden" name="filter" value="{{ request('filter') }}">
        @endif
    </x-search-bar>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="text-left px-5 py-3.5 font-semibold text-gray-600">Produk</th>
                <th class="text-left px-4 py-3.5 font-semibold text-gray-600 hidden md:table-cell">Kategori</th>
                <th class="text-center px-4 py-3.5 font-semibold text-gray-600 w-36">Stok Saat Ini</th>
                <th class="text-left px-4 py-3.5 font-semibold text-gray-600 w-64">Update Stok</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($products as $product)
            <tr class="hover:bg-gray-50/50 transition-colors" x-data="{ stock: {{ $product->stock }} }">
                <td class="px-5 py-3.5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-gray-100 flex items-center justify-center text-lg flex-shrink-0 overflow-hidden">
                            @if($product->thumbnail)
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" class="w-full h-full object-cover">
                            @else
                                {{ $product->category->icon ?? '🛍️' }}
                            @endif
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">{{ $product->name }}</p>
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-xs text-gray-400 hover:text-navy transition-colors">Edit produk →</a>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3.5 text-gray-500 text-xs hidden md:table-cell">{{ $product->category->name }}</td>
                <td class="px-4 py-3.5 text-center">
                    @if($product->stock === 0)
                        <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-1 rounded-full bg-red-100 text-red-600">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block"></span> Habis
                        </span>
                    @elseif($product->stock <= 5)
                        <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-1 rounded-full bg-amber-100 text-amber-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 inline-block"></span> {{ $product->stock }} unit
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span> {{ $product->stock }} unit
                        </span>
                    @endif
                </td>
                <td class="px-4 py-3.5">
                    <form action="{{ route('admin.stock.update', $product) }}" method="POST" class="flex items-center gap-2">
                        @csrf @method('PATCH')
                        <div class="flex items-center border-2 border-gray-200 rounded-xl overflow-hidden bg-white focus-within:border-navy transition-colors">
                            <button type="button" onclick="let i=this.nextElementSibling; i.value=Math.max(0,+i.value-1)"
                                    class="px-3 py-2.5 text-gray-400 hover:bg-gray-100 hover:text-navy transition-colors font-bold text-lg leading-none select-none">−</button>
                            <input type="number" name="stock" value="{{ $product->stock }}" min="0"
                                   class="w-20 text-center text-sm font-bold text-gray-800 border-x-2 border-gray-200 py-2.5 outline-none bg-white"
                                   style="appearance:textfield;-moz-appearance:textfield;">
                            <button type="button" onclick="let i=this.previousElementSibling; i.value=+i.value+1"
                                    class="px-3 py-2.5 text-gray-400 hover:bg-gray-100 hover:text-navy transition-colors font-bold text-lg leading-none select-none">+</button>
                        </div>
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-navy text-white text-xs font-semibold rounded-xl hover:bg-[#12301f] transition-colors shadow-sm whitespace-nowrap">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            Simpan
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-12 text-gray-400">
                    <p class="text-2xl mb-2">📦</p>
                    <p>Tidak ada produk ditemukan</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($products->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">
        {{ $products->links() }}
    </div>
    @endif
</div>

@endsection
