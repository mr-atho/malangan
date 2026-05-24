@extends('emails.layout')
@section('subject', 'Update Pesanan #' . $order->order_number)

@section('content')
@php
$configs = [
    'pending'    => ['icon' => '🕐', 'color' => '#f59e0b', 'bg' => '#fffbeb', 'desc' => 'Pesanan Anda sedang menunggu konfirmasi dari tim kami.'],
    'processing' => ['icon' => '⚙️', 'color' => '#3b82f6', 'bg' => '#eff6ff', 'desc' => 'Pesanan Anda sedang kami proses dan disiapkan untuk pengiriman.'],
    'shipped'    => ['icon' => '🚚', 'color' => '#8b5cf6', 'bg' => '#f5f3ff', 'desc' => 'Pesanan Anda sudah dalam perjalanan menuju alamat tujuan.'],
    'delivered'  => ['icon' => '✅', 'color' => '#10b981', 'bg' => '#ecfdf5', 'desc' => 'Pesanan Anda telah diterima. Terima kasih sudah berbelanja di malangan.com!'],
    'cancelled'  => ['icon' => '❌', 'color' => '#ef4444', 'bg' => '#fef2f2', 'desc' => 'Pesanan Anda telah dibatalkan. Hubungi kami jika ada pertanyaan.'],
];
$cfg = $configs[$order->status] ?? ['icon' => '📦', 'color' => '#6b7280', 'bg' => '#f9fafb', 'desc' => ''];
@endphp

<h2 style="margin:0 0 8px;font-size:22px;color:#1B4332;font-weight:700;">Update Status Pesanan</h2>
<p style="margin:0 0 24px;font-size:15px;color:#6b7280;">Halo, <strong>{{ $name }}</strong>!</p>

<table width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 24px;background:{{ $cfg['bg'] }};border-radius:12px;border-left:4px solid {{ $cfg['color'] }};">
  <tr><td style="padding:20px 24px;">
    <p style="margin:0 0 6px;font-size:28px;">{{ $cfg['icon'] }}</p>
    <p style="margin:0 0 4px;font-size:18px;font-weight:700;color:{{ $cfg['color'] }};">{{ $label }}</p>
    <p style="margin:0;font-size:14px;color:#374151;">{{ $cfg['desc'] }}</p>
  </td></tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 20px;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
  <tr style="background:#f8f8f8;">
    <td style="padding:10px 20px;font-size:13px;color:#6b7280;">No. Pesanan</td>
    <td style="padding:10px 20px;font-size:13px;font-weight:700;color:#1B4332;text-align:right;">#{{ $order->order_number }}</td>
  </tr>
  <tr>
    <td style="padding:10px 20px;font-size:13px;color:#6b7280;">Subtotal</td>
    <td style="padding:10px 20px;font-size:13px;color:#374151;text-align:right;">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
  </tr>
  <tr style="background:#f8f8f8;">
    <td style="padding:10px 20px;font-size:13px;color:#6b7280;">Ongkos Kirim</td>
    <td style="padding:10px 20px;font-size:13px;color:#374151;text-align:right;">
      @if($order->shipping_type === 'pickup')
        Gratis
      @elseif($order->shipping_type === 'outside' && $order->shipping_cost == 0)
        <span style="color:#d97706;font-weight:600;">Menunggu konfirmasi</span>
      @else
        Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
      @endif
    </td>
  </tr>
  <tr>
    <td style="padding:10px 20px;font-size:13px;font-weight:700;color:#1B4332;">Total</td>
    <td style="padding:10px 20px;font-size:13px;font-weight:700;color:#1B4332;text-align:right;">
      @if($order->shipping_type === 'outside' && $order->shipping_cost == 0)
        <span style="color:#d97706;">Belum termasuk ongkir</span>
      @else
        Rp {{ number_format($order->total, 0, ',', '.') }}
      @endif
    </td>
  </tr>
  @if($order->status === 'shipped')
  <tr style="background:#f8f8f8;">
    <td style="padding:10px 20px;font-size:13px;color:#6b7280;">Dikirim pada</td>
    <td style="padding:10px 20px;font-size:13px;color:#374151;text-align:right;">{{ $order->shipped_at?->format('d F Y, H:i') }} WIB</td>
  </tr>
  @endif
  @if($order->status === 'delivered')
  <tr style="background:#f8f8f8;">
    <td style="padding:10px 20px;font-size:13px;color:#6b7280;">Diterima pada</td>
    <td style="padding:10px 20px;font-size:13px;color:#374151;text-align:right;">{{ $order->delivered_at?->format('d F Y, H:i') }} WIB</td>
  </tr>
  @endif
</table>

@if($order->shipping_type === 'outside' && $order->shipping_cost == 0)
<table width="100%" cellpadding="0" cellspacing="0" style="margin:-8px 0 20px;background:#fffbeb;border-radius:12px;border-left:4px solid #f59e0b;">
  <tr><td style="padding:14px 20px;font-size:13px;color:#92400e;">
    ℹ️ <strong>Ongkir belum dikonfirmasi.</strong> Tim kami akan menghubungi kamu via WhatsApp ke nomor <strong>{{ $order->shipping_phone }}</strong> untuk konfirmasi ongkos kirim sebelum pesanan diproses.
  </td></tr>
</table>
@endif

<table width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 20px;">
  <tr>
    <td align="center">
      <a href="{{ url('/pesanan/' . $order->order_number) }}" style="display:inline-block;background:#1B4332;color:#ffffff;font-weight:700;font-size:15px;padding:14px 36px;border-radius:50px;text-decoration:none;">
        Lihat Pesanan →
      </a>
    </td>
  </tr>
</table>

<p style="margin:0;font-size:13px;color:#9ca3af;text-align:center;">
  Ada pertanyaan? Balas email ini atau hubungi <a href="mailto:info@malangan.com" style="color:#1B4332;">info@malangan.com</a>
</p>
@endsection
