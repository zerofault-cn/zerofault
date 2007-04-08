# users 
# MySQL数据库备份与恢复系统　ver0.01
# Copyleft @ 2004 by 孙广智
# 主机名：localhost  数据库名：users
#---------------------------------------------------
#
# MySQL Server Version: 4.0.20-standard
#;
use users;
# 数据表　user_info　的结构;
DROP TABLE IF EXISTS `user_info`;
CREATE TABLE `user_info` (
  `user_name` char(30) NOT NULL default '',
  `user_passwd` char(20) NOT NULL default '',
  `user_group` char(10) default NULL,
  PRIMARY KEY  (`user_name`)
) TYPE=MyISAM;
#
# 向表　user_info　中插入数据;
#
