-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping data for table smoffice.activity_log: ~0 rows (approximately)
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
	(1, 'modul', 'This model has been created data', 'App\\Models\\Modul', 'created', 15, 'App\\Models\\User', 1, '{"attributes": {"edit": 1, "name": "area", "view": 1, "create": 1, "delete": 1, "detail": 1, "export": 0, "import": 0}}', NULL, '2024-05-21 13:43:55', '2024-05-21 13:43:55'),
	(2, 'modul', 'This model has been created data', 'App\\Models\\Modul', 'created', 16, 'App\\Models\\User', 1, '{"attributes": {"edit": 1, "name": "sub_area", "view": 1, "create": 1, "delete": 1, "detail": 1, "export": 0, "import": 0}}', NULL, '2024-05-21 13:44:08', '2024-05-21 13:44:08'),
	(3, 'area', 'This model has been created data', 'App\\Models\\Area', 'created', 1, 'App\\Models\\User', 1, '{"attributes": {"name": "CIBINONG", "branch_id": 3}}', NULL, '2024-05-21 13:44:48', '2024-05-21 13:44:48'),
	(4, 'area', 'This model has been updated data', 'App\\Models\\Area', 'updated', 1, 'App\\Models\\User', 1, '{"old": {"name": "CIBINONG", "branch_id": 3}, "attributes": {"name": "BOGOR TENGAH", "branch_id": 3}}', NULL, '2024-05-21 13:45:11', '2024-05-21 13:45:11'),
	(5, 'sub_area', 'This model has been created data', 'App\\Models\\SubArea', 'created', 1, 'App\\Models\\User', 1, '{"attributes": {"name": "CIBINONG", "area_id": 1, "branch_id": 3}}', NULL, '2024-05-21 13:45:26', '2024-05-21 13:45:26'),
	(6, 'customer', 'This model has been updated data', 'App\\Models\\Customer', 'updated', 9, 'App\\Models\\User', 1, '{"old": {"LA": "-6.5911326336936", "LO": "106.79257772863", "area": null, "code": "BGR009", "name": "LANI, TOKO", "type": "S", "phone": "0812 9087 8763", "photo": null, "banner": 0, "status": 1, "address": "JL. LAYUNG SARI 1 EMPANG BOGOR SELATAN", "subarea": null, "user_id": null, "branch_id": 3, "created_by": 1, "deleted_by": null, "updated_by": 1, "status_registration": "Y"}, "attributes": {"LA": "-6.5911326336936", "LO": "106.79257772863", "area": null, "code": "BGR009", "name": "LANI, TOKO", "type": "S", "phone": "0812 9087 8763", "photo": null, "banner": 0, "status": 1, "address": "JL. LAYUNG SARI 1 EMPANG BOGOR SELATAN", "subarea": null, "user_id": null, "branch_id": 3, "created_by": 1, "deleted_by": null, "updated_by": 1, "status_registration": "Y"}}', NULL, '2024-05-21 13:51:27', '2024-05-21 13:51:27'),
	(7, 'customer', 'This model has been updated data', 'App\\Models\\Customer', 'updated', 16, 'App\\Models\\User', 1, '{"old": {"LA": "14", "LO": "43", "area": null, "code": "BGR0010", "name": "Martabak Jakarta", "type": "O", "phone": "+1 (295) 436-1993", "photo": "uploads/customer//BGR0010-Martabak Jakarta-19-Mar-2024 114435.jpg", "banner": 0, "status": 1, "address": "Deleniti autem commo", "subarea": null, "user_id": null, "branch_id": 3, "created_by": 1, "deleted_by": null, "updated_by": null, "status_registration": "Y"}, "attributes": {"LA": "14", "LO": "43", "area": null, "code": "BGR0010", "name": "Martabak Jakarta", "type": "O", "phone": "+1 (295) 436-1993", "photo": "uploads/customer//BGR0010-Martabak Jakarta-19-Mar-2024 114435.jpg", "banner": 0, "status": 1, "address": "Deleniti autem commo", "subarea": null, "user_id": null, "branch_id": 3, "created_by": 1, "deleted_by": null, "updated_by": 1, "status_registration": "Y"}}', NULL, '2024-05-21 13:59:20', '2024-05-21 13:59:20');

-- Dumping data for table smoffice.detail_gift_visits: ~0 rows (approximately)
INSERT INTO `detail_gift_visits` (`id`, `header_visit_id`, `product_id`, `qty`, `created_at`, `updated_at`) VALUES
	(1, 7, 1, 10, '2024-03-22 06:37:41', '2024-03-22 06:37:41'),
	(2, 8, 1, 10, '2024-03-22 06:46:42', '2024-03-22 06:46:42'),
	(3, 9, 1, 10, '2024-03-23 05:40:59', '2024-03-23 05:40:59'),
	(4, 13, 1, 10, '2024-03-27 03:43:20', '2024-03-27 03:43:20'),
	(5, 14, 1, 10, '2024-03-27 08:17:47', '2024-03-27 08:17:47'),
	(6, 15, 1, 10, '2024-03-28 03:30:48', '2024-03-28 03:30:48'),
	(7, 16, 1, 10, '2024-03-28 03:34:15', '2024-03-28 03:34:15'),
	(8, 22, 1, 10, '2024-04-04 04:33:48', '2024-04-04 04:33:48'),
	(9, 24, 1, 10, '2024-04-05 03:05:00', '2024-04-05 03:05:00'),
	(10, 25, 1, 10, '2024-04-05 07:11:55', '2024-04-05 07:11:55'),
	(11, 26, 1, 10, '2024-04-05 07:16:22', '2024-04-05 07:16:22'),
	(12, 27, 1, 10, '2024-04-05 07:22:14', '2024-04-05 07:22:14');

-- Dumping data for table smoffice.detail_outlet_visits: ~0 rows (approximately)
INSERT INTO `detail_outlet_visits` (`id`, `header_visit_id`, `sales_amount`, `customer_id`, `store_name`, `market_name`, `mark`, `created_at`, `updated_at`) VALUES
	(1, 5, NULL, NULL, NULL, NULL, NULL, '2024-03-20 22:30:13', '2024-03-20 22:30:13'),
	(2, 7, 40, 1, NULL, NULL, NULL, '2024-03-22 06:37:41', '2024-03-22 06:37:41'),
	(3, 8, 30, NULL, 'Toko Plastik 50', 'Pasar Cibinong', 'Sebelah tukang perabotan', '2024-03-22 06:46:42', '2024-03-22 06:46:42'),
	(4, 9, 30, 2, NULL, NULL, NULL, '2024-03-23 05:40:59', '2024-03-23 05:40:59'),
	(5, 13, 40, NULL, 'Plastik Jaya', 'Cibinong', 'Sebelah tukang perabot', '2024-03-27 03:43:20', '2024-03-27 03:43:20'),
	(6, 14, 30, 1, NULL, NULL, NULL, '2024-03-27 08:17:47', '2024-03-27 08:17:47'),
	(7, 15, 30, NULL, NULL, NULL, NULL, '2024-03-28 03:30:48', '2024-03-28 03:30:48'),
	(8, 16, 20, NULL, NULL, NULL, NULL, '2024-03-28 03:34:15', '2024-03-28 03:34:15'),
	(9, 22, 50, NULL, NULL, NULL, NULL, '2024-04-04 04:33:48', '2024-04-04 04:33:48'),
	(10, 24, 50, 1, NULL, NULL, NULL, '2024-04-05 03:05:00', '2024-04-05 03:05:00'),
	(11, 25, 50, 1, NULL, NULL, NULL, '2024-04-05 07:11:55', '2024-04-05 07:11:55'),
	(12, 26, 40, 1, NULL, NULL, NULL, '2024-04-05 07:16:22', '2024-04-05 07:16:22'),
	(13, 27, 50, 1, NULL, NULL, NULL, '2024-04-05 07:22:14', '2024-04-05 07:22:14');

-- Dumping data for table smoffice.detail_store_visits: ~0 rows (approximately)
INSERT INTO `detail_store_visits` (`id`, `header_visit_id`, `category_product_id`, `display_product_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 4, 1, '2024-03-20 08:39:23', '2024-03-20 08:39:23'),
	(2, 1, 1, 1, '2024-03-20 08:39:23', '2024-03-20 08:39:23'),
	(3, 2, 4, 1, '2024-03-20 22:09:53', '2024-03-20 22:09:53'),
	(4, 2, 4, 1, '2024-03-20 22:10:25', '2024-03-20 22:10:25'),
	(5, 6, 4, 1, '2024-03-21 08:17:04', '2024-03-21 08:17:04'),
	(6, 6, 1, 2, '2024-03-21 08:17:04', '2024-03-21 08:17:04'),
	(7, 6, 3, 2, '2024-03-21 08:17:04', '2024-03-21 08:17:04'),
	(8, 10, 4, 1, '2024-03-25 09:33:37', '2024-03-25 09:33:37'),
	(9, 11, 4, 1, '2024-03-27 03:36:08', '2024-03-27 03:36:08'),
	(10, 11, 1, 1, '2024-03-27 03:36:08', '2024-03-27 03:36:08'),
	(11, 23, 4, 1, '2024-04-04 09:27:02', '2024-04-04 09:27:02');

-- Dumping data for table smoffice.header_visits: ~0 rows (approximately)
INSERT INTO `header_visits` (`id`, `date`, `serial`, `time_in`, `time_out`, `LA`, `LO`, `banner`, `status_registration`, `activity`, `note`, `customer_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, '2024-03-20', 1, '15:38:45', '15:39:23', '-6.1494622', '106.7131557', 0, 'N', 'Visit', 'notes', 10, 1, '2024-03-20 08:38:45', '2024-03-20 08:39:23'),
	(2, '2024-03-21', 1, '05:09:11', '05:10:25', '-6.2062592', '106.8531712', 0, 'N', 'Visit', 'notes', 10, 1, '2024-03-20 22:09:11', '2024-03-20 22:10:25'),
	(3, '2024-03-21', 2, '05:10:35', '05:12:12', '-6.2062592', '106.8531712', 0, 'N', 'Visit', 'notes', 2, 1, '2024-03-20 22:10:35', '2024-03-20 22:12:12'),
	(4, '2024-03-21', 3, '05:12:22', '05:12:42', '-6.2062592', '106.8531712', 0, 'N', 'Visit', 'pemilik tidak ramah', 4, 1, '2024-03-20 22:12:22', '2024-03-20 22:12:42'),
	(5, '2024-03-21', 4, '05:29:39', '05:30:13', '-6.2062592', '106.8531712', 0, 'N', 'Visit', 'Notes', 17, 1, '2024-03-20 22:29:39', '2024-03-20 22:30:13'),
	(6, '2024-03-21', 5, '15:16:15', '15:17:04', '-6.1485062', '106.7143568', 0, 'N', 'Visit', 'notes', 4, 1, '2024-03-21 08:16:15', '2024-03-21 08:17:04'),
	(7, '2024-03-22', 1, '13:35:41', '13:37:41', '-6.1439814', '106.7043106', 0, 'M', 'Visit', 'notes', 16, 1, '2024-03-22 06:35:41', '2024-03-22 06:37:41'),
	(8, '2024-03-22', 2, '13:45:31', '13:46:42', '-6.1439814', '106.7043106', 0, 'N', 'Visit', 'notes', 17, 1, '2024-03-22 06:45:31', '2024-03-22 06:46:42'),
	(9, '2024-03-23', 1, '12:39:53', '12:40:59', '-6.1484904', '106.7143477', 0, 'Y', 'Visit', 'notes', 17, 1, '2024-03-23 05:39:53', '2024-03-23 05:40:59'),
	(10, '2024-03-25', 1, '16:32:55', '16:33:37', '-6.1486731', '106.7315841', 0, 'N', 'Visit', 'notes', 10, 1, '2024-03-25 09:32:55', '2024-03-25 09:33:37'),
	(11, '2024-03-27', 1, '10:32:18', '10:36:08', NULL, NULL, 0, 'N', 'Visit', NULL, 2, 1, '2024-03-27 03:32:18', '2024-03-27 03:36:08'),
	(12, '2024-03-27', 1, '10:33:42', NULL, NULL, NULL, 0, 'N', NULL, NULL, 1, 2, '2024-03-27 03:33:42', '2024-03-27 03:33:42'),
	(13, '2024-03-27', 2, '10:38:53', '10:43:20', NULL, NULL, 0, 'M', 'Visit', NULL, 17, 1, '2024-03-27 03:38:53', '2024-03-27 03:43:20'),
	(14, '2024-03-27', 3, '10:57:30', '15:17:47', '-6.1521718', '106.7337956', 0, 'Y', 'Visit', NULL, 16, 1, '2024-03-27 03:57:30', '2024-03-27 08:17:47'),
	(15, '2024-03-28', 1, '10:27:45', '10:30:48', '-6.1494223', '106.7131557', 0, 'Y', 'Visit', NULL, 17, 1, '2024-03-28 03:27:45', '2024-03-28 03:30:48'),
	(16, '2024-03-28', 2, '10:33:32', '10:34:15', '-6.1494223', '106.7131557', 0, 'Y', 'Visit', NULL, 16, 1, '2024-03-28 03:33:32', '2024-03-28 03:34:15'),
	(17, '2024-03-28', 3, '13:57:42', '13:58:02', NULL, NULL, 0, 'N', 'Visit', NULL, 1, 1, '2024-03-28 06:57:42', '2024-03-28 06:58:02'),
	(18, '2024-03-28', 4, '14:00:55', '14:01:13', NULL, NULL, 0, 'N', 'Visit', NULL, 11, 1, '2024-03-28 07:00:55', '2024-03-28 07:01:13'),
	(19, '2024-03-28', 5, '14:03:10', '14:03:37', NULL, NULL, 0, 'N', 'Visit', NULL, 12, 1, '2024-03-28 07:03:10', '2024-03-28 07:03:37'),
	(20, '2024-03-28', 6, '16:31:28', NULL, NULL, NULL, 0, 'N', NULL, NULL, 11, 1, '2024-03-28 09:31:28', '2024-03-28 09:31:28'),
	(21, '2024-03-28', 7, '16:32:58', NULL, NULL, NULL, 0, 'N', NULL, NULL, 13, 1, '2024-03-28 09:32:58', '2024-03-28 09:32:58'),
	(22, '2024-04-04', 1, '11:30:35', '11:33:48', '-6.1494295', '106.7116815', 0, 'Y', 'Visit', NULL, 16, 1, '2024-04-04 04:30:35', '2024-04-04 04:33:48'),
	(23, '2024-04-04', 2, '16:25:49', '16:27:02', '-6.1494295', '106.7116815', 0, 'N', 'Visit', NULL, 12, 1, '2024-04-04 09:25:49', '2024-04-04 09:27:02'),
	(24, '2024-04-05', 1, '10:04:00', '10:05:00', '-6.1494295', '106.7116815', 0, 'Y', 'Visit', NULL, 24, 1, '2024-04-05 03:04:00', '2024-04-05 03:05:00'),
	(25, '2024-04-05', 2, '14:10:52', '14:11:55', '-6.1485247', '106.7143489', 0, 'Y', 'Visit', NULL, 24, 1, '2024-04-05 07:10:52', '2024-04-05 07:11:55'),
	(26, '2024-04-05', 3, '14:15:26', '14:16:21', '-6.1494295', '106.7116815', 0, 'N', 'Visit', NULL, 26, 1, '2024-04-05 07:15:26', '2024-04-05 07:16:21'),
	(27, '2024-04-05', 4, '14:21:28', '14:22:14', '-6.1494295', '106.7116815', 0, 'Y', 'Visit', NULL, 24, 1, '2024-04-05 07:21:28', '2024-04-05 07:22:14');

-- Dumping data for table smoffice.outlet_visit_products: ~0 rows (approximately)
INSERT INTO `outlet_visit_products` (`id`, `header_visit_id`, `product_id`, `purchase_price`, `created_at`, `updated_at`) VALUES
	(1, 7, 1, 500, '2024-03-22 06:37:41', '2024-03-22 06:37:41'),
	(2, 7, 4, 400, '2024-03-22 06:37:41', '2024-03-22 06:37:41'),
	(3, 8, 4, 400, '2024-03-22 06:46:42', '2024-03-22 06:46:42'),
	(4, 9, 1, 500, '2024-03-23 05:40:59', '2024-03-23 05:40:59'),
	(5, 13, 1, 500, '2024-03-27 03:43:20', '2024-03-27 03:43:20'),
	(6, 13, 4, 600, '2024-03-27 03:43:20', '2024-03-27 03:43:20'),
	(7, 14, 1, 500, '2024-03-27 08:17:47', '2024-03-27 08:17:47'),
	(8, 15, 1, 500, '2024-03-28 03:30:48', '2024-03-28 03:30:48'),
	(9, 16, 1, 500, '2024-03-28 03:34:15', '2024-03-28 03:34:15'),
	(10, 22, 1, 500, '2024-04-04 04:33:48', '2024-04-04 04:33:48'),
	(11, 24, 1, 500, '2024-04-05 03:05:00', '2024-04-05 03:05:00'),
	(12, 25, 1, 500, '2024-04-05 07:11:55', '2024-04-05 07:11:55'),
	(13, 26, 4, 400, '2024-04-05 07:16:22', '2024-04-05 07:16:22'),
	(14, 27, 1, 500, '2024-04-05 07:22:14', '2024-04-05 07:22:14');

-- Dumping data for table smoffice.outlet_visit_unproductive_reasons: ~0 rows (approximately)
INSERT INTO `outlet_visit_unproductive_reasons` (`id`, `header_visit_id`, `unproductive_reason_id`, `created_at`, `updated_at`) VALUES
	(1, 7, 4, '2024-03-22 06:37:41', '2024-03-22 06:37:41'),
	(2, 7, 5, '2024-03-22 06:37:41', '2024-03-22 06:37:41'),
	(3, 8, 4, '2024-03-22 06:46:42', '2024-03-22 06:46:42'),
	(4, 9, 5, '2024-03-23 05:40:59', '2024-03-23 05:40:59'),
	(5, 13, 5, '2024-03-27 03:43:20', '2024-03-27 03:43:20'),
	(6, 26, 6, '2024-04-05 07:16:22', '2024-04-05 07:16:22');

-- Dumping data for table smoffice.store_visit_brands: ~0 rows (approximately)
INSERT INTO `store_visit_brands` (`id`, `header_visit_id`, `brand_product_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 2, '2024-03-20 08:39:23', '2024-03-20 08:39:23'),
	(2, 1, 1, '2024-03-20 08:39:23', '2024-03-20 08:39:23'),
	(3, 2, 2, '2024-03-20 22:09:53', '2024-03-20 22:09:53'),
	(4, 2, 2, '2024-03-20 22:10:25', '2024-03-20 22:10:25'),
	(5, 6, 2, '2024-03-21 08:17:04', '2024-03-21 08:17:04'),
	(6, 6, 1, '2024-03-21 08:17:04', '2024-03-21 08:17:04'),
	(7, 10, 2, '2024-03-25 09:33:37', '2024-03-25 09:33:37'),
	(8, 10, 1, '2024-03-25 09:33:37', '2024-03-25 09:33:37'),
	(9, 11, 2, '2024-03-27 03:36:08', '2024-03-27 03:36:08'),
	(10, 23, 2, '2024-04-04 09:27:02', '2024-04-04 09:27:02');

-- Dumping data for table smoffice.store_visit_unproductive_reasons: ~0 rows (approximately)
INSERT INTO `store_visit_unproductive_reasons` (`id`, `header_visit_id`, `unproductive_reason_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 2, '2024-03-20 08:39:23', '2024-03-20 08:39:23'),
	(2, 11, 12, '2024-03-27 03:36:08', '2024-03-27 03:36:08'),
	(3, 17, 2, '2024-03-28 06:58:02', '2024-03-28 06:58:02'),
	(4, 18, 2, '2024-03-28 07:01:13', '2024-03-28 07:01:13'),
	(5, 19, 12, '2024-03-28 07:03:37', '2024-03-28 07:03:37');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
