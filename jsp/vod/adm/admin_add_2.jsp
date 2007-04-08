<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- 添加管理员-2 -->
<%
String goldsoft_admin=(String)session.getAttribute("goldsoft_admin");
Opendb opendb = new Opendb();
String admin_account=request.getParameter("admin_account");
String sql1="select admin_id from admin_info where admin_acount='"+admin_account+"'";
ResultSet rs=opendb.executeQuery(sql1);
if(rs.next())
{
	opendb.dbclose();
	%>
	<script>
		alert("帐号 <%=admin_account%> 已存在,请确认重新添加");
		window.history.go(-1);
	</script>
	<%
}
else
{
	int admin_id=1;
	if(!goldsoft_admin.equals("noadmin"))
	{
		String sql2="select max(admin_id) from admin_info";
		rs=opendb.executeQuery(sql2);
		rs.next();
		admin_id=rs.getInt(1);
		admin_id++;
	}
	String admin_name=request.getParameter("admin_name");
	String admin_pass=request.getParameter("admin_pass");
	String sql3="insert into admin_info values('"+admin_id+"','"+admin_account+"','"+admin_name+"','"+admin_pass+"','','','1','"+goldsoft_admin+"',CURDATE(),CURTIME())";
	int r=opendb.executeUpdate(sql3);
	if(r!=0)
	{
		%>
		<script>
			if(confirm("已成功添加,继续添加吗?"))
				window.location="index.jsp?content=admin_add_1";
			else
				window.location="index.jsp";
		</script>
		<%
	}
	else
	{
		%>
		<script>
			alert("添加记录失败,请检查重试,或者报告管理员");
			window.history.go(-1);
		</script>
		<%
	}
	opendb.dbclose();
}
%>
