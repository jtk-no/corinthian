<?php
// Bare for lokal testing: php -S localhost:8000 -t public bin/dev-router.php
// Ekte filer (stilark, bilder, skrift) sendes som de er; alt annet går til index.php.
$file = __DIR__ . '/../public' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if ($_SERVER['REQUEST_URI'] !== '/' && is_file($file)) {
    return false;
}
require __DIR__ . '/../public/index.php';
