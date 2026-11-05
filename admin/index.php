<?php
require __DIR__ . '/../includes/init.php';
require_admin();
$counts = $pdo->query('SELECT status, COUNT(*) AS count FROM orders GROUP BY status')->fetchAll(PDO::FETCH_KEY_PAIR);
$revenue = $pdo->query("SELECT COALESCE(SUM(total), 0) FROM orders WHERE status = 'completed'")->fetchColumn();
$products = $pdo->query('SELECT id, name, stock FROM products ORDER BY stock ASC, id ASC LIMIT 5')->fetchAll();
$pageTitle = 'Tổng quan quản trị';
require __DIR__ . '/../includes/header.php';
?>
<div class="page-heading"><div><p class="section-kicker">THỊNH NGUYỄN / QUẢN TRỊ</p><h1>Tổng quan cửa hàng</h1><p class="muted">Theo dõi đơn hàng, doanh thu và tồn kho trong cùng một nơi.</p></div></div>
<section class="stats-grid" aria-label="Thống kê đơn hàng">
<?php foreach (order_statuses() as $status => $label): ?><article class="stat-card"><p><?= e($label) ?></p><strong><?= (int) ($counts[$status] ?? 0) ?></strong><a href="<?= e(url('admin/orders.php?status=' . $status)) ?>">Xem đơn hàng →</a></article><?php endforeach; ?>
</section>
<section class="revenue-card"><p>Doanh thu từ đơn hoàn tất</p><strong><?= format_price($revenue) ?></strong><p>Chỉ tính các đơn hàng đã hoàn tất.</p></section>
<h2>5 sản phẩm có tồn kho thấp nhất</h2><table><thead><tr><th>Sản phẩm</th><th>Còn lại</th><th>Quản lý</th></tr></thead><tbody><?php foreach ($products as $product): ?><tr><td><?= e($product['name']) ?></td><td><?= (int) $product['stock'] ?></td><td><a href="<?= e(url('admin/product-form.php?id=' . (int) $product['id'])) ?>">Cập nhật</a></td></tr><?php endforeach; ?></tbody></table>
<?php require __DIR__ . '/../includes/footer.php'; ?>
