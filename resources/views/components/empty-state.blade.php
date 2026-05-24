@props(['emoji' => '📭', 'title', 'description' => '', 'actionLabel' => null, 'actionHref' => null])
<div class="text-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100">
    <div class="text-7xl mb-4">{{ $emoji }}</div>
    <h3 class="font-display text-xl font-bold text-gray-700 mb-2">{{ $title }}</h3>
    @if($description)
        <p class="text-gray-500 text-sm mb-6">{{ $description }}</p>
    @endif
    @if($actionLabel && $actionHref)
        <a href="{{ $actionHref }}" class="btn-primary text-sm">{{ $actionLabel }}</a>
    @endif
    {{ $slot }}
</div>
