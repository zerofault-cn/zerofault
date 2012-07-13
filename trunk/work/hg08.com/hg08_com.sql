# SQL-Front 5.1  (Build 4.16)

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;


# Host: localhost    Database: hg08_com
# ------------------------------------------------------
# Server version 5.0.22-community-nt-log

DROP DATABASE IF EXISTS `hg08_com`;
CREATE DATABASE `hg08_com` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `hg08_com`;

#
# Source for table hg_admin
#

DROP TABLE IF EXISTS `hg_admin`;
CREATE TABLE `hg_admin` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(255) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `realname` varchar(255) NOT NULL default '',
  `role` varchar(255) NOT NULL default '',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `login_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='后台管理员';

#
# Dumping data for table hg_admin
#

INSERT INTO `hg_admin` VALUES (1,'admin','32bb79e5a88829bfd6b94085067ace49','超级管理员','','0000-00-00 00:00:00','2012-07-10 14:09:21',1);
INSERT INTO `hg_admin` VALUES (2,'test','e10adc3949ba59abbe56e057f20f883e','TEST','','2012-07-06 10:36:35','2012-07-06 11:23:30',1);

#
# Source for table hg_admin_role
#

DROP TABLE IF EXISTS `hg_admin_role`;
CREATE TABLE `hg_admin_role` (
  `admin_id` mediumint(9) unsigned NOT NULL,
  `role_id` mediumint(9) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

#
# Dumping data for table hg_admin_role
#

INSERT INTO `hg_admin_role` VALUES (2,1);
INSERT INTO `hg_admin_role` VALUES (2,2);

#
# Source for table hg_album
#

DROP TABLE IF EXISTS `hg_album`;
CREATE TABLE `hg_album` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `category_id` smallint(5) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `sort` tinyint(3) unsigned NOT NULL default '0',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `modify_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `view` int(10) unsigned NOT NULL default '0',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Dumping data for table hg_album
#

INSERT INTO `hg_album` VALUES (1,5,'热门外景测试',2,'2012-07-10 15:30:45','2012-07-11 09:25:29',23,2);
INSERT INTO `hg_album` VALUES (2,5,'adfa',4,'2012-07-10 16:00:58','2012-07-11 10:25:42',5,1);
INSERT INTO `hg_album` VALUES (3,5,'测试测试测试测试测试',100,'2012-07-11 09:32:35','2012-07-11 09:32:35',0,1);
INSERT INTO `hg_album` VALUES (5,5,'shishang',100,'2012-07-11 09:38:27','2012-07-11 09:38:27',1,2);
INSERT INTO `hg_album` VALUES (6,5,'测试测试测试',100,'2012-07-11 09:39:33','2012-07-11 16:59:59',0,1);
INSERT INTO `hg_album` VALUES (7,4,'特照1',100,'2012-07-11 10:28:35','2012-07-11 10:28:35',0,1);

#
# Source for table hg_article
#

DROP TABLE IF EXISTS `hg_article`;
CREATE TABLE `hg_article` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `category_id` tinyint(3) NOT NULL default '0' COMMENT '类别',
  `title` varchar(255) NOT NULL default '' COMMENT '标题',
  `tags` varchar(255) NOT NULL default '' COMMENT '标签',
  `author` varchar(255) NOT NULL default '' COMMENT '作者',
  `summary` tinytext NOT NULL COMMENT '摘要',
  `content` text NOT NULL COMMENT '内容',
  `sort` smallint(5) NOT NULL default '0' COMMENT '显示排序',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '添加时间',
  `modify_time` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '修改时间',
  `view` int(11) unsigned NOT NULL default '0' COMMENT '查看次数',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章';

#
# Dumping data for table hg_article
#

INSERT INTO `hg_article` VALUES (1,1,'公司文化','','','公司文化摘要','公司文化正文',2,'2012-07-09 16:25:22','2012-07-12 11:42:36',46,1);
INSERT INTO `hg_article` VALUES (2,1,'公司全景','','','公司全景摘要','公司全景正文',4,'2012-07-09 16:25:41','2012-07-12 11:42:52',10,1);
INSERT INTO `hg_article` VALUES (3,1,'公司团队','','','','',6,'2012-07-09 16:26:02','2012-07-09 16:26:02',3,1);
INSERT INTO `hg_article` VALUES (4,2,'关于顾客预告片的发布说明！','','','关于顾客预告片的发布说明摘要1','关于顾客预告片的发布说明正文1',8,'2012-07-09 16:27:40','2012-07-12 14:57:17',12,2);
INSERT INTO `hg_article` VALUES (5,2,'关于顾客预告片的发布说明！2','','','关于顾客预告片的发布说明摘要2','关于顾客预告片的发布说明正文2',10,'2012-07-09 16:27:51','2012-07-12 14:57:30',2,-1);
INSERT INTO `hg_article` VALUES (6,2,'关于顾客预告片的发布说明！3','','','','',12,'2012-07-09 16:28:18','2012-07-09 16:28:18',3,2);
INSERT INTO `hg_article` VALUES (7,2,'关于顾客预告片的发布说明！4','','','','',100,'2012-07-10 17:23:37','2012-07-10 17:23:37',3,1);
INSERT INTO `hg_article` VALUES (8,2,'关于顾客预告片的发布说明！5','','','','',100,'2012-07-10 17:29:41','2012-07-10 17:29:41',0,1);
INSERT INTO `hg_article` VALUES (9,2,'关于顾客预告片的发布说明！6','','','','',100,'2012-07-10 17:31:06','2012-07-10 17:31:06',0,1);
INSERT INTO `hg_article` VALUES (10,2,'关于顾客预告片的发布说明！7','','','','',100,'2012-07-10 17:31:23','2012-07-10 17:31:23',2,1);
INSERT INTO `hg_article` VALUES (11,2,'关于顾客预告片的发布说明！8','','','','',100,'2012-07-10 17:31:41','2012-07-10 17:31:41',1,1);

#
# Source for table hg_category
#

DROP TABLE IF EXISTS `hg_category`;
CREATE TABLE `hg_category` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `pid` smallint(5) unsigned NOT NULL default '0',
  `type` varchar(255) NOT NULL default '' COMMENT '酒店或文章',
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL default '',
  `sort` smallint(5) unsigned NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='类别';

#
# Dumping data for table hg_category
#

INSERT INTO `hg_category` VALUES (1,0,'Article','关于皇宫','about',0,1);
INSERT INTO `hg_category` VALUES (2,0,'Article','最新活动','news',0,1);
INSERT INTO `hg_category` VALUES (3,0,'Photo','顾客特照','',0,1);
INSERT INTO `hg_category` VALUES (4,0,'Album','摄影作品','works',0,1);
INSERT INTO `hg_category` VALUES (5,4,'Album','时尚婚纱','',0,1);
INSERT INTO `hg_category` VALUES (6,4,'Album','个人写真','',0,1);
INSERT INTO `hg_category` VALUES (9,4,'Album','test','',0,1);

#
# Source for table hg_client
#

DROP TABLE IF EXISTS `hg_client`;
CREATE TABLE `hg_client` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `phone` varchar(255) NOT NULL default '',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Dumping data for table hg_client
#


#
# Source for table hg_feedback
#

DROP TABLE IF EXISTS `hg_feedback`;
CREATE TABLE `hg_feedback` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  `reply` text NOT NULL,
  `ip` varchar(255) NOT NULL default '',
  `addtime` datetime NOT NULL default '0000-00-00 00:00:00',
  `replytime` datetime NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='留言咨询';

#
# Dumping data for table hg_feedback
#

INSERT INTO `hg_feedback` VALUES (1,'test','奥德赛的方式','','','2012-07-13 17:07:57','0000-00-00 00:00:00',0);

#
# Source for table hg_node
#

DROP TABLE IF EXISTS `hg_node`;
CREATE TABLE `hg_node` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `pid` smallint(6) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `descr` tinytext,
  `level` tinyint(1) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Dumping data for table hg_node
#

INSERT INTO `hg_node` VALUES (1,0,'admin','后台管理','后台管理根节点',1,0);
INSERT INTO `hg_node` VALUES (6,1,'System','网站系统设置','',2,0);
INSERT INTO `hg_node` VALUES (7,6,'setting','网站参数设置','',3,0);
INSERT INTO `hg_node` VALUES (8,6,'flink','友情链接管理','',3,0);
INSERT INTO `hg_node` VALUES (9,1,'Index','默认首页','',2,0);
INSERT INTO `hg_node` VALUES (11,9,'index','默认首页','',3,0);
INSERT INTO `hg_node` VALUES (12,1,'Feedback','留言管理','',2,0);

#
# Source for table hg_photo
#

DROP TABLE IF EXISTS `hg_photo`;
CREATE TABLE `hg_photo` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `category_id` smallint(5) unsigned NOT NULL default '0',
  `album_id` smallint(5) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `sort` tinyint(3) unsigned NOT NULL default '0',
  `thumb` varchar(255) NOT NULL default '',
  `src` varchar(255) NOT NULL default '',
  `width` int(10) unsigned NOT NULL default '0',
  `height` int(10) unsigned NOT NULL default '0',
  `type` varchar(255) NOT NULL default '',
  `size` int(10) unsigned NOT NULL default '0',
  `addtime` datetime NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Dumping data for table hg_photo
#

INSERT INTO `hg_photo` VALUES (1,5,2,'1',3,'html/Attach/Photo_thumb/20120710164021.450039.jpg','html/Attach/Photo_src/20120710164021.450039.jpg',0,0,'',0,'0000-00-00 00:00:00',0);
INSERT INTO `hg_photo` VALUES (2,5,2,'2',2,'html/Attach/Photo_thumb/20120710164021.137115.jpg','html/Attach/Photo_src/20120710164021.137115.jpg',0,0,'',0,'0000-00-00 00:00:00',0);
INSERT INTO `hg_photo` VALUES (3,5,2,'3 2',1,'html/Attach/Photo_thumb/20120710164021.842546.jpg','html/Attach/Photo_src/20120710164021.842546.jpg',0,0,'',0,'0000-00-00 00:00:00',-1);
INSERT INTO `hg_photo` VALUES (4,5,1,'',1,'html/Attach/Photo_thumb/20120711092530.334108.gif','html/Attach/Photo_src/20120711092530.334108.gif',0,0,'',0,'0000-00-00 00:00:00',1);
INSERT INTO `hg_photo` VALUES (5,5,1,'',0,'html/Attach/Photo_thumb/20120711163843.329777.jpg','html/Attach/Photo_src/20120711163843.329777.jpg',600,300,'jpeg',41935,'0000-00-00 00:00:00',1);
INSERT INTO `hg_photo` VALUES (6,5,3,'',0,'html/Attach/Photo_thumb/20120711093235.629449.jpg','html/Attach/Photo_src/20120711093235.629449.jpg',0,0,'',0,'0000-00-00 00:00:00',0);
INSERT INTO `hg_photo` VALUES (7,5,4,'',0,'html/Attach/Photo_thumb/20120711093804.138544.gif','html/Attach/Photo_src/20120711093804.138544.gif',0,0,'',0,'0000-00-00 00:00:00',0);
INSERT INTO `hg_photo` VALUES (8,5,5,'',0,'html/Attach/Photo_thumb/20120711093827.527790.jpg','html/Attach/Photo_src/20120711093827.527790.jpg',0,0,'',0,'0000-00-00 00:00:00',0);
INSERT INTO `hg_photo` VALUES (9,5,6,'',0,'html/Attach/Photo_thumb/20120711093933.172813.jpg','html/Attach/Photo_src/20120711093933.172813.jpg',0,0,'',0,'0000-00-00 00:00:00',0);
INSERT INTO `hg_photo` VALUES (10,5,6,'',0,'html/Attach/Photo_thumb/20120711093933.292827.gif','html/Attach/Photo_src/20120711093933.292827.gif',0,0,'',0,'0000-00-00 00:00:00',0);
INSERT INTO `hg_photo` VALUES (11,5,6,'',0,'html/Attach/Photo_thumb/20120711093933.309261.jpg','html/Attach/Photo_src/20120711093933.309261.jpg',0,0,'',0,'0000-00-00 00:00:00',0);
INSERT INTO `hg_photo` VALUES (12,5,2,'22',0,'html/Attach/Photo_thumb/20120711102542.750469.jpg','html/Attach/Photo_src/20120711102542.750469.jpg',0,0,'',0,'0000-00-00 00:00:00',1);
INSERT INTO `hg_photo` VALUES (13,5,2,'',0,'html/Attach/Photo_thumb/20120711102542.856977.jpg','html/Attach/Photo_src/20120711102542.856977.jpg',0,0,'',0,'0000-00-00 00:00:00',1);
INSERT INTO `hg_photo` VALUES (14,3,0,'特照2',0,'html/Attach/Photo_thumb/20120711102835.092268.jpg','html/Attach/Photo_src/20120711102835.092268.jpg',0,0,'',0,'0000-00-00 00:00:00',-1);
INSERT INTO `hg_photo` VALUES (21,3,0,'test',100,'html/Attach/Photo_thumb/20120711162905.808055.jpg','html/Attach/Photo_src/20120711162905.808055.jpg',654,488,'jpeg',45869,'2012-07-11 16:29:05',2);
INSERT INTO `hg_photo` VALUES (22,3,0,'test3',100,'html/Attach/Photo_thumb/20120712093008.453200.jpg','html/Attach/Photo_src/20120712093008.453200.jpg',750,749,'jpeg',115240,'2012-07-12 09:30:08',2);
INSERT INTO `hg_photo` VALUES (23,3,0,'test4',100,'html/Attach/Photo_thumb/20120712093031.531055.png','html/Attach/Photo_src/20120712093031.531055.png',1072,710,'png',617227,'2012-07-12 09:30:31',1);

#
# Source for table hg_reserve
#

DROP TABLE IF EXISTS `hg_reserve`;
CREATE TABLE `hg_reserve` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `phone` varchar(255) NOT NULL default '',
  `qq` varchar(255) NOT NULL default '',
  `date` date NOT NULL default '0000-00-00',
  `remark` text NOT NULL,
  `addtime` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '创建时间',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='预订';

#
# Dumping data for table hg_reserve
#

INSERT INTO `hg_reserve` VALUES (1,'aaa','1233456','','2012-07-11','','2012-07-13 16:57:23',1);

#
# Source for table hg_role
#

DROP TABLE IF EXISTS `hg_role`;
CREATE TABLE `hg_role` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `descr` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Dumping data for table hg_role
#

INSERT INTO `hg_role` VALUES (1,'后台管理根角色',1,'所有管理员都必须先赋予此角色');
INSERT INTO `hg_role` VALUES (2,'网站设置',1,'网站设置');

#
# Source for table hg_role_node
#

DROP TABLE IF EXISTS `hg_role_node`;
CREATE TABLE `hg_role_node` (
  `role_id` smallint(5) unsigned NOT NULL,
  `node_id` smallint(5) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

#
# Dumping data for table hg_role_node
#

INSERT INTO `hg_role_node` VALUES (1,1);
INSERT INTO `hg_role_node` VALUES (2,6);
INSERT INTO `hg_role_node` VALUES (2,7);
INSERT INTO `hg_role_node` VALUES (2,8);
INSERT INTO `hg_role_node` VALUES (2,9);
INSERT INTO `hg_role_node` VALUES (2,11);

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
