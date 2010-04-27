-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost
-- 生成日期: 2010 年 04 月 27 日 15:53
-- 服务器版本: 5.0.22
-- PHP 版本: 5.2.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 数据库: `cuteflow`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `cf_additional_text`
-- 

CREATE TABLE IF NOT EXISTS `cf_additional_text` (
  `id` int(11) NOT NULL auto_increment,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `is_default` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- 导出表中的数据 `cf_additional_text`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `cf_attachment`
-- 

CREATE TABLE IF NOT EXISTS `cf_attachment` (
  `nID` int(11) NOT NULL auto_increment,
  `strPath` text NOT NULL,
  `nCirculationHistoryId` int(11) NOT NULL default '0',
  PRIMARY KEY  (`nID`),
  UNIQUE KEY `nID` (`nID`),
  KEY `nID_2` (`nID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- 导出表中的数据 `cf_attachment`
-- 

INSERT INTO `cf_attachment` (`nID`, `strPath`, `nCirculationHistoryId`) VALUES 
(1, '../attachments/cf_9/1272382725/ERP2.sql', 14);

-- --------------------------------------------------------

-- 
-- 表的结构 `cf_circulationform`
-- 

CREATE TABLE IF NOT EXISTS `cf_circulationform` (
  `nID` int(11) NOT NULL auto_increment,
  `nSenderId` int(11) NOT NULL default '0',
  `strName` text NOT NULL,
  `nMailingListId` int(11) NOT NULL default '0',
  `bIsArchived` tinyint(4) NOT NULL default '0',
  `nEndAction` tinyint(4) NOT NULL default '0',
  `bDeleted` int(11) NOT NULL,
  `bAnonymize` int(11) NOT NULL default '0',
  PRIMARY KEY  (`nID`),
  UNIQUE KEY `nID` (`nID`),
  KEY `nID_2` (`nID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- 导出表中的数据 `cf_circulationform`
-- 

INSERT INTO `cf_circulationform` (`nID`, `nSenderId`, `strName`, `nMailingListId`, `bIsArchived`, `nEndAction`, `bDeleted`, `bAnonymize`) VALUES 
(7, 42, 'circul-3(1)', 3, 0, 3, 0, 0),
(8, 42, 'circul_1-2-3(1)', 1, 0, 3, 0, 0),
(9, 40, 'test123', 1, 0, 3, 0, 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `cf_circulationhistory`
-- 

CREATE TABLE IF NOT EXISTS `cf_circulationhistory` (
  `nID` int(11) NOT NULL auto_increment,
  `nRevisionNumber` int(11) NOT NULL default '0',
  `dateSending` int(15) NOT NULL default '0',
  `strAdditionalText` text NOT NULL,
  `nCirculationFormId` int(11) NOT NULL default '0',
  PRIMARY KEY  (`nID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- 导出表中的数据 `cf_circulationhistory`
-- 

INSERT INTO `cf_circulationhistory` (`nID`, `nRevisionNumber`, `dateSending`, `strAdditionalText`, `nCirculationFormId`) VALUES 
(12, 1, 1272376971, '', 7),
(13, 1, 1272380759, '', 8),
(14, 1, 1272382725, '', 9);

-- --------------------------------------------------------

-- 
-- 表的结构 `cf_circulationprocess`
-- 

CREATE TABLE IF NOT EXISTS `cf_circulationprocess` (
  `nID` int(11) NOT NULL auto_increment,
  `nCirculationFormId` int(11) NOT NULL default '0',
  `nSlotId` int(11) NOT NULL default '0',
  `nUserId` int(11) NOT NULL default '0',
  `dateInProcessSince` int(15) NOT NULL default '0',
  `nDecissionState` tinyint(4) NOT NULL default '0',
  `dateDecission` int(15) NOT NULL default '0',
  `nIsSubstitiuteOf` int(11) NOT NULL default '0',
  `nCirculationHistoryId` int(11) NOT NULL default '0',
  `nResendCount` int(11) NOT NULL default '0',
  PRIMARY KEY  (`nID`),
  KEY `nCirculationFormId` (`nCirculationFormId`),
  KEY `nSlotId` (`nSlotId`),
  KEY `nUserId` (`nUserId`),
  KEY `nCirculationHistoryId` (`nCirculationHistoryId`),
  KEY `dateDecission` (`dateDecission`),
  KEY `dateInProcessSince` (`dateInProcessSince`),
  KEY `nDecissionState` (`nDecissionState`),
  KEY `nIsSubstitiuteOf` (`nIsSubstitiuteOf`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- 导出表中的数据 `cf_circulationprocess`
-- 

INSERT INTO `cf_circulationprocess` (`nID`, `nCirculationFormId`, `nSlotId`, `nUserId`, `dateInProcessSince`, `nDecissionState`, `dateDecission`, `nIsSubstitiuteOf`, `nCirculationHistoryId`, `nResendCount`) VALUES 
(45, 7, 4, 40, 1272376971, 0, 1272377026, 0, 12, 0),
(46, 7, 4, 41, 1272376971, 1, 1272380691, 0, 12, 0),
(47, 7, 4, 42, 1272376971, 0, 0, 0, 12, 0),
(48, 8, 1, 40, 1272380759, 1, 1272382639, 0, 13, 0),
(49, 8, 2, 40, 1272380805, 4, 1272380807, 0, 13, 0),
(50, 8, 2, 41, 1272380806, 0, 0, 0, 13, 0),
(51, 9, 1, 40, 1272382725, 1, 1272382865, 0, 14, 0),
(52, 9, 2, 40, 1272382865, 0, 0, 0, 14, 0),
(53, 9, 2, 41, 1272382865, 0, 0, 0, 14, 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `cf_config`
-- 

CREATE TABLE IF NOT EXISTS `cf_config` (
  `strCF_Server` text NOT NULL,
  `strSMTP_use_auth` text NOT NULL,
  `strSMTP_server` text NOT NULL,
  `strSMTP_port` varchar(8) NOT NULL default '',
  `strSMTP_userid` text NOT NULL,
  `strSMTP_pwd` tinytext NOT NULL,
  `strSysReplyAddr` text NOT NULL,
  `strMailAddTextDef` text NOT NULL,
  `strDefLang` char(3) NOT NULL default 'en',
  `bDetailSeperateWindow` varchar(5) NOT NULL default 'true',
  `strDefSortCol` varchar(32) NOT NULL default 'COL_CIRCULATION_NAME',
  `bShowPosMail` varchar(5) NOT NULL default 'true',
  `bFilter_AR_Wordstart` varchar(5) NOT NULL default 'true',
  `strCirculation_cols` varchar(255) NOT NULL default '12345',
  `nDelay_norm` int(11) NOT NULL default '7',
  `nDelay_interm` int(11) NOT NULL default '10',
  `nDelay_late` int(11) NOT NULL default '12',
  `strEmail_Format` varchar(8) NOT NULL default 'HTML',
  `strEmail_Values` varchar(8) NOT NULL default 'IFRAME',
  `nSubstitutePerson_Hours` int(11) NOT NULL default '96',
  `strSubstitutePerson_Unit` text NOT NULL,
  `nConfigID` int(11) NOT NULL default '0',
  `strSortDirection` text NOT NULL,
  `strVersion` text NOT NULL,
  `nShowRows` int(11) default NULL,
  `nAutoReload` int(11) NOT NULL default '0',
  `strUrlPassword` text NOT NULL,
  `tsLastUpdate` int(11) NOT NULL,
  `bAllowUnencryptedRequest` int(11) NOT NULL,
  `UserDefined1_Title` text NOT NULL,
  `UserDefined2_Title` text NOT NULL,
  `strDateFormat` tinytext NOT NULL,
  `strMailSendType` text NOT NULL,
  `strMtaPath` text NOT NULL,
  `strSlotVisibility` varchar(100) NOT NULL,
  `strSmtpEncryption` varchar(100) NOT NULL,
  `bSendWorkflowMail` int(11) NOT NULL,
  `bSendReminderMail` int(11) NOT NULL,
  PRIMARY KEY  (`nConfigID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- 导出表中的数据 `cf_config`
-- 

INSERT INTO `cf_config` (`strCF_Server`, `strSMTP_use_auth`, `strSMTP_server`, `strSMTP_port`, `strSMTP_userid`, `strSMTP_pwd`, `strSysReplyAddr`, `strMailAddTextDef`, `strDefLang`, `bDetailSeperateWindow`, `strDefSortCol`, `bShowPosMail`, `bFilter_AR_Wordstart`, `strCirculation_cols`, `nDelay_norm`, `nDelay_interm`, `nDelay_late`, `strEmail_Format`, `strEmail_Values`, `nSubstitutePerson_Hours`, `strSubstitutePerson_Unit`, `nConfigID`, `strSortDirection`, `strVersion`, `nShowRows`, `nAutoReload`, `strUrlPassword`, `tsLastUpdate`, `bAllowUnencryptedRequest`, `UserDefined1_Title`, `UserDefined2_Title`, `strDateFormat`, `strMailSendType`, `strMtaPath`, `strSlotVisibility`, `strSmtpEncryption`, `bSendWorkflowMail`, `bSendReminderMail`) VALUES 
('http://localhost/cuteflow2.11.2', '', '', '25', '', '', 'cuteflow@localhost.de', '', 'en', 'true', 'COL_CIRCULATION_PROCESS_DAYS', 'true', 'true', 'NAME---1---STATION---1---DAYS---1---START---1---SENDER---1---WHOLETIME---0---MAILLIST---0---TEMPLATE---0', 7, 10, 12, 'HTML', 'IFRAME', 1, 'DAYS', 1, 'ASC', '2.11.2', 50, 60, '0a661fb17a298c1f7a925b9e6c9b3c66', 1268657588, 0, 'user-defined1', 'user-defined2', 'm-d-Y', 'PHP', '', 'ALL', 'NONE', 1, 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `cf_fieldvalue`
-- 

CREATE TABLE IF NOT EXISTS `cf_fieldvalue` (
  `nID` int(11) NOT NULL auto_increment,
  `nInputFieldId` int(11) NOT NULL default '0',
  `nUserId` int(10) unsigned NOT NULL default '0',
  `strFieldValue` text NOT NULL,
  `nSlotId` int(11) NOT NULL default '0',
  `nFormId` int(11) NOT NULL default '0',
  `nCirculationHistoryId` int(11) default NULL,
  PRIMARY KEY  (`nID`),
  UNIQUE KEY `nID` (`nID`),
  KEY `nID_2` (`nID`),
  KEY `nInputFieldId` (`nInputFieldId`),
  KEY `nSlotId` (`nSlotId`),
  KEY `nFormId` (`nFormId`),
  KEY `nCirculationHistoryId` (`nCirculationHistoryId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- 导出表中的数据 `cf_fieldvalue`
-- 

INSERT INTO `cf_fieldvalue` (`nID`, `nInputFieldId`, `nUserId`, `strFieldValue`, `nSlotId`, `nFormId`, `nCirculationHistoryId`) VALUES 
(244, 2, 40, '', 4, 7, 12),
(245, 2, 41, '', 4, 7, 12),
(246, 2, 42, '0', 4, 7, 12),
(247, 7, 40, '0---0---1---1---0---0---1---0---', 4, 7, 12),
(248, 7, 41, '0---0---1---1---0---0---1---0---', 4, 7, 12),
(249, 7, 42, '0---0---1---1---0---0---1---0---', 4, 7, 12),
(250, 8, 40, '0---0---0---1---0---', 4, 7, 12),
(251, 8, 41, '0---0---0---1---0---', 4, 7, 12),
(252, 8, 42, '0---0---0---1---0---', 4, 7, 12),
(253, 4, 40, 'xx3xx2004-09-11', 4, 7, 12),
(254, 4, 41, 'xx3xx2004-09-11', 4, 7, 12),
(255, 4, 42, 'xx3xx2004-09-11', 4, 7, 12),
(256, 9, 40, '', 4, 7, 12),
(257, 9, 41, '', 4, 7, 12),
(258, 9, 42, '', 4, 7, 12),
(259, 3, 40, 'xx1xx1337', 4, 7, 12),
(260, 3, 41, 'xx1xx1337', 4, 7, 12),
(261, 3, 42, 'xx1xx1337', 4, 7, 12),
(262, 6, 40, '0---0---1---0---', 4, 7, 12),
(263, 6, 41, '0---0---1---0---', 4, 7, 12),
(264, 6, 42, '0---0---1---0---', 4, 7, 12),
(265, 1, 40, 'default value', 4, 7, 12),
(266, 1, 41, 'default value', 4, 7, 12),
(267, 1, 42, 'default value', 4, 7, 12),
(268, 5, 40, 'test1', 4, 7, 12),
(272, 9, 40, '', 1, 8, 13),
(269, 5, 41, 'test2', 4, 7, 12),
(271, 2, 40, '', 1, 8, 13),
(270, 5, 42, 'nOnSeNs NoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnSnOnSeNsNoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnS', 4, 7, 12),
(273, 1, 40, 'test1', 1, 8, 13),
(274, 2, 40, '0', 2, 8, 13),
(275, 2, 41, '0', 2, 8, 13),
(276, 9, 40, '', 2, 8, 13),
(277, 9, 41, '', 2, 8, 13),
(278, 1, 40, 'default value', 2, 8, 13),
(279, 1, 41, 'default value', 2, 8, 13),
(280, 2, 40, '0', 3, 8, 13),
(281, 2, 41, '0', 3, 8, 13),
(282, 2, 42, '0', 3, 8, 13),
(283, 9, 40, '', 3, 8, 13),
(284, 9, 41, '', 3, 8, 13),
(285, 9, 42, '', 3, 8, 13),
(286, 1, 40, 'default value', 3, 8, 13),
(287, 1, 41, 'default value', 3, 8, 13),
(288, 1, 42, 'default value', 3, 8, 13),
(289, 2, 40, '', 1, 9, 14),
(290, 9, 40, '', 1, 9, 14),
(291, 1, 40, 'default value', 1, 9, 14),
(292, 2, 40, '0', 2, 9, 14),
(293, 2, 41, '0', 2, 9, 14),
(294, 9, 40, '', 2, 9, 14),
(295, 9, 41, '', 2, 9, 14),
(296, 1, 40, 'default value', 2, 9, 14),
(297, 1, 41, 'default value', 2, 9, 14),
(298, 2, 40, '0', 3, 9, 14),
(299, 2, 41, '0', 3, 9, 14),
(300, 2, 42, '0', 3, 9, 14),
(301, 9, 40, '', 3, 9, 14),
(302, 9, 41, '', 3, 9, 14),
(303, 9, 42, '', 3, 9, 14),
(304, 1, 40, 'default value', 3, 9, 14),
(305, 1, 41, 'default value', 3, 9, 14),
(306, 1, 42, 'default value', 3, 9, 14);

-- --------------------------------------------------------

-- 
-- 表的结构 `cf_filter`
-- 

CREATE TABLE IF NOT EXISTS `cf_filter` (
  `nID` int(11) NOT NULL auto_increment,
  `nUserID` int(11) NOT NULL default '0',
  `strLabel` text NOT NULL,
  `strName` text NOT NULL,
  `nStationID` int(11) NOT NULL default '0',
  `nDaysInProgress_Start` text NOT NULL,
  `nDaysInProgress_End` text NOT NULL,
  `strSendDate_Start` text NOT NULL,
  `strSendDate_End` text NOT NULL,
  `nMailinglistID` int(11) NOT NULL default '0',
  `nTemplateID` int(11) NOT NULL default '0',
  `strCustomFilter` text NOT NULL,
  `nSenderID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`nID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- 导出表中的数据 `cf_filter`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `cf_formslot`
-- 

CREATE TABLE IF NOT EXISTS `cf_formslot` (
  `nID` int(11) NOT NULL auto_increment,
  `strName` tinytext NOT NULL,
  `nTemplateId` int(11) NOT NULL default '0',
  `nSlotNumber` int(11) NOT NULL default '0',
  `nSendType` int(11) NOT NULL default '0',
  PRIMARY KEY  (`nID`),
  UNIQUE KEY `nID` (`nID`),
  KEY `nID_2` (`nID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- 导出表中的数据 `cf_formslot`
-- 

INSERT INTO `cf_formslot` (`nID`, `strName`, `nTemplateId`, `nSlotNumber`, `nSendType`) VALUES 
(1, 'slot-1', 1, 1, 0),
(2, 'slot-2', 1, 2, 0),
(3, 'slot-3', 1, 3, 0),
(4, 'slot 1', 2, 1, 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `cf_formtemplate`
-- 

CREATE TABLE IF NOT EXISTS `cf_formtemplate` (
  `nID` int(11) NOT NULL auto_increment,
  `strName` tinytext NOT NULL,
  `bDeleted` int(11) NOT NULL default '0',
  PRIMARY KEY  (`nID`),
  UNIQUE KEY `nID` (`nID`),
  KEY `nID_2` (`nID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- 导出表中的数据 `cf_formtemplate`
-- 

INSERT INTO `cf_formtemplate` (`nID`, `strName`, `bDeleted`) VALUES 
(1, 'tpl_1-2-3', 0),
(2, 'tpl_1-all', 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `cf_inputfield`
-- 

CREATE TABLE IF NOT EXISTS `cf_inputfield` (
  `nID` int(11) NOT NULL auto_increment,
  `strName` tinytext NOT NULL,
  `nType` int(11) NOT NULL default '0',
  `strStandardValue` text NOT NULL,
  `bReadOnly` tinyint(4) NOT NULL default '0',
  `strBgColor` tinytext NOT NULL,
  PRIMARY KEY  (`nID`),
  UNIQUE KEY `nID` (`nID`),
  KEY `nID_2` (`nID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- 导出表中的数据 `cf_inputfield`
-- 

INSERT INTO `cf_inputfield` (`nID`, `strName`, `nType`, `strStandardValue`, `bReadOnly`, `strBgColor`) VALUES 
(1, 'TESTFIELD - Text', 1, 'default value', 0, ''),
(2, 'TESTFIELD - Checkbox', 2, '0', 0, ''),
(3, 'TESTFIELD - Number', 3, 'xx1xx1337', 0, ''),
(4, 'TESTFIELD - Date', 4, 'xx3xx2004-09-11', 0, ''),
(5, 'TESTFIELD - Textfield', 5, 'nOnSeNs NoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnSnOnSeNsNoNsEnS nOnSeNs NoNsEnS nOnSeNs NoNsEnS', 0, ''),
(6, 'TESTFIELD - Radiogroup', 6, '---4---Radiobutton - No1---0---Radiobutton - No2---0---Radiobutton - No3 (default)---1---Radiobutton - No4---0', 0, ''),
(7, 'TESTFIELD - Checkboxgroup', 7, '---8---Checkbox - No1---0---Checkbox - No2---0---Checkbox - No3 (default)---1---Checkbox - No4 (default)---1---Checkbox - No5---0---Checkbox - No6---0---Checkbox - No7 (default)---1---Checkbox - No8---0', 0, ''),
(8, 'TESTFIELD - Combobox', 8, '---5---Option No1---0---Option No2---0---Option No3---0---Option No4 (default)---1---Option No5---0', 0, ''),
(9, 'TESTFIELD - File', 9, '', 0, '');

-- --------------------------------------------------------

-- 
-- 表的结构 `cf_mailinglist`
-- 

CREATE TABLE IF NOT EXISTS `cf_mailinglist` (
  `nID` int(11) NOT NULL auto_increment,
  `strName` text NOT NULL,
  `nTemplateId` int(11) NOT NULL default '0',
  `bIsEdited` int(11) default NULL,
  `bIsDefault` int(11) NOT NULL default '0',
  `bDeleted` int(11) NOT NULL default '0',
  PRIMARY KEY  (`nID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- 导出表中的数据 `cf_mailinglist`
-- 

INSERT INTO `cf_mailinglist` (`nID`, `strName`, `nTemplateId`, `bIsEdited`, `bIsDefault`, `bDeleted`) VALUES 
(1, 'mail_1-2-3', 1, 0, 0, 0),
(3, 'mail-3(1)', 2, 0, 0, 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `cf_slottofield`
-- 

CREATE TABLE IF NOT EXISTS `cf_slottofield` (
  `nID` int(11) NOT NULL auto_increment,
  `nSlotId` int(11) NOT NULL default '0',
  `nFieldId` int(11) NOT NULL default '0',
  `nPosition` int(11) NOT NULL,
  PRIMARY KEY  (`nID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- 导出表中的数据 `cf_slottofield`
-- 

INSERT INTO `cf_slottofield` (`nID`, `nSlotId`, `nFieldId`, `nPosition`) VALUES 
(1, 1, 2, 1),
(2, 1, 9, 2),
(3, 1, 1, 3),
(4, 2, 2, 1),
(5, 2, 9, 2),
(6, 2, 1, 3),
(7, 3, 2, 1),
(8, 3, 9, 2),
(9, 3, 1, 3),
(10, 4, 2, 1),
(11, 4, 7, 2),
(12, 4, 8, 3),
(13, 4, 4, 4),
(14, 4, 9, 5),
(15, 4, 3, 6),
(16, 4, 6, 7),
(17, 4, 1, 8),
(18, 4, 5, 9);

-- --------------------------------------------------------

-- 
-- 表的结构 `cf_slottouser`
-- 

CREATE TABLE IF NOT EXISTS `cf_slottouser` (
  `nID` int(11) NOT NULL auto_increment,
  `nSlotId` int(11) NOT NULL default '0',
  `nMailingListId` int(11) NOT NULL default '0',
  `nUserId` int(11) NOT NULL default '0',
  `nPosition` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`nID`),
  UNIQUE KEY `nID` (`nID`),
  KEY `nID_2` (`nID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- 导出表中的数据 `cf_slottouser`
-- 

INSERT INTO `cf_slottouser` (`nID`, `nSlotId`, `nMailingListId`, `nUserId`, `nPosition`) VALUES 
(1, 1, 1, 40, 1),
(2, 2, 1, 40, 1),
(3, 2, 1, 41, 2),
(4, 3, 1, 40, 1),
(5, 3, 1, 41, 2),
(6, 3, 1, 42, 3),
(7, 4, 3, 40, 1),
(8, 4, 3, 41, 2),
(9, 4, 3, 42, 3);

-- --------------------------------------------------------

-- 
-- 表的结构 `cf_substitute`
-- 

CREATE TABLE IF NOT EXISTS `cf_substitute` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `substitute_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- 导出表中的数据 `cf_substitute`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `cf_user`
-- 

CREATE TABLE IF NOT EXISTS `cf_user` (
  `nID` int(11) NOT NULL auto_increment,
  `strLastName` tinytext NOT NULL,
  `strFirstName` tinytext NOT NULL,
  `strEMail` tinytext NOT NULL,
  `nAccessLevel` int(11) NOT NULL default '0',
  `strUserId` tinytext NOT NULL,
  `strPassword` tinytext NOT NULL,
  `strEmail_Format` varchar(8) NOT NULL default 'HTML',
  `strEmail_Values` varchar(8) NOT NULL default 'IFRAME',
  `nSubstitudeId` int(11) NOT NULL default '0',
  `tsLastAction` int(11) NOT NULL,
  `bDeleted` int(11) NOT NULL,
  `strStreet` text NOT NULL,
  `strCountry` text NOT NULL,
  `strZipcode` text NOT NULL,
  `strCity` text NOT NULL,
  `strPhone_Main1` text NOT NULL,
  `strPhone_Main2` text NOT NULL,
  `strPhone_Mobile` text NOT NULL,
  `strFax` text NOT NULL,
  `strOrganisation` text NOT NULL,
  `strDepartment` text NOT NULL,
  `strCostCenter` text NOT NULL,
  `UserDefined1_Value` text NOT NULL,
  `UserDefined2_Value` text NOT NULL,
  `nSubstituteTimeValue` int(11) NOT NULL,
  `strSubstituteTimeUnit` text NOT NULL,
  `bUseGeneralSubstituteConfig` int(11) NOT NULL,
  `bUseGeneralEmailConfig` int(11) NOT NULL,
  PRIMARY KEY  (`nID`),
  UNIQUE KEY `nID` (`nID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- 导出表中的数据 `cf_user`
-- 

INSERT INTO `cf_user` (`nID`, `strLastName`, `strFirstName`, `strEMail`, `nAccessLevel`, `strUserId`, `strPassword`, `strEmail_Format`, `strEmail_Values`, `nSubstitudeId`, `tsLastAction`, `bDeleted`, `strStreet`, `strCountry`, `strZipcode`, `strCity`, `strPhone_Main1`, `strPhone_Main2`, `strPhone_Mobile`, `strFax`, `strOrganisation`, `strDepartment`, `strCostCenter`, `UserDefined1_Value`, `UserDefined2_Value`, `nSubstituteTimeValue`, `strSubstituteTimeUnit`, `bUseGeneralSubstituteConfig`, `bUseGeneralEmailConfig`) VALUES 
(1, 'AGIGA', 'ERP Admin', 'mzhu@agigatech.com', 8, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'HTML', 'IFRAME', 0, 1271509832, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', 1, 1),
(40, 'z', 'test1', 'test1@local.com', 2, 'test1', 'e10adc3949ba59abbe56e057f20f883e', 'HTML', 'IFRAME', 0, 1272382792, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 'DAYS', 0, 0),
(41, 'AGIGA', 'test2', 'test2@example.com', 1, 'test2', 'e10adc3949ba59abbe56e057f20f883e', 'HTML', 'IFRAME', 0, 1272380728, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', 1, 1),
(42, 'z', 'test3', 'test3@local.com', 2, 'test3', 'e10adc3949ba59abbe56e057f20f883e', 'HTML', 'IFRAME', 0, 1272380825, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 'DAYS', 0, 0),
(43, 'AGIGA', 'Test6', 'test2@local.com', 1, 'test8', 'e10adc3949ba59abbe56e057f20f883e', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', 1, 1),
(44, 'AGIGA', 'Test9', 'mzhu@agigatech.com', 1, 'test9', 'c33367701511b4f6020ec61ded352059', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', 1, 1),
(45, 'AGIGA', 'Super Admin~~', 'zerofault@gmail.com', 8, 'administrator', '8891815eda4c6e329348d3a11611a7ba', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', 1, 1),
(46, 'AGIGA', 'Luo Kai', 'kail@agigatech.com', 8, 'Robin Luo', 'd41d8cd98f00b204e9800998ecf8427e', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', 1, 1),
(47, 'AGIGA', 'Tracy', 'JALI@cypress.com', 1, 'Tracy', '', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', 1, 1),
(48, 'AGIGA', 'fanjunxia', '', 8, 'Matty.Fan', '', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', 1, 1),
(49, 'AGIGA', 'Bin Li', 'Bin.li@agigatech.com', 8, 'Bin Li', '', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', 1, 1),
(50, 'AGIGA', 'Test', '', 1, 'test', '098f6bcd4621d373cade4e832627b4f6', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', 1, 1),
(51, 'AGIGA', 'Test4', 'test2@local.com', 8, 'test4', 'e10adc3949ba59abbe56e057f20f883e', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', 1, 1),
(52, 'AGIGA', 'Test5', 'aa1a@bbb.com', 1, 'test5', 'e10adc3949ba59abbe56e057f20f883e', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', 1, 1),
(53, 'AGIGA', 'Test6', 'test2@local.com', 1, 'test6', 'e10adc3949ba59abbe56e057f20f883e', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', 1, 1),
(54, 'AGIGA', 'Test6', 'test2@local.com', 1, 'test7', 'e10adc3949ba59abbe56e057f20f883e', 'HTML', 'IFRAME', 0, 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', 1, 1);

-- --------------------------------------------------------

-- 
-- 表的结构 `cf_user_index`
-- 

CREATE TABLE IF NOT EXISTS `cf_user_index` (
  `user_id` int(11) NOT NULL,
  `index` text NOT NULL,
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- 导出表中的数据 `cf_user_index`
-- 

INSERT INTO `cf_user_index` (`user_id`, `index`) VALUES 
(40, 'z test1 test1@local.com test1             '),
(41, 'AGIGA test2 test2@example.com test2             '),
(42, 'z test3 test3@local.com test3             '),
(43, 'AGIGA Test6 test2@local.com test8             '),
(44, 'AGIGA Test9 mzhu@agigatech.com test9             '),
(45, 'AGIGA Super Admin~~ zerofault@gmail.com administrator             '),
(46, 'AGIGA Luo Kai kail@agigatech.com Robin Luo             '),
(47, 'AGIGA Tracy JALI@cypress.com Tracy             '),
(48, 'AGIGA fanjunxia  Matty.Fan             '),
(49, 'AGIGA Bin Li Bin.li@agigatech.com Bin Li             '),
(50, 'AGIGA Test  test             '),
(51, 'AGIGA Test4 test2@local.com test4             '),
(52, 'AGIGA Test5 aa1a@bbb.com test5             '),
(53, 'AGIGA Test6 test2@local.com test6             '),
(54, 'AGIGA Test6 test2@local.com test7             ');
