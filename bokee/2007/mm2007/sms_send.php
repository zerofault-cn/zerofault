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
include_once($root_path."dbtable.php");

$day_limit=30;//ÿ����Ͷ5Ʊ
$month_limit=30;//ÿ����Ͷ30Ʊ

$sp_server='219.141.223.103';//SP�������ĵ�ַ
$authuser='boke';//�������ж��ŵ��û���������
$authpass='boke123';

/*�˳����������лظ�����޸����ݿ�
���͸�ʽ��
http://sms.3tong.net/sms/Sender?username=test&password=test&phone=13386221225&Service_code=8888&content=test&pgid=1&connId=1&mtTypeId=1&linkId=sdfsf&feephone=&reserve=wap.3tong.net
*/
$sql1="select * from ".$sms_table." where status=0 order by id limit 30";//ֻ����״ֵ̬Ϊ0��
$result1=$db->sql_query($sql1);
while($row=$db->sql_fetchrow($result1))
{
	$id				= $row['id'];
	$phone			= $row['phone'];//�ֻ�����
	$Service_code	= $row['service_code'];//�������
	$content		= $row['content'];//��������
	$connId			= $row['connId'];//����id,���������ƶ�����ͨ
	$linkId			= $row['linkId'];//������Ҫlinkid ���·�������Ч��
	$pgId			= $row['pgId'];//��Ŀid,ҵ����
	$feephone		= $row['feephone'];//�ƷѺ��롣���Ϊ�գ���ʾ�ƷѺ�����phone

	$mm_id			= $row['mm_id'];//MM��ID
	$addvote		= $row['addvote'];//����Ͷ��Ʊ��
	$day_poll		= $row['day_poll'];//������ͶƱ��
	$month_poll		= $row['month_poll'];//������ͶƱ��
	$status			= $row['status'];
	
	$reply='����ͶƱ�ѳɹ���'.sprintf("%04d",$mm_id).'��ѡ��Ŀǰ'.(getField($mm_id,'smsvote')+$addvote).'Ʊ���������ͶƱ����'.$day_limit.'Ʊ/�ա�'.$month_limit.'Ʊ/�µ����ƣ�ϵͳ�����ٻظ����ͷ���010-51818877';
	if($month_poll>=25)
	{
	//	$reply.='��ʾ�������»���Ͷ'.($month_limit-$month_poll).'Ʊ��';
	}
	else
	{
	//	$reply.='��ʾ�������컹��Ͷ'.($day_limit-$day_poll).'Ʊ��';
	}
	$senderUrl='http://'.$sp_server.'/Sender?username='.$authuser.'&password='.$authpass.'&phone='.$phone.'&Service_code='.$Service_code.'&content='.urlencode(mb_convert_encoding($reply,'gbk','gb2312')).'&pgId='.$pgId.'&connId='.$connId.'&mtTypeId=1&linkId='.$linkId.'&feephone='.$feephone.'&reserve=';
//	echo $senderUrl;
//	exit;
	//�������ж������󣬲�ȡ�÷��ͽ����xml��
	$xmldata=@file_get_contents($senderUrl);
	//����XML,��ȡresponsecode��smsid
	if(strlen($xmldata)>40)
	{
		$result_arr=makeXMLTree($xmldata);
	}
	else
	{
		echo 'δȡ����ȷ�ķ���XML';
		echo "<br>\r\n";
		continue;
	}
	$sql2="update mm_info set smsvote=(smsvote+".$addvote."),allvote=(allvote+".$addvote.") where id=".$mm_id;
	$sql3="update ".$sms_table." set status=(status+1),dealtime=UNIX_TIMESTAMP(),re_smsid=".$result_arr['response']['smsid']." where id=".$id;
	if(sizeof($result_arr)>0 && $result_arr['response']['responsecode']==0 && intval($result_arr['response']['smsid'])>0)
	{
		if($db->sql_query($sql3) && $db->sql_query($sql2))
		{
			echo 'pollok:'.$id;
			echo "<br>\r\n";
			echo 'smsid:'.$result_arr['response']['smsid'];
			echo "<br>\r\n";
			echo $senderUrl;
		//	echo "<br>\r\n";
		//	print_r($result_arr);
		}
		else
		{
			echo "ERROR:<br>\r\n";
			echo $sql2;
			echo "<br>\r\n";
			echo $sql3;
			echo "<br>\r\n";
		}
	}
	else
	{
		echo "ERROR:<br>\r\n";
		echo $senderUrl;
		echo "<br>\r\n";
		print_r($result_arr);
	}
}
//$db->sql_close();
?>
