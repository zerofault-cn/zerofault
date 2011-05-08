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

INSERT INTO `uchome_carmodel` VALUES (1,0,'brand','�µ�','A');
INSERT INTO `uchome_carmodel` VALUES (2,1,'model','�µ�A1','');
INSERT INTO `uchome_carmodel` VALUES (3,2,'profile','Sportback 1.8T �����','');
INSERT INTO `uchome_carmodel` VALUES (4,2,'profile','Sportback 1.8T ������','');
INSERT INTO `uchome_carmodel` VALUES (5,2,'profile','Sportback 1.4T ������','');
INSERT INTO `uchome_carmodel` VALUES (6,2,'profile','Sportback 1.4T ������','');
INSERT INTO `uchome_carmodel` VALUES (7,1,'model','�µ�A5','');
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

INSERT INTO `uchome_school` VALUES (1,'������У','���ݻ���������ʻԱ��ѵ����','',' 1�������������Ķ����߱��ࣨ��Ŀɽ·������Է�ƼҶ��棩\n\n  2����Ŀɽ·185�ţ��ϳ��������أ�','\nѧУ������1983����������20������ʷ���Ǿ���һ����ѵ���ʵļ�У����������Ϊʡ�����ż�У����˾λ�ں����л����������ģ�����λ����Խ����ͨ������\n\n������Уӵ��ע���ʽ�500�򣬽�������2300ƽ���ף����ĸ����豸��ȫ��������ʩ��������ɣ���ɺ��Զ���������100�������н���Ա100���ˣ��������ڹ�����Ա11�ˣ��������ѵѧԱԼ4000�����ң��Ǻ��ݵ�����ģ�ϴ���ʩ���걸�����������͹����������ļ�У��','�㽭','����');

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