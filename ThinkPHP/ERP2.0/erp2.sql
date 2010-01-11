-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost
-- 生成日期: 2010 年 01 月 11 日 11:15
-- 服务器版本: 5.0.22
-- PHP 版本: 5.2.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 数据库: `ERP2`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `erp_node`
-- 

DROP TABLE IF EXISTS `erp_node`;
CREATE TABLE `erp_node` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `pid` smallint(6) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- 导出表中的数据 `erp_node`
-- 

INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES 
(1, 0, 'Board', 'Board Basic Data', 0),
(2, 0, 'Category', 'Category Management', 0),
(3, 0, 'Dept', 'Department Management', 0),
(4, 0, 'Location', 'Location Setting', 0),
(5, 0, 'Product', 'Component Basic Data', 0),
(6, 0, 'ProductIn', 'Inventory Input Management', 0),
(7, 0, 'ProductOut', 'Inventory output Management', 0),
(8, 0, 'Setting', 'Options Setting', 0),
(9, 0, 'Staff', 'Staff Management', 0),
(10, 0, 'Supplier', 'Supplier Management', 0),
(11, 1, 'index', 'List', 0),
(12, 1, 'form', 'Form', 0),
(13, 1, 'submit', 'Submit', 0),
(14, 1, 'delete', 'Delete', 0),
(15, 2, 'index', 'List', 0),
(16, 2, 'submit', 'Submit', 0),
(17, 2, 'delete', 'Delete', 0),
(18, 3, 'index', 'List', 0),
(19, 3, 'submit', 'Submit', 0),
(20, 3, 'delete', 'Delete', 0),
(21, 4, 'index', 'List', 0),
(22, 4, 'submit', 'Submit', 0),
(23, 4, 'delete', 'Delete', 0),
(24, 5, 'index', 'List', 0),
(25, 5, 'form', 'Form', 0),
(26, 5, 'submit', 'Submit', 0),
(27, 5, 'delete', 'Delete', 0),
(28, 6, 'fixed', 'Fixed-Assets Entering', 0),
(29, 6, 'floating', 'Floating-Assets Entering', 0),
(30, 6, 'reject', 'Product Reject', 0),
(31, 6, 'form', 'Form', 0),
(32, 6, 'submit', 'Submit', 0),
(33, 6, 'confirm', 'Confirm', 0),
(34, 6, 'select', 'Select Basic Data', 0),
(35, 6, 'delete', 'Delete', 0),
(36, 7, 'applyFixed', 'Fixed-Assets Apply Management', 0),
(37, 7, 'applyFloating', 'Floating-Assets Apply Management', 0),
(38, 7, 'transfer', 'Transfer Management', 0),
(39, 7, 'release', 'Release Management', 0),
(40, 7, 'scrap', 'Scrap Management', 0),
(41, 7, 'returns', 'Return management', 0),
(42, 7, 'form', 'Form', 0),
(43, 7, 'submit', 'Submit', 0),
(44, 7, 'confirm', 'Confirm', 0),
(45, 7, 'select', 'Select Basic Data', 0),
(46, 7, 'delete', 'Delete', 0),
(47, 8, 'index', 'List', 0),
(48, 8, 'submit', 'Submit', 0),
(49, 8, 'delete', 'Delete', 0),
(50, 9, 'index', 'List', 0),
(51, 9, 'form', 'Form', 0),
(52, 9, 'submit', 'Submit', 0),
(53, 9, 'update', 'Update', 0),
(54, 9, 'delete', 'Delete', 0),
(55, 10, 'index', 'List', 0),
(56, 10, 'form', 'Form', 0),
(57, 10, 'submit', 'Submit', 0),
(58, 10, 'delete', 'Delete', 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `erp_product_flow`
-- 

DROP TABLE IF EXISTS `erp_product_flow`;
CREATE TABLE `erp_product_flow` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `code` varchar(255) NOT NULL,
  `action` enum('enter','reject','apply','transfer','release','scrap','return') NOT NULL,
  `fixed` tinyint(1) unsigned NOT NULL default '0',
  `product_id` smallint(5) unsigned NOT NULL,
  `from_type` enum('location','staff') NOT NULL,
  `from_id` smallint(5) unsigned NOT NULL,
  `to_type` enum('location','staff') NOT NULL,
  `to_id` smallint(5) unsigned NOT NULL,
  `supplier_id` smallint(5) unsigned NOT NULL,
  `staff_id` smallint(5) unsigned NOT NULL,
  `currency_id` smallint(5) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL default '0',
  `price` float(10,4) NOT NULL default '0.0000',
  `Lot` varchar(255) NOT NULL,
  `accessories` varchar(255) NOT NULL default '',
  `remark` tinytext NOT NULL,
  `create_time` datetime NOT NULL,
  `confirm_time` datetime NOT NULL,
  `confirmed_staff_id` smallint(5) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- 导出表中的数据 `erp_product_flow`
-- 



-- 
-- 表的结构 `erp_remark2`
-- 

DROP TABLE IF EXISTS `erp_remark2`;
CREATE TABLE `erp_remark2` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `flow_id` int(10) unsigned NOT NULL default '0',
  `staff_id` smallint(5) unsigned NOT NULL default '0',
  `remark` tinytext NOT NULL,
  `create_time` datetime NOT NULL,
  `status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- 导出表中的数据 `erp_remark2`
-- 

