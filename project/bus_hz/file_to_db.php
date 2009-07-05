<?php
//1/K1,����·,5:00,22:30,С��·����·��,5:50,22:30,A/B/C/D/T,����·-ʮ����-ʡ����¥��-��������-�ܶ���·��-������-ʯ����-������-�ຼ����-�����´�-�������-������·��-������-С��·-С��·����·��,С��·����·��-С��·-������-������·��-�������-�����´�-�ຼ����-������-ʯ����-������-�ܶ���·��-����·,�յ���:2Ԫ ��ͨ��:1Ԫ,


include_once("config.php");

$info=file(PATH_ROOT.'/hangzhou_bus_data.txt');

foreach($info as $row=>$line)
{
	$lines  = explode(',',rtrim($line));
	$numbers= explode("/",$lines[0]);
	$number = str_ireplace("K",'',$numbers[0]);
	$number = str_ireplace("(ҹ����)",'',$number);
	$number = str_ireplace("(����)",'',$number);
	$number = substr($number,0,3)=='B֧'? (2000+intval(str_ireplace("B֧",'',$number))) : $number;
	$number = substr($number,0,1)=='B' ? (1000+intval(str_ireplace("B",'',$number))) : $number;
	$number = substr($number,0,1)=='Y' ? (3000+intval(str_ireplace("Y",'',$number))) : $number;
	$number = substr($number,0,1)=='J' ? (4000+intval(str_ireplace("J",'',$number))) : $number;
	$number = intval($number);
	$fares  = explode(' ',$lines[sizeof($lines)-2]);
	$route1 = explode('-',$lines[8]);
	$route2 = explode('-',$lines[9]);
	
	$sql1="insert into ".LINE_TABLE." set name='".$lines[0]."',number='".$number."',start_sid=".getSiteId($lines[1]).",start_first='".$lines[2]."',start_last='".$lines[3]."',end_sid=".getSiteId($lines[4]).",end_first='".$lines[5]."',end_last='".$lines[6]."',fare_norm='".$fares[1]."',fare_cond='".$fares[0]."',ic_card='".$lines[7]."',service_hour='ÿ��'";
	$line_result=$db->sql_query($sql1);
	echo $lines[0].":".$line_result."\r\n";
	!$line_result && die($sql1);

	$insertid=$db->sql_nextid();
	foreach($route1 as $key=>$val)
	{
		$sql2="insert into ".ROUTE_TABLE." set lid=".$insertid.",sid=".getSiteId($val).",i=".(10*($key+1)).",direction=1";
		$r = $db->sql_query($sql2);
		!$r && die($sql2);
	}
	foreach($route2 as $key=>$val)
	{
		if(in_array($number,array(55,56,59,60,676)) || $lines[1]==$lines[4])//�����յ㲻��ͬһվ��˵�����ǻ���
		{
			break;
		}
		$sql4="insert into ".ROUTE_TABLE." set lid=".$insertid.",sid=".getSiteId($val).",i=".(10*($key+1)).",direction=-1";
		$r = $db->sql_query($sql4);
		!$r && die($sql4);
	}
}

function getSiteId($name) {
	global $db;
	$sql1="select id from ".SITE_TABLE." where name='".$name."'";
	$result1=$db->sql_query($sql1);
	if($db->sql_numrows($result1)>0)
	{
		return $db->sql_fetchfield(0,0,$result1);
	}
	else
	{
		$sql2="insert into ".SITE_TABLE." set name='".$name."'";
		$db->sql_query($sql2);
		return $db->sql_nextid();
	}
}

?>