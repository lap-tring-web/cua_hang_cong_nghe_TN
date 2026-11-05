<nav class="admin-nav" aria-label="Điều hướng quản trị">
    <?php foreach (['index.php' => 'Tổng quan', 'products.php' => 'Sản phẩm', 'categories.php' => 'Danh mục', 'orders.php' => 'Đơn hàng', 'contacts.php' => 'Liên hệ'] as $path => $label): ?>
    <a href="<?= e(url('admin/' . $path)) ?>" class="<?= $currentPage === $path ? 'active' : '' ?>"><?= e($label) ?></a>
    <?php endforeach; ?>
</nav>
