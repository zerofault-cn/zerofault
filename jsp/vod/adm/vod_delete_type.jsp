<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- 删除电影分类 -->
<%
Opendb opendb = new Opendb();
String dentry_id=request.getParameter("dentry_id");
String query1="delete from dict_entry where dentry_id='"+dentry_id+"'";
int r=opendb.executeUpdate(query1);
if(r!=0)
{
	%>
	<script>
		alert("已成功删除");
		window.location="index.jsp?content=vod_add_type_1";
	</script>
	<%
}
else
{
	%>
	<script>
		alert("删除记录时发生意外,请重试!");
		window.history.go(-1);
	</script>
	<%
}
opendb.dbclose();
%>
