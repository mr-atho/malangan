@props(['items' => []])
<div class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center gap-2 text-sm text-gray-500">
        @foreach($items as $item)
            @if(!$loop->last)
                <a href="{{ $item['url'] }}" class="hover:text-navy">{{ $item['label'] }}</a>
                <span>/</span>
            @else
                <span class="text-navy font-medium truncate max-w-xs">{{ $item['label'] }}</span>
            @endif
        @endforeach
    </div>
</div>
