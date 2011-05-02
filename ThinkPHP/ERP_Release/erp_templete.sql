# MySQL-Front Dump 2.5
#
# Host: localhost   Database: ERP2
# --------------------------------------------------------
# Server version 5.0.22-community-nt-log


#
# Table structure for table 'erp_template'
#

DROP TABLE IF EXISTS `erp_template`;
CREATE TABLE IF NOT EXISTS `erp_template` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `action` varchar(255) NOT NULL DEFAULT '' ,
  `do` varchar(255) NOT NULL DEFAULT '' ,
  `subject` varchar(255) NOT NULL DEFAULT '' ,
  `body` text NOT NULL DEFAULT '' ,
  PRIMARY KEY (`id`)
);



#
# Dumping data for table 'erp_template'
#

INSERT INTO `erp_template` (`id`, `action`, `do`, `subject`, `body`) VALUES("1", "apply", "new", "[staff] apply Product Requisition [code] for approval", "Hi [leader],\r\n  [staff] need to apply [product] [quantity] [unit], please login into the ERP System and approve the ER in the system. Thanks.\r\n  Direct access link as below:\r\n[url]");
INSERT INTO `erp_template` (`id`, `action`, `do`, `subject`, `body`) VALUES("2", "apply", "approve", "ER was approved, please release the product [product]", "Hi [manager],\\n\\n  [staff] need to apply [product] [quantity] [unit], it\'s approved, please release the product to him and confirm the ER in the System. Thanks.\\n  Direct access link as below:\\n\\t[url]");
INSERT INTO `erp_template` (`id`, `action`, `do`, `subject`, `body`) VALUES("3", "apply", "reject", "Apply Product Requisition [code] for [staff] was rejected", "Hi [staff],\\n\\n[leader] rejected your application [product] [quantity] [unit], please noted. Thanks.\\n  Direct access link as below:\\n\\t[url]");
INSERT INTO `erp_template` (`id`, `action`, `do`, `subject`, `body`) VALUES("4", "apply", "confirm", "confirm", "confirm");
INSERT INTO `erp_template` (`id`, `action`, `do`, `subject`, `body`) VALUES("5", "apply", "edit", "edit", "edit");
INSERT INTO `erp_template` (`id`, `action`, `do`, `subject`, `body`) VALUES("6", "apply", "delete", "delete", "delete");
INSERT INTO `erp_template` (`id`, `action`, `do`, `subject`, `body`) VALUES("7", "transfer", "new", "new", "new");
INSERT INTO `erp_template` (`id`, `action`, `do`, `subject`, `body`) VALUES("8", "transfer", "reject", "reject", "reject");
INSERT INTO `erp_template` (`id`, `action`, `do`, `subject`, `body`) VALUES("9", "transfer", "confirm", "confirm", "confirm body");
INSERT INTO `erp_template` (`id`, `action`, `do`, `subject`, `body`) VALUES("10", "transfer", "edit", "edit title", "edit body");
INSERT INTO `erp_template` (`id`, `action`, `do`, `subject`, `body`) VALUES("11", "transfer", "delete", "delete title", "delete body");
