ALTER TABLE `uchome`.`uchome_mtag`  ADD COLUMN `ext_id` smallint(6) unsigned NOT NULL DEFAULT 0;

ALTER TABLE `uchome`.`uchome_spacefield`  ADD COLUMN `car_role` tinyint(3) NOT NULL DEFAULT 0;

ALTER TABLE `uchome`.`uchome_spacefield`  ADD COLUMN `car_number` varchar(10) NOT NULL DEFAULT '';

ALTER TABLE `uchome`.`uchome_spacefield`  ADD COLUMN `car_model` int(11) unsigned NOT NULL DEFAULT 0;


CREATE TABLE `uchome_carmodel` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `pid` int(11) unsigned NOT NULL default '0',
  `type` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `initials` char(1) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `uchome_carmodel` VALUES (1,0,'brand','奥迪','A');
INSERT INTO `uchome_carmodel` VALUES (2,1,'model','奥迪A1','');
INSERT INTO `uchome_carmodel` VALUES (3,2,'profile','Sportback 1.8T 尊贵型','');
INSERT INTO `uchome_carmodel` VALUES (4,2,'profile','Sportback 1.8T 豪华型','');
INSERT INTO `uchome_carmodel` VALUES (5,2,'profile','Sportback 1.4T 舒适型','');
INSERT INTO `uchome_carmodel` VALUES (6,2,'profile','Sportback 1.4T 豪华型','');
INSERT INTO `uchome_carmodel` VALUES (7,1,'model','奥迪A5','');
INSERT INTO `uchome_carmodel` VALUES (8,7,'profile','S5 4.2 Coupe','');
INSERT INTO `uchome_carmodel` VALUES (9,7,'profile','3.2 Coupe quattro','');
INSERT INTO `uchome_carmodel` VALUES (10,7,'profile','3.0T S5 Sportback','');


CREATE TABLE `uchome_school` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `fullname` varchar(255) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `training` tinytext NOT NULL,
  `description` text NOT NULL,
  `province` varchar(255) NOT NULL default '',
  `city` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `uchome_school` VALUES (1,'黄龙驾校','杭州黄龙汽车驾驶员培训中心','',' 1、黄龙体育中心二环线北侧（天目山路新桃李苑酒家对面）\n\n  2、天目山路185号（老车管所场地）','\n学校创办于1983年至今已有20多年历史．是具有一类培训资质的驾校，曾经被评为省级诚信驾校．公司位于杭州市黄龙体育中心，地理位置优越，交通便利。\n\n黄龙驾校拥有注册资金500万，教练场地2300平分米，中心各种设备齐全，配套设施合理。共有桑塔纳和自动挡教练车100多辆，有教练员100余人，行政后勤管理人员11人，年可以培训学员约4000人左右，是杭州地区规模较大、设施较完备、教练质量和管理均较优秀的驾校。','浙江','杭州');

CREATE TABLE `uchome_vote` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `school_id` int(11) unsigned NOT NULL default '0',
  `vote_price` tinyint(3) unsigned NOT NULL default '0',
  `vote_service` tinyint(3) unsigned NOT NULL default '0',
  `vote_environment` tinyint(3) unsigned NOT NULL default '0',
  `vote_teacher` tinyint(3) unsigned NOT NULL default '0',
  `comment` text NOT NULL,
  `uid` int(11) unsigned NOT NULL default '0',
  `ip` varchar(16) NOT NULL default '',
  `votetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;