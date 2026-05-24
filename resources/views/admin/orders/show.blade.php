@extends('admin.layout')
@section('title', 'Detail Pesanan')

@section('admin-content')
<div class="max-w-3xl">
    <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-500 hover:text-navy mb-6 inline-flex items-center gap-1">← Kembali ke pesanan</a>

    <div class="space-y-5">

        {{-- Header & Update Status --}}
        <x-card class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <p class="text-xs text-gray-500 mb-1">Nomor Pesanan</p>
                <p class="font-bold text-navy text-lg">{{ $order->order_number }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $order->created_at->format('d F Y, H:i') }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $order->shipping_type_label }}</p>
            </div>
            <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="flex items-center gap-2">
                @csrf @method('PATCH')
                <select name="status" style="min-width:140px" class="border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none bg-white">
                    @foreach(['pending'=>'Menunggu','processing'=>'Diproses','shipped'=>'Dikirim','delivered'=>'Terkirim','cancelled'=>'Dibatalkan'] as $val=>$label)
                        <option value="{{ $val }}" {{ $order->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-navy text-white px-5 py-2 rounded-xl text-sm font-medium hover:opacity-90 whitespace-nowrap">Update Status</button>
            </form>
        </x-card>

        {{-- Panel Pengiriman (selalu tampil jika bukan pickup) --}}
        @if($order->shipping_type !== 'pickup')
        <x-card>
            <h3 class="font-display font-bold text-navy mb-4">🚚 Pengiriman</h3>

            @if($order->shipping_type === 'outside' && $order->shipping_cost == 0)
            <div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 mb-4 text-sm text-amber-700">
                ⚠️ Ongkir belum dikonfirmasi — hubungi customer via WhatsApp lalu isi di bawah.
            </div>
            @endif

            <form action="{{ route('admin.orders.shipping', $order) }}" method="POST" class="space-y-4">
                @csrf @method('PATCH')

                {{-- Ongkir --}}
                <div class="grid sm:grid-cols-3 gap-3">
                    <div class="sm:col-span-1">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Ongkos Kirim (Rp)</label>
                        <input type="number" name="shipping_cost" min="0"
                            value="{{ $order->shipping_cost > 0 ? (int)$order->shipping_cost : '' }}"
                            placeholder="0"
                            class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20">
                    </div>
                    <div class="sm:col-span-1">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Kurir</label>
                        <select name="courier" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none bg-white">
                            <option value="">Pilih Kurir</option>
                            @foreach(['JNE', 'SiCepat', 'J&T', 'AnterAja', 'Tiki', 'Pos Indonesia'] as $c)
                                <option value="{{ $c }}" {{ $order->courier === $c ? 'selected' : '' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-1">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Nomor Resi</label>
                        <input type="text" name="tracking_number" value="{{ $order->tracking_number }}"
                            placeholder="Contoh: JNE123456789"
                            class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20">
                    </div>
                </div>

                <button type="submit" class="bg-navy text-white px-5 py-2 rounded-xl text-sm font-medium hover:opacity-90">
                    Simpan Info Pengiriman
                </button>
            </form>
        </x-card>
        @endif

        {{-- Item Pesanan --}}
        <x-card>
            <h3 class="font-display font-bold text-navy mb-4">Item Pesanan</h3>
            <div class="space-y-4">
                @foreach($order->items as $item)
                <div class="flex gap-4">
                    <x-product-image class="w-12 h-12" :thumbnail="$item->product_thumbnail" icon="🛍️" />
                    <div class="flex-1">
                        <p class="font-medium text-sm text-gray-800">{{ $item->product_name }}</p>
                        <p class="text-xs text-gray-500">{{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                    <p class="font-bold text-navy text-sm">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>
            <div class="border-t border-gray-100 mt-5 pt-4 space-y-2 text-sm">
                <div class="flex justify-between text-gray-600"><span>Subtotal</span><span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span></div>
                <div class="flex justify-between text-gray-600">
                    <span>Ongkos Kirim
                        @if($order->shipping_type === 'outside' && $order->shipping_cost == 0)
                            <span class="text-xs text-amber-500">(belum dikonfirmasi)</span>
                        @endif
                    </span>
                    <span>
                        @if($order->shipping_type === 'pickup') Gratis
                        @else Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                        @endif
                    </span>
                </div>
                <div class="flex justify-between font-bold text-navy"><span>Total</span><span>Rp {{ number_format($order->total, 0, ',', '.') }}</span></div>
            </div>
        </x-card>

        {{-- Alamat & Pembayaran --}}
        <div class="grid sm:grid-cols-2 gap-5">
            <x-card>
                <h3 class="font-display font-bold text-navy mb-3">
                    {{ $order->shipping_type === 'pickup' ? '🏪 Ambil di Toko' : '📦 Alamat Pengiriman' }}
                </h3>
                <p class="text-sm font-semibold text-gray-800">{{ $order->shipping_name }}</p>
                <p class="text-sm text-gray-600 mt-1">{{ $order->shipping_phone }}</p>
                @if($order->shipping_type !== 'pickup')
                    <p class="text-sm text-gray-600 mt-1 leading-relaxed">{{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}</p>
                @else
                    <p class="text-sm text-gray-400 mt-1">Customer akan datang langsung ke toko</p>
                @endif
            </x-card>
            <x-card>
                <h3 class="font-display font-bold text-navy mb-3">Info Pembayaran</h3>
                <p class="text-sm text-gray-600">Metode:
                    <span class="font-semibold text-gray-800">
                        {{ match($order->payment_method) { 'cod' => 'COD', 'store' => 'Bayar di Toko', default => 'Transfer Bank' } }}
                    </span>
                </p>
                <p class="text-sm text-gray-600 mt-1">Status: <span class="font-semibold {{ $order->payment_status === 'paid' ? 'text-emerald-600' : 'text-amber-600' }}">{{ $order->payment_status === 'paid' ? 'Lunas' : 'Belum Bayar' }}</span></p>
                @if($order->notes)<p class="text-sm text-gray-600 mt-2 bg-gray-50 rounded-lg p-2">📝 {{ $order->notes }}</p>@endif
            </x-card>
        </div>

    </div>
</div>
@endsection
