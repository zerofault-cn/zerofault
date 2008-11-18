<?php
define('IN_MATCH', true);
$root_path="./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");

$sql="select * from ".$line_table." order by no";
$result=$db->sql_query($sql);
$i=0;
while($row=$db->sql_fetchrow($result))
{
	$lines[$i]['name']=$row['name'];
	$sql1="select sid from ".$route_table." where lid=".$row['id']." and direction=1 order by i";
	$result1=$db->sql_query($sql1);
	$j=0;
	while($row1=$db->sql_fetchrow($result1))
	{
		$lines[$i]['path1'][$j]['site_name']=getSiteName($row1['sid']);
		$lines[$i]['path1'][$j]['trans_line']=getTransLine($row['id'],$row1['sid']);
		$j++;
	}
	$sql2="select sid from ".$route_table." where lid=".$row['id']." and direction=-1 order by i";
	$result2=$db->sql_query($sql2);
	$j=0;
	while($row2=$db->sql_fetchrow($result2))
	{
		$lines[$i]['path2'][$j]['site_name']=getSiteName($row2['sid']);
		$lines[$i]['path2'][$j]['trans_line']=getTransLine($row['id'],$row2['sid']);
		$j++;
	}
	$i++;
}
//$smarty->assign('lines', $lines);

function getSiteName($sid) {
	global $db,$site_table;
	$sql="select name from ".$site_table." where id=".$sid;
	$result=$db->sql_query($sql);
	return $db->sql_fetchfield(0,0,$result);
}
function getTransLine($lid,$sid) {
	global $db,$route_table,$line_table;
	$sql="select name from ".$line_table." l,".$route_table." r where r.sid=".$sid." and l.id=r.lid and l.id!=".$lid;
	$result=$db->sql_query($sql);
	while($row=$db->sql_fetchrow($result))
	{
		$name[]=$row['name'];
	}
	if(sizeof($name)>0)
	{
		return implode(',',$name);
	}
	else
	{
		return '';
	}
}
echo '<pre>';
print_r($lines);
echo '</pre>';
?>