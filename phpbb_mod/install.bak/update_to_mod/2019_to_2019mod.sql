ALTER TABLE phpbb_auth_access ADD auth_globalannounce tinyint(1) NOT NULL;
ALTER TABLE phpbb_auth_access ADD auth_download tinyint(1) DEFAULT '0' NOT NULL;  
ALTER TABLE phpbb_auth_access ADD auth_sellpost TINYINT(1) NOT NULL;
ALTER TABLE phpbb_auth_access ADD auth_hide4reply TINYINT(1) NOT NULL;
ALTER TABLE phpbb_auth_access ADD auth_hide4posts TINYINT(1) NOT NULL;
ALTER TABLE phpbb_auth_access ADD auth_hide4fortune TINYINT(1) NOT NULL;
ALTER TABLE phpbb_auth_access ADD auth_ban TINYINT (1) NOT NULL DEFAULT '0';
ALTER TABLE phpbb_auth_access ADD auth_greencard TINYINT (1) NOT NULL DEFAULT '0';
ALTER TABLE phpbb_auth_access ADD auth_bluecard TINYINT (1) NOT NULL DEFAULT '0';

ALTER TABLE phpbb_forums ADD auth_globalannounce TINYINT (2) DEFAULT '3' NOT NULL;
ALTER TABLE phpbb_forums ADD auth_download TINYINT(2) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_forums ADD auth_sellpost TINYINT(2) DEFAULT '1' NOT NULL;
ALTER TABLE phpbb_forums ADD auth_hide4reply TINYINT(2) DEFAULT '3' NOT NULL;
ALTER TABLE phpbb_forums ADD auth_hide4posts TINYINT(2) DEFAULT '3' NOT NULL;
ALTER TABLE phpbb_forums ADD auth_hide4fortune TINYINT(2) DEFAULT '3' NOT NULL;
ALTER TABLE phpbb_forums ADD auth_ban TINYINT (2) not null DEFAULT '3';
ALTER TABLE phpbb_forums ADD auth_greencard TINYINT (2) not null DEFAULT '5';
ALTER TABLE phpbb_forums ADD auth_bluecard TINYINT (2) not null DEFAULT '1';
ALTER TABLE phpbb_forums ADD auth_commend tinyint(1) DEFAULT '3' NOT NULL;
ALTER TABLE phpbb_forums ADD forum_sub SMALLINT(5) UNSIGNED DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_forums ADD sort_sub SMALLINT(5) UNSIGNED DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_forums ADD main_sub smallint(50) UNSIGNED DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_forums ADD forum_icon varchar(150);

ALTER TABLE phpbb_groups ADD group_allow_pm TINYINT(2) DEFAULT '5' NOT NULL;
ALTER TABLE phpbb_groups ADD group_count INT(4) UNSIGNED DEFAULT '99999999';
ALTER TABLE phpbb_groups ADD group_count_max INT(4) UNSIGNED DEFAULT '99999999';
ALTER TABLE phpbb_groups ADD group_count_enable SMALLINT(2) UNSIGNED DEFAULT '0';

ALTER TABLE phpbb_posts ADD post_attachment TINYINT(1) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_posts ADD hiding_type TINYINT(1) UNSIGNED DEFAULT '0';
ALTER TABLE phpbb_posts	ADD hiding_condition_value INT(11) DEFAULT '0';
ALTER TABLE phpbb_posts	ADD hiding_cash_id SMALLINT(6) DEFAULT '0';
ALTER TABLE phpbb_posts	ADD post_bluecard TINYINT (1);

ALTER TABLE phpbb_privmsgs ADD privmsgs_attachment TINYINT(1) DEFAULT '0' NOT NULL;

ALTER TABLE phpbb_sessions ADD session_admin tinyint(2) DEFAULT '0' NOT NULL;

ALTER TABLE phpbb_themes ADD online_color varchar(6) default NULL;
ALTER TABLE phpbb_themes ADD offline_color varchar(6) default NULL;
ALTER TABLE phpbb_themes ADD hidden_color varchar(6) default NULL;

ALTER TABLE phpbb_topics ADD topic_attachment TINYINT(1) DEFAULT '0' NOT NULL;

ALTER TABLE phpbb_users ADD user_warnings SMALLINT (5) DEFAULT '0';
ALTER TABLE phpbb_users ADD user_birthday INT DEFAULT '999999' NOT NULL;
ALTER TABLE phpbb_users ADD user_next_birthday_greeting INT DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_users ADD user_show_quickreply TINYINT(1) DEFAULT '1' NOT NULL;
ALTER TABLE phpbb_users ADD user_quickreply_mode TINYINT(1) DEFAULT '1' NOT NULL;
ALTER TABLE phpbb_users ADD user_gender TINYINT DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_users ADD user_allow_ag TINYINT(1) DEFAULT '1' NOT NULL;
ALTER TABLE phpbb_users ADD user_allow_mass_pm TINYINT(1) DEFAULT '2' AFTER user_allow_pm;
ALTER TABLE phpbb_users ADD user_skype VARCHAR(255);

ALTER TABLE phpbb_user_group ADD group_moderator TINYINT(1) NOT NULL;

CREATE TABLE phpbb_cash (
  cash_id smallint(6) NOT NULL auto_increment,
  cash_order smallint(6) NOT NULL default '0',
  cash_settings smallint(4) NOT NULL default '3313',
  cash_dbfield varchar(64) NOT NULL default '',
  cash_name varchar(64) NOT NULL default 'GP',
  cash_default int(11) NOT NULL default '0',
  cash_decimals tinyint(2) NOT NULL default '0',
  cash_imageurl varchar(255) NOT NULL default '',
  cash_exchange int(11) NOT NULL default '1',
  cash_perpost int(11) NOT NULL default '25',
  cash_postbonus int(11) NOT NULL default '2',
  cash_perreply int(11) NOT NULL default '25',
  cash_maxearn int(11) NOT NULL default '75',
  cash_perpm int(11) NOT NULL default '0',
  cash_perchar int(11) NOT NULL default '20',
  cash_allowance tinyint(1) NOT NULL default '0',
  cash_allowanceamount int(11) NOT NULL default '0',
  cash_allowancetime tinyint(2) NOT NULL default '2',
  cash_allowancenext int(11) NOT NULL default '0',
  cash_forumlist varchar(255) NOT NULL default '',
  cash_max_sellingprice INT DEFAULT '0' NOT NULL,
  cash_min_sellingprice INT DEFAULT '1' NOT NULL,
  cash_max_fortunerequired INT DEFAULT '0' NOT NULL,
  cash_min_fortunerequired INT DEFAULT '1' NOT NULL,
  PRIMARY KEY  (cash_id)
);

CREATE TABLE phpbb_cash_events (
  event_name varchar(32) NOT NULL default '',
  event_data varchar(255) NOT NULL default '',
  PRIMARY KEY  (event_name)
);

CREATE TABLE phpbb_cash_exchange (
  ex_cash_id1 int(11) NOT NULL default '0',
  ex_cash_id2 int(11) NOT NULL default '0',
  ex_cash_enabled int(1) NOT NULL default '0',
  PRIMARY KEY  (ex_cash_id1,ex_cash_id2)
);

CREATE TABLE phpbb_cash_groups (
  group_id mediumint(6) NOT NULL default '0',
  group_type tinyint(2) NOT NULL default '0',
  cash_id smallint(6) NOT NULL default '0',
  cash_perpost int(11) NOT NULL default '0',
  cash_postbonus int(11) NOT NULL default '0',
  cash_perreply int(11) NOT NULL default '0',
  cash_perchar int(11) NOT NULL default '0',
  cash_maxearn int(11) NOT NULL default '0',
  cash_perpm int(11) NOT NULL default '0',
  cash_allowance tinyint(1) NOT NULL default '0',
  cash_allowanceamount int(11) NOT NULL default '0',
  cash_allowancetime tinyint(2) NOT NULL default '2',
  cash_allowancenext int(11) NOT NULL default '0',
  PRIMARY KEY  (group_id,group_type,cash_id)
);

CREATE TABLE phpbb_cash_log (
  log_id int(11) NOT NULL auto_increment,
  log_time int(11) NOT NULL default '0',
  log_type smallint(6) NOT NULL default '0',
  log_action varchar(255) NOT NULL default '',
  log_text varchar(255) NOT NULL default '',
  PRIMARY KEY  (log_id)
);

CREATE TABLE phpbb_favorites ( 
fav_id int(11) NOT NULL auto_increment, 
user_id int(11) NOT NULL default '0', 
topic_id int(11) NOT NULL default '0', 
PRIMARY KEY (`fav_id`) 
); 


CREATE TABLE phpbb_attachments_config (
  config_name varchar(255) NOT NULL,
  config_value varchar(255) NOT NULL,
  PRIMARY KEY (config_name)
);

CREATE TABLE phpbb_forbidden_extensions (
  ext_id mediumint(8) UNSIGNED NOT NULL auto_increment, 
  extension varchar(100) NOT NULL, 
  PRIMARY KEY (ext_id)
);

CREATE TABLE phpbb_extension_groups (
  group_id mediumint(8) NOT NULL auto_increment,
  group_name char(20) NOT NULL,
  cat_id tinyint(2) DEFAULT '0' NOT NULL, 
  allow_group tinyint(1) DEFAULT '0' NOT NULL,
  download_mode tinyint(1) UNSIGNED DEFAULT '1' NOT NULL,
  upload_icon varchar(100) DEFAULT '',
  max_filesize int(20) DEFAULT '0' NOT NULL,
  forum_permissions varchar(255) default '' NOT NULL,
  PRIMARY KEY group_id (group_id)
);

CREATE TABLE phpbb_extensions (
  ext_id mediumint(8) UNSIGNED NOT NULL auto_increment,
  group_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
  extension varchar(100) NOT NULL,
  comment varchar(100),
  PRIMARY KEY ext_id (ext_id)
);

CREATE TABLE phpbb_attachments_desc (
  attach_id mediumint(8) UNSIGNED NOT NULL auto_increment,
  physical_filename varchar(255) NOT NULL,
  real_filename varchar(255) NOT NULL,
  download_count mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
  comment varchar(255),
  extension varchar(100),
  mimetype varchar(100),
  filesize int(20) NOT NULL,
  filetime int(11) DEFAULT '0' NOT NULL,
  thumbnail tinyint(1) DEFAULT '0' NOT NULL,
  PRIMARY KEY (attach_id),
  KEY filetime (filetime),
  KEY physical_filename (physical_filename(10)),
  KEY filesize (filesize)
);

CREATE TABLE phpbb_attachments (
  attach_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL, 
  post_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL, 
  privmsgs_id mediumint(8) UNSIGNED DEFAULT '0' NOT NULL,
  user_id_1 mediumint(8) NOT NULL,
  user_id_2 mediumint(8) NOT NULL,
  KEY attach_id_post_id (attach_id, post_id),
  KEY attach_id_privmsgs_id (attach_id, privmsgs_id),
  KEY post_id (post_id),
  KEY privmsgs_id (privmsgs_id)
); 

CREATE TABLE phpbb_quota_limits (
  quota_limit_id mediumint(8) unsigned NOT NULL auto_increment,
  quota_desc varchar(20) NOT NULL default '',
  quota_limit bigint(20) unsigned NOT NULL default '0',
  PRIMARY KEY  (quota_limit_id)
);

CREATE TABLE phpbb_attach_quota (
  user_id mediumint(8) unsigned NOT NULL default '0',
  group_id mediumint(8) unsigned NOT NULL default '0',
  quota_type smallint(2) NOT NULL default '0',
  quota_limit_id mediumint(8) unsigned NOT NULL default '0',
  KEY quota_type (quota_type)
);

CREATE TABLE phpbb_payment (
	post_id MEDIUMINT(8) UNSIGNED NOT NULL,
	user_id MEDIUMINT(8) UNSIGNED NOT NULL,
	KEY post_id_user_id (post_id, user_id)
);

CREATE TABLE phpbb_link_categories (
  	cat_id mediumint(8) unsigned NOT NULL auto_increment,
  	cat_title varchar(100) NOT NULL default '',
  	cat_order mediumint(8) unsigned NOT NULL default '0',
  	PRIMARY KEY  (cat_id),
  	KEY cat_order (cat_order)
);

CREATE TABLE phpbb_links (
  	link_id mediumint(8) unsigned NOT NULL auto_increment,
  	link_title varchar(100) NOT NULL default '',
  	link_desc varchar(255) default NULL,
  	link_category mediumint(8) unsigned NOT NULL default '0',
  	link_url varchar(100) NOT NULL default '',
  	link_logo_src varchar(120) default NULL,
  	link_joined int(11) NOT NULL default '0',
  	link_active tinyint(1) NOT NULL default '0',
  	link_hits int(10) unsigned NOT NULL default '0',
  	user_id mediumint(8) NOT NULL default '0',
  	user_ip varchar(8) NOT NULL default '',
  	last_user_ip varchar(8) NOT NULL default '',
  	PRIMARY KEY  (link_id)
);

CREATE TABLE phpbb_link_config (
	config_name varchar(255) NOT NULL default '',
	config_value varchar(255) NOT NULL default ''
);

ALTER TABLE phpbb_auth_access ADD auth_commend tinyint(1) DEFAULT '3' NOT NULL;

ALTER TABLE phpbb_vote_desc ADD vote_max INT(3) DEFAULT '1' NOT NULL;
ALTER TABLE phpbb_vote_desc ADD vote_voted INT(7) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_vote_desc ADD vote_hide TINYINT(1) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_vote_desc ADD vote_tothide TINYINT(1) DEFAULT '0' NOT NULL;

INSERT INTO phpbb_themes (themes_id, template_name, style_name, head_stylesheet, body_background, body_bgcolor, body_text, body_link, body_vlink, body_alink, body_hlink, tr_color1, tr_color2, tr_color3, tr_class1, tr_class2, tr_class3, th_color1, th_color2, th_color3, th_class1, th_class2, th_class3, td_color1, td_color2, td_color3, td_class1, td_class2, td_class3, fontface1, fontface2, fontface3, fontsize1, fontsize2, fontsize3, fontcolor1, fontcolor2, fontcolor3, span_class1, span_class2, span_class3, online_color, offline_color, hidden_color) VALUES (2, 'cnphpbbice', 'cnphpbbice', 'cnphpbbice.css', '', 'E5E5E5', '000000', '006699', '5493B4', '', 'DD6900', 'EFEFEF', 'DEE3E7', 'D1D7DC', '', '', '', '98AAB1', '006699', 'FFFFFF', 'cellpic1.gif', 'cellpic3.gif', 'cellpic2.jpg', 'FAFAFA', 'FFFFFF', '', 'row1', 'row2', '', 'Verdana, Arial, Helvetica, sans-serif', 'Trebuchet MS', 'Courier, \'Courier New\', sans-serif', 12, 12, 12, '444444', '006600', 'FFA34F', '', '', '', '008500', 'DF0000', 'EBD400');
INSERT INTO phpbb_themes_name (themes_id, tr_color1_name, tr_color2_name, tr_color3_name, tr_class1_name, tr_class2_name, tr_class3_name, th_color1_name, th_color2_name, th_color3_name, th_class1_name, th_class2_name, th_class3_name, td_color1_name, td_color2_name, td_color3_name, td_class1_name, td_class2_name, td_class3_name, fontface1_name, fontface2_name, fontface3_name, fontsize1_name, fontsize2_name, fontsize3_name, fontcolor1_name, fontcolor2_name, fontcolor3_name, span_class1_name, span_class2_name, span_class3_name) VALUES (2, 'The lightest row colour', 'The medium row color', 'The darkest row colour', '', '', '', 'Border round the whole page', 'Outer table border', 'Inner table border', 'Silver gradient picture', 'Blue gradient picture', 'Fade-out gradient on index', 'Background for quote boxes', 'All white areas', '', 'Background for topic posts', '2nd background for topic posts', '', 'Main fonts', 'Additional topic title font', 'Form fonts', 'Smallest font size', 'Medium font size', 'Normal font size (post body etc)', 'Quote & copyright text', 'Code text colour', 'Main table header text colour', '', '', '');

INSERT INTO phpbb_config (config_name, config_value) VALUES ('cash_disable',0);
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cash_display_after_posts',1);
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cash_post_message','此贴为您赚得了 %s ');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cash_disable_spam_num',10);
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cash_disable_spam_time',24);
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cash_disable_spam_message','您超出了系统允许的最大发贴数，您将无法赚得虚拟货币');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cash_installed','是');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cash_version','2.2.2');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cash_adminbig','0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cash_adminnavbar','1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('points_name','点数');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_quickreply', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cash_system_type', '2');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_sellpost', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_hide4reply', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_hide4posts', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_hide4fortune', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('max_sellingprice', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('min_sellingprice', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('max_postsrequired', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('min_postsrequired', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('max_fortunerequired', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('min_fortunerequired', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cash_field_name', '');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('cash_type_name', '');
INSERT INTO phpbb_config (config_name, config_value ) VALUES ('who_is_online_time', '5');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('birthday_required', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('birthday_greeting', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('max_user_age', '100');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('min_user_age', '5');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('birthday_check_day', '7');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('bluecard_limit', '3');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('bluecard_limit_2', '1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('max_user_bancard ', '10');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('report_forum', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('email_enabled', 1);
INSERT INTO phpbb_config (config_name, config_value) VALUES ('board_disable_msg', '对不起，本论坛系统暂时不能访问，请稍候再试。');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('board_disable_downtime', '10 分钟');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('board_disable_notes', '论坛版本升级中');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('board_disable_admin_mod', '0');
UPDATE phpbb_users SET user_quickreply_mode=0 WHERE user_id=-1;
INSERT INTO phpbb_config (config_name, config_value) VALUES ('anonymous_show_sqr', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('anonymous_sqr_mode', '0');

ALTER TABLE phpbb_users ADD user_open_quickreply TINYINT(1) DEFAULT '1' NOT NULL;
UPDATE phpbb_users SET user_open_quickreply=0 WHERE user_id=-1;
INSERT INTO phpbb_config (config_name, config_value) VALUES ('anonymous_open_sqr', '0');

INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('upload_dir','files');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('upload_img','images/icon_clip.gif');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('topic_icon','images/icon_clip.gif');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('display_order','0');

INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('max_filesize','262144');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('attachment_quota','52428800');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('max_filesize_pm','262144');

INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('max_attachments','3');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('max_attachments_pm','1');

INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('disable_mod','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('allow_pm_attach','1');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('attachment_topic_review','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('allow_ftp_upload','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('show_apcp','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('attach_version','2.4.1');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('default_upload_quota', '0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('default_pm_quota', '0');

INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('ftp_server','');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('ftp_path','');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('download_path','');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('ftp_user','');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('ftp_pass','');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('ftp_pasv_mode','1');

INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('img_display_inlined','1');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('img_max_width','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('img_max_height','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('img_link_width','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('img_link_height','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('img_create_thumbnail','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('img_min_thumb_filesize','12000');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('img_imagick', '');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('use_gd2','0');

INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('wma_autoplay','0');

INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('flash_autoplay','0');
INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('basic_data_updated', '0');
INSERT INTO phpbb_forbidden_extensions (ext_id, extension) VALUES (1,'php');
INSERT INTO phpbb_forbidden_extensions (ext_id, extension) VALUES (2,'php3');
INSERT INTO phpbb_forbidden_extensions (ext_id, extension) VALUES (3,'php4');
INSERT INTO phpbb_forbidden_extensions (ext_id, extension) VALUES (4,'phtml');
INSERT INTO phpbb_forbidden_extensions (ext_id, extension) VALUES (5,'pl');
INSERT INTO phpbb_forbidden_extensions (ext_id, extension) VALUES (6,'asp');
INSERT INTO phpbb_forbidden_extensions (ext_id, extension) VALUES (7,'cgi');

INSERT INTO phpbb_extension_groups (group_id, group_name, cat_id, allow_group, download_mode, upload_icon, max_filesize, forum_permissions) VALUES (1,'Images',1,1,1,'',0,'');
INSERT INTO phpbb_extension_groups (group_id, group_name, cat_id, allow_group, download_mode, upload_icon, max_filesize, forum_permissions) VALUES (2,'Archives',0,1,1,'',0,'');
INSERT INTO phpbb_extension_groups (group_id, group_name, cat_id, allow_group, download_mode, upload_icon, max_filesize, forum_permissions) VALUES (3,'Plain Text',0,0,1,'',0,'');
INSERT INTO phpbb_extension_groups (group_id, group_name, cat_id, allow_group, download_mode, upload_icon, max_filesize, forum_permissions) VALUES (4,'Documents',0,0,1,'',0,'');
INSERT INTO phpbb_extension_groups (group_id, group_name, cat_id, allow_group, download_mode, upload_icon, max_filesize, forum_permissions) VALUES (5,'Real Media',0,0,2,'',0,'');
INSERT INTO phpbb_extension_groups (group_id, group_name, cat_id, allow_group, download_mode, upload_icon, max_filesize, forum_permissions) VALUES (6,'Streams',2,0,1,'',0,'');
INSERT INTO phpbb_extension_groups (group_id, group_name, cat_id, allow_group, download_mode, upload_icon, max_filesize, forum_permissions) VALUES (7,'Flash Files',3,0,1,'',0,'');

INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (1, 1,'gif', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (2, 1,'png', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (3, 1,'jpeg', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (4, 1,'jpg', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (5, 1,'tif', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (6, 1,'tga', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (7, 2,'gtar', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (8, 2,'gz', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (9, 2,'tar', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (10, 2,'zip', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (11, 2,'rar', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (12, 2,'ace', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (13, 3,'txt', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (14, 3,'c', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (15, 3,'h', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (16, 3,'cpp', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (17, 3,'hpp', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (18, 3,'diz', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (19, 4,'xls', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (20, 4,'doc', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (21, 4,'dot', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (22, 4,'pdf', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (23, 4,'ai', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (24, 4,'ps', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (25, 4,'ppt', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (26, 5,'rm', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (27, 6,'wma', '');
INSERT INTO phpbb_extensions (ext_id, group_id, extension, comment) VALUES (28, 7,'swf', '');

INSERT INTO phpbb_quota_limits (quota_limit_id, quota_desc, quota_limit) VALUES (1, 'Low', 262144);
INSERT INTO phpbb_quota_limits (quota_limit_id, quota_desc, quota_limit) VALUES (2, 'Medium', 2097152);
INSERT INTO phpbb_quota_limits (quota_limit_id, quota_desc, quota_limit) VALUES (3, 'High', 5242880);

INSERT INTO phpbb_link_categories (cat_id, cat_title, cat_order) VALUES (1, '艺术', 1);
INSERT INTO phpbb_link_categories (cat_id, cat_title, cat_order) VALUES (2, '商业', 2);
INSERT INTO phpbb_link_categories (cat_id, cat_title, cat_order) VALUES (3, '儿童', 3);
INSERT INTO phpbb_link_categories (cat_id, cat_title, cat_order) VALUES (4, '电脑', 4);
INSERT INTO phpbb_link_categories (cat_id, cat_title, cat_order) VALUES (5, '游戏', 5);
INSERT INTO phpbb_link_categories (cat_id, cat_title, cat_order) VALUES (6, '健康', 6);
INSERT INTO phpbb_link_categories (cat_id, cat_title, cat_order) VALUES (7, '生活', 7);
INSERT INTO phpbb_link_categories (cat_id, cat_title, cat_order) VALUES (8, '新闻', 8);

INSERT INTO phpbb_links (link_id , link_title, link_desc, link_category, link_url, link_logo_src, link_joined, link_active, link_hits, user_id, user_ip, last_user_ip ) VALUES (1, 'cnphpBB', 'phpbb中文开发小组', 4, 'http://www.cnphpbb.com/', 'images/links/cnphpBB_88a.gif', ".time().", 1, 0, 2, '', '');

INSERT INTO phpbb_link_config (config_name, config_value) VALUES ('site_logo', 'images/links/web_logo88a.gif');
INSERT INTO phpbb_link_config (config_name, config_value) VALUES ('site_url', '');
INSERT INTO phpbb_link_config (config_name, config_value) VALUES ('width', '88');
INSERT INTO phpbb_link_config (config_name, config_value) VALUES ('height', '31');
INSERT INTO phpbb_link_config (config_name, config_value) VALUES ('linkspp', '10');
INSERT INTO phpbb_link_config (config_name, config_value) VALUES ('display_interval', '6000');
INSERT INTO phpbb_link_config (config_name, config_value) VALUES ('display_logo_num', '10');
INSERT INTO phpbb_link_config (config_name, config_value) VALUES ('display_links_logo', '1');
INSERT INTO phpbb_link_config (config_name, config_value) VALUES ('email_notify', '1');
INSERT INTO phpbb_link_config (config_name, config_value) VALUES ('pm_notify ', '0');
INSERT INTO phpbb_link_config (config_name, config_value) VALUES ('lock_submit_site', '0');
INSERT INTO phpbb_link_config (config_name, config_value) VALUES ('allow_no_logo', '0');