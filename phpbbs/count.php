<?php
/*�����ļ�ϵͳ�ļ�����*/

$count_file=$phpbbs_root_path.'/countdata.txt';
$fp=fopen($count_file,"r+");
$filesize=filesize($count_file);
$countdata=fgets($fp,$filesize+1);
$countdata++;
rewind($fp);
fputs($fp,$countdata);
fclose($fp);

/*�������ݿ�ü�����*/
/*****************���ݿ⽨�����*********
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
��վ����<img src="<?=$phpbbs_root_path?>/imgcount.php?countdata=<?=$countdata?>">λ��������