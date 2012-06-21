set names utf8;

DROP TABLE IF EXISTS `zs_admin`;
CREATE TABLE `zs_admin` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(255) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `realname` varchar(255) NOT NULL default '',
  `role` varchar(255) NOT NULL default '',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `login_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统用户';

INSERT INTO `zs_admin` VALUES (1,'admin','32bb79e5a88829bfd6b94085067ace49','管理员','','0000-00-00 00:00:00','2012-06-12 14:52:42',1);


DROP TABLE IF EXISTS `zs_article`;
CREATE TABLE `zs_article` (
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


DROP TABLE IF EXISTS `zs_attachment`;
CREATE TABLE `zs_attachment` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '' COMMENT '文件原名',
  `type` varchar(255) NOT NULL default '' COMMENT '文件类型',
  `size` int(10) unsigned NOT NULL default '0' COMMENT '文件大小',
  `path` varchar(255) NOT NULL default '' COMMENT '保存路径',
  `model_name` varchar(255) NOT NULL default '' COMMENT '所属Model名',
  `model_id` int(10) unsigned NOT NULL default '0' COMMENT '所属Model的ID',
  `user_id` int(10) unsigned NOT NULL default '0' COMMENT '所属Owner',
  `upload_time` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '上传时间',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='附件文件';


DROP TABLE IF EXISTS `zs_book`;
CREATE TABLE `zs_book` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `category_id` smallint(5) unsigned NOT NULL default '0' COMMENT '酒店或婚礼',
  `region_id` smallint(5) unsigned NOT NULL default '0' COMMENT '区域ID',
  `hotel_id` smallint(5) unsigned NOT NULL default '0' COMMENT '酒店ID',
  `hotel_keyword` varchar(255) NOT NULL default '' COMMENT '酒店关键字',
  `begin_date` date NOT NULL default '0000-00-00' COMMENT '入住日期',
  `end_date` date NOT NULL default '0000-00-00' COMMENT '离开日期',
  `number` smallint(5) unsigned NOT NULL default '0' COMMENT '宴会桌数或人数',
  `level` varchar(255) NOT NULL default '' COMMENT '酒店等级',
  `name` varchar(255) NOT NULL default '',
  `phone` varchar(255) NOT NULL default '',
  `demand` text NOT NULL,
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '创建时间',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='预订';


DROP TABLE IF EXISTS `zs_category`;
CREATE TABLE `zs_category` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `pid` smallint(5) unsigned NOT NULL default '0',
  `type` varchar(255) NOT NULL default '' COMMENT '酒店或文章',
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL default '',
  `sort` smallint(5) unsigned NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='类别';


INSERT INTO `zs_category` VALUES (1,0,'Hotel','宴会酒店','banquet',1,1);
INSERT INTO `zs_category` VALUES (2,0,'Hotel','会议酒店','meeting',2,1);
INSERT INTO `zs_category` VALUES (3,0,'Article','浪漫婚礼','wedding',3,1);
INSERT INTO `zs_category` VALUES (4,0,'Article','商业活动','business',4,1);
INSERT INTO `zs_category` VALUES (5,0,'Article','会务服务','affair',5,1);
INSERT INTO `zs_category` VALUES (6,0,'Article','展会策划','exhibition',6,1);
INSERT INTO `zs_category` VALUES (7,0,'Article','最新动态','news',7,1);
INSERT INTO `zs_category` VALUES (8,0,'Article','关于致尚','about',8,1);
INSERT INTO `zs_category` VALUES (9,7,'Article','致尚优惠','',9,1);
INSERT INTO `zs_category` VALUES (10,7,'Article','会议新闻','',10,1);
INSERT INTO `zs_category` VALUES (11,7,'Article','会展新闻','',11,1);


DROP TABLE IF EXISTS `zs_district`;
CREATE TABLE `zs_district` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `pid` smallint(5) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `sort` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商业区域';


INSERT INTO `zs_district` VALUES (1,2,'夷陵广场',1);
INSERT INTO `zs_district` VALUES (2,2,'时代广场',2);


DROP TABLE IF EXISTS `zs_hotel`;
CREATE TABLE `zs_hotel` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '' COMMENT '酒店名称',
  `address` varchar(255) NOT NULL default '',
  `category_id` tinyint(3) unsigned NOT NULL default '0',
  `region_id` smallint(5) unsigned NOT NULL default '0' COMMENT '行政区',
  `district_id` smallint(5) unsigned NOT NULL default '0' COMMENT '商业区',
  `level_id` tinyint(3) unsigned NOT NULL default '0' COMMENT '星级',
  `capacity` smallint(5) unsigned NOT NULL default '0' COMMENT '承接能力',
  `introduction` text NOT NULL COMMENT '介绍',
  `addtime` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '添加时间',
  `sort` smallint(6) NOT NULL default '0',
  `view` int(10) unsigned NOT NULL default '0' COMMENT '浏览人气',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='酒店';


DROP TABLE IF EXISTS `zs_level`;
CREATE TABLE `zs_level` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `sort` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商业区域';


INSERT INTO `zs_level` VALUES (1,'5星',0);
INSERT INTO `zs_level` VALUES (2,'4星',0);
INSERT INTO `zs_level` VALUES (3,'3星',0);
INSERT INTO `zs_level` VALUES (4,'2星',0);
INSERT INTO `zs_level` VALUES (5,'1星',0);


DROP TABLE IF EXISTS `zs_region`;
CREATE TABLE `zs_region` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `pid` smallint(5) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `sort` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='行政区域';


INSERT INTO `zs_region` VALUES (1,0,'湖北省',0);
INSERT INTO `zs_region` VALUES (2,1,'宜昌市',0);
INSERT INTO `zs_region` VALUES (3,2,'夷陵区',0);
INSERT INTO `zs_region` VALUES (4,2,'西陵区',0);
INSERT INTO `zs_region` VALUES (5,2,'伍家岗区',0);
INSERT INTO `zs_region` VALUES (6,2,'点军区',0);
INSERT INTO `zs_region` VALUES (7,2,'猇亭区',0);
