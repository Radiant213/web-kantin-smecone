<?php
$raw = file_get_contents('vapid_keys.json');
$raw = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $raw);
$j = json_decode($raw, true);
if ($j) {
    echo 'PUB: ' . $j['publicKey'] . PHP_EOL;
    echo 'PRI: ' . $j['privateKey'] . PHP_EOL;
} else {
    echo 'PARSE_FAIL' . PHP_EOL;
    echo 'RAW: ' . bin2hex(substr($raw, 0, 10)) . PHP_EOL;
}
