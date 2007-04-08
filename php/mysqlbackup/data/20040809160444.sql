# phpbb 
# MySQL数据库备份与恢复系统　ver0.01
# Copyleft @ 2004 by 孙广智
# 主机名：localhost  数据库名：phpbb
#---------------------------------------------------
#
# MySQL Server Version: 4.0.20-standard
#;
use phpbb;
# 数据表　phpbb_auth_access　的结构;
DROP TABLE IF EXISTS `phpbb_auth_access`;
CREATE TABLE `phpbb_auth_access` (
  `group_id` mediumint(8) NOT NULL default '0',
  `forum_id` smallint(5) unsigned NOT NULL default '0',
  `auth_view` tinyint(1) NOT NULL default '0',
  `auth_read` tinyint(1) NOT NULL default '0',
  `auth_post` tinyint(1) NOT NULL default '0',
  `auth_reply` tinyint(1) NOT NULL default '0',
  `auth_edit` tinyint(1) NOT NULL default '0',
  `auth_delete` tinyint(1) NOT NULL default '0',
  `auth_sticky` tinyint(1) NOT NULL default '0',
  `auth_announce` tinyint(1) NOT NULL default '0',
  `auth_vote` tinyint(1) NOT NULL default '0',
  `auth_pollcreate` tinyint(1) NOT NULL default '0',
  `auth_attachments` tinyint(1) NOT NULL default '0',
  `auth_mod` tinyint(1) NOT NULL default '0',
  KEY `group_id` (`group_id`),
  KEY `forum_id` (`forum_id`)
) TYPE=MyISAM;
#
# 向表　phpbb_auth_access　中插入数据;
#
# 数据表　phpbb_banlist　的结构;
DROP TABLE IF EXISTS `phpbb_banlist`;
CREATE TABLE `phpbb_banlist` (
  `ban_id` mediumint(8) unsigned NOT NULL auto_increment,
  `ban_userid` mediumint(8) NOT NULL default '0',
  `ban_ip` varchar(8) NOT NULL default '',
  `ban_email` varchar(255) default NULL,
  PRIMARY KEY  (`ban_id`),
  KEY `ban_ip_user_id` (`ban_ip`,`ban_userid`)
) TYPE=MyISAM;
#
# 向表　phpbb_banlist　中插入数据;
#
# 数据表　phpbb_categories　的结构;
DROP TABLE IF EXISTS `phpbb_categories`;
CREATE TABLE `phpbb_categories` (
  `cat_id` mediumint(8) unsigned NOT NULL auto_increment,
  `cat_title` varchar(100) default NULL,
  `cat_order` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`cat_id`),
  KEY `cat_order` (`cat_order`)
) TYPE=MyISAM;
#
# 向表　phpbb_categories　中插入数据;
#
insert into `phpbb_categories` ( `cat_id`,  `cat_title`,  `cat_order`) values ("1", "Test category 1", "10");
# 数据表　phpbb_config　的结构;
DROP TABLE IF EXISTS `phpbb_config`;
CREATE TABLE `phpbb_config` (
  `config_name` varchar(255) NOT NULL default '',
  `config_value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`config_name`)
) TYPE=MyISAM;
#
# 向表　phpbb_config　中插入数据;
#
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("config_id", "1");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("board_disable", "0");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("sitename", "yourdomain.com");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("site_desc", "A _little_ text to describe your forum");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("cookie_name", "phpbb2mysql");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("cookie_path", "/");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("cookie_domain", "www.sgz.com");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("cookie_secure", "0");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("session_length", "3600");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("allow_html", "0");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("allow_html_tags", "b,i,u,pre");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("allow_bbcode", "1");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("allow_smilies", "1");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("allow_sig", "1");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("allow_namechange", "0");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("allow_theme_create", "0");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("allow_avatar_local", "0");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("allow_avatar_remote", "0");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("allow_avatar_upload", "0");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("override_user_style", "0");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("posts_per_page", "15");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("topics_per_page", "50");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("hot_threshold", "25");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("max_poll_options", "10");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("max_sig_chars", "255");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("max_inbox_privmsgs", "50");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("max_sentbox_privmsgs", "25");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("max_savebox_privmsgs", "50");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("board_email_sig", "Thanks, The Management");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("board_email", "root@www.sgz.com");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("smtp_delivery", "0");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("smtp_host", "");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("smtp_username", "");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("smtp_password", "");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("require_activation", "0");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("flood_interval", "15");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("board_email_form", "0");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("avatar_filesize", "6144");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("avatar_max_width", "80");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("avatar_max_height", "80");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("avatar_path", "images/avatars");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("avatar_gallery_path", "images/avatars/gallery");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("smilies_path", "images/smiles");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("default_style", "1");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("default_dateformat", "D M d, Y g:i a");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("board_timezone", "0");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("prune_enable", "1");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("privmsg_disable", "0");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("gzip_compress", "0");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("coppa_fax", "");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("coppa_mail", "");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("record_online_users", "0");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("record_online_date", "0");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("server_name", "www.sgz.com");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("server_port", "80");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("script_path", "/phpBB2/");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("version", ".0.2");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("board_startdate", "1090922485");
insert into `phpbb_config` ( `config_name`,  `config_value`) values ("default_lang", "chinese_simplified");
# 数据表　phpbb_disallow　的结构;
DROP TABLE IF EXISTS `phpbb_disallow`;
CREATE TABLE `phpbb_disallow` (
  `disallow_id` mediumint(8) unsigned NOT NULL auto_increment,
  `disallow_username` varchar(25) default NULL,
  PRIMARY KEY  (`disallow_id`)
) TYPE=MyISAM;
#
# 向表　phpbb_disallow　中插入数据;
#
# 数据表　phpbb_forum_prune　的结构;
DROP TABLE IF EXISTS `phpbb_forum_prune`;
CREATE TABLE `phpbb_forum_prune` (
  `prune_id` mediumint(8) unsigned NOT NULL auto_increment,
  `forum_id` smallint(5) unsigned NOT NULL default '0',
  `prune_days` tinyint(4) unsigned NOT NULL default '0',
  `prune_freq` tinyint(4) unsigned NOT NULL default '0',
  PRIMARY KEY  (`prune_id`),
  KEY `forum_id` (`forum_id`)
) TYPE=MyISAM;
#
# 向表　phpbb_forum_prune　中插入数据;
#
# 数据表　phpbb_forums　的结构;
DROP TABLE IF EXISTS `phpbb_forums`;
CREATE TABLE `phpbb_forums` (
  `forum_id` smallint(5) unsigned NOT NULL default '0',
  `cat_id` mediumint(8) unsigned NOT NULL default '0',
  `forum_name` varchar(150) default NULL,
  `forum_desc` text,
  `forum_status` tinyint(4) NOT NULL default '0',
  `forum_order` mediumint(8) unsigned NOT NULL default '1',
  `forum_posts` mediumint(8) unsigned NOT NULL default '0',
  `forum_topics` mediumint(8) unsigned NOT NULL default '0',
  `forum_last_post_id` mediumint(8) unsigned NOT NULL default '0',
  `prune_next` int(11) default NULL,
  `prune_enable` tinyint(1) NOT NULL default '0',
  `auth_view` tinyint(2) NOT NULL default '0',
  `auth_read` tinyint(2) NOT NULL default '0',
  `auth_post` tinyint(2) NOT NULL default '0',
  `auth_reply` tinyint(2) NOT NULL default '0',
  `auth_edit` tinyint(2) NOT NULL default '0',
  `auth_delete` tinyint(2) NOT NULL default '0',
  `auth_sticky` tinyint(2) NOT NULL default '0',
  `auth_announce` tinyint(2) NOT NULL default '0',
  `auth_vote` tinyint(2) NOT NULL default '0',
  `auth_pollcreate` tinyint(2) NOT NULL default '0',
  `auth_attachments` tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (`forum_id`),
  KEY `forums_order` (`forum_order`),
  KEY `cat_id` (`cat_id`),
  KEY `forum_last_post_id` (`forum_last_post_id`)
) TYPE=MyISAM;
#
# 向表　phpbb_forums　中插入数据;
#
insert into `phpbb_forums` ( `forum_id`,  `cat_id`,  `forum_name`,  `forum_desc`,  `forum_status`,  `forum_order`,  `forum_posts`,  `forum_topics`,  `forum_last_post_id`,  `prune_next`,  `prune_enable`,  `auth_view`,  `auth_read`,  `auth_post`,  `auth_reply`,  `auth_edit`,  `auth_delete`,  `auth_sticky`,  `auth_announce`,  `auth_vote`,  `auth_pollcreate`,  `auth_attachments`) values ("1", "1", "Test Forum 1", "This is just a test forum.", "0", "10", "1", "1", "1", "0", "0", "0", "0", "0", "0", "1", "1", "1", "3", "1", "1", "3");
# 数据表　phpbb_groups　的结构;
DROP TABLE IF EXISTS `phpbb_groups`;
CREATE TABLE `phpbb_groups` (
  `group_id` mediumint(8) NOT NULL auto_increment,
  `group_type` tinyint(4) NOT NULL default '1',
  `group_name` varchar(40) NOT NULL default '',
  `group_description` varchar(255) NOT NULL default '',
  `group_moderator` mediumint(8) NOT NULL default '0',
  `group_single_user` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`group_id`),
  KEY `group_single_user` (`group_single_user`)
) TYPE=MyISAM;
#
# 向表　phpbb_groups　中插入数据;
#
insert into `phpbb_groups` ( `group_id`,  `group_type`,  `group_name`,  `group_description`,  `group_moderator`,  `group_single_user`) values ("1", "1", "Anonymous", "Personal User", "0", "1");
insert into `phpbb_groups` ( `group_id`,  `group_type`,  `group_name`,  `group_description`,  `group_moderator`,  `group_single_user`) values ("2", "1", "Admin", "Personal User", "0", "1");
# 数据表　phpbb_posts　的结构;
DROP TABLE IF EXISTS `phpbb_posts`;
CREATE TABLE `phpbb_posts` (
  `post_id` mediumint(8) unsigned NOT NULL auto_increment,
  `topic_id` mediumint(8) unsigned NOT NULL default '0',
  `forum_id` smallint(5) unsigned NOT NULL default '0',
  `poster_id` mediumint(8) NOT NULL default '0',
  `post_time` int(11) NOT NULL default '0',
  `poster_ip` varchar(8) NOT NULL default '',
  `post_username` varchar(25) default NULL,
  `enable_bbcode` tinyint(1) NOT NULL default '1',
  `enable_html` tinyint(1) NOT NULL default '0',
  `enable_smilies` tinyint(1) NOT NULL default '1',
  `enable_sig` tinyint(1) NOT NULL default '1',
  `post_edit_time` int(11) default NULL,
  `post_edit_count` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`post_id`),
  KEY `forum_id` (`forum_id`),
  KEY `topic_id` (`topic_id`),
  KEY `poster_id` (`poster_id`),
  KEY `post_time` (`post_time`)
) TYPE=MyISAM;
#
# 向表　phpbb_posts　中插入数据;
#
insert into `phpbb_posts` ( `post_id`,  `topic_id`,  `forum_id`,  `poster_id`,  `post_time`,  `poster_ip`,  `post_username`,  `enable_bbcode`,  `enable_html`,  `enable_smilies`,  `enable_sig`,  `post_edit_time`,  `post_edit_count`) values ("1", "1", "1", "2", "972086460", "7F000001", "", "1", "0", "1", "1", "0", "0");
# 数据表　phpbb_posts_text　的结构;
DROP TABLE IF EXISTS `phpbb_posts_text`;
CREATE TABLE `phpbb_posts_text` (
  `post_id` mediumint(8) unsigned NOT NULL default '0',
  `bbcode_uid` varchar(10) NOT NULL default '',
  `post_subject` varchar(60) default NULL,
  `post_text` text,
  PRIMARY KEY  (`post_id`)
) TYPE=MyISAM;
#
# 向表　phpbb_posts_text　中插入数据;
#
insert into `phpbb_posts_text` ( `post_id`,  `bbcode_uid`,  `post_subject`,  `post_text`) values ("1", "", "", "This is an example post in your phpBB 2 installation. You may delete this post, this topic and even this forum if you like since everything seems to be working!");
# 数据表　phpbb_privmsgs　的结构;
DROP TABLE IF EXISTS `phpbb_privmsgs`;
CREATE TABLE `phpbb_privmsgs` (
  `privmsgs_id` mediumint(8) unsigned NOT NULL auto_increment,
  `privmsgs_type` tinyint(4) NOT NULL default '0',
  `privmsgs_subject` varchar(255) NOT NULL default '0',
  `privmsgs_from_userid` mediumint(8) NOT NULL default '0',
  `privmsgs_to_userid` mediumint(8) NOT NULL default '0',
  `privmsgs_date` int(11) NOT NULL default '0',
  `privmsgs_ip` varchar(8) NOT NULL default '',
  `privmsgs_enable_bbcode` tinyint(1) NOT NULL default '1',
  `privmsgs_enable_html` tinyint(1) NOT NULL default '0',
  `privmsgs_enable_smilies` tinyint(1) NOT NULL default '1',
  `privmsgs_attach_sig` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`privmsgs_id`),
  KEY `privmsgs_from_userid` (`privmsgs_from_userid`),
  KEY `privmsgs_to_userid` (`privmsgs_to_userid`)
) TYPE=MyISAM;
#
# 向表　phpbb_privmsgs　中插入数据;
#
# 数据表　phpbb_privmsgs_text　的结构;
DROP TABLE IF EXISTS `phpbb_privmsgs_text`;
CREATE TABLE `phpbb_privmsgs_text` (
  `privmsgs_text_id` mediumint(8) unsigned NOT NULL default '0',
  `privmsgs_bbcode_uid` varchar(10) NOT NULL default '0',
  `privmsgs_text` text,
  PRIMARY KEY  (`privmsgs_text_id`)
) TYPE=MyISAM;
#
# 向表　phpbb_privmsgs_text　中插入数据;
#
# 数据表　phpbb_ranks　的结构;
DROP TABLE IF EXISTS `phpbb_ranks`;
CREATE TABLE `phpbb_ranks` (
  `rank_id` smallint(5) unsigned NOT NULL auto_increment,
  `rank_title` varchar(50) NOT NULL default '',
  `rank_min` mediumint(8) NOT NULL default '0',
  `rank_special` tinyint(1) default '0',
  `rank_image` varchar(255) default NULL,
  PRIMARY KEY  (`rank_id`)
) TYPE=MyISAM;
#
# 向表　phpbb_ranks　中插入数据;
#
insert into `phpbb_ranks` ( `rank_id`,  `rank_title`,  `rank_min`,  `rank_special`,  `rank_image`) values ("1", "Site Admin", "-1", "1", "");
# 数据表　phpbb_search_results　的结构;
DROP TABLE IF EXISTS `phpbb_search_results`;
CREATE TABLE `phpbb_search_results` (
  `search_id` int(11) unsigned NOT NULL default '0',
  `session_id` varchar(32) NOT NULL default '',
  `search_array` text NOT NULL,
  PRIMARY KEY  (`search_id`),
  KEY `session_id` (`session_id`)
) TYPE=MyISAM;
#
# 向表　phpbb_search_results　中插入数据;
#
# 数据表　phpbb_search_wordlist　的结构;
DROP TABLE IF EXISTS `phpbb_search_wordlist`;
CREATE TABLE `phpbb_search_wordlist` (
  `word_text` varchar(50) binary NOT NULL default '',
  `word_id` mediumint(8) unsigned NOT NULL auto_increment,
  `word_common` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`word_text`),
  KEY `word_id` (`word_id`)
) TYPE=MyISAM;
#
# 向表　phpbb_search_wordlist　中插入数据;
#
insert into `phpbb_search_wordlist` ( `word_text`,  `word_id`,  `word_common`) values ("example", "1", "0");
insert into `phpbb_search_wordlist` ( `word_text`,  `word_id`,  `word_common`) values ("post", "2", "0");
insert into `phpbb_search_wordlist` ( `word_text`,  `word_id`,  `word_common`) values ("phpbb", "3", "0");
insert into `phpbb_search_wordlist` ( `word_text`,  `word_id`,  `word_common`) values ("installation", "4", "0");
insert into `phpbb_search_wordlist` ( `word_text`,  `word_id`,  `word_common`) values ("delete", "5", "0");
insert into `phpbb_search_wordlist` ( `word_text`,  `word_id`,  `word_common`) values ("topic", "6", "0");
insert into `phpbb_search_wordlist` ( `word_text`,  `word_id`,  `word_common`) values ("forum", "7", "0");
insert into `phpbb_search_wordlist` ( `word_text`,  `word_id`,  `word_common`) values ("since", "8", "0");
insert into `phpbb_search_wordlist` ( `word_text`,  `word_id`,  `word_common`) values ("everything", "9", "0");
insert into `phpbb_search_wordlist` ( `word_text`,  `word_id`,  `word_common`) values ("seems", "10", "0");
insert into `phpbb_search_wordlist` ( `word_text`,  `word_id`,  `word_common`) values ("working", "11", "0");
insert into `phpbb_search_wordlist` ( `word_text`,  `word_id`,  `word_common`) values ("welcome", "12", "0");
# 数据表　phpbb_search_wordmatch　的结构;
DROP TABLE IF EXISTS `phpbb_search_wordmatch`;
CREATE TABLE `phpbb_search_wordmatch` (
  `post_id` mediumint(8) unsigned NOT NULL default '0',
  `word_id` mediumint(8) unsigned NOT NULL default '0',
  `title_match` tinyint(1) NOT NULL default '0',
  KEY `word_id` (`word_id`)
) TYPE=MyISAM;
#
# 向表　phpbb_search_wordmatch　中插入数据;
#
insert into `phpbb_search_wordmatch` ( `post_id`,  `word_id`,  `title_match`) values ("1", "1", "0");
insert into `phpbb_search_wordmatch` ( `post_id`,  `word_id`,  `title_match`) values ("1", "2", "0");
insert into `phpbb_search_wordmatch` ( `post_id`,  `word_id`,  `title_match`) values ("1", "3", "0");
insert into `phpbb_search_wordmatch` ( `post_id`,  `word_id`,  `title_match`) values ("1", "4", "0");
insert into `phpbb_search_wordmatch` ( `post_id`,  `word_id`,  `title_match`) values ("1", "5", "0");
insert into `phpbb_search_wordmatch` ( `post_id`,  `word_id`,  `title_match`) values ("1", "6", "0");
insert into `phpbb_search_wordmatch` ( `post_id`,  `word_id`,  `title_match`) values ("1", "7", "0");
insert into `phpbb_search_wordmatch` ( `post_id`,  `word_id`,  `title_match`) values ("1", "8", "0");
insert into `phpbb_search_wordmatch` ( `post_id`,  `word_id`,  `title_match`) values ("1", "9", "0");
insert into `phpbb_search_wordmatch` ( `post_id`,  `word_id`,  `title_match`) values ("1", "10", "0");
insert into `phpbb_search_wordmatch` ( `post_id`,  `word_id`,  `title_match`) values ("1", "11", "0");
insert into `phpbb_search_wordmatch` ( `post_id`,  `word_id`,  `title_match`) values ("1", "12", "1");
insert into `phpbb_search_wordmatch` ( `post_id`,  `word_id`,  `title_match`) values ("1", "3", "1");
# 数据表　phpbb_sessions　的结构;
DROP TABLE IF EXISTS `phpbb_sessions`;
CREATE TABLE `phpbb_sessions` (
  `session_id` char(32) NOT NULL default '',
  `session_user_id` mediumint(8) NOT NULL default '0',
  `session_start` int(11) NOT NULL default '0',
  `session_time` int(11) NOT NULL default '0',
  `session_ip` char(8) NOT NULL default '0',
  `session_page` int(11) NOT NULL default '0',
  `session_logged_in` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`session_id`),
  KEY `session_user_id` (`session_user_id`),
  KEY `session_id_ip_user_id` (`session_id`,`session_ip`,`session_user_id`)
) TYPE=HEAP MAX_ROWS=500;
#
# 向表　phpbb_sessions　中插入数据;
#
# 数据表　phpbb_smilies　的结构;
DROP TABLE IF EXISTS `phpbb_smilies`;
CREATE TABLE `phpbb_smilies` (
  `smilies_id` smallint(5) unsigned NOT NULL auto_increment,
  `code` varchar(50) default NULL,
  `smile_url` varchar(100) default NULL,
  `emoticon` varchar(75) default NULL,
  PRIMARY KEY  (`smilies_id`)
) TYPE=MyISAM;
#
# 向表　phpbb_smilies　中插入数据;
#
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("1", ":D", "icon_biggrin.gif", "Very Happy");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("2", ":-D", "icon_biggrin.gif", "Very Happy");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("3", ":grin:", "icon_biggrin.gif", "Very Happy");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("4", ":)", "icon_smile.gif", "Smile");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("5", ":-)", "icon_smile.gif", "Smile");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("6", ":smile:", "icon_smile.gif", "Smile");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("7", ":(", "icon_sad.gif", "Sad");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("8", ":-(", "icon_sad.gif", "Sad");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("9", ":sad:", "icon_sad.gif", "Sad");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("10", ":o", "icon_surprised.gif", "Surprised");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("11", ":-o", "icon_surprised.gif", "Surprised");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("12", ":eek:", "icon_surprised.gif", "Surprised");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("13", ":shock:", "icon_eek.gif", "Shocked");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("14", ":?", "icon_confused.gif", "Confused");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("15", ":-?", "icon_confused.gif", "Confused");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("16", ":???:", "icon_confused.gif", "Confused");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("17", "8)", "icon_cool.gif", "Cool");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("18", "8-)", "icon_cool.gif", "Cool");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("19", ":cool:", "icon_cool.gif", "Cool");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("20", ":lol:", "icon_lol.gif", "Laughing");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("21", ":x", "icon_mad.gif", "Mad");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("22", ":-x", "icon_mad.gif", "Mad");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("23", ":mad:", "icon_mad.gif", "Mad");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("24", ":P", "icon_razz.gif", "Razz");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("25", ":-P", "icon_razz.gif", "Razz");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("26", ":razz:", "icon_razz.gif", "Razz");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("27", ":oops:", "icon_redface.gif", "Embarassed");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("28", ":cry:", "icon_cry.gif", "Crying or Very sad");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("29", ":evil:", "icon_evil.gif", "Evil or Very Mad");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("30", ":twisted:", "icon_twisted.gif", "Twisted Evil");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("31", ":roll:", "icon_rolleyes.gif", "Rolling Eyes");
insert into `phpbb_smilies` ( `smilies_id`,  `code`,  `smile_url`,  `emoticon`) values ("32", ":wink:", "icon_wink.gif", "Wink");
# 数据表　phpbb_themes　的结构;
DROP TABLE IF EXISTS `phpbb_themes`;
CREATE TABLE `phpbb_themes` (
  `themes_id` mediumint(8) unsigned NOT NULL auto_increment,
  `template_name` varchar(30) NOT NULL default '',
  `style_name` varchar(30) NOT NULL default '',
  `head_stylesheet` varchar(100) default NULL,
  `body_background` varchar(100) default NULL,
  `body_bgcolor` varchar(6) default NULL,
  `body_text` varchar(6) default NULL,
  `body_link` varchar(6) default NULL,
  `body_vlink` varchar(6) default NULL,
  `body_alink` varchar(6) default NULL,
  `body_hlink` varchar(6) default NULL,
  `tr_color1` varchar(6) default NULL,
  `tr_color2` varchar(6) default NULL,
  `tr_color3` varchar(6) default NULL,
  `tr_class1` varchar(25) default NULL,
  `tr_class2` varchar(25) default NULL,
  `tr_class3` varchar(25) default NULL,
  `th_color1` varchar(6) default NULL,
  `th_color2` varchar(6) default NULL,
  `th_color3` varchar(6) default NULL,
  `th_class1` varchar(25) default NULL,
  `th_class2` varchar(25) default NULL,
  `th_class3` varchar(25) default NULL,
  `td_color1` varchar(6) default NULL,
  `td_color2` varchar(6) default NULL,
  `td_color3` varchar(6) default NULL,
  `td_class1` varchar(25) default NULL,
  `td_class2` varchar(25) default NULL,
  `td_class3` varchar(25) default NULL,
  `fontface1` varchar(50) default NULL,
  `fontface2` varchar(50) default NULL,
  `fontface3` varchar(50) default NULL,
  `fontsize1` tinyint(4) default NULL,
  `fontsize2` tinyint(4) default NULL,
  `fontsize3` tinyint(4) default NULL,
  `fontcolor1` varchar(6) default NULL,
  `fontcolor2` varchar(6) default NULL,
  `fontcolor3` varchar(6) default NULL,
  `span_class1` varchar(25) default NULL,
  `span_class2` varchar(25) default NULL,
  `span_class3` varchar(25) default NULL,
  `img_size_poll` smallint(5) unsigned default NULL,
  `img_size_privmsg` smallint(5) unsigned default NULL,
  PRIMARY KEY  (`themes_id`)
) TYPE=MyISAM;
#
# 向表　phpbb_themes　中插入数据;
#
insert into `phpbb_themes` ( `themes_id`,  `template_name`,  `style_name`,  `head_stylesheet`,  `body_background`,  `body_bgcolor`,  `body_text`,  `body_link`,  `body_vlink`,  `body_alink`,  `body_hlink`,  `tr_color1`,  `tr_color2`,  `tr_color3`,  `tr_class1`,  `tr_class2`,  `tr_class3`,  `th_color1`,  `th_color2`,  `th_color3`,  `th_class1`,  `th_class2`,  `th_class3`,  `td_color1`,  `td_color2`,  `td_color3`,  `td_class1`,  `td_class2`,  `td_class3`,  `fontface1`,  `fontface2`,  `fontface3`,  `fontsize1`,  `fontsize2`,  `fontsize3`,  `fontcolor1`,  `fontcolor2`,  `fontcolor3`,  `span_class1`,  `span_class2`,  `span_class3`,  `img_size_poll`,  `img_size_privmsg`) values ("1", "subSilver", "subSilver", "subSilver.css", "", "E5E5E5", "000000", "006699", "5493B4", "", "DD6900", "EFEFEF", "DEE3E7", "D1D7DC", "", "", "", "98AAB1", "006699", "FFFFFF", "cellpic1.gif", "cellpic3.gif", "cellpic2.jpg", "FAFAFA", "FFFFFF", "", "row1", "row2", "", "Verdana, Arial, Helvetica, sans-serif", "Trebuchet MS", "Courier, 'Courier New', sans-serif", "10", "11", "12", "444444", "006600", "FFA34F", "", "", "", "", "");
# 数据表　phpbb_themes_name　的结构;
DROP TABLE IF EXISTS `phpbb_themes_name`;
CREATE TABLE `phpbb_themes_name` (
  `themes_id` smallint(5) unsigned NOT NULL default '0',
  `tr_color1_name` char(50) default NULL,
  `tr_color2_name` char(50) default NULL,
  `tr_color3_name` char(50) default NULL,
  `tr_class1_name` char(50) default NULL,
  `tr_class2_name` char(50) default NULL,
  `tr_class3_name` char(50) default NULL,
  `th_color1_name` char(50) default NULL,
  `th_color2_name` char(50) default NULL,
  `th_color3_name` char(50) default NULL,
  `th_class1_name` char(50) default NULL,
  `th_class2_name` char(50) default NULL,
  `th_class3_name` char(50) default NULL,
  `td_color1_name` char(50) default NULL,
  `td_color2_name` char(50) default NULL,
  `td_color3_name` char(50) default NULL,
  `td_class1_name` char(50) default NULL,
  `td_class2_name` char(50) default NULL,
  `td_class3_name` char(50) default NULL,
  `fontface1_name` char(50) default NULL,
  `fontface2_name` char(50) default NULL,
  `fontface3_name` char(50) default NULL,
  `fontsize1_name` char(50) default NULL,
  `fontsize2_name` char(50) default NULL,
  `fontsize3_name` char(50) default NULL,
  `fontcolor1_name` char(50) default NULL,
  `fontcolor2_name` char(50) default NULL,
  `fontcolor3_name` char(50) default NULL,
  `span_class1_name` char(50) default NULL,
  `span_class2_name` char(50) default NULL,
  `span_class3_name` char(50) default NULL,
  PRIMARY KEY  (`themes_id`)
) TYPE=MyISAM;
#
# 向表　phpbb_themes_name　中插入数据;
#
insert into `phpbb_themes_name` ( `themes_id`,  `tr_color1_name`,  `tr_color2_name`,  `tr_color3_name`,  `tr_class1_name`,  `tr_class2_name`,  `tr_class3_name`,  `th_color1_name`,  `th_color2_name`,  `th_color3_name`,  `th_class1_name`,  `th_class2_name`,  `th_class3_name`,  `td_color1_name`,  `td_color2_name`,  `td_color3_name`,  `td_class1_name`,  `td_class2_name`,  `td_class3_name`,  `fontface1_name`,  `fontface2_name`,  `fontface3_name`,  `fontsize1_name`,  `fontsize2_name`,  `fontsize3_name`,  `fontcolor1_name`,  `fontcolor2_name`,  `fontcolor3_name`,  `span_class1_name`,  `span_class2_name`,  `span_class3_name`) values ("1", "The lightest row colour", "The medium row color", "The darkest row colour", "", "", "", "Border round the whole page", "Outer table border", "Inner table border", "Silver gradient picture", "Blue gradient picture", "Fade-out gradient on index", "Background for quote boxes", "All white areas", "", "Background for topic posts", "2nd background for topic posts", "", "Main fonts", "Additional topic title font", "Form fonts", "Smallest font size", "Medium font size", "Normal font size (post body etc)", "Quote & copyright text", "Code text colour", "Main table header text colour", "", "", "");
# 数据表　phpbb_topics　的结构;
DROP TABLE IF EXISTS `phpbb_topics`;
CREATE TABLE `phpbb_topics` (
  `topic_id` mediumint(8) unsigned NOT NULL auto_increment,
  `forum_id` smallint(8) unsigned NOT NULL default '0',
  `topic_title` char(60) NOT NULL default '',
  `topic_poster` mediumint(8) NOT NULL default '0',
  `topic_time` int(11) NOT NULL default '0',
  `topic_views` mediumint(8) unsigned NOT NULL default '0',
  `topic_replies` mediumint(8) unsigned NOT NULL default '0',
  `topic_status` tinyint(3) NOT NULL default '0',
  `topic_vote` tinyint(1) NOT NULL default '0',
  `topic_type` tinyint(3) NOT NULL default '0',
  `topic_first_post_id` mediumint(8) unsigned NOT NULL default '0',
  `topic_last_post_id` mediumint(8) unsigned NOT NULL default '0',
  `topic_moved_id` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`topic_id`),
  KEY `forum_id` (`forum_id`),
  KEY `topic_moved_id` (`topic_moved_id`),
  KEY `topic_status` (`topic_status`),
  KEY `topic_type` (`topic_type`)
) TYPE=MyISAM;
#
# 向表　phpbb_topics　中插入数据;
#
insert into `phpbb_topics` ( `topic_id`,  `forum_id`,  `topic_title`,  `topic_poster`,  `topic_time`,  `topic_views`,  `topic_replies`,  `topic_status`,  `topic_vote`,  `topic_type`,  `topic_first_post_id`,  `topic_last_post_id`,  `topic_moved_id`) values ("1", "1", "Welcome to phpBB 2", "2", "972086460", "0", "0", "0", "0", "0", "1", "1", "0");
# 数据表　phpbb_topics_watch　的结构;
DROP TABLE IF EXISTS `phpbb_topics_watch`;
CREATE TABLE `phpbb_topics_watch` (
  `topic_id` mediumint(8) unsigned NOT NULL default '0',
  `user_id` mediumint(8) NOT NULL default '0',
  `notify_status` tinyint(1) NOT NULL default '0',
  KEY `topic_id` (`topic_id`),
  KEY `user_id` (`user_id`),
  KEY `notify_status` (`notify_status`)
) TYPE=MyISAM;
#
# 向表　phpbb_topics_watch　中插入数据;
#
# 数据表　phpbb_user_group　的结构;
DROP TABLE IF EXISTS `phpbb_user_group`;
CREATE TABLE `phpbb_user_group` (
  `group_id` mediumint(8) NOT NULL default '0',
  `user_id` mediumint(8) NOT NULL default '0',
  `user_pending` tinyint(1) default NULL,
  KEY `group_id` (`group_id`),
  KEY `user_id` (`user_id`)
) TYPE=MyISAM;
#
# 向表　phpbb_user_group　中插入数据;
#
insert into `phpbb_user_group` ( `group_id`,  `user_id`,  `user_pending`) values ("1", "-1", "0");
insert into `phpbb_user_group` ( `group_id`,  `user_id`,  `user_pending`) values ("2", "2", "0");
# 数据表　phpbb_users　的结构;
DROP TABLE IF EXISTS `phpbb_users`;
CREATE TABLE `phpbb_users` (
  `user_id` mediumint(8) NOT NULL default '0',
  `user_active` tinyint(1) default '1',
  `username` varchar(25) NOT NULL default '',
  `user_password` varchar(32) NOT NULL default '',
  `user_session_time` int(11) NOT NULL default '0',
  `user_session_page` smallint(5) NOT NULL default '0',
  `user_lastvisit` int(11) NOT NULL default '0',
  `user_regdate` int(11) NOT NULL default '0',
  `user_level` tinyint(4) default '0',
  `user_posts` mediumint(8) unsigned NOT NULL default '0',
  `user_timezone` decimal(4,2) NOT NULL default '0.00',
  `user_style` tinyint(4) default NULL,
  `user_lang` varchar(255) default NULL,
  `user_dateformat` varchar(14) NOT NULL default 'd M Y H:i',
  `user_new_privmsg` smallint(5) unsigned NOT NULL default '0',
  `user_unread_privmsg` smallint(5) unsigned NOT NULL default '0',
  `user_last_privmsg` int(11) NOT NULL default '0',
  `user_emailtime` int(11) default NULL,
  `user_viewemail` tinyint(1) default NULL,
  `user_attachsig` tinyint(1) default NULL,
  `user_allowhtml` tinyint(1) default '1',
  `user_allowbbcode` tinyint(1) default '1',
  `user_allowsmile` tinyint(1) default '1',
  `user_allowavatar` tinyint(1) NOT NULL default '1',
  `user_allow_pm` tinyint(1) NOT NULL default '1',
  `user_allow_viewonline` tinyint(1) NOT NULL default '1',
  `user_notify` tinyint(1) NOT NULL default '1',
  `user_notify_pm` tinyint(1) NOT NULL default '1',
  `user_popup_pm` tinyint(1) NOT NULL default '0',
  `user_rank` int(11) default '0',
  `user_avatar` varchar(100) default NULL,
  `user_avatar_type` tinyint(4) NOT NULL default '0',
  `user_email` varchar(255) default NULL,
  `user_icq` varchar(15) default NULL,
  `user_website` varchar(100) default NULL,
  `user_from` varchar(100) default NULL,
  `user_sig` text,
  `user_sig_bbcode_uid` varchar(10) default NULL,
  `user_aim` varchar(255) default NULL,
  `user_yim` varchar(255) default NULL,
  `user_msnm` varchar(255) default NULL,
  `user_occ` varchar(100) default NULL,
  `user_interests` varchar(255) default NULL,
  `user_actkey` varchar(32) default NULL,
  `user_newpasswd` varchar(32) default NULL,
  PRIMARY KEY  (`user_id`),
  KEY `user_session_time` (`user_session_time`)
) TYPE=MyISAM;
#
# 向表　phpbb_users　中插入数据;
#
insert into `phpbb_users` ( `user_id`,  `user_active`,  `username`,  `user_password`,  `user_session_time`,  `user_session_page`,  `user_lastvisit`,  `user_regdate`,  `user_level`,  `user_posts`,  `user_timezone`,  `user_style`,  `user_lang`,  `user_dateformat`,  `user_new_privmsg`,  `user_unread_privmsg`,  `user_last_privmsg`,  `user_emailtime`,  `user_viewemail`,  `user_attachsig`,  `user_allowhtml`,  `user_allowbbcode`,  `user_allowsmile`,  `user_allowavatar`,  `user_allow_pm`,  `user_allow_viewonline`,  `user_notify`,  `user_notify_pm`,  `user_popup_pm`,  `user_rank`,  `user_avatar`,  `user_avatar_type`,  `user_email`,  `user_icq`,  `user_website`,  `user_from`,  `user_sig`,  `user_sig_bbcode_uid`,  `user_aim`,  `user_yim`,  `user_msnm`,  `user_occ`,  `user_interests`,  `user_actkey`,  `user_newpasswd`) values ("-1", "0", "Anonymous", "", "0", "0", "0", "1090922486", "0", "0", "0.00", "", "", "", "0", "0", "0", "", "0", "0", "0", "1", "1", "1", "0", "1", "0", "1", "0", "", "", "0", "", "", "", "", "", "", "", "", "", "", "", "", "");
insert into `phpbb_users` ( `user_id`,  `user_active`,  `username`,  `user_password`,  `user_session_time`,  `user_session_page`,  `user_lastvisit`,  `user_regdate`,  `user_level`,  `user_posts`,  `user_timezone`,  `user_style`,  `user_lang`,  `user_dateformat`,  `user_new_privmsg`,  `user_unread_privmsg`,  `user_last_privmsg`,  `user_emailtime`,  `user_viewemail`,  `user_attachsig`,  `user_allowhtml`,  `user_allowbbcode`,  `user_allowsmile`,  `user_allowavatar`,  `user_allow_pm`,  `user_allow_viewonline`,  `user_notify`,  `user_notify_pm`,  `user_popup_pm`,  `user_rank`,  `user_avatar`,  `user_avatar_type`,  `user_email`,  `user_icq`,  `user_website`,  `user_from`,  `user_sig`,  `user_sig_bbcode_uid`,  `user_aim`,  `user_yim`,  `user_msnm`,  `user_occ`,  `user_interests`,  `user_actkey`,  `user_newpasswd`) values ("2", "1", "root", "e10adc3949ba59abbe56e057f20f883e", "0", "0", "0", "1090922486", "1", "1", "0.00", "1", "chinese_simplified", "d M Y h:i a", "0", "0", "0", "", "1", "0", "0", "1", "1", "1", "1", "1", "0", "1", "1", "1", "", "0", "root@www.sgz.com", "", "", "", "", "", "", "", "", "", "", "", "");
# 数据表　phpbb_vote_desc　的结构;
DROP TABLE IF EXISTS `phpbb_vote_desc`;
CREATE TABLE `phpbb_vote_desc` (
  `vote_id` mediumint(8) unsigned NOT NULL auto_increment,
  `topic_id` mediumint(8) unsigned NOT NULL default '0',
  `vote_text` text NOT NULL,
  `vote_start` int(11) NOT NULL default '0',
  `vote_length` int(11) NOT NULL default '0',
  PRIMARY KEY  (`vote_id`),
  KEY `topic_id` (`topic_id`)
) TYPE=MyISAM;
#
# 向表　phpbb_vote_desc　中插入数据;
#
# 数据表　phpbb_vote_results　的结构;
DROP TABLE IF EXISTS `phpbb_vote_results`;
CREATE TABLE `phpbb_vote_results` (
  `vote_id` mediumint(8) unsigned NOT NULL default '0',
  `vote_option_id` tinyint(4) unsigned NOT NULL default '0',
  `vote_option_text` varchar(255) NOT NULL default '',
  `vote_result` int(11) NOT NULL default '0',
  KEY `vote_option_id` (`vote_option_id`),
  KEY `vote_id` (`vote_id`)
) TYPE=MyISAM;
#
# 向表　phpbb_vote_results　中插入数据;
#
# 数据表　phpbb_vote_voters　的结构;
DROP TABLE IF EXISTS `phpbb_vote_voters`;
CREATE TABLE `phpbb_vote_voters` (
  `vote_id` mediumint(8) unsigned NOT NULL default '0',
  `vote_user_id` mediumint(8) NOT NULL default '0',
  `vote_user_ip` char(8) NOT NULL default '',
  KEY `vote_id` (`vote_id`),
  KEY `vote_user_id` (`vote_user_id`),
  KEY `vote_user_ip` (`vote_user_ip`)
) TYPE=MyISAM;
#
# 向表　phpbb_vote_voters　中插入数据;
#
# 数据表　phpbb_words　的结构;
DROP TABLE IF EXISTS `phpbb_words`;
CREATE TABLE `phpbb_words` (
  `word_id` mediumint(8) unsigned NOT NULL auto_increment,
  `word` char(100) NOT NULL default '',
  `replacement` char(100) NOT NULL default '',
  PRIMARY KEY  (`word_id`)
) TYPE=MyISAM;
#
# 向表　phpbb_words　中插入数据;
#
