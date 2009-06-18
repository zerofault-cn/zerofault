# MySQL-Front Dump 2.5
#
# Host: localhost   Database: 5dnote
# --------------------------------------------------------
# Server version 5.0.22-community-nt-log


#
# Table structure for table 'entries'
#

DROP TABLE IF EXISTS `entries`;
CREATE TABLE IF NOT EXISTS `entries` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL ,
  `url` varchar(255) ,
  `content` text ,
  `image` mediumblob ,
  `addtime` datetime NOT NULL ,
  `private` tinyint(1) unsigned NOT NULL DEFAULT '0' ,
  `type` enum('link','note','pic') NOT NULL  ,
  PRIMARY KEY (`id`)
);



#
# Table structure for table 'entry_tags'
#

DROP TABLE IF EXISTS `entry_tags`;
CREATE TABLE IF NOT EXISTS `entry_tags` (
  `id` int(3) unsigned NOT NULL auto_increment,
  `entry_id` int(3) unsigned NOT NULL ,
  `tag_id` smallint(3) unsigned NOT NULL ,
  PRIMARY KEY (`id`),
   KEY entry_id (`entry_id`)
);



#
# Table structure for table 'tags'
#

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(64) NOT NULL ,
  `count_link` smallint(3) unsigned NOT NULL DEFAULT '0' ,
  `count_note` smallint(3) unsigned NOT NULL DEFAULT '0' ,
  `count_pic` smallint(3) unsigned NOT NULL DEFAULT '0' ,
  `usetime` datetime NOT NULL ,
  PRIMARY KEY (`id`)
);

