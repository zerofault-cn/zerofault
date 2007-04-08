<?php
define('IN_MATCH', true);

$root_path="./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");
$sid=$_REQUEST['sid'];
$field=$_REQUEST['field'];
$sql="update subject set ".$field."=".$field."+1 where id='".$sid."'";
if($db->sql_query($sql))
{
	echo '<script>parent.getData("'.$field.'");</script>';
}

?>