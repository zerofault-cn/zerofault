<?
$file_file='modify_password.php';
if(''!=$submit)
{
	modify_password_2();
}
else
{
	modify_password_1();
}
function modify_password_1()
{
	$user_id=$_COOKIE['cookie_user_id'];
	if(''==$user_id)
	{
		errorMsg2('<br>您还没有登录,或登录已超时,请<a href="login.php">重新登录</a><br><br>');
		exit;
	}
	$user_account=$_COOKIE['cookie_user_account'];
	?>
<table width="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#E5F4FF" style="line-height:130%">
<tr>
	<td width=20 height=30><img src="image/table_top_left.gif"></td>
	<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/password_logo.gif"><img src="image/password_title.gif"></td>
	<td width=18><img src="image/table_top_right.gif"></td>
</tr>
<tr>
	<td rowspan=2 background="image/table_left.gif"></td>
	<td colspan=2></td>
	<td rowspan=2 background="image/table_right.gif"></td>
</tr>
<tr>
	<td>
	<table width="100%" border=0 cellpadding=0 cellspacing=0 class=formtable>
	<form action="<?=$this_file?>" name=form1 id=form1 method=post>
	<tr>
		<td align=right valign=top width=72>原始密码:</td>
		<td><input type=password name=user_oldpassword size=13 value=""><span style="color:red"><br>如果您忘了原始密码,请与管理员联系</span></td>
	</tr>
	<tr>
		<td align=right valign=top>新密码:</td>
		<td><input type=password name=user_password size=13 value=""><span style="color:red"><br>6位以上</span></td>
	</tr>
	<tr>
		<td align=right valign=top>确认新密码:</td>
		<td><input type=password name=user_repassword size=13 value=""><span style="color:red"><br>再输入一遍以供确认</span></td>
	</tr>
	<tr>
		<td></td>
		<td><input type=hidden name=user_id value="<?=$user_id?>">
			<input type=submit name=submit value=提交修改></td>
	</tr>
	</form>
	</table>
	</td>
</tr>
<tr>
	<td><img src="image/table_bottom_left.gif"></td>
	<td colspan=2 background="image/table_bottom.gif"></td>
	<td><img src="image/table_bottom_right.gif"></td>
</tr>
</table>
	<?
}

function modify_password_2()
{
	global $HTTP_POST_VARS;
	$user_id=$HTTP_POST_VARS['user_id'];
	$user_oldpassword=$HTTP_POST_VARS['user_oldpassword'];
	$user_password=$HTTP_POST_VARS['user_password'];
	$user_repassword=$HTTP_POST_VARS['user_repassword'];
	$sql1="select * from user_info where user_password=password('".$user_oldpassword."') and user_id=".$user_id;
	$result1=mysql_query($sql1);
	$sql2="update user_info set user_password=password('".$user_password."') where user_id='".$user_id."'";
	if(!mysql_fetch_array($result1))
	{
		errorMsg2('<br>错误的原始密码<br><br>');
	}
	elseif(strlen($user_password)<6)
	{
		errorMsg2('<br>新密码位数不够6位<br><br>');
	}
	elseif($user_password!=$user_repassword)
	{
		errorMsg2('<br>新密码前后不一致<br><br>');
	}
	elseif(mysql_query($sql2))
	{
		okMsg2('<br>密码修改成功<br><br>');
	}
	else
	{
		errorMsg2('<br>某些未知错误导致修改资料失败!<br><br>');
	}
}
?>