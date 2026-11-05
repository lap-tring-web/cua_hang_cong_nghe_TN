<?php
require __DIR__ . '/../includes/init.php';
require_admin();
$contacts = $pdo->query('SELECT * FROM contacts ORDER BY id DESC LIMIT 100')->fetchAll();
$pageTitle = 'Tin nhắn liên hệ';
require __DIR__ . '/../includes/header.php';
?>
<h1>Tin nhắn từ khách hàng</h1><p class="muted">100 tin nhắn mới nhất gửi qua biểu mẫu liên hệ.</p>
<?php if (!$contacts): ?><p>Chưa có tin nhắn liên hệ.</p><?php endif; ?>
<?php foreach ($contacts as $contact): ?><article class="contact-card"><h2><?= e($contact['subject']) ?></h2><p><?= e($contact['fullname']) ?> · <?= e($contact['email']) ?> · <?= e($contact['created_at']) ?></p><p><?= nl2br(e($contact['message'])) ?></p></article><?php endforeach; ?>
<?php require __DIR__ . '/../includes/footer.php'; ?>
