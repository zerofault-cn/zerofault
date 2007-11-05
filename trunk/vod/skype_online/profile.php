<?
ob_start();
$site_title="查看/编辑个人资料";
$page='profile';
include_once "common_function.php";
include_once "mysql_connect.php";
if('SkyMate'==$_COOKIE['cookie_agent'])
{
	include_once "mate_top.php";
	include_once "user_profile.php";
}
else
{
	include_once "top.php";
	if($mode!='register')
	{
		include_once "profile_navigation.php";
	}
	include_once "user_profile.php";
}
include_once "footer.php";
ob_end_flush();
?>
