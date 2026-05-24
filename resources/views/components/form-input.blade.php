@props(['label', 'name', 'type' => 'text', 'required' => false, 'value' => '', 'placeholder' => ''])
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1.5">
        {{ $label }}@if($required) *@endif
    </label>
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ $value }}"
        @if($required) required @endif
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        {{ $attributes->merge(['class' => 'w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20' . ($errors->has($name) ? ' border-red-300' : '')]) }}>
    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
