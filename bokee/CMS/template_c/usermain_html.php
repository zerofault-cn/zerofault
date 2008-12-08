<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>博客网CMS系统</title>
<style type="text/css">
<!--
body {
font-size: 14px;
}
-->
</style>
</head>
<body>
<p><img src="images/logo.gif" border="0"></p>
<p>欢迎 <font color="blue"><?php
echo $_obj['name'];
?>
</font> 使用博客网CMS系统，您的身份是：<font color="Blue"><?php
echo $_obj['role_name'];
?>
</font>，您上次登录时间是：<font color="Blue"><?php
echo $_obj['last_login'];
?>
</font></p>
<p>今天发文数：<font size="4"><?php
echo $_obj['today_article_num'];
?>
</font> 今天转载文章数：<font size="4"><?php
echo $_obj['today_rss_article_num'];
?>
</font>
本周发文数：<font size="4"><?php
echo $_obj['week_article_num'];
?>
</font> 本周转载文章数：<font size="4"><?php
echo $_obj['week_rss_article_num'];
?>
</font>
本月发文数：<font size="4"><?php
echo $_obj['month_article_num'];
?>
</font> 本月转载文章数：<font size="4"><?php
echo $_obj['month_rss_article_num'];
?>
</font></p>
今日发文：<br>
<table width="100%" cellspacing="2" bgcolor="#CCCCCC">
<tr bgcolor="#FFFFFF">
<td>文章ID</td>
<td>文章标题</td>
<td>发表时间</td>
</tr>
<?php
if (!empty($_obj['articles'])){
if (!is_array($_obj['articles']))
$_obj['articles']=array(array('articles'=>$_obj['articles']));
$_tmp_arr_keys=array_keys($_obj['articles']);
if ($_tmp_arr_keys[0]!='0')
$_obj['articles']=array(0=>$_obj['articles']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['articles'] as $rowcnt=>$articles) {
$articles['ROWCNT']=$rowcnt;
$articles['ALTROW']=$rowcnt%2;
$articles['ROWBIT']=$rowcnt%2;
$_obj=&$articles;
?>
<tr bgcolor="<?php
echo $_obj['bgcolor'];
?>
">
<td><?php
echo $_obj['id'];
?>
</td>
<td><a href="<?php
echo $_obj['remote_url'];
?>
" target="_blank"><?php
echo $_obj['title'];
?>
</a></td>
<td><?php
echo $_obj['create_time'];
?>
</td>
</tr>
<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
</table>
今日转载：<br>
<table width="100%" cellspacing="2" bgcolor="#CCCCCC">
<tr bgcolor="#FFFFFF">
<td>文章ID</td>
<td>文章标题</td>
<td>发表时间</td>
</tr>
<?php
if (!empty($_obj['rss_articles'])){
if (!is_array($_obj['rss_articles']))
$_obj['rss_articles']=array(array('rss_articles'=>$_obj['rss_articles']));
$_tmp_arr_keys=array_keys($_obj['rss_articles']);
if ($_tmp_arr_keys[0]!='0')
$_obj['rss_articles']=array(0=>$_obj['rss_articles']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['rss_articles'] as $rowcnt=>$rss_articles) {
$rss_articles['ROWCNT']=$rowcnt;
$rss_articles['ALTROW']=$rowcnt%2;
$rss_articles['ROWBIT']=$rowcnt%2;
$_obj=&$rss_articles;
?>
<tr bgcolor="<?php
echo $_obj['bgcolor'];
?>
">
<td><?php
echo $_obj['id'];
?>
</td>
<td><a href="<?php
echo $_obj['remote_url'];
?>
" target="_blank"><?php
echo $_obj['title'];
?>
</a></td>
<td><?php
echo $_obj['create_time'];
?>
</td>
</tr>
<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
</table>
<table width="90%" cellspacing="2" bgcolor="#CCCCCC">
<caption>CMS系统功能更新通告</caption>
<!-- <tr style="background-color: #eee;">
	<td valign="top">2007年3月28日：<br>增加“去除重复RSS文章”功能</td>
	<td valign="top">由于RSS来源数据库中出现的重复条目，导致同步到CMS后也出现重复，如果各位编辑发现发布后的页面上出现重复的文章标题，可以用以下两种方法解决：<br>
	1，在相应子栏目的文章列表页面下方，点击“去除重复的RSS文章”按钮即可，如果此栏目下记录数太多（10000条以上），可能一次清除不完全，可以多点几次按钮；<br>
	2，在“区块列表”中，在产生重复标题的区块后点一下“修改”，然后可以不做任何改动，再点保存即可。</td>
</tr>
<tr style="background-color: #fff;">
	<td valign="top">2007年3月27日：<br>增加“删除历史RSS文章”功能</td>
	<td valign="top">某些频道下因RSS文章过多导致CMS反应缓慢，各位编辑可根据自己情况删除各自频道下的历史RSS数据；手发文章不会被删除。</td>
</tr>
<tr style="background-color: #eee;">
	<td width="150" valign="top">2007年3月13日：<br>增加在标题链接上显示原始标题的功能</td>
	<td valign="top">在动态区块中有一个对标题长度做限制的功能，页面上只能显示被截断后的标题，为了方便用户，提高用户认知度，建议给截断后的标题加上Title属性，在区块代码里可以这样写：<?php
echo $_obj['str1'];
?>
</td>
</tr> -->
</table>
</body></html>
