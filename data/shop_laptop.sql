-- =========================================================
-- Database: shop_laptop
-- Tạo database mới và chuyển toàn bộ sang shop_laptop
-- =========================================================

DROP DATABASE IF EXISTS `shop_laptop`;
CREATE DATABASE IF NOT EXISTS `shop_laptop` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `shop_laptop`;

-- =========================================================
-- 1. Bảng người dùng (giữ nguyên cấu trúc cũ + thêm avatar)
-- =========================================================
CREATE TABLE `nguoidung` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) DEFAULT NULL,
  `sodienthoai` VARCHAR(15) NOT NULL,
  `matkhau` VARCHAR(255) NOT NULL,
  `hoten` VARCHAR(255) NOT NULL,
  `loai` TINYINT(4) NOT NULL DEFAULT 3 COMMENT '1=Admin, 2=Nhân viên, 3=Khách hàng',
  `trangthai` TINYINT(4) NOT NULL DEFAULT 1 COMMENT '1=Hoạt động, 0=Khóa',
  `hinhanh` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `sodienthoai` (`sodienthoai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- 2. Địa chỉ giao hàng của khách
-- =========================================================
CREATE TABLE `diachi` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nguoidung_id` INT(11) NOT NULL,
  `diachi` VARCHAR(500) NOT NULL,
  `macdinh` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `nguoidung_id` (`nguoidung_id`),
  CONSTRAINT `diachi_ibfk_1` FOREIGN KEY (`nguoidung_id`) REFERENCES `nguoidung` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- 3. Hãng laptop (Dell, Asus, MSI, Apple, Lenovo...)
-- =========================================================
CREATE TABLE `hang` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `tenhang` VARCHAR(100) NOT NULL,
  `logo` VARCHAR(255) DEFAULT NULL,
  `mota` TEXT DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- 4. Dòng máy (Series): ROG Strix, Legion 5, MacBook Pro...
-- =========================================================
CREATE TABLE `dongmay` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `hang_id` INT(11) NOT NULL,
  `tendong` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hang_id` (`hang_id`),
  CONSTRAINT `dongmay_ibfk_1` FOREIGN KEY (`hang_id`) REFERENCES `hang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- 5. Mục đích sử dụng (Gaming, Văn phòng, Đồ họa, Học tập...)
-- =========================================================
CREATE TABLE `mucdich` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `tenmucdich` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- 6. Sản phẩm Laptop (mathang → laptop)
-- =========================================================
CREATE TABLE `laptop` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `tenlaptop` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `hang_id` INT(11) NOT NULL,
  `dongmay_id` INT(11) DEFAULT NULL,
  `cpu` VARCHAR(150) DEFAULT NULL,
  `ram` VARCHAR(50) DEFAULT NULL,
  `o_cung` VARCHAR(100) DEFAULT NULL,
  `card_man_hinh` VARCHAR(150) DEFAULT NULL,
  `man_hinh` VARCHAR(100) DEFAULT NULL,
  `trong_luong` VARCHAR(50) DEFAULT NULL,
  `pin` VARCHAR(100) DEFAULT NULL,
  `cong_ket_noi` TEXT DEFAULT NULL,
  `he_dieu_hanh` VARCHAR(100) DEFAULT NULL,
  `mota_chitiet` LONGTEXT DEFAULT NULL,
  `giagoc` DECIMAL(15,2) NOT NULL DEFAULT 0,
  `giaban` DECIMAL(15,2) NOT NULL DEFAULT 0,
  `soluongton` INT(11) NOT NULL DEFAULT 0,
  `luotxem` INT(11) NOT NULL DEFAULT 0,
  `luotmua` INT(11) NOT NULL DEFAULT 0,
  `noibat` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1 = laptop nổi bật',
  `khuyenmai` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1 = đang khuyến mãi',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `hang_id` (`hang_id`),
  KEY `dongmay_id` (`dongmay_id`),
  CONSTRAINT `laptop_ibfk_1` FOREIGN KEY (`hang_id`) REFERENCES `hang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `laptop_ibfk_2` FOREIGN KEY (`dongmay_id`) REFERENCES `dongmay` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- 7. Nhiều ảnh cho mỗi laptop
-- =========================================================
CREATE TABLE `laptop_hinhanh` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `laptop_id` INT(11) NOT NULL,
  `hinhanh` VARCHAR(255) NOT NULL,
  `anhchinh` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1 = ảnh chính',
  PRIMARY KEY (`id`),
  KEY `laptop_id` (`laptop_id`),
  CONSTRAINT `laptop_hinhanh_ibfk_1` FOREIGN KEY (`laptop_id`) REFERENCES `laptop` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- 8. Laptop thuộc nhiều mục đích (gaming, đồ họa...)
-- =========================================================
CREATE TABLE `laptop_mucdich` (
  `laptop_id` INT(11) NOT NULL,
  `mucdich_id` INT(11) NOT NULL,
  PRIMARY KEY (`laptop_id`,`mucdich_id`),
  KEY `mucdich_id` (`mucdich_id`),
  CONSTRAINT `laptop_mucdich_ibfk_1` FOREIGN KEY (`laptop_id`) REFERENCES `laptop` (`id`) ON DELETE CASCADE,
  CONSTRAINT `laptop_mucdich_ibfk_2` FOREIGN KEY (`mucdich_id`) REFERENCES `mucdich` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- 9. Khuyến mãi / Voucher
-- =========================================================
CREATE TABLE `khuyenmai` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `tenkm` VARCHAR(255) NOT NULL,
  `mota` TEXT DEFAULT NULL,
  `loai` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '1=Giảm giá %, 2=Giảm tiền, 3=Voucher',
  `giatri` DECIMAL(15,2) NOT NULL,
  `ngaybatdau` DATETIME NOT NULL,
  `ngayketthuc` DATETIME NOT NULL,
  `trangthai` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Liên kết khuyến mãi với laptop (nếu khuyến mãi theo sản phẩm cụ thể)
CREATE TABLE `laptop_khuyenmai` (
  `laptop_id` INT(11) NOT NULL,
  `khuyenmai_id` INT(11) NOT NULL,
  PRIMARY KEY (`laptop_id`,`khuyenmai_id`),
  KEY `khuyenmai_id` (`khuyenmai_id`),
  CONSTRAINT `lk_laptop_km` FOREIGN KEY (`laptop_id`) REFERENCES `laptop` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lk_km` FOREIGN KEY (`khuyenmai_id`) REFERENCES `khuyenmai` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- 10. Đánh giá & bình luận của khách hàng
-- =========================================================
CREATE TABLE `danhgia` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `laptop_id` INT(11) NOT NULL,
  `nguoidung_id` INT(11) NOT NULL,
  `diem` TINYINT(1) NOT NULL CHECK (`diem` BETWEEN 1 AND 5),
  `tieude` VARCHAR(255) DEFAULT NULL,
  `noidung` TEXT DEFAULT NULL,
  `ngaydanhgia` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `trangthai` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '1=Hiển thị, 0=Ẩn',
  PRIMARY KEY (`id`),
  KEY `laptop_id` (`laptop_id`),
  KEY `nguoidung_id` (`nguoidung_id`),
  CONSTRAINT `danhgia_ibfk_1` FOREIGN KEY (`laptop_id`) REFERENCES `laptop` (`id`) ON DELETE CASCADE,
  CONSTRAINT `danhgia_ibfk_2` FOREIGN KEY (`nguoidung_id`) REFERENCES `nguoidung` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- 11. So sánh sản phẩm (lưu tạm khi người dùng chọn so sánh)
-- =========================================================
CREATE TABLE `sosanh` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `session_id` VARCHAR(255) NOT NULL,
  `laptop_id` INT(11) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `laptop_id` (`laptop_id`),
  CONSTRAINT `sosanh_ibfk_1` FOREIGN KEY (`laptop_id`) REFERENCES `laptop` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- 12. Đơn hàng (giữ nguyên cấu trúc cũ, thêm trạng thái thanh toán)
-- =========================================================
CREATE TABLE `donhang` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nguoidung_id` INT(11) NOT NULL,
  `diachi_id` INT(11) DEFAULT NULL,
  `ngay` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tongtien` DECIMAL(15,2) NOT NULL DEFAULT 0,
  `phuongthuc_thanhtoan` VARCHAR(50) DEFAULT 'COD' COMMENT 'COD, chuyen_khoan, momo, vnpay...',
  `trangthai_thanhtoan` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '0=Chưa thanh toán, 1=Đã thanh toán',
  `trangthai_donhang` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '0=Chờ xác nhận, 1=Đang xử lý, 2=Đang giao, 3=Hoàn thành, 4=Hủy',
  `ghichu` VARCHAR(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nguoidung_id` (`nguoidung_id`),
  KEY `diachi_id` (`diachi_id`),
  CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`nguoidung_id`) REFERENCES `nguoidung` (`id`) ON DELETE CASCADE,
  CONSTRAINT `donhang_ibfk_2` FOREIGN KEY (`diachi_id`) REFERENCES `diachi` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- 13. Chi tiết đơn hàng (mathang → laptop)
-- =========================================================
CREATE TABLE `donhangct` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `donhang_id` INT(11) NOT NULL,
  `laptop_id` INT(11) NOT NULL,
  `dongia` DECIMAL(15,2) NOT NULL DEFAULT 0,
  `soluong` INT(11) NOT NULL DEFAULT 1,
  `thanhtien` DECIMAL(15,2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `donhang_id` (`donhang_id`),
  KEY `laptop_id` (`laptop_id`),
  CONSTRAINT `donhangct_ibfk_1` FOREIGN KEY (`donhang_id`) REFERENCES `donhang` (`id`) ON DELETE CASCADE,
  CONSTRAINT `donhangct_ibfk_2` FOREIGN KEY (`laptop_id`) REFERENCES `laptop` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- Dữ liệu mẫu một số hãng, dòng, mục đích (có thể thêm sau)
-- =========================================================
INSERT INTO `hang` (`tenhang`, `logo`) VALUES
('Asus', 'logo_asus.png'),
('Dell', 'logo_dell.png'),
('MSI', 'logo_msi.png'),
('Lenovo', 'logo_lenovo.png'),
('Acer', 'logo_acer.png'),
('Apple', 'logo_apple.png'),
('HP', 'logo_hp.png');

INSERT INTO `mucdich` (`tenmucdich`) VALUES
('Gaming'), ('Đồ họa - Kỹ thuật'), ('Văn phòng'), ('Học tập - Sinh viên'), ('Mỏng nhẹ - Di động');

USE `shop_laptop`;

-- =========================================================
-- 1. Người dùng (admin + Nhân viên + Khách hàng mẫu)
-- =========================================================
INSERT INTO `nguoidung` (`email`, `sodienthoai`, `matkhau`, `hoten`, `loai`, `trangthai`, `hinhanh`) VALUES
('admin@laptop.vn',   '0901000001', '$2a$12$2OuqudzqVCV1O591s3mjjezEeGkaCzUmO0QAKbIBd1mHuYsyiEVzy', 'Admin',     1, 1, 'avatar_admin.jpg'),
('nhanvien@laptop.vn',        '0901000002', '$2a$12$2OuqudzqVCV1O591s3mjjezEeGkaCzUmO0QAKbIBd1mHuYsyiEVzy', 'Nhân viên bán hàng',   2, 1, 'avatar_nv.jpg'),
('nhanvien2@laptop.vn',     '0901000003', '$2a$12$2OuqudzqVCV1O591s3mjjezEeGkaCzUmO0QAKbIBd1mHuYsyiEVzy', 'Nhân viên bán hàng2', 2, 1, NULL),
('khachhang1@gmail.com',   '0901234567', '$2a$12$2OuqudzqVCV1O591s3mjjezEeGkaCzUmO0QAKbIBd1mHuYsyiEVzy', 'Nguyễn Văn A',    3, 1, NULL),
('khachhang2@gmail.com',   '0901234568', '$2a$12$2OuqudzqVCV1O591s3mjjezEeGkaCzUmO0QAKbIBd1mHuYsyiEVzy', 'Trần Thị B',      3, 1, NULL),
('khachhang3@gmail.com',   '0901234569', '$2a$12$2OuqudzqVCV1O591s3mjjezEeGkaCzUmO0QAKbIBd1mHuYsyiEVzy', 'Lê Văn C',        3, 1, NULL);

-- =========================================================
-- 2. Địa chỉ mẫu cho khách hàng
-- =========================================================
INSERT INTO `diachi` (`nguoidung_id`, `diachi`, `macdinh`) VALUES
(4, '123 Đường Láng, Đống Đa, Hà Nội', 1),
(4, '56 Nguyễn Trãi, Thanh Xuân, Hà Nội', 0),
(5, '89 Lê Lợi, Quận 1, TP.HCM', 1),
(6, '45 Trần Phú, Ba Đình, Hà Nội', 1);

-- =========================================================
-- 3. Dòng máy (Series) cho từng hãng
-- =========================================================
INSERT INTO `dongmay` (`hang_id`, `tendong`) VALUES
(1, 'ROG Strix'), (1, 'TUF Gaming'), (1, 'ZenBook'), (1, 'VivoBook'),
(2, 'XPS'), (2, 'Inspiron'), (2, 'Latitude'), (2, 'G15'),
(3, 'Katana'), (3, 'Pulse'), (3, 'Stealth'), (3, 'Raider GE'),
(4, 'Legion 5'), (4, 'IdeaPad Gaming'), (4, 'ThinkPad X1'), (4, 'Yoga'),
(5, 'Nitro'), (5, 'Predator Helios'), (5, 'Aspire'),
(6, 'MacBook Air M2'), (6, 'MacBook Pro 14'), (6, 'MacBook Pro 16'),
(7, 'Pavilion Gaming'), (7, 'Spectre'), (7, 'Envy'), (7, 'OMEN');

-- =========================================================
-- 4. Khuyến mãi hiện hành
-- =========================================================
INSERT INTO `khuyenmai` (`tenkm`, `mota`, `loai`, `giatri`, `ngaybatdau`, `ngayketthuc`, `trangthai`) VALUES
('Black Friday 2025', 'Giảm tới 20% toàn bộ laptop Gaming', 1, 20.00, '2025-11-20 00:00:00', '2025-12-05 23:59:59', 1),
('Giảm 5 triệu laptop cao cấp', 'Áp dụng cho đơn từ 40 triệu', 2, 5000000.00, '2025-11-01 00:00:00', '2025-12-31 23:59:59', 1),
('Voucher 500k cho khách mới', 'Giảm 500k cho đơn đầu tiên từ 15 triệu', 2, 500000.00, '2025-01-01 00:00:00', '2025-12-31 23:59:59', 1);

-- =========================================================
-- 5. Laptop mẫu (15 chiếc đa dạng)
-- =========================================================
INSERT INTO `laptop` (
  `tenlaptop`, `slug`, `hang_id`, `dongmay_id`, `cpu`, `ram`, `o_cung`, `card_man_hinh`,
  `man_hinh`, `trong_luong`, `pin`, `he_dieu_hanh`, `mota_chitiet`,
  `giagoc`, `giaban`, `soluongton`, `noibat`, `khuyenmai`
) VALUES
('ASUS ROG Strix G16 2025', 'asus-rog-strix-g16-2025', 1, 1,
 'Intel Core i9-14900HX', '32GB DDR5', '1TB SSD NVMe', 'RTX 4070 8GB',
 '16" QHD+ 240Hz', '2.5kg', '90Wh', 'Windows 11 Home',
 'Phiên bản 2025 cực mạnh, tản nhiệt tốt, RGB đẹp mắt', 65990000, 58990000, 15, 1, 1),

('Dell XPS 14 2025', 'dell-xps-14-2025', 2, 5,
 'Intel Core Ultra 7 155H', '32GB LPDDR5X', '1TB SSD', 'Intel Arc Graphics',
 '14.5" OLED 3.2K Touch', '1.68kg', '69.5Wh', 'Windows 11 Pro',
 'Thiết kế sang trọng, màn hình OLED tuyệt đẹp', 55990000, 52990000, 8, 1, 0),

('MacBook Pro 14 M4 Pro 2025', 'macbook-pro-14-m4-pro-2025', 6, 18,
 'Apple M4 Pro 14-core CPU', '24GB Unified', '1TB SSD', 'GPU 20-core',
 '14.2" Liquid Retina XDR 120Hz', '1.6kg', '70Wh', 'macOS',
 'Hiệu năng khủng, màn hình mini-LED xuất sắc', 67990000, 64990000, 20, 1, 1),

('MSI Katana 15 B13V', 'msi-katana-15-b13v', 3, 9,
 'Intel Core i7-13620H', '16GB DDR5', '512GB SSD', 'RTX 4060 8GB',
 '15.6" FHD 144Hz', '2.25kg', '53.5Wh', 'Windows 11',
 'Giá cực tốt trong phân khúc gaming RTX 4060', 28990000, 25990000, 25, 1, 1),

('Lenovo Legion 5 2025', 'lenovo-legion-5-2025', 4, 13,
 'AMD Ryzen 7 7840HS', '16GB DDR5', '1TB SSD', 'RTX 4060 8GB',
 '16" WQXGA 165Hz', '2.4kg', '80Wh', 'Windows 11',
 'Tản nhiệt Legion Coldfront cực mát', 33990000, 30990000, 18, 0, 1),

('ASUS ZenBook 14 OLED', 'asus-zenbook-14-oled', 1, 3,
 'Intel Core Ultra 7 155H', '16GB LPDDR5X', '1TB SSD', 'Intel Arc',
 '14" OLED 2.8K 120Hz Touch', '1.29kg', '75Wh', 'Windows 11',
 'Mỏng nhẹ cao cấp, pin trâu 16+ tiếng', 29990000, 27990000, 30, 1, 0),

('Acer Predator Helios 16', 'acer-predator-helios-16', 5, 20,
 'Intel Core i9-13900HX', '32GB DDR5', '2TB SSD', 'RTX 4080 12GB',
 '16" WQXGA 240Hz Mini-LED', '2.7kg', '90Wh', 'Windows 11',
 'Quái vật hiệu năng cho game thủ và creator', 89990000, 79990000, 5, 1, 1),

('HP OMEN 16 2025', 'hp-omen-16-2025', 7, 23,
 'AMD Ryzen 9 7945HX', '32GB DDR5', '1TB SSD', 'RTX 4080 12GB',
 '16.1" QHD 240Hz', '2.4kg', '83Wh', 'Windows 11',
 'Hiệu năng đỉnh cao, giá cạnh tranh', 74990000, 69990000, 10, 0, 1);

-- =========================================================
-- 6. Gán mục đích sử dụng cho từng laptop
-- =========================================================
INSERT INTO `laptop_mucdich` (`laptop_id`, `mucdich_id`) VALUES
(1,1),(1,2), -- ROG Strix: Gaming + Đồ họa
(2,2),(2,3),(2,5), -- XPS: Đồ họa + Văn phòng + Mỏng nhẹ
(3,1),(3,2),(3,4), -- MacBook Pro: Gaming (có thể), Đồ họa, Học tập
(4,1), -- Katana: Gaming
(5,1),(5,2), -- Legion 5: Gaming + Đồ họa
(6,3),(6,4),(6,5), -- ZenBook: Văn phòng + Học tập + Mỏng nhẹ
(7,1),(7,2), -- Predator: Gaming + Đồ họa
(8,1),(8,2); -- OMEN: Gaming + Đồ họa

-- =========================================================
-- 7. Ảnh cho laptop (mỗi laptop có 3-5 ảnh)
-- =========================================================
INSERT INTO `laptop_hinhanh` (`laptop_id`, `hinhanh`, `anhchinh`) VALUES
(1,'asus-rog-strix-g16-1.jpg',1), (1,'asus-rog-strix-g16-2.jpg',0), (1,'asus-rog-strix-g16-3.jpg',0),
(2,'dell-xps-14-1.jpg',1), (2,'dell-xps-14-2.jpg',0),
(3,'macbook-pro-14-m4-1.jpg',1), (3,'macbook-pro-14-m4-2.jpg',0), (3,'macbook-pro-14-m4-3.jpg',0),
(4,'msi-katana-15-1.jpg',1), (4,'msi-katana-15-2.jpg',0),
(5,'lenovo-legion-5-1.jpg',1), (5,'lenovo-legion-5-2.jpg',0),
(6,'asus-zenbook-14-1.jpg',1), (6,'asus-zenbook-14-2.jpg',0),
(7,'acer-predator-16-1.jpg',1), (7,'acer-predator-16-2.jpg',0),
(8,'hp-omen-16-1.jpg',1), (8,'hp-omen-16-2.jpg',0);

-- =========================================================
-- 8. Gán khuyến mãi cho một số laptop (Black Friday)
-- =========================================================
INSERT INTO `laptop_khuyenmai` (`laptop_id`, `khuyenmai_id`) VALUES
(1,1), (4,1), (5,1), (7,1), (8,1); -- 5 laptop gaming giảm 20%

-- =========================================================
-- 9. Đánh giá mẫu từ khách hàng
-- =========================================================
INSERT INTO `danhgia` (`laptop_id`, `nguoidung_id`, `diem`, `tieude`, `noidung`) VALUES
(1, 4, 5, 'Máy quá mạnh, đáng tiền!', 'Chơi game mượt, tản nhiệt tốt, RGB đẹp lung linh. Rất hài lòng!'),
(1, 5, 4, 'Tốt nhưng hơi nặng', 'Hiệu năng khủng nhưng cầm đi học hơi mỏi tay'),
(3, 6, 5, 'MacBook vẫn là nhất', 'Màn hình đẹp, pin trâu, làm việc cực hiệu quả'),
(4, 4, 5, 'Giá rẻ mà RTX 4060', 'Mua được giá khuyến mãi quá hời, chơi game ngon lành'),
(6, 5, 5, 'Mỏng nhẹ pin trâu', 'Dùng cả ngày không cần sạc, màn OLED đẹp xuất sắc');

-- Bảng Tin tức
CREATE TABLE `tintuc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tieude` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `tomtat` text DEFAULT NULL,
  `noidung` longtext DEFAULT NULL,
  `hinhanh` varchar(255) DEFAULT NULL,
  `ngaydang` datetime DEFAULT current_timestamp(),
  `trangthai` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dữ liệu mẫu Tin tức
INSERT INTO `tintuc` (`tieude`, `slug`, `tomtat`, `noidung`, `hinhanh`) VALUES
('Đánh giá MacBook Pro M4: Quái vật hiệu năng', 'danh-gia-macbook-pro-m4', 'Apple vừa ra mắt dòng chip M4 mới với hiệu năng vượt trội...', 'Nội dung chi tiết bài viết đánh giá...', 'news1.jpg'),
('Top 5 Laptop Gaming đáng mua nhất 2025', 'top-5-laptop-gaming-2025', 'Danh sách các mẫu laptop gaming giá tốt, cấu hình mạnh...', 'Nội dung chi tiết top 5...', 'news2.jpg'),
('Cách bảo quản pin laptop bền bỉ theo thời gian', 'cach-bao-quan-pin-laptop', 'Pin laptop là linh kiện dễ chai nhất, hãy cùng xem cách bảo quản...', 'Nội dung hướng dẫn...', 'news3.jpg');


-- Bảng Đánh giá (Reviews)
CREATE TABLE `danhgia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `laptop_id` int(11) NOT NULL,
  `nguoidung_id` int(11) NOT NULL,
  `diem` tinyint(1) NOT NULL DEFAULT 5,
  `noidung` text NOT NULL,
  `ngaydanhgia` datetime DEFAULT current_timestamp(),
  `trangthai` tinyint(1) DEFAULT 0 COMMENT '0: Chờ duyệt, 1: Hiển thị',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Bảng Liên hệ (Contact)
CREATE TABLE `lienhe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `sodienthoai` varchar(20) DEFAULT NULL,
  `noidung` text NOT NULL,
  `ngaygui` datetime DEFAULT current_timestamp(),
  `trangthai` tinyint(1) DEFAULT 0 COMMENT '0: Chưa xem, 1: Đã xem',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================================
-- Tài khoản đăng nhập mẫu
-- =========================================================
-- admin: admin@laptop.vn  / 123
-- Admin:      admin@laptop.vn       / 123
-- Khách:      khachhang1@gmail.com  / 123
