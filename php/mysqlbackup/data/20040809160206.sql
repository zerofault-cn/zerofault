# books 
# MySQL���ݿⱸ����ָ�ϵͳ��ver0.01
# Copyleft @ 2004 by �����
# ��������localhost  ���ݿ�����books
#---------------------------------------------------
#
# MySQL Server Version: 4.0.20-standard
#;
use books;
# ���ݱ�Book_Reviews���Ľṹ;
DROP TABLE IF EXISTS `Book_Reviews`;
CREATE TABLE `Book_Reviews` (
  `ISBN` varchar(20) NOT NULL default '',
  `Review` text,
  PRIMARY KEY  (`ISBN`)
) TYPE=MyISAM;
#
# ���Book_Reviews���в�������;
#
# ���ݱ�Books���Ľṹ;
DROP TABLE IF EXISTS `Books`;
CREATE TABLE `Books` (
  `ISBN` varchar(20) NOT NULL default '',
  `Auther` varchar(50) default NULL,
  `Title` varchar(255) default NULL,
  `Price` varchar(6) default NULL,
  PRIMARY KEY  (`ISBN`)
) TYPE=MyISAM;
#
# ���Books���в�������;
#
insert into `Books` ( `ISBN`,  `Auther`,  `Title`,  `Price`) values ("12345678901234567890", "Sunny", "ThizLinux Server Book", "90.00");
insert into `Books` ( `ISBN`,  `Auther`,  `Title`,  `Price`) values ("12345678901234567891", "O'LLEVY", "MySQL 4.0", "90.00");
insert into `Books` ( `ISBN`,  `Auther`,  `Title`,  `Price`) values ("12345678901234567892", "Time", "PHP 4.3.7 How To", "60.00");
insert into `Books` ( `ISBN`,  `Auther`,  `Title`,  `Price`) values ("12345678901234567893", "Sun Guang Zhi", "ThizLinux All Teach", "160.00");
insert into `Books` ( `ISBN`,  `Auther`,  `Title`,  `Price`) values ("98765432101234567890", "�����", "PHP & MySQL �߼�Ӧ��", "99.40");
insert into `Books` ( `ISBN`,  `Auther`,  `Title`,  `Price`) values ("12345612341234567890", "UFO", "DESCOVERY", "99.00");
insert into `Books` ( `ISBN`,  `Auther`,  `Title`,  `Price`) values ("123123235667598686", "aqadasdf", "qweqra", "123");
insert into `Books` ( `ISBN`,  `Auther`,  `Title`,  `Price`) values ("12312", "dd", "qwe", "123");
insert into `Books` ( `ISBN`,  `Auther`,  `Title`,  `Price`) values ("1525245", "uu", "dd", "23");
insert into `Books` ( `ISBN`,  `Auther`,  `Title`,  `Price`) values ("1231", "dd", "uwe", "231.22");
insert into `Books` ( `ISBN`,  `Auther`,  `Title`,  `Price`) values ("11111111111111222222", "aa", "adf", "123");
insert into `Books` ( `ISBN`,  `Auther`,  `Title`,  `Price`) values ("13481741983741341341", "uu", "adfowerwieur", "99");
insert into `Books` ( `ISBN`,  `Auther`,  `Title`,  `Price`) values ("11347189534657861451", "ooo", "aqiuqer", "88.00");
insert into `Books` ( `ISBN`,  `Auther`,  `Title`,  `Price`) values ("14617889506328975027", "uuok", "afowkejsa", "88.88");
insert into `Books` ( `ISBN`,  `Auther`,  `Title`,  `Price`) values ("14122345637441341346", "adfa", "qerqwer", "123");
insert into `Books` ( `ISBN`,  `Auther`,  `Title`,  `Price`) values ("14614786147515414513", "WHO", "who am i", "88");
insert into `Books` ( `ISBN`,  `Auther`,  `Title`,  `Price`) values ("45134132416345641413", "������", "ʮ�����֪��", "33.00");
insert into `Books` ( `ISBN`,  `Auther`,  `Title`,  `Price`) values ("16471634716516581251", "����", "������Ҳ��˵", "44.14");
insert into `Books` ( `ISBN`,  `Auther`,  `Title`,  `Price`) values ("13924256214145345614", "������", "��Ҫ��ô˵����", "44.90");
insert into `Books` ( `ISBN`,  `Auther`,  `Title`,  `Price`) values ("12312312312314142345", "asd", "134", "123");
insert into `Books` ( `ISBN`,  `Auther`,  `Title`,  `Price`) values ("12346567453123745672", "13123", "qwe131", "12");
insert into `Books` ( `ISBN`,  `Auther`,  `Title`,  `Price`) values ("13789897677512356576", "Sunny", "ufo-descovery", "88");
insert into `Books` ( `ISBN`,  `Auther`,  `Title`,  `Price`) values ("88456723539162374623", "������", "�������ռ�", "35.50");
# ���ݱ�Customers���Ľṹ;
DROP TABLE IF EXISTS `Customers`;
CREATE TABLE `Customers` (
  `CustomerID` int(5) NOT NULL auto_increment,
  `Name` varchar(40) default NULL,
  `Password` varchar(20) NOT NULL default '',
  `Address` varchar(255) default NULL,
  `City` varchar(255) default NULL,
  PRIMARY KEY  (`CustomerID`)
) TYPE=MyISAM;
#
# ���Customers���в�������;
#
insert into `Customers` ( `CustomerID`,  `Name`,  `Password`,  `Address`,  `City`) values ("1", "˳��", "12345678", "����", "����");
insert into `Customers` ( `CustomerID`,  `Name`,  `Password`,  `Address`,  `City`) values ("2", "�����", "sun78082", "����ʡ�������ռ������ٺ�һ��", "����");
insert into `Customers` ( `CustomerID`,  `Name`,  `Password`,  `Address`,  `City`) values ("3", "Sunny", "123456", "What UFO", "Ufo");
insert into `Customers` ( `CustomerID`,  `Name`,  `Password`,  `Address`,  `City`) values ("4", "Sunny Sun", "123123", "What UFO", "Ufo");
insert into `Customers` ( `CustomerID`,  `Name`,  `Password`,  `Address`,  `City`) values ("5", "BoBo", "123123", "What UFO", "Ufo");
insert into `Customers` ( `CustomerID`,  `Name`,  `Password`,  `Address`,  `City`) values ("6", "BoBo Ufo", "123123", "What UFO", "Ufo");
insert into `Customers` ( `CustomerID`,  `Name`,  `Password`,  `Address`,  `City`) values ("7", "qwea231", "123123", "qweqw21", "qweqweqwe");
# ���ݱ�Orders���Ľṹ;
DROP TABLE IF EXISTS `Orders`;
CREATE TABLE `Orders` (
  `OrderID` int(5) NOT NULL auto_increment,
  `CustomerID` int(5) default NULL,
  `Amount` varchar(8) default NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`OrderID`)
) TYPE=MyISAM;
#
# ���Orders���в�������;
#
