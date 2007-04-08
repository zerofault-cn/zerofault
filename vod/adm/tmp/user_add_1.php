<!-- 添加用户-1 -->
<script language="javascript">
function check()
{
	if(window.document.add.user_account.value=="")
	{
		alert("您忘了输入用户帐号！");
		document.add.user_account.focus();
		return false;
	}
	if(window.document.add.user_name.value=="")
	{
		alert("您忘了输入真实姓名！");
		document.add.user_name.focus();
		return false;
	}
	if(window.document.add.user_pass.value=="")
	{
		alert("您忘了输入密码！");
		document.add.user_pass.focus();
		return false;
	}
	if(window.document.add.user_repass.value=="")
	{
		alert("您忘了输入确认密码！");
		document.add.user_repass.focus();
		return false;
	}
	if(window.document.add.user_pass.value!=window.document.add.user_repass.value)
	{
		alert("前后密码不一致！");
		document.add.user_repass.focus();
		return false;
	}
	if(window.document.add.user_idcard.value=="")
	{
		alert("您忘了输入身份证号码！");
		document.add.user_idcard.focus();
		return false;
	}
	if(window.document.add.user_firstpay.value=="")
	{
		alert("您忘了输入预充点数！");
		document.add.user_firstpay.focus();
		return false;
	}
	
	return true;
}

function checkaccount()
{
	if(window.document.add.user_account.value=="")
	{
		alert("您忘了输入用户帐号！");
		document.add.user_account.focus();
		return false;
	}
	else
    {
		var page='user_newaccount_check.php?user_account='+document.add.user_account.value;
		window.open(page, '', 'width=150,height=50,toolbar=no,status=no,scrollbars=no,resizable=yes');
	}
}
</script>

<center>
<table width="100%" border=0 cellspacing=1 cellpadding=1 bgcolor=black>
<caption>添加新用户</caption>
<form action="user_add_2.php" method=post name=add onsubmit="return check()">
<tr bgcolor=white>
  <td align=right><span style="color:red">*</span>用户帐号:</td>
  <td><input type=text name=user_account> 
     <input type="button" name="check_account" value="检查帐号" onClick="checkaccount();">(检查本帐号是否已注册) 
  </td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>真实姓名:</td><td><input type=text name=user_name></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>密码:</td><td><input type=password name=user_pass></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>密码确认:</td><td><input type=password name=user_repass></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>身份证号:</td><td><input type=text name=user_idcard></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>客户类型:</td>
	<td><select name="user_type">
		<?
		include_once "../include/mysql_connect.php";
		$sql1="select utype_id,utype_mc from user_type order by utype_id";
		$result1=mysql_query($sql1);
		while($r=mysql_fetch_array($result1))
		{
			?>
			<option value="<?=$r[0]?>"><?=$r[1]?></option>
			<?
		}
		?>
		</select></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>缴费类型:</td>
	<td><select name="fee_type">
		<?
		//include "../include/mysql_connect.php";
		$sql1="select dentry_id,dentry_name from dict_entry where dtype_id=80 and del_flag=1 order by dentry_id";
		$result1=mysql_query($sql1);
		while($r=mysql_fetch_array($result1))
		{
			?>
			<option value="<?=$r[0]?>"><?=$r[1]?></option>
			<?
		}
		?>
		</select></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>观看权限:</td>
	<td><select name="prog_limit">
		<?
		$sql1="select dentry_id,dentry_name from dict_entry where dtype_id=90 and del_flag=1 order by dentry_id";
		$result1=mysql_query($sql1);
		while($r=mysql_fetch_array($result1))
		{
			?>
			<option value="<?=$r[0]?>"><?=$r[1]?></option>
			<?
		}
		?>
		</select></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>预充点数:</td><td><input type=text name=user_firstpay></td>
</tr>
<tr bgcolor=white>
	<td align=right>联系电话:</td><td><input type=text name=user_tel></td>
</tr>
<tr bgcolor=white>
	<td align=right>E-Mail:</td><td><input type=text name=user_email></td>
</tr>
<tr bgcolor=white>
	<td align=right>家庭住址:</td><td><input type=text name=user_addr></td>
</tr>
<tr bgcolor=white>	
	<td align=right>邮政编码:</td><td><input type=text name=user_post></td>
</tr>
<tr bgcolor=white>
	<td></td><td><input type=submit value="加入"></td>
</tr>
</form>
</table>
</center>
