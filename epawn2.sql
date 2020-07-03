-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 03, 2020 at 01:25 PM
-- Server version: 5.7.24
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epawn`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(21, '2020_02_27_142400_create_z_packages_table', 1),
(22, '2020_02_27_142511_create_z_pawned_items_table', 1),
(23, '2020_02_27_142542_create_z_package_durations_table', 1),
(24, '2020_02_28_060126_create_z_payments_table', 1),
(25, '2020_03_12_143146_create_z_notifictions_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bid_item`
--

CREATE TABLE `tbl_bid_item` (
  `id` int(11) NOT NULL,
  `item_id` int(50) NOT NULL,
  `bid_price` double(20,2) DEFAULT NULL,
  `bid_from` double(10,2) DEFAULT NULL,
  `bid_to` double(10,2) DEFAULT NULL,
  `user_id` int(50) NOT NULL,
  `pawnshop_id` int(11) NOT NULL,
  `bid_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isFromPawnshop` int(11) NOT NULL DEFAULT '1',
  `interest_per_durationdays` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_bid_item`
--

INSERT INTO `tbl_bid_item` (`id`, `item_id`, `bid_price`, `bid_from`, `bid_to`, `user_id`, `pawnshop_id`, `bid_date`, `isFromPawnshop`, `interest_per_durationdays`) VALUES
(111, 76, NULL, 2000.00, 4000.00, 48, 25, '2020-03-11 04:31:43', 1, 0.00),
(112, 76, NULL, 4000.00, 6000.00, 48, 23, '2020-03-11 04:32:43', 1, 0.00),
(113, 76, NULL, 2000.00, 3500.00, 48, 26, '2020-03-11 04:34:38', 1, 0.00),
(114, 77, NULL, 1000.00, 3000.00, 48, 23, '2020-03-11 04:41:32', 1, 0.00),
(115, 77, 3000.00, NULL, NULL, 48, 23, '2020-03-11 04:42:03', 0, 0.00),
(116, 78, NULL, 3000.00, 4000.00, 48, 23, '2020-03-11 04:47:31', 1, 0.00),
(117, 78, 4000.00, NULL, NULL, 48, 23, '2020-03-11 04:47:51', 0, 0.00),
(118, 78, 4000.00, NULL, NULL, 48, 23, '2020-03-11 04:47:52', 0, 0.00),
(121, 96, NULL, 1000.00, 3000.00, 48, 23, '2020-03-11 12:52:31', 1, 0.00),
(122, 96, 3000.00, NULL, NULL, 48, 23, '2020-03-11 12:53:17', 0, 0.00),
(123, 97, NULL, 5000.00, 10000.00, 51, 23, '2020-03-11 12:58:25', 1, 0.00),
(124, 97, 10000.00, 0.00, 0.00, 51, 23, '2020-03-11 13:03:56', 0, 0.00),
(125, 76, 3500.00, 0.00, 0.00, 48, 26, '2020-03-13 01:48:40', 0, 0.00),
(126, 76, 3500.00, 0.00, 0.00, 48, 26, '2020-03-13 01:48:43', 0, 0.00),
(127, 76, 4000.00, 0.00, 0.00, 48, 23, '2020-03-13 01:49:50', 0, 0.00),
(128, 76, 4000.00, 0.00, 0.00, 48, 23, '2020-03-13 01:50:12', 0, 0.00),
(129, 76, 5486.00, 0.00, 0.00, 48, 23, '2020-03-13 01:54:16', 0, 0.00),
(130, 76, 2740.00, 0.00, 0.00, 48, 26, '2020-03-13 01:55:18', 0, 0.00),
(131, 86, NULL, 50.00, 2000.00, 50, 23, '2020-03-13 02:00:20', 1, 0.00),
(132, 98, NULL, 2000.00, 3000.00, 48, 23, '2020-03-13 02:03:11', 1, 0.00),
(133, 98, 3000.00, NULL, NULL, 48, 23, '2020-03-13 02:03:49', 0, 0.00),
(134, 76, 5223.00, NULL, NULL, 48, 23, '2020-03-13 05:20:03', 0, 0.00),
(135, 98, NULL, 1000.00, 5000.00, 48, 23, '2020-04-10 12:56:29', 1, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gender`
--

CREATE TABLE `tbl_gender` (
  `gender_id` int(10) NOT NULL,
  `gender` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_item_accepted`
--

CREATE TABLE `tbl_item_accepted` (
  `id` int(11) NOT NULL,
  `user_id` int(50) NOT NULL,
  `accepted_item` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_item_category`
--

CREATE TABLE `tbl_item_category` (
  `category_id` int(5) NOT NULL,
  `category_name` varchar(30) NOT NULL,
  `category_description` text NOT NULL,
  `valid` int(11) NOT NULL DEFAULT '1',
  `fromUser` int(11) DEFAULT NULL,
  `category_reason` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_item_category`
--

INSERT INTO `tbl_item_category` (`category_id`, `category_name`, `category_description`, `valid`, `fromUser`, `category_reason`) VALUES
(4, 'Gold & Jewelries', 'Mga Gold og alahas', 1, 20, NULL),
(5, 'Appliances', 'Mga kagamitang de kuryente.', 1, 20, NULL),
(6, 'Machines', 'Mga kagamitang di makina', 1, 20, NULL),
(7, 'Gadgets / Devices', 'Mga gadgets', 1, 20, NULL),
(9, 'Sample', 'SAmple lng', 1, 23, NULL),
(10, 'MGA GULAY', 'LAMI MAN GUD MAG SALAD UG GULAY', 3, 23, 'Buang ka... Unsa ni dri gulayan'),
(11, 'MGA BAKAL', 'BAKAL NA DILI TAYA', 1, 23, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_item_photo`
--

CREATE TABLE `tbl_item_photo` (
  `id` int(11) NOT NULL,
  `item_id` int(50) NOT NULL,
  `item_photos` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_package_duration`
--

CREATE TABLE `tbl_package_duration` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `package_id` int(11) DEFAULT NULL,
  `duration_from` int(11) DEFAULT NULL,
  `duration_to` int(11) DEFAULT NULL,
  `interestRate` double(10,2) DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_package_duration`
--

INSERT INTO `tbl_package_duration` (`id`, `package_id`, `duration_from`, `duration_to`, `interestRate`, `created_at`, `updated_at`) VALUES
(3, 30, 1, 15, 2.00, NULL, NULL),
(4, 30, 16, 30, 5.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pawned_items`
--

CREATE TABLE `tbl_pawned_items` (
  `pawned_id` int(11) NOT NULL,
  `pawnshop_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `user_Id` int(11) NOT NULL,
  `days_deadline` int(11) DEFAULT NULL,
  `months_ext` int(11) DEFAULT NULL,
  `pawn_reason` varchar(600) NOT NULL,
  `pawn_amount` double(10,2) DEFAULT NULL,
  `payable` double(10,2) NOT NULL,
  `interest_rate` double(10,2) NOT NULL,
  `interest_per_durationdays` double(10,2) NOT NULL,
  `bid_from` int(111) DEFAULT NULL,
  `bid_to` int(111) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pawnshop_info`
--

CREATE TABLE `tbl_pawnshop_info` (
  `p_id` int(50) NOT NULL,
  `description` text NOT NULL,
  `user_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pawnshop_itemcategory`
--

CREATE TABLE `tbl_pawnshop_itemcategory` (
  `pawnshop_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pawnshop_itemcategory`
--

INSERT INTO `tbl_pawnshop_itemcategory` (`pawnshop_id`, `category_id`) VALUES
(23, 4),
(23, 7),
(23, 9),
(25, 4),
(25, 5),
(25, 6),
(25, 7),
(26, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pawnshop_package`
--

CREATE TABLE `tbl_pawnshop_package` (
  `package_id` int(11) NOT NULL,
  `package_name` text NOT NULL,
  `pawnshop_id` int(11) NOT NULL,
  `package_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment`
--

CREATE TABLE `tbl_payment` (
  `id` int(11) NOT NULL,
  `pawned_id` int(11) NOT NULL,
  `payment` double(10,2) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(20) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `gender_id` int(10) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `address` varchar(200) NOT NULL,
  `contact` varchar(11) NOT NULL,
  `email` varchar(40) NOT NULL,
  `image` varchar(200) NOT NULL,
  `business_permit` varchar(255) DEFAULT NULL,
  `control_num` varchar(255) DEFAULT NULL,
  `role_id` int(5) NOT NULL,
  `branch` varchar(200) NOT NULL,
  `latitude` text,
  `longtitude` text,
  `isValid` int(11) NOT NULL DEFAULT '0',
  `reason` text,
  `joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `noticed` timestamp NULL DEFAULT NULL,
  `flag` int(11) NOT NULL DEFAULT '0',
  `monthCofescation` int(11) NOT NULL,
  `is_email_verified` int(11) DEFAULT NULL,
  `confirmation_code` int(11) DEFAULT NULL,
  `expiration` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `fname`, `gender_id`, `username`, `password`, `address`, `contact`, `email`, `image`, `business_permit`, `control_num`, `role_id`, `branch`, `latitude`, `longtitude`, `isValid`, `reason`, `joined`, `noticed`, `flag`, `monthCofescation`, `is_email_verified`, `confirmation_code`, `expiration`) VALUES
(1, 'admin', 0, 'admin', 'admin', '', '', 'admin@admin.com', '', NULL, NULL, 1, '', '', '', 0, NULL, '2020-02-17 08:13:52', NULL, 0, 0, NULL, NULL, NULL),
(2, 'Super Admin 2', 0, 'Super Admin 2', 'admin', '', '', 'admin@gmail.com', '', NULL, NULL, 1, '', '', '', 0, NULL, '2020-02-17 08:13:52', NULL, 0, 0, NULL, NULL, NULL),
(23, 'RD Pawnshop', 0, 'RD Pawnshop', 'rd123', 'Door 2, Building 1, Golden Mat', '09261143433', 'rd@gmail.com', '1584585493Pinakamababa.png', '1583900614FB_IMG_1560417528415.jpg', '100698', 2, '', '7.062916', '125.598717', 1, NULL, '2020-03-01 17:14:42', '2020-03-22 11:42:44', 0, 4, NULL, NULL, '2020-04-22 12:42:44'),
(25, 'MLHUILLIER', 0, 'MLHUILLIER', 'ml123', 'UM Drive, Matina, Davao City', '09197915459', 'ml@gmail.com', '1583901019download (3).png', '1583901019download (3).jpg', '99666', 2, '', '7.063407', '125.598729', 3, NULL, '2020-03-01 17:29:14', '2020-03-02 02:32:27', 0, 3, NULL, NULL, '2020-03-18 00:00:00'),
(26, 'Cebuana', 0, 'Cebuana', 'cb123', '80 Gen, Douglas MacArthur Hwy,', '09381965306', 'cebuana@gmail.com', '1583901232download (2).png', '1583901232images.jpg', '63709', 2, '', '7.063143', '125.597943', 3, NULL, '2020-03-01 17:34:15', '2020-03-02 02:32:33', 0, 4, NULL, NULL, '2020-03-19 00:00:00'),
(48, 'Jeremiah Revil', 0, 'Jeremiah Revil', '1234', 'Matina Crossing, Davao City', '63950759927', 'maya_revil@yahoo.com', 'gray.jpg', NULL, NULL, 3, '', NULL, NULL, 0, NULL, '2020-03-11 04:09:53', NULL, 0, 0, 1, 20118, NULL),
(49, 'Fernando', 0, 'Fernando', '1234', ' Matina Pangi, Davao del Sur', '09121231234', 'layaofernd@gmail.com', 'gray2.jpg', NULL, NULL, 3, '', '7.0780908', '125.6088323', 0, NULL, '2020-03-11 04:55:03', NULL, 0, 0, 1, 89577, NULL),
(50, 'Francis', 0, 'Francis', '12041996', 'Almendras davao city', '63966681740', 'Kokoydegorio@gmail.com', '50user_profile1583904338826.jpg', NULL, NULL, 3, '', NULL, NULL, 0, NULL, '2020-03-11 04:56:03', NULL, 0, 0, 1, 35745, NULL),
(51, 'Totzkie', 0, 'Totzkie', 'password', 'Matina Aplaya Davao', '63912123123', 'abing.pj@gmail.com', '51user_profile1583938443592.jpg', NULL, NULL, 3, '', '7.0780916', '125.6088206', 0, NULL, '2020-03-11 08:44:08', NULL, 0, 0, 1, 63067, NULL),
(52, 'Yawa', 0, 'Yawa', '123', 'Taga yawa', '63930900886', 'potangina@gmail.com', '', NULL, NULL, 3, '', '7.0655451', '125.5618585', 0, NULL, '2020-03-12 10:19:42', NULL, 0, 0, 0, 42805, NULL),
(53, 'bingz company', 0, 'bingz company', 'password', 'Matina Aplaya, Davao City', '09121231234', 'bingz@gmail.com', '', '1584065384FB_IMG_1560417528415.jpg', '112233', 2, '', NULL, NULL, 3, NULL, '2020-03-13 02:09:44', '2020-03-13 09:10:50', 0, 0, NULL, NULL, '2020-03-12 10:10:50');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_itempost`
--

CREATE TABLE `tbl_user_itempost` (
  `item_id` int(50) NOT NULL,
  `item_name` varchar(30) NOT NULL,
  `item_description` text NOT NULL,
  `item_photo` varchar(255) NOT NULL,
  `photo_1` text NOT NULL,
  `photo_2` text NOT NULL,
  `photo_3` text NOT NULL,
  `photo_4` text NOT NULL,
  `category_id` int(10) NOT NULL,
  `user_id` int(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '0',
  `pawnshop_id` int(11) DEFAULT NULL,
  `initial_amount` double(10,2) NOT NULL,
  `isExpired` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_itempost`
--

INSERT INTO `tbl_user_itempost` (`item_id`, `item_name`, `item_description`, `item_photo`, `photo_1`, `photo_2`, `photo_3`, `photo_4`, `category_id`, `user_id`, `date`, `status`, `pawnshop_id`, `initial_amount`, `isExpired`) VALUES
(76, 'Wedding ring clasdic style', '2.5g pure saudi gold', '48item_picture_main1583900414414.jpg', '48item_other_pictures11583900414414.jpg', '48item_other_pictures21583900414414.jpg', '48item_other_pictures31583900414414.jpg', '48item_other_picture41583900414414.jpg', 4, 48, '2020-03-11 04:20:21', 0, NULL, 0.00, 1),
(77, 'Engagement ring', '1.1 G', '48item_picture_main1583901623279.jpg', '48item_other_pictures11583901623279.jpg', '48item_other_pictures21583901623279.jpg', '48item_other_pictures31583901623279.jpg', '48item_other_picture41583901623279.jpg', 4, 48, '2020-03-11 04:40:38', 1, 23, 3000.00, 1),
(78, 'Heart Necklace Gold', '18k saudi gold necklace', '48item_picture_main1583902020667.jpg', '48item_other_pictures11583902020667.jpg', '48item_other_pictures21583902020667.jpg', '48item_other_pictures31583902020667.jpg', '48item_other_picture41583902020667.jpg', 4, 48, '2020-03-11 04:47:04', 2, 23, 4000.00, 1),
(79, 'Samsung Galaxy S20', 'High definition camero up to 45mp', '49item_picture_main1583902702771.jpg', '49item_other_pictures11583902702771.jpg', '49item_other_pictures21583902702771.jpg', '49item_other_pictures31583902702771.jpg', '49item_other_picture41583902702771.jpg', 7, 49, '2020-03-11 04:58:31', 0, NULL, 0.00, 1),
(80, 'Cannon Dslr Camera', 'Dslr camera', '49item_picture_main1583902882491.jpg', '49item_other_pictures11583902882491.jpg', '49item_other_pictures21583902882491.jpg', '49item_other_pictures31583902882491.jpg', '49item_other_picture41583902882491.jpg', 7, 49, '2020-03-11 05:01:28', 0, NULL, 0.00, 1),
(81, 'Sonny Dslr Camera', 'Dslr', '49item_picture_main1583902922248.jpg', '49item_other_pictures11583902922248.jpg', '49item_other_pictures21583902922248.jpg', '49item_other_pictures31583902922248.jpg', '49item_other_picture41583902922248.jpg', 7, 49, '2020-03-11 05:02:06', 0, NULL, 0.00, 1),
(82, 'Samsung tv 2001 model style', 'Old but its work', '49item_picture_main1583902974826.jpg', '49item_other_pictures11583902974826.jpg', '49item_other_pictures21583902974826.jpg', '49item_other_pictures31583902974826.jpg', '49item_other_picture41583902974826.jpg', 5, 49, '2020-03-11 05:02:59', 0, NULL, 0.00, 1),
(83, 'Skyworth smart tv', 'Si smart', '49item_picture_main1583903134532.jpg', '49item_other_pictures11583903134532.jpg', '49item_other_pictures21583903134532.jpg', '49item_other_pictures31583903134532.jpg', '49item_other_picture41583903134532.jpg', 5, 49, '2020-03-11 05:05:37', 0, NULL, 0.00, 1),
(84, 'Welding Machine', 'Small but terrible', '49item_picture_main1583903270548.jpg', '49item_other_pictures11583903270548.jpg', '49item_other_pictures21583903270548.jpg', '49item_other_pictures31583903270548.jpg', '49item_other_picture41583903270548.jpg', 6, 49, '2020-03-11 05:07:52', 0, NULL, 0.00, 1),
(85, 'Magic Sing Microphone', 'Oye', '50item_picture_main1583903427590.jpg', '50item_other_pictures11583903427590.jpg', '50item_other_pictures21583903427590.jpg', '50item_other_pictures31583903427590.jpg', '50item_other_picture41583903427590.jpg', 5, 50, '2020-03-11 05:10:31', 0, NULL, 0.00, 1),
(86, 'Bracelet', '18k saudi gold', '50item_picture_main1583904121877.jpg', '50item_other_pictures11583904121877.jpg', '50item_other_pictures21583904121877.jpg', '50item_other_pictures31583904121877.jpg', '50item_other_picture41583904121877.jpg', 4, 50, '2020-03-11 05:22:04', 0, NULL, 0.00, 1),
(87, 'Heart pendant', 'Necklace', '50item_picture_main1583904151238.jpg', '50item_other_pictures11583904151238.jpg', '50item_other_pictures21583904151238.jpg', '50item_other_pictures31583904151238.jpg', '50item_other_picture41583904151238.jpg', 4, 50, '2020-03-11 05:22:35', 0, NULL, 0.00, 1),
(88, 'Necklace Cross Pendant', '18k Saudi Gold\r\n3G', '49item_picture_main1583904684438.jpg', '49item_other_pictures11583904684438.jpg', '49item_other_pictures21583904684438.jpg', '49item_other_pictures31583904684438.jpg', '49item_other_picture41583904684438.jpg', 4, 49, '2020-03-11 05:31:27', 0, NULL, 0.00, 1),
(89, 'Necklace Cross Pendant 2', '18k Saudi Gold, 3.5G', '49item_picture_main1583904708864.jpg', '49item_other_pictures11583904708864.jpg', '49item_other_pictures21583904708864.jpg', '49item_other_pictures31583904708864.jpg', '49item_other_picture41583904708864.jpg', 4, 49, '2020-03-11 05:31:52', 0, NULL, 0.00, 1),
(90, 'Engagement ring', 'Engagement ring with 1 diamind', '50item_picture_main1583914254020.jpg', '50item_other_pictures11583914254020.jpg', '50item_other_pictures21583914254020.jpg', '50item_other_pictures31583914254020.jpg', '50item_other_picture41583914254020.jpg', 4, 50, '2020-03-11 08:11:01', 0, NULL, 0.00, 1),
(91, 'Gold earrings', '18k gold earrings with 5 peso coin', '50item_picture_main1583914320925.jpg', '50item_other_pictures11583914320925.jpg', '50item_other_pictures21583914320925.jpg', '50item_other_pictures31583914320925.jpg', '50item_other_picture41583914320925.jpg', 4, 50, '2020-03-11 08:12:11', 0, NULL, 0.00, 1),
(92, 'Gold Necklace with heart penda', '18k gold, 8 grams', '50item_picture_main1583914404905.jpg', '50item_other_pictures11583914404905.jpg', '50item_other_pictures21583914404905.jpg', '50item_other_pictures31583914404905.jpg', '50item_other_picture41583914404905.jpg', 4, 50, '2020-03-11 08:13:31', 0, NULL, 0.00, 1),
(93, 'Bracelet', '.', '50item_picture_main1583914500384.jpg', '50item_other_pictures11583914500384.jpg', '50item_other_pictures21583914500384.jpg', '50item_other_pictures31583914500384.jpg', '50item_other_picture41583914500384.jpg', 4, 50, '2020-03-11 08:15:21', 0, NULL, 0.00, 1),
(94, 'Wedding Ring', '18k india gold. 3.5grams', '50item_picture_main1583914821726.jpg', '50item_other_pictures11583914821726.jpg', '50item_other_pictures21583914821726.jpg', '50item_other_pictures31583914821726.jpg', '50item_other_picture41583914821726.jpg', 4, 50, '2020-03-11 08:23:38', 0, NULL, 0.00, 1),
(96, 'Er', 'Er', '48item_picture_main1583931050853.jpg', '48item_other_pictures11583931050853.jpg', '48item_other_pictures21583931050853.jpg', '48item_other_pictures31583931050853.jpg', '48item_other_picture41583931050853.jpg', 4, 48, '2020-03-11 12:51:09', 2, 23, 3000.00, 1),
(97, 'Aryos', 'Aryos', '51item_picture_main1583931416318.jpg', '51item_other_pictures11583931416318.jpg', '51item_other_pictures21583931416318.jpg', '51item_other_pictures31583931416318.jpg', '51item_other_picture41583931416318.jpg', 4, 51, '2020-03-11 12:57:12', 2, 23, 10000.00, 1),
(98, 'Bracelet 18k', 'Bracelet', '48item_picture_main1584064745970.jpg', '48item_other_pictures11584064745970.jpg', '48item_other_pictures21584064745970.jpg', '48item_other_pictures31584064745970.jpg', '48item_other_picture41584064745970.jpg', 4, 48, '2020-03-13 01:59:07', 0, NULL, 0.00, 1),
(99, 'Engagement Ring simple style', '18k saudi gold', '48item_picture_main1584075947145.jpg', '48item_other_pictures11584075947145.jpg', '48item_other_pictures21584075947145.jpg', '48item_other_pictures31584075947145.jpg', '48item_other_picture41584075947145.jpg', 4, 48, '2020-03-13 05:05:52', 0, NULL, 0.00, 1),
(100, 'Gold Earrings', '18k saudi Gold, 1.2g each', '48item_picture_main1584076093719.jpg', '48item_other_pictures11584076093719.jpg', '48item_other_pictures21584076093719.jpg', '48item_other_pictures31584076093719.jpg', '48item_other_picture41584076093719.jpg', 4, 48, '2020-03-13 05:08:21', 0, NULL, 0.00, 1),
(101, 'Item fetch through camera', 'Camera gamit sa isa', '48item_picture_main1584119124529.jpg', '48item_other_pictures11584119124529.jpg', '48item_other_pictures21584119124529.jpg', '48item_other_pictures31584119124529.jpg', '48item_other_picture41584119124529.jpg', 7, 48, '2020-03-13 17:06:02', 0, NULL, 0.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_reports`
--

CREATE TABLE `tbl_user_reports` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `pawnshopId` int(11) DEFAULT NULL,
  `situation` text,
  `isFromPawnshop` int(11) DEFAULT NULL,
  `dateReported` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_reports`
--

INSERT INTO `tbl_user_reports` (`id`, `userId`, `pawnshopId`, `situation`, `isFromPawnshop`, `dateReported`) VALUES
(15, 48, 23, 'ok reported', 1, '2020-04-01 16:42:44');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_role`
--

CREATE TABLE `tbl_user_role` (
  `role_id` int(5) NOT NULL,
  `role` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_role`
--

INSERT INTO `tbl_user_role` (`role_id`, `role`) VALUES
(1, 'Superadmin'),
(2, 'Admin'),
(3, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `z_notifictions`
--

CREATE TABLE `z_notifictions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) DEFAULT NULL,
  `pawnshop_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `link` text COLLATE utf8mb4_unicode_ci,
  `title` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seen` tinyint(4) DEFAULT '0',
  `isFromPawnshop` tinyint(4) DEFAULT '0',
  `date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `z_notifictions`
--

INSERT INTO `z_notifictions` (`id`, `item_id`, `pawnshop_id`, `user_id`, `link`, `title`, `description`, `type`, `seen`, `isFromPawnshop`, `date`, `created_at`, `updated_at`) VALUES
(5, 76, 23, 48, '/Bidding/76/bidderId/48?itemId=76&biderId=48', 'New Bid', '', 'bid', 1, 0, '2020-03-13 09:54:16', '2020-03-13 08:54:16', '2020-03-13 09:04:03'),
(6, 76, 26, 48, '/Bidding/76/bidderId/48?itemId=76&biderId=48', 'New Bid', '', 'bid', 1, 0, '2020-03-13 09:55:18', '2020-03-13 08:55:18', '2020-03-14 21:34:35'),
(7, 98, 23, 48, '/Bidding/98/bidderId/48?itemId=98&biderId=48', 'New Bid', '', 'bid', 1, 0, '2020-03-13 10:03:49', '2020-03-13 09:03:49', '2020-03-13 09:04:11'),
(8, 76, 23, 48, '/Bidding/76/bidderId/48?itemId=76&biderId=48', 'New Bid', '', 'bid', 1, 0, '2020-03-13 13:20:03', '2020-03-13 12:20:03', '2020-03-13 12:20:51');

-- --------------------------------------------------------

--
-- Table structure for table `z_packages`
--

CREATE TABLE `z_packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pawnshop_id` bigint(20) DEFAULT NULL,
  `package_name` text COLLATE utf8mb4_unicode_ci,
  `package_description` text COLLATE utf8mb4_unicode_ci,
  `number_of_month` int(11) DEFAULT '0',
  `interest_per_month` double(10,2) DEFAULT '0.00',
  `pinalty_per_month` double(10,2) DEFAULT '0.00',
  `if_advance_interest` int(11) DEFAULT '0',
  `if_has_special_offer` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `z_packages`
--

INSERT INTO `z_packages` (`id`, `pawnshop_id`, `package_name`, `package_description`, `number_of_month`, `interest_per_month`, `pinalty_per_month`, `if_advance_interest`, `if_has_special_offer`, `created_at`, `updated_at`) VALUES
(29, 23, '1 Month Advance Interest Package', NULL, 4, 2.00, 1.00, 1, 0, '2020-03-11 11:27:00', '2020-03-14 22:47:03'),
(30, 25, 'Default', 'shits', 3, 3.00, 2.00, 1, 0, '2020-03-11 11:31:05', '2020-03-14 22:26:37'),
(31, 26, 'Default For Jewelries', NULL, 4, 3.00, 2.00, 1, 0, '2020-03-11 11:34:10', '2020-03-11 11:34:10');

-- --------------------------------------------------------

--
-- Table structure for table `z_pawned_items`
--

CREATE TABLE `z_pawned_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) DEFAULT NULL,
  `package_id` bigint(20) DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `pawnshop_id` bigint(20) DEFAULT NULL,
  `pawn_amount` double(10,2) DEFAULT NULL,
  `date_pawned` datetime DEFAULT NULL,
  `date_renew` datetime DEFAULT NULL,
  `date_claimed` datetime DEFAULT NULL,
  `is_claimed` int(11) DEFAULT '0',
  `is_confiscated` int(11) DEFAULT '0',
  `is_rejected` int(11) DEFAULT '0',
  `rejected_reason` text COLLATE utf8mb4_unicode_ci,
  `days_deadline` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `z_pawned_items`
--

INSERT INTO `z_pawned_items` (`id`, `item_id`, `package_id`, `customer_id`, `pawnshop_id`, `pawn_amount`, `date_pawned`, `date_renew`, `date_claimed`, `is_claimed`, `is_confiscated`, `is_rejected`, `rejected_reason`, `days_deadline`, `created_at`, `updated_at`) VALUES
(6, 78, 29, 48, 23, 4000.00, '2020-03-11 12:48:23', '2020-03-11 12:48:23', NULL, 0, 0, 0, NULL, 7, '2020-03-11 11:48:23', '2020-03-11 11:48:23'),
(8, 96, 29, 48, 23, 3000.00, '2020-03-11 20:53:55', '2020-03-11 20:53:55', '2020-03-11 20:54:45', 1, 0, 0, NULL, 5, '2020-03-11 19:53:55', '2020-03-11 19:54:45'),
(9, 97, 29, 51, 23, 10000.00, '2019-11-25 21:04:58', '2019-11-25 21:04:58', NULL, 0, 1, 0, NULL, 5, '2020-03-11 20:04:58', '2020-04-10 13:07:07');

-- --------------------------------------------------------

--
-- Table structure for table `z_payments`
--

CREATE TABLE `z_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) NOT NULL,
  `pawned_item_id` bigint(20) NOT NULL,
  `payment_type` int(11) NOT NULL DEFAULT '1',
  `payment_type_desc` text COLLATE utf8mb4_unicode_ci,
  `amount` double(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `z_payments`
--

INSERT INTO `z_payments` (`id`, `item_id`, `pawned_item_id`, `payment_type`, `payment_type_desc`, `amount`, `created_at`, `updated_at`) VALUES
(1, 96, 8, 1, 'claim', 3000.00, '2020-03-11 19:54:45', '2020-03-11 19:54:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_bid_item`
--
ALTER TABLE `tbl_bid_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_gender`
--
ALTER TABLE `tbl_gender`
  ADD PRIMARY KEY (`gender_id`);

--
-- Indexes for table `tbl_item_accepted`
--
ALTER TABLE `tbl_item_accepted`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_item_category`
--
ALTER TABLE `tbl_item_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_item_photo`
--
ALTER TABLE `tbl_item_photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `tbl_package_duration`
--
ALTER TABLE `tbl_package_duration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pawned_items`
--
ALTER TABLE `tbl_pawned_items`
  ADD PRIMARY KEY (`pawned_id`);

--
-- Indexes for table `tbl_pawnshop_info`
--
ALTER TABLE `tbl_pawnshop_info`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_pawnshop_itemcategory`
--
ALTER TABLE `tbl_pawnshop_itemcategory`
  ADD PRIMARY KEY (`pawnshop_id`,`category_id`);

--
-- Indexes for table `tbl_pawnshop_package`
--
ALTER TABLE `tbl_pawnshop_package`
  ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `role` (`role_id`),
  ADD KEY `gender_id` (`gender_id`);

--
-- Indexes for table `tbl_user_itempost`
--
ALTER TABLE `tbl_user_itempost`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `tbl_user_reports`
--
ALTER TABLE `tbl_user_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_role`
--
ALTER TABLE `tbl_user_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `z_notifictions`
--
ALTER TABLE `z_notifictions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `z_packages`
--
ALTER TABLE `z_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `z_pawned_items`
--
ALTER TABLE `z_pawned_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `z_payments`
--
ALTER TABLE `z_payments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_bid_item`
--
ALTER TABLE `tbl_bid_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `tbl_gender`
--
ALTER TABLE `tbl_gender`
  MODIFY `gender_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_item_accepted`
--
ALTER TABLE `tbl_item_accepted`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_item_category`
--
ALTER TABLE `tbl_item_category`
  MODIFY `category_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_item_photo`
--
ALTER TABLE `tbl_item_photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_package_duration`
--
ALTER TABLE `tbl_package_duration`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_pawned_items`
--
ALTER TABLE `tbl_pawned_items`
  MODIFY `pawned_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_pawnshop_info`
--
ALTER TABLE `tbl_pawnshop_info`
  MODIFY `p_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_pawnshop_package`
--
ALTER TABLE `tbl_pawnshop_package`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `tbl_user_itempost`
--
ALTER TABLE `tbl_user_itempost`
  MODIFY `item_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `tbl_user_reports`
--
ALTER TABLE `tbl_user_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_user_role`
--
ALTER TABLE `tbl_user_role`
  MODIFY `role_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `z_notifictions`
--
ALTER TABLE `z_notifictions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `z_packages`
--
ALTER TABLE `z_packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `z_pawned_items`
--
ALTER TABLE `z_pawned_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `z_payments`
--
ALTER TABLE `z_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_item_photo`
--
ALTER TABLE `tbl_item_photo`
  ADD CONSTRAINT `tbl_item_photo_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `tbl_user_itempost` (`item_id`);

--
-- Constraints for table `tbl_user_itempost`
--
ALTER TABLE `tbl_user_itempost`
  ADD CONSTRAINT `tbl_user_itempost_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `tbl_item_category` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
