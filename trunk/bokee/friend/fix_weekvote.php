<?php
define('IN_MATCH', true);
header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$root_path = "./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");
/*
//导出每月票数排行前10名，并清空月票数
$sql="select id,monthvote from user_info order by monthvote desc limit 10";
$result1=$db->sql_query($sql);
while($row1=$db->sql_fetchrow($result1))
{
	$sql2="insert into month_vote set date=(CURDATE()-INTERVAL 1 day),user_id=".$row1['id'].",vote=".$row1['monthvote'];
	if($db->sql_query($sql2))
	{
		$sql2ok=1;
		echo "sql2 ok!<br>\r\n";
	}
	else
	{
		echo "error:".$sql2."<br>\r\n";
	}
}
*/
$sql3="update user_info set monthvote=0";
if($db->sql_query($sql3))
{
	echo "sql3 ok!<br>\r\n";
}
else
{
	echo "error:".$sql3."<br>\r\n";
}
$db->sql_close();
?>