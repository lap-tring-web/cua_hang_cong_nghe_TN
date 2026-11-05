# Hướng dẫn thanh toán

Website local: http://localhost/thinh-tech/ . XAMPP Apache + MySQL cổng **3307**. Không cần cài thêm dịch vụ ngân hàng để dùng luồng hiện tại.

## Khách mua hàng

1. Đăng nhập, thêm sản phẩm vào giỏ, chọn **Đặt hàng**.
2. Kiểm tra thông tin nhận hàng, chọn một phương thức rồi nhấn **Xác nhận đặt hàng**:
   - **Thanh toán khi nhận hàng (COD)**: trả tiền cho nhân viên giao hàng lúc nhận sản phẩm.
   - **Chuyển khoản ngân hàng**: trang chi tiết đơn hiển thị QR BIDV, số tiền và nội dung chuyển khoản riêng (ví dụ `TN000017`).
3. Với chuyển khoản, dùng ứng dụng ngân hàng quét hoặc tải ảnh QR. Kiểm tra đúng người nhận, số tiền và nội dung trong ứng dụng trước khi xác nhận chuyển.
4. Sau khi thực sự chuyển khoản, nhấn **Tôi đã chuyển khoản**. Website hiển thị **Chờ đối soát chuyển khoản**. Nút này chỉ gửi thông báo cho shop.
5. Mở **Đơn hàng của tôi → Chi tiết** để theo dõi. Khi shop đã xác nhận, trạng thái thành **Đã thanh toán** và QR được ẩn.

## Shop đối soát

1. Đăng nhập admin, vào **Quản trị → Đơn hàng → Chi tiết**.
2. Đối chiếu giao dịch trong ứng dụng/sao kê BIDV với đúng số tiền và mã chuyển khoản của đơn.
3. Khi đã nhận đủ tiền thực tế, nhấn **Xác nhận đã nhận tiền** và xác nhận trong hộp thoại. Website lưu thời gian và tài khoản quản trị xác nhận.
4. Đơn chuyển khoản chỉ được chuyển sang đang giao/hoàn tất khi đã thanh toán. COD ghi nhận đã thu khi admin chuyển đơn sang hoàn tất.

Website hiện dùng đối soát thủ công. Chưa có kết nối ngân hàng, webhook hay cổng thanh toán để tự nhận thông báo tiền về; các nút trên website không thực hiện giao dịch ngân hàng.

## Hủy và hoàn tiền

- Khách hủy đơn đang chờ xử lý; quản trị có thể hủy đơn chờ/đang giao theo quy tắc hiện có. Hệ thống hoàn kho đúng một lần.
- Đơn đã thanh toán bị hủy chuyển sang **Chờ shop hoàn tiền**. Shop liên hệ khách, thực hiện hoàn tiền thực tế qua ngân hàng, sau đó chọn **Xác nhận đã hoàn tiền** trong chi tiết đơn.
- Hủy đơn không tự chuyển tiền lại cho khách. Đơn chuyển khoản đã hủy sẽ ẩn QR để tránh trả nhầm. Nếu khách đã chuyển tiền trước khi hủy nhưng chưa báo, vẫn có nút báo để shop đối soát và xử lý hoàn tiền.

## Thông tin nhận tiền

- Ngân hàng: **BIDV**, BIN `970418`.
- Số tài khoản: **8843681906**.
- Chủ tài khoản: **NGUYỄN NGÔ QUỐC THỊNH**, do chủ cửa hàng xác nhận.

Cấu hình ở `config/config.php`, các hằng `PAYMENT_BANK_BIN`, `PAYMENT_BANK_NAME`, `PAYMENT_ACCOUNT_NUMBER`, `PAYMENT_ACCOUNT_NAME`. Nếu đổi ngân hàng sau này, cập nhật cả BIN/tên/tài khoản và kiểm tra lại QR. Thông tin được chụp lại theo đơn khi đặt; đổi cấu hình chỉ áp dụng cho đơn mới.

QR VietQR được tạo cục bộ bằng PHP, kèm số tiền và nội dung đơn; không gửi số tài khoản qua API tạo QR bên ngoài. Ảnh QR gốc chủ shop cung cấp lưu ở `assets/payment-qr-original.png` để tham khảo; QR dùng khi mua hàng được tạo riêng theo đơn.

## Cài đặt và cập nhật CSDL

- Máy hiện tại đã áp dụng migration; không cần import lại.
- Cài mới: import **một** tệp `database/thinh_tech_export.sql` (dữ liệu bản đóng gói) hoặc `database/thinh_tech.sql` (dữ liệu khởi tạo). Cả hai đã có đủ cột thanh toán.
- Cập nhật bản cũ: sao lưu CSDL, chạy **một lần** `database/migrations/20261103_payments.sql` qua phpMyAdmin, rồi dùng mã nguồn mới. Không chạy sau khi đã import SQL mới.
- Migration giữ nguyên đơn cũ và coi là COD; đơn đã hoàn tất được ghi nhận đã thu. Vẫn có 6 bảng, các trường thanh toán nằm trong `orders`.

## Kiểm chứng

10 nhóm kiểm thử thanh toán đã đạt trên localhost, gồm phân quyền/CSRF, tổng tiền, trạng thái, hoàn kho/hoàn tiền, COD và bố cục mobile. PNG QR đã được giải mã độc lập để đối chiếu tài khoản, số tiền, nội dung và CRC. Chưa thực hiện giao dịch ngân hàng thật. Chi tiết ở `TEST_RESULTS.md`.
