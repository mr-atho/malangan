@extends('admin.layout')
@section('title', 'Edit: ' . $page->title)

@section('admin-content')
<div class="max-w-4xl">
    <div class="mb-4">
        <a href="{{ route('admin.pages.index') }}" class="text-sm text-gray-400 hover:text-navy flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Halaman
        </a>
    </div>

    <form action="{{ route('admin.pages.update', $page) }}" method="POST" class="space-y-5">
        @csrf @method('PATCH')

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Judul Halaman *</label>
                <input type="text" name="title" required value="{{ old('title', $page->title) }}"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20">
                <p class="text-xs text-gray-400 mt-1">URL: <span class="font-mono">/halaman/{{ $page->slug }}</span> (slug tidak berubah saat edit)</p>
                @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Meta Deskripsi <span class="text-gray-400 font-normal">(untuk SEO, maks 255 karakter)</span></label>
                <input type="text" name="meta_description" maxlength="255" value="{{ old('meta_description', $page->meta_description) }}"
                    placeholder="Deskripsi singkat halaman ini..."
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20">
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor Urut</label>
                    <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $page->sort_order) }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20">
                    <p class="text-xs text-gray-400 mt-1">Urutan tampil di menu footer (kecil = lebih atas).</p>
                </div>
                <div class="flex flex-col justify-end gap-3 pb-0.5">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $page->is_active) ? 'checked' : '' }} class="accent-navy w-4 h-4">
                        <span class="text-sm font-medium text-gray-700">Halaman aktif</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="show_in_footer" value="1" {{ old('show_in_footer', $page->show_in_footer) ? 'checked' : '' }} class="accent-navy w-4 h-4">
                        <span class="text-sm font-medium text-gray-700">Tampilkan di menu footer</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                Konten Halaman *
                <span class="text-gray-400 font-normal ml-1">(HTML diperbolehkan)</span>
            </label>
            <textarea name="content" rows="28" required
                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-navy/20 resize-y">{{ old('content', $page->content) }}</textarea>
            @error('content')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="bg-gold text-navy font-semibold px-6 py-2.5 rounded-xl text-sm hover:opacity-90 transition-opacity">
                Simpan Perubahan
            </button>
            <a href="{{ url('/halaman/' . $page->slug) }}" target="_blank"
               class="text-sm text-gray-500 hover:text-navy border border-gray-200 px-4 py-2.5 rounded-xl transition-colors">
                Preview ↗
            </a>
        </div>
    </form>
</div>
@endsection
