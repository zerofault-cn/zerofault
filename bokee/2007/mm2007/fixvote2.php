<?php
define('IN_MATCH', true);
header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$root_path = "./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");
include_once($root_path."dbtable.php");//����ͶƱʱ��Σ����ݲ�ͬʱ��Σ������ݱ��浽��ͬ�ı�
$multi=30;//ÿ����ͶƱ�൱��30������ͶƱ

//�����û���Ʊ��

$sql1="select * from mm_info where pass=1";
$result=$db->sql_query($sql1);
//while($row=$db->sql_fetchrow($result))
{
	$id=$row['id'];
	$id=$_REQUEST['id'];
	$sql2="select count(id) from ".$sms_table." where (status=0 or status=1) and addvote=1 and mm_id=".$id;//һ��һƱ��
	$sql3="select count(id) from ".$sms_table." where (status=0 or status=1) and addvote=5 and mm_id=".$id;//һ����Ʊ��
	$sql4="select count(id) from ".$ip_table." where del_flag!=1 and mm_id=".$id;//����ͶƱ
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