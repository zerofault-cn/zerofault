<!-- ��ӹ���Ա-1 -->
<script language="javascript">
function check()
{
	if(window.document.add.admin_account.value=="")
	{
		alert("���������������ʺ�");
		document.add.admin_account.focus();
		return false;
	}
	if(window.document.add.admin_name.value=="")
	{
		alert("��������������");
		document.add.admin_name.focus();
		return false;
	}
	if(window.document.add.admin_pass.value=="")
	{
		alert("��������������");
		document.add.admin_pass.focus();
		return false;
	}
	if(window.document.add.admin_repass.value=="")
	{
		alert("����������ȷ������");
		document.add.admin_repass.focus();
		return false;
	}
	if(window.document.add.admin_pass.value!=window.document.add.admin_repass.value)
	{
		alert("ǰ�����벻һ��!");
		document.add.admin_repass.focus();
		return false;
	}
	
	return true;
}
</script>
<center>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=1 bgcolor=black>
<caption>��ӹ���Ա</caption>
<form action="admin_add_2.php" method=post name=add onsubmit="return check()">
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>����Ա�ʺ�:</td>
	<td><input type=text name=admin_account></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>��ʵ����:</td>
	<td><input type=text name=admin_name></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>����:</td>
	<td><input type=password name=admin_pass></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>����ȷ��:</td>
	<td><input type=password name=admin_repass></td>
</tr>
<tr bgcolor=white>
	<td colspan=2 align=center><input type=submit value="&nbsp;���&nbsp;"></td>
</tr>
</form>
</table>
</center>
