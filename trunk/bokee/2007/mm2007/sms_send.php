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

$day_limit=30;//每天限投5票
$month_limit=30;//每月限投30票

$sp_server='219.141.223.103';//SP服务器的地址
$authuser='boke';//发送下行短信的用户名和密码
$authpass='boke123';

/*此程序负责发送下行回复语，并修改数据库
发送格式：
http://sms.3tong.net/sms/Sender?username=test&password=test&phone=13386221225&Service_code=8888&content=test&pgid=1&connId=1&mtTypeId=1&linkId=sdfsf&feephone=&reserve=wap.3tong.net
*/
$sql1="select * from ".$sms_table." where status=0 order by id limit 30";//只处理状态值为0的
$result1=$db->sql_query($sql1);
while($row=$db->sql_fetchrow($result1))
{
	$id				= $row['id'];
	$phone			= $row['phone'];//手机号码
	$Service_code	= $row['service_code'];//服务号码
	$content		= $row['content'];//短信内容
	$connId			= $row['connId'];//连接id,用来区分移动和联通
	$linkId			= $row['linkId'];//对于需要linkid 的下发短信有效。
	$pgId			= $row['pgId'];//节目id,业务编号
	$feephone		= $row['feephone'];//计费号码。如果为空，表示计费号码是phone

	$mm_id			= $row['mm_id'];//MM的ID
	$addvote		= $row['addvote'];//本次投的票数
	$day_poll		= $row['day_poll'];//今天已投票数
	$month_poll		= $row['month_poll'];//本月已投票数
	$status			= $row['status'];
	
	$reply='您的投票已成功，'.sprintf("%04d",$mm_id).'号选手目前'.(getField($mm_id,'smsvote')+$addvote).'票。如果您的投票超过'.$day_limit.'票/日、'.$month_limit.'票/月的限制，系统将不再回复。客服：010-51818877';
	if($month_poll>=25)
	{
	//	$reply.='提示：您本月还能投'.($month_limit-$month_poll).'票！';
	}
	else
	{
	//	$reply.='提示：您今天还能投'.($day_limit-$day_poll).'票！';
	}
	$senderUrl='http://'.$sp_server.'/Sender?username='.$authuser.'&password='.$authpass.'&phone='.$phone.'&Service_code='.$Service_code.'&content='.urlencode(mb_convert_encoding($reply,'gbk','gb2312')).'&pgId='.$pgId.'&connId='.$connId.'&mtTypeId=1&linkId='.$linkId.'&feephone='.$feephone.'&reserve=';
//	echo $senderUrl;
//	exit;
	//发出下行短信请求，并取得发送结果（xml）
	$xmldata=@file_get_contents($senderUrl);
	//解析XML,获取responsecode和smsid
	if(strlen($xmldata)>40)
	{
		$result_arr=makeXMLTree($xmldata);
	}
	else
	{
		echo '未取得正确的返回XML';
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
