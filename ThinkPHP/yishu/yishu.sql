# MySQL-Front 5.0  (Build 1.78)

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;


# Host: localhost    Database: yishu
# ------------------------------------------------------
# Server version 5.0.22-community-nt-log

#USE `yishu`;


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
LOCK TABLES `yishu_category` WRITE;
/*!40000 ALTER TABLE `yishu_category` DISABLE KEYS */;

INSERT INTO `yishu_category` VALUES (1,0,'艺术机构','2009-06-23 11:19:42','0000-00-00 00:00:00',10,1);
INSERT INTO `yishu_category` VALUES (2,0,'艺术门户','2009-06-23 11:24:50','0000-00-00 00:00:00',20,1);
INSERT INTO `yishu_category` VALUES (3,0,'名家官网','2009-07-03 12:54:40','2009-07-03 12:54:40',30,1);
INSERT INTO `yishu_category` VALUES (4,0,'艺术院校','2009-07-03 13:09:10','2009-07-03 13:09:10',40,1);
INSERT INTO `yishu_category` VALUES (5,0,'交易','2009-07-03 13:09:44','2009-07-03 13:09:44',50,0);
INSERT INTO `yishu_category` VALUES (6,0,'名家博客','2009-07-03 13:10:04','2009-07-03 13:10:04',60,0);
INSERT INTO `yishu_category` VALUES (7,0,'市场','2009-07-06 13:11:03','2009-07-06 13:11:03',70,1);
INSERT INTO `yishu_category` VALUES (8,0,'测试','2009-07-08 15:26:47','2009-07-08 15:26:47',80,-1);
INSERT INTO `yishu_category` VALUES (9,0,'书法','2009-07-08 17:30:58','2009-07-16 13:16:16',22,1);
INSERT INTO `yishu_category` VALUES (10,0,'艺术爱好','2009-07-08 17:31:14','2009-07-16 13:18:25',5,0);
INSERT INTO `yishu_category` VALUES (11,0,'收藏1','2009-07-16 13:11:51','2009-07-16 13:14:21',90,0);
/*!40000 ALTER TABLE `yishu_category` ENABLE KEYS */;
UNLOCK TABLES;

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
# Table structure for table yishu_node
#

DROP TABLE IF EXISTS `yishu_node`;
CREATE TABLE `yishu_node` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `pid` smallint(6) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `descr` tinytext,
  `level` tinyint(1) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Dumping data for table yishu_node
#
LOCK TABLES `yishu_node` WRITE;
/*!40000 ALTER TABLE `yishu_node` DISABLE KEYS */;

INSERT INTO `yishu_node` VALUES (1,0,'admin','管理后台','后台管理项目',1,0);
INSERT INTO `yishu_node` VALUES (2,1,'User','用户管理','用户管理模块',2,0);
INSERT INTO `yishu_node` VALUES (3,1,'Node','节点管理','节点管理模块',2,0);
INSERT INTO `yishu_node` VALUES (4,1,'Role','角色管理','角色管理模块',2,0);
INSERT INTO `yishu_node` VALUES (5,1,'Comment','评论管理','评论管理模块',2,0);
INSERT INTO `yishu_node` VALUES (6,2,'index','列表','',3,0);
INSERT INTO `yishu_node` VALUES (7,4,'index','列表','',3,0);
INSERT INTO `yishu_node` VALUES (8,1,'Category','分类管理','',2,0);
INSERT INTO `yishu_node` VALUES (9,8,'index','列表','',3,0);
INSERT INTO `yishu_node` VALUES (10,8,'add','添加','',3,0);
INSERT INTO `yishu_node` VALUES (11,8,'update','更新','',3,0);
INSERT INTO `yishu_node` VALUES (12,8,'delete','删除','',3,0);
INSERT INTO `yishu_node` VALUES (13,1,'Site','网站管理','',2,0);
INSERT INTO `yishu_node` VALUES (14,13,'index','列表','',3,0);
INSERT INTO `yishu_node` VALUES (15,3,'index','列表','',3,0);
INSERT INTO `yishu_node` VALUES (16,5,'update','更改','',3,0);
INSERT INTO `yishu_node` VALUES (17,5,'delete','删除','',3,0);
INSERT INTO `yishu_node` VALUES (18,13,'add','添加','',3,0);
INSERT INTO `yishu_node` VALUES (19,13,'update','更新','',3,0);
INSERT INTO `yishu_node` VALUES (20,13,'delete','删除','',3,0);
INSERT INTO `yishu_node` VALUES (21,1,'Index','默认首页','',2,0);
INSERT INTO `yishu_node` VALUES (22,3,'update','','',3,0);
INSERT INTO `yishu_node` VALUES (23,5,'index','','',3,0);
INSERT INTO `yishu_node` VALUES (24,21,'index','','',3,0);
INSERT INTO `yishu_node` VALUES (25,2,'add','','',3,0);
INSERT INTO `yishu_node` VALUES (26,4,'add','','',3,0);
INSERT INTO `yishu_node` VALUES (27,2,'update','','',3,0);
INSERT INTO `yishu_node` VALUES (28,4,'update','','',3,0);
INSERT INTO `yishu_node` VALUES (29,2,'delete','','',3,0);
INSERT INTO `yishu_node` VALUES (30,4,'delete','','',3,0);
INSERT INTO `yishu_node` VALUES (31,1,'Attach','附件管理','',2,0);
INSERT INTO `yishu_node` VALUES (32,31,'upload','上传','',3,0);
INSERT INTO `yishu_node` VALUES (33,2,'edit','','',3,0);
INSERT INTO `yishu_node` VALUES (34,4,'edit','','',3,0);
/*!40000 ALTER TABLE `yishu_node` ENABLE KEYS */;
UNLOCK TABLES;

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
LOCK TABLES `yishu_role` WRITE;
/*!40000 ALTER TABLE `yishu_role` DISABLE KEYS */;

INSERT INTO `yishu_role` VALUES (1,'后台管理员',1,'后台管理员');
INSERT INTO `yishu_role` VALUES (2,'网站管理员',1,'网站管理员');
INSERT INTO `yishu_role` VALUES (3,'网站检查员',1,'分类管理员');
INSERT INTO `yishu_role` VALUES (4,'分类管理员',1,'分类管理员');
INSERT INTO `yishu_role` VALUES (5,'分类检查员',1,'分类检查员');
INSERT INTO `yishu_role` VALUES (6,'评论管理员',1,'评论管理员');
INSERT INTO `yishu_role` VALUES (7,'评论监管',1,'评论监管');
INSERT INTO `yishu_role` VALUES (8,'权限管理员',1,'权限管理员');
INSERT INTO `yishu_role` VALUES (9,'权限监察',1,'权限监察');
INSERT INTO `yishu_role` VALUES (10,'超级管理员',1,'超级管理员');
INSERT INTO `yishu_role` VALUES (11,'功能测试员',1,'功能测试员');
/*!40000 ALTER TABLE `yishu_role` ENABLE KEYS */;
UNLOCK TABLES;

#
# Table structure for table yishu_role_node
#

DROP TABLE IF EXISTS `yishu_role_node`;
CREATE TABLE `yishu_role_node` (
  `role_id` smallint(5) unsigned NOT NULL,
  `node_id` smallint(5) unsigned NOT NULL,
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Dumping data for table yishu_role_node
#
LOCK TABLES `yishu_role_node` WRITE;
/*!40000 ALTER TABLE `yishu_role_node` DISABLE KEYS */;

INSERT INTO `yishu_role_node` VALUES (1,1);
INSERT INTO `yishu_role_node` VALUES (2,13);
INSERT INTO `yishu_role_node` VALUES (2,14);
INSERT INTO `yishu_role_node` VALUES (2,18);
INSERT INTO `yishu_role_node` VALUES (2,19);
INSERT INTO `yishu_role_node` VALUES (2,20);
INSERT INTO `yishu_role_node` VALUES (4,9);
INSERT INTO `yishu_role_node` VALUES (4,8);
INSERT INTO `yishu_role_node` VALUES (3,19);
INSERT INTO `yishu_role_node` VALUES (3,14);
INSERT INTO `yishu_role_node` VALUES (3,13);
INSERT INTO `yishu_role_node` VALUES (4,10);
INSERT INTO `yishu_role_node` VALUES (4,11);
INSERT INTO `yishu_role_node` VALUES (4,12);
INSERT INTO `yishu_role_node` VALUES (5,8);
INSERT INTO `yishu_role_node` VALUES (5,9);
INSERT INTO `yishu_role_node` VALUES (5,11);
INSERT INTO `yishu_role_node` VALUES (6,5);
INSERT INTO `yishu_role_node` VALUES (6,16);
INSERT INTO `yishu_role_node` VALUES (6,17);
INSERT INTO `yishu_role_node` VALUES (6,23);
INSERT INTO `yishu_role_node` VALUES (7,5);
INSERT INTO `yishu_role_node` VALUES (7,16);
INSERT INTO `yishu_role_node` VALUES (7,23);
INSERT INTO `yishu_role_node` VALUES (8,2);
INSERT INTO `yishu_role_node` VALUES (8,3);
INSERT INTO `yishu_role_node` VALUES (8,4);
INSERT INTO `yishu_role_node` VALUES (8,6);
INSERT INTO `yishu_role_node` VALUES (8,7);
INSERT INTO `yishu_role_node` VALUES (8,15);
INSERT INTO `yishu_role_node` VALUES (8,22);
INSERT INTO `yishu_role_node` VALUES (8,25);
INSERT INTO `yishu_role_node` VALUES (8,26);
INSERT INTO `yishu_role_node` VALUES (8,27);
INSERT INTO `yishu_role_node` VALUES (8,28);
INSERT INTO `yishu_role_node` VALUES (8,29);
INSERT INTO `yishu_role_node` VALUES (8,30);
INSERT INTO `yishu_role_node` VALUES (9,2);
INSERT INTO `yishu_role_node` VALUES (9,3);
INSERT INTO `yishu_role_node` VALUES (9,4);
INSERT INTO `yishu_role_node` VALUES (9,6);
INSERT INTO `yishu_role_node` VALUES (9,7);
INSERT INTO `yishu_role_node` VALUES (9,15);
INSERT INTO `yishu_role_node` VALUES (9,21);
INSERT INTO `yishu_role_node` VALUES (9,24);
INSERT INTO `yishu_role_node` VALUES (10,2);
INSERT INTO `yishu_role_node` VALUES (10,3);
INSERT INTO `yishu_role_node` VALUES (10,4);
INSERT INTO `yishu_role_node` VALUES (10,5);
INSERT INTO `yishu_role_node` VALUES (10,6);
INSERT INTO `yishu_role_node` VALUES (10,7);
INSERT INTO `yishu_role_node` VALUES (10,8);
INSERT INTO `yishu_role_node` VALUES (10,9);
INSERT INTO `yishu_role_node` VALUES (10,10);
INSERT INTO `yishu_role_node` VALUES (10,11);
INSERT INTO `yishu_role_node` VALUES (10,12);
INSERT INTO `yishu_role_node` VALUES (10,13);
INSERT INTO `yishu_role_node` VALUES (10,14);
INSERT INTO `yishu_role_node` VALUES (10,15);
INSERT INTO `yishu_role_node` VALUES (10,16);
INSERT INTO `yishu_role_node` VALUES (10,17);
INSERT INTO `yishu_role_node` VALUES (10,18);
INSERT INTO `yishu_role_node` VALUES (10,19);
INSERT INTO `yishu_role_node` VALUES (10,20);
INSERT INTO `yishu_role_node` VALUES (10,21);
INSERT INTO `yishu_role_node` VALUES (10,22);
INSERT INTO `yishu_role_node` VALUES (10,23);
INSERT INTO `yishu_role_node` VALUES (10,24);
INSERT INTO `yishu_role_node` VALUES (10,25);
INSERT INTO `yishu_role_node` VALUES (10,26);
INSERT INTO `yishu_role_node` VALUES (10,27);
INSERT INTO `yishu_role_node` VALUES (10,28);
INSERT INTO `yishu_role_node` VALUES (10,29);
INSERT INTO `yishu_role_node` VALUES (10,30);
INSERT INTO `yishu_role_node` VALUES (10,31);
INSERT INTO `yishu_role_node` VALUES (10,32);
INSERT INTO `yishu_role_node` VALUES (10,33);
INSERT INTO `yishu_role_node` VALUES (10,34);
INSERT INTO `yishu_role_node` VALUES (11,2);
INSERT INTO `yishu_role_node` VALUES (11,3);
INSERT INTO `yishu_role_node` VALUES (11,4);
INSERT INTO `yishu_role_node` VALUES (11,5);
INSERT INTO `yishu_role_node` VALUES (11,6);
INSERT INTO `yishu_role_node` VALUES (11,7);
INSERT INTO `yishu_role_node` VALUES (11,8);
INSERT INTO `yishu_role_node` VALUES (11,9);
INSERT INTO `yishu_role_node` VALUES (11,10);
INSERT INTO `yishu_role_node` VALUES (11,13);
INSERT INTO `yishu_role_node` VALUES (11,14);
INSERT INTO `yishu_role_node` VALUES (11,15);
INSERT INTO `yishu_role_node` VALUES (11,18);
INSERT INTO `yishu_role_node` VALUES (11,21);
INSERT INTO `yishu_role_node` VALUES (11,23);
INSERT INTO `yishu_role_node` VALUES (11,24);
INSERT INTO `yishu_role_node` VALUES (11,25);
INSERT INTO `yishu_role_node` VALUES (11,26);
INSERT INTO `yishu_role_node` VALUES (11,31);
INSERT INTO `yishu_role_node` VALUES (11,32);
/*!40000 ALTER TABLE `yishu_role_node` ENABLE KEYS */;
UNLOCK TABLES;

#
# Table structure for table yishu_user
#

DROP TABLE IF EXISTS `yishu_user`;
CREATE TABLE `yishu_user` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `account` varchar(64) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` char(32) NOT NULL,
  `create_time` datetime NOT NULL,
  `login_time` datetime NOT NULL,
  `status` tinyint(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Dumping data for table yishu_user
#
LOCK TABLES `yishu_user` WRITE;
/*!40000 ALTER TABLE `yishu_user` DISABLE KEYS */;

INSERT INTO `yishu_user` VALUES (1,'admin','系统管理员','21232f297a57a5a743894a0e4a801fc3','2009-08-09 19:19:25','2009-08-09 20:40:19',1);
INSERT INTO `yishu_user` VALUES (3,'test','测试用户','e10adc3949ba59abbe56e057f20f883e','2009-08-09 20:18:15','2009-08-09 20:56:13',1);
INSERT INTO `yishu_user` VALUES (4,'test2','测试用户','e10adc3949ba59abbe56e057f20f883e','2009-08-09 20:44:11','2009-08-09 20:56:53',1);
/*!40000 ALTER TABLE `yishu_user` ENABLE KEYS */;
UNLOCK TABLES;

#
# Table structure for table yishu_user_role
#

DROP TABLE IF EXISTS `yishu_user_role`;
CREATE TABLE `yishu_user_role` (
  `user_id` mediumint(9) unsigned NOT NULL,
  `role_id` mediumint(9) unsigned NOT NULL,
  KEY `userId` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Dumping data for table yishu_user_role
#
LOCK TABLES `yishu_user_role` WRITE;
/*!40000 ALTER TABLE `yishu_user_role` DISABLE KEYS */;

INSERT INTO `yishu_user_role` VALUES (3,3);
INSERT INTO `yishu_user_role` VALUES (3,1);
INSERT INTO `yishu_user_role` VALUES (3,5);
INSERT INTO `yishu_user_role` VALUES (3,7);
INSERT INTO `yishu_user_role` VALUES (3,9);
INSERT INTO `yishu_user_role` VALUES (4,1);
INSERT INTO `yishu_user_role` VALUES (4,11);
/*!40000 ALTER TABLE `yishu_user_role` ENABLE KEYS */;
UNLOCK TABLES;

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
# Table structure for table yishu_website
#

DROP TABLE IF EXISTS `yishu_website`;
CREATE TABLE `yishu_website` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `cate_id` smallint(5) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL,
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
LOCK TABLES `yishu_website` WRITE;
/*!40000 ALTER TABLE `yishu_website` DISABLE KEYS */;

INSERT INTO `yishu_website` VALUES (3,1,'雅昌','http://www.artron.net','雅昌艺术网成立于2000年10月，是目前全球最大最重要的中国艺术品门户','2009-06-23 16:40:41',10,1,0,2,28);
INSERT INTO `yishu_website` VALUES (4,11,'百度','http://www.baidu.com/','百度','2009-07-03 12:32:19',20,1,0,0,21);
INSERT INTO `yishu_website` VALUES (5,3,'测试2333','http://www.taobao.com/','undefined','2009-07-06 13:11:28',10,-1,0,0,0);
INSERT INTO `yishu_website` VALUES (6,1,'一千二百三十四','http://aa.fd','','2009-07-14 13:11:33',30,-1,0,0,1);
INSERT INTO `yishu_website` VALUES (7,1,'四百五十四','fhfg','','2009-07-14 13:11:59',40,-1,0,0,0);
INSERT INTO `yishu_website` VALUES (8,1,'六百四十三','fgsddfg','','2009-07-14 13:12:11',50,-1,1,0,0);
INSERT INTO `yishu_website` VALUES (9,1,'四百二十三','fsgfgds','','2009-07-14 13:12:23',60,-1,0,0,0);
INSERT INTO `yishu_website` VALUES (10,1,'二百三','hg','','2009-07-14 13:12:37',70,-1,0,0,0);
INSERT INTO `yishu_website` VALUES (11,1,'七百八十','sgdff','','2009-07-14 13:12:54',80,-1,0,0,0);
INSERT INTO `yishu_website` VALUES (12,11,'华夏收藏网','http://www.mycollect.net/','','2009-07-16 13:11:51',10,1,0,0,3);
INSERT INTO `yishu_website` VALUES (13,11,'中国收藏热线','http://www.997788.com/','','2009-07-16 13:13:31',20,1,0,0,1);
INSERT INTO `yishu_website` VALUES (14,11,'中华博物网','http://www.gg-art.com/','','2009-07-16 13:13:39',30,1,0,0,6);
INSERT INTO `yishu_website` VALUES (15,11,'美国自然历史博物馆','http://www.amnh.org/','','2009-07-16 13:13:52',40,1,1,0,2);
INSERT INTO `yishu_website` VALUES (16,11,'中国国家博物馆','http://www.nationalmuseum.cn/','','2009-07-16 13:14:01',50,1,0,0,2);
INSERT INTO `yishu_website` VALUES (17,11,'上海博物馆','http://www.shanghaimuseum.net/','','2009-07-16 13:14:10',60,1,0,0,1);
INSERT INTO `yishu_website` VALUES (18,11,'首都博物馆','http://www.capitalmuseum.org.cn/','','2009-07-16 13:14:21',70,1,0,0,0);
INSERT INTO `yishu_website` VALUES (19,9,'中国书法网','http://www.freehead.com/index.php','','2009-07-16 13:15:07',10,1,0,2,7);
INSERT INTO `yishu_website` VALUES (20,9,'中国书法家论坛','http://www.zgsfj.com/','','2009-07-16 13:15:19',20,1,0,0,9);
INSERT INTO `yishu_website` VALUES (21,9,'书法网论坛','http://www.shufa.org/','','2009-07-16 13:15:26',30,1,0,1,3);
INSERT INTO `yishu_website` VALUES (22,9,'书法江湖论坛','http://www.sf108.com/','','2009-07-16 13:15:42',40,1,0,0,3);
INSERT INTO `yishu_website` VALUES (23,9,'书法网','http://www.shufa.com/','','2009-07-16 13:15:50',50,1,0,0,3);
INSERT INTO `yishu_website` VALUES (24,9,'中国书画家网','http://www.zgshj.com/','','2009-07-16 13:16:00',60,1,0,0,1);
INSERT INTO `yishu_website` VALUES (25,9,'中国书法在线','http://www.zgsf.com.cn/','','2009-07-16 13:16:06',70,1,0,0,0);
INSERT INTO `yishu_website` VALUES (26,9,'中国书法艺术网','http://www.china-shufa.com/','','2009-07-16 13:16:16',80,1,0,0,0);
INSERT INTO `yishu_website` VALUES (27,10,'中华五千年','http://www.zh5000.com/','','2009-07-16 13:17:00',10,1,0,0,4);
INSERT INTO `yishu_website` VALUES (28,10,'艺术中国网','http://www.artx.cn/','哈哈\n呵呵','2009-07-16 13:17:07',20,1,0,0,4);
INSERT INTO `yishu_website` VALUES (29,10,'中华博物','http://www.gg-art.com/','','2009-07-16 13:17:30',30,1,0,1,1);
INSERT INTO `yishu_website` VALUES (30,2,'雅昌艺术网','http://www.artron.net/','','2009-07-16 13:17:39',40,1,0,0,7);
INSERT INTO `yishu_website` VALUES (31,10,'博宝网','http://www.artxun.com/','','2009-07-16 13:17:49',50,1,0,0,1);
INSERT INTO `yishu_website` VALUES (32,10,'中国书画交易中心','http://www.sh1122.com/','','2009-07-16 13:17:58',60,1,1,0,1);
INSERT INTO `yishu_website` VALUES (33,10,'博雅艺术网','http://www.manyart.com/','','2009-07-16 13:18:13',70,0,0,0,0);
INSERT INTO `yishu_website` VALUES (34,10,'艺术空间','http://www.artsky.com/','','2009-07-16 13:18:25',80,1,0,0,0);
/*!40000 ALTER TABLE `yishu_website` ENABLE KEYS */;
UNLOCK TABLES;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
