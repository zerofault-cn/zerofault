<?php
define('IN_MATCH', true);
define('IN_MATCH', true);
header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
$root_path="./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");
$sid=$_REQUEST['sid'];
$field=$_REQUEST['field'];
$sql1="select ".$field." from subject where id='".$sid."'";
$data=$db->sql_fetchfield(0,0,$result=$db->sql_query($sql1));
$data++;
$sql2="update subject set ".$field."=".$data." where id='".$sid."'";
if($db->sql_query($sql2))
{
	echo $data;
}

?>