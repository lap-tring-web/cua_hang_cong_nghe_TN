<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Trang chủ') ?> | <?= e(APP_NAME) ?></title>
    <meta name="description" content="Cửa hàng công nghệ Thịnh Nguyễn - thiết bị và phụ kiện cho học tập, làm việc và giải trí.">
    <link rel="icon" href="<?= e(url('assets/favicon-portrait.ico')) ?>" type="image/x-icon" sizes="16x16 32x32 48x48 64x64">
    <link rel="icon" href="<?= e(url('assets/favicon-portrait.png')) ?>" type="image/png" sizes="64x64">
    <link rel="stylesheet" href="<?= e(url('css/style.css?v=20261105-portrait-menu')) ?>">
    <script src="<?= e(url('js/main.js?v=20261103-final-audit-2s')) ?>" defer></script>
</head>
<body>
    <a class="skip-link" href="#main-content">Đến nội dung chính</a>
    <?php
    $currentPage = basename($_SERVER['SCRIPT_NAME'] ?? '');
    $requestPath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $isAdminArea = strpos($requestPath, '/admin/') !== false;
    $isAuthPage = in_array($currentPage, ['login.php', 'register.php'], true);
    ?>
    <header class="site-header">
        <div class="header-inner">
            <a class="brand" href="<?= e(url('index.php')) ?>" aria-label="<?= e(APP_NAME) ?> - Trang chủ">
                <img class="brand-logo" src="<?= e(url('assets/anh_chan_dung.jpg')) ?>" alt="Ảnh chân dung Nguyễn Ngô Quốc Thịnh — logo cửa hàng" width="72" height="72">
                <span class="brand-copy"><strong><?= e(APP_NAME) ?></strong><small><?= e(STUDENT_NAME) ?></small></span>
            </a>
            <div class="header-tools">
                <a class="header-search" href="<?= e(url('index.php#products')) ?>"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.5" cy="10.5" r="6.5"/><path d="m16 16 5 5"/></svg><span>Tìm kiếm</span></a>
                <a class="nav-cart <?= $currentPage === 'cart.php' ? 'active' : '' ?>" href="<?= e(url('cart.php')) ?>" aria-label="Giỏ hàng, <?= e(cart_count()) ?> sản phẩm"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 3h2l2 12h12l2-8H6"/><circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/></svg><span>Giỏ hàng</span><span id="cart-count" class="cart-count"><?= e(cart_count()) ?></span></a>
                <?php if (is_logged_in()): ?>
                    <?php $headerAvatarUrl = user_avatar_url(current_user()); ?>
                    <details class="account-menu" id="account-menu">
                        <summary class="account-avatar-toggle" aria-label="Tài khoản của <?= e(current_user()['fullname']) ?>" aria-controls="account-dropdown" title="Tài khoản của <?= e(current_user()['fullname']) ?>">
                            <?php if ($headerAvatarUrl): ?><img class="header-user-avatar" src="<?= e($headerAvatarUrl) ?>" alt="" width="40" height="40"><?php else: ?><span class="header-user-avatar avatar-initials" aria-hidden="true"><?= e(user_initials(current_user()['fullname'])) ?></span><?php endif; ?>
                        </summary>
                        <div class="account-dropdown" id="account-dropdown">
                            <div class="account-menu-identity"><span>Xin chào,</span><strong><?= e(current_user()['fullname']) ?></strong></div>
                            <nav class="account-menu-links" aria-label="Tài khoản cá nhân">
                                <a href="<?= e(url('profile.php')) ?>" <?= in_array($currentPage, ['profile.php', 'change-password.php'], true) ? 'aria-current="page"' : '' ?>>Tài khoản của tôi</a>
                                <a href="<?= e(url('orders.php')) ?>" <?= $currentPage === 'orders.php' ? 'aria-current="page"' : '' ?>>Đơn hàng của tôi</a>
                                <?php if (is_admin()): ?><a href="<?= e(url('admin/index.php')) ?>" <?= $isAdminArea ? 'aria-current="page"' : '' ?>>Quản trị cửa hàng</a><?php endif; ?>
                            </nav>
                            <form action="<?= e(url('logout.php')) ?>" method="post" class="account-logout-form"><?= csrf_field() ?><button type="submit">Đăng xuất</button></form>
                        </div>
                    </details>
                <?php else: ?>
                    <a class="guest-account-link" href="<?= e(url('login.php')) ?>" aria-label="Đăng nhập tài khoản" title="Đăng nhập tài khoản"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21v-2a8 8 0 0 1 16 0v2"/></svg></a>
                <?php endif; ?>
            </div>
            <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="main-navigation" aria-label="Mở menu điều hướng"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg></button>
        </div>
        <div class="navigation-row">
            <nav class="main-nav" id="main-navigation" aria-label="Điều hướng chính">
            <a href="<?= e(url('index.php')) ?>" class="<?= $currentPage === 'index.php' && !$isAdminArea ? 'active' : '' ?>">Trang chủ</a>
            <a href="<?= e(url('index.php#products')) ?>">Sản phẩm</a>
            <a href="<?= e(url('about.php')) ?>" class="<?= $currentPage === 'about.php' ? 'active' : '' ?>">Giới thiệu</a>
            <a href="<?= e(url('contact.php')) ?>" class="<?= $currentPage === 'contact.php' ? 'active' : '' ?>">Liên hệ</a>
            <?php if (!is_logged_in()): ?>
                <div class="nav-account">
                <a href="<?= e(url('login.php')) ?>" class="<?= $currentPage === 'login.php' ? 'active' : '' ?>">Đăng nhập</a>
                <a href="<?= e(url('register.php')) ?>" class="<?= $currentPage === 'register.php' ? 'active' : '' ?>">Đăng ký</a>
                </div>
            <?php endif; ?>
            </nav>
        </div>
    </header>

    <main id="main-content" class="<?= $isAuthPage ? 'auth-main' : ($currentPage === 'index.php' && !$isAdminArea ? 'store-main' : '') ?>">
        <?php if ($isAdminArea) require __DIR__ . '/admin-nav.php'; ?>
        <?php $flash = get_flash(); ?>
        <?php if ($flash): ?>
            <p class="alert alert-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></p>
        <?php endif; ?>
