CREATE TABLE erp_location (id SMALLINT (3) UNSIGNED AUTO_INCREMENT, name VARCHAR (255) NOT NULL, descr VARCHAR(255)  NOT NULL, PRIMARY KEY(id)) ;

CREATE TABLE erp_location_product (id INT UNSIGNED AUTO_INCREMENT, location_id SMALLINT UNSIGNED NOT NULL, product_id SMALLINT UNSIGNED NOT NULL, ori_quantity INT DEFAULT '0' NOT NULL, chg_quantity INT DEFAULT '0' NOT NULL, PRIMARY KEY(id)) ;

ALTER TABLE erp_location_product ADD type ENUM('location','staff')  NOT NULL AFTER id;

ALTER TABLE erp_product_flow CHANGE source target_type ENUM('location','staff')  NOT NULL;
ALTER TABLE erp_product_flow CHANGE destination target_id SMALLINT UNSIGNED NOT NULL;
ALTER TABLE erp_product_flow ADD action ENUM('enter','return','apply','transfer','release','scrap','back')  NOT NULL after code;

ALTER TABLE erp_product_flow CHANGE target_type from_type ENUM('location','staff')  NOT NULL;
ALTER TABLE erp_product_flow CHANGE target_id from_id SMALLINT  UNSIGNED NOT NULL;

ALTER TABLE erp_product_flow ADD to_type ENUM('location','staff')  NOT NULL AFTER from_id;
ALTER TABLE erp_product_flow ADD to_id SMALLINT UNSIGNED NOT NULL AFTER to_type;

ALTER TABLE erp_product_flow DROP confirmed_quantity;
ALTER TABLE erp_product_flow CHANGE project project VARCHAR(255)  NOT NULL;

ALTER TABLE erp_product DROP project;


ALTER TABLE erp_product ADD project VARCHAR(255)  NOT NULL AFTER MSL;

ALTER TABLE erp_product_flow DROP project;


ALTER TABLE erp_product ADD fixed TINYINT(1)  UNSIGNED DEFAULT "0" NOT NULL AFTER `type`;
ALTER TABLE erp_product_flow ADD fixed TINYINT(1)  UNSIGNED DEFAULT "0" NOT NULL AFTER `action`;

DROP TABLE IF EXISTS `erp_remark2`;
CREATE TABLE IF NOT EXISTS `erp_remark2` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `flow_id` int(10) unsigned NOT NULL DEFAULT '0' ,
  `product_id` smallint(5) unsigned NOT NULL DEFAULT '0' ,
  `staff_id` smallint(5) unsigned NOT NULL DEFAULT '0' ,
  `remark` text NOT NULL DEFAULT '' ,
  `create_time` datetime NOT NULL ,
  `status` tinyint(1) NOT NULL DEFAULT '0' ,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE erp_location_manager (id SMALLINT UNSIGNED AUTO_INCREMENT, location_id SMALLINT UNSIGNED DEFAULT '0' NOT NULL, fixed TINYINT (1) UNSIGNED DEFAULT '0' NOT NULL, staff_id SMALLINT UNSIGNED DEFAULT '0' NOT NULL, PRIMARY KEY(id)) ENGINE=MyISAM DEFAULT CHARSET=utf8;


#For absence
ALTER TABLE erp_staff ADD onboard DATE NOT NULL AFTER email;
ALTER TABLE erp_staff ADD balance_2009 decimal(5,1) unsigned  NOT NULL default 0 AFTER onboard;
CREATE TABLE IF NOT EXISTS erp_absence (
  id int(10) unsigned NOT NULL auto_increment,
  type varchar(255) NOT NULL DEFAULT '' ,
  staff_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  creator_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  time_from datetime NOT NULL ,
  time_to datetime NOT NULL  ,
  hours decimal(5,1) NOT NULL DEFAULT 0 ,
  deputy_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  notification varchar(255) NOT NULL DEFAULT '' ,
  attachment varchar(255) NOT NULL DEFAULT '' ,
  note tinytext NOT NULL DEFAULT '' ,
  create_time datetime NOT NULL  ,
  approver_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  comment tinytext NOT NULL DEFAULT '' ,
  status tinyint(1) NOT NULL DEFAULT '0' ,
  mail_status tinyint(1) unsigned NOT NULL DEFAULT '0' ,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE erp_options ADD descr TEXT NOT NULL AFTER code;


2010-09-03 For Test Log
CREATE TABLE erp_test (
id SMALLINT UNSIGNED AUTO_INCREMENT,
 name VARCHAR (255) NOT NULL,
 staff_id SMALLINT UNSIGNED DEFAULT '0' NOT NULL,
 project varchar (255) DEFAULT '' NOT NULL,
 version varchar(255) default '' not null,
 comment text not null default '',
 create_time DATETIME NOT NULL,
 edit_time timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
 result tinyint(1) not null default 0,
 status TINYINT (1) DEFAULT '0' NOT NULL,
 PRIMARY KEY(id)
 ) 
 ENGINE=MyISAM DEFAULT CHARSET=utf8 ;
CREATE TABLE IF NOT EXISTS `erp_test_entry` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `test_id` smallint(5) unsigned NOT NULL default '0',
  `x` varchar(255) NOT NULL default '',
  `y` varchar(255) NOT NULL default '',
  `string` varchar(255) NOT NULL default '',
  edit_time timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

2011/1/10 For Task
CREATE TABLE `erp_attachment` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `type` varchar(255) NOT NULL default '',
  `size` int(10) unsigned NOT NULL default '0',
  `path` varchar(255) NOT NULL default '',
  `model_name` varchar(255) NOT NULL default '',
  `model_id` int(10) unsigned NOT NULL default '0',
  `staff_id` int(10) unsigned NOT NULL default '0',
  `upload_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `erp_comment` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `content` TEXT NOT NULL default '',
  `model_name` varchar(255) NOT NULL default '',
  `model_id` int(10) unsigned NOT NULL default '0',
  `staff_id` int(10) unsigned NOT NULL default '0',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `erp_task` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `project` varchar(255) NOT NULL default '',
  `descr` text NOT NULL,
  `category_id` smallint(5) unsigned NOT NULL default '0',
  `creator_id` SMALLINT UNSIGNED DEFAULT "0" NOT NULL,
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `due_date` date NOT NULL default '0000-00-00',
  `press_interval` int(10) unsigned NOT NULL default '0',
  `done_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `notification` char(2) NOT NULL DEFAULT '';
  `status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `erp_task_owner` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `task_id` int(10) unsigned NOT NULL default '0',
  `staff_id` int(10) unsigned NOT NULL default '0',
  `action_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;