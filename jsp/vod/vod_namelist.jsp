<%@ page import="goldsoft.*,java.sql.*,java.net.*" %>
<%@ page errorPage="error.jsp" %>
<%
Opendb opendb = new Opendb();
StringReplace sr = new StringReplace();
String typepage = request.getParameter("typepage");
String dentry_id=request.getParameter("dentry_id");
String dentry_name=request.getParameter("dentry_name");
int intPageSize;
int intRowCount;
int intPageCount;
int intPage;
String strPage;
intPageSize = 8;
strPage = request.getParameter("page");
if (strPage == null) {
  intPage = 1;
}
else 
{
	intPage = java.lang.Integer.parseInt(strPage);
	if (intPage < 1)
		intPage = 1;
}

String sql1;
String sql2;
sql1="select count(*) from prog_info where prog_name is not null and prog_id is not null and del_flag=1 and prog_kindthr='"+dentry_id+"'";
sql2="select prog_id,prog_name,prog_path from prog_info where prog_name is not null and prog_id is not null and del_flag=1 and prog_kindthr='"+dentry_id+"' order by prog_id desc";

ResultSet rs = opendb.executeQuery(sql1);
rs.next();
intRowCount = rs.getInt(1);
rs = null;
rs = opendb.executeQuery(sql2);
intPageCount = (intRowCount + intPageSize - 1) / intPageSize;
if(intPage > intPageCount && intPageCount > 0)
	intPage = intPageCount;
if (intPage > 1) {
	for(int i = 0; i < (intPage - 1) * intPageSize; i++)
		rs.next();
}

%>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>无标题文档</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body leftMargin=0 topMargin=0 background="file:///usr/suit/newebox/image/vod/vod_namelist.jpg" bgcolor="#0a56d" >

<table width="630" border="0" cellpadding="0" cellspacing="0" height="460">
<tr>
	<td width=33 height=15>金</td>
	<td width=560>&nbsp;</td>
	<td width=37 height="15">&nbsp;</td>
</tr>
<tr>
	<td height=430>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table border=0 width=560 height=430 cellspacing=0 cellpadding=0>
	
	<tr>
		<td width="28" height="75">&nbsp;</td>
		<td width="250"></td>
		<td width="18">&nbsp;</td>
		<td colspan=2 align=right valign=bottom class=style24w>【<%=URLDecoder.decode(dentry_name,"iso88859-1")%>】</td>
	</tr>
	<tr>
		<td height="8" colspan=5></td>
	</tr>
	<tr>
		<td height=300>&nbsp;</td>
		<td valign=top>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<%
			String prog_id="";
			String prog_name="";
			int n = 0;
			while(rs.next())
			{
				prog_id=rs.getString(1).trim();
				prog_name = rs.getString(2).trim();
	  			if(prog_name.length() > 16)
				{
					prog_name=sr.substring(prog_name,0,16);
				}
				%>
			<tr id="<%=n%>">
				<td height=37 class=style24b><a style=color:white href='vod_introduce.jsp?typepage=<%=typepage%>&namepage=<%=intPage%>&prog_id=<%=prog_id%>&dentry_id=<%=dentry_id%>&dentry_name=<%=URLEncoder.encode(dentry_name,"iso8859-1")%>'>&nbsp;<%=prog_name%></a></td>
			</tr>
				<%
				n++;
				if(n>=intPageSize)
					break;
			}
			%>        
			</table></td>
		<td>&nbsp;</td>
		<td width="246">
			<br>
			<embed src="file:///usr/suit/newebox/list/list__vod2" width="240" height="180" type="application/x-mplayer2"></embed></td>
		<td width="18">&nbsp;</td>
	</tr>
    <tr>
		<td></td>
		<td height=35 valign="bottom" align=center class=style24w>第<%=intPage%>页&nbsp;&nbsp;&nbsp;&nbsp;共<%=intPageCount%>页</td>
		<td></td>
		<td></td>
		
		<td width="18"></td>
	</tr>
	</table>
	<!--********************************************* 可视面积 ***********************************************-->
	</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td height=15>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
</table>

</body>
<script language="JavaScript" type="text/JavaScript">
<!--
var key2=0;
function onfoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<td height=37 class=style24b bgcolor=#3366ff><a style="color:black" ' + dat;
	document.links[n].focus();
}

function losefoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<td height=37 class=style24w><a style="color:white" ' + dat;
}

function keyPress(e)
{
	var keycode=e.which
	var key1 = keycode -48
	var realkey=String.fromCharCode(e.which)
	var patern=/^[1-<%=n%>]$/; 
	if (patern.exec(key1)) 
	{
		if(key1 == key2 + 1)
			onfoc(key1 - 1);
		else
		{
			losefoc(key2);
			onfoc(key1 - 1)
			key2 = key1 -1;
		}
		setTimeout("",200);
		location = document.links[key2];
	  }
		 
	if(keycode==13)
	{
		setTimeout("",200);
		location = document.links[key2];
	}
	if(keycode==36)
	{
		location="vod_typelist.jsp?page=<%=typepage%>";
	}
	if(keycode==33)
	{
		location='?typepage=<%=typepage%>&dentry_id=<%=dentry_id%>&dentry_name=<%=URLEncoder.encode(dentry_name,"iso8859-1")%>&page=<%=intPage-1%>';
	}
	if(keycode==34)
	{
		location='?typepage=<%=typepage%>&dentry_id=<%=dentry_id%>&dentry_name=<%=URLEncoder.encode(dentry_name,"iso8859-1")%>&page=<%=intPage+1%>';
	}
	if(keycode==38)
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0)
			key2=<%=n-1%>;
		onfoc(key2)
	}
	if(keycode==40)
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2><%=n-1%>) 
			key2=0;
		onfoc(key2)
	}
}
   
document.onkeydown=keyPress
onfoc(0);
//-->
</script>
</html>
<%
opendb.dbclose();
%>
