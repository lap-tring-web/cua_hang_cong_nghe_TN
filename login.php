<?php
require __DIR__ . '/includes/init.php';

// Đã đăng nhập rồi thì không cần vào trang này nữa
if (is_logged_in()) {
    redirect('index.php');
}

$error = '';
$email = '';
$lockedUntil = (int) ($_SESSION['login_locked_until'] ?? 0);
if ($lockedUntil && $lockedUntil <= time()) {
    unset($_SESSION['login_attempts'], $_SESSION['login_locked_until']);
    $lockedUntil = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim(is_string($_POST['email'] ?? null) ? $_POST['email'] : '');
    $password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';

    if ($lockedUntil > time()) {
        $error = 'Đăng nhập đã bị khóa. Vui lòng thử lại sau ' . (int) ceil(($lockedUntil - time()) / 60) . ' phút.';
    } else {
    $stmt = $pdo->prepare('SELECT id, fullname, password_hash, role, avatar FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        // Đổi mã phiên ngay sau khi đăng nhập để chống chiếm phiên
        session_regenerate_id(true);
        unset($_SESSION['login_attempts'], $_SESSION['login_locked_until']);
        $_SESSION['user'] = [
            'id'       => $user['id'],
            'fullname' => $user['fullname'],
            'role'     => $user['role'],
            'avatar'   => $user['avatar'],
        ];
        set_flash('success', 'Xin chào ' . $user['fullname'] . '!');
        $returnTo = $_SESSION['return_to'] ?? 'index.php';
        unset($_SESSION['return_to']);
        redirect($returnTo);
    }

    // Không nói rõ sai email hay sai mật khẩu, để không lộ email nào đã đăng ký
    $error = 'Email hoặc mật khẩu không đúng.';
    $_SESSION['login_attempts'] = (int) ($_SESSION['login_attempts'] ?? 0) + 1;
    if ($_SESSION['login_attempts'] >= 5) {
        $lockedUntil = time() + 300;
        $_SESSION['login_locked_until'] = $lockedUntil;
        $error = 'Bạn đã đăng nhập sai 5 lần liên tiếp. Form bị khóa trong 5 phút.';
    }
    }
}

$pageTitle = 'Đăng nhập';
require __DIR__ . '/includes/header.php';
?>
<section class="auth-layout" aria-labelledby="login-title">
    <div class="auth-intro">
        <p class="section-kicker">TÀI KHOẢN THỊNH NGUYỄN</p>
        <img class="account-illustration" src="<?= e(url('assets/account-connect.svg')) ?>" alt="Minh họa tài khoản kết nối với các thiết bị công nghệ" width="460" height="300">
        <h2>Một tài khoản.<br>Trọn vẹn trải nghiệm.</h2>
        <p>Đồng hành cùng bạn từ lần khám phá đầu tiên đến góc máy hoàn chỉnh.</p>
        <ul class="account-benefits"><li><span aria-hidden="true">01</span><div><strong>Mua sắm thuận tiện</strong><small>Lưu thông tin để đặt hàng dễ dàng hơn.</small></div></li><li><span aria-hidden="true">02</span><div><strong>Theo dõi đơn hàng</strong><small>Chủ động xem lịch sử và tiến độ giao hàng.</small></div></li><li><span aria-hidden="true">03</span><div><strong>Quản lý trong tầm tay</strong><small>Cập nhật hồ sơ và địa chỉ nhận hàng.</small></div></li></ul>
    </div>
    <div class="auth-form-panel">
        <p class="auth-eyebrow">CHÀO MỪNG BẠN TRỞ LẠI</p>
        <h1 id="login-title">Đăng nhập</h1>
        <p class="auth-description">Đăng nhập để tiếp tục trải nghiệm cùng Thịnh Nguyễn.</p>
<form action="<?= e(url('login.php')) ?>" method="post" class="form auth-form">
    <?= csrf_field() ?>
    <?php if ($error): ?>
        <p class="alert alert-error" role="alert"><?= e($error) ?></p>
    <?php endif; ?>
    <?php if ($lockedUntil > time() && !$error): ?><p class="alert alert-error" role="alert">Form đăng nhập bị khóa trong 5 phút sau 5 lần sai liên tiếp.</p><?php endif; ?>
    <p>
        <label for="email">Email</label><br>
        <input type="email" id="email" name="email" value="<?= e($email) ?>" required autocomplete="username" maxlength="150" placeholder="Nhập địa chỉ email">
    </p>
    <p>
        <label for="password">Mật khẩu</label><br>
        <span class="password-field"><input type="password" id="password" name="password" required autocomplete="current-password" placeholder="Nhập mật khẩu"><button type="button" class="password-toggle" aria-controls="password" aria-pressed="false" aria-label="Hiện mật khẩu"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/><path class="eye-slash" d="m4 4 16 16"/></svg></button></span>
    </p>
    <p>
        <button type="submit" class="btn auth-submit" <?= $lockedUntil > time() ? 'disabled' : '' ?>>Đăng nhập</button>
    </p>
    <p class="auth-switch">Chưa có tài khoản? <a href="<?= e(url('register.php')) ?>">Đăng ký ngay <span aria-hidden="true">›</span></a></p>
</form>
        <p class="auth-help">Cần hỗ trợ tài khoản? <a href="<?= e(url('contact.php')) ?>">Liên hệ cửa hàng</a></p>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
