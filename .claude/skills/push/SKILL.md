---
description: Commit semua perubahan dan push ke GitHub (origin main)
---

## Remote

```
https://github.com/mr-atho/malangan.git
Branch: main
```

---

## Langkah-langkah

### 1. Cek status perubahan

```bash
git status
git diff --stat
```

### 2. Stage file yang relevan

Stage file view, asset, dan config yang berubah. Jangan stage file sensitif (`.env`, `storage/`, `database/database.sqlite`).

```bash
git add resources/ tailwind.config.js .claude/
# Tambahkan file lain jika ada (routes/, app/, dll)
```

### 3. Commit dengan pesan deskriptif

Format pesan commit:
```
<type>: <ringkasan singkat>

- Bullet poin detail perubahan

Co-Authored-By: Claude Sonnet 4.6 <noreply@anthropic.com>
```

Type yang umum dipakai:
- `feat` — fitur baru
- `fix` — perbaikan bug
- `style` — perubahan visual/tema (bukan CSS fix)
- `refactor` — perubahan kode tanpa ubah perilaku
- `docs` — dokumentasi

```bash
git commit -m "$(cat <<'EOF'
feat: deskripsi perubahan

- Detail 1
- Detail 2

Co-Authored-By: Claude Sonnet 4.6 <noreply@anthropic.com>
EOF
)"
```

### 4. Push

```bash
git push origin main
```

---

## File yang biasanya TIDAK di-stage

| File/Folder | Alasan |
|---|---|
| `.env` | Credentials dan konfigurasi lokal |
| `database/database.sqlite` | Data lokal dev, bukan source code |
| `storage/app/public/` | Upload user, sudah di `.gitignore` |
| `vendor/` | Dependencies, sudah di `.gitignore` |
| `node_modules/` | Dependencies JS, sudah di `.gitignore` |

---

## Cek hasil push

```bash
git log --oneline -5
```
