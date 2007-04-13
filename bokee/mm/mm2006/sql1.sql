ALTER TABLE `mm_user` RENAME `user_info`;
ALTER TABLE `user_info` CHANGE `user_id` `id` INT UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `user_info` CHANGE `user_blogname` `blogname` VARCHAR(255)  NOT NULL;
ALTER TABLE `user_info` CHANGE `user_blogurl` `blogurl` VARCHAR(255)  NOT NULL;
ALTER TABLE `user_info` DROP `user_commname`;
ALTER TABLE `user_info` DROP `user_commaddr`;
ALTER TABLE `user_info` CHANGE `user_name` `realname` VARCHAR(50)  NOT NULL;
ALTER TABLE `user_info` CHANGE `user_cardtype` `cardtype` TINYINT(1)  UNSIGNED  DEFAULT "0" NOT NULL;
ALTER TABLE `user_info` CHANGE `user_cardnum` `cardnum` VARCHAR(20)  NOT NULL;
ALTER TABLE `user_info` CHANGE `user_addr` `addr` VARCHAR(255)  NOT NULL;
ALTER TABLE `user_info` CHANGE `user_post` `post` VARCHAR(10)  NOT NULL;
ALTER TABLE `user_info` CHANGE `user_phone` `phone` VARCHAR(20)  NOT NULL;
ALTER TABLE `user_info` CHANGE `user_email` `email` VARCHAR(100)  NOT NULL;
ALTER TABLE `user_info` CHANGE `user_other` `other` VARCHAR(255)  NOT NULL;
ALTER TABLE `user_info` DROP `user_type`;
ALTER TABLE `user_info` CHANGE `user_agree` `pass` TINYINT(1)  UNSIGNED  DEFAULT "0" NOT NULL;
ALTER TABLE `user_info` CHANGE `user_pic` `photo` VARCHAR(255)  NOT NULL;
ALTER TABLE `user_info` CHANGE `user_time` `addtime` INT(11)  UNSIGNED  DEFAULT "0" NOT NULL;
ALTER TABLE `user_info` CHANGE `user_poll` `vote` INT(11)  UNSIGNED  DEFAULT "0" NOT NULL;
ALTER TABLE `user_info` DROP `user_vouth`;

ALTER TABLE `user_info` ADD `monthvote` INT UNSIGNED  DEFAULT "0" NOT NULL AFTER `vote`;

ALTER TABLE `user_info` CHANGE `user_commonnum` `comm_count` INT UNSIGNED DEFAULT "0" NOT NULL;

ALTER TABLE `user_info` DROP `user_vouth_time`;