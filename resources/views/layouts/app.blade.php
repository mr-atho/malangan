<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'malangan.com') - Oleh-oleh Khas Malang</title>
    <meta name="description" content="@yield('description', 'Toko online oleh-oleh dan produk asli khas Malang.')">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; color: #191919; }
        .font-display { font-family: 'Playfair Display', serif; }
        .batik-bg {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.07'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .nav-gold { color: #D4C5A9; }
        .bg-navy { background-color: #1B4332; }
        .border-gold { border-color: #D4C5A9; }
        .text-gold { color: #D4C5A9; }
        .bg-gold { background-color: #D4C5A9; }
        .hover\:bg-gold:hover { background-color: #c2b094; }
        .btn-primary { background-color: #1B4332; color: white; font-weight: 600; padding: 0.6rem 1.5rem; border-radius: 9999px; transition: background-color 0.2s; }
        .btn-primary:hover { background-color: #12301f; }
        .btn-navy { background-color: #0D1F18; color: white; font-weight: 600; padding: 0.6rem 1.5rem; border-radius: 9999px; transition: background-color 0.2s; }
        .btn-navy:hover { background-color: #0a1510; }
        .card-product { transition: transform 0.2s, box-shadow 0.2s; }
        .card-product:hover { transform: translateY(-4px); box-shadow: 0 12px 28px rgba(27,67,50,0.13); }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    {{-- Navbar --}}
    <nav class="bg-navy shadow-lg sticky top-0 z-50" x-data="{ mobileOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('home') }}" class="flex items-center flex-shrink-0">
                    @if(file_exists(public_path('images/logo.png')))
                        <div class="bg-white rounded-lg px-3 py-1.5">
                            <img src="{{ asset('images/logo.png') }}" alt="malangan.com" class="h-7 w-auto">
                        </div>
                    @else
                        <div class="w-9 h-9 bg-white rounded-full flex items-center justify-center font-display font-bold text-navy text-sm">M</div>
                        <span class="font-display text-xl font-bold text-white">malangan<span class="nav-gold">.com</span></span>
                    @endif
                </a>

                <form action="{{ route('products.index') }}" method="GET" class="hidden md:flex flex-1 max-w-md mx-6">
                    <div class="relative w-full">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk khas Malang..." class="w-full pl-4 pr-10 py-2 rounded-full bg-white/10 text-white placeholder-white/50 border border-white/20 focus:outline-none focus:ring-2 focus:ring-red-300 text-sm">
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-white/60 hover:text-gold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </div>
                </form>

                <div class="flex items-center gap-5 pr-1">
                    <a href="{{ route('products.index') }}" class="hidden md:block text-white/80 hover:text-gold text-sm font-medium transition-colors">Produk</a>

                    <a href="{{ route('cart.index') }}" class="relative p-1.5 text-white/80 hover:text-gold transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        @php
                            $cartCount = 0;
                            if(auth()->check()) {
                                $_cart = \App\Models\Cart::where('user_id', auth()->id())->with('items')->first();
                            } else {
                                $_cart = \App\Models\Cart::where('session_id', session()->getId())->where('user_id', null)->with('items')->first();
                            }
                            if(isset($_cart) && $_cart) $cartCount = $_cart->items->sum('quantity');
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 bg-gold text-navy text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">{{ $cartCount }}</span>
                        @endif
                    </a>

                    @auth
                        <div class="relative group">
                            <button class="flex items-center gap-2 text-white/80 hover:text-gold text-sm font-medium transition-colors py-1 pl-1">
                                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-navy font-bold text-xs">{{ substr(auth()->user()->name, 0, 1) }}</div>
                                <svg class="w-4 h-4 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-150 z-50">
                                <div class="px-4 py-2.5 border-b border-gray-100">
                                    <p class="text-xs font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                </div>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 text-sm text-amber-700 font-medium hover:bg-amber-50">⚙ Dashboard Admin</a>
                                @endif
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">Pesanan Saya</a>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">Profil Saya</a>
                                <div class="border-t border-gray-100">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 rounded-b-xl">Keluar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-white/80 hover:text-gold text-sm font-medium transition-colors hidden md:block">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-primary text-sm">Daftar</a>
                    @endauth
                    {{-- Mobile hamburger --}}
                    <button @click="mobileOpen = !mobileOpen" class="md:hidden text-white/80 hover:text-gold transition-colors p-1 ml-1">
                        <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>
        {{-- Mobile menu --}}
        <div x-show="mobileOpen" x-cloak class="md:hidden border-t border-white/10">
            <div class="px-4 pb-4 pt-3 space-y-1">
                <form action="{{ route('products.index') }}" method="GET" class="pb-2">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk khas Malang..."
                               class="w-full pl-4 pr-10 py-2.5 rounded-xl bg-white/10 text-white placeholder-white/50 border border-white/20 focus:outline-none focus:ring-1 focus:ring-gold text-sm">
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-white/60 hover:text-gold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </div>
                </form>
                <a href="{{ route('products.index') }}" class="block text-white/80 hover:text-gold text-sm font-medium py-2 transition-colors">Produk</a>
                @guest
                    <a href="{{ route('login') }}" class="block text-white/80 hover:text-gold text-sm font-medium py-2 transition-colors">Masuk</a>
                @endguest
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div id="flash-msg" class="fixed top-20 right-4 z-50 bg-emerald-500 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-2 text-sm font-medium transition-opacity duration-300">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div id="flash-msg" class="fixed top-20 right-4 z-50 bg-red-500 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-2 text-sm font-medium transition-opacity duration-300">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <main>@yield('content')</main>

    <footer class="bg-navy text-white mt-16">
        <div class="batik-bg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="md:col-span-2">
                        <div class="mb-4">
                            @if(file_exists(public_path('images/logo.png')))
                                <div class="bg-white rounded-lg px-4 py-2 inline-block">
                                    <img src="{{ asset('images/logo.png') }}" alt="malangan.com" class="h-9 w-auto">
                                </div>
                            @else
                                <div class="flex items-center gap-2">
                                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center font-display font-bold text-navy">M</div>
                                    <span class="font-display text-2xl font-bold text-white">malangan<span class="nav-gold">.com</span></span>
                                </div>
                            @endif
                        </div>
                        <p class="text-white/65 text-sm leading-relaxed mb-4">Platform belanja online terpercaya untuk produk asli dan souvenir khas Malang Raya. Dari hati pengrajin lokal, untuk seluruh Indonesia.</p>
                        <p class="text-white/50 text-xs">📍 Kota Malang, Jawa Timur &nbsp;|&nbsp; ✉ info@malangan.com</p>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gold mb-4">Kategori Produk</h4>
                        <ul class="space-y-2 text-sm text-white/65">
                            @foreach([['makanan-kuliner','Makanan & Kuliner'],['kerajinan-tangan','Kerajinan Tangan'],['topeng-kesenian','Topeng & Kesenian'],['batik-malang','Batik Malang'],['souvenir-aksesoris','Souvenir']] as [$slug, $name])
                                <li><a href="{{ route('products.index', ['category'=>$slug]) }}" class="hover:text-gold transition-colors">{{ $name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gold mb-4">Informasi</h4>
                        <ul class="space-y-2 text-sm text-white/65">
                            @foreach(\App\Models\Page::where('show_in_footer', true)->where('is_active', true)->orderBy('sort_order')->orderBy('title')->get() as $_footerPage)
                                <li><a href="{{ route('pages.show', $_footerPage->slug) }}" class="hover:text-gold transition-colors">{{ $_footerPage->title }}</a></li>
                            @endforeach
                            <li><a href="{{ route('login') }}" class="hover:text-gold transition-colors">Masuk / Daftar</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-white/10 mt-8 pt-6 text-center">
                    <p class="text-white/40 text-xs">© {{ date('Y') }} malangan.com &nbsp;·&nbsp; Bangga Produk Malang 🦅</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        const fm = document.getElementById('flash-msg');
        if(fm) setTimeout(() => { fm.style.opacity = '0'; setTimeout(() => fm.remove(), 300); }, 3500);
    </script>
    @stack('scripts')
</body>
</html>
