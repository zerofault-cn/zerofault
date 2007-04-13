<?php
define('IN_MATCH', true);
$root_path = "./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");

$keyword=conv($_REQUEST['keyword']);
$sql="select * from user_info where id='".$keyword."' or binary blogname LIKE '%".$keyword."%'";
$result=$db->sql_query($sql);
if($db->sql_numrows($result)>0)
{
	$row=$db->sql_fetchrow($result);
	header("location:comment.php?id=".$row['id']);
	exit;
}
else
{
	echo '<script>alert("没有搜索到您想要要的结果!");history.back()</script>';
	exit;
}

?>