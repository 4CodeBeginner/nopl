<?php

// Arahkan semua request ke public/index.php Laravel
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

if ($uri !== '/' && file_exists(__DIR__ . '/../public' . $uri)) {
    return false;
}

$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/../public/index.php';
$_SERVER['SCRIPT_NAME']     = '/index.php';

require __DIR__ . '/../public/index.php';
