<?php
$sql = array(); 
$sql[] = "
CREATE TABLE `article` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `sub_title` varchar(255) NOT NULL default '',
  `create_time` datetime default '0000-00-00 00:00:00',
  `channel_id` smallint(6) NOT NULL default '0',
  `subject_id` smallint(6) NOT NULL default '0',
  `author` varchar(50) NOT NULL default '0',
  `coop_media_id` smallint(6) NOT NULL default '0',
  `media_name` varchar(50) NOT NULL default '',
  `area_id` smallint(6) NOT NULL default '0',
  `view_num` mediumint(9) NOT NULL default '0',
  `comment_num` smallint(6) NOT NULL default '0',
  `score` smallint(6) NOT NULL default '0',
  `user_id` smallint(6) NOT NULL default '0',
  `template_id` smallint(6) NOT NULL default '0',
  `description` varchar(255) NOT NULL default '',
  `visible` tinyint(4) NOT NULL default '0',
  `keyword` varchar(50) NOT NULL default '',
  `mark` tinyint(4) NOT NULL default '0',
  `content_path` varchar(255) NOT NULL default '',
  `special_id` mediumint(9) NOT NULL default '0',
  `special_subject_id` mediumint(9) NOT NULL default '0',
  `is_multi_special` tinyint(4) NOT NULL default '0',
  `rel_blog_path` varchar(255) NOT NULL default '',
  `enable_comment` enum('Y','N') NOT NULL default 'Y',
  `enable_ad` enum('Y','N') NOT NULL default 'Y',
  `static_file_path` varchar(255) NOT NULL default '',
  `remote_static_file_path` varchar(255) NOT NULL default '',
  `remote_url` varchar(255) NOT NULL default '',
  `rss_url` varchar(255) NOT NULL default '',
  `is_rss` enum('Y','N') NOT NULL default 'N',
  `group_id` int(11) NOT NULL default '0',
  `auto_redirect` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `mark` (`mark`),
  KEY `area_id` (`area_id`),
  KEY `create_time` (`create_time`),
  KEY `channel_id` (`channel_id`),
  KEY `subject_id` (`subject_id`),
  KEY `coop_media_id` (`coop_media_id`),
  KEY `area_id_2` (`area_id`),
  KEY `view_num` (`view_num`),
  KEY `comment_num` (`comment_num`),
  KEY `user_id` (`user_id`),
  KEY `score` (`score`),
  KEY `special_id` (`special_id`,`special_subject_id`),
  KEY `is_multi_special` (`is_multi_special`),
  KEY `enable_comment` (`enable_comment`,`enable_ad`),
  KEY `is_rss` (`is_rss`),
  KEY `group_id` (`group_id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;
";
$sql[] = "
CREATE TABLE `article_group` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `category` enum('photo','article') NOT NULL default 'article',
  `subject_id` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `create_time` (`create_time`),
  KEY `category` (`category`),
  KEY `subject_id` (`subject_id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;
";
$sql[] = "
CREATE TABLE `flash_images` (
  `id` mediumint(9) NOT NULL auto_increment,
  `path` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;
";
$sql[] = "
CREATE TABLE `gallery` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `path` varchar(255) NOT NULL default '',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `user_id` smallint(6) NOT NULL default '0',
  `subject_id` smallint(6) NOT NULL default '0',
  `url` varchar(255) NOT NULL default '',
  `article_id` int(11) NOT NULL default '0',
  `category` tinyint(4) NOT NULL default '0',
  `description` varchar(255) NOT NULL default '',
  `group_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `subject_id` (`subject_id`),
  KEY `article_id` (`article_id`),
  KEY `category` (`category`),
  KEY `group_id` (`group_id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;
";
$sql[] = "
CREATE TABLE `map_article_special` (
  `id` int(11) NOT NULL auto_increment,
  `article_id` int(11) NOT NULL default '0',
  `special_id` mediumint(9) NOT NULL default '0',
  `special_subject_id` mediumint(9) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `article_id` (`article_id`),
  KEY `special_id` (`special_id`),
  KEY `special_subject_id` (`special_subject_id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;
";
$sql[] = "
CREATE TABLE `rel_article_subject` (
  `id` int(11) NOT NULL auto_increment,
  `article_id` int(11) NOT NULL default '0',
  `subject_id` smallint(6) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `category` tinyint(4) NOT NULL default '0',
  `updatetime` timestamp(14) NOT NULL,
  `plush_time` timestamp(14) NOT NULL,
  `datetime` timestamp(14) NOT NULL default '00000000000000',
  `source` enum('blog','cms','rss','blogmark','column','bbs') NOT NULL default 'cms',
  `mark` tinyint(4) NOT NULL default '1',
  `user_id` tinyint(4) NOT NULL default '0',
  `group_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `category` (`category`),
  KEY `datetime` (`datetime`),
  KEY `source` (`source`),
  KEY `mark` (`mark`),
  KEY `user_id` (`user_id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;
";
$sql[] = "
CREATE TABLE `rss_entry_attach` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `feed_id` int(11) NOT NULL default '0',
  `entry_id` int(11) NOT NULL default '0',
  `source` enum('blog','cms','rss','blogmark','column','bbs') NOT NULL default 'rss',
  `author` varchar(255) NOT NULL default '',
  `commentnum` mediumint(9) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `entry_id_2` (`entry_id`),
  KEY `datetime` (`datetime`),
  KEY `feed_id` (`feed_id`),
  KEY `entry_id` (`entry_id`),
  KEY `source` (`source`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;
";
$sql[] = "
CREATE TABLE `rss_feed_attach` (
  `id` int(11) NOT NULL auto_increment,
  `feed_id` int(11) NOT NULL default '0',
  `subject_id` smallint(6) NOT NULL default '0',
  `source` enum('blog','cms','rss','blogmark','column','bbs') NOT NULL default 'rss',
  PRIMARY KEY  (`id`),
  KEY `feed_id` (`feed_id`),
  KEY `subject_id` (`subject_id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;
";
$sql[] = "

CREATE TABLE `special` (
  `id` mediumint(9) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `dir_name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;
";
$sql[] = "

CREATE TABLE `special_subject` (
  `id` mediumint(9) NOT NULL auto_increment,
  `special_id` mediumint(9) NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `special_id` (`special_id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;
";
$sql[] = "
CREATE TABLE `subject` (
  `id` smallint(6) NOT NULL auto_increment,
  `parent_id` smallint(6) NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  `dir_name` varchar(50) NOT NULL default '',
  `sort` tinyint(4) NOT NULL default '0',
  `category` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `sort` (`sort`),
  KEY `category` (`category`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;
";
$sql[] = "
CREATE TABLE `template` (
  `id` smallint(6) NOT NULL auto_increment,
  `special_id` smallint(6) NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  `path` varchar(255) NOT NULL default '',
  `file_name` varchar(50) NOT NULL default '',
  `sort` tinyint(4) NOT NULL default '0',
  `is_default` enum('Y','N') NOT NULL default 'N',
  `subject_id` smallint(6) NOT NULL default '0',
  `special_subject_id` mediumint(9) NOT NULL default '0',
  `is_more` enum('Y','N') NOT NULL default 'N',
  `cur_page_num` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `channel_id` (`special_id`),
  KEY `sort` (`sort`),
  KEY `is_default` (`is_default`),
  KEY `subject_id` (`subject_id`),
  KEY `special_subject_id` (`special_subject_id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;
";
$sql[] = "
CREATE TABLE `template_block` (
  `id` mediumint(9) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `content` text NOT NULL,
  `template_id` smallint(6) NOT NULL default '0',
  `format` varchar(255) NOT NULL default '',
  `subject_id` smallint(6) NOT NULL default '0',
  `source` varchar(255) NOT NULL default '',
  `start_id` smallint(6) NOT NULL default '0',
  `num` smallint(6) NOT NULL default '0',
  `mark` tinyint(4) NOT NULL default '0',
  `selected_subject_id` smallint(6) NOT NULL default '0',
  `time` smallint(6) NOT NULL default '0',
  `title_length` smallint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `template_id` (`template_id`),
  KEY `subject_id` (`subject_id`),
  KEY `mark` (`mark`),
  KEY `selected_subject_id` (`selected_subject_id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;
";
$sql[] = "
CREATE TABLE `template_slash` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `template_id` smallint(6) NOT NULL default '0',
  `content` text NOT NULL,
  `category` enum('image','text','ad','block') NOT NULL default 'text',
  `block_id` smallint(6) NOT NULL default '0',
  taxis smallint(4) NOT NULL default '1000',
  PRIMARY KEY  (`id`),
  KEY `template_id` (`template_id`),
  KEY `category` (`category`),
  KEY `block_id` (`block_id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;
";
?>