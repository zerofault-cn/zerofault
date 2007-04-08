<%@ page import="goldsoft.*,java.sql.*,java.io.*" %>
<!-- 按类列出所有电影记录 -->
<%
Opendb opendb = new Opendb();
GetServerIp getServerIp=new GetServerIp();
int dentry_id=1027;//初始值
String str_dentry_id=(String)session.getAttribute("dentry_id");
if(str_dentry_id!=null)
	dentry_id=java.lang.Integer.parseInt(str_dentry_id);
%>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<caption>选择分类</caption>
<tr bgcolor=white>
<%
//首先查找类别
String sql1="select dentry_id,dentry_name from dict_entry where dtype_id=50 and del_flag=1 order by dentry_id";
ResultSet rs = opendb.executeQuery(sql1);
int prog_type_count=0;
int tmp_dentry_id=0;
String tmp_dentry_name="";
String now_dentry_name="";
while(rs != null && rs.next())
{
	tmp_dentry_id=rs.getInt(1);
	tmp_dentry_name=rs.getString(2).trim();
	prog_type_count++;
	%>
	<td align=center
	<%
	if(dentry_id==tmp_dentry_id)
	{
		out.print("bgcolor=#3399cc");
		now_dentry_name=tmp_dentry_name;
	}
	%>
	><a href="index.jsp?content=vod_prog&var1=dentry_id&value1=<%=tmp_dentry_id%>"><%=tmp_dentry_name%></td>
	<%
}
%>
</tr>
</table>
<%
String strOffset=(String)session.getAttribute("offset");
session.removeAttribute("offset");
int offset=0;
if(strOffset==null)
	offset=0;
else 
	offset=java.lang.Integer.parseInt(strOffset);
int pageitem=20;//设定每页显示行数
String sql2="select count(*) from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1006 and prog_kindthr="+dentry_id;
String sql3="select prog_id,prog_name,prog_path,prog_indate,del_flag from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1006 and prog_kindthr="+dentry_id+" order by prog_id desc limit "+offset+","+pageitem;
rs=opendb.executeQuery(sql2);
int rowCount=0;
rs.next();
rowCount=rs.getInt(1);
rs=null;
rs=opendb.executeQuery(sql3);
int prog_id=0;
String prog_name="";
String prog_path ="";
String prog_indate="";
int del_flag=0;
String realpath ="";
File f;
int i = 0;
%>
<script language="javascript">
function delrecord(prog_id)
{
	
	if(confirm("确定要删除该记录吗?"))
	{
		window.location="prog_delete.jsp?del_flag=record&page_from=vod_prog&prog_id="+prog_id;
	}
	else
		return;
}
function delfile(prog_id)
{
	if(confirm("确定要删除该文件吗？")&&confirm("删除将无法恢复哦！真的确认？"))
	{
		window.location="prog_delete.jsp?del_flag=file&page_from=vod_prog&prog_id="+prog_id;
	}
	else
		return;
}
</script>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<tr bgcolor=white>
	<td>序号</td>
	<td>名称</td>
	<td>播放</td>
	<td>录入时间</td>
	<td align=center>文件</td>
	<td align=center>有效否</td>
	<td align=center>操作</td>
</tr>
<%
while(rs!=null&&rs.next())
{
	i++;
	prog_id=rs.getInt(1);
	prog_name=rs.getString(2).trim();
	prog_path=rs.getString(3).trim();
	prog_indate=rs.getString(4).trim();
	del_flag=rs.getInt(5);
	if(prog_name.length()>18)
		prog_name=prog_name.substring(0,18);
	realpath = "/dpfs/" + prog_path;
	f = new File(realpath);
	%>
<tr bgcolor=white>
	<td align=center><%=i%></td>
	<td><%=prog_name%></td>
	<td><a href="lrtsp://<%=prog_path%>" title="<%=prog_path%>">1</a>|
		<%
		if(prog_path.substring(prog_path.lastIndexOf(".")).equals(".WMV"))
		{
			%>
			<a href="mms://<%=getServerIp.getIpByPath(prog_path)%>/<%=prog_path%>" title="<%=prog_path%>">2</a>
			<%
		}
		if(prog_path.substring(prog_path.lastIndexOf(".")).equals(".mp4"))
		{
			%>
			<a href="rtsp://<%=getServerIp.getIpByPath(prog_path)%>:555/<%=prog_path%>" title="<%=prog_path%>">2</a>
			<%
		}
		%></td>
	<td><%=prog_indate%></td>
	<td align=center>
	<%
	boolean f_exist=f.exists();
	if(f_exist) 
		out.print("<a style='color:blue' href=# title='文件路径:"+realpath+"'>有</a>");
	else
		out.print("<a style='color:red' href=# title='文件路径:"+realpath+"'>无</a>");
	%>
	</td>
	<td align=center>
	<%
	if(del_flag==1) 
		out.print("<span style=color:blue>有效</span>");
	else
		out.print("<span style=color:red>无效</span>");
	%>
	</td>
	<td align=center>
		<input type=button onclick="window.open('vod_modify_prog_1.jsp?prog_id=<%=prog_id%>','','width=450,height=600,toolbar=no,status=no,scrollbars=auto,resizeable=auto');" value="修改"><input type=button onclick='delrecord(<%=prog_id%>)'
		<%
		if(f_exist)
			out.print(" disabled");
		%>
		value="删除记录"><input type=button onclick='delfile(<%=prog_id%>)'
		<%
		if(!f_exist)
			out.print(" disabled");
		%>
		value="删除文件"></td>
</tr>
<%
}
opendb.dbclose();
%>
<tr bgcolor=white><td colspan=7 align=right>
<%
int preoffset=0;
int nextoffset=0;
int endpage=0;
if(offset!=0)
{
	preoffset=(offset-pageitem)>0?(offset-pageitem):0;
	%>
	<a href="index.jsp?content=vod_prog&var1=dentry_id&value1=<%=dentry_id%>&var2=offset&value2=0">【最前】</a>&nbsp;&nbsp;
	<a href="index.jsp?content=vod_prog&var1=dentry_id&value1=<%=dentry_id%>&var2=offset&value2=<%=preoffset%>">【前一页】</a>&nbsp;&nbsp;
	<%
}

if((offset+pageitem)<rowCount)
{
	nextoffset=offset+pageitem;
	endpage=rowCount-pageitem;
	%>
	<a href="index.jsp?content=vod_prog&var1=dentry_id&value1=<%=dentry_id%>&var2=offset&value2=<%=nextoffset%>">【后一页】</a>&nbsp;&nbsp;
	<a href="index.jsp?content=vod_prog&var1=dentry_id&value1=<%=dentry_id%>&var2=offset&value2=<%=endpage%>">【最后】</a>&nbsp;&nbsp;
	<%
}
%>
<%=(int)(Math.ceil((double)(rowCount-offset)/(double)pageitem))%>/<%=(int)(Math.ceil((double)rowCount/(double)pageitem))%>,共<%=rowCount%>条,每页<%=pageitem%>条
</td></tr>
<caption><span style="color:#3399cc"><%=now_dentry_name%></span>节目列表<span class=small>(共<span style="color:red"><%=rowCount%></span>个)</span></caption>
</table>
