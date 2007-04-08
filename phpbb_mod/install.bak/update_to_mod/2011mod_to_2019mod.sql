ALTER TABLE phpbb_topics CHANGE topic_title topic_title CHAR(120) NOT NULL;

ALTER TABLE phpbb_posts_text CHANGE post_subject post_subject VARCHAR(120) DEFAULT NULL;

ALTER TABLE phpbb_sessions ADD session_admin tinyint(2) DEFAULT '0' NOT NULL;

ALTER TABLE phpbb_users ADD user_allow_mass_pm TINYINT(1) DEFAULT '2' AFTER user_allow_pm;
ALTER TABLE phpbb_users ADD user_gender TINYINT DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_users ADD user_allow_ag TINYINT(1) DEFAULT '1' NOT NULL;
ALTER TABLE phpbb_users ADD user_open_quickreply TINYINT(1) DEFAULT '1' NOT NULL;
ALTER TABLE phpbb_users ADD user_skype VARCHAR(255);

ALTER TABLE phpbb_user_group ADD group_moderator TINYINT(1) NOT NULL;

ALTER TABLE phpbb_auth_access ADD auth_commend tinyint(1) DEFAULT '3' NOT NULL;

ALTER TABLE phpbb_forums ADD auth_commend tinyint(1) DEFAULT '3' NOT NULL;
ALTER TABLE phpbb_forums ADD forum_sub SMALLINT(5) UNSIGNED DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_forums ADD sort_sub SMALLINT(5) UNSIGNED DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_forums ADD main_sub smallint(50) UNSIGNED DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_forums ADD forum_icon varchar(150);

ALTER TABLE phpbb_vote_desc ADD vote_max INT(3) DEFAULT '1' NOT NULL;
ALTER TABLE phpbb_vote_desc ADD vote_voted INT(7) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_vote_desc ADD vote_hide TINYINT(1) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_vote_desc ADD vote_tothide TINYINT(1) DEFAULT '0' NOT NULL;

ALTER TABLE phpbb_groups ADD group_allow_pm TINYINT(2) DEFAULT '5' NOT NULL;
ALTER TABLE phpbb_groups ADD group_count INT(4) UNSIGNED DEFAULT '99999999';
ALTER TABLE phpbb_groups ADD group_count_max INT(4) UNSIGNED DEFAULT '99999999';
ALTER TABLE phpbb_groups ADD group_count_enable SMALLINT(2) UNSIGNED DEFAULT '0';

INSERT INTO phpbb_config (config_name, config_value) VALUES ('email_enabled', 1);
INSERT INTO phpbb_config (config_name, config_value) VALUES ('board_disable_msg', '对不起，本论坛系统暂时不能访问，请稍候再试。');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('board_disable_downtime', '10 分钟');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('board_disable_notes', '论坛版本升级中');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('board_disable_admin_mod', '0');

INSERT INTO phpbb_config (config_name, config_value) VALUES ('anonymous_show_sqr', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('anonymous_sqr_mode', '0');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('anonymous_open_sqr', '0');

UPDATE phpbb_users SET user_open_quickreply=0 WHERE user_id=-1;
UPDATE phpbb_users SET user_quickreply_mode=0 WHERE user_id=-1;

INSERT INTO phpbb_themes (themes_id, template_name, style_name, head_stylesheet, body_background, body_bgcolor, body_text, body_link, body_vlink, body_alink, body_hlink, tr_color1, tr_color2, tr_color3, tr_class1, tr_class2, tr_class3, th_color1, th_color2, th_color3, th_class1, th_class2, th_class3, td_color1, td_color2, td_color3, td_class1, td_class2, td_class3, fontface1, fontface2, fontface3, fontsize1, fontsize2, fontsize3, fontcolor1, fontcolor2, fontcolor3, span_class1, span_class2, span_class3, online_color, offline_color, hidden_color) VALUES (2, 'cnphpbbice', 'cnphpbbice', 'cnphpbbice.css', '', 'E5E5E5', '000000', '006699', '5493B4', '', 'DD6900', 'EFEFEF', 'DEE3E7', 'D1D7DC', '', '', '', '98AAB1', '006699', 'FFFFFF', 'cellpic1.gif', 'cellpic3.gif', 'cellpic2.jpg', 'FAFAFA', 'FFFFFF', '', 'row1', 'row2', '', 'Verdana, Arial, Helvetica, sans-serif', 'Trebuchet MS', 'Courier, \'Courier New\', sans-serif', 12, 12, 12, '444444', '006600', 'FFA34F', '', '', '', '008500', 'DF0000', 'EBD400');

INSERT INTO phpbb_themes_name (themes_id, tr_color1_name, tr_color2_name, tr_color3_name, tr_class1_name, tr_class2_name, tr_class3_name, th_color1_name, th_color2_name, th_color3_name, th_class1_name, th_class2_name, th_class3_name, td_color1_name, td_color2_name, td_color3_name, td_class1_name, td_class2_name, td_class3_name, fontface1_name, fontface2_name, fontface3_name, fontsize1_name, fontsize2_name, fontsize3_name, fontcolor1_name, fontcolor2_name, fontcolor3_name, span_class1_name, span_class2_name, span_class3_name) VALUES (2, 'The lightest row colour', 'The medium row color', 'The darkest row colour', '', '', '', 'Border round the whole page', 'Outer table border', 'Inner table border', 'Silver gradient picture', 'Blue gradient picture', 'Fade-out gradient on index', 'Background for quote boxes', 'All white areas', '', 'Background for topic posts', '2nd background for topic posts', '', 'Main fonts', 'Additional topic title font', 'Form fonts', 'Smallest font size', 'Medium font size', 'Normal font size (post body etc)', 'Quote & copyright text', 'Code text colour', 'Main table header text colour', '', '', '');

INSERT INTO phpbb_attachments_config (config_name, config_value) VALUES ('basic_data_updated', '0');
UPDATE phpbb_attachments_config SET config_value = '2.4.1' WHERE config_name = 'attach_version' LIMIT 1;

CREATE TABLE phpbb_sessions_keys (
	key_id varchar(32) DEFAULT '0' NOT NULL,
	user_id mediumint(8) DEFAULT '0' NOT NULL,
	last_ip varchar(8) DEFAULT '0' NOT NULL,
	last_login int(11) DEFAULT '0' NOT NULL,
	PRIMARY KEY (key_id, user_id),
	KEY last_login (last_login)
);

INSERT INTO phpbb_config (config_name, config_value) VALUES ('allow_autologin','1');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('max_autologin_time','0');

UPDATE phpbb_users SET user_active = 0 WHERE user_id = -1;
ALTER TABLE phpbb_users ADD COLUMN user_login_tries smallint(5) UNSIGNED DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_users ADD COLUMN user_last_login_try int(11) DEFAULT '0' NOT NULL;
INSERT INTO phpbb_config (config_name, config_value) VALUES ('max_login_attempts', '5');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('login_reset_time', '30');
UPDATE phpbb_config SET config_value = '.0.19' WHERE config_name = 'version';
