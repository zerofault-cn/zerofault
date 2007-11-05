<?
include_once "mysql_connect.php";
include_once "common_function.php";
$user_account=$_COOKIE['cookie_user_account'];
if(''!=$user_account)
{
	$sql2="select user_id,user_status2 from user_info where user_account='".$user_account."'";
	$result2=mysql_query($sql2);
	$user_id=mysql_result($result2,0,0);
	$user_status2=mysql_result($result2,0,1);
	$cookie_length=60;//Ä¬ÈÏ60·ÖÖÓ
	$ip=$_SERVER['REMOTE_ADDR'];
	mysql_query("update user_info SET user_ip='".$ip."',user_lastlogin=NOW() WHERE user_id='".$user_id."'");
	$cookie_length=60;
	setcookie("cookie_user_id", $user_id);
	setcookie("cookie_user_status2", $user_status2);
	header("location:index.php");
	exit;
}
else
{
	loginTable();
}
?>