-- phpMiniAdmin dump 1.5.091221
-- Datetime: 2011-05-24 22:46:57
-- Host: 
-- Database: uchome

/*!40030 SET NAMES utf8 */;
/*!40030 SET GLOBAL max_allowed_packet=16777216 */;

DROP TABLE IF EXISTS `uchome_ad`;
CREATE TABLE `uchome_ad` (
  `adid` smallint(6) unsigned NOT NULL auto_increment,
  `available` tinyint(1) NOT NULL default '1',
  `title` varchar(50) NOT NULL default '',
  `pagetype` varchar(20) NOT NULL default '',
  `adcode` text NOT NULL,
  `system` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`adid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_ad` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_ad` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_adminsession`;
CREATE TABLE `uchome_adminsession` (
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `ip` char(15) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  `errorcount` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`uid`)
) ENGINE=HEAP DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_adminsession` DISABLE KEYS */;
INSERT INTO `uchome_adminsession` VALUES ('1','192.168.1.102','1306274799','-1');
/*!40000 ALTER TABLE `uchome_adminsession` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_album`;
CREATE TABLE `uchome_album` (
  `albumid` mediumint(8) unsigned NOT NULL auto_increment,
  `albumname` varchar(50) NOT NULL default '',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(15) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  `updatetime` int(10) unsigned NOT NULL default '0',
  `picnum` smallint(6) unsigned NOT NULL default '0',
  `pic` varchar(60) NOT NULL default '',
  `picflag` tinyint(1) NOT NULL default '0',
  `friend` tinyint(1) NOT NULL default '0',
  `password` varchar(10) NOT NULL default '',
  `target_ids` text NOT NULL,
  PRIMARY KEY  (`albumid`),
  KEY `uid` (`uid`,`updatetime`),
  KEY `updatetime` (`updatetime`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_album` DISABLE KEYS */;
INSERT INTO `uchome_album` VALUES ('1','我的相册','2','majin','1306276960','1306276964','1','201105/24/2_13062769642CHT.jpg.thumb.jpg','1','0','','');
/*!40000 ALTER TABLE `uchome_album` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_appcreditlog`;
CREATE TABLE `uchome_appcreditlog` (
  `logid` mediumint(8) unsigned NOT NULL auto_increment,
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `appid` mediumint(8) unsigned NOT NULL default '0',
  `appname` varchar(60) NOT NULL default '',
  `type` tinyint(1) NOT NULL default '0',
  `credit` mediumint(8) unsigned NOT NULL default '0',
  `note` text NOT NULL,
  `dateline` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`logid`),
  KEY `uid` (`uid`,`dateline`),
  KEY `appid` (`appid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_appcreditlog` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_appcreditlog` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_blacklist`;
CREATE TABLE `uchome_blacklist` (
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `buid` mediumint(8) unsigned NOT NULL default '0',
  `dateline` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`uid`,`buid`),
  KEY `uid` (`uid`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_blacklist` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_blacklist` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_block`;
CREATE TABLE `uchome_block` (
  `bid` smallint(6) unsigned NOT NULL auto_increment,
  `blockname` varchar(40) NOT NULL default '',
  `blocksql` text NOT NULL,
  `cachename` varchar(30) NOT NULL default '',
  `cachetime` smallint(6) unsigned NOT NULL default '0',
  `startnum` tinyint(3) unsigned NOT NULL default '0',
  `num` tinyint(3) unsigned NOT NULL default '0',
  `perpage` tinyint(3) unsigned NOT NULL default '0',
  `htmlcode` text NOT NULL,
  PRIMARY KEY  (`bid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_block` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_block` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_blog`;
CREATE TABLE `uchome_blog` (
  `blogid` mediumint(8) unsigned NOT NULL auto_increment,
  `topicid` mediumint(8) unsigned NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` char(15) NOT NULL default '',
  `subject` char(80) NOT NULL default '',
  `classid` smallint(6) unsigned NOT NULL default '0',
  `viewnum` mediumint(8) unsigned NOT NULL default '0',
  `replynum` mediumint(8) unsigned NOT NULL default '0',
  `hot` mediumint(8) unsigned NOT NULL default '0',
  `dateline` int(10) unsigned NOT NULL default '0',
  `pic` char(120) NOT NULL default '',
  `picflag` tinyint(1) NOT NULL default '0',
  `noreply` tinyint(1) NOT NULL default '0',
  `friend` tinyint(1) NOT NULL default '0',
  `password` char(10) NOT NULL default '',
  `click_1` smallint(6) unsigned NOT NULL default '0',
  `click_2` smallint(6) unsigned NOT NULL default '0',
  `click_3` smallint(6) unsigned NOT NULL default '0',
  `click_4` smallint(6) unsigned NOT NULL default '0',
  `click_5` smallint(6) unsigned NOT NULL default '0',
  PRIMARY KEY  (`blogid`),
  KEY `uid` (`uid`,`dateline`),
  KEY `topicid` (`topicid`,`dateline`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_blog` DISABLE KEYS */;
INSERT INTO `uchome_blog` VALUES ('1','0','4','maj','hello','0','0','0','0','1306273897','','0','0','0','','0','0','0','0','0');
/*!40000 ALTER TABLE `uchome_blog` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_blogfield`;
CREATE TABLE `uchome_blogfield` (
  `blogid` mediumint(8) unsigned NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `tag` varchar(255) NOT NULL default '',
  `message` mediumtext NOT NULL,
  `postip` varchar(20) NOT NULL default '',
  `related` text NOT NULL,
  `relatedtime` int(10) unsigned NOT NULL default '0',
  `target_ids` text NOT NULL,
  `hotuser` text NOT NULL,
  `magiccolor` tinyint(6) NOT NULL default '0',
  `magicpaper` tinyint(6) NOT NULL default '0',
  `magiccall` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`blogid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_blogfield` DISABLE KEYS */;
INSERT INTO `uchome_blogfield` VALUES ('1','4','a:1:{i:1;s:5:\"hello\";}','<DIV>向大家问个好！</DIV>','222.82.253.154','a:0:{}','1306273900','','','0','0','0');
/*!40000 ALTER TABLE `uchome_blogfield` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_cache`;
CREATE TABLE `uchome_cache` (
  `cachekey` varchar(16) NOT NULL default '',
  `value` mediumtext NOT NULL,
  `mtime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`cachekey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_cache` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_carmodel`;
CREATE TABLE `uchome_carmodel` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `pid` int(11) unsigned NOT NULL default '0',
  `type` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `initials` char(1) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_carmodel` DISABLE KEYS */;
INSERT INTO `uchome_carmodel` VALUES ('1','0','brand','奥迪','A'),('2','1','model','奥迪A1',''),('3','2','profile','Sportback 1.8T 尊贵型',''),('4','2','profile','Sportback 1.8T 豪华型',''),('5','2','profile','Sportback 1.4T 舒适型',''),('6','2','profile','Sportback 1.4T 豪华型',''),('7','1','model','奥迪A5',''),('8','7','profile','S5 4.2 Coupe',''),('9','7','profile','3.2 Coupe quattro',''),('10','7','profile','3.0T S5 Sportback','');
/*!40000 ALTER TABLE `uchome_carmodel` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_class`;
CREATE TABLE `uchome_class` (
  `classid` mediumint(8) unsigned NOT NULL auto_increment,
  `classname` char(40) NOT NULL default '',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `dateline` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`classid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_class` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_class` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_click`;
CREATE TABLE `uchome_click` (
  `clickid` smallint(6) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `icon` varchar(100) NOT NULL default '',
  `idtype` varchar(15) NOT NULL default '',
  `displayorder` tinyint(6) unsigned NOT NULL default '0',
  PRIMARY KEY  (`clickid`),
  KEY `idtype` (`idtype`,`displayorder`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_click` DISABLE KEYS */;
INSERT INTO `uchome_click` VALUES ('1','路过','luguo.gif','blogid','0'),('2','雷人','leiren.gif','blogid','0'),('3','握手','woshou.gif','blogid','0'),('4','鲜花','xianhua.gif','blogid','0'),('5','鸡蛋','jidan.gif','blogid','0'),('6','漂亮','piaoliang.gif','picid','0'),('7','酷毙','kubi.gif','picid','0'),('8','雷人','leiren.gif','picid','0'),('9','鲜花','xianhua.gif','picid','0'),('10','鸡蛋','jidan.gif','picid','0'),('11','搞笑','gaoxiao.gif','tid','0'),('12','迷惑','mihuo.gif','tid','0'),('13','雷人','leiren.gif','tid','0'),('14','鲜花','xianhua.gif','tid','0'),('15','鸡蛋','jidan.gif','tid','0');
/*!40000 ALTER TABLE `uchome_click` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_clickuser`;
CREATE TABLE `uchome_clickuser` (
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(15) NOT NULL default '',
  `id` mediumint(8) unsigned NOT NULL default '0',
  `idtype` varchar(15) NOT NULL default '',
  `clickid` smallint(6) unsigned NOT NULL default '0',
  `dateline` int(10) unsigned NOT NULL default '0',
  KEY `id` (`id`,`idtype`,`dateline`),
  KEY `uid` (`uid`,`idtype`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_clickuser` DISABLE KEYS */;
INSERT INTO `uchome_clickuser` VALUES ('4','maj','1','tid','14','1306168813');
/*!40000 ALTER TABLE `uchome_clickuser` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_comment`;
CREATE TABLE `uchome_comment` (
  `cid` mediumint(8) unsigned NOT NULL auto_increment,
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `id` mediumint(8) unsigned NOT NULL default '0',
  `idtype` varchar(20) NOT NULL default '',
  `authorid` mediumint(8) unsigned NOT NULL default '0',
  `author` varchar(15) NOT NULL default '',
  `ip` varchar(20) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  `message` text NOT NULL,
  `magicflicker` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`cid`),
  KEY `authorid` (`authorid`,`idtype`),
  KEY `id` (`id`,`idtype`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_comment` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_config`;
CREATE TABLE `uchome_config` (
  `var` varchar(30) NOT NULL default '',
  `datavalue` text NOT NULL,
  PRIMARY KEY  (`var`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_config` DISABLE KEYS */;
INSERT INTO `uchome_config` VALUES ('sitename','我的空间'),('template','blue'),('adminemail','zerofault@gmail.com'),('onlinehold','1800'),('timeoffset','8'),('maxpage','100'),('starcredit','100'),('starlevelnum','5'),('cachemode','database'),('cachegrade','0'),('allowcache','1'),('allowdomain','0'),('allowrewrite','0'),('allowwatermark','0'),('allowftp','0'),('holddomain','www|*blog*|*space*|x'),('mtagminnum','5'),('feedday','7'),('feedmaxnum','100'),('feedfilternum','10'),('importnum','100'),('maxreward','10'),('singlesent','50'),('groupnum','8'),('closeregister','0'),('closeinvite','0'),('close','0'),('networkpublic','1'),('networkpage','1'),('seccode_register','1'),('uc_tagrelated','1'),('manualmoderator','1'),('linkguide','1'),('showall','1'),('sendmailday','0'),('realname','0'),('namecheck','0'),('namechange','0'),('name_allowviewspace','1'),('name_allowfriend','1'),('name_allowpoke','1'),('name_allowdoing','1'),('name_allowblog','0'),('name_allowalbum','0'),('name_allowthread','0'),('name_allowshare','0'),('name_allowcomment','0'),('name_allowpost','0'),('showallfriendnum','10'),('feedtargetblank','1'),('feedread','1'),('feedhotnum','3'),('feedhotday','2'),('feedhotmin','3'),('feedhiddenicon','friend,profile,task,wall'),('uc_tagrelatedtime','86400'),('privacy','a:2:{s:4:\"view\";a:12:{s:5:\"index\";i:0;s:7:\"profile\";i:0;s:6:\"friend\";i:0;s:4:\"wall\";i:0;s:4:\"feed\";i:0;s:4:\"mtag\";i:0;s:5:\"event\";i:0;s:5:\"doing\";i:0;s:4:\"blog\";i:0;s:5:\"album\";i:0;s:5:\"share\";i:0;s:4:\"poll\";i:0;}s:4:\"feed\";a:21:{s:5:\"doing\";i:1;s:4:\"blog\";i:1;s:6:\"upload\";i:1;s:5:\"share\";i:1;s:4:\"poll\";i:1;s:8:\"joinpoll\";i:1;s:6:\"thread\";i:1;s:4:\"post\";i:1;s:4:\"mtag\";i:1;s:5:\"event\";i:1;s:4:\"join\";i:1;s:6:\"friend\";i:1;s:7:\"comment\";i:1;s:4:\"show\";i:1;s:9:\"spaceopen\";i:1;s:6:\"credit\";i:1;s:6:\"invite\";i:1;s:4:\"task\";i:1;s:7:\"profile\";i:1;s:5:\"album\";i:1;s:5:\"click\";i:1;}}'),('cronnextrun','1306277220'),('my_status','1'),('uniqueemail','1'),('updatestat','1'),('my_showgift','1'),('topcachetime','60'),('newspacenum','3'),('sitekey','fa035314zWMhhFmF'),('my_siteid','5083512'),('my_sitekey','4a40ba3a99677c0008ce8140c26beed5'),('siteallurl',''),('licensed','0'),('debuginfo','0'),('miibeian',''),('headercharset','0'),('avatarreal','0'),('uc_dir',''),('my_ip',''),('closereason',''),('checkemail','0'),('regipdate',''),('my_closecheckupdate','0'),('openxmlrpc','0'),('domainroot',''),('name_allowpoll','0'),('name_allowevent','0'),('name_allowuserapp','0'),('videophoto','0'),('video_allowviewphoto','0'),('video_allowfriend','0'),('video_allowpoke','0'),('video_allowwall','0'),('video_allowcomment','0'),('video_allowdoing','0'),('video_allowblog','0'),('video_allowalbum','0'),('video_allowthread','0'),('video_allowpoll','0'),('video_allowevent','0'),('video_allowshare','0'),('video_allowpost','0'),('video_allowuserapp','0'),('ftpurl',''),('newspaceavatar','0'),('newspacerealname','0'),('newspacevideophoto','0');
/*!40000 ALTER TABLE `uchome_config` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_creditlog`;
CREATE TABLE `uchome_creditlog` (
  `clid` mediumint(8) unsigned NOT NULL auto_increment,
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `rid` mediumint(8) unsigned NOT NULL default '0',
  `total` mediumint(8) unsigned NOT NULL default '0',
  `cyclenum` mediumint(8) unsigned NOT NULL default '0',
  `credit` mediumint(8) unsigned NOT NULL default '0',
  `experience` mediumint(8) unsigned NOT NULL default '0',
  `starttime` int(10) unsigned NOT NULL default '0',
  `info` text NOT NULL,
  `user` text NOT NULL,
  `app` text NOT NULL,
  `dateline` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`clid`),
  KEY `uid` (`uid`,`rid`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_creditlog` DISABLE KEYS */;
INSERT INTO `uchome_creditlog` VALUES ('1','1','1','1','1','10','0','0','','','','1304876645'),('2','1','10','11','1','15','15','0','','','','1306270170'),('3','2','1','1','1','10','0','0','','','','1305286491'),('4','2','10','5','1','15','15','0','','','','1306274530'),('5','3','1','1','1','10','0','0','','','','1305287212'),('6','3','10','2','1','15','15','0','','','','1306015820'),('7','3','11','1','1','1','1','0','','2','','1305287318'),('8','1','30','4','1','1','1','0','','','1003094','1305394953'),('9','1','29','3','3','5','5','0','','','1058035,1003094,1005122','1305291805'),('10','2','19','1','1','5','5','0','','','','1305994851'),('11','3','8','1','1','3','3','0','','','','1306015872'),('12','4','1','1','1','10','0','0','','','','1306168645'),('13','4','10','2','1','15','15','0','','','','1306273026'),('14','4','31','1','1','1','1','0','tid1','','','1306168813'),('15','4','16','1','1','5','5','0','','','','1306273897'),('16','4','8','1','1','3','3','0','','','','1306273942'),('17','2','17','1','1','2','2','0','','','','1306276964');
/*!40000 ALTER TABLE `uchome_creditlog` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_creditrule`;
CREATE TABLE `uchome_creditrule` (
  `rid` mediumint(8) unsigned NOT NULL auto_increment,
  `rulename` char(20) NOT NULL default '',
  `action` char(20) NOT NULL default '',
  `cycletype` tinyint(1) NOT NULL default '0',
  `cycletime` int(10) NOT NULL default '0',
  `rewardnum` tinyint(2) NOT NULL default '1',
  `rewardtype` tinyint(1) NOT NULL default '1',
  `norepeat` tinyint(1) NOT NULL default '0',
  `credit` mediumint(8) unsigned NOT NULL default '0',
  `experience` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`rid`),
  KEY `action` (`action`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_creditrule` DISABLE KEYS */;
INSERT INTO `uchome_creditrule` VALUES ('1','开通空间','register','0','0','1','1','0','10','0'),('2','实名认证','realname','0','0','1','1','0','20','20'),('3','邮箱认证','realemail','0','0','1','1','0','40','40'),('4','成功邀请好友','invitefriend','4','0','20','1','0','10','10'),('5','设置头像','setavatar','0','0','1','1','0','15','15'),('6','视频认证','videophoto','0','0','1','1','0','40','40'),('7','成功举报','report','4','0','0','1','0','2','2'),('8','更新心情','updatemood','1','0','3','1','0','3','3'),('9','热点信息','hotinfo','4','0','0','1','0','10','10'),('10','每天登陆','daylogin','1','0','1','1','0','15','15'),('11','访问别人空间','visit','1','0','10','1','2','1','1'),('12','打招呼','poke','1','0','10','1','2','1','1'),('13','留言','guestbook','1','0','20','1','2','2','2'),('14','被留言','getguestbook','1','0','5','1','2','1','0'),('15','发表记录','doing','1','0','5','1','0','1','1'),('16','发表日志','publishblog','1','0','3','1','0','5','5'),('17','上传图片','uploadimage','1','0','10','1','0','2','2'),('18','拍大头贴','camera','1','0','5','1','0','3','3'),('19','发表话题','publishthread','1','0','5','1','0','5','5'),('20','回复话题','replythread','1','0','10','1','1','1','1'),('21','创建投票','createpoll','1','0','5','1','0','2','2'),('22','参与投票','joinpoll','1','0','10','1','1','1','1'),('23','发起活动','createevent','1','0','1','1','0','3','3'),('24','参与活动','joinevent','1','0','1','1','1','1','1'),('25','推荐活动','recommendevent','4','0','0','1','0','10','10'),('26','发起分享','createshare','1','0','3','1','0','2','2'),('27','评论','comment','1','0','40','1','1','1','1'),('28','被评论','getcomment','1','0','20','1','1','1','0'),('29','安装应用','installapp','4','0','0','1','3','5','5'),('30','使用应用','useapp','1','0','10','1','3','1','1'),('31','信息表态','click','1','0','10','1','1','1','1'),('32','修改实名','editrealname','0','0','1','0','0','5','0'),('33','更改邮箱认证','editrealemail','0','0','1','0','0','5','0'),('34','头像被删除','delavatar','0','0','1','0','0','10','10'),('35','获取邀请码','invitecode','0','0','1','0','0','0','0'),('36','搜索一次','search','0','0','1','0','0','1','0'),('37','日志导入','blogimport','0','0','1','0','0','10','0'),('38','修改域名','modifydomain','0','0','1','0','0','5','0'),('39','日志被删除','delblog','0','0','1','0','0','10','10'),('40','记录被删除','deldoing','0','0','1','0','0','2','2'),('41','图片被删除','delimage','0','0','1','0','0','4','4'),('42','投票被删除','delpoll','0','0','1','0','0','4','4'),('43','话题被删除','delthread','0','0','1','0','0','4','4'),('44','活动被删除','delevent','0','0','1','0','0','6','6'),('45','分享被删除','delshare','0','0','1','0','0','4','4'),('46','留言被删除','delguestbook','0','0','1','0','0','4','4'),('47','评论被删除','delcomment','0','0','1','0','0','2','2');
/*!40000 ALTER TABLE `uchome_creditrule` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_cron`;
CREATE TABLE `uchome_cron` (
  `cronid` smallint(6) unsigned NOT NULL auto_increment,
  `available` tinyint(1) NOT NULL default '0',
  `type` enum('user','system') NOT NULL default 'user',
  `name` char(50) NOT NULL default '',
  `filename` char(50) NOT NULL default '',
  `lastrun` int(10) unsigned NOT NULL default '0',
  `nextrun` int(10) unsigned NOT NULL default '0',
  `weekday` tinyint(1) NOT NULL default '0',
  `day` tinyint(2) NOT NULL default '0',
  `hour` tinyint(2) NOT NULL default '0',
  `minute` char(36) NOT NULL default '',
  PRIMARY KEY  (`cronid`),
  KEY `nextrun` (`available`,`nextrun`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_cron` DISABLE KEYS */;
INSERT INTO `uchome_cron` VALUES ('1','1','system','更新浏览数统计','log.php','1306277134','1306277400','-1','-1','-1','0	5	10	15	20	25	30	35	40	45	50	55'),('2','1','system','清理过期feed','cleanfeed.php','1306270222','1306350240','-1','-1','3','4'),('3','1','system','清理个人通知','cleannotification.php','1306273213','1306357560','-1','-1','5','6'),('4','1','system','同步UC的feed','getfeed.php','1306276980','1306277220','-1','-1','-1','2	7	12	17	22	27	32	37	42	47	52'),('5','1','system','清理脚印和最新访客','cleantrace.php','1306270212','1306346580','-1','-1','2','3');
/*!40000 ALTER TABLE `uchome_cron` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_data`;
CREATE TABLE `uchome_data` (
  `var` varchar(20) NOT NULL default '',
  `datavalue` text NOT NULL,
  `dateline` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`var`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_data` DISABLE KEYS */;
INSERT INTO `uchome_data` VALUES ('mail','a:9:{s:8:\"mailsend\";s:1:\"1\";s:13:\"maildelimiter\";s:1:\"0\";s:12:\"mailusername\";s:1:\"1\";s:6:\"server\";s:0:\"\";s:4:\"port\";s:0:\"\";s:4:\"auth\";s:1:\"0\";s:4:\"from\";s:0:\"\";s:13:\"auth_username\";s:0:\"\";s:13:\"auth_password\";s:0:\"\";}','1305489842'),('setting','a:14:{s:10:\"thumbwidth\";s:3:\"100\";s:11:\"thumbheight\";s:3:\"100\";s:13:\"maxthumbwidth\";s:0:\"\";s:14:\"maxthumbheight\";s:0:\"\";s:13:\"watermarkfile\";s:0:\"\";s:12:\"watermarkpos\";s:1:\"4\";s:6:\"ftpssl\";s:1:\"0\";s:7:\"ftphost\";s:0:\"\";s:7:\"ftpport\";s:0:\"\";s:7:\"ftpuser\";s:0:\"\";s:11:\"ftppassword\";s:0:\"\";s:7:\"ftppasv\";s:1:\"0\";s:6:\"ftpdir\";s:0:\"\";s:10:\"ftptimeout\";s:0:\"\";}','1305489842'),('network','a:5:{s:4:\"blog\";a:2:{s:4:\"hot1\";s:1:\"3\";s:5:\"cache\";s:3:\"600\";}s:3:\"pic\";a:2:{s:4:\"hot1\";s:1:\"3\";s:5:\"cache\";s:3:\"700\";}s:6:\"thread\";a:2:{s:4:\"hot1\";s:1:\"3\";s:5:\"cache\";s:3:\"800\";}s:5:\"event\";a:1:{s:5:\"cache\";s:3:\"900\";}s:4:\"poll\";a:1:{s:5:\"cache\";s:3:\"500\";}}','1304876611'),('newspacelist','a:3:{i:0;a:6:{s:3:\"uid\";s:1:\"4\";s:8:\"username\";s:3:\"maj\";s:4:\"name\";s:0:\"\";s:10:\"namestatus\";s:1:\"0\";s:11:\"videostatus\";s:1:\"0\";s:8:\"dateline\";s:10:\"1306168645\";}i:1;a:6:{s:3:\"uid\";s:1:\"3\";s:8:\"username\";s:5:\"hz123\";s:4:\"name\";s:0:\"\";s:10:\"namestatus\";s:1:\"0\";s:11:\"videostatus\";s:1:\"0\";s:8:\"dateline\";s:10:\"1305287212\";}i:2;a:6:{s:3:\"uid\";s:1:\"2\";s:8:\"username\";s:5:\"majin\";s:4:\"name\";s:0:\"\";s:10:\"namestatus\";s:1:\"0\";s:11:\"videostatus\";s:1:\"0\";s:8:\"dateline\";s:10:\"1305286491\";}}','1306168645'),('reason','','0'),('registerrule','','0');
/*!40000 ALTER TABLE `uchome_data` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_docomment`;
CREATE TABLE `uchome_docomment` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `upid` int(10) unsigned NOT NULL default '0',
  `doid` mediumint(8) unsigned NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(15) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  `message` text NOT NULL,
  `ip` varchar(20) NOT NULL default '',
  `grade` smallint(6) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `doid` (`doid`,`dateline`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_docomment` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_docomment` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_doing`;
CREATE TABLE `uchome_doing` (
  `doid` mediumint(8) unsigned NOT NULL auto_increment,
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(15) NOT NULL default '',
  `from` varchar(20) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  `message` text NOT NULL,
  `ip` varchar(20) NOT NULL default '',
  `replynum` int(10) unsigned NOT NULL default '0',
  `mood` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`doid`),
  KEY `uid` (`uid`,`dateline`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_doing` DISABLE KEYS */;
INSERT INTO `uchome_doing` VALUES ('1','3','hz123','','1306015872','<img src=\"image/face/12.gif\" class=\"face\">加速进度啊','60.176.180.218','0','12');
/*!40000 ALTER TABLE `uchome_doing` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_event`;
CREATE TABLE `uchome_event` (
  `eventid` mediumint(8) unsigned NOT NULL auto_increment,
  `topicid` mediumint(8) unsigned NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(15) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  `title` varchar(80) NOT NULL default '',
  `classid` smallint(6) unsigned NOT NULL default '0',
  `province` varchar(20) NOT NULL default '',
  `city` varchar(20) NOT NULL default '',
  `location` varchar(80) NOT NULL default '',
  `poster` varchar(60) NOT NULL default '',
  `thumb` tinyint(1) NOT NULL default '0',
  `remote` tinyint(1) NOT NULL default '0',
  `deadline` int(10) unsigned NOT NULL default '0',
  `starttime` int(10) unsigned NOT NULL default '0',
  `endtime` int(10) unsigned NOT NULL default '0',
  `public` tinyint(3) NOT NULL default '0',
  `membernum` mediumint(8) unsigned NOT NULL default '0',
  `follownum` mediumint(8) unsigned NOT NULL default '0',
  `viewnum` mediumint(8) unsigned NOT NULL default '0',
  `grade` tinyint(3) NOT NULL default '0',
  `recommendtime` int(10) unsigned NOT NULL default '0',
  `tagid` mediumint(8) unsigned NOT NULL default '0',
  `picnum` mediumint(8) unsigned NOT NULL default '0',
  `threadnum` mediumint(8) unsigned NOT NULL default '0',
  `updatetime` int(10) unsigned NOT NULL default '0',
  `hot` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`eventid`),
  KEY `grade` (`grade`,`recommendtime`),
  KEY `membernum` (`membernum`),
  KEY `uid` (`uid`,`eventid`),
  KEY `tagid` (`tagid`,`eventid`),
  KEY `topicid` (`topicid`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_event` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_event` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_eventclass`;
CREATE TABLE `uchome_eventclass` (
  `classid` smallint(6) unsigned NOT NULL auto_increment,
  `classname` varchar(80) NOT NULL default '',
  `poster` tinyint(1) NOT NULL default '0',
  `template` text NOT NULL,
  `displayorder` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`classid`),
  UNIQUE KEY `classname` (`classname`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_eventclass` DISABLE KEYS */;
INSERT INTO `uchome_eventclass` VALUES ('1','生活/聚会','0','费用说明：\r\n集合地点：\r\n着装要求：\r\n联系方式：\r\n注意事项：','1'),('2','出行/旅游','0','路线说明:\r\n费用说明:\r\n装备要求:\r\n交通工具:\r\n集合地点:\r\n联系方式:\r\n注意事项:','2'),('3','比赛/运动','0','费用说明：\r\n集合地点：\r\n着装要求：\r\n场地介绍：\r\n联系方式：\r\n注意事项：','4'),('4','电影/演出','0','剧情介绍：\r\n费用说明：\r\n集合地点：\r\n联系方式：\r\n注意事项：','3'),('5','教育/讲座','0','主办单位：\r\n活动主题：\r\n费用说明：\r\n集合地点：\r\n联系方式：\r\n注意事项：','5'),('6','其它','0','','6');
/*!40000 ALTER TABLE `uchome_eventclass` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_eventfield`;
CREATE TABLE `uchome_eventfield` (
  `eventid` mediumint(8) unsigned NOT NULL auto_increment,
  `detail` text NOT NULL,
  `template` varchar(255) NOT NULL default '',
  `limitnum` mediumint(8) unsigned NOT NULL default '0',
  `verify` tinyint(1) NOT NULL default '0',
  `allowpic` tinyint(1) NOT NULL default '0',
  `allowpost` tinyint(1) NOT NULL default '0',
  `allowinvite` tinyint(1) NOT NULL default '0',
  `allowfellow` tinyint(1) NOT NULL default '0',
  `hotuser` text NOT NULL,
  PRIMARY KEY  (`eventid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_eventfield` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_eventfield` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_eventinvite`;
CREATE TABLE `uchome_eventinvite` (
  `eventid` mediumint(8) unsigned NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(15) NOT NULL default '',
  `touid` mediumint(8) unsigned NOT NULL default '0',
  `tousername` varchar(15) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`eventid`,`touid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_eventinvite` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_eventinvite` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_eventpic`;
CREATE TABLE `uchome_eventpic` (
  `picid` mediumint(8) unsigned NOT NULL default '0',
  `eventid` mediumint(8) unsigned NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` char(15) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`picid`),
  KEY `eventid` (`eventid`,`picid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_eventpic` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_eventpic` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_feed`;
CREATE TABLE `uchome_feed` (
  `feedid` int(10) unsigned NOT NULL auto_increment,
  `appid` smallint(6) unsigned NOT NULL default '0',
  `icon` varchar(30) NOT NULL default '',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(15) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  `friend` tinyint(1) NOT NULL default '0',
  `hash_template` varchar(32) NOT NULL default '',
  `hash_data` varchar(32) NOT NULL default '',
  `title_template` text NOT NULL,
  `title_data` text NOT NULL,
  `body_template` text NOT NULL,
  `body_data` text NOT NULL,
  `body_general` text NOT NULL,
  `image_1` varchar(255) NOT NULL default '',
  `image_1_link` varchar(255) NOT NULL default '',
  `image_2` varchar(255) NOT NULL default '',
  `image_2_link` varchar(255) NOT NULL default '',
  `image_3` varchar(255) NOT NULL default '',
  `image_3_link` varchar(255) NOT NULL default '',
  `image_4` varchar(255) NOT NULL default '',
  `image_4_link` varchar(255) NOT NULL default '',
  `target_ids` text NOT NULL,
  `id` mediumint(8) unsigned NOT NULL default '0',
  `idtype` varchar(15) NOT NULL default '',
  `hot` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`feedid`),
  KEY `uid` (`uid`,`dateline`),
  KEY `dateline` (`dateline`),
  KEY `hot` (`hot`),
  KEY `id` (`id`,`idtype`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_feed` DISABLE KEYS */;
INSERT INTO `uchome_feed` VALUES ('9','1','mtag','2','majin','1305994802','0','c9099118207bd215f166ca6e7b9f0093','b7458211332fce6107d6d5568d11912f','{actor} 加入了群组 {mtag} ({field})','a:2:{s:4:\"mtag\";s:55:\"<a href=\"space.php?do=mtag&tagid=1\">疯狂的车车</a>\";s:5:\"field\";s:49:\"<a href=\"space.php?do=mtag&id=2\">地区联盟</a>\";}','','a:0:{}','','','','','','','','','','','0','','0'),('10','1','thread','2','majin','1305994851','0','998492c54d96cbcb821f60e05a8ab20b','8a2906ebae935bae7bbaccfba8916a7d','{actor} 发起了新话题','N;','<b>{subject}</b><br>群组: {mtag}<br>{summary}','a:3:{s:7:\"subject\";s:66:\"<a href=\"space.php?uid=2&do=thread&id=1\">感觉少了点什么</a>\";s:4:\"mtag\";s:55:\"<a href=\"space.php?do=mtag&tagid=1\">疯狂的车车</a>\";s:7:\"summary\";s:15:\"如题！！！\";}','','','','','','','','','','','1','tid','1'),('11','1','doing','3','hz123','1306015872','0','7405fddb51d86fcb3dce6bfa66d591b3','d99003326777066d356a9a233dee905b','{actor}：{message}','a:1:{s:7:\"message\";s:57:\"<img src=\"image/face/12.gif\" class=\"face\">加速进度啊\";}','','','','','','','','','','','','','1','doid','0'),('12','1','profile','4','maj','1306168645','0','3a7101a64ea7927f0b3f5179b7a457b3','ec7d775d9211880bca2ba1d401e3bcb9','{actor} 开通了自己的个人主页','a:0:{}','','a:0:{}','','','','','','','','','','','0','','0'),('13','1','click','4','maj','1306168813','0','c16466da056d7ac5fcdb52d95fd5bb83','6b8082a022b12b4116461b792c33abee','{actor} 送了一个“{click}”给 {touser} 的话题 {subject}','a:3:{s:6:\"touser\";s:35:\"<a href=\"space.php?uid=2\">majin</a>\";s:7:\"subject\";s:66:\"<a href=\"space.php?uid=2&do=thread&id=1\">感觉少了点什么</a>\";s:5:\"click\";s:6:\"鲜花\";}','','a:0:{}','','','','','','','','','','','0','','0'),('14','1','blog','4','maj','1306273897','0','2c24ba00fafd81b79f331389e04a26cb','7508f6d4011047da676031d2d0a792f2','{actor} 发表了新日志','N;','<b>{subject}</b><br>{summary}','a:2:{s:7:\"subject\";s:48:\"<a href=\"space.php?uid=4&do=blog&id=1\">hello</a>\";s:7:\"summary\";s:21:\"向大家问个好！\";}','','','','','','','','','','','1','blogid','0'),('15','1','mtag','1','admin','1306274709','0','c9099118207bd215f166ca6e7b9f0093','b7458211332fce6107d6d5568d11912f','{actor} 加入了群组 {mtag} ({field})','a:2:{s:4:\"mtag\";s:55:\"<a href=\"space.php?do=mtag&tagid=1\">疯狂的车车</a>\";s:5:\"field\";s:49:\"<a href=\"space.php?do=mtag&id=2\">地区联盟</a>\";}','','a:0:{}','','','','','','','','','','','0','','0'),('16','1','mtag','1','admin','1306276086','0','c9099118207bd215f166ca6e7b9f0093','0d990136e55a6566592c23d4560ff4c7','{actor} 加入了群组 {mtag} ({field})','a:2:{s:4:\"mtag\";s:58:\"<a href=\"space.php?do=mtag&tagid=2\">黄龙驾校群组</a>\";s:5:\"field\";s:49:\"<a href=\"space.php?do=mtag&id=4\">驾校联盟</a>\";}','','a:0:{}','','','','','','','','','','','0','','0'),('17','1','mtag','4','maj','1306276105','0','c9099118207bd215f166ca6e7b9f0093','de343d560ed46bc9afa61b9a749c340b','{actor} 加入了群组 {mtag} ({field})','a:2:{s:4:\"mtag\";s:55:\"<a href=\"space.php?do=mtag&tagid=1\">疯狂的车车</a>\";s:5:\"field\";s:49:\"<a href=\"space.php?do=mtag&id=2\">区域联盟</a>\";}','','a:0:{}','','','','','','','','','','','0','','0'),('18','1','mtag','2','majin','1306276451','0','c9099118207bd215f166ca6e7b9f0093','0d990136e55a6566592c23d4560ff4c7','{actor} 加入了群组 {mtag} ({field})','a:2:{s:4:\"mtag\";s:58:\"<a href=\"space.php?do=mtag&tagid=2\">黄龙驾校群组</a>\";s:5:\"field\";s:49:\"<a href=\"space.php?do=mtag&id=4\">驾校联盟</a>\";}','','a:0:{}','','','','','','','','','','','0','','0'),('19','1','album','2','majin','1306276964','0','ddf6fc73b8212250dd16cb085d44e413','fef5924d096191c0af353d442eb2362b','{actor} 更新了相册','N;','<b>{album}</b><br>共 {picnum} 张图片','a:2:{s:5:\"album\";s:56:\"<a href=\"space.php?uid=2&do=album&id=1\">我的相册</a>\";s:6:\"picnum\";s:1:\"1\";}','','attachment/201105/24/2_13062769642CHT.jpg.thumb.jpg','space.php?uid=2&do=album&picid=1','','','','','','','','1','albumid','0');
/*!40000 ALTER TABLE `uchome_feed` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_friend`;
CREATE TABLE `uchome_friend` (
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `fuid` mediumint(8) unsigned NOT NULL default '0',
  `fusername` varchar(15) NOT NULL default '',
  `status` tinyint(1) NOT NULL default '0',
  `gid` smallint(6) unsigned NOT NULL default '0',
  `note` varchar(50) NOT NULL default '',
  `num` mediumint(8) unsigned NOT NULL default '0',
  `dateline` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`uid`,`fuid`),
  KEY `fuid` (`fuid`),
  KEY `status` (`uid`,`status`,`num`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_friend` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_friend` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_friendguide`;
CREATE TABLE `uchome_friendguide` (
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `fuid` mediumint(8) unsigned NOT NULL default '0',
  `fusername` char(15) NOT NULL default '',
  `num` smallint(6) unsigned NOT NULL default '0',
  PRIMARY KEY  (`uid`,`fuid`),
  KEY `uid` (`uid`,`num`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_friendguide` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_friendguide` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_friendlog`;
CREATE TABLE `uchome_friendlog` (
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `fuid` mediumint(8) unsigned NOT NULL default '0',
  `action` varchar(10) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`uid`,`fuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_friendlog` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_friendlog` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_invite`;
CREATE TABLE `uchome_invite` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `code` varchar(20) NOT NULL default '',
  `fuid` mediumint(8) unsigned NOT NULL default '0',
  `fusername` varchar(15) NOT NULL default '',
  `type` tinyint(1) NOT NULL default '0',
  `email` varchar(100) NOT NULL default '',
  `appid` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_invite` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_invite` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_log`;
CREATE TABLE `uchome_log` (
  `logid` mediumint(8) unsigned NOT NULL auto_increment,
  `id` mediumint(8) unsigned NOT NULL default '0',
  `idtype` char(20) NOT NULL default '',
  PRIMARY KEY  (`logid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_log` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_magic`;
CREATE TABLE `uchome_magic` (
  `mid` varchar(15) NOT NULL default '',
  `name` varchar(30) NOT NULL default '',
  `description` text NOT NULL,
  `forbiddengid` text NOT NULL,
  `charge` smallint(6) unsigned NOT NULL default '0',
  `experience` smallint(6) unsigned NOT NULL default '0',
  `provideperoid` int(10) unsigned NOT NULL default '0',
  `providecount` smallint(6) unsigned NOT NULL default '0',
  `useperoid` int(10) unsigned NOT NULL default '0',
  `usecount` smallint(6) unsigned NOT NULL default '0',
  `displayorder` smallint(6) unsigned NOT NULL default '0',
  `custom` text NOT NULL,
  `close` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_magic` DISABLE KEYS */;
INSERT INTO `uchome_magic` VALUES ('invisible','隐身草','让自己隐身登录，不显示在线，24小时内有效','','50','5','86400','10','86400','1','0','','0'),('friendnum','好友增容卡','在允许添加的最多好友数限制外，增加10个好友名额','','30','3','86400','999','0','1','0','','0'),('attachsize','附件增容卡','使用一次，可以给自己增加 10M 的附件空间','','30','3','86400','999','0','1','0','','0'),('thunder','雷鸣之声','发布一条全站信息，让大家知道自己上线了','','500','5','86400','5','86400','1','0','','0'),('updateline','救生圈','把指定对象的发布时间更新为当前时间','','200','5','86400','999','0','1','0','','0'),('downdateline','时空机','把指定对象的发布时间修改为过去的时间','','250','5','86400','999','0','1','0','','0'),('color','彩色灯','把指定对象的标题变成彩色的','','50','5','86400','999','0','1','0','','0'),('hot','热点灯','把指定对象的热度增加站点推荐的热点值','','50','5','86400','999','0','1','0','','0'),('visit','互访卡','随机选择10个好友，向其打招呼、留言或访问空间','','20','2','86400','999','0','1','0','','0'),('icon','彩虹蛋','给指定对象的标题前面增加图标（最多8个图标）','','20','2','86400','999','0','1','0','','0'),('flicker','彩虹炫','让评论、留言的文字闪烁起来','','30','3','86400','999','0','1','0','','0'),('gift','红包卡','在自己的空间埋下积分红包送给来访者','','20','2','86400','999','0','1','0','','0'),('superstar','超级明星','在个人主页，给自己的头像增加超级明星标识','','30','3','86400','999','0','1','0','','0'),('viewmagiclog','八卦镜','查看指定用户最近使用的道具记录','','100','5','86400','999','0','1','0','','0'),('viewmagic','透视镜','查看指定用户当前持有的道具','','100','5','86400','999','0','1','0','','0'),('viewvisitor','偷窥镜','查看指定用户最近访问过的10个空间','','100','5','86400','999','0','1','0','','0'),('call','点名卡','发通知给自己的好友，让他们来查看指定的对象','','50','5','86400','999','0','1','0','','0'),('coupon','代金券','购买道具时折换一定量的积分','','0','0','0','0','0','1','0','','0'),('frame','相框','给自己的照片添上相框','','30','3','86400','999','0','1','0','','0'),('bgimage','信纸','给指定的对象添加信纸背景','','30','3','86400','999','0','1','0','','0'),('doodle','涂鸦板','允许在留言、评论等操作时使用涂鸦板','','30','3','86400','999','0','1','0','','0'),('anonymous','匿名卡','在指定的地方，让自己的名字显示为匿名','','50','5','86400','999','0','1','0','','0'),('reveal','照妖镜','可以查看一次匿名用户的真实身份','','100','5','86400','999','0','1','0','','0'),('license','道具转让许可证','使用许可证，将道具赠送给指定好友','','10','1','3600','999','0','1','0','','0'),('detector','探测器','探测埋了红包的空间','','10','1','86400','999','0','1','0','','0');
/*!40000 ALTER TABLE `uchome_magic` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_magicinlog`;
CREATE TABLE `uchome_magicinlog` (
  `logid` mediumint(8) unsigned NOT NULL auto_increment,
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(15) NOT NULL default '',
  `mid` varchar(15) NOT NULL default '',
  `count` smallint(6) unsigned NOT NULL default '0',
  `type` tinyint(3) unsigned NOT NULL default '0',
  `fromid` mediumint(8) unsigned NOT NULL default '0',
  `credit` smallint(6) unsigned NOT NULL default '0',
  `dateline` int(10) NOT NULL default '0',
  PRIMARY KEY  (`logid`),
  KEY `uid` (`uid`,`dateline`),
  KEY `type` (`type`,`fromid`,`dateline`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_magicinlog` DISABLE KEYS */;
INSERT INTO `uchome_magicinlog` VALUES ('1','2','majin','gift','1','1','0','20','1305286762');
/*!40000 ALTER TABLE `uchome_magicinlog` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_magicstore`;
CREATE TABLE `uchome_magicstore` (
  `mid` varchar(15) NOT NULL default '',
  `storage` smallint(6) unsigned NOT NULL default '0',
  `lastprovide` int(10) unsigned NOT NULL default '0',
  `sellcount` int(8) unsigned NOT NULL default '0',
  `sellcredit` int(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_magicstore` DISABLE KEYS */;
INSERT INTO `uchome_magicstore` VALUES ('thunder','5','1305286532','0','0'),('gift','998','1305286753','1','20');
/*!40000 ALTER TABLE `uchome_magicstore` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_magicuselog`;
CREATE TABLE `uchome_magicuselog` (
  `logid` mediumint(8) unsigned NOT NULL auto_increment,
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(15) NOT NULL default '',
  `mid` varchar(15) NOT NULL default '',
  `id` mediumint(8) unsigned NOT NULL default '0',
  `idtype` varchar(20) NOT NULL default '',
  `count` mediumint(8) unsigned NOT NULL default '0',
  `data` text NOT NULL,
  `dateline` int(10) unsigned NOT NULL default '0',
  `expire` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`logid`),
  KEY `uid` (`uid`,`mid`),
  KEY `id` (`id`,`idtype`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_magicuselog` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_magicuselog` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_mailcron`;
CREATE TABLE `uchome_mailcron` (
  `cid` mediumint(8) unsigned NOT NULL auto_increment,
  `touid` mediumint(8) unsigned NOT NULL default '0',
  `email` varchar(100) NOT NULL default '',
  `sendtime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`cid`),
  KEY `sendtime` (`sendtime`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_mailcron` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_mailcron` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_mailqueue`;
CREATE TABLE `uchome_mailqueue` (
  `qid` mediumint(8) unsigned NOT NULL auto_increment,
  `cid` mediumint(8) unsigned NOT NULL default '0',
  `subject` text NOT NULL,
  `message` text NOT NULL,
  `dateline` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`qid`),
  KEY `mcid` (`cid`,`dateline`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_mailqueue` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_mailqueue` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_member`;
CREATE TABLE `uchome_member` (
  `uid` mediumint(8) unsigned NOT NULL auto_increment,
  `username` char(15) NOT NULL default '',
  `password` char(32) NOT NULL default '',
  PRIMARY KEY  (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_member` DISABLE KEYS */;
INSERT INTO `uchome_member` VALUES ('1','admin','573a87daa1ab67464820205977de254a'),('2','majin','a4723c697c1ec3e9206290a72ff5e50c'),('3','hz123','7647f7d86dc5363966572f629e3e4cbd'),('4','maj','edb5ad9cd12070c367333f83dea09e5b');
/*!40000 ALTER TABLE `uchome_member` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_mtag`;
CREATE TABLE `uchome_mtag` (
  `tagid` mediumint(8) unsigned NOT NULL auto_increment,
  `tagname` varchar(40) NOT NULL default '',
  `fieldid` smallint(6) NOT NULL default '0',
  `membernum` mediumint(8) unsigned NOT NULL default '0',
  `threadnum` mediumint(8) unsigned NOT NULL default '0',
  `postnum` mediumint(8) unsigned NOT NULL default '0',
  `close` tinyint(1) NOT NULL default '0',
  `announcement` text NOT NULL,
  `pic` varchar(150) NOT NULL default '',
  `closeapply` tinyint(1) NOT NULL default '0',
  `joinperm` tinyint(1) NOT NULL default '0',
  `viewperm` tinyint(1) NOT NULL default '0',
  `threadperm` tinyint(1) NOT NULL default '0',
  `postperm` tinyint(1) NOT NULL default '0',
  `recommend` tinyint(1) NOT NULL default '0',
  `moderator` varchar(255) NOT NULL default '',
  `ext_id` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`tagid`),
  KEY `tagname` (`tagname`),
  KEY `threadnum` (`threadnum`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_mtag` DISABLE KEYS */;
INSERT INTO `uchome_mtag` VALUES ('1','疯狂的车车','2','3','1','0','0','','','0','0','0','0','0','0','','3229'),('2','黄龙驾校群组','4','2','0','0','0','','','0','0','0','0','0','0','','1');
/*!40000 ALTER TABLE `uchome_mtag` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_mtaginvite`;
CREATE TABLE `uchome_mtaginvite` (
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `tagid` mediumint(8) unsigned NOT NULL default '0',
  `fromuid` mediumint(8) unsigned NOT NULL default '0',
  `fromusername` char(15) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`uid`,`tagid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_mtaginvite` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_mtaginvite` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_myapp`;
CREATE TABLE `uchome_myapp` (
  `appid` mediumint(8) unsigned NOT NULL default '0',
  `appname` varchar(60) NOT NULL default '',
  `narrow` tinyint(1) NOT NULL default '0',
  `flag` tinyint(1) NOT NULL default '0',
  `version` mediumint(8) unsigned NOT NULL default '0',
  `displaymethod` tinyint(1) NOT NULL default '0',
  `displayorder` smallint(6) unsigned NOT NULL default '0',
  PRIMARY KEY  (`appid`),
  KEY `flag` (`flag`,`displayorder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_myapp` DISABLE KEYS */;
INSERT INTO `uchome_myapp` VALUES ('1058035','汽车工厂','0','1','0','0','1'),('1003094','争车位','0','1','0','0','2'),('1005122','德克萨斯扑克','1','0','0','0','0');
/*!40000 ALTER TABLE `uchome_myapp` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_myinvite`;
CREATE TABLE `uchome_myinvite` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `typename` varchar(100) NOT NULL default '',
  `appid` mediumint(8) NOT NULL default '0',
  `type` tinyint(1) NOT NULL default '0',
  `fromuid` mediumint(8) unsigned NOT NULL default '0',
  `touid` mediumint(8) unsigned NOT NULL default '0',
  `myml` text NOT NULL,
  `dateline` int(10) unsigned NOT NULL default '0',
  `hash` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `hash` (`hash`),
  KEY `uid` (`touid`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_myinvite` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_myinvite` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_notification`;
CREATE TABLE `uchome_notification` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `type` varchar(20) NOT NULL default '',
  `new` tinyint(1) NOT NULL default '0',
  `authorid` mediumint(8) unsigned NOT NULL default '0',
  `author` varchar(15) NOT NULL default '',
  `note` text NOT NULL,
  `dateline` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`,`new`,`dateline`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_notification` DISABLE KEYS */;
INSERT INTO `uchome_notification` VALUES ('1','2','clickthread','0','4','maj','对你的话题 <a href=\"space.php?uid=2&do=thread&id=1\" target=\"_blank\">感觉少了点什么</a> 做了表态','1306168813');
/*!40000 ALTER TABLE `uchome_notification` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_pic`;
CREATE TABLE `uchome_pic` (
  `picid` mediumint(8) NOT NULL auto_increment,
  `albumid` mediumint(8) unsigned NOT NULL default '0',
  `topicid` mediumint(8) unsigned NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(15) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  `postip` varchar(20) NOT NULL default '',
  `filename` varchar(100) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `type` varchar(20) NOT NULL default '',
  `size` int(10) unsigned NOT NULL default '0',
  `filepath` varchar(60) NOT NULL default '',
  `thumb` tinyint(1) NOT NULL default '0',
  `remote` tinyint(1) NOT NULL default '0',
  `hot` mediumint(8) unsigned NOT NULL default '0',
  `click_6` smallint(6) unsigned NOT NULL default '0',
  `click_7` smallint(6) unsigned NOT NULL default '0',
  `click_8` smallint(6) unsigned NOT NULL default '0',
  `click_9` smallint(6) unsigned NOT NULL default '0',
  `click_10` smallint(6) unsigned NOT NULL default '0',
  `magicframe` tinyint(6) NOT NULL default '0',
  PRIMARY KEY  (`picid`),
  KEY `albumid` (`albumid`,`dateline`),
  KEY `topicid` (`topicid`,`dateline`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_pic` DISABLE KEYS */;
INSERT INTO `uchome_pic` VALUES ('1','1','0','2','majin','1306276964','222.82.253.154','u=3356148545,2971559776&fm=0&gp=0.jpg','酷车','image/pjpeg','4624','201105/24/2_13062769642CHT.jpg','1','0','0','0','0','0','0','0','0');
/*!40000 ALTER TABLE `uchome_pic` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_picfield`;
CREATE TABLE `uchome_picfield` (
  `picid` mediumint(8) unsigned NOT NULL default '0',
  `hotuser` text NOT NULL,
  PRIMARY KEY  (`picid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_picfield` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_picfield` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_poke`;
CREATE TABLE `uchome_poke` (
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `fromuid` mediumint(8) unsigned NOT NULL default '0',
  `fromusername` varchar(15) NOT NULL default '',
  `note` varchar(255) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  `iconid` smallint(6) unsigned NOT NULL default '0',
  PRIMARY KEY  (`uid`,`fromuid`),
  KEY `uid` (`uid`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_poke` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_poke` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_poll`;
CREATE TABLE `uchome_poll` (
  `pid` mediumint(8) unsigned NOT NULL auto_increment,
  `topicid` mediumint(8) unsigned NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` char(15) NOT NULL default '',
  `subject` char(80) NOT NULL default '',
  `voternum` mediumint(8) unsigned NOT NULL default '0',
  `replynum` mediumint(8) unsigned NOT NULL default '0',
  `multiple` tinyint(1) NOT NULL default '0',
  `maxchoice` tinyint(3) NOT NULL default '0',
  `sex` tinyint(1) NOT NULL default '0',
  `noreply` tinyint(1) NOT NULL default '0',
  `credit` mediumint(8) unsigned NOT NULL default '0',
  `percredit` mediumint(8) unsigned NOT NULL default '0',
  `expiration` int(10) unsigned NOT NULL default '0',
  `lastvote` int(10) unsigned NOT NULL default '0',
  `dateline` int(10) unsigned NOT NULL default '0',
  `hot` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`pid`),
  KEY `uid` (`uid`,`dateline`),
  KEY `topicid` (`topicid`,`dateline`),
  KEY `voternum` (`voternum`),
  KEY `dateline` (`dateline`),
  KEY `lastvote` (`lastvote`),
  KEY `hot` (`hot`),
  KEY `percredit` (`percredit`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_poll` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_poll` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_pollfield`;
CREATE TABLE `uchome_pollfield` (
  `pid` mediumint(8) unsigned NOT NULL default '0',
  `notify` tinyint(1) NOT NULL default '0',
  `message` text NOT NULL,
  `summary` text NOT NULL,
  `option` text NOT NULL,
  `invite` text NOT NULL,
  `hotuser` text NOT NULL,
  PRIMARY KEY  (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_pollfield` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_pollfield` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_polloption`;
CREATE TABLE `uchome_polloption` (
  `oid` mediumint(8) unsigned NOT NULL auto_increment,
  `pid` mediumint(8) unsigned NOT NULL default '0',
  `votenum` mediumint(8) unsigned NOT NULL default '0',
  `option` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`oid`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_polloption` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_polloption` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_polluser`;
CREATE TABLE `uchome_polluser` (
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(15) NOT NULL default '',
  `pid` mediumint(8) unsigned NOT NULL default '0',
  `option` text NOT NULL,
  `dateline` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`uid`,`pid`),
  KEY `pid` (`pid`,`dateline`),
  KEY `uid` (`uid`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_polluser` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_polluser` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_post`;
CREATE TABLE `uchome_post` (
  `pid` int(10) unsigned NOT NULL auto_increment,
  `tagid` mediumint(8) unsigned NOT NULL default '0',
  `tid` mediumint(8) unsigned NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(15) NOT NULL default '',
  `ip` varchar(20) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  `message` text NOT NULL,
  `pic` varchar(255) NOT NULL default '',
  `isthread` tinyint(1) NOT NULL default '0',
  `hotuser` text NOT NULL,
  PRIMARY KEY  (`pid`),
  KEY `tid` (`tid`,`dateline`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_post` DISABLE KEYS */;
INSERT INTO `uchome_post` VALUES ('1','1','1','2','majin','124.160.47.70','1305994851','<DIV>如题！！！</DIV>','','1','4');
/*!40000 ALTER TABLE `uchome_post` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_profield`;
CREATE TABLE `uchome_profield` (
  `fieldid` smallint(6) unsigned NOT NULL auto_increment,
  `title` varchar(80) NOT NULL default '',
  `note` varchar(255) NOT NULL default '',
  `formtype` varchar(20) NOT NULL default '0',
  `inputnum` smallint(3) unsigned NOT NULL default '0',
  `choice` text NOT NULL,
  `mtagminnum` smallint(6) unsigned NOT NULL default '0',
  `manualmoderator` tinyint(1) NOT NULL default '0',
  `manualmember` tinyint(1) NOT NULL default '0',
  `displayorder` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`fieldid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_profield` DISABLE KEYS */;
INSERT INTO `uchome_profield` VALUES ('1','自由联盟','','text','100','','0','0','1','0'),('2','区域联盟','','text','100','','0','0','1','0'),('3','车系联盟','','text','100','','0','0','1','0'),('4','驾校联盟','','text','0','','0','0','0','0');
/*!40000 ALTER TABLE `uchome_profield` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_profilefield`;
CREATE TABLE `uchome_profilefield` (
  `fieldid` smallint(6) unsigned NOT NULL auto_increment,
  `title` varchar(80) NOT NULL default '',
  `note` varchar(255) NOT NULL default '',
  `formtype` varchar(20) NOT NULL default '0',
  `maxsize` tinyint(3) unsigned NOT NULL default '0',
  `required` tinyint(1) NOT NULL default '0',
  `invisible` tinyint(1) NOT NULL default '0',
  `allowsearch` tinyint(1) NOT NULL default '0',
  `choice` text NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`fieldid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_profilefield` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_profilefield` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_rate`;
CREATE TABLE `uchome_rate` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `school_id` int(11) unsigned NOT NULL default '0',
  `rate` decimal(4,2) unsigned NOT NULL default '0.00',
  `price` tinyint(3) unsigned NOT NULL default '0',
  `service` tinyint(3) unsigned NOT NULL default '0',
  `environment` tinyint(3) unsigned NOT NULL default '0',
  `coach` tinyint(3) unsigned NOT NULL default '0',
  `comment` text NOT NULL,
  `uid` int(11) unsigned NOT NULL default '0',
  `ip` varchar(16) NOT NULL default '',
  `addtime` datetime NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_rate` DISABLE KEYS */;
INSERT INTO `uchome_rate` VALUES ('1','1','2.50','1','2','3','4','非常好\r\n比较好\r\n一般好\r\n不很好\r\n很不好','1','192.168.1.102','2011-05-24 20:55:21','1'),('2','1','3.50','5','4','3','2','平均3.5','1','192.168.1.102','2011-05-24 22:29:30','1'),('3','1','3.80','5','3','3','4','还可以！','2','222.82.253.154','2011-05-24 22:36:19','1');
/*!40000 ALTER TABLE `uchome_rate` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_region`;
CREATE TABLE `uchome_region` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `pid` smallint(5) unsigned NOT NULL default '0',
  `name` varchar(120) NOT NULL default '',
  `coords` varchar(255) NOT NULL default '',
  `shape` varchar(4) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `parent_id` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=3409 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*!40000 ALTER TABLE `uchome_region` DISABLE KEYS */;
INSERT INTO `uchome_region` VALUES ('1','0','中国','',''),('2','1','北京','455,209,495,226','rect'),('3','1','安徽','449,309,489,326','rect'),('4','1','福建','485,367,525,384','rect'),('5','1','甘肃','231,191,271,208','rect'),('6','1','广东','434,391,474,408','rect'),('7','1','广西','364,397,404,414','rect'),('8','1','贵州','332,366,372,383','rect'),('9','1','海南','388,454,428,471','rect'),('10','1','河北','416,193,456,210','rect'),('11','1','河南','399,283,439,300','rect'),('12','1','黑龙江','548,92,600,99','rect'),('13','1','湖北','405,315,445,332','rect'),('14','1','湖南','383,353,423,370','rect'),('15','1','吉林','557,148,597,165','rect'),('16','1','江苏','485,284,525,301','rect'),('17','1','江西','426,361,466,378','rect'),('18','1','辽宁','518,183,558,200','rect'),('19','1','内蒙古','431,144,483,162','rect'),('20','1','宁夏','319,235,359,252','rect'),('21','1','青海','223,250,263,267','rect'),('22','1','山东','452,250,492,267','rect'),('23','1','山西','386,236,426,253','rect'),('24','1','陕西','335,285,375,302','rect'),('25','1','上海','507,311,547,328','rect'),('26','1','四川','293,318,333,335','rect'),('27','1','天津','462,228,502,245','rect'),('28','1','西藏','115,295,155,312','rect'),('29','1','新疆','98,180,138,197','rect'),('30','1','云南','280,388,320,405','rect'),('31','1','浙江','501,332,543,349','rect'),('32','1','重庆','349,318,389,335','rect'),('33','1','香港','430,415,470,432','rect'),('34','1','澳门','364,425,404,442','rect'),('35','1','台湾','503,403,543,420','rect'),('36','3','安庆','',''),('37','3','蚌埠','',''),('38','3','巢湖','',''),('39','3','池州','',''),('40','3','滁州','',''),('41','3','阜阳','',''),('42','3','淮北','',''),('43','3','淮南','',''),('44','3','黄山','',''),('45','3','六安','',''),('46','3','马鞍山','',''),('47','3','宿州','',''),('48','3','铜陵','',''),('49','3','芜湖','',''),('50','3','宣城','',''),('51','3','亳州','',''),('52','2','北京','',''),('53','4','福州','',''),('54','4','龙岩','',''),('55','4','南平','',''),('56','4','宁德','',''),('57','4','莆田','',''),('58','4','泉州','',''),('59','4','三明','',''),('60','4','厦门','',''),('61','4','漳州','',''),('62','5','兰州','',''),('63','5','白银','',''),('64','5','定西','',''),('65','5','甘南','',''),('66','5','嘉峪关','',''),('67','5','金昌','',''),('68','5','酒泉','',''),('69','5','临夏','',''),('70','5','陇南','',''),('71','5','平凉','',''),('72','5','庆阳','',''),('73','5','天水','',''),('74','5','武威','',''),('75','5','张掖','',''),('76','6','广州','',''),('77','6','深圳','',''),('78','6','潮州','',''),('79','6','东莞','',''),('80','6','佛山','',''),('81','6','河源','',''),('82','6','惠州','',''),('83','6','江门','',''),('84','6','揭阳','',''),('85','6','茂名','',''),('86','6','梅州','',''),('87','6','清远','',''),('88','6','汕头','',''),('89','6','汕尾','',''),('90','6','韶关','',''),('91','6','阳江','',''),('92','6','云浮','',''),('93','6','湛江','',''),('94','6','肇庆','',''),('95','6','中山','',''),('96','6','珠海','',''),('97','7','南宁','',''),('98','7','桂林','',''),('99','7','百色','',''),('100','7','北海','',''),('101','7','崇左','',''),('102','7','防城港','',''),('103','7','贵港','',''),('104','7','河池','',''),('105','7','贺州','',''),('106','7','来宾','',''),('107','7','柳州','',''),('108','7','钦州','',''),('109','7','梧州','',''),('110','7','玉林','',''),('111','8','贵阳','',''),('112','8','安顺','',''),('113','8','毕节','',''),('114','8','六盘水','',''),('115','8','黔东南','',''),('116','8','黔南','',''),('117','8','黔西南','',''),('118','8','铜仁','',''),('119','8','遵义','',''),('120','9','海口','',''),('121','9','三亚','',''),('122','9','白沙','',''),('123','9','保亭','',''),('124','9','昌江','',''),('125','9','澄迈县','',''),('126','9','定安县','',''),('127','9','东方','',''),('128','9','乐东','',''),('129','9','临高县','',''),('130','9','陵水','',''),('131','9','琼海','',''),('132','9','琼中','',''),('133','9','屯昌县','',''),('134','9','万宁','',''),('135','9','文昌','',''),('136','9','五指山','',''),('137','9','儋州','',''),('138','10','石家庄','',''),('139','10','保定','',''),('140','10','沧州','',''),('141','10','承德','',''),('142','10','邯郸','',''),('143','10','衡水','',''),('144','10','廊坊','',''),('145','10','秦皇岛','',''),('146','10','唐山','',''),('147','10','邢台','',''),('148','10','张家口','',''),('149','11','郑州','',''),('150','11','洛阳','',''),('151','11','开封','',''),('152','11','安阳','',''),('153','11','鹤壁','',''),('154','11','济源','',''),('155','11','焦作','',''),('156','11','南阳','',''),('157','11','平顶山','',''),('158','11','三门峡','',''),('159','11','商丘','',''),('160','11','新乡','',''),('161','11','信阳','',''),('162','11','许昌','',''),('163','11','周口','',''),('164','11','驻马店','',''),('165','11','漯河','',''),('166','11','濮阳','',''),('167','12','哈尔滨','',''),('168','12','大庆','',''),('169','12','大兴安岭','',''),('170','12','鹤岗','',''),('171','12','黑河','',''),('172','12','鸡西','',''),('173','12','佳木斯','',''),('174','12','牡丹江','',''),('175','12','七台河','',''),('176','12','齐齐哈尔','',''),('177','12','双鸭山','',''),('178','12','绥化','',''),('179','12','伊春','',''),('180','13','武汉','',''),('181','13','仙桃','',''),('182','13','鄂州','',''),('183','13','黄冈','',''),('184','13','黄石','',''),('185','13','荆门','',''),('186','13','荆州','',''),('187','13','潜江','',''),('188','13','神农架林区','',''),('189','13','十堰','',''),('190','13','随州','',''),('191','13','天门','',''),('192','13','咸宁','',''),('193','13','襄樊','',''),('194','13','孝感','',''),('195','13','宜昌','',''),('196','13','恩施','',''),('197','14','长沙','',''),('198','14','张家界','',''),('199','14','常德','',''),('200','14','郴州','',''),('201','14','衡阳','',''),('202','14','怀化','',''),('203','14','娄底','',''),('204','14','邵阳','',''),('205','14','湘潭','',''),('206','14','湘西','',''),('207','14','益阳','',''),('208','14','永州','',''),('209','14','岳阳','',''),('210','14','株洲','',''),('211','15','长春','',''),('212','15','吉林','',''),('213','15','白城','',''),('214','15','白山','',''),('215','15','辽源','',''),('216','15','四平','',''),('217','15','松原','',''),('218','15','通化','',''),('219','15','延边','',''),('220','16','南京','',''),('221','16','苏州','',''),('222','16','无锡','',''),('223','16','常州','',''),('224','16','淮安','',''),('225','16','连云港','',''),('226','16','南通','',''),('227','16','宿迁','',''),('228','16','泰州','',''),('229','16','徐州','',''),('230','16','盐城','',''),('231','16','扬州','',''),('232','16','镇江','',''),('233','17','南昌','',''),('234','17','抚州','',''),('235','17','赣州','',''),('236','17','吉安','',''),('237','17','景德镇','',''),('238','17','九江','',''),('239','17','萍乡','',''),('240','17','上饶','',''),('241','17','新余','',''),('242','17','宜春','',''),('243','17','鹰潭','',''),('244','18','沈阳','',''),('245','18','大连','',''),('246','18','鞍山','',''),('247','18','本溪','',''),('248','18','朝阳','',''),('249','18','丹东','',''),('250','18','抚顺','',''),('251','18','阜新','',''),('252','18','葫芦岛','',''),('253','18','锦州','',''),('254','18','辽阳','',''),('255','18','盘锦','',''),('256','18','铁岭','',''),('257','18','营口','',''),('258','19','呼和浩特','',''),('259','19','阿拉善盟','',''),('260','19','巴彦淖尔盟','',''),('261','19','包头','',''),('262','19','赤峰','',''),('263','19','鄂尔多斯','',''),('264','19','呼伦贝尔','',''),('265','19','通辽','',''),('266','19','乌海','',''),('267','19','乌兰察布市','',''),('268','19','锡林郭勒盟','',''),('269','19','兴安盟','',''),('270','20','银川','',''),('271','20','固原','',''),('272','20','石嘴山','',''),('273','20','吴忠','',''),('274','20','中卫','',''),('275','21','西宁','',''),('276','21','果洛','',''),('277','21','海北','',''),('278','21','海东','',''),('279','21','海南','',''),('280','21','海西','',''),('281','21','黄南','',''),('282','21','玉树','',''),('283','22','济南','',''),('284','22','青岛','',''),('285','22','滨州','',''),('286','22','德州','',''),('287','22','东营','',''),('288','22','菏泽','',''),('289','22','济宁','',''),('290','22','莱芜','',''),('291','22','聊城','',''),('292','22','临沂','',''),('293','22','日照','',''),('294','22','泰安','',''),('295','22','威海','',''),('296','22','潍坊','',''),('297','22','烟台','',''),('298','22','枣庄','',''),('299','22','淄博','',''),('300','23','太原','',''),('301','23','长治','',''),('302','23','大同','',''),('303','23','晋城','',''),('304','23','晋中','',''),('305','23','临汾','',''),('306','23','吕梁','',''),('307','23','朔州','',''),('308','23','忻州','',''),('309','23','阳泉','',''),('310','23','运城','',''),('311','24','西安','',''),('312','24','安康','',''),('313','24','宝鸡','',''),('314','24','汉中','',''),('315','24','商洛','',''),('316','24','铜川','',''),('317','24','渭南','',''),('318','24','咸阳','',''),('319','24','延安','',''),('320','24','榆林','',''),('321','25','上海','',''),('322','26','成都','',''),('323','26','绵阳','',''),('324','26','阿坝','',''),('325','26','巴中','',''),('326','26','达州','',''),('327','26','德阳','',''),('328','26','甘孜','',''),('329','26','广安','',''),('330','26','广元','',''),('331','26','乐山','',''),('332','26','凉山','',''),('333','26','眉山','',''),('334','26','南充','',''),('335','26','内江','',''),('336','26','攀枝花','',''),('337','26','遂宁','',''),('338','26','雅安','',''),('339','26','宜宾','',''),('340','26','资阳','',''),('341','26','自贡','',''),('342','26','泸州','',''),('343','27','天津','',''),('344','28','拉萨','',''),('345','28','阿里','',''),('346','28','昌都','',''),('347','28','林芝','',''),('348','28','那曲','',''),('349','28','日喀则','',''),('350','28','山南','',''),('351','29','乌鲁木齐','',''),('352','29','阿克苏','',''),('353','29','阿拉尔','',''),('354','29','巴音郭楞','',''),('355','29','博尔塔拉','',''),('356','29','昌吉','',''),('357','29','哈密','',''),('358','29','和田','',''),('359','29','喀什','',''),('360','29','克拉玛依','',''),('361','29','克孜勒苏','',''),('362','29','石河子','',''),('363','29','图木舒克','',''),('364','29','吐鲁番','',''),('365','29','五家渠','',''),('366','29','伊犁','',''),('367','30','昆明','',''),('368','30','怒江','',''),('369','30','普洱','',''),('370','30','丽江','',''),('371','30','保山','',''),('372','30','楚雄','',''),('373','30','大理','',''),('374','30','德宏','',''),('375','30','迪庆','',''),('376','30','红河','',''),('377','30','临沧','',''),('378','30','曲靖','',''),('379','30','文山','',''),('380','30','西双版纳','',''),('381','30','玉溪','',''),('382','30','昭通','',''),('383','31','杭州','',''),('384','31','湖州','',''),('385','31','嘉兴','',''),('386','31','金华','',''),('387','31','丽水','',''),('388','31','宁波','',''),('389','31','绍兴','',''),('390','31','台州','',''),('391','31','温州','',''),('392','31','舟山','',''),('393','31','衢州','',''),('394','32','重庆','',''),('395','33','香港','',''),('396','34','澳门','',''),('397','35','台湾','',''),('398','36','迎江区','',''),('399','36','大观区','',''),('400','36','宜秀区','',''),('401','36','桐城市','',''),('402','36','怀宁县','',''),('403','36','枞阳县','',''),('404','36','潜山县','',''),('405','36','太湖县','',''),('406','36','宿松县','',''),('407','36','望江县','',''),('408','36','岳西县','',''),('409','37','中市区','',''),('410','37','东市区','',''),('411','37','西市区','',''),('412','37','郊区','',''),('413','37','怀远县','',''),('414','37','五河县','',''),('415','37','固镇县','',''),('416','38','居巢区','',''),('417','38','庐江县','',''),('418','38','无为县','',''),('419','38','含山县','',''),('420','38','和县','',''),('421','39','贵池区','',''),('422','39','东至县','',''),('423','39','石台县','',''),('424','39','青阳县','',''),('425','40','琅琊区','',''),('426','40','南谯区','',''),('427','40','天长市','',''),('428','40','明光市','',''),('429','40','来安县','',''),('430','40','全椒县','',''),('431','40','定远县','',''),('432','40','凤阳县','',''),('433','41','蚌山区','',''),('434','41','龙子湖区','',''),('435','41','禹会区','',''),('436','41','淮上区','',''),('437','41','颍州区','',''),('438','41','颍东区','',''),('439','41','颍泉区','',''),('440','41','界首市','',''),('441','41','临泉县','',''),('442','41','太和县','',''),('443','41','阜南县','',''),('444','41','颖上县','',''),('445','42','相山区','',''),('446','42','杜集区','',''),('447','42','烈山区','',''),('448','42','濉溪县','',''),('449','43','田家庵区','',''),('450','43','大通区','',''),('451','43','谢家集区','',''),('452','43','八公山区','',''),('453','43','潘集区','',''),('454','43','凤台县','',''),('455','44','屯溪区','',''),('456','44','黄山区','',''),('457','44','徽州区','',''),('458','44','歙县','',''),('459','44','休宁县','',''),('460','44','黟县','',''),('461','44','祁门县','',''),('462','45','金安区','',''),('463','45','裕安区','',''),('464','45','寿县','',''),('465','45','霍邱县','',''),('466','45','舒城县','',''),('467','45','金寨县','',''),('468','45','霍山县','',''),('469','46','雨山区','',''),('470','46','花山区','',''),('471','46','金家庄区','',''),('472','46','当涂县','',''),('473','47','埇桥区','',''),('474','47','砀山县','',''),('475','47','萧县','',''),('476','47','灵璧县','',''),('477','47','泗县','',''),('478','48','铜官山区','',''),('479','48','狮子山区','',''),('480','48','郊区','',''),('481','48','铜陵县','',''),('482','49','镜湖区','',''),('483','49','弋江区','',''),('484','49','鸠江区','',''),('485','49','三山区','',''),('486','49','芜湖县','',''),('487','49','繁昌县','',''),('488','49','南陵县','',''),('489','50','宣州区','',''),('490','50','宁国市','',''),('491','50','郎溪县','',''),('492','50','广德县','',''),('493','50','泾县','',''),('494','50','绩溪县','',''),('495','50','旌德县','',''),('496','51','涡阳县','',''),('497','51','蒙城县','',''),('498','51','利辛县','',''),('499','51','谯城区','',''),('500','52','东城区','',''),('501','52','西城区','',''),('502','52','海淀区','',''),('503','52','朝阳区','',''),('504','52','崇文区','',''),('505','52','宣武区','',''),('506','52','丰台区','',''),('507','52','石景山区','',''),('508','52','房山区','',''),('509','52','门头沟区','',''),('510','52','通州区','',''),('511','52','顺义区','',''),('512','52','昌平区','',''),('513','52','怀柔区','',''),('514','52','平谷区','',''),('515','52','大兴区','',''),('516','52','密云县','',''),('517','52','延庆县','',''),('518','53','鼓楼区','',''),('519','53','台江区','',''),('520','53','仓山区','',''),('521','53','马尾区','',''),('522','53','晋安区','',''),('523','53','福清市','',''),('524','53','长乐市','',''),('525','53','闽侯县','',''),('526','53','连江县','',''),('527','53','罗源县','',''),('528','53','闽清县','',''),('529','53','永泰县','',''),('530','53','平潭县','',''),('531','54','新罗区','',''),('532','54','漳平市','',''),('533','54','长汀县','',''),('534','54','永定县','',''),('535','54','上杭县','',''),('536','54','武平县','',''),('537','54','连城县','',''),('538','55','延平区','',''),('539','55','邵武市','',''),('540','55','武夷山市','',''),('541','55','建瓯市','',''),('542','55','建阳市','',''),('543','55','顺昌县','',''),('544','55','浦城县','',''),('545','55','光泽县','',''),('546','55','松溪县','',''),('547','55','政和县','',''),('548','56','蕉城区','',''),('549','56','福安市','',''),('550','56','福鼎市','',''),('551','56','霞浦县','',''),('552','56','古田县','',''),('553','56','屏南县','',''),('554','56','寿宁县','',''),('555','56','周宁县','',''),('556','56','柘荣县','',''),('557','57','城厢区','',''),('558','57','涵江区','',''),('559','57','荔城区','',''),('560','57','秀屿区','',''),('561','57','仙游县','',''),('562','58','鲤城区','',''),('563','58','丰泽区','',''),('564','58','洛江区','',''),('565','58','清濛开发区','',''),('566','58','泉港区','',''),('567','58','石狮市','',''),('568','58','晋江市','',''),('569','58','南安市','',''),('570','58','惠安县','',''),('571','58','安溪县','',''),('572','58','永春县','',''),('573','58','德化县','',''),('574','58','金门县','',''),('575','59','梅列区','',''),('576','59','三元区','',''),('577','59','永安市','',''),('578','59','明溪县','',''),('579','59','清流县','',''),('580','59','宁化县','',''),('581','59','大田县','',''),('582','59','尤溪县','',''),('583','59','沙县','',''),('584','59','将乐县','',''),('585','59','泰宁县','',''),('586','59','建宁县','',''),('587','60','思明区','',''),('588','60','海沧区','',''),('589','60','湖里区','',''),('590','60','集美区','',''),('591','60','同安区','',''),('592','60','翔安区','',''),('593','61','芗城区','',''),('594','61','龙文区','',''),('595','61','龙海市','',''),('596','61','云霄县','',''),('597','61','漳浦县','',''),('598','61','诏安县','',''),('599','61','长泰县','',''),('600','61','东山县','',''),('601','61','南靖县','',''),('602','61','平和县','',''),('603','61','华安县','',''),('604','62','皋兰县','',''),('605','62','城关区','',''),('606','62','七里河区','',''),('607','62','西固区','',''),('608','62','安宁区','',''),('609','62','红古区','',''),('610','62','永登县','',''),('611','62','榆中县','',''),('612','63','白银区','',''),('613','63','平川区','',''),('614','63','会宁县','',''),('615','63','景泰县','',''),('616','63','靖远县','',''),('617','64','临洮县','',''),('618','64','陇西县','',''),('619','64','通渭县','',''),('620','64','渭源县','',''),('621','64','漳县','',''),('622','64','岷县','',''),('623','64','安定区','',''),('624','64','安定区','',''),('625','65','合作市','',''),('626','65','临潭县','',''),('627','65','卓尼县','',''),('628','65','舟曲县','',''),('629','65','迭部县','',''),('630','65','玛曲县','',''),('631','65','碌曲县','',''),('632','65','夏河县','',''),('633','66','嘉峪关市','',''),('634','67','金川区','',''),('635','67','永昌县','',''),('636','68','肃州区','',''),('637','68','玉门市','',''),('638','68','敦煌市','',''),('639','68','金塔县','',''),('640','68','瓜州县','',''),('641','68','肃北','',''),('642','68','阿克塞','',''),('643','69','临夏市','',''),('644','69','临夏县','',''),('645','69','康乐县','',''),('646','69','永靖县','',''),('647','69','广河县','',''),('648','69','和政县','',''),('649','69','东乡族自治县','',''),('650','69','积石山','',''),('651','70','成县','',''),('652','70','徽县','',''),('653','70','康县','',''),('654','70','礼县','',''),('655','70','两当县','',''),('656','70','文县','',''),('657','70','西和县','',''),('658','70','宕昌县','',''),('659','70','武都区','',''),('660','71','崇信县','',''),('661','71','华亭县','',''),('662','71','静宁县','',''),('663','71','灵台县','',''),('664','71','崆峒区','',''),('665','71','庄浪县','',''),('666','71','泾川县','',''),('667','72','合水县','',''),('668','72','华池县','',''),('669','72','环县','',''),('670','72','宁县','',''),('671','72','庆城县','',''),('672','72','西峰区','',''),('673','72','镇原县','',''),('674','72','正宁县','',''),('675','73','甘谷县','',''),('676','73','秦安县','',''),('677','73','清水县','',''),('678','73','秦州区','',''),('679','73','麦积区','',''),('680','73','武山县','',''),('681','73','张家川','',''),('682','74','古浪县','',''),('683','74','民勤县','',''),('684','74','天祝','',''),('685','74','凉州区','',''),('686','75','高台县','',''),('687','75','临泽县','',''),('688','75','民乐县','',''),('689','75','山丹县','',''),('690','75','肃南','',''),('691','75','甘州区','',''),('692','76','从化市','',''),('693','76','天河区','',''),('694','76','东山区','',''),('695','76','白云区','',''),('696','76','海珠区','',''),('697','76','荔湾区','',''),('698','76','越秀区','',''),('699','76','黄埔区','',''),('700','76','番禺区','',''),('701','76','花都区','',''),('702','76','增城区','',''),('703','76','从化区','',''),('704','76','市郊','',''),('705','77','福田区','',''),('706','77','罗湖区','',''),('707','77','南山区','',''),('708','77','宝安区','',''),('709','77','龙岗区','',''),('710','77','盐田区','',''),('711','78','湘桥区','',''),('712','78','潮安县','',''),('713','78','饶平县','',''),('714','79','南城区','',''),('715','79','东城区','',''),('716','79','万江区','',''),('717','79','莞城区','',''),('718','79','石龙镇','',''),('719','79','虎门镇','',''),('720','79','麻涌镇','',''),('721','79','道滘镇','',''),('722','79','石碣镇','',''),('723','79','沙田镇','',''),('724','79','望牛墩镇','',''),('725','79','洪梅镇','',''),('726','79','茶山镇','',''),('727','79','寮步镇','',''),('728','79','大岭山镇','',''),('729','79','大朗镇','',''),('730','79','黄江镇','',''),('731','79','樟木头','',''),('732','79','凤岗镇','',''),('733','79','塘厦镇','',''),('734','79','谢岗镇','',''),('735','79','厚街镇','',''),('736','79','清溪镇','',''),('737','79','常平镇','',''),('738','79','桥头镇','',''),('739','79','横沥镇','',''),('740','79','东坑镇','',''),('741','79','企石镇','',''),('742','79','石排镇','',''),('743','79','长安镇','',''),('744','79','中堂镇','',''),('745','79','高埗镇','',''),('746','80','禅城区','',''),('747','80','南海区','',''),('748','80','顺德区','',''),('749','80','三水区','',''),('750','80','高明区','',''),('751','81','东源县','',''),('752','81','和平县','',''),('753','81','源城区','',''),('754','81','连平县','',''),('755','81','龙川县','',''),('756','81','紫金县','',''),('757','82','惠阳区','',''),('758','82','惠城区','',''),('759','82','大亚湾','',''),('760','82','博罗县','',''),('761','82','惠东县','',''),('762','82','龙门县','',''),('763','83','江海区','',''),('764','83','蓬江区','',''),('765','83','新会区','',''),('766','83','台山市','',''),('767','83','开平市','',''),('768','83','鹤山市','',''),('769','83','恩平市','',''),('770','84','榕城区','',''),('771','84','普宁市','',''),('772','84','揭东县','',''),('773','84','揭西县','',''),('774','84','惠来县','',''),('775','85','茂南区','',''),('776','85','茂港区','',''),('777','85','高州市','',''),('778','85','化州市','',''),('779','85','信宜市','',''),('780','85','电白县','',''),('781','86','梅县','',''),('782','86','梅江区','',''),('783','86','兴宁市','',''),('784','86','大埔县','',''),('785','86','丰顺县','',''),('786','86','五华县','',''),('787','86','平远县','',''),('788','86','蕉岭县','',''),('789','87','清城区','',''),('790','87','英德市','',''),('791','87','连州市','',''),('792','87','佛冈县','',''),('793','87','阳山县','',''),('794','87','清新县','',''),('795','87','连山','',''),('796','87','连南','',''),('797','88','南澳县','',''),('798','88','潮阳区','',''),('799','88','澄海区','',''),('800','88','龙湖区','',''),('801','88','金平区','',''),('802','88','濠江区','',''),('803','88','潮南区','',''),('804','89','城区','',''),('805','89','陆丰市','',''),('806','89','海丰县','',''),('807','89','陆河县','',''),('808','90','曲江县','',''),('809','90','浈江区','',''),('810','90','武江区','',''),('811','90','曲江区','',''),('812','90','乐昌市','',''),('813','90','南雄市','',''),('814','90','始兴县','',''),('815','90','仁化县','',''),('816','90','翁源县','',''),('817','90','新丰县','',''),('818','90','乳源','',''),('819','91','江城区','',''),('820','91','阳春市','',''),('821','91','阳西县','',''),('822','91','阳东县','',''),('823','92','云城区','',''),('824','92','罗定市','',''),('825','92','新兴县','',''),('826','92','郁南县','',''),('827','92','云安县','',''),('828','93','赤坎区','',''),('829','93','霞山区','',''),('830','93','坡头区','',''),('831','93','麻章区','',''),('832','93','廉江市','',''),('833','93','雷州市','',''),('834','93','吴川市','',''),('835','93','遂溪县','',''),('836','93','徐闻县','',''),('837','94','肇庆市','',''),('838','94','高要市','',''),('839','94','四会市','',''),('840','94','广宁县','',''),('841','94','怀集县','',''),('842','94','封开县','',''),('843','94','德庆县','',''),('844','95','石岐街道','',''),('845','95','东区街道','',''),('846','95','西区街道','',''),('847','95','环城街道','',''),('848','95','中山港街道','',''),('849','95','五桂山街道','',''),('850','96','香洲区','',''),('851','96','斗门区','',''),('852','96','金湾区','',''),('853','97','邕宁区','',''),('854','97','青秀区','',''),('855','97','兴宁区','',''),('856','97','良庆区','',''),('857','97','西乡塘区','',''),('858','97','江南区','',''),('859','97','武鸣县','',''),('860','97','隆安县','',''),('861','97','马山县','',''),('862','97','上林县','',''),('863','97','宾阳县','',''),('864','97','横县','',''),('865','98','秀峰区','',''),('866','98','叠彩区','',''),('867','98','象山区','',''),('868','98','七星区','',''),('869','98','雁山区','',''),('870','98','阳朔县','',''),('871','98','临桂县','',''),('872','98','灵川县','',''),('873','98','全州县','',''),('874','98','平乐县','',''),('875','98','兴安县','',''),('876','98','灌阳县','',''),('877','98','荔浦县','',''),('878','98','资源县','',''),('879','98','永福县','',''),('880','98','龙胜','',''),('881','98','恭城','',''),('882','99','右江区','',''),('883','99','凌云县','',''),('884','99','平果县','',''),('885','99','西林县','',''),('886','99','乐业县','',''),('887','99','德保县','',''),('888','99','田林县','',''),('889','99','田阳县','',''),('890','99','靖西县','',''),('891','99','田东县','',''),('892','99','那坡县','',''),('893','99','隆林','',''),('894','100','海城区','',''),('895','100','银海区','',''),('896','100','铁山港区','',''),('897','100','合浦县','',''),('898','101','江州区','',''),('899','101','凭祥市','',''),('900','101','宁明县','',''),('901','101','扶绥县','',''),('902','101','龙州县','',''),('903','101','大新县','',''),('904','101','天等县','',''),('905','102','港口区','',''),('906','102','防城区','',''),('907','102','东兴市','',''),('908','102','上思县','',''),('909','103','港北区','',''),('910','103','港南区','',''),('911','103','覃塘区','',''),('912','103','桂平市','',''),('913','103','平南县','',''),('914','104','金城江区','',''),('915','104','宜州市','',''),('916','104','天峨县','',''),('917','104','凤山县','',''),('918','104','南丹县','',''),('919','104','东兰县','',''),('920','104','都安','',''),('921','104','罗城','',''),('922','104','巴马','',''),('923','104','环江','',''),('924','104','大化','',''),('925','105','八步区','',''),('926','105','钟山县','',''),('927','105','昭平县','',''),('928','105','富川','',''),('929','106','兴宾区','',''),('930','106','合山市','',''),('931','106','象州县','',''),('932','106','武宣县','',''),('933','106','忻城县','',''),('934','106','金秀','',''),('935','107','城中区','',''),('936','107','鱼峰区','',''),('937','107','柳北区','',''),('938','107','柳南区','',''),('939','107','柳江县','',''),('940','107','柳城县','',''),('941','107','鹿寨县','',''),('942','107','融安县','',''),('943','107','融水','',''),('944','107','三江','',''),('945','108','钦南区','',''),('946','108','钦北区','',''),('947','108','灵山县','',''),('948','108','浦北县','',''),('949','109','万秀区','',''),('950','109','蝶山区','',''),('951','109','长洲区','',''),('952','109','岑溪市','',''),('953','109','苍梧县','',''),('954','109','藤县','',''),('955','109','蒙山县','',''),('956','110','玉州区','',''),('957','110','北流市','',''),('958','110','容县','',''),('959','110','陆川县','',''),('960','110','博白县','',''),('961','110','兴业县','',''),('962','111','南明区','',''),('963','111','云岩区','',''),('964','111','花溪区','',''),('965','111','乌当区','',''),('966','111','白云区','',''),('967','111','小河区','',''),('968','111','金阳新区','',''),('969','111','新天园区','',''),('970','111','清镇市','',''),('971','111','开阳县','',''),('972','111','修文县','',''),('973','111','息烽县','',''),('974','112','西秀区','',''),('975','112','关岭','',''),('976','112','镇宁','',''),('977','112','紫云','',''),('978','112','平坝县','',''),('979','112','普定县','',''),('980','113','毕节市','',''),('981','113','大方县','',''),('982','113','黔西县','',''),('983','113','金沙县','',''),('984','113','织金县','',''),('985','113','纳雍县','',''),('986','113','赫章县','',''),('987','113','威宁','',''),('988','114','钟山区','',''),('989','114','六枝特区','',''),('990','114','水城县','',''),('991','114','盘县','',''),('992','115','凯里市','',''),('993','115','黄平县','',''),('994','115','施秉县','',''),('995','115','三穗县','',''),('996','115','镇远县','',''),('997','115','岑巩县','',''),('998','115','天柱县','',''),('999','115','锦屏县','',''),('1000','115','剑河县','',''),('1001','115','台江县','',''),('1002','115','黎平县','',''),('1003','115','榕江县','',''),('1004','115','从江县','',''),('1005','115','雷山县','',''),('1006','115','麻江县','',''),('1007','115','丹寨县','',''),('1008','116','都匀市','',''),('1009','116','福泉市','',''),('1010','116','荔波县','',''),('1011','116','贵定县','',''),('1012','116','瓮安县','',''),('1013','116','独山县','',''),('1014','116','平塘县','',''),('1015','116','罗甸县','',''),('1016','116','长顺县','',''),('1017','116','龙里县','',''),('1018','116','惠水县','',''),('1019','116','三都','',''),('1020','117','兴义市','',''),('1021','117','兴仁县','',''),('1022','117','普安县','',''),('1023','117','晴隆县','',''),('1024','117','贞丰县','',''),('1025','117','望谟县','',''),('1026','117','册亨县','',''),('1027','117','安龙县','',''),('1028','118','铜仁市','',''),('1029','118','江口县','',''),('1030','118','石阡县','',''),('1031','118','思南县','',''),('1032','118','德江县','',''),('1033','118','玉屏','',''),('1034','118','印江','',''),('1035','118','沿河','',''),('1036','118','松桃','',''),('1037','118','万山特区','',''),('1038','119','红花岗区','',''),('1039','119','务川县','',''),('1040','119','道真县','',''),('1041','119','汇川区','',''),('1042','119','赤水市','',''),('1043','119','仁怀市','',''),('1044','119','遵义县','',''),('1045','119','桐梓县','',''),('1046','119','绥阳县','',''),('1047','119','正安县','',''),('1048','119','凤冈县','',''),('1049','119','湄潭县','',''),('1050','119','余庆县','',''),('1051','119','习水县','',''),('1052','119','道真','',''),('1053','119','务川','',''),('1054','120','秀英区','',''),('1055','120','龙华区','',''),('1056','120','琼山区','',''),('1057','120','美兰区','',''),('1058','137','市区','',''),('1059','137','洋浦开发区','',''),('1060','137','那大镇','',''),('1061','137','王五镇','',''),('1062','137','雅星镇','',''),('1063','137','大成镇','',''),('1064','137','中和镇','',''),('1065','137','峨蔓镇','',''),('1066','137','南丰镇','',''),('1067','137','白马井镇','',''),('1068','137','兰洋镇','',''),('1069','137','和庆镇','',''),('1070','137','海头镇','',''),('1071','137','排浦镇','',''),('1072','137','东成镇','',''),('1073','137','光村镇','',''),('1074','137','木棠镇','',''),('1075','137','新州镇','',''),('1076','137','三都镇','',''),('1077','137','其他','',''),('1078','138','长安区','',''),('1079','138','桥东区','',''),('1080','138','桥西区','',''),('1081','138','新华区','',''),('1082','138','裕华区','',''),('1083','138','井陉矿区','',''),('1084','138','高新区','',''),('1085','138','辛集市','',''),('1086','138','藁城市','',''),('1087','138','晋州市','',''),('1088','138','新乐市','',''),('1089','138','鹿泉市','',''),('1090','138','井陉县','',''),('1091','138','正定县','',''),('1092','138','栾城县','',''),('1093','138','行唐县','',''),('1094','138','灵寿县','',''),('1095','138','高邑县','',''),('1096','138','深泽县','',''),('1097','138','赞皇县','',''),('1098','138','无极县','',''),('1099','138','平山县','',''),('1100','138','元氏县','',''),('1101','138','赵县','',''),('1102','139','新市区','',''),('1103','139','南市区','',''),('1104','139','北市区','',''),('1105','139','涿州市','',''),('1106','139','定州市','',''),('1107','139','安国市','',''),('1108','139','高碑店市','',''),('1109','139','满城县','',''),('1110','139','清苑县','',''),('1111','139','涞水县','',''),('1112','139','阜平县','',''),('1113','139','徐水县','',''),('1114','139','定兴县','',''),('1115','139','唐县','',''),('1116','139','高阳县','',''),('1117','139','容城县','',''),('1118','139','涞源县','',''),('1119','139','望都县','',''),('1120','139','安新县','',''),('1121','139','易县','',''),('1122','139','曲阳县','',''),('1123','139','蠡县','',''),('1124','139','顺平县','',''),('1125','139','博野县','',''),('1126','139','雄县','',''),('1127','140','运河区','',''),('1128','140','新华区','',''),('1129','140','泊头市','',''),('1130','140','任丘市','',''),('1131','140','黄骅市','',''),('1132','140','河间市','',''),('1133','140','沧县','',''),('1134','140','青县','',''),('1135','140','东光县','',''),('1136','140','海兴县','',''),('1137','140','盐山县','',''),('1138','140','肃宁县','',''),('1139','140','南皮县','',''),('1140','140','吴桥县','',''),('1141','140','献县','',''),('1142','140','孟村','',''),('1143','141','双桥区','',''),('1144','141','双滦区','',''),('1145','141','鹰手营子矿区','',''),('1146','141','承德县','',''),('1147','141','兴隆县','',''),('1148','141','平泉县','',''),('1149','141','滦平县','',''),('1150','141','隆化县','',''),('1151','141','丰宁','',''),('1152','141','宽城','',''),('1153','141','围场','',''),('1154','142','从台区','',''),('1155','142','复兴区','',''),('1156','142','邯山区','',''),('1157','142','峰峰矿区','',''),('1158','142','武安市','',''),('1159','142','邯郸县','',''),('1160','142','临漳县','',''),('1161','142','成安县','',''),('1162','142','大名县','',''),('1163','142','涉县','',''),('1164','142','磁县','',''),('1165','142','肥乡县','',''),('1166','142','永年县','',''),('1167','142','邱县','',''),('1168','142','鸡泽县','',''),('1169','142','广平县','',''),('1170','142','馆陶县','',''),('1171','142','魏县','',''),('1172','142','曲周县','',''),('1173','143','桃城区','',''),('1174','143','冀州市','',''),('1175','143','深州市','',''),('1176','143','枣强县','',''),('1177','143','武邑县','',''),('1178','143','武强县','',''),('1179','143','饶阳县','',''),('1180','143','安平县','',''),('1181','143','故城县','',''),('1182','143','景县','',''),('1183','143','阜城县','',''),('1184','144','安次区','',''),('1185','144','广阳区','',''),('1186','144','霸州市','',''),('1187','144','三河市','',''),('1188','144','固安县','',''),('1189','144','永清县','',''),('1190','144','香河县','',''),('1191','144','大城县','',''),('1192','144','文安县','',''),('1193','144','大厂','',''),('1194','145','海港区','',''),('1195','145','山海关区','',''),('1196','145','北戴河区','',''),('1197','145','昌黎县','',''),('1198','145','抚宁县','',''),('1199','145','卢龙县','',''),('1200','145','青龙','',''),('1201','146','路北区','',''),('1202','146','路南区','',''),('1203','146','古冶区','',''),('1204','146','开平区','',''),('1205','146','丰南区','',''),('1206','146','丰润区','',''),('1207','146','遵化市','',''),('1208','146','迁安市','',''),('1209','146','滦县','',''),('1210','146','滦南县','',''),('1211','146','乐亭县','',''),('1212','146','迁西县','',''),('1213','146','玉田县','',''),('1214','146','唐海县','',''),('1215','147','桥东区','',''),('1216','147','桥西区','',''),('1217','147','南宫市','',''),('1218','147','沙河市','',''),('1219','147','邢台县','',''),('1220','147','临城县','',''),('1221','147','内丘县','',''),('1222','147','柏乡县','',''),('1223','147','隆尧县','',''),('1224','147','任县','',''),('1225','147','南和县','',''),('1226','147','宁晋县','',''),('1227','147','巨鹿县','',''),('1228','147','新河县','',''),('1229','147','广宗县','',''),('1230','147','平乡县','',''),('1231','147','威县','',''),('1232','147','清河县','',''),('1233','147','临西县','',''),('1234','148','桥西区','',''),('1235','148','桥东区','',''),('1236','148','宣化区','',''),('1237','148','下花园区','',''),('1238','148','宣化县','',''),('1239','148','张北县','',''),('1240','148','康保县','',''),('1241','148','沽源县','',''),('1242','148','尚义县','',''),('1243','148','蔚县','',''),('1244','148','阳原县','',''),('1245','148','怀安县','',''),('1246','148','万全县','',''),('1247','148','怀来县','',''),('1248','148','涿鹿县','',''),('1249','148','赤城县','',''),('1250','148','崇礼县','',''),('1251','149','金水区','',''),('1252','149','邙山区','',''),('1253','149','二七区','',''),('1254','149','管城区','',''),('1255','149','中原区','',''),('1256','149','上街区','',''),('1257','149','惠济区','',''),('1258','149','郑东新区','',''),('1259','149','经济技术开发区','',''),('1260','149','高新开发区','',''),('1261','149','出口加工区','',''),('1262','149','巩义市','',''),('1263','149','荥阳市','',''),('1264','149','新密市','',''),('1265','149','新郑市','',''),('1266','149','登封市','',''),('1267','149','中牟县','',''),('1268','150','西工区','',''),('1269','150','老城区','',''),('1270','150','涧西区','',''),('1271','150','瀍河回族区','',''),('1272','150','洛龙区','',''),('1273','150','吉利区','',''),('1274','150','偃师市','',''),('1275','150','孟津县','',''),('1276','150','新安县','',''),('1277','150','栾川县','',''),('1278','150','嵩县','',''),('1279','150','汝阳县','',''),('1280','150','宜阳县','',''),('1281','150','洛宁县','',''),('1282','150','伊川县','',''),('1283','151','鼓楼区','',''),('1284','151','龙亭区','',''),('1285','151','顺河回族区','',''),('1286','151','金明区','',''),('1287','151','禹王台区','',''),('1288','151','杞县','',''),('1289','151','通许县','',''),('1290','151','尉氏县','',''),('1291','151','开封县','',''),('1292','151','兰考县','',''),('1293','152','北关区','',''),('1294','152','文峰区','',''),('1295','152','殷都区','',''),('1296','152','龙安区','',''),('1297','152','林州市','',''),('1298','152','安阳县','',''),('1299','152','汤阴县','',''),('1300','152','滑县','',''),('1301','152','内黄县','',''),('1302','153','淇滨区','',''),('1303','153','山城区','',''),('1304','153','鹤山区','',''),('1305','153','浚县','',''),('1306','153','淇县','',''),('1307','154','济源市','',''),('1308','155','解放区','',''),('1309','155','中站区','',''),('1310','155','马村区','',''),('1311','155','山阳区','',''),('1312','155','沁阳市','',''),('1313','155','孟州市','',''),('1314','155','修武县','',''),('1315','155','博爱县','',''),('1316','155','武陟县','',''),('1317','155','温县','',''),('1318','156','卧龙区','',''),('1319','156','宛城区','',''),('1320','156','邓州市','',''),('1321','156','南召县','',''),('1322','156','方城县','',''),('1323','156','西峡县','',''),('1324','156','镇平县','',''),('1325','156','内乡县','',''),('1326','156','淅川县','',''),('1327','156','社旗县','',''),('1328','156','唐河县','',''),('1329','156','新野县','',''),('1330','156','桐柏县','',''),('1331','157','新华区','',''),('1332','157','卫东区','',''),('1333','157','湛河区','',''),('1334','157','石龙区','',''),('1335','157','舞钢市','',''),('1336','157','汝州市','',''),('1337','157','宝丰县','',''),('1338','157','叶县','',''),('1339','157','鲁山县','',''),('1340','157','郏县','',''),('1341','158','湖滨区','',''),('1342','158','义马市','',''),('1343','158','灵宝市','',''),('1344','158','渑池县','',''),('1345','158','陕县','',''),('1346','158','卢氏县','',''),('1347','159','梁园区','',''),('1348','159','睢阳区','',''),('1349','159','永城市','',''),('1350','159','民权县','',''),('1351','159','睢县','',''),('1352','159','宁陵县','',''),('1353','159','虞城县','',''),('1354','159','柘城县','',''),('1355','159','夏邑县','',''),('1356','160','卫滨区','',''),('1357','160','红旗区','',''),('1358','160','凤泉区','',''),('1359','160','牧野区','',''),('1360','160','卫辉市','',''),('1361','160','辉县市','',''),('1362','160','新乡县','',''),('1363','160','获嘉县','',''),('1364','160','原阳县','',''),('1365','160','延津县','',''),('1366','160','封丘县','',''),('1367','160','长垣县','',''),('1368','161','浉河区','',''),('1369','161','平桥区','',''),('1370','161','罗山县','',''),('1371','161','光山县','',''),('1372','161','新县','',''),('1373','161','商城县','',''),('1374','161','固始县','',''),('1375','161','潢川县','',''),('1376','161','淮滨县','',''),('1377','161','息县','',''),('1378','162','魏都区','',''),('1379','162','禹州市','',''),('1380','162','长葛市','',''),('1381','162','许昌县','',''),('1382','162','鄢陵县','',''),('1383','162','襄城县','',''),('1384','163','川汇区','',''),('1385','163','项城市','',''),('1386','163','扶沟县','',''),('1387','163','西华县','',''),('1388','163','商水县','',''),('1389','163','沈丘县','',''),('1390','163','郸城县','',''),('1391','163','淮阳县','',''),('1392','163','太康县','',''),('1393','163','鹿邑县','',''),('1394','164','驿城区','',''),('1395','164','西平县','',''),('1396','164','上蔡县','',''),('1397','164','平舆县','',''),('1398','164','正阳县','',''),('1399','164','确山县','',''),('1400','164','泌阳县','',''),('1401','164','汝南县','',''),('1402','164','遂平县','',''),('1403','164','新蔡县','',''),('1404','165','郾城区','',''),('1405','165','源汇区','',''),('1406','165','召陵区','',''),('1407','165','舞阳县','',''),('1408','165','临颍县','',''),('1409','166','华龙区','',''),('1410','166','清丰县','',''),('1411','166','南乐县','',''),('1412','166','范县','',''),('1413','166','台前县','',''),('1414','166','濮阳县','',''),('1415','167','道里区','',''),('1416','167','南岗区','',''),('1417','167','动力区','',''),('1418','167','平房区','',''),('1419','167','香坊区','',''),('1420','167','太平区','',''),('1421','167','道外区','',''),('1422','167','阿城区','',''),('1423','167','呼兰区','',''),('1424','167','松北区','',''),('1425','167','尚志市','',''),('1426','167','双城市','',''),('1427','167','五常市','',''),('1428','167','方正县','',''),('1429','167','宾县','',''),('1430','167','依兰县','',''),('1431','167','巴彦县','',''),('1432','167','通河县','',''),('1433','167','木兰县','',''),('1434','167','延寿县','',''),('1435','168','萨尔图区','',''),('1436','168','红岗区','',''),('1437','168','龙凤区','',''),('1438','168','让胡路区','',''),('1439','168','大同区','',''),('1440','168','肇州县','',''),('1441','168','肇源县','',''),('1442','168','林甸县','',''),('1443','168','杜尔伯特','',''),('1444','169','呼玛县','',''),('1445','169','漠河县','',''),('1446','169','塔河县','',''),('1447','170','兴山区','',''),('1448','170','工农区','',''),('1449','170','南山区','',''),('1450','170','兴安区','',''),('1451','170','向阳区','',''),('1452','170','东山区','',''),('1453','170','萝北县','',''),('1454','170','绥滨县','',''),('1455','171','爱辉区','',''),('1456','171','五大连池市','',''),('1457','171','北安市','',''),('1458','171','嫩江县','',''),('1459','171','逊克县','',''),('1460','171','孙吴县','',''),('1461','172','鸡冠区','',''),('1462','172','恒山区','',''),('1463','172','城子河区','',''),('1464','172','滴道区','',''),('1465','172','梨树区','',''),('1466','172','虎林市','',''),('1467','172','密山市','',''),('1468','172','鸡东县','',''),('1469','173','前进区','',''),('1470','173','郊区','',''),('1471','173','向阳区','',''),('1472','173','东风区','',''),('1473','173','同江市','',''),('1474','173','富锦市','',''),('1475','173','桦南县','',''),('1476','173','桦川县','',''),('1477','173','汤原县','',''),('1478','173','抚远县','',''),('1479','174','爱民区','',''),('1480','174','东安区','',''),('1481','174','阳明区','',''),('1482','174','西安区','',''),('1483','174','绥芬河市','',''),('1484','174','海林市','',''),('1485','174','宁安市','',''),('1486','174','穆棱市','',''),('1487','174','东宁县','',''),('1488','174','林口县','',''),('1489','175','桃山区','',''),('1490','175','新兴区','',''),('1491','175','茄子河区','',''),('1492','175','勃利县','',''),('1493','176','龙沙区','',''),('1494','176','昂昂溪区','',''),('1495','176','铁峰区','',''),('1496','176','建华区','',''),('1497','176','富拉尔基区','',''),('1498','176','碾子山区','',''),('1499','176','梅里斯达斡尔区','',''),('1500','176','讷河市','',''),('1501','176','龙江县','',''),('1502','176','依安县','',''),('1503','176','泰来县','',''),('1504','176','甘南县','',''),('1505','176','富裕县','',''),('1506','176','克山县','',''),('1507','176','克东县','',''),('1508','176','拜泉县','',''),('1509','177','尖山区','',''),('1510','177','岭东区','',''),('1511','177','四方台区','',''),('1512','177','宝山区','',''),('1513','177','集贤县','',''),('1514','177','友谊县','',''),('1515','177','宝清县','',''),('1516','177','饶河县','',''),('1517','178','北林区','',''),('1518','178','安达市','',''),('1519','178','肇东市','',''),('1520','178','海伦市','',''),('1521','178','望奎县','',''),('1522','178','兰西县','',''),('1523','178','青冈县','',''),('1524','178','庆安县','',''),('1525','178','明水县','',''),('1526','178','绥棱县','',''),('1527','179','伊春区','',''),('1528','179','带岭区','',''),('1529','179','南岔区','',''),('1530','179','金山屯区','',''),('1531','179','西林区','',''),('1532','179','美溪区','',''),('1533','179','乌马河区','',''),('1534','179','翠峦区','',''),('1535','179','友好区','',''),('1536','179','上甘岭区','',''),('1537','179','五营区','',''),('1538','179','红星区','',''),('1539','179','新青区','',''),('1540','179','汤旺河区','',''),('1541','179','乌伊岭区','',''),('1542','179','铁力市','',''),('1543','179','嘉荫县','',''),('1544','180','江岸区','',''),('1545','180','武昌区','',''),('1546','180','江汉区','',''),('1547','180','硚口区','',''),('1548','180','汉阳区','',''),('1549','180','青山区','',''),('1550','180','洪山区','',''),('1551','180','东西湖区','',''),('1552','180','汉南区','',''),('1553','180','蔡甸区','',''),('1554','180','江夏区','',''),('1555','180','黄陂区','',''),('1556','180','新洲区','',''),('1557','180','经济开发区','',''),('1558','181','仙桃市','',''),('1559','182','鄂城区','',''),('1560','182','华容区','',''),('1561','182','梁子湖区','',''),('1562','183','黄州区','',''),('1563','183','麻城市','',''),('1564','183','武穴市','',''),('1565','183','团风县','',''),('1566','183','红安县','',''),('1567','183','罗田县','',''),('1568','183','英山县','',''),('1569','183','浠水县','',''),('1570','183','蕲春县','',''),('1571','183','黄梅县','',''),('1572','184','黄石港区','',''),('1573','184','西塞山区','',''),('1574','184','下陆区','',''),('1575','184','铁山区','',''),('1576','184','大冶市','',''),('1577','184','阳新县','',''),('1578','185','东宝区','',''),('1579','185','掇刀区','',''),('1580','185','钟祥市','',''),('1581','185','京山县','',''),('1582','185','沙洋县','',''),('1583','186','沙市区','',''),('1584','186','荆州区','',''),('1585','186','石首市','',''),('1586','186','洪湖市','',''),('1587','186','松滋市','',''),('1588','186','公安县','',''),('1589','186','监利县','',''),('1590','186','江陵县','',''),('1591','187','潜江市','',''),('1592','188','神农架林区','',''),('1593','189','张湾区','',''),('1594','189','茅箭区','',''),('1595','189','丹江口市','',''),('1596','189','郧县','',''),('1597','189','郧西县','',''),('1598','189','竹山县','',''),('1599','189','竹溪县','',''),('1600','189','房县','',''),('1601','190','曾都区','',''),('1602','190','广水市','',''),('1603','191','天门市','',''),('1604','192','咸安区','',''),('1605','192','赤壁市','',''),('1606','192','嘉鱼县','',''),('1607','192','通城县','',''),('1608','192','崇阳县','',''),('1609','192','通山县','',''),('1610','193','襄城区','',''),('1611','193','樊城区','',''),('1612','193','襄阳区','',''),('1613','193','老河口市','',''),('1614','193','枣阳市','',''),('1615','193','宜城市','',''),('1616','193','南漳县','',''),('1617','193','谷城县','',''),('1618','193','保康县','',''),('1619','194','孝南区','',''),('1620','194','应城市','',''),('1621','194','安陆市','',''),('1622','194','汉川市','',''),('1623','194','孝昌县','',''),('1624','194','大悟县','',''),('1625','194','云梦县','',''),('1626','195','长阳','',''),('1627','195','五峰','',''),('1628','195','西陵区','',''),('1629','195','伍家岗区','',''),('1630','195','点军区','',''),('1631','195','猇亭区','',''),('1632','195','夷陵区','',''),('1633','195','宜都市','',''),('1634','195','当阳市','',''),('1635','195','枝江市','',''),('1636','195','远安县','',''),('1637','195','兴山县','',''),('1638','195','秭归县','',''),('1639','196','恩施市','',''),('1640','196','利川市','',''),('1641','196','建始县','',''),('1642','196','巴东县','',''),('1643','196','宣恩县','',''),('1644','196','咸丰县','',''),('1645','196','来凤县','',''),('1646','196','鹤峰县','',''),('1647','197','岳麓区','',''),('1648','197','芙蓉区','',''),('1649','197','天心区','',''),('1650','197','开福区','',''),('1651','197','雨花区','',''),('1652','197','开发区','',''),('1653','197','浏阳市','',''),('1654','197','长沙县','',''),('1655','197','望城县','',''),('1656','197','宁乡县','',''),('1657','198','永定区','',''),('1658','198','武陵源区','',''),('1659','198','慈利县','',''),('1660','198','桑植县','',''),('1661','199','武陵区','',''),('1662','199','鼎城区','',''),('1663','199','津市市','',''),('1664','199','安乡县','',''),('1665','199','汉寿县','',''),('1666','199','澧县','',''),('1667','199','临澧县','',''),('1668','199','桃源县','',''),('1669','199','石门县','',''),('1670','200','北湖区','',''),('1671','200','苏仙区','',''),('1672','200','资兴市','',''),('1673','200','桂阳县','',''),('1674','200','宜章县','',''),('1675','200','永兴县','',''),('1676','200','嘉禾县','',''),('1677','200','临武县','',''),('1678','200','汝城县','',''),('1679','200','桂东县','',''),('1680','200','安仁县','',''),('1681','201','雁峰区','',''),('1682','201','珠晖区','',''),('1683','201','石鼓区','',''),('1684','201','蒸湘区','',''),('1685','201','南岳区','',''),('1686','201','耒阳市','',''),('1687','201','常宁市','',''),('1688','201','衡阳县','',''),('1689','201','衡南县','',''),('1690','201','衡山县','',''),('1691','201','衡东县','',''),('1692','201','祁东县','',''),('1693','202','鹤城区','',''),('1694','202','靖州','',''),('1695','202','麻阳','',''),('1696','202','通道','',''),('1697','202','新晃','',''),('1698','202','芷江','',''),('1699','202','沅陵县','',''),('1700','202','辰溪县','',''),('1701','202','溆浦县','',''),('1702','202','中方县','',''),('1703','202','会同县','',''),('1704','202','洪江市','',''),('1705','203','娄星区','',''),('1706','203','冷水江市','',''),('1707','203','涟源市','',''),('1708','203','双峰县','',''),('1709','203','新化县','',''),('1710','204','城步','',''),('1711','204','双清区','',''),('1712','204','大祥区','',''),('1713','204','北塔区','',''),('1714','204','武冈市','',''),('1715','204','邵东县','',''),('1716','204','新邵县','',''),('1717','204','邵阳县','',''),('1718','204','隆回县','',''),('1719','204','洞口县','',''),('1720','204','绥宁县','',''),('1721','204','新宁县','',''),('1722','205','岳塘区','',''),('1723','205','雨湖区','',''),('1724','205','湘乡市','',''),('1725','205','韶山市','',''),('1726','205','湘潭县','',''),('1727','206','吉首市','',''),('1728','206','泸溪县','',''),('1729','206','凤凰县','',''),('1730','206','花垣县','',''),('1731','206','保靖县','',''),('1732','206','古丈县','',''),('1733','206','永顺县','',''),('1734','206','龙山县','',''),('1735','207','赫山区','',''),('1736','207','资阳区','',''),('1737','207','沅江市','',''),('1738','207','南县','',''),('1739','207','桃江县','',''),('1740','207','安化县','',''),('1741','208','江华','',''),('1742','208','冷水滩区','',''),('1743','208','零陵区','',''),('1744','208','祁阳县','',''),('1745','208','东安县','',''),('1746','208','双牌县','',''),('1747','208','道县','',''),('1748','208','江永县','',''),('1749','208','宁远县','',''),('1750','208','蓝山县','',''),('1751','208','新田县','',''),('1752','209','岳阳楼区','',''),('1753','209','君山区','',''),('1754','209','云溪区','',''),('1755','209','汨罗市','',''),('1756','209','临湘市','',''),('1757','209','岳阳县','',''),('1758','209','华容县','',''),('1759','209','湘阴县','',''),('1760','209','平江县','',''),('1761','210','天元区','',''),('1762','210','荷塘区','',''),('1763','210','芦淞区','',''),('1764','210','石峰区','',''),('1765','210','醴陵市','',''),('1766','210','株洲县','',''),('1767','210','攸县','',''),('1768','210','茶陵县','',''),('1769','210','炎陵县','',''),('1770','211','朝阳区','',''),('1771','211','宽城区','',''),('1772','211','二道区','',''),('1773','211','南关区','',''),('1774','211','绿园区','',''),('1775','211','双阳区','',''),('1776','211','净月潭开发区','',''),('1777','211','高新技术开发区','',''),('1778','211','经济技术开发区','',''),('1779','211','汽车产业开发区','',''),('1780','211','德惠市','',''),('1781','211','九台市','',''),('1782','211','榆树市','',''),('1783','211','农安县','',''),('1784','212','船营区','',''),('1785','212','昌邑区','',''),('1786','212','龙潭区','',''),('1787','212','丰满区','',''),('1788','212','蛟河市','',''),('1789','212','桦甸市','',''),('1790','212','舒兰市','',''),('1791','212','磐石市','',''),('1792','212','永吉县','',''),('1793','213','洮北区','',''),('1794','213','洮南市','',''),('1795','213','大安市','',''),('1796','213','镇赉县','',''),('1797','213','通榆县','',''),('1798','214','江源区','',''),('1799','214','八道江区','',''),('1800','214','长白','',''),('1801','214','临江市','',''),('1802','214','抚松县','',''),('1803','214','靖宇县','',''),('1804','215','龙山区','',''),('1805','215','西安区','',''),('1806','215','东丰县','',''),('1807','215','东辽县','',''),('1808','216','铁西区','',''),('1809','216','铁东区','',''),('1810','216','伊通','',''),('1811','216','公主岭市','',''),('1812','216','双辽市','',''),('1813','216','梨树县','',''),('1814','217','前郭尔罗斯','',''),('1815','217','宁江区','',''),('1816','217','长岭县','',''),('1817','217','乾安县','',''),('1818','217','扶余县','',''),('1819','218','东昌区','',''),('1820','218','二道江区','',''),('1821','218','梅河口市','',''),('1822','218','集安市','',''),('1823','218','通化县','',''),('1824','218','辉南县','',''),('1825','218','柳河县','',''),('1826','219','延吉市','',''),('1827','219','图们市','',''),('1828','219','敦化市','',''),('1829','219','珲春市','',''),('1830','219','龙井市','',''),('1831','219','和龙市','',''),('1832','219','安图县','',''),('1833','219','汪清县','',''),('1834','220','玄武区','',''),('1835','220','鼓楼区','',''),('1836','220','白下区','',''),('1837','220','建邺区','',''),('1838','220','秦淮区','',''),('1839','220','雨花台区','',''),('1840','220','下关区','',''),('1841','220','栖霞区','',''),('1842','220','浦口区','',''),('1843','220','江宁区','',''),('1844','220','六合区','',''),('1845','220','溧水县','',''),('1846','220','高淳县','',''),('1847','221','沧浪区','',''),('1848','221','金阊区','',''),('1849','221','平江区','',''),('1850','221','虎丘区','',''),('1851','221','吴中区','',''),('1852','221','相城区','',''),('1853','221','园区','',''),('1854','221','新区','',''),('1855','221','常熟市','',''),('1856','221','张家港市','',''),('1857','221','玉山镇','',''),('1858','221','巴城镇','',''),('1859','221','周市镇','',''),('1860','221','陆家镇','',''),('1861','221','花桥镇','',''),('1862','221','淀山湖镇','',''),('1863','221','张浦镇','',''),('1864','221','周庄镇','',''),('1865','221','千灯镇','',''),('1866','221','锦溪镇','',''),('1867','221','开发区','',''),('1868','221','吴江市','',''),('1869','221','太仓市','',''),('1870','222','崇安区','',''),('1871','222','北塘区','',''),('1872','222','南长区','',''),('1873','222','锡山区','',''),('1874','222','惠山区','',''),('1875','222','滨湖区','',''),('1876','222','新区','',''),('1877','222','江阴市','',''),('1878','222','宜兴市','',''),('1879','223','天宁区','',''),('1880','223','钟楼区','',''),('1881','223','戚墅堰区','',''),('1882','223','郊区','',''),('1883','223','新北区','',''),('1884','223','武进区','',''),('1885','223','溧阳市','',''),('1886','223','金坛市','',''),('1887','224','清河区','',''),('1888','224','清浦区','',''),('1889','224','楚州区','',''),('1890','224','淮阴区','',''),('1891','224','涟水县','',''),('1892','224','洪泽县','',''),('1893','224','盱眙县','',''),('1894','224','金湖县','',''),('1895','225','新浦区','',''),('1896','225','连云区','',''),('1897','225','海州区','',''),('1898','225','赣榆县','',''),('1899','225','东海县','',''),('1900','225','灌云县','',''),('1901','225','灌南县','',''),('1902','226','崇川区','',''),('1903','226','港闸区','',''),('1904','226','经济开发区','',''),('1905','226','启东市','',''),('1906','226','如皋市','',''),('1907','226','通州市','',''),('1908','226','海门市','',''),('1909','226','海安县','',''),('1910','226','如东县','',''),('1911','227','宿城区','',''),('1912','227','宿豫区','',''),('1913','227','宿豫县','',''),('1914','227','沭阳县','',''),('1915','227','泗阳县','',''),('1916','227','泗洪县','',''),('1917','228','海陵区','',''),('1918','228','高港区','',''),('1919','228','兴化市','',''),('1920','228','靖江市','',''),('1921','228','泰兴市','',''),('1922','228','姜堰市','',''),('1923','229','云龙区','',''),('1924','229','鼓楼区','',''),('1925','229','九里区','',''),('1926','229','贾汪区','',''),('1927','229','泉山区','',''),('1928','229','新沂市','',''),('1929','229','邳州市','',''),('1930','229','丰县','',''),('1931','229','沛县','',''),('1932','229','铜山县','',''),('1933','229','睢宁县','',''),('1934','230','城区','',''),('1935','230','亭湖区','',''),('1936','230','盐都区','',''),('1937','230','盐都县','',''),('1938','230','东台市','',''),('1939','230','大丰市','',''),('1940','230','响水县','',''),('1941','230','滨海县','',''),('1942','230','阜宁县','',''),('1943','230','射阳县','',''),('1944','230','建湖县','',''),('1945','231','广陵区','',''),('1946','231','维扬区','',''),('1947','231','邗江区','',''),('1948','231','仪征市','',''),('1949','231','高邮市','',''),('1950','231','江都市','',''),('1951','231','宝应县','',''),('1952','232','京口区','',''),('1953','232','润州区','',''),('1954','232','丹徒区','',''),('1955','232','丹阳市','',''),('1956','232','扬中市','',''),('1957','232','句容市','',''),('1958','233','东湖区','',''),('1959','233','西湖区','',''),('1960','233','青云谱区','',''),('1961','233','湾里区','',''),('1962','233','青山湖区','',''),('1963','233','红谷滩新区','',''),('1964','233','昌北区','',''),('1965','233','高新区','',''),('1966','233','南昌县','',''),('1967','233','新建县','',''),('1968','233','安义县','',''),('1969','233','进贤县','',''),('1970','234','临川区','',''),('1971','234','南城县','',''),('1972','234','黎川县','',''),('1973','234','南丰县','',''),('1974','234','崇仁县','',''),('1975','234','乐安县','',''),('1976','234','宜黄县','',''),('1977','234','金溪县','',''),('1978','234','资溪县','',''),('1979','234','东乡县','',''),('1980','234','广昌县','',''),('1981','235','章贡区','',''),('1982','235','于都县','',''),('1983','235','瑞金市','',''),('1984','235','南康市','',''),('1985','235','赣县','',''),('1986','235','信丰县','',''),('1987','235','大余县','',''),('1988','235','上犹县','',''),('1989','235','崇义县','',''),('1990','235','安远县','',''),('1991','235','龙南县','',''),('1992','235','定南县','',''),('1993','235','全南县','',''),('1994','235','宁都县','',''),('1995','235','兴国县','',''),('1996','235','会昌县','',''),('1997','235','寻乌县','',''),('1998','235','石城县','',''),('1999','236','安福县','',''),('2000','236','吉州区','',''),('2001','236','青原区','',''),('2002','236','井冈山市','',''),('2003','236','吉安县','',''),('2004','236','吉水县','',''),('2005','236','峡江县','',''),('2006','236','新干县','',''),('2007','236','永丰县','',''),('2008','236','泰和县','',''),('2009','236','遂川县','',''),('2010','236','万安县','',''),('2011','236','永新县','',''),('2012','237','珠山区','',''),('2013','237','昌江区','',''),('2014','237','乐平市','',''),('2015','237','浮梁县','',''),('2016','238','浔阳区','',''),('2017','238','庐山区','',''),('2018','238','瑞昌市','',''),('2019','238','九江县','',''),('2020','238','武宁县','',''),('2021','238','修水县','',''),('2022','238','永修县','',''),('2023','238','德安县','',''),('2024','238','星子县','',''),('2025','238','都昌县','',''),('2026','238','湖口县','',''),('2027','238','彭泽县','',''),('2028','239','安源区','',''),('2029','239','湘东区','',''),('2030','239','莲花县','',''),('2031','239','芦溪县','',''),('2032','239','上栗县','',''),('2033','240','信州区','',''),('2034','240','德兴市','',''),('2035','240','上饶县','',''),('2036','240','广丰县','',''),('2037','240','玉山县','',''),('2038','240','铅山县','',''),('2039','240','横峰县','',''),('2040','240','弋阳县','',''),('2041','240','余干县','',''),('2042','240','波阳县','',''),('2043','240','万年县','',''),('2044','240','婺源县','',''),('2045','241','渝水区','',''),('2046','241','分宜县','',''),('2047','242','袁州区','',''),('2048','242','丰城市','',''),('2049','242','樟树市','',''),('2050','242','高安市','',''),('2051','242','奉新县','',''),('2052','242','万载县','',''),('2053','242','上高县','',''),('2054','242','宜丰县','',''),('2055','242','靖安县','',''),('2056','242','铜鼓县','',''),('2057','243','月湖区','',''),('2058','243','贵溪市','',''),('2059','243','余江县','',''),('2060','244','沈河区','',''),('2061','244','皇姑区','',''),('2062','244','和平区','',''),('2063','244','大东区','',''),('2064','244','铁西区','',''),('2065','244','苏家屯区','',''),('2066','244','东陵区','',''),('2067','244','沈北新区','',''),('2068','244','于洪区','',''),('2069','244','浑南新区','',''),('2070','244','新民市','',''),('2071','244','辽中县','',''),('2072','244','康平县','',''),('2073','244','法库县','',''),('2074','245','西岗区','',''),('2075','245','中山区','',''),('2076','245','沙河口区','',''),('2077','245','甘井子区','',''),('2078','245','旅顺口区','',''),('2079','245','金州区','',''),('2080','245','开发区','',''),('2081','245','瓦房店市','',''),('2082','245','普兰店市','',''),('2083','245','庄河市','',''),('2084','245','长海县','',''),('2085','246','铁东区','',''),('2086','246','铁西区','',''),('2087','246','立山区','',''),('2088','246','千山区','',''),('2089','246','岫岩','',''),('2090','246','海城市','',''),('2091','246','台安县','',''),('2092','247','本溪','',''),('2093','247','平山区','',''),('2094','247','明山区','',''),('2095','247','溪湖区','',''),('2096','247','南芬区','',''),('2097','247','桓仁','',''),('2098','248','双塔区','',''),('2099','248','龙城区','',''),('2100','248','喀喇沁左翼蒙古族自治县','',''),('2101','248','北票市','',''),('2102','248','凌源市','',''),('2103','248','朝阳县','',''),('2104','248','建平县','',''),('2105','249','振兴区','',''),('2106','249','元宝区','',''),('2107','249','振安区','',''),('2108','249','宽甸','',''),('2109','249','东港市','',''),('2110','249','凤城市','',''),('2111','250','顺城区','',''),('2112','250','新抚区','',''),('2113','250','东洲区','',''),('2114','250','望花区','',''),('2115','250','清原','',''),('2116','250','新宾','',''),('2117','250','抚顺县','',''),('2118','251','阜新','',''),('2119','251','海州区','',''),('2120','251','新邱区','',''),('2121','251','太平区','',''),('2122','251','清河门区','',''),('2123','251','细河区','',''),('2124','251','彰武县','',''),('2125','252','龙港区','',''),('2126','252','南票区','',''),('2127','252','连山区','',''),('2128','252','兴城市','',''),('2129','252','绥中县','',''),('2130','252','建昌县','',''),('2131','253','太和区','',''),('2132','253','古塔区','',''),('2133','253','凌河区','',''),('2134','253','凌海市','',''),('2135','253','北镇市','',''),('2136','253','黑山县','',''),('2137','253','义县','',''),('2138','254','白塔区','',''),('2139','254','文圣区','',''),('2140','254','宏伟区','',''),('2141','254','太子河区','',''),('2142','254','弓长岭区','',''),('2143','254','灯塔市','',''),('2144','254','辽阳县','',''),('2145','255','双台子区','',''),('2146','255','兴隆台区','',''),('2147','255','大洼县','',''),('2148','255','盘山县','',''),('2149','256','银州区','',''),('2150','256','清河区','',''),('2151','256','调兵山市','',''),('2152','256','开原市','',''),('2153','256','铁岭县','',''),('2154','256','西丰县','',''),('2155','256','昌图县','',''),('2156','257','站前区','',''),('2157','257','西市区','',''),('2158','257','鲅鱼圈区','',''),('2159','257','老边区','',''),('2160','257','盖州市','',''),('2161','257','大石桥市','',''),('2162','258','回民区','',''),('2163','258','玉泉区','',''),('2164','258','新城区','',''),('2165','258','赛罕区','',''),('2166','258','清水河县','',''),('2167','258','土默特左旗','',''),('2168','258','托克托县','',''),('2169','258','和林格尔县','',''),('2170','258','武川县','',''),('2171','259','阿拉善左旗','',''),('2172','259','阿拉善右旗','',''),('2173','259','额济纳旗','',''),('2174','260','临河区','',''),('2175','260','五原县','',''),('2176','260','磴口县','',''),('2177','260','乌拉特前旗','',''),('2178','260','乌拉特中旗','',''),('2179','260','乌拉特后旗','',''),('2180','260','杭锦后旗','',''),('2181','261','昆都仑区','',''),('2182','261','青山区','',''),('2183','261','东河区','',''),('2184','261','九原区','',''),('2185','261','石拐区','',''),('2186','261','白云矿区','',''),('2187','261','土默特右旗','',''),('2188','261','固阳县','',''),('2189','261','达尔罕茂明安联合旗','',''),('2190','262','红山区','',''),('2191','262','元宝山区','',''),('2192','262','松山区','',''),('2193','262','阿鲁科尔沁旗','',''),('2194','262','巴林左旗','',''),('2195','262','巴林右旗','',''),('2196','262','林西县','',''),('2197','262','克什克腾旗','',''),('2198','262','翁牛特旗','',''),('2199','262','喀喇沁旗','',''),('2200','262','宁城县','',''),('2201','262','敖汉旗','',''),('2202','263','东胜区','',''),('2203','263','达拉特旗','',''),('2204','263','准格尔旗','',''),('2205','263','鄂托克前旗','',''),('2206','263','鄂托克旗','',''),('2207','263','杭锦旗','',''),('2208','263','乌审旗','',''),('2209','263','伊金霍洛旗','',''),('2210','264','海拉尔区','',''),('2211','264','莫力达瓦','',''),('2212','264','满洲里市','',''),('2213','264','牙克石市','',''),('2214','264','扎兰屯市','',''),('2215','264','额尔古纳市','',''),('2216','264','根河市','',''),('2217','264','阿荣旗','',''),('2218','264','鄂伦春自治旗','',''),('2219','264','鄂温克族自治旗','',''),('2220','264','陈巴尔虎旗','',''),('2221','264','新巴尔虎左旗','',''),('2222','264','新巴尔虎右旗','',''),('2223','265','科尔沁区','',''),('2224','265','霍林郭勒市','',''),('2225','265','科尔沁左翼中旗','',''),('2226','265','科尔沁左翼后旗','',''),('2227','265','开鲁县','',''),('2228','265','库伦旗','',''),('2229','265','奈曼旗','',''),('2230','265','扎鲁特旗','',''),('2231','266','海勃湾区','',''),('2232','266','乌达区','',''),('2233','266','海南区','',''),('2234','267','化德县','',''),('2235','267','集宁区','',''),('2236','267','丰镇市','',''),('2237','267','卓资县','',''),('2238','267','商都县','',''),('2239','267','兴和县','',''),('2240','267','凉城县','',''),('2241','267','察哈尔右翼前旗','',''),('2242','267','察哈尔右翼中旗','',''),('2243','267','察哈尔右翼后旗','',''),('2244','267','四子王旗','',''),('2245','268','二连浩特市','',''),('2246','268','锡林浩特市','',''),('2247','268','阿巴嘎旗','',''),('2248','268','苏尼特左旗','',''),('2249','268','苏尼特右旗','',''),('2250','268','东乌珠穆沁旗','',''),('2251','268','西乌珠穆沁旗','',''),('2252','268','太仆寺旗','',''),('2253','268','镶黄旗','',''),('2254','268','正镶白旗','',''),('2255','268','正蓝旗','',''),('2256','268','多伦县','',''),('2257','269','乌兰浩特市','',''),('2258','269','阿尔山市','',''),('2259','269','科尔沁右翼前旗','',''),('2260','269','科尔沁右翼中旗','',''),('2261','269','扎赉特旗','',''),('2262','269','突泉县','',''),('2263','270','西夏区','',''),('2264','270','金凤区','',''),('2265','270','兴庆区','',''),('2266','270','灵武市','',''),('2267','270','永宁县','',''),('2268','270','贺兰县','',''),('2269','271','原州区','',''),('2270','271','海原县','',''),('2271','271','西吉县','',''),('2272','271','隆德县','',''),('2273','271','泾源县','',''),('2274','271','彭阳县','',''),('2275','272','惠农县','',''),('2276','272','大武口区','',''),('2277','272','惠农区','',''),('2278','272','陶乐县','',''),('2279','272','平罗县','',''),('2280','273','利通区','',''),('2281','273','中卫县','',''),('2282','273','青铜峡市','',''),('2283','273','中宁县','',''),('2284','273','盐池县','',''),('2285','273','同心县','',''),('2286','274','沙坡头区','',''),('2287','274','海原县','',''),('2288','274','中宁县','',''),('2289','275','城中区','',''),('2290','275','城东区','',''),('2291','275','城西区','',''),('2292','275','城北区','',''),('2293','275','湟中县','',''),('2294','275','湟源县','',''),('2295','275','大通','',''),('2296','276','玛沁县','',''),('2297','276','班玛县','',''),('2298','276','甘德县','',''),('2299','276','达日县','',''),('2300','276','久治县','',''),('2301','276','玛多县','',''),('2302','277','海晏县','',''),('2303','277','祁连县','',''),('2304','277','刚察县','',''),('2305','277','门源','',''),('2306','278','平安县','',''),('2307','278','乐都县','',''),('2308','278','民和','',''),('2309','278','互助','',''),('2310','278','化隆','',''),('2311','278','循化','',''),('2312','279','共和县','',''),('2313','279','同德县','',''),('2314','279','贵德县','',''),('2315','279','兴海县','',''),('2316','279','贵南县','',''),('2317','280','德令哈市','',''),('2318','280','格尔木市','',''),('2319','280','乌兰县','',''),('2320','280','都兰县','',''),('2321','280','天峻县','',''),('2322','281','同仁县','',''),('2323','281','尖扎县','',''),('2324','281','泽库县','',''),('2325','281','河南蒙古族自治县','',''),('2326','282','玉树县','',''),('2327','282','杂多县','',''),('2328','282','称多县','',''),('2329','282','治多县','',''),('2330','282','囊谦县','',''),('2331','282','曲麻莱县','',''),('2332','283','市中区','',''),('2333','283','历下区','',''),('2334','283','天桥区','',''),('2335','283','槐荫区','',''),('2336','283','历城区','',''),('2337','283','长清区','',''),('2338','283','章丘市','',''),('2339','283','平阴县','',''),('2340','283','济阳县','',''),('2341','283','商河县','',''),('2342','284','市南区','',''),('2343','284','市北区','',''),('2344','284','城阳区','',''),('2345','284','四方区','',''),('2346','284','李沧区','',''),('2347','284','黄岛区','',''),('2348','284','崂山区','',''),('2349','284','胶州市','',''),('2350','284','即墨市','',''),('2351','284','平度市','',''),('2352','284','胶南市','',''),('2353','284','莱西市','',''),('2354','285','滨城区','',''),('2355','285','惠民县','',''),('2356','285','阳信县','',''),('2357','285','无棣县','',''),('2358','285','沾化县','',''),('2359','285','博兴县','',''),('2360','285','邹平县','',''),('2361','286','德城区','',''),('2362','286','陵县','',''),('2363','286','乐陵市','',''),('2364','286','禹城市','',''),('2365','286','宁津县','',''),('2366','286','庆云县','',''),('2367','286','临邑县','',''),('2368','286','齐河县','',''),('2369','286','平原县','',''),('2370','286','夏津县','',''),('2371','286','武城县','',''),('2372','287','东营区','',''),('2373','287','河口区','',''),('2374','287','垦利县','',''),('2375','287','利津县','',''),('2376','287','广饶县','',''),('2377','288','牡丹区','',''),('2378','288','曹县','',''),('2379','288','单县','',''),('2380','288','成武县','',''),('2381','288','巨野县','',''),('2382','288','郓城县','',''),('2383','288','鄄城县','',''),('2384','288','定陶县','',''),('2385','288','东明县','',''),('2386','289','市中区','',''),('2387','289','任城区','',''),('2388','289','曲阜市','',''),('2389','289','兖州市','',''),('2390','289','邹城市','',''),('2391','289','微山县','',''),('2392','289','鱼台县','',''),('2393','289','金乡县','',''),('2394','289','嘉祥县','',''),('2395','289','汶上县','',''),('2396','289','泗水县','',''),('2397','289','梁山县','',''),('2398','290','莱城区','',''),('2399','290','钢城区','',''),('2400','291','东昌府区','',''),('2401','291','临清市','',''),('2402','291','阳谷县','',''),('2403','291','莘县','',''),('2404','291','茌平县','',''),('2405','291','东阿县','',''),('2406','291','冠县','',''),('2407','291','高唐县','',''),('2408','292','兰山区','',''),('2409','292','罗庄区','',''),('2410','292','河东区','',''),('2411','292','沂南县','',''),('2412','292','郯城县','',''),('2413','292','沂水县','',''),('2414','292','苍山县','',''),('2415','292','费县','',''),('2416','292','平邑县','',''),('2417','292','莒南县','',''),('2418','292','蒙阴县','',''),('2419','292','临沭县','',''),('2420','293','东港区','',''),('2421','293','岚山区','',''),('2422','293','五莲县','',''),('2423','293','莒县','',''),('2424','294','泰山区','',''),('2425','294','岱岳区','',''),('2426','294','新泰市','',''),('2427','294','肥城市','',''),('2428','294','宁阳县','',''),('2429','294','东平县','',''),('2430','295','荣成市','',''),('2431','295','乳山市','',''),('2432','295','环翠区','',''),('2433','295','文登市','',''),('2434','296','潍城区','',''),('2435','296','寒亭区','',''),('2436','296','坊子区','',''),('2437','296','奎文区','',''),('2438','296','青州市','',''),('2439','296','诸城市','',''),('2440','296','寿光市','',''),('2441','296','安丘市','',''),('2442','296','高密市','',''),('2443','296','昌邑市','',''),('2444','296','临朐县','',''),('2445','296','昌乐县','',''),('2446','297','芝罘区','',''),('2447','297','福山区','',''),('2448','297','牟平区','',''),('2449','297','莱山区','',''),('2450','297','开发区','',''),('2451','297','龙口市','',''),('2452','297','莱阳市','',''),('2453','297','莱州市','',''),('2454','297','蓬莱市','',''),('2455','297','招远市','',''),('2456','297','栖霞市','',''),('2457','297','海阳市','',''),('2458','297','长岛县','',''),('2459','298','市中区','',''),('2460','298','山亭区','',''),('2461','298','峄城区','',''),('2462','298','台儿庄区','',''),('2463','298','薛城区','',''),('2464','298','滕州市','',''),('2465','299','张店区','',''),('2466','299','临淄区','',''),('2467','299','淄川区','',''),('2468','299','博山区','',''),('2469','299','周村区','',''),('2470','299','桓台县','',''),('2471','299','高青县','',''),('2472','299','沂源县','',''),('2473','300','杏花岭区','',''),('2474','300','小店区','',''),('2475','300','迎泽区','',''),('2476','300','尖草坪区','',''),('2477','300','万柏林区','',''),('2478','300','晋源区','',''),('2479','300','高新开发区','',''),('2480','300','民营经济开发区','',''),('2481','300','经济技术开发区','',''),('2482','300','清徐县','',''),('2483','300','阳曲县','',''),('2484','300','娄烦县','',''),('2485','300','古交市','',''),('2486','301','城区','',''),('2487','301','郊区','',''),('2488','301','沁县','',''),('2489','301','潞城市','',''),('2490','301','长治县','',''),('2491','301','襄垣县','',''),('2492','301','屯留县','',''),('2493','301','平顺县','',''),('2494','301','黎城县','',''),('2495','301','壶关县','',''),('2496','301','长子县','',''),('2497','301','武乡县','',''),('2498','301','沁源县','',''),('2499','302','城区','',''),('2500','302','矿区','',''),('2501','302','南郊区','',''),('2502','302','新荣区','',''),('2503','302','阳高县','',''),('2504','302','天镇县','',''),('2505','302','广灵县','',''),('2506','302','灵丘县','',''),('2507','302','浑源县','',''),('2508','302','左云县','',''),('2509','302','大同县','',''),('2510','303','城区','',''),('2511','303','高平市','',''),('2512','303','沁水县','',''),('2513','303','阳城县','',''),('2514','303','陵川县','',''),('2515','303','泽州县','',''),('2516','304','榆次区','',''),('2517','304','介休市','',''),('2518','304','榆社县','',''),('2519','304','左权县','',''),('2520','304','和顺县','',''),('2521','304','昔阳县','',''),('2522','304','寿阳县','',''),('2523','304','太谷县','',''),('2524','304','祁县','',''),('2525','304','平遥县','',''),('2526','304','灵石县','',''),('2527','305','尧都区','',''),('2528','305','侯马市','',''),('2529','305','霍州市','',''),('2530','305','曲沃县','',''),('2531','305','翼城县','',''),('2532','305','襄汾县','',''),('2533','305','洪洞县','',''),('2534','305','吉县','',''),('2535','305','安泽县','',''),('2536','305','浮山县','',''),('2537','305','古县','',''),('2538','305','乡宁县','',''),('2539','305','大宁县','',''),('2540','305','隰县','',''),('2541','305','永和县','',''),('2542','305','蒲县','',''),('2543','305','汾西县','',''),('2544','306','离石市','',''),('2545','306','离石区','',''),('2546','306','孝义市','',''),('2547','306','汾阳市','',''),('2548','306','文水县','',''),('2549','306','交城县','',''),('2550','306','兴县','',''),('2551','306','临县','',''),('2552','306','柳林县','',''),('2553','306','石楼县','',''),('2554','306','岚县','',''),('2555','306','方山县','',''),('2556','306','中阳县','',''),('2557','306','交口县','',''),('2558','307','朔城区','',''),('2559','307','平鲁区','',''),('2560','307','山阴县','',''),('2561','307','应县','',''),('2562','307','右玉县','',''),('2563','307','怀仁县','',''),('2564','308','忻府区','',''),('2565','308','原平市','',''),('2566','308','定襄县','',''),('2567','308','五台县','',''),('2568','308','代县','',''),('2569','308','繁峙县','',''),('2570','308','宁武县','',''),('2571','308','静乐县','',''),('2572','308','神池县','',''),('2573','308','五寨县','',''),('2574','308','岢岚县','',''),('2575','308','河曲县','',''),('2576','308','保德县','',''),('2577','308','偏关县','',''),('2578','309','城区','',''),('2579','309','矿区','',''),('2580','309','郊区','',''),('2581','309','平定县','',''),('2582','309','盂县','',''),('2583','310','盐湖区','',''),('2584','310','永济市','',''),('2585','310','河津市','',''),('2586','310','临猗县','',''),('2587','310','万荣县','',''),('2588','310','闻喜县','',''),('2589','310','稷山县','',''),('2590','310','新绛县','',''),('2591','310','绛县','',''),('2592','310','垣曲县','',''),('2593','310','夏县','',''),('2594','310','平陆县','',''),('2595','310','芮城县','',''),('2596','311','莲湖区','',''),('2597','311','新城区','',''),('2598','311','碑林区','',''),('2599','311','雁塔区','',''),('2600','311','灞桥区','',''),('2601','311','未央区','',''),('2602','311','阎良区','',''),('2603','311','临潼区','',''),('2604','311','长安区','',''),('2605','311','蓝田县','',''),('2606','311','周至县','',''),('2607','311','户县','',''),('2608','311','高陵县','',''),('2609','312','汉滨区','',''),('2610','312','汉阴县','',''),('2611','312','石泉县','',''),('2612','312','宁陕县','',''),('2613','312','紫阳县','',''),('2614','312','岚皋县','',''),('2615','312','平利县','',''),('2616','312','镇坪县','',''),('2617','312','旬阳县','',''),('2618','312','白河县','',''),('2619','313','陈仓区','',''),('2620','313','渭滨区','',''),('2621','313','金台区','',''),('2622','313','凤翔县','',''),('2623','313','岐山县','',''),('2624','313','扶风县','',''),('2625','313','眉县','',''),('2626','313','陇县','',''),('2627','313','千阳县','',''),('2628','313','麟游县','',''),('2629','313','凤县','',''),('2630','313','太白县','',''),('2631','314','汉台区','',''),('2632','314','南郑县','',''),('2633','314','城固县','',''),('2634','314','洋县','',''),('2635','314','西乡县','',''),('2636','314','勉县','',''),('2637','314','宁强县','',''),('2638','314','略阳县','',''),('2639','314','镇巴县','',''),('2640','314','留坝县','',''),('2641','314','佛坪县','',''),('2642','315','商州区','',''),('2643','315','洛南县','',''),('2644','315','丹凤县','',''),('2645','315','商南县','',''),('2646','315','山阳县','',''),('2647','315','镇安县','',''),('2648','315','柞水县','',''),('2649','316','耀州区','',''),('2650','316','王益区','',''),('2651','316','印台区','',''),('2652','316','宜君县','',''),('2653','317','临渭区','',''),('2654','317','韩城市','',''),('2655','317','华阴市','',''),('2656','317','华县','',''),('2657','317','潼关县','',''),('2658','317','大荔县','',''),('2659','317','合阳县','',''),('2660','317','澄城县','',''),('2661','317','蒲城县','',''),('2662','317','白水县','',''),('2663','317','富平县','',''),('2664','318','秦都区','',''),('2665','318','渭城区','',''),('2666','318','杨陵区','',''),('2667','318','兴平市','',''),('2668','318','三原县','',''),('2669','318','泾阳县','',''),('2670','318','乾县','',''),('2671','318','礼泉县','',''),('2672','318','永寿县','',''),('2673','318','彬县','',''),('2674','318','长武县','',''),('2675','318','旬邑县','',''),('2676','318','淳化县','',''),('2677','318','武功县','',''),('2678','319','吴起县','',''),('2679','319','宝塔区','',''),('2680','319','延长县','',''),('2681','319','延川县','',''),('2682','319','子长县','',''),('2683','319','安塞县','',''),('2684','319','志丹县','',''),('2685','319','甘泉县','',''),('2686','319','富县','',''),('2687','319','洛川县','',''),('2688','319','宜川县','',''),('2689','319','黄龙县','',''),('2690','319','黄陵县','',''),('2691','320','榆阳区','',''),('2692','320','神木县','',''),('2693','320','府谷县','',''),('2694','320','横山县','',''),('2695','320','靖边县','',''),('2696','320','定边县','',''),('2697','320','绥德县','',''),('2698','320','米脂县','',''),('2699','320','佳县','',''),('2700','320','吴堡县','',''),('2701','320','清涧县','',''),('2702','320','子洲县','',''),('2703','321','长宁区','',''),('2704','321','闸北区','',''),('2705','321','闵行区','',''),('2706','321','徐汇区','',''),('2707','321','浦东新区','',''),('2708','321','杨浦区','',''),('2709','321','普陀区','',''),('2710','321','静安区','',''),('2711','321','卢湾区','',''),('2712','321','虹口区','',''),('2713','321','黄浦区','',''),('2714','321','南汇区','',''),('2715','321','松江区','',''),('2716','321','嘉定区','',''),('2717','321','宝山区','',''),('2718','321','青浦区','',''),('2719','321','金山区','',''),('2720','321','奉贤区','',''),('2721','321','崇明县','',''),('2722','322','青羊区','',''),('2723','322','锦江区','',''),('2724','322','金牛区','',''),('2725','322','武侯区','',''),('2726','322','成华区','',''),('2727','322','龙泉驿区','',''),('2728','322','青白江区','',''),('2729','322','新都区','',''),('2730','322','温江区','',''),('2731','322','高新区','',''),('2732','322','高新西区','',''),('2733','322','都江堰市','',''),('2734','322','彭州市','',''),('2735','322','邛崃市','',''),('2736','322','崇州市','',''),('2737','322','金堂县','',''),('2738','322','双流县','',''),('2739','322','郫县','',''),('2740','322','大邑县','',''),('2741','322','蒲江县','',''),('2742','322','新津县','',''),('2743','322','都江堰市','',''),('2744','322','彭州市','',''),('2745','322','邛崃市','',''),('2746','322','崇州市','',''),('2747','322','金堂县','',''),('2748','322','双流县','',''),('2749','322','郫县','',''),('2750','322','大邑县','',''),('2751','322','蒲江县','',''),('2752','322','新津县','',''),('2753','323','涪城区','',''),('2754','323','游仙区','',''),('2755','323','江油市','',''),('2756','323','盐亭县','',''),('2757','323','三台县','',''),('2758','323','平武县','',''),('2759','323','安县','',''),('2760','323','梓潼县','',''),('2761','323','北川县','',''),('2762','324','马尔康县','',''),('2763','324','汶川县','',''),('2764','324','理县','',''),('2765','324','茂县','',''),('2766','324','松潘县','',''),('2767','324','九寨沟县','',''),('2768','324','金川县','',''),('2769','324','小金县','',''),('2770','324','黑水县','',''),('2771','324','壤塘县','',''),('2772','324','阿坝县','',''),('2773','324','若尔盖县','',''),('2774','324','红原县','',''),('2775','325','巴州区','',''),('2776','325','通江县','',''),('2777','325','南江县','',''),('2778','325','平昌县','',''),('2779','326','通川区','',''),('2780','326','万源市','',''),('2781','326','达县','',''),('2782','326','宣汉县','',''),('2783','326','开江县','',''),('2784','326','大竹县','',''),('2785','326','渠县','',''),('2786','327','旌阳区','',''),('2787','327','广汉市','',''),('2788','327','什邡市','',''),('2789','327','绵竹市','',''),('2790','327','罗江县','',''),('2791','327','中江县','',''),('2792','328','康定县','',''),('2793','328','丹巴县','',''),('2794','328','泸定县','',''),('2795','328','炉霍县','',''),('2796','328','九龙县','',''),('2797','328','甘孜县','',''),('2798','328','雅江县','',''),('2799','328','新龙县','',''),('2800','328','道孚县','',''),('2801','328','白玉县','',''),('2802','328','理塘县','',''),('2803','328','德格县','',''),('2804','328','乡城县','',''),('2805','328','石渠县','',''),('2806','328','稻城县','',''),('2807','328','色达县','',''),('2808','328','巴塘县','',''),('2809','328','得荣县','',''),('2810','329','广安区','',''),('2811','329','华蓥市','',''),('2812','329','岳池县','',''),('2813','329','武胜县','',''),('2814','329','邻水县','',''),('2815','330','利州区','',''),('2816','330','元坝区','',''),('2817','330','朝天区','',''),('2818','330','旺苍县','',''),('2819','330','青川县','',''),('2820','330','剑阁县','',''),('2821','330','苍溪县','',''),('2822','331','峨眉山市','',''),('2823','331','乐山市','',''),('2824','331','犍为县','',''),('2825','331','井研县','',''),('2826','331','夹江县','',''),('2827','331','沐川县','',''),('2828','331','峨边','',''),('2829','331','马边','',''),('2830','332','西昌市','',''),('2831','332','盐源县','',''),('2832','332','德昌县','',''),('2833','332','会理县','',''),('2834','332','会东县','',''),('2835','332','宁南县','',''),('2836','332','普格县','',''),('2837','332','布拖县','',''),('2838','332','金阳县','',''),('2839','332','昭觉县','',''),('2840','332','喜德县','',''),('2841','332','冕宁县','',''),('2842','332','越西县','',''),('2843','332','甘洛县','',''),('2844','332','美姑县','',''),('2845','332','雷波县','',''),('2846','332','木里','',''),('2847','333','东坡区','',''),('2848','333','仁寿县','',''),('2849','333','彭山县','',''),('2850','333','洪雅县','',''),('2851','333','丹棱县','',''),('2852','333','青神县','',''),('2853','334','阆中市','',''),('2854','334','南部县','',''),('2855','334','营山县','',''),('2856','334','蓬安县','',''),('2857','334','仪陇县','',''),('2858','334','顺庆区','',''),('2859','334','高坪区','',''),('2860','334','嘉陵区','',''),('2861','334','西充县','',''),('2862','335','市中区','',''),('2863','335','东兴区','',''),('2864','335','威远县','',''),('2865','335','资中县','',''),('2866','335','隆昌县','',''),('2867','336','东  区','',''),('2868','336','西  区','',''),('2869','336','仁和区','',''),('2870','336','米易县','',''),('2871','336','盐边县','',''),('2872','337','船山区','',''),('2873','337','安居区','',''),('2874','337','蓬溪县','',''),('2875','337','射洪县','',''),('2876','337','大英县','',''),('2877','338','雨城区','',''),('2878','338','名山县','',''),('2879','338','荥经县','',''),('2880','338','汉源县','',''),('2881','338','石棉县','',''),('2882','338','天全县','',''),('2883','338','芦山县','',''),('2884','338','宝兴县','',''),('2885','339','翠屏区','',''),('2886','339','宜宾县','',''),('2887','339','南溪县','',''),('2888','339','江安县','',''),('2889','339','长宁县','',''),('2890','339','高县','',''),('2891','339','珙县','',''),('2892','339','筠连县','',''),('2893','339','兴文县','',''),('2894','339','屏山县','',''),('2895','340','雁江区','',''),('2896','340','简阳市','',''),('2897','340','安岳县','',''),('2898','340','乐至县','',''),('2899','341','大安区','',''),('2900','341','自流井区','',''),('2901','341','贡井区','',''),('2902','341','沿滩区','',''),('2903','341','荣县','',''),('2904','341','富顺县','',''),('2905','342','江阳区','',''),('2906','342','纳溪区','',''),('2907','342','龙马潭区','',''),('2908','342','泸县','',''),('2909','342','合江县','',''),('2910','342','叙永县','',''),('2911','342','古蔺县','',''),('2912','343','和平区','',''),('2913','343','河西区','',''),('2914','343','南开区','',''),('2915','343','河北区','',''),('2916','343','河东区','',''),('2917','343','红桥区','',''),('2918','343','东丽区','',''),('2919','343','津南区','',''),('2920','343','西青区','',''),('2921','343','北辰区','',''),('2922','343','塘沽区','',''),('2923','343','汉沽区','',''),('2924','343','大港区','',''),('2925','343','武清区','',''),('2926','343','宝坻区','',''),('2927','343','经济开发区','',''),('2928','343','宁河县','',''),('2929','343','静海县','',''),('2930','343','蓟县','',''),('2931','344','城关区','',''),('2932','344','林周县','',''),('2933','344','当雄县','',''),('2934','344','尼木县','',''),('2935','344','曲水县','',''),('2936','344','堆龙德庆县','',''),('2937','344','达孜县','',''),('2938','344','墨竹工卡县','',''),('2939','345','噶尔县','',''),('2940','345','普兰县','',''),('2941','345','札达县','',''),('2942','345','日土县','',''),('2943','345','革吉县','',''),('2944','345','改则县','',''),('2945','345','措勤县','',''),('2946','346','昌都县','',''),('2947','346','江达县','',''),('2948','346','贡觉县','',''),('2949','346','类乌齐县','',''),('2950','346','丁青县','',''),('2951','346','察雅县','',''),('2952','346','八宿县','',''),('2953','346','左贡县','',''),('2954','346','芒康县','',''),('2955','346','洛隆县','',''),('2956','346','边坝县','',''),('2957','347','林芝县','',''),('2958','347','工布江达县','',''),('2959','347','米林县','',''),('2960','347','墨脱县','',''),('2961','347','波密县','',''),('2962','347','察隅县','',''),('2963','347','朗县','',''),('2964','348','那曲县','',''),('2965','348','嘉黎县','',''),('2966','348','比如县','',''),('2967','348','聂荣县','',''),('2968','348','安多县','',''),('2969','348','申扎县','',''),('2970','348','索县','',''),('2971','348','班戈县','',''),('2972','348','巴青县','',''),('2973','348','尼玛县','',''),('2974','349','日喀则市','',''),('2975','349','南木林县','',''),('2976','349','江孜县','',''),('2977','349','定日县','',''),('2978','349','萨迦县','',''),('2979','349','拉孜县','',''),('2980','349','昂仁县','',''),('2981','349','谢通门县','',''),('2982','349','白朗县','',''),('2983','349','仁布县','',''),('2984','349','康马县','',''),('2985','349','定结县','',''),('2986','349','仲巴县','',''),('2987','349','亚东县','',''),('2988','349','吉隆县','',''),('2989','349','聂拉木县','',''),('2990','349','萨嘎县','',''),('2991','349','岗巴县','',''),('2992','350','乃东县','',''),('2993','350','扎囊县','',''),('2994','350','贡嘎县','',''),('2995','350','桑日县','',''),('2996','350','琼结县','',''),('2997','350','曲松县','',''),('2998','350','措美县','',''),('2999','350','洛扎县','',''),('3000','350','加查县','',''),('3001','350','隆子县','',''),('3002','350','错那县','',''),('3003','350','浪卡子县','',''),('3004','351','天山区','',''),('3005','351','沙依巴克区','',''),('3006','351','新市区','',''),('3007','351','水磨沟区','',''),('3008','351','头屯河区','',''),('3009','351','达坂城区','',''),('3010','351','米东区','',''),('3011','351','乌鲁木齐县','',''),('3012','352','阿克苏市','',''),('3013','352','温宿县','',''),('3014','352','库车县','',''),('3015','352','沙雅县','',''),('3016','352','新和县','',''),('3017','352','拜城县','',''),('3018','352','乌什县','',''),('3019','352','阿瓦提县','',''),('3020','352','柯坪县','',''),('3021','353','阿拉尔市','',''),('3022','354','库尔勒市','',''),('3023','354','轮台县','',''),('3024','354','尉犁县','',''),('3025','354','若羌县','',''),('3026','354','且末县','',''),('3027','354','焉耆','',''),('3028','354','和静县','',''),('3029','354','和硕县','',''),('3030','354','博湖县','',''),('3031','355','博乐市','',''),('3032','355','精河县','',''),('3033','355','温泉县','',''),('3034','356','呼图壁县','',''),('3035','356','米泉市','',''),('3036','356','昌吉市','',''),('3037','356','阜康市','',''),('3038','356','玛纳斯县','',''),('3039','356','奇台县','',''),('3040','356','吉木萨尔县','',''),('3041','356','木垒','',''),('3042','357','哈密市','',''),('3043','357','伊吾县','',''),('3044','357','巴里坤','',''),('3045','358','和田市','',''),('3046','358','和田县','',''),('3047','358','墨玉县','',''),('3048','358','皮山县','',''),('3049','358','洛浦县','',''),('3050','358','策勒县','',''),('3051','358','于田县','',''),('3052','358','民丰县','',''),('3053','359','喀什市','',''),('3054','359','疏附县','',''),('3055','359','疏勒县','',''),('3056','359','英吉沙县','',''),('3057','359','泽普县','',''),('3058','359','莎车县','',''),('3059','359','叶城县','',''),('3060','359','麦盖提县','',''),('3061','359','岳普湖县','',''),('3062','359','伽师县','',''),('3063','359','巴楚县','',''),('3064','359','塔什库尔干','',''),('3065','360','克拉玛依市','',''),('3066','361','阿图什市','',''),('3067','361','阿克陶县','',''),('3068','361','阿合奇县','',''),('3069','361','乌恰县','',''),('3070','362','石河子市','',''),('3071','363','图木舒克市','',''),('3072','364','吐鲁番市','',''),('3073','364','鄯善县','',''),('3074','364','托克逊县','',''),('3075','365','五家渠市','',''),('3076','366','阿勒泰市','',''),('3077','366','布克赛尔','',''),('3078','366','伊宁市','',''),('3079','366','布尔津县','',''),('3080','366','奎屯市','',''),('3081','366','乌苏市','',''),('3082','366','额敏县','',''),('3083','366','富蕴县','',''),('3084','366','伊宁县','',''),('3085','366','福海县','',''),('3086','366','霍城县','',''),('3087','366','沙湾县','',''),('3088','366','巩留县','',''),('3089','366','哈巴河县','',''),('3090','366','托里县','',''),('3091','366','青河县','',''),('3092','366','新源县','',''),('3093','366','裕民县','',''),('3094','366','和布克赛尔','',''),('3095','366','吉木乃县','',''),('3096','366','昭苏县','',''),('3097','366','特克斯县','',''),('3098','366','尼勒克县','',''),('3099','366','察布查尔','',''),('3100','367','盘龙区','',''),('3101','367','五华区','',''),('3102','367','官渡区','',''),('3103','367','西山区','',''),('3104','367','东川区','',''),('3105','367','安宁市','',''),('3106','367','呈贡县','',''),('3107','367','晋宁县','',''),('3108','367','富民县','',''),('3109','367','宜良县','',''),('3110','367','嵩明县','',''),('3111','367','石林县','',''),('3112','367','禄劝','',''),('3113','367','寻甸','',''),('3114','368','兰坪','',''),('3115','368','泸水县','',''),('3116','368','福贡县','',''),('3117','368','贡山','',''),('3118','369','宁洱','',''),('3119','369','思茅区','',''),('3120','369','墨江','',''),('3121','369','景东','',''),('3122','369','景谷','',''),('3123','369','镇沅','',''),('3124','369','江城','',''),('3125','369','孟连','',''),('3126','369','澜沧','',''),('3127','369','西盟','',''),('3128','370','古城区','',''),('3129','370','宁蒗','',''),('3130','370','玉龙','',''),('3131','370','永胜县','',''),('3132','370','华坪县','',''),('3133','371','隆阳区','',''),('3134','371','施甸县','',''),('3135','371','腾冲县','',''),('3136','371','龙陵县','',''),('3137','371','昌宁县','',''),('3138','372','楚雄市','',''),('3139','372','双柏县','',''),('3140','372','牟定县','',''),('3141','372','南华县','',''),('3142','372','姚安县','',''),('3143','372','大姚县','',''),('3144','372','永仁县','',''),('3145','372','元谋县','',''),('3146','372','武定县','',''),('3147','372','禄丰县','',''),('3148','373','大理市','',''),('3149','373','祥云县','',''),('3150','373','宾川县','',''),('3151','373','弥渡县','',''),('3152','373','永平县','',''),('3153','373','云龙县','',''),('3154','373','洱源县','',''),('3155','373','剑川县','',''),('3156','373','鹤庆县','',''),('3157','373','漾濞','',''),('3158','373','南涧','',''),('3159','373','巍山','',''),('3160','374','潞西市','',''),('3161','374','瑞丽市','',''),('3162','374','梁河县','',''),('3163','374','盈江县','',''),('3164','374','陇川县','',''),('3165','375','香格里拉县','',''),('3166','375','德钦县','',''),('3167','375','维西','',''),('3168','376','泸西县','',''),('3169','376','蒙自县','',''),('3170','376','个旧市','',''),('3171','376','开远市','',''),('3172','376','绿春县','',''),('3173','376','建水县','',''),('3174','376','石屏县','',''),('3175','376','弥勒县','',''),('3176','376','元阳县','',''),('3177','376','红河县','',''),('3178','376','金平','',''),('3179','376','河口','',''),('3180','376','屏边','',''),('3181','377','临翔区','',''),('3182','377','凤庆县','',''),('3183','377','云县','',''),('3184','377','永德县','',''),('3185','377','镇康县','',''),('3186','377','双江','',''),('3187','377','耿马','',''),('3188','377','沧源','',''),('3189','378','麒麟区','',''),('3190','378','宣威市','',''),('3191','378','马龙县','',''),('3192','378','陆良县','',''),('3193','378','师宗县','',''),('3194','378','罗平县','',''),('3195','378','富源县','',''),('3196','378','会泽县','',''),('3197','378','沾益县','',''),('3198','379','文山县','',''),('3199','379','砚山县','',''),('3200','379','西畴县','',''),('3201','379','麻栗坡县','',''),('3202','379','马关县','',''),('3203','379','丘北县','',''),('3204','379','广南县','',''),('3205','379','富宁县','',''),('3206','380','景洪市','',''),('3207','380','勐海县','',''),('3208','380','勐腊县','',''),('3209','381','红塔区','',''),('3210','381','江川县','',''),('3211','381','澄江县','',''),('3212','381','通海县','',''),('3213','381','华宁县','',''),('3214','381','易门县','',''),('3215','381','峨山','',''),('3216','381','新平','',''),('3217','381','元江','',''),('3218','382','昭阳区','',''),('3219','382','鲁甸县','',''),('3220','382','巧家县','',''),('3221','382','盐津县','',''),('3222','382','大关县','',''),('3223','382','永善县','',''),('3224','382','绥江县','',''),('3225','382','镇雄县','',''),('3226','382','彝良县','',''),('3227','382','威信县','',''),('3228','382','水富县','',''),('3229','383','西湖区','',''),('3230','383','上城区','',''),('3231','383','下城区','',''),('3232','383','拱墅区','',''),('3233','383','滨江区','',''),('3234','383','江干区','',''),('3235','383','萧山区','',''),('3236','383','余杭区','',''),('3237','383','市郊','',''),('3238','383','建德市','',''),('3239','383','富阳市','',''),('3240','383','临安市','',''),('3241','383','桐庐县','',''),('3242','383','淳安县','',''),('3243','384','吴兴区','',''),('3244','384','南浔区','',''),('3245','384','德清县','',''),('3246','384','长兴县','',''),('3247','384','安吉县','',''),('3248','385','南湖区','',''),('3249','385','秀洲区','',''),('3250','385','海宁市','',''),('3251','385','嘉善县','',''),('3252','385','平湖市','',''),('3253','385','桐乡市','',''),('3254','385','海盐县','',''),('3255','386','婺城区','',''),('3256','386','金东区','',''),('3257','386','兰溪市','',''),('3258','386','市区','',''),('3259','386','佛堂镇','',''),('3260','386','上溪镇','',''),('3261','386','义亭镇','',''),('3262','386','大陈镇','',''),('3263','386','苏溪镇','',''),('3264','386','赤岸镇','',''),('3265','386','东阳市','',''),('3266','386','永康市','',''),('3267','386','武义县','',''),('3268','386','浦江县','',''),('3269','386','磐安县','',''),('3270','387','莲都区','',''),('3271','387','龙泉市','',''),('3272','387','青田县','',''),('3273','387','缙云县','',''),('3274','387','遂昌县','',''),('3275','387','松阳县','',''),('3276','387','云和县','',''),('3277','387','庆元县','',''),('3278','387','景宁','',''),('3279','388','海曙区','',''),('3280','388','江东区','',''),('3281','388','江北区','',''),('3282','388','镇海区','',''),('3283','388','北仑区','',''),('3284','388','鄞州区','',''),('3285','388','余姚市','',''),('3286','388','慈溪市','',''),('3287','388','奉化市','',''),('3288','388','象山县','',''),('3289','388','宁海县','',''),('3290','389','越城区','',''),('3291','389','上虞市','',''),('3292','389','嵊州市','',''),('3293','389','绍兴县','',''),('3294','389','新昌县','',''),('3295','389','诸暨市','',''),('3296','390','椒江区','',''),('3297','390','黄岩区','',''),('3298','390','路桥区','',''),('3299','390','温岭市','',''),('3300','390','临海市','',''),('3301','390','玉环县','',''),('3302','390','三门县','',''),('3303','390','天台县','',''),('3304','390','仙居县','',''),('3305','391','鹿城区','',''),('3306','391','龙湾区','',''),('3307','391','瓯海区','',''),('3308','391','瑞安市','',''),('3309','391','乐清市','',''),('3310','391','洞头县','',''),('3311','391','永嘉县','',''),('3312','391','平阳县','',''),('3313','391','苍南县','',''),('3314','391','文成县','',''),('3315','391','泰顺县','',''),('3316','392','定海区','',''),('3317','392','普陀区','',''),('3318','392','岱山县','',''),('3319','392','嵊泗县','',''),('3320','393','衢州市','',''),('3321','393','江山市','',''),('3322','393','常山县','',''),('3323','393','开化县','',''),('3324','393','龙游县','',''),('3325','394','合川区','',''),('3326','394','江津区','',''),('3327','394','南川区','',''),('3328','394','永川区','',''),('3329','394','南岸区','',''),('3330','394','渝北区','',''),('3331','394','万盛区','',''),('3332','394','大渡口区','',''),('3333','394','万州区','',''),('3334','394','北碚区','',''),('3335','394','沙坪坝区','',''),('3336','394','巴南区','',''),('3337','394','涪陵区','',''),('3338','394','江北区','',''),('3339','394','九龙坡区','',''),('3340','394','渝中区','',''),('3341','394','黔江开发区','',''),('3342','394','长寿区','',''),('3343','394','双桥区','',''),('3344','394','綦江县','',''),('3345','394','潼南县','',''),('3346','394','铜梁县','',''),('3347','394','大足县','',''),('3348','394','荣昌县','',''),('3349','394','璧山县','',''),('3350','394','垫江县','',''),('3351','394','武隆县','',''),('3352','394','丰都县','',''),('3353','394','城口县','',''),('3354','394','梁平县','',''),('3355','394','开县','',''),('3356','394','巫溪县','',''),('3357','394','巫山县','',''),('3358','394','奉节县','',''),('3359','394','云阳县','',''),('3360','394','忠县','',''),('3361','394','石柱','',''),('3362','394','彭水','',''),('3363','394','酉阳','',''),('3364','394','秀山','',''),('3365','395','沙田区','',''),('3366','395','东区','',''),('3367','395','观塘区','',''),('3368','395','黄大仙区','',''),('3369','395','九龙城区','',''),('3370','395','屯门区','',''),('3371','395','葵青区','',''),('3372','395','元朗区','',''),('3373','395','深水埗区','',''),('3374','395','西贡区','',''),('3375','395','大埔区','',''),('3376','395','湾仔区','',''),('3377','395','油尖旺区','',''),('3378','395','北区','',''),('3379','395','南区','',''),('3380','395','荃湾区','',''),('3381','395','中西区','',''),('3382','395','离岛区','',''),('3383','396','澳门','',''),('3384','397','台北','',''),('3385','397','高雄','',''),('3386','397','基隆','',''),('3387','397','台中','',''),('3388','397','台南','',''),('3389','397','新竹','',''),('3390','397','嘉义','',''),('3391','397','宜兰县','',''),('3392','397','桃园县','',''),('3393','397','苗栗县','',''),('3394','397','彰化县','',''),('3395','397','南投县','',''),('3396','397','云林县','',''),('3397','397','屏东县','',''),('3398','397','台东县','',''),('3399','397','花莲县','',''),('3400','397','澎湖县','',''),('3401','3','合肥','',''),('3402','3401','庐阳区','',''),('3403','3401','瑶海区','',''),('3404','3401','蜀山区','',''),('3405','3401','包河区','',''),('3406','3401','长丰县','',''),('3407','3401','肥东县','',''),('3408','3401','肥西县','','');
/*!40000 ALTER TABLE `uchome_region` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_report`;
CREATE TABLE `uchome_report` (
  `rid` mediumint(8) unsigned NOT NULL auto_increment,
  `id` mediumint(8) unsigned NOT NULL default '0',
  `idtype` varchar(15) NOT NULL default '',
  `new` tinyint(1) NOT NULL default '0',
  `num` smallint(6) unsigned NOT NULL default '0',
  `dateline` int(10) unsigned NOT NULL default '0',
  `reason` text NOT NULL,
  `uids` text NOT NULL,
  PRIMARY KEY  (`rid`),
  KEY `id` (`id`,`idtype`,`num`,`dateline`),
  KEY `new` (`new`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_report` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_report` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_school`;
CREATE TABLE `uchome_school` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `fullname` varchar(255) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `training` tinytext NOT NULL,
  `description` text NOT NULL,
  `province_id` smallint(5) unsigned NOT NULL default '0',
  `city_id` smallint(5) unsigned NOT NULL default '0',
  `region_id` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_school` DISABLE KEYS */;
INSERT INTO `uchome_school` VALUES ('1','黄龙驾校','杭州黄龙汽车驾驶员培训中心','',' 1、黄龙体育中心二环线北侧（天目山路新桃李苑酒家对面）\n\n  2、天目山路185号（老车管所场地）','\n学校创办于1983年至今已有20多年历史．是具有一类培训资质的驾校，曾经被评为省级诚信驾校．公司位于杭州市黄龙体育中心，地理位置优越，交通便利。\n\n黄龙驾校拥有注册资金500万，教练场地2300平分米，中心各种设备齐全，配套设施合理。共有桑塔纳和自动挡教练车100多辆，有教练员100余人，行政后勤管理人员11人，年可以培训学员约4000人左右，是杭州地区规模较大、设施较完备、教练质量和管理均较优秀的驾校。','31','383','3229'),('2','技工驾校','杭州市汽车驾驶技工学校机动车驾驶员培训中心','杭州莫干山路打铁弄口70号','','杭州汽车技工学校驾驶培训中心是国家重点技工学校---杭州汽车技工学校的一个分支机构，在利用现有教学资源承担本校全日制学生驾驶培训的同时，积极向社会开放，为社会学员提供汽车驾驶培训业务，既是本校学生的实训基地，又是对外服务的培训单位，教学设施齐全、设备先进，拥有标准化教室、实习教室、多媒体教室，并配备全套专业教学模型，拥有无纸化模拟考场。与同类学校相比具有雄厚的师资力量和优良的办学条件，地理位置优越，训练场地专业，教练员同时就是本校的实习指导教师，一级实习指导教师占教练员总数的  30 %，拥有星级教练员 22 人，教学规范，管理科学，年培训量可达3000余人，考核合格率达90％以上。驾驶培训中心以创造“一流的服务、一流的质量、一流的队伍”迎接四方学员，以“一切为了学员，为了学员的一切，为了一切学员”的指导思想开展服务，具有较高的知名度和良好的社会声誉，特别是以 “规范培训、文明执教、承诺服务、廉洁教学”享誉杭城内外，以质量和服务取信于学员，以优质优价满足学员需求，办班灵活，实行体检、理科、术科一条龙服务，加强对教练员的考核，确保学员足时训练。建校三十年余来，在管理部门建立“零投诉”记录，被杭州市众和理科中心确定为“交通法规”理论教学点、杭州市机动车服务管理局确定为“营运车辆”驾驶员培训教学点，是省、市“十佳”驾培机构 AAA级驾驶培训学校。\r\n\r\n \r\n','31','383','3232'),('3','长运驾校','杭州长运驾驶培训有限公司','杭州市西溪路529号','','杭州长运驾驶培训有限公司创办于1979年5月，是浙江省最早期的驾驶培训学校之一，专业从事汽车驾驶员和交通行业各类技术等级培训，属杭州市一类驾校。在历年的行业教学评估中，公司多次获得“优胜单位”和“优秀培训业户”等荣誉称号。并在2006年和2008年荣获杭州市驾培行业信用质量考核“AAA级”优胜单位，特别是在2009年获得了杭州市“十佳”驾培机构的荣誉称号。学校拥有71辆教练车，19名星级教练员，在公司全体员工的共同努力下，迄今已为社会培养普通驾驶员及初、中、高级驾驶员、修理工等各类交通技术人才12万余名，得到了社会各界的广泛认同和良好评价。\r\n\r\n       公司以“重信用、抓质量、树品牌”为指导思想，完善管理体制，注重加强教练员队伍建设，特别是加强教练员的思想素质教育，使教练员深刻理解驾驶培训的竞争实质其实是教练员素质的竞争、服务的竞争、品牌的竞争。要求教练员为人师表，把学生利益放在第一位，廉洁执教，文明施教。结合当今新形势，在完善廉洁教学制度前提下，引导教练员树立“淡泊名利、忠实屡职”的自律理念，努力打造“廉洁从业、诚信守纪”的共同价值观，实行对学员的跟踪反馈，利用电话、问卷调查等形式让学员对教练员进行打分评价，并且作为教练员年终考核的一定依据，直接和奖金挂钩。  \r\n\r\n       注重教学方法，以质取胜，我公司在历年的教学质量抽查中一直都保持全市前十以内，作为一个公营驾培机构，我公司一直以学员利益为先，近几年来，个别私人驾校为取得更大经济利益，以低价吸引学员，教学过程严重“缩水”，而我公司的教练员一直坚持在教学中让学员“多跑多练”，真正让学员上车上路，而不仅仅只是为了应付考试。特别是一些老的教练员有自己独特的一套教学方法，教学中能根据学员年龄特点因材施教，对待不同的学员采取不同的教学方法，在教学过程中循序渐进，以平和的心态进行教学。并且在平时安全活动中教练员都能踊跃发言，互相交流心得，总结教学经验，就是因为有这些优质的教练员，09年我公司考生的合格率为91.7℅。\r\n \r\n       随着培训行业的发展，杭州长运驾驶培训有限公司一直秉着“重信用、抓质量、树品牌”的方针，注重长运品牌，注重规范管理，把握发展契机，本着对社会负责，对学员负责的态度，以文明驾培、品质驾培为目标，在杭州市车管局、驾培机构的领导下，一个更新、更优的长运驾校将向市民展示。\r\n\r\n','31','383','3229'),('4','公交驾校','杭州市公共交通总公司培训中心','绍兴路468号','','杭州市公共交通总公司培训中心经杭州市市政公用事业管理局批准于1993年6月18日成立。现有教职工69名；专兼职教师37名。并持有浙江省公安厅、杭州市车辆管理所颁发的《机动车驾驶员培训许可证》及杭州市劳动局颁发的《技工培训考核许可证》。主要培训项目有大客驾驶培训（包括B+A驾驶培训）；大货、小型汽车及桑塔纳轿车驾驶培训；以及各类级别的汽车驾驶、修理工、电工、漆工等技术等级培训；对外承接技工等级考核。是一个具有一定规模的培训基地。　　中心地处城市建设发展区，邻近享有全国声誉的钱江小商品市场和省重点安居工程--三塘小区。可乘坐12路、22路、34路、34','31','383','3231'),('5','新塘驾校','杭州新塘驾驶培训有限公司','杭州市彭埠镇三新北路66号','',' 杭州市新塘驾驶培训有限公司具有浙江省一类驾驶培训服务资质。总投资2500万，注册资金500万。学校教学设施齐全，师资力量雄厚，拥有训练场地75000平方米。现阶段为了配合公安部最新推出的九项考试项目，我校特建立一个占地20亩的封闭训练场地，使学员在本校场地内就可完成所有考试项目训练。此外，我校还拥有A、B、C、Z、各类教练车200余辆并有大批星级教练员可供选择。\r\n   公司已在杭州市区设立了各报名网络点。同时，公司为学员在校培训期间提供就餐、休息、停车等场所提供便利服务。 ','31','383','3234'),('6','铁路驾校','杭州铁路汽车驾驶培训有限公司','','','　杭州铁路分局汽车驾驶员培训中心坐落于万松岭南侧．欢迎您来我校参训．共同努力实现学员考试一次性合格率第一名，保证前三名的目标！　　1、杭州市优秀驾校，执教监督单位，行业特别推荐单位，免审单位。　　2、足时培训，一次性合格率稳居杭城前茅。　　3、杭州首家推出“五不”制度（一顿饭、一滴酒、一分钱、一包烟、一次牌）的驾校。　　4、可根据学员自身情况合理安排训练时间（全日制、业余制、双休日班）　　5、杭州首家推出合同学车，切实保障学员权利，明确责任，义务关系。　　6、校内拥有城区唯一自训坡道和面积最大灯光最亮的20000平方米的水泥场地。可以进行全部9个项目夜间和初、中级道路训练。   ','31','383','3230'),('7','军旅驾校','杭州军旅机动车驾驶员培训中心','杭州市彭埠镇云峰二区102号','','','31','383','3234'),('8','一运驾校','杭州第一汽车运输有限公司驾驶员培训中心','杭州市绍兴路81号','','一运公司培训中心系杭州第一汽车运输有限公司所属专业性驾驶员培训单位，是杭州市最早的培训单位之一，拥有一支较高素质、技能的教练队伍，从事大小车驾驶培训，长期以来内部管理严格，教学计划根据便于学员学习掌握驾驶教学。办学宗旨：以质量求生存，以信誉求发展，努力为社会培养遵章守法的合格驾驶人才。  ','31','383','3232'),('9','三运驾校','杭州三运机动车驾驶员培训有限公司','三墩镇厚仁路方田湾','','州三运机动车驾驶员培训有限公司是一家由杭州长运三运运输有限公司为大股东的股份制企业。企业的注册地址：杭州石桥路397弄7#。公司占地面积18余亩，硬化教练场地8000余平方米，移库倒桩车位30余个，泊车室内场地1200平方米。有办公用房及教职学员休息室500平方米，理课教室和排故教学室近200平方米，拥有全套电化教学设备和无纸化考试电脑训练设备。企业注册资本壹佰伍拾万元。第一期将投入教练车辆30辆（大货10辆，桑塔纳20辆）公司将以全新的车辆投入教学。　','31','383','3232'),('10','赛协驾校','杭州赛协驾驶员培训有限公司','江干区机场路里街天仙庙21号','',' 杭州赛协驾驶员培训有限公司是浙江省和杭州市驾驶员培训行业协会的会员单位。地址在杭州市江干区笕丁路6号，是向社会培训小汽车驾驶员的专业公司。\r\n    \r\n     公司自2001年成立以来，本着对社会和学员负责的态度，坚持以诚信为本，科学规范教学，廉洁礼貌待人，和每一位学员鉴订学驾合同，做到：“不拿学员一包烟，不额外多收学员一分钱，不吃学员一餐饭”，公司与教练员签订了教学责任“合约书”，严格把好培训质量和安全廉洁关。','31','383','3234'),('11','浙一水建驾校','杭州浙一水建机动车培训有限公司','浙江省杭州市滨江区省水电新村一区','','杭州市浙一水建机动车驾驶员培训中心（浙一水建驾校）于1987年成立，是杭州市地区最早从事汽车驾驶培训的18家专业培训单位之一，具有极佳的机动车培训基地，培训中心现拥有大客、大货、桑塔纳教练车126辆，训练场地20000平方米，是杭州地区有限几家超百辆教练车的大型驾培一类单位之一。','31','383','3233'),('12','天羽驾校','杭州天羽汽车驾驶培训有限公司','七堡蚕种场航海路760号','','浙江天羽驾校（原金盾驾校）是浙江省级公安机关离退休老同志集资筹办的集体所有制学校，是一所专业培训汽车驾驶的学校，它的宗旨是为社会培训合格的驾驶人才。 天羽驾校（原金盾驾校）于1993年底建立，1994年4月正式开学培训，七年来，已为社会培训6000余名合格的汽车驾驶员。天羽驾校（原金盾驾校）地址在杭州市江干区七堡，地处近郊，交通方便。 天羽驾校（原金盾驾校）现有大小型教练车30余辆，有6000平方米的教练场..','31','383','3234'),('13','杭州四季青驾校','杭州四季青汽车驾驶员培训有限公司','杭海路567号','','四季青驾校培训场以信誉第一，坚持热情的服务，规范的管理，优质的教学，竭诚服务于学员，服务于社会，欢迎社会各界人士来培训场学习。 \r\n    杭州四季青驾校文教培训场为社会培训了大量合格的汽车驾驶员。本培训场现推出如下特价服务项目：\r\n    1、代办驾驶员安全学习的落户等一切学车手续。\r\n    2、提供体检、报名、缴费、打卡、办证等一条龙服务。\r\n    3、市区内学车就近接送学员（路训）。\r\n    4、 学员取得驾驶证资格后，免费提供车辆及教练员在市区道路陪驾。\r\n    5、可根据学员自身情况合理安排训练时间，开设早训专场、全日制、业余制、双休日班、晚间培训（路训）。\r\n    6、为方便学员学车，本培训场采用场地、道路分车训练的流水作业方式。\r\n    7、专职教练和专训车辆每周六天在场地恭候。\r\n    8、提供桩考、路考模拟测试场地。\r\n    9、学车40天后可考试 。\r\n    10、谢绝请吃、送礼、在训练期间奉送校内餐券，免费就餐。 \r\n    11、每年组织一次驾车旅游联谊活动。','31','383','3234'),('14','宁大驾校','杭州宁大汽车驾驶员培训有限公司','三墩镇塘河村高家庄桥南16号','','杭州宁大驾驶员培训有限公司(宁大驾校)是一家AAA级正规专业驾校，2005年度杭州100多所驾校并例排名第5位。\r\n    宁大驾校培训基地位于文一西路延伸段金埭路50号，基地拥有培训场地面积10000平方米，9选6科目齐全教育环境、教育设施完善，配有学员休息室、食堂等，本公司现有高级教员35人，为前来学车的学员提供、体检、术科、上车接送等一条龙服务，价格优惠，欢迎广大学车市民前来学车。3.4星级优秀教练員，专车接送；认真教学；欢迎咨询。场地学车地点：杭州市文一西路（宁大驾驶员培训基地）。','31','383','3229'),('15','航摩驾校','杭州市航摩机动车驾驶员培训中心','西湖区西溪路858号','','    航摩机动车驾驶员培训中心(航摩驾校)，隶属于杭州市射击汽车摩托车运动中心，坐落在西湖区西溪路858号，占地90余，拥有按国际比赛标准要求建造，目前国内一流的射击场馆，其周边有9000余平方米的汽车、摩托车训练考试基地。\r\n    航摩驾校现有汽摩教练车60余辆，聘请技师和中、高级操作教练员，并已拥有杭州市首批三星级汽车驾驶操作员，是行业主管部门认定的二类资质培训业户，专业培训B、C、D、E、F类机动车驾驶员。\r\n    航摩驾校集20余年培训教学经验，条件优越，场地规范，设施齐全，并承诺诚信为本，廉洁高效，服务周到，来航摩参加汽车摩托车培训，不失为您理想选择！\r\n','31','383','3229'),('16','经职驾校','杭州经职机动车驾驶员培训有限公司','下沙镇七路村','','浙江经职机动车驾驶员培训有限公司由浙江勤盛教育后勤服务有限公司和浙江经济职业技术学院共同组建。公司秉承“严谨、勤学、求实、开拓”的校训，坚持以“质量求生存、以特色占市场”的培训方针，“以辅助教学、服务社会、廉洁执教、优质高效”为办学宗旨，注重培养员工的服务意思，加强廉洁执教建设并对教练员的技术技能进行严格考核，严把教学质量、安全关。','31','383','3234'),('17','平安驾校','杭州平安机动车驾驶员培训有限公司','天目山路369号','','杭州平安驾培中心是一家专业的驾训公司，位于天目山路369号（近汽车西站）。拥有教练车50辆。学校注重内部的教学管理，重视教练的业务水平，抓好教练的素质教育。为学员提供高素质、高水平经验丰富的教练队伍，廉洁施教，优质服务，保证学员上车时间，重点培养学员的实际驾驶操作技能。考试合格率高，学员满意度高。做到：“不拿学员一包烟，不额外多收学员一分钱，不吃学员一餐饭”，公司与教练员签订了教学责任“合约书”，严格把好培训质量和安全廉洁关。主城区学员学车都可上门接送。滨江学员也可以接送。\r\n平安驾校特色服务：\r\n1、提供报名、体检、办证、考试一条龙服务。\r\n2、学车期间专车接送。\r\n3、根据学员的自身情况合理安排学车时间。\r\n4、提供全新教练车。','31','383','3229'),('18','心成驾校','杭州心成机动车驾驶员培训有限公司','杭州市拱墅区莫干山路498号(拱墅交警对面)','','杭州心成驾驶培训学校成立于2002年，位于杭州市拱墅区湖墅南路156号（沈塘桥大塘巷社区），拥有全新桑塔纳教练车70辆，教练员78名，其中四星级教练3名、三星级教练员10名及多名高级教练员，拥有中高级职称、技师等级的占90%，达到三级驾校资质。\r\n\r\n杭州心成驾校荣誉：多年来连续被行业主管部门评为优胜单位，2007、2008年驾培信用质量考核为“AAA”优胜驾校。\r\n\r\n杭州心成驾驶培训学校为了感谢社会各界学员对学校的支持，推出学车特别价（含模拟驾驶费，不含体检和报名费）。在学员学车过程中，教练组成员承诺不吃学员一顿饭，不拿学员一包烟，更加拒绝收学员送的红包，礼品。为了使学员对学车的过程有个直观的认识，现更推出了免费体验驾驶乐趣活动。每个有学车意向的学员只需要联系上杭州心成驾校，核实相关情况后就能进学车场地免费体验三次专业的教学，时间有限，欲报从速。\r\n\r\n心成驾校服务特色：\r\n一、为学员提供报名、体检、理论等一条龙服务。\r\n二、全程学车上门接送。\r\n三、引进先进的IC卡计时系统。\r\n四、可根据学员自身情况合理安排训练时间。\r\n五、提供夜间灯光训练。\r\n六、驾校可保留学员学车档案，代理加入市区安全组以及年审手续。\r\n七、夏季夜间特色学车。\r\n','31','383','3232'),('19','大安驾校','杭州大安机动车驾驶员培训有限公司','江干区范家村天成路148号','','  大安驾校拥有各型性能良好的车辆提供教学，教练员是通过严格的考核，并持证上岗，属经验丰富、作风正派、有职业道德、责任心强的高级驾驶员执教。\r\n    大安驾校始终坚持一次性收费，随到随学原则，如有特殊情况可采取上门服务，学校对行管人员及教练员有一系列之有效的管理制度。不允许对学员以任何名义摊派费用，学校对违章违纪的行为历来奉行严惩不怠的原则，力求给学员一个满意的答复。\r\n    大安驾校以雄厚的师资力量、优越的办学条件、成功的办学经验、科学的教学管理、一流的服务质量赢得了广大学员及各界的好评。我们欢迎有志于汽车驾驭的朋友来学校报名学习。','31','383','3234'),('20','中兴驾校','杭州中兴机动车驾驶员培训有限公司','天目山路369号','','杭州中兴驾校（原杭州中银驾校）成立于1991年，位于位于天目山路369号（汽车西站旁），四周环境优雅，空气清新。学校培训场地面积8500多平方米，拥有齐全的教学设施，共有教学车辆40多辆，现有45名经验丰富的教练（其中杭州市星级教练员6名），按小班制，对学员精心辅导施教。中兴驾校的教学理念是：专业、严谨、诚信！中兴驾校学员合格率在杭州驾校处于行业领先水平，多次被评为杭州优秀驾校。我们十分注重教练员的管理和教风建设，严格杜绝教练员收取学员香烟、礼品，并实行教练员和学员分餐制度，确保学员权益。 学员体检报名实行上门服务，学车实行包接包送！欢迎学员“比服务! 比价格! 比教学质量!”挑选一个好驾校。','31','383','3229'),('21','万丰驾校','杭州万丰机动车驾驶员培训有限公司','杭州市拱墅区半山路296号','','注册地处于拱墅区的杭州万丰机动车培训中心，是杭州市AAA级质量信用考核优胜单位、驾培协会会员单位，是驾培扶贫帮困企业之一。现拥有正规的、经政府部门批准的大型训练中心基地约15000㎡和经公安交通部门批准的杭城经典教练路线，以及办公及教学室800余㎡。驾校现有车况良好的教练车及工作用车60余辆、教练员及管理人员70余人，本着强大的优秀师资力量及和超前的服务管理理念，力争杭州最优秀的驾校。','31','383','3232'),('22','交通职高驾校','杭州交通职业高级中学机动车驾驶员培训中心','德胜路44号','','    杭州交通职高是省重点示范性职业高中，设有汽车驾驶、修理等六个专业，学校驾校中心是学生实习基地，除培训在校学生外，也向社会招生。培训C型和B型驾驶员。\r\n    交通职高驾校培训中心，有完善的教学设施，优秀的师资队伍。教学注重基础，注重实际，严格按教学大纲要求进行正规培训。','31','383','3232'),('23','公联驾校','杭州公联机动车驾驶员培训有限公司','下沙经济开发区文津北路28号，计量学院北1000米','','我们汽训队地处清泰门外，交通方便，乘公交20、14、44、202、836、39路近江村，29、71、809、32、517近江小区站底下车即可，拥有大客A型、大货B型、轿车C型教学用车和专职教员，场地面积3000多平方米，教学配套硬件设施齐全，师资力量雄厚，年培训量近千名，场、路考合格率在90%以上，2002年被评为浙江省公众满意诚信培训单位，深受广大学驾人员的好评。\r\n\r\n服务内容：\r\n一、免费代办学习驾驶过程中的一切手续（登记打表、体检制证等）\r\n二、可上门实行一条龙服务，四人以上驻点教学。\r\n三、学车时间自选，特设有双休、节假日和晚间培训。\r\n四、提供考前培训和考后轿车陪驾。\r\n五、领取驾照后为您落实安全组，代为办理驾照年检验审和异地过户转藉。\r\n一次性缴费、收费合理、考出为止，杜绝乱收费。\r\n \r\n\r\n地址:杭州市婺江路\r\n\r\n训练场地：下沙','31','383','3234'),('24','超时代驾校','杭州超时代机动车驾驶员培训有限公司','九堡镇九堡1组','','    杭州超时代培训有限公司(超时代驾校)是杭州首家采用高科技的驾驶系统与实车训练相结合的新型教学模式的驾驶培训公司。 \r\n    超时代驾校学员通过先期模拟驾驶训练，培养良好的心理素质，熟练掌握驾驶基础操作，做到“心中有底，驾车不慌”。再经具有丰富带教经验的教练员指导，进行实车训练。学员能很快领会驾驶教学要求，科学、系统、规范的掌握驾驶的操作技能。','31','383','3234'),('25','海鹏驾校','杭州海鹏机动车驾驶员培训中心','西湖区西溪路156号','','    杭州海鹏机动车驾驶员培训中心(海鹏驾校)属四星级驾校，拥有 5000 平方米的培训基地，备有桑塔纳教练小车 65 辆，教练员 60 余人。文教培训场系公司下属的培训场所，地处杭州市中心，老文教区块，高校林立，交通便捷。 \r\n    海鹏驾校教练员具有大专学历、高级驾驶员职称，驾驶技术好，经验丰富。培训场制度完善，管理严格，先后为社会输送了大量的合格驾驶人才，取得了社会良好的赞誉。 \r\n    海鹏驾校培训场以信誉第一，坚持热情的服务，规范的管理，优质的教学，竭诚服务于学员，服务于社会，欢迎社会各界人士来培训场学习。 \r\n    海鹏驾校现推出如下特价服务项目：\r\n    1、代办驾驶员安全学习的落户等一切学车手续。\r\n    2、提供体检、报名、缴费、打卡、办证等一条龙服务。\r\n    3、市区内学车就近接送学员（路训）。\r\n    4、学员取得驾驶证资格后，免费提供车辆及教练员在市区道路陪驾。\r\n    5、可根据学员自身情况合理安排训练时间，开设早训专场、全日制、业余制、双休日班、晚间培训（路训）。\r\n    6 、为方便学员学车，本培训场采用场地、道路分车训练的流水作业方式。\r\n    7 、专职教练和专训车辆每周六天在场地恭候。\r\n    8 、为白天工作繁忙之人士提供夜场灯光场训。\r\n    9 、学车20天后可考试 。\r\n    10 、谢绝请吃、送礼、在训练期间奉送校内餐券，免费就餐。','31','383','3229'),('26','大成驾校','杭州大成机动车驾驶员培训有限公司','文三路20号','','浙江大成机动车驾驶员培训有限公司(大成驾校)成立于1978年，前身是浙江省大成建设实业公司汽车培训队（浙建汽训队），1988年起面向社会招生。\r\n\r\n大成驾校自成立以来，以科学、严谨的教学态度，规范细致的教学手段，抱着诚信服务、廉洁施教的教学宗旨，至今已向社会输送了万余名合格驾驶人才。近年来公司坚持面向市场，服务社会的宗旨，不断加强廉政教育和提高培训质量。\r\n\r\n大成驾校拥有桑塔纳教练车30余辆，教练员30余名，其中星级教练四名。\r\n\r\n大成驾校宗旨：诚实守信、质量为本。\r\n','31','383','3229'),('27','浙公技校','杭州浙公技校驾驶培训中心','西溪路523号','','浙江公路机械技工学校创办于1978年，隶属于浙江省交通厅，是浙江省重点学校，交通部重点学校。校汽驾中心成立于1995年，依托学校由学校统一管理，目前拥有桑塔纳教练车20辆，训练场地6000平方米.中心实施科学管理，培养了一支过硬的教练队伍，从制度上保证廉洁教学和安全教学.在教学上严格执行驾驶培训教育大纲，严把教学质量的第一个环节，实施以人为本，分层教学，满意服务，根据学员对象不断变化，逐步在培训时间，培训方式和人员组合等各方面推行特色教学，确保较高的技术和考出率满意率。浙江浙公驾驶培训学校以具有完善的科学化管理，特色化教学，人性化服务体系的重点单位。','31','383','3229'),('28','诚信驾校','杭州诚信机动车驾驶员培训有限公司','上塘路1606号','','杭州诚信机动车驾驶员培训有限公司(诚信驾校)拥有各型性能良好的车辆提供教学，教练员是通过严格的考核，并持证上岗，属经验丰富、作风正派、有职业道德、责任心强的高级驾驶员执教。\r\n\r\n诚信驾校始终坚持一次性收费，随到随学原则，如有特殊情况可采取上门服务，学校对行管人员及教练员有一系列之有效的管理制度。不允许对学员以任何名义摊派费用，学校对违章违纪的行为历来奉行严惩不怠的原则，力求给学员一个满意的答复。\r\n\r\n诚信驾校以雄厚的师资力量、优越的办学条件、成功的办学经验、科学的教学管理、一流的服务质量赢得了广大学员及各界的好评。本校训练场地还有室内和室外之分，是杭城目前为止唯一一家具有大规模室内训练场地的驾校。可免去学员受伏夏日晒雨淋和严冬冷风侵袭之苦。本校全年开展学员培训工作，学员可自由选择休假日或下班时间(晚上)参加各项培训。真正做到学车与工作或学习两不误。我们欢迎有志于汽车驾驭的朋友来学校报名学习。\r\n','31','383','3232'),('29','东信驾校','杭州东信机动车驾驶员培训有限公司','文三路398号东方通信大厦','','东信驾训成立于2002年12月，系普天东方通信集团有限公司下属的一家子公司，投资1000万，按一类驾训资质要求设立，拥有教练车辆50辆，留下和秋涛北路两大块教练场地，以“朋友似的教学、酒店式的服务、现代化的管理”为理念，配以一流的硬件设施和优雅的环境，致力于打造杭城驾驶培训新景象。\r\n    公司推出的服务措施在杭城驾培业掀起一股新风。在此基础上，东信驾训首推“全额返还培训费”制，即在训期间发现教练员收受学员红包、礼品等或接受请客吃饭，公司全额返还培训费。同时，红外线倒桩设备的启用，ISO9002质量管理体系的引入，都将大大提升东信驾训的服务水平。凭借东信的品牌和管理优势，我们相信东信驾训有能力走的更远。 ','31','383','3229'),('30','五洲驾校','杭州五洲机动车驾驶员培训有限公司','杭海路434-1','','杭州驾校联盟网推荐：杭州学车去五洲机动车驾驶员培训有限公司（五洲驾校）是杭州驾校，教学服务质量好，学车交通便利，上门接送，五洲机动车驾驶员培训有限公司（五洲驾校）欢迎您报名我们的驾校！\r\n\r\n本公司是一家具有二级资质的机动车驾驶员培训有限责任公司。硬件设施齐全。现公司拥有普桑教练车20辆，解放大型货车教练车2辆。教练场地约6000平方，交通十分便利。 公司为实施“规范教学，诚信服务、安全至上”的宗旨，在交通公安等管理部门的指导下，建立制定了一套的教练员管理、教练规则考核、场务管理、廉洁自律等规章制度。\r\n\r\n特别在注重教练员的业务素质和职业道德上不断进行完善、改进，为学员提供优质的服务。提高学员的满意率和考核率。为杭州机动车驾驶培训行业成为一个新亮点作出应有的贡献。\r\n','31','383','3234'),('31','警官驾校','浙江警官职业学院汽车驾驶培训中心','杭州下沙浙江警官职业学院','','本培训学校为专业的机动车驾驶培训机构，教学水平上乘，承接各类型机动车驾驶培训业务','31','383','3234'),('32','捷安驾校','杭州捷安汽车驾驶员培训有限公司','香积寺路206号','','中外合资杭州捷安汽车驾驶员培训有限公司(捷安驾校)是经浙江省和杭州交通、公安部门批准成立的具有二类资质的专业驾驶员培训学校。\r\n\r\n捷安驾校目前拥有桑塔纳教练车30辆，标准硬化场地三处，总部位于城区绍兴路、香积市路口，场地开阔，教学设施齐全，交通便利，给您学车带来舒畅与便捷。作为杭州市唯一一家中外合资驾陪企业，我们吸收了国外的先进经营理念，以市场需要为依托、学员需求为己任，诚信经营为前提，以人为本为宗旨，使您真正做到轻松学车、快乐学车。 \r\n\r\n捷安驾校服务特色：\r\n1、实行体检、理科、术科一条龙代办服务。\r\n2、学车上门接送学员。\r\n3、学车期间谢绝学员给教练员送礼品或红包，一经核实，双倍返还。\r\n4、学后优惠加入公司车友俱乐部，享受各种服务（代办驾照年审、清卡、换证、车辆保险等）。\r\n','31','383','3231'),('33','浙大同力驾校','杭州浙大同力机动车驾驶员培训有限公司','浙江省杭州市湖州街61号浙大城市学院旁','','浙大同力驾校是浙大后勤集团、城院教育发展公司的下属企业，提供考小车C1、C2类驾照的驾驶培训培训，是浙大机械与能源工程学院汽车专业和杭州之江专修学院的学生汽车驾驶实践基地，从03年10月发展至今，已有教练车普桑38辆、自动档捷达1辆和“环保节能电动训练仪（第二代）”1辆，在浙江大学华家池、紫金港、城市学院三校区及打铁关和平广场附近等有驾驶培训场地22121㎡，方便学员杭州学车就近培训；并拥有一支技术精湛、清政廉洁的教练员队伍，其中杭州市驾校十佳教练员2名、省优秀教练员1名、星级教练员11名，用心教练已为社会输送技术一流、品质高尚的优秀驾驶员。\r\n\r\n浙大同力驾校坚持“高起点、高标准、高质量”的经营方针以及“管理规范、教育有序、热情求实、语言文明、诚信负责、廉洁从教”的教学准则和以“人为本、诚信办学”的服务理念，努力创新，在杭城驾培市场激烈竞争中赢得一席之地，树立良好的品牌杭州驾校形象。\r\n\r\n浙大同力驾校连续四年稳居行业各项排行榜前列：路考合格率都排名在前十、08年以93.4%排第八名、“AAA优胜杭州驾校”，是07年度杭州驾协优秀会员单位，是08年度十佳杭州驾校，是08年度浙江省十佳驾驶培训学校，是一家有规模、有实力、高合格率的“重信用，重质量”杭州市知名品牌驾校。在浙大城市学院还有一块近一万㎡的市区训练场地，四周绿树鲜花、公安部规定的场内道路驾驶训练科目齐全，为学员训练驾驶基本功提供极好条件。\r\n\r\n浙大同力驾校将继续本着“全心全意为学员服务”的宗旨和“精彩学车，快乐享受”的理念，以一流的驾驶培训硬件设施为载体，凭借丰富的驾驶培训教学经验和管理经验，积极探索创新的管理模式和教学方式，实行网上学车报名和网上学车培训预约，推广应用先进科技手段，提高了驾培的科技含量和培训质量，全面做好驾驶培训各项工作，努力实现“我们的服务与您的需求同步”，全力打造和提升 “浙大同力”的杭州考驾照的知名品牌。\r\n','31','383','3232'),('34','乔支驾校','杭州乔支机动车驾驶培训有限公司','文华路西斗门8号','','市第二支队汽训队即杭州乔支汽车驾驶培训学校前身为公安二队，现有大型（解放）B2、小型（桑塔纳）C1、自动档型（捷达）C2等教练车，新修近6000平方米高标准训练场（仿红外线）及新增九项设施齐全。注重廉洁服务和规范施教，无额外收费。我队拥有一支技术精湛、教学经验丰富、责任心强的教练队伍，有良好的口碑声誉和教学质量，近年来学员实践考试一次性通过率均在96%以上。\r\n\r\n    根据广大学员工作比较繁忙的实际情况，我们在教学时间安排上采取以学员为中心，自由、灵活、分散的方法，特开设假日班、双体日班、早晚班、中午班。由学员约定上车训练时间，在保证训练总学时的前提下，依照个人的训练情况，组织安排考试。若考试未能通过，仍可继续学习，直到考出为止。','31','383','3229'),('35','汇丰驾校','杭州汇丰机动车驾驶培训有限公司','下沙高教园区','','杭州汇丰机动车驾驶培训学校(汇丰驾校)座落在环境优美的杭州下沙高教园区，并在市区设有多处培训点，是杭州二类资质驾驶培训单位。\r\n    汇丰驾校严格执行省公安厅、交通厅的规定，教学设施齐全，配备全新桑塔纳教练车，驾校场地宽敞，设有圆饼路、单边桥、S型路等规定考试项目。\r\n    汇丰驾校规范管理、个性培训、轻松学车，尊重学员。实行体检、理科、术科一条龙服务，教学时间灵活，可预约调整。学校操作规范、培训严格，能增强学员从容面对道路考试，公司承诺除学员所缴纳及代收费用外，不再产生任何费用，教练谢绝红包或礼品。\r\n    汇丰驾校特色服务：\r\n    1、学员可网上报名，实行体检、理科术训、考试一条龙服务。\r\n    2、可根据学员自身情况合理安排训练时间（全日制、业余制、双休日班）\r\n    3、校区场地宽敞，备有模拟考桩，能促进学员顺利通过倒装考试。\r\n    4、全新教练车，学车10天后可参加科目二考试。\r\n    5、学车全程提供上门接送。  ','31','383','3234'),('36','蒋村驾校','杭州蒋村驾驶培训有限公司','花蒋路','  杭州蒋村驾驶培训有限公司(蒋村驾校)是以提供驾驶培训及驾驶员相关服务为主的专业驾训公司。\r\n    蒋村驾校投资1000万元人民币，按国家一类驾训资质要求设立。所有培训车辆均为全新车辆','','31','383','3229'),('37','辰龙驾校','杭州辰龙汽车驾驶员培训有限公司','彭埠镇章家坝寸东区130-1号','','    公司开业至今１０年，曾为社会培养了万余名驾驶员，积累了丰富的教考经验，公司新管理机制日益完善，对外有学员服务承诺、意见反馈单；对内有教练上岗责任制、员工纪律考核、员工业绩奖惩罚等。公司一贯提倡诚信原则，公正、合理的收费将给每一位学员带来更为全面的高质量服务。\r\n\r\n经营许可证号：330101J00057\r\n经营资质：驾培二类\r\n经营项目：驾培(汽车驾驶员培训)\r\n','31','383','3234'),('38','众安驾校','杭州众安机动车驾驶员培训中心','下沙杭钢农场内','','杭州众安机动车驾驶员培训中心(众安驾校)是经浙江省和杭州交通，公安部门批准成立的具有三类资质的专业驾驶员培训学校。驾校培训场地位于下沙大学城计量学院东300米，占地5000余平方的训练场地，同时可容纳100余辆车进行多个科目的训练：设置齐全，具有桩训场地、连续障碍、单边桥，曲线路，侧方停车，上坡停车与起步，起伏路、直角转弯。\r\n    众安驾校提出了“快乐学车，驾车无忧”的学车理念，倡导“我们的服务与您的需求同步，”全年365天，天天培训，多种约车方式，实行夜间和节假日全天候培训，满足个性化驾训需求，在完成标准五彩纷呈的驾驶技能培训的基础上，着重打造享受型的驾训服务，成为能够满足不同层次需求的新型驾训服务机构。打造下沙最好的驾驶培训学校。\r\n    众安驾校特色服务： \r\n    一、上门报名    \r\n    为学车学生提供最为便捷的报名服务，免费代办暂住证（外地户口学生）\r\n    二、特色快班     \r\n    杭州最具优势的驾驶培训服务，无论学车考证时间，报名手续办理，还是技术及跟踪服务，让您感觉到的是快捷，方便，周到，中心特设晚间培训，让您学车，工作无忧。\r\n    三、体检练车接送    \r\n    为学员方便培训中心服务承诺提供体检练车一条龙接送服务。\r\n    四、全新教练车辆   \r\n    08年来中心新增数十辆全新的教练车，实现最高合格率，让学员更轻松，更安全，充分体验驾驶乐趣。\r\n    五、签定培训合同 \r\n    学员报名培训时，均签定国家标准的学车合同，切实保障学员权利，明确义务关系，学车价格全透明，开据正式发票。','31','383','3234'),('39','东运驾校','杭州东运汽车驾驶培训有限公司','江干区章家坝东区112-1','','东运驾校投资1000万元人民币，按国家一类驾训资质要求设立，拥有教练车50多辆。在当前激烈的市场竞争中，驾校注重内部教学管理，抓好教练员的素质教育，重视驾校教练员的业务水平，并拥有高素质、高水平、廉洁奉公的教练队伍，提供学员的满意率和考核率，引进先进的IC卡计时系统，保证了学员的上车时间，也为学员提供优质的学车环境和优质服务。\r\n    东运驾校特色服务：\r\n    1、提供免费专车接送学员体检，以免学员舟车劳顿之苦。\r\n    2、在学车过程中，决不另外收取费用，教员严格遵守廉正规定和职业道德规范，不接受学员的请吃、礼品、礼金。如有违反上述承诺的，欢迎学员举报，我们必将严肃处理，给学员一个满意的答复。\r\n    3、我公司还开设一对一贵宾式服务，专车接送、专人培训，提供最新、最舒适的培训车辆，让学员享受五星级高档次、全方位的服务。','31','383','3234'),('40','迪佛驾校','浙江迪佛汽车有限公司机动车驾驶员培训分公司','白石巷88号','','    浙江迪佛汽车驾校前身系杭州电信汽训队，有二十多年的汽车驾驶员培训历史．随着市场发展，经营规模不断扩大并在2002年2月正式更名为浙江迪佛汽车驾校，我校拥有标准的场地设施，规范的管理制度，一流的的教练队伍，还可以根据学员的学习要求灵活的安排学车时间。\r\n    规范的管理，全程的的服务是我们的宗旨，让您体验驾车乐趣是我们的使命．相信通过我们的真诚的服务，能让您熟练掌握驾车技能，使您的未来生活更加美好。“视学员为上帝，广交天下朋友！”','31','383','3232'),('41','天城驾校','杭州天城汽车驾驶培训有限公司','下沙、城西','','杭州天城汽车驾驶培训有限公司（以下简称杭州天城驾校）成立于2008年6月。现拥有各类教练车近60辆，教职员工70余人，训练场地近20000平方米，是一家具有良好教学资质的新型汽车驾驶员培训机构。\r\n\r\n“最透明的价格，最优质的服务”天城驾校把这一条作为自己的使命宣言。在实际的工作中，驾校在经过物价局核准的收费标准中，根据学员的不同服务要求，制订出不用的收费标准，以适应市场的状况。“学员第一，快乐学车”是每个天城员工进入驾校第一次培训时的要求，驾校的衣食父母是学员，任何人都必须以学员为中心，没有任何借口来做服务不周的解释。\r\n\r\n天城驾校注重自己的品牌，因为天城人深知品牌就是驾校的生命。品牌的创造靠的是为学员提供实实在在的服务，只有做到阳光驾培，让消费者明明白白，天城的品牌才能有其强大的生命力。\r\n\r\n虽然我们在工作中取得了一定的成绩，但是距离我们工作目标还相差甚远，我们将不断努力是天城驾校继续大步前进。','31','383','3234'),('42','九州驾校','杭州九州机动车驾驶员培训有限公司','城北 丁桥','','杭州九洲机动车驾驶员培训有限公司是经过杭州市公安局、杭州市机动车服务管理局批准成立的专业汽车驾驶培训机构，培训实行理科、术科一步到位。本公司拥有全新的小型车（C1型）、封闭式的教练场（1万平方米），本驾校选址环境幽雅，依山傍水，空气清晰，并拥有与休闲学驾相协调的配套设施（配有学员休息室、茶室、食堂等设施），为每个学员学驾期间提供舒心和便捷服务。\r\n公司拥有城东和城北（丁桥）两处上万平方米标准的和考试项目齐全的训练场地，并配置了全新的车辆及教学设备，使每个学员都能在封闭场地内完成所有考试项目的训练；公司拥有一支训练有素的教练员队伍。可根据每个学员的不同特点因材施教，为确保每个学员顺利通过考试奠定了坚实的基础。公司建立了一整套规章制度，要求每个员工严格自律、廉洁执教；公司坚持合理收费，明码标价以保障学员利益。\r\n1、为学员免费代办一切学车手续，实行一条龙服务模式：学员报名交费后，由驾校派人陪同学员体检，体检合格后，根据学员住址，以就近原则，安排理科学车10天（白天、晚上均可）。\r\n2、上车学车期间（封闭式教练场内）为学员代订午餐。\r\n3、体检与上车训练时由公司派车接送。','31','383','3234'),('43','五环驾驶','杭州五环驾驶员培训有限公司','远大花园长坂巷9－1号','','    五环驾校位于杭州拱墅区远大花园长坂巷9－1号，环境优美交通便利，有多路车可以到达。\r\n    五环驾校欢迎您的到来！\r\n ','31','383','3232'),('44','友谊驾校','杭州友谊机动车驾驶员培训有限公司','古墩路杭州车管所西侧','','杭州友谊驾驶培训学校(友谊驾校)是为机关干部职工和为社会提供学车便利而创建的师资力量和硬件设备,管理培训一流的专业驾驶培训学校.校址位于杭州市公安局车辆管理所西侧,学车\\办理证照\\上牌等各种驾驶员和车辆事务均十分便捷。\r\n\r\n友谊驾校拥有近万平方米的教学场地，设有圆饼路、单边桥、S形路等完善设备设施，能模拟各种路况，有效帮助新手上路前积累处理各种突发情况的经验。学校所有车辆均为全新桑塔钠教练车，精选教练，特别注重教练的人品素质，管理严格，确保培训质量水平，以“服务学员、学员至上”为办校理念，绝不容许吃、卡、拿、要现象出现。\r\n\r\n友谊驾校——您的车上生活从此起步！\r\n\r\n友谊驾校特色服务： \r\n\r\n1、简化报名手续，学员可网上报名，实行体检、理科术训、考试一条龙服务。\r\n\r\n2、可根据学员自身情况灵活安排训练时间。\r\n\r\n3、提供夜间灯光场地训练。\r\n\r\n4、学员上车接送。\r\n','31','383','3229'),('45','快时驾校','杭州快时机动车驾驶员培训有限公司','杭州市七堡、龙居山','','杭州快时达机动车驾驶员培训有限公司(快时达驾校)是一家二级资质的机动车驾驶员培训有限责任公司。\r\n快时达驾校严格执行省公安厅、交通厅的规定，教学设施齐全，配备全新桑塔纳教练车，驾校场地宽敞，设有圆饼路、单边桥、S型路等规定考试项目。实行体检、理科、术科一条龙服务，教学时间灵活，可预约调整。驾校建立制定了一套的教练员管理、教练规则考核、场务管理、廉洁自律等规章制度。\r\n\r\n快时达驾校特别在注重教练员的业务素质和职业道德上不断进行完善、改进，为学员提供优质的服务。提高学员的满意率和考核率。学校操作规范、培训严格，能增强学员从容面对道路考试，公司承诺除学员所缴纳及代收费用外，不再产生任何费用。\r\n','31','383','3234'),('46','城北驾校','杭州城北机动车驾驶员培训有限公司','北大桥拱墅交警大队旁（景苑路30号）','','城北驾校地处市中心，北大桥拱墅交警大队旁（景苑路30号）城市执法局对面，拥有较大规模配套，设施齐全训练场，环境幽雅，交通便利，立体式的训练场地，一流的服务是您理想的培训基地。\r\n\r\n\r\n    城北驾校自建校至今，始终坚持严格管理、廉洁施教的原则，精心组织教学训练，确保培训质量。在同行业中具有较高的知名度和良好的社会声誉。\r\n\r\n\r\n    凡在校学车者同时代办驾驶证转户等事宜。','31','383','3232'),('47','东胜驾校','杭州东胜汽车驾驶员培训有限公司','江干区景西路','','  杭州东胜汽车驾驶员培训滨江分部地处滨江区东信大道和南环路的交叉点，距铁路桥洞20米，交通方便。\r\n\r\n\r\n    东胜驾校在3500平方米的训练场内置有单边桥，圆饼路，曲线路，侧方停车，直角转弯，定点停车等设施。\r\n\r\n\r\n    东胜驾校以科学管理和按教学大纲培训，提倡理论与实际相结合，注重学员的实际驾驶技能训练，为确保培训质量，东胜驾校与教练员签定教学责任书，严把教学质量和安全廉洁关。\r\n ','31','383','3234'),('48','昌盛驾校','杭州昌盛汽车驾驶培训有限公司','转塘镇江口村','','杭州转塘昌盛驾校成立于1978年，面向社会招生。驾校2009年经营管理全面改革，新的一年里以科学、严谨的教学态度，规范细致的教学手段，抱着诚信服务、廉洁施教的教学宗旨，向社会输送了合格驾驶人才。2009年公司坚持面向市场，服务社会的宗旨，不断加强廉政教育和提高培训质量公司拥有桑塔纳教练车38辆，教练员42余名','31','383','3229'),('49','广大驾校','杭州广大汽车驾驶员培训有限公司','机场路一巷71号','下沙路88号（下沙一号路口）\r\n三墩三联村\r\n北部软件园（76路公交总站）\r\n转塘区杭天路8号（梦湖山庄后面）','杭州广大驾校是由全公司直营教练车辆组成的省十佳驾校，也是杭州市区唯一的优秀示范驾校,并荣获质量信用考核“优胜单位”的称号。\r\n\r\n现广大驾校所有车辆均安装了GPS全球定位系统，实现车辆定位、超速报警、盗窃报警、疲劳报警、报表统计等各种管理功能，使驾校在整个车辆管理提前进入了现代化科技化管理，有效地解决了驾驶培训企业的核心安全问题. 并有效避免不按规定线路及场地训练等管理作用。\r\n\r\n广大驾校有经公安交通部门批准的杭城所有经典教练路线。公司对教练队伍实行严格的纪律考核，严禁教练工作中的不正之风。学员在学车中若对教练有意见，驾校可随时更换教练，以满足学员的要求。\r\n\r\n','31','383','3229'),('50','交通技工驾校','杭州交通高级技工学校机动车驾驶员培训中心杭州分中心','桐君街道濮家庄村坞泥口','','杭州交通高级技工学校机动车驾驶员培训中心是本省最早从事汽车（驾驶类）专业培训的学校。\r\n\r\n驾培中心拥有各类教练车125辆，有全省最大，占地5万余平方米的封闭式训练场，训练场教学设施一应俱全。训练场内建有山区道路、平面交叉、交式互通、陡坡急弯为一体总长达7公里的训练路段，能满足各个阶段汽车驾驶训练的需要。通过训练，可让学员掌握全面的汽车驾驶技术','31','383','3231'),('51','梦之岛驾校','杭州梦之岛机动车驾驶员培训中心','西湖区麦岭沙村608号','','\r\n    梦之岛驾校地理位置优越，对学员提供免费住宿，实行从报名、考试、办证一条龙的服务，欢迎广大学车爱好者前来报名！','31','383','3229'),('52','公交驾校','杭州市公交电车公司驾驶员培训站','莫干山路582号','','','31','383','3232'),('53','之江驾校','杭州之江机动车驾驶员培训中心','杭州余杭区乔司镇三角村','杭州之江机动车驾驶员培训中心','之江驾校位于杭州余杭区乔司镇三角村，环境优美交通便利，有多路车可以到达。\r\n\r\n    经营许可证号：330101J00038\r\n    经营资质：驾培二类\r\n    经营项目：驾培(汽车驾驶员培训)\r\n    之江驾校欢迎您的到来！','31','383','3236'),('54','浙邮驾校','临安浙邮机动车驾驶员培训有限公司','临安市于潜镇阳路306号','','    浙邮驾校位于临安市于潜镇阳路306号，环境优美交通便利，有多路车可以到达。\r\n\r\n    经营许可证号：330185J00003\r\n    经营资质：驾培二类\r\n    经营项目：驾培(汽车驾驶员培训)\r\n    浙邮驾校欢迎您的到来！\r\n \r\n','31','383','3240');
/*!40000 ALTER TABLE `uchome_school` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_session`;
CREATE TABLE `uchome_session` (
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` char(15) NOT NULL default '',
  `password` char(32) NOT NULL default '',
  `lastactivity` int(10) unsigned NOT NULL default '0',
  `ip` int(10) unsigned NOT NULL default '0',
  `magichidden` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`uid`),
  KEY `lastactivity` (`lastactivity`),
  KEY `ip` (`ip`)
) ENGINE=HEAP DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_session` DISABLE KEYS */;
INSERT INTO `uchome_session` VALUES ('2','majin','a4723c697c1ec3e9206290a72ff5e50c','1306277151','222082253','0'),('1','admin','573a87daa1ab67464820205977de254a','1306276182','192168001','0');
/*!40000 ALTER TABLE `uchome_session` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_share`;
CREATE TABLE `uchome_share` (
  `sid` mediumint(8) unsigned NOT NULL auto_increment,
  `topicid` mediumint(8) unsigned NOT NULL default '0',
  `type` varchar(30) NOT NULL default '',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(15) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  `title_template` text NOT NULL,
  `body_template` text NOT NULL,
  `body_data` text NOT NULL,
  `body_general` text NOT NULL,
  `image` varchar(255) NOT NULL default '',
  `image_link` varchar(255) NOT NULL default '',
  `hot` mediumint(8) unsigned NOT NULL default '0',
  `hotuser` text NOT NULL,
  PRIMARY KEY  (`sid`),
  KEY `uid` (`uid`,`dateline`),
  KEY `topicid` (`topicid`,`dateline`),
  KEY `hot` (`hot`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_share` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_share` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_show`;
CREATE TABLE `uchome_show` (
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(15) NOT NULL default '',
  `credit` int(10) unsigned NOT NULL default '0',
  `note` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`uid`),
  KEY `credit` (`credit`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_show` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_show` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_space`;
CREATE TABLE `uchome_space` (
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `groupid` smallint(6) unsigned NOT NULL default '0',
  `credit` int(10) NOT NULL default '0',
  `experience` int(10) NOT NULL default '0',
  `username` char(15) NOT NULL default '',
  `name` char(20) NOT NULL default '',
  `namestatus` tinyint(1) NOT NULL default '0',
  `videostatus` tinyint(1) NOT NULL default '0',
  `domain` char(15) NOT NULL default '',
  `friendnum` int(10) unsigned NOT NULL default '0',
  `viewnum` int(10) unsigned NOT NULL default '0',
  `notenum` int(10) unsigned NOT NULL default '0',
  `addfriendnum` smallint(6) unsigned NOT NULL default '0',
  `mtaginvitenum` smallint(6) unsigned NOT NULL default '0',
  `eventinvitenum` smallint(6) unsigned NOT NULL default '0',
  `myinvitenum` smallint(6) unsigned NOT NULL default '0',
  `pokenum` smallint(6) unsigned NOT NULL default '0',
  `doingnum` smallint(6) unsigned NOT NULL default '0',
  `blognum` smallint(6) unsigned NOT NULL default '0',
  `albumnum` smallint(6) unsigned NOT NULL default '0',
  `threadnum` smallint(6) unsigned NOT NULL default '0',
  `pollnum` smallint(6) unsigned NOT NULL default '0',
  `eventnum` smallint(6) unsigned NOT NULL default '0',
  `sharenum` smallint(6) unsigned NOT NULL default '0',
  `dateline` int(10) unsigned NOT NULL default '0',
  `updatetime` int(10) unsigned NOT NULL default '0',
  `lastsearch` int(10) unsigned NOT NULL default '0',
  `lastpost` int(10) unsigned NOT NULL default '0',
  `lastlogin` int(10) unsigned NOT NULL default '0',
  `lastsend` int(10) unsigned NOT NULL default '0',
  `attachsize` int(10) unsigned NOT NULL default '0',
  `addsize` int(10) unsigned NOT NULL default '0',
  `addfriend` smallint(6) unsigned NOT NULL default '0',
  `flag` tinyint(1) NOT NULL default '0',
  `newpm` smallint(6) unsigned NOT NULL default '0',
  `avatar` tinyint(1) NOT NULL default '0',
  `regip` char(15) NOT NULL default '',
  `ip` int(10) unsigned NOT NULL default '0',
  `mood` smallint(6) unsigned NOT NULL default '0',
  PRIMARY KEY  (`uid`),
  KEY `username` (`username`),
  KEY `domain` (`domain`),
  KEY `ip` (`ip`),
  KEY `updatetime` (`updatetime`),
  KEY `mood` (`mood`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_space` DISABLE KEYS */;
INSERT INTO `uchome_space` VALUES ('1','1','194','184','admin','','0','0','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','1304876645','1305291805','0','0','1306273630','0','0','0','0','1','0','0','192.168.1.101','192168001','0'),('2','5','72','84','majin','','0','0','','0','2','0','0','0','0','0','0','0','0','1','1','0','0','0','1305286491','1306276964','0','1305994851','1306276192','0','4624','0','0','0','0','0','115.238.43.169','222082253','0'),('3','5','44','34','hz123','','0','0','','0','0','0','0','0','0','0','0','1','0','0','0','0','0','0','1305287212','1306015872','0','1306015872','1306015820','0','0','0','0','0','0','0','218.72.21.217','60176180','12'),('4','5','49','39','maj','','0','0','','0','0','0','0','0','0','0','0','0','1','0','0','0','0','0','1306168645','1306273942','0','1306273942','1306276012','0','0','0','0','0','0','0','222.82.253.154','222082253','0');
/*!40000 ALTER TABLE `uchome_space` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_spacefield`;
CREATE TABLE `uchome_spacefield` (
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `sex` tinyint(1) NOT NULL default '0',
  `email` varchar(100) NOT NULL default '',
  `newemail` varchar(100) NOT NULL default '',
  `emailcheck` tinyint(1) NOT NULL default '0',
  `mobile` varchar(40) NOT NULL default '',
  `qq` varchar(20) NOT NULL default '',
  `msn` varchar(80) NOT NULL default '',
  `msnrobot` varchar(15) NOT NULL default '',
  `msncstatus` tinyint(1) NOT NULL default '0',
  `videopic` varchar(32) NOT NULL default '',
  `birthyear` smallint(6) unsigned NOT NULL default '0',
  `birthmonth` tinyint(3) unsigned NOT NULL default '0',
  `birthday` tinyint(3) unsigned NOT NULL default '0',
  `blood` varchar(5) NOT NULL default '',
  `marry` tinyint(1) NOT NULL default '0',
  `birthprovince` varchar(20) NOT NULL default '',
  `birthcity` varchar(20) NOT NULL default '',
  `resideprovince` varchar(20) NOT NULL default '',
  `residecity` varchar(20) NOT NULL default '',
  `note` text NOT NULL,
  `spacenote` text NOT NULL,
  `authstr` varchar(20) NOT NULL default '',
  `theme` varchar(20) NOT NULL default '',
  `nocss` tinyint(1) NOT NULL default '0',
  `menunum` smallint(6) unsigned NOT NULL default '0',
  `css` text NOT NULL,
  `privacy` text NOT NULL,
  `friend` mediumtext NOT NULL,
  `feedfriend` mediumtext NOT NULL,
  `sendmail` text NOT NULL,
  `magicstar` tinyint(1) NOT NULL default '0',
  `magicexpire` int(10) unsigned NOT NULL default '0',
  `timeoffset` varchar(20) NOT NULL default '',
  `car_role` tinyint(3) NOT NULL default '0',
  `car_number` varchar(10) NOT NULL default '',
  `car_brand` smallint(5) unsigned NOT NULL default '0',
  `car_model` smallint(5) unsigned NOT NULL default '0',
  `car_profile` smallint(5) unsigned NOT NULL default '0',
  `province_id` smallint(5) unsigned NOT NULL default '0',
  `city_id` smallint(5) unsigned NOT NULL default '0',
  `region_id` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_spacefield` DISABLE KEYS */;
INSERT INTO `uchome_spacefield` VALUES ('1','0','','','0','','','','','0','','0','0','0','','0','','','','','','','','','0','0','','','','','','0','0','','0','','0','0','0','0','0','0'),('2','0','devilmartin@163.com','','0','','','','','0','','0','0','0','','0','','','','','','','','','0','0','','','','','','0','0','','0','','0','0','0','0','0','0'),('3','0','hz8779@126.com','','0','','','','','0','','0','0','0','','0','','','','','<img src=\"image/face/12.gif\" class=\"face\">加速进度啊','<img src=\"image/face/12.gif\" class=\"face\">加速进度啊','','','0','0','','','','','','0','0','','0','','0','0','0','0','0','0'),('4','0','maj@163.com','','0','','','','','0','','0','0','0','','0','','','','','今天天气不错！','今天天气不错！','','','0','0','','','','','','0','0','','0','','0','0','0','0','0','0');
/*!40000 ALTER TABLE `uchome_spacefield` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_spaceinfo`;
CREATE TABLE `uchome_spaceinfo` (
  `infoid` mediumint(8) unsigned NOT NULL auto_increment,
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `type` varchar(20) NOT NULL default '',
  `subtype` varchar(20) NOT NULL default '',
  `title` text NOT NULL,
  `subtitle` varchar(255) NOT NULL default '',
  `friend` tinyint(1) NOT NULL default '0',
  `startyear` smallint(6) unsigned NOT NULL default '0',
  `endyear` smallint(6) unsigned NOT NULL default '0',
  `startmonth` smallint(6) unsigned NOT NULL default '0',
  `endmonth` smallint(6) unsigned NOT NULL default '0',
  PRIMARY KEY  (`infoid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_spaceinfo` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_spaceinfo` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_spacelog`;
CREATE TABLE `uchome_spacelog` (
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` char(15) NOT NULL default '',
  `opuid` mediumint(8) unsigned NOT NULL default '0',
  `opusername` char(15) NOT NULL default '',
  `flag` tinyint(1) NOT NULL default '0',
  `expiration` int(10) unsigned NOT NULL default '0',
  `dateline` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`uid`),
  KEY `flag` (`flag`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_spacelog` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_spacelog` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_stat`;
CREATE TABLE `uchome_stat` (
  `daytime` int(10) unsigned NOT NULL default '0',
  `login` smallint(6) unsigned NOT NULL default '0',
  `register` smallint(6) unsigned NOT NULL default '0',
  `invite` smallint(6) unsigned NOT NULL default '0',
  `appinvite` smallint(6) unsigned NOT NULL default '0',
  `doing` smallint(6) unsigned NOT NULL default '0',
  `blog` smallint(6) unsigned NOT NULL default '0',
  `pic` smallint(6) unsigned NOT NULL default '0',
  `poll` smallint(6) unsigned NOT NULL default '0',
  `event` smallint(6) unsigned NOT NULL default '0',
  `share` smallint(6) unsigned NOT NULL default '0',
  `thread` smallint(6) unsigned NOT NULL default '0',
  `docomment` smallint(6) unsigned NOT NULL default '0',
  `blogcomment` smallint(6) unsigned NOT NULL default '0',
  `piccomment` smallint(6) unsigned NOT NULL default '0',
  `pollcomment` smallint(6) unsigned NOT NULL default '0',
  `pollvote` smallint(6) unsigned NOT NULL default '0',
  `eventcomment` smallint(6) unsigned NOT NULL default '0',
  `eventjoin` smallint(6) unsigned NOT NULL default '0',
  `sharecomment` smallint(6) unsigned NOT NULL default '0',
  `post` smallint(6) unsigned NOT NULL default '0',
  `wall` smallint(6) unsigned NOT NULL default '0',
  `poke` smallint(6) unsigned NOT NULL default '0',
  `click` smallint(6) unsigned NOT NULL default '0',
  PRIMARY KEY  (`daytime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_stat` DISABLE KEYS */;
INSERT INTO `uchome_stat` VALUES ('20110509','1','1','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),('20110513','3','2','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0'),('20110522','2','0','0','0','1','0','0','0','0','0','1','0','0','0','0','0','0','0','0','0','0','0','0'),('20110524','4','1','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','1'),('20110525','2','0','0','0','1','1','1','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
/*!40000 ALTER TABLE `uchome_stat` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_statuser`;
CREATE TABLE `uchome_statuser` (
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `daytime` int(10) unsigned NOT NULL default '0',
  `type` char(20) NOT NULL default '',
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_statuser` DISABLE KEYS */;
INSERT INTO `uchome_statuser` VALUES ('4','0','login'),('2','0','login');
/*!40000 ALTER TABLE `uchome_statuser` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_tag`;
CREATE TABLE `uchome_tag` (
  `tagid` mediumint(8) unsigned NOT NULL auto_increment,
  `tagname` char(30) NOT NULL default '',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `dateline` int(10) unsigned NOT NULL default '0',
  `blognum` smallint(6) unsigned NOT NULL default '0',
  `close` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`tagid`),
  KEY `tagname` (`tagname`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_tag` DISABLE KEYS */;
INSERT INTO `uchome_tag` VALUES ('1','hello','4','1306273897','1','0');
/*!40000 ALTER TABLE `uchome_tag` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_tagblog`;
CREATE TABLE `uchome_tagblog` (
  `tagid` mediumint(8) unsigned NOT NULL default '0',
  `blogid` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`tagid`,`blogid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_tagblog` DISABLE KEYS */;
INSERT INTO `uchome_tagblog` VALUES ('1','1');
/*!40000 ALTER TABLE `uchome_tagblog` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_tagspace`;
CREATE TABLE `uchome_tagspace` (
  `tagid` mediumint(8) unsigned NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` char(15) NOT NULL default '',
  `grade` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`tagid`,`uid`),
  KEY `grade` (`tagid`,`grade`),
  KEY `uid` (`uid`,`grade`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_tagspace` DISABLE KEYS */;
INSERT INTO `uchome_tagspace` VALUES ('1','2','majin','9'),('1','1','admin','0'),('2','1','admin','9'),('1','4','maj','0'),('2','2','majin','0');
/*!40000 ALTER TABLE `uchome_tagspace` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_task`;
CREATE TABLE `uchome_task` (
  `taskid` smallint(6) unsigned NOT NULL auto_increment,
  `available` tinyint(1) NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  `note` text NOT NULL,
  `num` mediumint(8) unsigned NOT NULL default '0',
  `maxnum` mediumint(8) unsigned NOT NULL default '0',
  `image` varchar(150) NOT NULL default '',
  `filename` varchar(50) NOT NULL default '',
  `starttime` int(10) unsigned NOT NULL default '0',
  `endtime` int(10) unsigned NOT NULL default '0',
  `nexttime` int(10) unsigned NOT NULL default '0',
  `nexttype` varchar(20) NOT NULL default '',
  `credit` smallint(6) NOT NULL default '0',
  `displayorder` smallint(6) unsigned NOT NULL default '0',
  PRIMARY KEY  (`taskid`),
  KEY `displayorder` (`displayorder`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_task` DISABLE KEYS */;
INSERT INTO `uchome_task` VALUES ('1','1','更新一下自己的头像','头像就是你在这里的个人形象。<br>设置自己的头像后，会让更多的朋友记住您。','0','0','image/task/avatar.gif','avatar.php','0','0','0','','20','1'),('2','1','将个人资料补充完整','把自己的个人资料填写完整吧。<br>这样您会被更多的朋友找到的，系统也会帮您找到朋友。','0','0','image/task/profile.gif','profile.php','0','0','0','2','20','0'),('3','1','发表自己的第一篇日志','现在，就写下自己的第一篇日志吧。<br>与大家一起分享自己的生活感悟。','0','0','image/task/blog.gif','blog.php','0','0','0','','5','3'),('4','1','寻找并添加五位好友','有了好友，您发的日志、图片等会被好友及时看到并传播出去；<br>您也会在首页方便及时的看到好友的最新动态。','0','0','image/task/friend.gif','friend.php','0','0','0','','50','4'),('5','1','验证激活自己的邮箱','填写自己真实的邮箱地址并验证通过。<br>您可以在忘记密码的时候使用该邮箱取回自己的密码；<br>还可以及时接受站内的好友通知等等。','0','0','image/task/email.gif','email.php','0','0','0','','10','5'),('6','1','邀请10个新朋友加入','邀请一下自己的QQ好友或者邮箱联系人，让亲朋好友一起来加入我们吧。','0','0','image/task/friend.gif','invite.php','0','0','0','','100','6'),('7','1','领取每日访问大礼包','每天登录访问自己的主页，就可领取大礼包。','0','0','image/task/gift.gif','gift.php','0','0','0','day','5','99');
/*!40000 ALTER TABLE `uchome_task` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_thread`;
CREATE TABLE `uchome_thread` (
  `tid` mediumint(8) unsigned NOT NULL auto_increment,
  `topicid` mediumint(8) unsigned NOT NULL default '0',
  `tagid` mediumint(8) unsigned NOT NULL default '0',
  `eventid` mediumint(8) unsigned NOT NULL default '0',
  `subject` char(80) NOT NULL default '',
  `magiccolor` tinyint(6) unsigned NOT NULL default '0',
  `magicegg` tinyint(6) unsigned NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` char(15) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  `viewnum` mediumint(8) unsigned NOT NULL default '0',
  `replynum` mediumint(8) unsigned NOT NULL default '0',
  `lastpost` int(10) unsigned NOT NULL default '0',
  `lastauthor` char(15) NOT NULL default '',
  `lastauthorid` mediumint(8) unsigned NOT NULL default '0',
  `displayorder` tinyint(1) unsigned NOT NULL default '0',
  `digest` tinyint(1) NOT NULL default '0',
  `hot` mediumint(8) unsigned NOT NULL default '0',
  `click_11` smallint(6) unsigned NOT NULL default '0',
  `click_12` smallint(6) unsigned NOT NULL default '0',
  `click_13` smallint(6) unsigned NOT NULL default '0',
  `click_14` smallint(6) unsigned NOT NULL default '0',
  `click_15` smallint(6) unsigned NOT NULL default '0',
  PRIMARY KEY  (`tid`),
  KEY `tagid` (`tagid`,`displayorder`,`lastpost`),
  KEY `uid` (`uid`,`lastpost`),
  KEY `lastpost` (`lastpost`),
  KEY `topicid` (`topicid`,`dateline`),
  KEY `eventid` (`eventid`,`lastpost`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_thread` DISABLE KEYS */;
INSERT INTO `uchome_thread` VALUES ('1','0','1','0','感觉少了点什么','0','0','2','majin','1305994851','1','0','1305994851','majin','2','0','0','1','0','0','0','1','0');
/*!40000 ALTER TABLE `uchome_thread` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_topic`;
CREATE TABLE `uchome_topic` (
  `topicid` mediumint(8) unsigned NOT NULL auto_increment,
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(15) NOT NULL default '',
  `subject` varchar(80) NOT NULL default '',
  `message` mediumtext NOT NULL,
  `jointype` varchar(255) NOT NULL default '',
  `joingid` varchar(255) NOT NULL default '',
  `pic` varchar(100) NOT NULL default '',
  `thumb` tinyint(1) NOT NULL default '0',
  `remote` tinyint(1) NOT NULL default '0',
  `joinnum` mediumint(8) unsigned NOT NULL default '0',
  `lastpost` int(10) unsigned NOT NULL default '0',
  `dateline` int(10) unsigned NOT NULL default '0',
  `endtime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`topicid`),
  KEY `lastpost` (`lastpost`),
  KEY `joinnum` (`joinnum`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_topic` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_topic` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_topicuser`;
CREATE TABLE `uchome_topicuser` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `topicid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(15) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`,`dateline`),
  KEY `topicid` (`topicid`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_topicuser` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_topicuser` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_userapp`;
CREATE TABLE `uchome_userapp` (
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `appid` mediumint(8) unsigned NOT NULL default '0',
  `appname` varchar(60) NOT NULL default '',
  `privacy` tinyint(1) NOT NULL default '0',
  `allowsidenav` tinyint(1) NOT NULL default '0',
  `allowfeed` tinyint(1) NOT NULL default '0',
  `allowprofilelink` tinyint(1) NOT NULL default '0',
  `narrow` tinyint(1) NOT NULL default '0',
  `menuorder` smallint(6) NOT NULL default '0',
  `displayorder` smallint(6) NOT NULL default '0',
  KEY `uid` (`uid`,`appid`),
  KEY `menuorder` (`uid`,`menuorder`),
  KEY `displayorder` (`uid`,`displayorder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_userapp` DISABLE KEYS */;
INSERT INTO `uchome_userapp` VALUES ('1','1058035','汽车工厂','0','1','1','1','0','0','0'),('1','1003094','争车位','0','1','1','1','0','0','0'),('1','1005122','德克萨斯扑克','0','1','1','1','1','0','0');
/*!40000 ALTER TABLE `uchome_userapp` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_userappfield`;
CREATE TABLE `uchome_userappfield` (
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `appid` mediumint(8) unsigned NOT NULL default '0',
  `profilelink` text NOT NULL,
  `myml` text NOT NULL,
  KEY `uid` (`uid`,`appid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_userappfield` DISABLE KEYS */;
INSERT INTO `uchome_userappfield` VALUES ('1','1058035','',''),('1','1003094','','echo \"<div class=\\\"box_content\\\"><div class=\\\"app_content_1003094\\\"><div>\";echo \'把你的车停到好友的私家车位赚更多的钱\';\necho \"</div></div></div>\";'),('1','1005122','','');
/*!40000 ALTER TABLE `uchome_userappfield` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_userevent`;
CREATE TABLE `uchome_userevent` (
  `eventid` mediumint(8) unsigned NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(15) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  `status` tinyint(4) NOT NULL default '0',
  `fellow` mediumint(8) unsigned NOT NULL default '0',
  `template` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`eventid`,`uid`),
  KEY `uid` (`uid`,`dateline`),
  KEY `eventid` (`eventid`,`status`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_userevent` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_userevent` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_usergroup`;
CREATE TABLE `uchome_usergroup` (
  `gid` smallint(6) unsigned NOT NULL auto_increment,
  `grouptitle` varchar(20) NOT NULL default '',
  `system` tinyint(1) NOT NULL default '0',
  `banvisit` tinyint(1) NOT NULL default '0',
  `explower` int(10) NOT NULL default '0',
  `maxfriendnum` smallint(6) unsigned NOT NULL default '0',
  `maxattachsize` int(10) unsigned NOT NULL default '0',
  `allowhtml` tinyint(1) NOT NULL default '0',
  `allowcomment` tinyint(1) NOT NULL default '0',
  `searchinterval` smallint(6) unsigned NOT NULL default '0',
  `searchignore` tinyint(1) NOT NULL default '0',
  `postinterval` smallint(6) unsigned NOT NULL default '0',
  `spamignore` tinyint(1) NOT NULL default '0',
  `videophotoignore` tinyint(1) NOT NULL default '0',
  `allowblog` tinyint(1) NOT NULL default '0',
  `allowdoing` tinyint(1) NOT NULL default '0',
  `allowupload` tinyint(1) NOT NULL default '0',
  `allowshare` tinyint(1) NOT NULL default '0',
  `allowmtag` tinyint(1) NOT NULL default '0',
  `allowthread` tinyint(1) NOT NULL default '0',
  `allowpost` tinyint(1) NOT NULL default '0',
  `allowcss` tinyint(1) NOT NULL default '0',
  `allowpoke` tinyint(1) NOT NULL default '0',
  `allowfriend` tinyint(1) NOT NULL default '0',
  `allowpoll` tinyint(1) NOT NULL default '0',
  `allowclick` tinyint(1) NOT NULL default '0',
  `allowevent` tinyint(1) NOT NULL default '0',
  `allowmagic` tinyint(1) NOT NULL default '0',
  `allowpm` tinyint(1) NOT NULL default '0',
  `allowviewvideopic` tinyint(1) NOT NULL default '0',
  `allowmyop` tinyint(1) NOT NULL default '0',
  `allowtopic` tinyint(1) NOT NULL default '0',
  `allowstat` tinyint(1) NOT NULL default '0',
  `magicdiscount` tinyint(1) NOT NULL default '0',
  `verifyevent` tinyint(1) NOT NULL default '0',
  `edittrail` tinyint(1) NOT NULL default '0',
  `domainlength` smallint(6) unsigned NOT NULL default '0',
  `closeignore` tinyint(1) NOT NULL default '0',
  `seccode` tinyint(1) NOT NULL default '0',
  `color` varchar(10) NOT NULL default '',
  `icon` varchar(100) NOT NULL default '',
  `manageconfig` tinyint(1) NOT NULL default '0',
  `managenetwork` tinyint(1) NOT NULL default '0',
  `manageprofilefield` tinyint(1) NOT NULL default '0',
  `manageprofield` tinyint(1) NOT NULL default '0',
  `manageusergroup` tinyint(1) NOT NULL default '0',
  `managefeed` tinyint(1) NOT NULL default '0',
  `manageshare` tinyint(1) NOT NULL default '0',
  `managedoing` tinyint(1) NOT NULL default '0',
  `manageblog` tinyint(1) NOT NULL default '0',
  `managetag` tinyint(1) NOT NULL default '0',
  `managetagtpl` tinyint(1) NOT NULL default '0',
  `managealbum` tinyint(1) NOT NULL default '0',
  `managecomment` tinyint(1) NOT NULL default '0',
  `managemtag` tinyint(1) NOT NULL default '0',
  `managethread` tinyint(1) NOT NULL default '0',
  `manageevent` tinyint(1) NOT NULL default '0',
  `manageeventclass` tinyint(1) NOT NULL default '0',
  `managecensor` tinyint(1) NOT NULL default '0',
  `managead` tinyint(1) NOT NULL default '0',
  `managesitefeed` tinyint(1) NOT NULL default '0',
  `managebackup` tinyint(1) NOT NULL default '0',
  `manageblock` tinyint(1) NOT NULL default '0',
  `managetemplate` tinyint(1) NOT NULL default '0',
  `managestat` tinyint(1) NOT NULL default '0',
  `managecache` tinyint(1) NOT NULL default '0',
  `managecredit` tinyint(1) NOT NULL default '0',
  `managecron` tinyint(1) NOT NULL default '0',
  `managename` tinyint(1) NOT NULL default '0',
  `manageapp` tinyint(1) NOT NULL default '0',
  `managetask` tinyint(1) NOT NULL default '0',
  `managereport` tinyint(1) NOT NULL default '0',
  `managepoll` tinyint(1) NOT NULL default '0',
  `manageclick` tinyint(1) NOT NULL default '0',
  `managemagic` tinyint(1) NOT NULL default '0',
  `managemagiclog` tinyint(1) NOT NULL default '0',
  `managebatch` tinyint(1) NOT NULL default '0',
  `managedelspace` tinyint(1) NOT NULL default '0',
  `managetopic` tinyint(1) NOT NULL default '0',
  `manageip` tinyint(1) NOT NULL default '0',
  `managehotuser` tinyint(1) NOT NULL default '0',
  `managedefaultuser` tinyint(1) NOT NULL default '0',
  `managespacegroup` tinyint(1) NOT NULL default '0',
  `managespaceinfo` tinyint(1) NOT NULL default '0',
  `managespacecredit` tinyint(1) NOT NULL default '0',
  `managespacenote` tinyint(1) NOT NULL default '0',
  `managevideophoto` tinyint(1) NOT NULL default '0',
  `managelog` tinyint(1) NOT NULL default '0',
  `magicaward` text NOT NULL,
  PRIMARY KEY  (`gid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_usergroup` DISABLE KEYS */;
INSERT INTO `uchome_usergroup` VALUES ('1','站点管理员','-1','0','0','0','0','1','1','0','1','0','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','0','0','0','1','1','0','red','image/group/admin.gif','1','1','1','1','1','1','1','1','1','1','0','1','1','1','1','1','1','1','1','0','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1',''),('2','信息管理员','-1','0','0','0','0','1','1','0','1','0','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','0','0','0','3','1','0','blue','image/group/infor.gif','0','0','0','0','0','1','1','1','1','1','0','1','1','1','1','1','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','1','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0',''),('3','贵宾VIP','1','0','0','0','0','1','1','0','1','0','1','0','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','0','0','0','0','0','3','0','0','green','image/group/vip.gif','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0',''),('4','受限会员','0','0','-999999999','10','10','0','0','600','0','300','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','1','0','0','0','1','','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0',''),('5','普通会员','0','0','0','100','20','0','1','60','0','60','0','0','1','1','1','1','1','1','1','0','1','1','1','1','1','1','1','0','1','0','0','0','0','0','0','0','0','','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0',''),('6','中级会员','0','0','100','200','50','0','1','30','0','30','0','0','1','1','1','1','1','1','1','0','1','1','1','1','1','1','1','0','1','0','0','0','0','0','5','0','0','','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0',''),('7','高级会员','0','0','1000','300','100','1','1','10','1','10','0','0','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','0','1','0','0','0','0','0','3','0','0','','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0',''),('8','禁止发言','-1','0','0','1','1','0','0','9999','0','9999','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','1','0','99','0','1','','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0',''),('9','禁止访问','-1','1','0','1','1','0','0','9999','0','9999','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','1','0','99','0','1','','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','');
/*!40000 ALTER TABLE `uchome_usergroup` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_userlog`;
CREATE TABLE `uchome_userlog` (
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `action` char(10) NOT NULL default '',
  `type` tinyint(1) NOT NULL default '0',
  `dateline` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_userlog` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_userlog` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_usermagic`;
CREATE TABLE `uchome_usermagic` (
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(15) NOT NULL default '',
  `mid` varchar(15) NOT NULL default '',
  `count` smallint(6) unsigned NOT NULL default '0',
  PRIMARY KEY  (`uid`,`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_usermagic` DISABLE KEYS */;
INSERT INTO `uchome_usermagic` VALUES ('2','majin','gift','1');
/*!40000 ALTER TABLE `uchome_usermagic` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_usertask`;
CREATE TABLE `uchome_usertask` (
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` char(15) NOT NULL default '',
  `taskid` smallint(6) unsigned NOT NULL default '0',
  `credit` smallint(6) NOT NULL default '0',
  `dateline` int(10) unsigned NOT NULL default '0',
  `isignore` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`uid`,`taskid`),
  KEY `isignore` (`isignore`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_usertask` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_usertask` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_visitor`;
CREATE TABLE `uchome_visitor` (
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `vuid` mediumint(8) unsigned NOT NULL default '0',
  `vusername` char(15) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`uid`,`vuid`),
  KEY `dateline` (`uid`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `uchome_visitor` DISABLE KEYS */;
INSERT INTO `uchome_visitor` VALUES ('2','3','hz123','1305287318');
/*!40000 ALTER TABLE `uchome_visitor` ENABLE KEYS */;

DROP TABLE IF EXISTS `uchome_vote`;
CREATE TABLE `uchome_vote` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `school_id` int(11) unsigned NOT NULL default '0',
  `vote_avg` decimal(3,1) unsigned NOT NULL default '0.0',
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

/*!40000 ALTER TABLE `uchome_vote` DISABLE KEYS */;
/*!40000 ALTER TABLE `uchome_vote` ENABLE KEYS */;


-- phpMiniAdmin dump end
