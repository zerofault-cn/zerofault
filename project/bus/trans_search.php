<pre>
<?php

define('IN_MATCH', true);
$root_path="./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");


$key=array('教工路口','浙二医院');

echo 'end:'.$e_sid=getSid($key[1]);
echo "\r\nstart:".$s_sid=getSid($key[0]);
echo "\r\n";

$result=findNext($s_sid);
print_r($result);
getResult($result);
function getResult($result) {
	foreach($result as $lid=>$sid)
	{
		echo getLname($lid).":";
		if(is_array($sid) && sizeof($sid)>0)
		{
			foreach($sid as $lid2=>$sid2)
			{
				echo getSname($lid2).":";
				getResult($sid2);
			}
		}
		else
		{
			echo getSname($sid)."\r\n";
		}
	}
}
function findNext($s_sid) {
	global $db,$e_sid;
	//取得该站点在它所在线路上的后续站点
	$nextSidArr=getNextSid($s_sid);
//	print_r($nextSidArr);

//	$result=array();
	$c=0;//查询深度
	foreach($nextSidArr as $lid=>$sidArr)//遍历每天线路,在该线路上找终点
	{
//		$result[$lid]=array();
		foreach($sidArr as $sid)
		{
			if($sid==$e_sid)
			{
				$result[$lid]=$sid;
			//	return $result;
			}
			else
			{
			//	findNext($sid);
			}
		}
		if(sizeof($result[$lid])>0)
		{
			return $result;
		}
		else
		{
			$c=1;
		}
	}
	if($c==1)
	{
		foreach($nextSidArr as $lid=>$sidArr)
		{
//			$result[$lid]=array();
			foreach($sidArr as $sid)
			{
				$nextSidArr2=getNextSid($sid);
//				$result[$lid][$sid]=array();
				foreach($nextSidArr2 as $lid2=>$sidArr2)
				{
//					$result[$lid][$sid][$lid2]=array();
					foreach($sidArr2 as $sid2)
					{
						if($sid2==$e_sid)
						{
							$result[$lid][$sid][$lid2]=$sid2;
						}
					}
					if(sizeof($result[$lid][$sid][$lid2])>0)
					{
					//	return $result;
					break;
					}
					else
					{
						$c=2;
					}
				}
			}
		}
		return $result;
	}
}

function getSid($name) {
	global $db,$site_table;
	$sql1="select id from ".$site_table." where binary name='".$name."'";
	$result1=$db->sql_query($sql1);
	if($db->sql_numrows($result1)>0)
	{
		return $db->sql_fetchfield(0,0,$result1);
	}
	else
	{
		return 0;
	}
}
function getSname($sid) {
	global $db,$site_table;
	$sql1="select name from ".$site_table." where id=".$sid;
	$result1=$db->sql_query($sql1);
	if($db->sql_numrows($result1)>0)
	{
		return $db->sql_fetchfield(0,0,$result1);
	}
	else
	{
		return 0;
	}
}
function getLname($lid) {
	global $db,$line_table;
	$sql1="select name from ".$line_table." where id=".$lid;
	$result1=$db->sql_query($sql1);
	if($db->sql_numrows($result1)>0)
	{
		return $db->sql_fetchfield(0,0,$result1);
	}
	else
	{
		return 0;
	}
}
function getLidBySname($sname) {
	global $db,$route_table,$site_table;
	$sql1="select distinct lid from ".$route_table." r,".$site_table." s where s.name='".$sname."' and r.sid=s.id";
	$result1=$db->sql_query($sql1);
	$lid_arr=array();
	while($row=$db->sql_fetchrow($result1))
	{
		$lid_arr[]=$row['lid'];
	}
	return $lid_arr;
}
function getLidBySid($sid) {
	global $db,$route_table;
	$sql1="select distinct lid from ".$route_table." where sid=".$sid;
	$result1=$db->sql_query($sql1);
	$lid_arr=array();
	while($row=$db->sql_fetchrow($result1))
	{
		$lid_arr[]=$row['lid'];
	}
	return $lid_arr;
}
function getNextSid($sid) {
	global $db,$route_table;
	$lid_arr=getLidBySid($sid);
	foreach($lid_arr as $lid)
	{
		$sql1="select distinct r2.sid as sid from ".$route_table." r1,".$route_table." r2 where r1.lid=".$lid." and r1.sid=".$sid." and r2.direction=r1.direction and r2.i>r1.i and r2.lid=r1.lid";
		$result1=$db->sql_query($sql1);
		$sid_arr[$lid]=array();
		while($row=$db->sql_fetchrow($result1))
		{
			$sid_arr[$lid][]=$row['sid'];
		}
	}
	return $sid_arr;
}
?>
</pre>