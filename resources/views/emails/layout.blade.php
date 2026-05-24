<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('subject') | malangan.com</title>
</head>
<body style="margin:0;padding:0;background:#f4f4f5;font-family:'Helvetica Neue',Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f5;padding:32px 16px;">
  <tr><td align="center">
    <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.08);">

      {{-- Header --}}
      <tr>
        <td style="background:#1B4332;padding:28px 40px;text-align:center;">
          <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
              <td align="center">
                <span style="display:inline-block;width:40px;height:40px;background:#ffffff;border-radius:50%;text-align:center;line-height:40px;font-weight:700;font-size:18px;color:#1B4332;vertical-align:middle;">M</span>
                <span style="font-size:22px;font-weight:700;color:#D4C5A9;margin-left:8px;vertical-align:middle;">malangan</span><span style="font-size:22px;font-weight:700;color:#ffffff;vertical-align:middle;">.com</span>
              </td>
            </tr>
          </table>
        </td>
      </tr>

      {{-- Body --}}
      <tr>
        <td style="padding:40px 40px 32px;">
          @yield('content')
        </td>
      </tr>

      {{-- Footer --}}
      <tr>
        <td style="background:#f8f8f8;border-top:1px solid #e5e7eb;padding:20px 40px;text-align:center;">
          <p style="margin:0;font-size:12px;color:#9ca3af;">Email ini dikirim otomatis oleh sistem malangan.com</p>
          <p style="margin:4px 0 0;font-size:12px;color:#9ca3af;">© {{ date('Y') }} malangan.com · Kota Malang, Jawa Timur</p>
        </td>
      </tr>

    </table>
  </td></tr>
</table>
</body>
</html>
