<?
include "session.php";
define('IN_MATCH', true);

$root_path = "./../";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");

$id = $_REQUEST['id'];

if($id>0)
{
	$sql="delete from user_info where id=".$id;
}
if(''!=$sql && $db->sql_query($sql))
{
	echo 'ok';
}
else
{
	echo 'error|sql:'.$sql;
}

$db->sql_close();

?>