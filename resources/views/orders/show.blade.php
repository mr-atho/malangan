@extends('layouts.app')
@section('title', 'Detail Pesanan ' . $order->order_number)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('orders.index') }}" class="text-gray-400 hover:text-navy transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h1 class="font-display text-2xl font-bold text-navy">Detail Pesanan</h1>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-4 mb-6 flex items-center gap-3 text-sm">
            <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Status Card --}}
    <x-card class="mb-5">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <p class="text-sm text-gray-500 mb-1">Nomor Pesanan</p>
                <p class="font-bold text-navy text-lg">{{ $order->order_number }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $order->created_at->format('d F Y, H:i') }}</p>
            </div>
            <x-status-badge :status="$order->status" class="px-4 py-1.5 text-sm">{{ $order->status_label }}</x-status-badge>
        </div>

        {{-- Progress --}}
        <div class="mt-6">
            @php
                $steps = ['pending' => 0, 'processing' => 1, 'shipped' => 2, 'delivered' => 3];
                $currentStep = $steps[$order->status] ?? 0;
            @endphp
            <div class="flex items-center">
                @foreach(['Dipesan','Diproses','Dikirim','Terkirim'] as $i => $label)
                    <div class="flex flex-col items-center flex-1 {{ $i > 0 ? 'relative' : '' }}">
                        @if($i > 0)
                            <div class="absolute left-0 right-0 top-3 h-0.5 -translate-y-1/2 {{ $i <= $currentStep ? 'bg-navy' : 'bg-gray-200' }}" style="left:-50%;right:50%;"></div>
                        @endif
                        <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs z-10 {{ $i <= $currentStep ? 'bg-navy text-white' : 'bg-gray-200 text-gray-400' }}">
                            {{ $i <= $currentStep ? '✓' : ($i+1) }}
                        </div>
                        <p class="text-xs mt-1 text-center {{ $i <= $currentStep ? 'text-navy font-medium' : 'text-gray-400' }}">{{ $label }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </x-card>

    {{-- Items --}}
    <x-card class="mb-5">
        <h3 class="font-display font-bold text-navy mb-4">Produk Dipesan</h3>
        <div class="space-y-4">
            @foreach($order->items as $item)
            <div class="flex gap-4">
                <x-product-image class="w-14 h-14" :thumbnail="$item->product_thumbnail" icon="🛍️" />
                <div class="flex-1">
                    <p class="font-medium text-sm text-gray-800">{{ $item->product_name }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                </div>
                <p class="font-bold text-navy text-sm">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
            </div>
            @endforeach
        </div>
        <div class="border-t border-gray-100 mt-5 pt-4 space-y-2 text-sm">
            <div class="flex justify-between text-gray-600"><span>Subtotal</span><span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span></div>
            <div class="flex justify-between text-gray-600">
                <span>Ongkos Kirim</span>
                <span>
                    @if($order->shipping_type === 'pickup') Gratis
                    @elseif($order->shipping_type === 'outside' && $order->shipping_cost == 0) <span class="text-amber-500 text-xs">Menunggu konfirmasi</span>
                    @else Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                    @endif
                </span>
            </div>
            <div class="flex justify-between font-bold text-navy text-base pt-2 border-t border-gray-100"><span>Total</span><span>Rp {{ number_format($order->total, 0, ',', '.') }}</span></div>
        </div>
    </x-card>

    {{-- Info Resi / Tracking (jika sudah dikirim) --}}
    @if($order->tracking_number)
    <x-card class="mb-5">
        <h3 class="font-display font-bold text-navy mb-4">🚚 Info Pengiriman</h3>
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
            <div class="flex items-start justify-between gap-4 flex-wrap">
                <div>
                    <p class="text-xs text-blue-500 font-medium mb-1">Nomor Resi</p>
                    <p class="font-bold text-blue-800 text-xl tracking-widest">{{ $order->tracking_number }}</p>
                    <p class="text-sm text-blue-600 mt-1">Kurir: <span class="font-semibold">{{ $order->courier }}</span></p>
                </div>
                @if($order->tracking_url)
                <a href="{{ $order->tracking_url }}" target="_blank" rel="noopener"
                    class="flex-shrink-0 bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-700 transition-colors">
                    Lacak Paket →
                </a>
                @else
                <div class="text-sm text-blue-600">
                    <p>Lacak di website kurir:</p>
                    <p class="font-semibold">{{ $order->courier }}</p>
                </div>
                @endif
            </div>
        </div>
        <p class="text-xs text-gray-400 mt-3">* Update tracking mungkin memerlukan waktu beberapa jam setelah pengiriman</p>
    </x-card>
    @elseif($order->shipping_type === 'outside' && in_array($order->status, ['pending', 'processing']))
    <x-card class="mb-5">
        <div class="flex items-start gap-3">
            <span class="text-2xl">📞</span>
            <div>
                <p class="font-semibold text-gray-800 text-sm">Admin akan menghubungi kamu</p>
                <p class="text-xs text-gray-500 mt-0.5">Tim kami akan konfirmasi ongkir dan kurir via WhatsApp ke nomor <span class="font-medium">{{ $order->shipping_phone }}</span></p>
            </div>
        </div>
    </x-card>
    @endif

    {{-- Shipping & Payment Info --}}
    <div class="grid sm:grid-cols-2 gap-5">
        <x-card>
            <h3 class="font-display font-bold text-navy mb-3">
                {{ $order->shipping_type === 'pickup' ? '🏪 Ambil di Toko' : '📦 Alamat Pengiriman' }}
            </h3>
            <p class="text-sm font-semibold text-gray-800">{{ $order->shipping_name }}</p>
            <p class="text-sm text-gray-600 mt-1">{{ $order->shipping_phone }}</p>
            @if($order->shipping_type !== 'pickup')
                <p class="text-sm text-gray-600 mt-1">{{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}</p>
            @else
                <p class="text-sm text-gray-400 mt-1">Datang langsung ke toko kami. Admin akan konfirmasi alamat via WhatsApp.</p>
            @endif
        </x-card>
        <x-card>
            <h3 class="font-display font-bold text-navy mb-3">💳 Pembayaran</h3>
            <p class="text-sm text-gray-600">Metode:
                <span class="font-semibold text-gray-800">
                    {{ match($order->payment_method) { 'cod' => 'COD', 'store' => 'Bayar di Toko', default => 'Transfer Bank' } }}
                </span>
            </p>
            <p class="text-sm text-gray-600 mt-1">Status:
                <span class="font-semibold {{ $order->payment_status === 'paid' ? 'text-emerald-600' : 'text-amber-600' }}">
                    {{ $order->payment_status === 'paid' ? 'Lunas' : 'Belum Bayar' }}
                </span>
            </p>
            @if($order->notes)
                <p class="text-sm text-gray-600 mt-2 bg-gray-50 rounded-lg p-2">📝 {{ $order->notes }}</p>
            @endif
        </x-card>
    </div>
</div>
@endsection
