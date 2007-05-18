<?php
define('IN_MATCH', true);

header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$root_path="./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");
include_once($root_path."functions.php");
include_once($root_path."dbtable.php");//根据不同的投票时间段选取不同的数据表

$day_limit=30;//每天限投5票
$month_limit=30;//每月限投30票

$mm_id_arr=array(
'1087'
);
for($i=0;$i<sizeof($mm_id_arr);$i++)
{
	$mm_id=$mm_id_arr[$i];
	if($mm_id==0)
	{
		continue;
	}
	$feephone=$phone='158'.mt_rand(10000001,99999999);

	$status=1;
	$addvote=5;
	$smsid='30000';
	$rand_time=time()+mt_rand(0,3600);

	/*
	限制每日和每月投票数
	*/
	$today_start=mktime(0,0,0,date("m",$rand_time),date("d",$rand_time),date("Y",$rand_time));//今天开始时间戳记
	$month_start=mktime(0,0,0,date("m",$rand_time),1,date("Y",$rand_time));//本月开始时间戳记
	//检查是否超过每日投票限制
	$sql1="select count(*) from ".$sms_table." where polltime>".$today_start." and polltime<".($today_start+86400)." and status=1 and addvote=1 and feephone='".$feephone."'";
	$sql10="select 5*count(*) from ".$sms_table." where polltime>".$today_start." polltime<".($today_start+86400)." and status=1 and addvote=5 and feephone='".$feephone."'";
	$day_poll=$db->sql_fetchfield(0,0,$db->sql_query($sql1)) + $db->sql_fetchfield(0,0,$db->sql_query($sql10));
	if($day_poll>=$day_limit)
	{
		$status=2;
		continue;
	}
	elseif($day_poll+$addvote>$day_limit)
	{
		$status=6;
		continue;
	}

	//检查是否超过每月投票限制
	$sql2="select count(*) from ".$sms_table." where (status=0 or status=1) and addvote=1 and feephone='".$feephone."'";
	$sql20="select 5*count(*) from ".$sms_table." where (status=0 or status=1) and addvote=5 and feephone='".$feephone."'";
	$month_poll=$db->sql_fetchfield(0,0,$db->sql_query($sql2)) + $db->sql_fetchfield(0,0,$db->sql_query($sql20));
	if($month_poll>=$month_limit)
	{
		$status=4;
		continue;
	}
	elseif($month_poll+$addvote>$month_limit)
	{
		$status=8;
		continue;
	}
	$sql3="insert into ".$sms_table." set phone='".$phone."',service_code='".$Service_code."',content='".$content."',connId='".$connId."',linkId='".$linkId."',pgId='".$pgId."',feephone='".$feephone."',smsid='".$smsid."',polltime='".$rand_time."',mm_id=".$mm_id.",addvote=".$addvote.",day_poll=".$day_poll.",month_poll=".$month_poll.",status=".$status;
	$sql4="update mm_info set smsvote=smsvote+5,allvote=allvote+5 where id=".$mm_id;
	if($status==1 && $db->sql_query($sql3) && $db->sql_query($sql4))
	{
		writeLog('autosms_5.txt',$phone.'|'.date("Y-m-d H:i:s",$rand_time).'|'.$mm_id,'');
	}
	else
	{
		echo 'err:'.$sql3;
	}
}
?>
