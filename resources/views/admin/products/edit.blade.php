@extends('admin.layout')
@section('title', 'Edit Produk')

@section('admin-content')
<a href="{{ route('admin.products.index') }}" class="text-sm text-gray-500 hover:text-navy mb-6 inline-flex items-center gap-1">← Kembali</a>


<div class="grid md:grid-cols-3 gap-6 items-start mt-4">

    {{-- Kolom Kiri: Form --}}
    <div class="md:col-span-2 space-y-5">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-display font-bold text-navy mb-5">Edit Produk</h3>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Produk *</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori *</label>
                        <select name="category_id" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 bg-white">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Asal Produk</label>
                        <input type="text" name="origin" value="{{ old('origin', $product->origin) }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Harga (Rp) *</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Harga Coret (Rp)</label>
                        <input type="number" name="original_price" value="{{ old('original_price', $product->original_price) }}" min="0" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Stok *</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Berat</label>
                        <input type="text" name="weight" value="{{ old('weight', $product->weight) }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi Singkat</label>
                        <input type="text" name="short_description" value="{{ old('short_description', $product->short_description) }}" maxlength="500" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi Lengkap *</label>
                        <textarea name="description" rows="5" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 resize-none">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-display font-bold text-navy mb-4">Pengaturan</h3>
                <div class="flex flex-wrap gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="accent-navy w-4 h-4">
                        <span class="text-sm font-medium text-gray-700">Aktif</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="accent-navy w-4 h-4">
                        <span class="text-sm font-medium text-gray-700">Produk Unggulan</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_bestseller" value="1" {{ old('is_bestseller', $product->is_bestseller) ? 'checked' : '' }} class="accent-navy w-4 h-4">
                        <span class="text-sm font-medium text-gray-700">Produk Terlaris</span>
                    </label>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-gold text-navy font-semibold px-6 py-2.5 rounded-xl text-sm hover:opacity-90">Simpan Perubahan</button>
                <a href="{{ route('admin.products.index') }}" class="border border-gray-200 text-gray-600 px-6 py-2.5 rounded-xl text-sm hover:border-gray-300">Batal</a>
            </div>
        </form>
    </div>

    {{-- Kolom Kanan: Gambar Carousel --}}
    <div class="lg:sticky lg:top-24 space-y-4">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h3 class="font-display font-bold text-navy mb-0.5">Gambar Carousel</h3>
            <p class="text-xs text-gray-400 mb-4">Klik bintang untuk jadikan gambar utama (thumbnail). Hover untuk hapus.</p>

            {{-- Existing images --}}
            @if($product->images->isNotEmpty())
            <div class="grid grid-cols-3 gap-2 mb-4">
                @foreach($product->images as $img)
                <div class="relative group">
                    <img src="{{ asset('storage/'.$img->image) }}" alt=""
                         class="w-full aspect-square object-cover rounded-xl border-2 transition-colors {{ $img->is_primary ? 'border-gold' : 'border-gray-200' }}">

                    {{-- Set as primary --}}
                    @if(!$img->is_primary)
                    <form action="{{ route('admin.products.images.primary', [$product, $img]) }}" method="POST"
                          class="absolute top-1 left-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        @csrf @method('PATCH')
                        <button type="submit" title="Jadikan gambar utama"
                                class="w-7 h-7 bg-gold hover:bg-yellow-400 text-navy rounded-full flex items-center justify-center shadow-md transition-colors">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </button>
                    </form>
                    @endif

                    {{-- Badge utama --}}
                    @if($img->is_primary)
                        <span class="absolute top-1 left-1 bg-gold text-navy text-[10px] px-1.5 py-0.5 rounded font-bold leading-none flex items-center gap-0.5">
                            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            Utama
                        </span>
                    @endif

                    {{-- Delete --}}
                    <form action="{{ route('admin.products.images.destroy', [$product, $img]) }}" method="POST"
                          onsubmit="return confirm('Hapus gambar ini?')"
                          class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        @csrf @method('DELETE')
                        <button type="submit" title="Hapus gambar"
                                class="w-7 h-7 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center shadow-md transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
            @else
                <p class="text-sm text-gray-400 mb-4 text-center py-6 border-2 border-dashed border-gray-100 rounded-xl">Belum ada gambar carousel</p>
            @endif

            {{-- Upload --}}
            <form action="{{ route('admin.products.images.store', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tambah Gambar</label>
                <input type="file" name="images[]" accept="image/*" multiple required
                       class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm mb-2">
                <button type="submit"
                        class="w-full bg-navy text-white font-medium py-2.5 rounded-xl text-sm hover:opacity-90">
                    Upload Gambar
                </button>
                <p class="text-xs text-gray-400 mt-1.5 text-center">Bisa pilih lebih dari satu. Maks 2MB/file.</p>
            </form>
        </div>
    </div>

</div>
@endsection
