<?php
// Router for PHP's local development server. Apache uses .htaccess instead.
$path = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');
if (preg_match('~^/(config|includes|database)(/|$)~i', $path) || preg_match('~/(\.[^/]+)(/|$)~', $path) || preg_match('~\.(sql|md|ps1|log)$~i', $path) || preg_match('~^/uploads/.*\.(php\d*|phtml|phar)(\.|$)~i', $path)) {
    $_SERVER['SCRIPT_NAME'] = '/403.php';
    require __DIR__ . '/includes/init.php';
    http_response_code(403);
    $pageTitle = 'Truy cập bị từ chối';
    require __DIR__ . '/includes/header.php';
    echo '<h1>403</h1><p>Thư mục này không cho phép truy cập trực tiếp.</p>';
    require __DIR__ . '/includes/footer.php';
    return true;
}
$file = realpath(__DIR__ . $path);
if ($path !== '/' && (!$file || !str_starts_with($file, __DIR__ . DIRECTORY_SEPARATOR) || is_dir($file))) {
    $_SERVER['SCRIPT_NAME'] = '/404.php';
    require __DIR__ . '/404.php';
    return true;
}
return false;
