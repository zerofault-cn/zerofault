<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN" xml:lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="http://www.bokee.com/favicon.ico" type="image/x-icon" />
<meta name="description" content="博客网，www.bokee.com,最具影响力中文网站之一，免费提供专业博客托管服务（BSP），现拥有博客公社、移动博客、图片博客、视频博客、教师博客、学生博客、博采、播客和RSS博览等多个应用版块。" />
<meta name="keywords" content="blog,weblog,blogger,bokee.com,www.bokee.com,博客中国,博客网,中国博客,博客,博采,我的博客,博客托管,图片博客,移动博客,群体博客,博客通,SNS,社会网络,博客动力,博客公社,教师博客,学生博客,IT,方兴东,微软问题,科技,新知,生活,社会软件,IT业界,互联网实验室,新媒体,博客研究,podcast,播客,标签,tag,BSP" />
<meta name="copyright" content="www.bokee.com,博客网,版权所有" />
<meta name="author" content="www.bokee.com,博客网" />
<meta name="robots" content="all" />
<title><?php
echo $_obj['title'];
?>
</title>
<style type="text/css">
<!--
html {
width:100%;
}
body, div {
font-size:12px; font-family:"Verdana" "宋体"; line-height: 150%; text-align: center; margin:auto;
} 
a {
color:#0531F2; text-decoration:none;}
a:hover {
color:#f00; text-decoration:underline;}
input{ 
width: 106px; border: 1px solid #7F9DB9; background: White;}
img{	
border: 0px;}
ul{ 
margin: 5px 0px 5px 0px!important;margin: 5px 0px 5px 30px;}
li{
font-size: 12px;	text-align: left;}
#main{
width: 760px;	text-align: center;}
/* 顶部辅助导航 */
#top{
	width: 760px;
	height: 52px;
	text-align: left;
}
#navigation{
   width: 680px;
	margin-top: -30px!important;margin-top: -30px;
	margin-left: 100px!important;margin-left: 80px;
}
.black{
	font-size:12px;
	color: Black;
}
#banner{
	width: 760px;
	height: 62px;
}
#mid{
	width:760px;
	margin-top: 5px;
	margin-bottom: 5px;
}
#midleft{
   float: left;
	width: 623px!important;width: 623px;
	border-right: 1px solid #B4C2D4;
}
#midnavigation{
	width: 618px!important;width: 623px;
	height: 26px;
	background: url(images/nav_05.gif) repeat-x;
	text-align: left;
	padding-top: 5px!important;padding-top: 3px;
	padding-left: 5px;
	color: #064CCE;
}
#midnav{
	width: 615px;
	background: #F7F7F7;
	margin-left: 0px!important;margin-left: -8px;
	margin-top: -5px!important;margin-top: 0px;
	padding-bottom: 10px;
}
#navtitle{
	color:#D63402;
   font-size: 18px;
   font-weight: bold;
	padding-top: 5px;
}
#navtags{
	width:97%!important;width:99%;
	font-size: 12px;
	color: #047CED;
	text-align: left;
	padding-left: 5px;
   height: 21px;
	background: #E6E4E4;
	padding-top: 2px!important;padding-top: 1px;
}
.ash{
	font-size: 12px;
	color: #2E0C02;
}
#midleftnav{
	width: 95%;
	margin: 10px;
}
.midtext{
	width:98%;
	padding: 10px;
	font-size: 14px;
	color: #000;
	text-align: left;
}
#banner1{
	width: 572px;
	height: 62px;
}
#link{
	width: 572px;
	border: 1px solid #39A9C7;
   margin-top: 10px;
}
#linktitle{
	height: 24px;
	background: #86D6EB;
   text-align: left;
	padding-left: 10px;
	padding-top: 2px;
}
.blue{
	color: #080DF8;
	font-size: 12px;
}
#letterad{
	border: 1px solid #FFC80C;
	padding: 12px;
	width: 548px !important;
	width /**/: 572px;
	clear: both;
	float: left;
   margin-top: 10px;
	margin-left: 5px;
	background: #FFFFE9;
	display: inline;
}
#letterad table{
	width: 100%;
}
#letterad table td{
	font-size: 12px;
	color:#080DF8;
	height: 20px;
}
#assert{
	width:540px;
	text-align: left;
	margin: 5px;
}
.red{
	font-size: 12px;
	color: #f00;
}
.topic {
	font-family: "宋体";
	background-color:#eeeeee;
	font-size:12px;
	padding-top:4px;
	padding-bottom:2px;
	padding-left:2px;
	padding-right:2px;
	margin-left:35px;
	margin-right:5px;
	border: 1px solid #333333;	
	}
.content {
	font-size:14px;
	padding-top:10px;
	padding-bottom:10px;
	padding-left:10px;
	padding-right:10px;
	margin-left:35px;
	margin-right:5px;
	margin-bottom: 5px;
	border-left: 1px solid #333333;	
	border-right: 1px solid #333333;	
	border-bottom: 1px solid #333333;	
	text-align:left;
	}
#leave {
	width: 572px;
	border: 1px solid #39A9C7;
	margin-top: 10px;
	text-align:center;
	margin-left:12px;
	background: #fff;
}
#leave table {
   width:98%;
	padding-left:30px; 
}
#leave table td {
   font-size: 12px;
	color:#000;
} 
#leavetitle {
	height: 25px;
	background: #86D6EB;
	padding-top: 2px;
	font-size: 14px;
	color: #000;
	font-weight: bold;
}
.linkies {

	font-family:"??";
	font-size:12px;
	padding-top:10px;
	padding-bottom:10px;
	padding-left:10px;
	padding-right:10px;
	margin-left:5px;
	margin-right:5px;
	text-align: center;
	}
.linkies a:link {
	font-size:12px;
	text-decoration: none;
	}
.linkies a:visited {
	font-size:12px;
	text-decoration: none;
	}
.linkies a:hover {
	font-size:12px;
	text-decoration: underline;
	}
.comment-zl {
	width:540px;
	text-align:left;
}
#textbox {
	width:260px;
	height: 80px;
	font-size: 12px;
}
#vouch{
	width:98%;
	height: 26px;
	border-bottom: 1px solid #000;
	text-align: left;
	padding-left: 10px;
	font-weight: bold;
	padding-top: 3px;
}
#vouchnav{
	width:97%;
	text-align:left;
	height: 130px;
}
#vouchimg{
   float: left;
   width: 140px;
	height: 120px;
	text-align: left;
	border:1px solid #000;
	margin: 5px;
}
#vouchimgnav{
   float: right;
	text-align: left;
	width:400px!important;width:380px;
}

#midright{
   float: right;
   width:120px;
	overflow: hidden;
	background: url(images/nav_07.gif) repeat-x;
}
#midrightbanner{
	width:125px;
	margin-top:10px;
}
#midrightimg{
	width:120px;
	padding-bottom: 5px;
	padding-top: 5px;
}
#bottom{
   clear: both;
	width:760px;
	height: 22px;
	background: #3792A3;
	margin-top: 5px;
	padding-top: 3px;
	color: #fff;
}
.white{
	font-size:12px;
	color: #fff;
}
#fundus{
	width: 760px;
	margin-top: 5px;
	margin-bottom: 5px;
}

#fxinput{
width:15px;height:15px; }
/* 文章页页头导航 */

.contentnav {
	width: 588px;
	float: right;
	margin-top: 19px;
	line-height: 2;
	border-bottom: 1px solid #000;
	background: #D70F00 url(../images/jiao.gif)  no-repeat left top;
	color: #fff;
	text-align: center;
}
.contentnav a {
	color: #fff;
	text-decoration: none;
}
.contentnav a:hover {
	color: #ccc;
	text-decoration: underline;
}
/* 页脚 */
#footer {
	width: 760px;
	background: #979797;
	border-bottom: 2px solid #000;
	color: #fff;
	line-height: 2;
	margin: 15px auto 0;
	clear: both;
}
#footer a {
	color: #fff;
}
#copyright {
	text-align: center;
	width: 760px;
	margin: 0 auto;
	padding: 0;
	clear: both;
}
#copyright a {
	color: #000;
}
.adbox2{
	float: left;
	margin: 0 5px 5px 0;
	width: 360px;
	height: 300px;
}
.textad {
	list-style: none;
	margin: 0;
	padding: 0;
}
.textad2 {
	width: 100%;
	margin: 0;
	padding: 0;
	list-style: none;
}
.textad2 li {
	float: left;
	width: 24%;
}
.interfix{
	width:572px;
	border:1px solid #39A9C7;
	float:left;
	margin-top: 6px;
	display: inline;
	margin-left: 6px;
}
.interfix ul{
	width: 500px;
	float:left;
	margin-top:10px;
	padding-bottom:0px!important; padding-bottom:10px;
	margin-left:0px!important;margin-left:20px
}
.interfix li{
	width:500px;
	float:left;
	text-align:left;
	font-size:12px;
	color:#828282;
	line-height:18px;
}
.interfix li A{
	font-size: 12px;
	color:#0000F7;
	text-decoration:underline;
}
.interfix li A:hover{
	font-size: 12px;
	color:#ff0000;
	text-decoration:none;
}
.interfixtitle{
	width: 572px;
	height:27px;
	float:left;
	margin:0;
	background: #86D6EB;
}
.interfixtitle h2{
	text-align:left;
	font-size:14px;
	float:left;
	display:inline;
	margin-left:8px;
	margin-top:6px;
	text-indent:20px;
}
.logo{
	width: 140px;
	height: 52px;
	float: left;
}
.logor{
	width: 619px;
	height: 28px;
	float: right;
	background: url(http://images.bokee.com/sports/images/index_nav1.gif) no-repeat;
}
.logor h2{
	width: 550px;
	float: right;
	font-size: 14px;
	color: #fff;
	margin-top: 8px;
	text-align: left;
	display: inline;
	margin-right: 8px;
}
.logor h2 A{
	color: #fff;
}
.logor h2 A:hover{
	color: #fff;
}
.logor h2 span{
	font-size: 12px;
	font-weight: normal;
	float: right;
	color: #000;
}
.logor h2 span A{
	color: #000;
}
.logor h2 span A:hover{
	color: #f00;
}
.logorb{
	width: 619px;
	height: 24px;
	float: right;
	background: url(http://images.bokee.com/sports/images/index_nav2.gif) no-repeat;
}
.logorb h2{
	width: 560px;
	float: right;
	text-align: left;
	line-height: 24px;
	font-size: 14px;
}
.logorb h2 A{
	color: #fff;
	font-size: 14px;
	letter-spacing: 0.04em;
}
.logorb h2 A:hover{
	color: #fff;
	font-size: 14px;
	letter-spacing: 0.04em;
}
-->
</style>
<script type="text/javascript" src="http://finance.bokee.com/include/function.js"></script>
</HEAD>

<BODY>
<div id="main"><!-- 头部开始 -->

<div class="logo"><img src="http://images.bokee.com/sports/images/logo.gif" alt="logo" /></div>
  <div class="logor">
    <h2><span>·<a href="http://sports.bokee.com">体育频道全新推出!</a></span><a href="/">首页</a> <a href="/basketball/">篮球</a> <a href="/others/">综合</a> <a href="/chinafb/">国内</a> <a href="/globalfb/">国际</a></h2>
  </div>
  <div class="logorb">
    <h2><a href="http://blog.bokee.com">博客</a> <a href="/basketball/nba/">NBA</a> <a href="/others/outdoor/">户外</a> <a href="/chinafb/chinaa/">中超</a> <a href="/globalfb/italy/">意甲</a> <a href="/globalfb/england/">英超</a> <a href="/globalfb/spain/">西甲</a> <a href="/video/">视频</a> <a href="http://rss.bokee.com/entrycat.2.html">RSS</a> <a href="http://blogmark.bokee.com/hot/03.html">博采</a> <a href="http://bbs.bokee.com">社区</a> <a href="http://column.bokee.com">专栏</a></h2>
  </div>

<!-- 上部的banner或广告条 --><div class=adbox><!--体育内页 - 760*60 通栏_1-->
<script src=http://adimage.bokee.com/images/ads/sports/article/ad_sub_fc_1.js></script>	
<!--Adforward End-->
</div>
  <div id="mid">

    <div id="midleft">
      <div id="midnavigation">您的位置：<?php
echo $_obj['article_nav'];
?>
 > 正文</div>
      <div id="midnav">

        <div id="navtitle"><?php
echo $_obj['title'];
?>
</div>
        http://<?php
echo $_obj['channel_name'];
?>
.bokee.com 　发表于: <?php
echo $_obj['create_time'];
?>
 　来源:<?php
echo $_obj['coop_media_name'];
?>
<div id="midleftnav">
          <hr size="1" style="BORDER-RIGHT: 0px; BORDER-TOP: 0px; BORDER-LEFT: 0px; BORDER-BOTTOM: #000 1px solid">
          <div id="midtext" class="midtext"><?php
echo $_obj['content'];
?>
</div>
          <div id="banner1" style="WIDTH: 572px; HEIGHT: 28px">&nbsp;
          </div><!-------------link start--------------><!----- 频道内页文章尾57060BANNER -----><div class=adbox>
<!--体育内页 - 570*60 文章尾小通栏-->
<script src=http://adimage.bokee.com/images/ads/sports/article/ad_sub_sfc_txtend.js></script>
<!--Adforward End-->

</div>
          <div id="link">
            <div id="linktitle">相关链接</div></div>
    <div id="letterad"><!-- 20 txtad -->
	<script src=http://adimage.bokee.com/images/ads/sports/article/ad_sub_20txtend.js></script>
    </div><!-------------letterad start-------------->

    <div class="interfix">
	<div class="interfixtitle"><h2>相关文章</h2></div>
	<?php
echo $_obj['rel_cms_content'];
?>

</div>
<div class="interfix">
	<div class="interfixtitle"><h2>相关博客文章</h2></div>
	<?php
echo $_obj['rel_blog_content'];
?>

</div>
<div class="interfix">
	<div class="interfixtitle"><h2>相关RSS文章</h2></div>
	<?php
echo $_obj['rel_rss_content'];
?>

</div>
    <div align="center">【<A title=将此文加入博客中国博采 href="javascript:d=document;t=d.selection?(d.selection.type!='None'?d.selection.createRange().text:''):(d.getSelection?d.getSelection():'');void(keyit=window.open('http://blogmark.blogchina.com/jsp/key/quickaddkey.jsp?k='+encodeURI(d.title)+'&amp;u='+encodeURI(d.location.href)+'&amp;c='+encodeURI(t),'keyit','scrollbars=no,width=500,height=430,status=no,resizable=yes'));keyit.focus();" target=_self >博采本文</A>| <A href="javascript:commend();">推荐本文</A> | <A href="javascript:chgfont(16);">大</A> <A href="javascript:chgfont(14);">中</A> <A href="javascript:chgfont(12);">小</A> | <A href="javascript:doPrint();">打印本文</A> | <A href="javascript:window.close();">关闭本页</A>】</div>

          <div id="assert"><span class="red">【郑重声明】</span>博客中国刊载此文不代表同意其说法或描述，仅为提供更多信息，也不构成任何投资或其他建议。转载需经博客中国同意并注明出处。本网站有部分文章是由网友自由上传。对于此类文章本站仅提供交流平台，不为其版权负责。如果您发现本网站上有侵犯您的知识产权的文章，请发信至<A href="mailto:ceditor@blogchina.com">ceditor@blogchina.com</A><br>
            <span class="red">【本文网址】<A 
href="<?php
echo $_obj['url'];
?>
"><?php
echo $_obj['url'];
?>
</A></span> </div>
<!-- 评论开始 -->
<!--title--><!--新闻源文：【<?php
echo $_obj['title'];
?>
】--><!--title-->
<!--content--><!--  【摘要】:<?php
echo $_obj['description'];
?>
<br> <?php
echo $_obj['url'];
?>
--><!--content-->
<span id="replyContent" ></span>
<script id="replyLoader" defer ></script>
<script>replyLoader.src="http://comment.sports.bokee.com/replyThreadTUTF.jsp?forumID=22&channel_id=<?php
echo $_obj['channel_name'];
?>
_<?php
echo $_obj['channel_id'];
?>
&articleID=<?php
echo $_obj['article_id'];
?>
&m=1";</script>
<!-- 评论结束 --><!-- 今日推荐开始 -->
<!-- 今日推荐结束 -->
        </div>
      </div>

    </div>
 <div id="midright"><script src=http://adimage.bokee.com/images/ads/sports/article/ad_sub_btn_123.js></script>	
<script src=http://adimage.bokee.com/images/ads/sports/article/ad_sub_5txt.js></script>   
<script src=http://adimage.bokee.com/images/ads/sports/article/ad_sub_btn_456.js></script> 
</div><!-- 频道内页右侧12060BUTTON_5 --><!-- 频道内页右侧12060BUTTON_6 --><!-- 频道内页右侧精采推荐文字链1~10 --><style type="text/css">
#midright {
width:122px;}
</style>
<div style="border:1px solid #FFC80C; width:120px;">
<!-- 10 text ad -->
 <script src=http://adimage.bokee.com/images/ads/sports/article/ad_sub_hottxt.js></script>
</div>
</div>

  </div>
</div><!-------midleft  end--------------><!-------midright  strat--------------><!-- 右边广告开始 --><!-- 右边广告结束 -->
<DIV></DIV>
<DIV></DIV><!-------mid  end--------------><!-------main  end--------------><!-- 页脚开始 --><div id="footer"><a href="mailto:ceditor@blogchina.com">主编信箱</a> | <a href="http://www.bokee.com/new/about/aboutus.html">关于本站</a> | <a href="http://www.bokee.com/new/about/copyright.html">版权声明</a> | <a href="http://www.bokee.com/new/about/notonduty.htm">免责条款</a> | <a href="http://www.bokee.com/new/about/privacy.htm">隐私保护</a> | <a href="http://www.bokee.com/new/about/sitemap.html">网站导航</a> | <a href="http://www.bokee.com/new/about/contact.html">联系方式</a> | <a href="http://www.bokee.com/new/display/37233.html">诚聘英才</a> | <a href="http://www.bokee.com/reg.html">用户注册</a> | <a href="http://www.bokee.com/new/about/thank.html">特别鸣谢</a> | <a href="http://www.bokee.com/new/about/morelink.htm">友情链接</a></div>

<div id="copyright">Copyright 2002 - 2005 Bokee.com, All Rights Reserved. 博客时代，版权所有</div><!-- 页脚结束 -->
</BODY>
</HTML>