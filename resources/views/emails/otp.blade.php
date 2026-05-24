@extends('emails.layout')
@section('subject', 'Kode Verifikasi Email')

@section('content')
<h2 style="margin:0 0 8px;font-size:22px;color:#1B4332;font-weight:700;">Verifikasi Email Anda</h2>
<p style="margin:0 0 24px;font-size:15px;color:#6b7280;">Halo, <strong>{{ $name }}</strong>!</p>

<p style="margin:0 0 20px;font-size:15px;color:#374151;line-height:1.6;">
  Gunakan kode OTP berikut untuk memverifikasi alamat email Anda di <strong>malangan.com</strong>.
  Kode ini berlaku selama <strong>10 menit</strong>.
</p>

<table width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 24px;">
  <tr>
    <td align="center">
      <div style="display:inline-block;background:#1B4332;border-radius:12px;padding:20px 48px;">
        <span style="font-size:40px;font-weight:700;letter-spacing:12px;color:#D4C5A9;font-family:'Courier New',monospace;">{{ $otp }}</span>
      </div>
    </td>
  </tr>
</table>

<p style="margin:0 0 8px;font-size:13px;color:#9ca3af;text-align:center;">
  Jangan bagikan kode ini kepada siapapun, termasuk tim malangan.com.
</p>
<p style="margin:0;font-size:13px;color:#9ca3af;text-align:center;">
  Jika Anda tidak mendaftar di malangan.com, abaikan email ini.
</p>
@endsection
