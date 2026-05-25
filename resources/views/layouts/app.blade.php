@php
    $cart = null;
    if(auth()->check()) {
        $cart = \App\Models\Cart::where('user_id', auth()->id())->with('items.product.category')->first();
    } else {
        $cart = \App\Models\Cart::where('session_id', session()->getId())->where('user_id', null)->with('items.product.category')->first();
    }
    $cartCount = $cart ? $cart->items->sum('quantity') : 0;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'malangan.com') - Oleh-oleh Khas Malang</title>
    <meta name="description" content="@yield('description', 'Toko online oleh-oleh dan produk asli khas Malang.')">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --navy: #3B5F8A; --gold: #D4956A; --gold-dk: #C07A50; --cream: #F6F8FB; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; color: #1e2d3d; }
        .font-display { font-family: 'Playfair Display', serif; }
        .text-navy { color: var(--navy); }
        .bg-navy { background-color: var(--navy); }
        .text-gold { color: var(--gold); }
        .bg-gold { background-color: var(--gold); }
        .border-gold { border-color: var(--gold); }
        .hover\:text-gold:hover { color: var(--gold); }
        .hover\:border-gold:hover { border-color: var(--gold); }
        .bg-cream { background-color: var(--cream); }
        .btn-primary {
            background: var(--navy);
            color: white;
            font-weight: 500;
            font-size: 0.875rem;
            padding: 0.75rem 2rem;
            border-radius: 9999px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-block;
            letter-spacing: 0.02em;
        }
        .btn-primary:hover { background: #2d4a6b; box-shadow: 0 10px 25px -5px rgba(59,95,138,0.3); transform: translateY(-0.5px); }
        .btn-ghost {
            border: 1px solid #d1dae6;
            color: #3B5F8A;
            font-weight: 500;
            font-size: 0.875rem;
            padding: 0.75rem 2rem;
            border-radius: 9999px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-block;
        }
        .btn-ghost:hover { border-color: var(--gold); color: var(--gold); }
        .btn-gold {
            background: var(--gold);
            color: var(--navy);
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.75rem 2rem;
            border-radius: 9999px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-block;
        }
        .btn-gold:hover { background: var(--gold-dk); box-shadow: 0 10px 25px -5px rgba(197,168,128,0.25); }
        .card-product { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-product:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -15px rgba(0,0,0,0.05); }
        .batik-bg {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        [x-cloak] { display: none !important; }
        #flash-msg { animation: slideInDown 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
        @keyframes slideInDown { from { opacity: 0; transform: translateY(-12px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-white text-zinc-900 antialiased" x-data="{ mobileOpen: false, searchOpen: false, cartOpen: {{ session('success') && str_contains(session('success'), 'berhasil ditambahkan') ? 'true' : 'false' }} }">

    {{-- Navbar --}}
    <nav class="bg-white/80 backdrop-blur-md border-b border-zinc-100 sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex-shrink-0">
                    @if(file_exists(public_path('images/logo.png')))
                        <img src="{{ asset('images/logo.png') }}" alt="malangan.com" class="h-8 w-auto">
                    @else
                        <span class="font-display text-xl font-bold tracking-tight text-navy">malangan<span class="text-gold">.com</span></span>
                    @endif
                </a>

                {{-- Center nav (desktop) --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-zinc-600 hover:text-navy hover:border-b-2 hover:border-gold pb-1 pt-1.5 transition-colors">Beranda</a>
                    <a href="{{ route('products.index') }}" class="text-sm font-medium text-zinc-600 hover:text-navy hover:border-b-2 hover:border-gold pb-1 pt-1.5 transition-colors">Semua Produk</a>
                </div>

                {{-- Right actions --}}
                <div class="flex items-center gap-1">

                    {{-- Search (desktop) --}}
                    <div class="relative hidden md:block">
                        <button @click="searchOpen = !searchOpen"
                                class="p-2 text-zinc-400 hover:text-navy hover:bg-zinc-50 rounded-full transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                        <div x-show="searchOpen" x-cloak @click.outside="searchOpen = false"
                             class="absolute right-0 top-12 w-80 bg-white rounded-2xl shadow-xl border border-zinc-100 p-3.5 z-50">
                            <form action="{{ route('products.index') }}" method="GET">
                                <div class="relative">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                           placeholder="Cari produk khas Malang..."
                                           class="w-full pl-4 pr-10 py-2.5 rounded-full bg-zinc-50 border border-zinc-200 focus:outline-none focus:border-gold focus:ring-1 focus:ring-gold text-sm text-zinc-800">
                                    <button type="submit" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-navy transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Cart --}}
                    <button @click="cartOpen = !cartOpen" class="relative p-2.5 text-zinc-400 hover:text-navy hover:bg-zinc-50 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        @if($cartCount > 0)
                            <span class="absolute top-0.5 right-0.5 bg-gold text-zinc-950 text-[10px] font-bold rounded-full flex items-center justify-center shadow-[0_2px_8px_rgba(197,168,128,0.35)]" style="width:17px;height:17px">{{ $cartCount }}</span>
                        @endif
                    </button>

                    {{-- Auth --}}
                    @auth
                        <div class="relative group ml-1">
                            <button class="flex items-center gap-1.5 py-1.5 px-2 rounded-xl hover:bg-gray-50 transition-colors">
                                <div class="w-7 h-7 bg-navy rounded-full flex items-center justify-center text-white font-semibold text-xs">{{ substr(auth()->user()->name, 0, 1) }}</div>
                                <svg class="w-3 h-3 text-gray-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="absolute right-0 top-full mt-2 w-52 bg-white rounded-2xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-150 z-50 overflow-hidden">
                                <div class="px-4 py-3 bg-gray-50 border-b border-gray-100">
                                    <p class="text-xs font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-400 truncate mt-0.5">{{ auth()->user()->email }}</p>
                                </div>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-amber-600 font-medium hover:bg-amber-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        Dashboard Admin
                                    </a>
                                @endif
                                <a href="{{ route('orders.index') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    Pesanan Saya
                                </a>
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    Profil Saya
                                </a>
                                <div class="border-t border-gray-100">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-2 w-full px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors rounded-b-2xl">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="hidden md:block text-sm font-medium text-gray-500 hover:text-navy transition-colors px-3 py-2">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-primary ml-1">Daftar</a>
                    @endauth

                    {{-- Mobile hamburger --}}
                    <button @click="mobileOpen = !mobileOpen"
                            class="md:hidden p-2 text-gray-400 hover:text-navy hover:bg-gray-50 rounded-xl transition-colors ml-1">
                        <svg x-show="!mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileOpen" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div x-show="mobileOpen" x-cloak class="md:hidden border-t border-gray-100 bg-white">
            <div class="px-4 py-4 space-y-1">
                <form action="{{ route('products.index') }}" method="GET" class="mb-3">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                               class="w-full pl-4 pr-10 py-2.5 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none text-sm text-gray-800">
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </div>
                </form>
                <a href="{{ route('home') }}" class="block px-3 py-2.5 text-sm font-medium text-gray-700 hover:text-navy hover:bg-gray-50 rounded-xl transition-colors">Beranda</a>
                <a href="{{ route('products.index') }}" class="block px-3 py-2.5 text-sm font-medium text-gray-700 hover:text-navy hover:bg-gray-50 rounded-xl transition-colors">Semua Produk</a>
                @guest
                    <div class="pt-3 border-t border-gray-100 flex gap-2">
                        <a href="{{ route('login') }}" class="flex-1 text-center btn-ghost py-2.5">Masuk</a>
                        <a href="{{ route('register') }}" class="flex-1 text-center btn-primary py-2.5">Daftar</a>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    {{-- Flash messages --}}
    @if(session('success'))
        <div id="flash-msg" class="fixed top-20 right-4 z-50 bg-emerald-600 text-white px-5 py-3 rounded-2xl shadow-xl flex items-center gap-3 text-sm font-medium max-w-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div id="flash-msg" class="fixed top-20 right-4 z-50 bg-red-600 text-white px-5 py-3 rounded-2xl shadow-xl flex items-center gap-3 text-sm font-medium max-w-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <main>@yield('content')</main>

    {{-- Slide-over Mini-Cart Drawer --}}
    <div x-show="cartOpen"
         class="fixed inset-0 z-[100] overflow-hidden"
         x-cloak
         style="display: none;">
        {{-- Backdrop overlay --}}
        <div class="absolute inset-0 bg-zinc-950/40 backdrop-blur-sm transition-opacity"
             x-show="cartOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="cartOpen = false"></div>

        <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
            <div class="w-screen max-w-md"
                 x-show="cartOpen"
                 x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 @click.away="cartOpen = false">

                <div class="h-full flex flex-col bg-white shadow-2xl border-l border-zinc-100">
                    {{-- Header --}}
                    <div class="flex items-center justify-between px-6 py-5 border-b border-zinc-100">
                        <div class="flex items-center gap-2">
                            <span class="text-xl">🛒</span>
                            <h2 class="font-display text-lg font-bold text-zinc-900 tracking-wide">Keranjang Belanja</h2>
                        </div>
                        <button @click="cartOpen = false" class="text-zinc-400 hover:text-zinc-600 p-1.5 rounded-full hover:bg-zinc-50 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    {{-- Items list --}}
                    <div class="flex-1 py-6 overflow-y-auto px-6 space-y-5">
                        @if($cart && $cart->items->isNotEmpty())
                            @foreach($cart->items as $item)
                                <div class="flex gap-4 border-b border-zinc-100 pb-5 last:border-0 last:pb-0">
                                    <a href="{{ route('products.show', $item->product->slug) }}" class="flex-shrink-0 w-16 h-16 rounded-xl bg-zinc-50 border border-zinc-100 overflow-hidden group">
                                        @if($item->product->thumbnail)
                                            <img src="{{ asset('storage/' . $item->product->thumbnail) }}" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-xl bg-zinc-100/50">🛍️</div>
                                        @endif
                                    </a>
                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('products.show', $item->product->slug) }}" class="text-sm font-semibold text-zinc-800 hover:text-gold line-clamp-1 transition-colors">{{ $item->product->name }}</a>
                                        <p class="text-[10px] text-zinc-400 font-bold uppercase tracking-wider mt-0.5">{{ $item->product->category->name }}</p>
                                        <div class="flex items-center justify-between mt-2.5">
                                            {{-- Mini count update --}}
                                            <div class="flex items-center border border-zinc-200 rounded-full overflow-hidden bg-white shadow-sm">
                                                <form action="{{ route('cart.decrement', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="w-7 h-7 flex items-center justify-center text-zinc-500 hover:bg-zinc-50 hover:text-red-500 font-semibold text-sm transition-colors">−</button>
                                                </form>
                                                <span class="w-8 h-7 flex items-center justify-center font-bold text-xs border-x border-zinc-200 text-zinc-800">{{ $item->quantity }}</span>
                                                <form action="{{ route('cart.increment', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="w-7 h-7 flex items-center justify-center text-zinc-500 hover:bg-zinc-50 hover:text-green-600 font-semibold text-sm transition-colors">+</button>
                                                </form>
                                            </div>
                                            <p class="text-xs font-bold text-zinc-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col justify-between items-end flex-shrink-0">
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="text-zinc-300 hover:text-red-500 transition-colors p-1.5 rounded-full hover:bg-zinc-50">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                              @endforeach
                        @else
                            <div class="text-center py-24 flex flex-col items-center">
                                <span class="text-6xl bg-zinc-50 rounded-full p-6 inline-block mb-4">🛒</span>
                                <h3 class="font-display text-base font-bold text-zinc-800">Keranjang Kosong</h3>
                                <p class="text-xs text-zinc-400 mt-1.5 max-w-[200px] mx-auto leading-relaxed">Belum ada produk pilihan yang dimasukkan ke dalam keranjang.</p>
                                <a href="{{ route('products.index') }}" @click="cartOpen = false" class="btn-primary mt-6 text-xs px-5 py-2.5 shadow-sm">Mulai Belanja</a>
                            </div>
                        @endif
                    </div>

                    {{-- Footer actions --}}
                    @if($cart && $cart->items->isNotEmpty())
                        <div class="border-t border-zinc-100 px-6 py-6 bg-zinc-50/50">
                            <div class="flex justify-between font-bold text-zinc-900 text-sm">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                            </div>
                            <p class="text-[10px] text-zinc-400 mt-1">Belum termasuk ongkos kirim (ongkir dikonfirmasi saat checkout).</p>
                            <div class="mt-6 flex flex-col gap-2.5">
                                <a href="{{ route('checkout.index') }}" class="btn-primary w-full text-center text-xs py-3.5 shadow-sm hover:shadow-md">Lanjut ke Checkout</a>
                                <a href="{{ route('cart.index') }}" class="btn-ghost w-full text-center text-xs py-3.5 bg-white shadow-sm hover:border-gold">Lihat Detail Keranjang</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-navy text-white mt-20">
        <div class="batik-bg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-10">
                    <div class="md:col-span-5">
                        @if(file_exists(public_path('images/logo.png')))
                            <div class="bg-white/10 rounded-xl px-4 py-2 inline-block mb-5">
                                <img src="{{ asset('images/logo.png') }}" alt="malangan.com" class="h-8 w-auto">
                            </div>
                        @else
                            <div class="mb-5">
                                <span class="font-display text-2xl font-bold text-white">malangan<span class="text-gold">.com</span></span>
                            </div>
                        @endif
                        <p class="text-white/55 text-sm leading-relaxed mb-5 max-w-xs">Platform belanja online untuk produk asli dan souvenir khas Malang Raya. Dari hati pengrajin lokal, untuk seluruh Indonesia.</p>
                        <p class="text-white/35 text-xs">Kota Malang, Jawa Timur &nbsp;&middot;&nbsp; info@malangan.com</p>
                    </div>
                    <div class="md:col-span-3 md:col-start-7">
                        <h4 class="text-xs font-semibold tracking-widest uppercase text-gold mb-5">Kategori</h4>
                        <ul class="space-y-3 text-sm text-white/55">
                            @foreach([['makanan-kuliner','Makanan & Kuliner'],['kerajinan-tangan','Kerajinan Tangan'],['topeng-kesenian','Topeng & Kesenian'],['batik-malang','Batik Malang'],['souvenir-aksesoris','Souvenir']] as [$slug, $name])
                                <li><a href="{{ route('products.index', ['category'=>$slug]) }}" class="hover:text-white transition-colors">{{ $name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="md:col-span-3">
                        <h4 class="text-xs font-semibold tracking-widest uppercase text-gold mb-5">Informasi</h4>
                        <ul class="space-y-3 text-sm text-white/55">
                            @foreach(\App\Models\Page::where('show_in_footer', true)->where('is_active', true)->orderBy('sort_order')->orderBy('title')->get() as $_footerPage)
                                <li><a href="{{ route('pages.show', $_footerPage->slug) }}" class="hover:text-white transition-colors">{{ $_footerPage->title }}</a></li>
                            @endforeach
                            <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Masuk / Daftar</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-white/10 mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <p class="text-white/30 text-xs">© 2011 - {{ date('Y') }} malangan.com &nbsp;&middot;&nbsp; Bangga Produk Malang</p>
                    <p class="text-white/30 text-xs">Dibuat dengan cinta di Malang</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        const fm = document.getElementById('flash-msg');
        if (fm) setTimeout(() => {
            fm.style.transition = 'opacity 0.3s, transform 0.3s';
            fm.style.opacity = '0';
            fm.style.transform = 'translateY(-8px)';
            setTimeout(() => fm.remove(), 300);
        }, 3500);
    </script>
    @stack('scripts')
</body>
</html>
