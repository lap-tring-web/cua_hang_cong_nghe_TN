<?php
require __DIR__ . '/includes/init.php';
require_login();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('orders.php');
$id = filter_var(is_scalar($_POST['id'] ?? null) ? $_POST['id'] : '', FILTER_VALIDATE_INT);
try {
    $pdo->beginTransaction();
    $stmt = $pdo->prepare('SELECT id, status, payment_status FROM orders WHERE id = ? AND user_id = ? FOR UPDATE');
    $stmt->execute([$id, current_user()['id']]);
    $order = $stmt->fetch();
    if (!$order || $order['status'] !== 'pending') throw new RuntimeException('Chỉ có thể hủy đơn hàng của bạn khi đang chờ xử lý.');
    $stmt = $pdo->prepare('SELECT product_id, quantity FROM order_items WHERE order_id = ? ORDER BY product_id');
    $stmt->execute([$id]);
    $restore = $pdo->prepare('UPDATE products SET stock = stock + ? WHERE id = ?');
    foreach ($stmt->fetchAll() as $item) $restore->execute([$item['quantity'], $item['product_id']]);
    $stmt = $pdo->prepare("UPDATE orders SET status = 'cancelled', payment_status = ? WHERE id = ?");
    $stmt->execute([payment_status_after_cancel($order['payment_status']), $id]);
    $pdo->commit();
    set_flash('success', 'Đã hủy đơn hàng và hoàn lại tồn kho.' . ($order['payment_status'] === 'paid' ? ' Shop sẽ liên hệ để hoàn tiền cho bạn.' : ''));
} catch (Throwable $exception) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    if ($exception instanceof PDOException) { error_log($exception->getMessage()); set_flash('error', 'Chưa thể hủy đơn. Vui lòng thử lại.'); }
    else set_flash('error', $exception->getMessage());
}
redirect('orders.php');
