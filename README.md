# Cửa hàng Công Nghệ Thịnh Nguyễn

Đồ án cá nhân của Nguyễn Ngô Quốc Thịnh · N25DTCN057 · D25TXCN01-N.
PHP thuần 8.2+, PDO MySQL, HTML/CSS/JavaScript; không dùng framework.

## Tải từ GitHub và chạy trên máy mới

**Bắt đầu tại [HUONG_DAN_CAI_DAT.md](HUONG_DAN_CAI_DAT.md)**: hướng dẫn clone/tải ZIP, cấu hình XAMPP và phpMyAdmin cổng **3307**, import SQL, đăng nhập và xử lý lỗi.

```powershell
git clone git@github.com:lap-tring-web/cua_hang_cong_nghe_TN.git C:\xampp\htdocs\thinh-tech
```

Repository chứa trực tiếp mã ứng dụng ở thư mục gốc (có `index.php`), kèm ảnh cục bộ, uploads và `database/thinh_tech_export.sql`. Sau khi cài theo hướng dẫn, mở **http://localhost/thinh-tech/**. Không cần npm, Composer hoặc tải ảnh từ website khác. Nếu tải ZIP, đổi tên thư mục giải nén thành `thinh-tech` rồi đặt trong `htdocs`.

Thông tin “máy hiện tại” bên dưới chỉ mô tả máy của tác giả; **máy mới bắt buộc tạo database và import bản SQL xuất**, không có sẵn dữ liệu chỉ nhờ tải source.

## Chạy ngay trên máy hiện tại

1. Mở XAMPP Control Panel, bật **Apache** và **MySQL**. MySQL dùng cổng **3307**.
2. Mở website: http://localhost/thinh-tech/ .
3. Mở quản lý CSDL: http://localhost/phpmyadmin/ , chọn database `thinh_tech`.
4. Database đã có đủ dữ liệu; không cần import lại trên máy hiện tại.

Máy hiện tại đã có liên kết thư mục `C:\xampp\htdocs\thinh-tech` trỏ tới mã nguồn trong `D:\Subject-riki-hk2\lms_laptrinhweb\minishop_Thinh\thinh-tech`. Chỉnh sửa trong dự án sẽ có hiệu lực ngay trên localhost; không cần chép qua lại. Liên kết chỉ dành cho máy hiện tại; khi chuyển máy, làm theo mục cài mới bên dưới.

Website và phpMyAdmin dùng hai đường dẫn riêng. phpMyAdmin quản lý 6 bảng CSDL, không phải trang bán hàng. Cấu hình phpMyAdmin trên máy hiện tại cũng dùng `127.0.0.1:3307`.

Tùy chọn chạy nhanh khi không dùng Apache: chạy `powershell -ExecutionPolicy Bypass -File .\start-local.ps1`, mở http://127.0.0.1:8088/ . Script dùng PHP của C:\xampp, tạo .runtime cho session và upload tạm. Giữ cửa sổ PowerShell chạy; Ctrl+C để dừng. Cách này không cung cấp phpMyAdmin.

## Cài mới trên XAMPP Apache

1. Chép thư mục thinh-tech vào C:\xampp\htdocs\thinh-tech.
2. Tạo database trống `thinh_tech` (utf8mb4) và import `database/thinh_tech_export.sql` bằng phpMyAdmin để có dữ liệu của bản đóng gói hiện tại. SQL chỉ dùng cho database mới; không import vào database đang có bảng. `database/thinh_tech.sql` là bộ dữ liệu khởi tạo ban đầu; chỉ chọn một trong hai tệp để import.
3. Cấu hình config/config.php: host localhost, port 3307, database thinh_tech, user root, password mặc định rỗng.
4. Bật Apache + MySQL, mở http://localhost/thinh-tech/.
5. Apache cần bật mod_rewrite và AllowOverride All. Trang 404 dùng quy tắc tương đối, hoạt động ở thư mục con hoặc gốc domain.

## Tài khoản minh họa

Mật khẩu chung: `ThinhTech@2026`.

- Admin: nguyenngothinh669@gmail.com
- Khách 1: khachhang1@thinhtech.local
- Khách 2: khachhang2@thinhtech.local

Đây là tài khoản của website đồ án, không phải mật khẩu email. Đổi mật khẩu trước khi công khai hosting.

## Dữ liệu

4 danh mục, 15 sản phẩm thực tế có ảnh WebP từ nguồn hãng và GEARVN, tên/mô tả/thông số đối chiếu đúng mẫu. Xem `PRODUCT_SOURCES.md` và `database/real-products.json` để tra nguồn từng ảnh. Bộ khởi tạo có 3 tài khoản và 5 đơn; bản xuất gồm cả tài khoản, avatar và đơn phát sinh từ thao tác trên localhost. Số liệu chính xác tại thời điểm đóng gói nằm trong `deliverables/release-manifest.json` ở thư mục cha. Giá và tồn kho là dữ liệu demo cho đồ án, không phải báo giá hiện hành của hãng. Ảnh và thông số đã được đối chiếu theo sản phẩm thực tế; ảnh lưu cục bộ ở `images/products`. Trang chủ và Giới thiệu dùng ảnh thực tế Logitech/Keychron, WebP cục bộ trong assets/photos; 6 ảnh JPG demo chỉ giữ làm tham khảo.

## Chức năng

- Giao diện sáng tham khảo cách trình bày ASUS, dùng ảnh chân dung sinh viên làm logo cửa hàng; đăng nhập hai cột, đăng ký đồng bộ, hiện/ẩn mật khẩu và menu mobile. Màu và nguyên tắc bố cục ở `DESIGN.md`.
- Lọc, tìm kiếm, sắp xếp, phân trang 8 sản phẩm; chi tiết có thông số và 3 sản phẩm liên quan.
- Đăng ký, đăng nhập, đăng xuất, hồ sơ, đổi mật khẩu; khóa theo session 5 phút sau 5 lần sai liên tiếp. Khách sửa họ tên/số điện thoại/địa chỉ và tải, thay hoặc xóa ảnh đại diện. Avatar góc trên theo tài khoản đang đăng nhập; bấm để mở hồ sơ, đơn hàng, đăng xuất và quản trị (nếu có quyền).
- Giỏ hàng session; nhấn Thêm vào giỏ ở danh sách/chi tiết sản phẩm sẽ hiện thông báo ở góc trên bên phải màn hình, tự ẩn sau 2 giây và cập nhật số lượng giỏ, giữ nguyên trang đang xem. Bộ đếm tạm dừng khi rê chuột hoặc focus trong thông báo. Chỉ chuyển sang giỏ khi khách bấm biểu tượng giỏ hoặc Xem giỏ hàng. Khi tắt JavaScript, form quay lại danh sách/chi tiết và hiện thông báo. Đặt hàng có transaction và khóa dòng sản phẩm.
- Thanh toán khi nhận hàng (COD) hoặc chuyển khoản BIDV. QR được tạo ngay trong website, chứa số tiền và nội dung riêng của đơn. Khách thông báo chuyển khoản; admin đối soát và xác nhận tiền về. Hướng dẫn ở `PAYMENTS.md`.
- Khách hủy đơn chờ xử lý; admin hủy đơn chờ/đang giao; hoàn kho trong transaction và chỉ một lần.
- Admin quản lý sản phẩm/ảnh, danh mục, đơn hàng, liên hệ; dashboard thống kê.
- CSRF mọi POST, e() chống XSS, prepared statements, phân quyền, chặn thư mục nội bộ và PHP trong uploads.

## Cập nhật website đã cài trước phần thanh toán

Máy hiện tại đã cập nhật CSDL. Với bản cũ trên máy khác: sao lưu CSDL, chạy **một lần** `database/migrations/20261103_payments.sql` trong tab SQL của phpMyAdmin, rồi dùng mã nguồn mới. Không chạy migration sau khi import SQL mới vì các cột thanh toán đã có sẵn. Đơn cũ giữ phương thức COD; đơn hoàn tất được ghi nhận đã thu tiền. Không cần thêm bảng CSDL.

## Hồ sơ và ảnh đại diện

Đăng nhập → **bấm avatar ở góc trên bên phải → Tài khoản của tôi** → cập nhật họ tên, số điện thoại, địa chỉ. Chọn ảnh đại diện để xem trước, sau đó nhấn **Lưu thay đổi**. Có thể bỏ ảnh vừa chọn hoặc đánh dấu **Xóa ảnh đại diện hiện tại** rồi lưu. Email đăng nhập giữ cố định; đổi mật khẩu qua liên kết riêng. Thông tin nhận hàng mới được điền sẵn ở checkout; đơn đã đặt giữ thông tin lịch sử.

Ảnh hỗ trợ JPG, PNG, WebP, tối đa 2 MB, mỗi chiều tối đa 4096 pixel. Khi chưa có ảnh, website hiển thị chữ viết tắt của tên. Chưa đăng nhập hiện biểu tượng tài khoản dẫn đến đăng nhập. Logo cửa hàng ở bên trái là ảnh chân dung sinh viên cố định theo đề thi; avatar tài khoản ở bên phải theo người đăng nhập. Nút Tài khoản ở hàng điều hướng được bỏ. Menu avatar dùng được trên điện thoại, bằng bàn phím và khi tắt JavaScript.

Máy hiện tại đã có cột `users.avatar`. Nếu cập nhật từ bản cũ trên máy khác, sao lưu CSDL rồi chạy **một lần** `database/migrations/20261103_user_avatars.sql`. SQL cài mới và bản xuất đã có cột này; không chạy migration lại. Bảo đảm thư mục `uploads/avatars` có quyền ghi và giữ nguyên `.htaccess`. Tên ảnh do máy chủ tạo ngẫu nhiên; thay/xóa ảnh chỉ dọn tệp avatar cũ sau khi cập nhật CSDL thành công.

## Cấu hình hosting

Theo yêu cầu ngày 03/11/2026, hosting để cập nhật sau; phần E hiện chưa triển khai. Các bước dưới đây dành cho lần cập nhật đó.

Có thể dùng biến môi trường MINISHOP_DB_HOST, MINISHOP_DB_PORT, MINISHOP_DB_NAME, MINISHOP_DB_USER, MINISHOP_DB_PASS, MINISHOP_BASE_URL. Cổng 3307 là cấu hình local; hosting cần dùng cổng nhà cung cấp cấp. APP_DEBUG mặc định false. MINISHOP_DEBUG=1 chỉ để debug local.

Chọn hosting PHP 8.2 + MySQL/MariaDB có panel và HTTPS; upload nội dung thinh-tech; tạo/import CSDL; cập nhật thông số; cấp quyền ghi uploads; kiểm tra /config/config.php và /database/ trả 403; kiểm tra CSRF và tải ảnh. Bật mod_rewrite và AllowOverride All để dùng trang 404 riêng. Duy trì website đến khi chấm.

Không đưa .runtime hoặc start-local.ps1 lên hosting. Báo cáo và video cần ghi URL hosting thật sau khi triển khai.

## Hồ sơ đã chuẩn bị

Thư mục `deliverables` ở thư mục cha chứa báo cáo PDF nháp, ZIP mã nguồn, tệp SQL xuất riêng và ảnh chân dung. ZIP chứa thư mục `thinh-tech`, có đầy đủ `.htaccess` và ảnh sản phẩm; không có `.runtime`.

Kịch bản quay mới FINAL01 nằm trong `VIDEO_SCRIPT.md` (cập nhật 05/11/2026, dự kiến 9:35). Bảng nhắc và dữ liệu/ảnh để chọn nhanh ở `deliverables/QUAY_VIDEO_FINAL01/` trong thư mục cha. Không cần xóa dữ liệu đã test; dùng email mới và hai đơn mới cho lượt quay. Báo cáo chưa phải bản nộp cuối vì còn ảnh minh chứng có thanh địa chỉ, ảnh CSDL, ảnh sau hủy đơn và URL video. PDF nháp dùng giao diện cũ; cần thay ảnh sau cập nhật ASUS. Ảnh giao diện mới ở `deliverables/preview` trong thư mục cha. Không cần chờ hosting để chạy và rà soát A–D trên local.

## Cập nhật danh mục ảnh thật

Máy hiện tại đã cập nhật đủ 15 sản phẩm. Với bản TN cũ, sao lưu CSDL, chép thư mục `images/products` rồi chạy `database/migrations/20261103_real_products.sql` trong phpMyAdmin. Migration chỉ đổi tên, mô tả, thông số và đường dẫn ảnh của đúng sản phẩm mẫu, không đổi giá/tồn kho/ID hay lịch sử đơn hàng. SQL khởi tạo và bản export mới đã có danh mục mới. Bộ tải ảnh/đối chiếu dành cho phát triển ở `tools/import-real-products.py` trong thư mục cha.


Cập nhật nhận diện 05/11/2026: theo xác nhận mới nhất của sinh viên sau khi hỏi lại giảng viên, logo cửa hàng phải là ảnh chân dung Nguyễn Ngô Quốc Thịnh. Header và footer mọi trang, gồm quản trị, dùng assets/anh_chan_dung.jpg; tên cửa hàng luôn hiển thị cả trên điện thoại. Avatar tài khoản vẫn thay đổi theo người đăng nhập. Video và ảnh minh chứng cần dùng giao diện mới này; nội dung chốt logo TN ngày 04/11 đã được thay thế.
