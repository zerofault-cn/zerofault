<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_mtag.php 13083 2009-08-10 09:35:23Z xupeng $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

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
	
	$id = $_POST['school_id'];
}
$perpage = 20;
$start = ($page-1)*$perpage;

//检查开始数
ckstart($start, $perpage);

$list = array();
$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('rate')." WHERE school_id=".$id), 0);
if($count) {
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('rate')." WHERE school_id=".$id." ORDER BY id DESC LIMIT ".$start.", ".$perpage);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[] = $value;
	}
}

//分页
$multi = multi($count, $perpage, $page, "space.php?uid=$space[uid]&do=mtag&id=$id");

include_once template("space_schoolrate");

?>