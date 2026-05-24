<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        Banner::truncate();

        $banners = [
            [
                'title'       => 'Keindahan Malang di Tanganmu',
                'subtitle'    => 'Ribuan produk souvenir, kuliner, dan kerajinan asli dari pengrajin lokal Malang.',
                'link'        => '/produk',
                'button_text' => 'Belanja Sekarang',
                'is_active'   => true,
                'sort_order'  => 1,
                'bg'          => [0x1B, 0x43, 0x32],
                'accent'      => [0xD4, 0xC5, 0xA9],
                'emoji'       => '🎭',
            ],
            [
                'title'       => 'Topeng Malangan — Warisan Budaya',
                'subtitle'    => 'Topeng kayu buatan tangan pengrajin asli Malang dengan ukiran penuh makna.',
                'link'        => '/produk?category=topeng-kesenian',
                'button_text' => 'Lihat Koleksi',
                'is_active'   => true,
                'sort_order'  => 2,
                'bg'          => [0x0D, 0x1F, 0x18],
                'accent'      => [0xD4, 0xC5, 0xA9],
                'emoji'       => '🏺',
            ],
            [
                'title'       => 'Apel & Olahan Khas Batu',
                'subtitle'    => 'Produk segar dan olahan apel Manalagi langsung dari kebun di Kota Batu.',
                'link'        => '/produk?category=buah-produk-alam',
                'button_text' => 'Jelajahi Produk',
                'is_active'   => true,
                'sort_order'  => 3,
                'bg'          => [0x6B, 0x8F, 0x71],
                'accent'      => [0xFF, 0xFF, 0xFF],
                'emoji'       => '🍎',
            ],
        ];

        Storage::disk('public')->makeDirectory('banners');

        foreach ($banners as $data) {
            $filename = 'banners/banner-' . $data['sort_order'] . '.png';
            $path     = Storage::disk('public')->path($filename);

            $this->generatePlaceholder($path, $data['bg'], $data['accent'], $data['title'], $data['emoji']);

            Banner::create([
                'title'       => $data['title'],
                'subtitle'    => $data['subtitle'],
                'image'       => $filename,
                'link'        => $data['link'],
                'button_text' => $data['button_text'],
                'is_active'   => $data['is_active'],
                'sort_order'  => $data['sort_order'],
            ]);
        }
    }

    private function generatePlaceholder(string $path, array $bg, array $accent, string $label, string $emoji): void
    {
        $w = 1200;
        $h = 480;
        $im = imagecreatetruecolor($w, $h);

        // Gradient background (left → right, dark variant on right)
        for ($x = 0; $x < $w; $x++) {
            $ratio = $x / $w;
            $r = (int) ($bg[0] * (1 - $ratio * 0.35));
            $g = (int) ($bg[1] * (1 - $ratio * 0.35));
            $b = (int) ($bg[2] * (1 - $ratio * 0.35));
            $col = imagecolorallocate($im, $r, $g, $b);
            imageline($im, $x, 0, $x, $h, $col);
        }

        // Subtle grid pattern overlay
        $grid = imagecolorallocatealpha($im, $accent[0], $accent[1], $accent[2], 120);
        for ($x = 0; $x < $w; $x += 40) {
            imageline($im, $x, 0, $x, $h, $grid);
        }
        for ($y = 0; $y < $h; $y += 40) {
            imageline($im, 0, $y, $w, $y, $grid);
        }

        // Label text
        $textColor = imagecolorallocate($im, $accent[0], $accent[1], $accent[2]);
        $font = 5;
        $textX = 60;
        $textY = $h / 2 - 20;
        imagestring($im, $font, $textX, $textY, $emoji . '  ' . mb_substr(strip_tags($label), 0, 40), $textColor);
        imagestring($im, 3, $textX, $textY + 28, 'malangan.com — Produk Khas Malang', $textColor);

        imagepng($im, $path);
        imagedestroy($im);
    }
}
