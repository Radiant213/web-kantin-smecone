<?php

// Load environment variables from Vercel
$_ENV['APP_KEY'] = getenv('APP_KEY') ?: $_ENV['APP_KEY'] ?? '';
$_ENV['APP_ENV'] = getenv('APP_ENV') ?: $_ENV['APP_ENV'] ?? 'production';
$_ENV['APP_DEBUG'] = getenv('APP_DEBUG') ?: $_ENV['APP_DEBUG'] ?? 'false';

// Forward Vercel requests to public/index.php
require __DIR__ . '/../public/index.php';
