# Kết quả kiểm thử

Nghiệm thu cuối 03/11/2026: `tools/final-audit.py` chạy 8 bộ trên bản sao Apache/PHP/MySQL riêng, tổng 84 ca/nhóm đạt (22 + 10 + 10 + 9 + 8 + 6 + 7 + 12). Bổ sung kiểm tra hết hàng rollback toàn bộ, giả tổng tiền, xác nhận xóa giỏ, CRUD danh mục/sản phẩm, thống kê khớp DB, toàn bộ endpoint admin bị chặn cho khách, giữ bộ lọc khi phân trang và 15 trang chi tiết. DB tạm dọn xong, dump CSDL và hash uploads chính trước/sau không đổi. 39 tệp PHP không lỗi cú pháp; 4 cách import/migration SQL đạt. Lượt trực tiếp localhost thêm 5 nhóm đạt, phpMyAdmin truy cập được. Thông báo giỏ đã sửa từ 900 về 2000ms, đo bản thử 2004ms và localhost 1924ms. Nhật ký `tools/final-audit-results.json`, `tools/final-live-results.json`; đối chiếu đề và điều kiện hồ sơ ở FINAL_AUDIT.md. Cập nhật 05/11/2026: theo xác nhận mới nhất, logo đã đổi sang ảnh chân dung sinh viên trên mọi trang; avatar tài khoản vẫn theo phiên đăng nhập. Kết quả kiểm tra ngày 03/11 bên dưới là lịch sử trước thay đổi logo. Báo cáo cũ và video vẫn cần hoàn thiện trước nộp.

Trang Giới thiệu nâng cấp (03/11/2026): HTTP 200, một h1, toàn bộ ảnh giải mã thành công; không tràn ngang ở 320/390/600/768/1000/1440/1920px. Bốn ô danh mục dẫn đúng category 1–4 và trả HTTP 200, focus bàn phím có viền rõ, không có lỗi JavaScript. Đã xem ảnh chụp desktop/mobile và cân chỉnh thẻ danh mục cao bằng nhau. PHP lint about/header và 7 nhóm test-ui đạt.

Ngày: 03/11/2026. PHP 8.2.12, MariaDB 10.4.32, MySQL local 3307, Chrome headless qua Playwright. Các script kiểm thử nằm ở tools/ trong thư mục cha.

## 22 kiểm tra luồng chính

Trang chủ phân trang 8 + 7; lọc/tìm/sắp xếp; product 404; responsive 4/3/2/1 không tràn ngang; quay lại checkout sau login; khách bị chặn admin; chặn xem đơn khác; giỏ session và tính tiền JS; transaction đặt hàng/trừ kho; hủy hoàn kho; hồ sơ; đổi mật khẩu từ chối mật khẩu hiện tại sai; CSRF; lưu liên hệ; dashboard; escape HTML liên hệ; thêm danh mục; CRUD sản phẩm/upload; thay ảnh xóa cũ; chuyển trạng thái đơn; GET không xóa sản phẩm; khóa login 5 lần.

## 10 kiểm tra bổ sung

Chặn thư mục nội bộ + custom 404; đăng ký + hash + PRG; email trùng; đổi mật khẩu đúng; đăng nhập mật khẩu mới; chặn xóa sản phẩm đã đặt; chặn xóa danh mục có hàng; từ chối tệp PHP giả JPEG; chặn hoàn tất → pending; các trang chính vừa màn hình 390px.

## Apache

Dự án đã chạy trực tiếp trên Apache XAMPP tại `http://localhost/thinh-tech/` ngày 03/11/2026. Cả 22 kiểm tra chính và 10 kiểm tra bổ sung đã chạy lại thành công trên đường dẫn thư mục con này, dùng `THINHTECH_TEST_BASE_URL=http://localhost/thinh-tech`. Đã xác nhận form đăng nhập giữ session, giỏ hàng/checkout, hủy hoàn kho, upload thay ảnh và chuyển hướng giữ đúng tiền tố `/thinh-tech/`.

phpMyAdmin tại `http://localhost/phpmyadmin/` truy cập được, hiển thị máy chủ `127.0.0.1:3307`, database `thinh_tech` với đủ 6 bảng. Lần rà soát sau cập nhật hồ sơ: categories 4, products 15, users 4, orders 8, order_items 12, contacts 1. Số liệu lúc đóng gói nằm trong deliverables/release-manifest.json. config/config.php và database/ trả 403; URL sai trả 404 riêng.

Dùng Apache XAMPP trên cổng kiểm thử 8089, cấu hình nằm trong tools/apache-test.conf, không sửa cấu hình XAMPP hệ thống. Đã xác nhận HTTP 200 cho trang chủ, 403 cho config/config.php, database/, includes/functions.php, uploads/test.php, database/thinh_tech.sql; 404 với giao diện riêng cho URL không tồn tại. Cần lặp lại các kiểm tra này trên hosting thật sau triển khai.

## Dữ liệu sau kiểm thử

4 danh mục, 15 sản phẩm, 4 tài khoản (1 admin), 8 đơn: pending 2, shipping 1, completed 2, cancelled 3. Có 1 liên hệ được gửi thật qua form trong quá trình chụp minh họa. Tài khoản, ảnh đại diện và đơn phát sinh từ thao tác của người dùng được giữ nguyên. Dữ liệu QA thanh toán/hồ sơ tạo tạm đã được dọn theo id riêng, hoàn tồn kho tương ứng.

## Kiểm tra sau cập nhật giao diện ASUS

Ngày 03/11/2026, chạy lại 22 + 10 kiểm tra trên `http://localhost/thinh-tech`: tất cả đạt. Kiểm tra cú pháp toàn bộ 32 tệp PHP không có lỗi. `tools/test-ui.cjs` bổ sung 7 nhóm kiểm tra và đều đạt:

- Trang chủ/đăng nhập/đăng ký không tràn ngang ở 320, 390, 768, 1000 và 1440px; ảnh tải đủ, giữ logo/tên cửa hàng. Header dùng biểu tượng đăng nhập chung cho khách theo bản cập nhật menu avatar.
- Hiện/ẩn mật khẩu qua Enter/Space, ARIA và giá trị nhập được giữ; autocomplete đăng nhập đúng.
- Menu mobile mở/đóng, Escape đưa focus về nút menu; điều hướng đăng ký và nhãn giỏ hàng đọc được.
- Đăng ký có hai nút hiện/ẩn; mật khẩu không khớp báo lỗi và đưa focus đúng trường; điều khoản mở đọc được.
- Tôn trọng cài đặt giảm chuyển động.
- Bảng đơn hàng, chi tiết và checkout không làm tràn trang ở 320/390/768px.
- Không có lỗi JavaScript trong console ở các luồng giao diện được kiểm tra.

Đã xem trực tiếp trang chủ, đăng nhập, đăng ký trên Chrome desktop và giao diện điện thoại. Ảnh mới ở `deliverables/preview` trong thư mục cha; kết quả máy đọc ở `tools/test-ui-results.json`. Những ảnh này là xem trước giao diện, chưa thay thế ảnh minh chứng có thanh địa chỉ cho báo cáo cuối.

## 10 nhóm kiểm tra thanh toán

`tools/test-payments.cjs` chạy đạt trên Apache localhost với MySQL cổng 3307. Kết quả máy đọc ở `tools/test-payment-results.json`.

- Đặt đơn chuyển khoản lưu thông tin người nhận theo đơn, tính tổng ở máy chủ và trừ kho đúng.
- PNG QR tải về được bộ đọc độc lập zxing-cpp giải mã; khớp BIDV, số tài khoản, số tiền, mã đơn, tiền tệ VND và CRC16.
- Chặn xem QR/báo chuyển tiền cho đơn người khác; khách không có quyền xác nhận tiền về; bắt buộc CSRF.
- Chặn giao đơn chuyển khoản chưa được admin xác nhận thanh toán.
- Khách nhấn thông báo nhiều lần không tự đánh dấu đã trả và không đổi tổng tiền.
- Admin xác nhận ghi thời gian/người đối soát; thao tác lặp bị chặn; ẩn QR sau khi đã nhận tiền.
- Hủy đơn đã thanh toán hoàn kho đúng một lần, chuyển chờ hoàn tiền; admin có thể ghi nhận hoàn tiền.
- Chuyển khoản muộn sau khi hủy đi vào luồng đối soát/hoàn tiền, không mở lại đơn.
- COD không có QR, ghi nhận đã thu khi hoàn tất; từ chối phương thức giả và yêu cầu hoàn tiền sai trạng thái; không tràn ngang ở 320/390/768/1440px.
- Không có lỗi JavaScript trong các luồng được kiểm tra.

Sau cập nhật đã chạy lại 22 + 10 kiểm tra cũ và 7 nhóm giao diện, đều đạt; kiểm tra cú pháp 38 tệp PHP không có lỗi. Ảnh thanh toán desktop/mobile và checkout ở `deliverables/preview`. Không thực hiện giao dịch ngân hàng thật; xác nhận admin trong bài kiểm thử chỉ là dữ liệu tạm để kiểm tra trạng thái.

`tools/test-payment-install.py` đã kiểm tra riêng ba cách cài đặt trong CSDL tạm: import bộ khởi tạo, import bản xuất hiện tại và nâng cấp CSDL cũ bằng migration. Cả ba đều có đủ 6 bảng/cột thanh toán và trạng thái đơn cũ đúng. CSDL tạm được dọn sau mỗi kiểm tra; CSDL website hiện tại được giữ nguyên. Kết quả ở `tools/test-payment-install-results.json`.

## 9 nhóm kiểm tra hồ sơ và ảnh đại diện

`tools/test-profile.cjs` chạy đạt trên Apache localhost, dùng tài khoản QA riêng và dọn sau kiểm thử. Kết quả ở `tools/test-profile-results.json`.

- Bắt buộc đăng nhập; có chữ viết tắt tên khi chưa có ảnh, email chỉ đọc; avatar tài khoản nằm bên phải, tách biệt logo chân dung cửa hàng bên trái (cập nhật ngày 05/11).
- Lưu thông tin cá nhân; bỏ qua id/email/role giả gửi lên; không sửa tài khoản khác; bắt buộc CSRF.
- Xem trước và bỏ ảnh chọn; tải PNG được lưu tên ngẫu nhiên, hiện ở góc trên và phục vụ với MIME ảnh/nosniff.
- Lỗi giữ dữ liệu nhập, focus bảng lỗi có liên kết và giữ ảnh đã lưu; không cập nhật một phần khi có lỗi.
- Máy chủ chặn ảnh giả, SVG, ảnh vượt 2 MB hoặc 4096 pixel; có thể bỏ lựa chọn sai ở trình duyệt.
- Thay JPG/WebP xóa ảnh cũ sau khi lưu; lưu không chọn ảnh vẫn giữ ảnh; đăng nhập lại vẫn có avatar.
- Không tràn ngang ở 320/390/768/1000/1440px và màn hình ngang 844px; xóa ảnh đồng bộ phiên đăng nhập khác.
- Lưu hồ sơ/ảnh bằng form chuẩn vẫn hoạt động khi tắt JavaScript.
- Không có lỗi JavaScript.

Sau cập nhật đã chạy lại 22 luồng chính, 10 kiểm tra bổ sung, 10 nhóm thanh toán và 7 nhóm giao diện; tất cả đạt. Kiểm tra cú pháp 39 tệp PHP đạt. Ảnh xem trước ở `deliverables/preview/profile-desktop.png` và `profile-mobile.png`, là dữ liệu QA minh họa đã dọn sau khi chụp.

Kiểm tra import trong CSDL tạm đã đạt cả bộ khởi tạo, bản xuất mới, migration thanh toán và migration avatar. CSDL cũ giữ đủ tài khoản khi thêm cột users.avatar; không tạo thêm bảng. CSDL tạm được dọn sau kiểm tra.

## 8 nhóm kiểm tra menu avatar

Ở bản kiểm tra ngày 03/11/2026, ảnh chân dung cố định được bỏ và liên kết Tài khoản chuyển vào menu avatar. Ngày 05/11 đã khôi phục chân dung ở vị trí logo cửa hàng theo yêu cầu mới; menu avatar giữ nguyên. `tools/test-account-menu.cjs` đã đạt:

- Khách chưa đăng nhập thấy biểu tượng dẫn đến đăng nhập, không có ảnh/tên tài khoản trước đó.
- Avatar góc trên đúng theo người đăng nhập ở trang chủ/hồ sơ/đơn hàng/liên hệ; bấm mở Tài khoản của tôi.
- Enter/Space/ArrowDown hoạt động; Escape đóng và trả focus; bấm hoặc chuyển focus ra ngoài đóng menu.
- Menu nằm trong màn hình ở 320/390/768/1000/1440px, không mở chồng với điều hướng mobile.
- Lưu ảnh cập nhật header; đổi tài khoản đổi tên/ảnh tương ứng; đăng xuất không giữ thông tin cũ.
- Admin có Quản trị cửa hàng; khách không có liên kết quản trị.
- Menu, liên kết hồ sơ và POST đăng xuất hoạt động khi tắt JavaScript.
- Không có lỗi JavaScript.

Đã chạy lại 9 nhóm hồ sơ, 7 nhóm giao diện, 22 luồng chính và 10 kiểm tra bổ sung sau thay đổi header; tất cả đạt. Ảnh `deliverables/preview/avatar-menu-desktop.png` và `avatar-menu-mobile.png` là minh họa từ tài khoản QA đã dọn. Kết quả máy đọc ở `tools/test-account-menu-results.json`.

## 6 nhóm kiểm tra thêm giỏ tại chỗ

`tools/test-cart-async.cjs` chạy trên Apache localhost, dùng session riêng và không thay đổi dữ liệu đơn/tồn kho:

- Thêm từ danh sách giữ URL, bộ lọc và vị trí cuộn; hiện thông báo, cập nhật số lượng và nhãn hỗ trợ giỏ.
- Thêm nhiều lần/số lượng từ chi tiết được lưu đúng; chỉ chuyển giỏ khi bấm liên kết; thông báo vừa màn hình 320/390/768/1440px.
- Đang xử lý có trạng thái bận, chặn nút/gửi trùng; khôi phục điều khiển sau phản hồi.
- Tổng số lượng không vượt tồn kho; từ chối id/số lượng sai dạng, sản phẩm không tồn tại và GET ở API JSON.
- CSRF hết hạn/lỗi mạng hiện thông báo đúng, giữ nguyên trang/số lượng, không tự thử lại yêu cầu.
- Tắt JavaScript vẫn thêm được và quay về trang danh sách/chi tiết với thông báo; chặn chuyển hướng ra ngoài. Tồn kho không đổi, không có lỗi JavaScript.

Kết quả ở tools/test-cart-async-results.json; ảnh desktop/mobile ở deliverables/preview/cart-added-*.png. Các kiểm tra giỏ/đặt hàng/thanh toán và giao diện đã được cập nhật để chủ động mở giỏ sau khi thêm.

## Giới hạn hiện tại

Chưa kiểm thử hosting, HTTPS và panel nhà cung cấp. Không dùng dữ liệu này để tuyên bố đã đạt phần E. Ảnh chụp tự động chưa có thanh địa chỉ trình duyệt. D10 khóa theo session. Chưa chạy thử tải đồng thời lớn hoặc đánh giá bảo mật production.


Cập nhật thông báo phía trên (03/11/2026): kiểm tra trình duyệt xác nhận vị trí trên desktop/mobile, tự ẩn sau khoảng 3 giây, đặt lại thời gian khi thêm tiếp, tạm dừng khi hover/focus và đếm lại sau khi rời. Đã chạy lại đủ 6 nhóm test-cart-async, PHP lint header và xem ảnh mobile; đều đạt.

Điều chỉnh vị trí theo yêu cầu: thông báo nằm ở góc trên bên phải (cách mép trên/phải 24px trên desktop, 16px trên điện thoại). Kiểm tra Chrome ở 1440px và 390px xác nhận đúng vị trí, tự ẩn sau khoảng 3 giây và giữ nguyên trang sản phẩm.

Cập nhật thời gian theo yêu cầu: thông báo góc trên bên phải tự ẩn sau 2 giây. Chrome kiểm tra thực tế 2009ms, vẫn hiển thị sau 1 giây và giữ nguyên trang sản phẩm; đạt.

Lịch sử kiểm tra logo nét ký trước ngày 05/11 (đã được thay bằng chân dung): SVG hợp lệ, ảnh header/footer tải đầy đủ; chạy lại 7 nhóm test-ui đều đạt, không tràn ngang ở 320/390/768/1000/1440px. Đã xem ảnh header desktop/mobile và bảng logo đen–trắng.

Favicon tab: đổi sang đường dẫn favicon-signature.svg/ico mới để tránh cache biểu tượng cũ; kiểm tra trang chủ/đăng nhập/đăng ký có đủ hai định dạng, HTTP 200 và giải mã hình ảnh thành công. PHP lint header đạt.

Danh mục ảnh thật (03/11/2026): kiểm tra đủ 15 trang chi tiết khớp tên, ảnh cục bộ 1100 × 1100 và thương hiệu/thông số; tìm kiếm Logitech trả đúng 6 món, thêm giỏ tại chỗ cập nhật đúng. Desktop/mobile 320/390/768/1440px không tràn ngang. 6 nhóm test-cart-async và 7 nhóm test-ui đạt; bản seed/export và migration thanh toán/avatar cài trên DB thử đều đạt. Migration danh mục chạy hai lần trên DB thử vẫn đúng 15 món, giữ ID/giá/tồn kho. Trước/sau cập nhật DB thật đã đối chiếu giá/tồn kho/danh mục và toàn bộ order_items, số lượng users/orders/contacts không đổi. Ảnh tổng hợp ở deliverables/preview/real-products-contact-sheet.jpg.

Ảnh banner thật: đủ 3 ảnh giải mã thành công từ assets/photos, không tràn trang ở 320/390/600/768/1000/1440/1920px; hai ô dẫn đúng danh mục 1/2 và hiện đúng 4 sản phẩm. Đã xem ảnh desktop/mobile, cân chỉnh vùng chữ và ảnh tai nghe; 7 nhóm test-ui và PHP lint index đạt. Nguồn ảnh lưu assets/photos/sources.json và PRODUCT_SOURCES.md.

## Logo chân dung — 05/11/2026

- Đã thay logo header/footer và favicon bằng ảnh chân dung có sẵn, theo xác nhận mới nhất của sinh viên sau khi hỏi lại giảng viên.
- 47 lượt kiểm tra trang/kích thước trên localhost đạt: trang công khai, đăng nhập/đăng ký, sản phẩm, 404, trang quản trị, hồ sơ và đơn hàng; gồm 320/390/768/1440px. Ảnh tải đủ, tên cửa hàng hiển thị, không tràn ngang hoặc đè logo lên nút tài khoản. Hai favicon trả HTTP 200.
- Kiểm tra cú pháp header/footer, 404 và tổng quan admin đạt. Chỉ đăng nhập và xem trang; không đổi sản phẩm, đơn hàng, hồ sơ hoặc tồn kho.
- Nhật ký: tools/portrait-logo-results.json; ảnh xem trước: deliverables/preview/portrait-logo/ ở thư mục cha. Ảnh xem trước không có thanh địa chỉ, cần chụp lại ảnh minh chứng báo cáo có thanh địa chỉ theo đề.

### Rà lại sau đổi logo — 05/11/2026

- Phát hiện dropdown avatar lệch ra mép trái trên màn hình nhỏ do vị trí nút tài khoản thay đổi; đã sửa neo dropdown tại breakpoint 600px và cập nhật phiên bản CSS.
- Chạy tools/check-portrait-logo.cjs: 151 lượt trang/kích thước đạt với khách vãng lai, khách hàng và admin; các chiều rộng 320/390/600/601/768/900/1000/1440px. Kiểm tra logo header/footer, tên cửa hàng, thông tin sinh viên ở chân trang, không tràn ngang; dropdown nằm trong màn hình, mở hồ sơ, đóng bằng Escape, tương tác menu mobile, thông báo thêm giỏ tại chỗ, giao diện không JavaScript và hai favicon. Không có lỗi JavaScript.
- Cả 39 tệp PHP kiểm tra cú pháp đạt. Lượt rà này không tạo/sửa đơn, sản phẩm, hồ sơ hoặc tồn kho; không chạy lại bộ kiểm thử nghiệp vụ ghi dữ liệu.
- Đồng bộ kỳ vọng ảnh chân dung trong tools/test-account-menu.cjs theo yêu cầu mới. Báo cáo PDF nháp và ảnh minh chứng cũ vẫn phải cập nhật trước khi nộp.
