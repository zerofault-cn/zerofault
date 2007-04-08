<?php
define('IN_MATCH', true);
header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$root_path = "./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");

//修正用户的留言数
$sql="select mm_id,count(*) as count from mm_comment where mm_id!=0 group by mm_id";
$result1=$db->sql_query($sql);
while($row1=$db->sql_fetchrow($result1))
{
	$mm_id=$row1['mm_id'];
	$count=$row1['count'];
	$sql2="update mm_info set comm_count=".$count." where id=".$mm_id;
	if($db->sql_query($sql2))
	{
		echo $mm_id.' '.$count.' ok!<br>';
		echo "\r\n";
	}
	else
	{
		echo 'error:'.$sql2;
		echo "<br>\r\n";
	}
}

?>