<!-- ����û�-1 -->
<script language="javascript">
function check()
{
	if(window.document.add.user_account.value=="")
	{
		alert("�����������û��ʺţ�");
		document.add.user_account.focus();
		return false;
	}
	if(window.document.add.user_name.value=="")
	{
		alert("������������ʵ������");
		document.add.user_name.focus();
		return false;
	}
	if(window.document.add.user_pass.value=="")
	{
		alert("�������������룡");
		document.add.user_pass.focus();
		return false;
	}
	if(window.document.add.user_repass.value=="")
	{
		alert("����������ȷ�����룡");
		document.add.user_repass.focus();
		return false;
	}
	if(window.document.add.user_pass.value!=window.document.add.user_repass.value)
	{
		alert("ǰ�����벻һ�£�");
		document.add.user_repass.focus();
		return false;
	}
	if(window.document.add.user_idcard.value=="")
	{
		alert("�������������֤���룡");
		document.add.user_idcard.focus();
		return false;
	}
	if(window.document.add.user_firstpay.value=="")
	{
		alert("����������Ԥ�������");
		document.add.user_firstpay.focus();
		return false;
	}
	
	return true;
}

function checkaccount()
{
	if(window.document.add.user_account.value=="")
	{
		alert("�����������û��ʺţ�");
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
<caption>������û�</caption>
<form action="user_add_2.php" method=post name=add onsubmit="return check()">
<tr bgcolor=white>
  <td align=right><span style="color:red">*</span>�û��ʺ�:</td>
  <td><input type=text name=user_account> 
     <input type="button" name="check_account" value="����ʺ�" onClick="checkaccount();">(��鱾�ʺ��Ƿ���ע��) 
  </td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>��ʵ����:</td><td><input type=text name=user_name></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>����:</td><td><input type=password name=user_pass></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>����ȷ��:</td><td><input type=password name=user_repass></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>���֤��:</td><td><input type=text name=user_idcard></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>�ͻ�����:</td>
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
	<td align=right><span style="color:red">*</span>�ɷ�����:</td>
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
	<td align=right><span style="color:red">*</span>�ۿ�Ȩ��:</td>
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
	<td align=right><span style="color:red">*</span>Ԥ�����:</td><td><input type=text name=user_firstpay></td>
</tr>
<tr bgcolor=white>
	<td align=right>��ϵ�绰:</td><td><input type=text name=user_tel></td>
</tr>
<tr bgcolor=white>
	<td align=right>E-Mail:</td><td><input type=text name=user_email></td>
</tr>
<tr bgcolor=white>
	<td align=right>��ͥסַ:</td><td><input type=text name=user_addr></td>
</tr>
<tr bgcolor=white>	
	<td align=right>��������:</td><td><input type=text name=user_post></td>
</tr>
<tr bgcolor=white>
	<td></td><td><input type=submit value="����"></td>
</tr>
</form>
</table>
</center>
