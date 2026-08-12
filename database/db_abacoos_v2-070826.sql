-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 08, 2026 at 09:15 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_abacoos_v2`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `a_id` int(11) NOT NULL,
  `t_id` int(11) NOT NULL DEFAULT 0,
  `account_name` text DEFAULT NULL,
  `date_added` varchar(20) DEFAULT NULL,
  `added_by` int(11) NOT NULL DEFAULT 0,
  `date_deleted` varchar(20) DEFAULT NULL,
  `deleted_by` int(11) NOT NULL DEFAULT 0,
  `is_deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`a_id`, `t_id`, `account_name`, `date_added`, `added_by`, `date_deleted`, `deleted_by`, `is_deleted`) VALUES
(1, 1, 'Thaddeus Mcneil', '2026-04-10 14:07:36', 31, '2026-04-10 14:21:00', 31, 0),
(2, 1, 'Marsden Rutledge', '2026-04-16 14:11:04', 31, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `t_id` int(11) NOT NULL DEFAULT 0 COMMENT 'tenant_id',
  `module` varchar(70) NOT NULL DEFAULT '0',
  `action` varchar(400) NOT NULL,
  `description` text NOT NULL,
  `action_by` int(11) NOT NULL DEFAULT 0,
  `log_action_date` varchar(50) NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `t_id`, `module`, `action`, `description`, `action_by`, `log_action_date`) VALUES
(1, 1, 'Tenant', 'Tenant Email Verified', 'Email: wakek45156@exespay.com <br />Subscription: Free', 20, '2026-03-26 15:25:49'),
(2, 1, 'Tenant', 'Tenant Email Verified', 'Email: wakek45156@exespay.com <br />Subscription: Free', 20, '2026-03-26 15:26:51'),
(3, 1, 'Tenant', 'Tenant Email Verified', 'Email: hetocar482@agoalz.com <br />Subscription: Free', 27, '2026-04-01 13:48:01'),
(4, 1, 'Tenant', 'Tenant Email Verified', 'Email: hetocar482@agoalz.com <br />Subscription: Free', 35, '2026-04-06 12:41:27'),
(5, 1, 'User', 'Delete', 'Email: <b></b> <br /> Name: <b> </b>', 31, '2026-04-07 10:04:45'),
(6, 1, 'User', 'Delete', 'Email: <b>hetocar482@agoalz.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-07 10:23:15'),
(7, 1, 'User', 'Add', 'Email: hetocar482@agoalz.com', 31, '2026-04-07 10:25:03'),
(8, 1, 'User', 'Delete', 'Email: <b>hetocar482@agoalz.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-07 10:25:42'),
(9, 1, 'User', 'Add', 'Email: rofoc23034@bpotogo.com', 31, '2026-04-07 10:37:42'),
(10, 1, 'User', 'Delete', 'Email: <b>rofoc23034@bpotogo.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-07 10:38:26'),
(11, 1, 'User', 'Add', 'Email: rofoc23034@bpotogo.com', 31, '2026-04-07 10:40:02'),
(12, 1, 'User', 'Delete', 'Email: <b>rofoc23034@bpotogo.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-07 11:06:11'),
(13, 1, 'User', 'Delete', 'Email: <b>rofoc23034@bpotogo.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-07 11:07:53'),
(14, 1, 'User', 'Delete', 'Email: <b>rofoc23034@bpotogo.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-07 11:07:58'),
(15, 1, 'User', 'Delete', 'Email: <b>rofoc23034@bpotogo.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-07 11:08:02'),
(16, 1, 'User', 'Delete', 'Email: <b>rofoc23034@bpotogo.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-07 11:08:09'),
(17, 1, 'User', 'Delete', 'Email: <b>rofoc23034@bpotogo.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-07 11:08:25'),
(18, 1, 'User', 'Delete', 'Email: <b>rofoc23034@bpotogo.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-07 11:08:36'),
(19, 1, 'User', 'Delete', 'Email: <b>rofoc23034@bpotogo.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-07 11:08:47'),
(20, 1, 'User', 'Delete', 'Email: <b>rofoc23034@bpotogo.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-07 11:15:16'),
(21, 1, 'User', 'Delete', 'Email: <b>rofoc23034@bpotogo.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-07 11:15:21'),
(22, 1, 'User', 'Delete', 'Email: <b>rofoc23034@bpotogo.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-07 11:15:26'),
(23, 1, 'User', 'Delete', 'Email: <b>rofoc23034@bpotogo.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-07 11:17:55'),
(24, 1, 'User', 'Delete', 'Email: <b>rofoc23034@bpotogo.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-07 11:18:00'),
(25, 1, 'User', 'Delete', 'Email: <b>rofoc23034@bpotogo.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-07 11:19:08'),
(26, 1, 'User', 'Delete', 'Email: <b>rofoc23034@bpotogo.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-07 11:19:12'),
(27, 1, 'User', 'Delete', 'Email: <b>rofoc23034@bpotogo.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-07 11:23:01'),
(28, 1, 'User', 'Delete', 'Email: <b>rofoc23034@bpotogo.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-07 11:47:02'),
(29, 1, 'User', 'Delete', 'Email: <b>rofoc23034@bpotogo.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-07 11:47:08'),
(30, 1, 'User', 'Delete', 'Email: <b>rofoc23034@bpotogo.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-07 11:48:45'),
(31, 1, 'User', 'Add', 'Email: rofoc23034@bpotogo.com', 31, '2026-04-07 11:51:04'),
(32, 1, 'User', 'Delete', 'Email: <b>rofoc23034@bpotogo.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-07 11:57:18'),
(33, 1, 'User', 'Add', 'Email: rofoc23034@bpotogo.com', 31, '2026-04-07 12:04:13'),
(34, 1, 'User', 'Delete', 'Email: <b>rofoc23034@bpotogo.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-07 12:04:39'),
(35, 1, 'User', 'Add', 'Email: <b>rofoc23034@bpotogo.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-07 15:18:25'),
(36, 1, 'User', 'Add', 'Email: <b>rofoc230347@bpotogo.com</b> ', 31, '2026-04-07 15:23:57'),
(37, 1, 'User', 'Delete', 'Email: <b>rofoc230347@bpotogo.com</b> <br /> Name: <b> </b>', 31, '2026-04-07 15:24:58'),
(38, 1, 'User', 'Delete', 'Email: <b>rofoc23034@bpotogo.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-07 15:25:03'),
(39, 1, 'User', 'Add', 'Email: <b>rofoc230347@bpotogo.com</b> <br /> Name: <b> </b>', 31, '2026-04-07 15:28:14'),
(40, 1, 'User', 'Delete', 'Email: <b>rofoc230347@bpotogo.com</b> ', 31, '2026-04-07 15:29:46'),
(41, 1, 'User', 'Add', 'Email: <b>rofoc230347@bpotogo.com</b> ', 31, '2026-04-07 15:29:53'),
(42, 1, 'User', 'Delete', 'Email: <b>rofoc230347@bpotogo.com</b> ', 31, '2026-04-07 15:32:14'),
(43, 1, 'Account', 'Add', 'Account Name: <b>Trident</b>', 31, '2026-04-08 14:40:47'),
(44, 1, 'Account', 'Delete', 'Account Name: <b>Trident</b>', 31, '2026-04-10 10:03:46'),
(45, 1, 'Account', 'Add', 'Account Name: <b>China</b>', 31, '2026-04-10 11:10:10'),
(46, 1, 'Account', 'Delete', 'Account Name: <b>China</b>', 31, '2026-04-10 11:13:26'),
(47, 1, 'Account', 'Add', 'Account Name: <b>China</b>', 31, '2026-04-10 11:13:35'),
(48, 1, 'Account', 'Delete', 'Account Name: <b>China</b>', 31, '2026-04-10 11:27:56'),
(49, 1, 'Account', 'Add', 'Account Name: <b>trident</b>', 31, '2026-04-10 11:29:19'),
(50, 1, 'Account', 'Delete', 'Account Name: <b>trident</b>', 31, '2026-04-10 11:35:00'),
(51, 1, 'Account', 'Add', 'Account Name: <b>Trident</b>', 31, '2026-04-10 11:39:41'),
(52, 1, 'Account', 'Edit', 'Old Account Name: <b>Trident</b> <br />New Account Name: <b>China</b>', 31, '2026-04-10 11:51:39'),
(53, 1, 'Account', 'Edit', 'Old Account Name: <b>China</b> <br />New Account Name: <b>Trident</b>', 31, '2026-04-10 11:51:52'),
(54, 1, 'Account', 'Edit', 'Old Account Name: <b>Trident</b> <br />New Account Name: <b>Trident7</b>', 31, '2026-04-10 11:52:23'),
(55, 1, 'Account', 'Edit', 'Old Account Name: <b>Trident7</b> <br />New Account Name: <b>Trident</b>', 31, '2026-04-10 11:52:30'),
(56, 1, 'Account', 'Edit', 'Old Account Name: <b>Trident</b> <br />New Account Name: <b>china</b>', 31, '2026-04-10 11:53:19'),
(57, 1, 'Account', 'Delete', 'Account Name: <b>china</b>', 31, '2026-04-10 11:53:47'),
(58, 1, 'Account', 'Add', 'Account Name: <b>trident</b>', 31, '2026-04-10 11:53:53'),
(59, 1, 'Account', 'Add', 'Account Name: <b>Trident</b>', 31, '2026-04-10 12:00:11'),
(60, 1, 'Account', 'Add', 'Account Name: <b>Trident</b>', 31, '2026-04-10 12:00:38'),
(61, 1, 'Account', 'Add', 'Account Name: <b>sample</b>', 31, '2026-04-10 12:02:52'),
(62, 1, 'Account', 'Edit', 'Old Account Name: <b>sample</b> <br />New Account Name: <b>Trident</b>', 31, '2026-04-10 12:03:00'),
(63, 1, 'Account', 'Edit', 'Old Account Name: <b>Trident</b> <br />New Account Name: <b>Trident7</b>', 31, '2026-04-10 12:06:48'),
(64, 1, 'Account', 'Add', 'Account Name: <b>trident</b>', 31, '2026-04-10 12:07:19'),
(65, 1, 'Account', 'Edit', 'Old Account Name: <b>trident</b> <br />New Account Name: <b>Trident</b>', 31, '2026-04-10 12:07:25'),
(66, 1, 'Account', 'Edit', 'Old Account Name: <b>Trident</b> <br />New Account Name: <b>Trident7</b>', 31, '2026-04-10 12:07:30'),
(67, 1, 'Account', 'Edit', 'Old Account Name: <b>Trident7</b> <br />New Account Name: <b>Trident</b>', 31, '2026-04-10 12:07:34'),
(68, 1, 'User', 'Add', 'Email: <b>rofoc23034@bpotogo.com</b> <br /> Name: <b>sample sample</b>', 31, '2026-04-10 12:14:39'),
(69, 1, 'Category', 'Add', 'Category Name: <b>Sample</b>', 31, '2026-04-10 13:45:13'),
(70, 1, 'Category', 'Add', 'Category Name: <b>sample 1</b>', 31, '2026-04-10 13:45:27'),
(71, 1, 'Category', 'Delete', 'Category Name: <b>sample 1</b>', 31, '2026-04-10 13:48:53'),
(72, 1, 'Category', 'Add', 'Category Name: <b>sample 1</b>', 31, '2026-04-10 13:50:56'),
(73, 1, 'Category', 'Delete', 'Category Name: <b>sample 1</b>', 31, '2026-04-10 13:51:01'),
(74, 1, 'Category', 'Edit', 'Old Category Name: <b>Sample</b> <br />New Category Name: <b>Sample 1</b>', 31, '2026-04-10 13:56:17'),
(75, 1, 'Category', 'Edit', 'Old Category Name: <b>Sample 1</b> <br />New Category Name: <b>Sample</b>', 31, '2026-04-10 13:56:32'),
(76, 1, 'Category', 'Edit', 'Old Category Name: <b>Sample</b> <br />New Category Name: <b>Sample 1</b>', 31, '2026-04-10 13:56:36'),
(77, 1, 'Category', 'Edit', 'Old Category Name: <b>Sample 1</b> <br />New Category Name: <b>Sample</b>', 31, '2026-04-10 13:56:43'),
(78, 1, 'Category', 'Edit', 'Old Category Name: <b>Sample</b> <br />New Category Name: <b>Sample 1</b>', 31, '2026-04-10 13:56:48'),
(79, 1, 'Category', 'Add', 'Category Name: <b>Sample</b>', 31, '2026-04-10 13:57:19'),
(80, 1, 'Category', 'Add', 'Category Name: <b>Sample 1</b>', 31, '2026-04-10 13:57:35'),
(81, 1, 'Category', 'Edit', 'Old Category Name: <b>Sample 1</b> <br />New Category Name: <b>Cash</b>', 31, '2026-04-10 13:57:46'),
(82, 1, 'Category', 'Delete', 'Category Name: <b>Sample</b>', 31, '2026-04-10 13:57:52'),
(83, 1, 'Account', 'Edit', 'Old Account Name: <b>Trident</b> <br />New Account Name: <b>Christian</b>', 31, '2026-04-10 13:59:48'),
(84, 1, 'Account', 'Add', 'Account Name: <b>sadas</b>', 31, '2026-04-10 14:00:52'),
(85, 1, 'Account', 'Delete', 'Account Name: <b>sadas</b>', 31, '2026-04-10 14:01:18'),
(86, 1, 'Account', 'Add', 'Account Name: <b>Christian</b>', 31, '2026-04-10 14:07:36'),
(87, 1, 'Account', 'Delete', 'Account Name: <b>Christian</b>', 31, '2026-04-10 14:21:00'),
(88, 1, 'Category', 'Add', 'Category Name: <b>Sample</b>', 31, '2026-04-10 16:44:36'),
(89, 1, 'Sub-Account', 'Add', 'Sub-Account Name: <b>Trident</b> <br />Sub-Account Number: <b></b>', 31, '2026-04-16 10:40:43'),
(90, 1, 'Sub-Account', 'Add', 'Sub-Account Name: <b>Trident</b> <br />Sub-Account Number: <b></b>', 31, '2026-04-16 10:41:46'),
(91, 1, 'Sub-Account', 'Add', 'Sub-Account Name: <b>Trident</b> <br />Sub-Account Number: <b></b>', 31, '2026-04-16 10:44:20'),
(92, 1, 'Sub-Account', 'Add', 'Sub-Account Name: <b>Zelda Freeman</b> <br />Sub-Account Number: <b></b>', 31, '2026-04-16 10:45:33'),
(93, 1, 'Sub-Account', 'Add', 'Sub-Account Name: <b>Irma Barlow</b> <br />Sub-Account Number: <b></b>', 31, '2026-04-16 10:52:21'),
(94, 1, 'Sub-account', 'Edit', 'Old Sub-account Name: <b>Irma Barlow</b> <br />Old Sub-account Number: <b>557</b> <br />New Sub-account Name: <b>Karyn Calderon</b> <br />New Sub-account Number: <b>327</b>', 31, '2026-04-16 11:46:01'),
(95, 1, 'Sub-Account', 'Add', 'Sub-Account Name: <b>Hope Underwood</b> <br />Sub-Account Number: <b>336</b>', 31, '2026-04-16 11:47:18'),
(96, 1, 'Sub-account', 'Edit', 'Old Sub-account Name: <b>Hope Underwood</b> <br />Old Sub-account Number: <b>336</b> <br />New Sub-account Name: <b>Garth Moreno</b> <br />New Sub-account Number: <b>263</b>', 31, '2026-04-16 11:47:34'),
(97, 1, 'Sub-account', 'Edit', 'Old Sub-account Name: <b>Garth Moreno</b> <br />Old Sub-account Number: <b>263</b> <br />New Sub-account Name: <b>John Hyde</b> <br />New Sub-account Number: <b>765</b>', 31, '2026-04-16 13:23:23'),
(98, 1, 'Sub-account', 'Delete', 'Sub-account Name: <b>John Hyde</b> <br />Sub-account Number: <b>765</b>', 31, '2026-04-16 13:29:28'),
(99, 1, 'Sub-Account', 'Add', 'Sub-Account Name: <b>Nasim Austin</b> <br />Sub-Account Number: <b>235</b>', 31, '2026-04-16 13:30:32'),
(100, 1, 'Sub-account', 'Edit', 'Old Sub-account Name: <b>Nasim Austin</b> <br />Old Sub-account Number: <b>235</b> <br />New Sub-account Name: <b>Dara Ray</b> <br />New Sub-account Number: <b>685</b>', 31, '2026-04-16 13:31:18'),
(101, 1, 'Sub-account', 'Edit', 'Old Sub-account Name: <b>Dara Ray</b> <br />Old Sub-account Number: <b>685</b> <br />New Sub-account Name: <b>Dara Ray</b> <br />New Sub-account Number: <b>685</b>', 31, '2026-04-16 13:31:46'),
(102, 1, 'Sub-account', 'Delete', 'Sub-account Name: <b>Dara Ray</b> <br />Sub-account Number: <b>685</b>', 31, '2026-04-16 13:31:53'),
(103, 1, 'Sub-Account', 'Add', 'Sub-Account Name: <b>Daryl Raymond</b> <br />Sub-Account Number: <b>203</b>', 31, '2026-04-16 13:32:02'),
(104, 1, 'Sub-account', 'Edit', 'Old Sub-account Name: <b>Daryl Raymond</b> <br />Old Sub-account Number: <b>203</b> <br />New Sub-account Name: <b>Jasper Winters</b> <br />New Sub-account Number: <b>965</b>', 31, '2026-04-16 13:34:36'),
(105, 1, 'Sub-account', 'Edit', 'Old Sub-account Name: <b>Jasper Winters</b> <br />Old Sub-account Number: <b>965</b> <br />New Sub-account Name: <b>Jasper Winters</b> <br />New Sub-account Number: <b>965</b>', 31, '2026-04-16 13:35:37'),
(106, 1, 'Sub-Account', 'Add', 'Sub-Account Name: <b>Alexa Wooten</b> <br />Sub-Account Number: <b>403</b>', 31, '2026-04-16 13:38:14'),
(107, 1, 'Sub-account', 'Edit', 'Old Sub-account Name: <b>Alexa Wooten</b> <br />Old Sub-account Number: <b>403</b> <br />New Sub-account Name: <b>Plato Meyers</b> <br />New Sub-account Number: <b>567</b>', 31, '2026-04-16 13:38:19'),
(108, 1, 'Sub-account', 'Delete', 'Sub-account Name: <b>Plato Meyers</b> <br />Sub-account Number: <b>567</b>', 31, '2026-04-16 13:38:36'),
(109, 1, 'Sub-Account', 'Add', 'Sub-Account Name: <b>Brenna Collins</b> <br />Sub-Account Number: <b>255</b>', 31, '2026-04-16 13:38:41'),
(110, 1, 'Account', 'Edit', 'Old Account Name: <b>Christian</b> <br />New Account Name: <b>Thaddeus Mcneil</b>', 31, '2026-04-16 14:11:00'),
(111, 1, 'Account', 'Add', 'Account Name: <b>Marsden Rutledge</b>', 31, '2026-04-16 14:11:04'),
(112, 1, 'Sub-Account', 'Add', 'Sub-Account Name: <b>Raya Cunningham</b> <br />Sub-Account Number: <b>261</b>', 31, '2026-04-16 14:12:12'),
(113, 1, 'Transaction', 'Add', 'Account Name: <b>Thaddeus Mcneil</b> <br />Sub-Account Name: <b>Brenna Collins</b> <br />Date: <b>Apr 30, 2026</b> <br />Category: <b>Sample</b> <br />Description: <b>qweqwe</b> <br />Amount: <b>1,000.00</b> <br />Type: <b>IN (Debit)</b> <br />', 31, '2026-04-30 13:54:15'),
(114, 1, 'Transaction', 'Add', 'Account Name: <b>Thaddeus Mcneil</b> <br />Sub-Account Name: <b>Brenna Collins</b> <br />Date: <b>Apr 30, 2026</b> <br />Category: <b>Cash</b> <br />Description: <b>sample</b> <br />Amount: <b>10,000.00</b> <br />Type: <b>IN (Debit)</b> <br />', 31, '2026-04-30 13:56:53'),
(115, 1, 'Transaction', 'Add', 'Account Name: <b>Thaddeus Mcneil</b> <br />Sub-Account Name: <b>Brenna Collins</b> <br />Date: <b>Apr 30, 2026</b> <br />Category: <b>Sample</b> <br />Description: <b>nsdfnsdfsndf</b> <br />Amount: <b>200.00</b> <br />Type: <b>IN (Debit)</b> <br />', 31, '2026-04-30 13:59:44'),
(116, 1, 'Transaction', 'Add', 'Account Name: <b>Thaddeus Mcneil</b> <br />Sub-Account Name: <b>Brenna Collins</b> <br />Date: <b>Apr 30, 2026</b> <br />Category: <b>Cash</b> <br />Description: <b>Voluptas qui porro a</b> <br />Amount: <b>10,000.00</b> <br />Type: <b>IN (Debit)</b> <br />', 31, '2026-04-30 16:16:56'),
(117, 1, 'Transaction', 'Add', 'Account Name: <b>Thaddeus Mcneil</b> <br />Sub-Account Name: <b>Brenna Collins</b> <br />Date: <b>May 04, 2026</b> <br />Category: <b>Sample</b> <br />Description: <b>sample</b> <br />Amount: <b>10,000.00</b> <br />Type: <b>IN (Debit)</b> <br />', 31, '2026-05-04 21:11:30'),
(118, 1, 'Transaction', 'Add', 'Account Name: <b>Thaddeus Mcneil</b> <br />Sub-Account Name: <b>Brenna Collins</b> <br />Date: <b>May 04, 2026</b> <br />Category: <b>Cash</b> <br />Description: <b>Asperiores officia u</b> <br />Amount: <b>12,222.00</b> <br />Type: <b>IN (Debit)</b> <br />', 31, '2026-05-04 21:23:42'),
(119, 1, 'Transaction', 'Add', 'Account Name: <b>Thaddeus Mcneil</b> <br />Sub-Account Name: <b>Brenna Collins</b> <br />Date: <b>May 06, 2026</b> <br />Category: <b>Cash</b> <br />Description: <b>Numquam soluta volup</b> <br />Amount: <b>1,000.00</b> <br />Type: <b>IN (Debit)</b> <br />', 31, '2026-05-06 09:55:46'),
(120, 1, 'Transaction', 'Add', 'Account Name: <b>Thaddeus Mcneil</b> <br />Sub-Account Name: <b>Brenna Collins</b> <br />Date: <b>May 06, 2026</b> <br />Category: <b>Sample</b> <br />Description: <b>Occaecat saepe et po</b> <br />Amount: <b>10,000.00</b> <br />Type: <b>IN (Debit)</b> <br />', 31, '2026-05-06 09:57:23'),
(121, 1, 'Transaction', 'Add', 'Account Name: <b>Thaddeus Mcneil</b> <br />Sub-Account Name: <b>Brenna Collins</b> <br />Date: <b>May 07, 2026</b> <br />Category: <b>Cash</b> <br />Description: <b>Adipisci sit proide</b> <br />Amount: <b>20,000.00</b> <br />Type: <b>IN (Debit)</b> <br />', 31, '2026-05-06 10:01:01'),
(122, 1, 'Transaction', 'Add', 'Account Name: <b>Thaddeus Mcneil</b> <br />Sub-Account Name: <b>Brenna Collins</b> <br />Date: <b>May 06, 2026</b> <br />Category: <b>Sample</b> <br />Description: <b>Dolor magna magni mo</b> <br />Amount: <b>23,423.00</b> <br />Type: <b>IN (Debit)</b> <br />', 31, '2026-05-06 10:11:11'),
(123, 1, 'Transaction', 'Add', 'Account Name: <b>Thaddeus Mcneil</b> <br />Sub-Account Name: <b>Brenna Collins</b> <br />Date: <b>May 08, 2026</b> <br />Category: <b>Sample</b> <br />Description: <b>Dignissimos aut id d</b> <br />Amount: <b>34,343.00</b> <br />Type: <b>IN (Debit)</b> <br />', 31, '2026-05-06 10:14:08'),
(124, 1, 'Transaction', 'Add', 'Account Name: <b>Thaddeus Mcneil</b> <br />Sub-Account Name: <b>Brenna Collins</b> <br />Date: <b>May 06, 2026</b> <br />Category: <b>Sample</b> <br />Description: <b>Aliquip labore enim</b> <br />Amount: <b>234,234.00</b> <br />Type: <b>IN (Debit)</b> <br />', 31, '2026-05-06 10:14:55'),
(125, 1, 'Transaction', 'Add', 'Account Name: <b>Thaddeus Mcneil</b> <br />Sub-Account Name: <b>Brenna Collins</b> <br />Date: <b>May 06, 2026</b> <br />Category: <b>Cash</b> <br />Description: <b>Dolores aut tempora</b> <br />Amount: <b>10,000.00</b> <br />Type: <b>IN (Debit)</b> <br />', 31, '2026-05-06 10:16:02'),
(126, 1, 'Transaction', 'Add', 'Account Name: <b>Thaddeus Mcneil</b> <br />Sub-Account Name: <b>Brenna Collins</b> <br />Date: <b>May 06, 2026</b> <br />Category: <b>Sample</b> <br />Description: <b>Sample</b> <br />Amount: <b>1,000.00</b> <br />Type: <b>IN (Debit)</b> <br />', 31, '2026-05-06 11:05:35'),
(127, 1, 'Transaction', 'Add', 'Account Name: <b>Thaddeus Mcneil</b> <br />Sub-Account Name: <b>Brenna Collins</b> <br />Date: <b>May 07, 2026</b> <br />Category: <b>Sample</b> <br />Description: <b>Sunt quis error volu</b> <br />Amount: <b>500.00</b> <br />Type: <b>OUT (Credit)</b> <br />', 31, '2026-05-07 10:23:07'),
(128, 1, 'Transaction', 'Add', 'Account Name: <b>Thaddeus Mcneil</b> <br />Sub-Account Name: <b>Brenna Collins</b> <br />Date: <b>May 07, 2026</b> <br />Category: <b>Cash</b> <br />Description: <b>qweqwe</b> <br />Amount: <b>1,000.00</b> <br />Type: <b>IN (Debit)</b> <br />', 31, '2026-05-07 11:34:17'),
(129, 1, 'Transaction', 'Add', 'Account Name: <b>Thaddeus Mcneil</b> <br />Sub-Account Name: <b>Brenna Collins</b> <br />Date: <b>May 07, 2026</b> <br />Category: <b>Sample</b> <br />Description: <b>zzxczxc</b> <br />Amount: <b>300.00</b> <br />Type: <b>OUT (Credit)</b> <br />', 31, '2026-05-07 11:35:07');

-- --------------------------------------------------------

--
-- Table structure for table `bs_user`
--

CREATE TABLE `bs_user` (
  `user_id` int(100) UNSIGNED NOT NULL,
  `t_id` int(11) NOT NULL DEFAULT 0 COMMENT 'Table tenant',
  `first_name` text DEFAULT NULL,
  `last_name` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `verification_code` text DEFAULT NULL,
  `is_completed` int(1) NOT NULL DEFAULT 0 COMMENT '0 = incomplete, 1 = completed',
  `is_verified` int(1) NOT NULL DEFAULT 0 COMMENT '0 = not verified, 1 = verified',
  `is_admin` int(1) NOT NULL DEFAULT 0,
  `date_added` varchar(20) DEFAULT NULL,
  `added_by` int(11) NOT NULL DEFAULT 0,
  `date_modified` varchar(20) DEFAULT NULL,
  `modified_by` int(11) NOT NULL DEFAULT 0,
  `date_deleted` varchar(20) DEFAULT NULL,
  `deleted_by` int(11) NOT NULL DEFAULT 0,
  `is_deleted` int(1) NOT NULL DEFAULT 0,
  `last_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `uid` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bs_user`
--

INSERT INTO `bs_user` (`user_id`, `t_id`, `first_name`, `last_name`, `email`, `password`, `verification_code`, `is_completed`, `is_verified`, `is_admin`, `date_added`, `added_by`, `date_modified`, `modified_by`, `date_deleted`, `deleted_by`, `is_deleted`, `last_login`, `uid`) VALUES
(1, 0, 'Trident', 'Corporation', 'trident@gmail.com', '$2y$10$xBT6X3bxEH7V/9RXUlycTO.WKQZGvGhHDR2/Rt9TWZrOktwyAbj/.', NULL, 0, 0, 1, '2024-11-19 10:18:56', 1, NULL, 0, NULL, 0, 0, '2026-04-07 01:44:24', 'c4ca4238a0b923820dcc509a6f75849b'),
(2, 0, 'Super', 'Admin', 'superadmin@gmail.com', '$2y$10$E0T.3t9a.tJSY3/J/zSpq.aqoAgTIoYy0CJucSBrY7PlbjHUWfY1y', NULL, 0, 0, 1, '2024-11-19 10:27:38', 1, NULL, 0, NULL, 0, 0, '2026-04-07 01:44:26', 'c81e728d9d4c2f636f067f89cc14862c'),
(3, 0, 'Admin', 'Admin', 'admin@gmail.com', '$2y$10$E0T.3t9a.tJSY3/J/zSpq.aqoAgTIoYy0CJucSBrY7PlbjHUWfY1y', NULL, 0, 0, 1, '2024-11-19 10:35:35', 1, NULL, 0, NULL, 0, 0, '2026-04-07 01:44:57', 'eccbc87e4b5ce2fe28308fd9f2a7baf3'),
(4, 0, 'Ronald', 'Tangguan', 'ronald@gmail.com', '$2y$10$3L4FOlaoc6tLAtncIJnYgOJJfUMDQdBqSLO.MZIYlIPGa0msBfMWK', NULL, 0, 0, 0, '2024-11-26 13:40:23', 1, NULL, 0, NULL, 0, 0, '2025-03-03 06:09:46', 'a87ff679a2f3e71d9181a67b7542122c'),
(5, 0, 'Benz', 'Lozada', 'benz@gmail.com', '$2y$10$Ak9bkFuEtCGZPIZkF5A4rObu7yF8qh.C0LxTHaksnF5tnkkOHjdQq', NULL, 0, 0, 0, '2024-11-26 13:41:04', 1, NULL, 0, NULL, 0, 0, '2024-11-26 07:39:13', 'e4da3b7fbbce2345d7772b0674a318d5'),
(6, 0, 'Kevin', 'Cortez', 'kevin@gmail.com', '$2y$10$OrZmObNRQApwT4l6llgNZObwWTLSJOImTk4FxRKEDQaD7Gwgmtia.', NULL, 0, 0, 0, '2024-11-26 13:43:41', 1, NULL, 0, NULL, 0, 0, '2024-11-26 07:39:16', '1679091c5a880faf6fb5e6087eb1b2dc'),
(7, 0, 'Hadden', 'James', 'hadden@gmail.com', '$2y$10$Cbra9y/DgbllPEOex0GKK.X11gWVuPIQx4vIV8eDvB3lkAbesMJZO', NULL, 0, 0, 0, '2024-11-26 13:45:54', 1, NULL, 0, NULL, 0, 0, '2024-11-26 07:39:23', '8f14e45fceea167a5a36dedd4bea2543'),
(8, 0, 'Christian', 'Mori', 'christian@gmail.com', '$2y$10$6WG3ZyqTH.6OpawAmc1oG.JrtAH7yOR.m4V.TmW2Yf8tEZvu05ZZy', NULL, 0, 0, 0, '2024-11-26 13:47:17', 1, NULL, 0, NULL, 0, 0, '2026-04-06 01:19:28', 'c9f0f895fb98ab9159f51fd0297e236d'),
(9, 0, NULL, NULL, 'ronald23@gmail.com', '$2y$10$EE9CVY6kScu4qf21SYHume/3bOsSfvxnBYHqHDNOWAT6tdFeA1Tvu', NULL, 0, 0, 0, '2025-03-03 14:13:09', 0, NULL, 0, NULL, 0, 0, '2026-03-31 13:59:35', '45c48cce2e2d7fbdea1afc51c7c6ad26'),
(10, 1, NULL, NULL, 'sample@gmail.com', '$2y$10$ruDD9e7YXEovs9O/8ZjAI.bR71zHQ8gMMwTXG8DnShu9kErbVCW3y', NULL, 0, 0, 0, '2025-03-03 14:13:41', 0, NULL, 0, NULL, 0, 0, '2026-04-06 03:32:42', 'd3d9446802a44259755d38e6d163e820'),
(35, 2, 'sample', 'sample', 'rofoc23034@bpotogo.com', '$2y$10$apWaelOUKLvFp.oyBdDYFe7BqhI9ZCdOuELcCK6OQ2R7v.deZ3JHy', '$2y$10$Mw8g3vi/YPc.MVpJRGzXGO09Ds8dC6DhFNrKM9E0oh.bn/XlJ9O7i', 0, 1, 0, '2026-04-06 12:37:31', 31, NULL, 0, NULL, 0, 0, '2026-04-07 02:38:26', '1c383cd30b7c298ab50293adfecb7b18'),
(31, 1, 'Maisie', 'Wood', 'chris@gmail.com', '$2y$10$6WG3ZyqTH.6OpawAmc1oG.JrtAH7yOR.m4V.TmW2Yf8tEZvu05ZZy', NULL, 0, 1, 0, '2026-04-06 11:31:22', 27, NULL, 0, NULL, 0, 0, '2026-04-30 01:18:58', 'c16a5320fa475530d9583c34fd356ef5'),
(36, 0, NULL, NULL, 'rofoc23034@bpotogo.com', NULL, NULL, 0, 0, 0, '2026-04-07 15:23:57', 31, NULL, 0, NULL, 0, 0, '2026-04-10 04:14:33', '19ca14e7ea6328a42e0eb13d585e4c22');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `c_id` int(11) NOT NULL,
  `t_id` int(11) NOT NULL DEFAULT 0,
  `category_name` text DEFAULT NULL,
  `date_added` varchar(20) DEFAULT NULL,
  `added_by` int(11) NOT NULL DEFAULT 0,
  `date_deleted` varchar(20) DEFAULT NULL,
  `deleted_by` int(11) NOT NULL DEFAULT 0,
  `is_deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`c_id`, `t_id`, `category_name`, `date_added`, `added_by`, `date_deleted`, `deleted_by`, `is_deleted`) VALUES
(1, 1, 'Sample', '2026-04-10 13:57:19', 31, '2026-04-10 13:57:52', 31, 1),
(2, 1, 'Cash', '2026-04-10 13:57:35', 31, NULL, 0, 0),
(3, 1, 'Sample', '2026-04-10 16:44:36', 31, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `s_id` int(11) NOT NULL,
  `s_type` text DEFAULT NULL COMMENT 'Subscription type: Free, Basic, Pro',
  `account` int(11) NOT NULL DEFAULT 0 COMMENT 'Number of account included, 0 = unli',
  `sub_account` int(11) NOT NULL DEFAULT 0 COMMENT 'Number of sub-account included, 0 = unli',
  `transfer` int(1) NOT NULL DEFAULT 0 COMMENT '0 = not included, 1 = included',
  `check_book` int(11) NOT NULL DEFAULT 0 COMMENT 'Number of check book included',
  `user` int(11) NOT NULL DEFAULT 0 COMMENT 'Number of users included, 0 = unli'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscription`
--

INSERT INTO `subscription` (`s_id`, `s_type`, `account`, `sub_account`, `transfer`, `check_book`, `user`) VALUES
(1, 'Free', 1, 1, 0, 0, 1),
(2, 'Basic', 3, 3, 1, 0, 3),
(3, 'Pro', 0, 0, 1, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sub_account`
--

CREATE TABLE `sub_account` (
  `sa_id` int(11) NOT NULL,
  `t_id` int(11) NOT NULL DEFAULT 0 COMMENT 'tenant_id',
  `a_id` int(11) NOT NULL DEFAULT 0 COMMENT 'account_id',
  `sub_account_name` text DEFAULT NULL,
  `sub_account_number` text DEFAULT NULL,
  `date_added` varchar(20) DEFAULT NULL,
  `added_by` int(11) NOT NULL DEFAULT 0,
  `date_deleted` varchar(20) DEFAULT NULL,
  `deleted_by` int(11) NOT NULL DEFAULT 0,
  `is_deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_account`
--

INSERT INTO `sub_account` (`sa_id`, `t_id`, `a_id`, `sub_account_name`, `sub_account_number`, `date_added`, `added_by`, `date_deleted`, `deleted_by`, `is_deleted`) VALUES
(1, 1, 1, 'Plato Meyers', '567', '2026-04-16 13:38:14', 31, '2026-04-16 13:38:36', 31, 1),
(2, 1, 1, 'Brenna Collins', '255', '2026-04-16 13:38:41', 31, NULL, 0, 0),
(3, 1, 2, 'Raya Cunningham', '261', '2026-04-16 14:12:12', 31, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tenant`
--

CREATE TABLE `tenant` (
  `t_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0 COMMENT 'Table bs_user',
  `s_id` int(11) NOT NULL DEFAULT 0 COMMENT 'Table subscription',
  `account` int(11) NOT NULL DEFAULT 0 COMMENT '	Number of account included, 0 = unli',
  `sub_account` int(11) NOT NULL DEFAULT 0 COMMENT 'Number of sub-account included, 0 = unli	',
  `transfer` int(1) NOT NULL DEFAULT 0 COMMENT '0 = not included, 1 = included',
  `check_book` int(11) NOT NULL DEFAULT 0 COMMENT 'Number of check book included',
  `user` int(11) NOT NULL DEFAULT 0 COMMENT 'Number of users included, 0 = unli'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tenant`
--

INSERT INTO `tenant` (`t_id`, `user_id`, `s_id`, `account`, `sub_account`, `transfer`, `check_book`, `user`) VALUES
(1, 27, 1, 2, 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tenant_user`
--

CREATE TABLE `tenant_user` (
  `tu_id` int(11) NOT NULL,
  `t_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tenant_user`
--

INSERT INTO `tenant_user` (`tu_id`, `t_id`, `user_id`) VALUES
(1, 2, 35),
(13, 1, 35);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `tt_id` int(11) NOT NULL,
  `t_id` int(11) NOT NULL DEFAULT 0 COMMENT 'tenant_id',
  `transaction_type` int(1) NOT NULL DEFAULT 0 COMMENT '0 = transaction, 1 = transfer',
  `a_id` int(11) NOT NULL DEFAULT 0 COMMENT 'account_id',
  `sa_id` int(11) NOT NULL DEFAULT 0 COMMENT 'sub-account_id',
  `tt_date` varchar(20) DEFAULT NULL,
  `c_id` int(11) NOT NULL DEFAULT 0 COMMENT 'category_id',
  `description` text DEFAULT NULL,
  `type` int(1) NOT NULL DEFAULT 0 COMMENT '0 = IN, 1 = OUT',
  `from_account` int(11) NOT NULL DEFAULT 0,
  `to_account` int(11) NOT NULL DEFAULT 0,
  `remarks` text DEFAULT NULL,
  `amount` decimal(9,2) NOT NULL DEFAULT 0.00,
  `date_added` varchar(20) DEFAULT NULL,
  `added_by` int(11) NOT NULL DEFAULT 0,
  `date_modified` varchar(20) DEFAULT NULL,
  `modified_by` int(11) NOT NULL DEFAULT 0,
  `date_deleted` varchar(20) DEFAULT NULL,
  `deleted_by` int(11) NOT NULL DEFAULT 0,
  `is_deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`tt_id`, `t_id`, `transaction_type`, `a_id`, `sa_id`, `tt_date`, `c_id`, `description`, `type`, `from_account`, `to_account`, `remarks`, `amount`, `date_added`, `added_by`, `date_modified`, `modified_by`, `date_deleted`, `deleted_by`, `is_deleted`) VALUES
(1, 1, 0, 1, 2, '2026-05-06', 3, 'Sample', 0, 0, 0, NULL, 1000.00, '2026-05-06 11:05:35', 31, NULL, 0, NULL, 0, 0),
(2, 1, 0, 1, 2, '2026-05-07', 3, 'Sunt quis error volu', 1, 0, 0, NULL, 500.00, '2026-05-07 10:23:07', 31, NULL, 0, NULL, 0, 0),
(3, 1, 0, 1, 2, '2026-05-07', 2, 'qweqwe', 0, 0, 0, NULL, 1000.00, '2026-05-07 11:34:17', 31, NULL, 0, NULL, 0, 0),
(4, 1, 0, 1, 2, '2026-05-07', 3, 'zzxczxc', 1, 0, 0, NULL, 300.00, '2026-05-07 11:35:07', 31, NULL, 0, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_img`
--

CREATE TABLE `transaction_img` (
  `ti_id` int(11) NOT NULL,
  `t_id` int(11) NOT NULL DEFAULT 0 COMMENT 'Tenant_id',
  `tt_id` int(11) NOT NULL DEFAULT 0 COMMENT 'transaction_id',
  `original_file_name` text DEFAULT NULL,
  `new_file_name` text DEFAULT NULL,
  `file_extension` text DEFAULT NULL,
  `date_added` varchar(20) DEFAULT NULL,
  `added_by` int(11) NOT NULL DEFAULT 0,
  `date_deleted` varchar(20) DEFAULT NULL,
  `deleted_by` int(11) NOT NULL DEFAULT 0,
  `is_deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_img`
--

INSERT INTO `transaction_img` (`ti_id`, `t_id`, `tt_id`, `original_file_name`, `new_file_name`, `file_extension`, `date_added`, `added_by`, `date_deleted`, `deleted_by`, `is_deleted`) VALUES
(1, 1, 1, 'EXAMPLE_PORTRAIT.png', '9a4e5a9492c367d4d764560a11aadca9_20260506110535.webp', 'webp', '2026-05-06 11:05:35', 31, NULL, 0, 0),
(2, 1, 1, 'EXAMPLE_LANDSCAPE.png', '7a469967f170456b8f247f32b91d162b_20260506110535.webp', 'webp', '2026-05-06 11:05:35', 31, NULL, 0, 0),
(3, 1, 2, 'EXAMPLE_PORTRAIT.png', '2695af816f482fed5d176caf51819be5_20260507102307.webp', 'webp', '2026-05-07 10:23:07', 31, NULL, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bs_user`
--
ALTER TABLE `bs_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `sub_account`
--
ALTER TABLE `sub_account`
  ADD PRIMARY KEY (`sa_id`);

--
-- Indexes for table `tenant`
--
ALTER TABLE `tenant`
  ADD PRIMARY KEY (`t_id`);

--
-- Indexes for table `tenant_user`
--
ALTER TABLE `tenant_user`
  ADD PRIMARY KEY (`tu_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`tt_id`);

--
-- Indexes for table `transaction_img`
--
ALTER TABLE `transaction_img`
  ADD PRIMARY KEY (`ti_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `bs_user`
--
ALTER TABLE `bs_user`
  MODIFY `user_id` int(100) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sub_account`
--
ALTER TABLE `sub_account`
  MODIFY `sa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tenant`
--
ALTER TABLE `tenant`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tenant_user`
--
ALTER TABLE `tenant_user`
  MODIFY `tu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `tt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaction_img`
--
ALTER TABLE `transaction_img`
  MODIFY `ti_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
