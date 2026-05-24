@extends('admin.layout')
@section('title', 'Manajemen Kategori')

@section('admin-content')
<div class="grid lg:grid-cols-2 gap-6">
    {{-- Form Tambah --}}
    <x-card>
        <h3 class="font-display font-bold text-navy mb-5">Tambah Kategori Baru</h3>
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <x-form-input label="Nama Kategori" name="name" :value="old('name')" :required="true" />
            <x-form-input label="Icon (emoji)" name="icon" :value="old('icon')" placeholder="🛍️" />
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
                <textarea name="description" rows="2" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 resize-none">{{ old('description') }}</textarea>
            </div>
            <x-form-input label="Urutan Tampil" name="sort_order" type="number" :value="old('sort_order', 0)" min="0" />
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" checked class="accent-navy w-4 h-4">
                <span class="text-sm font-medium text-gray-700">Aktif</span>
            </label>
            <button type="submit" class="w-full bg-gold text-navy font-semibold py-2.5 rounded-xl text-sm hover:opacity-90">Tambah Kategori</button>
        </form>
    </x-card>

    {{-- List Kategori --}}
    <x-card :flush="true">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-display font-bold text-navy">Daftar Kategori</h3>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($categories as $cat)
            <div class="px-6 py-4 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3 min-w-0">
                    <span class="text-2xl flex-shrink-0">{{ $cat->icon }}</span>
                    <div class="min-w-0">
                        <p class="font-medium text-sm text-gray-800">{{ $cat->name }}</p>
                        <p class="text-xs text-gray-400">{{ $cat->products_count }} produk · urutan: {{ $cat->sort_order }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <x-status-badge :status="$cat->is_active ? 'active' : 'inactive'" />
                    <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-400 hover:text-red-600 text-xs px-2 py-1 border border-red-100 rounded-lg hover:border-red-200 transition-colors">Hapus</button>
                    </form>
                </div>
            </div>
            @empty
            <p class="text-center py-10 text-sm text-gray-400">Belum ada kategori</p>
            @endforelse
        </div>
    </x-card>
</div>
@endsection
