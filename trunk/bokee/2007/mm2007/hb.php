<?php
define('IN_MATCH', true);

header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$root_path="./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
$id=intval($_REQUEST['id']);
$add=intval($_REQUEST['add']);//add表示每次增加的投票数
$from=$_REQUEST['from'];
$ip=GetIP();
if($ip!='202.103.30.13' && $ip!='218.249.35.66')
{
	echo "未认证客户端";
	exit;
}
if($id>0)
{
	$sql="select * from mm_info where id=".$id;
	$result=$db->sql_query($sql);
	if($db->sql_numrows($result)==0)
	{
		echo '此ID不存在';
		exit;
	}
}
if($id>0 && $add>0 && ''!=$from)
{
	if($add>0)
	{
		$sql="update mm_info set ".$from."_vote=(".$from."_vote+".$add."),smsvote=(smsvote+".$add."),allvote=(allvote+".$add.") where id=".$id;
	}
	if(''!=$sql && $db->sql_query($sql))
	{
		echo 'ok';//getField($id,'allvote').'|'.getOrder($id);//取得选手的总票数和目前排名
	}
	else
	{
		echo '出错了:'.$sql;
	}
}
elseif($id>0 && ''==$add && ''==$from)
{
	echo intval(getField($id,'smsvote')).'|'.getOrder($id);//取得选手的短信票数和目前排名
}
else
{
	echo 'url参数不对';
}
//$db->sql_close();
?>