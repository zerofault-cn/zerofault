<?php
define('IN_MATCH', true);
$php_path = "./";

include_once($php_path."config.php");
include_once($php_path."includes/db.php");

$blogurl=$_REQUEST['url'];
$tmp_blogurl=substr($blogurl,7);
if(strpos($tmp_blogurl,'/')>0)
{
	$tmp_blogurl=substr($tmp_blogurl,0,strpos($tmp_blogurl,'/'));
}
$sql="select * from user_info where blogurl LIKE 'http://".$tmp_blogurl."%'";
$result=$db->sql_query($sql);
if($db->sql_numrows($result)>0)
{
	echo "<script>parent.setErr('�˲������ӵ�ַ�Ѿ�������!�����ظ�����');parent.showMsg('blogurl_msg','�˲������ӵ�ַ�Ѿ�ע��!');</script>";
}
else
{
	echo "<script>parent.setErr('');parent.showMsg('blogurl_msg','�˲������ӵ�ַ��δ����!');</script>";
}
$db->sql_close();
?>