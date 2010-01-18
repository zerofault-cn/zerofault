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