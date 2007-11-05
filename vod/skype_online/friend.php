<?
ob_start();
$site_title=$_COOKIE['user_account']."的好友列表";
$page='friend';
include_once "common_function.php";
include_once "mysql_connect.php";
if('SkyMate'==$_COOKIE['cookie_agent'])
{
	include_once "mate_top.php";
	$list='friend';
	include_once "mate_member_list.php";
}
else
{
	include_once "top.php";
	include_once "friend_list.php";
}
include_once "footer.php";
ob_end_flush();
?>
