<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_mtag.php 13083 2009-08-10 09:35:23Z xupeng $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}
exit('1');
$page = empty($_GET['page'])?1:intval($_GET['page']);
if($page<1) $page=1;
$id = empty($_GET['id'])?0:intval($_GET['id']);
//评价
if(!empty($_POST['submit'])) {
	$price = min(5, intval($_POST['price']));
	$service = min(5, intval($_POST['service']));
	$environment = min(5, intval($_POST['environment']));
	$coach = min(5, intval($_POST['coach']));
	$rate = round(($price+$service+$environment+$coach)/4, 1);
	$setarr = array(
		'school_id' => intval($_POST['school_id']),
		'rate' => $rate,
		'price' => $price,
		'service' => $service,
		'environment' => $environment,
		'coach' => $coach,
		'comment' => shtmlspecialchars(trim($_POST['comment'])),
		'uid' => $space['uid'],
		'ip' => $_SERVER['REMOTE_ADDR'],
		'act_time' => date('Y-m-d H:i:s'),
		'status' => 1
	);
	inserttable('rate', $setarr);
	showmessage('do_sucess', "space.php?do=schoolrate&id=".$_POST['school_id'], 0);
	exit;
}
echo $perpage = 20;
$start = ($page-1)*$perpage;

//检查开始数
ckstart($start, $perpage);

$list = array();
$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('rate')." WHERE school_id=".$id), 0);
if($count) {
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('rate')." WHERE school_id=".$id." ORDER BY id DESC LIMIT ".$start.", ".$perpage);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$user = $_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query("select username, name from ".tname('space')." where uid=".$value['uid']));
		$value['username'] = empty(trim($user['name']))?$user['username']:$user['name'];
		$value['width_price'] = $value['price']/5*100;
		$value['width_service'] = $value['service']/5*100;
		$value['width_environment'] = $value['environment']/5*100;
		$value['width_coach'] = $value['coach']/5*100;

		$list[] = $value;
	}
}
print_r($list);
//分页
$multi = multi($count, $perpage, $page, "space.php?do=schoolrate&id=$id");

include_once template("space_schoolrate");

?>