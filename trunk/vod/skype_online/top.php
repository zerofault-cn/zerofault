<html>
<head>
<title><?=$site_title?></title>
<link rel="stylesheet" href="style.css" type="text/css">
<meta http-equiv=content-type content="text/html; charset=gb2312">
<meta name="keywords" content="skype call center skycall EPN eCard 网络名片 电子名片 语音留言 自动答录 电子名片">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function MM_showHideLayers() { //v3.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}

//-->
</script>
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
</head>
<body background="image/minibg.gif" topmargin=0 style="background-position: center;background-repeat: no-repeat;background-attachment: fixed" onLoad="MM_preloadImages('image/top_navi_btn_1_over.gif','image/top_navi_btn_2_over.gif','image/top_navi_btn_3_over.gif','image/top_navi_btn_4_over.gif','image/top_navi_btn_5_over.gif','image/top_navi_btn_21_over.gif','image/top_navi_btn_22_over.gif')">
<center>
<a name=top></a>
<table width="770" border=0 cellpadding=0 cellspacing=0 bgcolor="#F4F8FF">
<tr>
	<td width=12 height="100%" background="image/border_left.gif"></td>
	<td align=center valign=top>
	<table width="100%" border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td align=center><img src="image/logo_top.gif" width=746></td>
	</tr>
	</table>
	<table width="100%" border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td align=right background="image/top_banner_bg.gif">
		<DIV ID="div1" STYLE="position:absolute; z-index:1; width:0px; visibility: visible; height:0px">
		<div id="product" style="position:absolute; z-index:1; width: 84px; visibility: hidden; top: 32px; left: 81px" onMouseOver="MM_showHideLayers('product','','show')" onMouseOut="MM_showHideLayers('product','','hide')"> 
		<table border=0 cellspacing=0 cellpadding=0 width="100%" bgcolor=#E5F4FF>
		<tr> 
			<td align=center>
			<a href="skymate.php" onMouseOver="MM_swapImage('btn21','','image/top_navi_btn_21_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="image/top_navi_btn_21.gif" name=btn21 border=0></a><br>
			<a href="ecard_intro.php" onMouseOver="MM_swapImage('btn22','','image/top_navi_btn_22_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="image/top_navi_btn_22.gif" name=btn22 border=0></a>			</td>
		</tr>
		</table>
		</div>
		</div>
		<a href="index.php" onMouseOver="MM_swapImage('btn1','','image/top_navi_btn_1_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="<?
		if(''==$page || $page=='index')
		{
			echo 'image/top_navi_btn_1_active.gif';
		}
		else
		{
			echo 'image/top_navi_btn_1.gif';
		}?>" name=btn1 border=0></a><img src="image/top_navi_sep.gif"><a href="skymate.php" onMouseOver="MM_swapImage('btn2','','image/top_navi_btn_2_over.gif',1);MM_showHideLayers('product','','show')" onMouseOut="MM_swapImgRestore();MM_showHideLayers('product','','hide')"><img src="<?
		if($page=='product')
		{
			echo 'image/top_navi_btn_2_active.gif';
		}
		else
		{
			echo 'image/top_navi_btn_2.gif';
		}?>" name=btn2 border=0></a><img src="image/top_navi_sep.gif"><a href="faq.php" onMouseOver="MM_swapImage('btn3','','image/top_navi_btn_3_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="<?
		if($page=='faq')
		{
			echo 'image/top_navi_btn_3_active.gif';
		}
		else
		{
			echo 'image/top_navi_btn_3.gif';
		}?>" name=btn3 border=0></a><img src="image/top_navi_sep.gif"><a href="community.php" onMouseOver="MM_swapImage('btn4','','image/top_navi_btn_4_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="<?
		if($page=='community')
		{
			echo 'image/top_navi_btn_4_active.gif';
		}
		else
		{
			echo 'image/top_navi_btn_4.gif';
		}?>" name=btn4 border=0></a><img src="image/top_navi_sep.gif"><a href="http://forum.skycall.cn/" onMouseOver="MM_swapImage('btn5','','image/top_navi_btn_5_over.gif',1)" onMouseOut="MM_swapImgRestore()" target=_blank><img src="<?
		if($page=='forum')
		{
			echo 'image/top_navi_btn_5_active.gif';
		}
		else
		{
			echo 'image/top_navi_btn_5.gif';
		}?>" name=btn5 border=0></a>
		</td>
	</tr>
	</table>
	</td>
	<td width=12 background="image/border_right.gif"></td>
</tr>
</table>
</center>