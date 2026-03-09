<?php
$raw = file_get_contents('vapid_keys.json');
// Remove UTF-16 BOM and convert
$raw = mb_convert_encoding($raw, 'UTF-8', 'UTF-16LE');
if (strpos($raw, '{') !== false) {
    $raw = substr($raw, strpos($raw, '{'));
}
$j = json_decode($raw, true);
if ($j) {
    echo $j['publicKey'] . PHP_EOL;
    echo $j['privateKey'] . PHP_EOL;

    $env = file_get_contents('.env');
    $env = preg_replace('/\nVAPID_[A-Z_]+=.*/', '', $env);
    $env = rtrim($env) . "\n";
    $env .= 'VAPID_PUBLIC_KEY="' . $j['publicKey'] . '"' . "\n";
    $env .= 'VAPID_PRIVATE_KEY="' . $j['privateKey'] . '"' . "\n";
    file_put_contents('.env', $env);
    echo "DONE" . PHP_EOL;
} else {
    echo "FAILED: " . json_last_error_msg() . PHP_EOL;
}
