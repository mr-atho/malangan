@extends('layouts.app')

@section('title', $product->name)
@section('description', $product->short_description ?? substr(strip_tags($product->description), 0, 160))

@section('content')

<x-breadcrumb :items="[
    ['label' => 'Beranda', 'url' => route('home')],
    ['label' => $product->category->name, 'url' => route('products.index', ['category' => $product->category->slug])],
    ['label' => $product->name],
]" />

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid md:grid-cols-2 gap-10 mb-16">

        {{-- Image Carousel --}}
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

        <div>
        @if(count($allImages) > 0)
        <script>
        window._carouselImgs = @json($allImages);
        function productCarousel() {
            return {
                imgs: window._carouselImgs,
                cur: 0,
                modal: false,
                tx: 0,
                get multi() { return this.imgs.length > 1; },
                prev() { this.cur = (this.cur - 1 + this.imgs.length) % this.imgs.length; },
                next() { this.cur = (this.cur + 1) % this.imgs.length; },
                go(i)  { this.cur = i; },
                open(i){ this.cur = i; this.modal = true; document.body.style.overflow = 'hidden'; },
                close(){ this.modal = false; document.body.style.overflow = ''; },
                swipeStart(e){ this.tx = e.changedTouches[0].screenX; },
                swipeEnd(e){ const d = this.tx - e.changedTouches[0].screenX; if(Math.abs(d) > 50){ d > 0 ? this.next() : this.prev(); } }
            };
        }
        </script>
        <div x-data="productCarousel()"
             @keydown.escape.window="if(modal) close()"
             @keydown.left.window="if(modal && multi) prev()"
             @keydown.right.window="if(modal && multi) next()">

            {{-- Main image --}}
            <div class="relative aspect-square bg-amber-50 rounded-2xl overflow-hidden mb-3 group cursor-zoom-in"
                 @click="open(cur)"
                 @touchstart="swipeStart($event)"
                 @touchend="swipeEnd($event)">

                <img :src="imgs[cur]" alt="{{ $product->name }}" class="w-full h-full object-cover select-none">

                {{-- Prev / Next (visible on hover) --}}
                <template x-if="multi">
                    <div>
                        <button @click.stop="prev()"
                                class="absolute left-2 top-1/2 -translate-y-1/2 w-9 h-9 bg-black/30 hover:bg-black/55 backdrop-blur-sm rounded-full flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button @click.stop="next()"
                                class="absolute right-2 top-1/2 -translate-y-1/2 w-9 h-9 bg-black/30 hover:bg-black/55 backdrop-blur-sm rounded-full flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </template>

                {{-- Counter badge --}}
                <template x-if="multi">
                    <div class="absolute top-2 left-2 bg-black/40 backdrop-blur-sm text-white text-xs px-2 py-0.5 rounded-full pointer-events-none">
                        <span x-text="cur + 1"></span>/<span x-text="imgs.length"></span>
                    </div>
                </template>

                {{-- Dots indicator --}}
                <template x-if="multi">
                    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-1.5 pointer-events-none">
                        <template x-for="(img, i) in imgs" :key="i">
                            <span class="rounded-full transition-all duration-200"
                                  :class="cur === i ? 'w-4 h-2 bg-white' : 'w-2 h-2 bg-white/50'"></span>
                        </template>
                    </div>
                </template>

                {{-- Zoom hint icon --}}
                <div class="absolute top-2 right-2 w-8 h-8 bg-black/25 backdrop-blur-sm rounded-full flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                </div>
            </div>

            {{-- Thumbnail strip --}}
            <template x-if="multi">
                <div class="flex gap-2 overflow-x-auto pb-1">
                    <template x-for="(img, i) in imgs" :key="i">
                        <button @click="go(i)"
                                class="flex-shrink-0 w-16 h-16 rounded-xl overflow-hidden border-2 transition-all duration-150"
                                :class="cur === i ? 'border-navy' : 'border-gray-200 opacity-60 hover:opacity-90 hover:border-gold'">
                            <img :src="img" alt="" class="w-full h-full object-cover select-none">
                        </button>
                    </template>
                </div>
            </template>

            {{-- Lightbox / Modal --}}
            <div x-show="modal" x-cloak
                 class="fixed inset-0 z-50 flex items-center justify-center"
                 x-transition:enter="transition-opacity duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @touchstart="swipeStart($event)"
                 @touchend="swipeEnd($event)">

                {{-- Backdrop --}}
                <div class="absolute inset-0 bg-black/90" @click="close()"></div>

                {{-- Close --}}
                <button @click="close()"
                        class="absolute top-4 right-4 z-20 w-10 h-10 bg-white/10 hover:bg-white/25 rounded-full flex items-center justify-center text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                {{-- Counter in modal --}}
                <template x-if="multi">
                    <div class="absolute top-5 left-1/2 -translate-x-1/2 z-20 text-white/70 text-sm font-medium bg-black/30 px-3 py-1 rounded-full">
                        <span x-text="cur + 1"></span> / <span x-text="imgs.length"></span>
                    </div>
                </template>

                {{-- Prev in modal --}}
                <template x-if="multi">
                    <button @click="prev()"
                            class="absolute left-3 sm:left-5 top-1/2 -translate-y-1/2 z-20 w-10 h-10 bg-white/10 hover:bg-white/25 rounded-full flex items-center justify-center text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                </template>

                {{-- Main lightbox image --}}
                <div class="relative z-10 w-full px-14 sm:px-20 flex items-center justify-center" style="max-height:80vh;">
                    <img :src="imgs[cur]" alt="{{ $product->name }}"
                         class="max-w-full max-h-[78vh] object-contain rounded-xl shadow-2xl select-none mx-auto block">
                </div>

                {{-- Next in modal --}}
                <template x-if="multi">
                    <button @click="next()"
                            class="absolute right-3 sm:right-5 top-1/2 -translate-y-1/2 z-20 w-10 h-10 bg-white/10 hover:bg-white/25 rounded-full flex items-center justify-center text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </template>

                {{-- Thumbnail strip in modal --}}
                <template x-if="multi">
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 flex gap-2 max-w-xs sm:max-w-sm overflow-x-auto px-2">
                        <template x-for="(img, i) in imgs" :key="i">
                            <button @click="go(i)"
                                    class="flex-shrink-0 w-12 h-12 rounded-lg overflow-hidden border-2 transition-all duration-150"
                                    :class="cur === i ? 'border-white' : 'border-white/25 opacity-50 hover:opacity-80 hover:border-white/60'">
                                <img :src="img" alt="" class="w-full h-full object-cover select-none">
                            </button>
                        </template>
                    </div>
                </template>
            </div>
        </div>
        @else
        <div class="aspect-square bg-amber-50 rounded-2xl flex items-center justify-center text-9xl">
            {{ $product->category->icon ?? '🛍️' }}
        </div>
        @endif
        </div>

        {{-- Details --}}
        <div>
            <p class="text-gold text-sm font-semibold mb-2 flex items-center gap-1">
                {{ $product->category->icon }} {{ $product->category->name }}
            </p>
            <h1 class="font-display text-2xl md:text-3xl font-bold text-navy mb-2">{{ $product->name }}</h1>

            @if($product->origin)
                <p class="text-sm text-gray-500 mb-4 flex items-center gap-1">📍 {{ $product->origin }}</p>
            @endif

            {{-- Rating --}}
            @if($product->reviews->count() > 0)
            <div class="flex items-center gap-2 mb-4">
                <div class="flex text-yellow-400">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4 {{ $i <= round($product->average_rating) ? 'fill-current' : 'fill-gray-200' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <span class="text-sm text-gray-600">{{ number_format($product->average_rating, 1) }} ({{ $product->reviews->count() }} ulasan)</span>
            </div>
            @endif

            {{-- Price --}}
            <div class="flex items-baseline gap-3 mb-5">
                <span class="text-3xl font-bold text-navy">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                @if($product->original_price)
                    <span class="text-base text-gray-400 line-through">Rp {{ number_format($product->original_price, 0, ',', '.') }}</span>
                    <span class="bg-red-100 text-red-600 text-sm font-bold px-2 py-0.5 rounded-full">-{{ $product->discount_percent }}%</span>
                @endif
            </div>

            {{-- Stock & Weight --}}
            <div class="flex gap-4 mb-6 text-sm">
                <div class="bg-gray-50 rounded-xl px-4 py-2.5">
                    <p class="text-gray-400 text-xs">Stok</p>
                    <p class="font-semibold text-navy">{{ $product->stock > 0 ? $product->stock . ' tersedia' : 'Habis' }}</p>
                </div>
                @if($product->weight)
                <div class="bg-gray-50 rounded-xl px-4 py-2.5">
                    <p class="text-gray-400 text-xs">Berat</p>
                    <p class="font-semibold text-navy">{{ $product->weight }}</p>
                </div>
                @endif
            </div>

            @if($product->short_description)
                <p class="text-gray-600 text-sm leading-relaxed mb-6 bg-amber-50 rounded-xl p-4 border border-amber-100">{{ $product->short_description }}</p>
            @endif

            @if($product->stock > 0)
            <form action="{{ route('cart.add') }}" method="POST" class="flex gap-3">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden">
                    <button type="button" onclick="changeQty(-1)" class="px-4 py-2.5 text-gray-500 hover:bg-gray-50 text-lg font-bold">−</button>
                    <input type="number" name="quantity" id="qty" value="1" min="1" max="{{ $product->stock }}" class="w-14 text-center py-2.5 border-none focus:outline-none text-sm font-medium">
                    <button type="button" onclick="changeQty(1)" class="px-4 py-2.5 text-gray-500 hover:bg-gray-50 text-lg font-bold">+</button>
                </div>
                <button type="submit" class="flex-1 btn-navy text-sm flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Tambah ke Keranjang
                </button>
            </form>
            @else
                <div class="bg-red-50 text-red-600 text-sm font-medium px-4 py-3 rounded-xl border border-red-100">Stok habis - Silakan cek kembali nanti</div>
            @endif
        </div>
    </div>

    {{-- Description --}}
    <x-card class="p-7 mb-8">
        <h2 class="font-display text-xl font-bold text-navy mb-4">Deskripsi Produk</h2>
        <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">{!! nl2br(e($product->description)) !!}</div>
    </x-card>

    {{-- Reviews --}}
    @if($product->reviews->count() > 0)
    <x-card class="p-7 mb-8">
        <h2 class="font-display text-xl font-bold text-navy mb-6">Ulasan Pembeli ({{ $product->reviews->count() }})</h2>
        <div class="space-y-5">
            @foreach($product->reviews->take(5) as $review)
            <div class="pb-5 border-b border-gray-100 last:border-0 last:pb-0">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 bg-navy rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0">{{ substr($review->user->name, 0, 1) }}</div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-medium text-sm text-gray-800">{{ $review->user->name }}</span>
                            <div class="flex text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-3 h-3 {{ $i <= $review->rating ? 'fill-current' : 'fill-gray-200' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                        </div>
                        @if($review->comment)
                            <p class="text-sm text-gray-600">{{ $review->comment }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </x-card>
    @endif

    {{-- Related Products --}}
    @if($relatedProducts->isNotEmpty())
    <div>
        <h2 class="font-display text-2xl font-bold text-navy mb-6">Produk Serupa</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            @foreach($relatedProducts as $product)
                @include('components.product-card', ['product' => $product])
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
