<?php
define('IN_MATCH', true);

header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$root_path="./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
$id=intval($_REQUEST['id']);
$field=$_REQUEST['field'];
if(strlen(trim($field))<5)
{
	$field='allvote';
}
if($id>0)
{
	echo getField($id,$field).'|'.getOrder($id);//取得选手的总票数和目前排名
}
else
{
	echo "no id";
}
//$db->sql_close();
?>