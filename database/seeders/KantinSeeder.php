<?php

namespace Database\Seeders;

use App\Models\Kantin;
use App\Models\Kiosk;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KantinSeeder extends Seeder
{
    public function run(): void
    {
        // ── Kantin data ──
        $kantins = [
            [
                'name' => 'Kantin Corner',
                'description' => 'Kantin utama di sudut sekolah dengan berbagai pilihan makanan dan minuman favorit.',
                'image' => null,
            ],
            [
                'name' => 'Kantin Pemasaran',
                'description' => 'Kantin di area jurusan Pemasaran dengan aneka jajanan dan makanan berat.',
                'image' => null,
            ],
            [
                'name' => 'Kantin Belakang',
                'description' => 'Kantin di belakang sekolah yang menyediakan makanan rumahan dan minuman segar.',
                'image' => null,
            ],
        ];

        // ── Kiosk + Menu demo data ──
        $kioskData = [
            // Kantin Corner
            [
                'kantin_index' => 0,
                'name' => 'Warung Bu Sari',
                'description' => 'Spesialis nasi goreng dan mie goreng kampung.',
                'menus' => [
                    ['name' => 'Nasi Goreng Spesial', 'description' => 'Nasi goreng dengan telur, ayam, dan kerupuk', 'price' => 15000],
                    ['name' => 'Mie Goreng Jawa', 'description' => 'Mie goreng bumbu kecap khas Jawa', 'price' => 12000],
                    ['name' => 'Es Teh Manis', 'description' => 'Teh manis segar dingin', 'price' => 5000],
                    ['name' => 'Nasi Ayam Geprek', 'description' => 'Nasi dengan ayam geprek sambal bawang', 'price' => 18000],
                ],
            ],
            [
                'kantin_index' => 0,
                'name' => 'Kedai Pak Joko',
                'description' => 'Aneka soto dan bakso mantap.',
                'menus' => [
                    ['name' => 'Bakso Urat', 'description' => 'Bakso urat jumbo dengan kuah kaldu sapi', 'price' => 15000],
                    ['name' => 'Soto Ayam', 'description' => 'Soto ayam khas Solo dengan nasi', 'price' => 13000],
                    ['name' => 'Es Jeruk', 'description' => 'Jeruk peras segar', 'price' => 5000],
                ],
            ],
            // Kantin Pemasaran
            [
                'kantin_index' => 1,
                'name' => 'Dapur Mbak Rina',
                'description' => 'Makanan rumahan murah meriah.',
                'menus' => [
                    ['name' => 'Nasi Rames', 'description' => 'Nasi dengan lauk pauk lengkap', 'price' => 12000],
                    ['name' => 'Nasi Kuning', 'description' => 'Nasi kuning komplet dengan lauk', 'price' => 10000],
                    ['name' => 'Gorengan Campur', 'description' => 'Isi 5: tahu, tempe, bakwan, pisang, risol', 'price' => 5000],
                    ['name' => 'Jus Alpukat', 'description' => 'Jus alpukat segar dengan susu coklat', 'price' => 8000],
                ],
            ],
            [
                'kantin_index' => 1,
                'name' => 'Snack Corner Dian',
                'description' => 'Jajanan kekinian dan minuman hits.',
                'menus' => [
                    ['name' => 'Corndog Mozarella', 'description' => 'Corndog isi sosis dan mozarella leleh', 'price' => 10000],
                    ['name' => 'Dimsum Ayam', 'description' => 'Dimsum ayam isi 5 pcs', 'price' => 12000],
                    ['name' => 'Boba Brown Sugar', 'description' => 'Minuman boba gula aren', 'price' => 10000],
                ],
            ],
            // Kantin Belakang
            [
                'kantin_index' => 2,
                'name' => 'Warteg Barokah',
                'description' => 'Makanan warteg paling lengkap di kantin.',
                'menus' => [
                    ['name' => 'Nasi + Ayam Goreng', 'description' => 'Nasi putih dengan ayam goreng kampung', 'price' => 15000],
                    ['name' => 'Nasi + Rendang', 'description' => 'Nasi putih dengan rendang daging sapi', 'price' => 18000],
                    ['name' => 'Sayur Asem', 'description' => 'Sayur asem segar khas Sunda', 'price' => 5000],
                    ['name' => 'Es Cendol', 'description' => 'Cendol ijo dengan gula merah dan santan', 'price' => 7000],
                ],
            ],
            [
                'kantin_index' => 2,
                'name' => 'Juice & Smoothie Bar',
                'description' => 'Minuman segar dan healthy drinks.',
                'menus' => [
                    ['name' => 'Green Smoothie', 'description' => 'Smoothie bayam, pisang, dan madu', 'price' => 12000],
                    ['name' => 'Jus Mangga', 'description' => 'Jus mangga harum manis segar', 'price' => 8000],
                    ['name' => 'Milkshake Coklat', 'description' => 'Milkshake coklat premium', 'price' => 15000],
                ],
            ],
        ];

        // Create kantins
        $createdKantins = [];
        foreach ($kantins as $kantinData) {
            $createdKantins[] = Kantin::create($kantinData);
        }

        // Create penjual users and their kiosks + menus
        foreach ($kioskData as $index => $kiosk) {
            $penjual = User::create([
                'name' => 'Penjual ' . $kiosk['name'],
                'email' => 'penjual' . ($index + 1) . '@kantin.test',
                'password' => Hash::make('password'),
                'role' => 'penjual',
            ]);

            $createdKiosk = Kiosk::create([
                'kantin_id' => $createdKantins[$kiosk['kantin_index']]->id,
                'user_id' => $penjual->id,
                'name' => $kiosk['name'],
                'description' => $kiosk['description'],
            ]);

            foreach ($kiosk['menus'] as $menu) {
                Menu::create([
                    'kiosk_id' => $createdKiosk->id,
                    'name' => $menu['name'],
                    'description' => $menu['description'],
                    'price' => $menu['price'],
                ]);
            }
        }
    }
}
