@extends('layouts.app')
@section('title', $page->title)
@section('description', $page->meta_description ?? '')

@section('content')

{{-- Override warna konten DB agar sesuai tema --}}
<style>
    .prose-content .bg-emerald-50  { background-color: rgba(59,95,138,0.07) !important; }
    .prose-content .border-emerald-200 { border-color: rgba(59,95,138,0.18) !important; }
    .prose-content .text-emerald-800,
    .prose-content .text-emerald-700 { color: var(--navy) !important; }
    .prose-content .bg-blue-50     { background-color: var(--cream) !important; }
    .prose-content .border-blue-200 { border-color: #dde3ec !important; }
    .prose-content .text-blue-800,
    .prose-content .text-blue-700  { color: var(--navy) !important; }
    .prose-content .bg-purple-50   { background-color: #f4f3f0 !important; }
    .prose-content .border-purple-200 { border-color: #dde3ec !important; }
    .prose-content .text-purple-800,
    .prose-content .text-purple-700 { color: var(--navy) !important; }
    .prose-content .bg-gray-50     { background-color: var(--cream) !important; }

    .prose-content section          { margin-bottom: 2.5rem; }
    .prose-content h2               { font-family: 'Playfair Display', serif; font-size: 1.375rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem; }
    .prose-content h3               { font-size: 1rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem; }
    .prose-content p                { color: #6b7280; line-height: 1.75; }
    .prose-content strong           { color: #374151; font-weight: 600; }
    .prose-content a                { color: var(--navy); text-decoration: underline; }
    .prose-content a:hover          { color: var(--gold); }
    .prose-content ul li,
    .prose-content ol li            { color: #6b7280; }
</style>

<x-breadcrumb :items="[
    ['label' => 'Beranda', 'url' => route('home')],
    ['label' => $page->title],
]" />

{{-- Page header --}}
<div class="bg-cream border-b border-gray-100">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-14 text-center">
        <p class="text-xs font-semibold tracking-widest uppercase text-gold mb-3">malangan.com</p>
        <h1 class="font-display text-3xl md:text-4xl font-bold text-navy leading-tight">{{ $page->title }}</h1>
        @if($page->meta_description)
            <p class="text-gray-500 text-base mt-4 max-w-xl mx-auto leading-relaxed">{{ $page->meta_description }}</p>
        @endif
    </div>
</div>

{{-- Content --}}
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="prose-content">
        {!! $page->content !!}
    </div>

    {{-- Footer nav --}}
    <div class="mt-12 pt-8 border-t border-gray-100 flex items-center justify-between flex-wrap gap-4 text-sm">
        <a href="{{ route('home') }}"
           class="flex items-center gap-1.5 text-gray-400 hover:text-navy transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Beranda
        </a>
        <a href="{{ route('products.index') }}"
           class="flex items-center gap-1 font-semibold text-navy hover:text-gold transition-colors">
            Lihat Produk
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
</div>

@endsection
