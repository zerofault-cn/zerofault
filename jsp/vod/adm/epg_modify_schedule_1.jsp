<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- ��ӻ���½�Ŀ��-1 -->
<script language="javascript">
function check()
{
	if(window.document.add.select_num.value!=1)
	{
		alert("��Ҫ���Ǹ�Ƶ����ӽ�Ŀ����?");
		return false;
	}
	if(window.document.add.select_weekday.value!=1)
	{
		alert("������ѡ���ڼ�!");
		return false;
	}
	
	return true;
}

</script>
<form name=add method=POST action="epg_modify_schedule_2.jsp" onsubmit="return check()">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=2 bgcolor=black>
<caption>���ӵ�̨��Ŀ������</caption>
<tr bgcolor=white>
	<td align=right>ѡ��Ƶ��:</td>
	<td><select name=num onchange="document.add.select_num.value=1">
		<option value="">��ѡ��</option>
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
	<td align=right>ѡ������:</td>
	<td><select name=weekday onchange="document.add.select_weekday.value=1">
		<option value="">��ѡ��</option>
		<option value=1>����һ</option>
		<option value=2>���ڶ�</option>
		<option value=3>������</option>
		<option value=4>������</option>
		<option value=5>������</option>
		<option value=6>������</option>
		<option value=7>������</option>
		</select></td>
</tr>
<tr bgcolor=white>
	<td align=right>��Ŀ��:</td>
	<td><textarea name=program rows=25 cols=60>����</textarea></td>
</tr>
<tr bgcolor=white>
	<td align=right><input type=hidden name=select_num><input type=hidden name=select_weekday></td>
	<td><input type=submit value="&nbsp;�ύ&nbsp;" name=B2></td>
</tr>
</table>
</form>