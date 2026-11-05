# Định hướng giao diện

Chủ dự án: Nguyễn Ngô Quốc Thịnh. Thương hiệu Cửa hàng Công Nghệ Thịnh Nguyễn.

- Thiết kế cập nhật 03/11/2026 theo tham khảo trực tiếp trang chủ, đăng nhập và đăng ký ASUS. Nền trắng #FFFFFF, nền phụ #F4F5F7, nút/liên kết xanh #1762C4, chữ #20242B. Logo TN nét ký đơn sắc đen–trắng làm nhận diện riêng theo ảnh phong cách do chủ dự án cung cấp.
- Font: Segoe UI / Arial, hỗ trợ tiếng Việt, không phụ thuộc mạng ngoài.
- Trang chủ: header hai tầng, banner rộng nền sáng với ảnh góc làm việc thật, hai bảng giới thiệu theo nhu cầu, tìm kiếm, danh mục, sắp xếp, lưới Grid, phân trang. Khi lọc/tìm kiếm/sang trang, tập trung hiển thị danh sách sản phẩm.
- Lưới: 4 cột trên 1100px, 3 cột 901–1100px, 2 cột 501–900px, 1 cột tối đa 500px.
- Header dùng ảnh chân dung Nguyễn Ngô Quốc Thịnh làm logo cạnh tên cửa hàng trên mọi trang, kể cả quản trị và điện thoại. Góc phải hiển thị avatar của tài khoản đang đăng nhập. Khách chưa đăng nhập thấy biểu tượng tài khoản chung dẫn đến đăng nhập.
- Đăng nhập: khung trắng hai cột, minh họa tài khoản và ba lợi ích bên trái; biểu mẫu bên phải. Điện thoại hiển thị biểu mẫu tập trung. Đăng ký: khung giữa trang, trường thông tin chia cột trên desktop, một cột trên mobile; điều khoản có thể mở đọc.
- Nút hiện/ẩn mật khẩu có nhãn hỗ trợ đọc màn hình và bàn phím. Cho phép dán và dùng trình quản lý mật khẩu; autocomplete phù hợp. Menu điện thoại mở/đóng, Escape trả focus về nút menu; không có carousel tự chạy.
- Hồ sơ cá nhân chia hai vùng ảnh đại diện và thông tin; trên điện thoại xếp một cột. Có xem trước cục bộ, bỏ ảnh vừa chọn, xóa ảnh đã lưu và phản hồi sau khi lưu. Lỗi có nhãn theo trường, giữ nội dung nhập và đưa focus vào bảng lỗi có liên kết tới trường. Avatar khách ở góc phải header; thiếu ảnh dùng chữ viết tắt tên.
- Bấm avatar mở menu Tài khoản của tôi/Đơn hàng của tôi/Đăng xuất và Quản trị cửa hàng nếu có quyền. Không còn liên kết Tài khoản riêng ở hàng điều hướng. Menu dùng details/summary, có nhãn tên chủ tài khoản, hỗ trợ Escape/Enter/Space/ArrowDown và đóng khi bấm hoặc chuyển focus ra ngoài; nằm gọn trong màn hình mobile.
- Banner góc làm việc, ảnh bàn phím Keychron K8 và tai nghe Logitech Zone Vibe 100 dùng ảnh thực tế từ trang hãng, lưu WebP cục bộ. SVG cũ giữ làm tài nguyên tham khảo; minh họa trang tài khoản vẫn dùng SVG riêng. Không sao chép logo/hình ảnh ASUS.
- CSS thống nhất cho cửa hàng, tài khoản và quản trị; focus rõ, tôn trọng prefers-reduced-motion, bảng cuộn trong khung trên mobile.
- Thêm vào giỏ xử lý tại chỗ, không đổi URL/vị trí cuộn/bộ lọc. Thông báo ở góc trên bên phải màn hình có nội dung thành công hoặc lỗi, nút đóng và Xem giỏ hàng; số lượng/nhãn giỏ được cập nhật từ máy chủ. Vô hiệu hóa nút thêm trong lúc chờ để tránh thao tác trùng. Thông báo có role=status, không tự lấy focus, tự ẩn sau 2 giây; tạm dừng khi rê chuột hoặc focus bên trong và đếm lại sau khi rời. Mỗi thông báo mới đặt lại bộ đếm.
- Checkout có hai lựa chọn radio COD/chuyển khoản, nhãn và mô tả rõ; dùng được bằng bàn phím. Chi tiết đơn chuyển khoản đặt QR cạnh số tiền và thông tin BIDV; trên điện thoại chuyển thành một cột. Có tải QR, sao chép số tài khoản/nội dung và phản hồi đọc được bằng trình đọc màn hình. Trạng thái thanh toán có cả chữ và màu; nút thông báo chuyển khoản giải thích rõ shop sẽ đối soát.
- Logo chính: ảnh chân dung có sẵn assets/anh_chan_dung.jpg, hiển thị tròn cạnh tên cửa hàng tại header và footer, gồm trang quản trị. Favicon dùng favicon-portrait.png và favicon-portrait.ico tạo từ cùng ảnh chân dung. Tài nguyên TN cũ giữ làm tham khảo, không dùng ở giao diện hiện tại. Trên điện thoại giữ cả chân dung và tên cửa hàng.
- Tham khảo tinh thần trình bày thiết bị của ASUS và cách phân nhóm cửa hàng công nghệ; giao diện tự xây bằng CSS thuần.

- Danh mục dùng 15 ảnh sản phẩm thực tế từ trang sản phẩm hãng/GEARVN; ảnh WebP 1100 × 1100, nền trắng, giữ nguyên hình dạng và dấu hiệu nhận diện. Chỉ cắt lề trắng ngoài, thu phóng và căn giữa, không tạo ảnh giả bằng AI. Tên và thông số khớp mẫu trong ảnh, nguồn lưu tại PRODUCT_SOURCES.md. Banner ảnh thật mang tính giới thiệu không gian/sản phẩm; nguồn riêng ở assets/photos/sources.json.

- Banner desktop giữ chữ tối trên vùng sáng, ảnh thật bên phải hòa nền; mobile xếp chữ và ảnh thành hai phần, tránh chữ chồng ảnh. Hai ô danh mục dùng ảnh tối và gradient để chữ trắng rõ; ảnh tai nghe hiển thị contain để không mất sản phẩm khi khung hẹp.

- Trang Giới thiệu: banner hai vùng chữ/ảnh góc máy thật, câu chuyện thương hiệu cạnh ảnh sử dụng tai nghe, bốn liên kết danh mục có ảnh thiết bị thật, ba lợi ích mua sắm và vùng liên hệ. Giữ tông trắng–xanh, khoảng cách thoáng, không dùng số liệu khách hàng hay cam kết thương mại chưa xác thực. Mobile xếp banner/câu chuyện/liên hệ một cột, danh mục hai cột; thông tin đồ án đặt cuối nội dung. CSS trong nhóm about được giới hạn riêng, không thay đổi trang Liên hệ.


Cập nhật nhận diện 05/11/2026: theo xác nhận mới nhất của sinh viên sau khi hỏi lại giảng viên, logo cửa hàng phải là ảnh chân dung Nguyễn Ngô Quốc Thịnh. Header và footer mọi trang, gồm quản trị, dùng assets/anh_chan_dung.jpg; tên cửa hàng luôn hiển thị cả trên điện thoại. Avatar tài khoản vẫn thay đổi theo người đăng nhập. Video và ảnh minh chứng cần dùng giao diện mới này; nội dung chốt logo TN ngày 04/11 đã được thay thế.
