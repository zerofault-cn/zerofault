/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;


#CREATE DATABASE `yishu321` /*!40100 DEFAULT CHARACTER SET gb2312 */;DROP DATABASE IF EXISTS `yishu321`;

USE `yishu321`;
CREATE TABLE `yishu_category` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `pid` smallint(5) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL,
  `addtime` datetime NOT NULL,
  `usetime` datetime NOT NULL,
  `sort` smallint(5) unsigned NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

INSERT INTO `yishu_category` VALUES (1,0,'艺术门户','2009-07-13 23:11:59','2009-08-29 09:29:13',10,1);
INSERT INTO `yishu_category` VALUES (2,0,'书法','2009-07-16 14:34:48','2009-07-16 14:39:10',20,1);
INSERT INTO `yishu_category` VALUES (3,0,'美术','2009-07-16 14:39:37','2009-07-16 14:50:10',30,-1);
INSERT INTO `yishu_category` VALUES (4,0,'当代艺术','2009-07-19 12:16:19','2009-08-17 21:50:37',40,1);
INSERT INTO `yishu_category` VALUES (5,0,'国画','2009-07-19 12:16:32','2009-08-28 16:20:35',50,1);
INSERT INTO `yishu_category` VALUES (6,0,'在线交易','2009-08-16 15:56:15','2009-08-29 11:05:32',60,1);
INSERT INTO `yishu_category` VALUES (7,0,'油画','2009-08-17 16:19:07','2009-08-17 16:19:07',70,1);
INSERT INTO `yishu_category` VALUES (8,0,'名家网站','2009-08-17 16:20:32','2009-08-29 10:58:48',80,1);
INSERT INTO `yishu_category` VALUES (9,0,'雕塑','2009-08-17 16:20:56','2009-08-28 14:35:43',90,1);
INSERT INTO `yishu_category` VALUES (10,0,'画院','2009-08-17 16:21:07','2009-09-03 11:27:34',100,1);
INSERT INTO `yishu_category` VALUES (11,0,'报刊杂志','2009-08-17 16:22:08','2009-08-28 16:56:02',95,1);
INSERT INTO `yishu_category` VALUES (12,0,'展会','2009-08-17 16:22:48','2009-08-17 16:22:48',150,1);
INSERT INTO `yishu_category` VALUES (13,0,'设计','2009-08-17 16:22:58','2009-08-29 10:54:39',130,1);
INSERT INTO `yishu_category` VALUES (14,0,'','2009-08-17 16:23:08','2009-08-17 16:23:08',140,-1);
INSERT INTO `yishu_category` VALUES (15,0,'院校','2009-08-17 16:24:03','2009-08-28 17:30:18',120,1);
INSERT INTO `yishu_category` VALUES (16,0,'收藏','2009-08-17 16:25:58','2009-08-29 11:19:38',160,1);
INSERT INTO `yishu_category` VALUES (17,0,'艺术机构','2009-08-17 17:31:36','2009-08-29 08:26:39',105,1);
INSERT INTO `yishu_category` VALUES (18,0,'教育','2009-08-17 21:25:16','2009-08-17 21:25:16',180,1);
INSERT INTO `yishu_category` VALUES (19,0,'拍卖行','2009-08-26 12:00:18','2009-08-29 11:03:01',135,1);
INSERT INTO `yishu_category` VALUES (20,0,'国外网站','2009-08-26 12:02:50','2009-08-29 10:42:04',125,1);
INSERT INTO `yishu_category` VALUES (21,0,'画廊','2009-08-28 14:51:39','2009-08-28 15:19:53',210,1);
INSERT INTO `yishu_category` VALUES (22,0,'出版社','2009-08-28 16:56:41','2009-08-28 16:57:07',155,1);
INSERT INTO `yishu_category` VALUES (23,0,'C G','2009-08-29 10:41:41','2009-08-29 10:45:17',230,1);
INSERT INTO `yishu_category` VALUES (24,0,'摄影','2009-08-29 10:51:50','2009-08-29 11:16:58',240,1);
CREATE TABLE `yishu_comment` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `site_id` mediumint(8) unsigned NOT NULL,
  `name` varchar(64) NOT NULL default '',
  `email` varchar(64) NOT NULL default '',
  `ip` varchar(16) NOT NULL,
  `content` text NOT NULL,
  `addtime` datetime NOT NULL,
  `status` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO `yishu_comment` VALUES (1,1,'adam','zerofault@gmail.com','125.119.87.135','很好很强大\r\n祝发展壮大','2009-07-16 23:11:18',1);
INSERT INTO `yishu_comment` VALUES (2,1,'zerofault','','125.119.87.135','沙发被抢了\r\n只有板凳了','2009-07-16 23:12:50',1);
INSERT INTO `yishu_comment` VALUES (3,1,'匿名','','125.119.87.135','这么活跃，我也来','2009-07-16 23:24:59',1);
INSERT INTO `yishu_comment` VALUES (4,66,'匿名','','122.224.130.150','这个不错吗','2009-08-17 16:02:06',1);
CREATE TABLE `yishu_node` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `pid` smallint(6) unsigned NOT NULL,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `descr` tinytext,
  `level` tinyint(1) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

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
CREATE TABLE `yishu_role` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `descr` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

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
CREATE TABLE `yishu_role_node` (
  `role_id` smallint(5) unsigned NOT NULL,
  `node_id` smallint(5) unsigned NOT NULL,
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `yishu_role_node` VALUES (1,1);
INSERT INTO `yishu_role_node` VALUES (2,20);
INSERT INTO `yishu_role_node` VALUES (2,19);
INSERT INTO `yishu_role_node` VALUES (2,18);
INSERT INTO `yishu_role_node` VALUES (2,14);
INSERT INTO `yishu_role_node` VALUES (2,13);
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
INSERT INTO `yishu_role_node` VALUES (2,24);
INSERT INTO `yishu_role_node` VALUES (2,21);
INSERT INTO `yishu_role_node` VALUES (9,24);
INSERT INTO `yishu_role_node` VALUES (9,21);
INSERT INTO `yishu_role_node` VALUES (9,15);
INSERT INTO `yishu_role_node` VALUES (9,7);
INSERT INTO `yishu_role_node` VALUES (9,4);
INSERT INTO `yishu_role_node` VALUES (9,3);
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
INSERT INTO `yishu_role_node` VALUES (2,32);
INSERT INTO `yishu_role_node` VALUES (2,31);
INSERT INTO `yishu_role_node` VALUES (11,32);
INSERT INTO `yishu_role_node` VALUES (11,31);
INSERT INTO `yishu_role_node` VALUES (11,26);
INSERT INTO `yishu_role_node` VALUES (11,24);
INSERT INTO `yishu_role_node` VALUES (11,23);
INSERT INTO `yishu_role_node` VALUES (11,21);
INSERT INTO `yishu_role_node` VALUES (11,18);
INSERT INTO `yishu_role_node` VALUES (11,15);
INSERT INTO `yishu_role_node` VALUES (11,14);
INSERT INTO `yishu_role_node` VALUES (11,13);
INSERT INTO `yishu_role_node` VALUES (11,10);
INSERT INTO `yishu_role_node` VALUES (11,9);
INSERT INTO `yishu_role_node` VALUES (11,8);
INSERT INTO `yishu_role_node` VALUES (11,7);
INSERT INTO `yishu_role_node` VALUES (11,5);
INSERT INTO `yishu_role_node` VALUES (11,4);
INSERT INTO `yishu_role_node` VALUES (11,3);
CREATE TABLE `yishu_user` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `account` varchar(64) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` char(32) NOT NULL,
  `create_time` datetime NOT NULL,
  `login_time` datetime NOT NULL,
  `status` tinyint(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO `yishu_user` VALUES (1,'admin','系统管理员','8891815eda4c6e329348d3a11611a7ba','2009-08-09 19:19:25','2009-09-12 20:57:16',1);
INSERT INTO `yishu_user` VALUES (3,'test','测试用户','e10adc3949ba59abbe56e057f20f883e','2009-08-09 20:18:15','2009-08-16 13:43:25',1);
INSERT INTO `yishu_user` VALUES (4,'test2','测试用户','e10adc3949ba59abbe56e057f20f883e','2009-08-09 20:44:11','2009-08-09 20:56:53',1);
INSERT INTO `yishu_user` VALUES (5,'zaofc','管理员','9f09ec28f4a2d02b1b9fe57a0ed39aa5','2009-08-16 13:42:38','2009-08-29 08:24:19',1);
CREATE TABLE `yishu_user_role` (
  `user_id` mediumint(9) unsigned NOT NULL,
  `role_id` mediumint(9) unsigned NOT NULL,
  KEY `userId` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `yishu_user_role` VALUES (3,3);
INSERT INTO `yishu_user_role` VALUES (3,1);
INSERT INTO `yishu_user_role` VALUES (3,5);
INSERT INTO `yishu_user_role` VALUES (3,7);
INSERT INTO `yishu_user_role` VALUES (3,9);
INSERT INTO `yishu_user_role` VALUES (4,1);
INSERT INTO `yishu_user_role` VALUES (4,11);
INSERT INTO `yishu_user_role` VALUES (5,1);
INSERT INTO `yishu_user_role` VALUES (5,2);
INSERT INTO `yishu_user_role` VALUES (5,4);
INSERT INTO `yishu_user_role` VALUES (5,6);
CREATE TABLE `yishu_vote` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `site_id` mediumint(8) unsigned NOT NULL default '0',
  `vote` tinyint(3) unsigned NOT NULL default '0',
  `addtime` datetime NOT NULL,
  `ip` varchar(16) NOT NULL,
  `session` varchar(32) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

INSERT INTO `yishu_vote` VALUES (1,1,8,'2009-07-14 21:55:37','125.122.211.25','');
INSERT INTO `yishu_vote` VALUES (2,1,10,'2009-07-16 23:47:23','125.119.87.135','');
INSERT INTO `yishu_vote` VALUES (3,58,10,'2009-07-17 12:31:12','124.90.50.44','');
INSERT INTO `yishu_vote` VALUES (4,26,9,'2009-07-24 22:42:18','125.122.221.132','');
INSERT INTO `yishu_vote` VALUES (5,25,8,'2009-07-26 11:32:57','125.120.227.121','');
INSERT INTO `yishu_vote` VALUES (6,25,5,'2009-08-16 14:05:14','125.122.210.211','');
INSERT INTO `yishu_vote` VALUES (7,66,9,'2009-08-17 16:02:11','122.224.130.150','');
INSERT INTO `yishu_vote` VALUES (8,25,10,'2009-09-02 13:29:11','122.224.130.150','');
INSERT INTO `yishu_vote` VALUES (9,1,10,'2009-09-12 21:13:20','125.120.224.132','');
INSERT INTO `yishu_vote` VALUES (10,25,2,'2009-09-12 21:13:50','125.120.224.132','');
INSERT INTO `yishu_vote` VALUES (11,60,7,'2009-09-12 21:14:58','125.120.224.132','');
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
  `famous` tinyint(1) unsigned NOT NULL default '0',
  `recommend` tinyint(1) unsigned NOT NULL default '0',
  `hit` mediumint(8) unsigned NOT NULL default '0',
  `view` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=324 DEFAULT CHARSET=utf8;

INSERT INTO `yishu_website` VALUES (1,1,'雅昌艺术网','http://www.artron.net/','雅昌艺术网成立于2000年10月，是目前全球最大最重要的中国艺术品门户，是获取艺术资讯的首选媒体平台，是艺术品收藏投资及爱好者不可或缺的重要工具。它已成为艺术界最为推崇的互联网品牌。\n雅昌艺术网逾50万的专业会员、每天800万人次的浏览量，在中国互联网协会chinarank评测的全球中文互联网排名中位居400名之列。','2009-07-13 23:20:20',1,1,1,1,1,20,70);
INSERT INTO `yishu_website` VALUES (2,2,'中国书法网','http://www.freehead.com/index.php','','2009-07-16 14:34:48',10,1,0,1,0,52,22);
INSERT INTO `yishu_website` VALUES (3,2,'中国书法家论坛','http://www.zgsfj.com/','','2009-07-16 14:34:56',20,1,0,1,0,17,24);
INSERT INTO `yishu_website` VALUES (4,2,'书法网论坛','http://www.shufa.org/','','2009-07-16 14:35:04',30,1,0,1,0,16,19);
INSERT INTO `yishu_website` VALUES (5,2,'书法江湖论坛','http://www.sf108.com/bbs/index.php','','2009-07-16 14:35:16',40,1,0,1,0,8,21);
INSERT INTO `yishu_website` VALUES (6,2,'汉字硬笔书法网','http://www.yingbishufa.com/','','2009-07-16 14:35:26',50,1,0,1,0,17,20);
INSERT INTO `yishu_website` VALUES (7,2,'书法空间','http://www.9610.com/','','2009-07-16 14:35:32',60,1,0,1,0,18,22);
INSERT INTO `yishu_website` VALUES (8,2,'书法网','http://www.shufa.com/','','2009-07-16 14:35:40',70,1,0,1,0,15,8);
INSERT INTO `yishu_website` VALUES (9,2,'中国硬笔书法在线论坛','http://bbs.yingbishufa.com/','','2009-07-16 14:35:47',80,1,0,1,0,16,12);
INSERT INTO `yishu_website` VALUES (10,2,'硬笔书法天地','http://www.ybsftd.com/','','2009-07-16 14:35:56',90,1,0,1,0,17,13);
INSERT INTO `yishu_website` VALUES (11,2,'中国书法家','http://www.china-shufajia.com/','','2009-07-16 14:36:10',100,1,0,1,0,16,5);
INSERT INTO `yishu_website` VALUES (12,2,'中国书画家网','http://www.zgshj.com/','','2009-07-16 14:36:19',110,1,0,0,0,15,8);
INSERT INTO `yishu_website` VALUES (13,2,'中国书法在线','http://www.zgsf.com.cn/','','2009-07-16 14:36:26',120,1,0,0,0,16,4);
INSERT INTO `yishu_website` VALUES (14,2,'中国书法家园','http://www.eshufa.com/','','2009-07-16 14:36:32',130,1,0,0,0,14,5);
INSERT INTO `yishu_website` VALUES (15,2,'中国书画之家','http://www.bookdraw.com/','','2009-07-16 14:36:40',140,1,0,0,0,13,8);
INSERT INTO `yishu_website` VALUES (16,2,'中国书法艺术网','http://www.china-shufa.com/','','2009-07-16 14:36:48',150,1,0,0,0,16,8);
INSERT INTO `yishu_website` VALUES (17,2,'中国硬笔书法艺术网','http://www.ybsf.org/','','2009-07-16 14:37:00',160,1,0,0,0,20,6);
INSERT INTO `yishu_website` VALUES (18,2,'浙江书法网','http://www.zjshufa.com/','','2009-07-16 14:37:09',170,1,0,0,0,20,6);
INSERT INTO `yishu_website` VALUES (19,2,'中国书法站','http://www.chinashufa.com/','','2009-07-16 14:37:16',180,1,0,0,0,20,5);
INSERT INTO `yishu_website` VALUES (20,2,'书法展馆','http://www.worldartsexposition.com/','','2009-07-16 14:37:30',190,1,0,0,0,15,7);
INSERT INTO `yishu_website` VALUES (21,2,'书法视野','http://cn.cl2000.com/','','2009-07-16 14:37:40',200,1,0,0,0,25,6);
INSERT INTO `yishu_website` VALUES (22,2,'中国篆刻论坛','http://www.zgzkw.com/','','2009-07-16 14:38:18',210,1,0,0,0,14,7);
INSERT INTO `yishu_website` VALUES (23,2,'中国书法简史','http://www.cc5000.com/','','2009-07-16 14:38:27',220,1,0,0,0,15,13);
INSERT INTO `yishu_website` VALUES (24,2,'华夏艺术网','http://www.artsweb.com.cn/','','2009-07-16 14:39:10',230,1,0,0,0,15,6);
INSERT INTO `yishu_website` VALUES (25,1,'美术家网','http://www.shw.cn/','','2009-07-16 14:39:37',10,1,0,0,0,16,27);
INSERT INTO `yishu_website` VALUES (26,1,'美术同盟','http://arts.tom.com/','','2009-07-16 14:39:43',20,1,1,1,0,16,22);
INSERT INTO `yishu_website` VALUES (27,15,'中国美术学院','http://www.chinaacademyofart.com/','','2009-07-16 14:39:54',30,1,0,0,0,21,17);
INSERT INTO `yishu_website` VALUES (28,17,'中国美术家协会','http://www.caan.cn/','','2009-07-16 14:40:01',40,1,0,0,0,17,17);
INSERT INTO `yishu_website` VALUES (29,1,'雅客艺术','http://www.yahqq.com/','','2009-07-16 14:40:18',50,1,0,0,0,18,24);
INSERT INTO `yishu_website` VALUES (30,1,'美术中国','http://www.art86.cn/','','2009-07-16 14:41:25',60,1,0,0,0,18,7);
INSERT INTO `yishu_website` VALUES (31,15,'清华大学美术学院','http://ad.tsinghua.edu.cn/','','2009-07-16 14:41:37',40,1,0,0,0,16,8);
INSERT INTO `yishu_website` VALUES (32,3,'中华美术网','http://www.ieshu.com/','','2009-07-16 14:41:45',80,-1,0,0,0,3,2);
INSERT INTO `yishu_website` VALUES (33,15,'山东工艺美术学院','http://www.sdada.edu.cn/','','2009-07-16 14:42:01',300,1,0,0,0,14,8);
INSERT INTO `yishu_website` VALUES (34,1,'美术在线','http://arts.cnool.net/','','2009-07-16 14:42:11',100,1,0,0,0,14,5);
INSERT INTO `yishu_website` VALUES (35,15,'鲁迅美术学院','http://www.lumei.edu.cn/','','2009-07-16 14:42:34',60,1,0,0,0,16,9);
INSERT INTO `yishu_website` VALUES (36,15,'四川美术学院','http://www.scfai.edu.cn/','','2009-07-16 14:42:53',50,1,0,0,0,31,13);
INSERT INTO `yishu_website` VALUES (37,5,'新华网-书画频道','http://www.xinhuanet.com/','','2009-07-16 14:44:34',130,1,0,0,0,15,7);
INSERT INTO `yishu_website` VALUES (38,7,'油画第一网','http://www.dafen.net/','','2009-07-16 14:44:48',140,1,0,0,0,16,11);
INSERT INTO `yishu_website` VALUES (39,5,'中国画家网','http://www.chinesepainternet.com/','','2009-07-16 14:45:01',150,1,0,0,0,16,13);
INSERT INTO `yishu_website` VALUES (40,18,'中国少儿美术教育网','http://www.ccartedu.com/','','2009-07-16 14:45:17',160,1,0,0,0,18,7);
INSERT INTO `yishu_website` VALUES (41,15,'西安美术学院','http://www.xafa.edu.cn/','','2009-07-16 14:45:28',80,1,0,0,0,22,6);
INSERT INTO `yishu_website` VALUES (42,15,'天津美术学院','http://www.tjarts.edu.cn/','','2009-07-16 14:45:38',70,1,0,0,0,15,9);
INSERT INTO `yishu_website` VALUES (43,1,'荣宝斋中国美术网','http://www.rbzarts.com/','','2009-07-16 14:45:50',190,1,0,0,0,16,9);
INSERT INTO `yishu_website` VALUES (44,15,'湖北美术学院','http://www.hifa.edu.cn/','','2009-07-16 14:46:01',110,1,0,0,0,13,7);
INSERT INTO `yishu_website` VALUES (45,3,'中青网-美术画廊','http://www.cycnet.com/','','2009-07-16 14:46:12',210,-1,0,0,0,2,3);
INSERT INTO `yishu_website` VALUES (46,18,'中国美术教育信息网','http://www.arteduinfo.com/','','2009-07-16 14:48:25',220,1,0,0,0,16,7);
INSERT INTO `yishu_website` VALUES (47,3,'中国美术家论坛','http://www.zgart.net/','','2009-07-16 14:48:33',230,-1,0,0,0,12,8);
INSERT INTO `yishu_website` VALUES (48,15,'中央美术学院','http://www.cafa.com.cn/','','2009-07-16 14:48:46',20,1,0,0,0,15,7);
INSERT INTO `yishu_website` VALUES (49,6,'西部书画网','http://www.xbsh.net/','','2009-07-16 14:48:56',250,1,0,0,0,19,8);
INSERT INTO `yishu_website` VALUES (50,3,'嘉德在线','http://www.guaweb.com/','','2009-07-16 14:49:04',260,-1,0,0,0,3,2);
INSERT INTO `yishu_website` VALUES (51,18,'江苏美术教育网','http://www.jsmsjy.com/','','2009-07-16 14:49:14',270,1,0,0,0,14,7);
INSERT INTO `yishu_website` VALUES (52,3,'翰文轩','http://www.hwxart.com/','','2009-07-16 14:49:26',280,-1,0,0,0,9,7);
INSERT INTO `yishu_website` VALUES (53,10,'北京画院','http://www.bjaa.com.cn/','','2009-07-16 14:49:35',290,1,0,0,0,16,8);
INSERT INTO `yishu_website` VALUES (54,3,'中国书画网','http://www.cnartist.com/','','2009-07-16 14:49:43',300,-1,0,0,0,5,6);
INSERT INTO `yishu_website` VALUES (55,3,'云鹤斋工作室','http://www.cdyhz.com/','','2009-07-16 14:49:54',310,-1,0,0,0,6,8);
INSERT INTO `yishu_website` VALUES (56,3,'国际在线-文化画廊','http://gb.cri.cn/','','2009-07-16 14:50:03',320,-1,0,0,0,2,3);
INSERT INTO `yishu_website` VALUES (57,3,'美术长廊','http://www.ccnt.com/','','2009-07-16 14:50:10',330,-1,0,0,0,6,6);
INSERT INTO `yishu_website` VALUES (58,1,'中华五千年','http://www.zh5000.com/','','2009-07-16 14:51:43',10,1,0,1,0,17,23);
INSERT INTO `yishu_website` VALUES (59,1,'艺术中国','http://art.china.cn/','艺术中国是国务院新闻办领导的中国互联网新闻中心、中国网旗下的专业艺术媒体。艺术中国以“精典艺术,大家格调,国际视野,主流声音”为宗旨,坚持学术品质,立足高端,面向大众。','2009-07-19 11:47:08',5,1,1,1,1,19,20);
INSERT INTO `yishu_website` VALUES (60,1,'卓克艺术网','http://www.zhuokearts.com/','卓克艺术网是一家领先的互联网在线媒体及增值资讯服务提供商。它以推动中国文化发展为己任，始终致力于向全球华人展示中国艺术及文化企业的风采和魅力。\n        作为中国最大的艺术文化综合门户网站之一，卓克艺术网目前已收录了国内外艺术品拍卖机构500多家，拍卖记录100多万条，著名艺术机构3000多家，包含有6万多名艺术家的市场行情，拥有稳定会员5万多名，日浏览点击量超过百万次。\n','2009-07-19 11:51:54',20,1,1,1,1,18,29);
INSERT INTO `yishu_website` VALUES (61,1,'全球艺术网','http://www.artnet.cn/','全球艺术网 ( www.artnet.cn 或www.artnet.com.cn )创建立于2003年，是一?含艺术品资讯、艺术品收藏、艺术品市场投资分析、海外艺术品动态以及艺术品在线拍卖交易的专业网站，目前它是最强势最专业的艺术品交易交流门户网。','2009-07-19 11:53:30',30,1,1,1,1,20,18);
INSERT INTO `yishu_website` VALUES (62,1,'雅宝网','http://www.yabaoo.com/','雅宝网(http://www.yabaoo.com)通过提供在线媒体及海量艺术资讯，信息整合综合性资讯，在线艺术论坛，艺术品拍卖、鉴定等全面服务于艺术机构、艺术群体和艺术品收藏、鉴赏、投资爱好者，并为艺术品评鉴提供重要标准。\r\n\r\n雅宝网遵循全面、主流、权威、客观、深入的服务理念，将文化艺术，以专业、精准、及时的标准，利用资讯、论坛、交流、交易、搜索等网络平台，有效的拓展学术交流、拍卖收藏、教育研讨等领域，努力打造中国最具价值的“艺术权威网络平台”。','2009-07-19 12:27:25',40,1,1,1,1,22,13);
INSERT INTO `yishu_website` VALUES (64,6,'琉璃厂在线','http://shop.freehead.com/index.php','中国书法网琉璃厂在线','2009-08-16 15:56:35',10,1,0,0,0,33,13);
INSERT INTO `yishu_website` VALUES (65,6,'书法江湖商城','http://shop.sf108.com/','','2009-08-16 15:56:55',20,1,0,0,0,12,13);
INSERT INTO `yishu_website` VALUES (66,6,'嘉德在线－书画、油画、古董、收藏、邮品、艺术品、鉴定、拍卖','http://www.artrade.com/','','2009-08-16 15:57:09',30,-1,0,0,0,12,11);
INSERT INTO `yishu_website` VALUES (67,6,'天天中国艺术品网','http://art.365ccm.com/','','2009-08-16 15:57:22',40,1,0,0,0,16,14);
INSERT INTO `yishu_website` VALUES (68,6,'淘艺网','http://www.taooyi.cn/','','2009-08-16 15:57:35',11,1,0,0,0,19,16);
INSERT INTO `yishu_website` VALUES (69,6,'中国书法超市','http://www.qyx888.com/','','2009-08-16 15:57:49',9,1,0,0,0,13,6);
INSERT INTO `yishu_website` VALUES (70,6,'『绘画作品交易』','http://www.shwbbs.com/','','2009-08-16 15:58:08',70,1,0,0,0,16,8);
INSERT INTO `yishu_website` VALUES (71,6,'书画玩家','http://www.sh518.cc/','','2009-08-16 16:45:25',8,1,0,0,0,16,8);
INSERT INTO `yishu_website` VALUES (72,6,'博宝艺术网','http://www.artxun.com/','','2009-08-16 16:45:56',90,1,0,0,0,14,5);
INSERT INTO `yishu_website` VALUES (73,6,'交艺网','http://www.artronmore.net/','','2009-08-16 16:46:14',100,1,0,0,0,13,8);
INSERT INTO `yishu_website` VALUES (74,6,'艺购网','http://www.art-gou.com/','','2009-08-16 16:46:49',110,1,0,0,0,14,7);
INSERT INTO `yishu_website` VALUES (75,6,'∷ 交易区∷ - 中国在线艺术网论坛','http://bbs.21nowart.com/','','2009-08-16 16:51:00',120,1,0,0,0,14,6);
INSERT INTO `yishu_website` VALUES (76,1,'东方文化艺术网','http://www.eastart.net/','','2009-08-16 16:56:59',50,1,0,0,0,13,5);
INSERT INTO `yishu_website` VALUES (77,1,'古今艺术网','http://www.gujinyishu.com/','','2009-08-16 16:57:45',60,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (78,1,'7080艺术网','http://www.7080art.com/','','2009-08-16 16:58:15',70,1,0,0,0,13,3);
INSERT INTO `yishu_website` VALUES (79,1,'中国艺术博客','http://www.artcn.com/','','2009-08-16 16:58:40',80,1,0,0,0,13,7);
INSERT INTO `yishu_website` VALUES (80,1,'艺术品联合网','http://ysplh.com/','','2009-08-16 16:58:53',90,1,0,0,0,13,5);
INSERT INTO `yishu_website` VALUES (81,1,'99艺术网','http://www.99ys.com/','','2009-08-16 17:28:03',100,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (82,1,'中国艺术品拍卖','http://www.artew.com/','','2009-08-16 17:28:13',110,1,0,0,0,14,4);
INSERT INTO `yishu_website` VALUES (83,1,'中国艺术品','http://www.cnarts.net/','','2009-08-16 17:28:24',120,1,0,0,0,16,4);
INSERT INTO `yishu_website` VALUES (84,1,'宝藏网','http://www.baozang.com/','','2009-08-16 21:52:06',130,1,0,0,0,13,7);
INSERT INTO `yishu_website` VALUES (85,1,'浙江在线??世纪美术','http://art.zjol.com.cn/','','2009-08-16 21:54:16',140,1,0,0,0,12,5);
INSERT INTO `yishu_website` VALUES (86,1,'中国艺术新闻网－Artnews','http://www.artnews.cn/','','2009-08-16 21:55:11',150,1,0,0,0,13,5);
INSERT INTO `yishu_website` VALUES (87,1,'中国当代美术家网','http://www.666969.com/','','2009-08-17 16:09:23',160,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (88,1,'艺展网-首页','http://art.newexpo.com/','','2009-08-17 16:09:43',170,1,0,0,0,13,2);
INSERT INTO `yishu_website` VALUES (89,1,'艺术在线网','http://www.yishu.com/','','2009-08-17 16:11:05',180,1,0,0,0,14,3);
INSERT INTO `yishu_website` VALUES (90,1,'世界艺术品网社区门户','http://www.artokok.com/','','2009-08-17 16:15:00',190,1,0,0,0,14,4);
INSERT INTO `yishu_website` VALUES (91,1,'世界艺术品网社区门户 ART|艺术品|艺品|艺术|工艺品|艺术家|鉴宝|中国首创艺术类社区交流平台','http://www.artokok.com/','','2009-08-17 16:15:00',200,-1,0,0,0,1,0);
INSERT INTO `yishu_website` VALUES (92,1,'世界艺术品网社区门户 ART|艺术品|艺品|艺术|工艺品|艺术家|鉴宝|中国首创艺术类社区交流平台','http://www.artokok.com/','','2009-08-17 16:15:00',210,-1,0,0,0,0,1);
INSERT INTO `yishu_website` VALUES (93,1,'世界艺术品网社区门户 ART|艺术品|艺品|艺术|工艺品|艺术家|鉴宝|中国首创艺术类社区交流平台','http://www.artokok.com/','','2009-08-17 16:15:00',220,-1,0,0,0,1,0);
INSERT INTO `yishu_website` VALUES (94,1,'浙江艺术网','http://www.art-zj.com/','','2009-08-17 16:16:04',230,1,0,0,0,13,7);
INSERT INTO `yishu_website` VALUES (95,1,'艺术中国-中国传统文化和艺术的门户网站 - |收藏拍卖|中国书法|中国国画|国学|中国历史|中国武术|中国戏曲|','http://www.artx.cn/','','2009-08-17 16:16:22',240,-1,0,0,0,1,0);
INSERT INTO `yishu_website` VALUES (96,1,'卓克艺术网 - 中国大型艺术门户网','http://www.zhuokearts.com/','','2009-08-17 16:16:31',250,-1,0,0,0,1,0);
INSERT INTO `yishu_website` VALUES (97,6,'大雅艺术网','http://www.dycc.cc/','','2009-08-17 16:16:52',130,1,0,0,0,15,7);
INSERT INTO `yishu_website` VALUES (98,1,'世界艺术品网社区门户 ART|艺术品|艺品|艺术|工艺品|艺术家|鉴宝|中国首创艺术类社区交流平台','http://www.artokok.com/','','2009-08-17 16:17:07',260,-1,0,0,0,1,1);
INSERT INTO `yishu_website` VALUES (99,1,'世界艺术品网社区门户 ART|艺术品|艺品|艺术|工艺品|艺术家|鉴宝|中国首创艺术类社区交流平台','http://www.artokok.com/','','2009-08-17 16:19:48',270,-1,0,0,0,1,0);
INSERT INTO `yishu_website` VALUES (100,1,'美术中国 ART86.cn 美术网络联盟','http://art86.cn/','','2009-08-17 21:27:13',280,-1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (101,16,'中华收藏网','http://www.sc001.com.cn/','','2009-08-17 21:28:17',50,1,0,0,0,12,8);
INSERT INTO `yishu_website` VALUES (102,4,'Art-Ba-Ba','http://www.art-ba-ba.com/','','2009-08-17 21:30:12',10,1,0,0,0,13,5);
INSERT INTO `yishu_website` VALUES (103,4,'中国艺术个案网','http://www.artgean.com/','','2009-08-17 21:31:13',20,1,0,0,0,13,6);
INSERT INTO `yishu_website` VALUES (104,4,'ArtGuide 艺术概','http://www.artguide.net.cn/','','2009-08-17 21:31:33',30,1,0,0,0,17,6);
INSERT INTO `yishu_website` VALUES (105,1,'世纪在线中国艺术网','http://www.cl2000.com/','','2009-08-17 21:34:00',290,1,0,0,0,13,5);
INSERT INTO `yishu_website` VALUES (106,4,'艺术导报','http://www.mahoo.com.cn/','','2009-08-17 21:35:54',40,1,0,0,0,16,5);
INSERT INTO `yishu_website` VALUES (107,1,'艺术眼 ARTSPY.CN','http://www.artspy.cn/','','2009-08-17 21:36:10',300,1,0,0,0,17,3);
INSERT INTO `yishu_website` VALUES (108,4,'A-BBS.com','http://www.abbs.com.cn/','','2009-08-17 21:39:52',50,1,0,0,0,13,8);
INSERT INTO `yishu_website` VALUES (109,4,'艺术国际','http://www.artintern.net/','','2009-08-17 21:40:47',60,1,0,0,0,12,5);
INSERT INTO `yishu_website` VALUES (110,14,'在艺术网??当代艺术门户 - Powered By arttp','http://www.arttp.com/','','2009-08-17 21:41:22',10,1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (111,4,'在艺术网','http://www.arttp.com/','','2009-08-17 21:41:32',70,1,0,0,0,16,5);
INSERT INTO `yishu_website` VALUES (112,4,'艺术-搜狐文化频道','http://cul.sohu.com/','','2009-08-17 21:42:08',80,1,0,0,0,13,7);
INSERT INTO `yishu_website` VALUES (113,4,'Artmaz-麦子当代艺术网','http://www.artmaz.com/','','2009-08-17 21:43:16',90,1,0,0,0,17,7);
INSERT INTO `yishu_website` VALUES (114,4,'中国艺术在行动','http://www.caaia.com/','','2009-08-17 21:44:21',100,1,0,0,0,13,8);
INSERT INTO `yishu_website` VALUES (115,4,'中国当代艺术网','http://www.artc.net.cn/','','2009-08-17 21:46:33',110,1,0,0,0,15,4);
INSERT INTO `yishu_website` VALUES (116,4,'宋庄当代艺术','http://www.szfeeling.com/','','2009-08-17 21:47:14',120,1,0,0,0,17,8);
INSERT INTO `yishu_website` VALUES (117,4,'ART218艺术网站 - 中国美术学院 展示文化研究中心','http://www.art218.com/','','2009-08-17 21:47:36',130,1,0,0,0,12,6);
INSERT INTO `yishu_website` VALUES (118,4,'| ArtZineChina.com | 中国艺志','http://www.artzinechina.com/','','2009-08-17 21:48:37',140,1,0,0,0,15,7);
INSERT INTO `yishu_website` VALUES (119,4,'中国当代艺术第一门户-东方视觉iONLY.com.cn','http://www.ionly.com.cn/','','2009-08-17 21:49:58',150,1,0,0,0,15,6);
INSERT INTO `yishu_website` VALUES (120,4,'艺术先锋网','http://www.chn-art.com/','','2009-08-17 21:50:10',160,1,0,0,0,13,8);
INSERT INTO `yishu_website` VALUES (121,4,'网易??尖锋艺术','http://tech.163.com/','','2009-08-17 21:50:37',170,1,0,0,0,14,5);
INSERT INTO `yishu_website` VALUES (122,21,'上海煌杰画廊','http://www.hjgallery.com/','','2009-08-17 21:51:32',50,1,0,0,0,12,9);
INSERT INTO `yishu_website` VALUES (123,21,'杭州方向','http://www.directart.com.cn/','','2009-08-17 21:51:48',60,1,0,0,0,13,7);
INSERT INTO `yishu_website` VALUES (124,21,'萨奇画廊','http://www.saatchi-gallery.co.uk/','','2009-08-17 21:52:15',70,1,0,0,0,13,6);
INSERT INTO `yishu_website` VALUES (125,21,'晓荷艺术画廊','http://www.arts8.net.cn/','','2009-08-17 21:52:43',80,1,0,0,0,12,8);
INSERT INTO `yishu_website` VALUES (126,21,'浙江名家书画网','http://www.0575h.com/','','2009-08-17 21:53:33',90,1,0,0,0,13,7);
INSERT INTO `yishu_website` VALUES (127,16,'盛世收藏','http://www.sssc.cn/','','2009-08-17 21:54:38',20,1,0,0,0,12,8);
INSERT INTO `yishu_website` VALUES (128,16,'收藏_新浪财经','http://finance.sina.com.cn/','','2009-08-17 21:54:55',40,1,0,0,0,12,6);
INSERT INTO `yishu_website` VALUES (129,16,'中国收藏网','http://www.socang.com/','','2009-08-17 21:55:10',30,1,0,0,0,14,7);
INSERT INTO `yishu_website` VALUES (130,16,'中国收藏网收藏爱好者的网上家园！','http://www.shoucang.com/','','2009-08-17 21:55:25',50,-1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (131,16,'收藏_新浪财经_新浪网','http://finance.sina.com.cn/','','2009-08-17 21:55:37',60,-1,0,0,0,13,8);
INSERT INTO `yishu_website` VALUES (132,11,'收藏--《北京商报》','http://www.bbtnews.com.cn/','','2009-08-17 21:56:25',10,1,0,0,0,15,6);
INSERT INTO `yishu_website` VALUES (133,16,'收藏投资','http://www.chinasecurities.com.cn/','','2009-08-17 21:57:15',70,1,0,0,0,12,2);
INSERT INTO `yishu_website` VALUES (134,10,'上海油画雕塑院','http://www.youdiao.com.cn/','','2009-08-17 21:57:37',300,1,0,0,0,13,6);
INSERT INTO `yishu_website` VALUES (135,16,'浙江省中国人物画研究会','http://www.zgrwh.com/','','2009-08-17 21:57:46',80,-1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (136,10,'浙江省中国人物画研究会','http://www.zgrwh.com/','','2009-08-17 22:23:01',310,1,0,0,0,16,5);
INSERT INTO `yishu_website` VALUES (137,1,'博艺网','http://www.boyie.com/','','2009-08-26 11:39:40',310,1,1,0,0,12,9);
INSERT INTO `yishu_website` VALUES (138,19,'朵云轩','http://www.duoyunxuan.com/','','2009-08-26 12:00:42',7,1,0,0,0,13,9);
INSERT INTO `yishu_website` VALUES (139,20,'德国联邦艺术及展览馆','http://www.kah-bonn.de/','','2009-08-26 12:06:00',51,1,0,0,0,12,5);
INSERT INTO `yishu_website` VALUES (140,20,'俄罗斯冬宫博物馆','http://www.hermitagemuseum.org/','','2009-08-26 12:06:26',61,1,0,0,0,16,9);
INSERT INTO `yishu_website` VALUES (141,20,'梵蒂冈博物馆','http://mv.vatican.va/','','2009-08-26 12:10:26',30,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (142,20,'法国奥赛美术馆','http://www.musee-orsay.fr/','','2009-08-26 12:12:06',40,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (143,20,'凡尔赛宫','http://en.chateauversailles.fr/homepage','','2009-08-26 12:13:01',50,1,0,0,0,4,4);
INSERT INTO `yishu_website` VALUES (144,20,'乌菲兹美术馆','http://www.uffizi.it/','','2009-08-26 12:14:50',60,1,0,0,0,12,3);
INSERT INTO `yishu_website` VALUES (145,20,'蓬皮杜现代艺术中心','http://www.centrepompidou.fr/','','2009-08-26 12:16:14',70,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (146,20,'荷兰国立美术馆','http://www.rijksmuseum.nl/','','2009-08-26 13:14:13',80,1,0,0,0,13,3);
INSERT INTO `yishu_website` VALUES (147,20,'维多莉亚艾伯特美术馆','http://www.vam.ac.uk/','','2009-08-26 13:15:10',90,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (148,20,'匈牙利布达佩斯国立博物馆','http://www.hnm.hu/','','2009-08-26 13:15:57',100,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (149,15,'南京艺术学院','http://www.njarti.edu.cn/','','2009-08-26 13:55:09',120,1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (150,15,'欢迎进入天津美术学院-首页','http://www.tjarts.edu.cn/','','2009-08-26 13:57:03',260,-1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (151,20,'国立瑞士博物馆','http://www.musee-suisse.ch/','','2009-08-26 14:12:54',110,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (152,20,'奥地利美术馆','http://www.belvedere.at/','','2009-08-26 14:13:22',120,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (153,20,'保加利亚国家历史博物馆','http://www.historymuseum.org/','','2009-08-26 14:15:38',130,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (154,20,'布达佩斯艺术馆','http://www.mucsarnok.hu/','','2009-08-26 14:16:09',140,1,0,0,0,13,6);
INSERT INTO `yishu_website` VALUES (155,20,'美国国家艺术馆','http://www.americanart.si.edu/','','2009-08-26 14:17:21',150,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (156,20,'路易斯安娜现代美术馆','http://www.louisiana.dk/','','2009-08-26 14:17:56',160,1,0,0,0,11,4);
INSERT INTO `yishu_website` VALUES (157,20,'芬兰国家艺廊','http://www.fng.fi/','','2009-08-26 14:18:25',170,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (158,20,'爱尔兰国家艺廊','http://www.nationalgallery.ie/','','2009-08-26 14:19:26',180,1,0,0,0,13,3);
INSERT INTO `yishu_website` VALUES (159,20,'维多利亚艾伯特美术馆','http://www.vam.ac.uk/','','2009-08-26 14:20:26',190,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (160,20,'白金汉宫','http://www.royal.gov.uk/','','2009-08-26 14:21:00',9,1,0,0,0,12,3);
INSERT INTO `yishu_website` VALUES (161,20,'皇家艺术学院','http://www.royalacademy.org.uk/','','2009-08-26 14:21:50',210,1,0,0,0,10,4);
INSERT INTO `yishu_website` VALUES (162,20,'英国皇宫','http://www.hrp.org.uk/','','2009-08-26 14:22:11',220,1,0,0,0,13,2);
INSERT INTO `yishu_website` VALUES (163,20,'英国皇宫(含伦敦塔等)','http://www.hrp.org.uk/','','2009-08-26 14:22:14',230,-1,0,0,0,12,8);
INSERT INTO `yishu_website` VALUES (164,20,'伦敦自然历史博物馆','http://www.nhm.ac.uk/','','2009-08-26 14:22:46',240,1,0,0,0,11,4);
INSERT INTO `yishu_website` VALUES (165,20,'伦敦博物馆','http://www.museumoflondon.org.uk/','','2009-08-26 14:23:05',250,1,0,0,0,12,2);
INSERT INTO `yishu_website` VALUES (166,20,'泰德美术馆','http://www.tate.org.uk/','','2009-08-26 14:23:43',260,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (167,20,'国家肖像画廊','http://www.npg.org.uk/','','2009-08-26 14:25:47',270,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (168,20,'国家艺廊','http://www.nationalgallery.org.uk/','','2009-08-26 14:26:18',280,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (169,20,'苏格兰国立博物馆','http://www.nms.ac.uk/','','2009-08-26 14:26:53',290,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (170,20,'非洲艺术博物馆','http://www.afrikamuseum.nl/','','2009-08-26 14:27:21',300,1,0,0,0,14,4);
INSERT INTO `yishu_website` VALUES (171,20,'比利时皇家美术馆','http://www.fine-arts-museum.be/','','2009-08-26 14:28:24',310,1,0,0,0,13,5);
INSERT INTO `yishu_website` VALUES (172,20,'梵谷美术馆','http://www.vangoghmuseum.nl/','','2009-08-26 14:28:47',320,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (173,20,'皇家军事博物馆','http://www.klm-mra.be/','','2009-08-26 14:29:53',330,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (174,20,'橘园美术馆','http://www.paris-tourism.com/','','2009-08-26 14:30:12',340,1,0,0,0,12,2);
INSERT INTO `yishu_website` VALUES (175,20,'莫奈美术馆','http://www.marmottan.com/','','2009-08-26 14:30:57',350,1,0,0,0,12,6);
INSERT INTO `yishu_website` VALUES (176,20,'罗丹美术馆','http://www.musee-rodin.fr/','','2009-08-26 14:31:25',360,1,0,0,0,13,2);
INSERT INTO `yishu_website` VALUES (177,20,'班贝基金会','http://www.fondation-bemberg.fr/','','2009-08-26 14:31:45',370,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (178,20,'(旧)慕尼黑美术馆','http://www.artechock.de/','','2009-08-26 14:32:27',380,1,0,0,0,13,2);
INSERT INTO `yishu_website` VALUES (179,20,'(新)慕尼黑美术馆','http://www.pinakothek.de/','','2009-08-26 14:32:52',390,1,0,0,0,13,3);
INSERT INTO `yishu_website` VALUES (180,20,'慕尼黑科学博物馆','http://www.deutsches-museum.de/','','2009-08-26 14:33:16',400,1,0,0,0,13,6);
INSERT INTO `yishu_website` VALUES (181,20,'柏林国立美术馆','http://www.smb.spk-berlin.de/','','2009-08-26 14:33:38',410,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (182,20,'德国柏林老美术馆','http://www.smb.museum/','','2009-08-26 14:34:33',420,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (183,20,'包豪斯美术馆','http://www.bauhaus.de/','','2009-08-26 14:34:54',430,1,0,0,0,20,4);
INSERT INTO `yishu_website` VALUES (184,20,'柏林古根汉美术馆','http://www.deutsche-guggenheim-berlin.de/','','2009-08-26 14:35:21',440,1,0,0,0,14,3);
INSERT INTO `yishu_website` VALUES (185,20,'科隆路易博物馆','http://www.museenkoeln.de/','','2009-08-26 14:35:38',450,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (186,20,'卢浮宫','http://www.louvre.fr/','','2009-08-26 22:06:04',8,1,0,0,0,11,4);
INSERT INTO `yishu_website` VALUES (187,15,'中央美术学院 欢迎您！','http://www.cafa.edu.cn/','','2009-08-26 22:09:45',270,-1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (188,15,'广州美术学院','http://www.gzarts.edu.cn/','','2009-08-26 22:13:57',100,1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (189,9,'雕塑中国','http://www.dszg.com/','','2009-08-28 14:33:27',10,1,0,0,0,9,3);
INSERT INTO `yishu_website` VALUES (190,9,'中国雕塑网','http://www.diaosu.cn/','','2009-08-28 14:33:40',20,1,0,0,0,10,2);
INSERT INTO `yishu_website` VALUES (191,9,'雕塑在线','http://www.diaosunet.com/','','2009-08-28 14:33:51',30,1,0,0,0,11,5);
INSERT INTO `yishu_website` VALUES (192,9,'雅昌雕塑网','http://sculpture.artron.net/','','2009-08-28 14:34:13',40,1,0,0,0,11,4);
INSERT INTO `yishu_website` VALUES (193,9,'中国雕塑设计艺术网','http://www.diasu.cn/','','2009-08-28 14:35:23',70,1,0,0,0,11,3);
INSERT INTO `yishu_website` VALUES (194,9,'西部雕塑网','http://www.xbarts.com/','','2009-08-28 14:35:43',60,1,0,0,0,10,4);
INSERT INTO `yishu_website` VALUES (195,21,'上海大剧院画廊','http://www.aagalaxy.com.cn/','','2009-08-28 14:41:46',100,1,0,0,0,11,6);
INSERT INTO `yishu_website` VALUES (196,1,'中国美术（英文版）','http://www.artscenechina.com/','','2009-08-28 14:43:32',320,1,0,0,0,4,1);
INSERT INTO `yishu_website` VALUES (197,1,'今日艺术','http://www.artstoday.com/','','2009-08-28 14:47:52',330,1,0,0,0,6,1);
INSERT INTO `yishu_website` VALUES (198,21,'第一艺术网','http://www.no1art.com.cn/','','2009-08-28 14:53:53',110,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (199,17,'中国美术馆','http://www.namoc.org/','','2009-08-28 14:54:08',50,1,0,0,0,10,6);
INSERT INTO `yishu_website` VALUES (200,17,'中国风现代美术馆','http://artchina.com.cn/','','2009-08-28 14:54:34',60,1,0,0,0,14,5);
INSERT INTO `yishu_website` VALUES (201,17,'上海美术馆','http://www.sh-artmuseum.org.cn/','','2009-08-28 15:01:45',70,1,0,0,0,14,4);
INSERT INTO `yishu_website` VALUES (202,17,'河南博物院','http://www.chnmus.net/','','2009-08-28 15:06:34',80,1,0,0,0,14,3);
INSERT INTO `yishu_website` VALUES (203,17,'秦始皇兵马俑博物馆','http://www.bmy.com.cn/','','2009-08-28 15:08:22',90,1,0,0,0,12,3);
INSERT INTO `yishu_website` VALUES (204,17,'中国国家博物馆网站','http://www.chnmuseum.cn/','','2009-08-28 15:09:05',100,1,0,0,0,9,3);
INSERT INTO `yishu_website` VALUES (205,17,'南京博物院','http://www.njmuseum.com/','','2009-08-28 15:11:04',110,1,0,0,0,12,2);
INSERT INTO `yishu_website` VALUES (206,6,'阳光艺术网','http://www.letart.com/','','2009-08-28 15:14:45',260,1,0,0,0,10,2);
INSERT INTO `yishu_website` VALUES (207,21,'北京大千画廊','http://www.daqiangallery.com.cn/','','2009-08-28 15:17:33',120,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (208,21,'艺博画廊','http://www.yibo-art.com/','','2009-08-28 15:19:53',130,1,0,0,0,11,4);
INSERT INTO `yishu_website` VALUES (209,5,'中国画林','http://www.cnpf.net/','','2009-08-28 15:36:22',160,1,0,0,0,9,5);
INSERT INTO `yishu_website` VALUES (210,1,'欢迎光临中国艺苑网','http://www.china-gallery.com/','','2009-08-28 15:46:52',340,1,0,0,0,7,2);
INSERT INTO `yishu_website` VALUES (211,10,'苏州画院','http://www.sz-art.com/','','2009-08-28 15:47:43',320,1,0,0,0,7,5);
INSERT INTO `yishu_website` VALUES (212,1,'华艺网','http://www.yishujie.com/','','2009-08-28 15:48:20',350,1,0,0,0,6,1);
INSERT INTO `yishu_website` VALUES (213,1,'荣宝斋美术网','http://www.rbzarts.com/','','2009-08-28 15:56:35',360,1,0,0,0,6,2);
INSERT INTO `yishu_website` VALUES (214,1,'荣宝斋美术网','http://www.rbzarts.com/','','2009-08-28 15:56:37',370,1,0,0,0,7,2);
INSERT INTO `yishu_website` VALUES (215,16,'中国画收藏网','http://www.cpcart.com/','','2009-08-28 15:58:23',90,1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (216,1,'中国美术家','http://www.meishujia.cn/','','2009-08-28 15:59:59',380,1,0,0,0,5,2);
INSERT INTO `yishu_website` VALUES (217,5,'中国文艺--国画','http://www.wenyi.com/','','2009-08-28 16:05:50',170,1,0,0,0,10,4);
INSERT INTO `yishu_website` VALUES (218,5,'中国画院画家网画家网','http://www.cnart.biz/','','2009-08-28 16:20:35',180,1,0,0,0,10,5);
INSERT INTO `yishu_website` VALUES (219,8,'何水法','http://www.hsf88.com/','','2009-08-28 16:22:50',10,1,0,0,0,12,6);
INSERT INTO `yishu_website` VALUES (220,8,'李苦禅','http://www.likuchan.com/','','2009-08-28 16:23:06',20,1,0,0,0,9,7);
INSERT INTO `yishu_website` VALUES (221,8,'陈运权','http://www.cyq99.com/','','2009-08-28 16:24:26',30,1,0,0,0,10,5);
INSERT INTO `yishu_website` VALUES (222,11,'艺术新闻','http://www.cansart.com.tw/','','2009-08-28 16:41:08',20,1,0,0,0,11,8);
INSERT INTO `yishu_website` VALUES (223,13,'?????院','http://www.artgate.com.tw/','','2009-08-28 16:49:26',10,1,0,0,0,11,7);
INSERT INTO `yishu_website` VALUES (224,11,'艺术沙龙','http://www.artsalon.cn/','','2009-08-28 16:56:02',30,1,0,0,0,13,6);
INSERT INTO `yishu_website` VALUES (225,22,'人民美术出版社','http://www.renmei.com.cn/','','2009-08-28 16:57:07',10,1,0,0,0,12,5);
INSERT INTO `yishu_website` VALUES (226,1,'精拍艺术网','http://www.jingp.com/','','2009-08-28 17:04:41',390,1,0,0,0,6,2);
INSERT INTO `yishu_website` VALUES (227,1,'拍联艺术网','http://www.plys.cn/','','2009-08-28 17:05:18',400,1,0,0,0,6,1);
INSERT INTO `yishu_website` VALUES (228,6,'淘艺网','http://www.taooyi.cn/','','2009-08-28 17:05:42',270,1,0,0,0,9,3);
INSERT INTO `yishu_website` VALUES (229,19,'中国嘉德','http://www.cguardian.com/','','2009-08-28 17:07:47',5,1,0,0,0,10,4);
INSERT INTO `yishu_website` VALUES (230,17,'首都博物馆','http://www.capitalmuseum.org.cn/','','2009-08-28 17:09:47',120,1,0,0,0,9,2);
INSERT INTO `yishu_website` VALUES (231,17,'中国油画学会','http://www.chinaops.org/','','2009-08-28 17:10:08',130,1,0,0,0,13,2);
INSERT INTO `yishu_website` VALUES (232,19,'北京长风','http://www.chieftown.com/','','2009-08-28 17:10:42',30,1,0,0,0,8,2);
INSERT INTO `yishu_website` VALUES (233,19,'北京保利','http://www.polypm.com.cn/','','2009-08-28 17:11:05',6,1,0,0,0,11,6);
INSERT INTO `yishu_website` VALUES (234,19,'佳士得','http://www.christies.com/','','2009-08-28 17:14:03',1,1,0,0,0,9,5);
INSERT INTO `yishu_website` VALUES (235,19,'苏富比','http://www.sothebys.com/','','2009-08-28 17:19:14',2,1,0,0,0,11,3);
INSERT INTO `yishu_website` VALUES (236,15,'中国艺术研究院','http://www.zgysyjy.org.cn/','','2009-08-28 17:27:13',310,1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (237,15,'集美大学艺术学院','http://art.jmu.edu.cn/','','2009-08-28 17:30:18',320,1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (238,20,'威尼斯古根汉美术馆','http://www.guggenheim-venice.it/','','2009-08-29 08:25:58',140,1,0,0,0,11,5);
INSERT INTO `yishu_website` VALUES (239,20,'乌菲滋美术馆','http://www.uffizi.it/','','2009-08-29 08:26:39',150,1,0,0,0,12,2);
INSERT INTO `yishu_website` VALUES (240,20,'布雷拉美术馆','http://www.brera.beniculturali.it/','','2009-08-29 08:28:17',460,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (241,20,'匈牙利国家博物馆','http://www.hnm.hu/','','2009-08-29 08:28:39',470,1,0,0,0,8,3);
INSERT INTO `yishu_website` VALUES (242,20,'奥地利贝尔弗第宫美术馆','http://www.belvedere.at/','','2009-08-29 08:29:43',480,1,0,0,0,11,4);
INSERT INTO `yishu_website` VALUES (243,20,'慕夏美术馆','http://www.mucha.cz/','','2009-08-29 08:52:42',490,1,0,0,0,10,3);
INSERT INTO `yishu_website` VALUES (244,20,'维也纳艺术史博物馆','http://www.khm.at/','','2009-08-29 08:53:50',500,1,0,0,0,11,4);
INSERT INTO `yishu_website` VALUES (245,20,'布拉格国家美术馆','http://www.ngprague.cz/','','2009-08-29 08:54:27',510,1,0,0,0,12,5);
INSERT INTO `yishu_website` VALUES (246,20,'加纳达基金会','http://www.gianadda.ch/','','2009-08-29 08:55:13',520,1,0,0,0,13,5);
INSERT INTO `yishu_website` VALUES (247,20,'拜勒基金会','http://www.beyeler.com/','','2009-08-29 08:55:41',530,1,0,0,0,11,3);
INSERT INTO `yishu_website` VALUES (248,20,'汉堡艺术馆','http://www.hamburger-kunsthalle.de/','','2009-08-29 08:56:41',540,1,0,0,0,8,5);
INSERT INTO `yishu_website` VALUES (249,20,'汉堡艺术及手工艺博物馆','http://www.mkg-hamburg.de/','','2009-08-29 08:57:06',550,1,0,0,0,10,5);
INSERT INTO `yishu_website` VALUES (250,20,'斯图卡特国家艺廊','http://www.staatsgalerie.de/','','2009-08-29 08:57:45',560,1,0,0,0,14,2);
INSERT INTO `yishu_website` VALUES (251,20,'罗马日耳曼历史博物馆','http://www.museenkoeln.de/','','2009-08-29 08:58:08',570,1,0,0,0,17,4);
INSERT INTO `yishu_website` VALUES (252,20,'科隆路易博物馆','http://www.museenkoeln.de/','','2009-08-29 08:59:15',580,-1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (253,1,'中华书画网','http://www.zhshw.com/','','2009-08-29 09:29:13',410,1,0,0,0,7,2);
INSERT INTO `yishu_website` VALUES (254,20,'CGFA-艺术史','http://cgfa.dotsrc.org/','','2009-08-29 09:31:58',590,1,0,0,0,11,5);
INSERT INTO `yishu_website` VALUES (255,17,'北京故宫','http://www.dpm.org.cn/','','2009-08-29 09:35:49',140,1,0,0,0,10,3);
INSERT INTO `yishu_website` VALUES (256,17,'纽约现代艺术馆','http://www.moma.org/','','2009-08-29 09:37:58',150,1,0,0,0,12,3);
INSERT INTO `yishu_website` VALUES (257,20,'Glubibulgà插画','http://www.slap-press.com/','','2009-08-29 09:39:48',600,1,0,0,0,11,3);
INSERT INTO `yishu_website` VALUES (258,20,'光州双年展','http://www.gwangju-biennale.org/','','2009-08-29 09:43:21',610,1,0,0,0,12,7);
INSERT INTO `yishu_website` VALUES (259,20,'artnet世界艺术在线 ','http://www.artnet.com/','','2009-08-29 09:46:56',620,1,0,0,0,8,2);
INSERT INTO `yishu_website` VALUES (260,20,'纽约摄影学院','http://www.nyip.com/','','2009-08-29 09:48:06',630,1,0,0,0,12,5);
INSERT INTO `yishu_website` VALUES (261,20,'卡塞尔文献展','http://www.documenta.de/','','2009-08-29 09:49:55',640,1,0,0,0,12,3);
INSERT INTO `yishu_website` VALUES (262,20,'里昂双年展','http://www.biennale-de-lyon.org/','','2009-08-29 09:51:37',650,1,0,0,0,10,4);
INSERT INTO `yishu_website` VALUES (263,20,'伦敦双年展','http://www.marisol.co.uk/','','2009-08-29 09:53:35',660,1,0,0,0,12,3);
INSERT INTO `yishu_website` VALUES (264,20,'日本横滨三年展','http://www.jpf.go.jp/','','2009-08-29 09:55:08',670,1,0,0,0,11,4);
INSERT INTO `yishu_website` VALUES (265,20,'伊斯坦布尔双年展','http://www.iksv.org/','','2009-08-29 09:55:46',680,1,0,0,0,9,4);
INSERT INTO `yishu_website` VALUES (266,20,'秘鲁利马双年展','http://e.busca.uol.com.br/','','2009-08-29 09:56:23',690,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (267,20,'西班牙巴伦西亚双年展','http://www.bienaldevalencia.com/','','2009-08-29 09:58:13',700,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (268,20,'多伦多CAB双年展','http://www.aspacegallery.org/','','2009-08-29 09:58:39',710,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (269,20,'南非约翰内斯堡双年展','http://www.camwood.org/','','2009-08-29 09:59:25',720,1,0,0,0,7,5);
INSERT INTO `yishu_website` VALUES (270,20,'德国柏林双年展','http://www.berlinbiennale.de/','','2009-08-29 10:00:06',730,1,0,0,0,9,4);
INSERT INTO `yishu_website` VALUES (271,20,'加拿大蒙特利尔双年展','http://www.ciac.ca/','','2009-08-29 10:00:35',740,1,0,0,0,13,5);
INSERT INTO `yishu_website` VALUES (272,20,'澳大利亚悉尼双年展','http://www.biennaleofsydney.com.au/','','2009-08-29 10:01:11',750,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (273,20,'古巴哈瓦纳双年展','http://www.universes-in-universe.de/','','2009-08-29 10:01:39',760,1,0,0,0,13,5);
INSERT INTO `yishu_website` VALUES (274,20,'巴黎国立网球场现代美术馆 ','http://www.jeudepaume.org/','','2009-08-29 10:03:13',770,1,0,0,0,11,12);
INSERT INTO `yishu_website` VALUES (275,20,'法国里昂当代艺术馆','http://www.mac-lyon.com/','','2009-08-29 10:04:15',780,1,0,0,0,10,3);
INSERT INTO `yishu_website` VALUES (276,20,'法国尼斯当代艺术馆 ','http://www.mamac-nice.org/','','2009-08-29 10:05:35',160,1,0,0,0,12,5);
INSERT INTO `yishu_website` VALUES (277,20,'法国格勒诺布尔美术馆','http://www.ville-grenoble.fr/','','2009-08-29 10:05:55',790,1,0,0,0,9,1);
INSERT INTO `yishu_website` VALUES (278,20,'瑞典斯德哥尔摩现代美术馆','http://www.modernamuseet.se/','','2009-08-29 10:06:27',800,1,0,0,0,13,5);
INSERT INTO `yishu_website` VALUES (279,20,'美国芝加哥当代美术馆','http://www.mcachicago.org/','','2009-08-29 10:07:13',810,1,0,0,0,10,4);
INSERT INTO `yishu_website` VALUES (280,20,'澳大利亚悉尼当代艺术馆','http://www.mca.com.au/','','2009-08-29 10:07:49',820,1,0,0,0,13,3);
INSERT INTO `yishu_website` VALUES (281,20,'蒙特利尔当代艺术中心','http://www.ciac.ca/','','2009-08-29 10:11:01',830,1,0,0,0,9,4);
INSERT INTO `yishu_website` VALUES (282,20,'西班牙巴塞罗纳当代文化中心','http://www.cccb.org/','','2009-08-29 10:11:38',840,1,0,0,0,10,4);
INSERT INTO `yishu_website` VALUES (283,20,'美国DIA中心','http://www.diacenter.org/','','2009-08-29 10:13:04',850,1,0,0,0,11,5);
INSERT INTO `yishu_website` VALUES (284,20,'美国纽约古根海姆美术馆','http://www.guggenheim.org/','','2009-08-29 10:14:02',860,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (285,20,'古根海姆美术馆（西班牙比尔堡） ','http://www.guggenheim-bilbao.es/','','2009-08-29 10:14:50',870,1,0,0,0,11,3);
INSERT INTO `yishu_website` VALUES (286,20,'金山现代艺术博物馆 ','http://www.sfmoma.org/','','2009-08-29 10:17:24',880,1,0,0,0,12,5);
INSERT INTO `yishu_website` VALUES (287,20,'网上博物馆','http://www.webnetmuseum.org/','','2009-08-29 10:20:35',890,1,0,0,0,11,4);
INSERT INTO `yishu_website` VALUES (288,20,'Jodi','http://map.jodi.org/','','2009-08-29 10:24:45',900,1,0,0,0,11,2);
INSERT INTO `yishu_website` VALUES (289,20,'ZKM德国卡尔斯鲁儿艺术和媒体技术中心','http://www.zkm.de/','','2009-08-29 10:30:34',910,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (290,20,'奥地利林兹的未来美术馆','http://www.aec.at/','','2009-08-29 10:32:58',920,1,0,0,0,12,3);
INSERT INTO `yishu_website` VALUES (291,20,'interferences','http://www.interferences.org/','','2009-08-29 10:36:39',930,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (292,20,'德国斯图加特孤独城堡研究院','http://www.akademie-solitude.de/','','2009-08-29 10:37:11',940,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (293,20,'法国卡蒂亚当代艺术基金会','http://fondation.cartier.com/','','2009-08-29 10:38:08',950,1,0,0,0,11,3);
INSERT INTO `yishu_website` VALUES (294,20,'美国古根海姆基金会','http://www.guggenheim.org/','','2009-08-29 10:38:45',960,1,0,0,0,12,3);
INSERT INTO `yishu_website` VALUES (295,20,'巴黎国立高等美术学院','http://www.ensba.fr/','','2009-08-29 10:40:26',970,1,0,0,0,9,4);
INSERT INTO `yishu_website` VALUES (296,20,'法国新文化杂志 ','http://www.technikart.com/','','2009-08-29 10:42:04',980,1,0,0,0,13,2);
INSERT INTO `yishu_website` VALUES (297,23,'火神网','http://www.huoshen.net/','','2009-08-29 10:42:20',10,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (298,23,'火星时代网','http://www.hxsd.com/','','2009-08-29 10:42:51',20,1,0,0,0,13,3);
INSERT INTO `yishu_website` VALUES (299,23,'CG杂志','http://www.newcg.com/','','2009-08-29 10:43:08',30,1,0,0,0,14,4);
INSERT INTO `yishu_website` VALUES (300,23,'点格城市','http://www.diancity.com/','','2009-08-29 10:45:17',40,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (301,13,'设计吧廊 ','http://www.balang88.cn/','','2009-08-29 10:48:04',20,1,0,0,0,10,4);
INSERT INTO `yishu_website` VALUES (302,13,'艺术迷','http://www.fansart.com/','','2009-08-29 10:54:39',30,1,0,0,0,10,4);
INSERT INTO `yishu_website` VALUES (303,8,'邱志杰','http://www.qiuzhijie.com/','','2009-08-29 10:58:48',40,1,0,0,0,10,2);
INSERT INTO `yishu_website` VALUES (304,24,'光圈','http://www.aperture.org/','','2009-08-29 10:59:26',10,1,0,0,0,11,4);
INSERT INTO `yishu_website` VALUES (305,19,'睿芙奥','http://ravenelart.com/','','2009-08-29 11:01:01',40,1,0,0,0,7,2);
INSERT INTO `yishu_website` VALUES (306,19,'北京翰海','http://www.hanhai.net/','','2009-08-29 11:01:14',50,1,0,0,0,8,2);
INSERT INTO `yishu_website` VALUES (307,19,'北京诚轩','http://www.chengxuan.com/','','2009-08-29 11:02:44',60,1,0,0,0,8,3);
INSERT INTO `yishu_website` VALUES (308,19,'北京华辰','http://www.huachenauctions.com/','','2009-08-29 11:03:01',70,1,0,0,0,5,2);
INSERT INTO `yishu_website` VALUES (309,19,'上海泓盛','http://www.hosane.com/','','2009-08-29 11:04:47',80,1,0,0,0,8,2);
INSERT INTO `yishu_website` VALUES (310,6,'竞友网','http://www.bidpal.cn/','','2009-08-29 11:05:32',280,1,0,0,0,11,4);
INSERT INTO `yishu_website` VALUES (311,16,'藏点','http://www.cangdian.com/','','2009-08-29 11:08:41',100,1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (312,24,'色影无忌','http://www.xitek.com/','','2009-08-29 11:12:54',20,1,0,0,0,15,4);
INSERT INTO `yishu_website` VALUES (313,24,'摄影图片','http://www.magnumphotos.com/','','2009-08-29 11:14:37',30,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (314,24,'中国摄影在线','http://www.cphoto.net/','','2009-08-29 11:15:15',40,1,0,0,0,12,2);
INSERT INTO `yishu_website` VALUES (315,24,'中国摄影在线','http://www.cphoto.net/','','2009-08-29 11:15:18',50,1,0,0,0,10,3);
INSERT INTO `yishu_website` VALUES (316,24,'蜂鸟网','http://www.fengniao.com/','','2009-08-29 11:15:59',60,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (317,24,'橡树摄影网','http://www.xiangshu.com/','','2009-08-29 11:16:12',70,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (318,24,'新摄影','http://www.nphoto.net/','','2009-08-29 11:16:58',80,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (319,16,'杭州收藏网','http://www.hzscp.com/','','2009-08-29 11:18:04',110,1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (320,16,'田黄收藏网','http://www.tianhuangweb.com/','','2009-08-29 11:19:29',120,1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (321,16,'徐州收藏网','http://www.xzscw.com/','','2009-08-29 11:19:38',130,1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (322,10,'首页－中国国家画院网','http://www.chinanap.net/','','2009-09-03 11:16:16',330,1,0,0,0,7,6);
INSERT INTO `yishu_website` VALUES (323,10,'杭州吴山书画院','http://www.wsshy.com/','','2009-09-03 11:27:34',340,1,0,0,0,0,0);

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
