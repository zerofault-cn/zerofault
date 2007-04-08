<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- 添加或更新节目单-2, -->
<%
Opendb opendb = new Opendb();
StringReplace sr = new StringReplace();
ResultSet rs = null;
int num=java.lang.Integer.parseInt(request.getParameter("num"));
int weekday=java.lang.Integer.parseInt(request.getParameter("weekday"));
String program=request.getParameter("program");
program=sr.newline(program);
//program=sr.transIso(program);

String sql1="select * from epg_schedule where num="+num+" and weekday="+weekday;
String sql2="";
rs=opendb.executeQuery(sql1);
if(rs!=null&&rs.next())
{
	sql2="update epg_schedule set program='"+program+"' where num="+num+" and weekday="+weekday;
}
else
{
	sql2="insert into epg_schedule values("+num+","+weekday+",'"+program+"')";
}
int r = opendb.executeUpdate(sql2);
if(r!=0)
{
	%>
	<script>
		if(confirm("已成功添加,继续添加吗?"))
			window.location="index.jsp?content=epg_modify_schedule_1";
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
opendb.dbclose();
%>
