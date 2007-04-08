# MySQL-Front Dump 2.5
#
# Host: 211.152.20.32   Database: mm2007
# --------------------------------------------------------
# Server version 4.1.14-log


#
# Table structure for table 'mm_comment'
#

CREATE TABLE `mm_comment` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(50) NOT NULL default '',
  `content` text NOT NULL,
  `addtime` int(11) NOT NULL default '0',
  `mark` tinyint(1) unsigned NOT NULL default '0',
  `mm_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `mm_id` (`mm_id`),
  KEY `mark` (`mark`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



#
# Table structure for table 'mm_info'
#

CREATE TABLE `mm_info` (
  `id` int(6) unsigned NOT NULL auto_increment,
  `blogname` varchar(255) NOT NULL default '',
  `blogurl` varchar(255) NOT NULL default '',
  `realname` varchar(255) NOT NULL default '',
  `age` tinyint(3) unsigned default '0',
  `height` smallint(4) unsigned default '0',
  `weight` smallint(4) unsigned default '0',
  `area` tinyint(1) unsigned NOT NULL default '0',
  `certitype` tinyint(1) unsigned default '0',
  `certinum` varchar(255) default NULL,
  `address` varchar(255) default NULL,
  `postcode` varchar(255) default NULL,
  `telenum` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `other` varchar(255) default NULL,
  `english` varchar(255) default NULL,
  `putonghua` varchar(255) default NULL,
  `intro` varchar(255) default NULL,
  `photo` varchar(255) default NULL,
  `addtime` int(10) unsigned NOT NULL default '0',
  `hbun_vote` int(10) unsigned NOT NULL default '0',
  `hbte_vote` int(10) unsigned NOT NULL default '0',
  `hbivr_vote` int(10) unsigned NOT NULL default '0',
  `netvote` int(10) unsigned NOT NULL default '0',
  `smsvote` int(10) unsigned NOT NULL default '0',
  `allvote` int(3) unsigned NOT NULL default '0',
  `pass` tinyint(1) unsigned NOT NULL default '0',
  `comm_count` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `area` (`area`),
  KEY `allvote` (`allvote`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



#
# Table structure for table 'poll_ip1'
#

CREATE TABLE `poll_ip1` (
  `id` int(3) unsigned NOT NULL auto_increment,
  `ip` char(15) NOT NULL default '',
  `mm_id` int(3) unsigned default '0',
  `polltime` int(11) unsigned default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



#
# Table structure for table 'poll_sms1'
#

CREATE TABLE `poll_sms1` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `phone` varchar(11) NOT NULL default '',
  `service_code` enum('9951','10665110') NOT NULL default '9951',
  `content` varchar(255) NOT NULL default '0',
  `connId` int(10) unsigned NOT NULL default '0',
  `linkId` varchar(64) NOT NULL default '0',
  `pgId` int(10) unsigned NOT NULL default '0',
  `feephone` varchar(11) NOT NULL default '0',
  `smsid` varchar(64) NOT NULL default '0',
  `polltime` int(10) unsigned NOT NULL default '0',
  `mm_id` int(10) unsigned NOT NULL default '0',
  `addvote` tinyint(1) unsigned NOT NULL default '0',
  `day_poll` tinyint(3) unsigned NOT NULL default '0',
  `month_poll` tinyint(3) unsigned NOT NULL default '0',
  `dealtime` int(10) unsigned NOT NULL default '0',
  `re_smsid` bigint(20) NOT NULL default '0',
  `status` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `polltime` (`polltime`),
  KEY `mm_id` (`mm_id`),
  KEY `status` (`status`)
) ;

