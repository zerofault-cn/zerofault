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
$add=intval($_REQUEST['add']);//add��ʾÿ�����ӵ�ͶƱ��
$from=$_REQUEST['from'];
$ip=GetIP();
if($ip!='202.103.30.13' && $ip!='218.249.35.66')
{
	echo "δ��֤�ͻ���";
	exit;
}
if($id>0)
{
	$sql="select * from mm_info where id=".$id;
	$result=$db->sql_query($sql);
	if($db->sql_numrows($result)==0)
	{
		echo '��ID������';
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
		echo 'ok';//getField($id,'allvote').'|'.getOrder($id);//ȡ��ѡ�ֵ���Ʊ����Ŀǰ����
	}
	else
	{
		echo '������:'.$sql;
	}
}
elseif($id>0 && ''==$add && ''==$from)
{
	echo intval(getField($id,'smsvote')).'|'.getOrder($id);//ȡ��ѡ�ֵĶ���Ʊ����Ŀǰ����
}
else
{
	echo 'url��������';
}
//$db->sql_close();
?>