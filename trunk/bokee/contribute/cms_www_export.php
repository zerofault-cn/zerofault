<?php
define('IN_MATCH', true);
$root_path ="./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");
include_once($root_path."functions.php");


$sql="select blogname,blogurl,month_article from author order by month_article desc limit 17";
$result=$db->sql_query($sql);
while($row=$db->sql_fetchrow($result))
{
	echo '<li><a href="'.$row['blogurl'].'" title="'.$row['blogname'].'">'.substr_cut($row['blogname'], 18).'</a><span>&nbsp;&nbsp;'.$row["month_article"].'ƪ</span></li>';
}

?>