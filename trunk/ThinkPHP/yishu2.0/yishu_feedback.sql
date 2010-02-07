CREATE TABLE `yishu_feedback` (
  `id` int(11) NOT NULL auto_increment,
  `nickname` varchar(255) not NULL default '',
  `email` varchar(255) not NULL default '',
  `subject` varchar(255) not NULL default '',
  `message` text not null default '',
  `reply` text not null default '',
  `addtime` datetime not null,
  `replytime` datetime not null,
  `status` tinyint(1) not null default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;