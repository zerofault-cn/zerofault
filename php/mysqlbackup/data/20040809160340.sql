# users 
# MySQL���ݿⱸ����ָ�ϵͳ��ver0.01
# Copyleft @ 2004 by �����
# ��������localhost  ���ݿ�����users
#---------------------------------------------------
#
# MySQL Server Version: 4.0.20-standard
#;
use users;
# ���ݱ�user_info���Ľṹ;
DROP TABLE IF EXISTS `user_info`;
CREATE TABLE `user_info` (
  `user_name` char(30) NOT NULL default '',
  `user_passwd` char(20) NOT NULL default '',
  `user_group` char(10) default NULL,
  PRIMARY KEY  (`user_name`)
) TYPE=MyISAM;
#
# ���user_info���в�������;
#
