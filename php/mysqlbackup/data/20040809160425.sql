# hotel 
# MySQL���ݿⱸ����ָ�ϵͳ��ver0.01
# Copyleft @ 2004 by �����
# ��������localhost  ���ݿ�����hotel
#---------------------------------------------------
#
# MySQL Server Version: 4.0.20-standard
#;
use hotel;
# ���ݱ�computer���Ľṹ;
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
# ���computer���в�������;
#
insert into `computer` ( `id`,  `hotel`,  `computer`,  `about`,  `dd`) values ("1", "����", "����80G", "����ʱ�䣺18��00", "2004-02-11 08:43:08");
insert into `computer` ( `id`,  `hotel`,  `computer`,  `about`,  `dd`) values ("2", "ɽˮ", "����", "����ʱ�䣺08��30", "2004-02-11 08:44:53");
insert into `computer` ( `id`,  `hotel`,  `computer`,  `about`,  `dd`) values ("3", "�ĺ�", "����", "����ʱ�䣺18��30", "2004-02-11 08:45:49");
insert into `computer` ( `id`,  `hotel`,  `computer`,  `about`,  `dd`) values ("4", "����", "����60G", "����ʱ��Ϊ18:00", "2004-02-11 16:28:02");
insert into `computer` ( `id`,  `hotel`,  `computer`,  `about`,  `dd`) values ("5", "��ƽ", "�绰��3338888", "��", "2004-02-19 15:03:27");
# ���ݱ�fix���Ľṹ;
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
# ���fix���в�������;
#
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("1", "����804", "������Դ����ʧ��", "����������ť����", "2004-02", "2004-02-11 09:55:26");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("2", "����901", "���м��", "��ʾ����ɫ,��Ļ��ȵ���ʧ��.ĩ��.", "2004-02", "2004-02-11 16:46:35");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("3", "ɽˮ1006", "IP��ͻ", "-", "2004-02", "2004-02-13 08:46:23");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("4", "����209", "����", "-", "2004-02", "2004-02-13 08:48:12");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("5", "����210", "�ڴ���", "-", "2004-02", "2004-02-13 08:48:39");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("6", "ɽˮ709", "IP��ͻ", "-", "2004-02", "2004-02-13 08:49:24");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("7", "ɽˮ1310", "������", "����δ����˿��", "2004-02", "2004-02-13 13:33:02");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("8", "ɽˮ718", "��ʾ����ťʧ��", "����ʾ������͸������ס", "2004-02", "2004-02-13 16:08:31");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("9", "�ĺ�", "��������", "-", "2004-02", "2004-02-19 15:15:48");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("10", "����522", "���߱��γ�", "-", "2004-02", "2004-02-19 15:18:43");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("11", "ɽˮ1216", "û����������", "-", "2004-02", "2004-02-19 15:20:10");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("12", "����210", "ϵͳ����", "-", "2004-02", "2004-02-19 15:23:14");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("13", "����907", "������", "-", "2004-02", "2004-02-19 15:23:46");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("14", "����807", "������", "-", "2004-02", "2004-02-20 08:40:03");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("15", "����304", "��������", "-", "2004-02", "2004-02-20 08:40:51");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("16", "ɽˮ806", "��������", "-", "2004-02", "2004-02-20 08:41:34");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("17", "�ĺ�910", "����ҳ", "-", "2004-02", "2004-02-20 08:42:56");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("18", "ɽˮ908", "IP��ͻ", "-", "2004-02", "2004-02-20 08:43:16");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("19", "ɽˮ908", "IP��ͻ", "-", "2004-02", "2004-02-20 08:43:43");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("20", "ɽˮ1416", "������ϵͳ", "Щ���й�����������û��������OK", "2004-02", "2004-02-20 08:46:31");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("21", "ɽˮ818", "����", "-", "2004-02", "2004-02-20 08:47:21");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("22", "����201", "ȥ��û��", "-", "2004-02", "2004-02-20 08:49:44");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("23", "ɽˮ1205", "��������", "-", "2004-02", "2004-02-20 08:50:09");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("24", "����914", "����ˮ��ͷ����ʪ", "-", "2004-02", "2004-02-20 08:50:56");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("25", "���803", "IP��ͻ", "-", "2004-02", "2004-02-20 08:51:29");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("26", "�ĺ�1013", "û����", "-", "2004-02", "2004-02-20 08:51:59");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("27", "����516", "ûװ��������", "-", "2004-02", "2004-02-20 08:52:35");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("28", "�ĺ�1116", "IP��ͻ����", "-", "2004-02", "2004-02-20 08:53:16");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("29", "�ĺ�912", "��������", "-", "2004-02", "2004-02-20 08:53:42");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("30", "������414", "���˲�������", "-", "2004-02", "2004-02-20 08:54:12");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("31", "�ĺ�813", "����û�в�������", "-", "2004-02", "2004-02-20 08:58:24");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("32", "������313", "������", "-", "2004-02", "2004-02-20 08:59:02");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("33", "ɽˮ1016", "IP��ͻ", "-", "2004-02", "2004-02-20 08:59:24");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("34", "����607", "������", "-", "2004-02", "2004-02-20 08:59:50");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("35", "ɽˮ1402", "������", "-", "2004-02", "2004-02-20 09:00:19");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("36", "����209", "�޻�", "�ؽ�", "2004-02", "2004-02-20 09:01:03");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("37", "����919", "��������ʧ��������", "-", "2004-02", "2004-02-20 09:02:38");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("38", "���835", "����", "�뵽�������Ӣ������", "2004-02", "2004-02-20 09:03:57");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("39", "����317", "���������˻�", "-", "2004-02", "2004-02-20 09:04:46");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("40", "����312", "��������С", "-", "2004-02", "2004-02-20 09:05:23");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("41", "�ĺ�910", "��ʾ����ʾ������ɫ", "-", "2004-02", "2004-02-20 09:06:12");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("42", "���801", "ȥ��û��", "-", "2004-02", "2004-02-20 09:08:18");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("43", "����210", "������", "-", "2004-02", "2004-02-20 09:09:08");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("44", "�ĺ�812", "���˲��Ὺ����", "-", "2004-02", "2004-02-20 09:09:38");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("45", "����", "��������", "-", "2004-02", "2004-02-20 09:10:51");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("46", "�ĺ�805", "ϵͳ��������", "�ؽ�", "2004-02", "2004-02-20 09:12:01");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("47", "ɽˮ1202", "ϵͳ��������", "�ؽ�", "2004-02", "2004-02-20 09:13:04");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("48", "������220", "������", "-", "2004-02", "2004-02-20 09:13:34");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("49", "������222", "�����Դ������", "-", "2004-02", "2004-02-20 09:14:31");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("50", "����208", "���˽���COMS�����˳�", "-", "2004-02", "2004-02-20 09:15:56");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("51", "�ĺ�1003", "ϵͳ��������", "�ؽ�", "2004-02", "2004-02-20 09:52:51");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("52", "������412", "����������������", "����317����OK", "2004-02", "2004-02-20 09:54:49");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("53", "����314", "������", "-", "2004-02-20", "2004-02-23 01:44");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("54", "����", "��������", "-", "2004-02-20", "2004-02-23 03:42");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("55", "����402", "��Դ�Ӵ�����", "-", "2004-02-21", "2004-02-23 03:44");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("56", "�ĺ�1013", "��ʾ��������16ɫ", "-", "2004-02-21", "2004-02-23 03:46");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("57", "���805", "ϵͳ���������򲻿���ҳ", "�ؽ�", "2004-02-21", "2004-02-23 03:48");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("58", "������325", "������", "-", "2004-02-21", "2004-02-23 03:49");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("59", "����623", "ϵͳ�������ַǷ�����", "���һ���ڴ�", "2004-02-21", "2004-02-23 03:52");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("60", "������", "��������", "-", "2004-02-21", "2004-02-23 03:52");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("61", "ɽˮ901", "IP��ͻ", "-", "2004-02-21", "2004-02-23 03:53");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("62", "ɽˮ1409", "������", "-", "2004-02-21", "2004-02-23 03:54");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("63", "���817", "ϵͳ����", "�����޲���ڴ�", "2004-02-21", "2004-02-23 03:55");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("64", "����709", "IP��ͻ", "-", "2004-02-21", "2004-02-23 03:56");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("65", "����", "��������", "-", "2004-02-21", "2004-02-23 03:57");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("66", "����205", "COMS������ɫ��ҳ", "-", "2004-02-22", "2004-02-23 03:58");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("67", "ɽˮ1001", "������", "-", "2004-02-22", "2004-02-23 03:59");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("68", "�ĺ�1003", "�ڴ���", "-", "2004-02-22", "2004-02-23 03:59");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("69", "��ƽ523", "�����Դ��ͷ��", "�޺�", "2004-02-22", "2004-02-23 04:01");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("70", "����517", "������", "-", "2004-02-22", "2004-02-23 04:02");
insert into `fix` ( `id`,  `hotel`,  `problem`,  `about`,  `mm`,  `dd`) values ("71", "����709", "ϵͳ�����������ܽ���ϵͳ", "�ؽ�", "2004-02-22", "2004-02-23 04:03");
# ���ݱ�guestbook���Ľṹ;
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
# ���guestbook���в�������;
#
insert into `guestbook` ( `id`,  `name`,  `email`,  `qq`,  `text`,  `reply`,  `ip`,  `dd`) values ("27", "�ÿ�", "-", "-", "��ɭ���������Բ��������޸ģ��������棬��ӻظ����ܵȡ�
��Ҫ�ļ���PASS.PHP passinc.php gbact.php guestbook.php gbnews.php
PASS.PHP: ������֤ҳ��,ֻ����������,����ͨ��MD5����,Ĭ��Ϊsenboy,���ִ�Сд.
�޸�����: ��ͨ��[MD5����ֵ]�����µ�����MD5ֵ,�������ɵ�MD5ֵ�ֹ���ӵ�PASSINC.PHPҳ���$password��������������޸�.


", "", "127.0.0.1", "2004-04-04 01:13");
insert into `guestbook` ( `id`,  `name`,  `email`,  `qq`,  `text`,  `reply`,  `ip`,  `dd`) values ("31", "adf", "adf", "adf", "asdfasf", "", "172.16.79.3", "2004-08-03 18:11");
insert into `guestbook` ( `id`,  `name`,  `email`,  `qq`,  `text`,  `reply`,  `ip`,  `dd`) values ("32", "�ÿ�", "-", "-", "FSaa", "", "172.16.79.3", "2004-08-03 18:22");
insert into `guestbook` ( `id`,  `name`,  `email`,  `qq`,  `text`,  `reply`,  `ip`,  `dd`) values ("33", "�����", "qwea231@21cn.com", "16462931", "�����ˣ��������ͦ�õġ�", "", "172.16.79.3", "2004-08-03 18:29");
insert into `guestbook` ( `id`,  `name`,  `email`,  `qq`,  `text`,  `reply`,  `ip`,  `dd`) values ("34", "�ÿ�", "-", "-", "adfadfasdfasdf", "", "172.16.79.3", "2004-08-03 21:26");
insert into `guestbook` ( `id`,  `name`,  `email`,  `qq`,  `text`,  `reply`,  `ip`,  `dd`) values ("28", "�ÿ�", "-", "-", "��ɭ���������Բ���
��д/���Ի�����PHP4.*+apache/abyss+mysql4.*
	������ϵ��ʽ��MSN:senboyad@hotmail.com QQ:108542270 TEL:(0668)3258765
	Ŀ�꣺������ԣ���ҳ��ʾ��������֤(md5����)����ȷ�����ַ��������ύ���룩���������б�/��ʾ��IP����ˢ�����ظ����ԣ�ɾ�����ԣ�
	ʹ������������������������ǲ���е���ʹ�ñ�����������ĺ���������Ҫ������ҵ��;������ѡ���רҵ�İ汾����һ��Ҫ�����޸ĺ���ʹ�ã����ڴ�������ڷǶ��Ʋ�Ʒ�����ǲ���֤������ṩ�Ĺ�������������������������������õ������Լ�Ҫ��Ĺ��ܣ����������������г��Ķ��Ʒ������������Ҫʹ�ñ������˵�����Ѿ�ͬ�������ϵ���������벻Ҫʹ�á�", "", "127.0.0.1", "2004-04-04 01:21");
insert into `guestbook` ( `id`,  `name`,  `email`,  `qq`,  `text`,  `reply`,  `ip`,  `dd`) values ("30", "senboy", "senboyad@hotmail.com", "108542270", "2004ɭ����������������򣺡�������Դ�������������״���һ����������������������վ���״��ṩ����60000���ף����й������Ϊ��һ���������ִ�վ��
��������վ�������Դ���������ۣ��������봹ѯ��
senboyad@hotmail.com
QQ:108542270

��������վ����飺  http://cnejob.myrice.com/ad/
��������Դ����飺 http://cnejob.myrice.com/ad/hack/", "", "127.0.0.1", "2004-06-13 14:27");
# ���ݱ�hardware���Ľṹ;
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
# ���hardware���в�������;
#
