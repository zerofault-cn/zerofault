<?php
$id=$_REQUEST['id'];
$phpbbs_root_path="..";
include_once $phpbbs_root_path.'/include/db_connect.php';
$sql1="select * from software where id=".$id;
$result1=mysql_query($sql1);
$path=mysql_result($result1,0,"path");
$path=$phpbbs_root_path.'/../'.$path;
$sql2="update software set count=count+1 where id=".$id;
mysql_query($sql2);
//	Header ("Content-Type:application/zip");
header("location:".$path);
exit;
?>
