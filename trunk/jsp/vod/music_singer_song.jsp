<%@ page import="goldsoft.*,java.sql.*" %>
<%@ taglib uri="oscache" prefix="cache" %>
<%@ page errorPage="error.jsp" %>
<%
//Cookie cookies[]=request.getCookies();
String account="1";
String password="1";
//if(cookies==null)
//{
//	response.sendRedirect("login_1.jsp");
//}
//	account=cookies[1].getValue();
//	password=cookies[2].getValue();


int type_label =java.lang.Integer.parseInt(request.getParameter("type_label"));
int type_id =java.lang.Integer.parseInt(request.getParameter("type_id"));
String singer_id = request.getParameter("singer_id");
String fpage = request.getParameter("fpage");
int intPageSize=0;
int intRowCount=0;
int intPageCount=0;
int intPage=0;
String strPage="";
intPageSize = 8;
int list_max = 20;
int list_cur = 0;
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
StringReplace sr=new StringReplace();
GetServerIp getServerIp=new GetServerIp();
String sql1="select count(prog_id) from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and del_flag=1 and publisher="+singer_id;
ResultSet rs = opendb.executeQuery(sql1);
if(rs != null && rs.next()) {
	intRowCount = rs.getInt(1);
}
intPageCount = (intRowCount + intPageSize - 1) / intPageSize;
if(intPage > intPageCount && intPageCount > 0)
	intPage = intPageCount;
String photo = "", introduce = "",singer_name="",list="";
rs = null;
String sql2="select photo,introduce,singer_name from singer_info where photo is not null and introduce is not null and singer_name is not null and singer_name is not null and singer_id="+singer_id;
rs = opendb.executeQuery(sql2);
if(rs != null && rs.next()) {
	photo = rs.getString(1);
	introduce = rs.getString(2);
	singer_name=rs.getString(3);
}
String sql3="select prog_path,prog_name from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and del_flag=1 and publisher="+singer_id+" order by prog_id desc";
rs=opendb.executeQuery(sql3);
if(intPage > 1) {
	for(int i = 0; i < (intPage - 1) * intPageSize; i++)	{
		rs.next();
	}
}
String[] item = new String[intPageSize];
String prog_name="";
String prog_path = "";
String prog_ip="";
String conv32 = "" + (char) 32;
int n = 0;
for(int i = 0; i < intPageSize; i++) {
	if(rs != null && rs.next()) 
	{
		prog_path=rs.getString(1).trim();
		prog_name=rs.getString(2).trim();
		if(prog_name.length()>18)
			prog_name=prog_name.substring(0,18);
		prog_path=sr.replace(prog_path, conv32, "%20");
		prog_ip=getServerIp.getIpByPath(prog_path);
		/*****************************用darwin时的播放路径**********************************
		item[i] = "<a style=color:#ffffff href=lrtsp://"+prog_path+"?"+account+"&"+password+">&nbsp;" +prog_name+ "</a>";
		/*****************************用helix播MP4格式**************************************
		item[i] = "<a style=color:#ffffff href='ltsp://"+prog_ip+":555/"+prog_path+"'>&nbsp;" +prog_name+ "</a>";
		/*****************************用helix播WMV格式**************************************/
		item[i] = "<a style=color:#ffffff href='mms://"+prog_ip+"/"+prog_path+"'>&nbsp;" +prog_name+ "</a>";
		/**********************************************************************************/
		n++;
	}
	else 
		item[i] = "<a href=#></a>";
}
rs.beforeFirst();
prog_path="";
for(int i=0;i<intRowCount;i++)//生成list
{
	if(rs != null && rs.next())
	{
		if(list_cur < list_max) 
		{
			prog_path=rs.getString(1).trim();
			prog_ip=getServerIp.getIpByPath(prog_path);
			/*****************************用darwin时的播放路径****************************
			list=list+"|lrtsp://"+prog_path+"?"+account+"&"+password;
			/*****************************用helix播MP4格式********************************
			list=list+"|ltsp://"+prog_ip+":555/"+prog_path;
			/*****************************用helix播WMV格式********************************/
			list=list+"|mms://"+prog_ip+"/"+prog_path;
			/****************************************************************************/
			list_cur++;
		}
		else
			break;
	}
}
opendb.dbclose();

%>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>无标题文档</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body leftMargin=0 topMargin=0 background="file:///usr/suit/newebox/image/music/music_songlist.jpg" bgcolor="#0a56d" onload="onfoc(0)">
<table width="630" border="0" cellpadding="0" cellspacing="0" height="440">
<tr>
	<td width=33 height=15>金</td>
	<td width=560>&nbsp;</td>
	<td width=37 height="15">&nbsp;</td>
</tr>
<tr>
	<td height=400>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	    <td width="26" height="60">&nbsp;</td>
		<td width="264">&nbsp;</td>
		<td width="12"></td>
		<td width="258" valign="bottom">
			<table border=0 width="100%" height="100%" cellspacing=0 cellpadding=0>
			<tr>
				<td height="100%" class=style22w align=right valign=bottom>第<%=intPage%>页 共<%=intPageCount%>页</td>
			</tr>
			</table></td>
	</tr>
	<tr>
		<td colspan=4 height=10></td>
	</tr>
	<tr>
	    <td>&nbsp;</td>
	    <td valign="top">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<%
		for(int i = 0; i < item.length; i++) 
		{
			%>
		<tr id=<%=i%>>
			<td height=40 class=style24b>
			<%
			if(item[0].equals("<a href=#></a>"))
			{
				out.println("<a href=# class=style24w style=color:white>暂时没有歌曲</a>");
				n=i+1;
				break;
			}
			else
			{
				out.println(item[i]);
			}
			%></td>
		</tr>
		<%
		}
		%>
        </table></td>
		<td>&nbsp;</td>
		<td valign=top>
			<table width="100%" border=0 cellpadding=0 cellspacing=0>
			<tr>
				<td height=21 colspan=4></td>
			</tr>
			<tr>
				<td width="22">&nbsp;</td>
				<td width="93" height=122><img src="/photo/<%=photo%>" width="93" height="122"></td>
				<td width=20>&nbsp;</td>
				<td class=style24w align=center><%=singer_name%></td>
			</tr>
			<tr>
				<td height=26 colspan=4>&nbsp;</td>
			</tr>
			<tr>
				<td class=style22w colspan=4>
				<marquee direction="up" loop=-1 behavior="scroll" height="154" scrolldelay="50" scrollamount="1" border="0">
				<%=introduce%>
				</marquee>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
	<!--********************************************* 可视面积 ***********************************************-->
	</td>
	<td></td>
</tr>

</table>
</body>
<script language="JavaScript" type="text/JavaScript">
<!--
var key2=0;
function onfoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("<a "));
	t2.innerHTML = '<td height=40 class=style24w bgcolor=#0066ff> ' + dat;
	document.links[n].focus();
}
function losefoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("<a "));
	t2.innerHTML = '<td height=40 class=style24b>' + dat;
}

function loc(url) {
 location=url;
}
function keyDown(e){
	var keycode=e.which
	var key1 = keycode - 48
	var realkey=String.fromCharCode(e.which)
	var patern=/^[1-<%=n%>]$/; 
	if (patern.exec(key1)) {
		   if(key1 == key2 + 1) onfoc(key1 - 1);
		   else {
		   	losefoc(key2);
		   	onfoc(key1 - 1)
		   	key2 = key1 -1;
		   }
		   location = document.links[key2];
	}
	if(keycode==13||keycode==70)
	{
		location = document.links[key2];
	}
	if(keycode==59) location="list://\"<%=list%>|\"";
	if(keycode==36) location="music_singer_list.jsp?type_label=<%=type_label%>&type_id=<%=type_id%>&page=<%=fpage%>";
	if(keycode==33) location="?type_label=<%=type_label%>&type_id=<%=type_id%>&fpage=<%=fpage%>&singer_id=<%=singer_id%>&page=<%=intPage - 1%>";
	if(keycode==34) location="?type_label=<%=type_label%>&type_id=<%=type_id%>&fpage=<%=fpage%>&singer_id=<%=singer_id%>&page=<%=intPage + 1%>";
	if(keycode==38)
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0) key2=<%=n-1%>;
			onfoc(key2)
	}
	if(keycode==40)
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2><%=n-1%>) key2=0;
			onfoc(key2)
	}
}
document.onkeydown=keyDown
//-->
</script>
</html>
