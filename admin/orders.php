<?php
require __DIR__ . '/../includes/init.php';
require_admin();

$statuses = order_statuses();

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $orderIdInput = $_POST['order_id'] ?? null;
    $orderId = is_scalar($orderIdInput) ? filter_var($orderIdInput, FILTER_VALIDATE_INT) : false;
    $statusInput = $_POST['status'] ?? null;
    $newStatus = is_string($statusInput) ? $statusInput : '';

    if ($orderId === false || $orderId < 1 || !isset($statuses[$newStatus])) {
        set_flash('error', 'Mã đơn hàng hoặc trạng thái không hợp lệ.');
    } else {
        try {
        $pdo->beginTransaction();
        $exists = $pdo->prepare('SELECT status, payment_method, payment_status FROM orders WHERE id = ? FOR UPDATE');
        $exists->execute([$orderId]);
        $lockedOrder = $exists->fetch();
        $oldStatus = $lockedOrder['status'] ?? false;
        $allowed = ['pending' => ['shipping', 'cancelled'], 'shipping' => ['completed', 'cancelled'], 'completed' => [], 'cancelled' => []];
        if ($oldStatus === false) {
            set_flash('error', 'Không tìm thấy đơn hàng.');
        } elseif ($oldStatus !== $newStatus && !in_array($newStatus, $allowed[$oldStatus] ?? [], true)) {
            set_flash('error', 'Không thể chuyển trạng thái đơn hàng theo cách này.');
        } elseif ($oldStatus === $newStatus) {
            set_flash('success', 'Trạng thái đơn hàng không thay đổi.');
        } elseif ($lockedOrder['payment_method'] === 'bank_transfer' && $lockedOrder['payment_status'] !== 'paid' && in_array($newStatus, ['shipping', 'completed'], true)) {
            set_flash('error', 'Cần đối soát và xác nhận chuyển khoản trước khi giao hàng.');
        } else {
            $paymentStatus = $lockedOrder['payment_status'];
            if ($newStatus === 'cancelled') {
                $lines = $pdo->prepare('SELECT product_id, quantity FROM order_items WHERE order_id = ? ORDER BY product_id');
                $lines->execute([$orderId]);
                $restore = $pdo->prepare('UPDATE products SET stock = stock + ? WHERE id = ?');
                foreach ($lines->fetchAll() as $line) $restore->execute([$line['quantity'], $line['product_id']]);
                $paymentStatus = payment_status_after_cancel($paymentStatus);
            }
            $collectedCod = $newStatus === 'completed' && $lockedOrder['payment_method'] === 'cod';
            if ($collectedCod) $paymentStatus = 'paid';
            $update = $pdo->prepare('UPDATE orders SET status = ?, payment_status = ?, paid_at = IF(?, COALESCE(paid_at, NOW()), paid_at), payment_confirmed_by = IF(?, ?, payment_confirmed_by) WHERE id = ?');
            $update->execute([$newStatus, $paymentStatus, (int) $collectedCod, (int) $collectedCod, current_user()['id'], $orderId]);
            set_flash('success', 'Đã cập nhật trạng thái đơn hàng #' . $orderId . '.');
        }
        $pdo->commit();
        } catch (Throwable $exception) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            error_log($exception->getMessage());
            set_flash('error', 'Chưa thể cập nhật đơn hàng. Vui lòng thử lại.');
        }
    }
    redirect('admin/orders.php');
}

$filterInput = $_GET['status'] ?? '';
$filter = is_string($filterInput) && isset($statuses[$filterInput]) ? $filterInput : '';
if ($filter !== '') {
    $stmt = $pdo->prepare('SELECT * FROM orders WHERE status = ? ORDER BY id DESC');
    $stmt->execute([$filter]);
} else {
    $stmt = $pdo->query('SELECT * FROM orders ORDER BY id DESC');
}
$orders = $stmt->fetchAll();

$pageTitle = 'Quản lý đơn hàng';
require __DIR__ . '/../includes/header.php';
?>
<section class="admin-page">
    <div class="page-heading">
        <div>
            <h2>Quản lý đơn hàng</h2>
            <p class="muted">Theo dõi đơn và cập nhật tiến độ giao hàng. Đơn COD hoàn tất được ghi nhận đã thu tiền.</p>
        </div>
        <a href="<?= e(url('admin/products.php')) ?>" class="btn btn-quiet">Quản lý sản phẩm</a>
    </div>

    <nav class="category-bar status-filters" aria-label="Lọc đơn hàng">
        <a href="<?= e(url('admin/orders.php')) ?>" class="<?= $filter === '' ? 'active' : '' ?>">Tất cả</a>
        <?php foreach ($statuses as $value => $label): ?>
            <a href="<?= e(url('admin/orders.php?status=' . rawurlencode($value))) ?>"
               class="<?= $filter === $value ? 'active' : '' ?>"><?= e($label) ?></a>
        <?php endforeach; ?>
    </nav>

    <?php if (!$orders): ?>
        <div class="empty-state">
            <h3>Chưa có đơn hàng</h3>
            <p>Đơn hàng phù hợp sẽ xuất hiện tại đây.</p>
        </div>
    <?php else: ?>
        <div class="table-wrap">
            <table class="admin-table orders-table">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Ngày đặt</th>
                        <th>Người nhận</th>
                        <th>Tổng tiền</th>
                        <th>Thanh toán</th>
                        <th>Trạng thái</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?= (int) $order['id'] ?></td>
                            <td><?= e(date('d/m/Y H:i', strtotime($order['created_at']))) ?></td>
                            <td><?= e($order['fullname']) ?><span class="table-subtext"><?= e($order['phone']) ?></span></td>
                            <td><?= format_price($order['total']) ?></td>
                            <td><span class="payment-badge payment-badge-<?= e($order['payment_status']) ?>"><?= e(payment_status_label($order['payment_status'])) ?></span><span class="table-subtext"><?= $order['payment_method'] === 'cod' ? 'COD' : 'Chuyển khoản QR' ?></span><?php if ($order['payment_reference']): ?><span class="table-subtext"><?= e($order['payment_reference']) ?></span><?php endif; ?><a class="table-payment-link" href="<?= e(url('order-detail.php?id=' . (int) $order['id'] . '#payment')) ?>">Đối soát / xem thanh toán</a></td>
                            <td>
                                <form action="<?= e(url('admin/orders.php')) ?>" method="post" class="status-form">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="order_id" value="<?= (int) $order['id'] ?>">
                                    <select name="status" aria-label="Trạng thái đơn hàng #<?= (int) $order['id'] ?>">
                                        <?php foreach ($statuses as $value => $label): ?>
                                            <option value="<?= e($value) ?>"
                                                <?= $order['status'] === $value ? 'selected' : '' ?>>
                                                <?= e($label) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" class="btn btn-small">Lưu</button>
                                </form>
                            </td>
                            <td>
                                <a href="<?= e(url('order-detail.php?id=' . (int) $order['id'])) ?>">Xem đơn</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
