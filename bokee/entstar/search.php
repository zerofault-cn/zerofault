<?php
define('IN_MATCH', true);
$root_path="./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");
$keyword=$_REQUEST['keyword'];
if($keyword!='')
{
	$sql="select id from user_info where realname like '%".$keyword."%'";
	$result=$db->sql_query($sql);
	if($row=$db->sql_fetchrow($result))
	{
		header("location:comment.php?id=".$row['id']);
		exit;
	}
}
else
{
	echo '<script>alert("没有搜索到您想要要的结果!");history.back()</script>';
}

?>