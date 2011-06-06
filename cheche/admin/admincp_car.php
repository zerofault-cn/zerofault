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

if(!empty($_POST['submit'])) {
	$id = empty($_POST['id'])?0:intval($_POST['id']);
	$pid = empty($_POST['pid'])?0:intval($_POST['pid']);
	$type = $_POST['type'];
	$name = trim($_POST['name']);
	$initials = empty($_POST['initials'])?'':strtoupper(trim($_POST['initials']));
	$displayorder = empty($_POST['displayorder'])?0:intval($_POST['displayorder']);
	if (''==$name) {
		die('名称必须填写！');
	}
	//检查名称是否已存在
	$sql = "Select * from ".tname('carmodel')." where id!=".$id." and type='".$type."' and name='".$name."'";
	$rs = $_SGLOBAL['db']->query($sql);
	if ($_SGLOBAL['db']->num_rows($rs)>0) {
		die('-1');
	}
	if ('brand' == $type) {
		if (''==$initials) {
			die('名称拼音首字母必须填写！');
		}
	}
	elseif ('model' == $type) {
	}
	elseif ('profile' == $type) {
	}
	$setarr = array(
		'pid' => $pid,
		'type' => $type,
		'name' => $name,
		'initials' => $initials,
		'displayorder' => $displayorder
		);
	if($id>0) {
		updatetable('carmodel', $setarr, array('id'=>$id));
	} else {
		inserttable('carmodel', $setarr);
	}
	die('1');
}

if(empty($_GET['op'])) {
	if (empty($_REQUEST['brand_id'])) {
		//brand list
		$sql = "Select *from ".tname('carmodel')." where pid=0 order by initials, displayorder desc";
		$rs = $_SGLOBAL['db']->query($sql);
		$brand_arr = array();
		while ($row = $_SGLOBAL['db']->fetch_array($rs)) {
			$a = $row['initials'];
			if (!array_key_exists($a, $brand_arr)) {
				$brand_arr[$a] = array();
			}
			$brand_arr[$a][] = $row;
		}
	}
	else {
		$brand_id = intval($_REQUEST['brand_id']);
		$brand_name = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select name from ".tname('carmodel')." where id=".$brand_id), 0);

		//model list
		$sql = "Select * from ".tname('carmodel')." where pid=".$brand_id." order by name";
		$rs = $_SGLOBAL['db']->query($sql);
		$model_arr = array();
		while ($row = $_SGLOBAL['db']->fetch_array($rs)) {
			$row['profile_arr'] = array();
			$rs2 = $_SGLOBAL['db']->query("Select * from ".tname('carmodel')." where pid=".$row['id']." order by name");
			while ($row2 = $_SGLOBAL['db']->fetch_array($rs2)) {
				$row['profile_arr'][] = $row2;
			}
			$model_arr[] = $row;
		}
	}

} elseif($_GET['op'] == 'add') {

} elseif($_GET['op'] == 'edit') {

} elseif($_GET['op'] == 'delete') {
	
}

?>