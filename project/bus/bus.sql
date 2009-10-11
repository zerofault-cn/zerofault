CREATE TABLE `bus_hz_route` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `lid` smallint(5) unsigned NOT NULL default '0',
  `sid` int(10) unsigned NOT NULL default '0',
  `sort` smallint(5) unsigned NOT NULL default '0',
  `dir` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `lid` (`lid`),
  KEY `i` (`sort`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `bus_hz_site` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `around` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `bus_hz_line` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(32) NOT NULL default '',
  `number` smallint(5) unsigned NOT NULL default '0',
  `start_sid` int(10) unsigned NOT NULL default '0',
  `start_first` varchar(64) NOT NULL default '',
  `start_last` varchar(64) NOT NULL default '',
  `end_sid` int(10) unsigned NOT NULL default '0',
  `end_first` varchar(64) NOT NULL default '',
  `end_last` varchar(64) NOT NULL default '',
  `fare_norm` varchar(240) NOT NULL default '',
  `fare_cond` varchar(240) NOT NULL default '',
  `ic_card` varchar(32) NOT NULL default '',
  `service_hour` varchar(16) NOT NULL default '',
  `update_time` datetime default '0000-00-00 00:00:00',
  `status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;