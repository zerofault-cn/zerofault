<?
ob_start();
$site_title="�޸�����";
$page='profile';
include_once "common_function.php";
include_once "mysql_connect.php";
if('SkyMate'==$_COOKIE['cookie_agent'])
{
	include_once "mate_top.php";
	echo '<table width="100%" height="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#F4F8FF"><tr><td>';
	echo '<a href="index.php">���غ����б�</a>';
	include_once "modify_transfer.php";
	echo '</td></tr></table>';
}
ob_end_flush();
?>