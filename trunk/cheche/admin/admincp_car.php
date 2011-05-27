<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: admincp_profield.php 11954 2009-04-17 09:29:53Z liguode $
*/

if(!defined('IN_UCHOME') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

//权限
if(!checkperm('manageprofield')) {
	cpmessage('no_authority_management_operation');
}

if(submitcheck('submit')) {
	$setarr = array(
		'name' => shtmlspecialchars(trim($_POST['name'])),
	);
	if(empty($thevalue['id'])) {
		inserttable('car', $setarr);
	} else {
		updatetable('car', $setarr, array('id'=>$thevalue['id']));
	}
	
	//更新缓存
	include_once(S_ROOT.'./source/function_cache.php');
	profield_cache();
	
	cpmessage('do_success', 'admincp.php?ac=car');
}

if(empty($_GET['op'])) {
	$theurl = 'admincp.php?ac=car';


	$actives = array('view' => ' class="active"');

} elseif($_GET['op'] == 'add') {

} elseif($_GET['op'] == 'edit') {

} elseif($_GET['op'] == 'delete') {
	
}

?>