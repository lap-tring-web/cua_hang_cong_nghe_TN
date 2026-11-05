<?php
require __DIR__ . '/includes/init.php';

$categoryInput = $_GET['category'] ?? '';
$categoryId = is_scalar($categoryInput) ? filter_var($categoryInput, FILTER_VALIDATE_INT) : false;
$categoryId = $categoryId !== false && $categoryId > 0 ? $categoryId : 0;
$keywordInput = $_GET['q'] ?? '';
$keyword = is_string($keywordInput) ? trim($keywordInput) : '';
$sortInput = $_GET['sort'] ?? '';
$sort = is_string($sortInput) ? $sortInput : '';

$categories = $pdo->query('SELECT id, name FROM categories ORDER BY id')->fetchAll();
$sql = 'SELECT id, name, price, image, stock FROM products';
$conditions = [];
$parameters = [];

if ($categoryId > 0) {
    $conditions[] = 'category_id = ?';
    $parameters[] = $categoryId;
}

if ($keyword !== '') {
    $conditions[] = 'name LIKE ?';
    $parameters[] = '%' . $keyword . '%';
}

if ($conditions) {
    $sql .= ' WHERE ' . implode(' AND ', $conditions);
}

$orderBy = [
    'price_asc' => 'price ASC',
    'price_desc' => 'price DESC',
];
$sql .= ' ORDER BY ' . ($orderBy[$sort] ?? 'id ASC');

$statement = $pdo->prepare($sql);
$countSql = 'SELECT COUNT(*) FROM products' . ($conditions ? ' WHERE ' . implode(' AND ', $conditions) : '');
$countStatement = $pdo->prepare($countSql);
$countStatement->execute($parameters);
$totalProducts = (int) $countStatement->fetchColumn();
$totalPages = max(1, (int) ceil($totalProducts / 8));
$pageInput = $_GET['page'] ?? '1';
$pageValue = is_scalar($pageInput) ? filter_var($pageInput, FILTER_VALIDATE_INT) : false;
$page = min(max($pageValue ?: 1, 1), $totalPages);
$sql .= ' LIMIT 8 OFFSET ' . (($page - 1) * 8);
$statement = $pdo->prepare($sql);
$statement->execute($parameters);
$products = $statement->fetchAll();

$pageTitle = 'Trang chủ';
require __DIR__ . '/includes/header.php';
?>
<?php if (!$categoryId && $keyword === '' && $page === 1 && $sort === ''): ?>
<p class="announcement">CÔNG NGHỆ CHO MỖI NGÀY <span>Khám phá phụ kiện phù hợp với bạn</span><a href="#products">Xem sản phẩm <span aria-hidden="true">›</span></a></p>
<section class="shop-hero" aria-labelledby="hero-title">
    <div class="shop-hero-copy">
        <p class="hero-kicker">THỊNH NGUYỄN · TECH & ACCESSORIES</p>
        <h1 id="hero-title">Góc máy mới.<br>Cảm hứng mới.</h1>
        <p>Kết nối với điều bạn yêu thích. Khám phá thiết bị và phụ kiện cho học tập, làm việc và giải trí.</p>
        <a href="#products" class="hero-link">Khám phá ngay <span aria-hidden="true">›</span></a>
        <div class="hero-tags"><span>Thiết bị chọn lọc</span><span>Thông số rõ ràng</span></div>
    </div>
    <div class="shop-hero-image">
        <img src="<?= e(url('assets/photos/workspace.webp')) ?>" srcset="<?= e(url('assets/photos/workspace-800.webp')) ?> 800w, <?= e(url('assets/photos/workspace.webp')) ?> 1600w" sizes="(max-width: 600px) 100vw, 58vw" alt="Góc làm việc thực tế với màn hình, bàn phím, chuột và tấm lót bàn Logitech" width="1600" height="900" fetchpriority="high">
    </div>
</section>
<section class="feature-grid" aria-label="Khám phá theo nhu cầu">
    <a class="feature-panel feature-work" href="<?= e(url('index.php?category=1#products')) ?>"><div><p class="section-kicker">LÀM VIỆC HIỆU QUẢ</p><h2>Từng thao tác.<br>Thêm chính xác.</h2><span class="text-link">Bàn phím & chuột <span aria-hidden="true">›</span></span></div><img src="<?= e(url('assets/photos/keychron-k8-workspace.webp')) ?>" alt="Ảnh thực tế bàn phím cơ Keychron K8 trên bàn làm việc" width="1200" height="675" loading="lazy"></a>
    <a class="feature-panel feature-sound" href="<?= e(url('index.php?category=2#products')) ?>"><div><p class="section-kicker">ÂM THANH & CẢM HỨNG</p><h2>Đắm chìm trong<br>thế giới của bạn.</h2><span class="text-link">Khám phá âm thanh <span aria-hidden="true">›</span></span></div><img src="<?= e(url('assets/photos/logitech-zone-vibe-audio.webp')) ?>" alt="Ảnh cận cảnh tai nghe Logitech Zone Vibe 100 màu graphite" width="1200" height="568" loading="lazy"></a>
</section>
<?php endif; ?>
<section id="products" class="catalog-section">
    <div class="section-heading">
        <div>
            <p class="section-kicker">TÌM THIẾT BỊ DÀNH CHO BẠN</p>
            <h2>Khám phá sản phẩm</h2>
        </div>
        <p class="muted"><?= $totalProducts ?> sản phẩm phù hợp</p>
    </div>

    <form action="<?= e(url('index.php')) ?>" method="get" class="search-form">
        <input type="search" name="q" value="<?= e($keyword) ?>" placeholder="Tìm sản phẩm..."
               aria-label="Tìm sản phẩm">
        <?php if ($categoryId > 0): ?>
            <input type="hidden" name="category" value="<?= (int) $categoryId ?>">
        <?php endif; ?>
        <?php if (isset($orderBy[$sort])): ?>
            <input type="hidden" name="sort" value="<?= e($sort) ?>">
        <?php endif; ?>
        <button type="submit" class="btn">Tìm</button>
    </form>

    <nav class="category-bar" aria-label="Lọc theo danh mục">
        <a href="<?= e(url('index.php')) ?>" class="<?= $categoryId === 0 ? 'active' : '' ?>">Tất cả</a>
        <?php foreach ($categories as $category): ?>
            <?php
            $categoryParameters = ['category' => (int) $category['id']];
            if ($keyword !== '') {
                $categoryParameters['q'] = $keyword;
            }
            if (isset($orderBy[$sort])) {
                $categoryParameters['sort'] = $sort;
            }
            ?>
            <a href="<?= e(url('index.php?' . http_build_query($categoryParameters))) ?>"
               class="<?= $categoryId === (int) $category['id'] ? 'active' : '' ?>">
                <?= e($category['name']) ?>
            </a>
        <?php endforeach; ?>
    </nav>

    <form action="<?= e(url('index.php')) ?>" method="get" class="sort-form">
        <?php if ($categoryId > 0): ?>
            <input type="hidden" name="category" value="<?= (int) $categoryId ?>">
        <?php endif; ?>
        <?php if ($keyword !== ''): ?>
            <input type="hidden" name="q" value="<?= e($keyword) ?>">
        <?php endif; ?>
        <label for="sort">Sắp xếp:</label>
        <select id="sort" name="sort">
            <option value="" <?= $sort === '' ? 'selected' : '' ?>>Mặc định</option>
            <option value="price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>Giá tăng dần</option>
            <option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>Giá giảm dần</option>
        </select>
        <button type="submit" class="btn">Sắp xếp</button>
    </form>

    <p class="result-status" role="status">Tìm thấy <?= $totalProducts ?> sản phẩm<?= $keyword !== '' ? ' cho “' . e($keyword) . '”' : '' ?></p>

    <?php if (!$products): ?>
        <p>Không tìm thấy sản phẩm nào.</p>
    <?php endif; ?>

    <div class="product-list">
        <?php foreach ($products as $product): ?>
            <article class="product-card">
                <a class="product-image-link" href="<?= e(url('product.php?id=' . (int) $product['id'])) ?>"><img src="<?= e(url($product['image'])) ?>" alt="<?= e($product['name']) ?>" loading="lazy" width="400" height="400"></a>
                <h3><?= e($product['name']) ?></h3>
                <p class="price"><?= format_price($product['price']) ?></p>
                <a href="<?= e(url('product.php?id=' . (int) $product['id'])) ?>" class="btn">Xem chi tiết</a>
                <?php if ((int) $product['stock'] > 0): ?>
                    <form action="<?= e(url('cart-add.php')) ?>" method="post" class="inline-form" data-add-to-cart>
                        <?= csrf_field() ?>
                        <input type="hidden" name="return_to" value="<?= e('index.php' . (!empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '') . '#products') ?>">
                        <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
                        <button type="submit" class="btn btn-accent">Thêm vào giỏ</button>
                    </form>
                <?php else: ?>
                    <p class="muted">Hết hàng</p>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </div>
    <?php if ($totalPages > 1): ?><nav class="pagination" aria-label="Phân trang sản phẩm">
    <?php for ($number = 1; $number <= $totalPages; $number++):
        $query = http_build_query(['category' => $categoryId, 'q' => $keyword, 'sort' => $sort, 'page' => $number]); ?>
        <a href="<?= e(url('index.php?' . $query . '#products')) ?>" class="<?= $page === $number ? 'active' : '' ?>" <?= $page === $number ? 'aria-current="page"' : '' ?>><?= $number ?></a>
    <?php endfor; ?></nav><?php endif; ?>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
