ALTER TABLE phpbb_users ADD COLUMN user_login_tries smallint(5) UNSIGNED DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_users ADD COLUMN user_last_login_try int(11) DEFAULT '0' NOT NULL;
INSERT INTO phpbb_config (config_name, config_value) VALUES ('max_login_attempts', '5');
INSERT INTO phpbb_config (config_name, config_value) VALUES ('login_reset_time', '30');

UPDATE phpbb_config SET config_value = '.0.19' WHERE config_name = 'version';
UPDATE phpbb_attachments_config SET config_value = '2.4.1' WHERE config_name='attach_version';