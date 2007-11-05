<link rel="stylesheet" href="style.css" type="text/css">
<?
include_once "mysql_connect.php";
include_once "functions.php";
addFriend();
function addFriend()
{
	global $HTTP_GET_VARS;
	$user_id=$HTTP_GET_VARS['user_id'];
	$sql1="select * from user_friend where user_id=".$_COOKIE['cookie_user_id']." and friend_id=".$user_id;
	$result1=mysql_query($sql1);
	$sql2="select * from user_info where user_id=".$user_id." and user_permit=1";
	$result2=mysql_query($sql2);
	$sql3="insert into user_friend(user_id,friend_id,friend_addtime) values(".$_COOKIE['cookie_user_id'].",".$user_id.",NOW())";
	if(!isset($_COOKIE['cookie_user_account']) || ''==$_COOKIE['cookie_user_account'])
	{
		errorMsg("您尚未登录,或连接已超时,请重新<a href='?action=login1'>登录</a>");
	}
	elseif($_COOKIE['cookie_user_id']==$user_id)
	{
		errorMsg("您不能加自己为好友!");
	}
	elseif(mysql_fetch_array($result1))
	{
		errorMsg("您已经添加这个用户为好友了!");
	}
	elseif(mysql_fetch_array($result2))
	{
		errorMsg("该用户禁止被别人加为好友!");
	}
	elseif(mysql_query($sql3))
	{
		okMsg("添加成功<br>您可以<a href='window.history.go(-1);'>返回</a>,或者<a href='javascript:window.close();'>关闭窗口</a>");
	}
	else
	{
		errorMsg("系统数据库错误!");
	}
}
?>