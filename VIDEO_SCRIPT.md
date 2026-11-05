# KỊCH BẢN THUYẾT TRÌNH VÀ QUAY VIDEO ĐỒ ÁN

**Chuẩn đối chiếu đã chốt ngày 05/11/2026:** theo xác nhận của sinh viên, chỉ áp dụng đề PDF ban đầu: tối thiểu **12 sản phẩm, 3 danh mục**, video **5–10 phút**. Không áp dụng yêu cầu nội dung trong ảnh LMS vừa gửi. Hiện có 15 sản phẩm và 4 danh mục, đã đạt ngưỡng dữ liệu này. Logo cửa hàng dùng ảnh chân dung theo xác nhận mới nhất ngày 05/11/2026; avatar tài khoản theo người đăng nhập.

**Đề tài:** Cửa hàng Công Nghệ Thịnh Nguyễn  
**Sinh viên:** Nguyễn Ngô Quốc Thịnh · N25DTCN057 · D25TXCN01-N  
**Bản soạn:** 04/11/2026  
**Thời lượng mục tiêu:** 9 phút 10 giây; tập thử để giữ tổng thời lượng từ 5 đến 10 phút.

Phần trong khối trích dẫn là lời để nói. Phần **Thao tác** là hướng dẫn, không đọc vào video. Nói tự nhiên, vừa thao tác vừa giải thích; không cần đọc thuộc từng chữ. Mốc thời gian là phân bổ dự kiến, chưa phải thời lượng đã đo khi sinh viên thuyết trình.

## 1. Chuẩn bị trước khi quay

1. Bật Apache và MySQL trong XAMPP; MySQL dùng cổng **3307**. Mở website `http://localhost/thinh-tech/` và phpMyAdmin `http://localhost/phpmyadmin/`.
2. Quay toàn màn hình 1920 × 1080 nếu máy hỗ trợ; giữ thanh địa chỉ, chữ rõ, zoom trình duyệt khoảng 100%. Tắt thông báo cá nhân và thử mic 10 giây. Đề không yêu cầu ghi hình khuôn mặt, nhưng yêu cầu giọng thuyết minh của chính sinh viên.
3. Dùng hai phiên trình duyệt tách biệt, chẳng hạn cửa sổ thường cho khách và cửa sổ ẩn danh cho admin. Hai tab trong cùng một phiên sẽ dùng chung trạng thái đăng nhập.
4. Mở sẵn các tab mã nguồn: `config/config.php`, `includes/init.php`, `checkout.php`, `order-cancel.php`, `includes/functions.php`. Trong phpMyAdmin mở database `thinh_tech`.
5. Chuẩn bị email mới để đăng ký tài khoản quay, chẳng hạn `thinh.baocao0411@example.com`; nếu đã dùng thì đổi địa chỉ khác. Chuẩn bị thông tin nhận hàng hợp lệ, ảnh avatar và ảnh sản phẩm JPG/PNG/WebP dưới 2 MB. Có thể dùng ảnh có sẵn trong `images/products/` để minh họa upload.
6. Tài khoản website admin: **nguyenngothinh669@gmail.com**. Tài khoản khách có sẵn: **khachhang1@thinhtech.local**. Mật khẩu minh họa của hai tài khoản này: **ThinhTech@2026**. Đây là mật khẩu website đồ án; không nói hoặc nhập mật khẩu email cá nhân. Tài khoản mới đăng ký dùng mật khẩu bạn vừa đặt.
7. Trước buổi quay, đăng nhập khách có sẵn, tạo **một đơn COD minh họa mới**, còn Chờ xử lý, ghi chú “Đơn minh họa quay báo cáo”, rồi ghi lại mã. Đơn này dùng cho admin chuyển Đang giao → Hoàn tất ở phần 7. Không lấy một đơn có sẵn của khách khác để sửa trạng thái.
8. Trong video sẽ tạo **một đơn chuyển khoản khác** bằng tài khoản mới, rồi hủy ở vai trò khách. Hai đơn phục vụ hai tình huống khác nhau; đơn đã hủy không mở lại để giao hàng.
9. Chuẩn bị nội dung nhập dài trong một tệp nháp để dán nhanh: mô tả sản phẩm, thông số, thông tin liên hệ. Khi tập, nếu chậm, ưu tiên luồng chính và bỏ các đoạn tùy chọn ở phần 12.

**Cấu hình nhận diện cập nhật (05/11/2026):** sinh viên xác nhận sau khi hỏi lại giảng viên: logo cửa hàng phải là ảnh chân dung của mình trên mọi trang, kể cả quản trị. Khi quay, chỉ ảnh chân dung cạnh tên cửa hàng và nói: “Em sử dụng ảnh chân dung của mình làm logo cửa hàng theo yêu cầu cá nhân hóa của đề thi.” Avatar tài khoản bên phải vẫn theo người đăng nhập. Ảnh minh chứng phải chụp lại theo giao diện này.

## 2. 00:00–00:30 | Mở đầu: đề tài và công nghệ

**Màn hình:** Trang chủ, thấy tên cửa hàng; cuộn nhẹ để giới thiệu giao diện, chưa thao tác mua hàng.

**Lời thuyết minh:**

> Em kính chào thầy. Em là Nguyễn Ngô Quốc Thịnh, mã số sinh viên N25DTCN057, lớp D25TXCN01-N.
>
> Sau đây em xin trình bày đồ án website Cửa hàng Công Nghệ Thịnh Nguyễn, với chủ đề thiết bị và phụ kiện công nghệ. Dự án sử dụng HTML, CSS, JavaScript, PHP thuần và MySQL/MariaDB, không dùng framework. Em sẽ trình bày luồng khách hàng, quản trị, cơ sở dữ liệu và một số xử lý bảo mật.

**Đối chiếu:** Thông tin sinh viên, chủ đề, công nghệ, mục video của đề.

## 3. 00:30–01:20 | Giao diện và khám phá sản phẩm

**Thao tác theo thứ tự:**

1. Cuộn qua banner và vùng sản phẩm; chỉ tên cửa hàng, điều hướng, footer có MSSV/họ tên.
2. Tìm **Logitech**, chọn sắp xếp giá tăng hoặc giảm và nhấn nút **Sắp xếp**.
3. Xóa từ khóa, lọc **Chuột và bàn phím**. Sau đó mở lại danh sách tất cả, sang trang 2.
4. Mở một sản phẩm, chỉ ảnh, giá, mô tả, bảng thông số và các sản phẩm cùng danh mục.
5. Nếu thao tác nhanh, dùng chế độ responsive để đổi độ rộng về khoảng 390px, rồi trả về desktop. Không dành lâu cho DevTools.

**Lời thuyết minh:**

> Giao diện sử dụng tông trắng và xanh, hướng đến trải nghiệm đơn giản, rõ ràng cho cửa hàng công nghệ. Khách có thể tìm sản phẩm theo tên, lọc theo danh mục và sắp xếp theo giá.
>
> Danh sách được chia tám sản phẩm mỗi trang. Trang chi tiết có hình ảnh thực tế, thông số và tối đa ba sản phẩm liên quan cùng danh mục. Bố cục thích ứng theo kích thước màn hình để sử dụng trên cả máy tính và điện thoại.

**Lưu ý khi quay:** Danh mục hiện tại chỉ có tối đa bốn sản phẩm nên không có trang 2 khi lọc riêng. Muốn minh họa phân trang, trở về danh sách tất cả. Không tìm “TN” vì tên sản phẩm đã đổi sang mẫu thật. Không nói giá demo là giá bán chính thức của hãng.

**Đối chiếu:** A1–A6, B4–B7, D8.

## 4. 01:20–02:00 | Đăng ký và đăng nhập

**Thao tác:**

1. Mở Đăng ký, nhập họ tên, điện thoại, email mới, mật khẩu và xác nhận, tích điều khoản.
2. Nếu còn thời gian, nhập hai mật khẩu khác nhau để hiện lỗi, rồi sửa cho đúng.
3. Đăng ký thành công, đăng nhập bằng tài khoản vừa tạo. Chỉ menu avatar đã thay đổi theo tài khoản.

**Lời thuyết minh:**

> Tiếp theo, em tạo một tài khoản khách hàng. Biểu mẫu kiểm tra các trường bắt buộc, định dạng số điện thoại và hai mật khẩu phải trùng nhau. Máy chủ tiếp tục kiểm tra dữ liệu và ngăn email đăng ký trùng.
>
> Sau khi đăng nhập, hệ thống sử dụng session để ghi nhận tài khoản. Khách bấm avatar ở góc trên để mở hồ sơ, xem đơn hàng hoặc đăng xuất.

**Đối chiếu:** A3, A7, C1–C2.

## 5. 02:00–02:40 | Giỏ hàng và cập nhật số lượng

**Thao tác:**

1. Mở sản phẩm còn hàng, nhấn **Thêm vào giỏ**; dừng khoảng hai giây để thấy thông báo tự ẩn, trang không bị chuyển.
2. Thêm một sản phẩm khác, chủ động mở biểu tượng giỏ hàng.
3. Đổi số lượng một dòng từ 1 thành 2, chỉ tổng tiền thay đổi ngay, nhấn **Cập nhật giỏ hàng**.
4. Nhấn xóa một dòng, chọn **Quay lại** trong hộp xác nhận để giữ giỏ và tiếp tục đặt hàng.

**Lời thuyết minh:**

> Khi thêm sản phẩm, thông báo xuất hiện ở góc trên bên phải khoảng hai giây; khách tiếp tục xem hàng ngay tại trang hiện tại.
>
> Trong giỏ, JavaScript tính lại thành tiền khi đổi số lượng. Em nhấn Cập nhật giỏ hàng để lưu thay đổi. Thao tác xóa có bước xác nhận để tránh xóa nhầm. Giá dùng khi xử lý đơn luôn được đọc lại từ cơ sở dữ liệu.

**Đối chiếu:** A8, C3; bổ sung thông báo theo yêu cầu chủ dự án.

## 6. 02:40–03:35 | Đặt hàng, QR, lịch sử và hủy đơn

**Thao tác:**

1. Nhấn **Đặt hàng**, nhập người nhận, điện thoại và địa chỉ hợp lệ. Ghi chú: “Đơn chuyển khoản minh họa trong video”.
2. Chỉ hai lựa chọn COD/chuyển khoản; chọn **Chuyển khoản ngân hàng** → **Xác nhận đặt hàng**.
3. Ở chi tiết đơn, chỉ mã đơn, tổng tiền, tài khoản BIDV, QR và nội dung chuyển khoản. Có thể nhấn một nút sao chép.
4. Mở **Đơn hàng của tôi** qua avatar, xem lại đơn vừa tạo; mở chi tiết, nhấn **Hủy đơn hàng** và xác nhận. Chỉ trạng thái Đã hủy.
5. Không nhấn thông báo đã chuyển khoản nếu chưa chuyển. Không chuyển tiền thật để thực hiện bài quay.

**Lời thuyết minh:**

> Khách có thể thanh toán khi nhận hàng hoặc chuyển khoản ngân hàng. Ở đây em tạo một đơn chuyển khoản minh họa. Sau khi đặt, website hiển thị QR chứa số tiền và nội dung riêng của đơn để thuận tiện đối chiếu.
>
> Website chưa đối soát ngân hàng tự động. Nút “Tôi đã chuyển khoản” chỉ gửi thông báo; quản trị viên phải kiểm tra giao dịch trước khi xác nhận tiền về.
>
> Khách xem lại đơn trong lịch sử và có thể hủy khi đơn còn Chờ xử lý. Em hủy đơn vừa tạo; hệ thống cập nhật trạng thái và hoàn lại tồn kho trong một giao dịch.

**Đối chiếu:** C4–C6; chức năng thanh toán bổ sung. 

## 7. 03:35–04:00 | Hồ sơ và liên hệ

**Thao tác:**

1. Avatar → **Tài khoản của tôi**. Sửa địa chỉ, chọn ảnh đại diện, nhấn **Lưu thay đổi**; chỉ avatar góc trên đã cập nhật.
2. Mở **Liên hệ**, điền và gửi nội dung mẫu dưới đây. Giữ nguyên thẻ HTML trong tin nhắn để kiểm tra ở phần bảo mật.

**Nội dung chuẩn bị để dán:**

- Họ tên: Nguyễn Ngô Quốc Thịnh.
- Email: email của tài khoản quay.
- Tiêu đề: `Tư vấn bàn phím Keychron K8`.
- Nội dung: `Em muốn tìm hiểu kết nối của bàn phím Keychron K8. <script>alert('kiem-tra')</script>`.

**Lời thuyết minh:**

> Trong hồ sơ, khách cập nhật họ tên, điện thoại, địa chỉ và ảnh đại diện. Ảnh được xem trước và chỉ lưu khi xác nhận.
>
> Em gửi một liên hệ có chứa đoạn HTML để kiểm tra cách hiển thị dữ liệu tại khu vực quản trị ở phần sau.

**Lưu ý:** Nếu thao tác chưa quen, dành thêm 10–15 giây cho phần này và rút gọn đoạn giao diện; không cắt mất luồng đặt và hủy đơn.

**Đối chiếu:** C7–C8; avatar bổ sung.

## 8. 04:00–05:50 | Luồng quản trị

### 04:00–04:20 | Đăng nhập và tổng quan

**Thao tác:** Chuyển sang phiên trình duyệt riêng, đăng nhập admin → avatar → **Quản trị cửa hàng**. Chỉ số đơn theo trạng thái, doanh thu và bảng năm sản phẩm tồn thấp nhất.

> Ở vai trò quản trị, hệ thống cung cấp tổng quan đơn hàng theo trạng thái, doanh thu từ các đơn đã hoàn tất và năm sản phẩm có tồn kho thấp nhất. Những thông tin này hỗ trợ theo dõi hoạt động cửa hàng.

### 04:20–05:00 | Thêm, sửa và tải ảnh sản phẩm

**Thao tác:** Mở Sản phẩm, chỉ phân trang → **Thêm sản phẩm**. Dán dữ liệu dưới đây, chọn ảnh và lưu. Mở Sửa, thay giá hoặc một thông số, chọn ảnh mới rồi lưu.

**Dữ liệu nhập mẫu:**

| Trường | Giá trị |
|---|---|
| Tên | Chuột Logitech M330 – bản minh họa quản trị |
| Danh mục | Chuột và bàn phím |
| Giá | 259000 |
| Tồn kho | 5 |
| Mô tả | Bản ghi dùng minh họa thao tác quản trị trong video đồ án. |
| Thông số, dòng 1 | Kết nối: USB receiver 2.4 GHz |
| Thông số, dòng 2 | Nguồn: 1 pin AA |

> Em thêm một bản ghi sản phẩm minh họa, gồm danh mục, giá, tồn kho, mô tả, thông số và hình ảnh. Sau khi lưu, thông tin xuất hiện trong danh sách quản lý.
>
> Quản trị viên có thể sửa và thay ảnh. Khi thay ảnh tải lên thành công, hệ thống dọn ảnh cũ trong uploads. Sản phẩm đã nằm trong đơn hàng được bảo vệ để giữ dữ liệu lịch sử.

**Ghi chú:** Ảnh cũ được dọn là ảnh đã tải vào uploads, không phải ảnh nguồn dùng chung trong images. Dùng hai tệp ảnh dưới 2 MB đã chuẩn bị; không dừng tìm ảnh trên Internet khi quay.

### 05:00–05:20 | Quản lý danh mục

**Thao tác:** Thêm `Phụ kiện minh họa` → đổi tên thành `Phụ kiện quay báo cáo` → xóa và xác nhận. Danh mục này phải để trống, không gán sản phẩm vừa thêm vào đây.

> Danh mục hỗ trợ thêm, đổi tên và xóa. Em thao tác với một danh mục trống. Với danh mục đang có sản phẩm, hệ thống chặn xóa để giữ quan hệ dữ liệu.

### 05:20–05:50 | Quản lý đơn hàng

**Thao tác:** Mở Đơn hàng, lọc Chờ xử lý, chọn **đơn COD minh họa mới đã chuẩn bị trước buổi quay** theo mã đã ghi. Đổi Đang giao → Lưu → Hoàn tất → Lưu. Mở tổng quan để thấy thống kê cập nhật nếu còn thời gian.

> Quản trị viên xem và lọc đơn theo trạng thái. Với đơn COD minh họa đã chuẩn bị, em chuyển từ Chờ xử lý sang Đang giao, rồi Hoàn tất. COD hoàn tất được ghi nhận đã thu tiền.
>
> Với đơn chuyển khoản, hệ thống yêu cầu xác nhận tiền về trước khi giao. Đơn chuyển khoản đã trả tiền mà bị hủy sẽ chuyển sang chờ hoàn tiền để quản trị xử lý.

**Đối chiếu phần quản trị:** D1–D4, D6–D7, D9. Không đọc số lượng thống kê cũ nếu dữ liệu vừa thay đổi.

## 9. 05:50–07:35 | Mã nguồn, CSDL và giao dịch đặt hàng

### 05:50–06:15 | Cấu trúc dự án và môi trường

**Thao tác:** Mở cây thư mục dự án và config/config.php, chỉ DB_PORT; không cần cuộn đọc toàn bộ tệp.

> Mã nguồn được chia thành các trang khách hàng, thư mục admin, config, includes, CSS, JavaScript và tài nguyên ảnh. Header, footer và các hàm dùng chung được tách riêng để giữ giao diện và xử lý thống nhất.
>
> Website chạy trên XAMPP, dùng PDO để kết nối MySQL tại cổng 3307. Tệp init khởi tạo session, nạp cấu hình, kết nối dữ liệu và kiểm tra CSRF cho các yêu cầu POST.

### 06:15–06:45 | Cơ sở dữ liệu trong phpMyAdmin

**Thao tác:** Mở phpMyAdmin → thinh_tech; chỉ sáu bảng. Mở Structure của orders hoặc order_items, chỉ khóa và cột dữ liệu. Có thể dùng Designer nếu đã chuẩn bị sẵn.
  
> Cơ sở dữ liệu gồm sáu bảng: categories lưu danh mục, products lưu sản phẩm, users lưu tài khoản, orders lưu đơn, order_items lưu từng dòng hàng và contacts lưu liên hệ.
>
> Khóa ngoại liên kết sản phẩm với danh mục, đơn với người mua và chi tiết với đơn cùng sản phẩm. Bảng order_items lưu tên và đơn giá tại thời điểm mua, nên lịch sử đơn vẫn giữ đúng khi sản phẩm được cập nhật về sau.

### 06:45–07:35 | Giải thích checkout.php và order-cancel.php

**Thao tác:** Chỉ lần lượt các đoạn `beginTransaction`, `SELECT ... FOR UPDATE`, kiểm tra stock, INSERT orders/order_items, UPDATE stock, `commit`, `rollBack`. Sau đó mở đoạn khóa và kiểm tra đơn trong order-cancel.php.

> Đoạn xử lý em chọn giải thích là đặt hàng. Trước hết, hệ thống bắt đầu giao dịch và khóa các dòng sản phẩm cần mua bằng SELECT FOR UPDATE để đọc lại giá và tồn kho mới nhất.
>
> Nếu đủ hàng, hệ thống tạo đơn, lưu các dòng hàng và trừ kho, sau đó commit. Nếu một bước xảy ra lỗi, rollback đưa dữ liệu trở về trước giao dịch, tránh trường hợp đã trừ kho nhưng chưa có đơn.
>
> Khi hủy, hệ thống khóa đơn, kiểm tra đúng chủ sở hữu và trạng thái Chờ xử lý rồi mới hoàn kho. Vì vậy gửi lại yêu cầu hủy không làm cộng tồn kho thêm lần nữa.

**Đối chiếu:** B1–B3, C4–C6, D5. Phát âm FOR UPDATE là “pho ấp-đây” hoặc nói “khóa dòng để cập nhật”; không cần cố đọc tiếng Anh nếu không quen.

## 10. 07:35–08:50 | Minh họa bảo mật

**Thao tác và lời nói đi cùng:**

**1. Phân quyền, khoảng 15 giây:** Quay lại phiên khách đang đăng nhập, nhập `http://localhost/thinh-tech/admin/index.php`.

> Em dùng tài khoản khách để truy cập trang quản trị. Hệ thống trả mã 403 vì tài khoản không có quyền. Quyền được kiểm tra tại máy chủ, không chỉ dựa vào việc ẩn liên kết trên giao diện.

**2. Hiển thị nội dung liên hệ, khoảng 20 giây:** Chuyển sang phiên admin → Liên hệ, tìm tiêu đề vừa gửi. Chỉ đoạn `<script>...` xuất hiện dạng chữ và không có hộp thoại alert.

> Nội dung liên hệ có chứa thẻ script được hiển thị như văn bản thay vì thực thi. Khi xuất dữ liệu người dùng ra HTML, hệ thống dùng hàm e để mã hóa các ký tự đặc biệt.

**3. Truy cập thư mục nội bộ, khoảng 15 giây:** Mở `http://localhost/thinh-tech/config/config.php`, tiếp theo `/thinh-tech/database/`, chỉ 403.

> Các thư mục cấu hình, mã dùng chung và cơ sở dữ liệu được chặn truy cập trực tiếp bằng cấu hình Apache.

**4. Giải thích ngắn, khoảng 25 giây:** Mở includes/functions.php ở csrf_verify/upload_image hoặc chỉ đoạn đã chuẩn bị.

> Các form POST có token CSRF. Truy vấn nhận tham số người dùng dùng prepared statements; mật khẩu lưu bằng password_hash và được xác minh bằng password_verify.
>
> Ảnh tải lên được giới hạn hai megabyte, kiểm tra nội dung và đặt tên ngẫu nhiên; thư mục uploads chặn thực thi PHP. Form đăng nhập khóa năm phút sau năm lần sai liên tiếp trong cùng phiên.

**Đối chiếu:** B3, C1, C5, D1, D3, D5, D10–D11. Đây là các biện pháp cụ thể đã có, không nói “bảo mật tuyệt đối”. Nếu muốn minh họa đổi id đơn người khác hoặc khóa đăng nhập, dùng phần tùy chọn và bù thời lượng.

## 11. 08:50–09:10 | Kết thúc

**Thao tác:** Quay về trang chủ, dừng ở tên cửa hàng và vùng sản phẩm.

> Qua phần trình bày, em đã minh họa quá trình mua hàng, quản trị cửa hàng, cấu trúc dữ liệu và các xử lý bảo mật chính.
>
> Phiên bản này chạy trên localhost; phần hosting cộng điểm chưa triển khai. Hướng phát triển tiếp theo là đưa website lên hosting có HTTPS và bổ sung đối soát thanh toán tự động. Em xin kết thúc phần báo cáo và cảm ơn thầy đã theo dõi.

Không tuyên bố đã triển khai Internet, tự động nhận tiền hoặc đã được chấm đủ điểm khi chưa có căn cứ.

## 12. Các đoạn tùy chọn khi còn thời gian

Không cộng tất cả vào bản chính. Nếu dùng một đoạn, rút gọn phần khác hoặc quay đoạn bổ sung để tập trả lời vấn đáp; tổng video nộp vẫn phải 5–10 phút.

### Đổi mật khẩu, khoảng 20–30 giây

**Thao tác:** Ở tài khoản mới đăng ký → hồ sơ → Đổi mật khẩu. Nhập sai mật khẩu hiện tại để thấy lỗi, sửa đúng rồi lưu. Ghi lại mật khẩu mới nếu còn đăng nhập lại.

> Việc đổi mật khẩu bắt buộc nhập đúng mật khẩu hiện tại. Nếu sai, hệ thống từ chối; khi đúng, mật khẩu mới được băm trước khi lưu.

### Truy cập đơn của người khác, khoảng 10–15 giây

**Chuẩn bị:** Dùng admin xác định một mã đơn thực sự thuộc khách khác, không dùng mã đơn không tồn tại.

**Thao tác:** Trong phiên khách nhập order-detail.php?id= với mã đó.

> Khi thay mã sang đơn của người khác, hệ thống không cung cấp nội dung và trả 404. Máy chủ kiểm tra quyền sở hữu của đơn.

### Khóa đăng nhập, khoảng 25–40 giây

**Thao tác:** Dùng phiên thứ ba, đăng nhập sai năm lần, chỉ form bị khóa và thông báo năm phút. Không chờ đủ năm phút trong video.

> Sau năm lần đăng nhập sai liên tiếp, form bị khóa năm phút. Bộ đếm hiện được quản lý theo session.

### Xác nhận đã nhận tiền, khoảng 20–30 giây

Chỉ dùng đơn thử được ghi rõ là dữ liệu mô phỏng; không sửa trạng thái thanh toán của đơn thực tế chưa nhận tiền. Nếu cần thực hiện, phải tạo thêm đơn chuyển khoản riêng, chưa hủy.

> Trong bản trình diễn này, em mô phỏng bước quản trị ghi nhận kết quả đối soát trên đơn thử. Ở vận hành thực tế, thao tác chỉ thực hiện sau khi kiểm tra tiền đã vào tài khoản. Nhấn thông báo từ phía khách không tự làm đơn trở thành đã thanh toán.

## 13. Trước khi xuất video và nộp

- Nghe lại tiếng, kiểm tra thao tác và lời nói khớp; giữ khoảng trống để người xem đọc thông báo. Có thể cắt thời gian chờ/nhập liệu, nhưng không dùng cắt ghép làm sai kết quả hoặc thay một thao tác lỗi bằng kết quả không liên quan.
- Thời lượng cuối từ **5 đến 10 phút**, nên chừa khoảng 30 giây dưới giới hạn 10 phút. Bản chính dự kiến 9:10; nếu quá dài, giảm mô tả giao diện hoặc bỏ demo thay avatar, giữ đủ luồng khách/admin/CSDL/bảo mật.
- Lấy lại số liệu sau quay: số tài khoản/đơn thay đổi khi đăng ký và đặt đơn. Số được kiểm tra ngày 03/11/2026 là 4 danh mục, 15 sản phẩm, 4 tài khoản, 12 đơn; **không dùng như số cố định** sau video này vì bạn còn thêm sản phẩm/tài khoản/đơn minh họa.
- Xuất lại SQL và ZIP cùng mã nguồn sau khi chốt dữ liệu. Báo cáo dùng ảnh giao diện mới, số liệu mới và đủ minh chứng theo đề; kịch bản không thay thế báo cáo.
- Tải lên YouTube ở chế độ **Không công khai** hoặc Google Drive **Bất kỳ ai có đường liên kết**. Mở thử ở cửa sổ ẩn danh, kiểm tra video phát được rồi điền liên kết và thời lượng vào báo cáo.
- Nộp đủ cả **LMS và Google Form của giảng viên**, trước **23:00 ngày 07/11/2026** theo đề. Các liên kết, số liệu và phiên bản mã nguồn phải thống nhất.

## 14. Câu hỏi vấn đáp nên chuẩn bị

| Câu hỏi | Ý chính cần giải thích bằng lời của mình |
|---|---|
| Vì sao phải dùng transaction khi đặt hàng? | Lưu đơn, dòng hàng và trừ kho phải cùng thành công; nếu lỗi thì cùng hoàn tác. |
| FOR UPDATE làm gì? | Khóa dòng sản phẩm trong giao dịch để các giao dịch khác không cùng thay đổi tồn kho đó cho đến khi commit/rollback. |
| Vì sao không lấy giá từ giỏ do trình duyệt gửi? | Dữ liệu phía khách có thể bị sửa; giá cần đọc lại ở DB khi xử lý đơn. |
| Vì sao giữ đơn giá trong order_items? | Giữ lịch sử lúc mua dù giá/tên sản phẩm hiện tại thay đổi. |
| e() và prepared statements khác nhau thế nào? | e() xử lý văn bản khi xuất HTML; prepared statements tách tham số khỏi câu SQL. Hai việc bảo vệ hai ngữ cảnh khác nhau. |
| Tại sao POST vẫn cần CSRF? | POST không tự chứng minh thao tác được gửi từ form hợp lệ của phiên; token bổ sung kiểm tra đó. |
| Vì sao dùng password_hash? | Không lưu mật khẩu nguyên văn; dùng password_verify để kiểm tra mật khẩu nhập với bản băm. |
| Vì sao hủy lặp không hoàn kho nhiều lần? | Khóa đơn, kiểm tra pending và chuyển cancelled trong cùng giao dịch; lần sau không còn pending. |
| QR có tự biết tiền đã về không? | Chưa; QR chứa thông tin chuyển khoản, admin phải đối soát; thông báo của khách chỉ là reported. |
| localhost có được tính hosting E không? | Không. E yêu cầu hosting thật, CSDL trên hosting, HTTPS và các điều kiện của đề. |

## 15. Nguồn đối chiếu

Đề thi PDF gốc trong thư mục cha: mục 2 (cá nhân hóa), mục 8 (video 5–10 phút và nội dung gợi ý), mục 9 (hồ sơ/nơi nộp/hạn nộp), mục 10 (thang điểm). Nội dung thao tác được đối chiếu mã nguồn hiện tại và kết quả nghiệm thu trong FINAL_AUDIT.md; không coi các mốc thời gian là bằng chứng đã quay xong video.
