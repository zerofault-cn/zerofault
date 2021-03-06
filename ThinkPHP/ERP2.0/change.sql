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
  `update_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `due_date` date NOT NULL default '0000-00-00',
  `press_interval` int(10) unsigned NOT NULL default '0',
  `notification` char(2) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `erp_task_owner` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `task_id` int(10) unsigned NOT NULL default '0',
  `staff_id` int(10) unsigned NOT NULL default '0',
  `action_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(3) NOT NULL default '0',
  `mail_time` int(10) unsigned not null default 0,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `erp_task_participant` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `task_id` int(10) unsigned NOT NULL default '0',
  `staff_id` int(10) unsigned NOT NULL default '0',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE erp_task CHANGE notification notification CHAR(4)  NOT NULL default '';

ALTER TABLE erp_absence ADD hours_remain DECIMAL(5,2)  DEFAULT "0" NOT NULL AFTER hours;
update erp_absence set hours_remain=hours;


DROP TABLE IF EXISTS `erp_share`;
CREATE TABLE `erp_share` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `staff_id` smallint(5) unsigned NOT NULL default '0',
  `dept_id` smallint(5) unsigned NOT NULL default '0',
  `category_id` smallint(5) unsigned NOT NULL default '0',
  `project_id` smallint(5) unsigned NOT NULL default '0',
  `notification` char(4) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `keywords` varchar(255) NOT NULL default '',
  `content` text not null default '',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `modify_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `hit` smallint(5) unsigned NOT NULL default '0',
  `status` tinyint(1) unsigned NOT NULL default '0',
  `mail_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


2012/1/6
DROP TABLE IF EXISTS `erp_status_board`;
CREATE TABLE `erp_status_board` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `flow_id` smallint(5) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `info` text NOT NULL,
  `remark` text NOT NULL,
  `owner_id` smallint(5) unsigned NOT NULL default '0',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `update_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `erp_status_flow`;
CREATE TABLE `erp_status_flow` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `item_ids` text NOT NULL,
  `owner_ids` text NOT NULL,
  `creator_id` smallint(5) unsigned NOT NULL default '0',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `update_time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `erp_status_item`;
CREATE TABLE `erp_status_item` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `owner_id` smallint(5) unsigned NOT NULL default '0',
  `type` varchar(255) NOT NULL default '',
  `sort` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `erp_status_item` VALUES (1,'Power voltage','test all voltage class',0,'radio',1);
INSERT INTO `erp_status_item` VALUES (2,'Power ripple','',0,'radio',2);
INSERT INTO `erp_status_item` VALUES (3,'Clock frequency','make sure 50Mhz crystal frequency are good',0,'radio',3);
INSERT INTO `erp_status_item` VALUES (4,'reset timing','check reset waveform of reset input',0,'radio',4);
INSERT INTO `erp_status_item` VALUES (5,'FPGA JTAG port test','Set up communication with FPGA through JTAG',0,'radio',5);
INSERT INTO `erp_status_item` VALUES (6,'Download image to SPI Flash','Test the connection between FPGA and SPI flash.',0,'radio',6);
INSERT INTO `erp_status_item` VALUES (7,'CPLD program','',0,'radio',7);
INSERT INTO `erp_status_item` VALUES (8,'Data read and write validation','Test whether host read and write to DDR3 Memory are OK?',0,'radio',8);
INSERT INTO `erp_status_item` VALUES (9,'Run on Intel Server Board S5520HC(DDR3-1333)','',0,'radio',9);
INSERT INTO `erp_status_item` VALUES (10,'Run on Intel Oak Creek Canyan Platform(DDR3-1333)','',0,'radio',10);
INSERT INTO `erp_status_item` VALUES (11,'Run on SuperMicro Server Board H8SGL(DDR3-1333)','',0,'radio',11);

DROP TABLE IF EXISTS `erp_status_status`;
CREATE TABLE `erp_status_status` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `flow_id` smallint(5) unsigned NOT NULL default '0',
  `board_id` smallint(5) unsigned NOT NULL default '0',
  `item_id` smallint(5) unsigned NOT NULL default '0',
  `owner_id` smallint(5) unsigned NOT NULL default '0',
  `substitute_id` smallint(5) unsigned NOT NULL default '0',
  `sort` tinyint(3) unsigned NOT NULL default '0',
  `update_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(3) NOT NULL default '-1',
  `mail_status` tinyint(3) NOT NULL default '-1',
  `comment` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `erp_status_template`;
CREATE TABLE `erp_status_template` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `item_ids` text NOT NULL,
  `owner_ids` text NOT NULL,
  `creator_id` smallint(5) unsigned NOT NULL default '0',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `update_time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `erp_status_revision` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `board_id` smallint(5) unsigned NOT NULL default '0',
  `status_id` smallint(5) unsigned NOT NULL default '0',
  `field` varchar(255) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  `sort` tinyint(3) unsigned NOT NULL default '0',
  `staff_id` smallint(5) unsigned NOT NULL default '0',
  `update_time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `erp_status_board` ADD COLUMN `remark` text NOT NULL AFTER `info`;

CREATE TABLE `erp_status_log` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `type` varchar(255) NOT NULL default '',
  `action_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `staff_id` smallint(5) unsigned NOT NULL default '0',
  `content` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

2012/2/14
ALTER TABLE `erp_status_status` CHANGE `mail_status` `mail_time` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0';

CREATE TABLE `erp_status_remind` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `flow_id` smallint(5) unsigned NOT NULL default '0',
  `item_id` smallint(5) unsigned NOT NULL default '0',
  `costTime` int(10) unsigned NOT NULL default '0',
  `remindInterval` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `flow_id` (`flow_id`,`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


2012/2/23
ALTER TABLE `erp_status_board` CHANGE COLUMN `owner_id` `owner_id` smallint(5) NOT NULL DEFAULT 0;