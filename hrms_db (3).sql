-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2025 at 08:17 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hrms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_master`
--

CREATE TABLE `admin_master` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `admin_pass` varchar(100) NOT NULL,
  `admin_created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_master`
--

CREATE TABLE `attendance_master` (
  `a_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `a_punch_in_time` time NOT NULL DEFAULT current_timestamp(),
  `a_punch_out_time` time DEFAULT NULL,
  `a_working_hours` bigint(20) DEFAULT NULL,
  `a_date` date NOT NULL,
  `a_status` int(11) NOT NULL DEFAULT 1 COMMENT '1 for absent, 2 for present, 3 for on leave,\r\n4 for half day'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance_master`
--

INSERT INTO `attendance_master` (`a_id`, `u_id`, `company_id`, `a_punch_in_time`, `a_punch_out_time`, `a_working_hours`, `a_date`, `a_status`) VALUES
(2, 6, 106, '09:00:00', '12:00:00', 8, '2025-03-12', 2),
(3, 6, 106, '12:00:00', '12:00:00', 6, '2025-03-11', 2),
(5, 6, 106, '12:00:00', '12:00:00', 9, '2025-03-10', 2),
(6, 6, 106, '12:00:00', NULL, 7, '2025-03-14', 2),
(7, 6, 106, '12:00:00', '03:00:00', NULL, '2025-03-07', 1),
(8, 6, 106, '13:00:00', '16:00:00', NULL, '2025-03-06', 1),
(9, 6, 106, '09:00:00', '07:00:00', NULL, '2025-03-05', 1),
(10, 6, 106, '08:00:00', '11:00:00', 3, '2025-03-04', 1),
(11, 6, 106, '09:00:00', '12:00:00', 3, '2025-03-03', 4),
(12, 6, 106, '12:00:00', '18:00:00', 6, '2025-03-02', 1),
(13, 6, 106, '09:00:00', '14:00:00', 5, '2025-03-01', 1),
(14, 6, 106, '14:00:00', NULL, NULL, '2025-03-19', 2),
(15, 33, 1, '10:41:20', '12:02:06', 1, '2025-03-13', 4),
(16, 44, 1, '12:05:59', '12:06:36', 0, '2025-03-13', 4);

-- --------------------------------------------------------

--
-- Table structure for table `attendance_status`
--

CREATE TABLE `attendance_status` (
  `a_status_id` int(11) NOT NULL,
  `a_status_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance_status`
--

INSERT INTO `attendance_status` (`a_status_id`, `a_status_name`) VALUES
(1, 'absent'),
(2, 'present'),
(3, 'on-leave'),
(4, 'half_day');

-- --------------------------------------------------------

--
-- Table structure for table `company_master`
--

CREATE TABLE `company_master` (
  `company_id` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `company_email` varchar(100) NOT NULL,
  `company_phone` bigint(20) NOT NULL,
  `company_latitude` decimal(10,8) NOT NULL,
  `company_longitude` decimal(10,8) NOT NULL,
  `company_address` text NOT NULL,
  `company_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_master`
--

INSERT INTO `company_master` (`company_id`, `company_name`, `company_email`, `company_phone`, `company_latitude`, `company_longitude`, `company_address`, `company_created_at`) VALUES
(1, 'CHPL', 'chpl@gmail.com', 9273546901, 22.98920300, 72.49666500, ' World Trade Tower, Sarkhej - Gandhinagar Hwy, Makarba, Ahmedabad, Sarkhej-Okaf, Gujarat 380051', '2025-03-05 06:52:28'),
(105, 'Tech Innovators', 'contact@techinnovators.com', 1234567890, 0.00000000, 0.00000000, '123 Tech Street, Silicon Valley, CA', '2024-01-14 18:30:00'),
(106, 'Global Solutions', 'info@globalsolutions.com', 9876543210, 0.00000000, 0.00000000, '456 Business Road, New York, NY', '2023-12-09 18:30:00'),
(107, 'NextGen Enterprises', 'support@nextgen.com', 1122334455, 0.00000000, 0.00000000, '789 Future Avenue, Austin, TX', '2024-02-04 18:30:00'),
(108, 'Pioneer Tech', 'hello@pioneertech.com', 6677889900, 0.00000000, 0.00000000, '321 Innovation Blvd, Seattle, WA', '2023-11-19 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `dept_master`
--

CREATE TABLE `dept_master` (
  `dept_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `dept_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dept_master`
--

INSERT INTO `dept_master` (`dept_id`, `company_id`, `dept_name`) VALUES
(1, 1, 'HR'),
(10, 105, 'Human Resources'),
(11, 105, 'Finance'),
(13, 106, 'Marketing'),
(14, 107, 'Sales'),
(15, 107, 'Customer Support'),
(16, 108, 'Product Development'),
(17, 108, 'IT & Security'),
(18, 105, 'Human Resources'),
(19, 105, 'Finance'),
(20, 105, 'Research & Development'),
(21, 106, 'Engineering'),
(22, 106, 'Marketing'),
(23, 106, 'Operations'),
(24, 106, 'Business Development'),
(25, 106, 'Customer Relations'),
(26, 107, 'Sales'),
(27, 107, 'Customer Support'),
(28, 107, 'Product Management'),
(29, 108, 'Product Development'),
(30, 108, 'IT & Security'),
(31, 108, 'Cloud Computing'),
(32, 108, 'Quality Assurance'),
(33, 108, 'Data Science'),
(34, 1, 'Human Resources'),
(35, 1, 'Finance'),
(36, 1, 'Operations'),
(37, 105, 'Research & Development'),
(38, 105, 'Engineering'),
(39, 105, 'Product Management'),
(40, 105, 'Marketing'),
(41, 105, 'Customer Support'),
(42, 106, 'Software Development'),
(43, 106, 'Sales'),
(44, 106, 'IT & Security'),
(45, 107, 'Business Development'),
(46, 107, 'Quality Assurance'),
(47, 107, 'Customer Service'),
(48, 107, 'HR & Payroll'),
(49, 107, 'Logistics'),
(50, 108, 'Cloud Computing'),
(51, 108, 'Cybersecurity'),
(52, 108, 'Data Science');

-- --------------------------------------------------------

--
-- Table structure for table `leave_master`
--

CREATE TABLE `leave_master` (
  `l_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `u_id` int(100) NOT NULL,
  `leave_type_id` int(11) NOT NULL,
  `l_reason` varchar(100) NOT NULL,
  `l_start_date` varchar(50) NOT NULL,
  `l_end_date` varchar(50) NOT NULL,
  `l_status_id` int(11) NOT NULL DEFAULT 1,
  `l_applied_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `l_approved_by` int(11) DEFAULT NULL,
  `is_delete` int(11) NOT NULL DEFAULT 0 COMMENT '0 for active,1 for delete'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_master`
--

INSERT INTO `leave_master` (`l_id`, `company_id`, `u_id`, `leave_type_id`, `l_reason`, `l_start_date`, `l_end_date`, `l_status_id`, `l_applied_at`, `l_approved_by`, `is_delete`) VALUES
(1, 1, 33, 2, 'medical emergency', '2025-03-17', '', 1, '2025-03-13 05:50:06', NULL, 0),
(2, 1, 33, 2, 'medical emergency', '2025-03-14', '', 1, '2025-03-13 05:50:15', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `leave_statuses`
--

CREATE TABLE `leave_statuses` (
  `id` int(11) NOT NULL,
  `status_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_statuses`
--

INSERT INTO `leave_statuses` (`id`, `status_name`) VALUES
(2, 'Approved'),
(1, 'Pending'),
(3, 'Rejected');

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`id`, `type_name`) VALUES
(2, 'Casual Leave'),
(3, 'Paid Leave'),
(1, 'Sick Leave');

-- --------------------------------------------------------

--
-- Table structure for table `otp_master`
--

CREATE TABLE `otp_master` (
  `otp_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `otp_code` int(11) NOT NULL,
  `otp_created_at` datetime NOT NULL,
  `otp_expires_at` datetime NOT NULL,
  `otp_status` int(11) NOT NULL DEFAULT 0 COMMENT '0 for unused and 1 for used'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `otp_master`
--

INSERT INTO `otp_master` (`otp_id`, `u_id`, `otp_code`, `otp_created_at`, `otp_expires_at`, `otp_status`) VALUES
(1, 6, 6026, '2025-03-10 14:28:53', '2025-03-10 14:33:53', 1),
(2, 6, 9228, '2025-03-10 14:34:25', '2025-03-10 14:39:25', 0),
(3, 26, 1255, '2025-03-10 15:01:06', '2025-03-10 15:06:06', 0),
(4, 6, 7786, '2025-03-10 15:35:31', '2025-03-10 15:40:31', 1),
(5, 6, 3281, '2025-03-10 17:33:57', '2025-03-10 17:38:57', 0),
(6, 26, 3060, '2025-03-10 17:46:41', '2025-03-10 17:51:41', 0),
(7, 6, 6665, '2025-03-10 18:01:31', '2025-03-10 18:06:31', 1),
(8, 26, 6409, '2025-03-10 18:10:22', '2025-03-10 18:15:22', 0),
(9, 6, 2512, '2025-03-10 18:10:48', '2025-03-10 18:15:48', 1),
(10, 43, 3926, '2025-03-10 18:17:06', '2025-03-10 18:22:06', 0),
(11, 26, 1798, '2025-03-10 18:20:07', '2025-03-10 18:25:07', 0),
(12, 44, 5800, '2025-03-10 18:24:37', '2025-03-10 18:29:37', 1),
(13, 26, 8167, '2025-03-10 18:32:56', '2025-03-10 18:37:56', 1),
(14, 26, 7397, '2025-03-11 09:49:49', '2025-03-11 09:54:49', 1),
(15, 44, 5685, '2025-03-11 09:56:47', '2025-03-11 10:01:47', 0),
(16, 43, 1710, '2025-03-11 09:59:50', '2025-03-11 10:04:50', 0),
(17, 45, 8157, '2025-03-11 10:02:29', '2025-03-11 10:07:29', 0),
(18, 26, 2062, '2025-03-11 10:04:08', '2025-03-11 10:09:08', 0),
(19, 6, 6754, '2025-03-11 10:05:23', '2025-03-11 10:10:23', 1),
(20, 44, 6590, '2025-03-11 10:07:10', '2025-03-11 10:12:10', 0),
(21, 26, 7701, '2025-03-11 11:22:01', '2025-03-11 11:27:01', 1),
(22, 44, 1547, '2025-03-11 11:24:01', '2025-03-11 11:29:01', 1),
(23, 45, 2400, '2025-03-11 11:24:22', '2025-03-11 11:29:22', 1),
(24, 45, 4429, '2025-03-12 11:49:02', '2025-03-12 11:54:02', 1),
(25, 44, 4791, '2025-03-12 12:47:21', '2025-03-12 12:52:21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `position_master`
--

CREATE TABLE `position_master` (
  `position_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `position_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `position_master`
--

INSERT INTO `position_master` (`position_id`, `company_id`, `dept_id`, `position_name`) VALUES
(2, 1, 1, 'Junior'),
(3, 105, 10, 'HR Manager'),
(4, 105, 11, 'Finance Analyst'),
(6, 106, 13, 'Marketing Specialist'),
(7, 107, 14, 'Sales Executive'),
(8, 107, 15, 'Support Representative'),
(9, 108, 16, 'Product Manager'),
(10, 108, 17, 'Cybersecurity Analyst');

-- --------------------------------------------------------

--
-- Table structure for table `public_holidays`
--

CREATE TABLE `public_holidays` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `holiday_name` varchar(255) NOT NULL,
  `holiday_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `public_holidays`
--

INSERT INTO `public_holidays` (`id`, `company_id`, `holiday_name`, `holiday_date`) VALUES
(1, 1, 'New Year\'s Day', '2025-01-01'),
(2, 1, 'Republic Day', '2025-01-26'),
(3, 1, 'Independence Day', '2025-08-15'),
(4, 1, 'Gandhi Jayanti', '2025-10-02'),
(5, 1, 'Christmas', '2025-12-25'),
(6, 1, 'Good Friday', '2025-04-18'),
(7, 1, 'Labour Day', '2025-05-01'),
(8, 1, 'Diwali', '2025-10-20'),
(9, 1, 'Makar Sankranti', '2025-01-14'),
(10, 1, 'Maha Shivaratri', '2025-02-26'),
(11, 1, 'Holi', '2025-03-14'),
(12, 1, 'Ram Navami', '2025-04-06'),
(13, 1, 'Hanuman Jayanti', '2025-04-15'),
(14, 1, 'Raksha Bandhan', '2025-08-09'),
(15, 1, 'Krishna Janmashtami', '2025-08-16'),
(16, 1, 'Ganesh Chaturthi', '2025-08-30'),
(17, 1, 'Navaratri Start', '2025-09-22'),
(18, 1, 'Dussehra', '2025-10-02'),
(19, 1, 'Govardhan Puja', '2025-10-21'),
(20, 1, 'Bhai Dooj', '2025-10-22'),
(21, 1, 'Kartik Purnima', '2025-11-05'),
(22, 105, 'New Year\'s Day', '2025-01-01'),
(23, 105, 'Republic Day', '2025-01-26'),
(24, 105, 'Independence Day', '2025-08-15'),
(25, 105, 'Gandhi Jayanti', '2025-10-02'),
(26, 105, 'Christmas', '2025-12-25'),
(27, 106, 'New Year\'s Day', '2025-01-01'),
(28, 106, 'Republic Day', '2025-01-26'),
(29, 106, 'Independence Day', '2025-08-15'),
(30, 106, 'Gandhi Jayanti', '2025-10-02'),
(31, 106, 'Christmas', '2025-12-25'),
(32, 107, 'New Year\'s Day', '2025-01-01'),
(33, 107, 'Republic Day', '2025-01-26'),
(34, 107, 'Independence Day', '2025-08-15'),
(35, 107, 'Gandhi Jayanti', '2025-10-02'),
(36, 107, 'Christmas', '2025-12-25'),
(37, 108, 'New Year\'s Day', '2025-01-01'),
(38, 108, 'Republic Day', '2025-01-26'),
(39, 108, 'Independence Day', '2025-08-15'),
(40, 108, 'Gandhi Jayanti', '2025-10-02'),
(41, 108, 'Christmas', '2025-12-25'),
(42, 105, 'Good Friday', '2025-04-18'),
(43, 105, 'Labour Day', '2025-05-01'),
(44, 105, 'Diwali', '2025-10-20'),
(45, 106, 'Good Friday', '2025-04-18'),
(46, 106, 'Labour Day', '2025-05-01'),
(47, 106, 'Diwali', '2025-10-20'),
(48, 107, 'Good Friday', '2025-04-18'),
(49, 107, 'Labour Day', '2025-05-01'),
(50, 107, 'Diwali', '2025-10-20'),
(51, 108, 'Good Friday', '2025-04-18'),
(52, 108, 'Labour Day', '2025-05-01'),
(53, 108, 'Diwali', '2025-10-20'),
(54, 105, 'Makar Sankranti', '2025-01-14'),
(55, 105, 'Maha Shivaratri', '2025-02-26'),
(56, 105, 'Holi', '2025-03-14'),
(57, 105, 'Ram Navami', '2025-04-06'),
(58, 105, 'Hanuman Jayanti', '2025-04-15'),
(59, 105, 'Raksha Bandhan', '2025-08-09'),
(60, 105, 'Krishna Janmashtami', '2025-08-16'),
(61, 105, 'Ganesh Chaturthi', '2025-08-30'),
(62, 105, 'Navaratri Start', '2025-09-22'),
(63, 105, 'Dussehra', '2025-10-02'),
(64, 105, 'Govardhan Puja', '2025-10-21'),
(65, 105, 'Bhai Dooj', '2025-10-22'),
(66, 105, 'Kartik Purnima', '2025-11-05'),
(67, 106, 'Makar Sankranti', '2025-01-14'),
(68, 106, 'Maha Shivaratri', '2025-02-26'),
(69, 106, 'Holi', '2025-03-14'),
(70, 106, 'Ram Navami', '2025-04-06'),
(71, 106, 'Hanuman Jayanti', '2025-04-15'),
(72, 106, 'Raksha Bandhan', '2025-08-09'),
(73, 106, 'Krishna Janmashtami', '2025-08-16'),
(74, 106, 'Ganesh Chaturthi', '2025-08-30'),
(75, 106, 'Navaratri Start', '2025-09-22'),
(76, 106, 'Dussehra', '2025-10-02'),
(77, 106, 'Govardhan Puja', '2025-10-21'),
(78, 106, 'Bhai Dooj', '2025-10-22'),
(79, 106, 'Kartik Purnima', '2025-11-05'),
(80, 107, 'Makar Sankranti', '2025-01-14'),
(81, 107, 'Maha Shivaratri', '2025-02-26'),
(82, 107, 'Holi', '2025-03-14'),
(83, 107, 'Ram Navami', '2025-04-06'),
(84, 107, 'Hanuman Jayanti', '2025-04-15'),
(85, 107, 'Raksha Bandhan', '2025-08-09'),
(86, 107, 'Krishna Janmashtami', '2025-08-16'),
(87, 107, 'Ganesh Chaturthi', '2025-08-30'),
(88, 107, 'Navaratri Start', '2025-09-22'),
(89, 107, 'Dussehra', '2025-10-02'),
(90, 107, 'Govardhan Puja', '2025-10-21'),
(91, 107, 'Bhai Dooj', '2025-10-22'),
(92, 107, 'Kartik Purnima', '2025-11-05'),
(93, 108, 'Makar Sankranti', '2025-01-14'),
(94, 108, 'Maha Shivaratri', '2025-02-26'),
(95, 108, 'Holi', '2025-03-14'),
(96, 108, 'Ram Navami', '2025-04-06'),
(97, 108, 'Hanuman Jayanti', '2025-04-15'),
(98, 108, 'Raksha Bandhan', '2025-08-09'),
(99, 108, 'Krishna Janmashtami', '2025-08-16'),
(100, 108, 'Ganesh Chaturthi', '2025-08-30'),
(101, 108, 'Navaratri Start', '2025-09-22'),
(102, 108, 'Dussehra', '2025-10-02'),
(103, 108, 'Govardhan Puja', '2025-10-21'),
(104, 108, 'Bhai Dooj', '2025-10-22'),
(105, 108, 'Kartik Purnima', '2025-11-05');

-- --------------------------------------------------------

--
-- Table structure for table `user_master`
--

CREATE TABLE `user_master` (
  `u_id` int(11) NOT NULL,
  `u_name` varchar(100) NOT NULL,
  `u_email` varchar(100) NOT NULL,
  `u_pass` varchar(100) NOT NULL,
  `u_phone` bigint(20) NOT NULL,
  `u_gender` int(11) NOT NULL COMMENT '1 for male,2 for female',
  `dept_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `u_salary` bigint(20) NOT NULL,
  `u_joining_Date` varchar(100) NOT NULL,
  `u_created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `u_modified_by` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '0 for user, 1 for admin',
  `u_is_delete` int(11) NOT NULL DEFAULT 0 COMMENT '0 for active, 1 for deleted ',
  `u_dob` date NOT NULL,
  `company_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_master`
--

INSERT INTO `user_master` (`u_id`, `u_name`, `u_email`, `u_pass`, `u_phone`, `u_gender`, `dept_id`, `position_id`, `u_salary`, `u_joining_Date`, `u_created_date`, `u_modified_by`, `u_is_delete`, `u_dob`, `company_id`) VALUES
(3, 'hello', 'hello@gmail.com', '$2y$10$OVKnBSowChYsOh/ul4BBS.mKHuVDcR14cj6gI1c2e8Kyf2perJvTe', 123456, 1, 1, 2, 1234567, '2025-03-13 14:54:53', '2025-03-06 05:26:45', '2025-03-04 09:25:34', 1, '0000-00-00', 1),
(5, '', 'nil@gmail.com', '$2y$10$G87pseCDC/9Yr3dpyJ4qIOpMF2SNhBYyjapnCTCWvSjPZJodFtcrq', 0, 1, 1, 2, 12345, '0000-00-00 00:00:00', '2025-03-06 06:02:36', '2025-03-04 09:51:37', 0, '0000-00-00', 1),
(6, 'nil', 'nilsadariya10@gmail.com', '$2y$10$g6HQG.Hrs.83RiSohgvybu/9wWP7bwmceAdDxg0Bor0K8tMNxrNAG', 987654321, 1, 1, 2, 12345, '0000-00-00 00:00:00', '2025-03-06 07:06:38', '2025-03-11 05:49:20', 0, '0000-00-00', 106),
(18, 'john', 'john@gmail.com', '$2y$10$U0AAqZ6rJwYwMdTbagWsRu3ih2LZgEVrmQUlThU3l9ydLMbiFZ84q', 1234567890, 1, 1, 2, 50000, '0000-00-00 00:00:00', '2025-03-05 12:00:38', '2025-03-05 12:00:38', 0, '0000-00-00', 1),
(19, 'john', 'john123@gmail.com', '$2y$10$zSzk2QarSv.70WkAmTc6.eN/H4nXtm9M170w.IVlE9a/TRg5h/8lW', 1234567890, 1, 1, 2, 50000, '', '2025-03-05 12:06:33', '2025-03-05 12:06:33', 0, '0000-00-00', 1),
(20, 'john', 'john1233@gmail.com', '$2y$10$UE.iOwu18Ox3OlQHikIgC.CZP1cEQ0s7fcfcz74Ps864.QQL8E0s2', 1234567890, 1, 1, 2, 50000, '', '2025-03-05 12:08:08', '2025-03-05 12:08:08', 0, '0000-00-00', 1),
(21, 'john', 'john12343@gmail.com', '$2y$10$1OMeY2ovNzMnc5dwaOdC.OB8zq3KMzdStlkmoXhckG.bwsDUIcQia', 1234567890, 1, 1, 2, 50000, '', '2025-03-05 12:09:11', '2025-03-05 12:09:11', 0, '0000-00-00', 1),
(22, 'John Doe', 'john123gg43@gmail.com', '$2y$10$ycnlZNNPl9tE.DOBuNUfp.mCoHF9423vkAmsgmF5IwpDix8ucf9Ty', 2345678901, 1, 1, 2, 50000, '', '2025-03-06 09:11:47', '2025-03-06 12:21:36', 0, '0000-00-00', 1),
(23, 'john', 'john1232134gg43@gmail.com', '$2y$10$n3Vl4X8EiPlAczp0luzsZeJJh.kSP.x0STNl0JIkjjSr1HPiT0qum', 1234567890, 1, 1, 2, 50000, '', '2025-03-05 12:10:28', '2025-03-05 12:10:28', 0, '0000-00-00', 1),
(25, 'John Doe', 'johndoe@example.com', '$2y$10$Cqzz2gYrfg.BiBvlebfU2uAlUUvgnVpZGyfkACs4y6WimQznyc/gO', 9876543210, 0, 1, 2, 50000, '2025-03-05', '2025-03-05 12:18:24', '2025-03-05 12:18:24', 0, '1990-01-01', 1),
(26, 'Pratham', 'prathampatel1730@gmail.com', '$2y$10$YIP5HR.LtFSFJ9HKe7pgGOJrZQzYgUOm5mjXCfnBJNzp0X4oTips6', 1234567890, 1, 1, 2, 20000, '05/03/2025', '2025-03-05 12:46:53', '2025-03-05 12:46:53', 0, '0000-00-00', 1),
(29, 'Pratham', 'patel@gmail.com', '$2y$10$zuSJ6HyAw4EFpP73YFm4zuIHsUM75/7Zr/GaGL3C63qx8X0zyP1L2', 1023456789, 1, 1, 2, 20000, '05/03/2025', '2025-03-05 13:13:53', '2025-03-05 13:13:53', 0, '0000-00-00', 1),
(30, 'Pratham', 'abc@gmail.com', '$2y$10$Uh/NKSRaw9eODgzcr8L8VOnZ5Fn19zfa7r5iU.NKRnU4Y4ss2WdIe', 1234567890, -1, 1, 2, 20000, '06/03/2025', '2025-03-06 03:58:08', '2025-03-06 03:58:08', 0, '0000-00-00', 1),
(31, 'kgk', 'dfh@gmail.com', '$2y$10$2w4kHzjwKpiZXrSBktoITu/JCXmT4uW4zYYjTvcb1dzz0.0e4wnH.', 1230456678, 2, 1, 2, 20000, '06/03/2025', '2025-03-06 04:05:57', '2025-03-06 04:05:57', 0, '0000-00-00', 1),
(32, 'Pratham', 'ps@gmail.com', '$2y$10$0MWDscUCkreljQfMSSMd2.SAGlJVu8m57qLdqKxSKGXKV4mFeDmme', 1230456789, 1, 1, 2, 20000, '06/03/2025', '2025-03-06 04:42:12', '2025-03-06 04:42:12', 0, '0000-00-00', 1),
(33, 'Urva patel', 'pac@gmail.com', '$2y$10$yqMABR428uMetVyzYuWChuQiAdulaaO.in3f/udPw8I7y3iM3JBJe', 7898465450, 2, 1, 2, 20000, '06/03/2025', '2025-03-06 07:13:13', '2025-03-12 10:47:46', 0, '2025-03-05', 1),
(34, 'Pratham', 'test@gmail.com', '$2y$10$b9DJJukXILii11DPRJqTFOsFcm.j7pA4AqEw1zRGhng8CWZCPVVLC', 1023456789, 1, 1, 2, 20000, '06/03/2025', '2025-03-06 07:40:57', '2025-03-06 07:40:57', 0, '0000-00-00', 1),
(35, 'Ayushiii', 'ayushi@gmail.com', '$2y$10$.wZXeEIb1u3Uf7FfN4uy1OWUbkmB.PVw/jAnN61HHftwTQ5UdYbNu', 9685781698, 2, 1, 2, 20000, '06/03/2025', '2025-03-06 10:20:11', '2025-03-07 07:06:11', 0, '2025-03-07', 1),
(36, 'Pratham', 'zxc@gmail.com', '$2y$10$CfQT2R8cVctmU7apdGWhxet92REglZCTcdWXax3mL/IZ25qenBnP.', 8498465416, 2, 14, 7, 20000, '07/03/2025', '2025-03-07 05:09:38', '2025-03-07 05:09:38', 0, '0000-00-00', 1),
(37, 'ldfd', 'asd@gmail.com', '$2y$10$b.z62550ZjRkC9trQlDvJ.piVl7Mc5rO9TabbtAnH.ISQ8W5LOqQO', 2876876546, 2, 15, 8, 20000, '07-03-2025', '2025-03-07 05:29:10', '2025-03-07 05:29:10', 0, '0000-00-00', 1),
(38, 'ae', 'e@gmail.com', '$2y$10$B0e8yCA.b3pPmIDh6ZaT9.JAWYGUlMAD3lgbyzQ4/1UfqiRRT1DGG', 8946543068, 2, 14, 7, 20000, '2025-03-07', '2025-03-07 05:31:34', '2025-03-07 05:31:34', 0, '2025-03-04', 1),
(43, 'pratham b patel', 'thepking17@gmail.com', '$2y$10$81yHubQPS0r/Cnejb5keBulOvdrvNylS8yru/8YpOf/OFS2KZ90Yi', 1234567890, 1, 1, 2, 20000, '2025-03-10', '2025-03-10 12:46:38', '2025-03-10 12:46:38', 0, '2025-03-10', 1),
(44, 'pp', '3882.stkabirdin@gmail.com', '$2y$10$qbnFTD9dCYyoOEdUdKFqau.nKtXzYbLHYG2gRa1f/yub3xwUUKKDy', 1234567890, 1, 1, 2, 20000, '2025-03-10', '2025-03-10 12:53:07', '2025-03-12 07:18:43', 0, '2025-03-10', 1),
(45, 'Ayushi', 'ayushinagar2004@gmail.com', '$2y$10$MXi3WAFEO985pzVhAXpTp.MTimBmwse2g5ki6pTwvfiCa50lkFgjq', 9685781698, 2, 1, 2, 20000, '2025-01-06', '2025-03-11 04:32:13', '2025-03-12 06:19:45', 0, '2005-03-26', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_master`
--
ALTER TABLE `admin_master`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `admin_email` (`admin_email`);

--
-- Indexes for table `attendance_master`
--
ALTER TABLE `attendance_master`
  ADD PRIMARY KEY (`a_id`),
  ADD KEY `u_id` (`u_id`),
  ADD KEY `a_status` (`a_status`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `attendance_status`
--
ALTER TABLE `attendance_status`
  ADD PRIMARY KEY (`a_status_id`);

--
-- Indexes for table `company_master`
--
ALTER TABLE `company_master`
  ADD PRIMARY KEY (`company_id`),
  ADD UNIQUE KEY `company_email` (`company_email`);

--
-- Indexes for table `dept_master`
--
ALTER TABLE `dept_master`
  ADD PRIMARY KEY (`dept_id`),
  ADD KEY `fk_dept_company` (`company_id`);

--
-- Indexes for table `leave_master`
--
ALTER TABLE `leave_master`
  ADD PRIMARY KEY (`l_id`),
  ADD KEY `leave_master_ibfk_4` (`l_approved_by`),
  ADD KEY `leave_master_ibfk_5` (`l_status_id`),
  ADD KEY `leave_type_id` (`leave_type_id`),
  ADD KEY `fk_leave_company` (`company_id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `leave_statuses`
--
ALTER TABLE `leave_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `status_name` (`status_name`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_name` (`type_name`);

--
-- Indexes for table `otp_master`
--
ALTER TABLE `otp_master`
  ADD PRIMARY KEY (`otp_id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `position_master`
--
ALTER TABLE `position_master`
  ADD PRIMARY KEY (`position_id`),
  ADD KEY `dept_id` (`dept_id`),
  ADD KEY `fk_position_company` (`company_id`);

--
-- Indexes for table `public_holidays`
--
ALTER TABLE `public_holidays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `user_master`
--
ALTER TABLE `user_master`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `u_email` (`u_email`),
  ADD KEY `dept_id` (`dept_id`),
  ADD KEY `position_id` (`position_id`),
  ADD KEY `fk_user_company` (`company_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_master`
--
ALTER TABLE `admin_master`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance_master`
--
ALTER TABLE `attendance_master`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `attendance_status`
--
ALTER TABLE `attendance_status`
  MODIFY `a_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `company_master`
--
ALTER TABLE `company_master`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `dept_master`
--
ALTER TABLE `dept_master`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `leave_master`
--
ALTER TABLE `leave_master`
  MODIFY `l_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `leave_statuses`
--
ALTER TABLE `leave_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `otp_master`
--
ALTER TABLE `otp_master`
  MODIFY `otp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `position_master`
--
ALTER TABLE `position_master`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `public_holidays`
--
ALTER TABLE `public_holidays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `user_master`
--
ALTER TABLE `user_master`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance_master`
--
ALTER TABLE `attendance_master`
  ADD CONSTRAINT `attendance_master_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `user_master` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendance_master_ibfk_2` FOREIGN KEY (`a_status`) REFERENCES `attendance_status` (`a_status_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attendance_master_ibfk_3` FOREIGN KEY (`company_id`) REFERENCES `company_master` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dept_master`
--
ALTER TABLE `dept_master`
  ADD CONSTRAINT `fk_dept_company` FOREIGN KEY (`company_id`) REFERENCES `company_master` (`company_id`) ON DELETE CASCADE;

--
-- Constraints for table `leave_master`
--
ALTER TABLE `leave_master`
  ADD CONSTRAINT `fk_leave_company` FOREIGN KEY (`company_id`) REFERENCES `company_master` (`company_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leave_master_ibfk_4` FOREIGN KEY (`l_approved_by`) REFERENCES `admin_master` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `leave_master_ibfk_5` FOREIGN KEY (`l_status_id`) REFERENCES `leave_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `leave_master_ibfk_6` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `leave_master_ibfk_7` FOREIGN KEY (`u_id`) REFERENCES `user_master` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `otp_master`
--
ALTER TABLE `otp_master`
  ADD CONSTRAINT `otp_master_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `user_master` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `position_master`
--
ALTER TABLE `position_master`
  ADD CONSTRAINT `dept_id` FOREIGN KEY (`dept_id`) REFERENCES `dept_master` (`dept_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_position_company` FOREIGN KEY (`company_id`) REFERENCES `company_master` (`company_id`) ON DELETE CASCADE;

--
-- Constraints for table `public_holidays`
--
ALTER TABLE `public_holidays`
  ADD CONSTRAINT `public_holidays_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `company_master` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_master`
--
ALTER TABLE `user_master`
  ADD CONSTRAINT `fk_user_company` FOREIGN KEY (`company_id`) REFERENCES `company_master` (`company_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_master_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `dept_master` (`dept_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_master_ibfk_2` FOREIGN KEY (`position_id`) REFERENCES `position_master` (`position_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_master_ibfk_3` FOREIGN KEY (`company_id`) REFERENCES `company_master` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
