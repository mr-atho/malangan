@extends('layouts.app')

@section('title', $currentCategory ? $currentCategory->name : 'Semua Produk')

@section('content')

<x-breadcrumb :items="[
    ['label' => 'Beranda', 'url' => route('home')],
    ['label' => $currentCategory ? $currentCategory->name : 'Semua Produk'],
]" />

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6" x-data="{ filterOpen: false }">

    {{-- Collection Page Header & Toolbar --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between border-b border-zinc-100 pb-6 mb-8 gap-4">
        <div>
            <h1 class="font-display text-3xl font-bold tracking-tight text-zinc-900">
                {{ $currentCategory ? $currentCategory->name : 'Semua Produk' }}
            </h1>
            <p class="text-xs text-zinc-400 mt-1.5 font-medium tracking-wide">
                Menampilkan {{ $products->total() }} produk hasil karya pengrajin Malang Raya
            </p>
        </div>

        <div class="flex items-center gap-3 self-start md:self-auto">
            {{-- Filter button trigger --}}
            <button @click="filterOpen = true"
                    class="inline-flex items-center gap-2 border border-zinc-200 rounded-full px-5 py-2.5 text-xs font-semibold text-zinc-700 bg-white hover:border-gold hover:text-gold transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filter & Kategori
            </button>

            {{-- Sorting select form --}}
            <form method="GET" class="relative">
                @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                @if(request('min_price'))<input type="hidden" name="min_price" value="{{ request('min_price') }}">@endif
                @if(request('max_price'))<input type="hidden" name="max_price" value="{{ request('max_price') }}">@endif
                <select name="sort" onchange="this.form.submit()"
                        class="border border-zinc-200 rounded-full px-5 py-2.5 text-xs font-semibold focus:outline-none focus:border-gold focus:ring-1 focus:ring-gold bg-white text-zinc-700 cursor-pointer hover:border-zinc-300 transition-colors shadow-sm">
                    <option value="latest"     {{ request('sort','latest') === 'latest'     ? 'selected' : '' }}>Terbaru</option>
                    <option value="price_asc"  {{ request('sort') === 'price_asc'           ? 'selected' : '' }}>Harga: Terendah</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc'          ? 'selected' : '' }}>Harga: Tertinggi</option>
                    <option value="popular"    {{ request('sort') === 'popular'             ? 'selected' : '' }}>Terpopuler</option>
                </select>
            </form>
        </div>
    </div>

    {{-- Filter Drawer Panel (Left slideout) --}}
    <div x-show="filterOpen" class="fixed inset-0 z-[100] overflow-hidden" x-cloak style="display: none;">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-zinc-950/40 backdrop-blur-sm transition-opacity"
             x-show="filterOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="filterOpen = false"></div>

        <div class="fixed inset-y-0 left-0 max-w-full flex pr-10">
            <div class="w-screen max-w-sm"
                 x-show="filterOpen"
                 x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full">
                 
                <div class="h-full flex flex-col bg-white shadow-2xl border-r border-zinc-100 py-6 px-6 overflow-y-auto">
                    {{-- Drawer Title --}}
                    <div class="flex items-center justify-between border-b border-zinc-100 pb-5 mb-6">
                        <h2 class="font-display text-lg font-bold text-zinc-900 tracking-wide flex items-center gap-2">
                            <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                            Filter Katalog
                        </h2>
                        <button @click="filterOpen = false" class="text-zinc-400 hover:text-zinc-600 p-1.5 rounded-full hover:bg-zinc-50 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    
                    {{-- Categories --}}
                    <div class="mb-8">
                        <h3 class="font-semibold text-zinc-900 mb-3.5 font-display text-sm tracking-wide">Kategori</h3>
                        <ul class="space-y-1.5">
                            <li>
                                <a href="{{ route('products.index') }}" 
                                   class="flex items-center justify-between px-4 py-2.5 rounded-xl text-sm transition-all {{ !request('category') ? 'bg-navy text-white font-medium shadow-sm' : 'text-zinc-600 hover:text-navy hover:bg-zinc-50' }}">
                                    <span>Semua Produk</span>
                                </a>
                            </li>
                            @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('products.index', ['category' => $cat->slug]) }}" 
                                   class="flex items-center justify-between px-4 py-2.5 rounded-xl text-sm transition-all {{ request('category') === $cat->slug ? 'bg-navy text-white font-medium shadow-sm' : 'text-zinc-600 hover:text-navy hover:bg-zinc-50' }}">
                                    <span class="flex items-center gap-2">{{ $cat->icon }} {{ $cat->name }}</span>
                                    <span class="text-xs {{ request('category') === $cat->slug ? 'text-white/75' : 'text-zinc-400' }}">{{ $cat->active_products_count }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Price range --}}
                    <div class="border-t border-zinc-100 pt-6">
                        <h3 class="font-semibold text-zinc-900 mb-3.5 font-display text-sm tracking-wide">Harga</h3>
                        <form method="GET" action="{{ route('products.index') }}" class="space-y-3">
                            @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                            @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                            @if(request('sort'))<input type="hidden" name="sort" value="{{ request('sort') }}">@endif
                            
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold uppercase tracking-wider text-zinc-400">Harga Minimal</label>
                                <input type="number" name="min_price" placeholder="Rp 0" value="{{ request('min_price') }}"
                                       class="w-full border border-zinc-200 bg-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-colors">
                            </div>
                            <div class="space-y-2 mb-4">
                                <label class="text-[10px] font-bold uppercase tracking-wider text-zinc-400">Harga Maksimal</label>
                                <input type="number" name="max_price" placeholder="Rp 0" value="{{ request('max_price') }}"
                                       class="w-full border border-zinc-200 bg-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold focus:ring-1 focus:ring-gold transition-colors">
                            </div>
                            
                            <button type="submit" class="w-full bg-navy text-white text-xs font-semibold py-3.5 rounded-xl hover:bg-[#2d4a6b] transition-all shadow-sm uppercase tracking-widest">Terapkan Filter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Catalog area --}}
    <main class="w-full">
        
        {{-- Search bar container --}}
        <div class="mb-6">
            <x-search-bar action="{{ route('products.index') }}"
                          placeholder="Cari produk khas Malang..."
                          variant="frontend"
                          :reset-url="request('search') ? route('products.index', array_filter(['category' => request('category'), 'sort' => request('sort')])) : null">
                @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                @if(request('sort') && request('sort') !== 'latest')<input type="hidden" name="sort" value="{{ request('sort') }}">@endif
            </x-search-bar>
        </div>

        {{-- Active filters indicator --}}
        @if(request()->hasAny(['search', 'min_price', 'max_price']))
            <div class="flex flex-wrap items-center gap-2 mb-6">
                <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wider mr-1">Filter Aktif:</span>
                @if(request('search'))
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 bg-gold/10 text-gold-dk border border-gold/20 rounded-full">
                        Kata kunci: "{{ request('search') }}"
                        <a href="{{ route('products.index', array_filter(['category' => request('category'), 'sort' => request('sort')])) }}" class="hover:text-red-500 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        </a>
                    </span>
                @endif
                @if(request('min_price') || request('max_price'))
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 bg-gold/10 text-gold-dk border border-gold/20 rounded-full">
                        Harga: Rp {{ number_format(request('min_price') ?: 0, 0, ',', '.') }} – {{ request('max_price') ? 'Rp '.number_format(request('max_price'), 0, ',', '.') : '∞' }}
                        <a href="{{ route('products.index', array_filter(['category' => request('category'), 'search' => request('search'), 'sort' => request('sort')])) }}" class="hover:text-red-500 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        </a>
                    </span>
                @endif
                <a href="{{ route('products.index', array_filter(['category' => request('category'), 'sort' => request('sort')])) }}"
                   class="text-xs text-zinc-400 hover:text-red-500 transition-colors font-semibold ml-1">Hapus semua filter</a>
            </div>
        @endif

        {{-- Products Grid --}}
        @if($products->isEmpty())
            <x-empty-state emoji="🔍" title="Produk tidak ditemukan"
                description="Coba gunakan kata kunci lain atau bersihkan filter pencarian."
                actionLabel="Lihat Semua Produk" actionHref="{{ route('products.index') }}" />
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    @include('components.product-card', ['product' => $product])
                @endforeach
            </div>
            <div class="mt-12 flex justify-center border-t border-zinc-100 pt-8">{{ $products->links() }}</div>
        @endif
    </main>
</div>

@endsection
