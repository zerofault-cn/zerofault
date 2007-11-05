<?
if(''==$syspassword)
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
		<table width="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#E5F4FF" style="line-height:130%">
		<tr>
			<td width=20 height=30><img src="image/table_top_left.gif"></td>
			<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/login_logo.gif"><img src="image/login_title.gif"></td>
			<td width=18><img src="image/table_top_right.gif"></td>
		</tr>
		<tr>
			<td rowspan=2 background="image/table_left.gif"></td>
			<td colspan=2></td>
			<td rowspan=2 background="image/table_right.gif"></td>
		</tr>
		<tr>
			<td>
			<table width="100%" border=0 cellpadding=0 cellspacing=0 class=formTable>
			<form action="<?=$PHP_SELF?>" name=form1 method=post>
			<tr>
				<td align=right>系统密码:</td>
				<td><input type=password name=syspassword size=13></td>
			</tr>
			<tr>
				<td colspan=2 align=center><input type=submit name=submit value="登录"></td>
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
	include_once "common_function.php";
	$syspassword=$HTTP_POST_VARS['syspassword'];
	if($syspassword!='goldway123456')
	{
		errorMsg("<br>密码错误,请重新输入<br><br>");
	}
	else
	{
		setcookie("goldsoft_user",1);
		header("location:index.php");
		exit;
	}
}
?>