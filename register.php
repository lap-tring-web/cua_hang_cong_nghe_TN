<?php
require __DIR__ . '/includes/init.php';

$errors = [];
$fullname = '';
$email = '';
$phone = '';
$address = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Lấy dữ liệu và cắt khoảng trắng thừa
    $fullname = trim(is_string($_POST['fullname'] ?? null) ? $_POST['fullname'] : '');
    $email = trim(is_string($_POST['email'] ?? null) ? $_POST['email'] : '');
    $phone = trim(is_string($_POST['phone'] ?? null) ? $_POST['phone'] : '');
    $address = trim(is_string($_POST['address'] ?? null) ? $_POST['address'] : '');
    $password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';
    $password2 = is_string($_POST['password2'] ?? null) ? $_POST['password2'] : '';

    // 2. Kiểm tra từng trường; lỗi của trường nào ghi vào khóa của trường đó
    if (mb_strlen($fullname) < 2 || mb_strlen($fullname) > 100) {
        $errors['fullname'] = 'Họ tên phải có từ 2 đến 100 ký tự.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 150) {
        $errors['email'] = 'Email không hợp lệ.';
    }
    if (!preg_match('/^0[0-9]{9}$/', $phone)) {
        $errors['phone'] = 'Số điện thoại gồm 10 chữ số, bắt đầu bằng số 0.';
    }
    if (mb_strlen($address) > 255) $errors['address'] = 'Địa chỉ không quá 255 ký tự.';
    if (strlen($password) < 8 || strlen($password) > 72) {
        $errors['password'] = 'Mật khẩu phải có từ 8 đến 72 byte.';
    }
    if ($password !== $password2) {
        $errors['password2'] = 'Hai mật khẩu không khớp nhau.';
    }
    if (($_POST['agree'] ?? null) !== '1') {
        $errors['agree'] = 'Bạn cần đồng ý với điều khoản sử dụng.';
    }

    // 3. Email đã có người dùng chưa?
    if (!isset($errors['email'])) {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors['email'] = 'Email này đã được đăng ký.';
        }
    }

    // 4. Không có lỗi: lưu tài khoản rồi chuyển sang trang đăng nhập
    if (!$errors) {
        $stmt = $pdo->prepare(
            'INSERT INTO users (fullname, email, password_hash, phone, address)
             VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([$fullname, $email, password_hash($password, PASSWORD_DEFAULT), $phone, $address]);

        set_flash('success', 'Đăng ký thành công. Mời bạn đăng nhập.');
        redirect('login.php');
    }
}

$pageTitle = 'Đăng ký';
require __DIR__ . '/includes/header.php';
?>
<section class="register-layout" aria-labelledby="register-title">
<div class="register-heading"><p class="section-kicker">TÀI KHOẢN THỊNH NGUYỄN</p><h1 id="register-title">Tạo tài khoản của bạn</h1><p>Khởi đầu trải nghiệm công nghệ. Đặt hàng thuận tiện và quản lý mọi thứ ở một nơi.</p><p>Đã có tài khoản? <a href="<?= e(url('login.php')) ?>">Đăng nhập <span aria-hidden="true">›</span></a></p></div>

<form action="<?= e(url('register.php')) ?>" method="post" class="form auth-form register-form" id="register-form">
    <?= csrf_field() ?>
    <?php if ($errors): ?><p class="alert alert-error" role="alert">Vui lòng kiểm tra các thông tin được đánh dấu bên dưới.</p><?php endif; ?>
    <p class="required-note">Các trường có dấu <span>*</span> là bắt buộc.</p>
    <div class="form-grid">
    <p>
        <label for="fullname">Họ và tên <span class="required-mark">*</span></label><br>
        <input type="text" id="fullname" name="fullname" value="<?= e($fullname) ?>"
               required minlength="2" maxlength="100" autocomplete="name" aria-describedby="fullname-error" <?= isset($errors['fullname']) ? 'aria-invalid="true"' : '' ?>>
        <span class="error" id="fullname-error"><?= e($errors['fullname'] ?? '') ?></span>
    </p>
    <p>
        <label for="phone">Số điện thoại <span class="required-mark">*</span></label>
        <input type="tel" id="phone" name="phone" value="<?= e($phone) ?>" required pattern="0[0-9]{9}" title="Số điện thoại gồm 10 chữ số, bắt đầu bằng số 0" autocomplete="tel" inputmode="tel" aria-describedby="phone-error" <?= isset($errors['phone']) ? 'aria-invalid="true"' : '' ?>>
        <span class="error" id="phone-error"><?= e($errors['phone'] ?? '') ?></span>
    </p>
    </div>
    <p><label for="email">Email <span class="required-mark">*</span></label><input type="email" id="email" name="email" value="<?= e($email) ?>" required maxlength="150" autocomplete="email" aria-describedby="email-error" <?= isset($errors['email']) ? 'aria-invalid="true"' : '' ?>><span class="error" id="email-error"><?= e($errors['email'] ?? '') ?></span></p>
    <p>
        <label for="password">Mật khẩu <span class="required-mark">*</span></label>
        <span class="password-field"><input type="password" id="password" name="password" required minlength="8" maxlength="72" autocomplete="new-password" aria-describedby="password-hint new-password-error" <?= isset($errors['password']) ? 'aria-invalid="true"' : '' ?>><button type="button" class="password-toggle" aria-controls="password" aria-pressed="false" aria-label="Hiện mật khẩu"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/><path class="eye-slash" d="m4 4 16 16"/></svg></button></span>
        <small class="field-hint" id="password-hint">Tối thiểu 8 ký tự. Nên kết hợp chữ hoa, chữ thường, số và ký hiệu; tối đa 72 byte.</small>
        <span class="error" id="new-password-error"><?= e($errors['password'] ?? '') ?></span>
    </p>
    <p>
        <label for="password2">Nhập lại mật khẩu <span class="required-mark">*</span></label>
        <span class="password-field"><input type="password" id="password2" name="password2" required minlength="8" maxlength="72" autocomplete="new-password" aria-describedby="password-error" <?= isset($errors['password2']) ? 'aria-invalid="true"' : '' ?>><button type="button" class="password-toggle" aria-controls="password2" aria-pressed="false" aria-label="Hiện mật khẩu nhập lại"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/><path class="eye-slash" d="m4 4 16 16"/></svg></button></span>
        <span class="error" id="password-error" aria-live="polite"><?= e($errors['password2'] ?? '') ?></span>
    </p>
    <p>
        <label for="address">Địa chỉ nhận hàng <span class="optional-label">(tùy chọn)</span></label><br>
        <textarea id="address" name="address" rows="2" maxlength="255" autocomplete="street-address" aria-describedby="address-error"><?= e($address) ?></textarea>
        <span class="error" id="address-error"><?= e($errors['address'] ?? '') ?></span>
    </p>
    <details class="account-terms"><summary>Điều khoản sử dụng tài khoản</summary><p>Website là đồ án học tập, sản phẩm và đơn hàng dùng để minh họa. Bạn có thể cập nhật thông tin, đổi mật khẩu và theo dõi đơn hàng trong tài khoản. Thông tin đăng ký được dùng để quản lý tài khoản và xử lý đơn hàng trên website. Vui lòng không cung cấp thông tin thanh toán hoặc mật khẩu dùng ở dịch vụ khác. Liên hệ cửa hàng khi cần hỗ trợ.</p></details>
    <p class="checkbox-row">
        <input type="checkbox" id="agree" name="agree" value="1" required <?= ($_POST['agree'] ?? null) === '1' ? 'checked' : '' ?> aria-describedby="agree-error">
        <label for="agree">Tôi đồng ý với điều khoản sử dụng tài khoản.</label>
    </p>
    <span class="error" id="agree-error"><?= e($errors['agree'] ?? '') ?></span>
    <p>
        <button type="submit" class="btn auth-submit">Đăng ký</button>
    </p>
</form>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
