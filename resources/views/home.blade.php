@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

{{-- HERO SECTION --}}
<section class="relative overflow-hidden bg-navy min-h-[520px] flex items-center">
    <div class="batik-bg absolute inset-0 opacity-60"></div>
    <div class="absolute inset-0 hero-gradient"></div>
    {{-- Decorative circles --}}
    <div class="absolute top-0 right-0 w-96 h-96 rounded-full opacity-10" style="background: radial-gradient(circle, #D4C5A9, transparent); transform: translate(30%, -30%);"></div>
    <div class="absolute bottom-0 left-0 w-72 h-72 rounded-full opacity-10" style="background: radial-gradient(circle, #D4C5A9, transparent); transform: translate(-30%, 30%);"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 w-full">
        <div class="grid md:grid-cols-2 gap-10 items-center">
            <div>
                <div class="inline-flex items-center gap-2 bg-white/10 rounded-full px-4 py-1.5 mb-5 text-gold text-sm font-medium">
                    <span>🦅</span> Produk Asli Malang Raya
                </div>
                <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-4">
                    Keindahan<br><span class="text-gold">Malang</span><br>di Tanganmu
                </h1>
                <p class="text-white/70 text-base md:text-lg leading-relaxed mb-8 max-w-md">
                    Temukan ribuan produk souvenir, kuliner, kerajinan, dan oleh-oleh asli dari pengrajin lokal Kota & Kabupaten Malang.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('products.index') }}" class="btn-primary text-base px-8 py-3">Belanja Sekarang</a>
                    <a href="{{ route('products.index', ['category' => 'topeng-kesenian']) }}" class="border border-gold text-gold hover:bg-gold hover:text-navy font-semibold px-8 py-3 rounded-full transition-colors text-base">Lihat Topeng Malang</a>
                </div>
                <div class="flex gap-8 mt-10">
                    <div>
                        <p class="text-2xl font-bold text-gold font-display">200+</p>
                        <p class="text-white/60 text-xs mt-0.5">Produk Unggulan</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gold font-display">50+</p>
                        <p class="text-white/60 text-xs mt-0.5">Pengrajin Lokal</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gold font-display">5000+</p>
                        <p class="text-white/60 text-xs mt-0.5">Pelanggan Puas</p>
                    </div>
                </div>
            </div>
            <div class="hidden md:flex justify-center">
                <div class="relative w-80 h-80">
                    <div class="absolute inset-0 bg-gold/20 rounded-full animate-pulse"></div>
                    <div class="absolute inset-4 bg-gold/10 rounded-full flex items-center justify-center">
                        <span class="text-9xl">🎭</span>
                    </div>
                    {{-- Floating badges --}}
                    <div class="absolute -top-2 -right-4 bg-white rounded-xl px-3 py-2 shadow-lg text-xs font-semibold text-navy">
                        🍜 Kuliner Khas
                    </div>
                    <div class="absolute -bottom-2 -left-4 bg-white rounded-xl px-3 py-2 shadow-lg text-xs font-semibold text-navy">
                        🏺 Kerajinan Asli
                    </div>
                </div>
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
             start() { this.timer = setInterval(() => this.next(), 5000); },
             stop()  { clearInterval(this.timer); },
             next()  { this.active = (this.active + 1) % this.total; },
             prev()  { this.active = (this.active - 1 + this.total) % this.total; }
         }"
         x-init="start()"
         @mouseenter="stop()" @mouseleave="start()"
         class="relative w-full h-56 sm:h-72 md:h-96 overflow-hidden bg-navy">

    {{-- Slides — semua absolute agar tidak menyebabkan reflow --}}
    @foreach($banners as $i => $banner)
    <div class="absolute inset-0 transition-opacity duration-700"
         :class="active === {{ $i }} ? 'opacity-100 z-10' : 'opacity-0 z-0'">
        <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}"
             class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-black/10"></div>
        <div class="absolute inset-0 flex items-center">
            <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-16 w-full">
                <h2 class="font-display text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-2" style="text-shadow:0 2px 16px rgba(0,0,0,0.8)">{{ $banner->title }}</h2>
                @if($banner->subtitle)
                    <p class="text-white text-sm sm:text-base mb-5 max-w-md" style="text-shadow:0 1px 8px rgba(0,0,0,0.8)">{{ $banner->subtitle }}</p>
                @endif
                @if($banner->link && $banner->button_text)
                    <a href="{{ $banner->link }}" class="inline-block bg-white text-navy text-sm font-bold px-6 py-2.5 rounded-full hover:bg-gold transition-colors shadow-md">
                        {{ $banner->button_text }}
                    </a>
                @endif
            </div>
        </div>
    </div>
    @endforeach

    {{-- Prev / Next --}}
    @if($banners->count() > 1)
    <button @click="prev()" class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 bg-black/30 hover:bg-black/50 text-white rounded-full flex items-center justify-center transition-colors z-20">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
    </button>
    <button @click="next()" class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 bg-black/30 hover:bg-black/50 text-white rounded-full flex items-center justify-center transition-colors z-20">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
    </button>

    {{-- Dots --}}
    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-1.5 z-20">
        @foreach($banners as $i => $banner)
        <button @click="active = {{ $i }}"
                :class="active === {{ $i }} ? 'bg-white w-5' : 'bg-white/50 w-2'"
                class="h-2 rounded-full transition-all duration-300"></button>
        @endforeach
    </div>
    @endif
</section>
@endif

{{-- KATEGORI --}}
<section class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <x-section-header title="Kategori Produk" subtitle="Jelajahi" />
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($categories as $category)
        <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="group bg-white rounded-2xl p-4 text-center shadow-sm hover:shadow-md border border-gray-100 hover:border-gold transition-all duration-200 card-product">
            <div class="text-4xl mb-3 group-hover:scale-110 transition-transform duration-200">{{ $category->icon }}</div>
            <h3 class="text-sm font-semibold text-gray-800 group-hover:text-navy leading-tight">{{ $category->name }}</h3>
            <p class="text-xs text-gray-400 mt-1">{{ $category->active_products_count }} produk</p>
        </a>
        @endforeach
    </div>
</section>

{{-- PRODUK UNGGULAN --}}
@if($featuredProducts->isNotEmpty())
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-section-header title="Produk Unggulan" subtitle="Pilihan Terbaik" align="left"
            linkHref="{{ route('products.index', ['featured' => 1]) }}" />
        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            @foreach($featuredProducts as $product)
            @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- BANNER BUDAYA MALANG --}}
<section class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-5">
        <div class="banner-primary rounded-2xl p-7 text-white">
            <span class="text-4xl mb-3 block">🏔️</span>
            <h3 class="font-display text-xl font-bold mb-2">Dari Kaki Gunung Arjuno</h3>
            <p class="text-sm leading-relaxed text-white/[0.78]">Produk kopi dan hasil bumi dari lereng gunung yang subur di sekitar Malang.</p>
            <a href="{{ route('products.index', ['category' => 'buah-produk-alam']) }}" class="inline-block mt-4 text-sm font-medium hover:underline text-gold">Jelajahi →</a>
        </div>
        <div class="banner-dark rounded-2xl p-7 text-white">
            <span class="text-4xl mb-3 block">🎭</span>
            <h3 class="font-display text-xl font-bold mb-2">Warisan Topeng Malangan</h3>
            <p class="text-sm leading-relaxed text-white/[0.78]">Topeng Malangan, warisan budaya leluhur Kota Malang yang penuh nilai seni tinggi.</p>
            <a href="{{ route('products.index', ['category' => 'topeng-kesenian']) }}" class="inline-block mt-4 text-sm font-medium hover:underline text-gold">Jelajahi →</a>
        </div>
        <div class="banner-accent rounded-2xl p-7 text-white">
            <span class="text-4xl mb-3 block">🍎</span>
            <h3 class="font-display text-xl font-bold mb-2">Apel Segar dari Batu</h3>
            <p class="text-sm leading-relaxed text-white/[0.78]">Apel Manalagi dan berbagai olahan apel langsung dari kebun di Kota Batu, Malang.</p>
            <a href="{{ route('products.index', ['category' => 'buah-produk-alam']) }}" class="inline-block mt-4 text-sm font-medium hover:underline text-gold">Jelajahi →</a>
        </div>
    </div>
</section>

{{-- PRODUK TERLARIS --}}
@if($bestsellerProducts->isNotEmpty())
<section class="py-14 bg-amber-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-section-header title="🔥 Produk Terlaris" subtitle="Paling Diminati" align="left"
            linkHref="{{ route('products.index') }}" />
        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            @foreach($bestsellerProducts as $product)
            @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- PRODUK TERBARU --}}
@if($newProducts->isNotEmpty())
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-section-header title="Produk Terbaru" subtitle="Baru Hadir" align="left"
            linkHref="{{ route('products.index') }}" />
        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            @foreach($newProducts as $product)
            @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA SECTION --}}
<section class="py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-navy rounded-3xl overflow-hidden batik-bg">
            <div class="px-8 md:px-14 py-12 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h2 class="font-display text-3xl md:text-4xl font-bold text-white mb-2">Daftarkan Produk Anda</h2>
                    <p class="text-white/65 max-w-md">Apakah Anda pengrajin lokal Malang? Bergabung dan jangkau pelanggan di seluruh Indonesia.</p>
                </div>
                <div class="flex gap-3 flex-shrink-0">
                    <a href="{{ route('register') }}" class="btn-primary text-sm px-8 py-3 whitespace-nowrap">Daftar Sekarang</a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
