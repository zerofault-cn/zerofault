<%@ page import="goldsoft.*,java.sql.*" %>
<!-- 添加电影类别-1 -->
<script language="javascript">
function check()
{
	
	if(window.document.add.dentry_name.value=="")
	{
		alert("您忘了输入分类名");
		document.add.dentry_name.focus();
		return false;
	}
	return true;
}

function delrecord(dentry_id)
{
	
	if(confirm("确定要删除吗?"))
	{
		window.location="vod_delete_type.jsp?dentry_id="+dentry_id;
	}
	else
		return;
}
</script>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<caption>已存在的电影分类</caption>
<tr bgcolor=white>
	<td align=center>序号</td>
	<td align=center>类别名称</td>
	<td align=center>有效否</td>
	<td align=center>操作</td>
</tr>
<%
Opendb opendb = new Opendb();
String sql1="select dentry_id,dentry_name,del_flag from dict_entry where dtype_id=50 order by dentry_id";
ResultSet rs = opendb.executeQuery(sql1);
int i=0;
int tmp_dentry_id=0;
String tmp_dentry_name="";
int tmp_del_flag=0;
while(rs != null && rs.next())
{
	i++;
	tmp_dentry_id=rs.getInt(1);
	tmp_dentry_name=rs.getString(2).trim();
	tmp_del_flag=rs.getInt(3);
	%>
<tr bgcolor=white>
	<td align=center><%=i%></td>
	<td align=center><a href="index.jsp?content=vod_prog&flag=dentry_id&value=<%=tmp_dentry_id%>"><%=tmp_dentry_name%></a></td>
	<td align=center>
	<%
	if(tmp_del_flag==1) 
		out.print("<span style=color:blue>有效</span>");
	else
		out.print("<span style=color:red>无效</span>");
	%>
	</td>
	<td align=center>
		<input type=button onclick="window.open('vod_modify_type_1.jsp?dentry_id=<%=tmp_dentry_id%>','','width=400,height=300,toolbar=no,status=no,scrollbars=auto,resizeable=auto');" value="修改">
		<input type=button onclick='delrecord(<%=tmp_dentry_id%>)' value="删除">
		</td>
</tr>
<%
}
opendb.dbclose();
%>

<form action="vod_add_type_2.jsp" method=post name=add onsubmit="return check();">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<caption>添加新的分类</caption>
<tr bgcolor=white>
	<td align=right>分类名称:</td>
	<td><input name=dentry_name></td>
</tr>
<tr bgcolor=white>
	<td align=right>简短介绍:</td>
	<td><textarea name=dentry_describe cols=30 rows=4>不用了</textarea></td>
</tr>
<tr  bgcolor=white>
	<td></td>
	<td><input type=submit value="&nbsp;&nbsp;添&nbsp;&nbsp;加&nbsp;&nbsp;"></td>
</tr>
</table>
</form>
