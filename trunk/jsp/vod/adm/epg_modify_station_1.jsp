<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- 修改电视电台频道信息-1 -->
<%
Opendb opendb = new Opendb();
String num=request.getParameter("num");
String sql1="select * from epg_station where num='"+num+"'";
ResultSet rs=opendb.executeQuery(sql1);
rs.next();
String type=rs.getString("type").trim();
String station=rs.getString("station").trim();
String path=rs.getString("path").trim();
opendb.dbclose();
%>
<form action="epg_modify_station_2.jsp" method=post name=modify><p>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=1 bgcolor=black>
<caption>修改频道信息</caption>
<tr bgcolor=white>
	<td align=right>修改类型:</td>
	<td><input type=radio name=type value=tv
		<%
		if(type.equals("tv"))
			out.print(" checked");
		%>
		>电视台&nbsp;&nbsp;
		<input type=radio name=type value=radio 
		<%
		if(type.equals("radio"))
			out.print(" checked");
		%>
		>电台</td>
</tr>
<tr bgcolor=white>
	<td align=right>名称:</td>
	<td><input type=text name=station value="<%=station%>"></td>
</tr>
<tr bgcolor=white>
	<td align=right>播放路径</td>
	<td><input type=text name=path size=40 value="<%=path%>"></td>
</tr>
<tr bgcolor=white>
	<td colspan=2 align=center><input type=submit value=提交修改>&nbsp;&nbsp;<input type=reset value="重置">&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="取消修改"></td>
</tr>
</table>
<input type=hidden name=num value="<%=num%>">
</form>
