<%@ page language="java" import="java.sql.*" %>
<jsp:useBean id="user" scope="page" class="MySQL.dbconnect"/>
<html>
<head>
<title>�޸�/ɾ��ѧ����Ϣ</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<script language="javascript">
function check_student()
{
	if(window.document.modify_student.id.value=="")
	{
		alert("����������id");
		document.modify_student.id.focus();
		return false;
	}
	if(window.document.modify_student.sname.value=="")
	{
		alert("����������sname");
		document.modify_student.sname.focus();
		return false;
	}
	if(window.document.modify_student.grade.value=="")
	{
		alert("����������grade");
		document.modify_student.grade.focus();
		return false;
	}
	if(window.document.modify_student.mobile.value=="")
	{
		alert("����������mobile");
		document.modify_student.mobile.focus();
		return false;
	}
	if(window.document.modify_student.mobile.value.length!=11&&window.document.modify_student.mobile.value.length!=8)
	{
		alert("��������ֻ���λ������");
		document.modify_student.mobile.focus();
		return false;
	}
	return true;
}
function check_passwd()
{
	if(window.document.modify_passwd.passwd.value=="")
	{
		alert("���벻��Ϊ��");
		document.modify_passwd.passwd.focus();
		return false;
	}
	if(window.document.modify_passwd.passwd.value!=window.document.modify_passwd.repasswd.value)
	{
		alert("���벻һ��!");
		document.modify_passwd.repasswd.focus();
		return false;
	}
	return true;
}
function check_phone()
{
	if(window.document.modify_phone.phone.value=="")
	{
		alert("��ϵ��ʽ����Ϊ��");
		document.modify_phone.phone.focus();
		return false;
	}
	return true;
}
function check_teacher()
{
	if(window.document.modify_teacher.teacher.value=="")
	{
		alert("��ʦ������Ϊ��");
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
	<caption>�޸�ѧ����Ϣ</caption>
	<form name=modify_student action="modify_2.jsp" method=post onsubmit="return check_student();">
	<tr><td align=right><span class=red>����:</span></td><td><input name=id size=8 value="<%=id%>" readonly></td></tr>
	<tr><td align=right>ѧ��ѧ��:</td><td><input name=ssn maxlength=4 size=8 value="<%=ssn%>"></td></tr>
	<tr><td align=right>ѧ������:</td><td><input name=sname size=8 value="<%=sname%>"></td></tr>
	<tr><td align=right>�Ƿ���У�ò�:</td><td><input type="radio" name="haveLunch" value="1" <%if(elunch.equals("1"))out.print("checked");%>>��&nbsp;&nbsp;
	<input type="radio" name="haveLunch" value="0" <%if(elunch.equals("0"))out.print("checked");%>>��</td></tr>
	<tr><td align=right>�༶����:</td><td><select name=grade>
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
	<tr><td align=right>�ҳ��ֻ�:</td><td><input name=mobile size=11 maxlength=11 value="<%=mobile%>"><span class=red>:�ֻ���Ϊ11λ����</span></td></tr>
	<tr><td></td><td><input type=hidden name=action value=modify_student><input type=submit value="�ύ�޸�"></td></tr>
	</form>
	</table>
	<%
}
if(request.getParameter("action").equals("modify_passwd"))
{
	%>
	<table width=100% border="0" cellpadding="0" cellspacing="0">
	<caption>�޸�����</caption>
	<form name=modify_passwd action="modify_2.jsp" target=_blank method=post onsubmit="return check_passwd();">
	<tr><td align=right><span class=red>�༶����:</span></td><td><input name=grade value="<%=grade%>" size=12 readonly></td></tr>
	<tr><td align=right>������������:</td><td><input type=password name=passwd></td></tr>
	<tr><td align=right>����������ȷ��:</td><td><input type=password name=repasswd></td></tr>
	<tr><td align=right></td><td><span class=red></span></td></tr>
	<tr><td></td><td><input type=hidden name=action value=modify_passwd><input type=submit value="�ύ�޸�"></td></tr>
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
		old_phone="δ����";
	rs3.close();
	%>
	<table width=100% border="0" cellpadding="0" cellspacing="0">
	<caption>�޸���ʦ��ϵ��ʽ</caption>
	<form name=modify_phone action="modify_2.jsp" target=_blank method=post onsubmit="return check_phone();">
	<tr><td align=right><span class=red>�༶����:</span></td><td><input name=grade value="<%=grade%>" size=14 readonly></td></tr>
	<tr><td align=right>ԭ������ϵ�绰:</td><td><input name=old_phone value='<%=old_phone%>' size=14 readonly></td></tr>
	<tr><td align=right>�����µ���ϵ�绰:</td><td><input name=phone size=14></td></tr>
	<tr><td align=right></td><td></td></tr>
	<tr><td></td><td><input type=hidden name=action value=modify_phone><input type=submit value="�ύ�޸�"></td></tr>
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
	<caption>�޸İ༶������ʦ</caption>
	<form name=modify_teacher action="modify_2.jsp" target=_blank method=post onsubmit="return check_teacher();">
	<tr><td align=right><span class=red>�༶����:</span></td><td><input name=grade value="<%=each_grade%>" size=10 readonly></td></tr>
	<tr><td align=right>ԭ���Ĺ�����ʦ:</td><td><input name=old_teacher value='<%=old_teacher%>' size=10 readonly></td></tr>
	<tr><td align=right>�������µĹ�����ʦ:</td><td><input name=teacher size=10></td></tr>
	<tr><td align=right></td><td></td></tr>
	<tr><td></td><td><input type=hidden name=action value=modify_teacher><input type=submit value="�ύ�޸�"></td></tr>
	</form>
	</table>
	<%
}
%>
</center>
</body>
</html>