<?php

define('APP_NAME', 'Cửa hàng Công Nghệ Thịnh Nguyễn');
define('STUDENT_NAME', 'Nguyễn Ngô Quốc Thịnh');
define('STUDENT_ID', 'N25DTCN057');
define('STUDENT_CLASS', 'D25TXCN01-N');
define('STORE_EMAIL', 'nguyenngothinh669@gmail.com');
define('STORE_PHONE', '0343 180 715');
define('STORE_ADDRESS', '80/15B Hoàng Hoa Thám, Bình Thạnh, TP. Hồ Chí Minh');
// Receiver provided by the shop owner. QR is generated locally, without external APIs.
define('PAYMENT_BANK_BIN', '970418');
define('PAYMENT_BANK_NAME', 'BIDV');
define('PAYMENT_ACCOUNT_NUMBER', '8843681906');
define('PAYMENT_ACCOUNT_NAME', 'NGUYỄN NGÔ QUỐC THỊNH');
define('APP_DEBUG', getenv('MINISHOP_DEBUG') === '1');
$scriptDirectory = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/minishop/index.php'));
if (basename($scriptDirectory) === 'admin') {
    $scriptDirectory = str_replace('\\', '/', dirname($scriptDirectory));
}
$defaultBaseUrl = $scriptDirectory === '/' ? '/' : $scriptDirectory . '/';
define('BASE_URL', rtrim(getenv('MINISHOP_BASE_URL') ?: $defaultBaseUrl, '/') . '/');

define('DB_HOST', getenv('MINISHOP_DB_HOST') ?: 'localhost');
define('DB_PORT', getenv('MINISHOP_DB_PORT') ?: '3307');
define('DB_NAME', getenv('MINISHOP_DB_NAME') ?: 'thinh_tech');
define('DB_USER', getenv('MINISHOP_DB_USER') ?: 'root');
define('DB_PASS', getenv('MINISHOP_DB_PASS') ?: '');
