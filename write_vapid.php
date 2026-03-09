<?php
$raw = file_get_contents('vapid_keys.json');
// Remove BOM
$raw = preg_replace('/\x{FEFF}/u', '', $raw);
$raw = ltrim($raw, "\xEF\xBB\xBF");
$j = json_decode($raw, true);
if (!$j) {
    // Try removing all non-ascii prefix
    $raw = substr($raw, strpos($raw, '{'));
    $j = json_decode($raw, true);
}

// Write to .env
$env = file_get_contents('.env');
if (strpos($env, 'VAPID_PUBLIC_KEY') === false) {
    $env .= "\nVAPID_PUBLIC_KEY=\"" . $j['publicKey'] . "\"";
    $env .= "\nVAPID_PRIVATE_KEY=\"" . $j['privateKey'] . "\"";
    $env .= "\n";
    file_put_contents('.env', $env);
    echo "VAPID keys written to .env" . PHP_EOL;
} else {
    echo "VAPID keys already in .env" . PHP_EOL;
}
echo "PUBLIC: " . $j['publicKey'] . PHP_EOL;
echo "PRIVATE: " . $j['privateKey'] . PHP_EOL;
