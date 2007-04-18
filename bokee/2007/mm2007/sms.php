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
include_once($root_path."dbtable.php");//���ݲ�ͬ��ͶƱʱ���ѡȡ��ͬ�����ݱ�

$day_limit=30;//ÿ����Ͷ5Ʊ
$month_limit=30;//ÿ����Ͷ30Ʊ
$log_file="sms_query2.txt";

/*
������ֻ�������ж��ţ��������ݿ⣬������������
��sms_send.php��ʱ��������
*/
/*
���ո�ʽ��
?phone=13388888888&Service_code=9951&content=SWS0002&connId=111&linkId=111&pgId=111&feephone=&phonetype=&feephonetype=&smsid=1&reportcode=1
http://211.152.19.81/mm2007/sms.php?phone=13312345678&Service_code=10665110&content=Sws0002&connId=2000&linkId=18285919479388702675&pgId=68&feephone=13312345678&phonetype=0&feephonetype=0&mtTypeId=1&smsid=828616&reserve=
������룺��ͨ��9951
		  �ƶ���10665110
�������ݣ�SWS0001��һ��һƱ��
		  S50001��һ����Ʊ��
ͬһ���룺ÿ����Ͷ5Ʊ��
		  ÿ����Ͷ30Ʊ��
*/

//��ȡ����ֵ
$phone		= $_REQUEST['phone'];//�ֻ�����
$Service_code	= $_REQUEST['Service_code'];//�������
$content	= $_REQUEST['content'];//��������
$connId		= $_REQUEST['connId'];//����id,���������ƶ�����ͨ
$linkId		= $_REQUEST['linkId'];//������Ҫlinkid ���·�������Ч��
$pgId		= $_REQUEST['pgId'];//��Ŀid,ҵ����
$feephone	= $_REQUEST['feephone'];//�ƷѺ��롣���Ϊ�գ���ʾ�ƷѺ�����phone
$phonetype	= $_REQUEST['phonetype'];
$feephonetype	= $_REQUEST['feephonetype'];
$smsid		= $_REQUEST['smsid'];//���ű�š�


/*
�����������ݣ���֤��ʽ��
*/
if(''==$phone || ''==$Service_code || ''==$content || ''==$connId || ''==$linkId || ''==$pgId || ''==$smsid)
{
	echo $info='[error01:����������]';
	writeLog($log_file,$_SERVER["QUERY_STRING"],$info);
	exit;
}
/*
����ǰ׺'SWS'��'S5'�ж�ͶƱ��
*/
if(($Service_code=='10665110' && eregi("^(SWS)([0-9]{4}$)",$content,$regs)) || ($Service_code=='9951' && eregi("^(SW#S)([0-9]{4}$)",$content,$regs)))
{
	$addvote=1;//һ��Ͷ1Ʊ
	$mm_id=intval($regs[2]);//MM��ID
}
elseif(eregi("^(S5)([0-9]{4}$)",$content,$regs))
{
	$addvote=5;//һ��Ͷ5Ʊ
	$mm_id=intval($regs[2]);
}
else
{
	if($content=='0000')//ĳЩ��֪�Ĵ�����룬��д��־
	{
		echo '���Ŵ���:0000';
		exit;
	}
	else
	{
		echo $info='[error02:����Ķ��Ŵ���]';
		writeLog($log_file,$_SERVER["QUERY_STRING"],$info);
		exit;
	}
}
if(strlen($phone)>11)
{
	$phone=substr($phone,-11);
}
$feephone=(strlen($feephone)>10)?$feephone:$phone;//��ȡ�Ʒ��ֻ���,%28null%29
if(strlen($feephone)>11)
{
	$feephone=substr($feephone,-11);
}
/*
����ÿ�պ�ÿ��ͶƱ��
*/
$today_start=mktime(0,0,0,date("m"),date("d"),date("Y"));//���쿪ʼʱ�����
$month_start=mktime(0,0,0,date("m"),1,date("Y"));//���¿�ʼʱ�����

/*���ö���״̬status
0����ʱֵ,ͶƱ�ɹ���δ��������
1��ͶƱ�ɹ����ѷ�������
2������ÿ��Ʊ�����ƣ�δ��������
3������ÿ��Ʊ�����ƣ��ѷ�������
4������ÿ��Ʊ�����ƣ�δ��������
5������ÿ��Ʊ�����ƣ��ѷ�������
6����������ÿ��Ʊ�����ƣ��Ѿ�����һ��Ͷ5Ʊ��ֻ��һ��Ͷ1Ʊ��δ��������
7����������ÿ��Ʊ�����ƣ��Ѿ�����һ��Ͷ5Ʊ��ֻ��һ��Ͷ1Ʊ���ѷ�������
8����������ÿ��Ʊ�����ƣ��Ѿ�����һ��Ͷ5Ʊ��ֻ��һ��Ͷ1Ʊ��δ��������
9����������ÿ��Ʊ�����ƣ��Ѿ�����һ��Ͷ5Ʊ��ֻ��һ��Ͷ1Ʊ���ѷ�������
*/
$status=0;

//����Ƿ񳬹�ÿ��ͶƱ����
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
//����Ƿ񳬹�ÿ��ͶƱ����
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
		echo $info='['.$feephone.'��'.sprintf("%04d",$mm_id).'Ͷ'.$addvote.'Ʊok��]';
	}
	elseif($status==2)
	{
		echo $info='[�������Ѿ�Ͷ��'.$day_limit.'Ʊ��]';
	}
	elseif($status==4)
	{
		echo $info='[�������Ѿ�Ͷ��'.$month_limit.'Ʊ��]';
	}
	elseif($status==6)
	{
		echo $info='[�������Ѿ�Ͷ��'.$day_poll.'Ʊ��,�Ѿ�������һ��Ͷ5Ʊ��]';
	}
	elseif($status==8)
	{
		echo $info='[�������Ѿ�Ͷ��'.$month_poll.'Ʊ��,�Ѿ�������һ��Ͷ5Ʊ��]';
	}
	writeLog($log_file,$_SERVER["QUERY_STRING"],$info);
}
else
{
	echo 'err:'.$sql3;
}

//$db->sql_close();
?>