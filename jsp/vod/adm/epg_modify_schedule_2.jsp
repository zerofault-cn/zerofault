<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- ��ӻ���½�Ŀ��-2, -->
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
		if(confirm("�ѳɹ����,���������?"))
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
		alert("��Ӽ�¼ʧ��,��������,���߱������Ա");
		window.history.go(-1);
	</script>
	<%
}
opendb.dbclose();
%>
