<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- ��Ӹ�����Ϣ-1 -->
<script language="javascript">
function check()
{
	if(window.document.add.select_area.value!=1)
	{
		alert("������ѡ��������!");
		return false;
	}
	if(window.document.add.select_chorus.value!=1)
	{
		alert("������ѡ�ݳ���ʽ!");
		return false;
	}
	if(window.document.add.select_other.value!=1)
	{
		alert("������ѡ��������!");
		return false;
	}
	if(window.document.add.singer_name.value=="")
	{
		alert("�����������������!");
		document.add.singer_name.focus();
		return false;
	}
	return true;
}

</script>
<form name=add method=POST action="music_add_singer_2.jsp" ENCTYPE="multipart/form-data" onsubmit="return check()">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=2 bgcolor=black>
<caption>��������¼��(<span style="color:red">*</span>Ϊ����)</caption>
<tr bgcolor=white>
	<td align=right>������:</td>
	<td><input type=text name=singer_name></td>
</tr>
<tr bgcolor=white>
	<td align=right>���෽ʽ:</td>
	<td><select name=type_area_id onchange="document.add.select_area.value=1">
		<option value="">���������</option>
		<option value="">----------</option>
		<%
		Opendb opendb = new Opendb();
		ResultSet rs=opendb.executeQuery("select type_id,type_name from singer_type where type_label=1 order by type_id");
		while(rs.next())
		{
			%>
			<option value="<%=rs.getInt(1)%>"><%=rs.getString(2).trim()%></option>
			<%
		}
		%></select>
		<select name=type_chorus_id onchange="document.add.select_chorus.value=1">
		<option value="">�ݳ���ʽ</option>
		<option value="">--------</option>
		<%
		rs=null;
		rs=opendb.executeQuery("select type_id,type_name from singer_type where type_label=2 order by type_id");
		while(rs.next())
		{
			%>
			<option value="<%=rs.getInt(1)%>"><%=rs.getString(2).trim()%></option>
			<%
		}
		%></select>
		<select name=type_other_id onchange="document.add.select_other.value=1">
		<option value="">������ʽ</option>
		<option value="">--------</option>
		<%
		rs=null;
		rs=opendb.executeQuery("select type_id,type_name from singer_type where type_label=3 order by type_id");
		while(rs.next())
		{
			%>
			<option value="<%=rs.getInt(1)%>"><%=rs.getString(2).trim()%></option>
			<%
		}
		%></select></td>
</tr>
<tr bgcolor=white>
	<td align=right>�ϴ���Ƭ:</td>
	<td><INPUT TYPE=FILE NAME=photo SIZE=50></td>
</tr>
<tr bgcolor=white>
	<td align=right>���ּ��:</td>
	<td><textarea name=introduce cols=60 rows=15>����</textarea></td>
</tr>
<tr bgcolor=white>
	<td align=right><input type=hidden name=select_area><input type=hidden name=select_chorus><input type=hidden name=select_other></td>
	<td><input type=submit value="&nbsp;�ύ&nbsp;" name=B2></td>
</tr>
</table>
</form>