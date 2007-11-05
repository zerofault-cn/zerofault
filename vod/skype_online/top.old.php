<html>
<head>
<title><?=$site_title?></title>
<link rel="stylesheet" href="style.css" type="text/css">
<meta http-equiv=content-type content="text/html; charset=gb2312">
<meta name="keywords" content="skype call center skycall EPN eCard 网络名片 电子名片 语音留言 自动答录 电子名片">
</head>
<script language="javascript" src="realtime.js"></script>
<script language="JavaScript">
function msg_send()
{
  showMyModalDialog('http://localhost:8088/vod/skype_online/eCard.php?s=goldsoft-zerofault', 680, 340);
}
function showMyModalDialog(url, width, height)
{
  showModalDialog(url, '', 'dialogWidth:' + width + 'px;dialogHeight:' + height + 'px;center:yes;status:no;scroll:no;help:no');
}
</script>
<script language=JavaScript>
var imgUrl=new Array();
var imgtext=new Array();
var adNum=0;//当前
imgUrl[1]="image/product/skymate1.jpg";
imgtext[1]="SkyMate嵌入web主页";
imgUrl[2]="image/product/skymate2.jpg";
imgtext[2]="SkyMate录音页面";
imgUrl[3]="image/product/skymate3.jpg";
imgtext[3]="SkyMate设置页面";
imgUrl[4]="image/product/skymate4.jpg";
imgtext[4]="SkyMate版权信息";
function playTran()
{
	if (document.all)
	{
		imgInit.filters.revealTrans.play();
	}
}
var key=0;
function nextAd()
{
	if(adNum<imgUrl.length-1)
	{
		adNum++;
	}
	else
	{
		adNum=1;
	}
	if(key==0)
	{
		key=1;
	}
	else if(document.all)
	{
		imgInit.filters.revealTrans.Transition=26;
		imgInit.filters.revealTrans.apply();
		playTran();
	}
	document.images.imgInit.src=imgUrl[adNum];
	focustext.innerHTML=imgtext[adNum];
	theTimer=setTimeout("nextAd()", 5000);
}
</script>
<body topmargin=0 background="image/minibg.gif" style="background-position: center;background-repeat: no-repeat;background-attachment: fixed">
<center>
<table width="760" border=0 cellpadding=0 cellspacing=0>
<tr>
	<td 
	<td align=center><a name=top></a>
	<table width="100%" border=0 cellspacing=0 cellpadding=0 class=outertable>
	<tr>
		<td align=center width="14%">
			
		</td>
		<td>
			<table width="100%" border=0 cellspacing=0 cellpadding=0>
			<tr>
				<td><a href="index.php"><img src="image/skype.gif" height=40 border=0></td>
			</tr>
			<tr>
				<td><span class=indexlogo>SkyCall欢迎您</span></td>
			</tr>
			</table>
		</td>
		<td align=right>
		<!-- 互通易[eclickchat.com] 实时交谈帮助系统网站代码 开始 -->
<div id="lc_img_1"></div>
<script src="http://free.eclickchat.net/client/visit/visit_main_js?dHlwZSUx&Y29tcGFueSUxMzc"></script>
<!-- 互通易[eclickchat.com] 实时交谈帮助系统网站代码 结束 -->
		<?//=contectUs('SkyCall客户服务')?>
		</td>
	</tr>
	</table>
	<br>
	<!-- 顶部导航 -->
	<table width="100%" border=0 cellspacing=0 cellpadding=0>
	<tr class=topNavigation>
		<td align=center <?if(''==$page || $page=='index')echo 'class="topSelected"'?>><a href="index.php">首页</a></td>
		<td align=center <?if($page=='SkyMate')echo 'class="topSelected"'?>><a href="SkyMate_intro.php">SkyMate</a></td>
		<td align=center <?if($page=='eCard')echo 'class="topSelected"'?>><a href="eCard_intro.php">eCard</a></td>
		<td align=center <?if($page=='faq')echo 'class="topSelected"'?>><a href="faq.php">FAQ</a></td>
		<td align=center <?if($page=='community')echo 'class="topSelected"'?>><a href="community.php">社区</a></td>
		<td align=center <?if($page=='forum')echo 'class="topSelected"'?>><a href="http://forum.skycall.cn" target=_blank>论坛</a></td>
	</tr>
	<tr>
		<td colspan=6 height=2 bgcolor=#a5bede></td>
	</tr>
	</table>
	<br>
	