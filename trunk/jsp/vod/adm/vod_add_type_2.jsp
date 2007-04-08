<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- 添加电影类别-2 -->
<%
String goldsoft_admin=(String)session.getAttribute("goldsoft_admin");
Opendb opendb = new Opendb();
String dentry_name=request.getParameter("dentry_name");
String sql1="select * from dict_entry where dentry_name='"+dentry_name+"'";
ResultSet rs=opendb.executeQuery(sql1);
if(rs!=null&&rs.next())
{
	%>
	<script>
		alert("'<%=dentry_name%>'已经有了,添加其他类别吧!");
		window.history.go(-1);
	</script>
	<%
}
else
{
	rs=null;
	int dtype_id=50;
	String dentry_describe=request.getParameter("dentry_describe");
	int del_flag=1;
	String sql2="select max(dentry_id) from dict_entry";
	rs=opendb.executeQuery(sql2);
	int dentry_id=0;
	if(rs!=null&&rs.next())
	{
		dentry_id=rs.getInt(1);
		dentry_id=dentry_id+1;
	}
	String sql3="insert into dict_entry values("+dentry_id+","+dtype_id+",'"+dentry_name+"','"+dentry_describe+"',"+del_flag+",'"+goldsoft_admin+"',CURDATE(),CURTIME())";
	int r=opendb.executeUpdate(sql3);
	if(r!=0)
	{
		%>
		<script>
			if(confirm("已成功添加,继续添加吗?"))
				window.location="index.jsp?content=vod_add_type_1";
			else
				window.location="index.jsp?content=vod_prog";
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
