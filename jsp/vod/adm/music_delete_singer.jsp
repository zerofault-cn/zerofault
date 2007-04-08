<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- 删除歌手 -->
<%
Opendb opendb = new Opendb();
String singer_id=request.getParameter("singer_id");
String query1="delete from singer_info where singer_id='"+singer_id+"'";
int r=opendb.executeUpdate(query1);
if(r!=0)
{
	%>
	<script>
		alert("已成功删除歌手");
		window.location="index.jsp?content=music_singer_list";
	</script>
	<%
}
else
{
	%>
	<script>
		alert("删除歌手时发生意外,请检查重试!");
		window.history.go(-1);
	</script>
	<%
}
opendb.dbclose();
%>
