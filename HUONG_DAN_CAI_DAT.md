# Cài đặt Cửa hàng Công Nghệ Thịnh Nguyễn từ GitHub

Tác giả: **Nguyễn Ngô Quốc Thịnh — N25DTCN057 — D25TXCN01-N**.

Mục tiêu: tải đầy đủ source, database và ảnh để chạy tại **http://localhost/thinh-tech/** giống bản localhost của tác giả ở thời điểm xuất dữ liệu. Tên thư mục đúng là `thinh-tech` (có chữ **h**), database là `thinh_tech` (dấu gạch dưới).

## 1. Môi trường

- Windows và XAMPP PHP **8.2 trở lên**, Apache 2.4, MariaDB 10.4 trở lên (khuyến nghị cùng bản XAMPP PHP 8.2/MariaDB 10.4 để tương thích SQL).
- PHP có `pdo_mysql`, `mbstring`, `fileinfo`, `zlib`, bật upload và session; có trong bộ XAMPP phù hợp. Giới hạn upload tối thiểu 2 MB, `post_max_size` lớn hơn giới hạn upload.
- MySQL/MariaDB dùng cổng **3307**. Apache dùng cổng **80** để giữ nguyên URL trong hướng dẫn.
- Trình duyệt hiện đại. Git chỉ cần nếu clone; tải ZIP không cần Git hoặc SSH.
- Source dùng PHP thuần; không cần `npm install`, `composer install` hay công cụ biên dịch. Thư viện tạo QR và toàn bộ ảnh đã nằm trong repository.

## 2. Tải source — chọn một cách

### Cách A: clone bằng SSH

Máy tải phải có Git và SSH key đã thêm vào tài khoản GitHub có quyền đọc repository. Nếu thư mục đích chưa tồn tại, chạy PowerShell:

```powershell
git clone git@github.com:lap-tring-web/cua_hang_cong_nghe_TN.git C:\xampp\htdocs\thinh-tech
```

Nếu không dùng SSH nhưng có quyền đọc repository, có thể clone HTTPS:

```powershell
git clone https://github.com/lap-tring-web/cua_hang_cong_nghe_TN.git C:\xampp\htdocs\thinh-tech
```

### Cách B: tải ZIP

1. Mở https://github.com/lap-tring-web/cua_hang_cong_nghe_TN .
2. Chọn **Code → Download ZIP**, giải nén.
3. Đổi tên thư mục chứa `index.php` từ `cua_hang_cong_nghe_TN-main` thành **`thinh-tech`**.
4. Chép thư mục đó vào `C:\xampp\htdocs\`.

Kết quả phải là:

```text
C:\xampp\htdocs\thinh-tech\
├── index.php
├── .htaccess
├── README.md
├── HUONG_DAN_CAI_DAT.md
├── admin\
├── config\
├── includes\
├── assets\
├── css\
├── js\
├── images\products\
├── uploads\avatars\
└── database\thinh_tech_export.sql
```

Không để thành `htdocs\thinh-tech\cua_hang_cong_nghe_TN-main\index.php`. Giữ các file `.htaccess`, ảnh chân dung, ảnh sản phẩm và ảnh upload. Máy mới không cần tạo liên kết junction như máy tác giả.

## 3. Đặt cổng MySQL là 3307

1. Dừng MySQL trong XAMPP Control Panel trước khi sửa.
2. Chọn **MySQL → Config → my.ini** (thường ở `C:\xampp\mysql\bin\my.ini`).
3. Đặt `port=3307` trong cả hai nhóm `[client]` và `[mysqld]`. Giữ các thiết lập còn lại.
4. Nếu XAMPP Control Panel có **Config → Service and Port Settings → MySQL**, đặt Main Port thành `3307` để panel theo dõi đúng.
5. Trong `C:\xampp\phpMyAdmin\config.inc.php`, tìm cấu hình server đang dùng và đặt:

```php
$cfg['Servers'][$i]['host'] = '127.0.0.1';
$cfg['Servers'][$i]['port'] = '3307';
$cfg['Servers'][$i]['connect_type'] = 'tcp';
```

6. Bật **Apache + MySQL**. Cổng 3307 phải chưa bị một MySQL khác chiếm.

Các thiết lập XAMPP/phpMyAdmin thuộc từng máy, không tự thay đổi khi clone Git.

## 4. Tạo database và import dữ liệu giống bản tác giả

1. Mở **http://localhost/phpmyadmin/**.
2. Tạo database **`thinh_tech`**, bảng mã **`utf8mb4_unicode_ci`**.
3. Chọn database đó → **Import/Nhập** → chọn:

   ```text
   C:\xampp\htdocs\thinh-tech\database\thinh_tech_export.sql
   ```

4. Giữ định dạng SQL và mã hóa UTF-8, nhấn thực hiện. Sau khi thành công có 6 bảng: `categories`, `products`, `users`, `orders`, `order_items`, `contacts`.

**Chỉ import `thinh_tech_export.sql` cho lần cài này.** Đây là bản dữ liệu xuất từ localhost, gồm sản phẩm, tài khoản, đơn hàng và liên hệ ở thời điểm chuẩn bị source. `thinh_tech.sql` là dữ liệu khởi tạo khác; không import thêm nó. Các migration trong `database/migrations` dành cho bản cũ; **không chạy lại migration sau khi import bản export**.

Chỉ import vào database mới, trống. File export có lệnh thay thế bảng; với máy đang có dữ liệu, phải sao lưu trước và không import đè để cập nhật source.

GitHub không chạy hoặc đồng bộ MySQL. Đơn mới phát sinh trên máy tác giả sau khi xuất SQL sẽ không tự xuất hiện trên máy tải source.

## 5. Kiểm tra kết nối website

File `config/config.php` đã có cấu hình local mặc định:

| Thiết lập | Giá trị |
|---|---|
| Host | `localhost` |
| Port | `3307` |
| Database | `thinh_tech` |
| User | `root` |
| Password | rỗng với XAMPP mặc định |

Nếu MySQL trên máy bạn có mật khẩu hoặc tài khoản riêng, sửa giá trị mặc định `DB_USER`/`DB_PASS` trong file này cho đúng. Cũng có thể cấu hình biến môi trường `MINISHOP_DB_HOST`, `MINISHOP_DB_PORT`, `MINISHOP_DB_NAME`, `MINISHOP_DB_USER`, `MINISHOP_DB_PASS`; biến môi trường có ưu tiên hơn cấu hình mặc định. Dự án **không tự đọc file `.env`**.

`BASE_URL` được nhận diện tự động; với thư mục `thinh-tech` không cần sửa đường dẫn. Không đặt `MINISHOP_BASE_URL` của một máy khác trên máy mới.

Apache cần bật `mod_rewrite` và `AllowOverride All` cho `htdocs` để nhận `.htaccess`, trang 404 và các quy tắc bảo vệ. XAMPP thông thường đã có; nếu sửa cấu hình, khởi động lại Apache. Giữ thư mục `uploads` và `uploads/avatars` có quyền ghi cho Apache.

## 6. Chạy và đăng nhập

- Website: **http://localhost/thinh-tech/**.
- Đăng nhập: **http://localhost/thinh-tech/login.php**.
- Quản trị: **http://localhost/thinh-tech/admin/** (cần đăng nhập admin).
- Quản lý database: **http://localhost/phpmyadmin/**.

| Vai trò | Email | Mật khẩu demo |
|---|---|---|
| Admin | `nguyenngothinh669@gmail.com` | `ThinhTech@2026` |
| Khách 1 | `khachhang1@thinhtech.local` | `ThinhTech@2026` |
| Khách 2 | `khachhang2@thinhtech.local` | `ThinhTech@2026` |

Đây là tài khoản website đồ án, không phải mật khẩu hộp thư. Nếu tác giả thay mật khẩu sau ngày bàn giao thì dùng mật khẩu tương ứng bản SQL mới.

Sau cài đặt, kiểm tra:

1. Trang chủ có logo chân dung, tên cửa hàng và ảnh sản phẩm thật.
2. Có 15 sản phẩm, 4 danh mục ở bản bàn giao này; số liệu chính xác của tài khoản/đơn hàng theo bản SQL được xuất.
3. Đăng nhập khách, bấm avatar mở **Tài khoản của tôi** và **Đơn hàng của tôi**.
4. Thêm sản phẩm vào giỏ: giữ nguyên trang, thông báo ở góc phải trên khoảng 2 giây.
5. Đăng nhập admin, mở trang tổng quan và quản lý sản phẩm/danh mục/đơn hàng.
6. Khi thử mua, chọn COD hoặc chuyển khoản. QR dùng tài khoản chủ cửa hàng; quay demo không cần chuyển tiền thật. Nút báo đã chuyển khoản không tự xác nhận tiền về.

Mỗi máy có session/giỏ hàng riêng; cookie đăng nhập và giỏ của máy tác giả không nằm trong source. Dữ liệu database và ảnh được phục hồi theo bản export; những thao tác mới sau đó độc lập trên từng máy.

## 7. Lỗi thường gặp

| Hiện tượng | Cách xử lý |
|---|---|
| Không mở được localhost | Bật Apache; kiểm tra phần mềm đang chiếm cổng 80. Nếu dùng cổng Apache khác, URL cũng phải thêm cổng đó. |
| 404 ngay trang chủ | Kiểm tra `C:\xampp\htdocs\thinh-tech\index.php` có thật; dùng đúng tên `thinh-tech`, tránh lồng thư mục sau giải nén. |
| “Hệ thống đang bận” | Kiểm tra MySQL đang chạy cổng 3307, database đã import, user/password đúng; xem `C:\xampp\apache\logs\error.log` để biết lỗi thực tế. |
| phpMyAdmin kết nối nhầm database/cổng | Kiểm tra host `127.0.0.1`, port `3307` trong cấu hình phpMyAdmin; website và phpMyAdmin có cấu hình kết nối riêng. |
| Thiếu bảng/cột hoặc migration báo trùng | Cài mới bằng một file `thinh_tech_export.sql` trong database trống; không trộn SQL khởi tạo/migration. |
| Ảnh thiếu | Kiểm tra đã tải đủ `assets`, `images` và `uploads`, không chỉ các file PHP. |
| Avatar không lưu | Kiểm tra thư mục `uploads/avatars` có quyền ghi, upload được bật và file JPG/PNG/WebP không quá 2 MB. |
| Lỗi HTTP 500 ngay cả trang công khai | Kiểm tra Apache nạp PHP và cho phép `.htaccess`; đọc Apache error log, kiểm tra `mod_rewrite`. |
| Trình duyệt còn giao diện cũ | Nhấn **Ctrl + F5** để tải lại CSS và ảnh. |
| SSH báo Permission denied (publickey) | Thêm SSH public key vào đúng tài khoản GitHub hoặc dùng HTTPS/Download ZIP; repository private cần được cấp quyền. |

## 8. Cập nhật và phạm vi bàn giao

- Source có đầy đủ mã PHP, CSS, JavaScript, thư viện QR, ảnh cục bộ và SQL. Các file thử nghiệm, session `.runtime`, ZIP đóng gói và bộ công cụ cá nhân ở thư mục cha không cần để chạy website nên không nằm trong repository này.
- `.gitattributes` giữ nguyên byte file khi clone để source/ảnh không bị đổi kiểu xuống dòng theo máy.
- Khi tác giả cập nhật dữ liệu: xuất lại `thinh_tech_export.sql` rồi commit/push. Người cài mới dùng bản export đó. Với máy đã sử dụng, `git pull` chỉ cập nhật file; không tự thay đổi database và không nên import đè dữ liệu đang dùng.
- Hosting để triển khai sau. GitHub Pages không chạy được PHP/MySQL; repository này chia sẻ source để chạy bằng XAMPP hoặc hosting PHP phù hợp.
- Báo cáo cuối, video và ảnh xác nhận nộp bài là hồ sơ riêng, không phải điều kiện để ứng dụng chạy.
