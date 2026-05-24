@extends('layouts.app')
@section('title', 'Pesanan Saya')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="font-display text-3xl font-bold text-navy mb-8">Pesanan Saya</h1>

    @if($orders->isEmpty())
        <x-empty-state emoji="📦" title="Belum ada pesanan"
            description="Mulai belanja dan temukan produk khas Malang favoritmu!"
            actionLabel="Belanja Sekarang" actionHref="{{ route('products.index') }}" />
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
            <x-card :flush="true" class="overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="font-semibold text-navy text-sm">{{ $order->order_number }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <x-status-badge :status="$order->status">{{ $order->status_label }}</x-status-badge>
                </div>
                <div class="px-6 py-4">
                    <div class="flex flex-wrap gap-2 mb-3">
                        @foreach($order->items->take(3) as $item)
                            <span class="text-xs bg-gray-50 border border-gray-100 rounded-lg px-3 py-1 text-gray-600">{{ $item->product_name }} ×{{ $item->quantity }}</span>
                        @endforeach
                        @if($order->items->count() > 3)
                            <span class="text-xs text-gray-400">+{{ $order->items->count() - 3 }} produk lainnya</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="font-bold text-navy">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                        <a href="{{ route('orders.show', $order->order_number) }}" class="text-sm text-navy hover:text-gold font-medium transition-colors">Lihat Detail →</a>
                    </div>
                </div>
            </x-card>
            @endforeach
        </div>
        <div class="mt-6">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
