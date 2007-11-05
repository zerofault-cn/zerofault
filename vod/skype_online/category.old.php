<?
ob_start();
$site_title="SkyCall·ÖÀà";
$page='community';
include_once "common_function.php";
include_once "mysql_connect.php";
if('SkyMate'==$_COOKIE['cookie_agent'])
{
	include_once "mate_top.php";
	include_once "category_list.php";
}
else
{
	include_once "top.php";
	include_once "category_list.php";
}

include_once "footer.php";
ob_end_flush();
?>
