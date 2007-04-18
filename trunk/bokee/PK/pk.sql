# MySQL-Front Dump 2.5
#
# Host: localhost   Database: pk
# --------------------------------------------------------
# Server version 4.1.20-community-nt


#
# Table structure for table 'comment'
#

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `sid` int(10) unsigned NOT NULL default '0',
  `side` tinyint(1) NOT NULL default '0',
  `username` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  `addtime` int(10) unsigned NOT NULL default '0',
  `ip` varchar(64) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ;



#
# Dumping data for table 'comment'
#

INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("1", "1", "1", "dfds", "", "sdfds", "1175969164", "127.0.0.1");
INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("2", "1", "1", "234", "", "fdsfadf", "1175969330", "127.0.0.1");
INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("3", "1", "1", "234", "", "fdsfadf", "1175969365", "127.0.0.1");
INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("4", "1", "1", "dfsf", "", "sddsf", "1175969382", "127.0.0.1");
INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("5", "1", "1", "dfsf", "", "sddsf", "1175969429", "127.0.0.1");
INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("6", "1", "1", "dfads", "", "sdfsd", "1175969600", "127.0.0.1");
INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("7", "1", "1", "dfads", "", "哈哈哈", "1175969605", "127.0.0.1");
INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("8", "1", "1", "dfads", "", "分散地方第三方撒", "1175969615", "127.0.0.1");
INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("9", "1", "1", "dfads", "", "第三方的", "1175969619", "127.0.0.1");
INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("10", "1", "1", "dfads", "", "发送到", "1175969654", "127.0.0.1");
INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("11", "1", "1", "", "", "", "1175970044", "127.0.0.1");
INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("12", "1", "1", "", "", "", "1175970138", "127.0.0.1");
INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("13", "1", "1", "", "", "", "1175970263", "127.0.0.1");
INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("14", "1", "1", "", "", "", "1175970269", "127.0.0.1");
INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("15", "1", "1", "", "", "", "1175970340", "127.0.0.1");
INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("16", "1", "-1", "zerofault", "", "right&nbsp;side", "1175970402", "127.0.0.1");
INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("17", "1", "1", "aaa", "", "left&nbsp;side", "1175970415", "127.0.0.1");
INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("18", "1", "0", "aaa", "", "center&nbsp;side", "1175970426", "127.0.0.1");
INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("19", "1", "1", "aaa", "", "rwerewr", "1175970445", "127.0.0.1");
INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("20", "1", "1", "aaa", "", "dfadsfs", "1175970448", "127.0.0.1");
INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("21", "1", "1", "aaa", "", "fdsfd", "1175970452", "127.0.0.1");
INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("22", "1", "1", "aaa", "", "dsfasdf", "1175970455", "127.0.0.1");
INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("23", "1", "1", "aaa", "", "afdsfdsfdsfds", "1175970458", "127.0.0.1");
INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("24", "1", "1", "dfsd", "", "fdsfds", "1175971046", "127.0.0.1");
INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("25", "1", "1", "dfsd", "", "dsfds", "1175971071", "127.0.0.1");
INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("26", "1", "-1", "fsdf", "", "fsdfdsfd", "1175971080", "127.0.0.1");
INSERT INTO `comment` (`id`, `sid`, `side`, `username`, `title`, `content`, `addtime`, `ip`) VALUES("27", "1", "0", "dfdsf", "", "fsdf", "1175971470", "127.0.0.1");


#
# Table structure for table 'subject'
#

DROP TABLE IF EXISTS `subject`;
CREATE TABLE `subject` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `descr` text NOT NULL,
  `l_title` varchar(255) NOT NULL default '',
  `r_title` varchar(255) NOT NULL default '',
  `l_opinion` text NOT NULL,
  `r_opinion` text NOT NULL,
  `l_comm` int(10) unsigned NOT NULL default '0',
  `r_comm` int(10) unsigned NOT NULL default '0',
  `l_vote` int(10) unsigned NOT NULL default '0',
  `r_vote` int(10) unsigned NOT NULL default '0',
  `c_point` text NOT NULL,
  `c_comm` int(10) unsigned NOT NULL default '0',
  `addtime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ;



#
# Dumping data for table 'subject'
#

INSERT INTO `subject` (`id`, `title`, `descr`, `l_title`, `r_title`, `l_opinion`, `r_opinion`, `l_comm`, `r_comm`, `l_vote`, `r_vote`, `c_point`, `c_comm`, `addtime`) VALUES("1", "", "", "", "", "", "", "2", "1", "415", "446", "", "1", "0");
