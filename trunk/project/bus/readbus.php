<?php
//1/K1,凤起路,5:00,22:30,小河路登云路口,5:50,22:30,A/B/C/D/T,凤起路-十四中-省府大楼东-武林门南-密渡桥路口-沈塘桥-石灰桥-打索桥-余杭塘上-董家新村-大关桥西-湖墅北路口-长征桥-小河路-小河路登云路口,小河路登云路口-小河路-长征桥-湖墅北路口-大关桥西-董家新村-余杭塘上-打索桥-石灰桥-沈塘桥-密渡桥路口-凤起路,空调车:2元 普通车:1元,


define('IN_MATCH', true);
$root_path="./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");

echo '<pre>';
$info=file('hangzhou_bus_data.txt');


foreach($info as $row=>$lines)
{
	$line=explode(',',rtrim($lines));
	$number_arr=explode("/",$line[0]);
	$number=str_ireplace("K",'',$number_arr[0]);
	$number=str_ireplace("(夜间线)",'',$number);
	$number=str_ireplace("(区间)",'',$number);
	$number=str_ireplace("B支",'200',$number);
	$number=str_ireplace("B",'100',$number);
	$number=str_ireplace("Y",'300',$number);
	$number=intval($number);
	$fare=explode(' ',$line[sizeof($line)-2]);
	$route1=explode('-',$line[8]);
	$route2=explode('-',$line[9]);
	
	echo	"\r\n".$sql1="insert into bus_hz_line set name='".$line[0]."',number='".$number."',term1=".getSiteId($line[1]).",start_time1='".$line[2]."',end_time1='".$line[3]."',term2=".getSiteId($line[4]).",start_time2='".$line[5]."',end_time2='".$line[6]."',fare_norm='".$fare[1]."',fare_cond='".$fare[0]."',ic_card='".$line[7]."',service_hour='每天'";
	$line_result=$db->sql_query($sql1);
	echo "\r\nresult:".$line_result;
	if(!$line_result)
	{
		exit;
	}
	$insertid=$db->sql_nextid();
	foreach($route1 as $key=>$val)
	{
		echo		"\r\n".$sql2="insert into bus_hz_route set lid=".$insertid.",sid=".getSiteId($val).",i=".(10*($key+1)).",direction=1";
		echo "\r\nresult:".$db->sql_query($sql2);
	}
	if(!in_array($number,array(55,56,59,60,676)) && $line[1]!=$line[4])//起点和终点不是同一站，说明不是环线
	{
		foreach($route2 as $key=>$val)
		{
			echo		"\r\n".$sql4="insert into bus_hz_route set lid=".$insertid.",sid=".getSiteId($val).",i=".(10*($key+1)).",direction=-1";
			echo "\r\nresult:".$db->sql_query($sql4);
		}
	}
}

function getSiteId($name) {
	global $db;
	$sql1="select id from bus_hz_site where name='".$name."'";
	$result1=$db->sql_query($sql1);
	if($db->sql_numrows($result1)>0)
	{
		return $db->sql_fetchfield(0,0,$result1);
	}
	else
	{
		$sql2="insert into bus_hz_site set name='".$name."'";
		$db->sql_query($sql2);
		return $db->sql_nextid();
	}
}
echo '</pre>';
?>