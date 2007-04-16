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
) COMMENT='投稿文章表';



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
) COMMENT='作者信息表';



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
) COMMENT='频道栏目表';



#
# Dumping data for table 'channel'
#

INSERT INTO channel VALUES("6", "新闻线索", "0", "0", "0", "0");
INSERT INTO channel VALUES("7", "生活频道-美食", "0", "0", "0", "0");
INSERT INTO channel VALUES("8", "情侣博客文章推荐", "0", "0", "0", "0");
INSERT INTO channel VALUES("9", "美女博客情感发泄", "0", "0", "0", "0");
INSERT INTO channel VALUES("10", "产品体验", "0", "0", "0", "0");
INSERT INTO channel VALUES("11", "美女文章推荐", "0", "0", "0", "0");
INSERT INTO channel VALUES("12", "情感诉说", "0", "0", "0", "0");
INSERT INTO channel VALUES("13", "妈妈宝宝秀", "0", "0", "0", "0");
INSERT INTO channel VALUES("14", "网友推荐群组", "0", "0", "0", "0");
INSERT INTO channel VALUES("15", "两性生活", "0", "0", "0", "0");
INSERT INTO channel VALUES("16", "生活频道-休闲", "0", "0", "0", "0");
INSERT INTO channel VALUES("17", "生活频道-消费", "0", "0", "0", "0");
INSERT INTO channel VALUES("18", "生活频道-家居", "0", "0", "0", "0");
INSERT INTO channel VALUES("19", "生活频道-宠物", "0", "0", "0", "0");
INSERT INTO channel VALUES("20", "生活频道-星座", "0", "0", "0", "0");
INSERT INTO channel VALUES("21", "SHOW大年", "0", "0", "0", "0");
INSERT INTO channel VALUES("22", "博客专题", "0", "0", "0", "0");
INSERT INTO channel VALUES("68", "娱乐", "1", "1", "0", "0");
INSERT INTO channel VALUES("69", "体育", "1", "1", "0", "0");
INSERT INTO channel VALUES("70", "女性", "1", "1", "0", "0");
INSERT INTO channel VALUES("71", "科技", "1", "0", "0", "0");
INSERT INTO channel VALUES("72", "经济", "1", "0", "0", "0");
INSERT INTO channel VALUES("73", "文化", "1", "0", "0", "0");
INSERT INTO channel VALUES("74", "生活", "1", "0", "0", "0");
INSERT INTO channel VALUES("76", "情感", "1", "0", "0", "0");
INSERT INTO channel VALUES("77", "教育", "1", "0", "0", "0");
INSERT INTO channel VALUES("78", "传媒", "1", "0", "0", "0");
INSERT INTO channel VALUES("79", "笑话", "1", "0", "0", "0");
INSERT INTO channel VALUES("80", "健康", "1", "0", "0", "0");
INSERT INTO channel VALUES("81", "社会", "1", "0", "0", "0");
INSERT INTO channel VALUES("82", "文学", "1", "0", "0", "0");
INSERT INTO channel VALUES("83", "军事", "1", "0", "0", "0");
INSERT INTO channel VALUES("84", "奥运", "1", "0", "0", "0");
INSERT INTO channel VALUES("85", "旅游", "1", "0", "0", "0");
INSERT INTO channel VALUES("86", "数码", "1", "0", "0", "0");
INSERT INTO channel VALUES("87", "图片", "1", "0", "0", "0");
INSERT INTO channel VALUES("88", "视频", "1", "0", "0", "0");
INSERT INTO channel VALUES("96", "时尚", "1", "0", "0", "0");
INSERT INTO channel VALUES("89", "世界杯-黄健翔事件", "0", "0", "0", "0");
INSERT INTO channel VALUES("90", "走进西藏", "0", "0", "0", "0");
INSERT INTO channel VALUES("91", "博客大集市", "0", "0", "0", "0");
INSERT INTO channel VALUES("92", "健身之旅", "0", "0", "0", "0");
INSERT INTO channel VALUES("93", "唐山大地震30年", "0", "0", "0", "0");
INSERT INTO channel VALUES("94", "动漫", "0", "0", "0", "0");
INSERT INTO channel VALUES("95", "[关爱女孩行动]征文", "0", "0", "0", "0");
INSERT INTO channel VALUES("97", "奥德赛-紫色风暴体验正文", "0", "0", "0", "0");
INSERT INTO channel VALUES("98", "博客群组 互动话题", "0", "0", "0", "0");
INSERT INTO channel VALUES("99", "新闻线索", "0", "0", "0", "0");
INSERT INTO channel VALUES("100", "ASUS六面娇娃评选活动", "0", "0", "0", "0");
INSERT INTO channel VALUES("101", "美凝访谈", "0", "0", "0", "0");
INSERT INTO channel VALUES("102", "汽车频道", "0", "0", "0", "0");
