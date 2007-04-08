<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- 修改电视电台频道信息-2 -->
<%
Opendb opendb = new Opendb();
String num=request.getParameter("num");
String station = request.getParameter("station");
String path= request.getParameter("path");
String type= request.getParameter("type");
String sql = "update epg_station set station='"+station+"',path='"+path+"',type='"+type+"' where num='"+num+"'";
int r = opendb.executeUpdate(sql);
if(r!=0)
{
	%>
	<script>
		alert("修改成功!");
		window.close();
	</script>
	<%
}
else
{
	%>
	<script>
		alert("修改失败,请检查重试");
		window.history.go(-1);
	</script>
	<%
}
opendb.dbclose();
%>
