<?php
include("common.php");

/*function format($text)
{
	$text=addslashes($text);
	$text=htmlspecialchars($text);
	$text=str_replace(" ","&nbsp;",$text);
	$text=nl2br($text);
	return $text;
}*/
//$time=date("Y-m-d H:i:s");

//����д���ļ�,���лظ�����д��
/*
if($type=="tech"||$type=="feeling"||$type=="joke")
{
	$text="$title\n$time\n$info";
	$fp=fopen("/document/$type/$title.txt","w"); 
	fwrite($fp,$text); 
	fclose($fp);
}
*/
//д�ļ�����,��ʼ�������ݿ�,�����Ǹ�ʽת��
if($extension=='enphp')$enphp=true;
if($extension=='enhtml')$enhtml=true;
if($extension=='enubb')$enubb=true;
$info=str($info,$enhtml,$enubb,$enphp);
$username=addslashes($username);

$phpbbs_root_path="..";
include_once $phpbbs_root_path.'/include/db_connect.php';
$sql1="insert into board(pid,title,username,info,time,ip) values('".$pid."','".$title."','".$username."','".$info."',now(),'".$_SERVER["REMOTE_ADDR"]."')";

if($r=mysql_query($sql1))
{
	header("location:index.php");
}
else
{
	echo "\$r=$r<br>";
	echo "���ݿ����,����ʧ��,�뷵��";
}

?>