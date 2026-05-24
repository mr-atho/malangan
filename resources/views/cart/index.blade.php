@extends('layouts.app')
@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="font-display text-3xl font-bold text-navy mb-8">Keranjang Belanja</h1>

    @if($cart->items->isEmpty())
        <x-empty-state emoji="🛒" title="Keranjang kosong"
            description="Belum ada produk di keranjang. Yuk mulai belanja!"
            actionLabel="Mulai Belanja" actionHref="{{ route('products.index') }}" />
    @else
        <div class="grid md:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart->items as $item)
                <x-card class="p-5 flex gap-4">
                    <a href="{{ route('products.show', $item->product->slug) }}" class="flex-shrink-0">
                        <x-product-image class="w-20 h-20"
                            :thumbnail="$item->product->thumbnail"
                            :icon="$item->product->category->icon ?? '🛍️'" />
                    </a>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('products.show', $item->product->slug) }}" class="font-semibold text-sm text-navy hover:text-gold line-clamp-2">{{ $item->product->name }}</a>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $item->product->category->name }}</p>
                        <p class="text-sm font-bold text-navy mt-1">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="flex flex-col items-end justify-between flex-shrink-0">
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="text-gray-300 hover:text-red-400 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </form>
                        {{-- Quantity control: 3 form terpisah, tanpa JS --}}
                        <div class="flex items-center border-2 border-gray-200 rounded-xl overflow-hidden">
                            <form action="{{ route('cart.decrement', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-10 h-10 flex items-center justify-center text-gray-500 hover:bg-gray-100 hover:text-red-500 font-bold text-xl transition-colors">−</button>
                            </form>

                            <span class="w-12 h-10 flex items-center justify-center font-bold text-base border-x-2 border-gray-200 text-navy">{{ $item->quantity }}</span>

                            <form action="{{ route('cart.increment', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-10 h-10 flex items-center justify-center text-gray-500 hover:bg-gray-100 hover:text-green-600 font-bold text-xl transition-colors">+</button>
                            </form>
                        </div>
                        <p class="text-sm font-bold text-navy">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </div>
                </x-card>
                @endforeach
            </div>

            {{-- Order Summary --}}
            <div class="lg:col-span-1">
                <x-card class="sticky top-24">
                    <h3 class="font-display text-lg font-bold text-navy mb-5">Ringkasan Pesanan</h3>
                    <div class="space-y-3 text-sm">
                        @foreach($cart->items as $item)
                        <div class="flex justify-between text-gray-600">
                            <span class="truncate max-w-32">{{ $item->product->name }} ×{{ $item->quantity }}</span>
                            <span class="font-medium flex-shrink-0 ml-2">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="border-t border-gray-100 mt-4 pt-4">
                        <div class="flex justify-between font-bold text-navy">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Belum termasuk ongkos kirim</p>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="btn-primary w-full text-center block mt-5 text-sm py-3">Lanjut ke Checkout</a>
                    <a href="{{ route('products.index') }}" class="block text-center text-sm text-navy hover:text-gold mt-3 font-medium">← Lanjut Belanja</a>
                </x-card>
            </div>
        </div>
    @endif
</div>
@endsection
