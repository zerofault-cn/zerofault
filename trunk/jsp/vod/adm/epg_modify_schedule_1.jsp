<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- 添加或更新节目单-1 -->
<script language="javascript">
function check()
{
	if(window.document.add.select_num.value!=1)
	{
		alert("您要给那个频道添加节目单呢?");
		return false;
	}
	if(window.document.add.select_weekday.value!=1)
	{
		alert("您忘了选星期几!");
		return false;
	}
	
	return true;
}

</script>
<form name=add method=POST action="epg_modify_schedule_2.jsp" onsubmit="return check()">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=2 bgcolor=black>
<caption>电视电台节目单更新</caption>
<tr bgcolor=white>
	<td align=right>选择频道:</td>
	<td><select name=num onchange="document.add.select_num.value=1">
		<option value="">请选择</option>
		<%
		Opendb opendb = new Opendb();
		ResultSet rs=opendb.executeQuery("select num,station,extend from epg_station order by type desc,num");
		while(rs.next())
		{
			%>
			<option value="<%=rs.getInt(1)%>"><%=rs.getString(2).trim()%></option>
			<%
		}
		%></select>
		</td>
</tr>
<tr bgcolor=white>
	<td align=right>选择星期:</td>
	<td><select name=weekday onchange="document.add.select_weekday.value=1">
		<option value="">请选择</option>
		<option value=1>星期一</option>
		<option value=2>星期二</option>
		<option value=3>星期三</option>
		<option value=4>星期四</option>
		<option value=5>星期五</option>
		<option value=6>星期六</option>
		<option value=7>星期日</option>
		</select></td>
</tr>
<tr bgcolor=white>
	<td align=right>节目单:</td>
	<td><textarea name=program rows=25 cols=60>暂无</textarea></td>
</tr>
<tr bgcolor=white>
	<td align=right><input type=hidden name=select_num><input type=hidden name=select_weekday></td>
	<td><input type=submit value="&nbsp;提交&nbsp;" name=B2></td>
</tr>
</table>
</form>