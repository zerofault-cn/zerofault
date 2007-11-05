<?
ob_start();
$site_title="SkyCall会员列表";
$page='member';
include_once "common_function.php";
include_once "mysql_connect.php";
include_once "top.php";
include_once "member_list.php";
include_once "footer.php";
ob_end_flush();
?>
