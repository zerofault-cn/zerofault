# MySQL-Front 5.0  (Build 1.78)

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;


# Host: localhost    Database: yishu
# ------------------------------------------------------
# Server version 5.0.22-community-nt-log

USE `yishu`;

#
# Table structure for table yishu_access
#

DROP TABLE IF EXISTS `yishu_access`;
CREATE TABLE `yishu_access` (
  `role_id` smallint(5) unsigned NOT NULL,
  `group_id` smallint(5) unsigned NOT NULL,
  `node_id` smallint(5) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL,
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Dumping data for table yishu_access
#

INSERT INTO `yishu_access` VALUES (1,0,1,1);
INSERT INTO `yishu_access` VALUES (1,0,6,1);
INSERT INTO `yishu_access` VALUES (1,0,3,1);
INSERT INTO `yishu_access` VALUES (1,0,2,1);
INSERT INTO `yishu_access` VALUES (2,0,1,1);
INSERT INTO `yishu_access` VALUES (2,0,7,1);
INSERT INTO `yishu_access` VALUES (2,0,3,1);
INSERT INTO `yishu_access` VALUES (2,0,8,1);
INSERT INTO `yishu_access` VALUES (2,0,9,1);
INSERT INTO `yishu_access` VALUES (2,0,10,1);
INSERT INTO `yishu_access` VALUES (1,0,7,1);
INSERT INTO `yishu_access` VALUES (1,0,12,1);
INSERT INTO `yishu_access` VALUES (1,0,11,1);
INSERT INTO `yishu_access` VALUES (1,0,10,1);
INSERT INTO `yishu_access` VALUES (1,0,9,1);
INSERT INTO `yishu_access` VALUES (1,0,8,1);
INSERT INTO `yishu_access` VALUES (1,0,13,1);
INSERT INTO `yishu_access` VALUES (1,0,14,1);
INSERT INTO `yishu_access` VALUES (1,0,15,1);
INSERT INTO `yishu_access` VALUES (1,0,16,1);
INSERT INTO `yishu_access` VALUES (2,0,2,1);

#
# Table structure for table yishu_admin
#

DROP TABLE IF EXISTS `yishu_admin`;
CREATE TABLE `yishu_admin` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(64) NOT NULL,
  `nick` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email` varchar(64) default NULL,
  `logintime` datetime NOT NULL,
  `flag` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Dumping data for table yishu_admin
#



#
# Table structure for table yishu_category
#

DROP TABLE IF EXISTS `yishu_category`;
CREATE TABLE `yishu_category` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `pid` smallint(5) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL,
  `addtime` datetime NOT NULL,
  `usetime` datetime NOT NULL,
  `sort` smallint(5) unsigned NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Dumping data for table yishu_category
#

INSERT INTO `yishu_category` VALUES (1,0,'艺术机构','2009-06-23 11:19:42','0000-00-00 00:00:00',10,1);
INSERT INTO `yishu_category` VALUES (2,0,'艺术门户','2009-06-23 11:24:50','0000-00-00 00:00:00',20,1);
INSERT INTO `yishu_category` VALUES (3,0,'名家官网','2009-07-03 12:54:40','2009-07-03 12:54:40',30,1);
INSERT INTO `yishu_category` VALUES (4,0,'艺术院校','2009-07-03 13:09:10','2009-07-03 13:09:10',40,1);
INSERT INTO `yishu_category` VALUES (5,0,'交易','2009-07-03 13:09:44','2009-07-03 13:09:44',50,0);
INSERT INTO `yishu_category` VALUES (6,0,'名家博客','2009-07-03 13:10:04','2009-07-03 13:10:04',60,0);
INSERT INTO `yishu_category` VALUES (7,0,'市场','2009-07-06 13:11:03','2009-07-06 13:11:03',70,1);
INSERT INTO `yishu_category` VALUES (8,0,'测试','2009-07-08 15:26:47','2009-07-08 15:26:47',80,-1);
INSERT INTO `yishu_category` VALUES (9,0,'书法','2009-07-08 17:30:58','2009-07-16 13:16:16',22,1);
INSERT INTO `yishu_category` VALUES (10,0,'艺术爱好','2009-07-08 17:31:14','2009-07-16 13:18:25',5,1);
INSERT INTO `yishu_category` VALUES (11,0,'收藏1','2009-07-16 13:11:51','2009-07-16 13:14:21',90,0);

#
# Table structure for table yishu_comment
#

DROP TABLE IF EXISTS `yishu_comment`;
CREATE TABLE `yishu_comment` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `site_id` mediumint(8) unsigned NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `content` text NOT NULL,
  `addtime` datetime NOT NULL,
  `status` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Dumping data for table yishu_comment
#

INSERT INTO `yishu_comment` VALUES (1,3,'0','','127.0.0.1','hehe\r\n测试评论','2009-07-03 14:28:46',1);
INSERT INTO `yishu_comment` VALUES (2,3,'0','','127.0.0.1','hehe\r\n测试评论2','2009-07-03 14:35:22',1);
INSERT INTO `yishu_comment` VALUES (3,3,'0','','127.0.0.1','function len(s) { \r\nvar l = 0; \r\nvar a = s.split(\"\"); \r\nfor (var i=0;i< a.length;i++) { \r\nif (a[i].charCodeAt(0)< 299) { \r\nl++; \r\n} else { \r\nl+=2; \r\n} \r\n} \r\nreturn l; \r\n} \r\n','2009-07-03 14:48:18',1);
INSERT INTO `yishu_comment` VALUES (4,3,'0','','127.0.0.1','嘿嘿','2009-07-03 15:00:34',1);
INSERT INTO `yishu_comment` VALUES (5,3,'0','','127.0.0.1','oo','2009-07-03 15:04:06',1);
INSERT INTO `yishu_comment` VALUES (6,3,'0','','127.0.0.1','fsdfsd','2009-07-03 15:04:19',1);
INSERT INTO `yishu_comment` VALUES (7,3,'0','','127.0.0.1','aadfs','2009-07-03 15:05:16',1);
INSERT INTO `yishu_comment` VALUES (8,3,'0','','127.0.0.1','恩恩','2009-07-03 15:05:41',1);
INSERT INTO `yishu_comment` VALUES (9,3,'0','','127.0.0.1','大幅度','2009-07-03 15:06:45',1);
INSERT INTO `yishu_comment` VALUES (10,4,'0','','127.0.0.1','ertert\r\ndf\r\n','2009-07-10 13:12:01',1);
INSERT INTO `yishu_comment` VALUES (11,4,'0','','127.0.0.1','评论测试\r\n测试测试','2009-07-10 13:14:46',1);
INSERT INTO `yishu_comment` VALUES (12,4,'0','','127.0.0.1','11','2009-07-10 13:15:44',-1);
INSERT INTO `yishu_comment` VALUES (13,30,'0','','127.0.0.1','很好很强大','2009-07-16 15:19:15',1);
INSERT INTO `yishu_comment` VALUES (14,19,'匿名','aa@gadf','127.0.0.1','daf','2009-07-17 13:59:32',1);

#
# Table structure for table yishu_node
#

DROP TABLE IF EXISTS `yishu_node`;
CREATE TABLE `yishu_node` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `pid` smallint(6) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `descr` tinytext,
  `level` tinyint(1) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Dumping data for table yishu_node
#

INSERT INTO `yishu_node` VALUES (1,0,'admin','后台管理',0,'后台管理项目',1,0);
INSERT INTO `yishu_node` VALUES (2,1,'Category','分类管理',0,'分类管理模块',2,0);
INSERT INTO `yishu_node` VALUES (3,1,'Comment','评论管理',0,'',0,0);
INSERT INTO `yishu_node` VALUES (4,1,'Group','用户组',0,'',0,0);
INSERT INTO `yishu_node` VALUES (5,1,'Index','管理首页',0,'',0,0);
INSERT INTO `yishu_node` VALUES (6,1,'Node','节点管理',0,'',0,0);
INSERT INTO `yishu_node` VALUES (7,1,'Public','公共模块',0,'',0,0);
INSERT INTO `yishu_node` VALUES (8,1,'Role','角色管理',0,'',0,0);
INSERT INTO `yishu_node` VALUES (9,1,'Site','网站管理',0,'',0,0);
INSERT INTO `yishu_node` VALUES (10,1,'User','',0,'',2,0);
INSERT INTO `yishu_node` VALUES (11,7,'checkLogin','',0,'{action[\'descr\']}',3,0);
INSERT INTO `yishu_node` VALUES (12,7,'logout','',0,'',3,0);
INSERT INTO `yishu_node` VALUES (13,6,'update','',0,'',3,0);
INSERT INTO `yishu_node` VALUES (14,6,'index','',0,'',3,0);
INSERT INTO `yishu_node` VALUES (15,2,'index','',0,'',3,0);
INSERT INTO `yishu_node` VALUES (16,3,'index','',0,'',3,0);
INSERT INTO `yishu_node` VALUES (17,4,'index','',0,'',3,0);
INSERT INTO `yishu_node` VALUES (18,5,'index','',0,'',3,0);
INSERT INTO `yishu_node` VALUES (19,7,'login','',0,'',3,0);
INSERT INTO `yishu_node` VALUES (20,8,'index','',0,'',3,0);
INSERT INTO `yishu_node` VALUES (21,9,'index','',0,'',3,0);
INSERT INTO `yishu_node` VALUES (22,10,'index','',0,'',3,0);
INSERT INTO `yishu_node` VALUES (25,7,'httpPost','',0,'',3,0);

#
# Table structure for table yishu_role
#

DROP TABLE IF EXISTS `yishu_role`;
CREATE TABLE `yishu_role` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `descr` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Dumping data for table yishu_role
#

INSERT INTO `yishu_role` VALUES (1,'管理员组',1,'具有一般管理员权限');
INSERT INTO `yishu_role` VALUES (2,'普通用户组',1,'一般用户权限');

#
# Table structure for table yishu_roleuser
#

DROP TABLE IF EXISTS `yishu_roleuser`;
CREATE TABLE `yishu_roleuser` (
  `role_id` mediumint(9) unsigned NOT NULL,
  `user_id` mediumint(9) unsigned NOT NULL,
  KEY `groupId` (`role_id`),
  KEY `userId` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Dumping data for table yishu_roleuser
#

INSERT INTO `yishu_roleuser` VALUES (1,3);
INSERT INTO `yishu_roleuser` VALUES (2,2);

#
# Table structure for table yishu_user
#

DROP TABLE IF EXISTS `yishu_user`;
CREATE TABLE `yishu_user` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `account` varchar(64) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `password` char(32) NOT NULL,
  `descr` varchar(255) NOT NULL,
  `create_time` datetime NOT NULL,
  `login_time` datetime NOT NULL,
  `status` tinyint(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Dumping data for table yishu_user
#

INSERT INTO `yishu_user` VALUES (1,'admin','管理员','21232f297a57a5a743894a0e4a801fc3','','0000-00-00 00:00:00','0000-00-00 00:00:00',1);
INSERT INTO `yishu_user` VALUES (2,'test','测试用户','e10adc3949ba59abbe56e057f20f883e','测试用户','0000-00-00 00:00:00','0000-00-00 00:00:00',1);
INSERT INTO `yishu_user` VALUES (3,'leader','领导','e10adc3949ba59abbe56e057f20f883e','具有一般管理权限的用户','0000-00-00 00:00:00','0000-00-00 00:00:00',1);

#
# Table structure for table yishu_vote
#

DROP TABLE IF EXISTS `yishu_vote`;
CREATE TABLE `yishu_vote` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `site_id` mediumint(8) unsigned NOT NULL default '0',
  `vote` tinyint(3) unsigned NOT NULL default '0',
  `addtime` datetime NOT NULL,
  `ip` varchar(16) NOT NULL,
  `session` varchar(32) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Dumping data for table yishu_vote
#

INSERT INTO `yishu_vote` VALUES (1,4,10,'2009-07-14 17:20:42','127.0.0.1','');
INSERT INTO `yishu_vote` VALUES (2,4,4,'2009-07-14 17:37:55','192.168.9.203','');
INSERT INTO `yishu_vote` VALUES (3,3,9,'2009-07-14 17:44:29','192.168.9.203','');
INSERT INTO `yishu_vote` VALUES (4,3,6,'2009-07-14 17:46:24','127.0.0.1','');
INSERT INTO `yishu_vote` VALUES (5,4,9,'2009-07-16 13:59:25','127.0.0.1','');
INSERT INTO `yishu_vote` VALUES (6,4,4,'2009-07-16 13:59:33','127.0.0.1','');
INSERT INTO `yishu_vote` VALUES (7,4,3,'2009-07-16 14:00:57','127.0.0.1','');
INSERT INTO `yishu_vote` VALUES (8,14,8,'2009-07-16 16:38:39','127.0.0.1','');
INSERT INTO `yishu_vote` VALUES (9,16,7,'2009-07-16 16:45:25','127.0.0.1','');
INSERT INTO `yishu_vote` VALUES (10,12,6,'2009-07-16 16:46:02','127.0.0.1','');
INSERT INTO `yishu_vote` VALUES (11,28,5,'2009-07-16 16:49:38','127.0.0.1','');
INSERT INTO `yishu_vote` VALUES (12,19,8,'2009-07-16 16:50:29','127.0.0.1','');
INSERT INTO `yishu_vote` VALUES (13,20,7,'2009-07-16 16:50:57','127.0.0.1','');
INSERT INTO `yishu_vote` VALUES (14,21,9,'2009-07-16 16:57:33','127.0.0.1','');
INSERT INTO `yishu_vote` VALUES (15,22,9,'2009-07-16 17:08:59','127.0.0.1','');
INSERT INTO `yishu_vote` VALUES (16,23,8,'2009-07-16 17:11:09','127.0.0.1','');

#
# Table structure for table yishu_website
#

DROP TABLE IF EXISTS `yishu_website`;
CREATE TABLE `yishu_website` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `cate_id` smallint(5) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL,
  `logo` blob NOT NULL,
  `url` varchar(255) NOT NULL,
  `descr` text NOT NULL,
  `addtime` datetime NOT NULL,
  `sort` smallint(5) unsigned NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '1',
  `flag` tinyint(1) unsigned NOT NULL default '0',
  `hit` mediumint(8) unsigned NOT NULL default '0',
  `view` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Dumping data for table yishu_website
#

INSERT INTO `yishu_website` VALUES (3,1,'雅昌','','http://www.artron.net','雅昌艺术网成立于2000年10月，是目前全球最大最重要的中国艺术品门户','2009-06-23 16:40:41',10,1,0,2,28);
INSERT INTO `yishu_website` VALUES (4,11,'百度','','http://www.baidu.com/','百度','2009-07-03 12:32:19',20,1,0,0,21);
INSERT INTO `yishu_website` VALUES (5,3,'测试2333','','http://www.taobao.com/','undefined','2009-07-06 13:11:28',10,-1,0,0,0);
INSERT INTO `yishu_website` VALUES (6,1,'一千二百三十四','','http://aa.fd','','2009-07-14 13:11:33',30,-1,0,0,1);
INSERT INTO `yishu_website` VALUES (7,1,'四百五十四','','fhfg','','2009-07-14 13:11:59',40,-1,0,0,0);
INSERT INTO `yishu_website` VALUES (8,1,'六百四十三','','fgsddfg','','2009-07-14 13:12:11',50,-1,1,0,0);
INSERT INTO `yishu_website` VALUES (9,1,'四百二十三','','fsgfgds','','2009-07-14 13:12:23',60,-1,0,0,0);
INSERT INTO `yishu_website` VALUES (10,1,'二百三','','hg','','2009-07-14 13:12:37',70,-1,0,0,0);
INSERT INTO `yishu_website` VALUES (11,1,'七百八十','','sgdff','','2009-07-14 13:12:54',80,-1,0,0,0);
INSERT INTO `yishu_website` VALUES (12,11,'华夏收藏网','','http://www.mycollect.net/','','2009-07-16 13:11:51',10,1,0,0,3);
INSERT INTO `yishu_website` VALUES (13,11,'中国收藏热线','','http://www.997788.com/','','2009-07-16 13:13:31',20,1,0,0,1);
INSERT INTO `yishu_website` VALUES (14,11,'中华博物网','','http://www.gg-art.com/','','2009-07-16 13:13:39',30,1,0,0,6);
INSERT INTO `yishu_website` VALUES (15,11,'美国自然历史博物馆','','http://www.amnh.org/','','2009-07-16 13:13:52',40,1,1,0,2);
INSERT INTO `yishu_website` VALUES (16,11,'中国国家博物馆','','http://www.nationalmuseum.cn/','','2009-07-16 13:14:01',50,1,0,0,2);
INSERT INTO `yishu_website` VALUES (17,11,'上海博物馆','','http://www.shanghaimuseum.net/','','2009-07-16 13:14:10',60,1,0,0,1);
INSERT INTO `yishu_website` VALUES (18,11,'首都博物馆','','http://www.capitalmuseum.org.cn/','','2009-07-16 13:14:21',70,1,0,0,0);
INSERT INTO `yishu_website` VALUES (19,9,'中国书法网','','http://www.freehead.com/index.php','','2009-07-16 13:15:07',10,1,0,2,7);
INSERT INTO `yishu_website` VALUES (20,9,'中国书法家论坛','','http://www.zgsfj.com/','','2009-07-16 13:15:19',20,1,0,0,9);
INSERT INTO `yishu_website` VALUES (21,9,'书法网论坛','','http://www.shufa.org/','','2009-07-16 13:15:26',30,1,0,1,3);
INSERT INTO `yishu_website` VALUES (22,9,'书法江湖论坛','','http://www.sf108.com/','','2009-07-16 13:15:42',40,1,0,0,3);
INSERT INTO `yishu_website` VALUES (23,9,'书法网','','http://www.shufa.com/','','2009-07-16 13:15:50',50,1,0,0,3);
INSERT INTO `yishu_website` VALUES (24,9,'中国书画家网','','http://www.zgshj.com/','','2009-07-16 13:16:00',60,1,0,0,1);
INSERT INTO `yishu_website` VALUES (25,9,'中国书法在线','','http://www.zgsf.com.cn/','','2009-07-16 13:16:06',70,1,0,0,0);
INSERT INTO `yishu_website` VALUES (26,9,'中国书法艺术网','','http://www.china-shufa.com/','','2009-07-16 13:16:16',80,1,0,0,0);
INSERT INTO `yishu_website` VALUES (27,10,'中华五千年','','http://www.zh5000.com/','','2009-07-16 13:17:00',10,1,0,0,4);
INSERT INTO `yishu_website` VALUES (28,10,'艺术中国网','','http://www.artx.cn/','哈哈\n呵呵','2009-07-16 13:17:07',20,1,0,0,4);
INSERT INTO `yishu_website` VALUES (29,10,'中华博物','','http://www.gg-art.com/','','2009-07-16 13:17:30',30,1,0,1,1);
INSERT INTO `yishu_website` VALUES (30,2,'雅昌艺术网','','http://www.artron.net/','','2009-07-16 13:17:39',40,1,0,0,7);
INSERT INTO `yishu_website` VALUES (31,10,'博宝网','','http://www.artxun.com/','','2009-07-16 13:17:49',50,1,0,0,1);
INSERT INTO `yishu_website` VALUES (32,10,'中国书画交易中心','','http://www.sh1122.com/','','2009-07-16 13:17:58',60,1,1,0,1);
INSERT INTO `yishu_website` VALUES (33,10,'博雅艺术网','','http://www.manyart.com/','','2009-07-16 13:18:13',70,0,0,0,0);
INSERT INTO `yishu_website` VALUES (34,10,'艺术空间','','http://www.artsky.com/','','2009-07-16 13:18:25',80,1,0,0,0);

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
