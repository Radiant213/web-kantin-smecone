import webpush from 'web-push';
import fs from 'fs';
const keys = webpush.generateVAPIDKeys();
fs.writeFileSync('vapid_keys.json', JSON.stringify(keys, null, 2));
console.log('Public:', keys.publicKey);
console.log('Private:', keys.privateKey);
