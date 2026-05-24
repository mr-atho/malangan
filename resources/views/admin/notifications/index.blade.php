@extends('admin.layout')
@section('title', 'Notifikasi')

@section('admin-content')
<div class="flex items-center justify-between mb-5">
    <p class="text-sm text-gray-400">{{ $notifications->total() }} notifikasi</p>
    <div class="flex gap-2">
        <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST">
            @csrf @method('PATCH')
            <button class="text-xs border border-gray-200 text-gray-500 hover:text-navy px-3 py-1.5 rounded-lg transition-colors">
                Tandai Semua Dibaca
            </button>
        </form>
        <form action="{{ route('admin.notifications.destroy-all') }}" method="POST"
              onsubmit="return confirm('Hapus semua notifikasi?')">
            @csrf @method('DELETE')
            <button class="text-xs border border-red-100 text-red-400 hover:text-red-600 px-3 py-1.5 rounded-lg transition-colors">
                Hapus Semua
            </button>
        </form>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    @forelse($notifications as $notif)
    @php
        $data = $notif->data;
        $isUnread = is_null($notif->read_at);
        $icon = match($data['type'] ?? '') {
            'order_placed'         => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-600', 'emoji' => '🛒'],
            'order_status_updated' => ['bg' => 'bg-blue-100',    'text' => 'text-blue-600',    'emoji' => '📦'],
            default                => ['bg' => 'bg-gray-100',    'text' => 'text-gray-500',    'emoji' => '🔔'],
        };
    @endphp
    <div class="px-6 py-4 flex items-start gap-4 border-b border-gray-50 {{ $isUnread ? 'bg-blue-50/40' : '' }}">
        <div class="w-10 h-10 {{ $icon['bg'] }} rounded-full flex items-center justify-center flex-shrink-0 text-lg">
            {{ $icon['emoji'] }}
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm text-gray-800 {{ $isUnread ? 'font-semibold' : '' }}">
                {{ $data['message'] ?? 'Notifikasi baru' }}
            </p>
            @if(isset($data['order_number']))
            <a href="{{ route('admin.orders.show', $data['order_id'] ?? '#') }}"
               class="text-xs text-navy hover:underline mt-0.5 inline-block">
                Lihat Pesanan #{{ $data['order_number'] }} →
            </a>
            @endif
            <p class="text-xs text-gray-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
        </div>
        <div class="flex items-center gap-2 flex-shrink-0">
            @if($isUnread)
                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
            @endif
            <form action="{{ route('admin.notifications.destroy', $notif->id) }}" method="POST">
                @csrf @method('DELETE')
                <button class="text-gray-300 hover:text-red-400 transition-colors p-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="text-center py-16">
        <p class="text-4xl mb-3">🔔</p>
        <p class="text-gray-400 text-sm">Belum ada notifikasi</p>
    </div>
    @endforelse
</div>

@if($notifications->hasPages())
<div class="mt-4">{{ $notifications->links() }}</div>
@endif
@endsection
