@props(['flush' => false])
<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl shadow-sm border border-gray-100' . ($flush ? '' : ' p-6')]) }}>
    {{ $slot }}
</div>
