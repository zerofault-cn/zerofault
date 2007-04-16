<?php
define('IN_MATCH', true);
header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$root_path = "./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");
include_once($root_path."dbtable.php");//设置投票时间段，根据不同时间段，将数据保存到不同的表
$multi=30;//每短信投票相当于30点网络投票

//修正用户的票数

$sql1="select * from mm_info where pass=1";
$result=$db->sql_query($sql1);
//while($row=$db->sql_fetchrow($result))
{
	$id=$row['id'];
	$id=$_REQUEST['id'];
	$sql2="select count(id) from ".$sms_table." where (status=0 or status=1) and addvote=1 and mm_id=".$id;//一条一票的
	$sql3="select count(id) from ".$sms_table." where (status=0 or status=1) and addvote=5 and mm_id=".$id;//一条五票的
	$sql4="select count(id) from ".$ip_table." where del_flag!=1 and mm_id=".$id;//网络投票
	$sms_vote1=$db->sql_fetchfield(0,0,$db->sql_query($sql2));
	$sms_vote5=$db->sql_fetchfield(0,0,$db->sql_query($sql3));
	$ip_vote=$db->sql_fetchfield(0,0,$db->sql_query($sql4));
	$sql5="update mm_info set netvote=".intval($ip_vote).",smsvote=(hbun_vote+hbte_vote+hbivr_vote+".(intval($sms_vote1)+5*intval($sms_vote5))."),allvote=(".$multi."*smsvote+netvote) where id=".$id;
	if($db->sql_query($sql5))
	{
		echo 'update '.$id.' ok!<br>';
		echo "\r\n";
	}
	else
	{
		echo 'error:'.$sql5;
		echo "<br>\r\n";
	}
}

?>