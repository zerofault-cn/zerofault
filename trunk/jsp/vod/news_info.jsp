<%@ taglib uri="oscache" prefix="cache" %>
<%@ page errorPage="error.jsp" %>
<%
String url_i=request.getParameter("url_i");
String type_id=request.getParameter("type_id");
String rss_source_url=request.getParameter("rss_source_url");
int y=java.lang.Integer.parseInt(request.getParameter("y"));
%>
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

<script language="javascript" type="text/javascript" src="file:///usr/suit/newebox/feedparser.js"></script>
<cache:cache time="1800" refresh="true">
<script language="javascript" type="text/javascript">
var feed=new FeedParser('<%=rss_source_url%>');
</script>
</cache:cache>	
<script language="JavaScript" type="text/JavaScript">
<!--
function keyPress(e){
	var keycode=e.which
	if (keycode==0)
       keycode=e.keyCode;
	var key1 = keycode -48
　	
	if(keycode==36)
	{
		location="news_submenu.jsp?url_i=<%=url_i%>&rss_type_id=<%=type_id%>";
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
document.onkeypress=keyPress

//-->
</script>

<style type="text/css">

#divScrollTextCont 
{
	position:absolute; 
	left:65px; 
	top:85px; 
	width:520px; 
	height:340px; 
	clip:rect(0px 520px 340px 0px); 
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
<body leftMargin=0 topMargin=0 background="file:///usr/suit/newebox/image/news/news_view.jpg" bgcolor="#0a56d" style="background-Attachment:fixed;">

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
	<table width=560 height=430 border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td width=30 height=28>&nbsp;</td>
		<td width=178>&nbsp;</td>
		<td width=345>&nbsp;</td>
		<td width="7">&nbsp;</td>
	</tr>
	<tr>
		<td height=33>&nbsp;</td>
		<td colspan=2 class=style24w>您的位置:【<script>document.write(feed.channel.title);</script>】--&gt;查看详细内容</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td height=5 colspan=4></td>
	</tr>
	<tr>
		<td></td>
		<td colspan=2>
		
<div id="divScrollTextCont">
	<div id="divText">
		<div class=style24b align=center>
			<script>document.write(feed.channel.item[<%=y%>].title+"<br><span class=style22b>发布日期："+feed.channel.lastBuildDate+"</span>");</script></div>
		<div class=style22b style="line-height:1.5em">
			<script>document.write(feed.channel.item[<%=y%>].description);</script></div>
	</div>
</div>
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
