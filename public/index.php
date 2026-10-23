<?php
declare(strict_types=1);

// Forsiden til corinthian.no: bare logo og navn.

// Valgfri konfigurasjon (config/config.php ligger ikke i Git). Uten den virker siden som før.
$configFile = __DIR__ . '/../config/config.php';
$config = is_file($configFile) ? require $configFile : [];
$siteUrl = rtrim((string) ($config['url'] ?? ''), '/');

// Alt annet enn forsiden gir 404, så ingen gamle eller tilfeldige adresser viser siden
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$notFound = !in_array($path, ['/', '/index.php'], true);
if ($notFound) {
    http_response_code(404);
}

// Sikkerhet: bare egne filer, ingen innebygging i andre sider
header("Content-Security-Policy: default-src 'self'; img-src 'self' data:; style-src 'self'; font-src 'self'; script-src 'none'; base-uri 'none'; form-action 'none'; frame-ancestors 'none'");
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');

// Versjon i adressen, så nettleseren henter nytt stilark når det endres
$asset = static function (string $file): string {
    $full = __DIR__ . $file;
    return htmlspecialchars($file . (is_file($full) ? '?v=' . filemtime($full) : ''), ENT_QUOTES);
};

// App-ikonet ligger inne i siden, slik som på Huskdagen (iPhone henter det ellers ikke riktig)
$touchIcon = __DIR__ . '/apple-touch-icon.png';
$touchIconData = is_file($touchIcon) ? 'data:image/png;base64,' . base64_encode((string) file_get_contents($touchIcon)) : '';
?>
<!doctype html>
<html lang="no">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title><?= $notFound ? 'Fant ikke siden · Corinthian' : 'Corinthian' ?></title>
    <meta name="description" content="Corinthian">
    <meta name="theme-color" content="#14232A">
<?php if ($siteUrl !== ''): ?>
    <link rel="canonical" href="<?= htmlspecialchars($siteUrl . '/', ENT_QUOTES) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($siteUrl . '/', ENT_QUOTES) ?>">
<?php endif; ?>
    <meta property="og:title" content="Corinthian">
    <meta property="og:type" content="website">
    <link rel="icon" href="<?= $asset('/favicon.svg') ?>" type="image/svg+xml">
<?php if ($touchIconData !== ''): ?>
    <link rel="apple-touch-icon" href="<?= $touchIconData ?>">
<?php endif; ?>
    <link rel="preload" href="/assets/fonts/marcellus.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="<?= $asset('/assets/css/site.css') ?>">
</head>
<body>
    <main class="brand">
        <img class="brand-mark" src="<?= $asset('/assets/img/logo-mark.svg') ?>" alt="" width="64" height="72">
        <span class="brand-rule" aria-hidden="true"></span>
<?php if ($notFound): ?>
        <p class="brand-name">Corinthian</p>
        <h1 class="brand-note">Siden finnes ikke</h1>
        <a class="brand-link" href="/">Til forsiden</a>
<?php else: ?>
        <h1 class="brand-name">Corinthian</h1>
<?php endif; ?>
    </main>
</body>
</html>
