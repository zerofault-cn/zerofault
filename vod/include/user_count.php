<?php
@session_start();
if(!session_is_registered("ip"))
{
	include_once "../include/db_connect.php";
	include_once "../include/getuserinfo.php";
	$ip=$_SERVER["REMOTE_ADDR"];
	$addr=getAddr($ip,3);
	$os=getOperation();
	$browse=getBrowser();
	$sql1="insert into user_count(ip,address,os,browse,time) values('".$ip."','".$addr."','".$os."','".$browse."',now())";
	if(mysql_query($sql1))
	{
		session_register("ip");
	}
}
?>