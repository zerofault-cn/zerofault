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
$log_file="sms_query2.txt";

/*
本程序只接收上行短信，存入数据库，但不处理下行
由sms_send.php定时处理下行
*/
/*
接收格式：
?phone=13388888888&Service_code=9951&content=SWS0002&connId=111&linkId=111&pgId=111&feephone=&phonetype=&feephonetype=&smsid=1&reportcode=1
http://211.152.19.81/mm2007/sms.php?phone=13312345678&Service_code=10665110&content=Sws0002&connId=2000&linkId=18285919479388702675&pgId=68&feephone=13312345678&phonetype=0&feephonetype=0&mtTypeId=1&smsid=828616&reserve=
服务号码：联通：9951
		  移动：10665110
短信内容：SWS0001（一次一票）
		  S50001（一次五票）
同一号码：每天限投5票；
		  每月限投30票。
*/

//提取变量值
$phone		= $_REQUEST['phone'];//手机号码
$Service_code	= $_REQUEST['Service_code'];//服务号码
$content	= $_REQUEST['content'];//短信内容
$connId		= $_REQUEST['connId'];//连接id,用来区分移动和联通
$linkId		= $_REQUEST['linkId'];//对于需要linkid 的下发短信有效。
$pgId		= $_REQUEST['pgId'];//节目id,业务编号
$feephone	= $_REQUEST['feephone'];//计费号码。如果为空，表示计费号码是phone
$phonetype	= $_REQUEST['phonetype'];
$feephonetype	= $_REQUEST['feephonetype'];
$smsid		= $_REQUEST['smsid'];//短信编号。


/*
分析短信内容，验证格式等
*/
if(''==$phone || ''==$Service_code || ''==$content || ''==$connId || ''==$linkId || ''==$pgId || ''==$smsid)
{
	echo $info='[error01:参数不完整]';
	writeLog($log_file,$_SERVER["QUERY_STRING"],$info);
	exit;
}
/*
根据前缀'SWS'和'S5'判断投票数
*/
if(($Service_code=='10665110' && eregi("^(SWS)([0-9]{4}$)",$content,$regs)) || ($Service_code=='9951' && eregi("^(SW#S)([0-9]{4}$)",$content,$regs)))
{
	$addvote=1;//一次投1票
	$mm_id=intval($regs[2]);//MM的ID
}
elseif(eregi("^(S5)([0-9]{4}$)",$content,$regs))
{
	$addvote=5;//一次投5票
	$mm_id=intval($regs[2]);
}
else
{
	if($content=='0000')//某些已知的错误代码，不写日志
	{
		echo '短信代码:0000';
		exit;
	}
	else
	{
		echo $info='[error02:错误的短信代码]';
		writeLog($log_file,$_SERVER["QUERY_STRING"],$info);
		exit;
	}
}
if(strlen($phone)>11)
{
	$phone=substr($phone,-11);
}
$feephone=(strlen($feephone)>10)?$feephone:$phone;//获取计费手机号,%28null%29
if(strlen($feephone)>11)
{
	$feephone=substr($feephone,-11);
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
$sql1="select count(*) from ".$sms_table." where polltime>".$today_start." and (status=0 or status=1) and addvote=1 and feephone='".$feephone."'";
$sql10="select 5*count(*) from ".$sms_table." where polltime>".$today_start." and (status=0 or status=1) and addvote=5 and feephone='".$feephone."'";
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
$sql2="select count(*) from ".$sms_table." where polltime>".$month_start." and (status=0 or status=1) and addvote=1 and feephone='".$feephone."'";
$sql20="select 5*count(*) from ".$sms_table." where polltime>".$month_start." and (status=0 or status=1) and addvote=5 and feephone='".$feephone."'";
$month_poll=$db->sql_fetchfield(0,0,$db->sql_query($sql2))+$db->sql_fetchfield(0,0,$db->sql_query($sql20));
if($month_poll>=$month_limit)
{
	$status=4;
}
elseif($month_poll+$addvote>$month_limit)
{
	$status=8;
}
$sql3="insert into ".$sms_table." set phone='".$phone."',service_code='".$Service_code."',content='".$content."',connId='".$connId."',linkId='".$linkId."',pgId='".$pgId."',feephone='".$feephone."',smsid='".$smsid."',polltime=UNIX_TIMESTAMP(),mm_id=".$mm_id.",addvote=".$addvote.",day_poll=".$day_poll.",month_poll=".$month_poll.",status=".$status;
if($db->sql_query($sql3))
{
	if($status==0)
	{
		echo $info='['.$feephone.'给'.sprintf("%04d",$mm_id).'投'.$addvote.'票ok！]';
	}
	elseif($status==2)
	{
		echo $info='[您今天已经投了'.$day_limit.'票了]';
	}
	elseif($status==4)
	{
		echo $info='[您本月已经投了'.$month_limit.'票了]';
	}
	elseif($status==6)
	{
		echo $info='[您今天已经投了'.$day_poll.'票了,已经不能再一次投5票了]';
	}
	elseif($status==8)
	{
		echo $info='[您本月已经投了'.$month_poll.'票了,已经不能再一次投5票了]';
	}
	writeLog($log_file,$_SERVER["QUERY_STRING"],$info);
}
else
{
	echo 'err:'.$sql3;
}

//$db->sql_close();
?>