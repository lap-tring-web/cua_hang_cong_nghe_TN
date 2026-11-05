<?php
require __DIR__ . '/includes/init.php';
require_login();
$userId = current_user()['id'];
$stmt = $pdo->prepare('SELECT fullname, email, phone, address, avatar FROM users WHERE id = ?');
$stmt->execute([$userId]);
$profile = $stmt->fetch();
$errors = [];
$removeAvatar = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach (['fullname', 'phone', 'address'] as $field) {
        $profile[$field] = trim(is_string($_POST[$field] ?? null) ? $_POST[$field] : '');
    }
    $removeAvatar = ($_POST['remove_avatar'] ?? '') === '1';
    $avatarFile = $_FILES['avatar'] ?? null;
    $hasUpload = $avatarFile !== null && (!is_array($avatarFile) || ($avatarFile['error'] ?? null) !== UPLOAD_ERR_NO_FILE);
    if (mb_strlen($profile['fullname']) < 2 || mb_strlen($profile['fullname']) > 100) {
        $errors['fullname'] = 'Họ tên phải có 2–100 ký tự.';
    }
    if (!preg_match('/^0[0-9]{9}$/', $profile['phone'])) {
        $errors['phone'] = 'Số điện thoại phải có 10 chữ số và bắt đầu bằng 0.';
    }
    if (mb_strlen($profile['address']) > 255) $errors['address'] = 'Địa chỉ không quá 255 ký tự.';
    if ($removeAvatar && $hasUpload) $errors['avatar'] = 'Vui lòng chọn đổi ảnh hoặc xóa ảnh trong một lần lưu.';

    $newAvatar = null;
    if (!$errors && $hasUpload) {
        try {
            $newAvatar = upload_user_avatar($avatarFile);
        } catch (RuntimeException $exception) {
            $errors['avatar'] = $exception->getMessage();
        }
    }
    if (!$errors) {
        try {
            $pdo->beginTransaction();
            // Lock the current avatar so simultaneous profile updates clean up the correct file.
            $stmt = $pdo->prepare('SELECT avatar FROM users WHERE id = ? FOR UPDATE');
            $stmt->execute([$userId]);
            $storedProfile = $stmt->fetch();
            if (!$storedProfile) throw new RuntimeException('Tài khoản không còn tồn tại.');
            $oldAvatar = $storedProfile['avatar'];
            $savedAvatar = $newAvatar ?? ($removeAvatar ? null : $oldAvatar);
            $stmt = $pdo->prepare('UPDATE users SET fullname = ?, phone = ?, address = ?, avatar = ? WHERE id = ?');
            $stmt->execute([$profile['fullname'], $profile['phone'], $profile['address'], $savedAvatar, $userId]);
            $pdo->commit();
            if ($oldAvatar !== $savedAvatar) delete_user_avatar($oldAvatar);
            $_SESSION['user']['fullname'] = $profile['fullname'];
            $_SESSION['user']['avatar'] = $savedAvatar;
            set_flash('success', 'Đã cập nhật hồ sơ của bạn.');
            redirect('profile.php');
        } catch (Throwable $exception) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            delete_user_avatar($newAvatar);
            error_log('Profile update failed: ' . $exception->getMessage());
            $errors['save'] = 'Chưa lưu được hồ sơ. Vui lòng thử lại.';
        }
    }
}

$avatarUrl = user_avatar_url($profile);
$pageTitle = 'Tài khoản của tôi';
require __DIR__ . '/includes/header.php';
?>
<div class="page-heading"><div><p class="section-kicker">TÀI KHOẢN THỊNH NGUYỄN</p><h1>Hồ sơ của tôi</h1><p class="muted">Cập nhật thông tin cá nhân và địa chỉ nhận hàng của bạn.</p></div><a class="text-link" href="<?= e(url('orders.php')) ?>">Xem đơn hàng <span aria-hidden="true">›</span></a></div>

<form action="<?= e(url('profile.php')) ?>" method="post" enctype="multipart/form-data" class="form profile-form" id="profile-form">
    <?= csrf_field() ?>
    <?php if ($errors): ?>
    <div class="alert alert-error profile-errors" role="alert" tabindex="-1" data-error-summary aria-labelledby="profile-error-title"><h2 id="profile-error-title">Chưa lưu được hồ sơ</h2><ul><?php foreach ($errors as $field => $error): ?><li><a href="#<?= $field === 'save' ? 'profile-save' : e($field) ?>"><?= e($error) ?></a></li><?php endforeach; ?></ul><p>Thông tin đã nhập được giữ lại. Nếu có đổi ảnh, vui lòng chọn lại ảnh trước khi lưu.</p></div>
    <?php endif; ?>
    <div class="profile-layout">
        <section class="profile-photo-panel" aria-labelledby="profile-photo-title">
            <p class="section-kicker">DẤU ẤN CỦA BẠN</p><h2 id="profile-photo-title">Ảnh đại diện</h2>
            <div class="profile-avatar-preview" id="avatar-preview" data-saved-avatar="<?= e($avatarUrl ?? '') ?>" data-saved-initials="<?= e(user_initials($profile['fullname'])) ?>">
                <img id="avatar-preview-image" src="<?= e($avatarUrl ?? url('assets/logo.svg')) ?>" alt="Ảnh đại diện của bạn" width="144" height="144" <?= $avatarUrl ? '' : 'hidden' ?>>
                <span class="avatar-initials" id="avatar-preview-initials" aria-hidden="true" <?= $avatarUrl ? 'hidden' : '' ?>><?= e(user_initials($profile['fullname'])) ?></span>
            </div>
            <label class="avatar-file-label" for="avatar">Chọn ảnh đại diện</label>
            <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png,image/webp" aria-describedby="avatar-hint avatar-error" <?= isset($errors['avatar']) ? 'aria-invalid="true"' : '' ?>>
            <p class="field-hint" id="avatar-hint">JPG, PNG hoặc WebP · tối đa 2 MB. Mỗi chiều tối đa 4096 pixel. Ảnh vuông sẽ hiển thị đẹp nhất.</p>
            <span class="error" id="avatar-error" aria-live="polite"><?= e($errors['avatar'] ?? '') ?></span>
            <button type="button" class="btn btn-quiet btn-small" id="avatar-reset" hidden>Bỏ ảnh vừa chọn</button>
            <?php if ($avatarUrl): ?><div class="avatar-remove-option"><input type="checkbox" id="remove-avatar" name="remove_avatar" value="1" <?= $removeAvatar ? 'checked' : '' ?>><label for="remove-avatar">Xóa ảnh đại diện hiện tại</label></div><?php endif; ?>
            <p class="avatar-preview-status" role="status" aria-live="polite"></p>
            <p class="profile-photo-note">Ảnh và thông tin chỉ cập nhật sau khi bạn nhấn <strong>Lưu thay đổi</strong>.</p>
        </section>
        <section class="profile-details" aria-labelledby="profile-details-title">
            <h2 id="profile-details-title">Thông tin cá nhân</h2><p class="muted">Thông tin này giúp cửa hàng liên hệ và giao hàng cho bạn.</p>
            <div class="form-grid">
                <p><label for="fullname">Họ và tên <span class="required-mark">*</span></label><input id="fullname" name="fullname" value="<?= e($profile['fullname']) ?>" required minlength="2" maxlength="100" autocomplete="name" aria-describedby="fullname-error" <?= isset($errors['fullname']) ? 'aria-invalid="true"' : '' ?>><span class="error" id="fullname-error"><?= e($errors['fullname'] ?? '') ?></span></p>
                <p><label for="phone">Số điện thoại <span class="required-mark">*</span></label><input type="tel" id="phone" name="phone" value="<?= e($profile['phone']) ?>" required pattern="0[0-9]{9}" maxlength="10" autocomplete="tel" inputmode="tel" title="Số điện thoại gồm 10 chữ số, bắt đầu bằng 0" aria-describedby="phone-error" <?= isset($errors['phone']) ? 'aria-invalid="true"' : '' ?>><span class="error" id="phone-error"><?= e($errors['phone'] ?? '') ?></span></p>
            </div>
            <p><label for="email">Email đăng nhập</label><input type="email" id="email" value="<?= e($profile['email']) ?>" readonly aria-describedby="email-hint"><small class="field-hint" id="email-hint">Email dùng để đăng nhập và được giữ cố định trong hồ sơ.</small></p>
            <p><label for="address">Địa chỉ nhận hàng <span class="optional-label">(tùy chọn)</span></label><textarea id="address" name="address" rows="3" maxlength="255" autocomplete="street-address" aria-describedby="address-error" <?= isset($errors['address']) ? 'aria-invalid="true"' : '' ?>><?= e($profile['address']) ?></textarea><span class="error" id="address-error"><?= e($errors['address'] ?? '') ?></span></p>
            <div class="form-actions profile-save-actions"><button type="submit" class="btn btn-accent" id="profile-save">Lưu thay đổi</button><a href="<?= e(url('change-password.php')) ?>">Đổi mật khẩu</a></div>
        </section>
    </div>
</form>
<?php require __DIR__ . '/includes/footer.php'; ?>
