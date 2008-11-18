
DROP TABLE IF EXISTS `bus_hz_line`;
CREATE TABLE IF NOT EXISTS `bus_hz_line` (
  `id` smallint(5) unsigned auto_increment,
  `name` varchar(16) NOT NULL default '',
  `number` smallint(5) unsigned NOT NULL default '0',
  `term1` int(10) unsigned NOT NULL default '0',
  `term2` int(10) unsigned NOT NULL default '0',
  `start_time1` time NOT NULL default '00:00:00',
  `start_time2` time NOT NULL default '00:00:00',
  `end_time1` time NOT NULL default '00:00:00',
  `end_time2` time NOT NULL default '00:00:00',
  `fare_norm` varchar(16) NOT NULL default '',
  `fare_cond` varchar(16) NOT NULL default '',
  `ic_card` varchar(10) NOT NULL default '',
  `service_hour` varchar(16) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `bus_hz_route`;
CREATE TABLE IF NOT EXISTS `bus_hz_route` (
  `id` int(10) unsigned auto_increment,
  `lid` smallint(5) unsigned NOT NULL default '0',
  `sid` int(10) unsigned NOT NULL default '0',
  `i` smallint(5) unsigned NOT NULL default '0',
  `direction` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `lid` (`lid`),
  KEY `i` (`i`)
) TYPE=MyISAM;


DROP TABLE IF EXISTS `bus_hz_site`;
CREATE TABLE IF NOT EXISTS `bus_hz_site` (
  `id` int(10) unsigned auto_increment,
  `name` varchar(255) NOT NULL default '',
  `subname` varchar(255) NOT NULL default '',
  `around` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

