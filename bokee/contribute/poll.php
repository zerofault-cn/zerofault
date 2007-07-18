<?php
define('IN_MATCH', true);

header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
$root_path = "./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");

$id=$_REQUEST['id'];
$author_id=$_REQUEST['author_id'];

$ip_limit=3;
$client_ip=GetIP();
$today_start=mktime(0,0,0,date("m"),date("d"),date("Y"));//今天开始时间戳记
$today_end=$today_start+86400;
$sql="select id,count from ip_count where ip='".$client_ip."' and aid=".$id." and polldate=CURDATE()";
$result=$db->sql_query($sql);
if($db->sql_numrows($result)>0)
{
	$ip_id=$db->sql_fetchfield(0,0,$result);
	$count=$db->sql_fetchfield(1,0,$result);
}
else
{
	$count=0;
}
if($count>=$ip_limit)//每天限制投票
{
	echo '<script>alert("每天只能给一篇文章投'.$ip_limit.'票！");</script>';
	exit();
}
//echo $count;
$sql1="update article set vote=vote+1 where id=".$id;
$sql2="update author set vote=vote+1 where id=".$author_id;
if($count==0)
{
	$sql3="insert into ip_count set aid=".$id.",ip='".$client_ip."',polldate=CURDATE(),count=1";
}
else
{
	$sql3="update ip_count set count=count+1 where id=".$ip_id;
}
if($db->sql_query($sql1) && $db->sql_query($sql2) && $db->sql_query($sql3))
{
//	setcookie("ipcount[".$id."]",$count+1,$today_end);
	echo '<script>alert("投票成功，感谢您的支持！");</script>';
	exit;
}
else
{
	echo $sql1.'|'.$sql2.'|'.$sql3;
}
?>