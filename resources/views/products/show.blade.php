@extends('layouts.app')

@section('title', $product->name)
@section('description', $product->short_description ?? substr(strip_tags($product->description), 0, 160))

@section('content')

<x-breadcrumb :items="[
    ['label' => 'Beranda', 'url' => route('home')],
    ['label' => $product->category->name, 'url' => route('products.index', ['category' => $product->category->slug])],
    ['label' => $product->name],
]" />

@php
    $allImages = collect();
    if ($product->thumbnail) {
        $allImages->push(asset('storage/' . $product->thumbnail));
    }
    foreach ($product->images as $img) {
        $url = asset('storage/' . $img->image);
        if (!$allImages->contains($url)) $allImages->push($url);
    }
    $allImages = $allImages->values()->toArray();
@endphp

<script>
window._productImgs = @json($allImages);
function productGallery() {
    return {
        imgs: window._productImgs,
        cur: 0,
        modal: false,
        tx: 0,
        get multi() { return this.imgs.length > 1; },
        prev()  { this.cur = (this.cur - 1 + this.imgs.length) % this.imgs.length; },
        next()  { this.cur = (this.cur + 1) % this.imgs.length; },
        go(i)   { this.cur = i; },
        open(i) { this.cur = i; this.modal = true; document.body.style.overflow = 'hidden'; },
        close() { this.modal = false; document.body.style.overflow = ''; },
        swipeStart(e) { this.tx = e.changedTouches[0].screenX; },
        swipeEnd(e)   { const d = this.tx - e.changedTouches[0].screenX; if (Math.abs(d) > 50) { d > 0 ? this.next() : this.prev(); } }
    };
}
</script>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid lg:grid-cols-12 gap-10 lg:gap-16 items-start mb-16">

        {{-- LEFT: Image Gallery --}}
        <div class="lg:col-span-5" x-data="productGallery()" @keydown.escape.window="if(modal) close()">

            {{-- Main image --}}
            <div class="relative aspect-square bg-cream rounded-2xl overflow-hidden border border-gray-100 cursor-zoom-in mb-3 group"
                 @click="open(cur)" @touchstart="swipeStart($event)" @touchend="swipeEnd($event)">

                <template x-if="imgs.length > 0">
                    <img :src="imgs[cur]" alt="{{ $product->name }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105 select-none">
                </template>
                <template x-if="imgs.length === 0">
                    <div class="w-full h-full flex items-center justify-center text-8xl text-gray-200">
                        {{ $product->category->icon ?? '🛍️' }}
                    </div>
                </template>

                {{-- Badges --}}
                <div class="absolute top-4 left-4 flex flex-col gap-2">
                    @if($product->discount_percent > 0)
                        <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">-{{ $product->discount_percent }}%</span>
                    @endif
                    @if($product->is_bestseller)
                        <span class="bg-amber-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">🔥 Terlaris</span>
                    @endif
                    @if($product->stock <= 0)
                        <span class="bg-gray-700 text-white text-xs font-bold px-3 py-1 rounded-full shadow">Habis</span>
                    @endif
                </div>

                {{-- Zoom hint --}}
                <div class="absolute bottom-4 right-4 bg-white/80 backdrop-blur-sm text-gray-500 text-xs px-3 py-1.5 rounded-full flex items-center gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Perbesar
                </div>

                {{-- Prev/Next arrows (if multiple images) --}}
                <template x-if="multi">
                    <div>
                        <button @click.stop="prev()"
                                class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 bg-white/80 hover:bg-white rounded-full shadow-md flex items-center justify-center transition-all opacity-0 group-hover:opacity-100">
                            <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button @click.stop="next()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 bg-white/80 hover:bg-white rounded-full shadow-md flex items-center justify-center transition-all opacity-0 group-hover:opacity-100">
                            <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </template>
            </div>

            {{-- Thumbnail strip --}}
            <template x-if="multi">
                <div class="flex gap-3 overflow-x-auto pb-1">
                    <template x-for="(img, i) in imgs" :key="i">
                        <button @click="go(i)"
                                class="flex-shrink-0 w-16 h-16 rounded-xl overflow-hidden border-2 transition-all duration-200"
                                :class="cur === i ? 'border-navy opacity-100 shadow-md' : 'border-transparent opacity-50 hover:opacity-75'">
                            <img :src="img" class="w-full h-full object-cover select-none">
                        </button>
                    </template>
                </div>
            </template>

            {{-- Lightbox --}}
            <div x-show="modal" x-cloak
                 class="fixed inset-0 z-[110] flex items-center justify-center"
                 x-transition:enter="transition-opacity duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @touchstart="swipeStart($event)" @touchend="swipeEnd($event)">

                <div class="absolute inset-0 bg-gray-950/95" @click="close()"></div>

                <button @click="close()"
                        class="absolute top-5 right-5 z-20 w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-colors border border-white/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <template x-if="multi">
                    <div class="absolute top-6 left-1/2 -translate-x-1/2 z-20 bg-white/10 border border-white/10 text-white/80 text-xs font-semibold px-4 py-1.5 rounded-full">
                        <span x-text="cur + 1"></span> / <span x-text="imgs.length"></span>
                    </div>
                </template>

                <template x-if="multi">
                    <div>
                        <button @click="prev()"
                                class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-11 h-11 bg-white/10 hover:bg-white/20 border border-white/10 text-white rounded-full flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button @click="next()"
                                class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-11 h-11 bg-white/10 hover:bg-white/20 border border-white/10 text-white rounded-full flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </template>

                <div class="relative z-10 w-full px-16 sm:px-24 flex items-center justify-center" style="max-height:85vh">
                    <img :src="imgs[cur]" alt="{{ $product->name }}"
                         class="max-w-full max-h-[82vh] object-contain rounded-2xl shadow-2xl select-none mx-auto block">
                </div>
            </div>
        </div>

        {{-- RIGHT: Purchase panel --}}
        <div class="lg:col-span-7">

            {{-- Category + Name + Origin + Rating --}}
            <div class="mb-5">
                <a href="{{ route('products.index', ['category' => $product->category->slug]) }}"
                   class="inline-flex items-center gap-1.5 text-[10px] font-bold tracking-widest uppercase text-gold hover:text-navy transition-colors mb-2">
                    {{ $product->category->icon }} {{ $product->category->name }}
                </a>
                <h1 class="font-display text-2xl md:text-3xl font-bold text-navy leading-tight mb-2">{{ $product->name }}</h1>
                <div class="flex items-center flex-wrap gap-3">
                    @if($product->origin)
                        <span class="text-sm text-gray-400 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $product->origin }}
                        </span>
                    @endif
                    @if($product->reviews->count() > 0)
                        <span class="text-gray-200">|</span>
                        <span class="flex items-center gap-1.5 text-sm text-gray-500">
                            <span class="flex text-amber-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-3.5 h-3.5 {{ $i <= round($product->average_rating) ? 'fill-current' : 'fill-gray-200' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </span>
                            <span class="font-semibold text-gray-700">{{ number_format($product->average_rating, 1) }}</span>
                            <span class="text-gray-400">({{ $product->reviews->count() }})</span>
                        </span>
                    @endif
                </div>
            </div>

            {{-- Price --}}
            <div class="flex items-center gap-3 pb-5 border-b border-gray-100 mb-5">
                <span class="text-3xl font-bold text-navy tracking-tight">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                @if($product->original_price)
                    <span class="text-sm text-gray-400 line-through">Rp {{ number_format($product->original_price, 0, ',', '.') }}</span>
                    <span class="bg-red-50 text-red-500 text-xs font-bold px-2.5 py-1 rounded-full border border-red-100">-{{ $product->discount_percent }}%</span>
                @endif
            </div>

            {{-- Short description --}}
            @if($product->short_description)
                <p class="text-sm text-gray-500 leading-relaxed mb-5">{{ $product->short_description }}</p>
            @endif

            {{-- Add to Cart --}}
            @if($product->stock > 0)
            <form action="{{ route('cart.add') }}" method="POST" class="mb-5">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                {{-- Stok indicator --}}
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs text-gray-400 font-medium">Jumlah</span>
                    <span class="flex items-center gap-1.5 text-xs font-medium text-emerald-600">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                        {{ $product->stock }} unit tersedia
                    </span>
                </div>

                {{-- Qty + Button --}}
                <div class="flex items-stretch gap-3">
                    <div class="flex items-center border border-gray-200 rounded-2xl bg-white flex-shrink-0 overflow-hidden">
                        <button type="button" onclick="changeQty(-1)"
                                class="w-11 h-12 flex items-center justify-center text-gray-400 hover:text-navy hover:bg-gray-50 transition-colors text-lg select-none">
                            −
                        </button>
                        <input type="number" name="quantity" id="qty" value="1" min="1" max="{{ $product->stock }}"
                               class="w-10 h-12 text-center text-sm font-semibold text-gray-800 border-x border-gray-100 focus:outline-none focus:ring-0 bg-white [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                        <button type="button" onclick="changeQty(1)"
                                class="w-11 h-12 flex items-center justify-center text-gray-400 hover:text-navy hover:bg-gray-50 transition-colors text-lg select-none">
                            +
                        </button>
                    </div>
                    <button type="submit"
                            class="flex-1 h-12 bg-navy text-white text-sm font-semibold rounded-2xl flex items-center justify-center gap-2 hover:bg-[#2d4a6b] transition-colors shadow-sm">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        Tambah ke Keranjang
                    </button>
                </div>
            </form>
            @else
                <div class="flex items-center gap-2 bg-red-50 border border-red-100 text-red-500 text-sm font-semibold px-5 py-3.5 rounded-2xl mb-5">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Stok Habis
                </div>
            @endif

            {{-- Accordion --}}
            <div class="border border-gray-100 rounded-2xl overflow-hidden divide-y divide-gray-100" x-data="{ open: null }">

                {{-- Deskripsi --}}
                <div>
                    <button @click="open = open === 'desc' ? null : 'desc'"
                            class="w-full flex items-center justify-between px-5 py-3.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors text-left">
                        <span>Deskripsi Produk</span>
                        <svg :class="open === 'desc' ? 'rotate-180' : ''"
                             class="w-4 h-4 text-gray-400 transition-transform duration-300 flex-shrink-0"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open === 'desc'"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-cloak
                         class="px-5 pb-4 text-sm text-gray-500 leading-relaxed border-t border-gray-50 pt-3">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>

                {{-- Spesifikasi --}}
                <div>
                    <button @click="open = open === 'specs' ? null : 'specs'"
                            class="w-full flex items-center justify-between px-5 py-3.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors text-left">
                        <span>Spesifikasi</span>
                        <svg :class="open === 'specs' ? 'rotate-180' : ''"
                             class="w-4 h-4 text-gray-400 transition-transform duration-300 flex-shrink-0"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open === 'specs'"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-cloak
                         class="px-5 pb-4 border-t border-gray-50 pt-3">
                        <dl class="space-y-2 text-sm">
                            <div class="flex justify-between py-1.5 border-b border-gray-50">
                                <dt class="text-gray-400">Kategori</dt>
                                <dd class="font-semibold text-gray-700">{{ $product->category->name }}</dd>
                            </div>
                            @if($product->origin)
                            <div class="flex justify-between py-1.5 border-b border-gray-50">
                                <dt class="text-gray-400">Asal Produk</dt>
                                <dd class="font-semibold text-gray-700">{{ $product->origin }}</dd>
                            </div>
                            @endif
                            @if($product->weight)
                            <div class="flex justify-between py-1.5 border-b border-gray-50">
                                <dt class="text-gray-400">Berat</dt>
                                <dd class="font-semibold text-gray-700">{{ $product->weight }}</dd>
                            </div>
                            @endif
                            <div class="flex justify-between py-1.5">
                                <dt class="text-gray-400">Stok</dt>
                                <dd class="font-semibold text-emerald-600">{{ $product->stock }} unit tersedia</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                {{-- Pengiriman --}}
                <div>
                    <button @click="open = open === 'ship' ? null : 'ship'"
                            class="w-full flex items-center justify-between px-5 py-3.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors text-left">
                        <span>Pengiriman</span>
                        <svg :class="open === 'ship' ? 'rotate-180' : ''"
                             class="w-4 h-4 text-gray-400 transition-transform duration-300 flex-shrink-0"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open === 'ship'"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-cloak
                         class="px-5 pb-4 border-t border-gray-50 pt-3 space-y-3 text-sm text-gray-500">
                        <div class="flex gap-3 items-start">
                            <span class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center flex-shrink-0 text-sm">🏪</span>
                            <div>
                                <p class="font-semibold text-gray-700 text-xs mb-0.5">Ambil Sendiri</p>
                                <p class="text-xs leading-relaxed">Gratis, di toko kami daerah Lowokwaru, Kota Malang.</p>
                            </div>
                        </div>
                        <div class="flex gap-3 items-start">
                            <span class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center flex-shrink-0 text-sm">🚴</span>
                            <div>
                                <p class="font-semibold text-gray-700 text-xs mb-0.5">Pengiriman Malang</p>
                                <p class="text-xs leading-relaxed">Flat Rp 15.000, estimasi H+1 area Kota & Kabupaten Malang.</p>
                            </div>
                        </div>
                        <div class="flex gap-3 items-start">
                            <span class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center flex-shrink-0 text-sm">🚛</span>
                            <div>
                                <p class="font-semibold text-gray-700 text-xs mb-0.5">Ekspedisi Nasional</p>
                                <p class="text-xs leading-relaxed">JNE, J&T, dan kargo lain. Ongkos kirim dikonfirmasi via WhatsApp.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Reviews --}}
    @if($product->reviews->count() > 0)
    <div class="border-t border-gray-100 pt-14 mb-14">
        <div class="flex items-center justify-between mb-8">
            <div>
                <p class="text-[10px] font-bold tracking-widest uppercase text-gold mb-1">Dari Pembeli</p>
                <h2 class="font-display text-2xl font-bold text-navy">Ulasan ({{ $product->reviews->count() }})</h2>
            </div>
            {{-- Average rating summary --}}
            <div class="text-center hidden sm:block">
                <p class="text-4xl font-bold text-navy font-display">{{ number_format($product->average_rating, 1) }}</p>
                <div class="flex justify-center text-amber-400 my-1">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4 {{ $i <= round($product->average_rating) ? 'fill-current' : 'fill-gray-200' }}" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                </div>
                <p class="text-xs text-gray-400">dari {{ $product->reviews->count() }} ulasan</p>
            </div>
        </div>
        <div class="grid md:grid-cols-2 gap-5">
            @foreach($product->reviews->take(4) as $review)
            <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 bg-navy rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                        {{ substr($review->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ $review->user->name }}</p>
                        <div class="flex text-amber-400 mt-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-3 h-3 {{ $i <= $review->rating ? 'fill-current' : 'fill-gray-200' }}" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                    </div>
                </div>
                @if($review->comment)
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $review->comment }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Related Products --}}
    @if($relatedProducts->isNotEmpty())
    <div class="border-t border-gray-100 pt-14">
        <div class="flex items-end justify-between mb-8">
            <div>
                <p class="text-[10px] font-bold tracking-widest uppercase text-gold mb-1">Mungkin Kamu Suka</p>
                <h2 class="font-display text-2xl font-bold text-navy">Produk Serupa</h2>
            </div>
            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}"
               class="text-sm font-semibold text-navy hover:text-gold transition-colors flex items-center gap-1 hidden sm:flex">
                Lihat semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            @foreach($relatedProducts as $prod)
                @include('components.product-card', ['product' => $prod])
            @endforeach
        </div>
    </div>
    @endif

</div>

@endsection

@push('scripts')
<script>
function changeQty(delta) {
    const input = document.getElementById('qty');
    const max = parseInt(input.max);
    const newVal = Math.min(Math.max(1, parseInt(input.value) + delta), max);
    input.value = newVal;
}
</script>
@endpush
