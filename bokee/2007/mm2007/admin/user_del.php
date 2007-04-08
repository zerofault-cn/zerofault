<?
include "session.php";
define('IN_MATCH', true);

$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");

$id = $_REQUEST['id'];

if(!is_array($id))
{
	$sql="delete from mm_info where id=".$id;
}
else
{
	$sql="delete from mm_info where id in (".implode(',',$id).")";
}
if($db->sql_query($sql))
{
	echo 'ok';
}
else
{
	echo 'error|sql:'.$sql;
}

$db->sql_close();

?>