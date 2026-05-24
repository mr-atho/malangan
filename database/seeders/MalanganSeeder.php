<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MalanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Categories
        $categories = [
            ['name' => 'Makanan & Kuliner', 'slug' => 'makanan-kuliner', 'icon' => '🍜', 'description' => 'Oleh-oleh kuliner khas Malang - keripik tempe, bakpao, bakwan, dan lainnya.', 'sort_order' => 1],
            ['name' => 'Kerajinan Tangan', 'slug' => 'kerajinan-tangan', 'icon' => '🏺', 'description' => 'Kerajinan unik khas pengrajin Malang - gerabah Dinoyo, anyaman, dan ukiran.', 'sort_order' => 2],
            ['name' => 'Topeng & Kesenian', 'slug' => 'topeng-kesenian', 'icon' => '🎭', 'description' => 'Topeng Malangan asli dan produk kesenian budaya lokal.', 'sort_order' => 3],
            ['name' => 'Batik Malang', 'slug' => 'batik-malang', 'icon' => '👘', 'description' => 'Batik motif khas Malang - Malangan, Singosari, dan motif alam Malang.', 'sort_order' => 4],
            ['name' => 'Buah & Produk Alam', 'slug' => 'buah-produk-alam', 'icon' => '🍎', 'description' => 'Apel Malang, kripik apel, sari apel, dan produk alam pegunungan Malang.', 'sort_order' => 5],
            ['name' => 'Souvenir & Aksesoris', 'slug' => 'souvenir-aksesoris', 'icon' => '🎁', 'description' => 'Souvenir khas Malang - gantungan kunci, kaos, magnet, dan merchandise.', 'sort_order' => 6],
        ];

        foreach ($categories as $cat) {
            \App\Models\Category::create($cat);
        }

        // Products
        $products = [
            // Makanan & Kuliner (category_id: 1)
            ['category_id' => 1, 'name' => 'Keripik Tempe Sanan Premium', 'slug' => 'keripik-tempe-sanan-premium', 'description' => 'Keripik tempe dari sentra keripik tempe Sanan, Kota Malang. Dibuat dari tempe berkualitas tinggi dengan cita rasa gurih renyah. Tersedia dalam pilihan original, pedas, dan balado.', 'short_description' => 'Keripik tempe asli Sanan, Malang - gurih renyah khas pengrajin lokal.', 'price' => 25000, 'original_price' => 30000, 'stock' => 100, 'weight' => '250gr', 'origin' => 'Sanan, Kota Malang', 'is_active' => true, 'is_featured' => true, 'is_bestseller' => true],
            ['category_id' => 1, 'name' => 'Bakwan Malang Siap Saji', 'slug' => 'bakwan-malang-siap-saji', 'description' => 'Bakwan Malang lengkap dengan bakso, siomay, tahu, dan kuah kaldu gurih. Dikirim dalam kondisi beku dan siap diseduh.', 'short_description' => 'Bakwan Malang autentik lengkap dengan kuah kaldu gurih.', 'price' => 45000, 'original_price' => 55000, 'stock' => 50, 'weight' => '500gr', 'origin' => 'Kota Malang', 'is_active' => true, 'is_featured' => true, 'is_bestseller' => true],
            ['category_id' => 1, 'name' => 'Sari Apel Malang 1 Liter', 'slug' => 'sari-apel-malang-1-liter', 'description' => 'Minuman sari apel asli dari buah apel Malang pilihan. Tanpa pewarna buatan, menyegarkan dan kaya vitamin.', 'short_description' => 'Minuman sari apel asli Malang, segar dan alami.', 'price' => 18000, 'original_price' => null, 'stock' => 80, 'weight' => '1000ml', 'origin' => 'Batu, Malang', 'is_active' => true, 'is_featured' => false, 'is_bestseller' => true],
            ['category_id' => 1, 'name' => 'Kripik Apel Malang Original', 'slug' => 'kripik-apel-malang-original', 'description' => 'Kripik dari apel Malang segar yang diproses dengan teknologi vacuum frying. Renyah, manis-asam alami tanpa pengawet.', 'short_description' => 'Kripik apel renyah dari apel Malang asli, vacuum frying.', 'price' => 35000, 'original_price' => 40000, 'stock' => 60, 'weight' => '100gr', 'origin' => 'Batu, Malang', 'is_active' => true, 'is_featured' => true, 'is_bestseller' => false],
            ['category_id' => 1, 'name' => 'Onde-onde Malang Isi Kacang Hijau', 'slug' => 'onde-onde-malang-isi-kacang-hijau', 'description' => 'Onde-onde khas Malang dengan isian kacang hijau yang manis dan legit. Dibuat secara tradisional oleh pengrajin lokal.', 'short_description' => 'Onde-onde khas Malang dengan isian kacang hijau tradisional.', 'price' => 20000, 'original_price' => null, 'stock' => 40, 'weight' => '300gr', 'origin' => 'Kota Malang', 'is_active' => true, 'is_featured' => false, 'is_bestseller' => false],

            // Kerajinan Tangan (category_id: 2)
            ['category_id' => 2, 'name' => 'Gerabah Dinoyo Vas Bunga Motif Batik', 'slug' => 'gerabah-dinoyo-vas-bunga-motif-batik', 'description' => 'Vas bunga dari gerabah sentra keramik Dinoyo, Malang. Dihias dengan motif batik Malangan yang elegan. Cocok sebagai dekorasi rumah.', 'short_description' => 'Vas gerabah Dinoyo bermotif batik Malangan, kerajinan autentik.', 'price' => 85000, 'original_price' => 100000, 'stock' => 25, 'weight' => '600gr', 'origin' => 'Dinoyo, Kota Malang', 'is_active' => true, 'is_featured' => true, 'is_bestseller' => false],
            ['category_id' => 2, 'name' => 'Set Mug Keramik Dinoyo Khas Malang', 'slug' => 'set-mug-keramik-dinoyo', 'description' => 'Set 2 mug keramik dari pengrajin Dinoyo. Motif gambar ikon Malang: Gunung Arjuno, Candi Singosari, dan Alun-alun Kota Malang.', 'short_description' => 'Set mug keramik bermotif ikon Malang dari pengrajin Dinoyo.', 'price' => 120000, 'original_price' => 150000, 'stock' => 30, 'weight' => '400gr', 'origin' => 'Dinoyo, Kota Malang', 'is_active' => true, 'is_featured' => true, 'is_bestseller' => true],
            ['category_id' => 2, 'name' => 'Anyaman Bambu Tas Pasar Malang', 'slug' => 'anyaman-bambu-tas-pasar-malang', 'description' => 'Tas dari anyaman bambu buatan pengrajin desa sekitar Kabupaten Malang. Kuat, ramah lingkungan, dan bernilai seni tinggi.', 'short_description' => 'Tas anyaman bambu handmade dari pengrajin Kabupaten Malang.', 'price' => 95000, 'original_price' => null, 'stock' => 20, 'weight' => '300gr', 'origin' => 'Kabupaten Malang', 'is_active' => true, 'is_featured' => false, 'is_bestseller' => false],

            // Topeng & Kesenian (category_id: 3)
            ['category_id' => 3, 'name' => 'Topeng Malangan Karakter Panji', 'slug' => 'topeng-malangan-karakter-panji', 'description' => 'Topeng Malangan karakter Raden Panji Asmorobangun, tokoh utama dalam seni tari Topeng Malang. Dibuat oleh pengrajin topeng tradisional dari Polowijen, Malang.', 'short_description' => 'Topeng Malangan asli karakter Panji dari pengrajin Polowijen.', 'price' => 350000, 'original_price' => 400000, 'stock' => 10, 'weight' => '500gr', 'origin' => 'Polowijen, Kota Malang', 'is_active' => true, 'is_featured' => true, 'is_bestseller' => false],
            ['category_id' => 3, 'name' => 'Topeng Malangan Karakter Bapang', 'slug' => 'topeng-malangan-karakter-bapang', 'description' => 'Topeng Malangan karakter Bapang - tokoh antagonis dalam tari Topeng Malang dengan warna merah khas. Karya seniman lokal Malang.', 'short_description' => 'Topeng Bapang berwarna merah, ikon seni Topeng Malangan.', 'price' => 320000, 'original_price' => null, 'stock' => 8, 'weight' => '500gr', 'origin' => 'Polowijen, Kota Malang', 'is_active' => true, 'is_featured' => true, 'is_bestseller' => false],
            ['category_id' => 3, 'name' => 'Miniatur Topeng Malangan Gantungan', 'slug' => 'miniatur-topeng-malangan-gantungan', 'description' => 'Miniatur topeng Malangan berukuran kecil untuk gantungan kunci atau dekorasi. Set 3 karakter berbeda: Panji, Bapang, dan Dewi Sekartaji.', 'short_description' => 'Miniatur topeng Malangan set 3 karakter, cocok untuk souvenir.', 'price' => 75000, 'original_price' => 90000, 'stock' => 35, 'weight' => '150gr', 'origin' => 'Kota Malang', 'is_active' => true, 'is_featured' => false, 'is_bestseller' => true],

            // Batik Malang (category_id: 4)
            ['category_id' => 4, 'name' => 'Batik Tulis Malangan Motif Tugu', 'slug' => 'batik-tulis-malangan-motif-tugu', 'description' => 'Kain batik tulis khas Malang dengan motif Tugu Malang. Dibuat oleh pengrajin batik dari Kampung Batik Malang menggunakan teknik tulis tradisional.', 'short_description' => 'Kain batik tulis motif Tugu Malang dari pengrajin lokal.', 'price' => 285000, 'original_price' => 350000, 'stock' => 15, 'weight' => '300gr', 'origin' => 'Kampung Batik, Kota Malang', 'is_active' => true, 'is_featured' => true, 'is_bestseller' => false],
            ['category_id' => 4, 'name' => 'Hem Batik Pria Motif Singosari', 'slug' => 'hem-batik-pria-motif-singosari', 'description' => 'Kemeja batik pria bermotif Candi Singosari. Bahan katun prima yang nyaman dipakai sehari-hari atau acara formal. Tersedia ukuran M, L, XL.', 'short_description' => 'Kemeja batik pria motif Singosari, bahan katun prima.', 'price' => 195000, 'original_price' => 230000, 'stock' => 25, 'weight' => '350gr', 'origin' => 'Singosari, Kabupaten Malang', 'is_active' => true, 'is_featured' => true, 'is_bestseller' => true],

            // Buah & Produk Alam (category_id: 5)
            ['category_id' => 5, 'name' => 'Apel Malang Manalagi 2 Kg', 'slug' => 'apel-malang-manalagi-2-kg', 'description' => 'Apel Manalagi segar langsung dari kebun apel di Batu, Malang. Rasa manis-segar, ukuran seragam, segar dipetik dari kebun sendiri.', 'short_description' => 'Apel Manalagi segar dari kebun Batu Malang.', 'price' => 38000, 'original_price' => 45000, 'stock' => 50, 'weight' => '2000gr', 'origin' => 'Batu, Malang', 'is_active' => true, 'is_featured' => false, 'is_bestseller' => true],
            ['category_id' => 5, 'name' => 'Kopi Arjuno Robusta Malang 250gr', 'slug' => 'kopi-arjuno-robusta-malang-250gr', 'description' => 'Kopi robusta dari lereng Gunung Arjuno, Malang. Ditanam pada ketinggian 800-1200 mdpl. Cita rasa bold, pahit sedang dengan aroma tanah yang khas.', 'short_description' => 'Kopi robusta lereng Gunung Arjuno, Malang - bold & aromatic.', 'price' => 65000, 'original_price' => null, 'stock' => 40, 'weight' => '250gr', 'origin' => 'Lereng Arjuno, Kabupaten Malang', 'is_active' => true, 'is_featured' => true, 'is_bestseller' => true],

            // Souvenir & Aksesoris (category_id: 6)
            ['category_id' => 6, 'name' => 'Kaos Malang Hits "Arema Never Die"', 'slug' => 'kaos-malang-arema-never-die', 'description' => 'Kaos dengan desain grafis khas Malang bermotif Arema. Bahan cotton combed 30s tebal dan nyaman. Pilihan warna biru dan putih.', 'short_description' => 'Kaos grafis khas Malang, cotton combed 30s berkualitas.', 'price' => 89000, 'original_price' => 110000, 'stock' => 60, 'weight' => '250gr', 'origin' => 'Kota Malang', 'is_active' => true, 'is_featured' => false, 'is_bestseller' => true],
            ['category_id' => 6, 'name' => 'Gantungan Kunci Topeng Malang Set', 'slug' => 'gantungan-kunci-topeng-malang-set', 'description' => 'Set gantungan kunci berbentuk miniatur topeng Malangan. Terdiri dari 5 karakter berbeda dalam satu paket. Cocok sebagai souvenir oleh-oleh khas Malang.', 'short_description' => 'Set gantungan kunci miniatur topeng Malangan, 5 karakter.', 'price' => 45000, 'original_price' => 55000, 'stock' => 80, 'weight' => '100gr', 'origin' => 'Kota Malang', 'is_active' => true, 'is_featured' => false, 'is_bestseller' => true],
            ['category_id' => 6, 'name' => 'Tote Bag Motif Batik Malangan', 'slug' => 'tote-bag-motif-batik-malangan', 'description' => 'Tas jinjing (tote bag) dengan motif batik Malangan dicetak digital. Bahan canvas tebal, cocok untuk belanja atau sehari-hari.', 'short_description' => 'Tote bag canvas motif batik Malangan, stylish & fungsional.', 'price' => 55000, 'original_price' => null, 'stock' => 45, 'weight' => '200gr', 'origin' => 'Kota Malang', 'is_active' => true, 'is_featured' => true, 'is_bestseller' => false],
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }

        // Admin user — role diset langsung (bukan mass-assign) karena tidak ada di $fillable
        $admin = \App\Models\User::create([
            'name' => 'Admin Malangan',
            'email' => 'admin@malangan.com',
            'password' => bcrypt('password'),
        ]);
        $admin->role = 'admin';
        $admin->save();

        // Demo customer
        \App\Models\User::create([
            'name' => 'Pelanggan Demo',
            'email' => 'pelanggan@malangan.com',
            'password' => bcrypt('password'),
        ]);
    }
}
