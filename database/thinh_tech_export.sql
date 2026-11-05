-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: thinh_tech
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (2,'Âm thanh và hình ảnh'),(1,'Chuột và bàn phím'),(3,'Lưu trữ và kết nối'),(4,'Phụ kiện góc máy');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
INSERT INTO `contacts` VALUES (3,'Trần Minh Anh','khachhang1@thinhtech.local','Tư vấn thiết bị cho góc học tập','Tôi muốn được tư vấn bàn phím và chuột cho góc học tập.','2026-11-03 07:23:18'),(11,'Nguyễn Ngô Quốc Thịnh','khachhang1@thinhtech.local','Tư vấn bàn phím Keychron K8`','Em muốn tìm hiểu kết nối của bàn phím Keychron K8.','2026-11-05 00:22:47');
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `price` int(10) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_order_items_order` (`order_id`),
  KEY `fk_order_items_product` (`product_id`),
  CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `fk_order_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,2,'Bàn phím cơ TN K2',790000,1),(2,1,9,'USB 64GB TN U4',150000,1),(3,2,5,'Tai nghe Bluetooth TN T3',450000,1),(4,2,6,'Webcam Full HD TN W5',520000,1),(5,3,10,'SSD di động TN S1',1290000,1),(6,4,1,'Chuột không dây TN M1',259000,1),(7,4,12,'Cáp sạc nhanh TN Flex',129000,1),(8,5,13,'Đế tản nhiệt laptop TN D6',320000,1),(9,5,11,'Hub USB-C TN Hub',349000,1),(16,12,1,'Chuột không dây TN M1',259000,1),(22,18,1,'Chuột không dây TN M1',259000,1),(23,19,1,'Chuột không dây TN M1',259000,1),(29,25,1,'Chuột không dây TN M1',259000,1),(31,27,3,'Bộ keycap TN Studio',390000,1),(32,28,1,'Chuột không dây TN M1',259000,1),(38,34,2,'Bàn phím cơ TN K2',790000,1),(39,35,1,'Chuột không dây Logitech M330 Silent Plus',259000,1),(40,36,6,'Webcam Logitech C920s Pro Full HD',520000,1);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `note` varchar(500) NOT NULL DEFAULT '',
  `total` int(10) unsigned NOT NULL,
  `status` enum('pending','shipping','completed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `payment_method` enum('cod','bank_transfer') NOT NULL DEFAULT 'cod',
  `payment_status` enum('unpaid','reported','paid','refund_pending','refunded') NOT NULL DEFAULT 'unpaid',
  `payment_reference` varchar(40) DEFAULT NULL,
  `payment_bank_bin` varchar(6) DEFAULT NULL,
  `payment_bank_name` varchar(100) DEFAULT NULL,
  `payment_account_number` varchar(34) DEFAULT NULL,
  `payment_account_name` varchar(100) DEFAULT NULL,
  `payment_reported_at` datetime DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `payment_confirmed_by` int(10) unsigned DEFAULT NULL,
  `refunded_at` datetime DEFAULT NULL,
  `refund_confirmed_by` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payment_reference` (`payment_reference`),
  KEY `fk_orders_user` (`user_id`),
  CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,2,'Trần Minh Anh','0901234567','Quận 1, TP. Hồ Chí Minh','',940000,'pending','2026-11-03 07:03:39','cod','unpaid',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,2,'Trần Minh Anh','0901234567','Quận 1, TP. Hồ Chí Minh','',970000,'shipping','2026-11-03 07:03:39','cod','unpaid',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,3,'Lê Gia Huy','0907654321','Thủ Đức, TP. Hồ Chí Minh','',1290000,'completed','2026-11-03 07:03:39','cod','paid',NULL,NULL,NULL,NULL,NULL,NULL,'2026-11-03 07:03:39',NULL,NULL,NULL),(4,3,'Lê Gia Huy','0907654321','Thủ Đức, TP. Hồ Chí Minh','',388000,'cancelled','2026-11-03 07:03:39','cod','unpaid',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,2,'Trần Minh Anh','0901234567','Quận 1, TP. Hồ Chí Minh','',669000,'completed','2026-11-03 07:03:39','cod','paid',NULL,NULL,NULL,NULL,NULL,NULL,'2026-11-03 07:03:39',NULL,NULL,NULL),(12,1,'Nguyễn Ngô Quốc Thịnh','0343180715','80/15B Hoàng Hoa Thám, Bình Thạnh, TP. Hồ Chí Minh','',259000,'cancelled','2026-11-03 11:10:15','cod','unpaid',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(18,10,'Nguyễn Tấn Du','0000000000','Hồng Ngự, Đồng tháp','',259000,'cancelled','2026-11-03 11:35:37','bank_transfer','reported','TN000018','970418','BIDV','8843681906','NGUYỄN NGÔ QUỐC THỊNH','2026-11-03 11:36:10',NULL,NULL,NULL,NULL),(19,10,'Nguyễn Tấn Du','0000000000','Hồng Ngự, đông tháp','',259000,'pending','2026-11-03 11:37:49','bank_transfer','unpaid','TN000019','970418','BIDV','8843681906','NGUYỄN NGÔ QUỐC THỊNH',NULL,NULL,NULL,NULL,NULL),(25,10,'Nguyễn Tấn Du','0000000000','Hồng Ngự, Đồng tháp','',259000,'pending','2026-11-03 12:14:32','bank_transfer','unpaid','TN000025','970418','BIDV','8843681906','NGUYỄN NGÔ QUỐC THỊNH',NULL,NULL,NULL,NULL,NULL),(27,10,'Nguyễn Tấn Du','0000000000','Hồng Ngự, Đồng tháp','',390000,'cancelled','2026-11-03 12:29:01','cod','unpaid',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(28,10,'Nguyễn Tấn Du','0000000000','Hồng Ngự, Đồng tháp','',259000,'pending','2026-11-03 12:29:16','bank_transfer','unpaid','TN000028','970418','BIDV','8843681906','NGUYỄN NGÔ QUỐC THỊNH',NULL,NULL,NULL,NULL,NULL),(34,10,'Nguyễn Tấn Du','0000000000','Hồng Ngự, Đồng tháp','',790000,'cancelled','2026-11-03 15:30:51','bank_transfer','reported','TN000034','970418','BIDV','8843681906','NGUYỄN NGÔ QUỐC THỊNH','2026-11-03 15:31:47',NULL,NULL,NULL,NULL),(35,10,'Nguyễn Tấn Du','0000000000','Hồng Ngự, Đồng tháp','',259000,'pending','2026-11-03 19:28:03','bank_transfer','unpaid','TN000035','970418','BIDV','8843681906','NGUYỄN NGÔ QUỐC THỊNH',NULL,NULL,NULL,NULL,NULL),(36,2,'Trần Minh Anh','0901234567','Quận 1, TP. Hồ Chí Minh','Đơn minh họa quay báo cáo',520000,'cancelled','2026-11-04 23:26:18','cod','unpaid',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `name` varchar(200) NOT NULL,
  `price` int(10) unsigned NOT NULL,
  `description` text DEFAULT NULL,
  `specifications` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`specifications`)),
  `image` varchar(255) NOT NULL,
  `stock` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_products_category` (`category_id`),
  CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,'Chuột không dây Logitech M330 Silent Plus',259000,'Chuột không dây Logitech M330 Silent Plus màu đen, thiết kế dành cho tay phải. Công nghệ SilentTouch giảm tiếng nhấp chuột, phù hợp góc học tập và văn phòng.','{\"Thương hiệu\": \"Logitech\", \"Model\": \"M330 Silent Plus\", \"Kết nối\": \"Không dây qua đầu thu USB\", \"Công nghệ\": \"SilentTouch, giảm hơn 90% tiếng nhấp chuột theo hãng\", \"Pin\": \"Lên đến 18 tháng tùy cách sử dụng\", \"Màu sắc\": \"Đen\"}','images/products/logitech-m330-silent-plus.webp',16,'2026-11-03 07:03:39'),(2,1,'Bàn phím cơ Keychron K8',790000,'Bàn phím cơ Keychron K8 bố cục TKL gọn gàng, hỗ trợ kết nối Bluetooth và cáp USB-C. Thiết kế phù hợp làm việc, học tập và sử dụng cùng Windows hoặc macOS.','{\"Thương hiệu\": \"Keychron\", \"Model\": \"K8\", \"Bố cục\": \"TKL, 87 phím (ANSI)\", \"Kết nối\": \"Bluetooth 5.1 và USB-C có dây\", \"Kết nối đa thiết bị\": \"Tối đa 3 thiết bị qua Bluetooth\", \"Dung lượng pin\": \"4000 mAh\"}','images/products/keychron-k8.webp',15,'2026-11-03 07:03:39'),(3,1,'Bộ keycap Keychron OSA PBT Blue & White',390000,'Bộ keycap Keychron chất liệu PBT, ký tự double-shot, profile OSA và phối xanh trắng. Dùng để thay keycap trên bàn phím cơ có switch chuẩn MX tương thích; sản phẩm là bộ keycap, không kèm bàn phím.','{\"Thương hiệu\": \"Keychron\", \"Dòng sản phẩm\": \"Double Shot PBT OSA Full Set\", \"Chất liệu\": \"PBT double-shot\", \"Profile\": \"OSA\", \"Phiên bản\": \"Full Set 141 phím, Blue and White\", \"Tương thích\": \"Switch cơ chân chữ thập MX, chiều cao thông thường\"}','images/products/keychron-osa-pbt-blue-white.webp',12,'2026-11-03 07:03:39'),(4,1,'Bàn di chuột Logitech Desk Mat Studio Series',159000,'Tấm lót bàn Logitech Desk Mat Studio Series màu xám, bề mặt mềm cho chuột di chuyển mượt. Đế chống trượt, mép chống tưa và bề mặt kháng nước đổ giúp góc làm việc gọn gàng.','{\"Thương hiệu\": \"Logitech\", \"Dòng sản phẩm\": \"Desk Mat Studio Series\", \"Màu sắc\": \"Mid Grey\", \"Bề mặt\": \"Vải mềm, kháng nước đổ\", \"Đế\": \"Chống trượt\", \"Mép viền\": \"Chống tưa\"}','images/products/logitech-desk-mat-studio-grey.webp',25,'2026-11-03 07:03:39'),(5,2,'Tai nghe Bluetooth Logitech Zone Vibe 100',450000,'Tai nghe chụp tai không dây Logitech Zone Vibe 100 màu graphite, có micro gập để tắt tiếng. Bluetooth đa điểm và driver 40 mm phù hợp nghe nhạc, họp và học trực tuyến.','{\"Thương hiệu\": \"Logitech\", \"Model\": \"Zone Vibe 100\", \"Kết nối\": \"Bluetooth đa điểm\", \"Driver\": \"40 mm\", \"Thời lượng nghe\": \"Lên đến 20 giờ tùy điều kiện sử dụng\", \"Thời lượng đàm thoại\": \"Lên đến 18 giờ\", \"Màu sắc\": \"Graphite\"}','images/products/logitech-zone-vibe-100.webp',18,'2026-11-03 07:03:39'),(6,2,'Webcam Logitech C920s Pro Full HD',520000,'Webcam Logitech C920s Pro với video Full HD 1080p, hai micro thu âm stereo và nắp che riêng tư. Ống kính tự động lấy nét, hỗ trợ điều chỉnh ánh sáng cho cuộc họp và lớp học trực tuyến.','{\"Thương hiệu\": \"Logitech\", \"Model\": \"C920s Pro HD\", \"Độ phân giải\": \"1920 × 1080, 30 fps\", \"Góc nhìn chéo\": \"78°\", \"Micro\": \"Hai micro stereo tích hợp\", \"Riêng tư\": \"Nắp che ống kính\"}','images/products/logitech-c920s.webp',10,'2026-11-03 07:03:39'),(7,2,'Loa Bluetooth Logitech Z207',620000,'Bộ loa máy tính Logitech Z207 màu đen gồm hai loa stereo. Kết nối Bluetooth hoặc ngõ vào 3,5 mm, chuyển đổi giữa thiết bị bằng Easy-Switch; loa sử dụng nguồn điện ngoài.','{\"Thương hiệu\": \"Logitech\", \"Model\": \"Z207\", \"Cấu hình\": \"2.0 stereo\", \"Công suất\": \"5 W RMS, 10 W đỉnh\", \"Kết nối\": \"Bluetooth và ngõ vào 3,5 mm\", \"Tính năng\": \"Easy-Switch giữa hai thiết bị Bluetooth\"}','images/products/logitech-z207.webp',14,'2026-11-03 07:03:39'),(8,2,'Micro USB Logitech G Snowball iCE',690000,'Micro USB Logitech G Snowball iCE màu đen, thu âm condenser với hướng thu cardioid. Kết nối plug-and-play và chân đế bàn đi kèm phù hợp ghi âm giọng nói, họp hoặc streaming.','{\"Thương hiệu\": \"Logitech G\", \"Model\": \"Snowball iCE\", \"Loại micro\": \"Condenser\", \"Hướng thu\": \"Cardioid\", \"Kết nối\": \"USB, plug-and-play\", \"Màu sắc\": \"Đen\"}','images/products/logitech-snowball-ice.webp',9,'2026-11-03 07:03:39'),(9,3,'USB SanDisk Ultra Dual Drive Luxe 64GB',150000,'USB SanDisk Ultra Dual Drive Luxe dung lượng 64GB, vỏ kim loại với đầu USB Type-A và Type-C. Thiết kế xoay giúp chuyển dữ liệu giữa máy tính và thiết bị USB-C tương thích.','{\"Thương hiệu\": \"SanDisk\", \"Model\": \"SDDDC4-064G-G46\", \"Dung lượng\": \"64GB\", \"Kết nối\": \"USB Type-C và Type-A, USB 3.1 Gen 1\", \"Tốc độ đọc\": \"Lên đến 150 MB/s theo nguồn sản phẩm\", \"Chất liệu\": \"Kim loại, màu bạc\"}','images/products/sandisk-ultra-dual-drive-luxe-64gb.webp',50,'2026-11-03 07:03:39'),(10,3,'SSD di động Samsung T7 500GB Đỏ',1290000,'SSD di động Samsung T7 dung lượng 500GB, phiên bản màu đỏ MU-PC500R/WW. Kết nối USB 3.2 Gen 2, tốc độ đọc lên đến 1.050 MB/s và ghi lên đến 1.000 MB/s trong điều kiện phù hợp.','{\"Thương hiệu\": \"Samsung\", \"Model\": \"MU-PC500R/WW\", \"Dung lượng\": \"500GB\", \"Kết nối\": \"USB 3.2 Gen 2, USB-C\", \"Tốc độ đọc/ghi tối đa\": \"1.050 / 1.000 MB/s\", \"Màu sắc\": \"Đỏ\"}','images/products/samsung-t7-500gb-red.webp',8,'2026-11-03 07:03:39'),(11,3,'Hub USB-C Anker 341 7-in-1',349000,'Hub USB-C Anker 341 (A8346) mở rộng laptop với HDMI, USB-A, USB-C và khe SD/microSD. Hỗ trợ HDMI 4K 30Hz và sạc truyền tiếp; cần thiết bị chủ hỗ trợ xuất hình qua USB-C để dùng HDMI.','{\"Thương hiệu\": \"Anker\", \"Model\": \"341 (A8346)\", \"Số cổng\": \"7 trong 1\", \"HDMI\": \"Tối đa 4K 30Hz\", \"USB-A\": \"2 cổng USB 3.0, tối đa 5 Gbps\", \"Sạc truyền tiếp\": \"Đầu vào PD 100 W, tối đa 85 W cho laptop\", \"Khe thẻ nhớ\": \"SD và microSD\"}','images/products/anker-341-7-in-1.webp',22,'2026-11-03 07:03:39'),(12,3,'Cáp Anker New Nylon USB-C 100W 3m',129000,'Cáp Anker New Nylon USB-C to USB-C A8758 bọc nylon, chiều dài 10 ft (khoảng 3 m). Hỗ trợ sạc tối đa 100W và truyền dữ liệu USB 2.0; công suất thực tế phụ thuộc bộ sạc và thiết bị.','{\"Thương hiệu\": \"Anker\", \"Model\": \"A8758, New Nylon USB-C to USB-C\", \"Chiều dài\": \"10 ft, khoảng 3 m\", \"Công suất sạc\": \"Tối đa 100 W\", \"Truyền dữ liệu\": \"Tối đa 480 Mbps\", \"Vật liệu\": \"Dây bọc nylon, chip e-Marker\"}','images/products/anker-new-nylon-usbc-100w.webp',30,'2026-11-03 07:03:39'),(13,4,'Đế tản nhiệt DeepCool Multi Core X6',320000,'Đế tản nhiệt laptop DeepCool Multi Core X6 thiết kế bốn quạt bố trí dạng cánh bướm. Có hai quạt 140 mm và hai quạt 100 mm, sử dụng nguồn USB 5V cho góc làm việc.','{\"Thương hiệu\": \"DeepCool\", \"Model\": \"Multi Core X6, DP-N422-MCX6\", \"Số quạt\": \"4: 2 × 140 mm và 2 × 100 mm\", \"Kích thước\": \"380 × 295 × 24 mm\", \"Khối lượng\": \"900 g\", \"Nguồn\": \"5V DC\"}','images/products/deepcool-multi-core-x6.webp',11,'2026-11-03 07:03:39'),(14,4,'Đèn màn hình BenQ ScreenBar',490000,'Đèn treo màn hình BenQ ScreenBar với thiết kế chiếu sáng bất đối xứng giúp hạn chế phản chiếu trên màn hình. Điều chỉnh nhiệt độ màu, tự động cân bằng độ sáng và kẹp gắn giúp tiết kiệm diện tích bàn.','{\"Thương hiệu\": \"BenQ\", \"Model\": \"ScreenBar\", \"Nhiệt độ màu\": \"2700–6500 K\", \"Điều chỉnh\": \"Độ sáng và nhiệt độ màu\", \"Tính năng\": \"Tự động điều chỉnh ánh sáng môi trường\", \"Lắp đặt\": \"Kẹp trên màn hình\"}','images/products/benq-screenbar.webp',7,'2026-11-03 07:03:39'),(15,4,'Giá đỡ tai nghe Corsair ST100 RGB',220000,'Giá đỡ tai nghe Corsair ST100 RGB với khung nhôm và đèn RGB điều khiển bằng iCUE. Tích hợp hai cổng USB-A cùng ngõ âm thanh 3,5 mm hỗ trợ âm thanh vòm ảo 7.1 theo cấu hình tương thích.','{\"Thương hiệu\": \"Corsair\", \"Model\": \"ST100 RGB, CA-9011167-NA\", \"Chất liệu\": \"Nhôm\", \"Cổng USB\": \"2 × USB 3.1 Gen 1 Type-A\", \"Âm thanh\": \"Ngõ 3,5 mm, hỗ trợ vòm ảo 7.1\", \"Đèn\": \"RGB, phần mềm Corsair iCUE\"}','images/products/corsair-st100-rgb.webp',16,'2026-11-03 07:03:39');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL DEFAULT '',
  `avatar` varchar(255) DEFAULT NULL,
  `role` enum('customer','admin') NOT NULL DEFAULT 'customer',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Nguyễn Ngô Quốc Thịnh','nguyenngothinh669@gmail.com','$2y$10$TniQZv.JC74hXT.felBLluAe44Ot1LPrPTnuYk24d.se2ZUiUt7qi','0343180715','80/15B Hoàng Hoa Thám, Bình Thạnh, TP. Hồ Chí Minh',NULL,'admin','2026-11-03 07:03:39'),(2,'Trần Minh Anh','khachhang1@thinhtech.local','$2y$10$TniQZv.JC74hXT.felBLluAe44Ot1LPrPTnuYk24d.se2ZUiUt7qi','0901234567','Quận 1, TP. Hồ Chí Minh',NULL,'customer','2026-11-03 07:03:39'),(3,'Lê Gia Huy','khachhang2@thinhtech.local','$2y$10$TniQZv.JC74hXT.felBLluAe44Ot1LPrPTnuYk24d.se2ZUiUt7qi','0907654321','Thủ Đức, TP. Hồ Chí Minh',NULL,'customer','2026-11-03 07:03:39'),(10,'Nguyễn Tấn Du','desshawn@gmail.com','$2y$10$T6571W2IQhn6PFAl1GW7E.rL6BH8Op3e8OU7i0gZ/0oCKHDgUrDOy','0000000000','Hồng Ngự, Đồng tháp','uploads/avatars/6530d8e99f974cb880fdfc6e7afb48b4.png','customer','2026-11-03 11:26:39');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'thinh_tech'
--

--
-- Dumping routines for database 'thinh_tech'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-05  9:37:09
