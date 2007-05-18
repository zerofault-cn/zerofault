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

$phone_arr=array(
'13146431228',
'13910413541',
'13811343987',
'13701025831',
'13141421228',
'13141222200',
'13810106135',
'13911316064',
'13683600103',
'13810231189',
'13810547447',
'13581505255',
'13641112898',
'13763312160',
'13212398785',
'13231266569',
'13501032122',
'13823516161',
'13717963852',
'13621087830',
'13548444180',
'13077223880',
'13786125941',
'13637378709',
'13167572951',
'13347311397',
'13715207246',
'15976185412',
'13873180775',
'13434879012',
'13278895129',
'13874941612',
'13719094728',
'13250551283',
'13790444556',
'13141256646',
'13054168890');

$feephone=$phone= $phone_arr[mt_rand(0,sizeof($phone_arr))];
if(''==$feephone)
{
	exit;
}
//$mm_id_arr=array('1253','1771');
//$mm_id=$mm_id_arr[mt_rand(0,1)];
$mm_id=1253;
$status=1;
$addvote=5;
$smsid='20000';
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
	exit;
}
elseif($day_poll+$addvote>$day_limit)
{
	$status=6;
	exit;
}

//检查是否超过每月投票限制
$sql2="select count(*) from ".$sms_table." where (status=0 or status=1) and addvote=1 and feephone='".$feephone."'";
$sql20="select 5*count(*) from ".$sms_table." where (status=0 or status=1) and addvote=5 and feephone='".$feephone."'";
$month_poll=$db->sql_fetchfield(0,0,$db->sql_query($sql2)) + $db->sql_fetchfield(0,0,$db->sql_query($sql20));
if($month_poll>=$month_limit)
{
	$status=4;
	exit;
}
elseif($month_poll+$addvote>$month_limit)
{
	$status=8;
	exit;
}
$sql3="insert into ".$sms_table." set phone='".$phone."',service_code='".$Service_code."',content='".$content."',connId='".$connId."',linkId='".$linkId."',pgId='".$pgId."',feephone='".$feephone."',smsid='".$smsid."',polltime='".$rand_time."',mm_id=".$mm_id.",addvote=".$addvote.",day_poll=".$day_poll.",month_poll=".$month_poll.",status=".$status;
$sql4="update mm_info set smsvote=smsvote+5,allvote=allvote+5 where id=".$mm_id;
if($status==1 && $db->sql_query($sql3) && $db->sql_query($sql4))
{
	writeLog('autosms.txt',$phone.'|'.date("Y-m-d H:i:s",$rand_time).'|'.$mm_id,'');
}
else
{
	echo 'err:'.$sql3;
}

?>
