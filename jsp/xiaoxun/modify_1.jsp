<%@ page language="java" import="java.sql.*" %>
<jsp:useBean id="user" scope="page" class="MySQL.dbconnect"/>
<html>
<head>
<title>修改/删除学生信息</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<script language="javascript">
function check_student()
{
	if(window.document.modify_student.id.value=="")
	{
		alert("您忘了输入id");
		document.modify_student.id.focus();
		return false;
	}
	if(window.document.modify_student.sname.value=="")
	{
		alert("您忘了输入sname");
		document.modify_student.sname.focus();
		return false;
	}
	if(window.document.modify_student.grade.value=="")
	{
		alert("您忘了输入grade");
		document.modify_student.grade.focus();
		return false;
	}
	if(window.document.modify_student.mobile.value=="")
	{
		alert("您忘了输入mobile");
		document.modify_student.mobile.focus();
		return false;
	}
	if(window.document.modify_student.mobile.value.length!=11&&window.document.modify_student.mobile.value.length!=8)
	{
		alert("您输入的手机号位数不对");
		document.modify_student.mobile.focus();
		return false;
	}
	return true;
}
function check_passwd()
{
	if(window.document.modify_passwd.passwd.value=="")
	{
		alert("密码不能为空");
		document.modify_passwd.passwd.focus();
		return false;
	}
	if(window.document.modify_passwd.passwd.value!=window.document.modify_passwd.repasswd.value)
	{
		alert("密码不一致!");
		document.modify_passwd.repasswd.focus();
		return false;
	}
	return true;
}
function check_phone()
{
	if(window.document.modify_phone.phone.value=="")
	{
		alert("联系方式不能为空");
		document.modify_phone.phone.focus();
		return false;
	}
	return true;
}
function check_teacher()
{
	if(window.document.modify_teacher.teacher.value=="")
	{
		alert("老师名不能为空");
		document.modify_teacher.teacher.focus();
		return false;
	}
	return true;
}
</script>

<body>
<center>
<%
String grade=(String)session.getAttribute("grade");

if(request.getParameter("action").equals("modify_student"))
{
	String id=request.getParameter("id");
	String query1="select ssn,sname,elunch,mobile from student where id='"+id+"'";
	String query2="select grade from student group by grade";
	ResultSet rs1=user.executeQuery(query1);
	ResultSet rs2=user.executeQuery(query2);
	rs1.next();
	String ssn=rs1.getString("ssn").trim();
	String sname=rs1.getString("sname").trim();
	String elunch=rs1.getString("elunch").trim();
	String allgrade=null;
	String mobile=rs1.getString("mobile").trim();
	rs1.close();
	%>
	<table width=100% border="0" cellpadding="0" cellspacing="0">
	<caption>修改学生信息</caption>
	<form name=modify_student action="modify_2.jsp" method=post onsubmit="return check_student();">
	<tr><td align=right><span class=red>卡号:</span></td><td><input name=id size=8 value="<%=id%>" readonly></td></tr>
	<tr><td align=right>学生学号:</td><td><input name=ssn maxlength=4 size=8 value="<%=ssn%>"></td></tr>
	<tr><td align=right>学生姓名:</td><td><input name=sname size=8 value="<%=sname%>"></td></tr>
	<tr><td align=right>是否在校用餐:</td><td><input type="radio" name="haveLunch" value="1" <%if(elunch.equals("1"))out.print("checked");%>>是&nbsp;&nbsp;
	<input type="radio" name="haveLunch" value="0" <%if(elunch.equals("0"))out.print("checked");%>>否</td></tr>
	<tr><td align=right>班级代号:</td><td><select name=grade>
	<%
	while(rs2.next())
	{
		allgrade=rs2.getString("grade").trim();
		out.println("<option value="+allgrade);
		if(allgrade.equals(grade))
			out.println(" selected");
		out.println(">"+allgrade+"</option>");
	}
	rs2.close();
	%>
	</select></td></tr>
	<tr><td align=right>家长手机:</td><td><input name=mobile size=11 maxlength=11 value="<%=mobile%>"><span class=red>:手机号为11位数字</span></td></tr>
	<tr><td></td><td><input type=hidden name=action value=modify_student><input type=submit value="提交修改"></td></tr>
	</form>
	</table>
	<%
}
if(request.getParameter("action").equals("modify_passwd"))
{
	%>
	<table width=100% border="0" cellpadding="0" cellspacing="0">
	<caption>修改密码</caption>
	<form name=modify_passwd action="modify_2.jsp" target=_blank method=post onsubmit="return check_passwd();">
	<tr><td align=right><span class=red>班级代号:</span></td><td><input name=grade value="<%=grade%>" size=12 readonly></td></tr>
	<tr><td align=right>请输入新密码:</td><td><input type=password name=passwd></td></tr>
	<tr><td align=right>重新输入以确认:</td><td><input type=password name=repasswd></td></tr>
	<tr><td align=right></td><td><span class=red></span></td></tr>
	<tr><td></td><td><input type=hidden name=action value=modify_passwd><input type=submit value="提交修改"></td></tr>
	</form>
	</table>
	<%
}
if(request.getParameter("action").equals("modify_phone"))
{
	String query3="select phone from teacher where grade='"+grade+"'";
	ResultSet rs3=user.executeQuery(query3);
	rs3.next();
	String old_phone=rs3.getString("phone").trim();
	if(old_phone.equals(""))
		old_phone="未设置";
	rs3.close();
	%>
	<table width=100% border="0" cellpadding="0" cellspacing="0">
	<caption>修改老师联系方式</caption>
	<form name=modify_phone action="modify_2.jsp" target=_blank method=post onsubmit="return check_phone();">
	<tr><td align=right><span class=red>班级代号:</span></td><td><input name=grade value="<%=grade%>" size=14 readonly></td></tr>
	<tr><td align=right>原来的联系电话:</td><td><input name=old_phone value='<%=old_phone%>' size=14 readonly></td></tr>
	<tr><td align=right>输入新的联系电话:</td><td><input name=phone size=14></td></tr>
	<tr><td align=right></td><td></td></tr>
	<tr><td></td><td><input type=hidden name=action value=modify_phone><input type=submit value="提交修改"></td></tr>
	</form>
	</table>
	<%
}
if(request.getParameter("action").equals("modify_teacher"))
{
	String each_grade=request.getParameter("grade");
	String query4="select teacher from teacher where grade='"+each_grade+"'";
	ResultSet rs4=user.executeQuery(query4);
	rs4.next();
	String old_teacher=rs4.getString("teacher").trim();
	rs4.close();
	%>
	<table width=100% border="0" cellpadding="0" cellspacing="0">
	<caption>修改班级管理老师</caption>
	<form name=modify_teacher action="modify_2.jsp" target=_blank method=post onsubmit="return check_teacher();">
	<tr><td align=right><span class=red>班级代号:</span></td><td><input name=grade value="<%=each_grade%>" size=10 readonly></td></tr>
	<tr><td align=right>原来的管理老师:</td><td><input name=old_teacher value='<%=old_teacher%>' size=10 readonly></td></tr>
	<tr><td align=right>请输入新的管理老师:</td><td><input name=teacher size=10></td></tr>
	<tr><td align=right></td><td></td></tr>
	<tr><td></td><td><input type=hidden name=action value=modify_teacher><input type=submit value="提交修改"></td></tr>
	</form>
	</table>
	<%
}
%>
</center>
</body>
</html>