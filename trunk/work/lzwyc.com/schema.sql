
DROP TABLE IF EXISTS `lzwyc_admin`;
CREATE TABLE `lzwyc_admin` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(255) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `realname` varchar(255) NOT NULL default '',
  `role` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统用户';


DROP TABLE IF EXISTS `lzwyc_article`;
CREATE TABLE `lzwyc_article` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `category_id` tinyint(3) NOT NULL default '0' COMMENT '类别',
  `title` varchar(255) NOT NULL default '' COMMENT '标题',
  `tags` varchar(255) NOT NULL default '' COMMENT '标签',
  `source` varchar(255) NOT NULL default '' COMMENT '来源',
  `content` text NOT NULL COMMENT '内容',
  `sort` int(11) unsigned NOT NULL default '0' COMMENT '显示排序',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '添加时间',
  `modify_time` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '修改时间',
  `view` int(11) unsigned NOT NULL default '0' COMMENT '查看次数',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章';

DROP TABLE IF EXISTS `lzwyc_attachment`;
CREATE TABLE `lzwyc_attachment` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '' COMMENT '文件原名',
  `type` varchar(255) NOT NULL default '' COMMENT '文件类型',
  `size` int(11) NOT NULL default '0' COMMENT '文件大小',
  `path` varchar(255) NOT NULL default '' COMMENT '保存路径',
  `model_name` varchar(255) NOT NULL default '' COMMENT '所属Model名',
  `model_id` int(11) NOT NULL default '0' COMMENT '所属Model的ID',
  `staff_id` int(11) NOT NULL default '0' COMMENT '所属Owner',
  `upload_time` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '上传时间',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;


DROP TABLE IF EXISTS `lzwyc_company`;
CREATE TABLE `lzwyc_company` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '' COMMENT '公司名称',
  `address` varchar(255) NOT NULL default '' COMMENT '公司地址',
  `mobile` varchar(255) NOT NULL default '' COMMENT '手机',
  `telephone` varchar(255) NOT NULL default '' COMMENT '电话',
  `introduction` text NOT NULL COMMENT '公司介绍',
  `sort` int(11) NOT NULL default '0' COMMENT '显示排序',
  `addtime` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '添加时间',
  `view` int(11) NOT NULL default '0' COMMENT '查看次数',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='装修公司';


DROP TABLE IF EXISTS `lzwyc_designer`;
CREATE TABLE `lzwyc_designer` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '' COMMENT '姓名',
  `feature` varchar(255) NOT NULL default '' COMMENT '专长',
  `workdate` date NOT NULL default '0000-00-00' COMMENT '入行日期',
  `title` varchar(255) NOT NULL default '' COMMENT '职位',
  `introduction` text NOT NULL COMMENT '个人简介',
  `sort` int(11) NOT NULL default '0' COMMENT '显示排序',
  `addtime` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '添加时间',
  `view` int(11) NOT NULL default '0' COMMENT '查看次数',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='设计师';


DROP TABLE IF EXISTS `lzwyc_feedback`;
CREATE TABLE `lzwyc_feedback` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `company_id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `phone` varchar(255) NOT NULL default '',
  `ccontent` text NOT NULL,
  `ip` varchar(255) NOT NULL default '',
  `addtime` datetime NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='留言咨询';


DROP TABLE IF EXISTS `lzwyc_invite`;
CREATE TABLE `lzwyc_invite` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0' COMMENT '客户ID',
  `district` smallint(5) unsigned NOT NULL default '0' COMMENT '地区',
  `address` varchar(255) NOT NULL default '' COMMENT '详细地址',
  `type` tinyint(3) unsigned NOT NULL default '0' COMMENT '装修类型',
  `space` tinyint(3) unsigned NOT NULL default '0' COMMENT '空间',
  `room` tinyint(3) unsigned NOT NULL default '0' COMMENT '户型',
  `area` decimal(8,2) unsigned NOT NULL default '0.00' COMMENT '面积',
  `budget` decimal(8,2) unsigned NOT NULL default '0.00' COMMENT '预算',
  `demand` text NOT NULL COMMENT '要求',
  `name` varchar(255) NOT NULL default '' COMMENT '联系姓名',
  `phone` varchar(255) NOT NULL default '' COMMENT '联系电话',
  `reserve_date` date NOT NULL default '0000-00-00' COMMENT '预约日期',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '创建时间',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='招标';

DROP TABLE IF EXISTS `lzwyc_region`;
CREATE TABLE `lzwyc_region` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `pid` smallint(5) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `sort` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `lzwyc_user`;
CREATE TABLE `lzwyc_user` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `type` tinyint(3) unsigned NOT NULL default '0' COMMENT '业主或公司',
  `email` varchar(255) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `realname` varchar(255) NOT NULL default '',
  `sex` tinyint(3) unsigned NOT NULL default '0',
  `reg_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `login_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='业主客户';

