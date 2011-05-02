SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `erp_absence` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL DEFAULT '',
  `staff_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `creator_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `time_from` datetime NOT NULL,
  `time_to` datetime NOT NULL,
  `hours` decimal(5,1) NOT NULL DEFAULT '0.0',
  `hours_remain` decimal(5,2) NOT NULL DEFAULT '0.00',
  `deputy_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `notification` varchar(255) NOT NULL DEFAULT '',
  `attachment` varchar(255) NOT NULL DEFAULT '',
  `note` tinytext NOT NULL,
  `create_time` datetime NOT NULL,
  `approver_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `comment` tinytext NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `mail_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_attachment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(255) NOT NULL DEFAULT '',
  `size` int(10) unsigned NOT NULL DEFAULT '0',
  `path` varchar(255) NOT NULL DEFAULT '',
  `model_name` varchar(255) NOT NULL DEFAULT '',
  `model_id` int(10) unsigned NOT NULL DEFAULT '0',
  `staff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `upload_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_category` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL DEFAULT '',
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `model_name` varchar(255) NOT NULL DEFAULT '',
  `model_id` int(10) unsigned NOT NULL DEFAULT '0',
  `staff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_department` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `function` varchar(255) NOT NULL,
  `leader_id` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_location` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `descr` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_location_manager` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `fixed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `staff_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_location_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('location','staff') NOT NULL,
  `location_id` smallint(5) unsigned NOT NULL,
  `product_id` smallint(5) unsigned NOT NULL,
  `ori_quantity` int(11) NOT NULL DEFAULT '0',
  `chg_quantity` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `pid` smallint(6) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `descr` tinytext,
  `level` tinyint(1) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_options` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `descr` text NOT NULL,
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_product` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('Component','Board') NOT NULL,
  `fixed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `code` varchar(255) NOT NULL,
  `Internal_PN` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `manufacture` varchar(255) NOT NULL,
  `MPN` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL DEFAULT '',
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
  `quantity` int(10) unsigned NOT NULL DEFAULT '0',
  `accessories` varchar(255) NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `remark` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_product_flow` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `action` enum('enter','return','apply','transfer','release','scrap','back') NOT NULL,
  `fixed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `product_id` smallint(5) unsigned NOT NULL,
  `from_type` enum('location','staff') NOT NULL,
  `from_id` smallint(5) unsigned NOT NULL,
  `to_type` enum('location','staff') NOT NULL,
  `to_id` smallint(5) unsigned NOT NULL,
  `supplier_id` smallint(5) unsigned NOT NULL,
  `staff_id` smallint(5) unsigned NOT NULL,
  `currency_id` smallint(5) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL DEFAULT '0',
  `price` float(10,4) NOT NULL DEFAULT '0.0000',
  `Lot` varchar(255) NOT NULL,
  `accessories` varchar(255) NOT NULL DEFAULT '',
  `remark` tinytext NOT NULL,
  `create_time` datetime NOT NULL,
  `confirm_time` datetime NOT NULL,
  `confirmed_staff_id` smallint(5) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_remark2` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `flow_id` int(10) unsigned NOT NULL DEFAULT '0',
  `product_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `staff_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `remark` text NOT NULL,
  `create_time` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `descr` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_role_node` (
  `role_id` smallint(5) unsigned NOT NULL,
  `node_id` smallint(5) unsigned NOT NULL,
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_staff` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `dept_id` smallint(5) unsigned NOT NULL,
  `leader_id` smallint(5) unsigned NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `realname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `onboard` date NOT NULL,
  `balance` decimal(3,1) unsigned NOT NULL DEFAULT '0.0',
  `create_time` datetime NOT NULL,
  `login_time` datetime NOT NULL,
  `is_leader` tinyint(1) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_staff_role` (
  `staff_id` smallint(5) unsigned NOT NULL,
  `role_id` smallint(5) unsigned NOT NULL,
  KEY `userId` (`staff_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_supplier` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_task` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `project` varchar(255) NOT NULL DEFAULT '',
  `descr` text NOT NULL,
  `category_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `creator_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `due_date` date NOT NULL DEFAULT '0000-00-00',
  `press_interval` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `notification` char(4) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_task_owner` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(10) unsigned NOT NULL DEFAULT '0',
  `staff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `action_time` datetime NOT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '0',
  `mail_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_task_participant` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(10) unsigned NOT NULL DEFAULT '0',
  `staff_id` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_template` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `action` varchar(255) NOT NULL DEFAULT '',
  `do` varchar(255) NOT NULL DEFAULT '',
  `subject` varchar(255) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_test` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `staff_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `project` varchar(255) NOT NULL DEFAULT '',
  `version` varchar(255) NOT NULL DEFAULT '',
  `comment` text NOT NULL,
  `create_time` datetime NOT NULL,
  `edit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `result` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erp_test_entry` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `test_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `x` varchar(255) NOT NULL DEFAULT '',
  `y` varchar(255) NOT NULL DEFAULT '',
  `string` varchar(255) NOT NULL DEFAULT '',
  `edit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
