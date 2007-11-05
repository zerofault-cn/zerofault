<?
ob_start();
$site_title="修改密码";
$page='profile';
include_once "common_function.php";
include_once "mysql_connect.php";
if('SkyMate'==$_COOKIE['cookie_agent'])
{
	include_once "mate_top.php";
	echo '<table width="100%" height="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#F4F8FF"><tr><td>';
	echo '<a href="index.php">返回好友列表</a>';
	include_once "modify_password.php";
	echo '</td></tr></table>';
}
else
{
	include_once "top.php";
	include_once "profile_navigation.php";
	include_once "modify_password.php";
	include_once "footer.php";
}
ob_end_flush();
?>
