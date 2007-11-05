<?
function mateAutoLogin()
{
	include_once "mysql_connect.php";
	global $HTTP_GET_VARS;
	$user_account=$HTTP_GET_VARS['user_account'];
	$sql2="select user_id,user_status2 from user_info where user_account='".$user_account."'";
	$result2=mysql_query($sql2);
	$user_id=mysql_result($result2,0,0);
	$user_status2=mysql_result($result2,0,1);
	$cookie_length=60;//Ä¬ÈÏ60·ÖÖÓ
	setcookie("cookie_user_id", $user_id , time() + 60 * $cookie_length);
	setcookie("cookie_user_account", $user_account ,time() + 60 * $cookie_length);
	setcookie("cookie_user_status2", $user_status2 ,time() + 60 * $cookie_length);
}
?>
