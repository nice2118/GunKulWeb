-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2023 at 12:26 PM
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
-- Database: `newsandactivities`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `AT_Code` int(11) NOT NULL,
  `AT_Entity No.` int(11) NOT NULL,
  `AT_Date` date NOT NULL,
  `AT_Time` time NOT NULL,
  `AT_Title` varchar(255) NOT NULL,
  `AT_Description` varchar(255) NOT NULL,
  `AT_Note` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `AT_Image` varchar(255) NOT NULL,
  `CountPage` int(11) NOT NULL,
  `AT_UserCreate` varchar(255) NOT NULL,
  `AT_CreateDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `AT_ModifyDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alertpopup`
--

CREATE TABLE `alertpopup` (
  `AP_Code` int(11) NOT NULL,
  `AP_Name` varchar(255) NOT NULL,
  `AP_Image` varchar(255) NOT NULL,
  `AP_DateStart` date NOT NULL,
  `AP_DateEnd` date NOT NULL,
  `AP_UserCreate` varchar(255) NOT NULL,
  `AP_Active` tinyint(1) NOT NULL DEFAULT 1,
  `AP_CreateDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `AP_ModifyDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CG_Entity No.` int(11) NOT NULL,
  `CG_IsFile` tinyint(1) NOT NULL DEFAULT 0,
  `CG_Entity Relation No.` int(11) NOT NULL,
  `CG_Name` varchar(255) NOT NULL,
  `CG_DescriptionTH` varchar(255) NOT NULL,
  `CG_DescriptionEN` varchar(255) NOT NULL,
  `CG_DefaultImage` varchar(255) NOT NULL,
  `CG_CreateDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `CG_ModifyDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CG_Entity No.`, `CG_IsFile`, `CG_Entity Relation No.`, `CG_Name`, `CG_DescriptionTH`, `CG_DescriptionEN`, `CG_DefaultImage`, `CG_CreateDate`, `CG_ModifyDate`) VALUES
(1, 0, 0, 'Andactivities', 'ข่าวสารและกิจกรรม', 'News & Activities', '', '2023-07-07 06:25:06', '2023-09-04 02:46:47'),
(2, 0, 0, 'Soft Skills', 'ทักษะทางสังคมที่ใช้เพื่อปฏิสัมพันธ์', 'Soft Skills', '2.jpg', '2023-07-10 10:29:50', '2023-08-15 07:21:35'),
(4, 0, 0, 'Knowledge Sharing', 'แบ่งปันความรู้', 'Knowledge Sharing', '4.jpg', '2023-07-10 10:30:31', '2023-08-17 09:05:55'),
(5, 0, 3, 'Digital Skill', 'Digital Skill', 'Digital Skill', '', '2023-07-10 10:30:31', '2023-08-11 06:18:06'),
(6, 0, 3, 'Language Skill', 'Language Skill', 'Language Skill', '', '2023-07-11 01:51:56', '2023-08-11 06:18:20'),
(8, 0, 6, 'Language Skill-1', 'ทักษะทางสังคมที่ใช้เพื่อปฏิสัมพันธ์กับผู้คน-1', 'Language Skill-1', '', '2023-07-11 08:52:14', '2023-07-13 17:00:00'),
(9, 0, 6, 'Language Skill-2', 'ทักษะทางสังคมที่ใช้เพื่อปฏิสัมพันธ์กับผู้คน-2', 'Language Skill-2', '', '2023-07-11 10:29:51', '2023-08-10 08:36:02'),
(10, 0, 0, 'Gallery', 'แกลลอรี่', 'Gallery', '', '2023-07-14 02:29:13', '2023-07-13 17:00:00'),
(19, 0, 0, 'ประกาศทั่วไป', 'ประกาศทั่วไป', 'General announcement', '', '2023-08-02 07:09:41', '2023-08-15 06:22:14'),
(20, 1, 0, 'ประกาศจากฝ่ายบุคคล', 'ประกาศจากฝ่ายบุคคล', 'ประกาศจากฝ่ายบุคคล', '', '2023-08-04 05:00:58', '2023-08-09 09:32:12'),
(22, 1, 20, 'นโยบาย', 'นโยบาย', 'นโยบาย', '', '2023-08-07 07:40:31', '2023-08-09 09:34:18'),
(23, 1, 20, 'สวัสดิการ', 'สวัสดิการ', 'สวัสดิการ', '', '2023-08-09 09:34:00', '2023-08-10 08:37:45'),
(27, 1, 0, 'News', 'ข่าวสาร', 'News', '', '2023-09-04 02:47:27', '2023-09-04 02:47:27'),
(28, 0, 0, 'Technical Skill', 'ทักษะทางเทคนิค', 'Technical Skill', '', '2023-09-04 02:49:34', '2023-09-04 02:49:34'),
(29, 0, 0, 'บทความ', 'บทความ', 'Article', '', '2023-09-04 02:50:54', '2023-09-04 02:50:54'),
(30, 1, 0, 'นโยบาย', 'นโยบาย', 'Policy', '', '2023-09-04 02:52:47', '2023-09-04 02:52:47'),
(31, 0, 0, 'เกมส์', 'เกมส์', 'Games', '', '2023-09-04 02:59:41', '2023-09-04 02:59:41');

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE `details` (
  `DT_Code` int(11) NOT NULL,
  `DT_Text` mediumtext DEFAULT NULL,
  `DT_Active` tinyint(1) NOT NULL DEFAULT 1,
  `DT_Sort` int(11) NOT NULL DEFAULT 0,
  `HD_Code` int(11) DEFAULT NULL,
  `DT_UserCreate` varchar(255) NOT NULL,
  `DT_CreateDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `DT_ModifyDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `engravedactivities`
--

CREATE TABLE `engravedactivities` (
  `EA_Code` int(11) NOT NULL,
  `EC_Code` int(11) NOT NULL,
  `EA_Name` varchar(255) NOT NULL,
  `EA_Path` varchar(255) NOT NULL,
  `CountPage` int(11) NOT NULL,
  `EC_UserCreate` varchar(255) NOT NULL,
  `EA_CreateDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `EA_ModifyDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `engravedactivities`
--

INSERT INTO `engravedactivities` (`EA_Code`, `EC_Code`, `EA_Name`, `EA_Path`, `CountPage`, `EC_UserCreate`, `EA_CreateDate`, `EA_ModifyDate`) VALUES
(2, 1, 'วันหยุดประจำปี-สำนักงานใหญ่ GKE', 'PDF/Holiday/HeadOfficeGKE/', 5, 'bbb', '2023-08-10 09:29:20', '2023-08-18 06:55:23'),
(3, 1, 'ไซต์งานก่อสร้าง และ O&M GKE', 'PDF/Holiday/ConstructionSiteGKE/', 0, 'bbb', '2023-08-10 09:29:20', '2023-08-18 06:55:23'),
(4, 1, 'โรงงาน GKA & GKP', 'PDF/Holiday/FactoryGKAGKP/', 0, 'bbb', '2023-08-10 09:29:20', '2023-08-18 06:55:23'),
(5, 1, 'สำนักงานใหญ่ GPD', 'PDF/Holiday/HeadOfficeGPD/', 0, 'bbb', '2023-08-10 09:29:20', '2023-08-18 06:55:23'),
(6, 1, 'ไซต์งานก่อสร้าง GPD', 'PDF/Holiday/ConstructionSiteGPD/', 0, 'bbb', '2023-08-10 09:29:20', '2023-08-18 06:55:23'),
(7, 2, 'สำนักงานใหญ่ GKE', 'PDF/TelephoneNumber/TelephoneNumber-GKE/', 0, 'bbb', '2023-08-10 09:31:19', '2023-08-25 09:36:05'),
(8, 2, 'โรงงาน GKA & GKP', 'PDF/TelephoneNumber/TelephoneNumber-GKAP/', 0, 'bbb', '2023-08-10 09:31:19', '2023-08-25 09:36:05'),
(9, 2, 'สำนักงานใหญ่ GPD', 'PDF/TelephoneNumber/TelephoneNumber-GPD/', 0, 'bbb', '2023-08-10 09:31:19', '2023-08-25 09:36:05'),
(10, 6, 'แผนที่ GKE', 'https://www.gunkul.com/th/contact-us/head-office', 0, 'aaa', '2023-08-17 06:57:45', '2023-09-04 03:12:06'),
(11, 7, 'GKE', 'https://www.gunkul.com/th/about-us/organization-chart', 0, 'aaa', '2023-08-17 07:06:06', '2023-09-04 03:07:52'),
(20, 0, 'Test', '123456', 0, 'aaa', '2023-08-21 01:33:35', '2023-08-21 01:33:35'),
(21, 0, 'Test', 'yyyyy', 0, 'aaa', '2023-08-21 01:33:49', '2023-08-21 01:33:49'),
(22, 0, 'Test', '123456', 0, 'aaa', '2023-08-21 01:35:36', '2023-08-21 01:35:36'),
(23, 0, 'Test', '123456', 0, 'aaa', '2023-08-21 01:38:51', '2023-08-21 01:38:51'),
(24, 0, 'Test1', '123456', 0, 'aaa', '2023-08-21 01:44:04', '2023-08-21 01:44:04'),
(25, 0, 'Test2', '123456', 0, 'aaa', '2023-08-21 01:44:04', '2023-08-21 01:44:04'),
(34, 19, 'ระบบลาและเงินเดือน', 'https://hrm.gunkul.net/LoginERS/login.aspx', 0, 'aaa', '2023-08-21 03:51:34', '2023-08-21 03:51:34'),
(35, 19, 'จองห้องประชุม', 'http://meetingroom.gunkul.com/login', 0, 'aaa', '2023-08-21 03:51:34', '2023-08-21 03:51:34'),
(36, 19, 'ระบบ e-Doc GKE', 'https://edoc.gunkul.com/share/page', 0, 'aaa', '2023-08-21 03:51:34', '2023-08-21 03:51:34'),
(37, 19, 'ระบบ e-Doc GKA, P', 'https://edocgka.gunkul.com/share/page', 0, 'aaa', '2023-08-21 03:51:34', '2023-08-21 03:51:34'),
(38, 19, 'ระบบ e-Doc GPD', 'https://edoc.gpdpublic.com/share/page', 0, 'aaa', '2023-08-21 03:51:34', '2023-08-21 03:51:34'),
(39, 19, 'ระบบ e-Doc JV', 'https://edocjv.gunkul.com/share/page', 0, 'aaa', '2023-08-21 03:51:34', '2023-08-21 03:51:34'),
(40, 20, 'ระบบ Dev e-Doc GKE', 'https://edocdev.gunkul.com/share/page', 0, 'aaa', '2023-08-21 03:52:22', '2023-08-21 03:52:22'),
(41, 20, 'ระบบ Dev e-Doc GKA, P', 'https://gkadev.gunkul.com/share/page', 0, 'aaa', '2023-08-21 03:52:22', '2023-08-21 03:52:22'),
(42, 20, 'ระบบ Dev e-Doc GPD', 'https://10.10.9.183:8443/share/page', 0, 'aaa', '2023-08-21 03:52:22', '2023-08-21 03:52:22'),
(43, 20, 'ระบบ Dev e-Doc JV', 'https://http://10.10.9.166:8080/share/page', 0, 'aaa', '2023-08-21 03:52:22', '2023-08-21 03:52:22'),
(44, 22, 'ระบบจองห้องประชุม', 'http://meetingroom.gunkul.com/login', 0, 'aaa', '2023-08-24 09:42:45', '2023-08-24 09:42:45'),
(45, 21, 'B-Plus', 'https://hrm.gunkul.net/LoginERS/login.aspx', 0, 'aaa', '2023-08-24 09:43:05', '2023-08-24 09:43:05'),
(46, 25, 'GKA&P', 'PDF/TelephoneNumber/TelephoneNumber-GKAP/', 0, 'aaa', '2023-08-25 09:57:36', '2023-08-25 09:57:36'),
(47, 24, 'GPD', 'PDF/TelephoneNumber/TelephoneNumber-GPD/', 0, 'aaa', '2023-08-25 09:57:49', '2023-08-25 09:57:49'),
(48, 23, 'GKE', 'PDF/TelephoneNumber/TelephoneNumber-GKE/', 0, 'aaa', '2023-08-25 09:58:05', '2023-08-25 09:58:05'),
(49, 7, 'GPD', 'https://www.gpdplc.com/th/who-we-are/organization-chart', 0, 'aaa', '2023-08-25 10:27:33', '2023-09-04 03:07:52'),
(50, 26, 'GKE', 'https://www.gunkul.com/en', 0, 'aaa', '2023-08-25 10:28:57', '2023-08-25 10:28:57'),
(51, 26, 'GPD', 'https://www.gpdplc.com/en/home', 0, 'aaa', '2023-08-25 10:28:57', '2023-08-25 10:28:57'),
(52, 6, 'แผนที่ GKA', 'https://maps.app.goo.gl/xzLsgb2QxSHfn81g6?g_st=il', 0, 'admin', '2023-09-04 02:08:38', '2023-09-04 03:12:06'),
(53, 6, 'คลัง', 'https://goo.gl/maps/jTTrTBZfbv2hoGmQ7', 0, '', '2023-09-04 03:12:06', '2023-09-04 03:12:06'),
(54, 28, 'วิสัยทัศน์', 'https://www.gunkul.com/th/about-us/vision-mission', 0, 'admin', '2023-09-04 07:02:47', '2023-09-04 07:05:37'),
(55, 28, 'พันธกิจ', 'https://www.gunkul.com/th/about-us/vision-mission', 0, 'admin', '2023-09-04 07:05:37', '2023-09-04 07:05:37'),
(56, 28, 'วัฒนะธรรมภายในองค์กร', 'https://www.gunkul.com/', 0, 'admin', '2023-09-04 07:05:37', '2023-09-04 07:05:37');

-- --------------------------------------------------------

--
-- Table structure for table `engravedcategory`
--

CREATE TABLE `engravedcategory` (
  `EC_Code` int(11) NOT NULL,
  `EC_Name` varchar(255) NOT NULL,
  `EC_DescriptionTH` varchar(255) NOT NULL,
  `EC_DescriptionEN` varchar(255) NOT NULL,
  `CountPage` int(11) NOT NULL,
  `EC_UserCreate` varchar(255) NOT NULL,
  `EC_CreateDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `EC_ModifyDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `engravedcategory`
--

INSERT INTO `engravedcategory` (`EC_Code`, `EC_Name`, `EC_DescriptionTH`, `EC_DescriptionEN`, `CountPage`, `EC_UserCreate`, `EC_CreateDate`, `EC_ModifyDate`) VALUES
(1, 'วันหยุดประจำปี', 'วันหยุดประจำปี', 'Holiday', 0, '1', '2023-08-04 08:28:18', '2023-08-06 06:09:32'),
(2, 'เบอร์โทรศัพท์ภายใน', 'เบอร์โทรศัพท์ภายใน', 'TelephoneNumber', 0, '', '2023-08-04 08:28:17', '0000-00-00 00:00:00'),
(6, 'แผนที่บริษัท', 'แผนที่บริษัท', 'Map', 0, 'aaa', '2023-08-17 06:55:51', '2023-09-04 02:05:49'),
(7, 'โครงสร้างองค์กร', 'โครงสร้างองค์กร', 'Management Structure', 0, 'aaa', '2023-08-17 07:05:19', '2023-08-25 10:22:25'),
(12, 'เบอร์โทรภายใน GKA', 'เบอร์โทรภายใน GKA', 'เบอร์โทรภายใน GKA', 0, 'GPDHA', '2023-08-18 07:54:17', '2023-08-18 07:54:17'),
(13, 'เบอร์โทรฉุกเฉิน GKA', 'เบอร์โทรฉุกเฉิน GKA', '-', 0, 'GKAHA', '2023-08-18 07:55:13', '2023-08-18 07:55:53'),
(19, 'ระบบจริง', 'ระบบจริง', 'System', 0, 'aaa', '2023-08-21 03:49:40', '2023-08-21 03:49:40'),
(20, 'ระบบเทส', 'ระบบเทส', 'Test System', 0, 'aaa', '2023-08-21 03:50:03', '2023-08-21 03:50:03'),
(21, 'B-Plus', 'ระบบลาและเงินเดือน', 'B-Plus', 0, 'aaa', '2023-08-24 09:41:34', '2023-08-24 09:41:34'),
(22, 'ระบบจองห้องประชุม', 'ระบบจองห้องประชุม', 'Meeting Room', 0, 'aaa', '2023-08-24 09:42:17', '2023-08-24 09:42:17'),
(23, 'เบอร์ภายใน GKE', 'เบอร์ภายใน GKE', 'GKE', 0, 'aaa', '2023-08-25 09:35:09', '2023-08-25 09:35:09'),
(24, 'เบอร์ภายใน GPD', 'เบอร์ภายใน GPD', 'GPD', 0, 'aaa', '2023-08-25 09:35:25', '2023-08-25 09:35:25'),
(25, 'เบอร์ภายใน GKA&P', 'เบอร์ภายใน GKA&P', 'GKA&P', 0, 'aaa', '2023-08-25 09:35:40', '2023-08-25 09:35:40'),
(26, 'เว็บไซต์บริษัท', 'เว็บไซต์บริษัท', 'Web', 0, 'aaa', '2023-08-25 10:27:49', '2023-08-25 10:27:49'),
(27, 'แบบฟอร์ม', 'แบบฟอร์ม', 'Printed Form', 0, '', '2023-09-04 02:57:19', '2023-09-04 02:57:19'),
(28, 'วิสัยทัศน์และพันธกิจ', 'วิสัยทัศน์และพันธกิจ', 'Vision & Mission', 0, 'admin', '2023-09-04 07:02:28', '2023-09-04 07:02:28');

-- --------------------------------------------------------

--
-- Table structure for table `fileactivities`
--

CREATE TABLE `fileactivities` (
  `FA_Code` int(11) NOT NULL,
  `FA_Entity No.` int(11) NOT NULL,
  `FA_UserCreate` varchar(255) NOT NULL,
  `FA_Date` date NOT NULL,
  `FA_Time` time NOT NULL,
  `FA_Title` varchar(255) NOT NULL,
  `FA_Description` varchar(255) NOT NULL,
  `FA_File` varchar(255) NOT NULL,
  `CountPage` int(11) NOT NULL,
  `FA_CreateDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `FA_ModifyDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `GR_Entity No.` int(11) NOT NULL,
  `GR_Activities Code` int(11) NOT NULL,
  `GR_Name` varchar(255) NOT NULL,
  `GR_CreateDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `GR_ModifyDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grouppositionheader`
--

CREATE TABLE `grouppositionheader` (
  `GH_Code` int(11) NOT NULL,
  `GH_Name` varchar(255) DEFAULT NULL,
  `GH_CreateDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `GH_ModifyDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grouppositionline`
--

CREATE TABLE `grouppositionline` (
  `GL_Code` int(11) NOT NULL,
  `GH_Code` int(11) DEFAULT NULL,
  `PT_Code` int(11) DEFAULT NULL,
  `GL_CreateDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `GL_ModifyDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `heading`
--

CREATE TABLE `heading` (
  `HD_Code` int(11) NOT NULL,
  `HD_Text` longtext DEFAULT NULL,
  `HD_Active` tinyint(1) NOT NULL DEFAULT 1,
  `HD_Sort` int(11) NOT NULL DEFAULT 0,
  `HG_Code` int(11) DEFAULT NULL,
  `HD_UserCreate` varchar(255) NOT NULL,
  `HD_CreateDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `HD_ModifyDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `headingcategories`
--

CREATE TABLE `headingcategories` (
  `HC_Code` int(11) NOT NULL,
  `HC_Text` varchar(255) DEFAULT NULL,
  `HC_DescriptionTH` varchar(255) NOT NULL,
  `HC_DescriptionEN` varchar(255) NOT NULL,
  `HC_DefaultImage` varchar(255) NOT NULL,
  `CountPage` int(11) NOT NULL,
  `HC_UserCreate` varchar(255) NOT NULL,
  `HC_CreateDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `HC_ModifyDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `headingcategories`
--

INSERT INTO `headingcategories` (`HC_Code`, `HC_Text`, `HC_DescriptionTH`, `HC_DescriptionEN`, `HC_DefaultImage`, `CountPage`, `HC_UserCreate`, `HC_CreateDate`, `HC_ModifyDate`) VALUES
(1, 'INTERNAL RECRUITMENT', 'ตำแหน่งงานว่างภายใน', 'INTERNAL RECRUITMENT', '', 49, '', '2023-07-25 08:57:55', '0000-00-00 00:00:00'),
(2, 'FAQ', 'คำถามที่พบบ่อย', 'FAQs', '2.jpg', 67, '', '2023-07-25 08:57:55', '2023-08-15 07:32:27');

-- --------------------------------------------------------

--
-- Table structure for table `headinggroup`
--

CREATE TABLE `headinggroup` (
  `HG_Code` int(11) NOT NULL,
  `HG_Text` varchar(255) DEFAULT NULL,
  `HG_Active` tinyint(1) NOT NULL DEFAULT 1,
  `HG_Sort` int(11) NOT NULL DEFAULT 0,
  `HC_Code` int(11) DEFAULT NULL,
  `HG_UserCreate` varchar(255) NOT NULL,
  `HG_CreateDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `HG_ModifyDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `indexsetup`
--

CREATE TABLE `indexsetup` (
  `IS_Code` int(11) NOT NULL,
  `IS_GroupCategory1` int(11) NOT NULL,
  `IS_GroupCategory2` int(11) NOT NULL,
  `IS_GroupMenu1` varchar(255) NOT NULL,
  `IS_GroupMenu1_Box1` int(11) NOT NULL,
  `IS_GroupMenu2` varchar(255) NOT NULL,
  `IS_GroupMenu2_Box2` int(11) NOT NULL,
  `IS_GroupMenu3` varchar(255) NOT NULL,
  `IS_GroupMenu3_Box3` int(11) NOT NULL,
  `IS_GroupMenu4` varchar(255) NOT NULL,
  `IS_GroupMenu4_Box4` int(11) NOT NULL,
  `IS_UserCreate` varchar(255) NOT NULL,
  `IS_CreateDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `IS_ModifyDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `indexsetup`
--

INSERT INTO `indexsetup` (`IS_Code`, `IS_GroupCategory1`, `IS_GroupCategory2`, `IS_GroupMenu1`, `IS_GroupMenu1_Box1`, `IS_GroupMenu2`, `IS_GroupMenu2_Box2`, `IS_GroupMenu3`, `IS_GroupMenu3_Box3`, `IS_GroupMenu4`, `IS_GroupMenu4_Box4`, `IS_UserCreate`, `IS_CreateDate`, `IS_ModifyDate`) VALUES
(1, 1, 19, '', 0, 'category', 2, 'category', 4, 'headingcategories', 2, 'admin', '2023-08-11 08:35:55', '2023-09-04 02:18:41');

-- --------------------------------------------------------

--
-- Table structure for table `masterheadingcategories`
--

CREATE TABLE `masterheadingcategories` (
  `MC_Code` int(11) NOT NULL,
  `MC_Text` varchar(255) NOT NULL,
  `HC_Code` int(11) NOT NULL,
  `MC_UserCreate` varchar(255) NOT NULL,
  `MC_CreateDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `MC_ModifyDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `masterheadingcategories`
--

INSERT INTO `masterheadingcategories` (`MC_Code`, `MC_Text`, `HC_Code`, `MC_UserCreate`, `MC_CreateDate`, `MC_ModifyDate`) VALUES
(1, 'รายละเอียด :', 1, 'bbb', '2023-08-06 06:47:21', '2023-08-06 06:47:21'),
(2, 'คุณสมบัติ :', 1, 'bbb', '2023-08-06 06:47:21', '2023-08-06 06:47:21'),
(3, 'ติดต่อ :', 1, 'aaa', '2023-08-18 07:44:23', '2023-08-18 07:44:23');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `MN_Code` int(11) NOT NULL,
  `MN_Name` varchar(255) NOT NULL,
  `MN_CreateDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `MN_ModifyDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`MN_Code`, `MN_Name`, `MN_CreateDate`, `MN_ModifyDate`) VALUES
(1, 'About Us', '2023-08-15 05:07:06', '2023-08-24 09:25:53'),
(2, 'ข่าวสารและกิจกรรม', '2023-08-15 07:57:49', '2023-08-24 09:26:13'),
(3, 'e-Learning', '2023-08-15 08:00:18', '2023-08-25 06:48:17'),
(4, 'เบอร์ภายใน', '2023-08-15 08:00:43', '2023-08-24 09:27:01'),
(5, 'มุม HR', '2023-08-15 08:01:03', '2023-08-24 09:27:10'),
(6, 'Link ภายใน', '2023-08-15 08:01:21', '2023-08-24 09:27:21');

-- --------------------------------------------------------

--
-- Table structure for table `permissionmenu`
--

CREATE TABLE `permissionmenu` (
  `PM_Code` int(11) NOT NULL,
  `PM_RelationPermission` int(11) NOT NULL,
  `PM_Menu` int(11) NOT NULL,
  `PM_RelationType` varchar(255) NOT NULL,
  `PM_RelationCode` int(11) NOT NULL,
  `PM_Name` varchar(255) NOT NULL,
  `PM_Direction` varchar(255) NOT NULL,
  `PM_Draw` tinyint(1) NOT NULL DEFAULT 0,
  `PM_Setup` tinyint(1) NOT NULL DEFAULT 0,
  `PM_UserCreate` varchar(255) NOT NULL,
  `PM_CreateDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `PM_ModifyDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `permissionmenu`
--

INSERT INTO `permissionmenu` (`PM_Code`, `PM_RelationPermission`, `PM_Menu`, `PM_RelationType`, `PM_RelationCode`, `PM_Name`, `PM_Direction`, `PM_Draw`, `PM_Setup`, `PM_UserCreate`, `PM_CreateDate`, `PM_ModifyDate`) VALUES
(12, 0, 6, 'EngravedCategory', 21, 'B-Plus', 'left', 0, 0, 'aaa', '2023-08-17 02:00:19', '2023-08-25 06:43:57'),
(17, 0, 2, 'Category', 19, 'ประกาศ', 'left', 0, 0, 'admin', '2023-08-17 02:06:31', '2023-09-04 02:47:45'),
(21, 0, 5, 'NoType', 0, 'นโยบาย***', 'left', 0, 0, '', '2023-08-17 02:09:30', '2023-09-04 02:59:50'),
(23, 0, 2, 'Category', 27, 'ข่าวสาร', 'left', 0, 0, 'admin', '2023-08-17 02:09:55', '2023-09-04 02:47:45'),
(46, 0, 4, 'EngravedCategory', 23, 'GKE', 'right', 0, 0, 'aaa', '2023-08-18 08:07:26', '2023-08-25 09:46:02'),
(48, 0, 10, 'Category', 19, 'รายชื่อผับ', 'left', 0, 0, 'GKEHA3', '2023-08-18 08:08:43', '2023-08-18 08:08:43'),
(74, 0, 6, 'EngravedCategory', 19, 'E-doc', 'left', 0, 0, 'aaa', '2023-08-24 09:44:58', '2023-08-25 06:43:57'),
(75, 0, 6, 'EngravedCategory', 20, 'E-doc-Dev', 'left', 0, 1, 'aaa', '2023-08-24 09:44:58', '2023-08-25 06:43:57'),
(76, 0, 6, 'EngravedCategory', 22, 'ระบบจองห้องประชุม', 'left', 0, 0, 'aaa', '2023-08-24 09:44:58', '2023-08-25 06:43:57'),
(77, 0, 6, 'NoType', 0, 'ระบบจัดการข่าวสาร', 'left', 1, 1, 'aaa', '2023-08-24 09:46:10', '2023-08-25 06:43:57'),
(78, 0, 6, 'NoType', 0, 'ระบบประกาศ', 'left', 0, 1, 'aaa', '2023-08-24 10:00:47', '2023-08-25 06:43:57'),
(79, 0, 6, 'Setup', 0, 'SetUp', 'left', 0, 1, 'aaa', '2023-08-24 10:00:47', '2023-08-25 06:43:57'),
(80, 78, 0, 'HeadingCategories', 1, 'ตำแหน่งว่างภายใน', 'left', 0, 1, 'aaa', '2023-08-24 10:01:20', '2023-08-24 10:01:20'),
(81, 78, 0, 'HeadingCategories', 2, 'FAQ', 'left', 0, 1, 'aaa', '2023-08-24 10:01:20', '2023-08-24 10:01:20'),
(82, 77, 0, 'Category', 1, 'กิจกรรม', 'left', 0, 1, '', '2023-08-24 10:03:11', '2023-09-04 03:16:23'),
(83, 77, 0, 'Category', 2, 'ทักษะทางสังคมที่ใช้เพื่อปฏิสัมพันธ์', 'left', 0, 1, '', '2023-08-24 10:03:11', '2023-09-04 03:16:23'),
(84, 77, 0, 'Category', 1, 'ทักษะหรือความสามารถในแต่ละสายอาชีพ', 'left', 0, 1, '', '2023-08-24 10:03:11', '2023-09-04 03:16:23'),
(85, 77, 0, 'Category', 4, 'แบ่งปันความรู้', 'left', 0, 1, '', '2023-08-24 10:03:11', '2023-09-04 03:16:23'),
(86, 77, 0, 'Category', 10, 'แกลลอรี่', 'left', 0, 1, '', '2023-08-24 10:03:11', '2023-09-04 03:16:23'),
(87, 77, 0, 'Category', 19, 'ประกาศทั่วไป', 'left', 0, 1, '', '2023-08-24 10:03:11', '2023-09-04 03:16:23'),
(88, 77, 0, 'Category', 20, 'ประกาศจากฝ่ายบุคคล', 'left', 0, 1, '', '2023-08-24 10:03:11', '2023-09-04 03:16:23'),
(90, 0, 4, 'EngravedCategory', 24, 'GPD', 'right', 0, 0, 'aaa', '2023-08-25 09:37:02', '2023-08-25 09:46:02'),
(91, 0, 4, 'EngravedCategory', 25, 'GKA&P', 'right', 0, 0, 'aaa', '2023-08-25 09:37:02', '2023-08-25 09:46:02'),
(93, 0, 5, 'EngravedCategory', 1, 'วันหยุดประจำปี', 'left', 0, 0, '', '2023-08-25 10:15:46', '2023-09-04 02:59:50'),
(94, 0, 5, 'HeadingCategories', 1, 'ตำแหน่งว่างภายใน', 'left', 0, 0, '', '2023-08-25 10:16:03', '2023-09-04 02:59:50'),
(95, 0, 5, 'HeadingCategories', 2, 'คำถามที่พบบ่อยจากฝ่าย HR', 'left', 0, 0, '', '2023-08-25 10:16:41', '2023-09-04 02:59:50'),
(96, 0, 5, 'EngravedCategory', 27, 'แบบฟอร์ม', 'left', 0, 0, '', '2023-08-25 10:17:18', '2023-09-04 02:59:50'),
(97, 0, 5, 'Category', 31, 'เกมส์', 'left', 0, 0, '', '2023-08-25 10:17:18', '2023-09-04 02:59:50'),
(98, 0, 3, 'Category', 4, 'Knowledge sharing', 'left', 0, 0, '', '2023-08-25 10:19:09', '2023-09-04 02:51:15'),
(99, 0, 3, 'Category', 28, 'Technical Skill', 'left', 0, 0, '', '2023-08-25 10:19:09', '2023-09-04 02:51:15'),
(100, 0, 3, 'Category', 2, 'Soft Skill', 'left', 0, 0, '', '2023-08-25 10:19:09', '2023-09-04 02:51:15'),
(101, 0, 3, 'Category', 29, 'บทความ', 'left', 0, 0, '', '2023-08-25 10:19:09', '2023-09-04 02:51:15'),
(102, 0, 2, 'Category', 1, 'ประชาสัมพันธ์กิจกรรม', 'left', 0, 0, 'admin', '2023-08-25 10:20:51', '2023-09-04 02:47:45'),
(103, 0, 2, 'Category', 10, 'ภาพกิจกรรม', 'left', 0, 0, 'admin', '2023-08-25 10:20:51', '2023-09-04 02:47:45'),
(104, 0, 1, 'EngravedCategory', 7, 'โครงสร้างองค์กร', 'right', 0, 0, 'admin', '2023-08-25 10:26:46', '2023-09-04 07:04:36'),
(105, 0, 1, 'EngravedCategory', 28, 'ค่านิยมองค์กร', 'right', 0, 0, 'admin', '2023-08-25 10:26:46', '2023-09-04 07:04:36'),
(106, 0, 1, 'EngravedCategory', 6, 'แผนที่บริษัท', 'right', 0, 0, 'admin', '2023-08-25 10:26:46', '2023-09-04 07:04:36'),
(107, 0, 1, 'EngravedCategory', 26, 'เว็บไซต์บริษัท', 'right', 0, 0, 'admin', '2023-08-25 10:26:46', '2023-09-04 07:04:36'),
(108, 77, 0, 'Category', 27, 'ข่าว', 'left', 0, 0, '', '2023-09-04 03:16:23', '2023-09-04 03:16:23'),
(109, 77, 0, 'Category', 28, 'ทักษะทางเทคนิค', 'left', 0, 0, '', '2023-09-04 03:16:23', '2023-09-04 03:16:23'),
(110, 77, 0, 'Category', 29, 'บทความ', 'left', 0, 0, '', '2023-09-04 03:16:23', '2023-09-04 03:16:23'),
(111, 77, 0, 'Category', 30, 'นโยบาย', 'left', 0, 0, '', '2023-09-04 03:16:23', '2023-09-04 03:16:23'),
(112, 77, 0, 'Category', 31, 'เกมส์', 'left', 0, 0, '', '2023-09-04 03:16:23', '2023-09-04 03:16:23');

-- --------------------------------------------------------

--
-- Table structure for table `permissionposition`
--

CREATE TABLE `permissionposition` (
  `PP_Code` int(11) NOT NULL,
  `PP_Type` enum('single','multi') NOT NULL,
  `PT_Code` int(11) NOT NULL,
  `PM_Code` int(11) NOT NULL,
  `PP_CreateDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `PP_ModifyDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `permissionposition`
--

INSERT INTO `permissionposition` (`PP_Code`, `PP_Type`, `PT_Code`, `PM_Code`, `PP_CreateDate`, `PP_ModifyDate`) VALUES
(7, 'multi', 1, 55, '2023-08-24 08:08:16', '2023-08-24 08:08:16'),
(8, 'multi', 1, 69, '2023-08-24 08:15:43', '2023-08-24 08:15:43'),
(9, 'multi', 1, 68, '2023-08-24 08:19:32', '2023-08-24 08:19:32'),
(10, 'multi', 1, 70, '2023-08-24 08:48:18', '2023-08-24 08:48:18'),
(11, 'single', 12, 79, '2023-08-25 03:17:56', '2023-08-25 03:17:56'),
(12, 'single', 12, 82, '2023-08-25 03:50:06', '2023-08-25 03:50:06');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `PT_Code` int(11) NOT NULL,
  `PT_Name` varchar(255) NOT NULL,
  `PT_Default` tinyint(1) NOT NULL DEFAULT 0,
  `PT_Admin` tinyint(1) NOT NULL DEFAULT 0,
  `PT_CreateDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `PT_ModifyDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`PT_Code`, `PT_Name`, `PT_Default`, `PT_Admin`, `PT_CreateDate`, `PT_ModifyDate`) VALUES
(1, 'Programmer', 0, 0, '2023-08-09 01:38:11', '2023-08-09 01:38:11'),
(2, 'IT', 0, 0, '2023-08-09 01:38:32', '2023-08-09 01:38:32'),
(3, 'แผนกค่าตอบแทนและสวัสดิการ', 0, 0, '2023-08-17 07:16:36', '2023-08-31 08:22:46'),
(4, 'แผนกสรรหาว่าจ้าง', 0, 0, '2023-08-17 07:16:56', '2023-08-31 08:23:02'),
(5, 'แผนก HROD', 0, 0, '2023-08-17 07:18:02', '2023-08-31 08:23:16'),
(6, 'แผนกธุรการและซ่อมบำรุง', 0, 0, '2023-08-17 07:18:14', '2023-08-31 08:23:29'),
(7, 'ฝ่าย HS', 0, 0, '2023-08-17 07:18:27', '2023-08-31 08:23:47'),
(11, 'General', 1, 0, '2023-08-21 10:04:26', '2023-08-21 10:05:20'),
(12, 'Admin', 0, 1, '2023-08-21 10:21:34', '2023-08-21 10:21:34');

-- --------------------------------------------------------

--
-- Table structure for table `setposition`
--

CREATE TABLE `setposition` (
  `SP_Code` bigint(11) NOT NULL,
  `SP_Name` varchar(255) NOT NULL,
  `US_Username` varchar(255) NOT NULL,
  `PT_Code` int(11) NOT NULL,
  `SP_CreateDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `SP_ModifyDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `setposition`
--

INSERT INTO `setposition` (`SP_Code`, `SP_Name`, `US_Username`, `PT_Code`, `SP_CreateDate`, `SP_ModifyDate`) VALUES
(1, '', 'ddd', 11, '2023-08-22 03:38:39', '2023-08-22 03:40:53'),
(66, '', 'bbb', 12, '2023-08-24 05:40:54', '2023-08-24 05:40:54'),
(68, '', 'ccc', 2, '2023-08-24 08:09:37', '2023-08-24 08:09:37'),
(69, '', 'ddd', 2, '2023-08-24 08:09:37', '2023-08-24 08:09:37'),
(70, '', 'aaa', 1, '2023-08-24 08:48:52', '2023-08-24 08:48:52'),
(71, '', 'aaa', 2, '2023-08-24 08:48:52', '2023-08-24 08:48:52'),
(72, '', 'aaa', 7, '2023-08-24 08:48:52', '2023-08-24 08:48:52'),
(73, '', 'aaa', 11, '2023-08-24 08:48:52', '2023-08-24 08:48:52'),
(74, '', 'aaa', 12, '2023-08-24 08:48:52', '2023-08-24 08:48:52'),
(75, '', '', 11, '2023-08-25 08:57:22', '2023-08-25 08:57:22'),
(76, '', 'zzz', 11, '2023-08-25 09:00:42', '2023-08-25 09:30:10'),
(77, '', 'yyy', 11, '2023-08-28 02:37:09', '2023-08-28 02:37:09'),
(78, '', 'xxx', 11, '2023-08-28 02:48:07', '2023-08-28 02:48:07'),
(79, '', 'vvv', 11, '2023-08-28 02:49:49', '2023-08-28 02:49:49'),
(80, '', 'admin', 12, '2023-08-31 08:26:19', '2023-08-31 08:26:19');

-- --------------------------------------------------------

--
-- Table structure for table `setup`
--

CREATE TABLE `setup` (
  `SU_Code` int(11) NOT NULL,
  `SU_DefaultImageNews` varchar(255) DEFAULT NULL,
  `SU_PathDefaultImageNews` varchar(255) NOT NULL,
  `SU_PathDefaultImageGallery` varchar(255) NOT NULL,
  `SU_PathDefaultFile` varchar(255) NOT NULL,
  `SU_HeaderDescriptionTH` varchar(255) NOT NULL,
  `SU_HeaderDescriptionEN` varchar(255) NOT NULL,
  `CountPage` int(11) NOT NULL,
  `SU_CreateDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `SU_ModifyDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `setup`
--

INSERT INTO `setup` (`SU_Code`, `SU_DefaultImageNews`, `SU_PathDefaultImageNews`, `SU_PathDefaultImageGallery`, `SU_PathDefaultFile`, `SU_HeaderDescriptionTH`, `SU_HeaderDescriptionEN`, `CountPage`, `SU_CreateDate`, `SU_ModifyDate`) VALUES
(1, '0.jpg', 'img/UploadAddActivities/', 'img/UploadAddGallery/', 'PDF/UploadAddActivities/', 'บริษัท กันกุลเอ็นจิเนียริ่ง จำกัด (มหาชน)', 'LEADING INTEGRATED ENERGY PLAYER', 1683, '2023-06-22 04:40:33', '2023-09-04 10:14:59');

--
-- Triggers `setup`
--
DELIMITER $$
CREATE TRIGGER `set_SU_ModifyDate` BEFORE UPDATE ON `setup` FOR EACH ROW BEGIN
  SET NEW.SU_ModifyDate = CURRENT_TIMESTAMP;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `setupgames`
--

CREATE TABLE `setupgames` (
  `GA_Code` int(11) NOT NULL,
  `GA_Iframe` varchar(500) NOT NULL,
  `GA_CreateDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `GA_ModifyDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `setupgames`
--

INSERT INTO `setupgames` (`GA_Code`, `GA_Iframe`, `GA_CreateDate`, `GA_ModifyDate`) VALUES
(1, '<iframe style=\"max-width:100%\" src=\"https://wordwall.net/th/embed/620534d5e58a47b7939eb484a22c7505?themeId=52&templateId=2&fontStackId=0\" width=\"500\" height=\"800\" frameborder=\"0\" allowfullscreen></iframe>', '2023-08-11 01:59:32', '2023-08-11 01:59:32'),
(2, '<iframe style=\"max-width:100%\" src=\"https://wordwall.net/th/embed/620534d5e58a47b7939eb484a22c7505?themeId=52&templateId=38&fontStackId=0\" width=\"500\" height=\"800\" frameborder=\"0\" allowfullscreen></iframe>', '2023-08-11 01:59:32', '2023-08-11 01:59:32'),
(3, '<iframe style=\"max-width:100%\" src=\"https://wordwall.net/th/embed/620534d5e58a47b7939eb484a22c7505?themeId=52&templateId=8&fontStackId=0\" width=\"500\" height=\"800\" frameborder=\"0\" allowfullscreen></iframe>', '2023-08-11 01:59:32', '2023-08-11 01:59:32'),
(4, '<iframe style=\"max-width:100%\" src=\"https://wordwall.net/th/embed/620534d5e58a47b7939eb484a22c7505?themeId=21&templateId=69&fontStackId=0\" width=\"500\" height=\"800\" frameborder=\"0\" allowfullscreen></iframe>', '2023-08-11 01:59:32', '2023-08-11 01:59:32'),
(5, '<iframe style=\"max-width:100%\" src=\"https://wordwall.net/th/embed/620534d5e58a47b7939eb484a22c7505?themeId=52&templateId=30&fontStackId=0\" width=\"500\" height=\"800\" frameborder=\"0\" allowfullscreen></iframe>', '2023-08-11 01:59:32', '2023-08-11 01:59:32'),
(6, '<iframe style=\"max-width:100%\" src=\"https://wordwall.net/th/embed/620534d5e58a47b7939eb484a22c7505?themeId=44&templateId=73&fontStackId=0\" width=\"500\" height=\"800\" frameborder=\"0\" allowfullscreen></iframe>', '2023-08-11 01:59:32', '2023-08-11 01:59:32'),
(7, '<iframe style=\"max-width:100%\" src=\"https://wordwall.net/th/embed/620534d5e58a47b7939eb484a22c7505?themeId=52&templateId=5&fontStackId=0\" width=\"500\" height=\"800\" frameborder=\"0\" allowfullscreen></iframe>', '2023-08-11 01:59:32', '2023-08-11 01:59:32'),
(8, '<iframe style=\"max-width:100%\" src=\"https://wordwall.net/th/embed/620534d5e58a47b7939eb484a22c7505?themeId=52&templateId=70&fontStackId=0\" width=\"500\" height=\"800\" frameborder=\"0\" allowfullscreen></iframe>', '2023-08-11 01:59:32', '2023-08-11 01:59:32');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `US_Username` varchar(255) NOT NULL,
  `US_Password` varchar(255) NOT NULL,
  `US_Prefix` enum('นาย','นาง','นางสาว') NOT NULL,
  `US_Fname` varchar(255) NOT NULL,
  `US_Lname` varchar(255) NOT NULL,
  `US_Image` varchar(255) NOT NULL,
  `US_Active` tinyint(1) NOT NULL DEFAULT 1,
  `PT_Code` int(11) NOT NULL,
  `US_CreateDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `US_ModifyDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`US_Username`, `US_Password`, `US_Prefix`, `US_Fname`, `US_Lname`, `US_Image`, `US_Active`, `PT_Code`, `US_CreateDate`, `US_ModifyDate`) VALUES
('admin', '1234', 'นาย', 'Programmer', 'Programmer', 'admin.png', 1, 0, '2023-08-18 06:10:16', '2023-09-01 01:38:06'),
('GKAHA', 'Gunkul@1', 'นาย', 'แผนกค่าตอบแทนและสวัสดิการ', 'แผนกค่าตอบแทนและสวัสดิการ', 'GKAHA.jpg', 1, 0, '2023-08-17 07:25:22', '2023-08-31 08:20:41'),
('GKEHA1', 'Gunkul@1', 'นาย', 'แผนกสรรหาว่าจ้าง', 'แผนกสรรหาว่าจ้าง', 'GKEHA1.jpg', 1, 0, '2023-08-17 07:20:56', '2023-08-31 08:20:58'),
('GKEHA2', 'Gunkul@1', 'นาย', 'แผนก HROD', 'แผนก HROD', 'GKEHA2.jpg', 1, 0, '2023-08-17 07:22:10', '2023-08-31 08:21:16'),
('GKEHA3', 'Gunkul@1', 'นาย', 'แผนกธุรการและซ่อมบำรุง', 'แผนกธุรการและซ่อมบำรุง', '', 1, 0, '2023-08-17 07:22:43', '2023-08-31 08:21:37'),
('GKEHA4', 'Gunkul@1', 'นาย', 'ฝ่าย HS', 'ฝ่าย HS', '', 1, 0, '2023-08-17 07:23:39', '2023-08-31 08:22:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`AT_Code`);

--
-- Indexes for table `alertpopup`
--
ALTER TABLE `alertpopup`
  ADD PRIMARY KEY (`AP_Code`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CG_Entity No.`);

--
-- Indexes for table `details`
--
ALTER TABLE `details`
  ADD PRIMARY KEY (`DT_Code`);

--
-- Indexes for table `engravedactivities`
--
ALTER TABLE `engravedactivities`
  ADD PRIMARY KEY (`EA_Code`);

--
-- Indexes for table `engravedcategory`
--
ALTER TABLE `engravedcategory`
  ADD PRIMARY KEY (`EC_Code`);

--
-- Indexes for table `fileactivities`
--
ALTER TABLE `fileactivities`
  ADD PRIMARY KEY (`FA_Code`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`GR_Entity No.`);

--
-- Indexes for table `grouppositionheader`
--
ALTER TABLE `grouppositionheader`
  ADD PRIMARY KEY (`GH_Code`);

--
-- Indexes for table `grouppositionline`
--
ALTER TABLE `grouppositionline`
  ADD PRIMARY KEY (`GL_Code`),
  ADD KEY `GH_Code` (`GH_Code`);

--
-- Indexes for table `heading`
--
ALTER TABLE `heading`
  ADD PRIMARY KEY (`HD_Code`);

--
-- Indexes for table `headingcategories`
--
ALTER TABLE `headingcategories`
  ADD PRIMARY KEY (`HC_Code`);

--
-- Indexes for table `headinggroup`
--
ALTER TABLE `headinggroup`
  ADD PRIMARY KEY (`HG_Code`);

--
-- Indexes for table `indexsetup`
--
ALTER TABLE `indexsetup`
  ADD PRIMARY KEY (`IS_Code`);

--
-- Indexes for table `masterheadingcategories`
--
ALTER TABLE `masterheadingcategories`
  ADD PRIMARY KEY (`MC_Code`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`MN_Code`);

--
-- Indexes for table `permissionmenu`
--
ALTER TABLE `permissionmenu`
  ADD PRIMARY KEY (`PM_Code`);

--
-- Indexes for table `permissionposition`
--
ALTER TABLE `permissionposition`
  ADD PRIMARY KEY (`PP_Code`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`PT_Code`);

--
-- Indexes for table `setposition`
--
ALTER TABLE `setposition`
  ADD PRIMARY KEY (`SP_Code`);

--
-- Indexes for table `setup`
--
ALTER TABLE `setup`
  ADD PRIMARY KEY (`SU_Code`);

--
-- Indexes for table `setupgames`
--
ALTER TABLE `setupgames`
  ADD PRIMARY KEY (`GA_Code`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`US_Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `AT_Code` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `alertpopup`
--
ALTER TABLE `alertpopup`
  MODIFY `AP_Code` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CG_Entity No.` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `details`
--
ALTER TABLE `details`
  MODIFY `DT_Code` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `engravedactivities`
--
ALTER TABLE `engravedactivities`
  MODIFY `EA_Code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `engravedcategory`
--
ALTER TABLE `engravedcategory`
  MODIFY `EC_Code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `fileactivities`
--
ALTER TABLE `fileactivities`
  MODIFY `FA_Code` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `GR_Entity No.` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grouppositionheader`
--
ALTER TABLE `grouppositionheader`
  MODIFY `GH_Code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `grouppositionline`
--
ALTER TABLE `grouppositionline`
  MODIFY `GL_Code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `heading`
--
ALTER TABLE `heading`
  MODIFY `HD_Code` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `headingcategories`
--
ALTER TABLE `headingcategories`
  MODIFY `HC_Code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `headinggroup`
--
ALTER TABLE `headinggroup`
  MODIFY `HG_Code` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `indexsetup`
--
ALTER TABLE `indexsetup`
  MODIFY `IS_Code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `masterheadingcategories`
--
ALTER TABLE `masterheadingcategories`
  MODIFY `MC_Code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `MN_Code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `permissionmenu`
--
ALTER TABLE `permissionmenu`
  MODIFY `PM_Code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `permissionposition`
--
ALTER TABLE `permissionposition`
  MODIFY `PP_Code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `PT_Code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `setposition`
--
ALTER TABLE `setposition`
  MODIFY `SP_Code` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `setup`
--
ALTER TABLE `setup`
  MODIFY `SU_Code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `setupgames`
--
ALTER TABLE `setupgames`
  MODIFY `GA_Code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grouppositionline`
--
ALTER TABLE `grouppositionline`
  ADD CONSTRAINT `grouppositionline_ibfk_1` FOREIGN KEY (`GH_Code`) REFERENCES `grouppositionheader` (`GH_Code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
