<!-- �޸�����-1 -->
<script language="javascript">
function check()
{
	
	if(window.document.amendpassword.admin_pass.value=="")
	{
		alert("����������������");
		document.amendpassword.admin_pass.focus();
		return false;
	}
	if(window.document.amendpassword.admin_repass.value=="")
	{
		alert("����������ȷ������");
		document.amendpassword.admin_repass.focus();
		return false;
	}
	if(window.document.amendpassword.admin_pass.value!=window.document.amendpassword.admin_repass.value)
	{
		alert("������ǰ��һ��!");
		document.amendpassword.admin_repass.focus();
		return false;
	}
	return true;
}
</script>
<center>
<table border="0" cellpadding="0" cellspacing="0" bordercolor=#aaaaaa >
<caption>�޸�����</caption>
<form action="admin_modify_password_2.php" method=post name=amendpassword onsubmit="return check()">
<tr><td align=right>������:</td><td><input type=password name=admin_pass></td></tr>
<tr><td align=right>������ȷ��:</td><td><input type=password name=admin_repass></td></tr>
<tr><td></td><td><input type=submit value="�޸�"></td></tr>
</form>
</table>
</center>
