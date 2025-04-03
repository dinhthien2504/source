-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th2 24, 2025 lúc 07:06 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `knlv`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 11, '2025-02-25', '2025-02-24 18:03:18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Áo', '2024-11-16', '2024-11-28 08:50:12', 0),
(2, 'Quần', '2024-11-16', '2024-11-22 00:42:53', 0),
(3, 'Phụ kiện', '2024-11-16', '2024-11-16 14:01:55', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `detailcarts`
--

CREATE TABLE `detailcarts` (
  `id` int(5) NOT NULL,
  `product_id` int(5) NOT NULL,
  `cart_id` int(5) NOT NULL,
  `quantity` int(10) NOT NULL DEFAULT 1,
  `size` varchar(50) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orderdetails`
--

CREATE TABLE `orderdetails` (
  `id` int(5) NOT NULL,
  `product_id` int(5) NOT NULL,
  `order_id` int(5) NOT NULL,
  `size` int(11) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` double(10,0) NOT NULL,
  `is_reviewed` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orderdetails`
--

INSERT INTO `orderdetails` (`id`, `product_id`, `order_id`, `size`, `quantity`, `price`, `is_reviewed`) VALUES
(1, 22, 1, 2, 1, 99000, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `voucher_id` int(5) DEFAULT NULL,
  `staff_id` int(5) DEFAULT NULL,
  `code_order` text NOT NULL,
  `note` varchar(255) NOT NULL,
  `total` decimal(10,0) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL,
  `by_date` DATETIME NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `voucher_id`, `staff_id`, `code_order`, `note`, `total`, `address`, `phone`, `by_date`, `status`) VALUES
(1, 11, NULL, 1, 'ORD1740420205802', '', 99000, 'Bình Thuận, Huyện Hàm Thuận Bắc, Xã Hàm Chính', 376373272, '2025-02-25', 4);

--
-- Bẫy `orders`
--
DELIMITER $$
CREATE TRIGGER `trg_ud_quantity_Dsizes` AFTER UPDATE ON `orders` FOR EACH ROW BEGIN
    IF NEW.status = 0 AND OLD.status <> 0 THEN
        UPDATE size_details Dsizes
        JOIN orderdetails Dod ON Dsizes.product_id = Dod.product_id
        SET Dsizes.quantity = Dsizes.quantity + Dod.quantity
        WHERE Dod.order_id = NEW.id
        AND Dod.size = Dsizes.size_id;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_ud_sales_pros` AFTER UPDATE ON `orders` FOR EACH ROW BEGIN
    IF NEW.status = 4 AND OLD.status <> 4 THEN
        UPDATE products p
        JOIN orderDetails od ON p.id = od.product_id
        SET p.sales = p.sales + od.quantity
        WHERE od.order_id = NEW.id;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `payment_date` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_method`
--

CREATE TABLE `payment_method` (
  `id` int(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `isActive` tinyint(4) NOT NULL DEFAULT 1,
  `createAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updateAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `privileges`
--

CREATE TABLE `privileges` (
  `id` int(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `url_match` varchar(3000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `privileges`
--

INSERT INTO `privileges` (`id`, `name`, `url_match`) VALUES
(1, 'Quản lý sản phẩm', 'admin\\/danh-muc$|admin\\/danh-muc-phu$|admin\\/san-pham$|admin\\/voucher$|category\\/showEditModal$|category\\/showSubEditModal$|product\\/getSubcategoriesByCategoryId$|product\\/getCategoryBySubCategoryId$|product\\/showEditModal$|voucher\\/showEditModal$|getImgByIdPro$|product\\/addImgPro$'),
(2, 'Quản lý thành viên', 'admin\\/khach-hang$|admin\\/nhan-vien$|user\\/showEditPrivilege$|user\\/showUserModal$|user\\/showStaffModal$|admin\\/phan-quyen$|admin\\/chinh-sua-quyen$|product\\/showQuantityEdit$'),
(3, 'Quản lý đơn hàng', 'admin\\/don-hang$|showOrderById$|Order\\/updateOrder$|Order\\/showOrderDetail$'),
(4, 'Quản lý marketing', 'admin\\/danh-gia$|admin\\/danh-gia\\/chi-tiet\\/\\d+$');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `productimages`
--

CREATE TABLE `productimages` (
  `id` int(5) NOT NULL,
  `product_id` int(5) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `productimages`
--

INSERT INTO `productimages` (`id`, `product_id`, `image`) VALUES
(1, 1, 'sp1.jpg'),
(2, 1, 'sp1.2.jpg'),
(3, 1, 'sp1.3.jpg'),
(4, 1, 'sp1.1.jpg'),
(5, 2, 'sp2.jpg'),
(6, 2, 'sp2.1.jpg'),
(7, 2, 'sp2.2.jpg'),
(8, 2, 'sp2.3.jpg'),
(9, 3, 'sp3.jpg'),
(10, 3, 'sp3.1.jpg'),
(11, 3, 'sp3.2.jpg'),
(12, 3, 'sp3.3.jpg'),
(13, 4, 'sp4.jpg'),
(14, 4, 'sp4.1.jpg'),
(15, 4, 'sp4.2.jpg'),
(16, 4, 'sp4.3.jpg'),
(17, 5, 'sp5.jpg'),
(18, 5, 'sp5.1.jpg'),
(19, 5, 'sp5.2.jpg'),
(20, 5, 'sp5.3.jpg'),
(21, 6, 'sp611.jpg'),
(22, 6, 'sp6.1.jpg'),
(23, 6, 'sp6.2.jpg'),
(24, 6, 'sp6.3.jpg'),
(25, 7, 'sp7.jpg'),
(26, 7, 'sp7.1.jpg'),
(27, 7, 'sp7.2.jpg'),
(28, 7, 'sp7.3.jpg'),
(32, 8, 'sp8.jpg'),
(33, 8, 'sp8.1.jpg'),
(34, 8, 'sp8.2.jpg'),
(35, 8, 'sp8.3.jpg'),
(56, 14, 'sp9.jpg'),
(57, 14, 'sp9.1.jpg'),
(58, 14, 'sp9.2.jpg'),
(59, 14, 'sp9.3.jpg'),
(60, 15, 'sp10.jpg'),
(61, 15, 'sp10.1.jpg'),
(62, 15, 'sp10.2.jpg'),
(63, 15, 'sp10.3.jpg'),
(64, 16, 'sp11.jpg'),
(65, 16, 'sp11.1.jpg'),
(66, 16, 'sp11.2.jpg'),
(67, 16, 'sp11.3.jpg'),
(68, 17, 'sp12.jpg'),
(69, 17, 'sp12.1.jpg'),
(70, 17, 'sp12.2.jpg'),
(71, 18, 'sp13.jpg'),
(72, 18, 'sp13.1.jpg'),
(73, 18, 'sp13.2.jpg'),
(74, 19, 'sp14.jpg'),
(75, 19, 'sp14.1.jpg'),
(76, 19, 'sp14.2.jpg'),
(77, 19, 'sp14.3.jpg'),
(78, 20, 'sp15.jpg'),
(79, 20, 'sp15.1.jpg'),
(80, 20, 'sp15.2.jpg'),
(81, 20, 'sp15.3.jpg'),
(82, 21, 'vn-11134207-7ras8-m3dnwjxrjancb1@resize_w900_nl.jpg'),
(83, 21, 'vn-11134207-7ras8-m3dnwjxrghig5d@resize_w900_nl.jpg'),
(84, 21, 'vn-11134207-7ras8-m3dnwjxrkp7sf0@resize_w900_nl.jpg'),
(87, 22, 'vn-11134207-7r98o-lxnnjbfsir4rbf.jpg'),
(88, 22, 'vn-11134207-7r98o-lxnnjbfsirbt36@resize_w900_nl.jpg'),
(89, 22, 'vn-11134207-7r98o-lxnno50kfm57e3@resize_w900_nl.jpg'),
(90, 22, 'vn-11134207-7r98o-lxnnnxzspihnbe@resize_w900_nl.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(5) NOT NULL,
  `subcategory_id` int(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` double(10,0) NOT NULL,
  `discount_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `detail` varchar(2000) NOT NULL,
  `views` int(10) NOT NULL DEFAULT 0,
  `sales` int(10) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `subcategory_id`, `name`, `price`, `discount_percent`, `detail`, `views`, `sales`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, 'Áo Thun Nam Better Days Ahead', 299000, 40.00, 'Chất liệu kết hợp Cotton và Polyester mang đến độ mềm mại, thông thoáng, co giãn nhẹ, hạn chế nhăn nhàu và độ bền cao thích hợp cho mọi hoạt động. Thiết kế đơn giản, hiện đại phù hợp mọi lứa tuổi. Dễ dàng phối đồ, tạo phong cách riêng và góp phần bảo vệ môi trường.', 0, 0, '2024-11-16', '2024-12-07 03:07:50', 1),
(2, 2, 'Áo Sơ Mi Dài Tay Nam Cafe', 250000, 10.00, 'Áo sơ mi mềm mại, nhẹ và hạn chế nhăn nhàu, tiết kiệm thời gian là ủi. Khử mùi hiệu quả tạo nên sự tự tin. Thiết ké cơ bản, có túi ngực cùng kiểu dàng suông phù hợp với nhiều độ tuổi khác nhau.', 0, 0, '2024-11-16', '2025-02-24 17:36:48', 0),
(3, 1, 'Áo Thun Đông Nam Mickey', 499000, 30.00, 'Kiểu dáng rộng rãi, thoải mái cùng hình Mickey nhỏ xinh ở ngực tạo điểm nhấn trẻ trung. Thiết kế dài tay giữ ấm tốt, thích hợp cho những ngày se lạnh. Dễ dàng phối đồ cùng quần jeans, quần dài, phù hợp mọi hoàn cảnh.', 0, 0, '2024-11-19', '2024-11-18 22:50:02', 0),
(4, 1, 'Áo thun thể thao nam trần chỉ', 279000, 50.00, 'Công nghệ dệt Jacquard hiện đại, tạo họa tiết lỗ độc đáo. Thấm hút tốt, khô nhanh, thông thoáng nhờ kiểu dệt - tạo cảm thoải mái cho làn da. Kiểu dáng áo thun thể thao basic, trẻ trung, năng động. Cổ tròn, ôm sát cổ, tạo cảm giác thoải mái khi vận động.', 0, 0, '2024-11-19', '2024-12-07 03:07:00', 0),
(5, 1, 'Áo Thun Đông Nam Giữ Nhiệt Cổ 3cm', 299000, 33.00, 'Được biết đến là sáng tạo tuyệt vời của ngành dệt may - sợi tái sinh có nguồn gốc từ Bamboo/ Tre ngày càng trở nên phổ biến. Chiếc áo này, với sự kết hợp của Bamboo và Spandex giúp vải sở hữu các tính năng ưu việt như mềm mại, thoáng, thấm hút tốt, co giãn hiệu quả, độ bền cao.', 0, 0, '2024-11-19', '2024-11-30 07:53:12', 0),
(6, 1, 'Áo Thun Đông Nam Mickey Everything', 529000, 30.00, 'Bộ sưu tập YODY x Disney với biểu tượng nổi tiếng chuột Mickey, hình ảnh được thiết kế bởi các nhà sáng tạo hàng đầu tại Disney. Áo nỉ dáng rộng, thoải mái cùng điểm nhấn nhỏ ở ngực và sau lưng trẻ trung.', 0, 0, '2024-11-19', '2024-11-30 07:53:12', 0),
(7, 1, 'Áo Thun Đông Nam Giữ Nhiệt Cổ Tròn', 200000, 10.00, 'Giữ nhiệt tốt, ấm áp từ trong ra ngoài cùng áo thun giữ nhiệt YODY. Chiếc áo này siêu thích hợp để mặc trong những ngày trời trở lạnh. Chất liệu Bamboo mềm mại, thoáng, co giãn tốt lại thân thiện với da. Sở hữu ngay nhé!', 0, 0, '2024-11-19', '2024-11-18 23:05:43', 0),
(8, 1, 'Áo Thun Thể Thao Nam Feel The Sport', 250000, 10.00, 'Mùa hè nóng bức nhưng cũng là lúc các anh tập luyện thể thao cường độ cao hơn. Thấu hiểu điều này, YODY mang đến chiếc áo thun thể thao mềm mại, thông thoáng, thấm hút tốt. Sản phẩm có khả năng hạn chế mùi hôi tuyệt vời. Thiết kế ba lỗ khoẻ khoắn, năng động, tha hồ tập luyện mà không lo bí nóng.', 0, 0, '2024-11-19', '2024-12-07 03:07:00', 0),
(14, 4, 'Quần Âu Nam Cạp Chun Ốp', 549000, 5.00, 'Lịch lãm cùng quân âu nam YODY. Đây là một trong những mẫu quần âu được cánh mày râu ưa chuộng bởi sự chỉn chu, nhã nhặn. Những tone màu cơ bản siêu dễ phối đồ. Đường may tỉ mỉ, chỉn chu giúp các anh tự tin khi đi làm, đi chơi.', 0, 0, '2024-11-30', '2024-11-30 05:47:55', 0),
(15, 4, ' Quần Âu Nam Cạp Di Động Kẻ Sọc', 429000, 5.00, 'Thiết kế cạp di động co giãn nhẹ, thoải mái vận động. Kiểu dáng kẻ sọc thanh lịch, trẻ trung. Phù hợp cho nhiều dịp như công sở, dạo phố hay sự kiện. Vải tạo từ sợi nano siêu mảnh, hạn chế nhăn nhàu, thấm hút mồ hôi tốt. Khả năng chống nắng UPF 98%, bảo vệ da khỏi tác hại tia UV.', 0, 0, '2024-11-30', '2024-11-30 05:54:01', 0),
(16, 5, 'Mũ Lưỡi Trai Thêu Space', 169000, 2.00, 'Hình thêu Space tinh tế, sắc nét thêm phần cá tính, đồng thời vải thấm mồ hôi giúp bạn luôn mát mẻ và thoải mái khi thời tiết nắng ấm áp. Kiểu dáng cơ bản nhưng không kém phần năng động.', 0, 0, '2024-11-30', '2024-11-30 05:55:57', 0),
(17, 5, ' Mũ Lưỡi Trai Unisex Wash Thêu Logo', 189000, 11.00, 'Mũ lưỡi trai unisex 100% cotton, vải wash mềm mịn, thấm hút mồ hôi tốt. Kích cỡ freesize, điều chỉnh dễ dàng. Công dụng che nắng, bảo vệ da đầu, tạo điểm nhấn cho outfit. Thêu logo độc đáo, form mũ chuẩn. Thoải mái, năng động, phù hợp mọi hoạt động.', 0, 0, '2024-11-30', '2024-11-30 05:57:40', 0),
(18, 6, 'Thắt Lưng Nam Mặt Khoá Tự Động', 499000, 20.00, 'Mặt khóa chất liệu hợp kim kẽm nguyên khối với thiết kế tinh tế. Da có đặc tính mềm, dẻo, không có hóa chất độc hại cùng với thiết kế trẻ trung hợp thời trang và vô cùng độc đáo. Mắt khóa tự động, dễ dàng điều chỉnh độ rộng.', 0, 0, '2024-11-30', '2025-02-24 17:36:48', 0),
(19, 6, ' Thắt Lưng Nam Khoá Cài Mặt Xoay 04', 499000, 10.00, 'Chất liệu: Da bò thật\r\nMặt khoá kim loại, thiết kế khoá kim cổ điển, đơn giản, dễ sửu dụng\r\nThắt lưng da nam với chất da bò thật mang lại độ chắc chắn cao khi sử dụng\r\nBản dây: 3,4cm\r\nKích thước mặt: Dài 8,3 cm - Rộng 4,5 cm\r\nĐồ bên từ 1-3 năm\r\nYODY - Look good. Feel good.', 0, 0, '2024-11-30', '2025-02-24 17:36:48', 0),
(20, 3, ' Quần Jeans Nam Slim Fit Ống Côn Coolmax', 599000, 10.00, 'Thiết kế ống côn ôm sát, tôn dáng mạnh mẽ. Form slim fit ôm vừa vặn giúp bạn trông gọn gàng và năng động. Sản phẩm bền màu, ít nhăn, dễ giặt ủi. Thích hợp mặc quanh năm, dù là nắng nóng hay se lạnh đều mang đến sự thoải mái tối ưu.', 0, 0, '2024-11-30', '2025-02-24 17:36:48', 0),
(21, 1, 'Áo Polo nam cổ V vải thun gân cotton trơn', 100000, 10.00, 'Chất liệu vải thun gân cotton co giãn 4 chiều, thoáng khí, thấm hút mồ hôi tốt. ( Chất vải theo cảm nhận cá nhân của shop mình là không được dày lắm nhưng cũng không mỏng quá, nhiều bạn khách bên mình có phản hồi là vải không dày, vì áo này mình làm mặc mùa hè ưu tiên sự mát mê và thông thoáng khí khi mặc ). Chất vải mềm co giãn, mặc không bị chảy vải.\r\n\r\n- vải mềm co giãn tốt, phần cổ áo được ép mếch giúp chiếc cổ áo được cứng cáp lên form đẹp, 2 bên tay áo có bo tay giúp tôn lên phần bắp tay nam tính.\r\n\r\n- Kiểu dáng áo ôm nhẹ tôn lên vẻ nam tính, sang trọng, lịch lãm của đàn ông\r\n\r\n- đường may tỉ mỉ cẩn thận, shop cam kết đổi trả nếu có bất kỳ lỗi nào của shop\r\n\r\n- Trong quá trình mua hàng và nhận hàng nếu nhận áo bị chật hay rộng shop có hỗ trợ đổi size theo ý muốn của khách hàng.\r\n\r\n- Phù hợp mặc ở nhà, mặc đi chơi, đi học, đi làm... Phù hợp với nhiều trang phục khác nhau.\r\n\r\n- Thiết kế hiện đại, trẻ trung, năng động, dễ phối đồ.\r\n\r\nÁo có 2 màu cơ bản Basic đó là: Đen - Trắng\r\n\r\nCách chọn size theo chiều cao và cân nặng: \r\n\r\nThông tin chọn size:\r\n\r\nSize S: 1m55- 1m67 ( 50 - 61kg ) ( lưu ý các bạn 50kg mặc size S sẽ thấy rộng không được ôm vào người )\r\n\r\nSize M: 1m60 - 1m70 ( 62 - 70kg ) ( bạn nào 60 - 61kg mà muốn mặc kiểu ôm người thì chọn size S nha, muốn rộng thì size M )\r\n\r\nSize L: 1m65 - 1m75 ( 71 - 79kg )\r\n\r\nSize XL: 1m70 - 1m80 ( 80 - 87kg )\r\n\r\n( Bảng size mang tính chất tham khảo, chọn mặc from vừa vặn thoải mái, lên xuống size tùy theo sở thích ăn mặc của bạn )\r\n\r\nLưu ý: Áo bên mình sẽ là from vừa vặn không phải from áo oversize nên các bạn hãy chọn size áo theo cân nặng của mình nhé!', 0, 0, '2025-02-18', '2025-02-24 17:36:48', 0),
(22, 1, 'Áo thun ngắn tay local brand fashion', 110000, 10.00, 'HIPHOPPUNKS CAM KẾT:\r\n﻿\r\n◾ Chất liệu vải Cotton 100% co dãn 2 chiều, Định lượng cao 230gsm, \r\n﻿\r\n◾ Vải chính phẩm đã qua xử lý co rút, và lông thừa\r\n﻿\r\n◾ chất vải mềm mịn dày nhưng cực kì mát và không xù\r\n﻿\r\n◾ Hoàn tiền nếu sản phẩm không giống với mô tả\r\n﻿\r\n◾ Nam và Nữ đều mặc được, form áo rộng chuẩn TAY LỠ UNISEX cực đẹp\r\n﻿\r\n————————————————————', 0, 1, '2025-02-25', '2025-02-24 18:04:26', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rateimages`
--

CREATE TABLE `rateimages` (
  `id` int(5) NOT NULL,
  `rate_id` int(5) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rateimages`
--

INSERT INTO `rateimages` (`id`, `rate_id`, `img`) VALUES
(1, 1, 'vn-11134207-7r98o-lxnnjbfsirbt36@resize_w900_nl.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rates`
--

CREATE TABLE `rates` (
  `id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `product_id` int(5) NOT NULL,
  `review_text` varchar(255) DEFAULT NULL,
  `rating` decimal(2,1) NOT NULL DEFAULT 0.0,
  `name_size` varchar(100) NOT NULL,
  `date_rate` DATETIME NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rates`
--

INSERT INTO `rates` (`id`, `user_id`, `product_id`, `review_text`, `rating`, `name_size`, `date_rate`) VALUES
(1, 11, 22, 'San pham dung mo ta', 5.0, 'M', '2025-02-25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sizes`
--

CREATE TABLE `sizes` (
  `id` int(5) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sizes`
--

INSERT INTO `sizes` (`id`, `name`) VALUES
(1, 'S'),
(2, 'M'),
(3, 'L'),
(4, 'XL'),
(5, 'XXL');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `size_details`
--

CREATE TABLE `size_details` (
  `id` int(5) NOT NULL,
  `product_id` int(5) NOT NULL,
  `size_id` int(5) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `size_details`
--

INSERT INTO `size_details` (`id`, `product_id`, `size_id`, `quantity`) VALUES
(1, 1, 3, 3),
(2, 1, 2, 10),
(3, 1, 1, 0),
(4, 2, 1, 2),
(5, 2, 2, 9),
(6, 2, 3, 2),
(7, 3, 1, 10),
(8, 3, 2, 9),
(9, 3, 3, 3),
(10, 4, 1, 0),
(11, 4, 2, 10),
(12, 4, 3, 9),
(13, 4, 4, 3),
(14, 5, 1, 9),
(15, 5, 2, 10),
(16, 5, 3, 9),
(17, 5, 4, 3),
(18, 6, 1, 9),
(19, 6, 2, 10),
(20, 6, 3, 9),
(21, 6, 4, 2),
(22, 7, 1, 10),
(23, 7, 2, 10),
(24, 7, 3, 9),
(25, 7, 4, 3),
(26, 8, 1, 9),
(27, 8, 2, 10),
(28, 8, 3, 9),
(29, 8, 4, 3),
(55, 14, 1, 11),
(56, 14, 2, 10),
(57, 14, 3, 0),
(58, 14, 4, 10),
(59, 14, 5, 0),
(60, 15, 1, 10),
(61, 15, 2, 0),
(62, 15, 3, 0),
(63, 15, 4, 0),
(64, 15, 5, 0),
(65, 16, 1, 10),
(66, 16, 2, 0),
(67, 16, 3, 0),
(68, 16, 4, 10),
(69, 16, 5, 0),
(70, 17, 1, 10),
(71, 17, 2, 0),
(72, 17, 3, 0),
(73, 17, 4, 0),
(74, 17, 5, 0),
(75, 18, 1, 12),
(76, 18, 2, 0),
(77, 18, 3, 15),
(78, 18, 4, 0),
(79, 18, 5, 0),
(80, 19, 1, 6),
(81, 19, 2, 0),
(82, 19, 3, 0),
(83, 19, 4, 3),
(84, 19, 5, 0),
(85, 20, 1, 7),
(86, 20, 2, 10),
(87, 20, 3, 10),
(88, 20, 4, 10),
(89, 20, 5, 0),
(90, 21, 1, 7),
(91, 21, 2, 10),
(92, 21, 3, 12),
(93, 21, 4, 0),
(94, 21, 5, 0),
(100, 22, 1, 0),
(101, 22, 2, 9),
(102, 22, 3, 10),
(103, 22, 4, 10),
(104, 22, 5, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(5) NOT NULL,
  `category_id` int(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `subcategories`
--

INSERT INTO `subcategories` (`id`, `category_id`, `name`, `created_at`, `updated_at`, `status`) VALUES
(1, 1, 'Áo thun nam', '2024-11-16', '2024-11-16 13:58:05', 0),
(2, 1, 'Áo sơ mi nam', '2024-11-16', '2024-11-16 13:58:05', 0),
(3, 2, 'Quần jeans nam', '2024-11-16', '2024-11-16 13:58:05', 0),
(4, 2, 'Quần âu nam', '2024-11-16', '2024-11-16 13:58:05', 0),
(5, 3, 'Mũ nam', '2024-11-16', '2024-11-16 14:02:50', 0),
(6, 3, 'Thắt lưng nam', '2024-11-16', '2024-11-16 14:02:50', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `role` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `email`, `image`, `password`, `address`, `role`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Admin ', '0', 'admin@gmail.com', '1739876546_sg-11134201-7rdyr-m0vnpz18p50wa2@resize_w900_nl.jpg', '123', '', 2, '2025-02-04', '2025-02-24 17:41:38', 0),
(11, 'Dinh Thien', '0376373272', 'dinhthien2504@gmail.com', 'anh-avatar-fb-8.jpg', '@Thien123', NULL, 0, '2025-02-25', '2025-02-24 18:03:01', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_privileges`
--

CREATE TABLE `user_privileges` (
  `id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `privilege_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user_privileges`
--

INSERT INTO `user_privileges` (`id`, `user_id`, `privilege_id`) VALUES
(73, 1, 2),
(74, 1, 3),
(75, 1, 4),
(102, 1, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int(5) NOT NULL,
  `code_voucher` varchar(20) NOT NULL,
  `discount_percent` decimal(3,1) NOT NULL DEFAULT 0.0,
  `max_discount` double NOT NULL,
  `expiration_date` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_carts_users` (`user_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `detailcarts`
--
ALTER TABLE `detailcarts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detailcarts_products` (`product_id`),
  ADD KEY `fk_detailcarts_carts` (`cart_id`);

--
-- Chỉ mục cho bảng `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orderDetail_products` (`product_id`),
  ADD KEY `fk_orderDetail_orders` (`order_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orders_users` (`user_id`),
  ADD KEY `fk_orders_vouchers` (`voucher_id`),
  ADD KEY `fk_orders_staffs` (`staff_id`);

--
-- Chỉ mục cho bảng `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_order_id` (`order_id`),
  ADD KEY `payment_paymentMethod_id` (`payment_method`);

--
-- Chỉ mục cho bảng `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `privileges`
--
ALTER TABLE `privileges`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `productimages`
--
ALTER TABLE `productimages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_productImage_products` (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_products_subCategoris` (`subcategory_id`);

--
-- Chỉ mục cho bảng `rateimages`
--
ALTER TABLE `rateimages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rateimages_rates` (`rate_id`);

--
-- Chỉ mục cho bảng `rates`
--
ALTER TABLE `rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rates_users` (`user_id`),
  ADD KEY `fk_rates_products` (`product_id`);

--
-- Chỉ mục cho bảng `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `size_details`
--
ALTER TABLE `size_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Size_detailToSize` (`size_id`),
  ADD KEY `Size_detailToPro` (`product_id`);

--
-- Chỉ mục cho bảng `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_subcategories_categories` (`category_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user_privileges`
--
ALTER TABLE `user_privileges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_privilege_privileges` (`privilege_id`),
  ADD KEY `fk_user_privilege_users` (`user_id`);

--
-- Chỉ mục cho bảng `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `detailcarts`
--
ALTER TABLE `detailcarts`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `privileges`
--
ALTER TABLE `privileges`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `productimages`
--
ALTER TABLE `productimages`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `rateimages`
--
ALTER TABLE `rateimages`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `rates`
--
ALTER TABLE `rates`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `size_details`
--
ALTER TABLE `size_details`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT cho bảng `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `user_privileges`
--
ALTER TABLE `user_privileges`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT cho bảng `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `fk_carts_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `detailcarts`
--
ALTER TABLE `detailcarts`
  ADD CONSTRAINT `fk_detailcarts_carts` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`),
  ADD CONSTRAINT `fk_detailcarts_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `fk_orderDetail_orders` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `fk_orderDetail_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_orders_vouchers` FOREIGN KEY (`voucher_id`) REFERENCES `vouchers` (`id`);

--
-- Các ràng buộc cho bảng `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `payment_paymentMethod_id` FOREIGN KEY (`payment_method`) REFERENCES `payment_method` (`id`);

--
-- Các ràng buộc cho bảng `productimages`
--
ALTER TABLE `productimages`
  ADD CONSTRAINT `fk_productImage_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_subCategoris` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`);

--
-- Các ràng buộc cho bảng `rateimages`
--
ALTER TABLE `rateimages`
  ADD CONSTRAINT `fk_rateimages_rates` FOREIGN KEY (`rate_id`) REFERENCES `rates` (`id`);

--
-- Các ràng buộc cho bảng `rates`
--
ALTER TABLE `rates`
  ADD CONSTRAINT `fk_rates_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `fk_rates_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `size_details`
--
ALTER TABLE `size_details`
  ADD CONSTRAINT `Size_detailToPro` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `Size_detailToSize` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`);

--
-- Các ràng buộc cho bảng `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `fk_subcategories_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Các ràng buộc cho bảng `user_privileges`
--
ALTER TABLE `user_privileges`
  ADD CONSTRAINT `fk_user_privilege_privileges` FOREIGN KEY (`privilege_id`) REFERENCES `privileges` (`id`),
  ADD CONSTRAINT `fk_user_privilege_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
