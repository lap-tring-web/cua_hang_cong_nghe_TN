<?php
require __DIR__ . '/includes/init.php';
require_login();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('orders.php');
$input = $_POST['order_id'] ?? null;
$orderId = is_scalar($input) ? filter_var($input, FILTER_VALIDATE_INT) : false;
if (!$orderId || $orderId < 1) {
    set_flash('error', 'Mã đơn hàng không hợp lệ.');
    redirect('orders.php');
}
try {
    $pdo->beginTransaction();
    $stmt = $pdo->prepare('SELECT * FROM orders WHERE id = ? AND user_id = ? FOR UPDATE');
    $stmt->execute([$orderId, current_user()['id']]);
    $order = $stmt->fetch();
    if (!$order || $order['payment_method'] !== 'bank_transfer' ||
        !in_array($order['payment_status'], ['unpaid', 'reported'], true)) {
        throw new RuntimeException('Không thể gửi thông báo chuyển khoản cho đơn hàng này.');
    }
    // Allow reporting a late transfer after cancellation so the shop can reconcile/refund it.
    if ($order['payment_status'] === 'unpaid') {
        $pdo->prepare("UPDATE orders SET payment_status = 'reported', payment_reported_at = NOW() WHERE id = ?")
            ->execute([$orderId]);
    }
    $pdo->commit();
    set_flash('success', 'Đã gửi thông báo chuyển khoản. Shop sẽ đối soát tiền về; đơn hàng chưa được xác nhận thanh toán.');
} catch (Throwable $exception) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    if ($exception instanceof PDOException) {
        error_log($exception->getMessage());
        set_flash('error', 'Chưa gửi được thông báo. Vui lòng thử lại.');
    } else set_flash('error', $exception->getMessage());
}
redirect('order-detail.php?id=' . $orderId);
