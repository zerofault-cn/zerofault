<%@ page language="java" import="java.sql.*" %>
<jsp:useBean id="info" scope="page" class="MySQL.dbconnect"/>
<%
String grade=(String)session.getAttribute("grade");
String query1="select id from student where grade='"+grade+"'";
String query2="select teacher,phone from teacher where grade='"+grade+"'";
ResultSet rs1=info.executeQuery(query1);
ResultSet rs2=info.executeQuery(query2);
int i=0;
while(rs1.next())
{
	i++;
}
String teacher=null;
String phone=null;
if(rs2.next())
{
	teacher=rs2.getString("teacher").trim();
	phone=rs2.getString("phone").trim();
}
%>
<table border=0 cellpadding=0 cellspacing=0 width=100%>
<tr><td background="image/top_white.gif" colspan=3 height=20 valign=top align=center><img height=16 src="image/message.gif" width=16>��Ϣ��ʾ</td></tr>
<tr><td align=right height=100% rowspan=4 valign=top width=10><img height="100%" src="image/point.gif" width=1></td>
	<td style="font-size:10pt">&nbsp;&nbsp;�༶����:<%=grade%></td>
	<td align=left height=100% rowspan=4 valign=top width=10><img height="100%" src="image/point.gif" width=1></td></tr>
<tr><td style="font-size:10pt">&nbsp;&nbsp;��ʦ����:<%=teacher%></td></tr>
<tr><td style="font-size:10pt">&nbsp;&nbsp;��������:<%=i%></td></tr>
<tr><td style="font-size:10pt">&nbsp;&nbsp;��ϵ��ʽ:<%=phone%></td></tr>
<tr><td background="image/bottom_white.gif" colspan=3 height=20></td></tr>
</table>