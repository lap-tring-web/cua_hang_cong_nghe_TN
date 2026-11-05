<?php
require __DIR__ . '/includes/init.php';
require_login();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = is_string($_POST['current_password'] ?? null) ? $_POST['current_password'] : '';
    $new = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';
    $confirm = is_string($_POST['password2'] ?? null) ? $_POST['password2'] : '';
    $stmt = $pdo->prepare('SELECT password_hash FROM users WHERE id = ?');
    $stmt->execute([current_user()['id']]);
    if (!password_verify($old, $stmt->fetchColumn())) $error = 'Mật khẩu hiện tại không đúng.';
    elseif (strlen($new) < 8 || strlen($new) > 72) $error = 'Mật khẩu mới phải có từ 8 đến 72 byte.';
    elseif ($new !== $confirm) $error = 'Hai mật khẩu mới không khớp.';
    elseif ($new === $old) $error = 'Mật khẩu mới phải khác mật khẩu hiện tại.';
    else {
        $stmt = $pdo->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
        $stmt->execute([password_hash($new, PASSWORD_DEFAULT), current_user()['id']]);
        session_regenerate_id(true);
        set_flash('success', 'Đã đổi mật khẩu thành công.');
        redirect('profile.php');
    }
}
$pageTitle = 'Đổi mật khẩu';
require __DIR__ . '/includes/header.php';
?>
<h1>Đổi mật khẩu</h1>
<form method="post" class="form">
    <?= csrf_field() ?>
    <?php if ($error): ?><p class="alert alert-error"><?= e($error) ?></p><?php endif; ?>
    <p><label for="current_password">Mật khẩu hiện tại</label><input type="password" id="current_password" name="current_password" required autocomplete="current-password"></p>
    <p><label for="password">Mật khẩu mới</label><input type="password" id="password" name="password" required minlength="8" maxlength="72" autocomplete="new-password"></p>
    <p><label for="password2">Nhập lại mật khẩu mới</label><input type="password" id="password2" name="password2" required minlength="8" maxlength="72" autocomplete="new-password"></p>
    <button class="btn btn-accent">Cập nhật mật khẩu</button>
</form>
<?php require __DIR__ . '/includes/footer.php'; ?>
