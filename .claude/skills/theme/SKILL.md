---
description: Update the visual theme of malangan.com (colors, fonts, layout style)
---

## Design system

All CSS variables and custom classes are defined in the `<style>` block of:

```
resources/views/layouts/app.blade.php
```

Current values:
```css
:root {
  --navy: #3B5F8A;    /* primary — dusty blue: navbar, headings, buttons */
  --gold: #D4956A;    /* accent — peach gold: labels, badges, hover states */
  --gold-dk: #C07A50; /* gold hover state */
  --cream: #F6F8FB;   /* section background alternator */
}
```

Fonts (loaded from Google Fonts in the same file):
- **Headings**: Playfair Display — class `font-display`
- **Body**: Inter

---

## How to change the theme color

### Step 1 — Update CSS variables (single source of truth)

Edit the `:root` block in `resources/views/layouts/app.blade.php`:

```css
:root {
  --navy: #NEW_PRIMARY;
  --gold: #NEW_ACCENT;
  --gold-dk: #NEW_ACCENT_DARK;  /* ~15% darker than --gold */
  --cream: #NEW_BG_ALT;
}
```

All Tailwind utility aliases (`text-navy`, `bg-navy`, `text-gold`, `bg-gold`, `btn-primary`, `btn-gold`, `btn-ghost`, `border-gold`, `bg-cream`) update automatically from these variables.

### Step 2 — Update hardcoded hover hex (navy darker shade)

The hover state for navy buttons is hardcoded as `hover:bg-[#2d4a6b]` (= navy darkened ~15%) in several files. When changing `--navy`, update this hex across **all** locations below:

| File | Line | What | Current value |
|---|---|---|---|
| `resources/views/products/show.blade.php` | ~233 | Add-to-cart button hover | `hover:bg-[#2d4a6b]` |
| `resources/views/products/index.blade.php` | ~128 | "Terapkan Filter" button hover | `hover:bg-[#2d4a6b]` |
| `resources/views/components/search-bar.blade.php` | 19–20 | Search "Cari" button hover (frontend + admin variants) | `hover:bg-[#2d4a6b]` |
| `resources/views/layouts/app.blade.php` | CSS block | `btn-primary:hover` rule | `background: #2d4a6b` |

> **Quick formula**: navy hover = navy hex with brightness reduced ~15%. E.g. `#3B5F8A` → `#2d4a6b`.

### Step 3 — Update hardcoded cream hex

Cream (`#FAF9F6` or `--cream`) appears hardcoded in some home sections. Update if changing `--cream`:

| File | Line | Context |
|---|---|---|
| `resources/views/home.blade.php` | ~10 | Hero right-panel decorative bg |
| `resources/views/home.blade.php` | ~173 | "Keunggulan Kami" section bg |
| `resources/views/home.blade.php` | ~271 | "Budaya & Kerajinan" section bg |

---

## Key files to edit when changing the theme

| What | File |
|---|---|
| **Color variables, button styles, card hover** | `resources/views/layouts/app.blade.php` — `<style>` block |
| **Navbar & footer HTML** | `resources/views/layouts/app.blade.php` |
| **Homepage layout & sections** | `resources/views/home.blade.php` |
| **Product card** | `resources/views/components/product-card.blade.php` |
| **Section header component** | `resources/views/components/section-header.blade.php` |
| **Search bar button hover** | `resources/views/components/search-bar.blade.php` |
| **Product detail page** | `resources/views/products/show.blade.php` |
| **Product catalog + filter drawer** | `resources/views/products/index.blade.php` |
| **Static page layout** | `resources/views/pages/show.blade.php` |

---

## Full color-change checklist

Run this checklist whenever the palette changes. Check off each item:

### CSS variables (auto-propagates to most elements)
- [ ] `--navy` in `layouts/app.blade.php` `:root`
- [ ] `--gold` in `layouts/app.blade.php` `:root`
- [ ] `--gold-dk` in `layouts/app.blade.php` `:root`
- [ ] `--cream` in `layouts/app.blade.php` `:root`

### Hardcoded navy-hover hex (`#2d4a6b`)
- [ ] `btn-primary:hover` CSS rule in `layouts/app.blade.php`
- [ ] Add-to-cart button in `products/show.blade.php` (`hover:bg-[#2d4a6b]`)
- [ ] "Terapkan Filter" button in `products/index.blade.php` (`hover:bg-[#2d4a6b]`)
- [ ] Search bar button in `components/search-bar.blade.php` (lines 19–20, `hover:bg-[#2d4a6b]`)

### Hardcoded cream hex (`#FAF9F6`)
- [ ] Hero panel in `home.blade.php` (~line 10, `bg-[#FAF9F6]`)
- [ ] "Keunggulan Kami" section in `home.blade.php` (~line 173, `bg-[#FAF9F6]`)
- [ ] "Budaya & Kerajinan" section in `home.blade.php` (~line 271, `bg-[#FAF9F6]`)

### DB-stored page content overrides (scoped to `.prose-content` in `pages/show.blade.php`)
These override Tailwind classes inside HTML stored in the database. Update if primary/accent colors change:
- [ ] `.bg-emerald-50` override → `rgba(R,G,B,0.07)` using new navy RGB
- [ ] `.border-emerald-200` override → `rgba(R,G,B,0.18)` using new navy RGB
- [ ] `.text-emerald-800`, `.text-emerald-700`, `.text-blue-800`, `.text-blue-700`, `.text-purple-800`, `.text-purple-700` → `var(--navy)`
- [ ] `.bg-blue-50` → `var(--cream)`
- [ ] `h2`, `h3`, `strong`, `a` color rules → `var(--navy)` / `var(--gold)`

---

## Current design style

- **Aesthetic**: Modern, premium, minimal
- **Background**: White `#ffffff` for main, cream `#F6F8FB` for alternating sections
- **Section headers**: Small gold uppercase label + large navy Playfair Display heading
- **Buttons**: `btn-primary` (navy pill), `btn-ghost` (outlined), `btn-gold` (gold pill)
- **Cards**: White, border-gray-100, hover lifts with shadow (`card-product` class)
- **Batik pattern**: SVG motif used in footer (`batik-bg` class)
- **Hero**: White bg, split 2-col layout, decorative cream panel on right side
- **Dark sections**: `bg-zinc-900` used intentionally for culture banners and CTA — these are decorative dark cards, not primary UI, leave as-is unless doing a full dark-mode change

---

## How to change fonts

In `layouts/app.blade.php`, update the Google Fonts `<link>` href and the `body` / `.font-display` CSS rules.
