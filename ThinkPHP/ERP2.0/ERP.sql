
CREATE TABLE IF NOT EXISTS erp_category (
  id smallint(5) unsigned NOT NULL auto_increment,
  type enum('Component','Board') NOT NULL DEFAULT 'Component' ,
  code varchar(255) NOT NULL DEFAULT '' ,
  name varchar(255) NOT NULL DEFAULT '' ,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS erp_department (
  id smallint(5) unsigned NOT NULL auto_increment,
  code varchar(255) NOT NULL DEFAULT '' ,
  name varchar(255) NOT NULL DEFAULT '' ,
  function varchar(255) NOT NULL DEFAULT '' ,
  leader_id smallint(5) unsigned NOT NULL DEFAULT 0 ,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;





CREATE TABLE IF NOT EXISTS erp_location (
  id smallint(3) unsigned NOT NULL auto_increment,
  name varchar(255) NOT NULL DEFAULT '' ,
  descr varchar(255) NOT NULL DEFAULT '' ,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



INSERT INTO erp_location VALUES("1", "local", "Local");


CREATE TABLE IF NOT EXISTS erp_location_manager (
  id smallint(5) unsigned NOT NULL auto_increment,
  location_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  fixed tinyint(1) unsigned NOT NULL DEFAULT '0' ,
  staff_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS erp_location_product (
  id int(10) unsigned NOT NULL auto_increment,
  type enum('location','staff') NOT NULL DEFAULT 'location' ,
  location_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  product_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  ori_quantity int(11) NOT NULL DEFAULT '0' ,
  chg_quantity int(11) NOT NULL DEFAULT '0' ,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS erp_node (
  id smallint(6) unsigned NOT NULL auto_increment,
  pid smallint(6) unsigned NOT NULL DEFAULT '0' ,
  name varchar(20) NOT NULL DEFAULT '' ,
  title varchar(50) NOT NULL DEFAULT '' ,
  level tinyint(1) unsigned NOT NULL DEFAULT '0' ,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




INSERT INTO erp_node VALUES("1", "0", "Board", "Board Basic Data", "0");
INSERT INTO erp_node VALUES("2", "0", "Category", "Category Management", "0");
INSERT INTO erp_node VALUES("3", "0", "Dept", "Department Management", "0");
INSERT INTO erp_node VALUES("4", "0", "Location", "Location Setting", "0");
INSERT INTO erp_node VALUES("5", "0", "Product", "Component Basic Data", "0");
INSERT INTO erp_node VALUES("6", "0", "ProductIn", "Inventory Input Management", "0");
INSERT INTO erp_node VALUES("7", "0", "ProductOut", "Inventory output Management", "0");
INSERT INTO erp_node VALUES("8", "0", "Setting", "Options Setting", "0");
INSERT INTO erp_node VALUES("9", "0", "Staff", "Staff Management", "0");
INSERT INTO erp_node VALUES("10", "0", "Supplier", "Supplier Management", "0");
INSERT INTO erp_node VALUES("11", "1", "index", "List", "0");
INSERT INTO erp_node VALUES("12", "1", "form", "Form", "0");
INSERT INTO erp_node VALUES("13", "1", "submit", "Submit", "0");
INSERT INTO erp_node VALUES("14", "1", "delete", "Delete", "0");
INSERT INTO erp_node VALUES("15", "2", "index", "List", "0");
INSERT INTO erp_node VALUES("16", "2", "submit", "Submit", "0");
INSERT INTO erp_node VALUES("17", "2", "delete", "Delete", "0");
INSERT INTO erp_node VALUES("18", "3", "index", "List", "0");
INSERT INTO erp_node VALUES("19", "3", "submit", "Submit", "0");
INSERT INTO erp_node VALUES("20", "3", "delete", "Delete", "0");
INSERT INTO erp_node VALUES("21", "4", "index", "List", "0");
INSERT INTO erp_node VALUES("22", "4", "submit", "Submit", "0");
INSERT INTO erp_node VALUES("23", "4", "delete", "Delete", "0");
INSERT INTO erp_node VALUES("24", "5", "index", "List", "0");
INSERT INTO erp_node VALUES("25", "5", "form", "Form", "0");
INSERT INTO erp_node VALUES("26", "5", "submit", "Submit", "0");
INSERT INTO erp_node VALUES("27", "5", "delete", "Delete", "0");
INSERT INTO erp_node VALUES("28", "6", "fixed", "Fixed-Assets Entering", "0");
INSERT INTO erp_node VALUES("29", "6", "floating", "Floating-Assets Entering", "0");
INSERT INTO erp_node VALUES("30", "6", "reject", "Product Reject", "0");
INSERT INTO erp_node VALUES("31", "6", "form", "Form", "0");
INSERT INTO erp_node VALUES("32", "6", "submit", "Submit", "0");
INSERT INTO erp_node VALUES("33", "6", "confirm", "Confirm", "0");
INSERT INTO erp_node VALUES("34", "6", "select", "Select Basic Data", "0");
INSERT INTO erp_node VALUES("35", "6", "delete", "Delete", "0");
INSERT INTO erp_node VALUES("36", "7", "applyFixed", "Fixed-Assets Apply Management", "0");
INSERT INTO erp_node VALUES("37", "7", "applyFloating", "Floating-Assets Apply Management", "0");
INSERT INTO erp_node VALUES("38", "7", "transfer", "Transfer Management", "0");
INSERT INTO erp_node VALUES("39", "7", "release", "Release Management", "0");
INSERT INTO erp_node VALUES("40", "7", "scrap", "Scrap Management", "0");
INSERT INTO erp_node VALUES("41", "7", "returns", "Return management", "0");
INSERT INTO erp_node VALUES("42", "7", "form", "Form", "0");
INSERT INTO erp_node VALUES("43", "7", "submit", "Submit", "0");
INSERT INTO erp_node VALUES("44", "7", "confirm", "Confirm", "0");
INSERT INTO erp_node VALUES("45", "7", "select", "Select Basic Data", "0");
INSERT INTO erp_node VALUES("46", "7", "delete", "Delete", "0");
INSERT INTO erp_node VALUES("47", "8", "index", "List", "0");
INSERT INTO erp_node VALUES("48", "8", "submit", "Submit", "0");
INSERT INTO erp_node VALUES("49", "8", "delete", "Delete", "0");
INSERT INTO erp_node VALUES("50", "9", "index", "List", "0");
INSERT INTO erp_node VALUES("51", "9", "form", "Form", "0");
INSERT INTO erp_node VALUES("52", "9", "submit", "Submit", "0");
INSERT INTO erp_node VALUES("53", "9", "update", "Update", "0");
INSERT INTO erp_node VALUES("54", "9", "delete", "Delete", "0");
INSERT INTO erp_node VALUES("55", "10", "index", "List", "0");
INSERT INTO erp_node VALUES("56", "10", "form", "Form", "0");
INSERT INTO erp_node VALUES("57", "10", "submit", "Submit", "0");
INSERT INTO erp_node VALUES("58", "10", "delete", "Delete", "0");



CREATE TABLE IF NOT EXISTS erp_options (
  id smallint(5) unsigned NOT NULL auto_increment,
  type varchar(255) NOT NULL DEFAULT '' ,
  name varchar(255) NOT NULL DEFAULT '' ,
  code varchar(255) NOT NULL DEFAULT '' ,
  sort smallint(5) unsigned NOT NULL DEFAULT '0' ,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



INSERT INTO erp_options VALUES("1", "character", "Agent", "", "1");
INSERT INTO erp_options VALUES("2", "character", "Manufacture", "", "2");
INSERT INTO erp_options VALUES("3", "character", "Other", "", "9");
INSERT INTO erp_options VALUES("4", "payment_terms", "Due 20th Of the Following Month", "", "1");
INSERT INTO erp_options VALUES("5", "payment_terms", "Due By End Of The Following Month", "", "2");
INSERT INTO erp_options VALUES("6", "payment_terms", "Payment due within 7 days", "", "3");
INSERT INTO erp_options VALUES("7", "payment_terms", "Cash Only", "", "4");
INSERT INTO erp_options VALUES("8", "tax", "Default tax group", "", "1");
INSERT INTO erp_options VALUES("9", "tax", "Ontario", "", "2");
INSERT INTO erp_options VALUES("10", "tax", "UK Inland Revenue", "", "3");
INSERT INTO erp_options VALUES("11", "currency", "Australian Dollars", "AUD", "1");
INSERT INTO erp_options VALUES("12", "currency", "Swiss Francs", "CHF", "2");
INSERT INTO erp_options VALUES("13", "currency", "Euro", "EUR", "3");
INSERT INTO erp_options VALUES("14", "currency", "Pounds", "GBP", "4");
INSERT INTO erp_options VALUES("15", "currency", "US Dollars", "USD", "5");
INSERT INTO erp_options VALUES("16", "unit", "pcs", "", "0");
INSERT INTO erp_options VALUES("17", "unit", "each", "", "0");
INSERT INTO erp_options VALUES("18", "unit", "set", "", "0");
INSERT INTO erp_options VALUES("19", "status", "OK", "", "4");
INSERT INTO erp_options VALUES("20", "status", "Need Repair", "", "5");
INSERT INTO erp_options VALUES("22", "status", "USD", "USD", "6");



CREATE TABLE IF NOT EXISTS erp_product (
  id smallint(5) unsigned NOT NULL auto_increment,
  type enum('Component','Board') NOT NULL DEFAULT '' ,
  fixed tinyint(1) unsigned NOT NULL DEFAULT '0' ,
  code varchar(255) NOT NULL DEFAULT '' ,
  Internal_PN varchar(255) NOT NULL DEFAULT '' ,
  description varchar(255) NOT NULL DEFAULT '' ,
  manufacture varchar(255) NOT NULL DEFAULT '' ,
  MPN varchar(255) NOT NULL DEFAULT '' ,
  value varchar(255) NOT NULL DEFAULT '' ,
  category_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  status_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  unit_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  Rohs tinyint(1) NOT NULL DEFAULT '0' ,
  LT_days smallint(5) unsigned NOT NULL DEFAULT '0' ,
  MOQ varchar(255) NOT NULL DEFAULT '' ,
  SPQ varchar(255) NOT NULL DEFAULT '' ,
  MSL varchar(255) NOT NULL DEFAULT '' ,
  project varchar(255) NOT NULL DEFAULT '' ,
  inventory_limit int(10) unsigned NOT NULL DEFAULT '0' ,
  currency_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  price float NOT NULL DEFAULT '0' ,
  quantity int(10) unsigned NOT NULL DEFAULT '0' ,
  accessories varchar(255) NOT NULL DEFAULT '' ,
  attachment varchar(255) NOT NULL DEFAULT '' ,
  remark tinytext NOT NULL DEFAULT '0' ,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;





CREATE TABLE IF NOT EXISTS erp_product_flow (
  id int(10) unsigned NOT NULL auto_increment,
  code varchar(255) NOT NULL DEFAULT '' ,
  action enum('enter','reject','apply','transfer','release','scrap','return') NOT NULL DEFAULT 'enter' ,
  fixed tinyint(1) unsigned NOT NULL DEFAULT '0' ,
  product_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  from_type enum('location','staff') NOT NULL DEFAULT 'location' ,
  from_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  to_type enum('location','staff') NOT NULL DEFAULT 'location' ,
  to_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  supplier_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  staff_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  currency_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  quantity int(10) unsigned NOT NULL DEFAULT '0' ,
  price float(10,4) NOT NULL DEFAULT '0.0000' ,
  Lot varchar(255) NOT NULL DEFAULT '' ,
  accessories varchar(255) NOT NULL DEFAULT '' ,
  remark tinytext NOT NULL DEFAULT '' ,
  create_time datetime NOT NULL ,
  confirm_time datetime NOT NULL ,
  confirmed_staff_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  status tinyint(1) NOT NULL DEFAULT '0' ,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS erp_remark2 (
  id int(10) unsigned NOT NULL auto_increment,
  flow_id int(10) unsigned NOT NULL DEFAULT '0' ,
  product_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  staff_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  remark text NOT NULL DEFAULT '' ,
  create_time datetime NOT NULL ,
  status tinyint(1) NOT NULL DEFAULT '0' ,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;






CREATE TABLE IF NOT EXISTS erp_role (
  id smallint(6) unsigned NOT NULL auto_increment,
  name varchar(20) NOT NULL DEFAULT '' ,
  descr varchar(255) ,
  status tinyint(1) NOT NULL DEFAULT '0' ,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS erp_role_node (
  role_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  node_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
   KEY roleId (role_id),
   KEY nodeId (node_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS erp_staff (
  id smallint(5) unsigned NOT NULL auto_increment,
  dept_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  leader_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  code varchar(255) NOT NULL DEFAULT '' ,
  name varchar(255) NOT NULL DEFAULT '' ,
  realname varchar(255) NOT NULL DEFAULT '' ,
  password varchar(32) NOT NULL DEFAULT '' ,
  email varchar(255) NOT NULL DEFAULT '' ,
  create_time datetime NOT NULL ,
  login_time datetime NOT NULL ,
  is_leader tinyint(1) unsigned NOT NULL DEFAULT '0' ,
  status tinyint(1) unsigned NOT NULL DEFAULT '0' ,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS erp_staff_role (
  staff_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  role_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
   KEY userId (staff_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS erp_supplier (
  id smallint(5) unsigned NOT NULL auto_increment,
  code varchar(255) NOT NULL DEFAULT '' ,
  name varchar(255) NOT NULL DEFAULT '' ,
  character_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  address varchar(255) NOT NULL DEFAULT '' ,
  contact varchar(255) NOT NULL DEFAULT '' ,
  postcode varchar(255) NOT NULL DEFAULT '' ,
  telephone varchar(255) NOT NULL DEFAULT '' ,
  cellphone varchar(255) NOT NULL DEFAULT '' ,
  fax varchar(255) NOT NULL DEFAULT '' ,
  email varchar(255) NOT NULL DEFAULT '' ,
  bank varchar(255) NOT NULL DEFAULT '' ,
  account varchar(255) NOT NULL DEFAULT '' ,
  payment_terms_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  tax_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  currency_id smallint(5) unsigned NOT NULL DEFAULT '0' ,
  website varchar(255) NOT NULL DEFAULT '' ,
  remark tinytext NOT NULL DEFAULT '' ,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS erp_template (
  id smallint(5) unsigned NOT NULL auto_increment,
  action varchar(255) NOT NULL DEFAULT '' ,
  do varchar(255) NOT NULL DEFAULT '' ,
  subject varchar(255) NOT NULL DEFAULT '' ,
  body text NOT NULL DEFAULT '' ,
  status tinyint(1) unsigned NOT NULL DEFAULT '0' ,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `erp_share` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `staff_id` smallint(5) unsigned NOT NULL default '0',
  `dept_id` smallint(5) unsigned NOT NULL default '0',
  `category` varchar(255) NOT NULL default '',
  `project` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `tags` varchar(255) NOT NULL default '',
  `create_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `modify_time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `erp_share_entry` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `share_id` int(11) unsigned NOT NULL default '0',
  `field` varchar(255) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;