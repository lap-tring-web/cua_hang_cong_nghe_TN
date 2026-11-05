<?php
require __DIR__ . '/includes/init.php';
$pageTitle = 'Về Thịnh Nguyễn';
require __DIR__ . '/includes/header.php';
?>
<div class="about-page">
    <section class="about-intro" aria-labelledby="about-title">
        <div class="about-intro-copy">
            <p class="section-kicker">VỀ THỊNH NGUYỄN · TECH & ACCESSORIES</p>
            <h1 id="about-title">Công nghệ gần hơn.<br><span>Cảm hứng mỗi ngày.</span></h1>
            <p>Một chiếc bàn phím vừa tay, một âm thanh yêu thích, một góc máy đúng chất bạn. Bắt đầu từ những điều nhỏ để mỗi ngày thêm hiệu quả.</p>
            <div class="about-actions">
                <a class="btn" href="<?= e(url('index.php#products')) ?>">Khám phá sản phẩm <span aria-hidden="true">↗</span></a>
                <a class="about-text-link" href="#our-story">Câu chuyện của chúng tôi <span aria-hidden="true">↓</span></a>
            </div>
        </div>
        <figure class="about-intro-photo">
            <img src="<?= e(url('assets/photos/about-desk.webp')) ?>" alt="Bàn phím, chuột và phụ kiện trên tấm lót bàn Logitech trong một góc làm việc sáng màu" width="1200" height="675" fetchpriority="high">
            <figcaption>Không gian của bạn. Phong cách của bạn.</figcaption>
        </figure>
    </section>
    <div class="about-brand-line"><span>THỊNH NGUYỄN</span><p>Thiết bị phù hợp cho <strong>học tập · làm việc · giải trí</strong></p></div>
    <section class="about-story" id="our-story" aria-labelledby="story-title">
        <figure>
            <img src="<?= e(url('assets/photos/about-everyday.webp')) ?>" alt="Không gian làm việc sáng tạo với tai nghe không dây Logitech Zone Vibe 100" width="1000" height="562" loading="lazy">
            <figcaption>Phụ kiện nhỏ, trải nghiệm khác biệt.</figcaption>
        </figure>
        <div class="about-story-copy">
            <p class="section-kicker">TỪ NHU CẦU MỖI NGÀY</p>
            <h2 id="story-title">Một góc máy tốt hơn.<br>Một ngày nhiều cảm hứng hơn.</h2>
            <p><?= e(APP_NAME) ?> hướng đến những thiết bị dễ dùng và phù hợp với nhịp sống của bạn — từ buổi học trực tuyến, giờ làm việc tập trung đến những phút giải trí cuối ngày.</p>
            <p>Chúng tôi tập trung vào phụ kiện máy tính, âm thanh, lưu trữ và kết nối. Thông tin rõ ràng giúp bạn tìm hiểu, so sánh và chọn món đồ phù hợp với góc máy của mình.</p>
            <a class="about-text-link" href="<?= e(url('contact.php')) ?>">Kết nối với Thịnh Nguyễn <span aria-hidden="true">→</span></a>
        </div>
    </section>
    <section class="about-collections" aria-labelledby="collections-title">
        <div class="about-section-heading"><div><p class="section-kicker">CHỌN THEO NHU CẦU</p><h2 id="collections-title">Công nghệ cho thế giới của bạn</h2></div><a class="about-text-link" href="<?= e(url('index.php#products')) ?>">Tất cả sản phẩm <span aria-hidden="true">→</span></a></div>
        <div class="about-collection-grid">
            <?php
            $collections = [
                ['id' => 1, 'title' => 'Chuột & bàn phím', 'copy' => 'Thoải mái trong từng thao tác.', 'image' => 'keychron-k8.webp', 'alt' => 'Bàn phím cơ Keychron K8'],
                ['id' => 2, 'title' => 'Âm thanh & hình ảnh', 'copy' => 'Kết nối rõ ràng, cảm hứng trọn vẹn.', 'image' => 'logitech-zone-vibe-100.webp', 'alt' => 'Tai nghe Logitech Zone Vibe 100'],
                ['id' => 3, 'title' => 'Lưu trữ & kết nối', 'copy' => 'Gọn nhẹ để luôn sẵn sàng.', 'image' => 'samsung-t7-500gb-red.webp', 'alt' => 'Ổ cứng di động Samsung T7 màu đỏ'],
                ['id' => 4, 'title' => 'Phụ kiện góc máy', 'copy' => 'Hoàn thiện không gian của bạn.', 'image' => 'benq-screenbar.webp', 'alt' => 'Đèn màn hình BenQ ScreenBar'],
            ];
            foreach ($collections as $collection): ?>
                <a class="about-collection" href="<?= e(url('index.php?category=' . $collection['id'] . '#products')) ?>">
                    <div class="about-collection-image"><img src="<?= e(url('images/products/' . $collection['image'])) ?>" alt="<?= e($collection['alt']) ?>" width="1100" height="1100" loading="lazy"></div>
                    <div class="about-collection-copy"><h3><?= e($collection['title']) ?></h3><p><?= e($collection['copy']) ?></p><span class="about-collection-arrow" aria-hidden="true">↗</span></div>
                </a>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="about-values" aria-labelledby="values-title">
        <div class="about-values-heading"><p class="section-kicker">TRẢI NGHIỆM TẠI THỊNH NGUYỄN</p><h2 id="values-title">Dễ chọn. Dễ mua.<br>Dễ theo dõi.</h2></div>
        <div class="about-value-list">
            <article><span aria-hidden="true">01</span><div><h3>Tìm đúng thứ bạn cần</h3><p>Tìm theo tên, lọc danh mục và sắp xếp theo giá để lựa chọn thuận tiện hơn.</p></div></article>
            <article><span aria-hidden="true">02</span><div><h3>Thông tin luôn rõ ràng</h3><p>Xem hình ảnh thực tế, thông số, giá và số lượng còn hàng trước khi đặt mua.</p></div></article>
            <article><span aria-hidden="true">03</span><div><h3>Chủ động trong từng đơn hàng</h3><p>Chọn thanh toán khi nhận hàng hoặc chuyển khoản; theo dõi đơn ngay trong tài khoản.</p></div></article>
        </div>
    </section>
    <section class="about-connect" aria-labelledby="connect-title">
        <div><p class="section-kicker">CÙNG HOÀN THIỆN GÓC MÁY</p><h2 id="connect-title">Bắt đầu từ một kết nối.</h2><p>Chia sẻ nhu cầu của bạn với Thịnh Nguyễn.</p><a class="btn" href="<?= e(url('contact.php')) ?>">Liên hệ cửa hàng <span aria-hidden="true">→</span></a></div>
        <address><div><span>GỌI CHO CHÚNG TÔI</span><a href="tel:0343180715"><?= e(STORE_PHONE) ?></a></div><div><span>EMAIL</span><a href="mailto:<?= e(STORE_EMAIL) ?>"><?= e(STORE_EMAIL) ?></a></div><div><span>ĐỊA CHỈ LIÊN HỆ</span><p><?= e(STORE_ADDRESS) ?></p></div></address>
    </section>
    <p class="about-project-note">Website được <?= e(STUDENT_NAME) ?> xây dựng trong đồ án Lập trình Web. Giá, dữ liệu mua sắm và đơn hàng phục vụ minh họa chức năng.</p>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
