<?php
define('IN_MATCH', true);
header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$root_path = "./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");

//重新统计用户的留言数
$sql="select user_id,count(*) as count from comment where user_id!=0 group by user_id";
$result1=$db->sql_query($sql);
while($row1=$db->sql_fetchrow($result1))
{
	$user_id=$row1['user_id'];
	$count=$row1['count'];
	$sql2="update user_info set comm_count=".$count." where id=".$user_id;
	if($db->sql_query($sql2))
	{
		echo $user_id.' '.$count.' ok!<br>';
	}
}

?>