# MySQL-Front Dump 2.5
#
# Host: localhost   Database: phpbbs
# --------------------------------------------------------
# Server version 3.23.52-nt

USE phpbbs;


#
# Table structure for table 'album_info'
#

DROP TABLE IF EXISTS album_info;
CREATE TABLE album_info (
  album_id smallint(5) unsigned NOT NULL auto_increment,
  singer_id smallint(5) unsigned default '0',
  album_name varchar(32) default NULL,
  album_pubdate varchar(10) default NULL,
  album_intro text,
  album_photo blob,
  album_count smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (album_id),
  KEY singer_id (singer_id)
) TYPE=MyISAM COMMENT='歌手专辑表';



#
# Table structure for table 'singer_info'
#

DROP TABLE IF EXISTS singer_info;
CREATE TABLE singer_info (
  singer_id smallint(5) unsigned NOT NULL auto_increment,
  singer_name varchar(16) default NULL,
  singer_name_fc char(1) default NULL,
  singer_photo blob,
  singer_intro text,
  singer_area_id tinyint(3) unsigned default '0',
  singer_chorus_id tinyint(3) unsigned default '0',
  PRIMARY KEY  (singer_id),
  KEY singer_id (singer_id)
) TYPE=MyISAM COMMENT='歌手信息表';



#
# Table structure for table 'singer_type'
#

DROP TABLE IF EXISTS singer_type;
CREATE TABLE singer_type (
  type_id tinyint(3) unsigned NOT NULL auto_increment,
  type_name char(8) default '0',
  type_label tinyint(3) unsigned default '0',
  PRIMARY KEY  (type_id),
  KEY type_id (type_id)
) TYPE=MyISAM COMMENT='歌手分类表';



#
# Table structure for table 'song_info'
#

DROP TABLE IF EXISTS song_info;
CREATE TABLE song_info (
  song_id mediumint(8) unsigned NOT NULL auto_increment,
  singer_id smallint(5) unsigned NOT NULL default '0',
  album_id smallint(5) unsigned default '0',
  song_name char(32) default '0',
  song_path char(255) default '0',
  song_lyric char(255) default '0',
  song_count smallint(5) unsigned default '0',
  song_addtime date default NULL,
  PRIMARY KEY  (song_id),
  KEY song_id (song_id,album_id)
) TYPE=MyISAM COMMENT='歌曲信息表';

