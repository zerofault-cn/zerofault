<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp.php 13003 2009-08-05 06:46:06Z liguode $
*/

//通用文件
include_once('./common.php');
include_once(S_ROOT.'./source/function_cp.php');
include_once(S_ROOT.'./source/function_magic.php');

//允许的方法
$acs = array('space', 'doing', 'upload', 'comment', 'blog', 'album', 'relatekw', 'common', 'class',
	'swfupload', 'thread', 'mtag', 'poke', 'friend',
	'avatar', 'profile', 'theme', 'import', 'feed', 'privacy', 'pm', 'share', 'advance', 'invite','sendmail',
	'userapp', 'task', 'credit', 'password', 'domain', 'event', 'poll', 'topic',
	'click','magic', 'top', 'videophoto', 'partner');
$ac = (empty($_GET['ac']) || !in_array($_GET['ac'], $acs))?'profile':$_GET['ac'];
$op = empty($_GET['op'])?'':$_GET['op'];

//权限判断
if(empty($_SGLOBAL['supe_uid'])) {
	if($_SERVER['REQUEST_METHOD'] == 'GET') {
		ssetcookie('_refer', rawurlencode($_SERVER['REQUEST_URI']));
	} else {
		ssetcookie('_refer', rawurlencode('cp.php?ac='.$ac));
	}
	showmessage('to_login', 'do.php?ac='.$_SCONFIG['login_action']);
}

//获取空间信息
$space = getspace($_SGLOBAL['supe_uid']);
if(empty($space)) {
	showmessage('space_does_not_exist');
}
$space['star'] = getstar($space['experience']);
//是否关闭站点
if(!in_array($ac, array('common', 'pm'))) {
	checkclose();
	//空间被锁定
	if($space['flag'] == -1) {
		showmessage('space_has_been_locked');
	}
	//禁止访问
	if(checkperm('banvisit')) {
		ckspacelog();
		showmessage('you_do_not_have_permission_to_visit');
	}
	//验证是否有权限玩应用
	if($ac =='userapp' && !checkperm('allowmyop')) {
		showmessage('no_privilege');
	}
}
	//左侧群组列表
	$space['mtag_list'] = array();
	$tagspace_list = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select group_concat(tagid) from ".tname('tagspace')." where uid=".$_SGLOBAL['supe_uid']), 0);
	if (!empty($tagspace_list)) {
		$rs = $_SGLOBAL['db']->query("select tagid, tagname, fieldid from ".tname('mtag')." where tagid in(".$tagspace_list.") order by tagid");
		while ($row = $_SGLOBAL['db']->fetch_array($rs)) {
			$field_name = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select title from ".tname('profield')." where fieldid=".$row['fieldid']), 0);
			if (!array_key_exists($field_name, $space['mtag_list'])) {
				$space['mtag_list'][$field_name] = array();
			}
			$space['mtag_list'][$field_name][] = $row;
		}
	}

//菜单
$actives = array($ac => ' class="active"');

include_once(S_ROOT.'./source/cp_'.$ac.'.php');

?>