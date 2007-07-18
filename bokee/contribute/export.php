<?php
/*
*供www首页和blogs首页调用的投稿作者排行
*/
define('IN_MATCH', true);
$root_path ="./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");
include_once($root_path."functions.php");

$for=$_REQUEST['for'];
if(''==$for)
{
	$for='www';
}
if($for=='www')
{
	$limit=17;
}
if($for=='blogs')
{
	$limit=10;
}
$sql="select blogname,blogurl,month_article from author order by month_article desc limit ".$limit;
$result=$db->sql_query($sql);
$i=1;
while($row=$db->sql_fetchrow($result))
{
	if($for=='www')
	{
		echo '<li><a href="'.$row['blogurl'].'" title="'.$row['blogname'].'">'.substr_cut($row['blogname'], 18).'</a><span>&nbsp;&nbsp;'.$row["month_article"].'篇 </span></li>';
	}
	if($for=='blogs')
	{
		echo '<li class="number'.sprintf("%02d",$i++).'"><a href="'.$row['blogurl'].'" title="'.$row['blogname'].'" target="_blank">'.substr_cut($row['blogname'], 14).'</a>&nbsp;&nbsp;'.$row["month_article"].'篇 </li>';
	}
}
?>