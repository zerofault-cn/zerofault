-- phpMyAdmin SQL Dump
-- version 2.6.0-pl3
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost
-- 生成日期: 2005 年 10 月 10 日 11:02
-- 服务器版本: 4.0.21
-- PHP 版本: 4.3.10
-- 
-- 数据库: `cms_sports`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `article`
-- 

CREATE TABLE `article` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `sub_title` varchar(255) NOT NULL default '',
  `create_time` datetime default '0000-00-00 00:00:00',
  `channel_id` smallint(6) NOT NULL default '0',
  `subject_id` smallint(6) NOT NULL default '0',
  `author` varchar(50) NOT NULL default '0',
  `coop_media_id` smallint(6) NOT NULL default '0',
  `media_name` varchar(50) NOT NULL default '',
  `area_id` smallint(6) NOT NULL default '0',
  `view_num` mediumint(9) NOT NULL default '0',
  `comment_num` smallint(6) NOT NULL default '0',
  `score` smallint(6) NOT NULL default '0',
  `user_id` smallint(6) NOT NULL default '0',
  `template_id` smallint(6) NOT NULL default '0',
  `description` varchar(255) NOT NULL default '',
  `visible` tinyint(4) NOT NULL default '0',
  `keyword` varchar(50) NOT NULL default '',
  `mark` tinyint(4) NOT NULL default '0',
  `content_path` varchar(255) NOT NULL default '',
  `special_id` mediumint(9) NOT NULL default '0',
  `special_subject_id` mediumint(9) NOT NULL default '0',
  `is_multi_special` tinyint(4) NOT NULL default '0',
  `rel_blog_path` varchar(255) NOT NULL default '',
  `enable_comment` enum('Y','N') NOT NULL default 'Y',
  `enable_ad` enum('Y','N') NOT NULL default 'Y',
  `static_file_path` varchar(255) NOT NULL default '',
  `remote_static_file_path` varchar(255) NOT NULL default '',
  `remote_url` varchar(255) NOT NULL default '',
  `rss_url` varchar(255) NOT NULL default '',
  `is_rss` enum('Y','N') NOT NULL default 'N',
  PRIMARY KEY  (`id`),
  KEY `mark` (`mark`),
  KEY `area_id` (`area_id`),
  KEY `create_time` (`create_time`),
  KEY `channel_id` (`channel_id`),
  KEY `subject_id` (`subject_id`),
  KEY `coop_media_id` (`coop_media_id`),
  KEY `area_id_2` (`area_id`),
  KEY `view_num` (`view_num`),
  KEY `comment_num` (`comment_num`),
  KEY `user_id` (`user_id`),
  KEY `score` (`score`),
  KEY `special_id` (`special_id`,`special_subject_id`),
  KEY `is_multi_special` (`is_multi_special`),
  KEY `enable_comment` (`enable_comment`,`enable_ad`),
  KEY `is_rss` (`is_rss`)
) TYPE=MyISAM AUTO_INCREMENT=112 ;

-- 
-- 导出表中的数据 `article`
-- 

INSERT INTO `article` VALUES (7, '云南弥勒发生不明爆炸事件 数十人死伤(组图)', '', '2005-09-14 16:29:45', 0, 1, '', 0, '合作媒体', 0, 0, 0, 0, 1, 0, '9月13日，发生爆炸的村子被毁于一旦。9月12日晚11时20分左右，云南省弥勒县沈岗寨发生不明爆炸事件，造成11人死亡，2人失踪，8人重伤，35人轻伤。目前，当地政府正在组织紧急营救，并处理�', 0, '爆炸', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/7.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/7rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-14/017.shtml', '', '', '', 'N');
INSERT INTO `article` VALUES (3, '国家保密局首次公布:天灾死亡数不再作国家秘密', '', '2005-09-13 22:57:31', 0, 1, '', 3, '新华社', 0, 0, 0, 0, 1, 0, '国家保密局首次举行新闻发布会，部分历史自然灾害事件将解密', 0, '天灾 国家保密局', 3, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-13/3.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-13/3rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-13/013.shtml', '', '', '', 'N');
INSERT INTO `article` VALUES (4, '国家保密局首次公布:天灾死亡数不再作国家秘密', '', '2005-09-13 23:13:31', 0, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '国家保密局首次公布:天灾死亡数不再作国家秘密', 0, '保密局 天灾', 3, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-13/4.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-13/4rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-13/014.shtml', '', '', '', 'N');
INSERT INTO `article` VALUES (5, '国家保密局首次举行新闻发布会，部分历史自然灾害事件', '', '2005-09-13 23:17:17', 0, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '国家保密局首次举行新闻发布会，部分历史自然灾害事件将解密', 0, '灾害 国家', 3, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-13/5.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-13/5rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-13/015.shtml', '', '', '', 'N');
INSERT INTO `article` VALUES (6, '部分历史自然灾害事件将解密', '', '2005-09-13 23:20:13', 0, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '国家保密局首次举行新闻发布会，部分历史自然灾害事件将解密', 0, '历史 自然', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-13/6.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-13/6rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-13/016.shtml', '', '', '', 'N');
INSERT INTO `article` VALUES (8, '云南弥勒发生不明爆炸事件 数十人死伤(组图)', '', '2005-09-14 16:31:22', 0, 1, '', 0, '合作媒体', 0, 0, 0, 0, 1, 0, '9月13日，发生爆炸的村子被毁于一旦。9月12日晚11时20分左右，云南省弥勒县沈岗寨发生不明爆炸事件，造成11人死亡，2人失踪，8人重伤，35人轻伤。目前，当地政府正在组织紧急营救，并处理�', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/8.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/8rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-14/018.shtml', '', '', '', 'N');
INSERT INTO `article` VALUES (9, '云南弥勒发生不明爆炸事件 数十人死伤(组图)', '', '2005-09-14 16:32:34', 0, 1, '', 0, '合作媒体', 0, 0, 0, 0, 1, 0, '9月13日，发生爆炸的村子被毁于一旦。9月12日晚11时20分左右，云南省弥勒县沈岗寨发生不明爆炸事件，造成11人死亡，2人失踪，8人重伤，35人轻伤。目前，当地政府正在组织紧急营救，并处理�', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/9.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/9rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-14/019.shtml', '', '', '', 'N');
INSERT INTO `article` VALUES (10, '文章标题', '副标题', '2005-09-14 18:02:54', 0, 2, '作者', 1, '中青报', 0, 0, 0, 0, 1, 0, '摘要摘要摘要摘要摘要', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/10.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/10rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/fc/2005-09-14/0210.shtml', '', '', '', 'N');
INSERT INTO `article` VALUES (11, '文章标题', '副标题', '2005-09-14 18:19:18', 0, 2, '作者', 1, '中青报', 0, 0, 0, 0, 1, 0, '摘要摘要摘要摘要摘要摘要摘要', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/11.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/11rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/2005-09-14/0211.shtml', '', '', '', 'N');
INSERT INTO `article` VALUES (12, '文章标题', '', '2005-09-14 18:23:00', 0, 2, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '关键词关键词', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/12.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/12rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/2005-09-14/0212.shtml', '', '', '', 'N');
INSERT INTO `article` VALUES (13, '文章标题', '副标题', '2005-09-14 18:24:52', 0, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '关键词关键词关键词v', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/13.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/13rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-14/0313.shtml', '', '', '', 'N');
INSERT INTO `article` VALUES (14, '文章标题', '', '2005-09-14 20:35:00', 0, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '摘要摘要摘要', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/14.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/14rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-14/0314.shtml', '', '', '', 'N');
INSERT INTO `article` VALUES (15, '文章标题', '', '2005-09-14 22:13:04', 0, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '摘要摘要摘要摘要', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/15.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/15rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-14/0315.shtml', '', '', '', 'N');
INSERT INTO `article` VALUES (16, '文章标题', '', '2005-09-14 22:13:50', 0, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '摘要摘要摘要摘要v', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/16.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/16rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-14/0316.shtml', '', '', '', 'N');
INSERT INTO `article` VALUES (17, '文章标题', '', '2005-09-14 22:16:43', 0, 3, '作者', 3, '新华社', 0, 0, 0, 0, 1, 0, '关键词关键词关键词关键词', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/17.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/17rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-14/0317.shtml', '', '', '', 'N');
INSERT INTO `article` VALUES (18, '文章标题', '', '2005-09-14 22:17:51', 0, 3, '作者', 1, '中青报', 0, 0, 0, 0, 1, 0, '摘要摘要摘要摘要', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/18.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/18rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-14/0318.shtml', '', '', '', 'N');
INSERT INTO `article` VALUES (19, '文章标题', '', '2005-09-14 22:20:20', 0, 3, '作者', 1, '中青报', 0, 0, 0, 0, 1, 0, '摘要摘要摘要摘要摘要摘要', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/19.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/19rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-14/0319.shtml', '', '', '', 'N');
INSERT INTO `article` VALUES (20, '文章标题', '', '2005-09-14 23:05:03', 0, 3, '作者', 1, '中青报', 0, 0, 0, 0, 1, 0, '摘要摘要摘要摘要v', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/20.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/20rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-14/0320.shtml', '', '', '', 'N');
INSERT INTO `article` VALUES (21, '文章标题', '', '2005-09-14 23:10:41', 0, 3, '作者', 1, '中青报', 0, 0, 0, 0, 1, 0, '关键词关键词关键词关键词关键词关键词关键词', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/21.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/21rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-14/0321.shtml', '', '', '', 'N');
INSERT INTO `article` VALUES (22, '云南弥勒发生不明爆炸事件 数十人死伤(组图)', '', '2005-09-14 23:14:22', 0, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '摘要摘要摘要摘要摘要摘要', 0, '关键词', 2, '', 0, 0, 0, '', 'Y', 'Y', '', '', '', '', 'N');
INSERT INTO `article` VALUES (23, '云南弥勒发生不明爆炸事件 数十人死伤(组图)', '', '2005-09-14 23:17:45', 0, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '9月13日，发生爆炸的村子被毁于一旦。9月12日晚11时20分左右，云南省弥勒县沈岗寨发生不明爆炸事件，造成11人死亡，2人失踪，8人重伤，35人轻伤。目前，当地政府正在组织紧急营救，并处理�', 0, '关键词', 3, '', 0, 0, 0, '', 'Y', 'Y', '', '', '', '', 'N');
INSERT INTO `article` VALUES (24, '云南弥勒发生不明爆炸事件 数十人死伤(组图)', '', '2005-09-14 23:20:50', 0, 3, '作者', 1, '中青报', 0, 0, 0, 0, 1, 0, '9月13日，发生爆炸的村子被毁于一旦。9月12日晚11时20分左右，云南省弥勒县沈岗寨发生不明爆炸事件，造成11人死亡，2人失踪，8人重伤，35人轻伤。目前，当地政府正在组织紧急营救，并处理�', 0, '爆炸', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/24.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-14/24rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-14/0324.shtml', '/html/cms_sport/cf/fc/cman/2005-09-14/0324.shtml', '', '', 'N');
INSERT INTO `article` VALUES (25, '文章标题', '', '2005-09-15 00:03:10', 0, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '摘要摘要摘要摘要', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/25.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/25rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-15/0325.shtml', '/html/cms_sport/cf/fc/cman/2005-09-15/0325.shtml', '', '', 'N');
INSERT INTO `article` VALUES (26, '文章标题', '', '2005-09-15 00:06:53', 0, 3, '', 3, '新华社', 0, 0, 0, 0, 1, 0, '关键词关键词关键词', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/26.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/26rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-15/0326.shtml', '/html/cms_sport/cf/fc/cman/2005-09-15/0326.shtml', '', '', 'N');
INSERT INTO `article` VALUES (27, '文章标题', '', '2005-09-15 00:07:59', 0, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '摘要摘要摘要摘要摘要摘要摘要', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/27.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/27rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-15/0327.shtml', '/html/cms_sport/cf/fc/cman/2005-09-15/0327.shtml', '', '', 'N');
INSERT INTO `article` VALUES (28, '文章标题', '', '2005-09-15 00:17:01', 0, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '关键词关键词关键词关键词', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/28.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/28rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-15/0328.shtml', '/html/cms_sport/cf/fc/cman/2005-09-15/0328.shtml', '', '', 'N');
INSERT INTO `article` VALUES (29, '文章标题', '', '2005-09-15 00:22:57', 0, 3, '', 3, '新华社', 0, 0, 0, 0, 1, 0, '摘要摘要摘要摘要', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/29.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/29rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-15/0329.shtml', '/html/cms_sport/cf/fc/cman/2005-09-15/0329.shtml', '', '', 'N');
INSERT INTO `article` VALUES (30, '文章标题', '副标题', '2005-09-15 00:25:35', 0, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '摘要摘要摘要摘要', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/30.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/30rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-15/0330.shtml', '/html/cms_sport/cf/fc/cman/2005-09-15/0330.shtml', '', '', 'N');
INSERT INTO `article` VALUES (31, '文章标题', '', '2005-09-15 00:38:07', 0, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '摘要摘要摘要', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/31.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/31rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-15/0331.shtml', '/html/cms_sport/cf/fc/cman/2005-09-15/0331.shtml', '', '', 'N');
INSERT INTO `article` VALUES (32, '文章标题', '', '2005-09-15 00:39:20', 0, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '关键词关键词关键词', 0, '关键词', 2, '', 0, 0, 0, '', 'Y', 'Y', '', '', '', '', 'N');
INSERT INTO `article` VALUES (33, '文章标题', '', '2005-09-15 00:40:15', 0, 3, '', 3, '新华社', 0, 0, 0, 0, 1, 0, '关键词关键词关键词', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/33.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/33rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-15/0333.shtml', '/html/cms_sport/cf/fc/cman/2005-09-15/0333.shtml', '', '', 'N');
INSERT INTO `article` VALUES (34, '文章标题', '', '2005-09-15 00:40:57', 0, 3, '', 3, '新华社', 0, 0, 0, 0, 1, 0, '关键词关键词关键词', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/34.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/34rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-15/0334.shtml', '/html/cms_sport/cf/fc/cman/2005-09-15/0334.shtml', '', '', 'N');
INSERT INTO `article` VALUES (35, '文章标题', '', '2005-09-15 00:46:40', 0, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '关键词关键词关键词', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/35.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/35rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-15/0335.shtml', '/html/cms_sport/cf/fc/cman/2005-09-15/0335.shtml', '', '', 'N');
INSERT INTO `article` VALUES (36, '文章标题', '', '2005-09-15 00:47:33', 0, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '关键词关键词关键词', 0, '关键词', 3, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/36.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/36rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-15/0336.shtml', '/html/cms_sport/cf/fc/cman/2005-09-15/0336.shtml', '', '', 'N');
INSERT INTO `article` VALUES (37, '文章标题', '', '2005-09-15 00:55:27', 0, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '关键词关键词关键词', 0, '关键词', 3, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/37.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/37rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-15/0337.shtml', '/html/cms_sport/cf/fc/cman/2005-09-15/0337.shtml', '', '', 'N');
INSERT INTO `article` VALUES (38, '文章标题', '', '2005-09-15 00:57:11', 0, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '关键词关键词关键词关键词', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/38.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/38rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-15/0338.shtml', '/html/cms_sport/cf/fc/cman/2005-09-15/0338.shtml', '', '', 'N');
INSERT INTO `article` VALUES (39, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-15 01:10:37', 0, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/39.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/39rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-15/0339.shtml', '/html/cms_sport/cf/fc/cman/2005-09-15/0339.shtml', '', '', 'N');
INSERT INTO `article` VALUES (40, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-15 01:13:07', 0, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/40.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/40rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-15/0340.shtml', '/html/cms_sport/cf/fc/cman/2005-09-15/0340.shtml', '', '', 'N');
INSERT INTO `article` VALUES (41, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-15 01:37:08', 0, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, '', 0, 0, 0, '', 'Y', 'Y', '', '', '', '', 'N');
INSERT INTO `article` VALUES (42, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-15 01:38:48', 0, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/42.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/42rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-15/0342.shtml', '/html/cms_sport/cf/fc/cman/2005-09-15/0342.shtml', 'http://sport.bokee.com/cf/fc/cman/2005-09-15/0342.shtml', '', 'N');
INSERT INTO `article` VALUES (43, '文章标题', '', '2005-09-15 03:33:26', 25, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '关键词关键词关键词', 0, '关键词', 2, '', 0, 0, 0, '', 'Y', 'Y', '', '', '', '', 'N');
INSERT INTO `article` VALUES (44, '文章标题', '', '2005-09-15 03:35:52', 25, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '关键词关键词关键词', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/44.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/44rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-15/0344.shtml', '/html/cms_sport/cf/fc/cman/2005-09-15/0344.shtml', 'http://sport.bokee.com/cf/fc/cman/2005-09-15/0344.shtml', '', 'N');
INSERT INTO `article` VALUES (45, '文章标题', '', '2005-09-15 03:43:35', 25, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '关键词关键词关键词', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/45.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/45rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-15/0345.shtml', '/html/cms_sport/cf/fc/cman/2005-09-15/0345.shtml', 'http://sport.bokee.com/cf/fc/cman/2005-09-15/0345.shtml', '', 'N');
INSERT INTO `article` VALUES (46, '文章标题', '', '2005-09-15 03:46:11', 25, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '关键词关键词关键词', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/46.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/46rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-15/0346.shtml', '/html/cms_sport/cf/fc/cman/2005-09-15/0346.shtml', 'http://sport.bokee.com/cf/fc/cman/2005-09-15/0346.shtml', '', 'N');
INSERT INTO `article` VALUES (47, '文章标题', '', '2005-09-15 03:47:13', 25, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '摘要摘要摘要', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/47.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/47rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-15/0347.shtml', '/html/cms_sport/cf/fc/cman/2005-09-15/0347.shtml', 'http://sport.bokee.com/cf/fc/cman/2005-09-15/0347.shtml', '', 'N');
INSERT INTO `article` VALUES (48, '文章标题', '', '2005-09-15 04:01:47', 25, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '关键词关键词关键词关键词', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/48.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/48rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-15/0348.shtml', '/html/cms_sport/cf/fc/cman/2005-09-15/0348.shtml', 'http://sport.bokee.com/cf/fc/cman/2005-09-15/0348.shtml', '', 'N');
INSERT INTO `article` VALUES (49, '文章标题', '', '2005-09-15 04:05:35', 25, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '关键词关键词关键词', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/49.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/49rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-15/0349.shtml', '/html/cms_sport/cf/fc/cman/2005-09-15/0349.shtml', 'http://sport.bokee.com/cf/fc/cman/2005-09-15/0349.shtml', '', 'N');
INSERT INTO `article` VALUES (50, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-15 19:49:11', 25, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/50.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/50rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-15/0350.shtml', '/html/cms_sport/cf/fc/cman/2005-09-15/0350.shtml', 'http://sport.bokee.com/cf/fc/cman/2005-09-15/0350.shtml', '', 'N');
INSERT INTO `article` VALUES (51, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-15 19:56:57', 25, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/51.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/51rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-15/0351.shtml', '/html/cms_sport/cf/fc/cman/2005-09-15/0351.shtml', 'http://sport.bokee.com/cf/fc/cman/2005-09-15/0351.shtml', '', 'N');
INSERT INTO `article` VALUES (52, '文章标题', '', '2005-09-15 21:38:56', 25, 3, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '关键词关键词关键词', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/52.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-15/52rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/cman/2005-09-15/0352.shtml', '/html/cms_sport/cf/fc/cman/2005-09-15/0352.shtml', 'http://sport.bokee.com/cf/fc/cman/2005-09-15/0352.shtml', '', 'N');
INSERT INTO `article` VALUES (53, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-16 00:46:15', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-16/53.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-16/53rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/2005-09-16/0153.shtml', '/html/cms_sport/2005-09-16/0153.shtml', 'http://sport.bokee.com/2005-09-16/0153.shtml', '', 'N');
INSERT INTO `article` VALUES (54, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-16 00:48:17', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-16/54.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-16/54rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/2005-09-16/0154.shtml', '/html/cms_sport/2005-09-16/0154.shtml', 'http://sport.bokee.com/2005-09-16/0154.shtml', '', 'N');
INSERT INTO `article` VALUES (55, '文章标题', '', '2005-09-16 01:36:46', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '关键词关键词关键词', 0, '关键词', 2, '', 0, 0, 0, '', 'Y', 'Y', '', '', '', '', 'N');
INSERT INTO `article` VALUES (56, '文章标题', '', '2005-09-16 01:39:29', 25, 2, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '关键词关键词关键词', 0, '关键词', 2, '', 0, 0, 0, '', 'Y', 'Y', '', '', '', '', 'N');
INSERT INTO `article` VALUES (57, '文章标题', '', '2005-09-16 01:40:48', 25, 2, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '关键词关键词关键词', 0, '关键词', 0, '', 0, 0, 0, '', 'Y', 'Y', '', '', '', '', 'N');
INSERT INTO `article` VALUES (58, '文章标题', '', '2005-09-16 01:41:33', 25, 2, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '关键词关键词关键词', 0, '关键词', 0, '', 0, 0, 0, '', 'Y', 'Y', '', '', '', '', 'N');
INSERT INTO `article` VALUES (59, '文章标题', '', '2005-09-16 01:44:46', 25, 2, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '关键词关键词关键词关键词', 0, '关键词', 2, '', 0, 0, 0, '', 'Y', 'Y', '', '', '', '', 'N');
INSERT INTO `article` VALUES (60, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-16 01:46:02', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-16/60.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-16/60rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-16/0160.shtml', '/html/cms_sport/cf/2005-09-16/0160.shtml', 'http://sport.bokee.com/cf/2005-09-16/0160.shtml', '', 'N');
INSERT INTO `article` VALUES (61, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-16 09:30:47', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-16/61.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-16/61rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-16/0161.shtml', '/html/cms_sport/cf/2005-09-16/0161.shtml', 'http://sport.bokee.com/cf/2005-09-16/0161.shtml', '', 'N');
INSERT INTO `article` VALUES (62, '文章标题', '', '2005-09-16 10:27:06', 25, 1, '', 3, '新华社', 0, 0, 0, 0, 1, 0, '摘要摘要摘要摘要', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-16/62.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-16/62rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-16/0162.shtml', '/html/cms_sport/cf/2005-09-16/0162.shtml', 'http://sport.bokee.com/cf/2005-09-16/0162.shtml', '', 'N');
INSERT INTO `article` VALUES (63, '文章标题文章标题', '', '2005-09-27 14:10:22', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '关键词关键词关键词关键词', 0, '关键词', 2, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-27/63.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-27/63rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-27/0163.shtml', '/html/cms_sport/cf/2005-09-27/0163.shtml', 'http://sport.bokee.com/cf/2005-09-27/0163.shtml', '', 'N');
INSERT INTO `article` VALUES (64, '测试转向', '', '2005-09-27 22:21:08', 25, 2, '', 0, '合作媒体', 0, 0, 0, 0, 1, 0, '', 0, '', 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-27/64.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-27/64rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/2005-09-27/0264.shtml', '/html/cms_sport/cf/fc/2005-09-27/0264.shtml', 'http://sport.bokee.com/cf/fc/2005-09-27/0264.shtml', 'http://www.bokee.com', 'Y');
INSERT INTO `article` VALUES (65, '测试 转向', '', '2005-09-27 22:32:50', 25, 2, '', 0, '合作媒体', 0, 0, 0, 0, 1, 0, '', 0, '', 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-27/65.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-27/65rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/2005-09-27/0265.shtml', '/html/cms_sport/cf/fc/2005-09-27/0265.shtml', 'http://sport.bokee.com/cf/fc/2005-09-27/0265.shtml', 'http://www.bokee.com', 'Y');
INSERT INTO `article` VALUES (66, 'fdsafasdf', '', '2005-09-27 22:34:37', 25, 2, '', 0, '合作媒体', 0, 0, 0, 0, 1, 0, '', 0, '', 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-27/66.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-27/66rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/fc/2005-09-27/0266.shtml', '/html/cms_sport/cf/fc/2005-09-27/0266.shtml', 'http://sport.bokee.com/cf/fc/2005-09-27/0266.shtml', 'http://www.bokee.com', 'Y');
INSERT INTO `article` VALUES (67, '文章标题', '', '2005-09-27 23:44:27', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '文章标题文章标题文章标题', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-27/67.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-27/67rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-27/0167.shtml', '/html/cms_sport/cf/2005-09-27/0167.shtml', 'http://sport.bokee.com/cf/2005-09-27/0167.shtml', '', 'N');
INSERT INTO `article` VALUES (68, '文章标题', '', '2005-09-27 23:45:59', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '文章标题文章标题文章标题', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-27/68.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-27/68rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-27/0168.shtml', '/html/cms_sport/cf/2005-09-27/0168.shtml', 'http://sport.bokee.com/cf/2005-09-27/0168.shtml', '', 'N');
INSERT INTO `article` VALUES (69, '文章标题', '', '2005-09-27 23:48:43', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '文章标题文章标题文章标题', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-27/69.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-27/69rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-27/0169.shtml', '/html/cms_sport/cf/2005-09-27/0169.shtml', 'http://sport.bokee.com/cf/2005-09-27/0169.shtml', '', 'N');
INSERT INTO `article` VALUES (70, '文章标题', '', '2005-09-27 23:49:51', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '文章标题文章标题文章标题', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-27/70.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-27/70rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-27/0170.shtml', '/html/cms_sport/cf/2005-09-27/0170.shtml', 'http://sport.bokee.com/cf/2005-09-27/0170.shtml', '', 'N');
INSERT INTO `article` VALUES (71, '文章标题', '', '2005-09-27 23:51:37', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '文章标题文章标题文章标题', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-27/71.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-27/71rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-27/0171.shtml', '/html/cms_sport/cf/2005-09-27/0171.shtml', 'http://sport.bokee.com/cf/2005-09-27/0171.shtml', '', 'N');
INSERT INTO `article` VALUES (72, '文章标题', '', '2005-09-28 10:26:05', 25, 1, '', 0, '合作媒体', 0, 0, 0, 0, 1, 0, '文章标题文章标题文章标题文章标题', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-28/72.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-28/72rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-28/0172.shtml', '/html/cms_sport/cf/2005-09-28/0172.shtml', 'http://sport.bokee.com/cf/2005-09-28/0172.shtml', '', 'N');
INSERT INTO `article` VALUES (73, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 10:48:54', 25, 1, '', 0, '合作媒体', 0, 0, 0, 0, 1, 0, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-28/73.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-28/73rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-28/0173.shtml', '/html/cms_sport/cf/2005-09-28/0173.shtml', 'http://sport.bokee.com/cf/2005-09-28/0173.shtml', '', 'N');
INSERT INTO `article` VALUES (74, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 11:00:58', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-28/74.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-28/74rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-28/0174.shtml', '/html/cms_sport/cf/2005-09-28/0174.shtml', 'http://sport.bokee.com/cf/2005-09-28/0174.shtml', '', 'N');
INSERT INTO `article` VALUES (75, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 11:07:13', 25, 1, '', 0, '合作媒体', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-28/75.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-28/75rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-28/0175.shtml', '/html/cms_sport/cf/2005-09-28/0175.shtml', 'http://sport.bokee.com/cf/2005-09-28/0175.shtml', '', 'N');
INSERT INTO `article` VALUES (76, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 11:08:42', 25, 1, '', 0, '合作媒体', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-28/76.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-28/76rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-28/0176.shtml', '/html/cms_sport/cf/2005-09-28/0176.shtml', 'http://sport.bokee.com/cf/2005-09-28/0176.shtml', '', 'N');
INSERT INTO `article` VALUES (77, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 11:15:01', 25, 1, '', 0, '合作媒体', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-28/77.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-28/77rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-28/0177.shtml', '/html/cms_sport/cf/2005-09-28/0177.shtml', 'http://sport.bokee.com/cf/2005-09-28/0177.shtml', '', 'N');
INSERT INTO `article` VALUES (78, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 11:18:37', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-28/78.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-28/78rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-28/0178.shtml', '/html/cms_sport/cf/2005-09-28/0178.shtml', 'http://sport.bokee.com/cf/2005-09-28/0178.shtml', '', 'N');
INSERT INTO `article` VALUES (79, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 11:19:56', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-28/79.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-28/79rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-28/0179.shtml', '/html/cms_sport/cf/2005-09-28/0179.shtml', 'http://sport.bokee.com/cf/2005-09-28/0179.shtml', '', 'N');
INSERT INTO `article` VALUES (80, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 11:25:47', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-28/80.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-28/80rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-28/0180.shtml', '/html/cms_sport/cf/2005-09-28/0180.shtml', 'http://sport.bokee.com/cf/2005-09-28/0180.shtml', '', 'N');
INSERT INTO `article` VALUES (81, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 11:30:05', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-28/81.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-28/81rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-28/0181.shtml', '/html/cms_sport/cf/2005-09-28/0181.shtml', 'http://sport.bokee.com/cf/2005-09-28/0181.shtml', '', 'N');
INSERT INTO `article` VALUES (82, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 11:33:55', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-28/82.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sport/2005-09-28/82rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sport/cf/2005-09-28/0182.shtml', '/html/cms_sport/cf/2005-09-28/0182.shtml', 'http://sport.bokee.com/cf/2005-09-28/0182.shtml', '', 'N');
INSERT INTO `article` VALUES (83, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 11:57:26', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/83.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/83rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/2005-09-28/0183.shtml', '/html/cms_sports/cf/2005-09-28/0183.shtml', 'http://sports.bokee.com/cf/2005-09-28/0183.shtml', '', 'N');
INSERT INTO `article` VALUES (84, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 11:59:16', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/84.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/84rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/2005-09-28/0184.shtml', '/html/cms_sports/cf/2005-09-28/0184.shtml', 'http://sports.bokee.com/cf/2005-09-28/0184.shtml', '', 'N');
INSERT INTO `article` VALUES (85, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 13:27:44', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/85.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/85rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/2005-09-28/0185.shtml', '/html/cms_sports/cf/2005-09-28/0185.shtml', 'http://sports.bokee.com/cf/2005-09-28/0185.shtml', '', 'N');
INSERT INTO `article` VALUES (86, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 13:31:40', 25, 1, '', 0, '合作媒体', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/86.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/86rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/2005-09-28/0186.shtml', '/html/cms_sports/cf/2005-09-28/0186.shtml', 'http://sports.bokee.com/cf/2005-09-28/0186.shtml', '', 'N');
INSERT INTO `article` VALUES (87, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 13:44:23', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/87.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/87rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/2005-09-28/0187.shtml', '/html/cms_sports/cf/2005-09-28/0187.shtml', 'http://sports.bokee.com/cf/2005-09-28/0187.shtml', '', 'N');
INSERT INTO `article` VALUES (88, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 13:46:29', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 4, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/88.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/88rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/2005-09-28/0188.shtml', '/html/cms_sports/cf/2005-09-28/0188.shtml', 'http://sports.bokee.com/cf/2005-09-28/0188.shtml', '', 'N');
INSERT INTO `article` VALUES (89, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 13:47:08', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/89.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/89rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/2005-09-28/0189.shtml', '/html/cms_sports/cf/2005-09-28/0189.shtml', 'http://sports.bokee.com/cf/2005-09-28/0189.shtml', '', 'N');
INSERT INTO `article` VALUES (90, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 13:48:35', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/90.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/90rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/2005-09-28/0190.shtml', '/html/cms_sports/cf/2005-09-28/0190.shtml', 'http://sports.bokee.com/cf/2005-09-28/0190.shtml', '', 'N');
INSERT INTO `article` VALUES (91, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 18:18:55', 25, 2, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/91.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/91rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/fc/2005-09-28/0291.shtml', '/html/cms_sports/cf/fc/2005-09-28/0291.shtml', 'http://sports.bokee.com/cf/fc/2005-09-28/0291.shtml', '', 'N');
INSERT INTO `article` VALUES (92, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 18:20:56', 25, 2, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/92.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/92rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/fc/2005-09-28/0292.shtml', '/html/cms_sports/cf/fc/2005-09-28/0292.shtml', 'http://sports.bokee.com/cf/fc/2005-09-28/0292.shtml', '', 'N');
INSERT INTO `article` VALUES (93, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 18:22:34', 25, 2, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/93.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/93rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/fc/2005-09-28/0293.shtml', '/html/cms_sports/cf/fc/2005-09-28/0293.shtml', 'http://sports.bokee.com/cf/fc/2005-09-28/0293.shtml', '', 'N');
INSERT INTO `article` VALUES (94, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 18:34:49', 25, 2, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/94.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/94rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/fc/2005-09-28/0294.shtml', '/html/cms_sports/cf/fc/2005-09-28/0294.shtml', 'http://sports.bokee.com/cf/fc/2005-09-28/0294.shtml', '', 'N');
INSERT INTO `article` VALUES (95, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 18:46:59', 25, 2, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/95.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/95rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/fc/2005-09-28/0295.shtml', '/html/cms_sports/cf/fc/2005-09-28/0295.shtml', 'http://sports.bokee.com/cf/fc/2005-09-28/0295.shtml', '', 'N');
INSERT INTO `article` VALUES (96, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 18:48:23', 25, 2, '', 0, '合作媒体', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/96.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/96rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/fc/2005-09-28/0296.shtml', '/html/cms_sports/cf/fc/2005-09-28/0296.shtml', 'http://sports.bokee.com/cf/fc/2005-09-28/0296.shtml', '', 'N');
INSERT INTO `article` VALUES (97, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 18:49:51', 25, 2, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/97.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/97rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/fc/2005-09-28/0297.shtml', '/html/cms_sports/cf/fc/2005-09-28/0297.shtml', 'http://sports.bokee.com/cf/fc/2005-09-28/0297.shtml', '', 'N');
INSERT INTO `article` VALUES (98, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 18:51:51', 25, 2, '', 0, '合作媒体', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/98.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/98rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/fc/2005-09-28/0298.shtml', '/html/cms_sports/cf/fc/2005-09-28/0298.shtml', 'http://sports.bokee.com/cf/fc/2005-09-28/0298.shtml', '', 'N');
INSERT INTO `article` VALUES (99, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 18:53:11', 25, 2, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/99.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/99rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/fc/2005-09-28/0299.shtml', '/html/cms_sports/cf/fc/2005-09-28/0299.shtml', 'http://sports.bokee.com/cf/fc/2005-09-28/0299.shtml', '', 'N');
INSERT INTO `article` VALUES (100, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 21:56:12', 25, 2, '', 3, '新华社', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/100.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/100rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/fc/2005-09-28/02100.shtml', '/html/cms_sports/cf/fc/2005-09-28/02100.shtml', 'http://sports.bokee.com/cf/fc/2005-09-28/02100.shtml', '', 'N');
INSERT INTO `article` VALUES (101, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 22:09:37', 25, 2, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/101.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/101rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/fc/2005-09-28/02101.shtml', '/html/cms_sports/cf/fc/2005-09-28/02101.shtml', 'http://sports.bokee.com/cf/fc/2005-09-28/02101.shtml', '', 'N');
INSERT INTO `article` VALUES (102, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 22:15:57', 25, 2, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/102.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/102rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/fc/2005-09-28/02102.shtml', '/html/cms_sports/cf/fc/2005-09-28/02102.shtml', 'http://sports.bokee.com/cf/fc/2005-09-28/02102.shtml', '', 'N');
INSERT INTO `article` VALUES (103, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-28 23:43:25', 25, 2, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '中新网9月14日电 据路透社报道，伊拉克警方及政府官员称，当地时间今天上午7时，一名自杀炸弹袭击者在巴格达引爆了自已的一辆小型客车，目前已造成至少82人死亡，163人受伤。', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/103.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-28/103rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/fc/2005-09-28/02103.shtml', '/html/cms_sports/cf/fc/2005-09-28/02103.shtml', 'http://sports.bokee.com/cf/fc/2005-09-28/02103.shtml', '', 'N');
INSERT INTO `article` VALUES (104, '李毅：有的人不是人是狼 深圳这支队邪气太盛了', '', '2005-09-29 14:00:08', 25, 2, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '李毅：有的人不是人是狼 深圳这支队邪气太盛了', 0, '深圳', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-29/104.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-29/104rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/fc/2005-09-29/02104.shtml', '/html/cms_sports/cf/fc/2005-09-29/02104.shtml', 'http://sports.bokee.com/cf/fc/2005-09-29/02104.shtml', '', 'N');
INSERT INTO `article` VALUES (105, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-29 15:58:04', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-29/105.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-29/105rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/2005-09-29/01105.shtml', '/html/cms_sports/cf/2005-09-29/01105.shtml', 'http://sports.bokee.com/cf/2005-09-29/01105.shtml', '', 'N');
INSERT INTO `article` VALUES (106, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-29 16:58:44', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-29/106.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-29/106rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/2005-09-29/01106.shtml', '/html/cms_sports/cf/2005-09-29/01106.shtml', 'http://sports.bokee.com/cf/2005-09-29/01106.shtml', '', 'N');
INSERT INTO `article` VALUES (107, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-29 17:16:11', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 0, '关键词', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-29/107.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-29/107rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/2005-09-29/01107.shtml', '/html/cms_sports/cf/2005-09-29/01107.shtml', 'http://sports.bokee.com/cf/2005-09-29/01107.shtml', '', 'N');
INSERT INTO `article` VALUES (108, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-29 17:37:13', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-29/108.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-29/108rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/2005-09-29/01108.shtml', '/html/cms_sports/cf/2005-09-29/01108.shtml', 'http://sports.bokee.com/cf/2005-09-29/01108.shtml', '', 'N');
INSERT INTO `article` VALUES (109, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-30 10:43:50', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-30/109.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-30/109rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/2005-09-30/01109.shtml', '/html/cms_sports/cf/2005-09-30/01109.shtml', 'http://sports.bokee.com/cf/2005-09-30/01109.shtml', '', 'N');
INSERT INTO `article` VALUES (110, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-30 10:45:36', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-30/110.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-30/110rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/2005-09-30/01110.shtml', '/html/cms_sports/cf/2005-09-30/01110.shtml', 'http://sports.bokee.com/cf/2005-09-30/01110.shtml', '', 'N');
INSERT INTO `article` VALUES (111, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', '', '2005-09-30 10:46:45', 25, 1, '', 1, '中青报', 0, 0, 0, 0, 1, 0, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 0, '爆炸', 3, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-30/111.txt', 0, 0, 0, 'D:/GreenAMP/www/CMS/content/cms_sports/2005-09-30/111rel_blog.txt', 'Y', 'Y', 'D:/GreenAMP/www/CMS/web/root/cms_sports/cf/2005-09-30/01111.shtml', '/html/cms_sports/cf/2005-09-30/01111.shtml', 'http://sports.bokee.com/cf/2005-09-30/01111.shtml', '', 'N');

-- --------------------------------------------------------

-- 
-- 表的结构 `flash_images`
-- 

CREATE TABLE `flash_images` (
  `id` mediumint(9) NOT NULL auto_increment,
  `path` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;

-- 
-- 导出表中的数据 `flash_images`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `gallery`
-- 

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `type` varchar(20) NOT NULL default '',
  `path` varchar(255) NOT NULL default '',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `user_id` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- 导出表中的数据 `gallery`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `map_article_special`
-- 

CREATE TABLE `map_article_special` (
  `id` int(11) NOT NULL auto_increment,
  `article_id` int(11) NOT NULL default '0',
  `special_id` mediumint(9) NOT NULL default '0',
  `special_subject_id` mediumint(9) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `article_id` (`article_id`),
  KEY `special_id` (`special_id`),
  KEY `special_subject_id` (`special_subject_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- 导出表中的数据 `map_article_special`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `rel_article_subject`
-- 

CREATE TABLE `rel_article_subject` (
  `id` int(11) NOT NULL auto_increment,
  `article_id` int(11) NOT NULL default '0',
  `subject_id` smallint(6) NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `category` tinyint(4) NOT NULL default '0',
  `datetime` timestamp(14) NOT NULL,
  `source` enum('blog','cms','rss','blogmark','column') NOT NULL default 'blog',
  `mark` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `category` (`category`),
  KEY `datetime` (`datetime`),
  KEY `source` (`source`),
  KEY `mark` (`mark`)
) TYPE=MyISAM AUTO_INCREMENT=67 ;

-- 
-- 导出表中的数据 `rel_article_subject`
-- 

INSERT INTO `rel_article_subject` VALUES (20, 63, 1, '', '', 0, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (21, 66, 2, 'fdsafasdf', 'http://sport.bokee.com/cf/fc/2005-09-27/0266.shtml', 0, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (22, 0, 2, 'JEEP', 'http://www.blogchina.com/1234.htm', 1, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (23, 67, 1, '文章标题', 'http://sport.bokee.com/cf/2005-09-27/0167.shtml', 0, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (24, 68, 1, '文章标题', 'http://sport.bokee.com/cf/2005-09-27/0168.shtml', 0, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (25, 69, 1, '文章标题', 'http://sport.bokee.com/cf/2005-09-27/0169.shtml', 0, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (26, 70, 1, '文章标题', 'http://sport.bokee.com/cf/2005-09-27/0170.shtml', 0, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (27, 71, 1, '文章标题', 'http://sport.bokee.com/cf/2005-09-27/0171.shtml', 0, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (28, 72, 1, '文章标题', 'http://sport.bokee.com/cf/2005-09-28/0172.shtml', 0, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (29, 73, 1, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sport.bokee.com/cf/2005-09-28/0173.shtml', 0, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (30, 74, 1, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sport.bokee.com/cf/2005-09-28/0174.shtml', 0, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (31, 75, 1, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sport.bokee.com/cf/2005-09-28/0175.shtml', 0, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (32, 76, 1, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sport.bokee.com/cf/2005-09-28/0176.shtml', 0, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (33, 77, 1, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sport.bokee.com/cf/2005-09-28/0177.shtml', 0, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (34, 78, 1, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sport.bokee.com/cf/2005-09-28/0178.shtml', 0, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (35, 79, 1, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sport.bokee.com/cf/2005-09-28/0179.shtml', 0, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (36, 80, 1, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sport.bokee.com/cf/2005-09-28/0180.shtml', 0, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (37, 81, 1, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sport.bokee.com/cf/2005-09-28/0181.shtml', 0, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (38, 82, 1, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sport.bokee.com/cf/2005-09-28/0182.shtml', 0, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (39, 83, 1, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/2005-09-28/0183.shtml', 0, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (40, 84, 1, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/2005-09-28/0184.shtml', 0, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (41, 85, 1, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/2005-09-28/0185.shtml', 0, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (42, 86, 1, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/2005-09-28/0186.shtml', 0, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (43, 87, 1, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/2005-09-28/0187.shtml', 0, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (44, 88, 1, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/2005-09-28/0188.shtml', 0, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (45, 89, 1, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/2005-09-28/0189.shtml', 0, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (46, 90, 1, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/2005-09-28/0190.shtml', 0, '00000000000000', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (47, 91, 2, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/fc/2005-09-28/0291.shtml', 0, '20050928181857', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (48, 92, 2, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/fc/2005-09-28/0292.shtml', 0, '20050928182057', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (49, 93, 2, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/fc/2005-09-28/0293.shtml', 0, '20050928182235', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (50, 94, 2, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/fc/2005-09-28/0294.shtml', 0, '20050928183451', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (51, 95, 2, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/fc/2005-09-28/0295.shtml', 0, '20050928184702', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (52, 96, 2, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/fc/2005-09-28/0296.shtml', 0, '20050928184824', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (53, 97, 2, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/fc/2005-09-28/0297.shtml', 0, '20050928184952', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (54, 98, 2, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/fc/2005-09-28/0298.shtml', 0, '20050928185152', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (55, 99, 2, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/fc/2005-09-28/0299.shtml', 0, '20050928185315', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (56, 100, 2, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/fc/2005-09-28/02100.shtml', 0, '20050928215616', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (57, 101, 2, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/fc/2005-09-28/02101.shtml', 0, '20050928220938', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (58, 102, 2, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/fc/2005-09-28/02102.shtml', 0, '20050928221600', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (59, 103, 2, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/fc/2005-09-28/02103.shtml', 0, '20050928234329', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (60, 104, 2, '李毅：有的人不是人是狼 深圳这支队邪气太盛了', 'http://sports.bokee.com/cf/fc/2005-09-29/02104.shtml', 0, '20050929140012', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (61, 105, 1, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/2005-09-29/01105.shtml', 0, '20050929155809', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (62, 106, 1, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/2005-09-29/01106.shtml', 0, '20050929165846', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (63, 107, 1, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/2005-09-29/01107.shtml', 0, '20050929171612', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (64, 108, 1, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/2005-09-29/01108.shtml', 0, '20050929173714', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (65, 110, 1, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/2005-09-30/01110.shtml', 0, '20050930104554', 'blog', 0);
INSERT INTO `rel_article_subject` VALUES (66, 111, 1, '巴格达爆炸82死163伤 自杀袭击者谎称招聘工人', 'http://sports.bokee.com/cf/2005-09-30/01111.shtml', 0, '20050930104702', 'blog', 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `rss_entry_attach`
-- 

CREATE TABLE `rss_entry_attach` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `entry_id` int(11) NOT NULL default '0',
  `feed_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `datetime` (`datetime`),
  KEY `entry_id` (`entry_id`),
  KEY `feed_id` (`feed_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- 导出表中的数据 `rss_entry_attach`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `rss_feed_attach`
-- 

CREATE TABLE `rss_feed_attach` (
  `id` int(11) NOT NULL auto_increment,
  `feed_id` int(11) NOT NULL default '0',
  `subject_id` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `feed_id` (`feed_id`),
  KEY `subject_id` (`subject_id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

-- 
-- 导出表中的数据 `rss_feed_attach`
-- 

INSERT INTO `rss_feed_attach` VALUES (1, 28, 3);

-- --------------------------------------------------------

-- 
-- 表的结构 `special`
-- 

CREATE TABLE `special` (
  `id` mediumint(9) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `dir_name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- 导出表中的数据 `special`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `special_subject`
-- 

CREATE TABLE `special_subject` (
  `id` mediumint(9) NOT NULL auto_increment,
  `special_id` mediumint(9) NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `special_id` (`special_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- 导出表中的数据 `special_subject`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `subject`
-- 

CREATE TABLE `subject` (
  `id` smallint(6) NOT NULL auto_increment,
  `parent_id` smallint(6) NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  `dir_name` varchar(50) NOT NULL default '',
  `sort` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `sort` (`sort`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;

-- 
-- 导出表中的数据 `subject`
-- 

INSERT INTO `subject` VALUES (1, 0, '足球', 'cf', 1);
INSERT INTO `subject` VALUES (2, 1, '国内足球', 'fc', 2);
INSERT INTO `subject` VALUES (3, 2, '国内男足', 'cman', 3);
INSERT INTO `subject` VALUES (4, 2, '国内女足', 'cwf', 3);

-- --------------------------------------------------------

-- 
-- 表的结构 `template`
-- 

CREATE TABLE `template` (
  `id` smallint(6) NOT NULL auto_increment,
  `special_id` smallint(6) NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  `path` varchar(255) NOT NULL default '',
  `file_name` varchar(50) NOT NULL default '',
  `sort` tinyint(4) NOT NULL default '0',
  `is_default` enum('Y','N') NOT NULL default 'N',
  `subject_id` smallint(6) NOT NULL default '0',
  `special_subject_id` mediumint(9) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `channel_id` (`special_id`),
  KEY `sort` (`sort`),
  KEY `is_default` (`is_default`),
  KEY `subject_id` (`subject_id`),
  KEY `special_subject_id` (`special_subject_id`)
) TYPE=MyISAM AUTO_INCREMENT=23 ;

-- 
-- 导出表中的数据 `template`
-- 

INSERT INTO `template` VALUES (21, 0, 'test', 'D:/GreenAMP/www/CMS/WEB-INF/html/templates/init/cms_sports/21.html', 'test.shtml', 0, 'N', 0, 0);
INSERT INTO `template` VALUES (22, 0, 'fsdf', 'D:/GreenAMP/www/CMS/WEB-INF/html/templates/init/cms_sports/22.html', 'sdfsd.shtml', 0, 'N', 0, 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `template_block`
-- 

CREATE TABLE `template_block` (
  `id` mediumint(9) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `content` varchar(255) NOT NULL default '',
  `template_id` smallint(6) NOT NULL default '0',
  `format` varchar(255) NOT NULL default '',
  `subject_id` smallint(6) NOT NULL default '0',
  `source` varchar(255) NOT NULL default '',
  `num` smallint(6) NOT NULL default '0',
  `mark` tinyint(4) NOT NULL default '0',
  `selected_subject_id` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `template_id` (`template_id`),
  KEY `subject_id` (`subject_id`),
  KEY `mark` (`mark`),
  KEY `selected_subject_id` (`selected_subject_id`)
) TYPE=MyISAM AUTO_INCREMENT=7 ;

-- 
-- 导出表中的数据 `template_block`
-- 

INSERT INTO `template_block` VALUES (1, 'list', 'SELECT title, create_time FROM article WHERE subject_id = 1 ORDER BY title DESC LIMIT 5', 0, '{title}{create_time}', 0, '', 0, 0, 0);
INSERT INTO `template_block` VALUES (2, 'lista', 'SELECT remote_url, title FROM article WHERE subject_id = 1 ORDER BY create_time DESC LIMIT 10', 0, '<span>0评</span>·<a href="{remote_url}">{title}</a>', 0, '', 0, 0, 0);
INSERT INTO `template_block` VALUES (5, 'fsfsdf', 'select * from rel_article_subject where source in (''cms'',''rss'') and subject_id in (2,4,3) and mark>=1 order by datetime desc limit 15', 0, '<li><a href={url}>{title}</a></li>', 2, '''cms'',''rss''', 15, 1, 2);
INSERT INTO `template_block` VALUES (6, 'fsfsdf', 'select * from rel_article_subject where source in (''cms'',''rss's',''blog'') and subject_id in (2,4,3) and mark>=1 order by datetime desc limit 15', 0, '<li><a href={url}>{title}</a></li>', 2, '''cms'',''rss'',''blog''', 15, 1, 2);

-- --------------------------------------------------------

-- 
-- 表的结构 `template_slash`
-- 

CREATE TABLE `template_slash` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `template_id` smallint(6) NOT NULL default '0',
  `content` text NOT NULL,
  `category` enum('image','text','ad','block') NOT NULL default 'text',
  `block_id` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `template_id` (`template_id`),
  KEY `category` (`category`),
  KEY `block_id` (`block_id`)
) TYPE=MyISAM AUTO_INCREMENT=17 ;

-- 
-- 导出表中的数据 `template_slash`
-- 

INSERT INTO `template_slash` VALUES (16, 'fdsfsdf', 22, '<img src="images/ty_151.gif" alt="ad" />', 'image', 1);

-- 
-- 表的结构 `header`
-- 

CREATE TABLE `header` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `subject_id` int(11) NOT NULL default '0',
  `content` text NOT NULL,
  `image_url` varchar(255) NOT NULL default '',
  `image_link` varchar(255) NOT NULL default '',
  `child_id` varchar(255) NOT NULL default '0',
  `parent_id` varchar(255) NOT NULL default '0',
  `choice` enum('Y','N') NOT NULL default 'N',
  `update_date` datetime default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=128 ;

-- 
-- 导出表中的数据 `header`
-- 

CREATE TABLE `flash` (
  `id` int(11) NOT NULL auto_increment,
  `upload_path` varchar(255) NOT NULL default '',
  `flash_name` varchar(255) NOT NULL default '',
  `xml_name` varchar(255) NOT NULL default '',
  `css_name` varchar(255) NOT NULL default '',
  `pic_dir` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=23 ;
