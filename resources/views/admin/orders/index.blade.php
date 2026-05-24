@extends('admin.layout')
@section('title', 'Manajemen Pesanan')

@section('admin-content')
{{-- Filter Status --}}
<div class="flex gap-2 mb-5 flex-wrap">
    @foreach([''=>'Semua', 'pending'=>'Menunggu', 'processing'=>'Diproses', 'shipped'=>'Dikirim', 'delivered'=>'Terkirim', 'cancelled'=>'Dibatalkan'] as $val => $label)
    <a href="{{ route('admin.orders.index', $val ? ['status'=>$val] : []) }}" class="px-4 py-1.5 rounded-full text-sm font-medium border transition-colors {{ request('status')===$val ? 'bg-navy text-white border-navy' : 'bg-white text-gray-600 border-gray-200 hover:border-navy' }}">{{ $label }}</a>
    @endforeach
</div>

<x-card :flush="true">
    <div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase">No. Pesanan</th>
                <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase hidden md:table-cell">Pelanggan</th>
                <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Total</th>
                <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($orders as $order)
            <tr class="hover:bg-gray-50/50">
                <td class="px-5 py-3.5">
                    <p class="font-semibold text-gray-800">{{ $order->order_number }}</p>
                    <p class="text-xs text-gray-400">{{ $order->created_at->format('d M Y') }}</p>
                </td>
                <td class="px-4 py-3.5 hidden md:table-cell">
                    <p class="font-medium text-gray-700">{{ $order->shipping_name }}</p>
                    <p class="text-xs text-gray-400">{{ $order->user?->email }}</p>
                </td>
                <td class="px-4 py-3.5 font-bold text-navy">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                <td class="px-4 py-3.5 text-center">
                    <x-status-badge :status="$order->status">{{ $order->status_label }}</x-status-badge>
                </td>
                <td class="px-5 py-3.5 text-right">
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-navy hover:text-gold text-xs font-medium px-3 py-1.5 border border-gray-200 rounded-lg hover:border-gold transition-colors">Detail</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center py-12 text-gray-400">Tidak ada pesanan</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
    <div class="px-5 py-4 border-t border-gray-100">{{ $orders->links() }}</div>
</x-card>
@endsection
