<%@ page import="goldsoft.*,java.sql.*" %>
<%@ taglib uri="oscache" prefix="cache" %>
<%@ page errorPage="error.jsp" %>
<%
String type1 = request.getParameter("type1");
int mm=type1.length();
String type2="";
if (mm==15) type2="中文流行排行榜";
if (mm==14) type2="中文点播排行榜";
if (mm==12) type2="外语流行排行榜";
if (mm==11) type2="外语点播排行榜";


int intPageSize;
int intPage;
String strPage;
intPageSize = 10;
strPage = request.getParameter("page");
if (strPage == null) {
  intPage = 1;
}
else {
  intPage = java.lang.Integer.parseInt(strPage);
  if (intPage < 1)
    intPage = 1;
}
Opendb opendb = new Opendb();
StringReplace sr = new StringReplace();
ResultSet rs = opendb.executeQuery("select path,name,singer from fashionsong where type1='" + type1 + "' order by power");
String[] item = new String[intPageSize];
String[] item1= new String[intPageSize];
String[] item2= new String[intPageSize];
String tmp_name=null;
String tmp_singer=null;
for(int i = 0; i < intPageSize; i++) {
	if(rs != null && rs.next()) 
	{
		tmp_name=rs.getString(2);
		if(tmp_name.length()>20)
		{
			tmp_name=tmp_name.substring(0,20)+"...";
		}
		item[i] = "<a style=color:white href=" + rs.getString(1) + ">" +(i+1)+"."+ tmp_name + "</a>";
		tmp_singer=rs.getString(3);
		if(tmp_singer.length()>12)
		{
			tmp_singer=tmp_singer.substring(0,12)+"...";
		}
		item1[i] =tmp_singer;
	}
	else {
	item[i] = "<a href=" +"#"+ ">" + "</a>";
	item1[i] = "<a href=" +"#"+ ">" + "</a>";
	}
}
opendb.dbclose();
%>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>无标题文档</title>
<link rel="stylesheet" href="style.css" type="text/css">

<script language="JavaScript" type="text/JavaScript">
<!--
var key2=0;
function onfoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<table height=100% width=100% border=0 cellpadding=0 cellspacing=0 bgcolor=#3366ff><tr><td><a class=style24w '+ dat+'</td></tr></table>';
	document.links[n].focus();
}
function losefoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<a style=color:white ' + dat;
}

function keyDown(e)
{
	var keycode=e.which
	
	if (keycode==0)
       keycode=e.keyCode;
	
	
	if(keycode==36)
	{
		location="music_paihangtype.jsp";
	}
	if(keycode==38)//光标左上键
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0) key2=9;
		onfoc(key2)
	}
	if(keycode==40)//光标右下键
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2>9) key2=0;
		onfoc(key2)
	}
}
    
document.onkeydown=keyDown
//document.captureEvents(Event.KEYDOWN)
//-->
</script>
</head>
<body leftMargin=0 topMargin=0 background="file:///usr/suit/newebox/image/music/music_top10.gif" bgcolor="#0a56d" onload="onfoc(0)">

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
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="79" height="65"></td>
		<td width="416" align=center valign=bottom class="style24w"><%=type2%></td>
		<td width="65"></td>
	</tr>
	<tr>
		<td height="33" colspan=3>&nbsp;</td>
		</tr>
	<tr>
	    <td height="307"></td>
	    <td valign="top" width=416>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" >
			<%
			for(int i = 0; i < item.length; i++) {
			%>
			<tr>
				<td height=28 id="<%=i%>" width="60%" class="style24w"><%=item[i]%></td>
				<td align=right width="40%" class="style24w"><%=item1[i]%></td>
			</tr>
			
			<%
			}
			%>
			</table></td>
		<td>&nbsp;</td>
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
</html>
