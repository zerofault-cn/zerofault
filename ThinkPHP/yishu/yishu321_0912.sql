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

INSERT INTO `yishu_category` VALUES (1,0,'�����Ż�','2009-07-13 23:11:59','2009-08-29 09:29:13',10,1);
INSERT INTO `yishu_category` VALUES (2,0,'�鷨','2009-07-16 14:34:48','2009-07-16 14:39:10',20,1);
INSERT INTO `yishu_category` VALUES (3,0,'����','2009-07-16 14:39:37','2009-07-16 14:50:10',30,-1);
INSERT INTO `yishu_category` VALUES (4,0,'��������','2009-07-19 12:16:19','2009-08-17 21:50:37',40,1);
INSERT INTO `yishu_category` VALUES (5,0,'����','2009-07-19 12:16:32','2009-08-28 16:20:35',50,1);
INSERT INTO `yishu_category` VALUES (6,0,'���߽���','2009-08-16 15:56:15','2009-08-29 11:05:32',60,1);
INSERT INTO `yishu_category` VALUES (7,0,'�ͻ�','2009-08-17 16:19:07','2009-08-17 16:19:07',70,1);
INSERT INTO `yishu_category` VALUES (8,0,'������վ','2009-08-17 16:20:32','2009-08-29 10:58:48',80,1);
INSERT INTO `yishu_category` VALUES (9,0,'����','2009-08-17 16:20:56','2009-08-28 14:35:43',90,1);
INSERT INTO `yishu_category` VALUES (10,0,'��Ժ','2009-08-17 16:21:07','2009-09-03 11:27:34',100,1);
INSERT INTO `yishu_category` VALUES (11,0,'������־','2009-08-17 16:22:08','2009-08-28 16:56:02',95,1);
INSERT INTO `yishu_category` VALUES (12,0,'չ��','2009-08-17 16:22:48','2009-08-17 16:22:48',150,1);
INSERT INTO `yishu_category` VALUES (13,0,'���','2009-08-17 16:22:58','2009-08-29 10:54:39',130,1);
INSERT INTO `yishu_category` VALUES (14,0,'','2009-08-17 16:23:08','2009-08-17 16:23:08',140,-1);
INSERT INTO `yishu_category` VALUES (15,0,'ԺУ','2009-08-17 16:24:03','2009-08-28 17:30:18',120,1);
INSERT INTO `yishu_category` VALUES (16,0,'�ղ�','2009-08-17 16:25:58','2009-08-29 11:19:38',160,1);
INSERT INTO `yishu_category` VALUES (17,0,'��������','2009-08-17 17:31:36','2009-08-29 08:26:39',105,1);
INSERT INTO `yishu_category` VALUES (18,0,'����','2009-08-17 21:25:16','2009-08-17 21:25:16',180,1);
INSERT INTO `yishu_category` VALUES (19,0,'������','2009-08-26 12:00:18','2009-08-29 11:03:01',135,1);
INSERT INTO `yishu_category` VALUES (20,0,'������վ','2009-08-26 12:02:50','2009-08-29 10:42:04',125,1);
INSERT INTO `yishu_category` VALUES (21,0,'����','2009-08-28 14:51:39','2009-08-28 15:19:53',210,1);
INSERT INTO `yishu_category` VALUES (22,0,'������','2009-08-28 16:56:41','2009-08-28 16:57:07',155,1);
INSERT INTO `yishu_category` VALUES (23,0,'C G','2009-08-29 10:41:41','2009-08-29 10:45:17',230,1);
INSERT INTO `yishu_category` VALUES (24,0,'��Ӱ','2009-08-29 10:51:50','2009-08-29 11:16:58',240,1);
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

INSERT INTO `yishu_comment` VALUES (1,1,'adam','zerofault@gmail.com','125.119.87.135','�ܺú�ǿ��\r\nף��չ׳��','2009-07-16 23:11:18',1);
INSERT INTO `yishu_comment` VALUES (2,1,'zerofault','','125.119.87.135','ɳ��������\r\nֻ�а����','2009-07-16 23:12:50',1);
INSERT INTO `yishu_comment` VALUES (3,1,'����','','125.119.87.135','��ô��Ծ����Ҳ��','2009-07-16 23:24:59',1);
INSERT INTO `yishu_comment` VALUES (4,66,'����','','122.224.130.150','���������','2009-08-17 16:02:06',1);
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

INSERT INTO `yishu_node` VALUES (1,0,'admin','�����̨','��̨������Ŀ',1,0);
INSERT INTO `yishu_node` VALUES (2,1,'User','�û�����','�û�����ģ��',2,0);
INSERT INTO `yishu_node` VALUES (3,1,'Node','�ڵ����','�ڵ����ģ��',2,0);
INSERT INTO `yishu_node` VALUES (4,1,'Role','��ɫ����','��ɫ����ģ��',2,0);
INSERT INTO `yishu_node` VALUES (5,1,'Comment','���۹���','���۹���ģ��',2,0);
INSERT INTO `yishu_node` VALUES (6,2,'index','�б�','',3,0);
INSERT INTO `yishu_node` VALUES (7,4,'index','�б�','',3,0);
INSERT INTO `yishu_node` VALUES (8,1,'Category','�������','',2,0);
INSERT INTO `yishu_node` VALUES (9,8,'index','�б�','',3,0);
INSERT INTO `yishu_node` VALUES (10,8,'add','���','',3,0);
INSERT INTO `yishu_node` VALUES (11,8,'update','����','',3,0);
INSERT INTO `yishu_node` VALUES (12,8,'delete','ɾ��','',3,0);
INSERT INTO `yishu_node` VALUES (13,1,'Site','��վ����','',2,0);
INSERT INTO `yishu_node` VALUES (14,13,'index','�б�','',3,0);
INSERT INTO `yishu_node` VALUES (15,3,'index','�б�','',3,0);
INSERT INTO `yishu_node` VALUES (16,5,'update','����','',3,0);
INSERT INTO `yishu_node` VALUES (17,5,'delete','ɾ��','',3,0);
INSERT INTO `yishu_node` VALUES (18,13,'add','���','',3,0);
INSERT INTO `yishu_node` VALUES (19,13,'update','����','',3,0);
INSERT INTO `yishu_node` VALUES (20,13,'delete','ɾ��','',3,0);
INSERT INTO `yishu_node` VALUES (21,1,'Index','Ĭ����ҳ','',2,0);
INSERT INTO `yishu_node` VALUES (22,3,'update','','',3,0);
INSERT INTO `yishu_node` VALUES (23,5,'index','','',3,0);
INSERT INTO `yishu_node` VALUES (24,21,'index','','',3,0);
INSERT INTO `yishu_node` VALUES (25,2,'add','','',3,0);
INSERT INTO `yishu_node` VALUES (26,4,'add','','',3,0);
INSERT INTO `yishu_node` VALUES (27,2,'update','','',3,0);
INSERT INTO `yishu_node` VALUES (28,4,'update','','',3,0);
INSERT INTO `yishu_node` VALUES (29,2,'delete','','',3,0);
INSERT INTO `yishu_node` VALUES (30,4,'delete','','',3,0);
INSERT INTO `yishu_node` VALUES (31,1,'Attach','��������','',2,0);
INSERT INTO `yishu_node` VALUES (32,31,'upload','�ϴ�','',3,0);
INSERT INTO `yishu_node` VALUES (33,2,'edit','','',3,0);
INSERT INTO `yishu_node` VALUES (34,4,'edit','','',3,0);
CREATE TABLE `yishu_role` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `descr` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

INSERT INTO `yishu_role` VALUES (1,'��̨����Ա',1,'��̨����Ա');
INSERT INTO `yishu_role` VALUES (2,'��վ����Ա',1,'��վ����Ա');
INSERT INTO `yishu_role` VALUES (3,'��վ���Ա',1,'�������Ա');
INSERT INTO `yishu_role` VALUES (4,'�������Ա',1,'�������Ա');
INSERT INTO `yishu_role` VALUES (5,'������Ա',1,'������Ա');
INSERT INTO `yishu_role` VALUES (6,'���۹���Ա',1,'���۹���Ա');
INSERT INTO `yishu_role` VALUES (7,'���ۼ��',1,'���ۼ��');
INSERT INTO `yishu_role` VALUES (8,'Ȩ�޹���Ա',1,'Ȩ�޹���Ա');
INSERT INTO `yishu_role` VALUES (9,'Ȩ�޼��',1,'Ȩ�޼��');
INSERT INTO `yishu_role` VALUES (10,'��������Ա',1,'��������Ա');
INSERT INTO `yishu_role` VALUES (11,'���ܲ���Ա',1,'���ܲ���Ա');
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

INSERT INTO `yishu_user` VALUES (1,'admin','ϵͳ����Ա','8891815eda4c6e329348d3a11611a7ba','2009-08-09 19:19:25','2009-09-12 20:57:16',1);
INSERT INTO `yishu_user` VALUES (3,'test','�����û�','e10adc3949ba59abbe56e057f20f883e','2009-08-09 20:18:15','2009-08-16 13:43:25',1);
INSERT INTO `yishu_user` VALUES (4,'test2','�����û�','e10adc3949ba59abbe56e057f20f883e','2009-08-09 20:44:11','2009-08-09 20:56:53',1);
INSERT INTO `yishu_user` VALUES (5,'zaofc','����Ա','9f09ec28f4a2d02b1b9fe57a0ed39aa5','2009-08-16 13:42:38','2009-08-29 08:24:19',1);
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

INSERT INTO `yishu_website` VALUES (1,1,'�Ų�������','http://www.artron.net/','�Ų�������������2000��10�£���Ŀǰȫ���������Ҫ���й�����Ʒ�Ż����ǻ�ȡ������Ѷ����ѡý��ƽ̨��������Ʒ�ղ�Ͷ�ʼ������߲��ɻ�ȱ����Ҫ���ߡ����ѳ�Ϊ��������Ϊ�Ƴ�Ļ�����Ʒ�ơ�\n�Ų���������50���רҵ��Ա��ÿ��800���˴ε�����������й�������Э��chinarank�����ȫ�����Ļ�����������λ��400��֮�С�','2009-07-13 23:20:20',1,1,1,1,1,20,70);
INSERT INTO `yishu_website` VALUES (2,2,'�й��鷨��','http://www.freehead.com/index.php','','2009-07-16 14:34:48',10,1,0,1,0,52,22);
INSERT INTO `yishu_website` VALUES (3,2,'�й��鷨����̳','http://www.zgsfj.com/','','2009-07-16 14:34:56',20,1,0,1,0,17,24);
INSERT INTO `yishu_website` VALUES (4,2,'�鷨����̳','http://www.shufa.org/','','2009-07-16 14:35:04',30,1,0,1,0,16,19);
INSERT INTO `yishu_website` VALUES (5,2,'�鷨������̳','http://www.sf108.com/bbs/index.php','','2009-07-16 14:35:16',40,1,0,1,0,8,21);
INSERT INTO `yishu_website` VALUES (6,2,'����Ӳ���鷨��','http://www.yingbishufa.com/','','2009-07-16 14:35:26',50,1,0,1,0,17,20);
INSERT INTO `yishu_website` VALUES (7,2,'�鷨�ռ�','http://www.9610.com/','','2009-07-16 14:35:32',60,1,0,1,0,18,22);
INSERT INTO `yishu_website` VALUES (8,2,'�鷨��','http://www.shufa.com/','','2009-07-16 14:35:40',70,1,0,1,0,15,8);
INSERT INTO `yishu_website` VALUES (9,2,'�й�Ӳ���鷨������̳','http://bbs.yingbishufa.com/','','2009-07-16 14:35:47',80,1,0,1,0,16,12);
INSERT INTO `yishu_website` VALUES (10,2,'Ӳ���鷨���','http://www.ybsftd.com/','','2009-07-16 14:35:56',90,1,0,1,0,17,13);
INSERT INTO `yishu_website` VALUES (11,2,'�й��鷨��','http://www.china-shufajia.com/','','2009-07-16 14:36:10',100,1,0,1,0,16,5);
INSERT INTO `yishu_website` VALUES (12,2,'�й��黭����','http://www.zgshj.com/','','2009-07-16 14:36:19',110,1,0,0,0,15,8);
INSERT INTO `yishu_website` VALUES (13,2,'�й��鷨����','http://www.zgsf.com.cn/','','2009-07-16 14:36:26',120,1,0,0,0,16,4);
INSERT INTO `yishu_website` VALUES (14,2,'�й��鷨��԰','http://www.eshufa.com/','','2009-07-16 14:36:32',130,1,0,0,0,14,5);
INSERT INTO `yishu_website` VALUES (15,2,'�й��黭֮��','http://www.bookdraw.com/','','2009-07-16 14:36:40',140,1,0,0,0,13,8);
INSERT INTO `yishu_website` VALUES (16,2,'�й��鷨������','http://www.china-shufa.com/','','2009-07-16 14:36:48',150,1,0,0,0,16,8);
INSERT INTO `yishu_website` VALUES (17,2,'�й�Ӳ���鷨������','http://www.ybsf.org/','','2009-07-16 14:37:00',160,1,0,0,0,20,6);
INSERT INTO `yishu_website` VALUES (18,2,'�㽭�鷨��','http://www.zjshufa.com/','','2009-07-16 14:37:09',170,1,0,0,0,20,6);
INSERT INTO `yishu_website` VALUES (19,2,'�й��鷨վ','http://www.chinashufa.com/','','2009-07-16 14:37:16',180,1,0,0,0,20,5);
INSERT INTO `yishu_website` VALUES (20,2,'�鷨չ��','http://www.worldartsexposition.com/','','2009-07-16 14:37:30',190,1,0,0,0,15,7);
INSERT INTO `yishu_website` VALUES (21,2,'�鷨��Ұ','http://cn.cl2000.com/','','2009-07-16 14:37:40',200,1,0,0,0,25,6);
INSERT INTO `yishu_website` VALUES (22,2,'�й�׭����̳','http://www.zgzkw.com/','','2009-07-16 14:38:18',210,1,0,0,0,14,7);
INSERT INTO `yishu_website` VALUES (23,2,'�й��鷨��ʷ','http://www.cc5000.com/','','2009-07-16 14:38:27',220,1,0,0,0,15,13);
INSERT INTO `yishu_website` VALUES (24,2,'����������','http://www.artsweb.com.cn/','','2009-07-16 14:39:10',230,1,0,0,0,15,6);
INSERT INTO `yishu_website` VALUES (25,1,'��������','http://www.shw.cn/','','2009-07-16 14:39:37',10,1,0,0,0,16,27);
INSERT INTO `yishu_website` VALUES (26,1,'����ͬ��','http://arts.tom.com/','','2009-07-16 14:39:43',20,1,1,1,0,16,22);
INSERT INTO `yishu_website` VALUES (27,15,'�й�����ѧԺ','http://www.chinaacademyofart.com/','','2009-07-16 14:39:54',30,1,0,0,0,21,17);
INSERT INTO `yishu_website` VALUES (28,17,'�й�������Э��','http://www.caan.cn/','','2009-07-16 14:40:01',40,1,0,0,0,17,17);
INSERT INTO `yishu_website` VALUES (29,1,'�ſ�����','http://www.yahqq.com/','','2009-07-16 14:40:18',50,1,0,0,0,18,24);
INSERT INTO `yishu_website` VALUES (30,1,'�����й�','http://www.art86.cn/','','2009-07-16 14:41:25',60,1,0,0,0,18,7);
INSERT INTO `yishu_website` VALUES (31,15,'�廪��ѧ����ѧԺ','http://ad.tsinghua.edu.cn/','','2009-07-16 14:41:37',40,1,0,0,0,16,8);
INSERT INTO `yishu_website` VALUES (32,3,'�л�������','http://www.ieshu.com/','','2009-07-16 14:41:45',80,-1,0,0,0,3,2);
INSERT INTO `yishu_website` VALUES (33,15,'ɽ����������ѧԺ','http://www.sdada.edu.cn/','','2009-07-16 14:42:01',300,1,0,0,0,14,8);
INSERT INTO `yishu_website` VALUES (34,1,'��������','http://arts.cnool.net/','','2009-07-16 14:42:11',100,1,0,0,0,14,5);
INSERT INTO `yishu_website` VALUES (35,15,'³Ѹ����ѧԺ','http://www.lumei.edu.cn/','','2009-07-16 14:42:34',60,1,0,0,0,16,9);
INSERT INTO `yishu_website` VALUES (36,15,'�Ĵ�����ѧԺ','http://www.scfai.edu.cn/','','2009-07-16 14:42:53',50,1,0,0,0,31,13);
INSERT INTO `yishu_website` VALUES (37,5,'�»���-�黭Ƶ��','http://www.xinhuanet.com/','','2009-07-16 14:44:34',130,1,0,0,0,15,7);
INSERT INTO `yishu_website` VALUES (38,7,'�ͻ���һ��','http://www.dafen.net/','','2009-07-16 14:44:48',140,1,0,0,0,16,11);
INSERT INTO `yishu_website` VALUES (39,5,'�й�������','http://www.chinesepainternet.com/','','2009-07-16 14:45:01',150,1,0,0,0,16,13);
INSERT INTO `yishu_website` VALUES (40,18,'�й��ٶ�����������','http://www.ccartedu.com/','','2009-07-16 14:45:17',160,1,0,0,0,18,7);
INSERT INTO `yishu_website` VALUES (41,15,'��������ѧԺ','http://www.xafa.edu.cn/','','2009-07-16 14:45:28',80,1,0,0,0,22,6);
INSERT INTO `yishu_website` VALUES (42,15,'�������ѧԺ','http://www.tjarts.edu.cn/','','2009-07-16 14:45:38',70,1,0,0,0,15,9);
INSERT INTO `yishu_website` VALUES (43,1,'�ٱ�ի�й�������','http://www.rbzarts.com/','','2009-07-16 14:45:50',190,1,0,0,0,16,9);
INSERT INTO `yishu_website` VALUES (44,15,'��������ѧԺ','http://www.hifa.edu.cn/','','2009-07-16 14:46:01',110,1,0,0,0,13,7);
INSERT INTO `yishu_website` VALUES (45,3,'������-��������','http://www.cycnet.com/','','2009-07-16 14:46:12',210,-1,0,0,0,2,3);
INSERT INTO `yishu_website` VALUES (46,18,'�й�����������Ϣ��','http://www.arteduinfo.com/','','2009-07-16 14:48:25',220,1,0,0,0,16,7);
INSERT INTO `yishu_website` VALUES (47,3,'�й���������̳','http://www.zgart.net/','','2009-07-16 14:48:33',230,-1,0,0,0,12,8);
INSERT INTO `yishu_website` VALUES (48,15,'��������ѧԺ','http://www.cafa.com.cn/','','2009-07-16 14:48:46',20,1,0,0,0,15,7);
INSERT INTO `yishu_website` VALUES (49,6,'�����黭��','http://www.xbsh.net/','','2009-07-16 14:48:56',250,1,0,0,0,19,8);
INSERT INTO `yishu_website` VALUES (50,3,'�ε�����','http://www.guaweb.com/','','2009-07-16 14:49:04',260,-1,0,0,0,3,2);
INSERT INTO `yishu_website` VALUES (51,18,'��������������','http://www.jsmsjy.com/','','2009-07-16 14:49:14',270,1,0,0,0,14,7);
INSERT INTO `yishu_website` VALUES (52,3,'������','http://www.hwxart.com/','','2009-07-16 14:49:26',280,-1,0,0,0,9,7);
INSERT INTO `yishu_website` VALUES (53,10,'������Ժ','http://www.bjaa.com.cn/','','2009-07-16 14:49:35',290,1,0,0,0,16,8);
INSERT INTO `yishu_website` VALUES (54,3,'�й��黭��','http://www.cnartist.com/','','2009-07-16 14:49:43',300,-1,0,0,0,5,6);
INSERT INTO `yishu_website` VALUES (55,3,'�ƺ�ի������','http://www.cdyhz.com/','','2009-07-16 14:49:54',310,-1,0,0,0,6,8);
INSERT INTO `yishu_website` VALUES (56,3,'��������-�Ļ�����','http://gb.cri.cn/','','2009-07-16 14:50:03',320,-1,0,0,0,2,3);
INSERT INTO `yishu_website` VALUES (57,3,'��������','http://www.ccnt.com/','','2009-07-16 14:50:10',330,-1,0,0,0,6,6);
INSERT INTO `yishu_website` VALUES (58,1,'�л���ǧ��','http://www.zh5000.com/','','2009-07-16 14:51:43',10,1,0,1,0,17,23);
INSERT INTO `yishu_website` VALUES (59,1,'�����й�','http://art.china.cn/','�����й��ǹ���Ժ���Ű��쵼���й��������������ġ��й������µ�רҵ����ý�塣�����й��ԡ���������,��Ҹ��,������Ұ,����������Ϊ��ּ,���ѧ��Ʒ��,����߶�,������ڡ�','2009-07-19 11:47:08',5,1,1,1,1,19,20);
INSERT INTO `yishu_website` VALUES (60,1,'׿��������','http://www.zhuokearts.com/','׿����������һ�����ȵĻ���������ý�弰��ֵ��Ѷ�����ṩ�̡������ƶ��й��Ļ���չΪ���Σ�ʼ����������ȫ����չʾ�й��������Ļ���ҵ�ķ�ɺ�������\n        ��Ϊ�й����������Ļ��ۺ��Ż���վ֮һ��׿��������Ŀǰ����¼�˹���������Ʒ��������500��ң�������¼100��������������������3000��ң�������6����������ҵ��г����飬ӵ���ȶ���Ա5�������������������������Ρ�\n','2009-07-19 11:51:54',20,1,1,1,1,18,29);
INSERT INTO `yishu_website` VALUES (61,1,'ȫ��������','http://www.artnet.cn/','ȫ�������� ( www.artnet.cn ��www.artnet.com.cn )��������2003�꣬��һ?������Ʒ��Ѷ������Ʒ�ղء�����Ʒ�г�Ͷ�ʷ�������������Ʒ��̬�Լ�����Ʒ�����������׵�רҵ��վ��Ŀǰ������ǿ����רҵ������Ʒ���׽����Ż�����','2009-07-19 11:53:30',30,1,1,1,1,20,18);
INSERT INTO `yishu_website` VALUES (62,1,'�ű���','http://www.yabaoo.com/','�ű���(http://www.yabaoo.com)ͨ���ṩ����ý�弰����������Ѷ����Ϣ�����ۺ�����Ѷ������������̳������Ʒ������������ȫ���������������������Ⱥ�������Ʒ�ղء����͡�Ͷ�ʰ����ߣ���Ϊ����Ʒ�����ṩ��Ҫ��׼��\r\n\r\n�ű�����ѭȫ�桢������Ȩ�����͹ۡ�����ķ���������Ļ���������רҵ����׼����ʱ�ı�׼��������Ѷ����̳�����������ס�����������ƽ̨����Ч����չѧ�������������ղء��������ֵ�����Ŭ�������й���߼�ֵ�ġ�����Ȩ������ƽ̨����','2009-07-19 12:27:25',40,1,1,1,1,22,13);
INSERT INTO `yishu_website` VALUES (64,6,'����������','http://shop.freehead.com/index.php','�й��鷨������������','2009-08-16 15:56:35',10,1,0,0,0,33,13);
INSERT INTO `yishu_website` VALUES (65,6,'�鷨�����̳�','http://shop.sf108.com/','','2009-08-16 15:56:55',20,1,0,0,0,12,13);
INSERT INTO `yishu_website` VALUES (66,6,'�ε����ߣ��黭���ͻ����Ŷ����ղء���Ʒ������Ʒ������������','http://www.artrade.com/','','2009-08-16 15:57:09',30,-1,0,0,0,12,11);
INSERT INTO `yishu_website` VALUES (67,6,'�����й�����Ʒ��','http://art.365ccm.com/','','2009-08-16 15:57:22',40,1,0,0,0,16,14);
INSERT INTO `yishu_website` VALUES (68,6,'������','http://www.taooyi.cn/','','2009-08-16 15:57:35',11,1,0,0,0,19,16);
INSERT INTO `yishu_website` VALUES (69,6,'�й��鷨����','http://www.qyx888.com/','','2009-08-16 15:57:49',9,1,0,0,0,13,6);
INSERT INTO `yishu_website` VALUES (70,6,'���滭��Ʒ���ס�','http://www.shwbbs.com/','','2009-08-16 15:58:08',70,1,0,0,0,16,8);
INSERT INTO `yishu_website` VALUES (71,6,'�黭���','http://www.sh518.cc/','','2009-08-16 16:45:25',8,1,0,0,0,16,8);
INSERT INTO `yishu_website` VALUES (72,6,'����������','http://www.artxun.com/','','2009-08-16 16:45:56',90,1,0,0,0,14,5);
INSERT INTO `yishu_website` VALUES (73,6,'������','http://www.artronmore.net/','','2009-08-16 16:46:14',100,1,0,0,0,13,8);
INSERT INTO `yishu_website` VALUES (74,6,'�չ���','http://www.art-gou.com/','','2009-08-16 16:46:49',110,1,0,0,0,14,7);
INSERT INTO `yishu_website` VALUES (75,6,'�� �������� - �й�������������̳','http://bbs.21nowart.com/','','2009-08-16 16:51:00',120,1,0,0,0,14,6);
INSERT INTO `yishu_website` VALUES (76,1,'�����Ļ�������','http://www.eastart.net/','','2009-08-16 16:56:59',50,1,0,0,0,13,5);
INSERT INTO `yishu_website` VALUES (77,1,'�Ž�������','http://www.gujinyishu.com/','','2009-08-16 16:57:45',60,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (78,1,'7080������','http://www.7080art.com/','','2009-08-16 16:58:15',70,1,0,0,0,13,3);
INSERT INTO `yishu_website` VALUES (79,1,'�й���������','http://www.artcn.com/','','2009-08-16 16:58:40',80,1,0,0,0,13,7);
INSERT INTO `yishu_website` VALUES (80,1,'����Ʒ������','http://ysplh.com/','','2009-08-16 16:58:53',90,1,0,0,0,13,5);
INSERT INTO `yishu_website` VALUES (81,1,'99������','http://www.99ys.com/','','2009-08-16 17:28:03',100,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (82,1,'�й�����Ʒ����','http://www.artew.com/','','2009-08-16 17:28:13',110,1,0,0,0,14,4);
INSERT INTO `yishu_website` VALUES (83,1,'�й�����Ʒ','http://www.cnarts.net/','','2009-08-16 17:28:24',120,1,0,0,0,16,4);
INSERT INTO `yishu_website` VALUES (84,1,'������','http://www.baozang.com/','','2009-08-16 21:52:06',130,1,0,0,0,13,7);
INSERT INTO `yishu_website` VALUES (85,1,'�㽭����??��������','http://art.zjol.com.cn/','','2009-08-16 21:54:16',140,1,0,0,0,12,5);
INSERT INTO `yishu_website` VALUES (86,1,'�й�������������Artnews','http://www.artnews.cn/','','2009-08-16 21:55:11',150,1,0,0,0,13,5);
INSERT INTO `yishu_website` VALUES (87,1,'�й�������������','http://www.666969.com/','','2009-08-17 16:09:23',160,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (88,1,'��չ��-��ҳ','http://art.newexpo.com/','','2009-08-17 16:09:43',170,1,0,0,0,13,2);
INSERT INTO `yishu_website` VALUES (89,1,'����������','http://www.yishu.com/','','2009-08-17 16:11:05',180,1,0,0,0,14,3);
INSERT INTO `yishu_website` VALUES (90,1,'��������Ʒ�������Ż�','http://www.artokok.com/','','2009-08-17 16:15:00',190,1,0,0,0,14,4);
INSERT INTO `yishu_website` VALUES (91,1,'��������Ʒ�������Ż� ART|����Ʒ|��Ʒ|����|����Ʒ|������|����|�й��״���������������ƽ̨','http://www.artokok.com/','','2009-08-17 16:15:00',200,-1,0,0,0,1,0);
INSERT INTO `yishu_website` VALUES (92,1,'��������Ʒ�������Ż� ART|����Ʒ|��Ʒ|����|����Ʒ|������|����|�й��״���������������ƽ̨','http://www.artokok.com/','','2009-08-17 16:15:00',210,-1,0,0,0,0,1);
INSERT INTO `yishu_website` VALUES (93,1,'��������Ʒ�������Ż� ART|����Ʒ|��Ʒ|����|����Ʒ|������|����|�й��״���������������ƽ̨','http://www.artokok.com/','','2009-08-17 16:15:00',220,-1,0,0,0,1,0);
INSERT INTO `yishu_website` VALUES (94,1,'�㽭������','http://www.art-zj.com/','','2009-08-17 16:16:04',230,1,0,0,0,13,7);
INSERT INTO `yishu_website` VALUES (95,1,'�����й�-�й���ͳ�Ļ����������Ż���վ - |�ղ�����|�й��鷨|�й�����|��ѧ|�й���ʷ|�й�����|�й�Ϸ��|','http://www.artx.cn/','','2009-08-17 16:16:22',240,-1,0,0,0,1,0);
INSERT INTO `yishu_website` VALUES (96,1,'׿�������� - �й����������Ż���','http://www.zhuokearts.com/','','2009-08-17 16:16:31',250,-1,0,0,0,1,0);
INSERT INTO `yishu_website` VALUES (97,6,'����������','http://www.dycc.cc/','','2009-08-17 16:16:52',130,1,0,0,0,15,7);
INSERT INTO `yishu_website` VALUES (98,1,'��������Ʒ�������Ż� ART|����Ʒ|��Ʒ|����|����Ʒ|������|����|�й��״���������������ƽ̨','http://www.artokok.com/','','2009-08-17 16:17:07',260,-1,0,0,0,1,1);
INSERT INTO `yishu_website` VALUES (99,1,'��������Ʒ�������Ż� ART|����Ʒ|��Ʒ|����|����Ʒ|������|����|�й��״���������������ƽ̨','http://www.artokok.com/','','2009-08-17 16:19:48',270,-1,0,0,0,1,0);
INSERT INTO `yishu_website` VALUES (100,1,'�����й� ART86.cn ������������','http://art86.cn/','','2009-08-17 21:27:13',280,-1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (101,16,'�л��ղ���','http://www.sc001.com.cn/','','2009-08-17 21:28:17',50,1,0,0,0,12,8);
INSERT INTO `yishu_website` VALUES (102,4,'Art-Ba-Ba','http://www.art-ba-ba.com/','','2009-08-17 21:30:12',10,1,0,0,0,13,5);
INSERT INTO `yishu_website` VALUES (103,4,'�й�����������','http://www.artgean.com/','','2009-08-17 21:31:13',20,1,0,0,0,13,6);
INSERT INTO `yishu_website` VALUES (104,4,'ArtGuide ������','http://www.artguide.net.cn/','','2009-08-17 21:31:33',30,1,0,0,0,17,6);
INSERT INTO `yishu_website` VALUES (105,1,'���������й�������','http://www.cl2000.com/','','2009-08-17 21:34:00',290,1,0,0,0,13,5);
INSERT INTO `yishu_website` VALUES (106,4,'��������','http://www.mahoo.com.cn/','','2009-08-17 21:35:54',40,1,0,0,0,16,5);
INSERT INTO `yishu_website` VALUES (107,1,'������ ARTSPY.CN','http://www.artspy.cn/','','2009-08-17 21:36:10',300,1,0,0,0,17,3);
INSERT INTO `yishu_website` VALUES (108,4,'A-BBS.com','http://www.abbs.com.cn/','','2009-08-17 21:39:52',50,1,0,0,0,13,8);
INSERT INTO `yishu_website` VALUES (109,4,'��������','http://www.artintern.net/','','2009-08-17 21:40:47',60,1,0,0,0,12,5);
INSERT INTO `yishu_website` VALUES (110,14,'��������??���������Ż� - Powered By arttp','http://www.arttp.com/','','2009-08-17 21:41:22',10,1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (111,4,'��������','http://www.arttp.com/','','2009-08-17 21:41:32',70,1,0,0,0,16,5);
INSERT INTO `yishu_website` VALUES (112,4,'����-�Ѻ��Ļ�Ƶ��','http://cul.sohu.com/','','2009-08-17 21:42:08',80,1,0,0,0,13,7);
INSERT INTO `yishu_website` VALUES (113,4,'Artmaz-���ӵ���������','http://www.artmaz.com/','','2009-08-17 21:43:16',90,1,0,0,0,17,7);
INSERT INTO `yishu_website` VALUES (114,4,'�й��������ж�','http://www.caaia.com/','','2009-08-17 21:44:21',100,1,0,0,0,13,8);
INSERT INTO `yishu_website` VALUES (115,4,'�й�����������','http://www.artc.net.cn/','','2009-08-17 21:46:33',110,1,0,0,0,15,4);
INSERT INTO `yishu_website` VALUES (116,4,'��ׯ��������','http://www.szfeeling.com/','','2009-08-17 21:47:14',120,1,0,0,0,17,8);
INSERT INTO `yishu_website` VALUES (117,4,'ART218������վ - �й�����ѧԺ չʾ�Ļ��о�����','http://www.art218.com/','','2009-08-17 21:47:36',130,1,0,0,0,12,6);
INSERT INTO `yishu_website` VALUES (118,4,'| ArtZineChina.com | �й���־','http://www.artzinechina.com/','','2009-08-17 21:48:37',140,1,0,0,0,15,7);
INSERT INTO `yishu_website` VALUES (119,4,'�й�����������һ�Ż�-�����Ӿ�iONLY.com.cn','http://www.ionly.com.cn/','','2009-08-17 21:49:58',150,1,0,0,0,15,6);
INSERT INTO `yishu_website` VALUES (120,4,'�����ȷ���','http://www.chn-art.com/','','2009-08-17 21:50:10',160,1,0,0,0,13,8);
INSERT INTO `yishu_website` VALUES (121,4,'����??�������','http://tech.163.com/','','2009-08-17 21:50:37',170,1,0,0,0,14,5);
INSERT INTO `yishu_website` VALUES (122,21,'�Ϻ��ͽܻ���','http://www.hjgallery.com/','','2009-08-17 21:51:32',50,1,0,0,0,12,9);
INSERT INTO `yishu_website` VALUES (123,21,'���ݷ���','http://www.directart.com.cn/','','2009-08-17 21:51:48',60,1,0,0,0,13,7);
INSERT INTO `yishu_website` VALUES (124,21,'���滭��','http://www.saatchi-gallery.co.uk/','','2009-08-17 21:52:15',70,1,0,0,0,13,6);
INSERT INTO `yishu_website` VALUES (125,21,'������������','http://www.arts8.net.cn/','','2009-08-17 21:52:43',80,1,0,0,0,12,8);
INSERT INTO `yishu_website` VALUES (126,21,'�㽭�����黭��','http://www.0575h.com/','','2009-08-17 21:53:33',90,1,0,0,0,13,7);
INSERT INTO `yishu_website` VALUES (127,16,'ʢ���ղ�','http://www.sssc.cn/','','2009-08-17 21:54:38',20,1,0,0,0,12,8);
INSERT INTO `yishu_website` VALUES (128,16,'�ղ�_���˲ƾ�','http://finance.sina.com.cn/','','2009-08-17 21:54:55',40,1,0,0,0,12,6);
INSERT INTO `yishu_website` VALUES (129,16,'�й��ղ���','http://www.socang.com/','','2009-08-17 21:55:10',30,1,0,0,0,14,7);
INSERT INTO `yishu_website` VALUES (130,16,'�й��ղ����ղذ����ߵ����ϼ�԰��','http://www.shoucang.com/','','2009-08-17 21:55:25',50,-1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (131,16,'�ղ�_���˲ƾ�_������','http://finance.sina.com.cn/','','2009-08-17 21:55:37',60,-1,0,0,0,13,8);
INSERT INTO `yishu_website` VALUES (132,11,'�ղ�--�������̱���','http://www.bbtnews.com.cn/','','2009-08-17 21:56:25',10,1,0,0,0,15,6);
INSERT INTO `yishu_website` VALUES (133,16,'�ղ�Ͷ��','http://www.chinasecurities.com.cn/','','2009-08-17 21:57:15',70,1,0,0,0,12,2);
INSERT INTO `yishu_website` VALUES (134,10,'�Ϻ��ͻ�����Ժ','http://www.youdiao.com.cn/','','2009-08-17 21:57:37',300,1,0,0,0,13,6);
INSERT INTO `yishu_website` VALUES (135,16,'�㽭ʡ�й����ﻭ�о���','http://www.zgrwh.com/','','2009-08-17 21:57:46',80,-1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (136,10,'�㽭ʡ�й����ﻭ�о���','http://www.zgrwh.com/','','2009-08-17 22:23:01',310,1,0,0,0,16,5);
INSERT INTO `yishu_website` VALUES (137,1,'������','http://www.boyie.com/','','2009-08-26 11:39:40',310,1,1,0,0,12,9);
INSERT INTO `yishu_website` VALUES (138,19,'������','http://www.duoyunxuan.com/','','2009-08-26 12:00:42',7,1,0,0,0,13,9);
INSERT INTO `yishu_website` VALUES (139,20,'�¹�����������չ����','http://www.kah-bonn.de/','','2009-08-26 12:06:00',51,1,0,0,0,12,5);
INSERT INTO `yishu_website` VALUES (140,20,'����˹���������','http://www.hermitagemuseum.org/','','2009-08-26 12:06:26',61,1,0,0,0,16,9);
INSERT INTO `yishu_website` VALUES (141,20,'��ٸԲ����','http://mv.vatican.va/','','2009-08-26 12:10:26',30,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (142,20,'��������������','http://www.musee-orsay.fr/','','2009-08-26 12:12:06',40,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (143,20,'��������','http://en.chateauversailles.fr/homepage','','2009-08-26 12:13:01',50,1,0,0,0,4,4);
INSERT INTO `yishu_website` VALUES (144,20,'�ڷ���������','http://www.uffizi.it/','','2009-08-26 12:14:50',60,1,0,0,0,12,3);
INSERT INTO `yishu_website` VALUES (145,20,'��Ƥ���ִ���������','http://www.centrepompidou.fr/','','2009-08-26 12:16:14',70,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (146,20,'��������������','http://www.rijksmuseum.nl/','','2009-08-26 13:14:13',80,1,0,0,0,13,3);
INSERT INTO `yishu_website` VALUES (147,20,'ά�����ǰ�����������','http://www.vam.ac.uk/','','2009-08-26 13:15:10',90,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (148,20,'������������˹���������','http://www.hnm.hu/','','2009-08-26 13:15:57',100,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (149,15,'�Ͼ�����ѧԺ','http://www.njarti.edu.cn/','','2009-08-26 13:55:09',120,1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (150,15,'��ӭ�����������ѧԺ-��ҳ','http://www.tjarts.edu.cn/','','2009-08-26 13:57:03',260,-1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (151,20,'������ʿ�����','http://www.musee-suisse.ch/','','2009-08-26 14:12:54',110,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (152,20,'�µ���������','http://www.belvedere.at/','','2009-08-26 14:13:22',120,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (153,20,'�������ǹ�����ʷ�����','http://www.historymuseum.org/','','2009-08-26 14:15:38',130,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (154,20,'������˹������','http://www.mucsarnok.hu/','','2009-08-26 14:16:09',140,1,0,0,0,13,6);
INSERT INTO `yishu_website` VALUES (155,20,'��������������','http://www.americanart.si.edu/','','2009-08-26 14:17:21',150,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (156,20,'·��˹�����ִ�������','http://www.louisiana.dk/','','2009-08-26 14:17:56',160,1,0,0,0,11,4);
INSERT INTO `yishu_website` VALUES (157,20,'������������','http://www.fng.fi/','','2009-08-26 14:18:25',170,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (158,20,'��������������','http://www.nationalgallery.ie/','','2009-08-26 14:19:26',180,1,0,0,0,13,3);
INSERT INTO `yishu_website` VALUES (159,20,'ά�����ǰ�����������','http://www.vam.ac.uk/','','2009-08-26 14:20:26',190,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (160,20,'�׽𺺹�','http://www.royal.gov.uk/','','2009-08-26 14:21:00',9,1,0,0,0,12,3);
INSERT INTO `yishu_website` VALUES (161,20,'�ʼ�����ѧԺ','http://www.royalacademy.org.uk/','','2009-08-26 14:21:50',210,1,0,0,0,10,4);
INSERT INTO `yishu_website` VALUES (162,20,'Ӣ���ʹ�','http://www.hrp.org.uk/','','2009-08-26 14:22:11',220,1,0,0,0,13,2);
INSERT INTO `yishu_website` VALUES (163,20,'Ӣ���ʹ�(���׶�����)','http://www.hrp.org.uk/','','2009-08-26 14:22:14',230,-1,0,0,0,12,8);
INSERT INTO `yishu_website` VALUES (164,20,'�׶���Ȼ��ʷ�����','http://www.nhm.ac.uk/','','2009-08-26 14:22:46',240,1,0,0,0,11,4);
INSERT INTO `yishu_website` VALUES (165,20,'�׶ز����','http://www.museumoflondon.org.uk/','','2009-08-26 14:23:05',250,1,0,0,0,12,2);
INSERT INTO `yishu_website` VALUES (166,20,'̩��������','http://www.tate.org.uk/','','2009-08-26 14:23:43',260,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (167,20,'����Ф����','http://www.npg.org.uk/','','2009-08-26 14:25:47',270,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (168,20,'��������','http://www.nationalgallery.org.uk/','','2009-08-26 14:26:18',280,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (169,20,'�ո������������','http://www.nms.ac.uk/','','2009-08-26 14:26:53',290,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (170,20,'�������������','http://www.afrikamuseum.nl/','','2009-08-26 14:27:21',300,1,0,0,0,14,4);
INSERT INTO `yishu_website` VALUES (171,20,'����ʱ�ʼ�������','http://www.fine-arts-museum.be/','','2009-08-26 14:28:24',310,1,0,0,0,13,5);
INSERT INTO `yishu_website` VALUES (172,20,'���������','http://www.vangoghmuseum.nl/','','2009-08-26 14:28:47',320,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (173,20,'�ʼҾ��²����','http://www.klm-mra.be/','','2009-08-26 14:29:53',330,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (174,20,'��԰������','http://www.paris-tourism.com/','','2009-08-26 14:30:12',340,1,0,0,0,12,2);
INSERT INTO `yishu_website` VALUES (175,20,'Ī��������','http://www.marmottan.com/','','2009-08-26 14:30:57',350,1,0,0,0,12,6);
INSERT INTO `yishu_website` VALUES (176,20,'�޵�������','http://www.musee-rodin.fr/','','2009-08-26 14:31:25',360,1,0,0,0,13,2);
INSERT INTO `yishu_website` VALUES (177,20,'�౴�����','http://www.fondation-bemberg.fr/','','2009-08-26 14:31:45',370,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (178,20,'(��)Ľ���������','http://www.artechock.de/','','2009-08-26 14:32:27',380,1,0,0,0,13,2);
INSERT INTO `yishu_website` VALUES (179,20,'(��)Ľ���������','http://www.pinakothek.de/','','2009-08-26 14:32:52',390,1,0,0,0,13,3);
INSERT INTO `yishu_website` VALUES (180,20,'Ľ��ڿ�ѧ�����','http://www.deutsches-museum.de/','','2009-08-26 14:33:16',400,1,0,0,0,13,6);
INSERT INTO `yishu_website` VALUES (181,20,'���ֹ���������','http://www.smb.spk-berlin.de/','','2009-08-26 14:33:38',410,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (182,20,'�¹�������������','http://www.smb.museum/','','2009-08-26 14:34:33',420,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (183,20,'����˹������','http://www.bauhaus.de/','','2009-08-26 14:34:54',430,1,0,0,0,20,4);
INSERT INTO `yishu_website` VALUES (184,20,'���ֹŸ���������','http://www.deutsche-guggenheim-berlin.de/','','2009-08-26 14:35:21',440,1,0,0,0,14,3);
INSERT INTO `yishu_website` VALUES (185,20,'��¡·�ײ����','http://www.museenkoeln.de/','','2009-08-26 14:35:38',450,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (186,20,'¬����','http://www.louvre.fr/','','2009-08-26 22:06:04',8,1,0,0,0,11,4);
INSERT INTO `yishu_website` VALUES (187,15,'��������ѧԺ ��ӭ����','http://www.cafa.edu.cn/','','2009-08-26 22:09:45',270,-1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (188,15,'��������ѧԺ','http://www.gzarts.edu.cn/','','2009-08-26 22:13:57',100,1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (189,9,'�����й�','http://www.dszg.com/','','2009-08-28 14:33:27',10,1,0,0,0,9,3);
INSERT INTO `yishu_website` VALUES (190,9,'�й�������','http://www.diaosu.cn/','','2009-08-28 14:33:40',20,1,0,0,0,10,2);
INSERT INTO `yishu_website` VALUES (191,9,'��������','http://www.diaosunet.com/','','2009-08-28 14:33:51',30,1,0,0,0,11,5);
INSERT INTO `yishu_website` VALUES (192,9,'�Ų�������','http://sculpture.artron.net/','','2009-08-28 14:34:13',40,1,0,0,0,11,4);
INSERT INTO `yishu_website` VALUES (193,9,'�й��������������','http://www.diasu.cn/','','2009-08-28 14:35:23',70,1,0,0,0,11,3);
INSERT INTO `yishu_website` VALUES (194,9,'����������','http://www.xbarts.com/','','2009-08-28 14:35:43',60,1,0,0,0,10,4);
INSERT INTO `yishu_website` VALUES (195,21,'�Ϻ����Ժ����','http://www.aagalaxy.com.cn/','','2009-08-28 14:41:46',100,1,0,0,0,11,6);
INSERT INTO `yishu_website` VALUES (196,1,'�й�������Ӣ�İ棩','http://www.artscenechina.com/','','2009-08-28 14:43:32',320,1,0,0,0,4,1);
INSERT INTO `yishu_website` VALUES (197,1,'��������','http://www.artstoday.com/','','2009-08-28 14:47:52',330,1,0,0,0,6,1);
INSERT INTO `yishu_website` VALUES (198,21,'��һ������','http://www.no1art.com.cn/','','2009-08-28 14:53:53',110,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (199,17,'�й�������','http://www.namoc.org/','','2009-08-28 14:54:08',50,1,0,0,0,10,6);
INSERT INTO `yishu_website` VALUES (200,17,'�й����ִ�������','http://artchina.com.cn/','','2009-08-28 14:54:34',60,1,0,0,0,14,5);
INSERT INTO `yishu_website` VALUES (201,17,'�Ϻ�������','http://www.sh-artmuseum.org.cn/','','2009-08-28 15:01:45',70,1,0,0,0,14,4);
INSERT INTO `yishu_website` VALUES (202,17,'���ϲ���Ժ','http://www.chnmus.net/','','2009-08-28 15:06:34',80,1,0,0,0,14,3);
INSERT INTO `yishu_website` VALUES (203,17,'��ʼ�ʱ���ٸ�����','http://www.bmy.com.cn/','','2009-08-28 15:08:22',90,1,0,0,0,12,3);
INSERT INTO `yishu_website` VALUES (204,17,'�й����Ҳ������վ','http://www.chnmuseum.cn/','','2009-08-28 15:09:05',100,1,0,0,0,9,3);
INSERT INTO `yishu_website` VALUES (205,17,'�Ͼ�����Ժ','http://www.njmuseum.com/','','2009-08-28 15:11:04',110,1,0,0,0,12,2);
INSERT INTO `yishu_website` VALUES (206,6,'����������','http://www.letart.com/','','2009-08-28 15:14:45',260,1,0,0,0,10,2);
INSERT INTO `yishu_website` VALUES (207,21,'������ǧ����','http://www.daqiangallery.com.cn/','','2009-08-28 15:17:33',120,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (208,21,'�ղ�����','http://www.yibo-art.com/','','2009-08-28 15:19:53',130,1,0,0,0,11,4);
INSERT INTO `yishu_website` VALUES (209,5,'�й�����','http://www.cnpf.net/','','2009-08-28 15:36:22',160,1,0,0,0,9,5);
INSERT INTO `yishu_website` VALUES (210,1,'��ӭ�����й���Է��','http://www.china-gallery.com/','','2009-08-28 15:46:52',340,1,0,0,0,7,2);
INSERT INTO `yishu_website` VALUES (211,10,'���ݻ�Ժ','http://www.sz-art.com/','','2009-08-28 15:47:43',320,1,0,0,0,7,5);
INSERT INTO `yishu_website` VALUES (212,1,'������','http://www.yishujie.com/','','2009-08-28 15:48:20',350,1,0,0,0,6,1);
INSERT INTO `yishu_website` VALUES (213,1,'�ٱ�ի������','http://www.rbzarts.com/','','2009-08-28 15:56:35',360,1,0,0,0,6,2);
INSERT INTO `yishu_website` VALUES (214,1,'�ٱ�ի������','http://www.rbzarts.com/','','2009-08-28 15:56:37',370,1,0,0,0,7,2);
INSERT INTO `yishu_website` VALUES (215,16,'�й����ղ���','http://www.cpcart.com/','','2009-08-28 15:58:23',90,1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (216,1,'�й�������','http://www.meishujia.cn/','','2009-08-28 15:59:59',380,1,0,0,0,5,2);
INSERT INTO `yishu_website` VALUES (217,5,'�й�����--����','http://www.wenyi.com/','','2009-08-28 16:05:50',170,1,0,0,0,10,4);
INSERT INTO `yishu_website` VALUES (218,5,'�й���Ժ������������','http://www.cnart.biz/','','2009-08-28 16:20:35',180,1,0,0,0,10,5);
INSERT INTO `yishu_website` VALUES (219,8,'��ˮ��','http://www.hsf88.com/','','2009-08-28 16:22:50',10,1,0,0,0,12,6);
INSERT INTO `yishu_website` VALUES (220,8,'�����','http://www.likuchan.com/','','2009-08-28 16:23:06',20,1,0,0,0,9,7);
INSERT INTO `yishu_website` VALUES (221,8,'����Ȩ','http://www.cyq99.com/','','2009-08-28 16:24:26',30,1,0,0,0,10,5);
INSERT INTO `yishu_website` VALUES (222,11,'��������','http://www.cansart.com.tw/','','2009-08-28 16:41:08',20,1,0,0,0,11,8);
INSERT INTO `yishu_website` VALUES (223,13,'?????Ժ','http://www.artgate.com.tw/','','2009-08-28 16:49:26',10,1,0,0,0,11,7);
INSERT INTO `yishu_website` VALUES (224,11,'����ɳ��','http://www.artsalon.cn/','','2009-08-28 16:56:02',30,1,0,0,0,13,6);
INSERT INTO `yishu_website` VALUES (225,22,'��������������','http://www.renmei.com.cn/','','2009-08-28 16:57:07',10,1,0,0,0,12,5);
INSERT INTO `yishu_website` VALUES (226,1,'����������','http://www.jingp.com/','','2009-08-28 17:04:41',390,1,0,0,0,6,2);
INSERT INTO `yishu_website` VALUES (227,1,'����������','http://www.plys.cn/','','2009-08-28 17:05:18',400,1,0,0,0,6,1);
INSERT INTO `yishu_website` VALUES (228,6,'������','http://www.taooyi.cn/','','2009-08-28 17:05:42',270,1,0,0,0,9,3);
INSERT INTO `yishu_website` VALUES (229,19,'�й��ε�','http://www.cguardian.com/','','2009-08-28 17:07:47',5,1,0,0,0,10,4);
INSERT INTO `yishu_website` VALUES (230,17,'�׶������','http://www.capitalmuseum.org.cn/','','2009-08-28 17:09:47',120,1,0,0,0,9,2);
INSERT INTO `yishu_website` VALUES (231,17,'�й��ͻ�ѧ��','http://www.chinaops.org/','','2009-08-28 17:10:08',130,1,0,0,0,13,2);
INSERT INTO `yishu_website` VALUES (232,19,'��������','http://www.chieftown.com/','','2009-08-28 17:10:42',30,1,0,0,0,8,2);
INSERT INTO `yishu_website` VALUES (233,19,'��������','http://www.polypm.com.cn/','','2009-08-28 17:11:05',6,1,0,0,0,11,6);
INSERT INTO `yishu_website` VALUES (234,19,'��ʿ��','http://www.christies.com/','','2009-08-28 17:14:03',1,1,0,0,0,9,5);
INSERT INTO `yishu_website` VALUES (235,19,'�ո���','http://www.sothebys.com/','','2009-08-28 17:19:14',2,1,0,0,0,11,3);
INSERT INTO `yishu_website` VALUES (236,15,'�й������о�Ժ','http://www.zgysyjy.org.cn/','','2009-08-28 17:27:13',310,1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (237,15,'������ѧ����ѧԺ','http://art.jmu.edu.cn/','','2009-08-28 17:30:18',320,1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (238,20,'����˹�Ÿ���������','http://www.guggenheim-venice.it/','','2009-08-29 08:25:58',140,1,0,0,0,11,5);
INSERT INTO `yishu_website` VALUES (239,20,'�ڷ���������','http://www.uffizi.it/','','2009-08-29 08:26:39',150,1,0,0,0,12,2);
INSERT INTO `yishu_website` VALUES (240,20,'������������','http://www.brera.beniculturali.it/','','2009-08-29 08:28:17',460,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (241,20,'���������Ҳ����','http://www.hnm.hu/','','2009-08-29 08:28:39',470,1,0,0,0,8,3);
INSERT INTO `yishu_website` VALUES (242,20,'�µ����������ڹ�������','http://www.belvedere.at/','','2009-08-29 08:29:43',480,1,0,0,0,11,4);
INSERT INTO `yishu_website` VALUES (243,20,'Ľ��������','http://www.mucha.cz/','','2009-08-29 08:52:42',490,1,0,0,0,10,3);
INSERT INTO `yishu_website` VALUES (244,20,'άҲ������ʷ�����','http://www.khm.at/','','2009-08-29 08:53:50',500,1,0,0,0,11,4);
INSERT INTO `yishu_website` VALUES (245,20,'���������������','http://www.ngprague.cz/','','2009-08-29 08:54:27',510,1,0,0,0,12,5);
INSERT INTO `yishu_website` VALUES (246,20,'���ɴ�����','http://www.gianadda.ch/','','2009-08-29 08:55:13',520,1,0,0,0,13,5);
INSERT INTO `yishu_website` VALUES (247,20,'���ջ����','http://www.beyeler.com/','','2009-08-29 08:55:41',530,1,0,0,0,11,3);
INSERT INTO `yishu_website` VALUES (248,20,'����������','http://www.hamburger-kunsthalle.de/','','2009-08-29 08:56:41',540,1,0,0,0,8,5);
INSERT INTO `yishu_website` VALUES (249,20,'�����������ֹ��ղ����','http://www.mkg-hamburg.de/','','2009-08-29 08:57:06',550,1,0,0,0,10,5);
INSERT INTO `yishu_website` VALUES (250,20,'˹ͼ���ع�������','http://www.staatsgalerie.de/','','2009-08-29 08:57:45',560,1,0,0,0,14,2);
INSERT INTO `yishu_website` VALUES (251,20,'�����ն�����ʷ�����','http://www.museenkoeln.de/','','2009-08-29 08:58:08',570,1,0,0,0,17,4);
INSERT INTO `yishu_website` VALUES (252,20,'��¡·�ײ����','http://www.museenkoeln.de/','','2009-08-29 08:59:15',580,-1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (253,1,'�л��黭��','http://www.zhshw.com/','','2009-08-29 09:29:13',410,1,0,0,0,7,2);
INSERT INTO `yishu_website` VALUES (254,20,'CGFA-����ʷ','http://cgfa.dotsrc.org/','','2009-08-29 09:31:58',590,1,0,0,0,11,5);
INSERT INTO `yishu_website` VALUES (255,17,'�����ʹ�','http://www.dpm.org.cn/','','2009-08-29 09:35:49',140,1,0,0,0,10,3);
INSERT INTO `yishu_website` VALUES (256,17,'ŦԼ�ִ�������','http://www.moma.org/','','2009-08-29 09:37:58',150,1,0,0,0,12,3);
INSERT INTO `yishu_website` VALUES (257,20,'Glubibulg���廭','http://www.slap-press.com/','','2009-08-29 09:39:48',600,1,0,0,0,11,3);
INSERT INTO `yishu_website` VALUES (258,20,'����˫��չ','http://www.gwangju-biennale.org/','','2009-08-29 09:43:21',610,1,0,0,0,12,7);
INSERT INTO `yishu_website` VALUES (259,20,'artnet������������ ','http://www.artnet.com/','','2009-08-29 09:46:56',620,1,0,0,0,8,2);
INSERT INTO `yishu_website` VALUES (260,20,'ŦԼ��ӰѧԺ','http://www.nyip.com/','','2009-08-29 09:48:06',630,1,0,0,0,12,5);
INSERT INTO `yishu_website` VALUES (261,20,'����������չ','http://www.documenta.de/','','2009-08-29 09:49:55',640,1,0,0,0,12,3);
INSERT INTO `yishu_website` VALUES (262,20,'�ﰺ˫��չ','http://www.biennale-de-lyon.org/','','2009-08-29 09:51:37',650,1,0,0,0,10,4);
INSERT INTO `yishu_website` VALUES (263,20,'�׶�˫��չ','http://www.marisol.co.uk/','','2009-08-29 09:53:35',660,1,0,0,0,12,3);
INSERT INTO `yishu_website` VALUES (264,20,'�ձ��������չ','http://www.jpf.go.jp/','','2009-08-29 09:55:08',670,1,0,0,0,11,4);
INSERT INTO `yishu_website` VALUES (265,20,'��˹̹����˫��չ','http://www.iksv.org/','','2009-08-29 09:55:46',680,1,0,0,0,9,4);
INSERT INTO `yishu_website` VALUES (266,20,'��³����˫��չ','http://e.busca.uol.com.br/','','2009-08-29 09:56:23',690,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (267,20,'��������������˫��չ','http://www.bienaldevalencia.com/','','2009-08-29 09:58:13',700,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (268,20,'���׶�CAB˫��չ','http://www.aspacegallery.org/','','2009-08-29 09:58:39',710,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (269,20,'�Ϸ�Լ����˹��˫��չ','http://www.camwood.org/','','2009-08-29 09:59:25',720,1,0,0,0,7,5);
INSERT INTO `yishu_website` VALUES (270,20,'�¹�����˫��չ','http://www.berlinbiennale.de/','','2009-08-29 10:00:06',730,1,0,0,0,9,4);
INSERT INTO `yishu_website` VALUES (271,20,'���ô���������˫��չ','http://www.ciac.ca/','','2009-08-29 10:00:35',740,1,0,0,0,13,5);
INSERT INTO `yishu_website` VALUES (272,20,'�Ĵ�����Ϥ��˫��չ','http://www.biennaleofsydney.com.au/','','2009-08-29 10:01:11',750,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (273,20,'�Ű͹�����˫��չ','http://www.universes-in-universe.de/','','2009-08-29 10:01:39',760,1,0,0,0,13,5);
INSERT INTO `yishu_website` VALUES (274,20,'������������ִ������� ','http://www.jeudepaume.org/','','2009-08-29 10:03:13',770,1,0,0,0,11,12);
INSERT INTO `yishu_website` VALUES (275,20,'�����ﰺ����������','http://www.mac-lyon.com/','','2009-08-29 10:04:15',780,1,0,0,0,10,3);
INSERT INTO `yishu_website` VALUES (276,20,'������˹���������� ','http://www.mamac-nice.org/','','2009-08-29 10:05:35',160,1,0,0,0,12,5);
INSERT INTO `yishu_website` VALUES (277,20,'��������ŵ����������','http://www.ville-grenoble.fr/','','2009-08-29 10:05:55',790,1,0,0,0,9,1);
INSERT INTO `yishu_website` VALUES (278,20,'���˹�¸��Ħ�ִ�������','http://www.modernamuseet.se/','','2009-08-29 10:06:27',800,1,0,0,0,13,5);
INSERT INTO `yishu_website` VALUES (279,20,'����֥�Ӹ統��������','http://www.mcachicago.org/','','2009-08-29 10:07:13',810,1,0,0,0,10,4);
INSERT INTO `yishu_website` VALUES (280,20,'�Ĵ�����Ϥ�ᵱ��������','http://www.mca.com.au/','','2009-08-29 10:07:49',820,1,0,0,0,13,3);
INSERT INTO `yishu_website` VALUES (281,20,'��������������������','http://www.ciac.ca/','','2009-08-29 10:11:01',830,1,0,0,0,9,4);
INSERT INTO `yishu_website` VALUES (282,20,'�������������ɵ����Ļ�����','http://www.cccb.org/','','2009-08-29 10:11:38',840,1,0,0,0,10,4);
INSERT INTO `yishu_website` VALUES (283,20,'����DIA����','http://www.diacenter.org/','','2009-08-29 10:13:04',850,1,0,0,0,11,5);
INSERT INTO `yishu_website` VALUES (284,20,'����ŦԼ�Ÿ���ķ������','http://www.guggenheim.org/','','2009-08-29 10:14:02',860,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (285,20,'�Ÿ���ķ�����ݣ��������ȶ����� ','http://www.guggenheim-bilbao.es/','','2009-08-29 10:14:50',870,1,0,0,0,11,3);
INSERT INTO `yishu_website` VALUES (286,20,'��ɽ�ִ���������� ','http://www.sfmoma.org/','','2009-08-29 10:17:24',880,1,0,0,0,12,5);
INSERT INTO `yishu_website` VALUES (287,20,'���ϲ����','http://www.webnetmuseum.org/','','2009-08-29 10:20:35',890,1,0,0,0,11,4);
INSERT INTO `yishu_website` VALUES (288,20,'Jodi','http://map.jodi.org/','','2009-08-29 10:24:45',900,1,0,0,0,11,2);
INSERT INTO `yishu_website` VALUES (289,20,'ZKM�¹�����˹³��������ý�弼������','http://www.zkm.de/','','2009-08-29 10:30:34',910,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (290,20,'�µ������ȵ�δ��������','http://www.aec.at/','','2009-08-29 10:32:58',920,1,0,0,0,12,3);
INSERT INTO `yishu_website` VALUES (291,20,'interferences','http://www.interferences.org/','','2009-08-29 10:36:39',930,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (292,20,'�¹�˹ͼ���ع¶��Ǳ��о�Ժ','http://www.akademie-solitude.de/','','2009-08-29 10:37:11',940,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (293,20,'���������ǵ������������','http://fondation.cartier.com/','','2009-08-29 10:38:08',950,1,0,0,0,11,3);
INSERT INTO `yishu_website` VALUES (294,20,'�����Ÿ���ķ�����','http://www.guggenheim.org/','','2009-08-29 10:38:45',960,1,0,0,0,12,3);
INSERT INTO `yishu_website` VALUES (295,20,'��������ߵ�����ѧԺ','http://www.ensba.fr/','','2009-08-29 10:40:26',970,1,0,0,0,9,4);
INSERT INTO `yishu_website` VALUES (296,20,'�������Ļ���־ ','http://www.technikart.com/','','2009-08-29 10:42:04',980,1,0,0,0,13,2);
INSERT INTO `yishu_website` VALUES (297,23,'������','http://www.huoshen.net/','','2009-08-29 10:42:20',10,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (298,23,'����ʱ����','http://www.hxsd.com/','','2009-08-29 10:42:51',20,1,0,0,0,13,3);
INSERT INTO `yishu_website` VALUES (299,23,'CG��־','http://www.newcg.com/','','2009-08-29 10:43:08',30,1,0,0,0,14,4);
INSERT INTO `yishu_website` VALUES (300,23,'������','http://www.diancity.com/','','2009-08-29 10:45:17',40,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (301,13,'��ư��� ','http://www.balang88.cn/','','2009-08-29 10:48:04',20,1,0,0,0,10,4);
INSERT INTO `yishu_website` VALUES (302,13,'������','http://www.fansart.com/','','2009-08-29 10:54:39',30,1,0,0,0,10,4);
INSERT INTO `yishu_website` VALUES (303,8,'��־��','http://www.qiuzhijie.com/','','2009-08-29 10:58:48',40,1,0,0,0,10,2);
INSERT INTO `yishu_website` VALUES (304,24,'��Ȧ','http://www.aperture.org/','','2009-08-29 10:59:26',10,1,0,0,0,11,4);
INSERT INTO `yishu_website` VALUES (305,19,'�ܽ��','http://ravenelart.com/','','2009-08-29 11:01:01',40,1,0,0,0,7,2);
INSERT INTO `yishu_website` VALUES (306,19,'��������','http://www.hanhai.net/','','2009-08-29 11:01:14',50,1,0,0,0,8,2);
INSERT INTO `yishu_website` VALUES (307,19,'��������','http://www.chengxuan.com/','','2009-08-29 11:02:44',60,1,0,0,0,8,3);
INSERT INTO `yishu_website` VALUES (308,19,'��������','http://www.huachenauctions.com/','','2009-08-29 11:03:01',70,1,0,0,0,5,2);
INSERT INTO `yishu_website` VALUES (309,19,'�Ϻ���ʢ','http://www.hosane.com/','','2009-08-29 11:04:47',80,1,0,0,0,8,2);
INSERT INTO `yishu_website` VALUES (310,6,'������','http://www.bidpal.cn/','','2009-08-29 11:05:32',280,1,0,0,0,11,4);
INSERT INTO `yishu_website` VALUES (311,16,'�ص�','http://www.cangdian.com/','','2009-08-29 11:08:41',100,1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (312,24,'ɫӰ�޼�','http://www.xitek.com/','','2009-08-29 11:12:54',20,1,0,0,0,15,4);
INSERT INTO `yishu_website` VALUES (313,24,'��ӰͼƬ','http://www.magnumphotos.com/','','2009-08-29 11:14:37',30,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (314,24,'�й���Ӱ����','http://www.cphoto.net/','','2009-08-29 11:15:15',40,1,0,0,0,12,2);
INSERT INTO `yishu_website` VALUES (315,24,'�й���Ӱ����','http://www.cphoto.net/','','2009-08-29 11:15:18',50,1,0,0,0,10,3);
INSERT INTO `yishu_website` VALUES (316,24,'������','http://www.fengniao.com/','','2009-08-29 11:15:59',60,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (317,24,'������Ӱ��','http://www.xiangshu.com/','','2009-08-29 11:16:12',70,1,0,0,0,13,4);
INSERT INTO `yishu_website` VALUES (318,24,'����Ӱ','http://www.nphoto.net/','','2009-08-29 11:16:58',80,1,0,0,0,12,4);
INSERT INTO `yishu_website` VALUES (319,16,'�����ղ���','http://www.hzscp.com/','','2009-08-29 11:18:04',110,1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (320,16,'����ղ���','http://www.tianhuangweb.com/','','2009-08-29 11:19:29',120,1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (321,16,'�����ղ���','http://www.xzscw.com/','','2009-08-29 11:19:38',130,1,0,0,0,0,0);
INSERT INTO `yishu_website` VALUES (322,10,'��ҳ���й����һ�Ժ��','http://www.chinanap.net/','','2009-09-03 11:16:16',330,1,0,0,0,7,6);
INSERT INTO `yishu_website` VALUES (323,10,'������ɽ�黭Ժ','http://www.wsshy.com/','','2009-09-03 11:27:34',340,1,0,0,0,0,0);

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
