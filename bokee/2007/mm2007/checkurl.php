<?php
define('IN_MATCH', true);
$root_path = "./";

include_once($root_path."config.php");
include_once($root_path."includes/db.php");

$blogurl=$_REQUEST['url'];
$tmp_blogurl=substr($blogurl,7);
if(strpos($tmp_blogurl,'/')>0)
{
	$tmp_blogurl=substr($tmp_blogurl,0,strpos($tmp_blogurl,'/'));//½ØÈ¡ÓòÃû×Ö·û´®
}
$sql="select * from mm_info where blogurl LIKE 'http://".$tmp_blogurl."%'";
$result=$db->sql_query($sql);
if($row=$db->sql_fetchrow($result))
{
	echo "<script>parent.setErr(1);parent.showMsg('blogurl_msg',1);</script>";
}
else
{
	echo "<script>parent.setErr(0);parent.showMsg('blogurl_msg',0);</script>";
}
$db->sql_close();
?>
