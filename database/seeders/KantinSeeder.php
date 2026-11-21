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
        // ── 1. Master Data Kantin SMECONE ──
        $kantins = [
            [
                'name' => 'Kantin Corner',
                'description' => 'Kantin utama di sudut sekolah SMECONE dengan berbagai pilihan hidangan favorit dan aneka snack.',
                'image' => null,
            ],
            [
                'name' => 'Kantin Pemasaran',
                'description' => 'Kantin di area jurusan Pemasaran SMECONE dengan aneka jajanan kekinian, hidangan berat, dan minuman segar.',
                'image' => null,
            ],
            [
                'name' => 'Kantin Lama (Belakang)',
                'description' => 'Kantin di area belakang sekolah dekat perpustakaan dengan deretan stand masakan nusantara dan jajanan tradisional.',
                'image' => null,
            ],
        ];

        // ── 2. Master Data Kios, Penjual & Menu Real SMECONE ──
        $kioskData = [
            // ══════════════════════════════════════════════════════════
            // KANTIN CORNER (1 Kios Besar)
            // ══════════════════════════════════════════════════════════
            [
                'kantin_index' => 0,
                'name' => 'Kantin Corner',
                'description' => 'Pusat hidangan lengkap Kantin Corner: bakso, soto, nasi rames, aneka gorengan, minuman dingin, dan snack sachet.',
                'user' => [
                    'name' => 'Penjual Kantin Corner',
                    'email' => 'corner@kantin.smecone',
                    'password' => 'password',
                ],
                'menus' => [
                    ['name' => 'Bakso 1 Porsi', 'description' => 'Bakso sapi kenyal dengan mie kuning, bihun, tahu, dan kuah kaldu gurih', 'price' => 6000, 'image' => 'menus/bakso.jpg'],
                    ['name' => 'Soto 1 Porsi', 'description' => 'Soto ayam khas Solo dengan suwiran ayam, tauge, kol, dan kuah kuning hangat', 'price' => 6000, 'image' => 'menus/soto.jpg'],
                    ['name' => 'Piscok', 'description' => 'Pisang cokelat lumer renyah manis digoreng dadakan', 'price' => 2000, 'image' => 'menus/piscok.jpg'],
                    ['name' => 'Risol', 'description' => 'Risol goreng gurih isi bihun dan sayuran', 'price' => 2000, 'image' => 'menus/risol.jpg'],
                    ['name' => 'Martabak Goreng', 'description' => 'Martabak telur goreng kulit krispi isi telur dan daun bawang', 'price' => 3000, 'image' => 'menus/martabak_goreng.jpg'],
                    ['name' => 'Nasi Rames 1 Porsi', 'description' => 'Nasi putih porsi kenyang dengan aneka lauk rumahan dan sambal', 'price' => 6000, 'image' => 'menus/nasi_rames.jpg'],
                    ['name' => 'Cireng 1 pcs', 'description' => 'Aci digoreng renyah kenyal dengan bumbu rujak pedas manis', 'price' => 1000, 'image' => 'menus/cireng.jpg'],
                    ['name' => 'Seblak Kering', 'description' => 'Kerupuk bantat pedas gurih bumbu kencur dan cabai', 'price' => 4000, 'image' => 'menus/seblak_kering.jpg'],
                    ['name' => 'Usus Goreng', 'description' => 'Keripik usus ayam goreng tepung renyah tanpa minyak', 'price' => 4000, 'image' => 'menus/usus_goreng.jpg'],
                    ['name' => 'Keripik Singkong', 'description' => 'Keripik singkong gurih renyah asin khas kantin', 'price' => 3000, 'image' => 'menus/keripik_singkong.jpg'],
                    ['name' => 'Teh Pucuk', 'description' => 'Teh Pucuk Harum melati dingin botol 350ml', 'price' => 4000, 'image' => 'menus/teh_pucuk.jpg'],
                    ['name' => 'Cimori', 'description' => 'Yogurt Cimory drink aneka rasa buah segar', 'price' => 5000, 'image' => 'menus/cimory.jpg'],
                    ['name' => 'Susu Milikku', 'description' => 'Susu bantal Milku rasa cokelat / stroberi dingin', 'price' => 4000, 'image' => 'menus/susu_milku.jpg'],
                    ['name' => 'Nipis Madu', 'description' => 'Minuman jeruk nipis madu segar dingin pelepas dahaga', 'price' => 4000, 'image' => 'menus/nipis_madu.jpg'],
                    ['name' => 'Air Mineral', 'description' => 'Air mineral dingin 600ml', 'price' => 3000, 'image' => 'menus/air_mineral.jpg'],
                    ['name' => 'Cheetos', 'description' => 'Snack jagung renyah rasa keju gurih sachet', 'price' => 3000, 'image' => 'menus/snack_cheetos.jpg'],
                    ['name' => 'Chitato', 'description' => 'Keripik kentang Chitato rasa sapi panggang sachet', 'price' => 4000, 'image' => 'menus/snack_chitato.jpg'],
                    ['name' => 'Cookies', 'description' => 'Biskuit cookies cokelat renyah', 'price' => 2000, 'image' => 'menus/snack_cookies.jpg'],
                    ['name' => 'Chiki Balls', 'description' => 'Snack bola-bola jagung rasa cokelat / keju', 'price' => 2000, 'image' => 'menus/snack_chiki.jpg'],
                    ['name' => 'Qtela', 'description' => 'Keripik singkong Qtela rasa balado / original', 'price' => 4000, 'image' => 'menus/snack_qtela.jpg'],
                ],
            ],

            // ══════════════════════════════════════════════════════════
            // KANTIN PEMASARAN (6 Kios)
            // ══════════════════════════════════════════════════════════
            [
                'kantin_index' => 1,
                'name' => 'Boszzfood',
                'description' => 'Spesialis burger, mie instan varian, takoyaki jepang, dan minuman es sachet segar.',
                'user' => [
                    'name' => 'Pemilik Boszzfood',
                    'email' => 'boszzfood@kantin.smecone',
                    'password' => 'password',
                ],
                'menus' => [
                    ['name' => 'Mie Instan Isi 1', 'description' => 'Mie instan kuah/goreng 1 bungkus + sawi dan telur', 'price' => 6000, 'image' => 'menus/mie_instan.jpg'],
                    ['name' => 'Mie Instan Isi 2', 'description' => 'Mie instan jumbo isi 2 porsi kenyang + sawi dan telur', 'price' => 7000, 'image' => 'menus/mie_instan.jpg'],
                    ['name' => 'Burger Kecil', 'description' => 'Burger mini dengan patty daging sapi dan saus gurih', 'price' => 5000, 'image' => 'menus/burger_kecil.jpg'],
                    ['name' => 'Burger Besar', 'description' => 'Burger jumbo double patty daging dengan saus keju spesial', 'price' => 8000, 'image' => 'menus/burger_besar.jpg'],
                    ['name' => 'Takoyaki 1 pcs', 'description' => 'Takoyaki bulat gurih isi sosis/gurita dengan katsuobushi', 'price' => 1000, 'image' => 'menus/takoyaki.jpg'],
                    ['name' => 'Es Teh', 'description' => 'Es teh manis segar dingin melati', 'price' => 2500, 'image' => 'menus/es_teh.jpg'],
                    ['name' => 'Es Pop Ice', 'description' => 'Es blender Pop Ice aneka rasa (Cokelat/Taro/Permen Karet) dengan meses', 'price' => 5000, 'image' => 'menus/pop_ice.jpg'],
                    ['name' => 'Es Beng-beng Drink', 'description' => 'Minuman cokelat Beng-beng drink dingin cokelat legit', 'price' => 5000, 'image' => 'menus/bengbeng_drink.jpg'],
                    ['name' => 'Es Chocolatos Drink', 'description' => 'Minuman cokelat kental Chocolatos dingin mantap', 'price' => 5000, 'image' => 'menus/chocolatos_drink.jpg'],
                ],
            ],
            [
                'kantin_index' => 1,
                'name' => 'Sosis Bakar Om Gun',
                'description' => 'Sosis bakar lezat bumbu BBQ pedas manis dan mie instan racikan Om Gun.',
                'user' => [
                    'name' => 'Om Gun (Sosis Bakar)',
                    'email' => 'omgun@kantin.smecone',
                    'password' => 'password',
                ],
                'menus' => [
                    ['name' => 'Sosis Kecil', 'description' => 'Sosis bakar ukuran standar dengan olesan bumbu BBQ pedas manis', 'price' => 5000, 'image' => 'menus/sosis_kecil.jpg'],
                    ['name' => 'Sosis Besar', 'description' => 'Sosis bakar jumbo premium gurih saus mayo dan saus pedas', 'price' => 8000, 'image' => 'menus/sosis_besar.jpg'],
                    ['name' => 'Mie Instan Isi 1', 'description' => 'Mie instan rebus/goreng 1 bungkus bumbu spesial', 'price' => 6000, 'image' => 'menus/mie_instan.jpg'],
                    ['name' => 'Mie Instan Isi 2', 'description' => 'Mie instan double porsi mantap mengenyangkan', 'price' => 7000, 'image' => 'menus/mie_instan.jpg'],
                ],
            ],
            [
                'kantin_index' => 1,
                'name' => '"Es Tea" Variant Mba Indah',
                'description' => 'Aneka varian teh kekinian, minuman sachet hits, serta cireng dan cibay hangat.',
                'user' => [
                    'name' => 'Mba Indah (Es Tea Variant)',
                    'email' => 'mbaindah@kantin.smecone',
                    'password' => 'password',
                ],
                'menus' => [
                    ['name' => 'Es Teh', 'description' => 'Es teh racikan khas Mba Indah manis dan wangi melati', 'price' => 2500, 'image' => 'menus/es_teh.jpg'],
                    ['name' => 'Matcha', 'description' => 'Es teh matcha hijau kental rasa manis lembut', 'price' => 5000, 'image' => 'menus/matcha_drink.jpg'],
                    ['name' => 'Thai Tea', 'description' => 'Es Thai Tea otentik wangi teh thailand dan susu creamy', 'price' => 5000, 'image' => 'menus/thai_tea.jpg'],
                    ['name' => 'Lemon Tea', 'description' => 'Es teh campur perasan lemon segar asam manis', 'price' => 4000, 'image' => 'menus/lemon_tea.jpg'],
                    ['name' => 'Es Pop Ice', 'description' => 'Es blender Pop Ice dingin segar aneka rasa', 'price' => 5000, 'image' => 'menus/pop_ice.jpg'],
                    ['name' => 'Es Nutrisari', 'description' => 'Es Nutrisari jeruk manis dingin segar kaya vitamin C', 'price' => 5000, 'image' => 'menus/nutrisari.jpg'],
                    ['name' => 'Es Chocolatos Drink', 'description' => 'Es Chocolatos cokelat manis creamy', 'price' => 5000, 'image' => 'menus/chocolatos_drink.jpg'],
                    ['name' => 'Cireng 1 pcs', 'description' => 'Cireng goreng renyah kenyal bumbu gurih', 'price' => 1000, 'image' => 'menus/cireng.jpg'],
                    ['name' => 'Cibay 1 pcs', 'description' => 'Aci ngambay gurih kenyal pedas lumer di mulut', 'price' => 1000, 'image' => 'menus/cibay.jpg'],
                ],
            ],
            [
                'kantin_index' => 1,
                'name' => 'Kantin Bu Sari',
                'description' => 'Nasi katsu lezat, batagor Bandung asli, dan aneka varian rasa risol kekinian.',
                'user' => [
                    'name' => 'Bu Sari',
                    'email' => 'busari@kantin.smecone',
                    'password' => 'password',
                ],
                'menus' => [
                    ['name' => 'Nasi Katsu 1 Porsi', 'description' => 'Nasi putih hangat dengan chicken katsu krispi, salad, dan saus katsu gurih', 'price' => 12000, 'image' => 'menus/nasi_katsu.jpg'],
                    ['name' => 'Batagor Biasa 1 Porsi', 'description' => 'Batagor goreng renyah disiram bumbu kacang gurih khas Bandung', 'price' => 5000, 'image' => 'menus/batagor.jpg'],
                    ['name' => 'Batagor Kuah 1 Porsi', 'description' => 'Batagor dengan kuah kaldu gurih pedas hangat', 'price' => 5000, 'image' => 'menus/batagor_kuah.jpg'],
                    ['name' => 'Risol Biasa 1 pcs', 'description' => 'Risol isi sayuran dan bihun renyah', 'price' => 3000, 'image' => 'menus/risol.jpg'],
                    ['name' => 'Risol Matcha 1 pcs', 'description' => 'Risol manis isi krim matcha leleh lembut', 'price' => 3000, 'image' => 'menus/risol_matcha.jpg'],
                    ['name' => 'Risol Durian 1 pcs', 'description' => 'Risol manis dengan isian vla durian legit wangi', 'price' => 3000, 'image' => 'menus/risol_durian.jpg'],
                    ['name' => 'Risol Cokelat 1 pcs', 'description' => 'Risol manis lumer isi cokelat leleh nikmat', 'price' => 3000, 'image' => 'menus/risol_cokelat.jpg'],
                ],
            ],
            [
                'kantin_index' => 1,
                'name' => 'Kantin Tante Mita',
                'description' => 'Ayam geprek pedas nampol, pentol kuah pedas, dimsum, aneka varian seblak, dan es teler.',
                'user' => [
                    'name' => 'Tante Mita',
                    'email' => 'tantemita@kantin.smecone',
                    'password' => 'password',
                ],
                'menus' => [
                    ['name' => 'Ayam Geprek 1 Porsi', 'description' => 'Ayam goreng tepung digeprek dengan sambal bawang pedas nampol + nasi hangat', 'price' => 12000, 'image' => 'menus/ayam_geprek.jpg'],
                    ['name' => 'Pentol Kuah 1 Porsi', 'description' => 'Pentol bakso sapi kenyal dengan kuah kaldu pedas gurih (bisa request pedas)', 'price' => 5000, 'image' => 'menus/pentol_kuah.jpg'],
                    ['name' => 'Dimsum 1 pcs', 'description' => 'Dimsum ayam kukus lembut disajikan dengan saus asam manis pedas', 'price' => 1000, 'image' => 'menus/dimsum.jpg'],
                    ['name' => 'Seblak Original (Kerupuk)', 'description' => 'Seblak kerupuk kenyal bumbu kencur pedas gurih khas Bandung', 'price' => 5000, 'image' => 'menus/seblak_kuah.jpg'],
                    ['name' => 'Seblak + Mie', 'description' => 'Seblak kuah pedas dengan topping mie kuning kenyal dan kerupuk', 'price' => 7000, 'image' => 'menus/seblak_kuah.jpg'],
                    ['name' => 'Seblak + Kwetiau', 'description' => 'Seblak kuah pedas dengan topping kwetiau lembut dan bumbu gurih', 'price' => 7000, 'image' => 'menus/seblak_kuah.jpg'],
                    ['name' => 'Seblak + Makaroni', 'description' => 'Seblak kuah pedas dengan campuran makaroni dan kerupuk', 'price' => 7000, 'image' => 'menus/seblak_kuah.jpg'],
                    ['name' => 'Seblak + Telur', 'description' => 'Seblak kuah pedas dengan kocokan telur gurih dan kerupuk', 'price' => 8000, 'image' => 'menus/seblak_kuah.jpg'],
                    ['name' => 'Seblak Komplit (Mie+Kerupuk+Telur)', 'description' => 'Seblak komplit porsi mantap: mie, kerupuk, sayuran, dan telur lezat', 'price' => 10000, 'image' => 'menus/seblak_kuah.jpg'],
                    ['name' => 'Es Teler 1 Porsi', 'description' => 'Es teler segar isi nangka, alpukat, kelapa muda, dan susu kental manis', 'price' => 5000, 'image' => 'menus/es_teler.jpg'],
                    ['name' => 'Mie Jebew 1 Porsi', 'description' => 'Mie jebew pedas ekstra cabai dengan bumbu gurih daun bawang', 'price' => 5000, 'image' => 'menus/mie_jebew.jpg'],
                ],
            ],
            [
                'kantin_index' => 1,
                'name' => 'Kantin 6CH',
                'description' => 'Surga aneka camilan pedas, basreng, makaroni, aneka snack sachet, dan Pop Mie hangat.',
                'user' => [
                    'name' => 'Pemilik Kantin 6CH',
                    'email' => 'kantin6ch@kantin.smecone',
                    'password' => 'password',
                ],
                'menus' => [
                    ['name' => 'Makaroni Pedas Sachet', 'description' => 'Makaroni goreng pedas gurih renyah bumbu daun jeruk', 'price' => 3000, 'image' => 'menus/makaroni_pedas.jpg'],
                    ['name' => 'Basreng', 'description' => 'Bakso goreng renyah gurih pedas daun jeruk nikmat', 'price' => 3000, 'image' => 'menus/basreng.jpg'],
                    ['name' => 'Keripik Usus', 'description' => 'Keripik usus ayam krispi gurih asin', 'price' => 4000, 'image' => 'menus/usus_goreng.jpg'],
                    ['name' => 'Keripik Singkong', 'description' => 'Keripik singkong tipis renyah rasa gurih', 'price' => 3000, 'image' => 'menus/keripik_singkong.jpg'],
                    ['name' => 'Seblak Kering Sachet', 'description' => 'Kerupuk bantat pedas cabai kering bumbu kencur', 'price' => 4000, 'image' => 'menus/seblak_kering.jpg'],
                    ['name' => 'Pop Mie', 'description' => 'Pop Mie seduh hangat rasa ayam bawang / kari ayam', 'price' => 5000, 'image' => 'menus/pop_mie.jpg'],
                    ['name' => 'Chiki Balls', 'description' => 'Snack jagung renyah manis gurih', 'price' => 2000, 'image' => 'menus/snack_chiki.jpg'],
                    ['name' => 'Cheetos', 'description' => 'Snack jagung rasa keju gurih sachet', 'price' => 3000, 'image' => 'menus/snack_cheetos.jpg'],
                    ['name' => 'Qtela', 'description' => 'Keripik singkong Qtela rasa balado renyah', 'price' => 4000, 'image' => 'menus/snack_qtela.jpg'],
                    ['name' => 'Es Teh', 'description' => 'Es teh manis segar pelepas dahaga', 'price' => 2500, 'image' => 'menus/es_teh.jpg'],
                    ['name' => 'Es Pop Ice', 'description' => 'Es blender Pop Ice aneka rasa segar manis', 'price' => 5000, 'image' => 'menus/pop_ice.jpg'],
                    ['name' => 'Es Good Day', 'description' => 'Es kopi Good Day dingin moccacino / carrebian nut', 'price' => 5000, 'image' => 'menus/good_day.jpg'],
                    ['name' => 'Air Mineral', 'description' => 'Air mineral dingin 600ml', 'price' => 3000, 'image' => 'menus/air_mineral.jpg'],
                ],
            ],

            // ══════════════════════════════════════════════════════════
            // KANTIN LAMA (BELAKANG - 5 Stand urut dari perpustakaan)
            // ══════════════════════════════════════════════════════════
            [
                'kantin_index' => 2,
                'name' => 'Stand 1 (Mie Ayam & Mie Instan)',
                'description' => 'Stand pertama dari arah perpustakaan: mie ayam gurih manis dan aneka mie instan rebus/goreng.',
                'user' => [
                    'name' => 'Penjual Stand 1',
                    'email' => 'stand1@kantin.smecone',
                    'password' => 'password',
                ],
                'menus' => [
                    ['name' => 'Mie Ayam 1 Porsi', 'description' => 'Mie ayam dengan potongan daging ayam semur manis gurih, sawi, dan kuah kaldu', 'price' => 9000, 'image' => 'menus/mie_ayam.jpg'],
                    ['name' => 'Mie Instan Isi 1', 'description' => 'Mie instan rebus/goreng 1 bungkus + sawi dan telur', 'price' => 7000, 'image' => 'menus/mie_instan.jpg'],
                    ['name' => 'Mie Instan Isi 2', 'description' => 'Mie instan double porsi kenyang + sawi dan telur', 'price' => 8000, 'image' => 'menus/mie_instan.jpg'],
                ],
            ],
            [
                'kantin_index' => 2,
                'name' => 'Stand 2 (Aneka Gorengan & Cimol)',
                'description' => 'Stand kedua dari arah perpustakaan: cireng, sempol, cimol bumbu tabur, pangsit goreng, dan makaroni.',
                'user' => [
                    'name' => 'Penjual Stand 2',
                    'email' => 'stand2@kantin.smecone',
                    'password' => 'password',
                ],
                'menus' => [
                    ['name' => 'Cireng 1 pcs', 'description' => 'Cireng goreng krispi kenyal disajikan hangat', 'price' => 1500, 'image' => 'menus/cireng.jpg'],
                    ['name' => 'Sempol 1 pcs', 'description' => 'Sempol ayam goreng balut telur gurih lezat', 'price' => 1500, 'image' => 'menus/sempol.jpg'],
                    ['name' => 'Cimol Porsi Kecil', 'description' => 'Cimol kenyal gurih bumbu tabur asin / balado (porsi 2k)', 'price' => 2000, 'image' => 'menus/cimol.jpg'],
                    ['name' => 'Cimol Porsi Sedang', 'description' => 'Cimol bumbu tabur gurih porsi sedang (porsi 3k)', 'price' => 3000, 'image' => 'menus/cimol.jpg'],
                    ['name' => 'Cimol Porsi Besar', 'description' => 'Cimol bumbu tabur gurih porsi mantap (porsi 4k)', 'price' => 4000, 'image' => 'menus/cimol.jpg'],
                    ['name' => 'Cimol Porsi Jumbo', 'description' => 'Cimol bumbu tabur gurih porsi puas jumbo (porsi 5k)', 'price' => 5000, 'image' => 'menus/cimol.jpg'],
                    ['name' => 'Pangsit Goreng 1 Packet', 'description' => 'Pangsit goreng krispi renyah isi daging olahan + saus sambal', 'price' => 5000, 'image' => 'menus/pangsit_goreng.jpg'],
                    ['name' => 'Makaroni 1 Packet', 'description' => 'Makaroni goreng renyah gurih bumbu tabur', 'price' => 3000, 'image' => 'menus/makaroni_pedas.jpg'],
                    ['name' => 'Keripik Singkong 1 Packet', 'description' => 'Keripik singkong renyah gurih bumbu asin', 'price' => 4000, 'image' => 'menus/keripik_singkong.jpg'],
                ],
            ],
            [
                'kantin_index' => 2,
                'name' => 'Stand 3 (Minuman Segar & Sachet)',
                'description' => 'Stand ketiga dari arah perpustakaan: aneka minuman sachet dingin instan dan es teh segar.',
                'user' => [
                    'name' => 'Penjual Stand 3',
                    'email' => 'stand3@kantin.smecone',
                    'password' => 'password',
                ],
                'menus' => [
                    ['name' => 'Es Teh', 'description' => 'Es teh manis segar dingin melati', 'price' => 2500, 'image' => 'menus/es_teh.jpg'],
                    ['name' => 'Es Pop Ice', 'description' => 'Es Pop Ice blender aneka rasa buah dan cokelat', 'price' => 5000, 'image' => 'menus/pop_ice.jpg'],
                    ['name' => 'Es Beng-beng Drink', 'description' => 'Es cokelat Beng-beng drink dingin manis', 'price' => 5000, 'image' => 'menus/bengbeng_drink.jpg'],
                    ['name' => 'Es Chocolatos Drink', 'description' => 'Es Chocolatos cokelat legit kental nikmat', 'price' => 5000, 'image' => 'menus/chocolatos_drink.jpg'],
                    ['name' => 'Es Nutrisari', 'description' => 'Es jeruk Nutrisari segar dingin kaya vitamin', 'price' => 5000, 'image' => 'menus/nutrisari.jpg'],
                    ['name' => 'Es Good Day', 'description' => 'Es kopi Good Day aneka rasa moccacino / vanilla latte', 'price' => 5000, 'image' => 'menus/good_day.jpg'],
                    ['name' => 'Es Milo Sachet', 'description' => 'Es Milo susu cokelat malt dingin segar bertenaga', 'price' => 5000, 'image' => 'menus/milo.jpg'],
                ],
            ],
            [
                'kantin_index' => 2,
                'name' => 'Stand 4 (Mendoan & Pecel Ketupat)',
                'description' => 'Stand keempat dari arah perpustakaan: tempe mendoan Banyumas hangat dan pecel mendoan ketupat bumbu kacang.',
                'user' => [
                    'name' => 'Penjual Stand 4',
                    'email' => 'stand4@kantin.smecone',
                    'password' => 'password',
                ],
                'menus' => [
                    ['name' => 'Mendoan 1 pcs', 'description' => 'Tempe mendoan hangat khas Banyumas disajikan dengan cabai rawit / sambal kecap', 'price' => 1000, 'image' => 'menus/mendoan.jpg'],
                    ['name' => 'Pecel Mendoan Ketupat 1 Porsi', 'description' => 'Pecel sayuran segar bumbu kacang khas Purwokerto disajikan dengan ketupat dan mendoan', 'price' => 5000, 'image' => 'menus/pecel_mendoan.jpg'],
                    ['name' => 'Mendoan Ketupat 1 Porsi', 'description' => 'Ketupat lembut dengan lauk tempe mendoan hangat dan siraman bumbu kacang gurih', 'price' => 5000, 'image' => 'menus/pecel_mendoan.jpg'],
                ],
            ],
            [
                'kantin_index' => 2,
                'name' => 'Stand 5 (Jajanan Pasar Tradisional)',
                'description' => 'Stand kelima dari arah perpustakaan: aneka kue basah tradisional, jajanan pasar nusantara, dan es teh.',
                'user' => [
                    'name' => 'Penjual Stand 5',
                    'email' => 'stand5@kantin.smecone',
                    'password' => 'password',
                ],
                'menus' => [
                    ['name' => 'Risol Mayo', 'description' => 'Risol goreng isi smoked beef, telur, dan saus mayo creamy gurih', 'price' => 2000, 'image' => 'menus/risol_mayo.jpg'],
                    ['name' => 'Pastel', 'description' => 'Pastel goreng renyah isi bihun, wortel, dan ayam', 'price' => 2000, 'image' => 'menus/pastel.jpg'],
                    ['name' => 'Lemper Ayam', 'description' => 'Ketan gurih dibungkus daun pisang isi suwiran ayam gurih', 'price' => 2000, 'image' => 'menus/lemper.jpg'],
                    ['name' => 'Lumpia Goreng', 'description' => 'Lumpia goreng renyah isi rebung dan sayuran bumbu gurih', 'price' => 2000, 'image' => 'menus/lumpia.jpg'],
                    ['name' => 'Onde-onde', 'description' => 'Onde-onde wijen goreng lembut kenyal isi kacang hijau manis', 'price' => 1000, 'image' => 'menus/onde_onde.jpg'],
                    ['name' => 'Klepon', 'description' => 'Kue klepon ketan hijau bertabur kelapa parut dengan gula merah meletup di mulut', 'price' => 1000, 'image' => 'menus/klepon.jpg'],
                    ['name' => 'Kue Lapis', 'description' => 'Kue lapis tepung beras kenyal manis berlapis warna-warni', 'price' => 2000, 'image' => 'menus/kue_lapis.jpg'],
                    ['name' => 'Dadar Gulung', 'description' => 'Dadar gulung pandan hijau isi unti kelapa gula merah manis gurih', 'price' => 2000, 'image' => 'menus/dadar_gulung.jpg'],
                    ['name' => 'Tahu Isi', 'description' => 'Tahu goreng isi aneka sayuran gurih pedas renyah', 'price' => 1000, 'image' => 'menus/tahu_isi.jpg'],
                    ['name' => 'Pisang Goreng', 'description' => 'Pisang goreng krispi manis gurih hangat', 'price' => 2000, 'image' => 'menus/pisang_goreng.jpg'],
                    ['name' => 'Getuk', 'description' => 'Getuk lindri singkong manis gurih tabur kelapa parut', 'price' => 1000, 'image' => 'menus/getuk.jpg'],
                    ['name' => 'Es Teh', 'description' => 'Es teh manis segar melati', 'price' => 2500, 'image' => 'menus/es_teh.jpg'],
                ],
            ],
        ];

        // ── 3. Buat Kantin ──
        $createdKantins = [];
        foreach ($kantins as $kantinData) {
            $createdKantins[] = Kantin::create($kantinData);
        }

        // ── 4. Buat User Penjual, Kios, dan Menu ──
        foreach ($kioskData as $kiosk) {
            $penjual = User::create([
                'name' => $kiosk['user']['name'],
                'email' => $kiosk['user']['email'],
                'password' => Hash::make($kiosk['user']['password']),
                'role' => 'penjual',
            ]);

            $createdKiosk = Kiosk::create([
                'kantin_id' => $createdKantins[$kiosk['kantin_index']]->id,
                'user_id' => $penjual->id,
                'name' => $kiosk['name'],
                'description' => $kiosk['description'],
                'image' => null,
            ]);

            foreach ($kiosk['menus'] as $menu) {
                Menu::create([
                    'kiosk_id' => $createdKiosk->id,
                    'name' => $menu['name'],
                    'description' => $menu['description'],
                    'price' => $menu['price'],
                    'image' => $menu['image'] ?? null,
                ]);
            }
        }
    }
}
