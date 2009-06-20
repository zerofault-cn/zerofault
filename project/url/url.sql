
DROP TABLE IF EXISTS url_category;
CREATE TABLE url_category (

  id smallint(3) unsigned NOT NULL auto_increment,

  pid smallint(3) unsigned NOT NULL default '0',

  name varchar(16) NOT NULL default '',
  descr varchar(255) NOT NULL default '',
  addtime int(10) unsigned NOT NULL default '0',
  
sort smallint(3) unsigned NOT NULL default '100',

  flag tinyint(1) unsigned NOT NULL default '0',

  PRIMARY KEY  (id)

);


DROP TABLE IF EXISTS url_website;
CREATE TABLE url_website (

  id int(3) unsigned NOT NULL auto_increment,

  cate_id smallint(3) unsigned NOT NULL default '0',

  name varchar(64) NOT NULL default '',

  url varchar(255) NOT NULL default '',

  descr varchar(255) NOT NULL default '',
  addtime int(10) unsigned NOT NULL default '0',

  sort smallint(3) unsigned NOT NULL default '100',

  flag tinyint(1) unsigned NOT NULL default '0',
  mark tinyint(1) unsigned NOT NULL default '0',

  hit int(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (id)

);

