<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>视频新闻内容</title>
<script language="JavaScript" type="text/JavaScript" src="locateCSS.js"></script>
<script language="JavaScript" type="text/JavaScript" src="functions.js"></script>
<script language="JavaScript" type="text/JavaScript">
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
	if(keycode==36)
	{
		location="news_title.html";
	}
}
document.onkeydown=keyDown

//-->
</script>
</head>
<body id="news_info">
<div id="topnavi">
<span class="topnavi">新闻频道：今日焦点</span>
</div>
<div id="mplayer">
<embed src="mms://192.168.0.100/060308085830_yujinjin_02.wmv" width="100%" height="100%" type="application/x-mplayer2"></embed>
</div>
<div id="news_info">
<p class="news_info">

</p>
</div>
</body>
</html>
