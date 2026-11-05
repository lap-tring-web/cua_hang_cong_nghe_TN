<?php
// Tệp khởi động: mọi trang đều nạp tệp này ở dòng đầu tiên.

require_once __DIR__ . '/../config/config.php';

// Hiển thị lỗi khi phát triển, ẩn lỗi và ghi nhật ký khi chạy thật
error_reporting(E_ALL);
ini_set('display_errors', APP_DEBUG ? '1' : '0');
ini_set('log_errors', '1');

// Session: cookie chỉ dành cho HTTP, không cho JavaScript đọc
session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax', 'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off']);
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_name('THINHTECHSESSID');
session_start();

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/avatars.php';
require_once __DIR__ . '/payments.php';
require_once __DIR__ . '/../config/db.php';

// Keep the name/avatar current across pages and other sessions of this account.
if (is_logged_in()) {
    $userStatement = $pdo->prepare('SELECT id, fullname, role, avatar FROM users WHERE id = ?');
    $userStatement->execute([current_user()['id']]);
    $sessionUser = $userStatement->fetch();
    if ($sessionUser) $_SESSION['user'] = $sessionUser;
    else unset($_SESSION['user']);
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    csrf_verify();
}
