<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>信息服务_首页</title>
<script language="JavaScript" type="text/JavaScript" src="locateCSS.js"></script>
</head>
<body id="game_index" onload="onfoc(0)">
<div id="topnavi">
<span class="topnavi">游戏娱乐</span>
</div>
<div id="game_index_menu">
<table border=0 width="100%" height="100%" cellspacing=0 cellpadding=0>
<tr>
	<td id="0" class="game_index_menu"><a style="color:#b6dbf8" href="game://raptor">1.本地游戏</a></td>
</tr>
<tr>
	<td id="1" class="game_index_menu"><a style="color:#b6dbf8" href="game://landlord">2.QQ网络游戏</a></td>
</tr>
<tr>
	<td id="2" class="game_index_menu"><a style="color:#b6dbf8" href="flash_game.html">3.FLASH游戏</a></td>
</tr>
<tr>
	<td id="3" class="game_index_menu"><a style="color:#b6dbf8" href="flash_mtv.html">4.FLASH MTV</a></td>
</tr>
</table>
</div>
</body>
<script language="JavaScript" type="text/JavaScript" src="functions.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function onfoc(n) {
	document.getElementById(n).style.backgroundImage="url(src_"+src_width+"/image/game/bar1.gif)";
	td=document.getElementById(n);
	dat =td.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	td.innerHTML = '<a style="color:#ffffff" ' + dat;
	document.links[n].focus();
}

function losefoc(n) {
	document.getElementById(n).style.backgroundImage="";
	td=document.getElementById(n);
	dat =td.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	td.innerHTML = '<a style="color:#b6dbf8" ' + dat;
}
function keyDown(e)
{
	if (ie)
	{
		var keycode=event.keyCode; 
	}
	else
	{
		var keycode=e.which;
	}
	var key1 = keycode -48;
	var patern=/^[1-link_count]$/; 
	if (patern.exec(key1)) 
	{
		if(key1 == key2 + 1) 
		{
			onfoc(key1-1);
		}
		else
		{
			losefoc(key2);
			onfoc(key1-1)
			key2=key1-1;
		}
		location=document.links[key2];
	}
	if(keycode==36)//HOME键
	{
		location="index.html";
	}
	if(keycode==37 || keycode==38)//光标左上键
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0)
		{
			key2=link_count-1;
		}
		onfoc(key2)
	}
	if(keycode==39 || keycode==40)//光标右下键
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2>link_count-1)
		{
			key2=0;
		}
		onfoc(key2)
	}
}
document.onkeydown=keyDown
//-->
</script>
</html>
