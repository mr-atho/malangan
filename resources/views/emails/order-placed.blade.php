@extends('emails.layout')
@section('subject', 'Pesanan #' . $order->order_number . ' Berhasil Dibuat')

@section('content')
<h2 style="margin:0 0 8px;font-size:22px;color:#1B4332;font-weight:700;">Pesanan Berhasil Dibuat!</h2>
<p style="margin:0 0 24px;font-size:15px;color:#6b7280;">Halo, <strong>{{ $name }}</strong>!</p>

<p style="margin:0 0 20px;font-size:15px;color:#374151;line-height:1.6;">
  Pesanan Anda telah kami terima dan sedang menunggu konfirmasi dari tim malangan.com.
  Kami akan memproses pesanan Anda dalam 1×24 jam.
</p>

{{-- Order Info --}}
<table width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 20px;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
  <tr style="background:#1B4332;">
    <td style="padding:12px 20px;font-size:13px;font-weight:600;color:#D4C5A9;">No. Pesanan</td>
    <td style="padding:12px 20px;font-size:13px;font-weight:700;color:#ffffff;text-align:right;">#{{ $order->order_number }}</td>
  </tr>
  <tr style="background:#f8f8f8;">
    <td style="padding:10px 20px;font-size:13px;color:#6b7280;">Tanggal</td>
    <td style="padding:10px 20px;font-size:13px;color:#374151;text-align:right;">{{ $order->created_at->format('d F Y, H:i') }} WIB</td>
  </tr>
  <tr>
    <td style="padding:10px 20px;font-size:13px;color:#6b7280;">Metode Bayar</td>
    <td style="padding:10px 20px;font-size:13px;color:#374151;text-align:right;">{{ $order->payment_method === 'cod' ? 'COD (Bayar di Tempat)' : 'Transfer Bank' }}</td>
  </tr>
</table>

{{-- Items --}}
<table width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 20px;">
  <tr style="background:#f8f8f8;">
    <td style="padding:10px 20px;font-size:12px;font-weight:600;color:#9ca3af;text-transform:uppercase;border-radius:8px 0 0 0;">Produk</td>
    <td style="padding:10px 20px;font-size:12px;font-weight:600;color:#9ca3af;text-align:right;border-radius:0 8px 0 0;">Subtotal</td>
  </tr>
  @foreach($order->items as $item)
  <tr style="border-bottom:1px solid #f3f4f6;">
    <td style="padding:10px 20px;font-size:14px;color:#374151;">
      {{ $item->product_name }}<br>
      <span style="font-size:12px;color:#9ca3af;">{{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</span>
    </td>
    <td style="padding:10px 20px;font-size:14px;color:#374151;text-align:right;font-weight:600;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
  </tr>
  @endforeach
  <tr style="background:#f8f8f8;">
    <td style="padding:10px 20px;font-size:13px;color:#6b7280;">Ongkos Kirim</td>
    <td style="padding:10px 20px;font-size:13px;color:#374151;text-align:right;">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
  </tr>
  <tr style="background:#1B4332;">
    <td style="padding:12px 20px;font-size:15px;font-weight:700;color:#D4C5A9;">Total</td>
    <td style="padding:12px 20px;font-size:15px;font-weight:700;color:#ffffff;text-align:right;">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
  </tr>
</table>

{{-- Shipping Address --}}
<table width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 24px;background:#f8f6f0;border-radius:12px;">
  <tr><td style="padding:16px 20px;">
    <p style="margin:0 0 8px;font-size:13px;font-weight:600;color:#1B4332;">📦 Dikirim ke:</p>
    <p style="margin:0;font-size:14px;color:#374151;line-height:1.6;">
      {{ $order->shipping_name }}<br>
      {{ $order->shipping_phone }}<br>
      {{ $order->shipping_address }}, {{ $order->shipping_city }},<br>
      {{ $order->shipping_province }} {{ $order->shipping_postal_code }}
    </p>
  </td></tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 20px;">
  <tr>
    <td align="center">
      <a href="{{ url('/pesanan/' . $order->order_number) }}" style="display:inline-block;background:#1B4332;color:#ffffff;font-weight:700;font-size:15px;padding:14px 36px;border-radius:50px;text-decoration:none;">
        Lihat Detail Pesanan →
      </a>
    </td>
  </tr>
</table>
@endsection
