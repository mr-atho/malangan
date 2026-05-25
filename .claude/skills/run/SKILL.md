---
description: Launch malangan.com Laravel dev server
---

## Launch

```bash
cd "/Users/tsmtpng/Documents/01_Atho's Docs/04_Web Development/Apps/malangan"

php artisan serve --port=8080 > /tmp/laravel.log 2>&1 &
echo "Laravel PID: $!"
```

Wait 2-3 seconds, then smoke test:

```bash
curl -s -o /dev/null -w "%{http_code}" http://127.0.0.1:8080
```

Expected: `200`

## URLs

- **App**: http://127.0.0.1:8080

## Test accounts

- Admin: `admin@malangan.com` / `password`
- Customer: `pelanggan@malangan.com` / `password`

## Notes

- Port 8080 dipakai karena port 8000 biasanya sudah dipakai app lain.
- SQLite digunakan untuk development (tidak perlu setup database terpisah).
- Logs Laravel: `/tmp/laravel.log`
