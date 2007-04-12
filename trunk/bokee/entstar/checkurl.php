<?php
define('IN_MATCH', true);
$root_path = "./";

include_once($root_path."config.php");
include_once($root_path."includes/db.php");

$blogurl=$_REQUEST['blogurl'];
$groupurl=$_REQUEST['groupurl'];
if(''!=$blogurl)
{
	$tmp_blogurl=substr($blogurl,7);
	if(strpos($tmp_blogurl,'/')>0)
	{
		$tmp_blogurl=substr($tmp_blogurl,0,strpos($tmp_blogurl,'/'));//截取域名字符串
	}
	$sql="select * from user_info where blogurl LIKE 'http://".$tmp_blogurl."%'";
	if($db->sql_numrows($db->sql_query($sql)))
	{
		echo "<script>parent.setErr(1);parent.showMsg('blogurl_msg',1);</script>";
	}
	else
	{
		echo "<script>parent.setErr(0);parent.showMsg('blogurl_msg',0);</script>";
	}
}
if(''!=$groupurl)
{
	$sql="select * from user_info where groupurl='".$groupurl."'";//检验群组地址是否已被注册
	if($db->sql_numrows($db->sql_query($sql)))
	{
		echo "<script>parent.setErr(2);parent.showMsg('groupurl_msg',3);</script>";
	}
	else
	{
		echo "<script>parent.setErr(0);parent.showMsg('groupurl_msg',2);</script>";
	}
}
$db->sql_close();
?>
