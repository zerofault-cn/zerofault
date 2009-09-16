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
  `id` int(10) unsigned NOT NULL auto_increment,
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
  `id` int(10) unsigned NOT NULL auto_increment,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `function` varchar(255) NOT NULL,
  `leader_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_department`
--


/*!40000 ALTER TABLE `erp_department` DISABLE KEYS */;
LOCK TABLES `erp_department` WRITE;
INSERT INTO `erp_department` VALUES (1,'C001','HW','Hardware',1),(2,'C002','SW','Software design',2),(3,'C003','FPGA','IC design',1),(4,'C004','Test','Test',2);
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
INSERT INTO `erp_node` VALUES (1,0,'Index','首页','',2,0),(4,3,'delete','删除','',3,0),(3,0,'User','用户管理','',2,0),(5,3,'edit','编辑','',3,0),(6,0,'Role','角色管理','',2,0),(8,6,'index','列表','',3,0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `erp_node` ENABLE KEYS */;

--
-- Table structure for table `erp_options`
--

DROP TABLE IF EXISTS `erp_options`;
CREATE TABLE `erp_options` (
  `id` int(10) unsigned NOT NULL auto_increment,
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
INSERT INTO `erp_options` VALUES (1,'character','Agent','',1),(2,'character','Manufacture','',2),(3,'character','Other','',9),(4,'payment_terms','Due 20th Of the Following Month','',1),(5,'payment_terms','Due By End Of The Following Month','',2),(6,'payment_terms','Payment due within 7 days','',3),(7,'payment_terms','Cash Only','',4),(8,'tax','Default tax group','',1),(9,'tax','Ontario','',2),(10,'tax','UK Inland Revenue','',3),(11,'currency','Australian Dollars','AUD',1),(12,'currency','Swiss Francs','CHF',2),(13,'currency','Euro','EUR',3),(14,'currency','Pounds','GBP',4),(15,'currency','US Dollars','USD',5);
UNLOCK TABLES;
/*!40000 ALTER TABLE `erp_options` ENABLE KEYS */;

--
-- Table structure for table `erp_product`
--

DROP TABLE IF EXISTS `erp_product`;
CREATE TABLE `erp_product` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `Internal_PN` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `manufacture` varchar(255) NOT NULL,
  `MPN` varchar(255) NOT NULL,
  `supplier_id` int(10) unsigned NOT NULL,
  `value` int(10) unsigned NOT NULL,
  `commodity_id` int(10) unsigned NOT NULL,
  `unit` varchar(255) NOT NULL,
  `Rohs` tinyint(1) NOT NULL,
  `LT_days` int(10) unsigned NOT NULL,
  `MOQ` varchar(255) NOT NULL,
  `SPQ` varchar(255) NOT NULL,
  `MSL` varchar(255) NOT NULL,
  `project` int(10) unsigned NOT NULL,
  `bottom_limit` int(10) unsigned NOT NULL,
  `currency_id` int(10) unsigned NOT NULL,
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
UNLOCK TABLES;
/*!40000 ALTER TABLE `erp_product` ENABLE KEYS */;

--
-- Table structure for table `erp_role`
--

DROP TABLE IF EXISTS `erp_role`;
CREATE TABLE `erp_role` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `descr` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_role`
--


/*!40000 ALTER TABLE `erp_role` DISABLE KEYS */;
LOCK TABLES `erp_role` WRITE;
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
UNLOCK TABLES;
/*!40000 ALTER TABLE `erp_role_node` ENABLE KEYS */;

--
-- Table structure for table `erp_staff`
--

DROP TABLE IF EXISTS `erp_staff`;
CREATE TABLE `erp_staff` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `dept_id` int(10) unsigned NOT NULL,
  `leader_id` int(10) unsigned NOT NULL,
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
  `staff_id` mediumint(9) unsigned NOT NULL,
  `role_id` mediumint(9) unsigned NOT NULL,
  KEY `userId` (`staff_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_staff_role`
--


/*!40000 ALTER TABLE `erp_staff_role` DISABLE KEYS */;
LOCK TABLES `erp_staff_role` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `erp_staff_role` ENABLE KEYS */;

--
-- Table structure for table `erp_supplier`
--

DROP TABLE IF EXISTS `erp_supplier`;
CREATE TABLE `erp_supplier` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `character_id` int(10) unsigned NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `postcode` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `cellphone` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `bank` varchar(255) NOT NULL,
  `account` varchar(255) NOT NULL,
  `payment_terms_id` int(10) unsigned NOT NULL,
  `tax_id` int(10) unsigned NOT NULL,
  `currency_id` int(10) unsigned NOT NULL,
  `website` varchar(255) NOT NULL,
  `remark` tinytext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_supplier`
--


/*!40000 ALTER TABLE `erp_supplier` DISABLE KEYS */;
LOCK TABLES `erp_supplier` WRITE;
INSERT INTO `erp_supplier` VALUES (1,'S00001','ss1',2,'USA','','','0123456','','','','','',4,8,13,'','good\r\nok'),(2,'S00002','ss2',3,'Franch','','','','','','','','',7,10,11,'','');
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

