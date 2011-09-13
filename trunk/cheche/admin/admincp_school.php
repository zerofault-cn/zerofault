<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: admincp_profield.php 11954 2009-04-17 09:29:53Z liguode $
*/

if(!defined('IN_UCHOME') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
header("Content-type: text/html; charset=utf-8"); 
//权限
if(!checkperm('manageprofield')) {
	cpmessage('no_authority_management_operation');
}
function error($msg) {
	$html  = '<script language="JavaScript" type="text/javascript">';
	$html .= 'parent.alert("'.$msg.'");';
	$html .= '</script>';
	die($html);
}
function success($msg){
	$html  = '<script language="JavaScript" type="text/javascript">';
	if($msg) {
		$html .= 'parent.alert("'.$msg.'");';
	}
	$html .= 'parent.window.location.href = parent.window.location.href;';
	$html .= '</script>';
	die($html);
}
function convert($data) {
	if (function_exists('iconv')) {
		$data = iconv('GBK','UTF-8',$data);
	}
	else {
		$data = mb_convert_encoding($data,'UTF-8','GBK');
	}
	return $data;
}
if (!empty($_POST['import'])) {
	$header_arr = array('驾校简称', '驾校全称', '联系电话', '驾校地址', '训练场地', '驾校简介', '归属省', '归属地市', '归属区县');
	$fields_arr = array('name', 'fullname', 'telenum', 'address', 'training', 'description', 'province', 'city', 'region');
	if (empty($_FILES['file']) || $_FILES['file']['size']==0) {
		error('您上传的文件是空的！');
	}
	$file = $_FILES['file'];
	$fp = fopen($file['tmp_name'], "r");
	$i=0;
	$values_arr = array();//to save the validated line array
	//setlocale(LC_ALL, NULL);
	setlocale(LC_ALL, 'en_US.UTF-8');
	while($value_arr = fgetcsv($fp)) {
	//	var_dump($value_arr);
		if (empty($value_arr) || ''==trim($value_arr[0])) {
			continue;
		}
		$value_arr = array_map('trim', $value_arr);
		if ($i == 0) {
			if (count($value_arr) != count($header_arr)) {
				error('您上传的文件头不正确！');
			}
		}
		else {
			if (count($value_arr) != count($header_arr)) {
				error('文件内容格式不正确(第'.($i+1).'行)');
			}
			$values_arr[$i] = array_combine($fields_arr, $value_arr);
		}
		$i++;
	}
	echo count($values_arr);
	mb_internal_encoding("UTF-8");
	foreach ($values_arr as $i=>$value_arr) {
		//转换省市区到region_id
		if ('省'==mb_substr($value_arr['province'], -1) || '市'==mb_substr($value_arr['province'], -1)) {
			$value_arr['province'] = mb_substr($value_arr['province'], 0, -1);
		}
		$province_arr = $_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query("Select * from ".tname('region')." where type='province' and name='".$value_arr['province']."'"));
		unset($value_arr['province']);
		$value_arr['province_id'] = intval($province_arr['id']);

		if ('市'==mb_substr($value_arr['city'], -1)) {
			$value_arr['city'] = mb_substr($value_arr['city'], 0, -1);
		}
		$city_arr = $_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query("Select * from ".tname('region')." where type='city' and pid='".$province_arr['id']."' and name='".$value_arr['city']."'"));
		unset($value_arr['city']);
		$value_arr['city_id'] = intval($city_arr['id']);

		$region_arr = $_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query("Select * from ".tname('region')." where type='region' and pid='".$city_arr['id']."' and name='".$value_arr['region']."'"));
		unset($value_arr['region']);
		$value_arr['region_id'] = intval($region_arr['id']);

		inserttable('school', array_map('addslashes', $value_arr));
	}
	success();
	exit;
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
		'name' => shtmlspecialchars(trim($_POST['name'])),
		'fullname' => shtmlspecialchars(trim($_POST['fullname'])),
		'telenum' => shtmlspecialchars(trim($_POST['telenum'])),
		'address' => shtmlspecialchars(trim($_POST['address'])),
		'training' => shtmlspecialchars($_POST['training']),
		'description' => shtmlspecialchars($_POST['description']),
		'province_id' => intval($_POST['province_id']),
		'city_id' => intval($_POST['city_id']),
		'region_id' => intval($_POST['region_id'])
	);
	if(empty($thevalue['id'])) {
		inserttable('school', $setarr);
	} else {
		updatetable('school', $setarr, array('id'=>$thevalue['id']));
	}
	
	//更新缓存
	include_once(S_ROOT.'./source/function_cache.php');
	profield_cache();
	
	cpmessage('do_success', 'admincp.php?ac=school');
	
} elseif (submitcheck('ordersubmit')) {
	foreach ($_POST['displayorder'] as $id => $value) {
		updatetable('school', array('displayorder'=>intval($value)), array('id'=>intval($id)));
	}
	
	cpmessage('do_success', 'admincp.php?ac=school');
}
//地区
$province_arr = array();
$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('region')." where pid=1");
while ($v = $_SGLOBAL['db']->fetch_array($query)) {
	$province_arr[$v['id']] = $v['name'];
}

if(empty($_GET['op'])) {
	$theurl = 'admincp.php?ac=school';
	
	//处理搜索选项
	$sql_ext = "";
	$s_name = "";
	if (!empty($_REQUEST['s_name'])) {
		$s_name = shtmlspecialchars(trim($_REQUEST['s_name']));
		$sql_ext .= " and (name like '%".$s_name."%' or fullname like '%".$s_name."%')";
	}
	if (!empty($_REQUEST['s_region_id'])) {
		$sql_ext .= " and region_id=".intval($_REQUEST['s_region_id']);
	}
	elseif (!empty($_REQUEST['s_city_id'])) {
		$sql_ext .= " and city_id=".intval($_REQUEST['s_city_id']);
		$region_arr = array();
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('region')." where pid=".intval($_REQUEST['s_city_id']));
		while ($v = $_SGLOBAL['db']->fetch_array($query)) {
			$region_arr[$v['id']] = $v['name'];
		}
		$region_opts = genOptions($region_arr, intval($_REQUEST['s_region_id']));
	}
	elseif (!empty($_REQUEST['s_province_id'])) {
		$sql_ext .= " and province_id=".intval($_REQUEST['s_province_id']);
		$city_arr = array();
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('region')." where pid=".intval($_REQUEST['s_province_id']));
		while ($v = $_SGLOBAL['db']->fetch_array($query)) {
			$city_arr[$v['id']] = $v['name'];
		}
		$city_opts = genOptions($city_arr, intval($_REQUEST['s_city_id']));
	}
	$province_opts = genOptions($province_arr, intval($_REQUEST['s_province_id']));

	//驾校列表
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select count(*) from ".tname('school')." where 1 ".$sql_ext." "), 0);
	$perpage = 20;
	if (''!=$sql_ext) {
		$perpage = 10000;
	}
	$page = intval($_GET['page']);
	if($page < 1) $page = 1;
	$start = ($page-1)*$perpage;
	$list = array();
	if ($count > 0) {
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('school')." where 1 ".$sql_ext." order by displayorder desc, id desc LIMIT ".$start.", ".$perpage);
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$rs = $_SGLOBAL['db']->query("select name from ".tname('region')." where id=".$value['province_id']);
			$value['province'] = $_SGLOBAL['db']->result($rs, 0);
			$rs = $_SGLOBAL['db']->query("select name from ".tname('region')." where id=".$value['city_id']);
			$value['city'] = $_SGLOBAL['db']->result($rs, 0);
			$rs = $_SGLOBAL['db']->query("select name from ".tname('region')." where id=".$value['region_id']);
			$value['region'] = $_SGLOBAL['db']->result($rs, 0);
			if (!empty($s_name)) {
				$value['name'] = str_replace($s_name, '<em>'.$s_name.'</em>', $value['name']);
				$value['fullname'] = str_replace($s_name, '<em>'.$s_name.'</em>', $value['fullname']);
			}
			$list[] = $value;
		}
		$multi = multi($count, $perpage, $page, $theurl);
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
	$id = intval($_GET['id']);
	//检查改驾校下是否有群组关联
	$query = "select count(*) from ".tname('mtag')." where fieldid=4 and ext_id=".$id;
	if ($_SGLOBAL['db']->result($_SGLOBAL['db']->query($query), 0) >0) {
		$school = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT * FROM ".tname('school')." WHERE id='".$id."'"), 0);
		$province_opts = genOptions($province_arr, $school['province_id']);

		//城市
		$city_arr = array();
		if (!empty($school['province_id'])) {
			$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('region')." where pid=".$school['province_id']);
			while ($arr = $_SGLOBAL['db']->fetch_array($query)) {
				$city_arr[$arr['id']] = $arr['name'];
			}
		}
		$city_opts = genOptions($city_arr, $school['city_id']);

		//区域
		$region_arr = array();
		if (!empty($school['city_id'])) {
			$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('region')." where pid=".$school['city_id']);
			while ($arr = $_SGLOBAL['db']->fetch_array($query)) {
				$region_arr[$arr['id']] = $arr['name'];
			}
		}
		$region_opts = genOptions($region_arr, $school['region_id']);

		//驾校
		$school_arr = array();
		if (!empty($school['region_id'])) {
			$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('school')." where region_id=".$school['region_id']." ");
			while ($arr = $_SGLOBAL['db']->fetch_array($query)) {
				if ($arr['id'] == $_GET['id']) {
					continue;
				}
				$school_arr[$arr['id']] = $arr['name'];
			}
		}
		$school_opts = genOptions($school_arr);

		if(submitcheck('deletesubmit')) {
			
			$ext_id = intval($_POST['ext_id']);
			if(empty($ext_id)) {
				cpmessage('您必须给原驾校下的群组选择一个新归宿！');
			}
			$query0= "update ".tname('mtag')." set ext_id=".$ext_id." where fieldid=4 and ext_id=".$id;
			$query = "delete from ".tname('school')." where id=".$id;
			if ($_SGLOBAL['db']->query($query0) && $_SGLOBAL['db']->query($query)) {
				cpmessage('do_success', 'admincp.php?ac=school');
			}
		}
	}
	else {
		$query = "delete from ".tname('school')." where id=".$id;
		if ($_SGLOBAL['db']->query($query)) {
			cpmessage('do_success', 'admincp.php?ac=school');
		}
	}
}

?>