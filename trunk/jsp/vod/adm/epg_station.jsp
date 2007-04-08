<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- 列出所有频道 -->
<%
Opendb opendb = new Opendb();
StringReplace sr=new StringReplace();
%>
<script language="javascript">
function confirmdel(num)
{
	
	if(confirm("确定要删除吗?"))
	{
		window.location="epg_delete_station.jsp?num="+num;
	}
	else
		return;
}

</script>

<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<tr bgcolor=white>
	<td align=center>序号</td>
	<td align=center>名称</td>
	<td align=center>播放方式</td>
	<td align=center>类型</td>
	<td align=center>操作</td>
</tr>
<%
String sql1="select * from epg_station order by type desc,num";
ResultSet rs=opendb.executeQuery(sql1);
int i=1;
int j=0;
int k=0;
while(rs!=null&&rs.next())
{
	int num=rs.getInt("num");
	String station=rs.getString("station").trim();
	String path =rs.getString("path").trim();
	String type=rs.getString("type").trim();
	String extend=rs.getString("extend").trim();
	if(extend.equals(""))
		extend="#";
	%>
<tr bgcolor=white>
	<td align=center><%=i%></td>
	<td><a href="<%=extend%>" target="_blank"><%=station%></td>
	<td align=center><a href="<%=path%>" title="<%=path%>"><%=path.substring(0,path.indexOf("://"))%></a></td>
	<td align=center>
		<%
		if(type.equals("tv"))
		{
			j++;
			out.print("<span style='color:#0066CC'>电视机</span>");
		}
		if(type.equals("radio"))
		{
			k++;
			out.print("<span style='color:#ff9922'>收音机</span>");
		}
		%></td>
	<td align=center>
		<input type=button onclick="window.open('epg_modify_station_1.jsp?num=<%=num%>','','width=450,height=200,toolbar=no,status=no,resizeable=yes');" value="修改">&nbsp;
		<input type=button onclick='confirmdel(<%=num%>)' value="删除"></td>
</tr>
	<%
	i++;
}
opendb.dbclose();
%>
<caption valign=top>已有频道(<span style='color:#0066CC'><%=j%></span>+<span style='color:#ff9922'><%=k%></span>=<span style="color:red"><%=i-1%></span>个)</caption>
</table>
<center><a href="#top">回到顶部</a></center>