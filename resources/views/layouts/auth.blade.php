<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Autentikasi') – malangan.com</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --navy: #3B5F8A; --gold: #D4956A; --gold-dk: #C07A50; --cream: #F6F8FB; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; color: #1e2d3d; }
        .font-display { font-family: 'Playfair Display', serif; }
        .bg-navy  { background-color: var(--navy); }
        .text-navy { color: var(--navy); }
        .text-gold { color: var(--gold); }
        .bg-gold  { background-color: var(--gold); }
        .border-navy { border-color: var(--navy); }
        .hover\:text-gold:hover { color: var(--gold); }
        .icon-bg-navy { background-color: rgba(59,95,138,0.1); }
        .btn-auth {
            display: block;
            width: 100%;
            background: var(--navy);
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            letter-spacing: 0.02em;
        }
        .btn-auth:hover { background: #2d4a6b; box-shadow: 0 10px 25px -5px rgba(59,95,138,0.3); transform: translateY(-0.5px); }
        .input-auth {
            display: block;
            width: 100%;
            padding: 0.625rem 0.875rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            color: #111827;
            background-color: #fff;
            transition: border-color 0.15s, box-shadow 0.15s;
            outline: none;
        }
        .input-auth:focus { border-color: var(--navy); box-shadow: 0 0 0 3px rgba(59,95,138,0.15); }
        .input-auth.is-error { border-color: #ef4444; }
        .input-otp {
            display: block;
            width: 100%;
            padding: 0.875rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
            letter-spacing: 0.5em;
            color: var(--navy);
            background-color: #f9fafb;
            transition: border-color 0.15s, box-shadow 0.15s;
            outline: none;
        }
        .input-otp:focus { border-color: var(--navy); box-shadow: 0 0 0 3px rgba(59,95,138,0.15); background-color: #fff; }
        [x-cloak] { display:none !important; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4" style="background-color:var(--cream, #F6F8FB);">

<div class="w-full max-w-md">

    {{-- Logo --}}
    <div class="text-center mb-7">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 group">
            @if(file_exists(public_path('images/logo.png')))
                <img src="{{ asset('images/logo.png') }}" alt="malangan.com" class="h-10 w-auto">
            @else
                <div class="w-10 h-10 bg-navy rounded-full flex items-center justify-center font-display font-bold text-white text-sm">M</div>
                <span class="font-display text-2xl font-bold text-navy">malangan<span class="text-gold">.com</span></span>
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
