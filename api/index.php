<?php

// Pastikan lokasi autoloader & file entry Laravel valid
$publicPath = __DIR__ . '/../public';

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Layani file statis jika ada di direktori public
if ($uri !== '/' && file_exists($publicPath . $uri)) {
    return false;
}

// Set script environment agar Laravel mengenali entry point
$_SERVER['SCRIPT_FILENAME'] = $publicPath . '/index.php';
$_SERVER['SCRIPT_NAME']     = '/index.php';

require $publicPath . '/index.php';
