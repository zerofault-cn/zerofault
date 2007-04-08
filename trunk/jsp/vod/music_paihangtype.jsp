<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>模板</title>
<link rel="stylesheet" href="style.css" type="text/css">
<script language="JavaScript" type="text/JavaScript">


var key2=0;
function onfoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<td height=45 align=center bgcolor=#3366ff><img src="file:///usr/suit/newebox/image/ir001-2.png"><a class="style24w" ' + dat;
	document.links[n].focus();
}

function losefoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<td height=45 align=center><img src="file:///usr/suit/newebox/image/ir001-1.png"><a class="style24b" style="color:white" ' + dat;
}
function loc(url) {
 location=url;
}

function keyPress(e){
	var keycode=e.which
	if (keycode==0)
       keycode=e.keyCode;
	var key1 = keycode -48
　	var patern=/^[1-4]$/; 
	if (patern.exec(key1)) 
	{
		onfoc(key1-1);
		location = document.links[key1 - 1];
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
		if(key2<0) key2=3;
		onfoc(key2)
	}
	if(keycode==40)//光标右下键
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2>3) key2=0;
		onfoc(key2)
	}
}    
document.onkeydown=keyPress

//-->
</script>
</head>

<body leftMargin=0 topMargin=0 background="file:///usr/suit/newebox/image/music/music_othersonglist.jpg" bgcolor="#0a56d" onload="onfoc(0)">

<table width="630" border="0" cellpadding="0" cellspacing="0" height="460">
<tr>
	<td width=33 height=15>金;</td>
	<td width=560>&nbsp;</td>
	<td width=37 height="15">&nbsp;</td>
</tr>
<tr>
	<td height=430>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table width="100%" border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td width=26 height=75>&nbsp;</td>
		<td width="264">&nbsp;</td>
		<td width="270" align=right valign=bottom>
			<table border=0 cellpadding=0 cellspacing=0>
			<tr>
				<td class=style24w>【音乐殿堂排行榜】</td>
			</tr>
			<tr>
				<td height=2></td>
			</tr>
			</table></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<table width="100%" border=0 cellspacing=0 cellpadding=0>
			<tr>
				<td height=30></td>
			</tr>
			<tr id=0>
				<td height="45" align=center><img src="file:///usr/suit/newebox/image/ir001-1.png"><a class="style24b" style="color:white" href="music_paihang.jsp?type1=zhongwenliuxing">中文流行排行榜</a></td>
			</tr>
			<tr>
				<td height="27">&nbsp;</td>
			</tr>
			<tr id=1>
				<td height="45" align=center><img src="file:///usr/suit/newebox/image/ir001-1.png"><a class="style24b" style="color:white" href="music_paihang.jsp?type1=zhongwendianpo" >中文点播排行榜</a></td>
			</tr>
			<tr>
				<td height="27">&nbsp;</td>
			</tr>
			<tr id=2>
				<td height="45" align=center><img src="file:///usr/suit/newebox/image/ir001-1.png"><a class="style24b" style="color:white" href="music_paihang.jsp?type1=waiyuliuxing">外语流行排行榜</a></td>
			</tr>
			<tr>
				<td height="27">&nbsp;</td>
			</tr>
			<tr id=3>
				<td height="45" align=center><img src="file:///usr/suit/newebox/image/ir001-1.png"><a class="style24b" style="color:white" href="music_paihang.jsp?type1=waiyudianpo">外语点播排行榜</a></td>
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
</html>
