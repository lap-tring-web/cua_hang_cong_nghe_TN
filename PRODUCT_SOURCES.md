# Nguồn ảnh và thông số sản phẩm

Đối chiếu ngày 03/11/2026. Ảnh sản phẩm thật lấy từ hãng; USB SanDisk dùng nguồn bán lẻ GEARVN. Chỉ thu nhỏ và đặt ảnh trên nền trắng, không dùng AI tạo ảnh sản phẩm. Ảnh lưu cục bộ ở images/products; chi tiết URL ảnh, kích thước và SHA-256 ở database/real-products.json.

Giá bán và tồn kho giữ nguyên dữ liệu demo đã có, không phải báo giá hiện hành của hãng. Các thương hiệu/hình ảnh thuộc chủ sở hữu tương ứng; nguồn công khai không đồng nghĩa với giấy phép sử dụng thương mại. Lịch sử đơn hàng lưu tên và giá tại thời điểm đặt, không đổi theo danh mục mới.

| ID | Mẫu sản phẩm | Nguồn đối chiếu |
|---|---|---|
| 1 | Chuột không dây Logitech M330 Silent Plus | [Trang sản phẩm](https://www.logitech.com/en-us/shop/p/m330-silent-plus-mouse) |
| 2 | Bàn phím cơ Keychron K8 | [Trang sản phẩm](https://www.keychron.com/products/keychron-k8-tenkeyless-wireless-mechanical-keyboard) |
| 3 | Bộ keycap Keychron OSA PBT Blue & White | [Trang sản phẩm](https://www.keychron.com/products/double-shot-pbt-osa-full-set-keycap-set) |
| 4 | Bàn di chuột Logitech Desk Mat Studio Series | [Trang sản phẩm](https://www.logitech.com/en-us/shop/p/desk-mat-studio-series) |
| 5 | Tai nghe Bluetooth Logitech Zone Vibe 100 | [Trang sản phẩm](https://www.logitech.com/en-us/shop/p/zone-vibe-100-wireless) |
| 6 | Webcam Logitech C920s Pro Full HD | [Trang sản phẩm](https://www.logitech.com/en-us/shop/p/c920s-pro-hd-webcam) |
| 7 | Loa Bluetooth Logitech Z207 | [Trang sản phẩm](https://www.logitech.com/en-us/shop/p/z207-stereo-speakers-bluetooth) |
| 8 | Micro USB Logitech G Snowball iCE | [Trang sản phẩm](https://www.logitechg.com/en-us/shop/p/snowball-ice-usb-microphone) |
| 9 | USB SanDisk Ultra Dual Drive Luxe 64GB | [Trang sản phẩm](https://gearvn.com/products/usb-3-1-sandisk-ultra-dual-drive-luxe-otg-type-c-ddc4-64gb) |
| 10 | SSD di động Samsung T7 500GB Đỏ | [Trang sản phẩm](https://www.samsung.com/vn/memory-storage/portable-ssd/t7-500gb-red-external-storage-nvme-1050-mb-s-mu-pc500r-ww/) |
| 11 | Hub USB-C Anker 341 7-in-1 | [Trang sản phẩm](https://www.anker.com/products/a8346) |
| 12 | Cáp Anker New Nylon USB-C 100W 3m | [Trang sản phẩm](https://www.anker.com/products/a8758) |
| 13 | Đế tản nhiệt DeepCool Multi Core X6 | [Trang sản phẩm](https://www.deepcool.com/products/Cooling/laptopcoolers/2021/11399.shtml) |
| 14 | Đèn màn hình BenQ ScreenBar | [Trang sản phẩm](https://www.benq.com/en-us/lighting/monitor-light/screenbar.html) |
| 15 | Giá đỡ tai nghe Corsair ST100 RGB | [Trang sản phẩm](https://www.corsair.com/us/en/p/gaming-gear-accessories/ca-9011167-na/st100-rgb-premium-headset-stand-with-7-1-surround-sound-ca-9011167-na) |

## Ảnh banner trang chủ

Banner góc làm việc và ảnh tai nghe từ Logitech, ảnh bàn phím Keychron K8 từ Keychron. Ảnh chụp thực tế lưu trong `assets/photos`, chỉ thu nhỏ/chuyển WebP và hiển thị cắt theo khung responsive. URL gốc, trang nguồn và SHA-256 ở `assets/photos/sources.json`.

| Vị trí | Nguồn |
|---|---|
| Góc máy mới | [Logitech Desk Mat Studio Series](https://www.logitech.com/en-us/shop/p/desk-mat-studio-series) |
| Bàn phím & chuột | [Keychron K8](https://www.keychron.com/products/keychron-k8-tenkeyless-wireless-mechanical-keyboard) |
| Khám phá âm thanh | [Logitech Zone Vibe 100](https://www.logitech.com/en-us/shop/p/zone-vibe-100-wireless) |

## Ảnh trang Giới thiệu

`about-desk.webp` dùng ảnh nhìn từ trên xuống của góc bàn với Logitech Desk Mat Studio Series; `about-everyday.webp` dùng ảnh sử dụng tai nghe Logitech Zone Vibe 100 trong không gian làm việc. Đây là ảnh giới thiệu trải nghiệm thiết bị, không phải ảnh cửa hàng hay nhân viên. Nguồn ảnh và SHA-256 nằm trong `assets/photos/sources.json`; xuất WebP bằng `tools/prepare-home-photos.py`. Bốn ô danh mục sử dụng lại ảnh sản phẩm thực tế đã liệt kê ở trên.
