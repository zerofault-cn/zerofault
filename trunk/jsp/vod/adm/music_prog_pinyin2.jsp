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
int type_id=0;
String str_type_id=request.getParameter("type_id");
if(str_type_id!=null)
	type_id =java.lang.Integer.parseInt(str_type_id);
String othertype=request.getParameter("othertype");
String value=request.getParameter("value");
String sql1="";;
String sql2="";
ResultSet rs=null;
Opendb opendb = new Opendb();
StringReplace sr=new StringReplace();
String conv32 = "" + (char) 32;
GetServerIp getServerIp=new GetServerIp();

if(othertype!=null&&othertype.equals("pinyin"))
{
	String flet = value.substring(0,1);
	String elet = value.substring(1) + "zzzzzzzzz";
	sql1="select count(prog_id) from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and prog_acot>='" + flet + "' and prog_acot<='" + elet + "' and del_flag=1 order by prog_acot";
	sql2="select prog_path,prog_name from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and prog_acot>='" + flet + "' and prog_acot<='" + elet + "' and del_flag=1 order by prog_acot";
}
else if(othertype!=null&&othertype.equals("wordcount"))
{
	if(value.compareTo("5")>0)
	{
		sql1="select count(*) from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and prog_timespan>='"+value+"' and del_flag=1";
		sql2="select prog_path,prog_name from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and prog_timespan>='"+value+"' and del_flag=1 order by prog_size,binary prog_name";
	}
	else
	{
		sql1="select count(*) from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and prog_timespan='"+value+"' and del_flag=1";
		sql2="select prog_path,prog_name from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and prog_timespan='"+value+"' and del_flag=1 order by binary prog_name";
	}
}
else
{
	if(type_label==2)
	{
		sql1="select count(distinct prog_id) from singer_info,prog_info where prog_name is not null and prog_path is not null and prog_info.prog_kindsec=1026 and singer_info.type_chorus_id="+type_id+" and singer_info.singer_id=prog_info.publisher and prog_info.del_flag=1";
		sql2="select distinct prog_path,prog_name from singer_info,prog_info where prog_name is not null and prog_path is not null and prog_info.prog_kindsec=1026 and singer_info.type_chorus_id="+type_id+" and singer_info.singer_id=prog_info.publisher and prog_info.del_flag=1";
	}
	if(type_label==3)
	{
		sql1="select count(distinct prog_id) from singer_info,prog_info where prog_name is not null and prog_path is not null and prog_info.prog_kindsec=1026 and singer_info.type_other_id="+type_id+" and singer_info.singer_id=prog_info.publisher and prog_info.del_flag=1";
		sql2="select distinct prog_path,prog_name from singer_info,prog_info where prog_name is not null and prog_path is not null and prog_info.prog_kindsec=1026 and singer_info.type_other_id="+type_id+" and singer_info.singer_id=prog_info.publisher and prog_info.del_flag=1";
	}
}

int i=0;
int intPageSize=0;
int intRowCount=0;
int intPageCount=0;
int intPage=0;
String strPage=null;
intPageSize = 9;
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

rs = opendb.executeQuery(sql1);
rs.next();
intRowCount = rs.getInt(1);
rs = null;
String list="";
rs = opendb.executeQuery(sql2);
intPageCount = (intRowCount + intPageSize - 1) / intPageSize;
if(intPage > intPageCount && intPageCount > 0)	
	intPage = intPageCount;
if (intPage > 1) 
{
	for(i = 0; i < (intPage - 1) * intPageSize; i++) 
	{
		rs.next();
	}
}

String[] item = new String[intPageSize];
String prog_name="";
String prog_path="";
String prog_ip="";
int n = 0;
for(i = 0; i < intPageSize; i++)
{
	if(rs != null && rs.next()) 
	{
		prog_path=rs.getString(1).trim();
		prog_name=rs.getString(2).trim();
		if(prog_name.length()>18)
			prog_name=prog_name.substring(0,18);
		prog_path=sr.replace(prog_path, conv32, "%20");//转换空格为'%20'
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
	{
		item[i] = "";
	}
}
rs.beforeFirst();
prog_path="";
for(i=0;i<intRowCount;i++)//生成list
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
	else
		break;
}
opendb.dbclose();

%>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>无标题文档</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body leftMargin=0 topMargin=0 background="file:///usr/suit/newebox/image/music/music_othersonglist.jpg" bgcolor="#0a56d" onload="onfoc(0)">
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
  <!--DWLayoutDefaultTable-->
  <tr>
    <td width="27" height="75"></td>
    <td width=264></td>
    <td width="10"></td>
    <td width="238" align=right  valign=bottom>
		<table>
		<tr><td class=style22w>第<%=intPage%>页 共<%=intPageCount%>页</td></tr>
		<tr><td height=5></td></tr>
		</table></td>
    <td width="21" ></td>
    
  </tr>
  <tr>
    <td ></td>
    <td valign="top">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<%
		for(i = 0; i < item.length; i++) 
		{
			%>
		<tr id=<%=i%>>
			<td height=40 class=style24b>
			<%
			if(item[0].equals(""))
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
    <td></td>
    <td valign=top>
	
	</td>
   
    <td></td>
  </tr>
 

</table>
	<!--******************************************可视面积******************************************-->
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
	if(keycode==59) 
	{
		location="list://\"<%=list%>|\"";
	}
	if(keycode==36) location="music_typelist.jsp?type_label=<%=type_label%>";
	if(keycode==33) location="?type_label=<%=type_label%>&type_id=<%=type_id%>&othertype=<%=othertype%>&value=<%=value%>&page=<%=intPage - 1%>";
	if(keycode==34) location="?type_label=<%=type_label%>&type_id=<%=type_id%>&othertype=<%=othertype%>&value=<%=value%>&page=<%=intPage + 1%>";
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
