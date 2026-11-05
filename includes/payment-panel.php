<?php
$isBankPayment = $order['payment_method'] === 'bank_transfer';
$isOrderOwner = (int) $order['user_id'] === (int) current_user()['id'];
$showQr = $isBankPayment && $order['status'] !== 'cancelled' && in_array($order['payment_status'], ['unpaid', 'reported'], true);
$receiver = payment_receiver($order);
?>
<section id="payment" class="payment-panel" aria-labelledby="payment-title">
    <div class="payment-panel-heading"><div><p class="section-kicker">THANH TOÁN ĐƠN HÀNG</p><h2 id="payment-title"><?= e(payment_methods()[$order['payment_method']]) ?></h2></div><span class="payment-badge payment-badge-<?= e($order['payment_status']) ?>"><?= e(payment_status_label($order['payment_status'])) ?></span></div>
    <?php if ($showQr): ?>
        <div class="bank-payment-layout">
            <div class="payment-qr-card"><span class="qr-bank-label"><?= e($receiver['bank_name']) ?> <span>VietQR</span></span><?= payment_qr_svg($order) ?><p>Quét bằng ứng dụng ngân hàng</p><a class="btn btn-quiet btn-small" href="<?= e(url('payment-qr.php?id=' . (int) $order['id'])) ?>" download>Tải mã QR</a></div>
            <div class="bank-payment-info"><p class="payment-amount-label">Số tiền cần chuyển</p><p class="payment-amount"><?= format_price($order['total']) ?></p>
                <dl class="bank-details"><div><dt>Ngân hàng</dt><dd><?= e($receiver['bank_name']) ?></dd></div><div><dt>Chủ tài khoản</dt><dd><?= e($receiver['account_name']) ?></dd></div><div><dt>Số tài khoản</dt><dd><strong><?= e($receiver['account_number']) ?></strong><button type="button" class="copy-button" data-copy="<?= e($receiver['account_number']) ?>" aria-label="Sao chép số tài khoản">Sao chép</button></dd></div><div><dt>Nội dung chuyển khoản</dt><dd><strong><?= e($order['payment_reference']) ?></strong><button type="button" class="copy-button" data-copy="<?= e($order['payment_reference']) ?>" aria-label="Sao chép nội dung chuyển khoản">Sao chép</button></dd></div></dl>
                <ol class="payment-steps"><li>Mở ứng dụng ngân hàng và quét hoặc tải ảnh QR.</li><li>Kiểm tra đúng tên người nhận, số tiền và nội dung trên trước khi chuyển.</li><li>Sau khi chuyển khoản, gửi thông báo để shop đối soát.</li></ol>
                <p class="payment-copy-status" role="status" aria-live="polite"></p>
                <?php if ($isOrderOwner && $order['payment_status'] === 'unpaid'): ?><form action="<?= e(url('payment-report.php')) ?>" method="post" class="payment-report-form"><?= csrf_field() ?><input type="hidden" name="order_id" value="<?= (int) $order['id'] ?>"><button class="btn" type="submit">Tôi đã chuyển khoản</button><small>Nút này thông báo cho shop, chưa xác nhận đã nhận tiền.</small></form><?php endif; ?>
                <?php if ($order['payment_status'] === 'reported'): ?><p class="payment-notice">Bạn đã thông báo chuyển khoản. Shop đang kiểm tra tiền về; vui lòng không thanh toán lần nữa.</p><?php endif; ?>
            </div>
        </div>
    <?php elseif ($order['payment_status'] === 'refund_pending'): ?>
        <p class="payment-notice">Đơn hàng đã hủy và đang chờ shop hoàn tiền. Shop sẽ liên hệ để xác nhận thông tin hoàn tiền; việc hủy đơn chưa chuyển tiền về tài khoản của bạn.</p>
    <?php elseif ($order['payment_status'] === 'refunded'): ?>
        <p class="payment-notice">Shop đã ghi nhận hoàn tiền<?= $order['refunded_at'] ? ' lúc ' . e(date('d/m/Y H:i', strtotime($order['refunded_at']))) : '' ?>. Nếu chưa nhận được, vui lòng liên hệ cửa hàng.</p>
    <?php elseif ($order['status'] === 'cancelled'): ?>
        <p class="payment-notice">Đơn hàng đã hủy. Vui lòng không chuyển khoản cho đơn này. Nếu bạn đã chuyển tiền, thông báo cho shop để đối soát và hoàn tiền.</p>
        <?php if ($isOrderOwner && $isBankPayment && $order['payment_status'] === 'unpaid'): ?><form action="<?= e(url('payment-report.php')) ?>" method="post"><?= csrf_field() ?><input type="hidden" name="order_id" value="<?= (int) $order['id'] ?>"><button class="btn btn-quiet" type="submit">Tôi đã chuyển khoản trước khi hủy</button></form><?php endif; ?>
        <?php if ($order['payment_status'] === 'reported'): ?><p class="payment-notice">Shop đã nhận thông báo chuyển khoản và sẽ đối soát khoản tiền của đơn đã hủy.</p><?php endif; ?>
    <?php elseif ($order['payment_status'] === 'paid'): ?>
        <p class="payment-notice payment-notice-success">Shop đã xác nhận nhận đủ <?= format_price($order['total']) ?><?= $order['paid_at'] ? ' lúc ' . e(date('d/m/Y H:i', strtotime($order['paid_at']))) : '' ?>. Bạn không cần thanh toán thêm cho đơn hàng này.</p>
    <?php else: ?>
        <p class="payment-notice">Bạn thanh toán <strong><?= format_price($order['total']) ?></strong> trực tiếp cho nhân viên giao hàng khi nhận sản phẩm. Không cần chuyển khoản trước.</p>
    <?php endif; ?>
    <?php if (is_admin()): ?>
        <div class="payment-admin"><h3>Đối soát thanh toán</h3>
        <?php if (in_array($order['payment_status'], ['unpaid', 'reported'], true) && ($isBankPayment || $order['status'] === 'completed')): ?>
            <p>Kiểm tra giao dịch thực tế, đúng số tiền <?= format_price($order['total']) ?><?= $order['payment_reference'] ? ' và nội dung ' . e($order['payment_reference']) : '' ?> trước khi xác nhận.</p>
            <form action="<?= e(url('admin/payment-update.php')) ?>" method="post" data-confirm="Bạn đã kiểm tra và nhận đủ tiền thực tế của đơn #<?= (int) $order['id'] ?>?">
                <?= csrf_field() ?><input type="hidden" name="order_id" value="<?= (int) $order['id'] ?>"><input type="hidden" name="action" value="confirm_payment"><button type="submit" class="btn">Xác nhận đã nhận tiền</button>
            </form>
        <?php elseif ($order['payment_status'] === 'refund_pending'): ?>
            <p>Thực hiện hoàn tiền <?= format_price($order['total']) ?> cho khách qua ngân hàng trước khi ghi nhận tại đây.</p>
            <form action="<?= e(url('admin/payment-update.php')) ?>" method="post" data-confirm="Bạn đã hoàn đủ tiền thực tế cho khách của đơn #<?= (int) $order['id'] ?>?">
                <?= csrf_field() ?><input type="hidden" name="order_id" value="<?= (int) $order['id'] ?>"><input type="hidden" name="action" value="confirm_refund"><button type="submit" class="btn">Xác nhận đã hoàn tiền</button>
            </form>
        <?php else: ?><p>Chưa có thao tác thanh toán cần đối soát tại thời điểm này.</p><?php endif; ?>
        </div>
    <?php endif; ?>
    <p class="payment-support">Cần hỗ trợ? <a href="tel:0343180715"><?= e(STORE_PHONE) ?></a> · <a href="<?= e(url('contact.php')) ?>">Liên hệ cửa hàng</a></p>
</section>
