<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: admincp_profield.php 11954 2009-04-17 09:29:53Z liguode $
*/
function success($msg) {
	$html = '<script>';
	$html.= 'alert("'.$msg.'");';
	$html.= 'parent.myLocation("");';
	$html.= '</script>';
	die($html);
}
function error($msg) {
	$html = '<script>';
	$html.= 'alert("'.$msg.'");';
	$html.= '</script>';
	die($html);
}
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
		error('名称必须填写！');
	}
	//检查名称是否已存在
	$sql = "Select * from ".tname('carmodel')." where id!=".$id." and pid='".$pid."' and name='".$name."'";
	$rs = $_SGLOBAL['db']->query($sql);
	if ($_SGLOBAL['db']->num_rows($rs)>0) {
		error('该名称已经添加过了！');
	}
	if ('brand' == $type) {
		if (''==$initials) {
			error('名称拼音首字母必须填写！');
		}
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
	success('提交成功！');
}
elseif (submitcheck('ordersubmit')) {
	foreach ($_POST['displayorder'] as $id => $value) {
		updatetable('carmodel', array('displayorder'=>intval($value)), array('id'=>intval($id)));
	}
	success('更新排序成功！');
}
if(empty($_REQUEST['op'])) {
	if (empty($_REQUEST['brand_id'])) {
		//brand list
		$sql = "Select *from ".tname('carmodel')." where pid=0 order by initials, displayorder desc";
		$rs = $_SGLOBAL['db']->query($sql);
		$brand_arr = array();
		while ($row = $_SGLOBAL['db']->fetch_array($rs)) {
			$row['count'] = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select count(*) from ".tname('carmodel')." where pid=".$row['id']), 0);
			$brand_arr[] = $row;
		}
	}
	elseif (empty($_REQUEST['model_id'])) {
		$brand_id = intval($_REQUEST['brand_id']);
		$brand_name = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select name from ".tname('carmodel')." where id=".$brand_id), 0);

		//model list
		$sql = "Select * from ".tname('carmodel')." where pid=".$brand_id." order by displayorder desc";
		$rs = $_SGLOBAL['db']->query($sql);
		$model_arr = array();
		while ($row = $_SGLOBAL['db']->fetch_array($rs)) {
			$row['count'] = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select count(*) from ".tname('carmodel')." where pid=".$row['id']), 0);
			$model_arr[] = $row;
		}
	}
	elseif (empty($_REQUEST['profile_id'])) {
		$brand_id = intval($_REQUEST['brand_id']);
		$brand_name = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select name from ".tname('carmodel')." where id=".$brand_id), 0);

		$model_id = intval($_REQUEST['model_id']);
		$model_name = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select name from ".tname('carmodel')." where id=".$model_id), 0);

		$sql = "Select * from ".tname('carmodel')." where pid=".$model_id." order by displayorder desc";
		$rs = $_SGLOBAL['db']->query($sql);
		$profile_arr = array();
		while ($row = $_SGLOBAL['db']->fetch_array($rs)) {
			$row['count'] = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select count(*) from ".tname('carmodel')." where pid=".$row['id']), 0);
			$profile_arr[] = $row;
		}
	}

} elseif($_REQUEST['op'] == 'add') {

} elseif($_REQUEST['op'] == 'edit') {
	$id = empty($_POST['id'])? 0 : intval($_POST['id']);
	$type = empty($_POST['type'])? '' : $_POST['type'];
	$name = trim($_POST['name']);
	if (empty($id) || empty($type)) {
		die('参数错误！');
	}
	if (''==$name) {
		die('名称必须填写！');
	}
	$tmp = explode(' ', $type);
	$type = $tmp[0];
	
	//检查名称是否已存在
	$sql = "Select * from ".tname('carmodel')." where id!=".$id." and type='".$type."' and name='".$name."'";
	$rs = $_SGLOBAL['db']->query($sql);
	if ($_SGLOBAL['db']->num_rows($rs)>0) {
		die('-1');
	}
	$setarr = array(
		'type' => $type,
		'name' => $name
		);
	updatetable('carmodel', $setarr, array('id'=>$id));
	die('1');
	

} elseif($_REQUEST['op'] == 'delete') {
	$id = empty($_REQUEST['id'])? 0 : intval($_REQUEST['id']);
	$type = empty($_REQUEST['type'])? '' : $_REQUEST['type'];
	if (empty($id) || empty($type)) {
		error('参数错误！');
	}
	//检测是否已被用户使用
	$sql = "Select * from ".tname('spacefield')." where car_".$type."=".$id;
	$rs = $_SGLOBAL['db']->query($sql);
	if ($_SGLOBAL['db']->num_rows($rs) > 0) {
		error('已在使用中，不能直接删除！');
	}
	$sql = "Delete from ".tname('carmodel')." where id=".$id;
	if ($_SGLOBAL['db']->query($sql)) {
		success('删除成功！');
	}
	else {
		error('系统错误！');
	}
}

?>