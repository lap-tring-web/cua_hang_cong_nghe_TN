# Kiểm tra cuối trước khi quay video và nộp đồ án

**Chuẩn đối chiếu đã chốt ngày 05/11/2026:** theo xác nhận của sinh viên, chỉ áp dụng đề PDF ban đầu: tối thiểu **12 sản phẩm, 3 danh mục**, video **5–10 phút**. Không áp dụng yêu cầu nội dung trong ảnh LMS vừa gửi. Hiện có 15 sản phẩm và 4 danh mục, đã đạt ngưỡng dữ liệu này. Logo cửa hàng dùng ảnh chân dung theo xác nhận mới nhất ngày 05/11/2026; avatar tài khoản theo người đăng nhập.

Kiểm tra ngày 03/11/2026, vai trò khách hàng và quản trị viên. Đối chiếu PDF đề thi 8 trang và mẫu báo cáo Word trong thư mục cha.

**Kết luận:** có thể tập và quay demo chức năng trên localhost. Các chức năng A–D đã chạy đạt trong phạm vi kiểm tra; bộ hồ sơ nộp còn cần cập nhật báo cáo và bổ sung video. Ngày 05/11/2026, sinh viên xác nhận phải dùng ảnh chân dung làm logo cửa hàng sau khi hỏi lại giảng viên. Hosting E chưa triển khai theo lựa chọn của sinh viên.

## Kết quả thực chạy

- 8 bộ kiểm tra trình duyệt, 84 ca/nhóm: luồng chính 22, bổ sung 10, thanh toán 10, hồ sơ 9, menu avatar 8, giỏ bất đồng bộ 6, giao diện 7, nghiệm thu bổ sung 12. Toàn bộ đạt trên bản sao mã nguồn/CSDL riêng qua Apache/PHP/MySQL 3307.
- Lượt kiểm tra trực tiếp localhost đạt 5 nhóm: trang công khai/ảnh; đăng nhập khách và hồ sơ/đơn/phân quyền; đăng nhập admin và toàn bộ trang quản lý; 403/404/phpMyAdmin; thông báo giỏ khoảng 2 giây.
- 39 tệp PHP qua kiểm tra cú pháp. SQL khởi tạo, bản xuất, migration thanh toán và avatar cài được trong DB tạm, sau đó dọn DB tạm.
- So sánh bản dump trước/sau và SHA-256 tệp trong uploads xác nhận CSDL và ảnh người dùng trên website chính không đổi. Các đơn hàng thao tác trong thử nghiệm thuộc DB riêng; không thực hiện chuyển tiền ngân hàng thật.
- Phát hiện thời gian thông báo trong mã là 900ms; đã khôi phục 2000ms theo yêu cầu. Đo trên bản thử khoảng 2004ms, trên localhost khoảng 1924ms sau khi thao tác thêm hoàn thành. Hover/focus vẫn tạm dừng bộ đếm.
- Lần chạy đầu bộ hồ sơ thiếu header nosniff vì máy chủ kiểm thử chưa nạp mod_headers. Đã sửa cấu hình kiểm thử và chạy lại đủ bộ đạt; không thay đổi cấu hình XAMPP chính.

Nhật ký máy đọc: `tools/final-audit-results.json`, `tools/final-live-results.json`, `tools/test-payment-install-results.json` trong thư mục cha. Lượt nghiệm thu đầy đủ: `tools/runtime/final-audit-20261103_174800/`. Ảnh xem trước: `deliverables/preview/final-audit/` (ảnh từ bản thử có dữ liệu QA; `live-admin.png` là số liệu thật của localhost). Ảnh tự động không có thanh địa chỉ, chỉ dùng tham khảo, không tự nhận là bộ ảnh minh chứng nộp cuối.

## Dữ liệu hiện tại

| Chỉ số | Kết quả |
|---|---:|
| Danh mục | 4 |
| Sản phẩm có ảnh, mô tả, giá | 15 |
| Tài khoản | 4, gồm 1 admin |
| Đơn hàng | 12 |
| Chờ xử lý | 4 |
| Đang giao | 1 |
| Hoàn tất | 2 |
| Đã hủy | 5 |
| Chi tiết đơn hàng | 16 dòng |
| Liên hệ | 1 |

Đủ ngưỡng dữ liệu tối thiểu theo đề. Giá/tồn kho phục vụ đồ án. Các ảnh/tên/thông số thiết bị thật được lưu nguồn ở PRODUCT_SOURCES.md. Đơn cũ có thể giữ tên minh họa lúc đặt vì order_items là lịch sử, không được đổi theo tên mới của sản phẩm.

## Đối chiếu A–D

“Đạt” dưới đây là chức năng đã kiểm tra, không phải điểm số hay xác nhận giảng viên chấp nhận hồ sơ. Yêu cầu nhận diện được cập nhật ngày 05/11/2026: ảnh chân dung làm logo trên mọi trang, kể cả quản trị.

| Mã | Kết quả đối chiếu |
|---|---|
| A1 | Đạt: header/nav/main/footer dùng chung, ảnh có thuộc tính alt, đường dẫn qua url(). |
| A2 | Đạt: Giới thiệu, Liên hệ; kiểm tra đủ 15 trang chi tiết có ảnh và bảng thông số. |
| A3 | Đạt: label, required, pattern điện thoại, minlength mật khẩu; lỗi được hiển thị. |
| A4 | Đạt: CSS riêng, :root, Flexbox header, Grid sản phẩm. |
| A5 | Đạt: 4/3/2/1 cột ở các khoảng kích thước yêu cầu; các trang khách/admin đã kiểm tra không tràn ngang. Bảng rộng cuộn trong khung riêng. |
| A6 | Đạt: active ở nav chính, nav quản trị, bộ lọc và phân trang. |
| A7 | Đạt: mật khẩu không khớp được báo; liên hệ ngắn bị chặn cả JavaScript và máy chủ. |
| A8 | Đạt: tổng giỏ tính ngay; xác nhận xóa dòng/xóa toàn bộ, nút Quay lại giữ giỏ. |
| B1 | Đạt: includes/init.php/functions.php/header.php/footer.php, cấu hình config/. |
| B2 | Đạt: 5 bảng bắt buộc và contacts, khóa chính, 4 quan hệ khóa ngoại bắt buộc, utf8mb4. |
| B3 | Đạt trong phạm vi rà soát: PDO, prepared statements cho tham số, e() cho văn bản; thử tìm kiếm SQL payload và liên hệ chứa script không thực thi. |
| B4 | Đạt: danh sách từ DB, lọc danh mục, tìm Logitech được 6 món. |
| B5 | Đạt: sản phẩm không tồn tại trả HTTP 404. |
| B6 | Đạt: tăng/giảm giá từ danh sách ORDER BY cho phép; kiểm tra thứ tự kết quả. |
| B7 | Đạt: số lượng kết quả; tối đa 3 sản phẩm cùng danh mục trên chi tiết. |
| C1 | Đạt: kiểm tra máy chủ/giữ trường lỗi/email trùng/password_hash; đăng ký tài khoản mới. |
| C2 | Đạt: session, đổi session ID khi đăng nhập, đăng xuất POST, giao diện theo trạng thái, PRG/flash. |
| C3 | Đạt: thêm/cập nhật/xóa dòng/xóa giỏ, giá đọc máy chủ; không tin tổng tiền giả. |
| C4 | Đạt: checkout transaction/FOR UPDATE/lưu đơn giá/trừ kho; thiếu hàng giữa giao dịch không tạo đơn hoặc trừ kho một phần. |
| C5 | Đạt: lịch sử/chi tiết của mình; khách khác không đọc đơn/QR bằng đổi id. |
| C6 | Đạt: chỉ khách sở hữu hủy đơn pending; hoàn kho một lần; thử hủy lặp không cộng thêm. |
| C7 | Đạt: sửa họ tên/số điện thoại/địa chỉ, giữ email/quyền; avatar là chức năng bổ sung đã kiểm tra. |
| C8 | Đạt: liên hệ lưu contacts và admin đọc được; nội dung HTML được hiển thị dạng chữ. |
| C9 | Đạt: khách vào orders/checkout trước đăng nhập được trả về đúng trang; checkout giỏ rỗng dẫn giỏ. |
| D1 | Đạt: tài khoản khách thử toàn bộ endpoint PHP trong admin/ nhận HTTP 403. |
| D2 | Đạt: sản phẩm phân trang 10/trang, thêm/sửa/xóa bằng POST; xóa sản phẩm có đơn bị chặn. |
| D3 | Đạt: kiểm tra nội dung ảnh, giới hạn 2 MB, tên ngẫu nhiên; .htaccess cấm PHP; ảnh giả bị từ chối. |
| D4 | Đạt: admin xem đơn, 4 bộ lọc khớp DB; đổi trạng thái hợp lệ, chặn quay ngược đơn hoàn tất. |
| D5 | Đạt: CSRF trên POST, 403 thư mục nội bộ, 404 riêng; kiểm tra lại trên Apache chính. |
| D6 | Đạt: thêm/đổi tên/xóa danh mục rỗng; chặn xóa danh mục có sản phẩm. |
| D7 | Đạt: thay ảnh sản phẩm xóa ảnh uploads cũ sau lưu thành công. |
| D8 | Đạt: 8 + 7 món ở trang chủ; giữ category/q/sort khi chuyển trang bằng 9 fixture tạm trong DB riêng. Danh mục thật hiện tối đa 4 món nên không tự hiện trang 2 khi lọc riêng. |
| D9 | Đạt: số đơn theo trạng thái, doanh thu chỉ từ completed, 5 món tồn thấp nhất khớp DB. |
| D10 | Đạt: 5 lần sai khóa form; mã đặt thời hạn time()+300. Khóa theo session, mở phiên khác có bộ đếm riêng. |
| D11 | Đạt: sai mật khẩu cũ bị chặn; đúng thì đổi được và đăng nhập bằng mật khẩu mới. |

Thanh toán bổ sung: COD, QR chuyển khoản BIDV khớp số tiền/mã đơn và CRC khi giải mã độc lập; không giao đơn chuyển khoản chưa đối soát; báo chuyển khoản không tự ghi đã trả; hủy đơn đã trả chuyển chờ hoàn, admin ghi nhận hoàn sau khi hoàn thực tế. Chưa tích hợp đối soát ngân hàng tự động.

## Nhận diện đã chốt và công việc trước nộp

1. **Nhận diện theo xác nhận mới nhất 05/11/2026:** logo cửa hàng phải là ảnh chân dung Nguyễn Ngô Quốc Thịnh trên mọi trang, kể cả quản trị. Đã thay header, footer và favicon; tên cửa hàng hiển thị trên điện thoại. Avatar người dùng vẫn theo tài khoản. Chụp lại ảnh minh chứng và quay video theo giao diện mới.
2. **Báo cáo:** PDF hiện là bản nháp giao diện cũ; mẫu Word gốc còn là mẫu. Cần bản báo cáo mới theo mẫu, ảnh minh chứng đủ từng mã, số hình đối chiếu, toàn bộ SQL/mã nguồn cùng phiên bản ZIP. Không dùng ảnh QA làm số liệu cuối.
3. **Video:** sinh viên tự quay/thuyết minh 5–10 phút, theo VIDEO_SCRIPT.md đã cập nhật; tải lên YouTube không công khai/Drive và kiểm tra liên kết bằng cửa sổ ẩn danh. Chưa có URL video để kiểm tra hoặc điền báo cáo.
4. **Hosting E:** chưa triển khai, ghi “Không triển khai”; không tính localhost là hosting thật.
5. **Sau khi quay:** các thao tác đăng ký/đặt hàng/sửa dữ liệu sẽ đổi số liệu. Chốt dữ liệu sau buổi quay, xuất SQL/ZIP lại, đồng bộ báo cáo và Google Form. Nộp đủ LMS và Form của giảng viên trước 23:00 ngày 07/11/2026 theo đề.

## Lượt quay đề xuất

Mở VIDEO_SCRIPT.md để xem lời dẫn và mốc thời gian. Dùng hai phiên khách/admin riêng. Luồng chính: trang chủ → tìm Logitech/lọc/sắp xếp → chi tiết → đăng ký/đăng nhập → giỏ → checkout/QR → xem/hủy đơn → avatar/profile → admin sản phẩm/danh mục/đơn/tổng quan → phpMyAdmin → giải thích transaction và bảo mật. Dùng hai đơn minh họa mới nếu cần trình bày cả hủy và hoàn tất; đơn đã hủy không mở lại. Không thao tác đối soát trên đơn đang có sẵn của người khác.

SQL lấy số liệu sau quay:

```sql
SELECT
 (SELECT COUNT(*) FROM categories) AS so_danh_muc,
 (SELECT COUNT(*) FROM products) AS so_san_pham,
 (SELECT COUNT(*) FROM users) AS so_tai_khoan,
 (SELECT COUNT(*) FROM users WHERE role='admin') AS so_admin,
 (SELECT COUNT(*) FROM orders) AS so_don_hang,
 (SELECT COUNT(*) FROM orders WHERE status='pending') AS cho_xu_ly,
 (SELECT COUNT(*) FROM orders WHERE status='shipping') AS dang_giao,
 (SELECT COUNT(*) FROM orders WHERE status='completed') AS hoan_tat,
 (SELECT COUNT(*) FROM orders WHERE status='cancelled') AS da_huy;
```

Phạm vi này là kiểm tra chức năng đồ án và các tình huống lỗi cụ thể, không phải đánh giá bảo mật production hoặc thử tải lớn. Điểm chấm phụ thuộc minh chứng, trình bày và quyết định của giảng viên.
