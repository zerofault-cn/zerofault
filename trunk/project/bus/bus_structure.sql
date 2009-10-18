-- MySQL dump 10.10
--
-- Host: localhost    Database: bus
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
-- Table structure for table `bus_hz_line`
--

DROP TABLE IF EXISTS `bus_hz_line`;
CREATE TABLE `bus_hz_line` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(32) NOT NULL default '',
  `number` smallint(5) unsigned NOT NULL default '0',
  `start_sid` int(10) unsigned NOT NULL default '0',
  `start_first` varchar(64) NOT NULL default '',
  `start_last` varchar(64) NOT NULL default '',
  `end_sid` int(10) unsigned NOT NULL default '0',
  `end_first` varchar(64) NOT NULL default '',
  `end_last` varchar(64) NOT NULL default '',
  `fare_norm` varchar(240) NOT NULL default '',
  `fare_cond` varchar(240) NOT NULL default '',
  `ic_card` varchar(32) NOT NULL default '',
  `service_day` varchar(16) NOT NULL,
  `update_time` datetime default '0000-00-00 00:00:00',
  `status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `bus_hz_route`
--

DROP TABLE IF EXISTS `bus_hz_route`;
CREATE TABLE `bus_hz_route` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `lid` smallint(5) unsigned NOT NULL default '0',
  `sid` int(10) unsigned NOT NULL default '0',
  `sort` smallint(5) unsigned NOT NULL default '0',
  `dir` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `lid` (`lid`),
  KEY `i` (`sort`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `bus_hz_site`
--

DROP TABLE IF EXISTS `bus_hz_site`;
CREATE TABLE `bus_hz_site` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `around` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `bus_hz_trans`
--

DROP TABLE IF EXISTS `bus_hz_trans`;
CREATE TABLE `bus_hz_trans` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `from_sid` int(10) unsigned NOT NULL default '0',
  `from_lid` smallint(5) unsigned NOT NULL default '0',
  `from_dir` tinyint(1) NOT NULL default '0',
  `from_sort1` smallint(5) unsigned NOT NULL default '0',
  `from_sort2` smallint(5) unsigned NOT NULL default '0',
  `trans_sid` int(10) unsigned NOT NULL default '0',
  `to_lid` smallint(5) unsigned NOT NULL default '0',
  `to_dir` tinyint(1) NOT NULL default '0',
  `to_sid` int(10) unsigned NOT NULL default '0',
  `to_sort1` smallint(5) unsigned NOT NULL default '0',
  `to_sort2` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

