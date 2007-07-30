<?php
define('IN_MATCH', true);

header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$root_path="./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");
include_once($root_path."dbtable.php");//根据不同的投票时间段选取不同的数据表

$day_limit=30;//每天限投5票
$month_limit=30;//每月限投30票
$log_file="sms_query.log";//复赛需改为sms_query2.log,决赛改为sms_query3.log
/*
本程序只接收上行短信，存入数据库，但不处理下行
由sms_send.php定时处理下行
*/
/*
接收格式：
http://nurse.bokee.com/nurse/sms.php?MOTYPE=MoBusi&AREA_ID=920108100&SERVICE_CODE=BKDD&SP_NO=10669290&PHONE_NO=13810289822&MSGCONTENT=helloword&MSGID=123456
接收成功返回:"OK_YYYY-MM-DD HH:MI:SS"

服务号码：联通:9511907
		  电信:95119071
		  网通:95119072(网通的linkid即msgid可以为空)
		  移动:10669290645
短信内容：HS00001（给编号00001投1票，一次2元）
*/

//接受参数
$area_id		= $_REQUEST['AREA_ID'];//由系统分配的代码
$service_code	= $_REQUEST['SERVICE_CODE'];//sp业务代码
$sp_no			= $_REQUEST['SP_NO'];//sp特服号,包含子号码，如10669290645
$phone_no		= $_REQUEST['PHONE_NO'];//用户手机号码
$msgcontent		= $_REQUEST['MSGCONTENT'];//上行消息内容,经过GBK的encode,如HS00001
$msgid			= $_REQUEST['MSGID'];//上行消息id,此处为linkid

/*
分析短信内容，验证格式等
*/
if(''==$area_id || ''==$service_code || ''==$sp_no || ''==$phone_no || ''==$msgcontent || ('95119072'!=$sp_no && ''==$msgid))
{
	echo $info='[error01:参数不完整]';
	writeLog($log_file,$_SERVER["QUERY_STRING"],$info);
	exit;
}

if(eregi("^(HS)([0-9]{1,5}$)",$msgcontent,$regs))
{
	$addvote=1;//一次投1票
	$user_id=intval($regs[2]);//user_id
}
else
{
	echo $info='[error02:错误的短信代码]';
	writeLog($log_file,$_SERVER["QUERY_STRING"],$info);
	exit;
}
if(!$user_id>0)
{
	echo $info='[error03:错误的用户编号]';
	writeLog($log_file,$_SERVER["QUERY_STRING"],$info);
	exit;
}
if(strlen($phone_no)>11)
{
	$phone_no=substr($phone_no,-11);
}

$sql="select * from user_info where pass>0 and id=".$user_id;
if($db->sql_numrows($db->sql_query($sql))==0)
{
	echo $info='不存在ID为'.$user_id.'的选手，您不能给她投票！';
	writeLog($log_file,$_SERVER["QUERY_STRING"],$info);
	exit;
}

/*
限制每日和每月投票数
*/
$today_start=mktime(0,0,0,date("m"),date("d"),date("Y"));//今天开始时间戳记
$month_start=mktime(0,0,0,date("m"),1,date("Y"));//本月开始时间戳记

/*设置短信状态status
0：初时值,投票成功，未发送下行
1：投票成功，已发送下行
2：超过每日票数限制，未发送下行
3：超过每日票数限制，已发送下行
4：超过每月票数限制，未发送下行
5：超过每月票数限制，已发送下行
6：即将超过每日票数限制，已经不能一次投5票，只能一次投1票，未发送下行
7：即将超过每日票数限制，已经不能一次投5票，只能一次投1票，已发送下行
8：即将超过每月票数限制，已经不能一次投5票，只能一次投1票，未发送下行
9：即将超过每月票数限制，已经不能一次投5票，只能一次投1票，已发送下行
*/
$status=0;

//检查是否超过每日投票限制
$sql1="select count(*) from ".$sms_table." where polltime>".$today_start." and addvote=1 and phone_no='".$phone_no."'";
$sql10="select 5*count(*) from ".$sms_table." where polltime>".$today_start." and addvote=5 and phone_no='".$phone_no."'";
$day_poll=$db->sql_fetchfield(0,0,$db->sql_query($sql1))+$db->sql_fetchfield(0,0,$db->sql_query($sql10));
if($day_poll>=$day_limit)
{
	$status=2;
}
elseif($day_poll+$addvote>$day_limit)
{
	$status=6;
}
//检查是否超过每月投票限制
//检查上半月投票情况
/*
$sql3="select count(*) from poll_sms2 where polltime>".$month_start." and (status=0 or status=1) and addvote=1 and feephone='".$feephone."'";
$sql30="select 5*count(*) from poll_sms2 where polltime>".$month_start." and (status=0 or status=1) and addvote=5 and feephone='".$feephone."'";
$half_month_poll=$db->sql_fetchfield(0,0,$db->sql_query($sql3))+$db->sql_fetchfield(0,0,$db->sql_query($sql30));
*/
$sql2="select count(*) from ".$sms_table." where polltime>".$month_start." and addvote=1 and phone_no='".$phone_no."'";
$sql20="select 5*count(*) from ".$sms_table." where polltime>".$month_start." and addvote=5 and phone_no='".$phone_no."'";
$month_poll=$db->sql_fetchfield(0,0,$db->sql_query($sql2))+$db->sql_fetchfield(0,0,$db->sql_query($sql20));
//$month_poll+=$half_month_poll;
if($month_poll>=$month_limit)
{
	$status=4;
}
elseif($month_poll+$addvote>$month_limit)
{
	$status=8;
}

if($status==0)
{
	$sql3="insert into ".$sms_table." set area_id='".$area_id."',service_code='".$service_code."',sp_no='".$sp_no."',phone_no='".$phone_no."',msgcontent='".$msgcontent."',msgid='".$msgid."',polltime=UNIX_TIMESTAMP(),user_id=".$user_id.",addvote=".$addvote.",day_poll=".$day_poll.",month_poll=".$month_poll.",status=".$status;
	if($db->sql_query($sql3))
	{
		$info='[status0:'.$phone_no.'给'.sprintf("%05d",$user_id).'投'.$addvote.'票ok！]';
		echo 'OK_'.date("Y-m-d H:i:s");
	}
	else
	{
		echo 'Error:'.$sql3;
	}
}
elseif($status==2)
{
	echo $info='[status2:您今天已经投了'.$day_limit.'票了]';
}
elseif($status==4)
{
	echo $info='[status4:您本月已经投了'.$month_limit.'票了]';
}
elseif($status==6)
{
	echo $info='[status6:您今天已经投了'.$day_poll.'票了,已经不能再一次投5票了]';
}
elseif($status==8)
{
	echo $info='[status8:您本月已经投了'.$month_poll.'票了,已经不能再一次投5票了]';
}
writeLog($log_file,$_SERVER["QUERY_STRING"],$info);

/*
将接收到的短信参数保存到文件中
*/
function writeLog($filename,$str,$info)
{
	$fp=fopen($filename,"r+");
	$time=date("Y-m-d H:i:s");
	fseek($fp,filesize($filename));
	fwrite($fp,$time."|".$str."|".$info."\r\n");
	fclose($fp);
}

//$db->sql_close();
?>