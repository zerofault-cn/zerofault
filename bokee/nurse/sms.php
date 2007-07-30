<?php
define('IN_MATCH', true);

header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$root_path="./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");
include_once($root_path."dbtable.php");//���ݲ�ͬ��ͶƱʱ���ѡȡ��ͬ�����ݱ�

$day_limit=30;//ÿ����Ͷ5Ʊ
$month_limit=30;//ÿ����Ͷ30Ʊ
$log_file="sms_query.log";//�������Ϊsms_query2.log,������Ϊsms_query3.log
/*
������ֻ�������ж��ţ��������ݿ⣬������������
��sms_send.php��ʱ��������
*/
/*
���ո�ʽ��
http://nurse.bokee.com/nurse/sms.php?MOTYPE=MoBusi&AREA_ID=920108100&SERVICE_CODE=BKDD&SP_NO=10669290&PHONE_NO=13810289822&MSGCONTENT=helloword&MSGID=123456
���ճɹ�����:"OK_YYYY-MM-DD HH:MI:SS"

������룺��ͨ:9511907
		  ����:95119071
		  ��ͨ:95119072(��ͨ��linkid��msgid����Ϊ��)
		  �ƶ�:10669290645
�������ݣ�HS00001�������00001Ͷ1Ʊ��һ��2Ԫ��
*/

//���ܲ���
$area_id		= $_REQUEST['AREA_ID'];//��ϵͳ����Ĵ���
$service_code	= $_REQUEST['SERVICE_CODE'];//spҵ�����
$sp_no			= $_REQUEST['SP_NO'];//sp�ط���,�����Ӻ��룬��10669290645
$phone_no		= $_REQUEST['PHONE_NO'];//�û��ֻ�����
$msgcontent		= $_REQUEST['MSGCONTENT'];//������Ϣ����,����GBK��encode,��HS00001
$msgid			= $_REQUEST['MSGID'];//������Ϣid,�˴�Ϊlinkid

/*
�����������ݣ���֤��ʽ��
*/
if(''==$area_id || ''==$service_code || ''==$sp_no || ''==$phone_no || ''==$msgcontent || ('95119072'!=$sp_no && ''==$msgid))
{
	echo $info='[error01:����������]';
	writeLog($log_file,$_SERVER["QUERY_STRING"],$info);
	exit;
}

if(eregi("^(HS)([0-9]{1,5}$)",$msgcontent,$regs))
{
	$addvote=1;//һ��Ͷ1Ʊ
	$user_id=intval($regs[2]);//user_id
}
else
{
	echo $info='[error02:����Ķ��Ŵ���]';
	writeLog($log_file,$_SERVER["QUERY_STRING"],$info);
	exit;
}
if(!$user_id>0)
{
	echo $info='[error03:������û����]';
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
	echo $info='������IDΪ'.$user_id.'��ѡ�֣������ܸ���ͶƱ��';
	writeLog($log_file,$_SERVER["QUERY_STRING"],$info);
	exit;
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
//����Ƿ񳬹�ÿ��ͶƱ����
//����ϰ���ͶƱ���
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
		$info='[status0:'.$phone_no.'��'.sprintf("%05d",$user_id).'Ͷ'.$addvote.'Ʊok��]';
		echo 'OK_'.date("Y-m-d H:i:s");
	}
	else
	{
		echo 'Error:'.$sql3;
	}
}
elseif($status==2)
{
	echo $info='[status2:�������Ѿ�Ͷ��'.$day_limit.'Ʊ��]';
}
elseif($status==4)
{
	echo $info='[status4:�������Ѿ�Ͷ��'.$month_limit.'Ʊ��]';
}
elseif($status==6)
{
	echo $info='[status6:�������Ѿ�Ͷ��'.$day_poll.'Ʊ��,�Ѿ�������һ��Ͷ5Ʊ��]';
}
elseif($status==8)
{
	echo $info='[status8:�������Ѿ�Ͷ��'.$month_poll.'Ʊ��,�Ѿ�������һ��Ͷ5Ʊ��]';
}
writeLog($log_file,$_SERVER["QUERY_STRING"],$info);

/*
�����յ��Ķ��Ų������浽�ļ���
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