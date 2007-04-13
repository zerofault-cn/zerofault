<?
$id=$_REQUEST['id'];
$offset=$_REQUEST["offset"];
include "../include/db_connect.php";
include "color.inc.php";
include "../include/rss_parser.php";
$sql1="select rss_source_url,prefetch from rss_source where id='".$id."'";
$result1=$db->sql_query($sql1);
$rss_source_url=$db->sql_fetchfield(0,0,$result1);
$prefetch=$db->sql_fetchfield(1,0,$result1);
if($prefetch==1)//判断是否已预取
{
	$local_rss_tmp='../rss_tmp/'.eregi_replace("([?=&]+)","",basename($rss_source_url));
	if(file_exists($local_rss_tmp))
	{
		$rss_source_url=$local_rss_tmp;//取本地暂存的xml文件
	}
}
readXML($rss_source_url);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>模板</title>
<link rel="stylesheet" href="style.css" type="text/css">
<style>
img
{
	width:350px;
	
}
</style>

<script language="JavaScript" type="text/JavaScript">
<!--
if(document.all)
{
	var ie=1;
}
else
{
	var ie=0;
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
	var key1 = keycode -48
　	if(keycode==36)
	{
		window.history.go(-1);
	}
	if(keycode==38)
	{
		scroll(-20);
	}
	if(keycode==40)
	{
		scroll(20);
	}
	if(keycode==33)
	{
		scroll(-200);
	}
	if(keycode==34)
	{
		scroll(200);
	}
	
}    
document.onkeydown=keyDown

//-->
</script>

<style type="text/css">

#divScrollTextCont 
{
	position:absolute; 
	left:90px; 
	top:100px; 
	width:650px; 
	height:400px; 
	clip:rect(0px 650px 400px 0px); 
	overflow:hidden; 
	visibility:hidden;
}
#divText
{
	position:absolute; 
	left:0px; 
	top:0px;
} 
</style>
<script language="JavaScript" type="text/javascript">
function lib_bwcheck(){ //Browsercheck (needed)
	this.ver=navigator.appVersion
	this.agent=navigator.userAgent
	this.dom=document.getElementById?1:0
	this.opera5=this.agent.indexOf("Opera 5")>-1
	this.ie5=(this.ver.indexOf("MSIE 5")>-1 && this.dom && !this.opera5)?1:0; 
	this.ie6=(this.ver.indexOf("MSIE 6")>-1 && this.dom && !this.opera5)?1:0;
	this.ie4=(document.all && !this.dom && !this.opera5)?1:0;
	this.ie=this.ie4||this.ie5||this.ie6
	this.mac=this.agent.indexOf("Mac")>-1
	this.ns6=(this.dom && parseInt(this.ver) >= 5) ?1:0; 
	this.ns4=(document.layers && !this.dom)?1:0;
	this.bw=(this.ie6 || this.ie5 || this.ie4 || this.ns4 || this.ns6 || this.opera5)
	return this
}
var bw=new lib_bwcheck()


/*****************

You set the width and height of the divs inside the style tag, you only have to
change the divScrollTextCont, Remember to set the clip the same as the width and height.
You can remove the divUp and divDown layers if you want. 
This script should also work if you make the divScrollTextCont position:relative.
Then you should be able to place this inside a table or something. Just remember
that Netscape crash very easily with relative positioned divs and tables.

Updated with a fix for error if moving over layer before pageload.

****************/


//If you want it to move faster you can set this lower, it's the timeout:
var speed = 30

//Sets variables to keep track of what's happening
var loop, timer

//Object constructor
function makeObj(obj,nest){
    nest=(!nest) ? "":'document.'+nest+'.'
	this.el=bw.dom?document.getElementById(obj):bw.ie4?document.all[obj]:bw.ns4?eval(nest+'document.'+obj):0;
  	this.css=bw.dom?document.getElementById(obj).style:bw.ie4?document.all[obj].style:bw.ns4?eval(nest+'document.'+obj):0;
	this.scrollHeight=bw.ns4?this.css.document.height:this.el.offsetHeight
	this.clipHeight=bw.ns4?this.css.clip.height:this.el.offsetHeight
	this.up=goUp;this.down=goDown;
	this.moveIt=moveIt; this.x=0; this.y=0;
    this.obj = obj + "Object"
    eval(this.obj + "=this")
    return this
}

// A unit of measure that will be added when setting the position of a layer.
var px = bw.ns4||window.opera?"":"px";

function moveIt(x,y){
	this.x = x
	this.y = y
	this.css.left = this.x+px
	this.css.top = this.y+px
}

//Makes the object go up
function goDown(move){
	if (this.y>-this.scrollHeight+oCont.clipHeight){
		this.moveIt(0,this.y-move)
			if (loop) setTimeout(this.obj+".down("+move+")",speed)
	}
}
//Makes the object go down
function goUp(move){
	if (this.y<0){
		this.moveIt(0,this.y-move)
		if (loop) setTimeout(this.obj+".up("+move+")",speed)
	}
}

//Calls the scrolling functions. Also checks whether the page is loaded or not.
function scroll(speed){
	if (scrolltextLoaded){
		loop = false;//控制自动滚动还是手动滚动
		if (speed>0) oScroll.down(speed)
		else oScroll.up(speed)
	}
}

//Stops the scrolling (called on mouseout)
function noScroll(){
	loop = false
	if (timer) clearTimeout(timer)
}

//Makes the object
var scrolltextLoaded = false
function scrolltextInit(){
	oCont = new makeObj('divScrollTextCont')
	oScroll = new makeObj('divText','divScrollTextCont')
	oScroll.moveIt(0,0)
	oCont.css.visibility = "visible"
	scrolltextLoaded = true
}
//Call the init on page load if the browser is ok...
if (bw.bw) 
	onload = scrolltextInit
</script>

</head>
<body leftMargin=0 topMargin=0 background="image/news/news_bg.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;">
<div id="divScrollTextCont">
	<div id="divText">
		<div class=style32w align=center style="line-height:1.5em">
			<?=$newsArray[$offset+$i]['title']?>
			<br><span class=style30w>发布日期：<?=$newsArray[$offset+$i]['pubDate']==''?$channelArray['pubDate']:$newsArray[$offset+$i]['pubDate']?></span>
		</div>
		<div class=style32w style="line-height:1.5em">
			<?=$newsArray[$offset+$i]['description']?>
		</div>
	</div>
</div>
<table width="800" border="0" cellpadding="0" cellspacing="0" height="590">
<tr>
	<td width=20 height=10></td>
	<td width=760><?include "top.php";?></td>
	<td width=20>&nbsp;</td>
</tr>
<tr>
	<td height=570>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table width="100%" border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td width=30 height=20>&nbsp;</td>
		<td width=700>&nbsp;</td>
		<td width="30">&nbsp;</td>
	</tr>
	<tr>
		<td height=41>&nbsp;</td>
		<td colspan=2 class=style32w style="color:#c5f300"><?=$channelArray['title']?></td>
		<td></td>
	</tr>
	</table>
<!--********************************************* 可视面积 ***********************************************-->
	</td>
	<td valign=bottom>
	<table width="100%" height="350" border=0 cellpadding=0 cellspacing=0 class=style22w>
	<tr>
		<td height="33%" align=center style="cursor:hand" onMouseDown="scroll(-200)" onMouseOver="this.style.backgroundColor='<?=$news_selectbar?>',scroll(-20)" onMouseOut="this.style.backgroundColor=''">上</td>
	</tr>
	<tr height="33%">
		<td height="33%" align=center style="cursor:hand" onMouseOver="this.style.backgroundColor='<?=$news_selectbar?>'" onMouseOut="this.style.backgroundColor=''" onclick="javascript:window.history.go(-1);">返<br>回</td>
	</tr>
	<tr>
		<td height="34%" align=center style="cursor:hand" onMouseDown="scroll(200)" onMouseOver="this.style.backgroundColor='<?=$news_selectbar?>',scroll(20)" onMouseOut="this.style.backgroundColor=''">下</td>
	</tr>
	</table>
	</td>
</tr>
</table>
</body>
</html>