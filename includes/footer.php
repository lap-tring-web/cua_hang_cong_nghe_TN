    </main>
    <div class="cart-notification" id="cart-notification" hidden>
        <span class="cart-notification-icon" aria-hidden="true">✓</span>
        <p class="cart-notification-message" role="status" aria-live="polite" aria-atomic="true"></p>
        <a href="<?= e(url('cart.php')) ?>">Xem giỏ hàng</a>
        <button type="button" class="cart-notification-close" aria-label="Đóng thông báo">×</button>
    </div>

    <footer class="site-footer">
        <div class="footer-inner">
            <div class="footer-grid">
                <div class="footer-about"><p class="footer-brand"><?= e(APP_NAME) ?></p><p>Thêm cảm hứng cho góc máy của bạn.<br>Thiết bị và phụ kiện cho mỗi ngày.</p><img class="footer-logo" src="<?= e(url('assets/anh_chan_dung.jpg')) ?>" alt="Ảnh chân dung Nguyễn Ngô Quốc Thịnh — logo cửa hàng" width="88" height="88" loading="lazy"></div>
                <div><h2>Khám phá</h2><a href="<?= e(url('index.php#products')) ?>">Tất cả sản phẩm</a><a href="<?= e(url('about.php')) ?>">Về Thịnh Nguyễn</a><a href="<?= e(url('contact.php')) ?>">Liên hệ cửa hàng</a></div>
                <div><h2>Tài khoản của bạn</h2><a href="<?= e(url('profile.php')) ?>">Thông tin tài khoản</a><a href="<?= e(url('orders.php')) ?>">Theo dõi đơn hàng</a><a href="<?= e(url('cart.php')) ?>">Giỏ hàng</a></div>
                <div class="footer-contact"><h2>Kết nối với chúng tôi</h2><a href="tel:0343180715"><?= e(STORE_PHONE) ?></a><a href="mailto:<?= e(STORE_EMAIL) ?>"><?= e(STORE_EMAIL) ?></a><p><?= e(STORE_ADDRESS) ?></p></div>
            </div>
            <div class="footer-bottom"><small>&copy; <?= date('Y') ?> <?= e(STUDENT_ID) ?> · <?= e(STUDENT_NAME) ?> · <?= e(STUDENT_CLASS) ?></small><span>Đồ án Lập trình Web · Dữ liệu minh họa</span></div>
        </div>
    </footer>
</body>
</html>
