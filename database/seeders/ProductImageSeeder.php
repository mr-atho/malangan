<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Keripik Tempe Sanan Premium (id: 1)
            1 => [
                'thumbnail' => 'products/keripik-tempe-1.jpg',
                'images' => [
                    'products/keripik-tempe-1.jpg',
                    'products/keripik-tempe-2.jpg',
                    'products/keripik-tempe-3.jpg',
                ],
            ],
            // Bakwan Malang Siap Saji (id: 2)
            2 => [
                'thumbnail' => 'products/bakwan-malang-1.jpg',
                'images' => [
                    'products/bakwan-malang-1.jpg',
                    'products/bakwan-malang-2.jpg',
                    'products/bakwan-malang-3.jpg',
                ],
            ],
            // Gerabah Dinoyo Vas Bunga (id: 6)
            6 => [
                'thumbnail' => 'products/gerabah-dinoyo-1.jpg',
                'images' => [
                    'products/gerabah-dinoyo-1.jpg',
                    'products/gerabah-dinoyo-2.jpg',
                    'products/gerabah-dinoyo-3.jpg',
                    'products/gerabah-dinoyo-4.jpg',
                ],
            ],
            // Topeng Malangan Karakter Panji (id: 9)
            9 => [
                'thumbnail' => 'products/topeng-panji-1.jpg',
                'images' => [
                    'products/topeng-panji-1.jpg',
                    'products/topeng-panji-2.jpg',
                    'products/topeng-panji-3.jpg',
                ],
            ],
            // Batik Tulis Malangan Motif Tugu (id: 12)
            12 => [
                'thumbnail' => 'products/batik-tugu-1.jpg',
                'images' => [
                    'products/batik-tugu-1.jpg',
                    'products/batik-tugu-2.jpg',
                    'products/batik-tugu-3.jpg',
                ],
            ],
        ];

        foreach ($data as $productId => $config) {
            $product = Product::find($productId);
            if (!$product) continue;

            $product->update(['thumbnail' => $config['thumbnail']]);

            foreach ($config['images'] as $i => $path) {
                ProductImage::create([
                    'product_id' => $productId,
                    'image'      => $path,
                    'is_primary' => $i === 0,
                    'sort_order' => $i + 1,
                ]);
            }
        }
    }
}
