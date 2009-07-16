-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost
-- 生成日期: 2009 年 06 月 22 日 23:48
-- 服务器版本: 5.0.22
-- PHP 版本: 5.2.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 数据库: `yishu`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `yishu_category`
-- 

CREATE TABLE IF NOT EXISTS `yishu_category` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `pid` smallint(5) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL,
  `addtime` datetime NOT NULL,
  `usetime` datetime NOT NULL,
  `sort` smallint(5) unsigned NOT NULL default '0',
  `flag` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- 表的结构 `yishu_comment`
-- 

CREATE TABLE IF NOT EXISTS `yishu_comment` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `site_id` mediumint(8) unsigned NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL, 
  `ip` varchar(16) NOT NULL,
  `content` text NOT NULL,
  `addtime` datetime NOT NULL,
  `flag` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- 表的结构 `yishu_vote`
-- 

CREATE TABLE IF NOT EXISTS `yishu_vote` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `site_id` mediumint(8) unsigned NOT NULL default '0',
  `vote` tinyint(3) unsigned NOT NULL default '0',
  `addtime` datetime NOT NULL,
  `ip` varchar(16) NOT NULL,
  `session` varchar(32) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- 表的结构 `yishu_website`
-- 

CREATE TABLE IF NOT EXISTS `yishu_website` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `cate_id` smallint(5) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `descr` text NOT NULL,
  `addtime` datetime NOT NULL,
  `sort` smallint(5) unsigned NOT NULL default '0',
  `flag` tinyint(1) NOT NULL default '1',
  `mark` tinyint(1) unsigned NOT NULL default '0',
  `hit` mediumint(8) unsigned NOT NULL default '0',
  `view` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
