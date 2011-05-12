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

//取得单个数据
$thevalue = $list = array();
$_GET['id'] = empty($_GET['id'])?0:intval($_GET['id']);
if($_GET['id']) {
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('school')." WHERE id=".$_GET['id']);
	$thevalue = $_SGLOBAL['db']->fetch_array($query);
}
if(!empty($_GET['op']) && $_GET['op'] != 'add' && empty($thevalue)) {
	cpmessage('there_is_no_designated_users_columns');
}

if(submitcheck('submit')) {
	$setarr = array(
		'title' => shtmlspecialchars(trim($_POST['title'])),
		'note' => shtmlspecialchars(trim($_POST['note'])),
		'formtype' => shtmlspecialchars(trim($_POST['formtype'])),
		'inputnum' => intval($_POST['inputnum']),
		'choice' => shtmlspecialchars(trim($_POST['choice'])),
		'mtagminnum' => intval($_POST['mtagminnum']),
		'manualmoderator' => intval($_POST['manualmoderator']),
		'manualmember' => intval($_POST['manualmember']),
		'displayorder' => intval($_POST['displayorder'])
	);
	$_POST['fieldid'] = intval($_POST['fieldid']);
	if(empty($thevalue['fieldid'])) {
		inserttable('profield', $setarr);
	} else {
		updatetable('profield', $setarr, array('fieldid'=>$thevalue['fieldid']));
	}
	
	//更新缓存
	include_once(S_ROOT.'./source/function_cache.php');
	profield_cache();
	
	cpmessage('do_success', 'admincp.php?ac=profield');
	
} elseif (submitcheck('ordersubmit')) {
	foreach ($_POST['displayorder'] as $fieldid => $value) {
		updatetable('profield', array('displayorder'=>intval($value)), array('fieldid'=>intval($fieldid)));
	}
	
	//更新缓存
	include_once(S_ROOT.'./source/function_cache.php');
	profield_cache();
	
	cpmessage('do_success', 'admincp.php?ac=profield');
}
//地区
$province_arr = array();
$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('region')." where pid=1");
while ($v = $_SGLOBAL['db']->fetch_array($query)) {
	$province_arr[$v['id']] = $v['name'];
}

if(empty($_GET['op'])) {
	//列表
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('school')." ORDER BY name");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$rs = $_SGLOBAL['db']->query("select name from ".tname('region')." where id=".$value['province_id']);
		$value['province'] = $_SGLOBAL['db']->result($rs, 0);
		$rs = $_SGLOBAL['db']->query("select name from ".tname('region')." where id=".$value['city_id']);
		$value['city'] = $_SGLOBAL['db']->result($rs, 0);
		$rs = $_SGLOBAL['db']->query("select name from ".tname('region')." where id=".$value['region_id']);
		$value['region'] = $_SGLOBAL['db']->result($rs, 0);
		$list[] = $value;
	}
	
	$actives = array('view' => ' class="active"');

} elseif($_GET['op'] == 'add') {
	$province_opts = genOptions($province_arr);
	//添加
	$thevalue = array('filedid' => 0, 'formtype' => 'text');
	$formtypearr = array();

} elseif($_GET['op'] == 'edit') {
	$province_opts = genOptions($province_arr, $thevalue['province_id']);

	//城市
	$city_arr = array();
	if (!empty($thevalue['province_id'])) {
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('region')." where pid=".$thevalue['province_id']);
		while ($v = $_SGLOBAL['db']->fetch_array($query)) {
			$city_arr[$v['id']] = $v['name'];
		}
	}
	$city_opts = genOptions($city_arr, $thevalue['city_id']);

	//区域
	$region_arr = array();
	if (!empty($thevalue['city_id'])) {
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('region')." where pid=".$thevalue['city_id']);
		while ($v = $_SGLOBAL['db']->fetch_array($query)) {
			$region_arr[$v['id']] = $v['name'];
		}
	}
	$region_opts = genOptions($region_arr, $thevalue['region_id']);

	$formtypearr = array($thevalue['formtype'] => ' selected');
	
} elseif($_GET['op'] == 'delete') {
	
	$_GET['fieldid'] = intval($_GET['fieldid']);
	
	//至少保留一个栏目
	if(count($_SGLOBAL['profield']) < 2) {
		cpmessage('have_one_mtag');
	}
	
	if(submitcheck('deletesubmit')) {
		
		$newfieldid = intval($_POST['newfieldid']);
		if(empty($_SGLOBAL['profield'][$newfieldid])) {
			cpmessage('there_is_no_designated_users_columns');
		}
		
		include_once(S_ROOT.'./source/function_delete.php');
		if($_GET['fieldid'] && deleteprofield(array($_GET['fieldid']), $newfieldid)) {
			//更新缓存
			include_once(S_ROOT.'./source/function_cache.php');
			profield_cache();
	
			cpmessage('do_success', 'admincp.php?ac=profield');
		} else {
			cpmessage('choose_to_delete_the_columns', 'admincp.php?ac=profield');
		}
	}
	
	$newfield = $_SGLOBAL['profield'];
	if(isset($newfield[$_GET['fieldid']])) {
		unset($newfield[$_GET['fieldid']]);
	}
	
}

?>