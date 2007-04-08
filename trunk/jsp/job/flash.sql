# MySQL-Front Dump 2.5
#
# Host: localhost   Database: job
# --------------------------------------------------------
# Server version 5.0.22-community-nt

USE job;


#
# Table structure for table 'flash'
#

CREATE TABLE IF NOT EXISTS `flash` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `title` varchar(255) ,
  `path` varchar(255) ,
  `count` tinyint(3) unsigned DEFAULT '0' ,
  `user` varchar(255) ,
  `uptime` datetime ,
  `descr` tinytext ,
  PRIMARY KEY (`id`),
   KEY id (`id`)
);

