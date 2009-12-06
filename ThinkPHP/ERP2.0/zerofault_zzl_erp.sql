-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: mysql.hosting.zymic.com
-- Generation Time: Dec 06, 2009 at 04:03 PM
-- Server version: 5.0.75
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zerofault_zzl_erp`
--

-- --------------------------------------------------------

--
-- Table structure for table `erp_category`
--

DROP TABLE IF EXISTS `erp_category`;
CREATE TABLE `erp_category` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `type` enum('Component','Board') NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `erp_category`
--

INSERT INTO `erp_category` (`id`, `type`, `code`, `name`) VALUES
(1, 'Component', 'P001', 'Resistor'),
(2, 'Component', 'P002', 'Capacitor'),
(3, 'Component', 'P003', 'PC'),
(4, 'Component', 'P004', 'Debugger'),
(5, 'Component', 'P005', 'Fabricated Board'),
(6, 'Component', 'P006', 'IC'),
(7, 'Component', 'P007', 'Mechanical'),
(8, 'Component', 'P008', 'Elec-Mech'),
(9, 'Component', 'P009', 'Cable'),
(10, 'Component', 'P010', 'Fixed  assets'),
(11, 'Component', 'P011', 'Purchased Board'),
(12, 'Board', 'P012', 'Internal');

-- --------------------------------------------------------

--
-- Table structure for table `erp_department`
--

DROP TABLE IF EXISTS `erp_department`;
CREATE TABLE `erp_department` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `function` varchar(255) NOT NULL,
  `leader_id` smallint(5) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `erp_department`
--

INSERT INTO `erp_department` (`id`, `code`, `name`, `function`, `leader_id`) VALUES
(1, 'D001', 'HW', 'Hardware', 1),
(2, 'D002', 'SW', 'Software design', 1),
(3, 'D003', 'FPGA', 'IC design', 1),
(4, 'D004', 'SAN office', 'Headquarter', 1),
(5, 'D005', 'Support', 'Support whole team', 1),
(6, 'D006', 'HR', '', 0),
(7, 'D007', 'Admin', 'Design Director', 6),
(8, 'D008', 'Warehouse', 'Storage the goods', 1),
(9, 'D009', 'Public', 'Use in public', 0);

-- --------------------------------------------------------

--
-- Table structure for table `erp_node`
--

DROP TABLE IF EXISTS `erp_node`;
CREATE TABLE `erp_node` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `pid` smallint(6) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `descr` tinytext,
  `level` tinyint(1) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `erp_node`
--

INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `descr`, `level`, `type`) VALUES
(1, 0, 'Supplier', 'Supplier Management', NULL, 0, 0),
(2, 1, 'index', 'List', NULL, 0, 0),
(3, 1, 'form', 'Add/Edit Form', NULL, 0, 0),
(4, 1, 'submit', 'Submit adding/changing', NULL, 0, 0),
(5, 1, 'delete', 'Delete', NULL, 0, 0),
(6, 0, 'Dept', 'Department Management', NULL, 0, 0),
(7, 6, 'index', 'List', NULL, 0, 0),
(8, 30, 'index', 'Query', NULL, 0, 0),
(9, 6, 'submit', 'Submit adding/changing', NULL, 0, 0),
(10, 6, 'delete', 'Delete', NULL, 0, 0),
(11, 0, 'Staff', 'Staff Management', NULL, 0, 0),
(12, 11, 'index', 'List', NULL, 0, 0),
(13, 11, 'form', 'Add/Edit Form', NULL, 0, 0),
(14, 11, 'submit', 'Submit adding/changing', NULL, 0, 0),
(15, 11, 'update', 'Disable/Enable Staff', NULL, 0, 0),
(16, 0, 'Category', 'Category Management', NULL, 0, 0),
(17, 16, 'index', 'List', NULL, 0, 0),
(18, 16, 'submit', 'Submit adding/changing', NULL, 0, 0),
(19, 16, 'delete', 'Delete', NULL, 0, 0),
(20, 0, 'Product', 'Component Management', NULL, 0, 0),
(21, 20, 'index', 'List', NULL, 0, 0),
(22, 20, 'form', 'Add/Edit Form', NULL, 0, 0),
(23, 20, 'submit', '  	 Submit adding/changing', NULL, 0, 0),
(24, 20, 'delete', 'Delete', NULL, 0, 0),
(25, 0, 'Board', 'Board Management', NULL, 0, 0),
(26, 25, 'index', 'List', NULL, 0, 0),
(27, 25, 'form', 'Add/Edit Form', NULL, 0, 0),
(28, 25, 'submit', 'Submit adding/changing', NULL, 0, 0),
(29, 25, 'delete', 'Delete', NULL, 0, 0),
(30, 0, 'Inventory', 'Inventory Query', NULL, 0, 0),
(31, 0, 'Setting', 'Options Setting', NULL, 0, 0),
(32, 0, 'ProductIn', 'Inventory Input Management', NULL, 0, 0),
(33, 31, 'index', 'List', NULL, 0, 0),
(34, 31, 'submit', 'Submit adding/changing', NULL, 0, 0),
(35, 31, 'delete', 'Delete', NULL, 0, 0),
(36, 32, 'index', 'Product Entering List', NULL, 0, 0),
(37, 32, 'returns', 'Product Return List ', NULL, 0, 0),
(38, 32, 'confirm', 'Confirm the Entering/Return', NULL, 0, 0),
(39, 32, 'form', 'Add/Edit Form', NULL, 0, 0),
(40, 32, 'submit', 'Submit adding/changing', NULL, 0, 0),
(41, 32, 'delete', 'Delete', NULL, 0, 0),
(42, 0, 'Role', 'Role Management', NULL, 0, 0),
(43, 42, 'index', 'List', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `erp_options`
--

DROP TABLE IF EXISTS `erp_options`;
CREATE TABLE `erp_options` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `sort` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `erp_options`
--

INSERT INTO `erp_options` (`id`, `type`, `name`, `code`, `sort`) VALUES
(1, 'character', 'Agent', '', 1),
(2, 'character', 'Manufacture', '', 2),
(3, 'character', 'Other', '', 3),
(4, 'payment_terms', 'Due 20th Of the Following Month', '', 1),
(5, 'payment_terms', 'Due By End Of The Following Month', '', 2),
(6, 'payment_terms', 'Payment due within 7 days', '', 3),
(7, 'payment_terms', 'Cash Only', '', 4),
(8, 'tax', 'Default tax group', '', 1),
(9, 'tax', 'Ontario', '', 2),
(10, 'tax', 'UK Inland Revenue', '', 3),
(11, 'currency', 'Australian Dollars', 'AUD', 1),
(12, 'currency', 'Swiss Francs', 'CHF', 2),
(13, 'currency', 'Euro', 'EUR', 3),
(14, 'currency', 'Pounds', 'GBP', 4),
(15, 'currency', 'US Dollars', 'USD', 5),
(16, 'unit', 'pcs', '', 0),
(17, 'unit', 'each', '', 0),
(18, 'unit', 'set', '', 0),
(19, 'status', 'OK', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `erp_product`
--

DROP TABLE IF EXISTS `erp_product`;
CREATE TABLE `erp_product` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `type` enum('Component','Board') NOT NULL,
  `code` varchar(255) NOT NULL,
  `Internal_PN` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `manufacture` varchar(255) NOT NULL,
  `MPN` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL default '',
  `category_id` smallint(5) unsigned NOT NULL,
  `unit_id` smallint(5) unsigned NOT NULL,
  `Rohs` tinyint(1) NOT NULL,
  `LT_days` smallint(5) unsigned NOT NULL,
  `MOQ` varchar(255) NOT NULL,
  `SPQ` varchar(255) NOT NULL,
  `MSL` varchar(255) NOT NULL,
  `project` int(10) unsigned NOT NULL,
  `inventory_limit` int(10) unsigned NOT NULL,
  `currency_id` smallint(5) unsigned NOT NULL,
  `price` float NOT NULL,
  `quantity` int(10) unsigned NOT NULL default '0',
  `accessories` varchar(255) NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `remark` tinytext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `erp_product`
--

INSERT INTO `erp_product` (`id`, `type`, `code`, `Internal_PN`, `description`, `manufacture`, `MPN`, `value`, `category_id`, `unit_id`, `Rohs`, `LT_days`, `MOQ`, `SPQ`, `MSL`, `project`, `inventory_limit`, `currency_id`, `price`, `quantity`, `accessories`, `attachment`, `remark`) VALUES
(1, 'Component', 'C000000001', 'PN001', 'ProductDesc', 'ProductManu', 'MPN001', '100', 1, 16, 99, 30, '12', '60', '1', 12, 12, 12, 9.99, 0, 'no', '', 'PN001'),
(2, 'Component', 'C000000002', 'PN002', 'product2', 'M2', 'MPN2', '100', 2, 18, 0, 0, '', '', '', 0, 0, 15, 1, 30, '', '', ''),
(3, 'Component', 'C000000003', 'c123001', 'debugger', '', '', '0', 4, 17, 0, 0, '', '', '', 0, 0, 0, 0, 0, '', '', ''),
(4, 'Component', 'C000000004', 'PI2PCIE241', '2:1 Mux/DeMux Switch', 'Pericom', 'PI2PCIE2412ZHE', '0', 6, 16, 0, 0, '', '', '', 0, 0, 0, 0, 10000, '', '', ''),
(5, 'Component', 'C000000005', 'AT91SAM9R6', 'MCU ARM9 64K SRAM 144-LFBGA', 'Atmel', 'AT91SAM9R64-CU', '0', 6, 16, 0, 0, '', '', '', 0, 0, 0, 0, 0, '', '', ''),
(6, 'Component', 'C000000006', 'EP3SL50F48', 'IC STRATIX III L 50K 484-FBGA', 'ALTERA', 'EP3SL50F48', '0', 6, 16, 0, 0, '', '', '', 0, 0, 0, 0, 0, '', '', ''),
(7, 'Component', 'C000000007', 'TAJD337K00', 'CAP TANT 330UF 6.3V 10% SMD', 'AVX', 'TAJD337K00', '330', 2, 16, 0, 0, '', '', '', 0, 0, 0, 0, 0, '', '', ''),
(8, 'Component', 'C000000008', 'AGIGA-IT-0', 'SoundStation IP4000', 'Polycom', '0004F2E0F5F7', '0', 10, 16, 0, 0, '', '', '', 0, 0, 0, 0, 0, '', '', ''),
(9, 'Component', 'C000000009', 'AGIGA-SW-1', 'Windows XP (EN) Professional', '', 'VYMPW-FBFJ4-RF3C4-DB', '0', 10, 16, 0, 0, '', '', '', 0, 0, 0, 0, 0, '', '', ''),
(10, 'Component', 'C000000010', 'pn11', '', '', '', '', 0, 16, 0, 0, '', '', '', 0, 0, 0, 0, 0, '', '', ''),
(11, 'Component', 'C000000011', 'AGIGA-ACCESSORY-0036', 'Multi Serial Controller Card', '', '090717GS2010933', '', 10, 16, 0, 0, '', '', '', 0, 0, 0, 0, 0, '', '', ''),
(12, 'Component', 'C000000012', 'AGIGA-IT-00027', 'Air Conditioner CF405RI', 'Ameite ', '02738908051053F15', '', 10, 18, 0, 0, '', '', '', 0, 0, 0, 0, 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `erp_product_flow`
--

DROP TABLE IF EXISTS `erp_product_flow`;
CREATE TABLE `erp_product_flow` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `code` varchar(255) NOT NULL,
  `product_id` smallint(5) unsigned NOT NULL,
  `source` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `supplier_id` smallint(5) unsigned NOT NULL,
  `staff_id` smallint(5) unsigned NOT NULL,
  `project` int(10) unsigned NOT NULL default '0',
  `currency_id` smallint(5) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL default '0',
  `price` float(10,4) NOT NULL default '0.0000',
  `Lot` varchar(255) NOT NULL,
  `accessories` varchar(255) NOT NULL default '',
  `remark` tinytext NOT NULL,
  `create_time` datetime NOT NULL,
  `confirm_time` datetime NOT NULL,
  `confirmed_staff_id` smallint(5) unsigned NOT NULL,
  `confirmed_quantity` int(10) unsigned NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `erp_product_flow`
--

INSERT INTO `erp_product_flow` (`id`, `code`, `product_id`, `source`, `destination`, `supplier_id`, `staff_id`, `project`, `currency_id`, `quantity`, `price`, `Lot`, `accessories`, `remark`, `create_time`, `confirm_time`, `confirmed_staff_id`, `confirmed_quantity`, `status`) VALUES
(1, 'A000000001', 1, 'Supplier', 'Storage', 1, 1, 0, 13, 100, 1.2000, '', '', 'hehe\r\ndd', '2009-09-27 23:24:07', '2009-11-25 15:32:32', 1, 0, 1),
(2, 'A000000002', 1, 'Supplier', 'Storage', 2, 1, 33, 14, 50, 2.9000, '', '', 'fafa', '2009-10-15 11:05:41', '2009-10-19 20:27:48', 1, 0, 1),
(4, 'B000000001', 1, 'Storage', 'Supplier', 1, 1, 0, 13, 12, 1.2000, '', '', 'hehe\r\ndd', '2009-10-15 14:49:33', '2009-11-25 15:33:54', 1, 0, 1),
(5, 'Out000000005', 1, 'Storage', 'Staff', 0, 1, 0, 0, 10, 0.0000, '', '', '', '2009-10-19 21:19:48', '2009-11-25 15:38:47', 1, 0, 1),
(6, 'Out000000006', 1, 'Storage', 'Staff', 0, 1, 0, 0, 20, 0.0000, '', '', '', '2009-10-19 21:20:27', '2009-11-25 15:49:21', 1, 0, 1),
(7, 'T000000006', 1, 'Staff', 'Staff', 0, 1, 0, 0, 20, 0.0000, '', '', '', '2009-10-19 21:47:21', '2009-11-26 13:29:25', 1, 0, 1),
(8, 'T000000006', 1, 'Staff', 'Staff', 0, 1, 0, 0, 12, 0.0000, '', '', '', '2009-10-19 21:48:12', '0000-00-00 00:00:00', 0, 0, 0),
(9, 'A000000009', 2, 'Supplier', 'Storage', 2, 1, 0, 15, 100, 1.2000, '', '', '', '2009-10-19 23:16:32', '2009-10-19 23:32:09', 1, 0, 1),
(10, 'Out000000010', 2, 'Storage', 'Manufactory', 0, 1, 0, 0, 80, 0.0000, '', '', '', '2009-10-19 23:32:59', '2009-10-19 23:48:51', 1, 0, 1),
(11, 'Out000000011', 2, 'Storage', 'Customer', 0, 1, 0, 0, 8, 0.0000, '', '', '', '2009-10-19 23:49:42', '2009-10-19 23:49:51', 1, 0, 1),
(12, 'Out000000012', 2, 'Storage', 'Scrap', 0, 1, 0, 0, 2, 0.0000, '', '', '', '2009-10-19 23:50:12', '2009-10-19 23:50:20', 1, 0, 1),
(13, 'R000000010', 2, 'Manufactory', 'Storage', 0, 1, 0, 0, 30, 0.0000, '', '', '', '2009-10-19 23:55:08', '2009-11-25 15:43:00', 1, 0, 1),
(14, 'T000000005', 1, 'Staff', 'Staff', 0, 1, 0, 0, 10, 0.0000, '', '', '', '2009-11-23 19:59:07', '0000-00-00 00:00:00', 0, 0, 0),
(15, 'A000000015', 1, 'Supplier', 'Storage', 0, 1, 0, 0, 0, 0.0000, '', '', '', '2009-11-25 14:41:19', '2009-11-29 22:34:00', 1, 0, 1),
(16, 'B000000015', 1, 'Storage', 'Supplier', 0, 1, 0, 15, 0, 12.0000, '', '', '', '2009-11-25 14:42:44', '2009-11-25 15:33:33', 1, 0, 1),
(17, 'T000000006', 1, 'Staff', 'Staff', 0, 1, 0, 0, 20, 0.0000, '', '', '', '2009-11-25 14:44:30', '0000-00-00 00:00:00', 0, 0, 0),
(18, 'B000000001', 1, 'Storage', 'Supplier', 1, 1, 0, 13, 90, 1.2000, '', '', 'hehe\r\ndd', '2009-11-25 15:33:15', '2009-11-25 15:33:33', 1, 0, 1),
(19, 'T000000005', 1, 'Staff', 'Staff', 0, 1, 0, 0, 10, 0.0000, '', '', '', '2009-11-25 15:35:19', '0000-00-00 00:00:00', 0, 0, 0),
(20, 'T000000006', 1, 'Staff', 'Staff', 0, 1, 0, 0, 20, 0.0000, '', '', '', '2009-11-25 15:49:28', '0000-00-00 00:00:00', 0, 0, 0),
(21, 'A000000021', 4, 'Supplier', 'Storage', 1, 1, 0, 0, 10000, 111.0000, '', '', '', '2009-11-26 15:18:19', '2009-11-29 22:34:00', 1, 0, 1),
(22, 'T000000006', 1, 'Staff', 'Staff', 0, 1, 0, 0, 20, 0.0000, '', '', '', '2009-11-26 16:27:03', '0000-00-00 00:00:00', 0, 0, 0),
(23, 'Out000000023', 2, 'Storage', 'Staff', 0, 1, 0, 0, 1, 0.0000, '', '', '', '2009-11-26 16:29:19', '0000-00-00 00:00:00', 0, 0, 0),
(24, 'B000000009', 2, 'Storage', 'Supplier', 2, 1, 0, 15, 10, 1.2000, '', '', '', '2009-11-30 15:09:46', '2009-11-30 15:10:16', 1, 0, 1),
(25, 'A000000025', 5, 'Supplier', 'Storage', 1, 1, 0, 0, 100, 0.0000, '', '', '', '2009-12-01 16:26:03', '0000-00-00 00:00:00', 0, 0, 0),
(26, 'A000000026', 5, 'Supplier', 'Storage', 3, 1, 0, 0, 25, 0.0000, '', '', '', '2009-12-01 16:51:56', '0000-00-00 00:00:00', 0, 0, 0),
(27, 'A000000027', 11, 'Supplier', 'Storage', 0, 1, 0, 0, 1, 0.0000, '', '', '', '2009-12-02 14:07:55', '0000-00-00 00:00:00', 0, 0, 0),
(28, 'A000000028', 12, 'Supplier', 'Storage', 0, 1, 0, 0, 1, 0.0000, '', '', '', '2009-12-02 14:40:44', '0000-00-00 00:00:00', 0, 0, 0),
(29, 'Out000000029', 2, 'Storage', 'Staff', 0, 1, 0, 0, 2, 0.0000, '', '', '', '2009-12-03 11:08:24', '0000-00-00 00:00:00', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `erp_role`
--

DROP TABLE IF EXISTS `erp_role`;
CREATE TABLE `erp_role` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  `descr` varchar(255) default NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `erp_role`
--

INSERT INTO `erp_role` (`id`, `name`, `descr`, `status`) VALUES
(3, 'System Admin', 'System Admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `erp_role_node`
--

DROP TABLE IF EXISTS `erp_role_node`;
CREATE TABLE `erp_role_node` (
  `role_id` smallint(5) unsigned NOT NULL,
  `node_id` smallint(5) unsigned NOT NULL,
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_role_node`
--

INSERT INTO `erp_role_node` (`role_id`, `node_id`) VALUES
(3, 41),
(3, 40),
(3, 39),
(3, 38),
(3, 37),
(3, 36),
(3, 35),
(3, 34),
(3, 33),
(3, 32),
(3, 31),
(3, 30),
(3, 29),
(3, 28),
(3, 27),
(3, 26),
(3, 25),
(3, 24),
(3, 23),
(3, 22),
(3, 21),
(3, 20),
(3, 19),
(3, 18),
(3, 17),
(3, 16),
(3, 15),
(3, 14),
(3, 13),
(3, 12),
(3, 11),
(3, 10),
(3, 9),
(3, 8),
(3, 7),
(3, 6),
(3, 5),
(3, 4),
(3, 3),
(3, 2),
(3, 1),
(3, 42),
(3, 43);

-- --------------------------------------------------------

--
-- Table structure for table `erp_staff`
--

DROP TABLE IF EXISTS `erp_staff`;
CREATE TABLE `erp_staff` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `dept_id` smallint(5) unsigned NOT NULL,
  `leader_id` smallint(5) unsigned NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `realname` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `create_time` datetime NOT NULL,
  `login_time` datetime NOT NULL,
  `is_leader` tinyint(1) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `erp_staff`
--

INSERT INTO `erp_staff` (`id`, `dept_id`, `leader_id`, `code`, `name`, `realname`, `password`, `email`, `create_time`, `login_time`, `is_leader`, `status`) VALUES
(1, 7, 0, 'E0001', 'administrator', 'Administrator', '8891815eda4c6e329348d3a11611a7ba', 'zerofault@gmail.com', '0000-00-00 00:00:00', '2009-12-06 23:59:59', 0, 1),
(2, 5, 6, 'E0002', 'Robin Luo', 'Luo Kai', 'd41d8cd98f00b204e9800998ecf8427e', 'kail@agigatech.com', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 1),
(3, 2, 1, 'E0003', 'test2', 'test2', 'e10adc3949ba59abbe56e057f20f883e', 'test2@example.com', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(4, 5, 1, 'E0004', 'Tracy', 'Tracy', '', 'JALI@cypress.com', '2009-11-23 18:26:25', '0000-00-00 00:00:00', 0, 1),
(5, 6, 6, 'E0005', 'Matty.Fan', 'fanjunxia', '', '', '2009-11-25 15:01:09', '0000-00-00 00:00:00', 1, 1),
(6, 7, 0, 'E0006', 'Bin Li', 'Bin Li', '', 'Bin.li@agigatech.com', '2009-11-26 14:06:37', '0000-00-00 00:00:00', 1, 1),
(7, 7, 0, 'E0007', 'admin', 'ERP Admin', '21232f297a57a5a743894a0e4a801fc3', '', '2009-12-06 23:59:01', '2009-12-07 00:01:46', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `erp_staff_role`
--

DROP TABLE IF EXISTS `erp_staff_role`;
CREATE TABLE `erp_staff_role` (
  `staff_id` smallint(5) unsigned NOT NULL,
  `role_id` smallint(5) unsigned NOT NULL,
  KEY `userId` (`staff_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_staff_role`
--

INSERT INTO `erp_staff_role` (`staff_id`, `role_id`) VALUES
(2, 2),
(3, 1),
(3, 2),
(7, 3),
(2, 1),
(5, 2),
(5, 1),
(6, 2),
(6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `erp_supplier`
--

DROP TABLE IF EXISTS `erp_supplier`;
CREATE TABLE `erp_supplier` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `character_id` smallint(5) unsigned NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `postcode` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `cellphone` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `bank` varchar(255) NOT NULL,
  `account` varchar(255) NOT NULL,
  `payment_terms_id` smallint(5) unsigned NOT NULL,
  `tax_id` smallint(5) unsigned NOT NULL,
  `currency_id` smallint(5) unsigned NOT NULL,
  `website` varchar(255) NOT NULL,
  `remark` tinytext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `erp_supplier`
--

INSERT INTO `erp_supplier` (`id`, `code`, `name`, `character_id`, `address`, `contact`, `postcode`, `telephone`, `cellphone`, `fax`, `email`, `bank`, `account`, `payment_terms_id`, `tax_id`, `currency_id`, `website`, `remark`) VALUES
(1, 'S00001', 'YIRAN Electronic', 1, 'Chengdu JinNiu district', 'Fan Jian Wei', '', '', '13032812977', '', '', '', '', 5, 8, 0, '', 'Components supplier'),
(2, 'S00002', 'Agiga SAN Office', 3, 'SAN Office', '', '', '', '', '', '', '', '', 0, 0, 0, '', 'Agiga Tech Headquarter'),
(3, 'S00003', 'Cadence', 1, 'Chao Yang District , Hong Dong Ave, Beijing , China Mainland', 'Fudan Jun ', '456546546', '13213232', '13301219875', '2343434234', 'Fudan@xinglang.com', '56456456456456', '564564564564564564545645645645645645', 4, 8, 15, '', ''),
(4, 'S00004', 'Krision', 3, 'Software', 'Xiaodong gao', '', '', '', '', '', '', '', 0, 8, 15, '', '');
