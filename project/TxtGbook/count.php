��վ�ѱ�����<?php
$count_file='countdata.txt';
$fp=fopen($count_file,"r+");
$filesize=filesize($count_file);
$countdata=fgets($fp,$filesize+1);
$countdata++;
rewind($fp);
fputs($fp,$countdata);
fclose($fp);
//echo $countdata;//�ı���ʽ��ʾ
echo '<img src="imgcount.php?countdata='.$countdata.'">';//ͼƬ��ʽ��ʾ
?>��<br>