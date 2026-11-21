import fs from 'node:fs';
import path from 'node:path';

const targetDirs = [
  path.resolve('storage/app/public/menus'),
  path.resolve('public/storage/menus')
];

// Ensure target directories exist
for (const dir of targetDirs) {
  if (!fs.existsSync(dir)) {
    fs.mkdirSync(dir, { recursive: true });
  }
}

const list = [
  // Kantin Corner
  { file: 'bakso.jpg', title: 'File:Bakso mi bihun.jpg' },
  { file: 'soto.jpg', title: 'File:Soto ayam.JPG' },
  { file: 'piscok.jpg', title: 'File:Pisang cokelat.jpg', q: 'pisang coklat' },
  { file: 'risol.jpg', title: 'File:Risole2.jpg' },
  { file: 'martabak_goreng.jpg', title: 'File:MartabakTelur.JPG' },
  { file: 'nasi_rames.jpg', title: 'File:Nasi Rames.JPG', q: 'nasi rames' },
  { file: 'cireng.jpg', title: 'File:Rujak cireng, Purwokerto 2015-03-22.jpg' },
  { file: 'seblak_kering.jpg', title: 'File:Basreng.jpg', q: 'kerupuk seblak pedas' },
  { file: 'usus_goreng.jpg', title: 'File:Kripik Usus Ayam.jpg' },
  { file: 'keripik_singkong.jpg', title: 'File:Tapioca Chips.jpg' },
  { file: 'teh_pucuk.jpg', title: 'File:Teh Botol Sosro.jpg', q: 'bottled iced tea' },
  { file: 'cimory.jpg', q: 'yogurt drink bottle' },
  { file: 'susu_milku.jpg', q: 'milk bottle carton' },
  { file: 'nipis_madu.jpg', q: 'lime iced juice drink' },
  { file: 'air_mineral.jpg', q: 'water bottle plastic mineral' },
  { file: 'snack_cheetos.jpg', q: 'cheese puff snack' },
  { file: 'snack_chitato.jpg', q: 'potato chips snack' },
  { file: 'snack_cookies.jpg', q: 'chocolate chip cookies snack' },
  { file: 'snack_chiki.jpg', q: 'cheese balls snack' },
  { file: 'snack_qtela.jpg', title: 'File:Tapioca chips 02.jpg' },

  // Kantin Pemasaran - Boszzfood
  { file: 'mie_instan.jpg', title: 'File:Indomie Mi goreng (03-07-2021).jpg' },
  { file: 'burger_kecil.jpg', q: 'mini burger slider' },
  { file: 'burger_besar.jpg', q: 'cheeseburger sesame bun' },
  { file: 'takoyaki.jpg', title: 'File:Takoyaki by yomi955.jpg' },
  { file: 'es_teh.jpg', title: 'File:ES TEH MANIS.jpg' },
  { file: 'pop_ice.jpg', q: 'blended smoothie plastic cup straw' },
  { file: 'bengbeng_drink.jpg', q: 'iced chocolate milk drink' },
  { file: 'chocolatos_drink.jpg', q: 'iced chocolate drink glass' },

  // Sosis Bakar Om Gun
  { file: 'sosis_kecil.jpg', title: 'File:Sosis bakar Skaten Solo.jpg' },
  { file: 'sosis_besar.jpg', title: 'File:Sosis bakar.jpg' },

  // "Es Tea" Mba Indah
  { file: 'matcha_drink.jpg', q: 'iced matcha green tea cup' },
  { file: 'thai_tea.jpg', q: 'thai iced tea cup' },
  { file: 'lemon_tea.jpg', q: 'iced lemon tea glass' },
  { file: 'nutrisari.jpg', q: 'iced orange drink glass' },
  { file: 'cibay.jpg', title: 'File:Cireng di kafe.jpg' },

  // Kantin Bu Sari
  { file: 'nasi_katsu.jpg', q: 'chicken katsu rice bowl' },
  { file: 'batagor.jpg', title: 'File:Batagor Savoy Homann Bandung.jpg' },
  { file: 'batagor_kuah.jpg', title: 'File:Batagor dan Bumbu Kacang.jpg' },
  { file: 'risol_matcha.jpg', title: 'File:Kue dadar gulung.JPG' },
  { file: 'risol_durian.jpg', title: 'File:Risole2.jpg' },
  { file: 'risol_cokelat.jpg', title: 'File:Risole2.jpg' },

  // Kantin Tante Mita
  { file: 'ayam_geprek.jpg', title: 'File:Ayam geprek.png' },
  { file: 'pentol_kuah.jpg', title: 'File:Pentol bakar.jpg', q: 'pentol bakso pedas' },
  { file: 'dimsum.jpg', title: 'File:Siomay Bandung.jpg', q: 'dim sum' },
  { file: 'seblak_kuah.jpg', title: 'File:Seblak 2.jpg' },
  { file: 'es_teler.jpg', title: 'File:Es Teller 77.jpg' },
  { file: 'mie_jebew.jpg', title: 'File:Mie aceh goreng.JPG', q: 'spicy noodle' },

  // Kantin 6CH
  { file: 'makaroni_pedas.jpg', q: 'spicy macaroni snack' },
  { file: 'basreng.jpg', title: 'File:Basreng.jpg' },
  { file: 'pop_mie.jpg', title: 'File:Instant noodles.jpg' },

  // Kantin Belakang (Lama)
  // Stand 1
  { file: 'mie_ayam.jpg', title: 'File:Mie ayam lima ribu rupiah.jpg' },

  // Stand 2
  { file: 'sempol.jpg', title: 'File:Sempol Beku di Car Free Day Jombang-2.jpg' },
  { file: 'cimol.jpg', title: 'File:Cimol.jpg' },
  { file: 'pangsit_goreng.jpg', title: 'File:Wonton 1.JPG' },

  // Stand 3
  { file: 'good_day.jpg', q: 'iced coffee cup' },
  { file: 'milo.jpg', q: 'iced chocolate milk drink' },

  // Stand 4
  { file: 'mendoan.jpg', title: 'File:Mendoan.jpg' },
  { file: 'pecel_mendoan.jpg', title: 'File:Pecel Hariadhi.JPG' },

  // Stand 5
  { file: 'risol_mayo.jpg', title: 'File:Risole2.jpg' },
  { file: 'pastel.jpg', title: 'File:Pastel isi sayur daging.JPG' },
  { file: 'lemper.jpg', title: 'File:Lemper.jpg' },
  { file: 'lumpia.jpg', title: 'File:Lumpia semarang.jpg', q: 'lumpia goreng' },
  { file: 'onde_onde.jpg', title: 'File:Indonesia onde-onde.jpg' },
  { file: 'klepon.jpg', title: 'File:Klepon Khas Tulungagung.jpg' },
  { file: 'kue_lapis.jpg', title: 'File:Kue Lapis.jpg' },
  { file: 'dadar_gulung.jpg', title: 'File:Kue dadar gulung.JPG' },
  { file: 'tahu_isi.jpg', title: 'File:Tahu isi goreng plus cabe rawit.jpg' },
  { file: 'pisang_goreng.jpg', title: 'File:Pisang goreng.jpg' },
  { file: 'getuk.jpg', title: 'File:Getuk 1.jpg' }
];

async function resolveUrl(item) {
  const headers = { 'User-Agent': 'SmeconeKantin/1.0 (https://kantin.radiantcode.web.id; galangmaruff1@gmail.com)' };
  
  if (item.title) {
    try {
      const api = 'https://commons.wikimedia.org/w/api.php?action=query&titles=' + encodeURIComponent(item.title) + '&prop=imageinfo&iiprop=url&iiurlwidth=800&format=json';
      const res = await fetch(api, { headers });
      const data = await res.json();
      const p = Object.values(data.query?.pages || {})[0];
      if (p && p.imageinfo && p.imageinfo[0]) {
        return p.imageinfo[0].thumburl || p.imageinfo[0].url;
      }
    } catch (e) {
      console.error(`Failed to resolve title ${item.title}:`, e.message);
    }
  }

  if (item.q) {
    try {
      const api = 'https://commons.wikimedia.org/w/api.php?action=query&generator=search&gsrsearch=' + encodeURIComponent(item.q) + '&gsrnamespace=6&gsrlimit=1&prop=imageinfo&iiprop=url&iiurlwidth=800&format=json';
      const res = await fetch(api, { headers });
      const data = await res.json();
      const p = Object.values(data.query?.pages || {})[0];
      if (p && p.imageinfo && p.imageinfo[0]) {
        return p.imageinfo[0].thumburl || p.imageinfo[0].url;
      }
    } catch (e) {
      console.error(`Failed to resolve search ${item.q}:`, e.message);
    }
  }

  return null;
}

async function downloadItem(item) {
  const url = await resolveUrl(item);
  if (!url) {
    console.error(`[ERR] No URL resolved for ${item.file}`);
    return false;
  }

  try {
    const res = await fetch(url, {
      headers: { 'User-Agent': 'SmeconeKantin/1.0 (https://kantin.radiantcode.web.id; galangmaruff1@gmail.com)' }
    });
    if (!res.ok) {
      console.error(`[ERR] Download HTTP ${res.status} for ${item.file}`);
      return false;
    }
    const buf = Buffer.from(await res.arrayBuffer());
    if (buf.length < 500) {
      console.error(`[ERR] Buffer too small (${buf.length} bytes) for ${item.file}`);
      return false;
    }

    for (const dir of targetDirs) {
      fs.writeFileSync(path.join(dir, item.file), buf);
    }
    console.log(`[OK] Saved ${item.file} (${buf.length} bytes)`);
    return true;
  } catch (err) {
    console.error(`[ERR] Exception downloading ${item.file}:`, err.message);
    return false;
  }
}

async function main() {
  console.log(`Starting authentic image downloads for ${list.length} menus...`);
  
  // Download in batches of 4 to respect rate limits
  const batchSize = 4;
  let successCount = 0;
  for (let i = 0; i < list.length; i += batchSize) {
    const batch = list.slice(i, i + batchSize);
    const results = await Promise.all(batch.map(item => downloadItem(item)));
    successCount += results.filter(Boolean).length;
    // short delay between batches
    await new Promise(r => setTimeout(r, 400));
  }

  console.log(`\n========================================`);
  console.log(`Finished! Successfully downloaded ${successCount}/${list.length} images.`);
  console.log(`========================================`);
}

main();
