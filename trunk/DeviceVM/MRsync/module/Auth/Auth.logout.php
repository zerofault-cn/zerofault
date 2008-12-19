<?php
$username=$_SESSION['auth']['Username'];

session_unset();
session_destroy();

/****************Event Log************************/
$POST_ARR=array(
	"type"=>"3",
	"source"=>'Auth Module',
	"user"=>$username,
	"action"=>'logout',
	"info_xml"=>'User:'.$username.' logout from '.$_SERVER['REMOTE_ADDR'],
	"description"=>'logout success!'
	);
include_once(PATH_Include."LogUL.php");
$ret=LogUL($POST_ARR);
/****************Event Log************************/

header("location:?Mod=System");
exit;

?>