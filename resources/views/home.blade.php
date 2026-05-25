@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

@php
$heroItems = $bestsellerProducts->take(6)->map(fn($p) => [
    'name'     => $p->name,
    'cat_name' => $p->category->name,
    'cat_icon' => $p->category->icon ?? '🛍️',
    'thumb'    => $p->thumbnail ? asset('storage/' . $p->thumbnail) : null,
    'url'      => route('products.show', $p->slug),
])->values()->toArray();
@endphp
<script>
window._heroItems = @json($heroItems);
function heroCarousel() {
    return {
        items: window._heroItems,
        cur: 0,
        timer: null,
        get item() { return this.items[this.cur]; },
        start() { this.timer = setInterval(() => this.next(), 4000); },
        stop()  { clearInterval(this.timer); },
        next()  { this.cur = (this.cur + 1) % this.items.length; },
        go(i)   { this.cur = i; }
    };
}
</script>

{{-- HERO --}}
<section class="min-h-[85vh] flex items-center bg-white relative overflow-hidden py-12 md:py-20">
    {{-- Decorative backgrounds --}}
    <div class="absolute top-0 right-0 w-full md:w-1/2 h-full bg-[#FAF9F6] opacity-80" style="border-bottom-left-radius: 80px"></div>
    <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-gold/5 blur-3xl"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full z-10">
        <div class="grid md:grid-cols-12 gap-12 lg:gap-16 items-center">
            <div class="md:col-span-7">
                <div class="inline-flex items-center gap-2 rounded-full bg-gold/10 px-4 py-1.5 mb-6 text-xs font-semibold uppercase tracking-wider text-gold">
                    <span class="w-1.5 h-1.5 rounded-full inline-block bg-gold animate-pulse"></span>
                    Warisan Produk Asli Malang Raya
                </div>
                <h1 class="font-display font-bold leading-[1.08] mb-6 text-zinc-900"
                    style="font-size: clamp(2.5rem, 5vw, 4.2rem)">
                    Keindahan<br>
                    <span class="italic font-normal text-gold display-serif">Malang</span><br>
                    di Tanganmu
                </h1>
                <p class="text-zinc-500 text-base md:text-lg leading-relaxed mb-8 max-w-lg">
                    Kurasi karya terbaik: dari souvenir bernilai seni tinggi, batik khas, kuliner lokal, hingga kerajinan tangan buatan pengrajin Malang Raya.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('products.index') }}" class="btn-primary shadow-sm hover:shadow-lg">Belanja Sekarang</a>
                    <a href="{{ route('products.index', ['category' => 'topeng-kesenian']) }}" class="btn-ghost">
                        Eksplorasi Budaya
                    </a>
                </div>
                <div class="grid grid-cols-3 gap-6 md:gap-10 mt-12 pt-8 border-t border-zinc-100 max-w-md">
                    <div>
                        <p class="text-2xl md:text-3xl font-bold font-display text-zinc-900">200+</p>
                        <p class="text-zinc-400 text-xs mt-1 uppercase tracking-wider font-semibold">Produk Pilihan</p>
                    </div>
                    <div>
                        <p class="text-2xl md:text-3xl font-bold font-display text-zinc-900">50+</p>
                        <p class="text-zinc-400 text-xs mt-1 uppercase tracking-wider font-semibold">Pengrajin Lokal</p>
                    </div>
                    <div>
                        <p class="text-2xl md:text-3xl font-bold font-display text-zinc-900">5K+</p>
                        <p class="text-zinc-400 text-xs mt-1 uppercase tracking-wider font-semibold">Pelanggan</p>
                    </div>
                </div>
            </div>
            
            {{-- Right showcase carousel --}}
            <div class="hidden md:col-span-5 md:flex justify-center items-center">
                @if(!empty($heroItems))
                <div class="relative w-full max-w-sm"
                     x-data="heroCarousel()"
                     x-init="start()"
                     @mouseenter="stop()" @mouseleave="start()">

                    {{-- Decorative gold frame --}}
                    <div class="absolute inset-0 border border-gold/30 rounded-3xl translate-x-3 translate-y-3 pointer-events-none"></div>

                    <a :href="item.url" class="block relative bg-white rounded-3xl shadow-lg overflow-hidden aspect-[4/5] flex flex-col justify-between p-8 border border-gray-100">
                        <div class="batik-bg absolute inset-0 opacity-[0.03]"></div>

                        {{-- Top: kategori + nomor --}}
                        <div class="relative z-10 flex justify-between items-center">
                            <span class="text-[10px] font-bold tracking-widest uppercase text-gold flex items-center gap-1">
                                <span x-text="item.cat_icon"></span>
                                <span x-text="item.cat_name" class="max-w-[120px] truncate"></span>
                            </span>
                            <span class="w-7 h-7 rounded-full bg-navy/5 border border-navy/10 flex items-center justify-center text-navy/40 text-[10px] font-bold"
                                  x-text="String(cur + 1).padStart(2, '0')"></span>
                        </div>

                        {{-- Tengah: gambar produk --}}
                        <div class="relative z-10 flex flex-col items-center py-4">
                            <div class="w-36 h-36 rounded-2xl overflow-hidden mb-5 bg-cream border border-gray-100 shadow-sm flex items-center justify-center">
                                <template x-if="item.thumb">
                                    <img :src="item.thumb" :alt="item.name"
                                         class="w-full h-full object-cover transition-opacity duration-500">
                                </template>
                                <template x-if="!item.thumb">
                                    <span class="text-6xl select-none" x-text="item.cat_icon"></span>
                                </template>
                            </div>
                            <h3 class="font-display text-lg text-navy font-bold text-center leading-snug line-clamp-2 px-2"
                                x-text="item.name"></h3>
                            <p class="text-[10px] text-gold mt-1.5 font-bold tracking-widest uppercase"
                               x-text="item.cat_name"></p>
                        </div>

                        {{-- Bawah: dots navigasi --}}
                        <div class="relative z-10">
                            <div class="flex justify-center gap-1.5 mb-4">
                                <template x-for="(p, i) in items" :key="i">
                                    <button @click.prevent="go(i); stop();"
                                            :class="cur === i ? 'bg-navy w-5' : 'bg-gray-200 w-1.5'"
                                            class="h-1.5 rounded-full transition-all duration-300"></button>
                                </template>
                            </div>
                            <div class="border-t border-gray-100 pt-3 flex justify-between items-center text-xs">
                                <span class="text-gray-400">Produk Terlaris</span>
                                <span class="text-gold font-semibold">100% Asli</span>
                            </div>
                        </div>
                    </a>

                    {{-- Badge kiri: nama produk aktif (dinamis) --}}
                    <div class="absolute top-[18%] -left-7 bg-white rounded-2xl px-4 py-3 shadow-md border border-gray-100 max-w-[148px]">
                        <p class="text-[9px] text-zinc-400 font-bold uppercase tracking-wider">Produk Terlaris</p>
                        <p class="text-xs font-bold text-navy mt-0.5 truncate" x-text="item.name"></p>
                    </div>

                    {{-- Badge kanan: statis --}}
                    <div class="absolute bottom-[18%] -right-7 bg-white rounded-2xl px-4 py-3 shadow-md border border-gray-100">
                        <p class="text-[9px] text-zinc-400 font-bold uppercase tracking-wider">Layanan Pengiriman</p>
                        <p class="text-xs font-bold text-navy mt-0.5">Seluruh Indonesia</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- BANNER CAROUSEL --}}
@if($banners->isNotEmpty())
<section x-data="{
             active: 0,
             total: {{ $banners->count() }},
             timer: null,
             start() { this.timer = setInterval(() => this.next(), 6000); },
             stop()  { clearInterval(this.timer); },
             next()  { this.active = (this.active + 1) % this.total; },
             prev()  { this.active = (this.active - 1 + this.total) % this.total; }
         }"
         x-init="start()"
         @mouseenter="stop()" @mouseleave="start()"
         class="relative w-full h-64 sm:h-80 md:h-[460px] overflow-hidden bg-zinc-950">

    @foreach($banners as $i => $banner)
    <div class="absolute inset-0 transition-all duration-1000 ease-in-out transform"
         x-show="active === {{ $i }}"
         x-transition:enter="opacity-0 scale-102"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-98">
        <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}"
             class="absolute inset-0 w-full h-full object-cover opacity-80">
        <div class="absolute inset-0 bg-gradient-to-r from-zinc-950/80 via-zinc-950/40 to-transparent"></div>
        <div class="absolute inset-0 flex items-center">
            <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-16 w-full">
                <h2 class="font-display text-2xl sm:text-4xl md:text-5xl font-bold text-white mb-3 tracking-wide leading-tight max-w-2xl">{{ $banner->title }}</h2>
                @if($banner->subtitle)
                    <p class="text-zinc-300 text-sm sm:text-base md:text-lg mb-8 max-w-lg leading-relaxed">{{ $banner->subtitle }}</p>
                @endif
                @if($banner->link && $banner->button_text)
                    <a href="{{ $banner->link }}" class="btn-gold shadow-md">{{ $banner->button_text }}</a>
                @endif
            </div>
        </div>
    </div>
    @endforeach

    @if($banners->count() > 1)
    <button @click="prev()" class="absolute left-6 top-1/2 -translate-y-1/2 w-11 h-11 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white rounded-full flex items-center justify-center transition-colors z-20 border border-white/10">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
    </button>
    <button @click="next()" class="absolute right-6 top-1/2 -translate-y-1/2 w-11 h-11 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white rounded-full flex items-center justify-center transition-colors z-20 border border-white/10">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
    </button>
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-20">
        @foreach($banners as $i => $banner)
        <button @click="active = {{ $i }}"
                :class="active === {{ $i }} ? 'bg-gold w-6' : 'bg-white/30 w-2'"
                class="h-2 rounded-full transition-all duration-300"></button>
        @endforeach
    </div>
    @endif
</section>
@endif

{{-- KATEGORI --}}
<section class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-10 text-center md:text-left">
        <p class="text-[10px] font-bold tracking-widest uppercase text-gold mb-2">Jelajahi Warisan</p>
        <h2 class="font-display text-3xl font-bold text-zinc-900">Kategori Pilihan</h2>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-5">
        @foreach($categories as $category)
        <a href="{{ route('products.index', ['category' => $category->slug]) }}"
           class="group bg-white rounded-2xl p-6 text-center border border-zinc-100 hover:border-gold/40 hover:shadow-[0_12px_25px_rgba(0,0,0,0.03)] transition-all duration-300 flex flex-col items-center justify-between">
            <div class="text-4xl mb-4 group-hover:scale-110 transition-transform duration-300 ease-out inline-block bg-zinc-50 rounded-full p-4 group-hover:bg-gold/5 w-16 h-16 flex items-center justify-center">{{ $category->icon }}</div>
            <div>
                <h3 class="text-sm font-semibold text-zinc-800 group-hover:text-gold leading-tight transition-colors">{{ $category->name }}</h3>
                <p class="text-[11px] text-zinc-400 mt-1.5">{{ $category->active_products_count }} produk</p>
            </div>
        </a>
        @endforeach
    </div>
</section>

{{-- PRODUK UNGGULAN --}}
@if($featuredProducts->isNotEmpty())
<section class="py-20 bg-[#FAF9F6]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="text-[10px] font-bold tracking-widest uppercase text-gold mb-2">Kurasi Terbaik</p>
                <h2 class="font-display text-3xl font-bold text-zinc-900">Produk Unggulan</h2>
            </div>
            <a href="{{ route('products.index', ['featured' => 1]) }}"
               class="text-sm font-bold text-navy hover:text-gold transition-colors hidden sm:flex items-center gap-1.5 group">
                Lihat Semua 
                <svg class="w-4 h-4 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- BANNER BUDAYA MALANG --}}
<section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6">
        <a href="{{ route('products.index', ['category' => 'buah-produk-alam']) }}"
           class="group relative rounded-3xl overflow-hidden p-8 text-white hover:shadow-xl transition-all duration-500 hover:-translate-y-1 border border-white/10"
           style="background-color: #1e3252;">
            <div class="batik-bg absolute inset-0 opacity-[0.08] group-hover:opacity-[0.14] transition-opacity"></div>
            <div class="relative z-10 flex flex-col justify-between h-full min-h-[220px]">
                <div>
                    <span class="text-4xl p-3 bg-white/5 border border-white/10 rounded-2xl inline-block mb-6">🏔️</span>
                    <h3 class="font-display text-xl font-bold mb-2">Dari Kaki Gunung Arjuno</h3>
                    <p class="text-xs text-white/55 leading-relaxed mb-6">Produk kopi premium dan hasil bumi asli dari lereng gunung subur di Malang Raya.</p>
                </div>
                <span class="text-[10px] font-bold tracking-widest uppercase text-gold flex items-center gap-1.5 group-hover:gap-2.5 transition-all">
                    Jelajahi <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </span>
            </div>
        </a>
        <a href="{{ route('products.index', ['category' => 'topeng-kesenian']) }}"
           class="group relative rounded-3xl overflow-hidden p-8 text-white hover:shadow-xl transition-all duration-500 hover:-translate-y-1 border border-white/10"
           style="background-color: #2d4a6b;">
            <div class="batik-bg absolute inset-0 opacity-[0.08] group-hover:opacity-[0.14] transition-opacity"></div>
            <div class="relative z-10 flex flex-col justify-between h-full min-h-[220px]">
                <div>
                    <span class="text-4xl p-3 bg-white/5 border border-white/10 rounded-2xl inline-block mb-6">🎭</span>
                    <h3 class="font-display text-xl font-bold mb-2">Warisan Topeng Malangan</h3>
                    <p class="text-xs text-white/55 leading-relaxed mb-6">Topeng kayu pahatan seniman lokal, menjaga tradisi leluhur Malang tetap hidup.</p>
                </div>
                <span class="text-[10px] font-bold tracking-widest uppercase text-gold flex items-center gap-1.5 group-hover:gap-2.5 transition-all">
                    Jelajahi <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </span>
            </div>
        </a>
        <a href="{{ route('products.index', ['category' => 'buah-produk-alam']) }}"
           class="group relative rounded-3xl overflow-hidden p-8 text-white hover:shadow-xl transition-all duration-500 hover:-translate-y-1 border border-white/10"
           style="background-color: #243d5c;">
            <div class="batik-bg absolute inset-0 opacity-[0.08] group-hover:opacity-[0.14] transition-opacity"></div>
            <div class="relative z-10 flex flex-col justify-between h-full min-h-[220px]">
                <div>
                    <span class="text-4xl p-3 bg-white/5 border border-white/10 rounded-2xl inline-block mb-6">🍎</span>
                    <h3 class="font-display text-xl font-bold mb-2">Apel Segar Kota Batu</h3>
                    <p class="text-xs text-white/55 leading-relaxed mb-6">Apel segar dan berbagai olahan buah olahan premium langsung dari perkebunan Batu.</p>
                </div>
                <span class="text-[10px] font-bold tracking-widest uppercase text-gold flex items-center gap-1.5 group-hover:gap-2.5 transition-all">
                    Jelajahi <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </span>
            </div>
        </a>
    </div>
</section>

{{-- PRODUK TERLARIS --}}
@if($bestsellerProducts->isNotEmpty())
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="text-[10px] font-bold tracking-widest uppercase text-gold mb-2">Favorit Konsumen</p>
                <h2 class="font-display text-3xl font-bold text-zinc-900">Produk Terlaris</h2>
            </div>
            <a href="{{ route('products.index') }}"
               class="text-sm font-bold text-navy hover:text-gold transition-colors hidden sm:flex items-center gap-1.5 group">
                Lihat Semua
                <svg class="w-4 h-4 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($bestsellerProducts as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- PRODUK TERBARU --}}
@if($newProducts->isNotEmpty())
<section class="py-20 bg-[#FAF9F6]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="text-[10px] font-bold tracking-widest uppercase text-gold mb-2">Koleksi Baru</p>
                <h2 class="font-display text-3xl font-bold text-zinc-900">Produk Terbaru</h2>
            </div>
            <a href="{{ route('products.index') }}"
               class="text-sm font-bold text-navy hover:text-gold transition-colors hidden sm:flex items-center gap-1.5 group">
                Lihat Semua
                <svg class="w-4 h-4 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($newProducts as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
<section class="py-24 px-4 sm:px-6 lg:px-8 bg-white">
    <div class="max-w-4xl mx-auto text-center">
        <div class="rounded-[32px] px-8 md:px-16 py-16 relative overflow-hidden border border-white/10 shadow-xl" style="background-color: #1e3252;">
            <div class="batik-bg absolute inset-0 opacity-[0.07]"></div>
            <div class="relative z-10">
                <p class="text-[10px] font-bold tracking-widest uppercase text-gold mb-4">Gabung Kemitraan Pengrajin</p>
                <h2 class="font-display text-3xl md:text-4xl font-bold text-white mb-5 leading-tight">Daftarkan Produk Unggulan Anda</h2>
                <p class="text-white/55 text-sm max-w-md mx-auto mb-10 leading-relaxed">
                    Apakah Anda produsen atau pengrajin lokal Malang Raya? Pasarkan produk autentik Anda ke seluruh pelosok Indonesia bersama kami.
                </p>
                <a href="{{ route('register') }}" class="btn-gold px-8 py-3.5 shadow-md hover:shadow-lg">Daftar Pengrajin Sekarang</a>
            </div>
        </div>
    </div>
</section>

@endsection
