@props(['thumbnail' => null, 'icon' => '🛍️'])
<div {{ $attributes->merge(['class' => 'rounded-xl bg-amber-50 flex items-center justify-center overflow-hidden flex-shrink-0']) }}>
    @if($thumbnail)
        <img src="{{ asset('storage/' . $thumbnail) }}" alt="" class="w-full h-full object-cover">
    @else
        <span class="text-2xl">{{ $icon }}</span>
    @endif
</div>
