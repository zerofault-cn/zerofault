ALTER TABLE phpbb_sessions ADD session_admin tinyint(2) DEFAULT '0' NOT NULL;

ALTER TABLE phpbb_users ADD user_allow_mass_pm TINYINT(1) DEFAULT '2' AFTER user_allow_pm;
ALTER TABLE phpbb_users ADD user_gender TINYINT DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_users ADD user_allow_ag TINYINT(1) DEFAULT '1' NOT NULL;

ALTER TABLE phpbb_user_group ADD group_moderator TINYINT(1) NOT NULL;

ALTER TABLE phpbb_auth_access ADD auth_commend tinyint(1) DEFAULT '3' NOT NULL;

ALTER TABLE phpbb_forums ADD auth_commend tinyint(1) DEFAULT '3' NOT NULL;
ALTER TABLE phpbb_forums ADD forum_sub SMALLINT(5) UNSIGNED DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_forums ADD sort_sub SMALLINT(5) UNSIGNED DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_forums ADD main_sub smallint(50) UNSIGNED DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_forums ADD forum_icon varchar(150);

ALTER TABLE phpbb_groups ADD group_allow_pm TINYINT(2) DEFAULT '5' NOT NULL;
ALTER TABLE phpbb_groups ADD group_count INT(4) UNSIGNED DEFAULT '99999999';
ALTER TABLE phpbb_groups ADD group_count_max INT(4) UNSIGNED DEFAULT '99999999';
ALTER TABLE phpbb_groups ADD group_count_enable SMALLINT(2) UNSIGNED DEFAULT '0';

ALTER TABLE phpbb_vote_desc ADD vote_max INT(3) DEFAULT '1' NOT NULL;
ALTER TABLE phpbb_vote_desc ADD vote_voted INT(7) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_vote_desc ADD vote_hide TINYINT(1) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_vote_desc ADD vote_tothide TINYINT(1) DEFAULT '0' NOT NULL;

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

ALTER TABLE phpbb_users ADD user_skype VARCHAR(255);

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