<?
ob_start();
$site_title="注册SkyCall会员列表";
$page='community';
include_once "common_function.php";
include_once "mysql_connect.php";
if('SkyMate'==$_COOKIE['cookie_agent'])
{
	include_once "mate_top.php";
	include_once "user_register.php";
}
else
{
	include_once "top.php";
	include_once "user_register.php";
}

include_once "footer.php";
ob_end_flush();
?>
