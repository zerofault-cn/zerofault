-- phpMyAdmin SQL Dump
-- version 2.6.0-pl3
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost
-- 生成日期: 2005 年 10 月 08 日 09:24
-- 服务器版本: 4.0.21
-- PHP 版本: 4.3.10
-- 
-- 数据库: `cms`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `area`
-- 

CREATE TABLE `area` (
  `id` smallint(6) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- 导出表中的数据 `area`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `channel`
-- 

CREATE TABLE `channel` (
  `id` smallint(6) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `dir_name` varchar(50) NOT NULL default '',
  `db_host` varchar(100) NOT NULL default '211.152.20.34',
  `db_port` varchar(10) NOT NULL default '3306',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

-- 
-- 导出表中的数据 `channel`
-- 

INSERT INTO `channel` VALUES (25, '体育频道', 'sports');

-- --------------------------------------------------------

-- 
-- 表的结构 `coop_media`
-- 

CREATE TABLE `coop_media` (
  `id` smallint(6) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `linkman` varchar(20) NOT NULL default '',
  `phone` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;

-- 
-- 导出表中的数据 `coop_media`
-- 

INSERT INTO `coop_media` VALUES (1, '中青报', 'http://www.young.com', '于敦德', '51818811');
INSERT INTO `coop_media` VALUES (3, '新华社', 'http://www.news.com', '于敦德', '4324234');

-- --------------------------------------------------------

-- 
-- 表的结构 `login_log`
-- 

CREATE TABLE `login_log` (
  `id` int(11) NOT NULL auto_increment,
  `user_name` varchar(50) NOT NULL default '',
  `login_time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `login_time` (`login_time`)
) TYPE=MyISAM AUTO_INCREMENT=93 ;

-- 
-- 导出表中的数据 `login_log`
-- 

INSERT INTO `login_log` VALUES (1, 'yudunde', '2005-08-29 16:03:49');
INSERT INTO `login_log` VALUES (2, 'yudunde', '2005-08-29 16:08:51');
INSERT INTO `login_log` VALUES (3, 'yudunde', '2005-08-30 13:34:10');
INSERT INTO `login_log` VALUES (4, 'yudunde', '2005-08-30 13:57:22');
INSERT INTO `login_log` VALUES (5, 'yudunde', '2005-08-30 17:37:43');
INSERT INTO `login_log` VALUES (6, 'yudunde', '2005-08-30 18:10:59');
INSERT INTO `login_log` VALUES (7, 'yudunde', '2005-08-31 11:37:43');
INSERT INTO `login_log` VALUES (8, 'yudunde', '2005-08-31 17:53:48');
INSERT INTO `login_log` VALUES (9, 'yudunde', '2005-08-31 22:00:31');
INSERT INTO `login_log` VALUES (10, 'yudunde', '2005-09-01 14:28:29');
INSERT INTO `login_log` VALUES (11, 'yudunde', '2005-09-01 14:46:45');
INSERT INTO `login_log` VALUES (12, 'xiangjing', '2005-09-01 15:23:11');
INSERT INTO `login_log` VALUES (13, 'yudunde', '2005-09-01 15:23:37');
INSERT INTO `login_log` VALUES (14, 'yudunde', '2005-09-01 15:38:13');
INSERT INTO `login_log` VALUES (15, 'xiangjing', '2005-09-01 15:39:14');
INSERT INTO `login_log` VALUES (16, 'yudunde', '2005-09-01 15:39:54');
INSERT INTO `login_log` VALUES (17, 'yudunde', '2005-09-03 16:18:32');
INSERT INTO `login_log` VALUES (18, 'yudunde', '2005-09-04 14:33:38');
INSERT INTO `login_log` VALUES (19, 'yudunde', '2005-09-05 11:14:58');
INSERT INTO `login_log` VALUES (20, 'yudunde', '2005-09-05 15:39:31');
INSERT INTO `login_log` VALUES (21, 'yudunde', '2005-09-05 16:45:03');
INSERT INTO `login_log` VALUES (22, 'yudunde', '2005-09-05 16:45:12');
INSERT INTO `login_log` VALUES (23, 'yudunde', '2005-09-06 14:56:11');
INSERT INTO `login_log` VALUES (24, 'yudunde', '2005-09-06 15:32:13');
INSERT INTO `login_log` VALUES (25, 'yudunde', '2005-09-06 17:16:10');
INSERT INTO `login_log` VALUES (26, 'yudunde', '2005-09-06 17:37:49');
INSERT INTO `login_log` VALUES (27, 'yudunde', '2005-09-06 18:35:39');
INSERT INTO `login_log` VALUES (28, 'yudunde', '2005-09-07 15:17:41');
INSERT INTO `login_log` VALUES (29, 'yudunde', '2005-09-07 16:49:14');
INSERT INTO `login_log` VALUES (30, 'yudunde', '2005-09-07 22:53:31');
INSERT INTO `login_log` VALUES (31, 'yudunde', '2005-09-08 12:50:19');
INSERT INTO `login_log` VALUES (32, 'yudunde', '2005-09-08 20:00:29');
INSERT INTO `login_log` VALUES (33, 'yudunde', '2005-09-10 19:35:10');
INSERT INTO `login_log` VALUES (34, 'yudunde', '2005-09-10 20:14:26');
INSERT INTO `login_log` VALUES (35, 'yudunde', '2005-09-11 00:49:48');
INSERT INTO `login_log` VALUES (36, 'yudunde', '2005-09-11 01:23:59');
INSERT INTO `login_log` VALUES (37, 'yudunde', '2005-09-11 15:07:29');
INSERT INTO `login_log` VALUES (38, 'yudunde', '2005-09-11 20:43:13');
INSERT INTO `login_log` VALUES (39, 'yudunde', '2005-09-11 20:44:02');
INSERT INTO `login_log` VALUES (40, 'yudunde', '2005-09-11 20:44:45');
INSERT INTO `login_log` VALUES (41, 'yudunde', '2005-09-11 20:44:58');
INSERT INTO `login_log` VALUES (42, 'yudunde', '2005-09-11 20:54:54');
INSERT INTO `login_log` VALUES (43, 'yudunde', '2005-09-11 20:56:01');
INSERT INTO `login_log` VALUES (44, 'yudunde', '2005-09-11 20:57:36');
INSERT INTO `login_log` VALUES (45, 'yudunde', '2005-09-11 20:57:44');
INSERT INTO `login_log` VALUES (46, 'yudunde', '2005-09-11 21:44:56');
INSERT INTO `login_log` VALUES (47, 'yudunde', '2005-09-11 23:59:25');
INSERT INTO `login_log` VALUES (48, 'yudunde', '2005-09-11 23:59:28');
INSERT INTO `login_log` VALUES (49, 'yudunde', '2005-09-11 23:59:59');
INSERT INTO `login_log` VALUES (50, 'yudunde', '2005-09-12 00:00:03');
INSERT INTO `login_log` VALUES (51, 'yudunde', '2005-09-12 00:00:41');
INSERT INTO `login_log` VALUES (52, 'yudunde', '2005-09-12 00:00:53');
INSERT INTO `login_log` VALUES (53, 'yudunde', '2005-09-12 00:01:08');
INSERT INTO `login_log` VALUES (54, 'yudunde', '2005-09-12 10:34:34');
INSERT INTO `login_log` VALUES (55, 'yudunde', '2005-09-12 11:03:42');
INSERT INTO `login_log` VALUES (56, 'yudunde', '2005-09-12 11:34:29');
INSERT INTO `login_log` VALUES (57, 'yudunde', '2005-09-12 13:57:58');
INSERT INTO `login_log` VALUES (58, 'yudunde', '2005-09-12 18:45:38');
INSERT INTO `login_log` VALUES (59, 'yudunde', '2005-09-12 19:59:27');
INSERT INTO `login_log` VALUES (60, 'yudunde', '2005-09-12 22:44:03');
INSERT INTO `login_log` VALUES (61, 'yudunde', '2005-09-13 14:05:09');
INSERT INTO `login_log` VALUES (62, 'tester', '2005-09-13 14:23:31');
INSERT INTO `login_log` VALUES (63, 'yudunde', '2005-09-13 14:37:48');
INSERT INTO `login_log` VALUES (64, 'yudunde', '2005-09-13 17:31:35');
INSERT INTO `login_log` VALUES (65, 'yudunde', '2005-09-14 14:21:48');
INSERT INTO `login_log` VALUES (66, 'yudunde', '2005-09-15 15:16:45');
INSERT INTO `login_log` VALUES (67, 'liutao', '2005-09-16 00:03:30');
INSERT INTO `login_log` VALUES (68, 'yudunde', '2005-09-16 00:04:44');
INSERT INTO `login_log` VALUES (69, 'yudunde', '2005-09-16 04:39:28');
INSERT INTO `login_log` VALUES (70, 'yudunde', '2005-09-16 09:28:02');
INSERT INTO `login_log` VALUES (71, 'yudunde', '2005-09-16 10:45:31');
INSERT INTO `login_log` VALUES (72, 'yudunde', '2005-09-19 13:45:34');
INSERT INTO `login_log` VALUES (73, 'yudunde', '2005-09-24 11:57:59');
INSERT INTO `login_log` VALUES (74, 'yudunde', '2005-09-25 16:42:24');
INSERT INTO `login_log` VALUES (75, 'yudunde', '2005-09-25 23:55:55');
INSERT INTO `login_log` VALUES (76, 'yudunde', '2005-09-26 13:02:06');
INSERT INTO `login_log` VALUES (77, 'yudunde', '2005-09-26 14:00:08');
INSERT INTO `login_log` VALUES (78, 'yudunde', '2005-09-26 14:01:11');
INSERT INTO `login_log` VALUES (79, 'yudunde', '2005-09-26 21:01:36');
INSERT INTO `login_log` VALUES (80, 'yudunde', '2005-09-27 09:55:21');
INSERT INTO `login_log` VALUES (81, 'yudunde', '2005-09-28 10:25:35');
INSERT INTO `login_log` VALUES (82, 'yudunde', '2005-09-28 21:17:50');
INSERT INTO `login_log` VALUES (83, 'yudunde', '2005-09-28 23:42:52');
INSERT INTO `login_log` VALUES (84, 'yudunde', '2005-09-29 13:59:44');
INSERT INTO `login_log` VALUES (85, 'yudunde', '2005-09-29 15:57:43');
INSERT INTO `login_log` VALUES (86, 'yudunde', '2005-09-30 10:43:29');
INSERT INTO `login_log` VALUES (87, 'yudunde', '2005-09-30 15:35:43');
INSERT INTO `login_log` VALUES (88, 'yudunde', '2005-10-02 16:22:23');
INSERT INTO `login_log` VALUES (89, 'yudunde', '2005-10-02 17:08:32');
INSERT INTO `login_log` VALUES (90, 'yudunde', '2005-10-03 15:08:33');
INSERT INTO `login_log` VALUES (91, 'yudunde', '2005-10-05 00:59:48');
INSERT INTO `login_log` VALUES (92, 'yudunde', '2005-10-05 22:48:34');

-- --------------------------------------------------------

-- 
-- 表的结构 `role`
-- 

CREATE TABLE `role` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- 导出表中的数据 `role`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `rss_article`
-- 

CREATE TABLE `rss_article` (
  `id` int(11) NOT NULL auto_increment,
  `url` varchar(100) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `pub_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `feed_title` varchar(255) NOT NULL default '',
  `feed_url` varchar(100) NOT NULL default '',
  `source` enum('blog','cms','rss','blogmark','column') NOT NULL default 'blog',
  PRIMARY KEY  (`id`),
  KEY `pubdate` (`pub_date`),
  KEY `source` (`source`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

-- 
-- 导出表中的数据 `rss_article`
-- 

INSERT INTO `rss_article` VALUES (2, 'http://www.blogchina.com/1234.htm', 'JEEP', '2005-06-15 00:00:00', 'donald blog', 'http://www.blogchina.com/1234.htm', 'blog');

-- --------------------------------------------------------

-- 
-- 表的结构 `user`
-- 

CREATE TABLE `user` (
  `id` smallint(6) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `real_name` varchar(50) NOT NULL default '',
  `password` varchar(50) NOT NULL default '',
  `last_login` datetime NOT NULL default '0000-00-00 00:00:00',
  `article_num` mediumint(9) NOT NULL default '0',
  `create_time` datetime default '0000-00-00 00:00:00',
  `email` varchar(50) NOT NULL default '',
  `cellphone` varchar(20) NOT NULL default '',
  `role_id` tinyint(4) NOT NULL default '0',
  `rss_user_id` int(11) NOT NULL default '102746',
  PRIMARY KEY  (`id`),
  KEY `role_id` (`role_id`),
  KEY `create_time` (`create_time`),
  KEY `article_num` (`article_num`),
  KEY `last_login` (`last_login`)
) TYPE=MyISAM AUTO_INCREMENT=10 ;

-- 
-- 导出表中的数据 `user`
-- 

INSERT INTO `user` VALUES (1, 'yudunde', '于敦德', 'e10adc3949ba59abbe56e057f20f883e', '2005-10-05 22:48:34', 0, '2005-08-17 00:00:00', 'yudunde@bokee.com', '13366839361', 0, 102746);
INSERT INTO `user` VALUES (9, 'liutao', '刘涛', 'e10adc3949ba59abbe56e057f20f883e', '2005-09-16 00:03:30', 0, '2005-09-16 00:03:19', 'liutao@bokee.com', '4324234423', 3, 0);
INSERT INTO `user` VALUES (7, 'fasdfds', 'fasdf', 'e10adc3949ba59abbe56e057f20f883e', '0000-00-00 00:00:00', 0, '2005-09-12 20:57:53', 'fasdfasdfasdf', '421342342', 3, 0);
INSERT INTO `user` VALUES (8, 'tester', '测试', 'e10adc3949ba59abbe56e057f20f883e', '2005-09-13 14:23:31', 0, '2005-09-13 14:23:21', 'test@bokee.com', '521343241', 3, 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `user_channel`
-- 

CREATE TABLE `user_channel` (
  `id` smallint(6) NOT NULL auto_increment,
  `user_id` smallint(6) NOT NULL default '0',
  `channel_id` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`,`channel_id`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;

-- 
-- 导出表中的数据 `user_channel`
-- 

INSERT INTO `user_channel` VALUES (1, 1, 1);
INSERT INTO `user_channel` VALUES (2, 7, 1);
INSERT INTO `user_channel` VALUES (3, 8, 1);
INSERT INTO `user_channel` VALUES (4, 9, 1);
        