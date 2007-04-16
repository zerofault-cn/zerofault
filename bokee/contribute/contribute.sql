# MySQL-Front Dump 2.5
#
# Host: localhost   Database: contribute
# --------------------------------------------------------
# Server version 4.1.20-community-nt


#
# Table structure for table 'article'
#

CREATE TABLE article (
  id int(10) unsigned NOT NULL auto_increment,
  author_id smallint(3) unsigned NOT NULL default '0',
  channel_id1 smallint(3) unsigned NOT NULL default '0',
  channel_id2 smallint(3) unsigned NOT NULL default '0',
  channel_id3 smallint(3) unsigned NOT NULL default '0',
  title varchar(255) NOT NULL default '',
  url varchar(255) NOT NULL default '',
  addtime int(10) unsigned NOT NULL default '0',
  vote smallint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY author_id (author_id)
) COMMENT='Ͷ�����±�';



#
# Dumping data for table 'article'
#



#
# Table structure for table 'author'
#

CREATE TABLE author (
  id int(10) unsigned NOT NULL auto_increment,
  blogid varchar(32) NOT NULL default '',
  blogname varchar(64) NOT NULL default '',
  blogurl varchar(255) NOT NULL default '',
  email varchar(255) NOT NULL default '',
  vote smallint(3) unsigned NOT NULL default '0',
  article_count smallint(3) unsigned NOT NULL default '0',
  month_article smallint(3) unsigned NOT NULL default '0',
  KEY id (id)
) COMMENT='������Ϣ��';



#
# Dumping data for table 'author'
#



#
# Table structure for table 'channel'
#

CREATE TABLE channel (
  id smallint(3) unsigned NOT NULL auto_increment,
  name varchar(64) NOT NULL default '',
  sys_flag tinyint(1) unsigned NOT NULL default '0',
  xml_flag tinyint(1) unsigned NOT NULL default '0',
  addtime int(10) unsigned NOT NULL default '0',
  article_count int(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (id)
) COMMENT='Ƶ����Ŀ��';



#
# Dumping data for table 'channel'
#

INSERT INTO channel VALUES("6", "��������", "0", "0", "0", "0");
INSERT INTO channel VALUES("7", "����Ƶ��-��ʳ", "0", "0", "0", "0");
INSERT INTO channel VALUES("8", "���²��������Ƽ�", "0", "0", "0", "0");
INSERT INTO channel VALUES("9", "��Ů������з�й", "0", "0", "0", "0");
INSERT INTO channel VALUES("10", "��Ʒ����", "0", "0", "0", "0");
INSERT INTO channel VALUES("11", "��Ů�����Ƽ�", "0", "0", "0", "0");
INSERT INTO channel VALUES("12", "�����˵", "0", "0", "0", "0");
INSERT INTO channel VALUES("13", "���豦����", "0", "0", "0", "0");
INSERT INTO channel VALUES("14", "�����Ƽ�Ⱥ��", "0", "0", "0", "0");
INSERT INTO channel VALUES("15", "��������", "0", "0", "0", "0");
INSERT INTO channel VALUES("16", "����Ƶ��-����", "0", "0", "0", "0");
INSERT INTO channel VALUES("17", "����Ƶ��-����", "0", "0", "0", "0");
INSERT INTO channel VALUES("18", "����Ƶ��-�Ҿ�", "0", "0", "0", "0");
INSERT INTO channel VALUES("19", "����Ƶ��-����", "0", "0", "0", "0");
INSERT INTO channel VALUES("20", "����Ƶ��-����", "0", "0", "0", "0");
INSERT INTO channel VALUES("21", "SHOW����", "0", "0", "0", "0");
INSERT INTO channel VALUES("22", "����ר��", "0", "0", "0", "0");
INSERT INTO channel VALUES("68", "����", "1", "1", "0", "0");
INSERT INTO channel VALUES("69", "����", "1", "1", "0", "0");
INSERT INTO channel VALUES("70", "Ů��", "1", "1", "0", "0");
INSERT INTO channel VALUES("71", "�Ƽ�", "1", "0", "0", "0");
INSERT INTO channel VALUES("72", "����", "1", "0", "0", "0");
INSERT INTO channel VALUES("73", "�Ļ�", "1", "0", "0", "0");
INSERT INTO channel VALUES("74", "����", "1", "0", "0", "0");
INSERT INTO channel VALUES("76", "���", "1", "0", "0", "0");
INSERT INTO channel VALUES("77", "����", "1", "0", "0", "0");
INSERT INTO channel VALUES("78", "��ý", "1", "0", "0", "0");
INSERT INTO channel VALUES("79", "Ц��", "1", "0", "0", "0");
INSERT INTO channel VALUES("80", "����", "1", "0", "0", "0");
INSERT INTO channel VALUES("81", "���", "1", "0", "0", "0");
INSERT INTO channel VALUES("82", "��ѧ", "1", "0", "0", "0");
INSERT INTO channel VALUES("83", "����", "1", "0", "0", "0");
INSERT INTO channel VALUES("84", "����", "1", "0", "0", "0");
INSERT INTO channel VALUES("85", "����", "1", "0", "0", "0");
INSERT INTO channel VALUES("86", "����", "1", "0", "0", "0");
INSERT INTO channel VALUES("87", "ͼƬ", "1", "0", "0", "0");
INSERT INTO channel VALUES("88", "��Ƶ", "1", "0", "0", "0");
INSERT INTO channel VALUES("96", "ʱ��", "1", "0", "0", "0");
INSERT INTO channel VALUES("89", "���籭-�ƽ����¼�", "0", "0", "0", "0");
INSERT INTO channel VALUES("90", "�߽�����", "0", "0", "0", "0");
INSERT INTO channel VALUES("91", "���ʹ���", "0", "0", "0", "0");
INSERT INTO channel VALUES("92", "����֮��", "0", "0", "0", "0");
INSERT INTO channel VALUES("93", "��ɽ�����30��", "0", "0", "0", "0");
INSERT INTO channel VALUES("94", "����", "0", "0", "0", "0");
INSERT INTO channel VALUES("95", "[�ذ�Ů���ж�]����", "0", "0", "0", "0");
INSERT INTO channel VALUES("97", "�µ���-��ɫ�籩��������", "0", "0", "0", "0");
INSERT INTO channel VALUES("98", "����Ⱥ�� ��������", "0", "0", "0", "0");
INSERT INTO channel VALUES("99", "��������", "0", "0", "0", "0");
INSERT INTO channel VALUES("100", "ASUS���潿����ѡ�", "0", "0", "0", "0");
INSERT INTO channel VALUES("101", "������̸", "0", "0", "0", "0");
INSERT INTO channel VALUES("102", "����Ƶ��", "0", "0", "0", "0");
