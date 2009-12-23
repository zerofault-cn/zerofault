SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


CREATE TABLE IF NOT EXISTS `erp_category` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `type` enum('Component','Board') NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_department` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `function` varchar(255) NOT NULL,
  `leader_id` smallint(5) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_location` (
  `id` smallint(3) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `descr` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `erp_location` (`id`, `name`, `descr`) VALUES (1, 'Local', 'Default Storage');

CREATE TABLE IF NOT EXISTS `erp_location_product` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `type` enum('location','staff') NOT NULL,
  `location_id` smallint(5) unsigned NOT NULL,
  `product_id` smallint(5) unsigned NOT NULL,
  `ori_quantity` int(11) NOT NULL default '0',
  `chg_quantity` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_node` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `pid` smallint(6) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `descr` tinytext,
  `level` tinyint(1) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_options` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `sort` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


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
(16, 'currency', 'China Yuan', 'CNY', 6),
(17, 'unit', 'pcs', '', 1),
(18, 'unit', 'each', '', 2),
(19, 'unit', 'set', '', 3),
(20, 'status', 'OK', '', 1),
(21, 'status', 'Bad', '', 2),
(22, 'status', 'Need to Repair', '', 3);



CREATE TABLE IF NOT EXISTS `erp_product` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `type` enum('Component','Board') NOT NULL,
  `fixed` tinyint(1) unsigned NOT NULL default '0',
  `code` varchar(255) NOT NULL,
  `Internal_PN` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `manufacture` varchar(255) NOT NULL,
  `MPN` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL default '',
  `category_id` smallint(5) unsigned NOT NULL,
  `status_id` smallint(5) unsigned NOT NULL,
  `unit_id` smallint(5) unsigned NOT NULL,
  `Rohs` tinyint(1) NOT NULL,
  `LT_days` smallint(5) unsigned NOT NULL,
  `MOQ` varchar(255) NOT NULL,
  `SPQ` varchar(255) NOT NULL,
  `MSL` varchar(255) NOT NULL,
  `project` varchar(255) NOT NULL,
  `inventory_limit` int(10) unsigned NOT NULL,
  `currency_id` smallint(5) unsigned NOT NULL,
  `price` float NOT NULL,
  `quantity` int(10) unsigned NOT NULL default '0',
  `accessories` varchar(255) NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `remark` tinytext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_product_flow` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `code` varchar(255) NOT NULL,
  `action` enum('enter','return','apply','transfer','release','scrap','back') NOT NULL,
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

CREATE TABLE IF NOT EXISTS `erp_role` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  `descr` varchar(255) default NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_role_node` (
  `role_id` smallint(5) unsigned NOT NULL,
  `node_id` smallint(5) unsigned NOT NULL,
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_staff` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `erp_staff` (`id`, `dept_id`, `leader_id`, `code`, `name`, `realname`, `password`, `email`, `create_time`, `login_time`, `is_leader`, `status`) VALUES
(1, 0, 0, 'E0001', '~admin_name~', 'Super Admin', '~admin_pass~', '', '0000-00-00 00:00:00', now(), 0, 1);

CREATE TABLE IF NOT EXISTS `erp_staff_role` (
  `staff_id` smallint(5) unsigned NOT NULL,
  `role_id` smallint(5) unsigned NOT NULL,
  KEY `userId` (`staff_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_supplier` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

