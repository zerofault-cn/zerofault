<?php
/*利用文件系统的计数器*/

$count_file=$phpbbs_root_path.'/countdata.txt';
$fp=fopen($count_file,"r+");
$filesize=filesize($count_file);
$countdata=fgets($fp,$filesize+1);
$countdata++;
rewind($fp);
fputs($fp,$countdata);
fclose($fp);

/*利用数据库得计数器*/
/*****************数据库建立语句*********
CREATE TABLE count
(
count varchar(6) NOT NULL default '0',
PRIMARY KEY  (count)

)TYPE=MyISAM;
/****************************************
mysql_connect("localhost","dba","sql");
mysql_select_db("phpbbs");
$query1="select * from count2";
$result1=mysql_query($query1);
$countdata=mysql_result($result1,0,"count");
$countdata++;
$query2="update count2 set count=".$countdata;
if(!mysql_query($query2))
	echo "sql error";
else
	echo "<img src=imgcount.php?countdata=$countdata>";
*/
?>
本站已有<img src="<?=$phpbbs_root_path?>/imgcount.php?countdata=<?=$countdata?>">位来访者了