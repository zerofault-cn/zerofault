本站已被访问<?php
$count_file='countdata.txt';
$fp=fopen($count_file,"r+");
$filesize=filesize($count_file);
$countdata=fgets($fp,$filesize+1);
$countdata++;
rewind($fp);
fputs($fp,$countdata);
fclose($fp);
//echo $countdata;//文本方式显示
echo '<img src="imgcount.php?countdata='.$countdata.'">';//图片方式显示
?>次<br>