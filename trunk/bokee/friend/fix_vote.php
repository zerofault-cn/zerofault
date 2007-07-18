<?php
define('IN_MATCH', true);
header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$root_path = "./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");

//修正用户的票数

$sql1="select * from user_info where pass>0";
$result=$db->sql_query($sql1);
while($row=$db->sql_fetchrow($result))
{
	$id=$row['id'];
//	$id=$_REQUEST['id'];
//	$sql3="select count(id) as count from ip_info where polltime>".(mktime(0,0,0,date("m"),date("d"),date("Y"))-86400)." and polltime<".mktime(0,0,0,date("m"),date("d"),date("Y"))." where user_id=".$id;
	
	$sql4="select count(id) from ip_info where user_id=".$id;
	$ip_vote=$db->sql_fetchfield(0,0,$db->sql_query($sql4));
	$sql5="update user_info set vote=".$ip_vote.",monthvote=".$ip_vote." where id=".$id;
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