<?
ob_start();
if(''==$_COOKIE['cookie_user_id'] && $_COOKIE['cookie_agent']=='SkyMate')
{
	header("location:mate_autologin.php");
	exit;
}
elseif($_COOKIE['cookie_agent']!='SkyMate' && ''==$_COOKIE['goldsoft_user'])
{
//	header("location:syslogin.php");
//	exit;
}
$site_title="SkyCallÊ×Ò³";
$page='index';
setcookie('cookie_returnUrl',$_SERVER['REQUEST_URI']);
include_once "common_function.php";
include_once "mysql_connect.php";

if(''!=$_COOKIE['cookie_user_id'])
{
	$sql1="select user_account,user_name from user_info where user_id='".$_COOKIE['cookie_user_id']."'";
	$result1=mysql_query($sql1);
	$user_account=mysql_result($result1,0,0);
	$user_name=mysql_result($result1,0,1);
	if(''==$user_name)
	{
		$user_name=$user_account;
	}
	setcookie('cookie_user_account',$user_account);
	setcookie('cookie_user_name',$user_name);
}
if('SkyMate'==$_COOKIE['cookie_agent'])
{
	include_once "mate_top.php";
	include_once "mate_member_list.php";
}
else
{
	include_once "top.php";
	include_once "welcome.php";
	include_once "footer.php";
}
ob_end_flush();
?>
