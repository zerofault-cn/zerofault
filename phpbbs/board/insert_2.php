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

//首先写入文件,所有回复都不写入
/*
if($type=="tech"||$type=="feeling"||$type=="joke")
{
	$text="$title\n$time\n$info";
	$fp=fopen("/document/$type/$title.txt","w"); 
	fwrite($fp,$text); 
	fclose($fp);
}
*/
//写文件结束,开始插入数据库,首先是格式转换
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
	echo "数据库故障,留言失败,请返回";
}

?>