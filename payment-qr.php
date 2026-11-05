<?php
require __DIR__ . '/includes/init.php';
require_login();
$input = $_GET['id'] ?? null;
$id = is_scalar($input) ? filter_var($input, FILTER_VALIDATE_INT) : false;
$stmt = $pdo->prepare('SELECT * FROM orders WHERE id = ?');
$stmt->execute([$id ?: 0]);
$order = $stmt->fetch();
if (!$order || ((int) $order['user_id'] !== (int) current_user()['id'] && !is_admin()) ||
    $order['payment_method'] !== 'bank_transfer' || $order['status'] === 'cancelled' ||
    !in_array($order['payment_status'], ['unpaid', 'reported'], true)) {
    http_response_code(404);
    exit('Không có mã QR thanh toán cho đơn hàng này.');
}
header('Content-Type: image/png');
header('Content-Disposition: attachment; filename="ThanhToan-' . $order['payment_reference'] . '.png"');
header('Cache-Control: no-store, private');
header('X-Content-Type-Options: nosniff');
echo payment_qr_png($order);
