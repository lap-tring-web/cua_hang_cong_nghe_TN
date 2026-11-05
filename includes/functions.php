<?php
// Các hàm dùng chung của Cửa hàng Công Nghệ Thịnh Nguyễn.

// ===== 1. Hiển thị =====

// Mã hóa ký tự đặc biệt trước khi in ra HTML (chống XSS)
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// Định dạng tiền: 250000 -> "250.000 đ"
function format_price($amount)
{
    return number_format((int) $amount, 0, ',', '.') . ' đ';
}

// Tạo đường dẫn tuyệt đối trong website: url('cart.php') -> "/minishop/cart.php"
function url($path = '')
{
    return BASE_URL . ltrim($path, '/');
}

// ===== 2. Chuyển hướng và thông báo một lần =====

function redirect($path)
{
    header('Location: ' . url($path));
    exit;
}

// $type là 'success' hoặc 'error'
function set_flash($type, $message)
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

// Lấy thông báo ra và xóa luôn, nên nó chỉ hiện đúng một lần
function get_flash()
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

// ===== 3. Tài khoản =====

function current_user()
{
    return $_SESSION['user'] ?? null;
}

function is_logged_in()
{
    return current_user() !== null;
}

function is_admin()
{
    return is_logged_in() && (current_user()['role'] ?? null) === 'admin';
}

// Đặt ở đầu những trang bắt buộc đăng nhập
function require_login()
{
    if (!is_logged_in()) {
        $request = $_SERVER['REQUEST_URI'] ?? '';
        $relative = str_starts_with($request, BASE_URL) ? substr($request, strlen(BASE_URL)) : '';
        if (preg_match('~^(checkout|orders|order-detail|profile|change-password)\.php(?:\?[^\r\n]*)?$~', $relative)) {
            $_SESSION['return_to'] = $relative;
        }
        set_flash('error', 'Vui lòng đăng nhập để tiếp tục.');
        redirect('login.php');
    }
}

// ===== 4. Giỏ hàng =====
// Giỏ hàng nằm trong session, dạng [mã sản phẩm => số lượng]

function cart_count()
{
    return array_sum($_SESSION['cart'] ?? []);
}

// Trả về [danh sách dòng hàng, tổng tiền]; tên và giá luôn lấy từ CSDL
function get_cart_items($pdo)
{
    $cart = $_SESSION['cart'] ?? [];
    if (!$cart) {
        return [[], 0];
    }

    $placeholders = implode(',', array_fill(0, count($cart), '?'));
    $stmt = $pdo->prepare("SELECT id, name, price, image, stock FROM products WHERE id IN ($placeholders)");
    $stmt->execute(array_keys($cart));

    $items = [];
    $total = 0;
    foreach ($stmt->fetchAll() as $product) {
        $quantity = $cart[$product['id']];
        $product['quantity'] = $quantity;
        $product['line_total'] = $product['price'] * $quantity;
        $total += $product['line_total'];
        $items[] = $product;
    }
    return [$items, $total];
}

// ===== 5. Đơn hàng =====

function order_statuses()
{
    return [
        'pending'   => 'Chờ xử lý',
        'shipping'  => 'Đang giao',
        'completed' => 'Hoàn tất',
        'cancelled' => 'Đã hủy',
    ];
}

function order_status_label($status)
{
    return order_statuses()[$status] ?? $status;
}

// Require this at the start of every page in admin/.
function require_admin()
{
    require_login();
    if (!is_admin()) {
        http_response_code(403);
        $pageTitle = 'Truy cập bị từ chối';
        require __DIR__ . '/header.php';
        echo '<section class="empty-state"><h1>403</h1><h2>Bạn không có quyền truy cập trang quản trị.</h2></section>';
        require __DIR__ . '/footer.php';
        exit;
    }
}

// Validate uploaded image contents and store it under a generated filename.
function upload_image($file)
{
    if (!is_array($file) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        $error = is_array($file) ? ($file['error'] ?? UPLOAD_ERR_NO_FILE) : UPLOAD_ERR_NO_FILE;
        throw new RuntimeException('Tải tệp lên thất bại (mã lỗi ' . (int) $error . ').');
    }
    if (($file['size'] ?? 0) > 2 * 1024 * 1024) {
        throw new RuntimeException('Ảnh không được lớn hơn 2 MB.');
    }

    $temporaryPath = $file['tmp_name'] ?? '';
    if (!is_string($temporaryPath) || $temporaryPath === '' || !is_uploaded_file($temporaryPath)) {
        throw new RuntimeException('Tệp tải lên không hợp lệ.');
    }

    $imageInfo = getimagesize($temporaryPath);
    $extensions = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];
    if ($imageInfo === false || !isset($extensions[$imageInfo['mime']])) {
        throw new RuntimeException('Chỉ chấp nhận ảnh JPG, PNG hoặc WebP.');
    }

    $uploadDirectory = __DIR__ . '/../uploads';
    if (!is_dir($uploadDirectory) || !is_writable($uploadDirectory)) {
        throw new RuntimeException('Không lưu được ảnh. Hãy kiểm tra quyền ghi của thư mục uploads.');
    }

    $filename = bin2hex(random_bytes(8)) . '.' . $extensions[$imageInfo['mime']];
    if (!move_uploaded_file($temporaryPath, $uploadDirectory . '/' . $filename)) {
        throw new RuntimeException('Không lưu được ảnh. Hãy kiểm tra quyền ghi của thư mục uploads.');
    }
    return 'uploads/' . $filename;
}

function csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field()
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function csrf_verify()
{
    $token = $_POST['csrf_token'] ?? '';
    if (!is_string($token) || !hash_equals(csrf_token(), $token)) {
        if (str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json')) {
            json_response(['success' => false, 'message' => 'Phiên thao tác đã hết hạn. Vui lòng tải lại trang rồi thử lại.', 'cart_count' => cart_count()], 403);
        }
        http_response_code(403);
        $pageTitle = 'Yêu cầu không hợp lệ';
        require __DIR__ . '/header.php';
        echo '<h1>403</h1><p>Yêu cầu không hợp lệ. Vui lòng tải lại trang và thử lại.</p>';
        require __DIR__ . '/footer.php';
        exit;
    }
}

function json_response($data, $status = 200)
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
    exit;
}
