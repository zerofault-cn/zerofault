<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- 修改歌手信息-1 -->
<html>
<head>
<title>修改歌手信息-1</title>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
<%
Opendb opendb = new Opendb();
String singer_id=request.getParameter("singer_id");
String sql1="select * from singer_info where singer_id='"+singer_id+"'";
ResultSet rs=opendb.executeQuery(sql1);
rs.next();
String singer_name=rs.getString("singer_name").trim();
String photo=rs.getString("photo").trim();
int type_area_id=rs.getInt("type_area_id");
int type_chorus_id=rs.getInt("type_chorus_id");
int type_other_id=rs.getInt("type_other_id");
String introduce=rs.getString("introduce").trim();
%>
<form name=modify method=POST action="music_modify_singer_2.jsp">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=2 bgcolor=black>
<caption>修改歌手资料</caption>
<tr bgcolor=white>
	<td align=right>歌手名:</td>
	<td><input type=text name=singer_name value="<%=singer_name%>"></td>
	<td rowspan=4><img src="/photo/<%=photo%>"></td>
</tr>
<tr bgcolor=white>
	<td align=right>地区及组合:</td>
	<td><select name=type_area_id>
		<%
		rs=null;
		rs=opendb.executeQuery("select type_id,type_name from singer_type where type_label=1 order by type_id");
		int type_id=0;
		String type_name="";
		while(rs.next())
		{
			
			type_id=rs.getInt(1);
			type_name=rs.getString(2).trim();
			%>
			<option value="<%=type_id%>"
			<%
			if(type_area_id==type_id)
				out.print(" selected");
			%>
			><%=type_name%></option>
			<%
		}
		%></select></td>
</tr>
<tr bgcolor=white>
	<td align=right>演唱方式:</td>
	<td><select name=type_chorus_id>
		<%
		rs=null;
		rs=opendb.executeQuery("select type_id,type_name from singer_type where type_label=2 order by type_id");
		while(rs.next())
		{
			
			type_id=rs.getInt(1);
			type_name=rs.getString(2).trim();
			%>
			<option value="<%=type_id%>"
			<%
			if(type_chorus_id==type_id)
				out.print(" selected");
			%>
			><%=type_name%></option>
			<%
		}
		%></select></td>
</tr>
<tr bgcolor=white>
	<td align=right>其他方式:</td>
	<td><select name=type_other_id>
		<%
		rs=null;
		rs=opendb.executeQuery("select type_id,type_name from singer_type where type_label=3 order by type_id");
		while(rs.next())
		{
			
			type_id=rs.getInt(1);
			type_name=rs.getString(2).trim();
			%>
			<option value="<%=type_id%>"
			<%
			if(type_other_id==type_id)
				out.print(" selected");
			%>
			><%=type_name%></option>
			<%
		}
		%></select></td>
</tr>

<tr bgcolor=white>
	<td align=right>歌手简介:</td>
	<td colspan=2><textarea name=introduce cols=45 rows=12><%=introduce%></textarea></td>
</tr>
<tr bgcolor=white>
	<td colspan=3 align=center><input type=submit value=提交修改>&nbsp;&nbsp;<input type=reset value="重置">&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="取消修改"></td>
</tr>
</table>
<input type=hidden name=singer_id value="<%=singer_id%>">
</form>
</body>
</html>
<%
opendb.dbclose();
%>