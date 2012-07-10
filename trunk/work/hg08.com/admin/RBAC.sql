DROP TABLE IF EXISTS `ruit_admin`;
CREATE TABLE `ruit_admin` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(255) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `realname` varchar(255) NOT NULL default '',
  `role` varchar(255) NOT NULL default '',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `login_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='后台管理员';

INSERT INTO `ruit_admin` VALUES (1,'admin','32bb79e5a88829bfd6b94085067ace49','超级管理员','','0000-00-00 00:00:00','0000-00-00 00:00:00',1);

DROP TABLE IF EXISTS `ruit_admin_role`;
CREATE TABLE `ruit_admin_role` (
  `admin_id` mediumint(9) unsigned NOT NULL,
  `role_id` mediumint(9) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ruit_node`;
CREATE TABLE `ruit_node` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `pid` smallint(6) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `descr` tinytext,
  `level` tinyint(1) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `ruit_node` VALUES (1,0,'admin','后台管理','后台管理根节点',1,0);


DROP TABLE IF EXISTS `ruit_role`;
CREATE TABLE `ruit_role` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `descr` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `ruit_role` VALUES (1,'后台管理根角色',1,'所有管理员都必须先赋予此角色');


DROP TABLE IF EXISTS `ruit_role_node`;
CREATE TABLE `ruit_role_node` (
  `role_id` smallint(5) unsigned NOT NULL,
  `node_id` smallint(5) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `ruit_role_node` VALUES (1,1);
