<%@ page language="java" import="java.sql.*" %>
<%
if(session.getAttribute("school")==null)
{
	%>
	<script>
		alert("��û��У������Ȩ��");	
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
	if(window.document.add.grade.value=="")
	{
		alert("����������༶����");
		document.add.grade.focus();
		return false;
	}
	if(window.document.add.teacher.value=="")
	{
		alert("������������ʦ��");
		document.add.teacher.focus();
		return false;
	}
	if(window.document.add.passwd.value=="")
	{
		alert("��������������");
		document.add.passwd.focus();
		return false;
	}
	if(window.document.add.repasswd.value=="")
	{
		alert("����������ȷ������");
		document.add.repasswd.focus();
		return false;
	}
	if(window.document.add.passwd.value!=window.document.add.repasswd.value)
	{
		alert("ǰ�����벻һ��!");
		document.add.repasswd.focus();
		return false;
	}
	if(window.document.add.phone.value=="")
	{
		alert("����������������ϵ��ʽ");
		document.add.phone.focus();
		return false;
	}
	return true;
}
</script>
<center>
<table border="0" cellpadding="0" cellspacing="0" bordercolor=#aaaaaa >
<caption>�����ʦ/�༶</caption>
<form action="add_teacher_2.jsp" method=post name=add onsubmit="return check()">
<tr><td align=right>�༶����:</td><td><input type=text name=grade></td></tr>
<tr><td align=right>��ʦ����:</td><td><input type=text name=teacher></td></tr>
<tr><td align=right>����:</td><td><input type=password name=passwd></td></tr>
<tr><td align=right>����ȷ��:</td><td><input type=password name=repasswd></td></tr>
<tr><td align=right>��ϵ��ʽ:</td><td><input type=text name=phone></td></tr>
<tr><td></td><td><input type=submit value="����"></td></tr>
</form>
</table>
</center>
<%
}
%>
