CREATE TABLE `comment` (  PRIMARY KEY (common_id)) SELECT * FROM `live_common`;
ALTER TABLE `comment` CHANGE `common_id` `id` INT UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `comment` CHANGE `common_user` `username` VARCHAR(50)  NOT NULL;
ALTER TABLE `comment` CHANGE `common_memo` `content` TEXT NOT NULL;
ALTER TABLE `comment` CHANGE `common_time` `addtime` INT(11)  DEFAULT "0" NOT NULL;
ALTER TABLE `comment` CHANGE `user_id` `user_id` INT DEFAULT "0" NOT NULL;
ALTER TABLE `comment` ADD `mark` TINYINT(1)  UNSIGNED DEFAULT "0" NOT NULL AFTER `user_id`;