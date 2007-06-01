# MySQL-Front Dump 2.5
#
# Host: localhost   Database: xprn_news
# --------------------------------------------------------
# Server version 4.1.20-community-nt


#
# Table structure for table 'article'
#

DROP TABLE IF EXISTS article;
CREATE TABLE article (
  id int(10) unsigned NOT NULL auto_increment,
  itemId varchar(32) NOT NULL default '',
  datetime datetime NOT NULL default '0000-00-00 00:00:00',
  title varchar(255) NOT NULL default '',
  industryName varchar(255) NOT NULL default '',
  content text NOT NULL,
  PRIMARY KEY  (id)
);

