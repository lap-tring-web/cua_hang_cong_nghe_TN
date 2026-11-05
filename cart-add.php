<?php
require __DIR__ . '/includes/init.php';

$jsonRequest = str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');
$returnInput = $_POST['return_to'] ?? '';
$returnTo = is_string($returnInput) && strlen($returnInput) <= 2048 && !preg_match('/[\x00-\x20\x7f]/', $returnInput)
    && preg_match('~^(?:index\.php(?:\?[^#\r\n]*)?(?:#products)?|product\.php\?id=[1-9][0-9]*)$~D', $returnInput)
    ? $returnInput : 'index.php';
$respond = static function ($success, $message, $status = 200, $added = 0) use ($jsonRequest, $returnTo) {
    if ($jsonRequest) json_response(['success' => $success, 'message' => $message, 'cart_count' => cart_count(), 'added_quantity' => $added], $status);
    set_flash($success ? 'success' : 'error', $message);
    redirect($returnTo);
};

// Trang này chỉ xử lý, không hiển thị: chỉ nhận POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    if ($jsonRequest) {
        header('Allow: POST');
        $respond(false, 'Vui lòng dùng nút Thêm vào giỏ trên trang sản phẩm.', 405);
    }
    redirect('index.php');
}

$productIdInput = $_POST['product_id'] ?? null;
$quantityInput = $_POST['quantity'] ?? '1';
$productId = is_scalar($productIdInput) ? filter_var($productIdInput, FILTER_VALIDATE_INT) : false;
$quantity = is_scalar($quantityInput) ? filter_var($quantityInput, FILTER_VALIDATE_INT) : false;
if ($productId === false || $productId < 1 || $quantity === false || $quantity < 1) {
    $respond(false, 'Thông tin sản phẩm hoặc số lượng không hợp lệ.', 422);
}

// Sản phẩm phải tồn tại và còn hàng
try {
    $stmt = $pdo->prepare('SELECT id, name, stock FROM products WHERE id = ?');
    $stmt->execute([$productId]);
    $product = $stmt->fetch();
} catch (PDOException $exception) {
    error_log('Add to cart failed: ' . $exception->getMessage());
    $respond(false, 'Chưa thêm được sản phẩm. Vui lòng thử lại sau.', 500);
}

if (!$product || $product['stock'] < 1) {
    $respond(false, 'Sản phẩm không tồn tại hoặc đã hết hàng.', 409);
}

// Cộng dồn số lượng, không vượt quá tồn kho
$stock = (int) $product['stock'];
$current = min(max(0, (int) ($_SESSION['cart'][$productId] ?? 0)), $stock);
$addedQuantity = min($quantity, $stock);
$finalQuantity = min($current + $addedQuantity, $stock);
$_SESSION['cart'][$productId] = $finalQuantity;

if ($finalQuantity - $current < $quantity) {
    $message = 'Giỏ hàng đã có ' . $finalQuantity . ' sản phẩm "' . $product['name'] . '", bằng số lượng còn hàng.';
} else {
    $message = 'Đã thêm "' . $product['name'] . '" vào giỏ hàng.';
}
$respond(true, $message, 200, $finalQuantity - $current);
