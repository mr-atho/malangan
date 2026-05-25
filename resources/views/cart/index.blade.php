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
                    <div class="flex flex-col items-end justify-between flex-shrink-0 gap-3">
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="text-zinc-300 hover:text-red-500 transition-colors p-1.5 rounded-full hover:bg-zinc-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </form>
                        {{-- Quantity control: 3 form terpisah, tanpa JS --}}
                        <div class="flex items-center border border-zinc-200 rounded-full overflow-hidden bg-white shadow-sm">
                            <form action="{{ route('cart.decrement', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-9 h-9 flex items-center justify-center text-zinc-500 hover:bg-zinc-50 hover:text-red-500 font-semibold text-lg transition-colors">−</button>
                            </form>

                            <span class="w-10 h-9 flex items-center justify-center font-bold text-sm border-x border-zinc-200 text-navy">{{ $item->quantity }}</span>

                            <form action="{{ route('cart.increment', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-9 h-9 flex items-center justify-center text-zinc-500 hover:bg-zinc-50 hover:text-green-600 font-semibold text-lg transition-colors">+</button>
                            </form>
                        </div>
                        <p class="text-sm font-bold text-navy">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </div>
                </x-card>
                @endforeach
            </div>

            {{-- Order Summary --}}
            <div class="lg:col-span-1">
                <x-card class="sticky top-24 border border-zinc-100/80 shadow-[0_8px_30px_rgba(0,0,0,0.02)] rounded-2xl p-6 bg-white">
                    <h3 class="font-display text-lg font-bold text-zinc-900 mb-5 tracking-wide">Ringkasan Pesanan</h3>
                    <div class="space-y-3.5 text-xs">
                        @foreach($cart->items as $item)
                        <div class="flex justify-between text-zinc-500">
                            <span class="truncate max-w-[140px]">{{ $item->product->name }} <span class="font-semibold text-zinc-400">×{{ $item->quantity }}</span></span>
                            <span class="font-semibold flex-shrink-0 ml-2 text-zinc-700">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="border-t border-zinc-100 mt-4.5 pt-4">
                        <div class="flex justify-between font-bold text-zinc-900 text-sm">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                        </div>
                        <p class="text-[10px] text-zinc-400 mt-1">Belum termasuk ongkos kirim (dikalkulasi saat checkout).</p>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="btn-primary w-full text-center block mt-6 text-xs py-3.5 shadow-sm hover:shadow-md uppercase tracking-wider font-bold">Lanjut ke Checkout</a>
                    <a href="{{ route('products.index') }}" class="block text-center text-xs text-zinc-400 hover:text-gold mt-4 font-semibold uppercase tracking-wider">← Lanjut Belanja</a>
                </x-card>
            </div>
        </div>
    @endif
</div>
@endsection
