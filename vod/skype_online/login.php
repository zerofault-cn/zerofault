<?
ob_start();
$site_title="SkyCall³ÉÔ±µÇÂ¼";
$page='login';
include_once "common_function.php";
include_once "mysql_connect.php";
if('SkyMate'==$_COOKIE['cookie_agent'])
{
	include_once "mate_top.php";
	include_once "user_login.php";
}
else
{
	include_once "top.php";
	include_once "user_login.php";
}
include_once "footer.php";
ob_end_flush();
?>
