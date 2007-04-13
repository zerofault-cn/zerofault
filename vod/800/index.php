<?
@session_start();
include_once "../include/getuserinfo.php";
include_once "../include/user_count.php";
$os=getOS();
$_SESSION['os']=$os;
$browser=getBrowser();
if($os=='Windows')
{
	if($browser=='mozilla')
	{
		header("location:pc_login_1.php");
		exit;
	}
	else
	{
		header("location:pc_login_1.php");
		exit;
	}
}
else//其他操作系统
{
	session_start();
	$_SESSION['goldsoft_user']='aaa';
//	setcookie("goldsoft_user",'ebox');
	header("location:menu_1.php");
	exit;
}
?>