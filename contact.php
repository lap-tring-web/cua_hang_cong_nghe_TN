<?php
require __DIR__ . '/includes/init.php';
$errors = [];
$values = ['fullname' => '', 'email' => '', 'subject' => '', 'message' => ''];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($values as $field => $value) $values[$field] = trim(is_string($_POST[$field] ?? null) ? $_POST[$field] : '');
    if (mb_strlen($values['fullname']) < 2 || mb_strlen($values['fullname']) > 100) $errors[] = 'Họ tên phải có 2–100 ký tự.';
    if (!filter_var($values['email'], FILTER_VALIDATE_EMAIL) || strlen($values['email']) > 150) $errors[] = 'Email không hợp lệ.';
    if (mb_strlen($values['subject']) < 2 || mb_strlen($values['subject']) > 200) $errors[] = 'Tiêu đề phải có 2–200 ký tự.';
    if (mb_strlen($values['message']) < 10 || mb_strlen($values['message']) > 5000) $errors[] = 'Nội dung phải có 10–5000 ký tự.';
    if (!$errors) {
        $stmt = $pdo->prepare('INSERT INTO contacts (fullname, email, subject, message) VALUES (?, ?, ?, ?)');
        $stmt->execute(array_values($values));
        set_flash('success', 'Cửa hàng đã nhận tin nhắn của bạn. Cảm ơn bạn đã liên hệ!');
        redirect('contact.php');
    }
}
$pageTitle = 'Liên hệ';
require __DIR__ . '/includes/header.php';
?>
<section>
    <h1>Luôn sẵn sàng lắng nghe</h1>
    <p><?= e(STORE_ADDRESS) ?> · <a href="tel:0343180715"><?= e(STORE_PHONE) ?></a></p>
    <p><a href="mailto:<?= e(STORE_EMAIL) ?>"><?= e(STORE_EMAIL) ?></a></p>
    <?php foreach ($errors as $error): ?><p class="alert alert-error"><?= e($error) ?></p><?php endforeach; ?>
    <form class="form" id="contact-form" method="post">
        <?= csrf_field() ?>
        <p>
            <label for="fullname">Họ tên</label><br>
            <input type="text" id="fullname" name="fullname" value="<?= e($values['fullname']) ?>" maxlength="100" required autocomplete="name">
        </p>
        <p>
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" value="<?= e($values['email']) ?>" maxlength="150" required autocomplete="email">
        </p>
        <p>
            <label for="subject">Tiêu đề</label><br>
            <input type="text" id="subject" name="subject" value="<?= e($values['subject']) ?>" maxlength="200" required>
        </p>
        <p>
            <label for="message">Nội dung</label><br>
            <textarea id="message" name="message" rows="6" minlength="10" maxlength="5000" required><?= e($values['message']) ?></textarea>
            <span class="error" id="message-error" aria-live="polite"></span>
        </p>
        <p><button type="submit" class="btn">Gửi</button></p>
    </form>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
