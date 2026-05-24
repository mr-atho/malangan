@extends('admin.layout')
@section('title', 'Manajemen Halaman')

@section('admin-content')
<div class="flex items-center justify-between mb-5">
    <div>
        <p class="text-sm text-gray-400 mt-0.5">Kelola halaman informasi dan pengaturan menu footer</p>
    </div>
    <a href="{{ route('admin.pages.create') }}" class="bg-gold text-navy font-semibold px-4 py-2 rounded-xl text-sm hover:opacity-90 transition-opacity flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Halaman
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-3 border-b border-gray-100 bg-gray-50 grid grid-cols-12 gap-4 text-xs font-semibold text-gray-400 uppercase tracking-wide">
        <div class="col-span-1 text-center">Urutan</div>
        <div class="col-span-4">Halaman</div>
        <div class="col-span-2 text-center">Status</div>
        <div class="col-span-2 text-center">Menu Footer</div>
        <div class="col-span-3 text-right">Aksi</div>
    </div>

    <div class="divide-y divide-gray-50">
        @forelse($pages as $page)
        <div class="px-6 py-4 grid grid-cols-12 gap-4 items-center">
            <div class="col-span-1 text-center text-sm font-mono text-gray-400">{{ $page->sort_order }}</div>

            <div class="col-span-4 min-w-0">
                <p class="font-semibold text-gray-800 text-sm">{{ $page->title }}</p>
                <p class="text-xs text-gray-400 font-mono mt-0.5 truncate">/halaman/{{ $page->slug }}</p>
            </div>

            <div class="col-span-2 text-center">
                <span class="text-xs px-2 py-0.5 rounded-full {{ $page->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                    {{ $page->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>

            <div class="col-span-2 text-center">
                <span class="text-xs px-2 py-0.5 rounded-full {{ $page->show_in_footer ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-400' }}">
                    {{ $page->show_in_footer ? 'Tampil' : 'Disembunyikan' }}
                </span>
            </div>

            <div class="col-span-3 flex items-center justify-end gap-2">
                <a href="{{ url('/halaman/' . $page->slug) }}" target="_blank"
                   class="text-xs text-gray-400 hover:text-navy px-2.5 py-1.5 border border-gray-200 rounded-lg transition-colors">
                    Lihat ↗
                </a>
                <a href="{{ route('admin.pages.edit', $page) }}"
                   class="text-xs bg-navy text-white px-2.5 py-1.5 rounded-lg hover:bg-navy/90 transition-colors">
                    Edit
                </a>
                <form action="{{ route('admin.pages.destroy', $page) }}" method="POST"
                      onsubmit="return confirm('Hapus halaman \"{{ $page->title }}\"? Tindakan ini tidak bisa dibatalkan.')">
                    @csrf @method('DELETE')
                    <button class="text-xs text-red-400 hover:text-red-600 px-2.5 py-1.5 border border-red-100 rounded-lg transition-colors">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @empty
        <p class="text-center py-12 text-sm text-gray-400">Belum ada halaman. <a href="{{ route('admin.pages.create') }}" class="text-navy underline">Buat halaman pertama.</a></p>
        @endforelse
    </div>
</div>

<div class="mt-4 bg-blue-50 border border-blue-200 rounded-xl px-5 py-3 text-sm text-blue-700 flex items-start gap-2">
    <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
    <span>Halaman yang diaktifkan <strong>Menu Footer</strong> akan otomatis muncul di bagian "Informasi" footer website, diurutkan berdasarkan nomor urut.</span>
</div>
@endsection
