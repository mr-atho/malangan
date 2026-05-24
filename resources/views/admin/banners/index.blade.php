@extends('admin.layout')
@section('title', 'Manajemen Banner')

@section('admin-content')
<div class="grid lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-display font-bold text-navy mb-5">Tambah Banner Baru</h3>
        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Judul *</label>
                <input type="text" name="title" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Subjudul</label>
                <input type="text" name="subtitle" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Gambar Banner *</label>
                <input type="file" name="image" accept="image/*" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Link (URL)</label>
                <input type="text" name="link" placeholder="/produk" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Teks Tombol</label>
                <input type="text" name="button_text" placeholder="Belanja Sekarang" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20">
            </div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" checked class="accent-navy w-4 h-4">
                <span class="text-sm font-medium text-gray-700">Aktif</span>
            </label>
            <button type="submit" class="w-full bg-gold text-navy font-semibold py-2.5 rounded-xl text-sm hover:opacity-90">Upload Banner</button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-display font-bold text-navy">Banner Aktif</h3>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($banners as $banner)
            <div class="p-5 flex gap-4">
                <div class="w-20 h-14 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                    <img src="{{ asset('storage/'.$banner->image) }}" alt="" class="w-full h-full object-cover">
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-sm text-gray-800">{{ $banner->title }}</p>
                    @if($banner->subtitle)<p class="text-xs text-gray-500 truncate">{{ $banner->subtitle }}</p>@endif
                    <span class="text-xs px-2 py-0.5 rounded-full mt-1 inline-block {{ $banner->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">{{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                </div>
                <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" onsubmit="return confirm('Hapus banner?')" class="flex-shrink-0">
                    @csrf @method('DELETE')
                    <button class="text-red-400 hover:text-red-600 text-xs px-2 py-1 border border-red-100 rounded-lg">Hapus</button>
                </form>
            </div>
            @empty
            <p class="text-center py-10 text-sm text-gray-400">Belum ada banner</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
