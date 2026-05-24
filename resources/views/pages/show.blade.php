@extends('layouts.app')
@section('title', $page->title)
@section('description', $page->meta_description ?? '')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-navy transition-colors">Beranda</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-600 font-medium">{{ $page->title }}</span>
    </nav>

    {{-- Header --}}
    <div class="batik-bg bg-navy rounded-3xl px-8 py-12 mb-10 text-center">
        <h1 class="font-display text-4xl font-bold text-gold mb-3">{{ $page->title }}</h1>
        @if($page->meta_description)
            <p class="text-white/70 text-base max-w-xl mx-auto">{{ $page->meta_description }}</p>
        @endif
    </div>

    {{-- Content --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-8 py-10 prose-content">
        {!! $page->content !!}
    </div>

    {{-- Footer nav --}}
    <div class="mt-8 flex flex-wrap gap-3 justify-center text-sm">
        <a href="{{ route('home') }}" class="text-gray-400 hover:text-navy transition-colors">← Kembali ke Beranda</a>
        <span class="text-gray-200">|</span>
        <a href="{{ route('products.index') }}" class="text-gray-400 hover:text-navy transition-colors">Lihat Produk</a>
    </div>
</div>
@endsection
