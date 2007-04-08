<?php
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
function format($text)
{
	$text=htmlspecialchars($text);
	$text=str_replace(" ","&nbsp;",$text);
	$text=nl2br($text);
//	$text=addslashes($text);
	return $text;
}
if($need_f)
{
	format($info);
}
$upflag=1;
$pics='';
for($i=1;$i<=3;$i++)
{
	if(isset(${'pic'.$i}) && ${'pic'.$i}!='')
	{
		$pic_file_name=date("YmdHis").strrchr(${'pic'.$i.'_name'},".");
		$upflag=$upflag && copy(${'pic'.$i},"/jbproject/tomcat/goldsoft/php-vod/news_pic/".$pic_file_name);
		$pics.=$pic_file_name.',';
		$info='<div align=center><img src=news_pic/'.$pic_file_name.'></div>'.$info;
	}
}
if($pics!='')
{
	$pics=substr($pics,0,-1);
}

$sql1="insert into rss_news(channel,title,author,info,time) values('".$channel."','".$title."','".$author."','".$info."',now())";
if($upflag&&mysql_query($sql1))
{
	?>
	<script>
	if(confirm("已成功添加,继续添加吗?"))
		window.location="index.php?content=rss_add_news_1";
	else
		window.location="index.php?content=rss_news";
	</script>
	<?
}
else
{
	?>
	<script>
	alert("添加记录失败,请检查重试,或者报告管理员");
	window.history.go(-1);
	</script>
	<?
}
?>