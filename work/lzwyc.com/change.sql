ALTER TABLE `lzwyc_invite`
  ADD COLUMN `view` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '关注度' AFTER `create_time`;
ALTER TABLE `lzwyc_invite`
  ADD COLUMN `qq` varchar(255) NOT NULL DEFAULT '' COMMENT 'QQ' AFTER `phone`;

ALTER TABLE `lzwyc_feedback`
  ADD COLUMN `reply` text NOT NULL AFTER `content`;
ALTER TABLE `lzwyc_feedback`
  ADD COLUMN `replytime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00';

ALTER TABLE `lzwyc_case`
  ADD COLUMN `company_id` int(10) unsigned NOT NULL DEFAULT 0 AFTER `id`;
ALTER TABLE `lzwyc_case`
  ADD COLUMN `sort` int(11) NOT NULL DEFAULT 0 AFTER `url`;

CREATE TABLE `lzwyc_point` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `point` int(10) NOT NULL default '0',
  `note` varchar(255) NOT NULL default '',
  `add_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `modify_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `lzwyc_view`
  ADD COLUMN `point` tinyint(3) unsigned NOT NULL DEFAULT 1;
