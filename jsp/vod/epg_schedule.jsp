<%@ page import="goldsoft.*,java.sql.*,java.util.*" %>
<%@ taglib uri="oscache" prefix="cache" %>
<%@ page errorPage="error.jsp" %>
<%
String type = request.getParameter("type");
String spage=request.getParameter("spage");
String num=request.getParameter("num");
String weekday[]=new String [7];
weekday[0]="星期一";
weekday[1]="星期二";
weekday[2]="星期三";
weekday[3]="星期四";
weekday[4]="星期五";
weekday[5]="星期六";
weekday[6]="星期天";
Opendb opendb = new Opendb();
StringReplace sr = new StringReplace();
ResultSet rs =null;
String sql1="select station,path from epg_station where num='"+num+"'";
rs = opendb.executeQuery(sql1);
String station="";
String path="";
if (rs != null && rs.next()) 
{
	station=rs.getString(1).trim();
	path=rs.getString(2).trim();
}
int week=0;
Calendar cal = Calendar.getInstance();
int nowhour=0;
nowhour=cal.get(cal.HOUR);
String weekstr = request.getParameter("week");
if(weekstr== null) 
{
	week = cal.get(cal.DAY_OF_WEEK) - 1;//初始化设置为当天周次
	if(week == 0)
		week = 7;
}
else
{
	week=java.lang.Integer.parseInt(weekstr);
}
%>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>节目单</title>
<link rel="stylesheet" href="style.css" type="text/css">

<script language="JavaScript" type="text/JavaScript">
function onfoc(n)
{
	t1 = document.getElementById(n);
	dat = t1.innerHTML;
	dat = dat.substring(0,dat.indexOf("</td>"));
	dat = dat.substring(dat.lastIndexOf(">") + 1);
	t1.innerHTML = '<td height=40 align=center class=style24b bgcolor=green>' + dat + '</td>';
	
}

var week=<%=week%>;
function keyPress(e)
{
	var keycode=e.which;
	if (keycode==0)
		keycode=e.keyCode;
	var key1=keycode-48;
	if(keycode==102)
	{
		location="<%=path%>";
	}
	if(keycode==38)
	{
		week=week-1;
		if(week<1)
			week=1;
		location = "?type=<%=type%>&spage=<%=spage%>&num=<%=num%>&week="+week;
	}
	if(keycode==40)
	{
		week=week+1;
		if(week>7)
			week=7;
		location = "?type=<%=type%>&spage=<%=spage%>&num=<%=num%>&week="+week;
	}
	var patern=/^[1-7]$/; 
	if(patern.exec(key1)) 
	{
		location = "?type=<%=type%>&spage=<%=spage%>&num=<%=num%>&week="+key1;
	}
	if(keycode==36)
	{
		location ="epg_station.jsp?type=<%=type%>&page=<%=spage%>&num=<%=num%>";
	}
}    

document.onkeypress=keyPress
</script>

</head>

<body leftMargin=0 topMargin=0 background="file:///usr/suit/newebox/image/bg/<%=type%>2.jpg" bgcolor="#0a56d" onload="onfoc(<%=week%>)">
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
		<td width="38" height="117">&nbsp;</td>
		<td width="118">&nbsp;</td>
		<td width="16">&nbsp;</td>
		<td width="365">&nbsp;</td>
		<td width="23">&nbsp;</td>
	</tr>
	<tr>
		<td></td>
		<td valign="top">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr id=1>
			<td height=40 align=center class=style24w>星期一</td>
		</tr>
		<tr id=2>
			<td height=40 align=center class=style24w>星期二</td>
		</tr>
		<tr id=3>
			<td height=40 align=center class=style24w>星期三</td>
		</tr>
		<tr id=4>
			<td height=40 align=center class=style24w>星期四</td>
		</tr>
		<tr id=5>
			<td height=40 align=center class=style24w>星期五</td>
		</tr>
		<tr id=6>
			<td height=40 align=center class=style24w>星期六</td>
		</tr>
		<tr id=7>
			<td height=40 align=center class=style24w>星期日</td>
		</tr>
        </table></td>
        <td></td>
        <td align=center class="style24w">
		<%
		String program="";
		String month="";
		String day="";
		String hour="";
		String minute="";
		rs=null;
		String sql2="select program from epg_schedule where num='"+num+"' and weekday='"+week+"' and program!=''";
		rs=opendb.executeQuery(sql2);
		if(rs!=null&&rs.next())
		{
			%>
			<marquee direction="up" loop=-1 behavior="scroll" dataformatas="html" width="365" height="260" scrolldelay="60" scrollamount="1" border="1">
			<table  width="100%" border=0 class="style22w">
			<caption class="style24w">《<%=station%>》 <%=weekday[week-1]%> 节目单&nbsp;</caption>
			<tr>
				<td colspan=2><hr size="0.5" width="80%"></td>
			</tr>
            <tr>
				<td style="line-height:1.5em"><%=rs.getString("program")%></td>
			</tr>
			<tr>
				<td colspan=2><hr size="0.5" width="80%"></td>
			</tr>
			</table>
			</marquee>
			<%
		}
		else
		{
			out.println("暂时没有节目单");
		}
		%>
		</td>
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
</html>
<%
opendb.dbclose();
%>