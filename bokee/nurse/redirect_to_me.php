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
if(''!=getBokie())
{
	$sql="select id from user_info where blogurl='http://".getBokie().".bokee.com'";
	$result=$db->sql_query($sql);
	if($db->sql_numrows($result)>0)
	{
		$row=$db->sql_fetchrow($result);
		header("location:comment.php?id=".$row['id']);
		exit;
	}
	else
	{
		header("location:http://nurse.bokee.com/");
		exit;
	}
}
else
{
	header("location:http://nurse.bokee.com/");
	exit;
}