-- MySQL dump 10.10
--
-- Host: localhost    Database: ERP
-- ------------------------------------------------------
-- Server version	5.0.22-community-nt-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `erp_commodity`
--

DROP TABLE IF EXISTS `erp_commodity`;
CREATE TABLE `erp_commodity` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_commodity`
--


/*!40000 ALTER TABLE `erp_commodity` DISABLE KEYS */;
LOCK TABLES `erp_commodity` WRITE;
INSERT INTO `erp_commodity` VALUES (1,'P001','Resistor'),(2,'P002','Capacitor');
UNLOCK TABLES;
/*!40000 ALTER TABLE `erp_commodity` ENABLE KEYS */;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_department`
--


/*!40000 ALTER TABLE `erp_department` DISABLE KEYS */;
LOCK TABLES `erp_department` WRITE;
INSERT INTO `erp_department` VALUES (1,'C001','HW','Hardware',1),(2,'C002','SW','Software design',1),(3,'C003','FPGA','IC design',1),(4,'C004','Test','Test',2);
UNLOCK TABLES;
/*!40000 ALTER TABLE `erp_department` ENABLE KEYS */;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_node`
--


/*!40000 ALTER TABLE `erp_node` DISABLE KEYS */;
LOCK TABLES `erp_node` WRITE;
INSERT INTO `erp_node` VALUES (1,0,'Index','Index','',2,0),(4,3,'delete','Delete','',3,0),(3,0,'User','User','',2,0),(5,3,'edit','Edit','',3,0),(6,0,'Role','Role','',2,0),(8,6,'index','List','',3,0),(9,0,'Staff','Staff',NULL,0,0),(10,0,'Supplier','Supplier',NULL,0,0),(11,0,'Node','Node',NULL,0,0),(12,0,'Goods','Goods',NULL,0,0),(13,0,'Dept','Dept',NULL,0,0),(14,0,'Commodity','Commodity',NULL,0,0),(15,14,'index','List',NULL,0,0),(16,14,'form','Add & Edit Form',NULL,0,0),(17,14,'submit','Submit',NULL,0,0),(18,13,'index','List',NULL,0,0),(19,13,'form','Add & Edit Form',NULL,0,0),(20,13,'submit','Submit',NULL,0,0),(21,12,'index','List',NULL,0,0),(22,1,'index','Index',NULL,0,0),(23,11,'index','List',NULL,0,0),(24,11,'update','Update',NULL,0,0),(25,10,'index','List',NULL,0,0),(26,10,'form','Add & Edit Form',NULL,0,0),(27,10,'submit','Submit',NULL,0,0),(28,0,'Product','Product',NULL,0,0),(29,28,'index','List',NULL,0,0),(30,28,'form','Add & Edit Form',NULL,0,0),(31,28,'submit','Submit',NULL,0,0),(32,6,'add','Add',NULL,0,0),(33,6,'edit','Edit',NULL,0,0),(34,6,'update','Update',NULL,0,0),(35,6,'delete','Delete',NULL,0,0),(36,9,'index','List',NULL,0,0),(37,9,'form','Add & Edit Form',NULL,0,0),(38,9,'submit','Submit',NULL,0,0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `erp_node` ENABLE KEYS */;

--
-- Table structure for table `erp_options`
--

DROP TABLE IF EXISTS `erp_options`;
CREATE TABLE `erp_options` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `sort` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_options`
--


/*!40000 ALTER TABLE `erp_options` DISABLE KEYS */;
LOCK TABLES `erp_options` WRITE;
INSERT INTO `erp_options` VALUES (1,'character','Agent','',1),(2,'character','Manufacture','',2),(3,'character','Other','',9),(4,'payment_terms','Due 20th Of the Following Month','',1),(5,'payment_terms','Due By End Of The Following Month','',2),(6,'payment_terms','Payment due within 7 days','',3),(7,'payment_terms','Cash Only','',4),(8,'tax','Default tax group','',1),(9,'tax','Ontario','',2),(10,'tax','UK Inland Revenue','',3),(11,'currency','Australian Dollars','AUD',1),(12,'currency','Swiss Francs','CHF',2),(13,'currency','Euro','EUR',3),(14,'currency','Pounds','GBP',4),(15,'currency','US Dollars','USD',5),(16,'unit','pcs','',0),(17,'unit','each','',0),(18,'unit','set','',0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `erp_options` ENABLE KEYS */;

--
-- Table structure for table `erp_product`
--

DROP TABLE IF EXISTS `erp_product`;
CREATE TABLE `erp_product` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `Internal_PN` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `manufacture` varchar(255) NOT NULL,
  `MPN` varchar(255) NOT NULL,
  `value` int(10) unsigned NOT NULL,
  `commodity_id` smallint(5) unsigned NOT NULL,
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
  `accessories` varchar(255) NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `remark` tinytext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_product`
--


/*!40000 ALTER TABLE `erp_product` DISABLE KEYS */;
LOCK TABLES `erp_product` WRITE;
INSERT INTO `erp_product` VALUES (1,'PN001','ProductDesc','ProductManu','MPN001',0,1,16,99,30,'12','60','1',12,12,12,9.99,'no','','PN001');
UNLOCK TABLES;
/*!40000 ALTER TABLE `erp_product` ENABLE KEYS */;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_product_flow`
--


/*!40000 ALTER TABLE `erp_product_flow` DISABLE KEYS */;
LOCK TABLES `erp_product_flow` WRITE;
INSERT INTO `erp_product_flow` VALUES (1,'A000000001',1,'Supplier','Storage',1,1,0,13,100,1.2000,'','','hehe\r\ndd','2009-09-27 23:24:07','2009-10-15 11:08:18',1,0,0),(2,'A000000002',1,'Supplier','Storage',0,1,33,0,0,0.0000,'','','fafa','2009-10-15 11:05:41','2009-10-15 11:08:18',1,0,0),(4,'B000000001',1,'Storage','Supplier',1,1,0,13,12,1.2000,'','','hehe\r\ndd','2009-10-15 14:49:33','0000-00-00 00:00:00',0,0,0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `erp_product_flow` ENABLE KEYS */;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_role`
--


/*!40000 ALTER TABLE `erp_role` DISABLE KEYS */;
LOCK TABLES `erp_role` WRITE;
INSERT INTO `erp_role` VALUES (1,'admin','admin',1),(2,'leader','leader',1);
UNLOCK TABLES;
/*!40000 ALTER TABLE `erp_role` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `erp_role_node` DISABLE KEYS */;
LOCK TABLES `erp_role_node` WRITE;
INSERT INTO `erp_role_node` VALUES (1,1),(1,3),(1,4),(1,5),(1,6),(1,8),(1,22),(2,1),(2,3),(2,4),(2,5),(2,6),(2,8),(2,22);
UNLOCK TABLES;
/*!40000 ALTER TABLE `erp_role_node` ENABLE KEYS */;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_staff`
--


/*!40000 ALTER TABLE `erp_staff` DISABLE KEYS */;
LOCK TABLES `erp_staff` WRITE;
INSERT INTO `erp_staff` VALUES (1,1,0,'E0001','admin','Administrator','21232f297a57a5a743894a0e4a801fc3','zerofault@gmail.com','0000-00-00 00:00:00','2009-09-13 11:32:43',1,1),(2,4,1,'E0002','staff1','Staff1','d41d8cd98f00b204e9800998ecf8427e','staff1@local','0000-00-00 00:00:00','0000-00-00 00:00:00',1,1),(3,2,1,'E0003','test2','test2','e10adc3949ba59abbe56e057f20f883e','test2@example.com','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `erp_staff` ENABLE KEYS */;

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


/*!40000 ALTER TABLE `erp_staff_role` DISABLE KEYS */;
LOCK TABLES `erp_staff_role` WRITE;
INSERT INTO `erp_staff_role` VALUES (2,1),(3,1),(3,2),(1,1),(2,2);
UNLOCK TABLES;
/*!40000 ALTER TABLE `erp_staff_role` ENABLE KEYS */;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_supplier`
--


/*!40000 ALTER TABLE `erp_supplier` DISABLE KEYS */;
LOCK TABLES `erp_supplier` WRITE;
INSERT INTO `erp_supplier` VALUES (1,'S00001','ss1',2,'USA','','','0123456','33','','','','',4,8,12,'','good\r\nok'),(2,'S00002','ss2',3,'Franch','','','','','','','','',7,10,11,'','');
UNLOCK TABLES;
/*!40000 ALTER TABLE `erp_supplier` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

