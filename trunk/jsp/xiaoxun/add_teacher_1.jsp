<%@ page language="java" import="java.sql.*" %>
<%
if(session.getAttribute("school")==null)
{
	%>
	<script>
		alert("您没有校方管理权限");	
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
		alert("您忘了输入班级代号");
		document.add.grade.focus();
		return false;
	}
	if(window.document.add.teacher.value=="")
	{
		alert("您忘了输入老师名");
		document.add.teacher.focus();
		return false;
	}
	if(window.document.add.passwd.value=="")
	{
		alert("您忘了输入密码");
		document.add.passwd.focus();
		return false;
	}
	if(window.document.add.repasswd.value=="")
	{
		alert("您忘了输入确认密码");
		document.add.repasswd.focus();
		return false;
	}
	if(window.document.add.passwd.value!=window.document.add.repasswd.value)
	{
		alert("前后密码不一致!");
		document.add.repasswd.focus();
		return false;
	}
	if(window.document.add.phone.value=="")
	{
		alert("您忘了输入您的联系方式");
		document.add.phone.focus();
		return false;
	}
	return true;
}
</script>
<center>
<table border="0" cellpadding="0" cellspacing="0" bordercolor=#aaaaaa >
<caption>添加老师/班级</caption>
<form action="add_teacher_2.jsp" method=post name=add onsubmit="return check()">
<tr><td align=right>班级代号:</td><td><input type=text name=grade></td></tr>
<tr><td align=right>老师姓名:</td><td><input type=text name=teacher></td></tr>
<tr><td align=right>密码:</td><td><input type=password name=passwd></td></tr>
<tr><td align=right>密码确认:</td><td><input type=password name=repasswd></td></tr>
<tr><td align=right>联系方式:</td><td><input type=text name=phone></td></tr>
<tr><td></td><td><input type=submit value="加入"></td></tr>
</form>
</table>
</center>
<%
}
%>
