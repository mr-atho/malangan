@extends('admin.layout')
@section('title', 'Dashboard')

@section('admin-content')

{{-- Stats --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-5 mb-8">
    @php
        $statsConfig = [
            ['label' => 'Total Pesanan', 'key' => 'total_orders', 'icon' => '📦', 'color' => 'bg-blue-50 text-blue-600'],
            ['label' => 'Pendapatan', 'key' => 'total_revenue', 'icon' => '💰', 'color' => 'bg-emerald-50 text-emerald-600', 'format' => 'currency'],
            ['label' => 'Total Produk', 'key' => 'total_products', 'icon' => '🛍️', 'color' => 'bg-amber-50 text-amber-600'],
            ['label' => 'Pelanggan', 'key' => 'total_customers', 'icon' => '👥', 'color' => 'bg-purple-50 text-purple-600'],
        ];
    @endphp
    @foreach($statsConfig as $s)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 {{ $s['color'] }} rounded-xl flex items-center justify-center text-xl">{{ $s['icon'] }}</div>
        </div>
        <p class="text-2xl font-bold text-navy">
            @if(isset($s['format']) && $s['format'] === 'currency')
                Rp {{ number_format($stats[$s['key']], 0, ',', '.') }}
            @else
                {{ number_format($stats[$s['key']]) }}
            @endif
        </p>
        <p class="text-sm text-gray-500 mt-0.5">{{ $s['label'] }}</p>
    </div>
    @endforeach
</div>

<div class="grid lg:grid-cols-2 gap-6">
    {{-- Recent Orders --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-display font-bold text-navy">Pesanan Terbaru</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-xs text-navy hover:text-gold font-medium">Lihat semua →</a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($recentOrders as $order)
            <div class="px-6 py-3.5 flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-800">{{ $order->order_number }}</p>
                    <p class="text-xs text-gray-500">{{ $order->shipping_name }} · {{ $order->created_at->diffForHumans() }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-navy">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                    <span class="inline-block text-xs px-2 py-0.5 rounded-full bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-700 font-medium">{{ $order->status_label }}</span>
                </div>
            </div>
            @empty
                <p class="text-center py-8 text-sm text-gray-400">Belum ada pesanan</p>
            @endforelse
        </div>
    </div>

    {{-- Low Stock --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-display font-bold text-navy">⚠ Stok Menipis</h3>
            <a href="{{ route('admin.products.index') }}" class="text-xs text-navy hover:text-gold font-medium">Kelola →</a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($lowStockProducts as $product)
            <div class="px-6 py-3.5 flex items-center justify-between">
                <p class="text-sm font-medium text-gray-800 truncate max-w-48">{{ $product->name }}</p>
                <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $product->stock === 0 ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-700' }}">
                    {{ $product->stock === 0 ? 'Habis' : $product->stock . ' sisa' }}
                </span>
            </div>
            @empty
                <p class="text-center py-8 text-sm text-gray-400">Semua stok aman ✓</p>
            @endforelse
        </div>
    </div>
</div>

@endsection
