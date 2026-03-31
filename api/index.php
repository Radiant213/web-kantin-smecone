<?php
// Pastikan folder-folder temp yang dibutuhkan Laravel dibikin otomatis di Vercel (karena /tmp itu kosong setiap ada request baru)
$tempDirectories = [
    '/tmp/storage/framework/views',
    '/tmp/bootstrap/cache'
];

foreach ($tempDirectories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}
// Meneruskan request ke public/index.php bawaan Laravel
require __DIR__ . '/../public/index.php';
