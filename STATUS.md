# Trạng thái và công việc còn lại

**Chuẩn đối chiếu đã chốt ngày 05/11/2026:** theo xác nhận của sinh viên, chỉ áp dụng đề PDF ban đầu: tối thiểu **12 sản phẩm, 3 danh mục**, video **5–10 phút**. Không áp dụng yêu cầu nội dung trong ảnh LMS vừa gửi. Hiện có 15 sản phẩm và 4 danh mục, đã đạt ngưỡng dữ liệu này. Logo cửa hàng dùng ảnh chân dung theo xác nhận mới nhất ngày 05/11/2026; avatar tài khoản theo người đăng nhập.

## Đã triển khai local

- Nghiệm thu cuối 03/11/2026: 8 bộ trình duyệt/84 ca hoặc nhóm kiểm tra đạt trên bản sao riêng, 5 nhóm kiểm tra trực tiếp localhost đạt, 39 tệp PHP lint đạt, 4 cách cài SQL/migration đạt. CSDL và uploads chính giữ nguyên. Xem FINAL_AUDIT.md và VIDEO_SCRIPT.md trước khi quay. Nhận diện đã cập nhật ngày 05/11/2026: ảnh chân dung sinh viên làm logo cửa hàng theo xác nhận mới nhất. Hồ sơ còn cần báo cáo cập nhật và URL video; hosting E vẫn chưa triển khai.

- Nâng cấp trang Giới thiệu (03/11/2026): banner ảnh thật, câu chuyện thương hiệu, bốn nhóm phụ kiện có liên kết, lợi ích mua sắm và thông tin liên hệ. Đồng bộ tông trắng–xanh, tương thích điện thoại; đã kiểm tra ảnh/liên kết, cú pháp PHP và 7 nhóm giao diện chung.

Các nhóm A–D đã có mã xử lý. Bản xuất có 4 danh mục, 15 sản phẩm, tối thiểu 4 tài khoản và 6 đơn ở 4 trạng thái; số liệu tại thời điểm đóng gói nằm trong deliverables/release-manifest.json. Kiểm thử trình duyệt tự động gồm 32 kiểm tra nghiệp vụ/giao diện/bảo mật, 7 nhóm giao diện, 10 nhóm thanh toán, 9 nhóm hồ sơ/ảnh đại diện và 8 nhóm menu avatar; kiểm tra cú pháp 39 tệp PHP. Logo header là ảnh chân dung sinh viên cố định theo đề; góc tài khoản dùng avatar theo người đăng nhập.

Đã cài vào XAMPP bằng liên kết thư mục htdocs. Website chạy tại http://localhost/thinh-tech/; phpMyAdmin tại http://localhost/phpmyadmin/ hiển thị đủ 6 bảng của `thinh_tech`, máy chủ 127.0.0.1:3307. Cả 32 kiểm tra đã chạy lại đạt trên Apache localhost, gồm đăng nhập/session, đặt hàng/hủy/hoàn kho, upload và phân quyền. Thư mục cấu hình/CSDL trả 403, URL sai trả 404.

D10 khóa theo session, phù hợp bài thực hành; chưa phải cơ chế chống brute force theo IP/tài khoản ở mức production.

## Thêm giỏ hàng tại chỗ

- Danh sách và chi tiết sản phẩm thêm giỏ qua POST/JSON, giữ nguyên trang và cập nhật huy hiệu giỏ. Thông báo ở góc trên bên phải màn hình tự ẩn sau 2 giây, tạm dừng khi rê chuột hoặc focus; có hỗ trợ trình đọc màn hình, nút đóng và Xem giỏ hàng.
- Vẫn kiểm tra CSRF/sản phẩm/số lượng/tồn kho tại máy chủ. Chặn gửi trùng khi đang xử lý; lỗi kết nối không tự gửi lại để tránh cộng hai lần. Form không JavaScript quay lại trang sản phẩm/danh sách với thông báo, chỉ cho phép đường dẫn nội bộ.
- 6 nhóm kiểm tra ở tools/test-cart-async.cjs đạt; dữ liệu kiểm thử chỉ dùng session, không tạo đơn hoặc đổi tồn kho.

## Hồ sơ khách hàng và ảnh đại diện

- Khách cập nhật họ tên, điện thoại, địa chỉ và tải/thay/xóa ảnh trong Tài khoản. Có xem trước ảnh và bỏ ảnh vừa chọn; email giữ cố định, đổi mật khẩu qua chức năng riêng.
- Avatar hiển thị ở góc trên bên phải, cập nhật khi lưu/đăng nhập lại và giữa các phiên. Bấm avatar mở Tài khoản của tôi/đơn hàng/đăng xuất và quản trị nếu có quyền; bỏ nút Tài khoản ở hàng menu. Logo cửa hàng vẫn là ảnh chân dung sinh viên cố định theo đề. Khách chưa đăng nhập dùng biểu tượng tài khoản chung.
- Chấp nhận JPG/PNG/WebP thật, tối đa 2 MB và 4096 pixel mỗi chiều; tên tệp ngẫu nhiên, chặn thực thi tệp, CSRF và chỉ cập nhật id của phiên đăng nhập. Lưu dữ liệu và thay/xóa ảnh cũ có kiểm soát bằng transaction/khóa dòng.
- Cột users.avatar đã thêm vào localhost, migration cho bản cũ và SQL cài mới. 9 nhóm kiểm tra đạt gồm ảnh giả/SVG/quá cỡ, phân quyền, dữ liệu lỗi, lưu không JavaScript và responsive. Dữ liệu kiểm thử riêng đã dọn.

## Thanh toán đã hoàn thành

- Chọn COD hoặc chuyển khoản BIDV khi đặt hàng. QR chứa đúng tài khoản, số tiền và mã tham chiếu riêng của đơn; tạo tại website, không phụ thuộc API tạo QR ngoài.
- Tài khoản nhận: BIDV, 8843681906, NGUYỄN NGÔ QUỐC THỊNH, theo thông tin chủ cửa hàng xác nhận.
- Khách gửi thông báo đã chuyển; admin kiểm tra giao dịch thực tế trước khi xác nhận. Đơn chuyển khoản chỉ được giao sau khi xác nhận đủ tiền. COD ghi nhận đã thu khi hoàn tất giao hàng.
- Hủy đơn đã trả tiền chuyển sang chờ hoàn tiền; admin ghi nhận sau khi hoàn thực tế. Website chưa kết nối dịch vụ đối soát/ngân hàng tự động và không tự chuyển tiền hoàn.
- Migration đã áp dụng trên localhost, bảo toàn dữ liệu cũ. SQL cài mới, bản xuất và ZIP được đồng bộ. Hướng dẫn ở PAYMENTS.md; ảnh minh họa ở deliverables/preview trong thư mục cha.

## Hosting để cập nhật sau

- Theo yêu cầu sinh viên ngày 03/11/2026, chưa triển khai hosting; phần E ghi "Chưa triển khai". Website tiếp tục chạy local với MySQL cổng 3307.
- Khi sinh viên cung cấp hosting, cập nhật cấu hình, nhập CSDL và kiểm thử HTTPS/panel/403. Hosting là phần cộng điểm, không phải điều kiện để hoàn thành A–D trên local.
- Apache XAMPP đã được kiểm tra riêng trên cổng 8089; chi tiết trong TEST_RESULTS.md.

## Cần hoàn tất trước nộp

- Website đã đổi sang giao diện sáng tham khảo ASUS ngày 03/11/2026, gồm đăng nhập/đăng ký. PDF nháp và ảnh minh chứng cũ đang thể hiện giao diện trước cập nhật; phải chụp lại và dựng báo cáo sau khi chốt giao diện. Ảnh xem nhanh mới ở deliverables/preview trong thư mục cha.
- Báo cáo cần ảnh chụp thực tế có thanh địa chỉ và tên cửa hàng, đủ 21 nhóm ảnh. Dùng nhận diện cập nhật ngày 05/11/2026: logo là ảnh chân dung sinh viên ở cạnh tên cửa hàng trên mọi trang, gồm quản trị; avatar bên phải theo tài khoản. Ảnh chân dung riêng vẫn có trong tệp bàn giao.
- Bổ sung ảnh CSDL/phpMyAdmin và ảnh sau khi hủy đơn. Bổ sung URL video thật, tài khoản chấm thử và số liệu cuối cùng; hosting để "Chưa triển khai" đến khi có địa chỉ thật.
- Bản SQL xuất hiện tại và ZIP mã nguồn đã được đồng bộ; nếu tiếp tục sửa website hoặc dữ liệu, xuất lại bằng tools/package-release.py trong thư mục cha trước khi nộp.
- Sinh viên quay video bằng giọng của mình, kiểm tra 5–10 phút và quyền xem công khai theo liên kết.

Báo cáo gốc trong thư mục cha là mẫu chưa điền; không nộp nguyên mẫu này.

Logo cập nhật: TN nét ký đen–trắng, tên Thịnh Nguyễn và dòng Technology & Accessories; đã áp dụng header/footer/favicon. Có SVG, PNG nền trong suốt và bản trắng dùng trên nền tối.

Đã thay 15 ảnh minh họa bằng ảnh sản phẩm thực tế, đổi tên/mô tả/thông số tương ứng với sự đồng ý của chủ dự án. Nguồn hãng cho 14 món, GEARVN cho USB SanDisk; ảnh WebP cục bộ và bảng nguồn ở PRODUCT_SOURCES.md. Giữ giá demo, tồn kho, ID, tài khoản, đơn hàng và tên/giá đã chụp tại lúc đặt.

Đã thay banner góc làm việc và hai ô bàn phím/âm thanh bằng ảnh thực tế Logitech/Keychron; ảnh tải về nội bộ, có nguồn, WebP và phiên bản banner 800px cho mobile.

## Kịch bản quay mới 05/11/2026

Đã thay VIDEO_SCRIPT.md bằng lượt FINAL01 dự kiến 9:35 theo đề 5–10 phút: email mới, hai đơn mới tạo ngay trong video (bank/hủy và COD/giao/hoàn tất), không xóa dữ liệu đã test. Kèm lời thuyết minh, đường đi UI, dòng checkout/cancel, bảng nhắc và dữ liệu/ảnh chọn nhanh ở deliverables/QUAY_VIDEO_FINAL01 trong thư mục cha. Chưa quay video; cần sinh viên tập, ghi hình và cung cấp URL trước khi hoàn thiện báo cáo.
