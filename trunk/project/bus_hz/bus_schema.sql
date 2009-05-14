
DROP TABLE IF EXISTS hz_line;
CREATE TABLE IF NOT EXISTS hz_line (
  id smallint(5) unsigned NOT NULL auto_increment,
  name varchar(32) NOT NULL DEFAULT '' ,
  number smallint(5) unsigned NOT NULL DEFAULT '0' ,
  start_sid int(10) unsigned NOT NULL DEFAULT '0' ,
  start_first varchar(64) NOT NULL DEFAULT '' ,
  start_last varchar(64) NOT NULL DEFAULT '' ,
  end_sid int(10) unsigned NOT NULL DEFAULT '0' ,
  end_first varchar(64) NOT NULL DEFAULT '' ,
  end_last varchar(64) NOT NULL DEFAULT '' ,
  fare_norm varchar(240) NOT NULL DEFAULT '' ,
  fare_cond varchar(240) NOT NULL DEFAULT '' ,
  ic_card varchar(32) NOT NULL DEFAULT '' ,
  service_hour varchar(16) NOT NULL DEFAULT '' ,
  PRIMARY KEY (id)
);



DROP TABLE IF EXISTS hz_route;
CREATE TABLE IF NOT EXISTS hz_route (
  id int(10) unsigned NOT NULL auto_increment,
  lid smallint(5) unsigned NOT NULL DEFAULT '0' ,
  sid int(10) unsigned NOT NULL DEFAULT '0' ,
  i smallint(5) unsigned NOT NULL DEFAULT '0' ,
  direction tinyint(1) NOT NULL DEFAULT '0' ,
  PRIMARY KEY (id),
   KEY lid (lid),
   KEY i (i)
);




DROP TABLE IF EXISTS hz_site;
CREATE TABLE IF NOT EXISTS hz_site (
  id int(10) unsigned NOT NULL auto_increment,
  name varchar(255) NOT NULL DEFAULT '' ,
  subname varchar(255) NOT NULL DEFAULT '' ,
  around varchar(255) NOT NULL DEFAULT '' ,
  PRIMARY KEY (id)
);

