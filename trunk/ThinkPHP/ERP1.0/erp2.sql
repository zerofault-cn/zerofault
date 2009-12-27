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
-- Table structure for table `erp_product_flow`
--

DROP TABLE IF EXISTS `erp_product_flow`;
CREATE TABLE `erp_product_flow` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `code` varchar(255) NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `source` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `supplier_id` int(10) unsigned NOT NULL default '0',
  `staff_id` int(10) unsigned NOT NULL,
  `project` int(10) unsigned NOT NULL default '0',
  `currency_id` int(10) unsigned NOT NULL default '0',
  `unit_id` mediumint(8) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `price` float(10,4) NOT NULL default '0.0000',
  `Lot` varchar(255) NOT NULL,
  `accessories` varchar(255) NOT NULL default '',
  `remark` tinytext NOT NULL,
  `create_time` datetime NOT NULL,
  `confirm_time` datetime NOT NULL,
  `confirm_staff_id` int(10) unsigned NOT NULL,
  `moved_quantity` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `erp_product_flow`
--


/*!40000 ALTER TABLE `erp_product_flow` DISABLE KEYS */;
LOCK TABLES `erp_product_flow` WRITE;
INSERT INTO `erp_product_flow` VALUES (1,'A000000001',1,'','',1,1,0,13,18,100,1.2000,'','','hehe','2009-09-27 23:24:07','0000-00-00 00:00:00',0,0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `erp_product_flow` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

