<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- ��ӵ�Ӱ��Ŀ-1 -->
<script language="javascript">
function check()
{
	if(window.document.add.select_flag.value!=1)
	{
		alert("������ѡ�����");
		return false;
	}
	if(window.document.add.prog_name.value=="")
	{
		alert("��������������");
		document.add.prog_name.focus();
		return false;
	}
	if(window.document.add.prog_path.value=="")
	{
		alert("����������·��");
		document.add.prog_path.focus();
		return false;
	}

	return true;
}

</script>

<form action=vod_add_prog_2.jsp method=post name=add onsubmit="return check()">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=1 bgcolor=black>
<caption>�����Ƶ�㲥��Ŀ(<span style="color:red">*</span>Ϊ����)</caption>
<tr bgcolor=white>
	<td width="25%" align=right><span style="color:red">*</span>ѡ������:</td>
	<td><select name=prog_kindthr onchange="document.add.select_flag.value=1">
		<option value="">��ѡ��</option>
		<%
		Opendb opendb = new Opendb();
		String sql1="select dentry_id,dentry_name from dict_entry where dtype_id=50 and del_flag=1 order by dentry_id";
		ResultSet rs = opendb.executeQuery(sql1);
		while(rs != null && rs.next())
		{
			%>
			<option value="<%=rs.getInt(1)%>"><%=rs.getString(2).trim()%></option>
			<%
		}
		opendb.dbclose();
		%>
		</select></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>����:</td>
	<td><input type=text name=prog_name></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>ѡ���ļ�:</td>
	<td><input type=file name=prog_path size=30><span class=small>(�����ϴ�����)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right>�ļ���С:</td>
	<td><input type=text name=prog_size value=0 size=5>M</td>
</tr>
<tr bgcolor=white>
	<td align=right>����ʱ��:</td>
	<td><input type=text name=prog_timespan value=0></td>
</tr>
<tr bgcolor=white>
	<td align=right>������:</td>
	<td><input type=text name=publisher value="δ֪"></td>
</tr>
<tr bgcolor=white>
	<td align=right>��������:</td>
	<td><input type=text name=pubdate value="0000-00-00"></td>
</tr>
<tr bgcolor=white>
	<td align=right>����:</td>
	<td><input type=text name=director value="δ֪"></td>
</tr>
<tr bgcolor=white>
	<td align=right>��Ҫ��Ա:</td>
	<td><input type=text name=prog_acot value="δ֪"></td>
</tr>
<tr bgcolor=white>
	<td align=right>���ݼ��:</td>
	<td><textarea name=prog_describe rows=12 cols=60>����</textarea></td>
</tr>
<tr bgcolor=white>
	<td><input type=hidden name=select_flag></td>
	<td><input type=submit value=�ύ></td>
</tr>
</table>
</form>
