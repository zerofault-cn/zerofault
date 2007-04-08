CREATE TABLE `poll_ip1` (
  `id` int(3) unsigned NOT NULL auto_increment,
  `ip` char(15) NOT NULL default '',
  `mm_id` int(3) unsigned default '0',
  `polltime` int(11) unsigned default '0',
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
);
CREATE TABLE `poll_sms1` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `phone` varchar(11) NOT NULL default '',
  `service_code` enum('9951','10665110') NOT NULL default '9951',
  `content` varchar(255) NOT NULL default '0',
  `connId` int(10) unsigned NOT NULL default '0',
  `linkId` varchar(64) NOT NULL default '0',
  `pgId` int(10) unsigned NOT NULL default '0',
  `feephone` varchar(11) NOT NULL default '0',
  `smsid` varchar(64) NOT NULL default '0',
  `polltime` int(10) unsigned NOT NULL default '0',
  `status` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `polltime` (`polltime`)
);