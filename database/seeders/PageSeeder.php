<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title'          => 'Tentang Kami',
                'slug'           => 'tentang-kami',
                'show_in_footer' => true,
                'sort_order'     => 1,
                'meta_description' => 'Kenali malangan.com — platform belanja online produk asli dan souvenir khas Malang Raya.',
                'content' => <<<HTML
<section class="mb-8">
    <h2 class="text-2xl font-display font-bold text-navy mb-4">Siapa Kami?</h2>
    <p class="text-gray-600 leading-relaxed mb-4">
        <strong>malangan.com</strong> adalah platform belanja online yang menghadirkan produk-produk asli dan souvenir khas Malang Raya langsung ke tangan Anda, di mana pun Anda berada di seluruh Indonesia.
    </p>
    <p class="text-gray-600 leading-relaxed">
        Kami lahir dari kecintaan terhadap kekayaan budaya dan kuliner Kota Malang. Dari Keripik Tempe Sanan yang renyah, Topeng Malangan yang memukau, hingga Batik Malang dengan motif khas — semuanya hadir di satu tempat.
    </p>
</section>

<section class="mb-8">
    <h2 class="text-2xl font-display font-bold text-navy mb-4">Misi Kami</h2>
    <ul class="space-y-3 text-gray-600">
        <li class="flex items-start gap-3">
            <span class="w-6 h-6 bg-gold/20 text-gold rounded-full flex items-center justify-center flex-shrink-0 mt-0.5 font-bold text-sm">✓</span>
            <span>Memperkenalkan produk lokal Malang kepada masyarakat Indonesia yang lebih luas.</span>
        </li>
        <li class="flex items-start gap-3">
            <span class="w-6 h-6 bg-gold/20 text-gold rounded-full flex items-center justify-center flex-shrink-0 mt-0.5 font-bold text-sm">✓</span>
            <span>Memberdayakan para pengrajin dan pelaku UMKM Malang Raya agar produk mereka dapat bersaing secara digital.</span>
        </li>
        <li class="flex items-start gap-3">
            <span class="w-6 h-6 bg-gold/20 text-gold rounded-full flex items-center justify-center flex-shrink-0 mt-0.5 font-bold text-sm">✓</span>
            <span>Menjaga keaslian produk — setiap item yang kami jual terverifikasi sebagai produk khas Malang.</span>
        </li>
        <li class="flex items-start gap-3">
            <span class="w-6 h-6 bg-gold/20 text-gold rounded-full flex items-center justify-center flex-shrink-0 mt-0.5 font-bold text-sm">✓</span>
            <span>Memberikan pengalaman belanja yang aman, mudah, dan menyenangkan.</span>
        </li>
    </ul>
</section>

<section class="mb-8">
    <h2 class="text-2xl font-display font-bold text-navy mb-4">Produk Kami</h2>
    <p class="text-gray-600 leading-relaxed mb-4">
        Kami menghadirkan lebih dari ratusan produk dalam 6 kategori utama:
    </p>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
        <div class="bg-gold/10 rounded-xl p-4 text-center">
            <p class="font-semibold text-navy text-sm">🍱 Makanan & Kuliner</p>
        </div>
        <div class="bg-gold/10 rounded-xl p-4 text-center">
            <p class="font-semibold text-navy text-sm">🏺 Kerajinan Tangan</p>
        </div>
        <div class="bg-gold/10 rounded-xl p-4 text-center">
            <p class="font-semibold text-navy text-sm">🎭 Topeng & Kesenian</p>
        </div>
        <div class="bg-gold/10 rounded-xl p-4 text-center">
            <p class="font-semibold text-navy text-sm">🧵 Batik Malang</p>
        </div>
        <div class="bg-gold/10 rounded-xl p-4 text-center">
            <p class="font-semibold text-navy text-sm">🍎 Buah & Produk Alam</p>
        </div>
        <div class="bg-gold/10 rounded-xl p-4 text-center">
            <p class="font-semibold text-navy text-sm">🎁 Souvenir & Aksesoris</p>
        </div>
    </div>
</section>

<section>
    <h2 class="text-2xl font-display font-bold text-navy mb-4">Hubungi Kami</h2>
    <div class="bg-gray-50 rounded-2xl p-6 space-y-3 text-gray-600 text-sm">
        <p>📍 <strong>Alamat:</strong> Kota Malang, Jawa Timur</p>
        <p>✉️ <strong>Email:</strong> info@malangan.com</p>
        <p>🕒 <strong>Jam Operasional:</strong> Senin – Sabtu, 08.00 – 17.00 WIB</p>
    </div>
</section>
HTML,
            ],
            [
                'title'          => 'Cara Pemesanan',
                'slug'           => 'cara-pemesanan',
                'show_in_footer' => true,
                'sort_order'     => 2,
                'meta_description' => 'Panduan langkah demi langkah cara memesan produk di malangan.com dengan mudah dan aman.',
                'content' => <<<HTML
<section class="mb-8">
    <p class="text-gray-600 leading-relaxed">
        Memesan produk khas Malang di <strong>malangan.com</strong> sangat mudah. Ikuti langkah-langkah berikut dan produk favorit Anda akan segera sampai di tangan.
    </p>
</section>

<section class="mb-8">
    <div class="space-y-6">
        <div class="flex gap-5 items-start">
            <div class="w-12 h-12 bg-navy text-gold rounded-2xl flex items-center justify-center font-display font-bold text-xl flex-shrink-0">1</div>
            <div>
                <h3 class="font-bold text-navy text-lg mb-1">Daftar / Masuk Akun</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Buat akun baru atau masuk ke akun yang sudah ada. Pendaftaran gratis dan hanya membutuhkan email serta password.</p>
            </div>
        </div>

        <div class="flex gap-5 items-start">
            <div class="w-12 h-12 bg-navy text-gold rounded-2xl flex items-center justify-center font-display font-bold text-xl flex-shrink-0">2</div>
            <div>
                <h3 class="font-bold text-navy text-lg mb-1">Pilih Produk</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Jelajahi koleksi kami dan klik produk yang Anda inginkan. Baca deskripsi, lihat foto, dan cek stok yang tersedia.</p>
            </div>
        </div>

        <div class="flex gap-5 items-start">
            <div class="w-12 h-12 bg-navy text-gold rounded-2xl flex items-center justify-center font-display font-bold text-xl flex-shrink-0">3</div>
            <div>
                <h3 class="font-bold text-navy text-lg mb-1">Masukkan ke Keranjang</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Klik tombol <strong>"Tambah ke Keranjang"</strong>. Anda dapat melanjutkan belanja atau langsung menuju keranjang untuk melakukan checkout.</p>
            </div>
        </div>

        <div class="flex gap-5 items-start">
            <div class="w-12 h-12 bg-navy text-gold rounded-2xl flex items-center justify-center font-display font-bold text-xl flex-shrink-0">4</div>
            <div>
                <h3 class="font-bold text-navy text-lg mb-1">Isi Data Pengiriman</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Masukkan nama, nomor telepon, dan alamat lengkap pengiriman Anda. Pastikan data yang diisi akurat agar paket tidak salah kirim.</p>
            </div>
        </div>

        <div class="flex gap-5 items-start">
            <div class="w-12 h-12 bg-navy text-gold rounded-2xl flex items-center justify-center font-display font-bold text-xl flex-shrink-0">5</div>
            <div>
                <h3 class="font-bold text-navy text-lg mb-1">Pilih Metode Pembayaran</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Saat ini kami menerima pembayaran melalui <strong>Transfer Bank</strong> dan <strong>Bayar di Tempat (COD)</strong> untuk area tertentu.</p>
            </div>
        </div>

        <div class="flex gap-5 items-start">
            <div class="w-12 h-12 bg-navy text-gold rounded-2xl flex items-center justify-center font-display font-bold text-xl flex-shrink-0">6</div>
            <div>
                <h3 class="font-bold text-navy text-lg mb-1">Konfirmasi & Pantau Pesanan</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Setelah pesanan terkonfirmasi, Anda dapat memantau status pesanan di menu <strong>"Pesanan Saya"</strong>. Tim kami akan memproses pesanan dalam 1×24 jam.</p>
            </div>
        </div>
    </div>
</section>

<section class="bg-gold/10 rounded-2xl p-6">
    <h3 class="font-bold text-navy mb-3">💡 Tips Berbelanja</h3>
    <ul class="space-y-2 text-sm text-gray-600">
        <li>• Periksa stok produk sebelum checkout untuk menghindari kehabisan.</li>
        <li>• Cantumkan catatan khusus jika ada permintaan tambahan (contoh: hadiah, kemasan khusus).</li>
        <li>• Simpan nomor pesanan Anda untuk memudahkan pelacakan.</li>
        <li>• Hubungi kami di info@malangan.com jika mengalami kendala.</li>
    </ul>
</section>
HTML,
            ],
            [
                'title'          => 'Kebijakan Pengiriman',
                'slug'           => 'kebijakan-pengiriman',
                'show_in_footer' => true,
                'sort_order'     => 3,
                'meta_description' => 'Informasi lengkap tentang kebijakan pengiriman, estimasi waktu, dan biaya pengiriman di malangan.com.',
                'content' => <<<HTML
<section class="mb-8">
    <p class="text-gray-600 leading-relaxed">
        Kami berkomitmen untuk mengirimkan setiap pesanan dengan aman dan tepat waktu. Berikut adalah kebijakan pengiriman yang berlaku di <strong>malangan.com</strong>.
    </p>
</section>

<section class="mb-8">
    <h2 class="text-2xl font-display font-bold text-navy mb-4">Wilayah Pengiriman</h2>
    <p class="text-gray-600 leading-relaxed mb-3">
        Kami melayani pengiriman ke seluruh wilayah Indonesia melalui mitra jasa pengiriman terpercaya.
    </p>
    <div class="grid md:grid-cols-3 gap-4">
        <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4">
            <p class="font-semibold text-emerald-800 text-sm mb-1">🏙️ Malang Raya</p>
            <p class="text-emerald-700 text-xs">Estimasi 1–2 hari kerja</p>
        </div>
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
            <p class="font-semibold text-blue-800 text-sm mb-1">🗺️ Jawa & Bali</p>
            <p class="text-blue-700 text-xs">Estimasi 2–4 hari kerja</p>
        </div>
        <div class="bg-purple-50 border border-purple-200 rounded-xl p-4">
            <p class="font-semibold text-purple-800 text-sm mb-1">🌏 Luar Jawa</p>
            <p class="text-purple-700 text-xs">Estimasi 4–7 hari kerja</p>
        </div>
    </div>
</section>

<section class="mb-8">
    <h2 class="text-2xl font-display font-bold text-navy mb-4">Biaya Pengiriman</h2>
    <p class="text-gray-600 leading-relaxed mb-4">
        Biaya pengiriman dihitung berdasarkan berat produk dan jarak pengiriman. Biaya akan ditampilkan secara otomatis saat proses checkout.
    </p>
    <div class="bg-gold/10 rounded-xl p-5">
        <p class="text-sm text-gray-600"><strong class="text-navy">Catatan:</strong> Untuk pembelian di atas <strong>Rp 500.000</strong>, pengiriman gratis ke seluruh wilayah Jawa dan Bali.</p>
    </div>
</section>

<section class="mb-8">
    <h2 class="text-2xl font-display font-bold text-navy mb-4">Proses Pengiriman</h2>
    <div class="space-y-4">
        <div class="flex gap-4 items-start">
            <div class="w-2 h-2 bg-gold rounded-full mt-2 flex-shrink-0"></div>
            <div>
                <p class="font-semibold text-gray-800 text-sm">Verifikasi Pesanan</p>
                <p class="text-gray-500 text-sm">Pesanan diverifikasi dalam 1×24 jam setelah pembayaran dikonfirmasi.</p>
            </div>
        </div>
        <div class="flex gap-4 items-start">
            <div class="w-2 h-2 bg-gold rounded-full mt-2 flex-shrink-0"></div>
            <div>
                <p class="font-semibold text-gray-800 text-sm">Pengemasan</p>
                <p class="text-gray-500 text-sm">Produk dikemas dengan aman menggunakan bahan pelindung agar tidak rusak selama pengiriman.</p>
            </div>
        </div>
        <div class="flex gap-4 items-start">
            <div class="w-2 h-2 bg-gold rounded-full mt-2 flex-shrink-0"></div>
            <div>
                <p class="font-semibold text-gray-800 text-sm">Pengiriman</p>
                <p class="text-gray-500 text-sm">Paket diserahkan ke mitra kurir dan Anda akan mendapat notifikasi status pengiriman.</p>
            </div>
        </div>
        <div class="flex gap-4 items-start">
            <div class="w-2 h-2 bg-gold rounded-full mt-2 flex-shrink-0"></div>
            <div>
                <p class="font-semibold text-gray-800 text-sm">Selesai</p>
                <p class="text-gray-500 text-sm">Status pesanan berubah menjadi "Terkirim" setelah paket diterima.</p>
            </div>
        </div>
    </div>
</section>

<section class="mb-8">
    <h2 class="text-2xl font-display font-bold text-navy mb-4">Penanganan Produk Rusak / Hilang</h2>
    <p class="text-gray-600 leading-relaxed mb-3">
        Jika produk yang Anda terima rusak atau tidak sesuai pesanan, segera hubungi kami dalam <strong>2×24 jam</strong> setelah paket diterima dengan menyertakan:
    </p>
    <ul class="space-y-2 text-sm text-gray-600 ml-4">
        <li>• Foto produk yang rusak atau tidak sesuai</li>
        <li>• Nomor pesanan Anda</li>
        <li>• Deskripsi singkat masalah yang terjadi</li>
    </ul>
    <p class="text-gray-600 leading-relaxed mt-3">Tim kami akan menindaklanjuti laporan dalam 1×24 jam.</p>
</section>

<section class="bg-navy/5 rounded-2xl p-6">
    <h3 class="font-bold text-navy mb-2">📞 Ada Pertanyaan?</h3>
    <p class="text-sm text-gray-600">Hubungi tim kami melalui email <strong>info@malangan.com</strong> atau kunjungi halaman <a href="/halaman/cara-pemesanan" class="text-navy underline hover:text-gold">Cara Pemesanan</a> untuk informasi lebih lanjut.</p>
</section>
HTML,
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}
