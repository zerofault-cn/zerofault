<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_profile.php 13149 2009-08-13 03:11:26Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}
$tagid = intval($_REQUEST['tagid']);
$id = empty($_REQUEST['id'])? 0 : intval($_REQUEST['id']);

if(!empty($_REQUEST['submit'])) {
	$setarr = array();
	
	$setarr['tagid'] = $tagid;
	$setarr['title'] = getstr($_POST['title'], 40, 1, 1, 1);
	$setarr['name'] = getstr($_POST['name'], 40, 1, 1, 1);
	$setarr['desc'] = getstr($_POST['desc'], 40, 1, 1, 1);
	$setarr['contact'] = getstr($_POST['contact'], 40, 1, 1, 1);
	$setarr['address'] = getstr($_POST['address'], 40, 1, 1, 1);
	$setarr['telephone'] = getstr($_POST['telephone'], 40, 1, 1, 1);
	$setarr['link'] = getstr($_POST['link'], 80, 1, 1, 1);
	$setarr['remark'] = getstr($_POST['remark'], 5000, 1, 1, 1, 1);
	$setarr['displayorder'] = intval($_POST['displayorder']);
	if ($id > 0) {
		updatetable('partner', $setarr, array('id'=>$id));
	}
	else {
		inserttable('partner', $setarr);
	}
	showmessage('do_success', "space.php?do=mtag&tagid=".$tagid."&view=partner");
}

$tagname = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("Select tagname from ".tname('mtag')." where tagid=".$tagid), 0);

if ($id>0) {
	$info = $_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query("Select * from ".tname('partner')." where id=".$id));
}
else {
	$info = array();
}
include template("cp_partner");

?>