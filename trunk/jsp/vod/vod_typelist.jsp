<%@ page language="java" import="java.sql.*,goldsoft.*,java.net.*" %>
<%@ page errorPage="error.jsp" %>
<%
Opendb opendb = new Opendb();
StringReplace sr = new StringReplace();
int intPageSize=0;
int intRowCount=0;
int intPageCount=0;
int intPage=0;
String strPage="";
intPageSize = 7;
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

String sql1="";
String sql2="";

sql1="select count(distinct dict_entry.dentry_id) from dict_entry,prog_info where prog_info.prog_kindsec='1006' and prog_info.prog_kindthr=dict_entry.dentry_id and dict_entry.dentry_id!=1026 and dict_entry.del_flag=1 and prog_info.del_flag=1";
sql2 = "select distinct dict_entry.dentry_id,dict_entry.dentry_name from dict_entry,prog_info where prog_info.prog_kindsec='1006' and dict_entry.dentry_id=prog_info.prog_kindthr and dict_entry.dentry_id!=1026 and dict_entry.del_flag=1 and prog_info.del_flag=1";
%>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>VOD电影</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body leftMargin=0 topMargin=0 background="file:///usr/suit/newebox/image/vod/vod_typelist.jpg" bgcolor="#0a56d" >

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
	<table border=0 width=560 cellspacing=0 cellpadding=0>
	  <!--DWLayoutTable-->
	<tr>
		<td width="29" height=87>&nbsp;</td>
		<td width="213">&nbsp;</td>
		<td width="20"></td>
		<td width="273"></td>
		<td width="25"></td>
		
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td valign=top>
		<table border=0 width="100%" height=294 cellspacing=0 cellpadding=0>
<%
int dentry_id=0;
String dentry_name="";
String url_dentry_name="";
int j = 0;
int n = 0;
int pre=0;
int next=0;
ResultSet rs = opendb.executeQuery(sql1);

if(rs!= null && rs.next()) 
{
	intRowCount = rs.getInt(1);
	
	if(intRowCount>0)
	{
		intPageCount = (intRowCount + intPageSize - 1) / intPageSize;
		if(intPage > intPageCount && intPageCount > 0)	
			intPage = intPageCount;
		rs=null;
		rs= opendb.executeQuery(sql2);
		if(rs!= null) {
			if (intPage > 1) {
				for(int i = 0; i < (intPage - 1) * intPageSize; i++) {
					rs.next();
				}
			}
			for(int i = 0; i < intPageSize; i++) {
				if(rs.next()) {
					dentry_id=rs.getInt(1);
					dentry_name=rs.getString(2).trim();
					%>
		<tr id=<%=n%>>
			<td height="42" align=center><img src="file:///usr/suit/newebox/image/22.png"><a class=style30b style="color:white" href='vod_namelist.jsp?typepage=<%=intPage%>&dentry_id=<%=dentry_id%>&dentry_name=<%=URLEncoder.encode(dentry_name,"iso8859-1")%>'><%=dentry_name%></a></td>
		</tr>
					<%
					n++;
				}
				
			}
		}
		%>
		<tr><td valign=bottom>
			<table width="100%" border=0 cellpadding=0 cellspacing=0>
			<tr>
				<td>
				<%
				if(intPageCount>1&&intPage>1)
				{
					pre=1;
					next=0;
					%>
				<img src="file:///usr/suit/newebox/image/pre.png">
					<%
				}
				%>
				</td>
				<td align=right>
				<%
				if(intPageCount>1&&intPage<intPageCount)
				{
					pre=0;
					next=1;
					%>
				<img src="file:///usr/suit/newebox/image/next.png">
					<%
				}
				%>
				</td></tr>
			</table></td>
		</tr>
	<%
	}
	else
	{
	%>
		<tr id=0>
			<td height="42" align=center class=style30b><a href="#">暂无数据</a></td>
		</tr>
	<%	
	}
}
opendb.dbclose();
%>
			
		</table></td>
		<td width=20>&nbsp;</td>
		<td width=273><br><embed src="file:///usr/suit/newebox/list/list__vod1" width="240" height="180" type="application/x-mplayer2"></embed></td>
		<td></td>
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
	t2.innerHTML = '<td height="42" bgcolor=#3366ff align=center><img src="file:///usr/suit/newebox/image/11.png"><a class="style30b" style="color:black" ' + dat;
	document.links[n].focus();
}

function losefoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<td height="42" align=center><img src="file:///usr/suit/newebox/image/22.png"><a class="style30w" style="color:white" ' + dat;
}

function keyPress(e)
{
	var keycode=e.which
	if (keycode==0)
       keycode=e.keyCode;
	var key1 = keycode -48;
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
		location=document.links[key2];
	}
	if(keycode==13)
	{
		setTimeout("",200);
		location=document.links[key2];
	}

	if(keycode==36)//HOME键
	{
		location="menu_1.jsp";
	}
	if(keycode==38)//光标左上键
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0) key2=<%=n-1%>;
		onfoc(key2)
	}
	if(keycode==40)//光标右下键
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2><%=n-1%>) key2=0;
		onfoc(key2)
		
	}
	if(keycode==33&&<%=pre%>==1)
	{
		location="?page=<%=intPage-1%>";
	}
	if(keycode==34&&<%=next%>==1)
	{
		location="?page=<%=intPage+1%>";
	}
}    
document.onkeypress=keyPress
onfoc(0);
//-->
</script>

</html>