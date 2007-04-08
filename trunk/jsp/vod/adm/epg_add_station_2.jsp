<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- 添加电视/电台频道-2 -->
<%
Opendb opendb = new Opendb();
String station = request.getParameter("station");
String path= request.getParameter("path");
String type= request.getParameter("type");
ResultSet rs;
rs=opendb.executeQuery("select * from epg_station where type='"+type+"' and path='"+path+"'");
if(rs!=null&&rs.next())
{
	%>
	<script>
		alert("数据库已存在相同路径,您可以选择改名");
		location="index.jsp?content=epg_station";
	</script>
	<%
}
else
{
	rs=null;
	rs=opendb.executeQuery("select max(num) from epg_station");
	int num=0;
	if(rs!=null&&rs.next())
	{
		num=rs.getInt(1);
		num=num+1;
		String sql = "insert into epg_station values('"+num+"','" + station + "','" + path + "','" + type + "')";
		int r = opendb.executeUpdate(sql);
		if(r!=0)
		{
			%>
			<script>
			if(confirm("已成功添加,继续添加吗?"))
				window.location="index.jsp?content=epg_add_station_1";
			else
				window.location="index.jsp?content=epg_station";
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
	}
}
opendb.dbclose();
%>
