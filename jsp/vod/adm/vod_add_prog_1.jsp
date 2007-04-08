<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- 添加电影节目-1 -->
<script language="javascript">
function check()
{
	if(window.document.add.select_flag.value!=1)
	{
		alert("您忘了选择分类");
		return false;
	}
	if(window.document.add.prog_name.value=="")
	{
		alert("您忘了输入名称");
		document.add.prog_name.focus();
		return false;
	}
	if(window.document.add.prog_path.value=="")
	{
		alert("您忘了输入路径");
		document.add.prog_path.focus();
		return false;
	}

	return true;
}

</script>

<form action=vod_add_prog_2.jsp method=post name=add onsubmit="return check()">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=1 bgcolor=black>
<caption>添加视频点播节目(<span style="color:red">*</span>为必填)</caption>
<tr bgcolor=white>
	<td width="25%" align=right><span style="color:red">*</span>选择类型:</td>
	<td><select name=prog_kindthr onchange="document.add.select_flag.value=1">
		<option value="">请选择</option>
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
	<td align=right><span style="color:red">*</span>名称:</td>
	<td><input type=text name=prog_name></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>选择文件:</td>
	<td><input type=file name=prog_path size=30><span class=small>(暂无上传功能)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right>文件大小:</td>
	<td><input type=text name=prog_size value=0 size=5>M</td>
</tr>
<tr bgcolor=white>
	<td align=right>播放时长:</td>
	<td><input type=text name=prog_timespan value=0></td>
</tr>
<tr bgcolor=white>
	<td align=right>出版商:</td>
	<td><input type=text name=publisher value="未知"></td>
</tr>
<tr bgcolor=white>
	<td align=right>出版日期:</td>
	<td><input type=text name=pubdate value="0000-00-00"></td>
</tr>
<tr bgcolor=white>
	<td align=right>导演:</td>
	<td><input type=text name=director value="未知"></td>
</tr>
<tr bgcolor=white>
	<td align=right>主要演员:</td>
	<td><input type=text name=prog_acot value="未知"></td>
</tr>
<tr bgcolor=white>
	<td align=right>内容简介:</td>
	<td><textarea name=prog_describe rows=12 cols=60>暂无</textarea></td>
</tr>
<tr bgcolor=white>
	<td><input type=hidden name=select_flag></td>
	<td><input type=submit value=提交></td>
</tr>
</table>
</form>
