# MySQL-Front Dump 2.5
#
# Host: localhost   Database: test
# --------------------------------------------------------
# Server version 5.0.22-community-nt


#
# Table structure for table 'bus_hz_line'
#

DROP TABLE IF EXISTS `bus_hz_line`;
CREATE TABLE IF NOT EXISTS `bus_hz_line` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(32) NOT NULL DEFAULT '' ,
  `number` smallint(5) unsigned NOT NULL DEFAULT '0' ,
  `term1` int(10) unsigned NOT NULL DEFAULT '0' ,
  `term2` int(10) unsigned NOT NULL DEFAULT '0' ,
  `start_time1` varchar(64) NOT NULL DEFAULT '' ,
  `start_time2` varchar(64) NOT NULL DEFAULT '' ,
  `end_time1` varchar(32) NOT NULL DEFAULT '' ,
  `end_time2` varchar(32) NOT NULL DEFAULT '' ,
  `fare_norm` varchar(255) NOT NULL DEFAULT '' ,
  `fare_cond` varchar(255) NOT NULL DEFAULT '' ,
  `ic_card` varchar(32) NOT NULL DEFAULT '' ,
  `service_hour` varchar(16) NOT NULL DEFAULT '' ,
  PRIMARY KEY (`id`)
);



#
# Table structure for table 'bus_hz_route'
#

DROP TABLE IF EXISTS `bus_hz_route`;
CREATE TABLE IF NOT EXISTS `bus_hz_route` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `lid` smallint(5) unsigned NOT NULL DEFAULT '0' ,
  `sid` int(10) unsigned NOT NULL DEFAULT '0' ,
  `i` smallint(5) unsigned NOT NULL DEFAULT '0' ,
  `direction` tinyint(1) NOT NULL DEFAULT '0' ,
  PRIMARY KEY (`id`),
   KEY lid (`lid`),
   KEY i (`i`)
);



#
# Table structure for table 'bus_hz_site'
#

DROP TABLE IF EXISTS `bus_hz_site`;
CREATE TABLE IF NOT EXISTS `bus_hz_site` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL DEFAULT '' ,
  `subname` varchar(255) NOT NULL DEFAULT '' ,
  `around` varchar(255) NOT NULL DEFAULT '' ,
  PRIMARY KEY (`id`)
);



#
# Table structure for table 'test'
#

DROP TABLE IF EXISTS `test`;
CREATE TABLE IF NOT EXISTS `test` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `FieldName` int(10) unsigned ,
  PRIMARY KEY (`id`)
);

