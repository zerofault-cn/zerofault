<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>����</title>
<link rel="stylesheet" href="style.css" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
var key2=0;
function onfoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<td height="40" bgcolor=#0066ff><a class="style24w" style="color:white" ' + dat;
	document.links[n].focus();
}

function losefoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<td height="40"><a class="style24b" style="color:white" ' + dat;
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
	var patern=/^[1-6]$/; 
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

	if(keycode==36)//HOME��
	{
		location="menu_1.jsp";
	}
	if(keycode==38)//������ϼ�
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0) key2=5;
		onfoc(key2)
	}
	if(keycode==40)//������¼�
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2>5) key2=0;
		onfoc(key2)
	}
}    
document.onkeypress=keyPress
//onfoc(0);
//-->
</script>
</head>

<body leftMargin=0 topMargin=0 background="file:///usr/suit/newebox/image/music/music_bg.jpg" bgcolor="#0a56d" onload="onfoc(0)">

<table width="630" border="0" cellpadding="0" cellspacing="0" height="460">
<tr>
	<td width=33 height=15>&nbsp;</td>
	<td width=560>&nbsp;</td>
	<td width=37 height="15">&nbsp;</td>
</tr>
<tr>
	<td height=430>&nbsp;</td>
	<td valign=top>
	<!--************************************ �������:Ƕ������ *************************************************-->
	<table width=560 height=430 border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width=26 height=100></td>
		<td width=239></td>
		<td width=30></td>
		<td width=270></td>
		</td width=15></td>
	</tr>
	<tr>
		<td></td>
		<td valign=top>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr id=0>
				<td height=40><a class=style24b style="color:white" href="music_typelist.jsp?type_label=1">��.�������ֶӷ���</a></td>
			</tr>
			<tr id=1>
				<td height=40><a class=style24b style="color:white" href="music_typelist.jsp?type_label=2">��.���ݳ���ʽ����</a></td>
			</tr>
			<tr id=2>
				<td height=40><a class=style24b style="color:white" href="music_typelist.jsp?type_label=4">��.��������������</a></td>
			</tr>
			<tr id=3>
				<td height=40><a class=style24b style="color:white" href="music_typelist.jsp?type_label=5">��.����������ĸ����</a></td>
			</tr>
			<tr id=4>
				<td height=40><a class=style24b style="color:white" href="music_typelist.jsp?type_label=3">��.�������ַ���</a></td>
			</tr>
			<tr id=5>
				<td height=40><a class=style24b style="color:white" href="music_paihangtype.jsp">��.�����������а�</a></td>
			</tr>
			</table>
		</td>
		<td></td>
		<td valign=top>
			<br>
			<br>
			<table width=270 height=180 border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td><embed src="file:///usr/suit/newebox/list/list__music1" width="270" height="180" type="application/x-mplayer2"></embed></td>
			</tr>
			</table>
		</td>
		<td></td>
	</tr>
	<tr>
		<td colspan=5></td>
	</tr>
	</table>


	<!--********************************************* ������� ***********************************************-->
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
