<?php
require 'vendor/autoload.php';
$keys = Minishlink\WebPush\VAPID::createVapidKeys();
echo 'PUBLIC=' . $keys['publicKey'] . PHP_EOL;
echo 'PRIVATE=' . $keys['privateKey'] . PHP_EOL;
