@extends('emails.layout')
@section('subject', 'Selamat Datang di malangan.com!')

@section('content')
<h2 style="margin:0 0 8px;font-size:22px;color:#1B4332;font-weight:700;">Selamat Datang, {{ $name }}! 🎉</h2>
<p style="margin:0 0 24px;font-size:15px;color:#6b7280;">Akun Anda telah berhasil diverifikasi.</p>

<p style="margin:0 0 20px;font-size:15px;color:#374151;line-height:1.6;">
  Terima kasih telah bergabung di <strong>malangan.com</strong> — toko oleh-oleh dan produk khas Malang terpercaya.
  Kini Anda bisa mulai menjelajahi ratusan produk asli Malang dan berbelanja dengan mudah.
</p>

<table width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 28px;">
  <tr>
    <td style="background:#f8f6f0;border-radius:12px;padding:20px 24px;">
      <p style="margin:0 0 12px;font-size:14px;font-weight:600;color:#1B4332;">Yang bisa Anda lakukan:</p>
      <table cellpadding="0" cellspacing="0">
        <tr><td style="padding:4px 0;font-size:14px;color:#374151;">🍜 &nbsp;Temukan produk kuliner khas Malang</td></tr>
        <tr><td style="padding:4px 0;font-size:14px;color:#374151;">🎭 &nbsp;Koleksi topeng dan kerajinan tangan</td></tr>
        <tr><td style="padding:4px 0;font-size:14px;color:#374151;">🧵 &nbsp;Batik Malangan motif eksklusif</td></tr>
        <tr><td style="padding:4px 0;font-size:14px;color:#374151;">🎁 &nbsp;Souvenir dan aksesoris khas Malang</td></tr>
      </table>
    </td>
  </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 20px;">
  <tr>
    <td align="center">
      <a href="{{ url('/produk') }}" style="display:inline-block;background:#D4C5A9;color:#1B4332;font-weight:700;font-size:15px;padding:14px 36px;border-radius:50px;text-decoration:none;">
        Mulai Belanja →
      </a>
    </td>
  </tr>
</table>

<p style="margin:0;font-size:13px;color:#9ca3af;text-align:center;">
  Ada pertanyaan? Hubungi kami di <a href="mailto:info@malangan.com" style="color:#1B4332;">info@malangan.com</a>
</p>
@endsection
