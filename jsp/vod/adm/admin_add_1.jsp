<!-- ��ӹ���Ա-1 -->
<%
if(session.getAttribute("goldsoft_admin")==null)
{
	%>
	<script>
		alert("����δ��¼,��Ȩ����");	
		window.history.go(-1);
	</script>
	<%
}
else
{
%>
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
<table border="0" cellpadding="0" cellspacing="0" bordercolor=#aaaaaa >
<caption>��ӹ���Ա</caption>
<form action="admin_add_2.jsp" method=post name=add onsubmit="return check()">
<tr><td align=right>����Ա�ʺ�:</td><td><input type=text name=admin_account></td></tr>
<tr><td align=right>��ʵ����:</td><td><input type=text name=admin_name></td></tr>
<tr><td align=right>����:</td><td><input type=password name=admin_pass></td></tr>
<tr><td align=right>����ȷ��:</td><td><input type=password name=admin_repass></td></tr>
<tr><td></td><td><input type=submit value="����"></td></tr>
</form>
</table>
</center>
<%
}
%>
