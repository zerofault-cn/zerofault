#
# Table structure for table 'Admin_User'
#

DROP TABLE IF EXISTS `Admin_User`;
CREATE TABLE IF NOT EXISTS `Admin_User` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `Type` enum('Self','Vendor','Client','Admin') ,
  `Role` enum('Admin','Staff','Contact') ,
  `Username` varchar(60) NOT NULL DEFAULT '' ,
  `Password` varchar(80) NOT NULL DEFAULT '' ,
  `PassValidate` datetime ,
  `PassChangeTime` datetime ,
  `Name` varchar(50) ,
  `EMail` varchar(200) ,
  `Memo` text ,
  `CreateTime` datetime ,
  `LastLoginTime` datetime ,
  `LastLoginIP` varchar(40) ,
  PRIMARY KEY (`ID`),
  UNIQUE KEY Username (`Username`)
);
INSERT INTO `Admin_User` (`ID`, `Type`, `Role`, `Username`, `Password`, `PassValidate`, `PassChangeTime`, `Name`, `EMail`, `Memo`, `CreateTime`, `LastLoginTime`, `LastLoginIP`) VALUES("1", "Admin", "Admin", "admin", "123456", NULL, NULL, NULL, NULL, NULL, NOW(), NOW(), "127.0.0.1");

#
# Table structure for table 'Event_Log'
#

DROP TABLE IF EXISTS `Event_Log`;
CREATE TABLE IF NOT EXISTS `Event_Log` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `ETID` int(10) unsigned NOT NULL DEFAULT '0' ,
  `Timestamp` datetime NOT NULL ,
  `Source` varchar(64) NOT NULL ,
  `User` varchar(64) ,
  `Action` varchar(255) ,
  `Info_XML` text ,
  `Description` text ,
  PRIMARY KEY (`ID`)
);
#
# Table structure for table 'Host_Info'
#

DROP TABLE IF EXISTS `Host_Info`;
CREATE TABLE IF NOT EXISTS `Host_Info` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `Host` varchar(32) NOT NULL ,
  `Host_Chroot` varchar(255) NOT NULL ,
  `Local_Chroot` varchar(255) NOT NULL ,
  `Time` datetime NOT NULL ,
  `Sync_ID` int(10) unsigned NOT NULL DEFAULT '0' ,
  `Mail` varchar(255) NOT NULL ,
  PRIMARY KEY (`ID`)
);



#
# Table structure for table 'Rsync_Host'
#

DROP TABLE IF EXISTS `Rsync_Host`;
CREATE TABLE IF NOT EXISTS `Rsync_Host` (
  `ID` smallint(5) unsigned NOT NULL auto_increment,
  `Name` varchar(64) NOT NULL ,
  `Host` varchar(64) NOT NULL ,
  `Path` varchar(255) NOT NULL ,
  `Description` varchar(255) ,
  PRIMARY KEY (`ID`)
);



#
# Table structure for table 'Sync_Info'
#

DROP TABLE IF EXISTS `Sync_Info`;
CREATE TABLE IF NOT EXISTS `Sync_Info` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `Sync_ID` int(11) NOT NULL DEFAULT '0' ,
  `Path` varchar(255) NOT NULL ,
  `Filename` varchar(255) NOT NULL ,
  PRIMARY KEY (`ID`)
);



#
# Table structure for table 'Sync_XML'
#

DROP TABLE IF EXISTS `Sync_XML`;
CREATE TABLE IF NOT EXISTS `Sync_XML` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `User_ID` tinyint(3) unsigned NOT NULL DEFAULT '0' ,
  `Host_ID` int(3) unsigned NOT NULL DEFAULT '0' ,
  `Filename` varchar(32) NOT NULL ,
  `Content` text ,
  `Create_Time` datetime ,
  `Modify_Time` datetime ,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' ,
  PRIMARY KEY (`ID`)
);

