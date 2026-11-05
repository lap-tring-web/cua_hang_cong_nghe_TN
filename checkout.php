<?php
require __DIR__ . '/includes/init.php';
require_login();

[$items, $total] = get_cart_items($pdo);
if (!$items) {
    set_flash('error', 'Giỏ hàng đang trống.');
    redirect('cart.php');
}

// Điền sẵn thông tin nhận hàng từ tài khoản
$stmt = $pdo->prepare('SELECT fullname, phone, address FROM users WHERE id = ?');
$stmt->execute([current_user()['id']]);
$account = $stmt->fetch();

$errors = [];
$fullname = $account['fullname'];
$phone = $account['phone'];
$address = $account['address'];
$note = '';
$paymentMethod = 'cod';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim(is_string($_POST['fullname'] ?? null) ? $_POST['fullname'] : '');
    $phone = trim(is_string($_POST['phone'] ?? null) ? $_POST['phone'] : '');
    $address = trim(is_string($_POST['address'] ?? null) ? $_POST['address'] : '');
    $note = trim(is_string($_POST['note'] ?? null) ? $_POST['note'] : '');
    $paymentMethodInput = $_POST['payment_method'] ?? 'cod';
    $paymentMethod = is_string($paymentMethodInput) ? $paymentMethodInput : '';
    if (!isset(payment_methods()[$paymentMethod])) {
        $errors['payment_method'] = 'Vui lòng chọn phương thức thanh toán hợp lệ.';
    }

    if (mb_strlen($fullname) < 2 || mb_strlen($fullname) > 100) {
        $errors['fullname'] = 'Họ tên phải có từ 2 đến 100 ký tự.';
    }
    if (!preg_match('/^0[0-9]{9}$/', $phone)) {
        $errors['phone'] = 'Số điện thoại gồm 10 chữ số, bắt đầu bằng số 0.';
    }
    if (mb_strlen($address) < 10 || mb_strlen($address) > 255) {
        $errors['address'] = 'Địa chỉ phải có từ 10 đến 255 ký tự.';
    }
    if (mb_strlen($note) > 500) {
        $errors['note'] = 'Ghi chú không quá 500 ký tự.';
    }

    if (!$errors) {
        try {
            $pdo->beginTransaction();

            // 1. Khóa từng dòng sản phẩm, đọc lại giá và tồn kho mới nhất
            $lock = $pdo->prepare('SELECT id, name, price, stock FROM products WHERE id = ? FOR UPDATE');
            $lines = [];
            $orderTotal = 0;
            $cart = $_SESSION['cart'];
            ksort($cart, SORT_NUMERIC);
            foreach ($cart as $productId => $quantity) {
                $lock->execute([$productId]);
                $product = $lock->fetch();
                if (!$product) {
                    throw new RuntimeException('Một sản phẩm trong giỏ không còn được bán.');
                }
                if (!is_int($quantity) || $quantity < 1 || $product['stock'] < $quantity) {
                    throw new RuntimeException(
                        'Sản phẩm "' . $product['name'] . '" chỉ còn ' . $product['stock'] . ' cái.'
                    );
                }
                $product['quantity'] = $quantity;
                $lines[] = $product;
                $orderTotal += $product['price'] * $quantity;
            }

            // 2. Ghi đơn hàng
            $stmt = $pdo->prepare(
                'INSERT INTO orders (user_id, fullname, phone, address, note, total, payment_method,
                 payment_bank_bin, payment_bank_name, payment_account_number, payment_account_name)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
            );
            $bankTransfer = $paymentMethod === 'bank_transfer';
            $stmt->execute([current_user()['id'], $fullname, $phone, $address, $note, $orderTotal, $paymentMethod,
                $bankTransfer ? PAYMENT_BANK_BIN : null, $bankTransfer ? PAYMENT_BANK_NAME : null,
                $bankTransfer ? PAYMENT_ACCOUNT_NUMBER : null, $bankTransfer ? PAYMENT_ACCOUNT_NAME : null]);
            $orderId = (int) $pdo->lastInsertId();
            if ($bankTransfer) {
                $reference = 'TN' . str_pad((string) $orderId, 6, '0', STR_PAD_LEFT);
                $pdo->prepare('UPDATE orders SET payment_reference = ? WHERE id = ?')->execute([$reference, $orderId]);
            }

            // 3. Ghi từng dòng hàng và trừ tồn kho
            $insertItem = $pdo->prepare(
                'INSERT INTO order_items (order_id, product_id, product_name, price, quantity)
                 VALUES (?, ?, ?, ?, ?)'
            );
            $reduceStock = $pdo->prepare('UPDATE products SET stock = stock - ? WHERE id = ?');
            foreach ($lines as $line) {
                $insertItem->execute([$orderId, $line['id'], $line['name'], $line['price'], $line['quantity']]);
                $reduceStock->execute([$line['quantity'], $line['id']]);
            }

            // 4. Mọi thứ thành công: xác nhận giao dịch
            $pdo->commit();

            unset($_SESSION['cart']);
            set_flash('success', 'Đặt hàng thành công. Mã đơn hàng của bạn là #' . $orderId . '.');
            redirect('order-detail.php?id=' . $orderId);
        } catch (PDOException $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            error_log($e->getMessage());
            $errors['order'] = 'Chưa thể xử lý đơn hàng. Vui lòng thử lại.';
        } catch (RuntimeException $e) {
            // Lỗi nghiệp vụ (hết hàng...): hủy mọi thay đổi và báo cho người dùng
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            $errors['order'] = $e->getMessage();
        }
    }
}

$pageTitle = 'Đặt hàng';
require __DIR__ . '/includes/header.php';
?>
<div class="page-heading"><div><p class="section-kicker">HOÀN TẤT MUA SẮM</p><h1>Đặt hàng & thanh toán</h1><p class="muted">Kiểm tra đơn hàng, thông tin nhận hàng và chọn cách thanh toán phù hợp.</p></div></div>

<?php if (isset($errors['order'])): ?>
    <p class="alert alert-error"><?= e($errors['order']) ?></p>
<?php endif; ?>

<h3>Đơn hàng của bạn</h3>
<div class="table-wrap">
<table>
    <thead>
        <tr>
            <th>Sản phẩm</th>
            <th>Đơn giá</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?= e($item['name']) ?></td>
                <td><?= format_price($item['price']) ?></td>
                <td><?= $item['quantity'] ?></td>
                <td><?= format_price($item['line_total']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3">Tổng cộng</th>
            <th><?= format_price($total) ?></th>
        </tr>
    </tfoot>
</table>
</div>

<h3>Thông tin nhận hàng</h3>
<form action="<?= e(url('checkout.php')) ?>" method="post" class="form checkout-form">
    <?= csrf_field() ?>
    <p>
        <label for="fullname">Người nhận</label><br>
        <input type="text" id="fullname" name="fullname" value="<?= e($fullname) ?>" required>
        <span class="error"><?= e($errors['fullname'] ?? '') ?></span>
    </p>
    <p>
        <label for="phone">Số điện thoại</label><br>
        <input type="tel" id="phone" name="phone" value="<?= e($phone) ?>" required>
        <span class="error"><?= e($errors['phone'] ?? '') ?></span>
    </p>
    <p>
        <label for="address">Địa chỉ nhận hàng</label><br>
        <textarea id="address" name="address" rows="3" required><?= e($address) ?></textarea>
        <span class="error"><?= e($errors['address'] ?? '') ?></span>
    </p>
    <p>
        <label for="note">Ghi chú</label><br>
        <textarea id="note" name="note" rows="2"><?= e($note) ?></textarea>
        <span class="error"><?= e($errors['note'] ?? '') ?></span>
    </p>
    <fieldset class="payment-methods" aria-describedby="payment-method-error">
        <legend>Phương thức thanh toán</legend>
        <label class="payment-option" for="payment-cod"><input type="radio" id="payment-cod" name="payment_method" value="cod" required <?= $paymentMethod === 'cod' ? 'checked' : '' ?>><span class="payment-option-icon" aria-hidden="true">₫</span><span><strong>Thanh toán khi nhận hàng</strong><small>Trả tiền trực tiếp cho nhân viên giao hàng (COD).</small></span></label>
        <label class="payment-option" for="payment-bank"><input type="radio" id="payment-bank" name="payment_method" value="bank_transfer" required <?= $paymentMethod === 'bank_transfer' ? 'checked' : '' ?>><span class="payment-option-icon" aria-hidden="true">QR</span><span><strong>Chuyển khoản ngân hàng</strong><small>Quét QR bằng ứng dụng ngân hàng, shop xác nhận tiền về.</small></span></label>
        <span class="error" id="payment-method-error"><?= e($errors['payment_method'] ?? '') ?></span>
        <p class="payment-method-note">Nếu chọn chuyển khoản, mã QR kèm số tiền và nội dung chuyển khoản sẽ xuất hiện sau khi xác nhận đặt hàng.</p>
    </fieldset>
    <p class="checkout-total">Tổng thanh toán <strong><?= format_price($total) ?></strong></p>
    <p>
        <button type="submit" class="btn btn-accent">Xác nhận đặt hàng</button>
        <a href="<?= e(url('cart.php')) ?>">Quay lại giỏ hàng</a>
    </p>
</form>
<?php require __DIR__ . '/includes/footer.php'; ?>
