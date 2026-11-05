<?php
require __DIR__ . '/../includes/init.php';
require_admin();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('admin/orders.php');
$input = $_POST['order_id'] ?? null;
$orderId = is_scalar($input) ? filter_var($input, FILTER_VALIDATE_INT) : false;
$action = is_string($_POST['action'] ?? null) ? $_POST['action'] : '';
if (!$orderId || $orderId < 1 || !in_array($action, ['confirm_payment', 'confirm_refund'], true)) {
    set_flash('error', 'Yêu cầu cập nhật thanh toán không hợp lệ.');
    redirect('admin/orders.php');
}
try {
    $pdo->beginTransaction();
    $stmt = $pdo->prepare('SELECT * FROM orders WHERE id = ? FOR UPDATE');
    $stmt->execute([$orderId]);
    $order = $stmt->fetch();
    if (!$order) throw new RuntimeException('Không tìm thấy đơn hàng.');
    if ($action === 'confirm_refund') {
        if ($order['status'] !== 'cancelled' || $order['payment_status'] !== 'refund_pending') {
            throw new RuntimeException('Chỉ xác nhận hoàn tiền cho đơn đã hủy và đang chờ hoàn tiền.');
        }
        $pdo->prepare("UPDATE orders SET payment_status = 'refunded', refunded_at = NOW(), refund_confirmed_by = ? WHERE id = ?")
            ->execute([current_user()['id'], $orderId]);
        $message = 'Đã ghi nhận shop hoàn tiền cho đơn #' . $orderId . '.';
    } else {
        if (!in_array($order['payment_status'], ['unpaid', 'reported'], true) ||
            ($order['payment_method'] === 'cod' && $order['status'] !== 'completed')) {
            throw new RuntimeException('Không thể xác nhận thanh toán ở trạng thái hiện tại.');
        }
        $newStatus = $order['status'] === 'cancelled' ? 'refund_pending' : 'paid';
        $pdo->prepare('UPDATE orders SET payment_status = ?, paid_at = NOW(), payment_confirmed_by = ? WHERE id = ?')
            ->execute([$newStatus, current_user()['id'], $orderId]);
        $message = $newStatus === 'refund_pending'
            ? 'Đã ghi nhận tiền về cho đơn đã hủy #' . $orderId . '. Shop cần hoàn tiền cho khách.'
            : 'Đã xác nhận thanh toán đơn #' . $orderId . '.';
    }
    $pdo->commit();
    set_flash('success', $message);
} catch (Throwable $exception) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    if ($exception instanceof PDOException) {
        error_log($exception->getMessage());
        set_flash('error', 'Chưa cập nhật được thanh toán. Vui lòng thử lại.');
    } else set_flash('error', $exception->getMessage());
}
redirect('order-detail.php?id=' . $orderId);
