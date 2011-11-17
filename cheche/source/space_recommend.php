<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_feed.php 13194 2009-08-18 07:44:40Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

if(!empty($_POST['submit'])) {
	if (!empty($_REQUEST['sel_uid'])) {
		$setarr = array(
			'uid' => $space['uid'],
			'fusername' => '',
			'status' => 0,
			'gid' => 1,
			'note' => '',
			'num' => 0,
			'dateline' => time()
		);

		foreach (array_unique($_REQUEST['sel_uid']) as $fuid) {
			$setarr['fuid'] = $fuid;
			inserttable('friend', $setarr);
		}
	}
	showmessage('您的请求已经提交，请等待对方确认', "space.php?do=home", 2);
	exit;
}
$result = array();

//获取所有好友
$friend_ids = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select group_concat(fuid) from ".tname('friend')." where uid=".$space['uid']), 0);
$friend_arr = array();
if (!empty($friend_ids)) {
	$friend_arr = explode(',', $friend_ids);
}

//同车系
$where = array();
if (!empty($space['car_brand'])) {
	$where['car'] = "car_brand=".$space['car_brand'];
	if (!empty($space['car_model'])) {
		$where['car'] = "car_model=".$space['car_model'];
	}
}
if (!empty($where)) {
	$where['uid'] = "uid!=".$space['uid'];
	$sql = "Select * from ".tname('spacefield')." where ".implode(" and ", $where);
	$rs = $_SGLOBAL['db']->query($sql);
	if ($_SGLOBAL['db']->num_rows($rs) > 0) {
		$result['car'] = array();
		$i = 0;
		while ($row = $_SGLOBAL['db']->fetch_array($rs)) {
			if ($i>=10) {
				break;
			}
			if (in_array($row['uid'], $friend_arr)) {
				//过滤已有的好友
				continue;
			}
			//根据uid获取username,realname
			$info = $_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query("Select username,name from ".tname('space')." where uid=".$row['uid']));
			realname_set($row['uid'], $info['username'], $info['name'], $info['name']);
			$result['car'][$row['uid']] = array(
				'uid' => $row['uid'],
				'username' => $info['username'],
				'name' => $info['name']
			);
			$i++;
		}
	}
}
//同城市
$where = array();
if (!empty($space['province_id'])) {
	$where['region'] = "province_id=".$space['province_id'];
	if (!empty($space['city_id'])) {
		$where['region'] = "city_id=".$space['city_id'];
	}
}
if (!empty($where)) {
	$where['uid'] = "uid!=".$space['uid'];
	$sql = "Select * from ".tname('spacefield')." where ".implode(" and ", $where);
	$rs = $_SGLOBAL['db']->query($sql);
	if ($_SGLOBAL['db']->num_rows($rs) > 0) {
		$result['city'] = array();
		$i = 0;
		while ($row = $_SGLOBAL['db']->fetch_array($rs)) {
			if ($i>=10) {
				break;
			}
			if (in_array($row['uid'], $friend_arr)) {
				//过滤已有的好友
				continue;
			}
			//根据uid获取username,realname
			$info = $_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query("Select username,name from ".tname('space')." where uid=".$row['uid']));
			realname_set($row['uid'], $info['username'], $info['name'], $info['name']);
			$result['city'][$row['uid']] = array(
				'uid' => $row['uid'],
				'username' => $info['username'],
				'name' => $info['name']
				);
			$i++;
		}
	}
}
//同城驾校群组
$where = array();
if (!empty($space['province_id'])) {
	$where['region'] = "province_id=".$space['province_id'];
	if (!empty($space['city_id'])) {
		$where['region'] = "city_id=".$space['city_id'];
	}
	//查找同城驾校
	$school_ids = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("Select group_concat(id) from ".tname('school')." where ".implode(" and ", $where)), 0);
	if (!empty($school_ids)) {
		$mtag_ids = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("Select group_concat(tagid) from ".tname('mtag')." where ext_field='school' and ext_id in (".$school_ids.")"), 0);
		if (!empty($mtag_ids)) {
			$sql = "Select uid from ".tname('tagspace')." where uid!=".$space['uid']." and tagid in (".$mtag_ids.")";
			$rs = $_SGLOBAL['db']->query($sql);
			if ($_SGLOBAL['db']->num_rows($rs) > 0) {
				$result['school'] = array();
				$i = 0;
				while ($row = $_SGLOBAL['db']->fetch_array($rs)) {
					if ($i>=10) {
						break;
					}
					if (in_array($row['uid'], $friend_arr)) {
						//过滤已有的好友
						continue;
					}
					//根据uid获取username,realname
					$info = $_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query("Select username,name from ".tname('space')." where uid=".$row['uid']));
					realname_set($row['uid'], $info['username'], $info['name'], $info['name']);
					$result['school'][$row['uid']] = array(
						'uid' => $row['uid'],
						'username' => $info['username'],
						'name' => $info['name']
						);
					$i++;
				}
			}
		}
	}
}
include_once template("space_recommend");

?>