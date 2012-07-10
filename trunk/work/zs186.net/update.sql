
DROP TABLE IF EXISTS `zs_admin_role`;
CREATE TABLE `zs_admin_role` (
  `admin_id` mediumint(9) unsigned NOT NULL,
  `role_id` mediumint(9) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;


DROP TABLE IF EXISTS `zs_node`;
CREATE TABLE `zs_node` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `pid` smallint(6) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `descr` tinytext,
  `level` tinyint(1) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;


INSERT INTO `zs_node` VALUES (1,0,'admin','后台管理','后台管理的根节点',1,0);


DROP TABLE IF EXISTS `zs_role`;
CREATE TABLE `zs_role` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `descr` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `zs_role` VALUES (1,'后台管理根角色',1,'所有管理员都必须先赋予此角色');


DROP TABLE IF EXISTS `zs_role_node`;
CREATE TABLE `zs_role_node` (
  `role_id` smallint(5) unsigned NOT NULL,
  `node_id` smallint(5) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

INSERT INTO `zs_role_node` VALUES (1,1);


CREATE TABLE `zs_feedback` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `phone` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  `reply` text NOT NULL,
  `ip` varchar(255) NOT NULL default '',
  `referer` varchar(255) NOT NULL default '',
  `addtime` datetime NOT NULL default '0000-00-00 00:00:00',
  `replytime` datetime NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='留言咨询';

ALTER TABLE `zs_hotel` ADD COLUMN `password` varchar(32) NOT NULL DEFAULT '' AFTER `name`;
