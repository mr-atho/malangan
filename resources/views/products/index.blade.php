@extends('layouts.app')

@section('title', $currentCategory ? $currentCategory->name : 'Semua Produk')

@section('content')

<x-breadcrumb :items="[
    ['label' => 'Beranda', 'url' => route('home')],
    ['label' => $currentCategory ? $currentCategory->name : 'Semua Produk'],
]" />

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ filterOpen: false }">

    {{-- Mobile filter toggle --}}
    <div class="lg:hidden mb-4">
        <button @click="filterOpen = !filterOpen"
                class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-medium text-navy flex items-center justify-between shadow-sm">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filter & Kategori
            </span>
            <svg :class="filterOpen ? 'rotate-180' : ''" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- Sidebar --}}
        <aside class="lg:w-60 flex-shrink-0 lg:!block" x-show="filterOpen" x-cloak>
            <x-card class="p-5 lg:sticky lg:top-24">
                <h3 class="font-semibold text-navy mb-4 font-display">Kategori</h3>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('products.index') }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition-colors {{ !request('category') ? 'bg-navy text-white font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span>Semua Produk</span>
                        </a>
                    </li>
                    @foreach($categories as $cat)
                    <li>
                        <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition-colors {{ request('category') === $cat->slug ? 'bg-navy text-white font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span class="flex items-center gap-2">{{ $cat->icon }} {{ $cat->name }}</span>
                            <span class="text-xs {{ request('category') === $cat->slug ? 'text-white/70' : 'text-gray-400' }}">{{ $cat->active_products_count }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>

                {{-- Price Filter --}}
                <div class="mt-6 pt-5 border-t border-gray-100">
                    <h3 class="font-semibold text-navy mb-3 font-display">Harga</h3>
                    <form method="GET" action="{{ route('products.index') }}" class="space-y-2">
                        @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                        @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                        @if(request('sort'))<input type="hidden" name="sort" value="{{ request('sort') }}">@endif
                        <input type="number" name="min_price" placeholder="Min (Rp)" value="{{ request('min_price') }}"
                               class="w-full border border-gray-200 bg-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-navy transition-colors">
                        <input type="number" name="max_price" placeholder="Max (Rp)" value="{{ request('max_price') }}"
                               class="w-full border border-gray-200 bg-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-navy transition-colors">
                        <button type="submit" class="w-full bg-navy text-white text-sm font-semibold py-2.5 rounded-lg hover:bg-[#12301f] transition-colors">Terapkan</button>
                    </form>
                </div>
            </x-card>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1">

            {{-- Search + Sort bar --}}
            <div class="mb-4">
                <x-search-bar action="{{ route('products.index') }}"
                              placeholder="Cari produk khas Malang..."
                              variant="frontend"
                              :reset-url="request('search') ? route('products.index', array_filter(['category' => request('category'), 'sort' => request('sort')])) : null">
                    @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                    @if(request('sort') && request('sort') !== 'latest')<input type="hidden" name="sort" value="{{ request('sort') }}">@endif
                </x-search-bar>
            </div>

            {{-- Active filters + sort row --}}
            <div class="flex flex-wrap items-center justify-between gap-2 mb-5">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-sm text-gray-500">{{ $products->total() }} produk</span>
                    @if(request('search'))
                        <span class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 bg-navy/10 text-navy rounded-full">
                            "{{ request('search') }}"
                            <a href="{{ route('products.index', array_filter(['category' => request('category'), 'sort' => request('sort')])) }}" class="hover:text-red-500 transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                            </a>
                        </span>
                    @endif
                    @if(request('min_price') || request('max_price'))
                        <span class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 bg-navy/10 text-navy rounded-full">
                            Rp {{ number_format(request('min_price') ?: 0, 0, ',', '.') }} – {{ request('max_price') ? 'Rp '.number_format(request('max_price'), 0, ',', '.') : '∞' }}
                            <a href="{{ route('products.index', array_filter(['category' => request('category'), 'search' => request('search'), 'sort' => request('sort')])) }}" class="hover:text-red-500 transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                            </a>
                        </span>
                    @endif
                    @if(request()->hasAny(['search', 'min_price', 'max_price']))
                        <a href="{{ route('products.index', array_filter(['category' => request('category'), 'sort' => request('sort')])) }}"
                           class="text-xs text-gray-400 hover:text-red-500 transition-colors">Hapus semua filter</a>
                    @endif
                </div>
                <form method="GET">
                    @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                    @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                    @if(request('min_price'))<input type="hidden" name="min_price" value="{{ request('min_price') }}">@endif
                    @if(request('max_price'))<input type="hidden" name="max_price" value="{{ request('max_price') }}">@endif
                    <select name="sort" onchange="this.form.submit()"
                            class="border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none bg-white text-gray-700 cursor-pointer hover:border-gray-300 transition-colors">
                        <option value="latest"     {{ request('sort','latest') === 'latest'     ? 'selected' : '' }}>Terbaru</option>
                        <option value="price_asc"  {{ request('sort') === 'price_asc'           ? 'selected' : '' }}>Harga: Terendah</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc'          ? 'selected' : '' }}>Harga: Tertinggi</option>
                        <option value="popular"    {{ request('sort') === 'popular'             ? 'selected' : '' }}>Terpopuler</option>
                    </select>
                </form>
            </div>

            {{-- Products Grid --}}
            @if($products->isEmpty())
                <x-empty-state emoji="🔍" title="Produk tidak ditemukan"
                    description="Coba gunakan kata kunci lain atau hapus filter yang diterapkan."
                    actionLabel="Lihat Semua Produk" actionHref="{{ route('products.index') }}" />
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach($products as $product)
                        @include('components.product-card', ['product' => $product])
                    @endforeach
                </div>
                <div class="mt-8">{{ $products->links() }}</div>
            @endif
        </main>
    </div>
</div>

@endsection
