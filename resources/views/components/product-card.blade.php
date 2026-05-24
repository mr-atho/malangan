<div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 card-product group">
    <a href="{{ route('products.show', $product->slug) }}" class="block">
        <div class="relative overflow-hidden aspect-square bg-gray-100">
            @if($product->thumbnail)
                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            @else
                <div class="w-full h-full flex items-center justify-center text-6xl bg-amber-50">
                    {{ $product->category->icon ?? '🛍️' }}
                </div>
            @endif
            @if($product->discount_percent > 0)
                <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">-{{ $product->discount_percent }}%</span>
            @endif
            @if($product->is_bestseller)
                <span class="absolute top-2 right-2 bg-amber-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">🔥 Laris</span>
            @endif
            @if($product->stock <= 0)
                <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                    <span class="bg-white text-gray-800 text-sm font-semibold px-4 py-1.5 rounded-full">Habis</span>
                </div>
            @endif
        </div>
    </a>
    <div class="p-3">
        <p class="text-xs text-gold font-medium mb-1">{{ $product->category->name }}</p>
        <a href="{{ route('products.show', $product->slug) }}">
            <h3 class="text-sm font-semibold text-gray-800 hover:text-navy leading-snug line-clamp-2 mb-2">{{ $product->name }}</h3>
        </a>
        @if($product->origin)
            <p class="text-xs text-gray-400 mb-2 flex items-center gap-1"><span>📍</span> {{ $product->origin }}</p>
        @endif
        <div class="flex items-center justify-between">
            <div>
                <p class="text-base font-bold text-navy">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                @if($product->original_price)
                    <p class="text-xs text-gray-400 line-through">Rp {{ number_format($product->original_price, 0, ',', '.') }}</p>
                @endif
            </div>
            @if($product->stock > 0)
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="w-8 h-8 bg-navy text-white rounded-full flex items-center justify-center hover:bg-gold hover:text-navy transition-colors text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </button>
            </form>
            @endif
        </div>
    </div>
</div>
