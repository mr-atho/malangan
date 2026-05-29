# Malangan.com

Platform e-commerce produk lokal khas Malang Raya — souvenir, kuliner, kerajinan, dan batik.

## Tech Stack

- **Backend:** Laravel 12 (PHP 8.2)
- **Frontend:** Blade + Tailwind CSS
- **Database:** MySQL (production), SQLite (opsional lokal)
- **Build tool:** Vite
- **Deploy:** GitHub Actions → SSH/rsync → Hostinger

## Fitur

- Katalog produk dengan kategori dan pencarian
- Keranjang belanja & checkout
- Manajemen pesanan (customer & admin)
- Autentikasi dengan verifikasi OTP via email
- Notifikasi email (pesanan masuk, update status, selamat datang)
- Panel admin: produk, kategori, pesanan, stok, banner, halaman, pengguna
- Halaman statis dinamis (About, Kebijakan, dll)

## Kategori Produk

Makanan & Kuliner · Kerajinan Tangan · Topeng & Kesenian · Batik Malang · Buah & Produk Alam · Souvenir & Aksesoris

## Instalasi

```bash
# Clone repository
git clone https://github.com/mr-atho/malangan.git
cd malangan

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Buat database MySQL, lalu sesuaikan .env:
# DB_DATABASE=laravel_malangan
# DB_USERNAME=root
# DB_PASSWORD=

# Jalankan migrasi + seeder
php artisan migrate --seed

# Build assets
npm run build
```

## Menjalankan Aplikasi

```bash
# Terminal 1 — dev server
php artisan serve --port=8080

# Terminal 2 — asset watcher (opsional)
npm run dev
```

Akses di: `http://localhost:8080`

## Akun Default (Seeder)

| Role     | Email                      | Password   |
|----------|----------------------------|------------|
| Admin    | admin@malangan.com         | password   |
| Customer | pelanggan@malangan.com     | password   |

## Deploy

Deploy otomatis via GitHub Actions setiap push ke branch `main`.

Pipeline: build Composer & Vite → rsync ke Hostinger → `migrate --force` → cache config/route/view.

**GitHub Secrets yang dibutuhkan:**

| Secret            | Keterangan                  |
|-------------------|-----------------------------|
| `SSH_PRIVATE_KEY` | Private key SSH ke Hostinger |
| `SSH_HOST`        | Hostname server              |
| `SSH_PORT`        | Port SSH                     |
| `SSH_USERNAME`    | Username Hostinger           |

## Design System

- **Warna:** Navy `#1e3a5f`, Gold `#c8a96e`, Background `gray-50`
- **Font:** Playfair Display (judul), Inter (body)
- **Motif:** Batik Malangan sebagai dekorator background

## Struktur Utama

```
app/
├── Http/Controllers/
│   ├── Admin/          # Controller panel admin
│   └── Auth/           # Autentikasi & OTP
├── Models/             # Eloquent models
└── Notifications/      # Email notifications
database/
├── migrations/
└── seeders/
resources/views/
├── admin/              # Tampilan panel admin
├── layouts/            # Layout utama
└── components/         # Komponen Blade reusable
.github/workflows/
└── deploy.yml          # CI/CD GitHub Actions
```

## Lisensi

MIT
