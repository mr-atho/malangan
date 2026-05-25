<div class="bg-white rounded-2xl overflow-hidden border border-zinc-100 card-product group relative flex flex-col h-full">
    <a href="{{ route('products.show', $product->slug) }}" class="block overflow-hidden relative aspect-square bg-zinc-50">
        @if($product->thumbnail)
            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out select-none">
        @else
            <div class="w-full h-full flex items-center justify-center text-5xl bg-zinc-100/50 select-none">
                {{ $product->category->icon ?? '🛍️' }}
            </div>
        @endif
        
        {{-- Badges --}}
        <div class="absolute top-3 left-3 flex flex-col gap-1.5 z-10">
            @if($product->discount_percent > 0)
                <span class="bg-red-600 text-white text-[10px] font-bold tracking-wider uppercase px-2.5 py-1 rounded-full shadow-sm">
                    -{{ $product->discount_percent }}%
                </span>
            @endif
            @if($product->is_bestseller)
                <span class="bg-gold text-zinc-950 text-[10px] font-bold tracking-wider uppercase px-2.5 py-1 rounded-full shadow-[0_2px_10px_rgba(197,168,128,0.4)]">
                    🔥 Laris
                </span>
            @endif
        </div>

        @if($product->stock <= 0)
            <div class="absolute inset-0 bg-zinc-900/60 backdrop-blur-[2px] flex items-center justify-center z-10">
                <span class="bg-white text-zinc-800 text-xs font-semibold tracking-wide uppercase px-4 py-2 rounded-full shadow-md">Habis</span>
            </div>
        @endif
    </a>
    
    <div class="p-4 flex-1 flex flex-col justify-between">
        <div>
            <p class="text-[10px] font-bold tracking-widest uppercase text-gold mb-1.5">{{ $product->category->name }}</p>
            <a href="{{ route('products.show', $product->slug) }}" class="block group-hover:text-gold transition-colors">
                <h3 class="text-sm font-semibold text-zinc-800 leading-snug line-clamp-2 min-h-[2.5rem] mb-1.5">{{ $product->name }}</h3>
            </a>
            @if($product->origin)
                <p class="text-xs text-zinc-400 mb-3 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>{{ $product->origin }}</span>
                </p>
            @endif
        </div>
        
        <div class="flex items-center justify-between pt-2 border-t border-zinc-100">
            <div>
                <p class="text-sm font-bold text-navy">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                @if($product->original_price)
                    <p class="text-[11px] text-zinc-400 line-through">Rp {{ number_format($product->original_price, 0, ',', '.') }}</p>
                @endif
            </div>
            
            @if($product->stock > 0)
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="w-8 h-8 bg-navy text-white rounded-full flex items-center justify-center hover:bg-gold hover:text-white hover:shadow-md transition-all duration-300 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
