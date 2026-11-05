<?php
require __DIR__ . '/../includes/init.php';
require_admin();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_var(is_scalar($_POST['id'] ?? null) ? $_POST['id'] : '', FILTER_VALIDATE_INT);
    $name = trim(is_string($_POST['name'] ?? null) ? $_POST['name'] : '');
    $action = $_POST['action'] ?? '';
    try {
        if ($action === 'delete' && $id > 0) {
            $stmt = $pdo->prepare('DELETE FROM categories WHERE id = ?'); $stmt->execute([$id]);
            set_flash('success', 'Đã xóa danh mục.');
        } elseif (in_array($action, ['create', 'rename'], true) && mb_strlen($name) >= 2 && mb_strlen($name) <= 100) {
            if ($action === 'rename' && $id > 0) {
                $stmt = $pdo->prepare('UPDATE categories SET name = ? WHERE id = ?'); $stmt->execute([$name, $id]);
            } elseif ($action === 'create') {
                $stmt = $pdo->prepare('INSERT INTO categories (name) VALUES (?)'); $stmt->execute([$name]);
            } else throw new RuntimeException('Danh mục không hợp lệ.');
            set_flash('success', 'Đã lưu danh mục.');
        } else throw new RuntimeException('Tên danh mục phải có từ 2 đến 100 ký tự.');
    } catch (PDOException $exception) {
        if ($exception->getCode() !== '23000') throw $exception;
        set_flash('error', 'Không thể xóa danh mục đang có sản phẩm.');
    } catch (RuntimeException $exception) { set_flash('error', $exception->getMessage()); }
    redirect('admin/categories.php');
}
$categories = $pdo->query('SELECT c.id, c.name, COUNT(p.id) AS product_count FROM categories c LEFT JOIN products p ON p.category_id = c.id GROUP BY c.id, c.name ORDER BY c.id')->fetchAll();
$pageTitle = 'Quản lý danh mục';
require __DIR__ . '/../includes/header.php';
?>
<h1>Quản lý danh mục</h1><p class="muted">Sắp xếp sản phẩm theo từng nhóm để khách hàng dễ tìm kiếm.</p>
<form method="post" class="form"><h2>Thêm danh mục</h2><?= csrf_field() ?><input type="hidden" name="action" value="create"><p><label for="category-name">Tên danh mục</label><input id="category-name" name="name" required minlength="2" maxlength="100"></p><button class="btn btn-accent">Thêm danh mục</button></form>
<div class="table-wrap"><table><thead><tr><th>Danh mục</th><th>Số sản phẩm</th><th>Thao tác</th></tr></thead><tbody>
<?php foreach ($categories as $category): ?><tr><td><form method="post" class="row-actions"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $category['id'] ?>"><input type="hidden" name="action" value="rename"><input name="name" aria-label="Tên danh mục <?= e($category['name']) ?>" value="<?= e($category['name']) ?>" required minlength="2" maxlength="100"><button class="btn btn-small">Đổi tên</button></form></td><td><?= (int) $category['product_count'] ?></td><td><form method="post" data-confirm="Xóa danh mục này?"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $category['id'] ?>"><input type="hidden" name="action" value="delete"><button class="btn btn-danger btn-small">Xóa</button></form></td></tr><?php endforeach; ?>
</tbody></table></div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
