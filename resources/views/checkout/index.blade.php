@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="font-display text-3xl font-bold text-navy mb-8">Checkout</h1>

    <form action="{{ route('checkout.store') }}" method="POST"
        x-data="{
            shippingType: '{{ old('shipping_type', 'local') }}',
            paymentMethod: '{{ old('payment_method', 'transfer') }}',
            subtotal: {{ $cart->total }},
            get shippingCost() {
                if (this.shippingType === 'pickup') return 0;
                if (this.shippingType === 'local') return 15000;
                return 0;
            },
            get total() { return this.subtotal + this.shippingCost; },
            get shippingLabel() {
                if (this.shippingType === 'pickup') return 'Gratis';
                if (this.shippingType === 'local') return 'Rp 15.000';
                return 'Dikonfirmasi admin';
            },
            get totalLabel() {
                if (this.shippingType === 'outside') return 'Belum termasuk ongkir';
                return 'Rp ' + this.total.toLocaleString('id-ID');
            }
        }">
        @csrf

        <div class="grid md:grid-cols-3 gap-6">
            <div class="md:col-span-2 space-y-5">

                {{-- Metode Pengiriman --}}
                <x-card>
                    <h2 class="font-display text-lg font-bold text-navy mb-5">🚚 Metode Pengiriman</h2>
                    <div class="space-y-3">
                        <label class="flex items-start gap-4 p-4 border-2 rounded-xl cursor-pointer transition-colors"
                            :class="shippingType === 'pickup' ? 'border-navy bg-navy/5' : 'border-gray-200 hover:border-gray-300'">
                            <input type="radio" name="shipping_type" value="pickup" x-model="shippingType" class="accent-navy mt-0.5">
                            <div class="flex-1">
                                <p class="font-semibold text-sm text-gray-800">🏪 Ambil di Toko</p>
                                <p class="text-xs text-gray-500 mt-0.5">Ambil langsung ke toko kami di Malang — <span class="font-semibold text-emerald-600">Gratis ongkir</span></p>
                                <p class="text-xs text-gray-400 mt-1">Jl. Contoh No. 12, Kota Malang (dikonfirmasi setelah pesan)</p>
                            </div>
                        </label>
                        <label class="flex items-start gap-4 p-4 border-2 rounded-xl cursor-pointer transition-colors"
                            :class="shippingType === 'local' ? 'border-navy bg-navy/5' : 'border-gray-200 hover:border-gray-300'">
                            <input type="radio" name="shipping_type" value="local" x-model="shippingType" class="accent-navy mt-0.5">
                            <div class="flex-1">
                                <p class="font-semibold text-sm text-gray-800">📍 Pengiriman Dalam Kota Malang</p>
                                <p class="text-xs text-gray-500 mt-0.5">Malang Kota & Kabupaten — <span class="font-semibold text-navy">Flat Rp 15.000</span></p>
                                <p class="text-xs text-gray-400 mt-1">Pengiriman 1–2 hari, dikemas aman untuk barang pecah belah</p>
                            </div>
                        </label>
                        <label class="flex items-start gap-4 p-4 border-2 rounded-xl cursor-pointer transition-colors"
                            :class="shippingType === 'outside' ? 'border-navy bg-navy/5' : 'border-gray-200 hover:border-gray-300'">
                            <input type="radio" name="shipping_type" value="outside" x-model="shippingType" class="accent-navy mt-0.5">
                            <div class="flex-1">
                                <p class="font-semibold text-sm text-gray-800">🚛 Pengiriman Luar Kota</p>
                                <p class="text-xs text-gray-500 mt-0.5">Ke seluruh Indonesia — <span class="font-semibold text-amber-600">Ongkir dikonfirmasi admin</span></p>
                                <p class="text-xs text-gray-400 mt-1">Admin menghubungi via WhatsApp untuk konfirmasi ongkir & kurir</p>
                            </div>
                        </label>
                    </div>

                    <div x-show="shippingType === 'outside'" x-transition class="mt-4 bg-amber-50 border border-amber-200 rounded-xl p-4 text-sm text-amber-800">
                        <p class="font-semibold mb-1">ℹ️ Cara kerja pengiriman luar kota:</p>
                        <ol class="list-decimal list-inside space-y-1 text-xs text-amber-700">
                            <li>Buat pesanan sekarang (total belum termasuk ongkir)</li>
                            <li>Admin menghubungi kamu via WhatsApp untuk konfirmasi ongkir & kurir yang aman</li>
                            <li>Setelah setuju, lakukan pembayaran (subtotal + ongkir)</li>
                            <li>Barang dikemas khusus dan dikirim</li>
                        </ol>
                    </div>
                </x-card>

                {{-- Info Kontak (selalu tampil) --}}
                <x-card>
                    <h2 class="font-display text-lg font-bold text-navy mb-5">👤 Informasi Kontak</h2>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama *</label>
                            <input type="text" name="shipping_name" value="{{ old('shipping_name', auth()->user()->name) }}" required
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 @error('shipping_name') border-red-300 @enderror">
                            @error('shipping_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor HP *</label>
                            <input type="text" name="shipping_phone" value="{{ old('shipping_phone', auth()->user()->phone) }}" required
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 @error('shipping_phone') border-red-300 @enderror">
                            @error('shipping_phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </x-card>

                {{-- Alamat Pengiriman (hanya jika bukan ambil di toko) --}}
                <div x-show="shippingType !== 'pickup'" x-transition>
                    <x-card>
                        <h2 class="font-display text-lg font-bold text-navy mb-5">📦 Alamat Pengiriman</h2>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Kota *</label>
                                <input type="text" name="shipping_city" value="{{ old('shipping_city') }}"
                                    placeholder="Contoh: Malang"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20">
                                @error('shipping_city')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Provinsi *</label>
                                <input type="text" name="shipping_province" value="{{ old('shipping_province', 'Jawa Timur') }}"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20">
                                @error('shipping_province')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Kode Pos *</label>
                                <input type="text" name="shipping_postal_code" value="{{ old('shipping_postal_code') }}"
                                    placeholder="65111"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20">
                                @error('shipping_postal_code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat Lengkap *</label>
                                <textarea name="shipping_address" rows="3"
                                    placeholder="Jl. ..., RT/RW, Kelurahan, Kecamatan"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20 resize-none">{{ old('shipping_address', auth()->user()->address) }}</textarea>
                                @error('shipping_address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </x-card>
                </div>

                {{-- Metode Pembayaran --}}
                <x-card>
                    <h2 class="font-display text-lg font-bold text-navy mb-5">💳 Metode Pembayaran</h2>
                    <div class="space-y-3">
                        <label class="flex items-center gap-4 p-4 border-2 rounded-xl cursor-pointer transition-colors"
                            :class="paymentMethod === 'transfer' ? 'border-navy bg-navy/5' : 'border-gray-200 hover:border-gray-300'">
                            <input type="radio" name="payment_method" value="transfer" x-model="paymentMethod" class="accent-navy">
                            <div>
                                <p class="font-semibold text-sm text-gray-800">🏦 Transfer Bank</p>
                                <p class="text-xs text-gray-500">BCA / BNI / Mandiri — konfirmasi via WhatsApp</p>
                            </div>
                        </label>
                        <label x-show="shippingType !== 'pickup'" class="flex items-center gap-4 p-4 border-2 rounded-xl cursor-pointer transition-colors"
                            :class="paymentMethod === 'cod' ? 'border-navy bg-navy/5' : 'border-gray-200 hover:border-gray-300'">
                            <input type="radio" name="payment_method" value="cod" x-model="paymentMethod" class="accent-navy">
                            <div>
                                <p class="font-semibold text-sm text-gray-800">💵 COD (Bayar di Tempat)</p>
                                <p class="text-xs text-gray-500">Bayar tunai saat paket tiba</p>
                            </div>
                        </label>
                        <label x-show="shippingType === 'pickup'" class="flex items-center gap-4 p-4 border-2 rounded-xl cursor-pointer transition-colors"
                            :class="paymentMethod === 'store' ? 'border-navy bg-navy/5' : 'border-gray-200 hover:border-gray-300'">
                            <input type="radio" name="payment_method" value="store" x-model="paymentMethod" class="accent-navy">
                            <div>
                                <p class="font-semibold text-sm text-gray-800">🏪 Bayar di Toko</p>
                                <p class="text-xs text-gray-500">Bayar langsung saat mengambil pesanan di toko</p>
                            </div>
                        </label>
                    </div>
                </x-card>

                {{-- Catatan --}}
                <x-card>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">📝 Catatan (opsional)</label>
                    <input type="text" name="notes" value="{{ old('notes') }}" placeholder="Catatan khusus untuk penjual..."
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-navy/20">
                </x-card>

            </div>

            {{-- Order Summary --}}
            <div>
                <x-card class="sticky top-24">
                    <h3 class="font-display text-lg font-bold text-navy mb-5">Ringkasan Pesanan</h3>
                    <div class="space-y-3 text-sm max-h-48 overflow-y-auto pr-1">
                        @foreach($cart->items as $item)
                        <div class="flex gap-3">
                            <x-product-image class="w-10 h-10"
                                :thumbnail="$item->product->thumbnail"
                                :icon="$item->product->category->icon ?? '🛍️'" />
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-700 line-clamp-2">{{ $item->product->name }}</p>
                                <p class="text-xs text-gray-400">×{{ $item->quantity }}</p>
                            </div>
                            <p class="text-xs font-semibold text-navy flex-shrink-0">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                        </div>
                        @endforeach
                    </div>
                    <div class="border-t border-gray-100 mt-4 pt-4 space-y-2 text-sm">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Ongkos Kirim</span>
                            <span x-text="shippingLabel" class="font-medium"></span>
                        </div>
                        <div class="flex justify-between font-bold text-navy pt-2 border-t border-gray-100 text-base">
                            <span>Total</span>
                            <span x-text="totalLabel"></span>
                        </div>
                        <p x-show="shippingType === 'outside'" class="text-xs text-amber-600 text-right">*ongkir dikonfirmasi admin</p>
                    </div>
                    <button type="submit" class="btn-primary w-full mt-5 text-sm py-3 text-center block">
                        Buat Pesanan →
                    </button>
                    <p class="text-xs text-gray-400 text-center mt-3">Dengan memesan, kamu menyetujui syarat & ketentuan kami</p>
                </x-card>
            </div>

        </div>
    </form>
</div>
@endsection
