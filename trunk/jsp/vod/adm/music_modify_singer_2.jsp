<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- 修改歌手信息 -->
<%
Opendb opendb = new Opendb();
int singer_id=java.lang.Integer.parseInt(request.getParameter("singer_id"));
String singer_name=request.getParameter("singer_name");
int type_area_id=java.lang.Integer.parseInt(request.getParameter("type_area_id"));
int type_chorus_id=java.lang.Integer.parseInt(request.getParameter("type_chorus_id"));
int type_other_id=java.lang.Integer.parseInt(request.getParameter("type_other_id"));
String introduce=request.getParameter("introduce");

String sql="update singer_info set singer_name='"+singer_name+"',type_area_id="+type_area_id+",type_chorus_id="+type_chorus_id+",type_other_id="+type_other_id+",introduce='"+introduce+"' where singer_id="+singer_id;
int r=opendb.executeUpdate(sql);
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