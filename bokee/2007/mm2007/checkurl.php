<?php
define('IN_MATCH', true);
$root_path = "./";

include_once($root_path."config.php");
include_once($root_path."includes/db.php");
if(mktime(14,0,0,1,18,2007)<time() && time()<mktime(14,0,0,4,12,2007))//海选投票日期
{
//	echo "<script>parent.setErr(2);</script>";
}
$blogurl=$_REQUEST['url'];
$tmp_blogurl=substr($blogurl,7);
if(strpos($tmp_blogurl,'/')>0)
{
	$tmp_blogurl=substr($tmp_blogurl,0,strpos($tmp_blogurl,'/'));//截取域名字符串
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
