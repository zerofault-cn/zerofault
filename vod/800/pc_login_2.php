<?
session_start();
include_once "../include/db_connect.php";
$user_account=$_POST['user_account'];
$user_pass=$_POST['user_pass'];
$sql1="select * from user_info where user_account ='".$user_account."'";
$result1=$db->sql_query($sql1);
if(!$db->sql_numrows($result1))
{
	$_SESSION['login_msg']='用户名错误!';
	header("location:pc_login_1.php");
	exit;
}
else
{
	$sql2="select user_account from user_info where user_account='".$user_account."' and user_pass='".$user_pass."'";
	$result2=$db->sql_query($sql2);
	if(!$db->sql_numrows($result2))
	{
		$_SESSION['login_msg']='密码错误,请重新输入';
		header("location:pc_login_1.php");
		exit;
	}
	else
	{
		$_SESSION['goldsoft_user']=$user_account;
		unset($_SESSION['login_msg']);
		header("location:menu_1.php");
		exit;
	}
}
?>


