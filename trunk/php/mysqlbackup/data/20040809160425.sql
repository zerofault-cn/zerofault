# hotel 
# MySQL数据库备份与恢复系统　ver0.01
# Copyleft @ 2004 by 孙广智
# 主机名：localhost  数据库名：hotel
#---------------------------------------------------
#
# MySQL Server Version: 4.0.20-standard
#;
use hotel;
# 数据表　computer　的结构;
DROP TABLE IF EXISTS `computer`;
CREATE TABLE `computer` (
  `id` int(11) NOT NULL auto_increment,
  `hotel` varchar(50) NOT NULL default '',
  `computer` text NOT NULL,
  `about` text NOT NULL,
  `dd` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `hotel` (`hotel`)
) TYPE=MyISAM;
#
# 向表　computer　中插入数据;
#
insert into `computer` ( `id`,  `hotel`,  `computer`,  `about`,  `dd`) values ("1", "九洲", "主机80G", "重启时间：18：00", "2004-02-11 08:43:08");
insert into `computer` ( `id`,  `hotel`,  `computer`,  `about`,  `dd`) values ("2", "山水", "主机", "重启时间：08：30", "2004-02-11 08:44:53");
insert into `computer` ( `id`,  `hotel`,  `computer`,  `about`,  `dd`) values ("3", "四海", "主机", "重启时间：18：30", "2004-02-11 08:45:49");
insert into `computer` ( `id`,  `hotel`,  `computer`,  `about`,  `dd`) values ("4", "东城", "主机60G", "重启时间为18:00", "2004-02-11 16:28:02");
insert into `computer` ( `id`,  `hotel`,  `computer`,  `about`,  `dd`) values ("5", "和平", "电话：3338888", "无", "2004-02-19 15:03:27");
# 数据表　fix　的结构;
DROP TABLE IF EXISTS `fix`;
CREATE TABLE `fix` (
  `id` int(11) NOT NULL auto_increment,
  `hotel` varchar(20) NOT NULL default '',
  `problem` varchar(100) NOT NULL default '',
  `about` text NOT NULL,
  `mm` varchar(30) NOT NULL default '',
  `dd` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `hotel` (`hotel`)
) TYPE=MyISAM;
#
# 向表　fix　中插入数据;
#
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("1", "东城804", "主机电源开关失灵", "改由重启按钮开机", "2004-02", "2004-02-11 09:55:26");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("2", "东城901", "例行检查", "显示器变色,屏幕宽度调节失灵.末换.", "2004-02", "2004-02-11 16:46:35");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("3", "山水1006", "IP冲突", "-", "2004-02", "2004-02-13 08:46:23");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("4", "昆仑209", "乱码", "-", "2004-02", "2004-02-13 08:48:12");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("5", "昆仑210", "内存松", "-", "2004-02", "2004-02-13 08:48:39");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("6", "山水709", "IP冲突", "-", "2004-02", "2004-02-13 08:49:24");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("7", "山水1310", "网卡松", "网卡未上螺丝。", "2004-02", "2004-02-13 13:33:02");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("8", "山水718", "显示器按钮失灵", "打开显示器后用透明胶封住", "2004-02", "2004-02-13 16:08:31");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("9", "四海", "主机掉线", "-", "2004-02", "2004-02-19 15:15:48");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("10", "九洲522", "网线被拔出", "-", "2004-02", "2004-02-19 15:18:43");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("11", "山水1216", "没有声卡驱动", "-", "2004-02", "2004-02-19 15:20:10");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("12", "昆仑210", "系统死机", "-", "2004-02", "2004-02-19 15:23:14");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("13", "东城907", "网卡松", "-", "2004-02", "2004-02-19 15:23:46");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("14", "九洲807", "网卡松", "-", "2004-02", "2004-02-20 08:40:03");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("15", "昆仑304", "开机乱码", "-", "2004-02", "2004-02-20 08:40:51");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("16", "山水806", "开机乱码", "-", "2004-02", "2004-02-20 08:41:34");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("17", "四海910", "改主页", "-", "2004-02", "2004-02-20 08:42:56");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("18", "山水908", "IP冲突", "-", "2004-02", "2004-02-20 08:43:16");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("19", "山水908", "IP冲突", "-", "2004-02", "2004-02-20 08:43:43");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("20", "山水1416", "进不了系统", "些机有光驱，软驱，没网卡启动OK", "2004-02", "2004-02-20 08:46:31");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("21", "山水818", "死机", "-", "2004-02", "2004-02-20 08:47:21");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("22", "昆仑201", "去到没事", "-", "2004-02", "2004-02-20 08:49:44");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("23", "山水1205", "开机乱码", "-", "2004-02", "2004-02-20 08:50:09");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("24", "东城914", "网线水晶头被淋湿", "-", "2004-02", "2004-02-20 08:50:56");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("25", "大帝803", "IP冲突", "-", "2004-02", "2004-02-20 08:51:29");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("26", "四海1013", "没声音", "-", "2004-02", "2004-02-20 08:51:59");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("27", "九洲516", "没装声卡驱动", "-", "2004-02", "2004-02-20 08:52:35");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("28", "四海1116", "IP冲突死机", "-", "2004-02", "2004-02-20 08:53:16");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("29", "四海912", "不能上网", "-", "2004-02", "2004-02-20 08:53:42");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("30", "九龙东414", "客人不会上网", "-", "2004-02", "2004-02-20 08:54:12");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("31", "四海813", "音箱没有插喇叭线", "-", "2004-02", "2004-02-20 08:58:24");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("32", "九龙西313", "网线松", "-", "2004-02", "2004-02-20 08:59:02");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("33", "山水1016", "IP冲突", "-", "2004-02", "2004-02-20 08:59:24");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("34", "九洲607", "网卡松", "-", "2004-02", "2004-02-20 08:59:50");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("35", "山水1402", "网线松", "-", "2004-02", "2004-02-20 09:00:19");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("36", "昆仑209", "无机", "重建", "2004-02", "2004-02-20 09:01:03");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("37", "东城919", "插座开关失灵网线松", "-", "2004-02", "2004-02-20 09:02:38");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("38", "大帝835", "死机", "入到桌面出现英文死机", "2004-02", "2004-02-20 09:03:57");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("39", "昆仑317", "开机开不了机", "-", "2004-02", "2004-02-20 09:04:46");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("40", "昆仑312", "音箱声音小", "-", "2004-02", "2004-02-20 09:05:23");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("41", "四海910", "显示器显示被调成色", "-", "2004-02", "2004-02-20 09:06:12");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("42", "大帝801", "去到没事", "-", "2004-02", "2004-02-20 09:08:18");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("43", "昆仑210", "键盘松", "-", "2004-02", "2004-02-20 09:09:08");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("44", "四海812", "客人不会开声音", "-", "2004-02", "2004-02-20 09:09:38");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("45", "东城", "主机重启", "-", "2004-02", "2004-02-20 09:10:51");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("46", "四海805", "系统不断重启", "重建", "2004-02", "2004-02-20 09:12:01");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("47", "山水1202", "系统不断重启", "重建", "2004-02", "2004-02-20 09:13:04");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("48", "九龙西220", "网卡松", "-", "2004-02", "2004-02-20 09:13:34");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("49", "九龙西222", "音箱电源被拔下", "-", "2004-02", "2004-02-20 09:14:31");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("50", "昆仑208", "客人进入COMS不会退出", "-", "2004-02", "2004-02-20 09:15:56");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("51", "四海1003", "系统不断重启", "重建", "2004-02", "2004-02-20 09:52:51");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("52", "九龙东412", "无声音，驱动出错", "换到317后修OK", "2004-02", "2004-02-20 09:54:49");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("53", "昆仑314", "主板松", "-", "2004-02-20", "2004-02-23 01:44");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("54", "东城", "主机掉线", "-", "2004-02-20", "2004-02-23 03:42");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("55", "昆仑402", "电源接触不良", "-", "2004-02-21", "2004-02-23 03:44");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("56", "四海1013", "显示器被调成16色", "-", "2004-02-21", "2004-02-23 03:46");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("57", "大帝805", "系统不能上网打不开主页", "重建", "2004-02-21", "2004-02-23 03:48");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("58", "九龙西325", "网卡松", "-", "2004-02-21", "2004-02-23 03:49");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("59", "九洲623", "系统死机出现非法操作", "拆回一条内存", "2004-02-21", "2004-02-23 03:52");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("60", "九龙西", "主机死机", "-", "2004-02-21", "2004-02-23 03:52");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("61", "山水901", "IP冲突", "-", "2004-02-21", "2004-02-23 03:53");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("62", "山水1409", "网卡松", "-", "2004-02-21", "2004-02-23 03:54");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("63", "大帝817", "系统死机", "换九洲拆回内存", "2004-02-21", "2004-02-23 03:55");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("64", "九洲709", "IP冲突", "-", "2004-02-21", "2004-02-23 03:56");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("65", "东城", "主机掉线", "-", "2004-02-21", "2004-02-23 03:57");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("66", "昆仑205", "COMS出错，黄色主页", "-", "2004-02-22", "2004-02-23 03:58");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("67", "山水1001", "换键盘", "-", "2004-02-22", "2004-02-23 03:59");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("68", "四海1003", "内存松", "-", "2004-02-22", "2004-02-23 03:59");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("69", "和平523", "音箱电源插头坏", "修好", "2004-02-22", "2004-02-23 04:01");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("70", "九洲517", "网卡松", "-", "2004-02-22", "2004-02-23 04:02");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("71", "九洲709", "系统不断重启不能进入系统", "重建", "2004-02-22", "2004-02-23 04:03");
# 数据表　guestbook　的结构;
DROP TABLE IF EXISTS `guestbook`;
CREATE TABLE `guestbook` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(25) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `qq` varchar(20) NOT NULL default '',
  `text` text NOT NULL,
  `reply` varchar(200) default NULL,
  `ip` varchar(30) NOT NULL default '',
  `dd` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
#
# 向表　guestbook　中插入数据;
#
insert into `guestbook` ( `id`,  `name`,  `email`,  `qq`,  `text`,  `reply`,  `ip`,  `dd`) values ("27", "访客", "-", "-", "《森林王子留言簿》几经修改：包括界面，添加回复功能等。
主要文件：PASS.PHP passinc.php gbact.php guestbook.php gbnews.php
PASS.PHP: 管理认证页面,只需输入密码,密码通过MD5加密,默认为senboy,区分大小写.
修改密码: 可通过[MD5加密值]生成新的密码MD5值,并将生成的MD5值手工添加到PASSINC.PHP页面的$password变量中完成密码修改.


", "", "127.0.0.1", "2004-04-04 01:13");
insert into `guestbook` ( `id`,  `name`,  `email`,  `qq`,  `text`,  `reply`,  `ip`,  `dd`) values ("31", "adf", "adf", "adf", "asdfasf", "", "172.16.79.3", "2004-08-03 18:11");
insert into `guestbook` ( `id`,  `name`,  `email`,  `qq`,  `text`,  `reply`,  `ip`,  `dd`) values ("32", "访客", "-", "-", "FSaa", "", "172.16.79.3", "2004-08-03 18:22");
insert into `guestbook` ( `id`,  `name`,  `email`,  `qq`,  `text`,  `reply`,  `ip`,  `dd`) values ("33", "孙广智", "qwea231@21cn.com", "16462931", "我来了，这个东东挺好的。", "", "172.16.79.3", "2004-08-03 18:29");
insert into `guestbook` ( `id`,  `name`,  `email`,  `qq`,  `text`,  `reply`,  `ip`,  `dd`) values ("34", "访客", "-", "-", "adfadfasdfasdf", "", "172.16.79.3", "2004-08-03 21:26");
insert into `guestbook` ( `id`,  `name`,  `email`,  `qq`,  `text`,  `reply`,  `ip`,  `dd`) values ("28", "访客", "-", "-", "《森林王子留言簿》
编写/测试环境：PHP4.*+apache/abyss+mysql4.*
	作者联系方式：MSN:senboyad@hotmail.com QQ:108542270 TEL:(0668)3258765
	目标：添加留言；分页显示；管理认证(md5加密)；正确处理字符（包括提交代码）；留言总列表/显示；IP限制刷屏；回复留言；删除留言；
	使用申明：这是自由软件，我们不会承担因使用本软件所带来的后果，如果你要用于商业用途，请你选择更专业的版本，或一定要经过修改后方能使用；由于此软件属于非定制产品，我们不保证软件所提供的功能能满足你的所有需求，如果你真正想得到符合自己要求的功能，你可以向作者提出有偿的定制服务。如果你现在要使用本软件就说明你已经同意了以上的条款，否则请不要使用。", "", "127.0.0.1", "2004-04-04 01:21");
insert into `guestbook` ( `id`,  `name`,  `email`,  `qq`,  `text`,  `reply`,  `ip`,  `dd`) values ("30", "senboy", "senboyad@hotmail.com", "108542270", "2004森林王子首推主打程序：《暗黑资源》！并用其轻易打造一个重量级音乐在线试听网站，首次提供歌曲60000多首，在中国将会成为数一数二的音乐大站！
此音乐网站程序和资源将公开发售，有意者请垂询：
senboyad@hotmail.com
QQ:108542270

《音乐网站》简介：  http://cnejob.myrice.com/ad/
《暗黑资源》简介： http://cnejob.myrice.com/ad/hack/", "", "127.0.0.1", "2004-06-13 14:27");
# 数据表　hardware　的结构;
DROP TABLE IF EXISTS `hardware`;
CREATE TABLE `hardware` (
  `id` int(11) NOT NULL auto_increment,
  `hotel` varchar(20) NOT NULL default '',
  `problem` varchar(100) NOT NULL default '',
  `about` text NOT NULL,
  `mm` varchar(30) NOT NULL default '',
  `dd` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `hotel` (`hotel`)
) TYPE=MyISAM;
#
# 向表　hardware　中插入数据;
#
