<?php
// Generate ECDSA P-256 key pair for VAPID
$config = [
    'curve_name' => 'prime256v1',
    'private_key_type' => OPENSSL_KEYTYPE_EC,
];
$key = openssl_pkey_new($config);
if (!$key) {
    echo "openssl_pkey_new failed: " . openssl_error_string() . PHP_EOL;
    exit(1);
}
$details = openssl_pkey_get_details($key);

$pubX = $details['ec']['x'];
$pubY = $details['ec']['y'];
$privD = $details['ec']['d'];

$publicKeyRaw = chr(4) . $pubX . $pubY;

$publicKey = rtrim(strtr(base64_encode($publicKeyRaw), '+/', '-_'), '=');
$privateKey = rtrim(strtr(base64_encode($privD), '+/', '-_'), '=');

echo "VAPID_PUBLIC_KEY=" . $publicKey . PHP_EOL;
echo "VAPID_PRIVATE_KEY=" . $privateKey . PHP_EOL;

$env = file_get_contents('.env');
$env = preg_replace('/\nVAPID_PUBLIC_KEY=.*/', '', $env);
$env = preg_replace('/\nVAPID_PRIVATE_KEY=.*/', '', $env);
$env = rtrim($env) . "\n";
$env .= 'VAPID_PUBLIC_KEY="' . $publicKey . '"' . "\n";
$env .= 'VAPID_PRIVATE_KEY="' . $privateKey . '"' . "\n";
file_put_contents('.env', $env);
echo "Written to .env!" . PHP_EOL;
