@extends('admin.layout')
@section('title', 'Tambah Produk')

@section('admin-content')
<div class="max-w-3xl">
    <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-500 hover:text-navy mb-6 inline-flex items-center gap-1">← Kembali ke daftar produk</a>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        <x-card>
            <h3 class="font-display font-bold text-navy mb-5">Informasi Produk</h3>
            <div class="grid sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <x-form-input label="Nama Produk" name="name" :value="old('name')" :required="true" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori *</label>
                    <select name="category_id" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 bg-white">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <x-form-input label="Asal Produk" name="origin" :value="old('origin')" placeholder="Contoh: Kota Malang" />
                <x-form-input label="Harga (Rp)" name="price" type="number" :value="old('price')" :required="true" min="0" />
                <x-form-input label="Harga Coret (Rp)" name="original_price" type="number" :value="old('original_price')" min="0" />
                <x-form-input label="Stok" name="stock" type="number" :value="old('stock', 0)" :required="true" min="0" />
                <x-form-input label="Berat" name="weight" :value="old('weight')" placeholder="250gr" />
                <div class="sm:col-span-2">
                    <x-form-input label="Deskripsi Singkat" name="short_description" :value="old('short_description')" />
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi Lengkap *</label>
                    <textarea name="description" rows="5" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 resize-none">{{ old('description') }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Foto Produk (Thumbnail)</label>
                    <input type="file" name="thumbnail" accept="image/*" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none">
                </div>
            </div>
        </x-card>

        <x-card>
            <h3 class="font-display font-bold text-navy mb-4">Pengaturan</h3>
            <div class="flex flex-wrap gap-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="accent-navy w-4 h-4">
                    <span class="text-sm font-medium text-gray-700">Aktif (tampil di toko)</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="accent-navy w-4 h-4">
                    <span class="text-sm font-medium text-gray-700">Produk Unggulan</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_bestseller" value="1" {{ old('is_bestseller') ? 'checked' : '' }} class="accent-navy w-4 h-4">
                    <span class="text-sm font-medium text-gray-700">Produk Terlaris</span>
                </label>
            </div>
        </x-card>

        <div class="flex gap-3">
            <button type="submit" class="bg-gold text-navy font-semibold px-6 py-2.5 rounded-xl text-sm hover:opacity-90">Simpan Produk</button>
            <a href="{{ route('admin.products.index') }}" class="border border-gray-200 text-gray-600 px-6 py-2.5 rounded-xl text-sm hover:border-gray-300">Batal</a>
        </div>
    </form>
</div>
@endsection
