const webpush = require('web-push');
const keys = webpush.generateVAPIDKeys();
const fs = require('fs');
fs.writeFileSync('vapid_keys.json', JSON.stringify(keys, null, 2));
console.log('Public:', keys.publicKey);
console.log('Private:', keys.privateKey);
