<?
function userLogin1()
{
	?>

<table width="100%" border=0 cellpadding=0 cellspacing=0 class=outertable>
<tr>
	<td align=center>
	<br>
	<table width="80%" border=0 cellpadding=5 cellspacing=0 class=innertable>
	<form action="?action=login2" name=form1 method=post>
	<caption align=left><img src="image/login_sm.gif">登录</caption>
	<tr>
		<td align=right>帐号:</td>
		<td><input type=text name=user_account size=20></td>
	</tr>
	<tr>
		<td align=right>密码:</td>
		<td><input type=password name=user_password size=20></td>
	</tr>
	<tr>
		<td align=right>保持登录:</td>
		<td><input type=checkbox name=cookieneverexp value=1></td>
	</tr>
	<tr>
		<td colspan=2 align=center><input type=hidden name=action value=login2><input type=submit value="登录">&nbsp;&nbsp;&nbsp;&nbsp;<input type=button onclick="javascript:window.location='?action=register1'" value="注册"></td>
	</tr>
	</table>
	<br>
	</td>
</tr>
</form>
</table>
	<?
}

function userLogin2()
{
	include_once "functions.php";
	include_once "mysql_connect.php";
	global $HTTP_POST_VARS;
	$user_account=$HTTP_POST_VARS['user_account'];
	$user_password=$HTTP_POST_VARS['user_password'];
	$cookieneverexp=$HTTP_POST_VARS['cookieneverexp'];
	if(''==$user_account)
	{
		errorMsg("您应该填写用户名称");
		exit;
	}
	if(''==$user_password)
	{
		errorMsg("您必须输入密码");
		exit;
	}
	$sql1="select * from user_info where user_account ='".$user_account."'";
	$result1=mysql_query($sql1);
	if(!mysql_fetch_array($result1))
	{
		errorMsg("不存在的用户名!");
		exit;
	}
	else
	{
		$sql2="select user_id,user_status2 from user_info where user_account='".$user_account."' and user_password=password('".$user_password."')";
		$result2=mysql_query($sql2);
		if(!$r2=mysql_fetch_array($result2))
		{
			errorMsg("密码错误,请重新输入");
			exit;
		}
		else
		{
			$user_id=$r2[0];
			$user_status2=$r2[1];
			if(isset($cookieneverexp))
			{
				$cookie_length = 504000;	// 单位:分钟,这里相当于1 year
			}
			else
			{
				$cookie_length=60;//默认60分钟
			}
			mysql_query("update user_info SET user_lastlogin=NOW() WHERE user_id='".$user_id."'");
			setcookie("cookie_user_id", $user_id , time() + 60 * $cookie_length);
			setcookie("cookie_user_account", $user_account ,time() + 60 * $cookie_length);
			setcookie("cookie_user_status2", $user_status2 ,time() + 60 * $cookie_length);
			header("location:?action=");
			exit;
		}
	}
}
?>
