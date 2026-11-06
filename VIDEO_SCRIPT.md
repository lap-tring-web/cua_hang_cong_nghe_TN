# KỊCH BẢN QUAY MỚI FINAL01 — CỬA HÀNG CÔNG NGHỆ THỊNH NGUYỄN

Nguyễn Ngô Quốc Thịnh · MSSV **N25DTCN057** · Lớp **D25TXCN01-N**  
Cập nhật **05/11/2026** · Dự kiến **9 phút 35 giây** · Giới hạn đề: **5–10 phút**

**Bạn chưa quay video thì có thể bắt đầu từ kịch bản này. Không cần xóa database hoặc khôi phục các đơn đã test.** Lượt mới dùng email mới, nhãn FINAL01 và hai đơn tạo ngay trong video. Mã đơn do hệ thống tự cấp, không cố định theo kịch bản cũ.

Phần **Nói** là lời thuyết minh mẫu; phần **Làm** là thao tác, không đọc thành tiếng. Mỗi cảnh theo nhịp: nói mục đích ngắn → thao tác → giải thích kết quả đang thấy. Khi chỉ code: mở đúng đoạn trước, trỏ chuột vào dòng rồi giải thích. Nói tự nhiên, chỉ khẳng định điều mình hiểu và đang quan sát được.

## 1. Chuẩn bị trước khi quay

### Môi trường và cửa sổ

1. Bật Apache và MySQL trong XAMPP; MySQL cổng **3307**. Mở **http://localhost/thinh-tech/** và nhấn Ctrl+F5. Tên đúng là `thinh-tech`, có chữ h.
2. Dùng hai phiên tách biệt: cửa sổ thường cho **KHÁCH**, cửa sổ ẩn danh hoặc trình duyệt khác cho **ADMIN**. Hai tab cùng cửa sổ chia sẻ session nên không dùng làm hai vai trò.
3. Cửa sổ KHÁCH: đăng xuất tài khoản cũ, mở giỏ, nếu còn hàng test thì xóa giỏ **trước khi quay**. Đây chỉ là giỏ của phiên, không xóa sản phẩm hay đơn cũ. Mở lại trang chủ; giữ phiên đó để quay.
4. Cửa sổ ADMIN: mở trang đăng nhập, có thể điền trước email, chưa nhấn đăng nhập nếu muốn ghi lại bước này trong video.
5. Mở sẵn VS Code với đúng thư mục ứng dụng `thinh-tech`, bật số dòng; chuẩn bị các tab `config/config.php`, `includes/init.php`, `checkout.php`, `order-cancel.php`, `includes/functions.php`, `login.php`, `register.php`. Trong VS Code dùng Ctrl+G để đến dòng.
6. Mở phpMyAdmin, chọn database `thinh_tech`; chuẩn bị tab Structure của `order_items`. Không mở toàn bộ dữ liệu tài khoản cá nhân không liên quan khi quay.
7. Quay 1080p nếu máy hỗ trợ, chữ dễ đọc, thanh địa chỉ còn trong khung hình. Thử mic 10 giây, tắt thông báo cá nhân. Đề yêu cầu giọng thuyết minh của chính sinh viên, không bắt buộc quay khuôn mặt.
8. Mở bảng nhắc nhanh ở màn hình phụ/điện thoại. Chuẩn bị dữ liệu để dán, nhưng không để trang chứa mật khẩu chiếm màn hình quay.

### Dữ liệu cho lượt FINAL01

| Mục | Giá trị chuẩn bị |
|---|---|
| Họ tên khách mới | Nguyễn Ngô Quốc Thịnh |
| Email mới | `quay.thinh.20261105.01@example.com` |
| Mật khẩu khách mới | `ThinhVideo@2026` |
| Điện thoại | `0343180715` |
| Địa chỉ | `80/15B Hoàng Hoa Thám, Bình Thạnh, TP. Hồ Chí Minh` |
| Admin website | `nguyenngothinh669@gmail.com` / `ThinhTech@2026` |
| Ghi chú đơn A | `FINAL01 - QR minh hoa va huy` |
| Ghi chú đơn B | `FINAL01 - COD giao va hoan tat` |
| Tiêu đề liên hệ | `FINAL01 - Tu van Keychron K8` |
| Sản phẩm admin tạm | `Chuột Logitech M330 - FINAL01` |
| Danh mục admin tạm | `Danh mục FINAL01` |

Email mới trên chưa tồn tại tại lúc kiểm tra ngày 05/11; hệ thống không gửi thư xác minh nên dùng email minh họa được. Nếu bạn đã tập bằng email đó, đổi `.01` thành `.02` và dùng nhãn FINAL02 thống nhất. Mật khẩu admin là mật khẩu website đồ án, không phải mật khẩu hộp thư.

Ảnh chọn sẵn trong `deliverables/QUAY_VIDEO_FINAL01/` ở thư mục cha:

- `avatar-chan-dung.jpg`: dùng cho hồ sơ khách vừa đăng ký.
- `logitech-m330-01.jpg` và `logitech-m330-02.jpg`: hai ảnh cùng mẫu M330, dùng thêm rồi thay ảnh sản phẩm tạm.
- `DU_LIEU_DAN_NHANH.txt`: địa chỉ, tên, thông số, nội dung liên hệ để dán nhanh.

### Hai đơn phải tách riêng

| Đơn | Tạo bởi | Phương thức | Kết thúc demo |
|---|---|---|---|
| A | Khách mới FINAL01 | Chuyển khoản | Khách hủy khi Chờ xử lý |
| B | Cùng khách FINAL01 | COD | Admin chuyển Đang giao → Hoàn tất |

**Không dùng đơn đã hủy cho cảnh giao hàng. Không sửa đơn test cũ. Không cần chuyển tiền thật hoặc bấm “Tôi đã chuyển khoản”.** Trước khi bấm hủy/cập nhật, luôn kiểm tra mã đơn và ghi chú FINAL01.

## 2. Phân bổ thời gian

| Thời gian | Nội dung | Cần thấy |
|---|---|---|
| 00:00–00:30 | Mở đầu | Họ tên, MSSV, chủ đề, logo chân dung |
| 00:30–01:15 | Khám phá giao diện | Tìm/lọc/sắp xếp/phân trang/chi tiết |
| 01:15–02:05 | Đăng ký, đăng nhập, hồ sơ | Tài khoản mới, avatar cập nhật |
| 02:05–03:15 | Giỏ → đơn A → QR → hủy | Toast 2 giây, tạo đơn, lịch sử, Đã hủy |
| 03:15–03:45 | Tạo đơn B COD | Mã COD mới, còn Chờ xử lý |
| 03:45–04:10 | Liên hệ | Nội dung chứa thẻ HTML được gửi |
| 04:10–06:10 | Quản trị | Tổng quan, thêm/sửa/xóa sản phẩm, ảnh, danh mục, đơn |
| 06:10–08:10 | Source và CSDL | 6 bảng, cấu hình, checkout/cancel có transaction |
| 08:10–09:15 | Bảo mật | Khách bị chặn admin, script hiện dạng chữ, 403 nội bộ |
| 09:15–09:35 | Kết thúc | Phạm vi local, giới hạn thanh toán/hosting |

Đây là **mốc tập luyện**, chưa phải thời lượng được đo. Nhập liệu bằng dán nhanh và tập chuyển cửa sổ. Nếu vượt thời gian, dùng cách rút gọn ở mục 14, không tăng tốc lời nói đến mức khó nghe.

## 3. Cảnh 1 — 00:00–00:30: Giới thiệu

**Màn hình:** trang chủ KHÁCH chưa đăng nhập, thanh địa chỉ và logo chân dung rõ.

**Nói:**

> Em kính chào thầy. Em là Nguyễn Ngô Quốc Thịnh, mã số sinh viên N25DTCN057, lớp D25TXCN01-N. Sau đây em xin trình bày website Cửa hàng Công Nghệ Thịnh Nguyễn, chuyên thiết bị và phụ kiện công nghệ.
>
> Dự án sử dụng HTML, CSS, JavaScript, PHP thuần và MySQL/MariaDB. Em dùng ảnh chân dung của mình làm logo trên mọi trang, gồm trang quản trị, theo yêu cầu cá nhân hóa của đề.

**Làm:** trỏ logo cạnh tên cửa hàng; cuộn nhanh tới chân trang để thấy MSSV và họ tên, quay lên vùng sản phẩm.

## 4. Cảnh 2 — 00:30–01:15: Tìm kiếm và sản phẩm

**Nói trước khi thao tác:**

> Khách có thể tìm theo tên, lọc danh mục và sắp xếp giá. Em minh họa bằng từ khóa Logitech.

**Làm:**

1. Nhập `Logitech` vào ô tìm kiếm → nhấn nút tìm.
2. Chọn **Giá tăng dần** → **Sắp xếp**.
3. Bấm liên kết menu **Sản phẩm** để bỏ bộ lọc; chọn **Chuột và bàn phím**.
4. Bấm **Sản phẩm** lại để về toàn bộ; mở trang **2**, rồi quay về trang 1.
5. Mở **Chuột không dây Logitech M330 Silent Plus**: ảnh, giá, mô tả, bảng thông số và sản phẩm liên quan.
6. Mở nhanh **Giới thiệu** rồi quay về sản phẩm M330; phần Liên hệ sẽ demo sau.

**Nói cùng kết quả:**

> Danh mục hiện có 15 sản phẩm thuộc 4 nhóm. Danh sách chia tám sản phẩm mỗi trang; trang chi tiết có thông số và sản phẩm liên quan. Giao diện trắng–xanh dùng CSS riêng, Grid và Flexbox, có bố cục thích ứng trên điện thoại.

Nếu thao tác responsive chưa quen, chỉ mô tả ở cảnh này và dành 5 giây cho nó khi mở CSS ở phần source. Không tìm tên TN cũ; danh mục hiện tối đa 4 sản phẩm nên phân trang phải minh họa ở **toàn bộ sản phẩm**.

## 5. Cảnh 3 — 01:15–02:05: Tài khoản mới và hồ sơ

**Nói:**

> Em tạo một tài khoản mới để minh họa độc lập với những lần kiểm thử trước. Form kiểm tra dữ liệu phía trình duyệt; máy chủ kiểm tra lại và ngăn email trùng.

**Làm:**

1. Vào **Đăng ký**, nhập dữ liệu FINAL01 ở mục 1, tích điều khoản → gửi đăng ký. Nhập cả hai mật khẩu đúng để tránh mất thời gian.
2. Website chuyển đến đăng nhập → dùng email vừa đăng ký và `ThinhVideo@2026` → **Đăng nhập**.
3. Bấm avatar bên phải → **Tài khoản của tôi**.
4. Điền địa chỉ đã chuẩn bị, chọn `avatar-chan-dung.jpg` → **Lưu thay đổi**.
5. Bấm avatar để thấy tên tài khoản, liên kết hồ sơ và đơn hàng.

**Nói cùng kết quả:**

> Hệ thống dùng session để nhận diện người dùng. Logo chân dung cửa hàng ở bên trái giữ nguyên; avatar tài khoản bên phải cập nhật theo người đăng nhập. Khách sửa được thông tin liên hệ và ảnh, còn email đăng nhập được giữ cố định. Địa chỉ vừa lưu sẽ điền sẵn khi checkout.

Không dùng chức năng đổi mật khẩu ở bản chính vì sẽ làm bạn phải nhớ một mật khẩu khác cho các cảnh sau.

## 6. Cảnh 4 — 02:05–03:15: Giỏ hàng, đơn chuyển khoản và hủy

### 6.1 Thêm giỏ và số lượng

**Nói:**

> Khi thêm sản phẩm, hệ thống giữ nguyên trang và hiện thông báo hai giây ở góc phải trên. Trong giỏ, thành tiền thay đổi ngay theo số lượng.

**Làm:**

1. Về **Sản phẩm**, mở M330, bấm **Thêm vào giỏ**. Để chuột ra khỏi thông báo, chờ khoảng 2 giây; hover sẽ tạm dừng bộ đếm.
2. Thêm **Bàn di chuột Logitech Desk Mat Studio Series** một lần.
3. Mở biểu tượng giỏ: M330 một chiếc và Desk Mat một chiếc.
4. Đổi M330 thành **2**, chỉ tổng tiền đổi; bấm **Cập nhật giỏ hàng**.
5. Bấm **Xóa** ở dòng Desk Mat → **Xác nhận xóa**. Còn M330 số lượng 2. Đây là xóa thật dòng trong giỏ của phiên, không xóa sản phẩm khỏi cửa hàng.

Giá tại thời điểm chuẩn bị: M330 259.000đ; hai chiếc là **518.000đ**. Nếu bạn đổi giá trước quay, đọc tổng tiền thực tế trên màn hình.

### 6.2 Checkout và QR

**Làm:**

1. **Đặt hàng** → kiểm tra người nhận, số điện thoại và địa chỉ đã điền sẵn.
2. Ghi chú `FINAL01 - QR minh hoa va huy`.
3. Chỉ hai lựa chọn thanh toán → chọn **Chuyển khoản ngân hàng** → **Xác nhận đặt hàng**.
4. Dừng ở chi tiết đơn: đọc mã **A = #_____** trên giấy nhắc; chỉ tổng tiền, BIDV, QR và nội dung `TN...` riêng của đơn.

**Nói:**

> Khách có thể chọn COD hoặc chuyển khoản. Với đơn A này, QR chứa số tiền và mã tham chiếu riêng để đối chiếu. Hệ thống chưa kết nối ngân hàng tự động; thông báo của khách không phải xác nhận tiền đã về.

### 6.3 Lịch sử và hủy đơn A

**Làm:** avatar → **Đơn hàng của tôi** → mở đúng đơn A → **Hủy đơn hàng** → **Xác nhận**. Dừng ở **Đã hủy** và thông báo hoàn tồn kho. Không bấm nút báo đã chuyển khoản.

**Nói:**

> Khách xem lại đơn trong lịch sử và được hủy đơn của mình khi còn Chờ xử lý. Em hủy đúng đơn vừa tạo; hệ thống đổi trạng thái và hoàn kho trong một giao dịch. Đơn đã hủy không thể hủy thêm để cộng kho lần nữa.

## 7. Cảnh 5 — 03:15–03:45: Tạo đơn COD riêng

**Nói:**

> Để minh họa xử lý giao hàng ở vai trò admin, em tạo một đơn COD khác. Đơn này độc lập với đơn A đã hủy.

**Làm:**

1. Mở **Bàn di chuột Logitech Desk Mat Studio Series** → **Thêm vào giỏ** một lần → giỏ → **Đặt hàng**.
2. Thông tin nhận hàng đã điền sẵn; ghi chú `FINAL01 - COD giao va hoan tat`.
3. Chọn **Thanh toán khi nhận hàng** → **Xác nhận đặt hàng**.
4. Ghi mã **B = #_____** trên giấy nhắc; chỉ **Chờ xử lý** và **COD**. Không hủy đơn B.

**Nói cùng kết quả:**

> Em sẽ dùng đúng mã đơn COD này để chuyển Đang giao và Hoàn tất ở phần quản trị.

## 8. Cảnh 6 — 03:45–04:10: Gửi liên hệ

**Làm:** vào **Liên hệ**, dán họ tên/email FINAL01, tiêu đề `FINAL01 - Tu van Keychron K8`, nội dung:

```text
Em muốn hỏi kết nối của bàn phím Keychron K8. <script>alert('kiem-tra-FINAL01')</script>
```

Nhấn **Gửi**, để thấy thông báo đã nhận.

**Nói:**

> Form liên hệ kiểm tra dữ liệu và lưu vào database để admin đọc. Em chủ động gửi một thẻ script vào ứng dụng của mình; ở phần bảo mật, em sẽ kiểm tra nó được hiển thị như văn bản và không thực thi.

## 9. Cảnh 7 — 04:10–06:10: Quản trị

### 9.1 04:10–04:30 — Đăng nhập và tổng quan

**Làm:** chuyển cửa sổ ADMIN → đăng nhập admin → avatar → **Quản trị cửa hàng**. Chỉ logo chân dung, bốn trạng thái, doanh thu và danh sách tồn thấp.

**Nói:**

> Khu vực quản trị cũng hiển thị logo chân dung của em. Dashboard thống kê đơn theo trạng thái, doanh thu từ các đơn hoàn tất và năm sản phẩm có tồn kho thấp nhất.

Không đọc cố định “14 đơn” vì trong video đã tạo thêm hai đơn; nói theo kết quả hiện tại nếu cần.

### 9.2 04:30–05:20 — Thêm, sửa, thay ảnh và xóa sản phẩm tạm

**Làm:** **Sản phẩm** → **Thêm sản phẩm**, nhập nhanh:

| Trường | Nội dung |
|---|---|
| Tên | `Chuột Logitech M330 - FINAL01` |
| Danh mục | Chuột và bàn phím |
| Giá | `259000` |
| Tồn kho | `5` |
| Mô tả | `Bản ghi minh họa quản trị trong video FINAL01; chuột không dây Logitech M330.` |
| Thông số dòng 1 | `Kết nối: USB receiver 2.4 GHz` |
| Thông số dòng 2 | `Nguồn: 1 pin AA` |
| Ảnh thêm | `logitech-m330-01.jpg` |

Bấm **Lưu sản phẩm**. Bản mới ở trang quản lý đầu tiên; chọn **Sửa**, đổi giá thành `249000`, chọn ảnh `logitech-m330-02.jpg`, lưu. Sau đó **Xóa** đúng bản ghi có hậu tố FINAL01 → **Xác nhận xóa**. Không đặt mua sản phẩm tạm trước khi xóa.

**Nói trong khi làm:**

> Em thêm một bản ghi minh họa để trình bày đầy đủ thao tác sản phẩm và tải ảnh. Sau đó em sửa giá và thay ảnh; ảnh upload cũ được dọn sau khi cập nhật thành công. Bản ghi tạm chưa có trong đơn hàng nên xóa được. Với sản phẩm đã có đơn, hệ thống chặn xóa để giữ lịch sử.

Nếu quá 50 giây, ưu tiên thêm có ảnh và sửa; có thể xóa sản phẩm tạm sau khi quay. Khi đó số liệu sản phẩm trong lúc quay sẽ tăng, cần thống kê lại sau khi chốt.

### 9.3 05:20–05:40 — Thêm, đổi tên, xóa danh mục

**Làm:** **Danh mục** → thêm `Danh mục FINAL01` → đổi thành `Danh mục FINAL01 - đã sửa` → **Đổi tên** → **Xóa** dòng đó → xác nhận. Danh mục này để trống, không gán sản phẩm vào.

**Nói:**

> Danh mục hỗ trợ thêm, đổi tên và xóa. Em xóa một danh mục trống; danh mục đang có sản phẩm được bảo vệ bởi quan hệ dữ liệu.

### 9.4 05:40–06:10 — Đơn B: Đang giao → Hoàn tất

**Làm:** **Đơn hàng** → lọc **Chờ xử lý** → tìm đúng **B = #_____**, bấm **Xem đơn** để kiểm tra ghi chú COD FINAL01 nếu cần → trở về quản lý.

Ở đúng dòng B: chọn **Đang giao** → **Lưu**. Sau lưu trang trở về danh sách tất cả; tìm lại **cùng mã B**, chọn **Hoàn tất** → **Lưu**. Chỉ trạng thái hoàn tất/đã thanh toán, có thể về Tổng quan thấy số liệu cập nhật.

**Nói:**

> Em chuyển đúng đơn COD đã tạo từ Chờ xử lý sang Đang giao, rồi Hoàn tất. COD hoàn tất được ghi nhận đã thu tiền. Hệ thống kiểm tra các bước chuyển trạng thái; đơn chuyển khoản chưa xác nhận tiền về thì chưa được giao.

Đây là dữ liệu mô phỏng chức năng, không tuyên bố đơn demo đã được giao hàng ngoài thực tế. Không chọn đơn A hoặc các đơn test cũ.

## 10. Cảnh 8 — 06:10–08:10: Cấu trúc, database và code

### 10.1 06:10–06:30 — Cây thư mục, cấu hình, responsive

**Làm:** VS Code → cây thư mục ứng dụng. Mở `config/config.php` **dòng 23–27**, trỏ **DB_PORT dòng 24**. Nếu đã tập responsive, dành khoảng 5 giây đổi cửa sổ trình duyệt về điện thoại rồi trả về; có thể thay phần responsive bằng cảnh này.

**Nói:**

> Source chia thành trang khách hàng, thư mục admin, config, includes, CSS, JavaScript và ảnh. Header và footer dùng chung giúp mọi trang giữ đúng nhận diện. Cấu hình kết nối dùng PDO, database thinh_tech ở cổng 3307. Giao diện tự chuyển số cột theo độ rộng màn hình.

### 10.2 06:30–07:00 — phpMyAdmin

**Làm:** mở phpMyAdmin → `thinh_tech` → danh sách sáu bảng. Mở Structure của `order_items`; chỉ các cột `order_id`, `product_id`, `product_name`, `price`, `quantity`, khóa và quan hệ nếu đang ở Relation view/Designer đã chuẩn bị.

**Nói:**

> Database có sáu bảng: categories, products, users, orders, order_items và contacts. Các khóa ngoại liên kết danh mục với sản phẩm, người dùng với đơn và đơn với từng dòng hàng. Order_items lưu tên và đơn giá ở thời điểm mua, nên lịch sử vẫn đúng khi tên hay giá sản phẩm hiện tại thay đổi.

Không tuyên bố đây là hosting. Nếu quay ảnh database cho báo cáo, cần bố trí khung hình theo yêu cầu của đề; cảnh video chỉ dùng để giải thích cấu trúc.

### 10.3 07:00–07:40 — `checkout.php`

**Làm:** mở file đúng ứng dụng, Ctrl+G **49**, sau đó **74**, **91**, **101**. Trỏ chuột, không chọn toàn bộ đoạn dài.

**Nói:**

> Đoạn xử lý em chọn là giao dịch đặt hàng. Dòng 49 bắt đầu transaction, dòng 52 khóa các sản phẩm bằng SELECT FOR UPDATE. Hệ thống đọc lại giá và tồn kho từ database để kiểm tra, thay vì tin tổng tiền gửi từ trình duyệt.
>
> Từ dòng 74 tạo đơn, dòng 91 lưu từng dòng hàng và dòng 94 trừ kho. Dòng 101 commit khi mọi bước thành công. Nếu lỗi, các nhánh ở dòng 107 và 113 rollback, tránh việc có đơn mà chưa trừ kho hoặc trừ kho nhưng chưa có đơn.

### 10.4 07:40–08:10 — `order-cancel.php`

**Làm:** mở file 25 dòng; chỉ **7 → 8–11 → 14–18 → 21**.

**Nói:**

> Khi hủy đơn, dòng 7 bắt đầu transaction; dòng 8 khóa đúng đơn thuộc user hiện tại. Dòng 11 chỉ cho hủy khi còn pending. Dòng 14 hoàn kho, dòng 16 đổi sang cancelled và dòng 18 commit. Nếu lỗi, dòng 21 rollback. Sau lần đầu đơn không còn pending nên yêu cầu hủy lặp không thể cộng kho thêm.

**Bảng chỉ code đã đối chiếu ngày 05/11/2026:**

| File | Dòng cần mở | Ý nghĩa |
|---|---|---|
| `config/config.php` | 24 | MySQL port 3307 |
| `includes/init.php` | 14–16; 31–33 | Session; kiểm tra CSRF mọi POST |
| `checkout.php` | 49; 52; 60–70 | Bắt đầu transaction, khóa, kiểm tra tồn/tính lại tổng |
| `checkout.php` | 74–83; 90–101 | Đơn, dòng hàng, trừ kho, commit |
| `checkout.php` | 106–115 | Rollback khi có lỗi |
| `order-cancel.php` | 7–11; 14–18; 21 | Khóa đơn/đúng chủ/pending, hoàn kho một lần |
| `includes/functions.php` | 7–9; 127; 141; 178–205 | Escape HTML, phân quyền, upload, CSRF |
| `login.php` | 24–30; 48 | Prepared statement, verify mật khẩu, khóa 300 giây |
| `register.php` | 55 | Hash mật khẩu trước khi lưu |

Các số dòng chỉ đúng phiên bản này; nếu sau đó chỉnh code, kiểm tra lại trước khi quay.

## 11. Cảnh 9 — 08:10–09:15: Bảo mật

### 11.1 Khách truy cập admin — khoảng 15 giây

**Làm:** về cửa sổ KHÁCH đang đăng nhập FINAL01; nhập `http://localhost/thinh-tech/admin/index.php`. Dừng ở 403, vẫn thấy logo chân dung và tên cửa hàng.

**Nói:**

> Em dùng tài khoản khách truy cập trực tiếp admin. Máy chủ trả 403 vì không đủ quyền; bảo vệ được kiểm tra phía server, không chỉ ẩn menu.

### 11.2 Script hiển thị thành chữ — khoảng 20 giây

**Làm:** chuyển ADMIN → **Liên hệ**, tìm tiêu đề FINAL01. Chỉ đúng nội dung `<script>alert('kiem-tra-FINAL01')</script>`, không hiện hộp thoại.

**Nói:**

> Tin nhắn vừa gửi được hiển thị dạng văn bản, không chạy script. Hàm e dùng htmlspecialchars khi xuất dữ liệu vào HTML. Đây là xử lý theo ngữ cảnh hiển thị; nội dung gốc vẫn được lưu trong database.

### 11.3 Chặn thư mục và giải thích — khoảng 30 giây

**Làm:** tab mới mở `http://localhost/thinh-tech/config/config.php`, rồi `http://localhost/thinh-tech/database/`, thấy 403. Quay VS Code `includes/functions.php` dòng **191**, rồi `login.php` dòng **24/28/48**, `register.php` dòng **55** nếu thao tác đủ nhanh.

**Nói:**

> Apache chặn truy cập trực tiếp cấu hình và database. Form POST có CSRF token; truy vấn tham số dùng prepared statements. Mật khẩu được băm bằng password_hash và kiểm tra bằng password_verify. Đăng nhập sai năm lần sẽ khóa form năm phút trong cùng session. Upload giới hạn ảnh hợp lệ tối đa hai megabyte và thư mục ảnh chặn thực thi PHP.

Trang Apache 403 của thư mục nội bộ có thể là trang lỗi mặc định, không có header ứng dụng; đây là kết quả chặn truy cập, không phải lỗi mất logo của các trang chức năng. Không tốn thời gian chờ hết khóa đăng nhập trong video.

## 12. Cảnh 10 — 09:15–09:35: Kết thúc

**Làm:** quay trang chủ có logo chân dung và tên cửa hàng; có thể cho thấy khách vừa bị 403 quay về trang chủ được.

**Nói:**

> Em đã trình bày luồng mua hàng, quản trị, cấu trúc dữ liệu và các xử lý bảo mật chính. Phiên bản này chạy trên localhost; hosting thật chưa triển khai. Mã nguồn, ảnh và SQL đã được chuẩn bị cùng hướng dẫn cài đặt. Em xin kết thúc và cảm ơn thầy đã theo dõi.

GitHub lưu source không đồng nghĩa website PHP đã được triển khai Internet. Không cần mở GitHub trong video nếu không còn thời gian.

## 13. Khi quay bị vướng thì xử lý thế nào?

| Tình huống | Cách làm |
|---|---|
| Đã dùng email FINAL01 khi tập | Chuyển email `.01` → `.02`, nhãn FINAL02 và tin nhắn script FINAL02 cho cả lượt mới. Không xóa tài khoản cũ để quay lại. |
| Đã tạo/hủy đơn A nhưng chưa bắt đầu quay | Trong lượt quay mới, tạo đơn A mới; mã đơn được ghi lại sau checkout. Không dùng mã cũ. |
| Giỏ có nhiều món test | Trước quay xóa giỏ của đúng phiên khách, rồi mở trang chủ. Không xóa lịch sử đơn hoặc import lại SQL. |
| Đơn COD không còn Chờ xử lý | Tạo một đơn COD FINAL mới. Không chuyển ngược đơn completed/cancelled hoặc sửa SQL. |
| Sau lọc Chờ xử lý rồi lưu Đang giao | Trang trở về danh sách tất cả. Tìm lại cùng mã B trước khi chuyển Hoàn tất. |
| Hủy không được vì đơn đã giao | Đã chọn sai đơn; quay lại đơn A mới còn pending. Không chỉnh code để vượt điều kiện. |
| Admin đang hiện tài khoản khách | Hai vai trò dùng chung phiên. Đăng nhập admin ở trình duyệt khác/cửa sổ ẩn danh riêng. |
| Toast không mất sau 2 giây | Di chuột ra khỏi toast và bỏ focus ở liên kết trong toast; hover/focus tạm dừng bộ đếm theo thiết kế. |
| Tìm Logitech rồi không có trang 2 | Bộ lọc ít kết quả. Bấm menu Sản phẩm để bỏ bộ lọc và xem toàn bộ. |
| Xóa sản phẩm báo đã có đơn | Chọn nhầm sản phẩm thật. Chỉ xóa bản ghi tạm có hậu tố FINAL01 chưa mua. |
| Lỡ nói sai một câu | Dừng 1–2 giây, nói lại câu đó rồi cắt đoạn vấp khi dựng. Kết quả demo vẫn phải là thao tác thật. |

## 14. Cách giữ video trong 10 phút

- Tập bấm đường đi một lần với dữ liệu FINAL00; khi ghi hình đổi FINAL01/FINAL02 để tài khoản mới chưa tồn tại.
- Dán dữ liệu chuẩn bị sẵn thay vì gõ cả đoạn địa chỉ/thông số. Giữ một nhịp ngắn cho người xem thấy kết quả lưu, tạo đơn, hủy, thay ảnh.
- Nếu gần quá thời gian: bỏ thử responsive trực tiếp, bỏ một lần thay ảnh hoặc dọn sản phẩm sau quay. Vẫn giữ cả luồng khách/admin, database, một đoạn code và hai minh họa phân quyền/XSS.
- Không cần quay tất cả A1–D11 riêng từng cảnh. Video là phần tổng quan; báo cáo vẫn cần minh chứng từng yêu cầu đã khai.
- Có thể cắt đoạn gõ/chọn file/chờ tải; không ghép kết quả khác đơn hoặc che lỗi để mô tả sai chức năng. Video cuối phải 5–10 phút, nên dừng dưới 9:50 để còn dư.
- Đổi mật khẩu và khóa form năm lần sai: tùy chọn cho vấn đáp/ảnh báo cáo hoặc thay một đoạn ít cần hơn; không cộng hết vào timeline 9:35.

## 15. Sau khi quay: số liệu, source và nộp

1. Xem lại video: giọng rõ, màn hình đọc được, các thao tác là cùng lượt FINAL, logo chân dung/tên cửa hàng hiện trên các trang ứng dụng, hai mã A/B không bị nhầm.
2. Sản phẩm/danh mục tạm đã xóa trong video thì số lượng trở lại mức cũ. Giữ hai đơn FINAL và tài khoản mới làm dữ liệu demo. Không xóa hàng loạt tài khoản/đơn cũ.
3. Sau quay, thống kê lại trong phpMyAdmin bằng SQL bên dưới. Trước lượt mới đã kiểm tra có **15 sản phẩm, 4 danh mục, 4 tài khoản, 14 đơn**. Nếu hoàn thành đúng một lượt mới, không phát sinh thao tác khác và xóa sản phẩm/danh mục tạm, dự kiến **15 sản phẩm, 4 danh mục, 5 tài khoản, 16 đơn**; đây chỉ là dự kiến, kết quả truy vấn mới là số dùng trong báo cáo.
4. Xuất lại database `thinh_tech` thành `database/thinh_tech_export.sql` và ZIP cùng phiên bản. Công cụ có sẵn ở thư mục cha: `tools/package-release.py`; không import SQL vào database đang dùng. Nếu tiếp tục bàn giao GitHub thì commit/push bản export sau quay.
5. Báo cáo hiện còn là bản nháp cũ; cần cập nhật ảnh chân dung, đủ minh chứng, số liệu mới và URL video. Với ảnh giao diện trong báo cáo, giữ rõ tên cửa hàng và logo chân dung; không dùng ảnh QA cũ.
6. Đặt tên video `N25DTCN057_NguyenNgoQuocThinh_VideoBaoCao.mp4`. Tải YouTube **Không công khai** hoặc Drive **Bất kỳ ai có đường liên kết**, mở thử khi chưa đăng nhập rồi điền link và thời lượng vào báo cáo.
7. Nộp cả **LMS và Google Form** trước **23:00 ngày 07/11/2026** theo đề PDF ban đầu. GitHub không thay thế ZIP/SQL và các link Drive riêng mà đề yêu cầu.

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

## 16. Câu hỏi vấn đáp nên hiểu

| Câu hỏi | Ý trả lời |
|---|---|
| Vì sao transaction? | Lưu đơn, chi tiết và trừ kho phải cùng thành công; có lỗi thì hoàn tác chung. |
| FOR UPDATE làm gì? | Khóa dòng trong transaction để các giao dịch khác không cùng cập nhật dòng đó đến khi commit/rollback. |
| Vì sao lấy giá từ DB? | Trình duyệt có thể bị sửa; server phải đọc giá và kiểm tra tồn mới nhất. |
| Vì sao order_items giữ giá/tên? | Lưu lịch sử ở thời điểm mua dù sản phẩm thay đổi sau đó. |
| e() khác prepared statements? | e() mã hóa khi xuất HTML, prepared statements tách dữ liệu khỏi SQL; hai ngữ cảnh khác nhau. |
| POST có đủ chống CSRF không? | Không; token gắn phiên giúp kiểm tra yêu cầu từ form hợp lệ. |
| Vì sao hủy lặp không hoàn kho hai lần? | Khóa đúng đơn và chỉ cho pending; sau lần đầu đã cancelled. |
| QR có tự báo tiền về không? | Chưa; khách chỉ báo, admin phải đối soát. Không tuyên bố tích hợp cổng thanh toán tự động. |
| Khóa đăng nhập có tuyệt đối không? | Chỉ bộ đếm theo session, chưa phải chống brute force production theo tài khoản/IP. |
| GitHub có tính hosting E không? | Không; E yêu cầu hosting PHP/MySQL thật, HTTPS và các điều kiện của đề. |

**Căn cứ:** đề PDF gốc, mục 2 (cá nhân hóa), mục 8 (video 5–10 phút và các nhóm nội dung), mục 9 (hồ sơ/nộp). Không áp dụng phần nội dung khác trong ảnh LMS đã được yêu cầu bỏ qua. Timeline là dự kiến; sinh viên cần tập và đo thời lượng trước khi xuất video nộp.
