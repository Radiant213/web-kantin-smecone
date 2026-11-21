import fs from 'node:fs';
import path from 'node:path';

const targetDirs = [
  path.resolve('storage/app/public/menus'),
  path.resolve('public/storage/menus')
];

// Mapping of filename to curated Unsplash photo ID
const photos = {
  'bakso.jpg': 'photo-1569718212165-3a8278d5f624', // Meatball noodle soup
  'soto.jpg': 'photo-1547928576-a4a33237cbc3', // Asian chicken soup
  'piscok.jpg': 'photo-1528735602780-2552fd46c7af', // Banana chocolate roll/fry
  'risol.jpg': 'photo-1544025162-d76694265947', // Spring roll / risoles
  'risol_matcha.jpg': 'photo-1505253758473-96b3015f27eb', // Green dessert pastry
  'risol_durian.jpg': 'photo-1567620905732-2d1ec7ab7445', // Golden pancake/pastry
  'risol_cokelat.jpg': 'photo-1606313564200-e75d5e30476c', // Chocolate roll / churro
  'martabak_goreng.jpg': 'photo-1601050690597-df0568f70950', // Fried stuffed flatbread
  'nasi_rames.jpg': 'photo-1546069901-ba9599a7e63c', // Mixed rice bowl
  'cireng.jpg': 'photo-1626777552726-4a6b54c97e46', // Fried snack
  'seblak_kering.jpg': 'photo-1566478989037-eec170784d0b', // Crispy crackers snack
  'usus_goreng.jpg': 'photo-1562967914-608f82629710', // Crispy fried strips
  'keripik_singkong.jpg': 'photo-1527515637462-cff94eecc1ac', // Chips
  'teh_pucuk.jpg': 'photo-1556679343-c7306c1976bc', // Bottled ice tea
  'cimory.jpg': 'photo-1553530666-ba11a7da3888', // Yogurt drink bottle
  'susu_milku.jpg': 'photo-1550583724-b2692b85b150', // Milk bottle
  'nipis_madu.jpg': 'photo-1513558161293-cdaf765ed2fd', // Citrus juice drink
  'air_mineral.jpg': 'photo-1523362628745-0c100150b504', // Mineral water
  'snack_cheetos.jpg': 'photo-1582293041079-7814c2f12063', // Cheesy chips snack
  'snack_chitato.jpg': 'photo-1566478989037-eec170784d0b', // Potato chips
  'snack_cookies.jpg': 'photo-1499636136210-6f4ee915583e', // Cookies
  'snack_chiki.jpg': 'photo-1582293041079-7814c2f12063', // Snack puffs
  'snack_qtela.jpg': 'photo-1527515637462-cff94eecc1ac', // Singkong chips
  'mie_instan.jpg': 'photo-1612927601601-6638404737ce', // Indomie noodles with egg
  'burger_kecil.jpg': 'photo-1550547660-d9450f859349', // Mini burger
  'burger_besar.jpg': 'photo-1568901346375-23c9450c58cd', // Gourmet burger
  'takoyaki.jpg': 'photo-1569058242567-93de6f36f8e6', // Takoyaki balls
  'es_teh.jpg': 'photo-1556679343-c7306c1976bc', // Fresh iced tea
  'pop_ice.jpg': 'photo-1572490122747-3968b75cc699', // Milkshake/blended smoothie
  'bengbeng_drink.jpg': 'photo-1541658016709-82535e94bc69', // Chocolate iced drink
  'chocolatos_drink.jpg': 'photo-1579954115563-e72bf1381629', // Rich iced chocolate
  'nutrisari.jpg': 'photo-1613478223719-2ab802602423', // Iced orange drink
  'good_day.jpg': 'photo-1517701550927-30cf4ba1dba5', // Iced coffee
  'milo.jpg': 'photo-1541658016709-82535e94bc69', // Iced chocolate malt
  'sosis_kecil.jpg': 'photo-1597404294360-feeeda04612e', // Grilled sausages
  'sosis_besar.jpg': 'photo-1597404294360-feeeda04612e', // Jumbo sausage
  'matcha_drink.jpg': 'photo-1536256263959-770b48d82b0a', // Iced matcha latte
  'thai_tea.jpg': 'photo-1576092768241-dec231879fc3', // Iced thai tea
  'lemon_tea.jpg': 'photo-1513558161293-cdaf765ed2fd', // Iced lemon tea
  'cibay.jpg': 'photo-1626777552726-4a6b54c97e46', // Fried aci snack
  'nasi_katsu.jpg': 'photo-1604908176997-125f25cc6f3d', // Chicken katsu rice
  'batagor.jpg': 'photo-1541544741938-0af808871cc0', // Fried dumplings with peanut sauce
  'batagor_kuah.jpg': 'photo-1569718212165-3a8278d5f624', // Dumplings in soup
  'ayam_geprek.jpg': 'photo-1626082927389-6cd097cdc6ec', // Spicy fried chicken
  'pentol_kuah.jpg': 'photo-1569718212165-3a8278d5f624', // Spicy meatballs
  'dimsum.jpg': 'photo-1563245372-f21724e3856d', // Dim sum basket
  'seblak_kuah.jpg': 'photo-1569718212165-3a8278d5f624', // Spicy red soup
  'es_teler.jpg': 'photo-1546069901-ba9599a7e63c', // Mixed fruit dessert
  'mie_jebew.jpg': 'photo-1612927601601-6638404737ce', // Ultra spicy noodles
  'makaroni_pedas.jpg': 'photo-1566478989037-eec170784d0b', // Spicy macaroni
  'basreng.jpg': 'photo-1566478989037-eec170784d0b', // Spicy fried meatballs
  'pop_mie.jpg': 'photo-1612927601601-6638404737ce', // Cup noodle
  'mie_ayam.jpg': 'photo-1569718212165-3a8278d5f624', // Chicken noodles
  'sempol.jpg': 'photo-1597404294360-feeeda04612e', // Fried meat skewer
  'cimol.jpg': 'photo-1626777552726-4a6b54c97e46', // Fried tapioca balls
  'pangsit_goreng.jpg': 'photo-1541544741938-0af808871cc0', // Crispy fried wontons
  'mendoan.jpg': 'photo-1606471191009-63994c53433b', // Tempeh mendoan
  'pecel_mendoan.jpg': 'photo-1546069901-ba9599a7e63c', // Indonesian salad with tempeh
  'risol_mayo.jpg': 'photo-1544025162-d76694265947', // Risoles mayo
  'pastel.jpg': 'photo-1628294895950-9805252327bc', // Empanada / pastel
  'lemper.jpg': 'photo-1505253758473-96b3015f27eb', // Sticky rice roll
  'lumpia.jpg': 'photo-1544025162-d76694265947', // Spring roll
  'onde_onde.jpg': 'photo-1505253758473-96b3015f27eb', // Sesame balls
  'klepon.jpg': 'photo-1505253758473-96b3015f27eb', // Traditional sweet rice cake
  'kue_lapis.jpg': 'photo-1505253758473-96b3015f27eb', // Layer cake
  'dadar_gulung.jpg': 'photo-1505253758473-96b3015f27eb', // Green rolled crepe
  'tahu_isi.jpg': 'photo-1606471191009-63994c53433b', // Stuffed tofu
  'pisang_goreng.jpg': 'photo-1528735602780-2552fd46c7af', // Fried banana
  'getuk.jpg': 'photo-1505253758473-96b3015f27eb' // Traditional cassava cake
};

async function downloadPhoto(filename, photoId) {
  const url = `https://images.unsplash.com/${photoId}?w=600&auto=format&fit=crop&q=80`;
  const primaryPath = path.join(targetDirs[0], filename);
  
  if (fs.existsSync(primaryPath) && fs.statSync(primaryPath).size > 1000) {
    // Already downloaded, just copy to secondary target
    fs.copyFileSync(primaryPath, path.join(targetDirs[1], filename));
    return;
  }

  try {
    const res = await fetch(url);
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    const buffer = Buffer.from(await res.arrayBuffer());
    
    for (const dir of targetDirs) {
      fs.writeFileSync(path.join(dir, filename), buffer);
    }
    console.log(`[OK] Downloaded: ${filename} (${buffer.length} bytes)`);
  } catch (err) {
    console.error(`[ERR] Failed ${filename}:`, err.message);
  }
}

async function main() {
  console.log('Starting parallel download of menu images...');
  const entries = Object.entries(photos);
  
  // Download in chunks of 5 for safety and speed
  const chunkSize = 5;
  for (let i = 0; i < entries.length; i += chunkSize) {
    const chunk = entries.slice(i, i + chunkSize);
    await Promise.all(chunk.map(([filename, photoId]) => downloadPhoto(filename, photoId)));
  }
  console.log('All menu image downloads complete!');
}

main();
