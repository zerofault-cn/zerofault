<?php

define('IN_MATCH', true);
$root_path="../";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");

$sql="select blogname,blogurl,count(article.author_id) as count from author,article where (article.channel_id1=70 or article.channel_id2=70 or article.channel_id3=70) and author.id=article.author_id and article.addtime>(UNIX_TIMESTAMP()-30*86400) group by article.author_id order by count desc limit 6";
$result = $db->sql_query($sql);
while($row=$db->sql_fetchrow($result))
{
	echo '<li><a href="'.$row["blogurl"].'" target="_blank">'.substr_cut($row["blogname"], 12).'</a></li>';
}
?>