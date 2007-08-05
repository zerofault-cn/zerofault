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
include_once($root_path."dbtable2.php");

$day_limit=30;//每天限投5票
$month_limit=30;//每月限投30票

/*此程序负责发送下行回复语，并修改数据库
发送格式：
http://211.99.210.121:8092/CPInterface/SMSHttpS.aspx?
AREA_ID=920108100&SERVICE_CODE=BKDD&SP_NO=10669290&PHONE_NO=13810289822&MSGCONTENT=helloword&MSGID=123456
http://211.99.210.121:8092/CPInterface/smsmtlwd.aspx?
ISP=9511LT&AREA_ID=9500108000&SERVICE_CODE=UNION1&SP_NO=9511907&PHONE_NO=13810120259&MSGCONTENT=0&MSGID=123456
ISP=9511LT 联通,9511DX 电信 9511WT 网通
*/
$sql1="select * from ".$sms_table." where status=0 order by id limit 30";//只处理状态值为0的
$result1=$db->sql_query($sql1);
while($row=$db->sql_fetchrow($result1))
{
	$id				= $row['id'];
	$isp			= $row['isp'];
	$area_id		= $row['area_id'];
	$service_code	= $row['service_code'];
	$sp_no			= $row['sp_no'];
	$phone_no		= $row['phone_no'];
	$msgid			= $row['msgid'];

	$user_id		= $row['user_id'];
	$addvote		= $row['addvote'];//本次投的票数
	$day_poll		= $row['day_poll'];//今天已投票数
	$month_poll		= $row['month_poll'];//本月已投票数
	$status			= $row['status'];
	//设定回复语
	$reply='投票成功，编号'.sprintf("%05d",$user_id).'选手目前已有'.(getField($user_id,'smsvote')+$addvote).'票。客服：010-51818877';
	//将回复语编码
	$reply=urlencode(mb_convert_encoding($reply,'gbk','gb2312'));
	$senderServer=("10669290645"==$sp_no)?'http://211.99.210.121:8092/CPInterface/SMSHttpS.aspx':'http://211.99.210.121:8092/CPInterface/smsmtlwd.aspx';
	$senderUrl=$senderServer.'?ISP='.$isp.'&AREA_ID='.$area_id.'&SERVICE_CODE='.$service_code.'&SP_NO='.$sp_no.'&PHONE_NO='.$phone_no.'&MSGCONTENT='.$reply.'&MSGID='.$msgid;
//	echo $senderUrl;
//	exit;
	$return_str=@file_get_contents($senderUrl);
	if(substr($return_str,0,2)=='OK')
	{
		$sql2="update ".$sms_table." set status=(status+1),dealtime=UNIX_TIMESTAMP() where id=".$id;
		$sql3="update user_info set smsvote=(smsvote+".$addvote.") where id=".$user_id;
		if($db->sql_query($sql2) && $db->sql_query($sql3))
		{
			echo 'pollok:'.$id;
			echo "<br>\r\n";
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
		echo $id.':未取得正确的返回结果';
		echo "<br>\r\n";
		echo $return_str;
		echo "<br>\r\n";
		continue;
	}
}
//$db->sql_close();
?>
