<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<!-- �г�����Ƶ�� -->
<%
Opendb opendb = new Opendb();
StringReplace sr=new StringReplace();
%>
<script language="javascript">
function confirmdel(num)
{
	
	if(confirm("ȷ��Ҫɾ����?"))
	{
		window.location="epg_delete_station.jsp?num="+num;
	}
	else
		return;
}

</script>

<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<tr bgcolor=white>
	<td align=center>���</td>
	<td align=center>����</td>
	<td align=center>���ŷ�ʽ</td>
	<td align=center>����</td>
	<td align=center>����</td>
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
			out.print("<span style='color:#0066CC'>���ӻ�</span>");
		}
		if(type.equals("radio"))
		{
			k++;
			out.print("<span style='color:#ff9922'>������</span>");
		}
		%></td>
	<td align=center>
		<input type=button onclick="window.open('epg_modify_station_1.jsp?num=<%=num%>','','width=450,height=200,toolbar=no,status=no,resizeable=yes');" value="�޸�">&nbsp;
		<input type=button onclick='confirmdel(<%=num%>)' value="ɾ��"></td>
</tr>
	<%
	i++;
}
opendb.dbclose();
%>
<caption valign=top>����Ƶ��(<span style='color:#0066CC'><%=j%></span>+<span style='color:#ff9922'><%=k%></span>=<span style="color:red"><%=i-1%></span>��)</caption>
</table>
<center><a href="#top">�ص�����</a></center>