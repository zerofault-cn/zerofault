<%@ page language="java" import="java.sql.*,goldsoft.*" %>

<%
Opendb opendb = new Opendb();
String num=request.getParameter("num");
String query1="delete from epg_station where num='"+num+"'";
int r=opendb.executeUpdate(query1);
if(r!=0)
{
	%>
	<script>
		alert("已成功删除");
		window.location="index.jsp?content=epg_station";
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
