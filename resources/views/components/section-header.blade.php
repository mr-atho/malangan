@props(['title', 'subtitle' => null, 'align' => 'center', 'linkHref' => null, 'linkText' => 'Lihat semua →'])
<div class="flex items-end {{ $align === 'center' ? 'flex-col text-center' : 'justify-between' }} mb-10">
    <div class="{{ $align === 'center' ? '' : '' }}">
        @if($subtitle)
            <p class="text-[10px] font-bold tracking-widest uppercase text-gold mb-2">{{ $subtitle }}</p>
        @endif
        <h2 class="font-display text-3xl md:text-4xl font-bold text-navy">{{ $title }}</h2>
    </div>
    @if($linkHref)
        <a href="{{ $linkHref }}" class="text-navy hover:text-gold font-medium text-sm transition-colors hidden md:block">{{ $linkText }}</a>
    @endif
</div>
