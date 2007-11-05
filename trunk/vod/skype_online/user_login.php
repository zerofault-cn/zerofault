<?
if(''!=$_COOKIE['cookie_user_id'])
{
	header("location:index.php");
	exit;
}
if(!isset($submit) || ''==$submit)
{
	?>
<center>
<table width="770" height="63%" border=0 cellpadding=0 cellspacing=0 bgcolor="#F4F8FF">
<tr>
	<td width=12 height="100%" background="image/border_left.gif"></td>
	<td align=center>
	<table width="100%" border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td height=16></td>
	</tr>
	<tr>
		<td>
		<?=loginTable()?>
		</td>
	</tr>
	<tr>
		<td height=16></td>
	</tr>
	</table>
	</td>
	<td width=12 background="image/border_right.gif"></td>
</tr>
</table>
</center>
	<?
}
else
{
	$user_account=$HTTP_POST_VARS['user_account'];
	$user_password=$HTTP_POST_VARS['user_password'];
	$cookieneverexp=$HTTP_POST_VARS['cookieneverexp'];
	$sql1="select * from user_info where user_account ='".$user_account."'";
	$result1=mysql_query($sql1);
	$sql2="select user_id,user_status2 from user_info where user_account='".$user_account."' and user_password=password('".$user_password."')";
	$result2=mysql_query($sql2);
	if(''==$user_account)
	{
		errorMsg("<br>您应该填写用户名称!<br><br>");
	}
	elseif(!mysql_fetch_array($result1))
	{
		errorMsg("<br>不存在的用户名!<br><br>");
	}
	elseif(!$r2=mysql_fetch_array($result2))
	{
		errorMsg("<br>密码错误,请重新输入<br><br>");
	}
	else
	{
		$user_id=$r2[0];
		$user_status2=$r2[1];
		if($cookieneverexp)
		{
			$cookie_length = 504000;	// 单位:分钟,这里相当于1 year
		}
		else
		{
			$cookie_length=60;//默认60分钟
		}
		$ip=$_SERVER['REMOTE_ADDR'];
		mysql_query("update user_info SET user_ip='".$ip."',user_lastlogin=NOW() WHERE user_id='".$user_id."'");
		setcookie("cookie_user_id", $user_id , time() + 60*$cookie_length);
		setcookie("cookie_user_account", $user_account ,time() + 60*$cookie_length);
		setcookie("cookie_user_status2", $user_status2 ,time() + 60*$cookie_length);
		$returnUrl=$_COOKIE['cookie_returnUrl'];
		if(''==$returnUrl)
		{
			$returnUrl='index.php';
		}
		header("location:".$returnUrl);
		exit;
	}
}
?>