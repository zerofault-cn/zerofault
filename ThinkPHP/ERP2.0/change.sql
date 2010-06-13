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


ALTER TABLE erp_staff ADD onboard DATE NOT NULL AFTER email;
CREATE TABLE IF NOT EXISTS `erp_leave` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort` tinyint(3) unsigned NOT NULL default '0',
  `status` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `erp_leave` (`id`, `name`, `description`, `sort`, `status`) VALUES
(1, 'Annual Leave（年假）', '﻿年假：员工依据累计工作年资享有年假。\r\n---\r\n年假以天为单位计。员工年假期间发给全薪。\r\n申请年假，需提前一星期提出申请，并由主管签核。\r\n必须先休年假，年假休完的情况下，才能申请公司特休假。\r\n公司特休假作为对年假的补充，不能与年假重复享有，叠加计算。\r\n如因公司工作需要未能当年度休假，可申请将年假延长至次年3月31日。\r\n员工有下列情形之一的，不享受当年的年休假：\r\n1）累计工作满1年不满10年的员工，请病假累计2个月以上的（含双休日、法定节假日）；\r\n2）累计工作满10年不满20年的员工，请病假累计3个月以上的（含双休日、法定节假日）；\r\n3）累计工作满20年以上的员工，请病假累计4个月以上的（含双休日、法定节假日）。', 1, 1),
(2, 'Time off with pay（补休）', '﻿补休假：员工可以依据核定过的加班时间进行补休。\r\n---\r\n1.需事先申请并由权责主管核准。人力资源部审核员工加班记录及已休假记录后，员工开始休假。\r\n2.补休假期间工资照发。\r\n3.补休需在次年的3月31日之前休完。2008年12月31日之前未休之补休有效期限延长至2009年12月31日。\r\n4.未休之补休不折现金，如员工未按规定申请补休，过期后则视为自动放弃休假', 2, 1);

