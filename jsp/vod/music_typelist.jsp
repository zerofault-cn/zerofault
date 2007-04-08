<%@ page import="goldsoft.*,java.sql.*" %>
<%@ taglib uri="oscache" prefix="cache" %>
<%@ page errorPage="error.jsp" %>
<%
int type_label=java.lang.Integer.parseInt(request.getParameter("type_label"));
String[] item = new String[7]; 
String[] item1 = new String[7];
int i=0;
int rowcount=0;
%>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>分类列表</title>
<link rel="stylesheet" href="style.css" type="text/css">

</head>

<body leftMargin=0 topMargin=0 background="file:///usr/suit/newebox/image/music/music_typelist.jpg" bgcolor="#0a56d" onload="onfoc(0)">
<table width="630" border="0" cellpadding="0" cellspacing="0" height="460">
<tr>
	<td width=33 height=15>&nbsp;</td>
	<td width=560>&nbsp;</td>
	<td width=37 height="15">&nbsp;</td>
</tr>
<tr>
	<td height=430>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table width="560" border="0" cellpadding="0" cellspacing="0">
	<tr>
	    <td width="26" height="78">&nbsp;</td>
	    <td width="210">&nbsp;</td>
		<td width=20></td>
	    <td width="294">&nbsp;</td>
		<td width=10></td>
	</tr>
	<tr>
	    <td >&nbsp;</td>
	    <td valign="top">
			<table width="100%" border="0" cellpadding="0" cellspacing="1">
			<%
			Opendb opendb = new Opendb();
			if(type_label==1||type_label==2)
			{
				ResultSet rs=opendb.executeQuery("select type_id,type_name from singer_type where type_label="+type_label+" and type_id!=0 order by type_id");
				while(rs!=null&&rs.next())
				{
					%>
					<tr id=<%=i%>>
						<td height="48">&nbsp;&nbsp;&nbsp;<img src="file:///usr/suit/newebox/image/ir003-1.png"><a class="style24b" style="color:white" href="music_singer_list.jsp?type_label=<%=type_label%>&type_id=<%=rs.getInt(1)%>"><%=rs.getString(2).trim()%></a></td>
					</tr>
					<%
				i++;
				}
				rowcount=i;
			}
			else if(type_label==3)
			{
				ResultSet rs=opendb.executeQuery("select type_id,type_name from singer_type where type_label="+type_label+" and type_id!=0 order by type_id");
				while(rs!=null&&rs.next())
				{
					%>
					<tr id=<%=i%>>
						<td height="48">&nbsp;&nbsp;&nbsp;<img src="file:///usr/suit/newebox/image/ir003-1.png"><a class="style24b" style="color:white" href="music_other_song.jsp?type_label=<%=type_label%>&type_id=<%=rs.getInt(1)%>"><%=rs.getString(2).trim()%></a></td>
					</tr>
					<%
				i++;
				}
				rowcount=i;
			}
			else
			{
				if(type_label==4)
				{
					item[0]="字数为一";
					item[1]="字数为二";
					item[2]="字数为三";
					item[3]="字数为四";
					item[4]="字数为五";
					item[5]="五字以上";
					item1[0]="music_other_song.jsp?type_label="+type_label+"&othertype=wordcount&value=1";
					item1[1]="music_other_song.jsp?type_label="+type_label+"&othertype=wordcount&value=2";
					item1[2]="music_other_song.jsp?type_label="+type_label+"&othertype=wordcount&value=3";
					item1[3]="music_other_song.jsp?type_label="+type_label+"&othertype=wordcount&value=4";
					item1[4]="music_other_song.jsp?type_label="+type_label+"&othertype=wordcount&value=5";
					item1[5]="music_other_song.jsp?type_label="+type_label+"&othertype=wordcount&value=6";
					rowcount=6;
				}
				if (type_label==5)
				{
					item[0]="首字母A-D";
					item[1]="首字母E-H";
					item[2]="首字母I-L";
					item[3]="首字母M-P";
					item[4]="首字母Q-U";
					item[5]="首字母W-Z";
					item1[0]="music_other_song.jsp?type_label="+type_label+"&othertype=pinyin&value=ad";
					item1[1]="music_other_song.jsp?type_label="+type_label+"&othertype=pinyin&value=eh";
					item1[2]="music_other_song.jsp?type_label="+type_label+"&othertype=pinyin&value=il";
					item1[3]="music_other_song.jsp?type_label="+type_label+"&othertype=pinyin&value=mp";
					item1[4]="music_other_song.jsp?type_label="+type_label+"&othertype=pinyin&value=qu";
					item1[5]="music_other_song.jsp?type_label="+type_label+"&othertype=pinyin&value=wz";
					rowcount=6;
				}
				for(i = 0; i <rowcount; i++) 
				{
					%>
					<tr id=<%=i%>>
						<td height="48">&nbsp;&nbsp;&nbsp;<img src="file:///usr/suit/newebox/image/ir003-1.png"><a class="style24b" style="color:white" href="<%=item1[i]%>"><%=item[i]%></a></td>
					</tr>
					<%
				}
			}
			opendb.dbclose();
			%>
			
			</table></td>
		<td>&nbsp;</td>
		<td>
			<br>
			<table width=280 height=210 border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td><embed src="file:///usr/suit/newebox/list/list__music2" width="280" height="210" type="application/x-mplayer2"></embed></td>
			</tr>
			</table>
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
<script language="JavaScript" type="text/JavaScript">
<!--
var key2=0;
function onfoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<td height="48" bgcolor=#3366ff>&nbsp;&nbsp;&nbsp;<img src="file:///usr/suit/newebox/image/ir003-2.png"><a class="style24w" ' + dat;
	document.links[n].focus();
}

function losefoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<td height="48">&nbsp;&nbsp;&nbsp;<img src="file:///usr/suit/newebox/image/ir003-1.png"><a class="style24b" style="color:white" ' + dat;
}

function loc(url) {
 location=url;
}

function keyPress(e)
{
	var keycode=e.which
	if (keycode==0)
       keycode=e.keyCode;
	var key1 = keycode -48;
	var patern=/^[1-<%=rowcount%>]$/; 
	if (patern.exec(key1)) {
		if(key1 == key2 + 1) 
			onfoc(key1 - 1);
		else{
			losefoc(key2);
			onfoc(key1 - 1)
			key2 = key1 -1;
		}
		setTimeout("loc(document.links[key2])",200);
	}
	if(keycode==13)
	{
		setTimeout("loc(document.links[key2])",200);
	}

	if(keycode==36)//HOME键
	{
		location="music_index.jsp";
	}
	if(keycode==38)//光标左上键
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0) key2=<%=rowcount%>-1;
		onfoc(key2)
	}
	if(keycode==40)//光标右下键
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2><%=rowcount%>-1) key2=0;
		onfoc(key2)
	}
}    
document.onkeypress=keyPress
//onfoc(0);
//-->
</script>
</html>
