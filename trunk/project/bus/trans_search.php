<pre>
<?php

define('IN_MATCH', true);
$root_path="./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");


$key=array('教工路口','文三新村');

echo 'end:'.$e_sid=getSid($key[1]);
echo "\r\nstart:".$s_sid=getSid($key[0]);
echo "\r\n";

print_r(findNext($s_sid));

function findNext($s_sid) {
	global $db,$e_sid;
	$nextSidArr=getNextSid($s_sid,getLidBySid($s_sid));
//	print_r($nextSidArr);

	$result=array();
	foreach($nextSidArr as $lid=>$sidArr)
	{
		$result[$lid]=array();
		foreach($sidArr as $sid)
		{
			$result[$lid]=$sid;
			if($sid==$e_sid)
			{
				return $result;
			}
			else
			{
				findNext($sid);
			}
		}
		
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
//获取某一站点针对某一线路的后续站点
function getNextSid($sid,$lid_arr) {
	global $db,$route_table;
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