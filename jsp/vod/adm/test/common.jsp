<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<%
Opendb opendb = new Opendb();
String sql1="select count(*) from admin_info";
String sql2="select admin_acount from admin_info order by admin_acount";
ResultSet rs=opendb.executeQuery(sql1);
int admin_num=0;
if(rs!=null&&rs.next())
{
	admin_num=rs.getInt(1);
}
else
{
	session.setAttribute("goldsoft_admin","noadmin");
	%>
	<script>
	alert("ϵͳ���޹���Ա,�������");
	location="index.jsp?content=admin_add_1";
	</script>
	<%
}
rs=null;
String[] admin_account = new String[admin_num];
int i=0;
rs=opendb.executeQuery(sql2);
while(rs!=null&&rs.next())
{
	admin_account[i]=rs.getString(1).trim();
	i++;
}
opendb.dbclose();
%>

<script language="javascript">
function check()
{
	
	if(window.document.login.passwd.value=="")
	{
		alert("��������������");
		document.login.passwd.focus();
		return false;
	}
	return true;
}
</script>


<center>
<%
String login_msg=(String)session.getAttribute("login_msg");
if(login_msg!=null)
{
	%>
	<script>
		alert("<%=login_msg%>");
	</script>
	<%
}
%>
<table>
<caption>������¼</caption>
<form action="login_2.jsp" name=login method=post>
<tr>
	<td align=right>�û���:</td>
	<td>
	<select name=admin_account>
	<%
	int j=0;
	for(j=0;j<i;j++)
	{
		out.println("<option value='"+admin_account[j]+"'>"+admin_account[j]+"</option>");
	}
	%>
	</select>
	</td>
</tr>
<tr>
	<td align=right>����:</td>
	<td><input type=password name=admin_pass value=""></td>
</tr>
<tr>
	<td></td>
	<td><input type=submit value=��¼ onclick="return check();"></td>
</tr>
</form>
</table>

</center>
