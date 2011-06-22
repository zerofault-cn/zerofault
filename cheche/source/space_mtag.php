<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_mtag.php 13083 2009-08-10 09:35:23Z xupeng $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

@include_once(S_ROOT.'./data/data_profield.php');

$page = empty($_GET['page'])?1:intval($_GET['page']);
if($page<1) $page=1;
$id = empty($_GET['id'])?0:intval($_GET['id']);
$tagid = empty($_GET['tagid'])?0:intval($_GET['tagid']);
$fieldid = empty($_GET['fieldid'])?0:intval($_GET['fieldid']);
$tagname = trim($_GET['tagname']);

//查询
if($tagname) {
	
	$fields = array();
	foreach ($_SGLOBAL['profield'] as $value) {
		if($value['formtype'] == 'text') {
			$fields[] = $value;//自由输入的分类
		}
	}
	
	$taglist = array();
	if($fieldid) {
		$plussql = " AND fieldid='$fieldid'";
		$field = $_SGLOBAL['profield'][$fieldid];
	} else {
		$plussql = '';
		$field = array();
	}
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('mtag')." WHERE tagname='$tagname' $plussql");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$taglist[] = $value;
	}
	
	if(empty($taglist)) {
		//群组创建
		$allowmk = 0;
		if($field && $field['formtype'] != 'text') {
			$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('profield')." WHERE fieldid='$fieldid'");
			if($field = $_SGLOBAL['db']->fetch_array($query)) {
				$field['choice'] = explode("\n", $field['choice']);
				$s = stripslashes($tagname);
				foreach ($field['choice'] as $subkey => $subvalue) {
					$subvalue = trim($subvalue);
					if($s == $subvalue) {
						//自动创建
						$mtag = array(
							'tagname' => addslashes($s),
							'fieldid' => $fieldid
						);
						$tagid = inserttable('mtag', $mtag, 1);
						showmessage('do_sucess', "space.php?do=mtag&tagid=".$tagid, 0);
					}
				}
			}
		} elseif ($fields) {
			$allowmk = 1;
		}
		if(!$allowmk) {
			showmessage('mtag_creat_error');
		}
	} elseif(count($taglist) == 1) {
		//直接跳转
		showmessage('do_sucess', "space.php?do=mtag&tagid=".$taglist[0]['tagid'], 0);
	}
	
	$_TPL['css'] = 'thread';
	include_once template("space_mtag_tagname");
	
} elseif($id) {
	$perpage = 20;
	$start = ($page-1)*$perpage;
	
	//检查开始数
	ckstart($start, $perpage);
	
	//栏目
	$list = array();
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('mtag')." WHERE fieldid='$id'"),0);
	if($count) {
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('mtag')." WHERE fieldid='$id' ORDER BY membernum DESC LIMIT $start,$perpage");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			if(empty($value['pic'])) {
				$value['pic'] = 'image/nologo.jpg';
			}
			if (2==$value['fieldid'] || 3==$value['fieldid']) {
				//区域联盟
				//还原地区信息
				$region = $_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query("SELECT * FROM ".tname('region')." WHERE id='".$value['region_id']."'"));
				if ('region' == $value['region_field']) {
					$region_id = $value['region_id'];
					$region_name = $region['name'];
				}
				elseif ('city' == $value['region_field']) {
					$city_id =  $value['region_id'];
					$city_name = $region['name'];
				}
				if (!empty($region_id)) {
					$city_name = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT name FROM ".tname('region')." WHERE id='".$region['pid']."'"), 0);
				}
				$value['ext_name'] = $city_name.$region_name;
			}
			if (3==$value['fieldid']) {
				//还原车系信息
				$car = $_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query("SELECT * FROM ".tname('carmodel')." WHERE id='".$value['ext_id']."'"));
				if ('profile' == $value['ext_field']) {
					$car_profile_id = $value['ext_id'];
				}
				elseif ('model' == $value['ext_field']) {
					$car_model_id = $value['ext_id'];
					$car_model_name = $car['name'];
				}
				if (!empty($car_profile_id)) {
					$car_model_name = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT name FROM ".tname('carmodel')." WHERE id='".$car['pid']."'"), 0);
				}
				$value['ext_name'] .= ' '.$car_model_name;
			}
			elseif (4==$value['fieldid']) {
				//驾校联盟
				$value['ext_name'] = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT name FROM ".tname('school')." WHERE id='".$value['ext_id']."'"), 0);
			}
			$list[] = $value;
		}
	}
	
	//分页
	$multi = multi($count, $perpage, $page, "space.php?uid=$space[uid]&do=mtag&id=$id");

	$fieldtitle = $_SGLOBAL['profield'][$id]['title'];
	
	$sub_actives = array($id => ' class="active"');
	$fieldids = array($id => ' selected');

	$_TPL['css'] = 'thread';
	include_once template("space_mtag_field");

} elseif($tagid) {

	$actives = array($_GET['view'] => ' class="active"');
	
	//指定的群组
	$mtag = getmtag($tagid);
	if($mtag['close']) {
		showmessage('mtag_close');
	}
	if (2==$mtag['fieldid'] || 3==$mtag['fieldid']) {
		//区域联盟
		//还原地区信息
		$region = $_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query("SELECT * FROM ".tname('region')." WHERE id='".$mtag['region_id']."'"));
		if ('region' == $mtag['region_field']) {
			$region_id = $mtag['region_id'];
			$region_name = $region['name'];
		}
		elseif ('city' == $mtag['region_field']) {
			$city_id =  $mtag['region_id'];
			$city_name = $region['name'];
		}
		if (!empty($region_id)) {
			$city_name = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT name FROM ".tname('region')." WHERE id='".$region['pid']."'"), 0);
		}
		$mtag['ext_name'] = $city_name.$region_name;
	}
	if (3==$mtag['fieldid']) {
		//还原车系信息
		$car = $_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query("SELECT * FROM ".tname('carmodel')." WHERE id='".$mtag['ext_id']."'"));
		if ('profile' == $mtag['ext_field']) {
			$car_profile_id = $mtag['ext_id'];
		}
		elseif ('model' == $mtag['ext_field']) {
			$car_model_id = $mtag['ext_id'];
			$car_model_name = $car['name'];
		}
		if (!empty($car_profile_id)) {
			$car_model_name = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT name FROM ".tname('carmodel')." WHERE id='".$car['pid']."'"), 0);
		}
		$mtag['ext_name'] .= ' '.$car_model_name;
	}
	elseif (4==$mtag['fieldid']) {
		//驾校联盟
		$mtag['ext_name'] = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT name FROM ".tname('school')." WHERE id='".$mtag['ext_id']."'"), 0);
		$mtag['ext_link'] = '<a href="space.php?do=mtag&view=school&school_id='.$mtag['ext_id'].'" title="查看该驾校其它群组">'.$mtag['ext_name'].'</a>';
	}
	//群组活动
	$eventnum = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname("event")." WHERE tagid='$tagid'"), 0);
	
	if($_GET['view'] == 'list' || $_GET['view'] == 'digest') {
		
		$perpage = 30;
		$start = ($page-1)*$perpage;
		
		//检查开始数
		ckstart($start, $perpage);
		$theurl = "space.php?uid=$space[uid]&do=mtag&tagid=$tagid&view=$_GET[view]";

		$wheresql = ($_GET['view'] == 'list')?'':" AND main.digest='1'";
		
		if($searchkey = stripsearchkey($_GET['searchkey'])) {
		   $wheresql .= "AND main.subject LIKE '%$searchkey%' ";
		   $theurl .= "&searchkey=$_GET[searchkey]";
		}
		  
		$list = array();
		$count = 0;
		
		if($mtag['allowview']) {
			$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('thread')." main WHERE main.tagid='$tagid' $wheresql"),0);
			if($count) {
				$query = $_SGLOBAL['db']->query("SELECT main.* FROM ".tname('thread')." main 
					WHERE main.tagid='$tagid' $wheresql
					ORDER BY main.displayorder DESC, main.lastpost DESC 
					LIMIT $start,$perpage");
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					realname_set($value['uid'], $value['username']);
					realname_set($value['lastauthorid'], $value['lastauthor']);
					$list[] = $value;
				}
			}
			//分页
			$multi = multi($count, $perpage, $page, $theurl);
	
			realname_get();
		}
		
		$_TPL['css'] = 'thread';
		include_once template("space_mtag_list");
		
	} elseif($_GET['view'] == 'member') {
		
		$perpage = 50;
		$start = ($page-1)*$perpage;
		
		//检查开始数
		ckstart($start, $perpage);
		
		//检索
		$wheresql = '';
		$_GET['key'] = stripsearchkey($_GET['key']);
		if($_GET['key']) {
			$wheresql = " AND main.username LIKE '%$_GET[key]%' ";
		}

		
		$list = $fuids = array();
		$count = 0;
		
		if($mtag['allowview']) {
			$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('tagspace')." main WHERE main.tagid='$tagid' $wheresql"),0);
			if($count) {
				$query = $_SGLOBAL['db']->query("SELECT field.*, main.username, main.grade FROM ".tname('tagspace')." main 
					LEFT JOIN ".tname('spacefield')." field ON field.uid=main.uid 
					WHERE main.tagid='$tagid' $wheresql ORDER BY main.grade DESC LIMIT $start,$perpage");
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					//实名
					realname_set($value['uid'], $value['username']);
					
					$value['p'] = rawurlencode($value['resideprovince']);
					$value['c'] = rawurlencode($value['residecity']);
					$fuids[] = $value['uid'];
					$list[] = $value;
				}
			}
			
			//在线状态
			$ols = array();
			if($fuids) {
				$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('session')." WHERE uid IN (".simplode($fuids).")");
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					if(!$value['magichidden']) {
						$ols[$value['uid']] = $value['lastactivity'];
					}
				}
			}
	
			//分页
			$multi = multi($count, $perpage, $page, "space.php?uid=$space[uid]&do=mtag&tagid=$tagid&view=member");
			
			//实名
			realname_get();
		}
		
		$_TPL['css'] = 'thread';
		include_once template("space_mtag_member");
	
	} elseif ($_GET['view'] == 'event') {
		
		$perpage = 10;
		$start = ($page-1)*$perpage;
		
		//检查开始数
		ckstart($start, $perpage);
		$eventlist = array();
		if($eventnum) {
			// 活动分类
			@include_once(S_ROOT.'./data/data_eventclass.php');
			$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname("event")." WHERE tagid='$tagid' ORDER BY eventid DESC LIMIT $start, $perpage");
			while($value=$_SGLOBAL['db']->fetch_array($query)) {
				if($value['poster']){
					$value['pic'] = pic_get($value['poster'], $value['thumb'], $value['remote']);
				} else {
					$value['pic'] = $_SGLOBAL['eventclass'][$value['classid']]['poster'];
				}
				$eventlist[] = $value;
			}
		}
		
		//分页
		$multi = multi($eventnum, $perpage, $page, "space.php?uid=$space[uid]&do=mtag&tagid=$tagid&view=event");
	
		$_TPL['css'] = 'thread';
		include_once template("space_mtag_event");
		
	} else {

		//群组首页
		$list = $starlist = $modlist = $memberlist = $checklist = array();
		
		if($mtag['allowview']) {
			$query = $_SGLOBAL['db']->query("SELECT main.* FROM ".tname('thread')." main 
				WHERE main.tagid='$tagid' 
				ORDER BY main.displayorder DESC, main.lastpost DESC 
				LIMIT 0,50");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				realname_set($value['uid'], $value['username']);
				realname_set($value['lastauthorid'], $value['lastauthor']);
				$list[] = $value;
			}
			
			//明星会员
			$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('tagspace')." WHERE tagid='$tagid' AND grade='1'");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				realname_set($value['uid'], $value['username']);
				$starlist[] = $value;
			}
			$starlist = sarray_rand($starlist, 12);//随机选择
								
			//会员
			$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('tagspace')." WHERE tagid='$tagid' AND grade='0' LIMIT 0,12");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				realname_set($value['uid'], $value['username']);
				$memberlist[] = $value;
			}
		}
		//群主
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('tagspace')." WHERE tagid='$tagid' AND grade>'7' ORDER BY grade DESC LIMIT 0,12");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['uid'], $value['username']);
			$modlist[] = $value;
		}
		//是群主
		if($mtag['grade']>=8) {
			//待审
			$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('tagspace')." WHERE tagid='$tagid' AND grade='-2' LIMIT 0,12");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				realname_set($value['uid'], $value['username']);
				$checklist[] = $value;
			}
		}
		
		realname_get();
		
		$_TPL['css'] = 'thread';
		include_once template("space_mtag_index");
	}

} else {

	$theurl = "space.php?uid=$space[uid]&do=mtag";
	
	if(empty($_GET['view'])) $_GET['view'] = 'me';
	if(!in_array($_GET['view'], array('me', 'hot', 'recommend', 'manage', 'school'))) $_GET['view'] = 'hot';
	
	$theurl .= "&view=$_GET[view]";
	$actives = array($_GET['view'] => ' class="active"');		

	$wherearr = array();
	
	//排序
	if (!in_array($_GET['orderby'], array('threadnum', 'postnum', 'membernum'))) {
		$_GET['orderby'] = 'threadnum';
	} else {
		$theurl .= "&orderby=$_GET[orderby]";
	}
	$orderbyarr = array($_GET['orderby'] => ' class="active"');
	
	//查询
	$_GET['fieldid'] = intval($_GET['fieldid']);
	if($_GET['fieldid']) {
		$wherearr[] = "mt.fieldid='$_GET[fieldid]'";
		$theurl .= "&fieldid=$_GET[fieldid]";
		$pro_actives = array($_GET['fieldid'] => ' class="current"');
	} else {
		$pro_actives = array('all' => ' class="current"');
	}
	
	$list = $rlist = array();
	$multi = '';
	$count = 0;
	
	$perpage = 20;
	$school_perpage = 10;
	$page = intval($_GET['page']);
	if($page < 1) $page = 1;
	$start = ($page-1)*$perpage;
	$school_start = ($page-1)*$school_perpage;

	if('school'==$_GET['view']) {
		$countsql = "select 0";
		if (!empty($_REQUEST['s_school_name']) && ''!=trim($_REQUEST['s_school_name'])) {
			//搜索驾校
			$s_school_name = shtmlspecialchars(trim($_REQUEST['s_school_name']));
			$school_ext .= " and (name like '%".$s_school_name."%' or fullname like '%".$s_school_name."%')";
			if (!empty($_REQUEST['province_id'])) {
				$province_name = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select name from ".tname('region')." where id=".intval($_REQUEST['province_id'])), 0);
				$school_ext .= " and province_id=".intval($_REQUEST['province_id']);
			}
			if (!empty($_REQUEST['city_id'])) {
				$city_name = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select name from ".tname('region')." where id=".intval($_REQUEST['city_id'])), 0);
				$school_ext .= " and city_id=".intval($_REQUEST['city_id']);
			}
			if (!empty($_REQUEST['region_id'])) {
				$region_name = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select name from ".tname('region')." where id=".intval($_REQUEST['region_id'])), 0);
				$school_ext .= " and region_id=".intval($_REQUEST['region_id']);
			}
			$query = $_SGLOBAL['db']->query("select * from ".tname('school')." where 1 ".$school_ext."  order by displayorder desc");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				//统计驾校下的群组数、话题数
				$value['mtag_count'] = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select count(*) from ".tname('mtag')." where fieldid=4 and ext_id=".$value['id']), 0);
				$value['member_count'] = intval($_SGLOBAL['db']->result($_SGLOBAL['db']->query("select sum(membernum) from ".tname('mtag')." where fieldid=4 and ext_id=".$value['id']), 0));

				$value['name'] = str_replace($s_school_name, '<em>'.$s_school_name.'</em>', $value['name']);
				$value['fullname'] = str_replace($s_school_name, '<em>'.$s_school_name.'</em>', $value['fullname']);
				$school_list[] = $value;
			}
		}
		else {
			$theurl = 'space.php?do=mtag&view=school';
			if (empty($_REQUEST['school_id'])) {
				if (empty($_REQUEST['province_id'])) {
					//获取省份热点形状
					$map_str = '';
					$sql = "select * from ".tname('region')." where pid=1";
					$query = $_SGLOBAL['db']->query($sql);
					while ($value = $_SGLOBAL['db']->fetch_array($query)) {
						$tmp = explode(',', $value['coords']);
						$map_str .= '<area shape="'.$value['shape'].'" coords="'.$value['coords'].'" href="?do=mtag&view=school&province_id='.$value['id'].'" alt="'.$value['name'].'"><div class="area_overlay" style="left:'.$tmp[0].'px;top:'.$tmp[1].'px;width:'.($tmp[2]-$tmp[0]).'px;"><a href="?do=mtag&view=school&province_id='.$value['id'].'">'.$value['name'].'</a></div>'."\n";
					}
				}
				else {
					$theurl .= '&province_id='.intval($_GET['province_id']);
					$school_ext = " and province_id=".intval($_GET['province_id']);
					$province_name = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select name from ".tname('region')." where id=".intval($_GET['province_id'])), 0);
					$profile = parse_ini_file(S_ROOT.'profile.ini', true);
					if (in_array($province_name, $profile['direct_city'])) {
						$_GET['city_id'] = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select id from ".tname('region')." where pid=".intval($_GET['province_id'])), 0);
					}
					if (empty($_GET['city_id'])) {
						//获取某省下的城市列表
						$city_list = array();
						$query = $_SGLOBAL['db']->query("select * from ".tname('region')." where pid=".intval($_GET['province_id']));
						while ($value = $_SGLOBAL['db']->fetch_array($query)) {
							//统计每个市下的驾校数
							$value['count'] = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select count(*) from ".tname('school')." where city_id=".$value['id']), 0);
							$city_list[] = $value;
						}
					}
					else {
						$theurl .= '&city_id='.intval($_GET['city_id']);
						$school_ext = " and city_id=".intval($_GET['city_id']);
						$city_name = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select name from ".tname('region')." where id=".intval($_GET['city_id'])), 0);
						if (empty($_GET['region_id'])) {
							//获取市下面的区域
							$region_list = array();
							$query = $_SGLOBAL['db']->query("select * from ".tname('region')." where pid=".intval($_GET['city_id']));
							while ($value = $_SGLOBAL['db']->fetch_array($query)) {
								//统计每个区下的驾校数
								$value['count'] = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select count(*) from ".tname('school')." where region_id=".$value['id']), 0);
								$region_list[] = $value;
							}
						}
						else {
							$theurl .= '&region_id='.intval($_GET['region_id']);
							$school_ext = " and region_id=".intval($_GET['region_id']);
							$region_name = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select name from ".tname('region')." where id=".intval($_GET['region_id'])), 0);
						}
					}
					$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select count(*) from ".tname('school')." where 1 ".$school_ext), 0);
					$school_list = array();
					if ($count > 0) {
						$query = $_SGLOBAL['db']->query("select * from ".tname('school')." where 1 ".$school_ext."  order by displayorder desc LIMIT ".$school_start.", ".$school_perpage);
						while ($value = $_SGLOBAL['db']->fetch_array($query)) {
							//统计驾校下的群组数、话题数
							$value['mtag_count'] = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select count(*) from ".tname('mtag')." where fieldid=4 and ext_id=".$value['id']), 0);
							$value['member_count'] = intval($_SGLOBAL['db']->result($_SGLOBAL['db']->query("select sum(membernum) from ".tname('mtag')." where fieldid=4 and ext_id=".$value['id']), 0));
							$school_list[] = $value;
						}
						$multi = multi($count, $school_perpage, $page, $theurl);
					}
				}
			}
			else {
				$query = $_SGLOBAL['db']->query("select * from ".tname('school')." where id=".$_REQUEST['school_id']." limit 1");
				$school = $_SGLOBAL['db']->fetch_array($query);
				$rate_count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select count(*) from ".tname('rate')." where school_id=".$_REQUEST['school_id']), 0);
				$rate_sum = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select sum(rate) from ".tname('rate')." where school_id=".$_REQUEST['school_id']), 0);
				$school['width'] = $rate_sum/max(1,$rate_count)*20;

				$province_name = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select name from ".tname('region')." where id=".$school['province_id']), 0);
				$city_name = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select name from ".tname('region')." where id=".$school['city_id']), 0);
				$region_name = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("select name from ".tname('region')." where id=".$school['region_id']), 0);
				
				//驾校下的群组
				$countsql = "select count(*) from ".tname('mtag')." where fieldid=4 and ext_id=".$_REQUEST['school_id'];
				$sql = "SELECT mt.* FROM ".tname('mtag')." mt WHERE fieldid=4 and ext_id=".$_REQUEST['school_id']." ORDER BY mt.".$_GET['orderby']." DESC LIMIT ".$start.", ".$perpage;
			}
		}
	}
	elseif($_GET['view'] == 'me' || $_GET['view'] == 'manage') {
		$sqlplus = $_GET['view'] == 'manage'?' AND main.grade=\'9\'':'';
		if($_GET['fieldid']) {
			$countsql = "SELECT COUNT(*) FROM ".tname('tagspace')." main, ".tname('mtag')." mt
				WHERE main.uid='$space[uid]' $sqlplus AND mt.tagid=main.tagid AND ".implode(' AND ', $wherearr);
			$sql = "SELECT main.*,mt.* FROM ".tname('tagspace')." main, ".tname('mtag')." mt
				WHERE main.uid='$space[uid]' $sqlplus AND mt.tagid=main.tagid AND ".implode(' AND ', $wherearr)." ORDER BY mt.{$_GET['orderby']} DESC LIMIT $start,$perpage";
		} else {
			$countsql = "SELECT COUNT(*) FROM ".tname('tagspace')." main
				WHERE main.uid='$space[uid]' $sqlplus";
			$sql = "SELECT main.*,mt.* FROM ".tname('tagspace')." main 
				LEFT JOIN ".tname('mtag')." mt ON mt.tagid=main.tagid
				WHERE main.uid='$space[uid]' $sqlplus ORDER BY mt.{$_GET['orderby']} DESC LIMIT $start,$perpage";
		}
	} else {
		if($_GET['view'] == 'recommend') {
			$wherearr[] = "mt.recommend='1'";
		}
		
		//搜索
		if($searchkey = stripsearchkey($_GET['searchkey'])) {
			$wherearr[] = "mt.tagname LIKE '%$searchkey%'";
			$theurl .= "&searchkey=$_GET[searchkey]";
		}
		
		$countsql = "SELECT COUNT(*) FROM ".tname('mtag')." mt WHERE ".(empty($wherearr)?'1':implode(' AND ', $wherearr));
		$sql = "SELECT mt.* FROM ".tname('mtag')." mt
			WHERE ".(empty($wherearr)?'1':implode(' AND ', $wherearr))." ORDER BY mt.{$_GET['orderby']} DESC LIMIT $start,$perpage";
	}
	
	$tagids = $tagnames = array();
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($countsql), 0);
	if($count) {
		$query = $_SGLOBAL['db']->query($sql);
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$value['title'] = $_SGLOBAL['profield'][$value['fieldid']]['title'];
			if(empty($value['pic'])) $value['pic'] = 'image/nologo.jpg';
			$tagids[] = $value['tagid'];
			$tagnames[$value['tagid']] = $value['tagname'];
			if (2==$value['fieldid'] || 3==$value['fieldid']) {
				//区域联盟
				//还原地区信息
				$region = $_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query("SELECT * FROM ".tname('region')." WHERE id='".$value['region_id']."'"));
				if ('region' == $value['region_field']) {
					$region_id = $value['region_id'];
					$region_name = $region['name'];
				}
				elseif ('city' == $value['region_field']) {
					$city_id =  $value['region_id'];
					$city_name = $region['name'];
				}
				if (!empty($region_id)) {
					$city_name = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT name FROM ".tname('region')." WHERE id='".$region['pid']."'"), 0);
				}
				$value['ext_name'] = $city_name.$region_name;
			}
			if (3==$value['fieldid']) {
				//还原车系信息
				$car = $_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query("SELECT * FROM ".tname('carmodel')." WHERE id='".$value['ext_id']."'"));
				if ('profile' == $value['ext_field']) {
					$car_profile_id = $value['ext_id'];
				}
				elseif ('model' == $value['ext_field']) {
					$car_model_id = $value['ext_id'];
					$car_model_name = $car['name'];
				}
				if (!empty($car_profile_id)) {
					$car_model_name = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT name FROM ".tname('carmodel')." WHERE id='".$car['pid']."'"), 0);
				}
				$value['ext_name'] .= ' '.$car_model_name;
			}
			elseif (4==$value['fieldid']) {
				//驾校联盟
				$value['ext_name'] = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT name FROM ".tname('school')." WHERE id='".$value['ext_id']."'"), 0);
			}
			$list[] = $value;
		}
		
		$multi = multi($count, $perpage, $page, $theurl);
	}
	
	$threadlist = array();
	if($tagids) {
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('thread')." WHERE tagid IN (".simplode($tagids).") ORDER BY dateline DESC LIMIT 0,10");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['uid'], $value['username']);
			realname_set($value['lastauthorid'], $value['lastauthor']);
			$value['tagname'] = getstr($tagnames[$value['tagid']], 20);
			$threadlist[] = $value;
		}
	}

	$_TPL['css'] = 'thread';
	include_once template("space_mtag");
}

?>