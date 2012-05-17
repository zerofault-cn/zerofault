ALTER TABLE `lzwyc_invite`
  ADD COLUMN `view` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '关注度' AFTER `create_time`;
ALTER TABLE `lzwyc_invite`
  ADD COLUMN `qq` varchar(255) NOT NULL DEFAULT '' COMMENT 'QQ' AFTER `phone`;

ALTER TABLE `lzwyc_feedback`
  ADD COLUMN `reply` text NOT NULL AFTER `content`;
