@props([
    'action',
    'placeholder' => 'Cari...',
    'value'       => null,
    'resetUrl'    => null,
    'variant'     => 'admin', // 'admin' | 'frontend'
    'append'      => null,    // slot untuk elemen tambahan (select, dll) setelah input
])

@php
    $val      = $value ?? request('search', '');
    $hasValue = $val !== '' && $val !== null;

    $inputClass = $variant === 'frontend'
        ? 'input-search'
        : 'input-admin pl-10 ' . ($hasValue && $resetUrl ? 'pr-9' : '');

    $btnClass = $variant === 'frontend'
        ? 'px-6 py-3 bg-navy text-white text-sm font-semibold rounded-xl hover:bg-[#2d4a6b] transition-colors shadow-sm whitespace-nowrap'
        : 'px-6 py-2.5 bg-navy text-white text-sm font-semibold rounded-xl hover:bg-[#2d4a6b] transition-colors shadow-sm whitespace-nowrap';
@endphp

<form action="{{ $action }}" method="GET" class="flex gap-3">
    {{ $slot }}

    <div class="relative flex-1">
        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input type="text"
               name="search"
               value="{{ $val }}"
               placeholder="{{ $placeholder }}"
               class="{{ $inputClass }}">
        @if($hasValue && $resetUrl)
            <a href="{{ $resetUrl }}"
               class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-300 hover:text-gray-500 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </a>
        @endif
    </div>

    @if($append)
        {{ $append }}
    @endif

    <button type="submit" class="{{ $btnClass }}">Cari</button>

    @if($hasValue && $resetUrl && $variant === 'admin')
        <a href="{{ $resetUrl }}"
           class="px-5 py-2.5 bg-white border border-gray-200 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors whitespace-nowrap">
            Reset
        </a>
    @endif
</form>
