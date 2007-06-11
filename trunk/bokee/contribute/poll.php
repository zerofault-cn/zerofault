<?php
define('IN_MATCH', true);

header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
$root_path = "./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");

$id=$_REQUEST['id'];
$author_id=$_REQUEST['author_id'];
$sql1="update article set vote=vote+1 where id=".$id;
$sql2="update author set vote=vote+1 where id=".$author_id;

if($db->sql_query($sql1) && $db->sql_query($sql2))
{
	echo '<script>alert("投票成功，感谢您的支持！");window.close();</script>';
	exit;
}

?>