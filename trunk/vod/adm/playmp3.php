<?php
$play_list=explode('|',$str_play_list);
for($i=0;$i<sizeof($play_list);$i++)
{
	$content.=$play_list[$i]."\r\n";
}
Header("Content-Type:audio/x-mpegurl");
echo $content;
?>
