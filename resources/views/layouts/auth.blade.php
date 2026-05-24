<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Autentikasi') – malangan.com</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; color: #0D1F18; }
        .font-display { font-family: 'Playfair Display', serif; }
        .bg-navy  { background-color: #1B4332; }
        .text-navy { color: #1B4332; }
        .text-gold { color: #D4C5A9; }
        .bg-gold  { background-color: #D4C5A9; }
        .border-navy { border-color: #1B4332; }
        [x-cloak] { display:none !important; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4" style="background-color:#e8ede9;">

<div class="w-full max-w-md">

    {{-- Logo --}}
    <div class="text-center mb-7">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 group">
            @if(file_exists(public_path('images/logo.png')))
                <img src="{{ asset('images/logo.png') }}" alt="malangan.com" class="h-10 w-auto">
            @else
                <div class="w-10 h-10 bg-navy rounded-full flex items-center justify-center font-display font-bold text-white text-sm">M</div>
                <span class="font-display text-2xl font-bold text-navy">malangan<span class="text-spicy-pink">.com</span></span>
            @endif
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        @yield('content')
    </div>

    @hasSection('footer_link')
    <p class="text-center text-sm text-gray-500 mt-5">@yield('footer_link')</p>
    @endif

</div>

@stack('scripts')
</body>
</html>
